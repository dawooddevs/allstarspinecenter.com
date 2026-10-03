<?php
/**
 * Imports the cleaned-up copy from the previous WordPress site (app/content/wp/*):
 * treatment pages, provider bios, page copy, testimonials, FAQs, contact settings,
 * legacy pages and redirects. Images and photos already set in the dashboard are kept.
 */
return function (): array {
    $dir = APP . '/content/wp';
    $now = now();
    $log = [];
    $html = fn(string $v): string => Html::clean(Html::paragraphs($v));

    return DB::tx(function () use ($dir, $now, &$log, $html) {
        // ---------- Treatments ----------
        $services = array_merge(
            require $dir . '/services-medical-1.php',
            require $dir . '/services-medical-2.php',
            require $dir . '/services-soft-injury.php',
            require $dir . '/services-allergy-foods.php'
        );
        $plain = ['title', 'menu_label', 'excerpt', 'hero_text', 'conditions', 'benefits', 'meta_title', 'meta_description', 'status'];
        $rich = ['what_is', 'how_it_works', 'what_to_expect'];
        $n = 0;
        foreach ($services as $slug => $d) {
            $id = DB::val('SELECT id FROM services WHERE slug = ?', [$slug]);
            if (!$id) {
                $log[] = "service {$slug}: not found, skipped";
                continue;
            }
            $u = ['needs_review' => 0, 'updated_at' => $now];
            foreach ($d as $k => $v) {
                if (in_array($k, $plain, true)) $u[$k] = $v;
                elseif (in_array($k, $rich, true)) $u[$k] = $html($v);
                elseif ($k === 'faqs') $u[$k] = json_encode(array_map(fn($f) => ['q' => $f[0], 'a' => $f[1]], $v), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            }
            DB::update('services', $u, 'id = ?', [$id]);
            $n++;
        }
        $log[] = "treatments updated: {$n}";

        // ---------- Providers ----------
        $n = 0;
        foreach (require $dir . '/providers.php' as $slug => $d) {
            $id = DB::val('SELECT id FROM providers WHERE slug = ?', [$slug]);
            if (!$id) {
                $log[] = "provider {$slug}: not found, skipped";
                continue;
            }
            $u = ['needs_review' => 0, 'updated_at' => $now];
            foreach (['name', 'credentials', 'title', 'short_bio', 'focus', 'locations', 'meta_title', 'meta_description'] as $k) {
                if (array_key_exists($k, $d)) $u[$k] = $d[$k];
            }
            foreach (['bio', 'education', 'experience', 'philosophy'] as $k) {
                if (array_key_exists($k, $d)) $u[$k] = $html($d[$k]);
            }
            DB::update('providers', $u, 'id = ?', [$id]);
            $n++;
        }
        $log[] = "providers updated: {$n}";

        // ---------- Pages ----------
        $n = 0;
        foreach (require $dir . '/pages.php' as $slug => $d) {
            $id = DB::val('SELECT id FROM pages WHERE slug = ?', [$slug]);
            if (!$id) {
                $log[] = "page {$slug}: not found, skipped";
                continue;
            }
            $u = ['updated_at' => $now];
            foreach (['title', 'intro', 'meta_title', 'meta_description', 'needs_review'] as $k) {
                if (array_key_exists($k, $d)) $u[$k] = $d[$k];
            }
            if (isset($d['content'])) $u['content'] = $html($d['content']);
            DB::update('pages', $u, 'id = ?', [$id]);
            $n++;
        }
        $log[] = "pages updated: {$n}";

        $extras = require $dir . '/extras.php';

        $maxSort = (int)DB::val('SELECT MAX(sort_order) FROM pages');
        foreach ($extras['new_pages'] as $p) {
            if (DB::val('SELECT id FROM pages WHERE slug = ?', [$p['slug']])) {
                $log[] = "page {$p['slug']}: already exists, kept";
                continue;
            }
            $maxSort += 10;
            DB::insert('pages', array_merge([
                'eyebrow' => '', 'intro' => '', 'image' => '', 'template' => 'default', 'show_cta' => 1, 'is_system' => 0,
                'needs_review' => 0, 'status' => 'published', 'meta_title' => '', 'meta_description' => '',
            ], $p, ['content' => $html($p['content']), 'sort_order' => $maxSort, 'created_at' => $now, 'updated_at' => $now]));
            $log[] = "page {$p['slug']}: created";
        }

        // ---------- Testimonials (matched by name) ----------
        $upsert = function (string $name, string $label, string $text, int $featured, string $status, int $sort) use ($now): string {
            $id = DB::val("SELECT id FROM testimonials WHERE LOWER(REPLACE(name, ' ', '')) = ?", [strtolower(str_replace(' ', '', $name))]);
            $row = ['name' => $name, 'label' => $label, 'content' => $text, 'rating' => 5, 'featured' => $featured, 'status' => $status, 'sort_order' => $sort, 'updated_at' => $now];
            if ($id) {
                DB::update('testimonials', $row, 'id = ?', [$id]);
                return 'updated';
            }
            DB::insert('testimonials', $row + ['created_at' => $now]);
            return 'added';
        };
        $counts = ['updated' => 0, 'added' => 0];
        foreach ($extras['testimonials'] as $i => [$name, $label, $text, $featured]) {
            $counts[$upsert($name, $label, $text, (int)$featured, 'published', ($i + 1) * 10)]++;
        }
        foreach ($extras['testimonial_drafts'] as $i => [$name, $label, $text]) {
            $upsert($name, $label, $text, 0, 'draft', 900 + $i * 10);
        }
        $log[] = "testimonials: {$counts['updated']} updated, {$counts['added']} added";

        // ---------- FAQs (homepage and billing groups are replaced) ----------
        foreach ($extras['faqs'] as $grp => $items) {
            DB::delete('faqs', 'grp = ?', [$grp]);
            foreach ($items as $i => [$q, $a]) {
                DB::insert('faqs', ['question' => $q, 'answer' => $a, 'grp' => $grp, 'sort_order' => ($i + 1) * 10, 'status' => 'published', 'created_at' => $now, 'updated_at' => $now]);
            }
            $log[] = "faqs {$grp}: " . count($items);
        }

        // ---------- Settings (only when still empty) ----------
        foreach ($extras['settings'] as $k => $v) {
            if (trim((string)Settings::get($k, '')) === '') {
                Settings::set($k, $v);
                $log[] = "setting {$k}: set";
            }
        }

        // ---------- Legacy redirects ----------
        foreach ($extras['redirects'] as [$from, $to]) {
            if (!DB::val('SELECT id FROM redirects WHERE source = ?', [$from])) {
                DB::insert('redirects', ['source' => $from, 'target' => $to, 'code' => 301, 'hits' => 0, 'note' => 'Old WordPress URL', 'created_at' => $now, 'updated_at' => $now]);
                $log[] = "redirect {$from} -> {$to}";
            }
        }
        return $log;
    });
};
