<?php
/**
 * Read-side content repository used by the public templates.
 */
final class Content
{
    public const CATEGORIES = [
        'medical' => ['label' => 'Medical Treatments', 'short' => 'Medical', 'icon' => 'stethoscope', 'blurb' => 'Injections, regenerative medicine, decompression and advanced in-office procedures.'],
        'soft-tissue' => ['label' => 'Soft Tissue Management', 'short' => 'Soft Tissue', 'icon' => 'waves', 'blurb' => 'Hands-on and instrument-assisted therapies for muscles and fascia.'],
        'injury' => ['label' => 'Injury & Accident Care', 'short' => 'Injury Care', 'icon' => 'car', 'blurb' => 'Evaluation and care after auto, work and sports injuries.'],
        'chiropractic' => ['label' => 'Chiropractic Care', 'short' => 'Chiropractic', 'icon' => 'spine', 'blurb' => 'Spinal and joint adjustments to support alignment, motion and function.'],
        'allergy' => ['label' => 'Allergy Treatments', 'short' => 'Allergy', 'icon' => 'flower', 'blurb' => 'Testing and immunotherapy for environmental and food allergies.'],
        'medical-foods' => ['label' => 'Medical Foods', 'short' => 'Medical Foods', 'icon' => 'pill', 'blurb' => 'Physician-supervised medical foods used as part of a care plan.'],
    ];

    public const PROVIDER_TYPES = [
        'chiropractor' => 'Chiropractors',
        'family_medicine' => 'Family Medicine',
        'physician_assistant' => 'Physician Assistants',
        'other' => 'Clinical Team',
    ];

    public const BODY_AREAS = [
        'neck' => 'Neck', 'shoulder' => 'Shoulder', 'back' => 'Back', 'hip' => 'Hip', 'knee' => 'Knee',
        'elbow' => 'Elbow', 'wrist-hand' => 'Wrist / Hand', 'leg' => 'Leg', 'ankle-foot' => 'Ankle / Foot', 'joint' => 'General Joint Pain',
    ];

    private static array $cache = [];

    public static function services(bool $publishedOnly = true): array
    {
        $key = 'services' . (int)$publishedOnly;
        if (!isset(self::$cache[$key])) {
            $sql = 'SELECT * FROM services' . ($publishedOnly ? " WHERE status = 'published'" : '') . ' ORDER BY sort_order, title';
            self::$cache[$key] = DB::all($sql);
        }
        return self::$cache[$key];
    }

    public static function servicesByCategory(): array
    {
        $out = array_fill_keys(array_keys(self::CATEGORIES), []);
        foreach (self::services() as $s) {
            $out[$s['category']][] = $s;
        }
        return $out;
    }

    public static function service(string $slug): ?array
    {
        return DB::one("SELECT * FROM services WHERE slug = ? AND status = 'published'", [$slug]);
    }

    public static function servicesBySlugs(array $slugs): array
    {
        $by = [];
        foreach (self::services() as $s) {
            $by[$s['slug']] = $s;
        }
        $out = [];
        foreach ($slugs as $slug) {
            if (isset($by[$slug])) {
                $out[] = $by[$slug];
            }
        }
        return $out;
    }

    public static function providers(): array
    {
        if (!isset(self::$cache['providers'])) {
            self::$cache['providers'] = DB::all("SELECT * FROM providers WHERE status = 'published' ORDER BY sort_order, name");
        }
        return self::$cache['providers'];
    }

    public static function provider(string $slug): ?array
    {
        return DB::one("SELECT * FROM providers WHERE slug = ? AND status = 'published'", [$slug]);
    }

    public static function page(string $slug): ?array
    {
        return DB::one("SELECT * FROM pages WHERE slug = ? AND status = 'published'", [$slug]);
    }

    public static function locations(): array
    {
        if (!isset(self::$cache['locations'])) {
            self::$cache['locations'] = DB::all("SELECT * FROM locations WHERE status = 'published' ORDER BY sort_order, name");
        }
        return self::$cache['locations'];
    }

    public static function testimonials(bool $featuredOnly = false): array
    {
        $sql = "SELECT * FROM testimonials WHERE status = 'published' AND content IS NOT NULL AND content <> ''" . ($featuredOnly ? ' AND featured = 1' : '') . ' ORDER BY sort_order, id';
        return DB::all($sql);
    }

    public static function faqs(string $group): array
    {
        return DB::all("SELECT * FROM faqs WHERE grp = ? AND status = 'published' ORDER BY sort_order, id", [$group]);
    }

    public static function serviceUrl(array $s): string
    {
        return url('service/' . $s['slug'] . '/');
    }

    public static function providerUrl(array $p): string
    {
        return url('doctor/' . $p['slug'] . '/');
    }

    public static function categoryLabel(string $cat): string
    {
        return self::CATEGORIES[$cat]['label'] ?? ucfirst($cat);
    }

    public static function serviceIcon(array $s): string
    {
        return $s['icon'] ?: (self::CATEGORIES[$s['category']]['icon'] ?? 'activity');
    }

    /** Related services: explicit list first, then same-category siblings. */
    public static function related(array $s, int $limit = 4): array
    {
        $out = self::servicesBySlugs(csv_list($s['related'] ?? ''));
        if (count($out) < $limit) {
            foreach (self::services() as $o) {
                if ($o['category'] === $s['category'] && $o['slug'] !== $s['slug'] && !in_array($o, $out, true)) {
                    $out[] = $o;
                }
                if (count($out) >= $limit) {
                    break;
                }
            }
        }
        return array_slice(array_values(array_filter($out, fn($o) => $o['slug'] !== $s['slug'])), 0, $limit);
    }

    public static function bodyAreaMap(): array
    {
        // Group matches per area and category, then interleave categories so
        // each area shows a balanced mix (max 8) rather than one category.
        $buckets = array_fill_keys(array_keys(self::BODY_AREAS), []);
        foreach (self::services() as $s) {
            foreach (csv_list($s['body_areas']) as $a) {
                if (isset($buckets[$a])) {
                    $buckets[$a][$s['category']][] = [
                        'title' => $s['menu_label'] ?: $s['title'],
                        'url' => self::serviceUrl($s),
                        'category' => self::CATEGORIES[$s['category']]['short'] ?? '',
                    ];
                }
            }
        }
        $map = [];
        foreach ($buckets as $area => $cats) {
            $map[$area] = [];
            while (count($map[$area]) < 8 && $cats) {
                foreach ($cats as $c => &$items) {
                    if ($items && count($map[$area]) < 8) {
                        $map[$area][] = array_shift($items);
                    }
                    if (!$items) {
                        unset($cats[$c]);
                    }
                }
                unset($items);
            }
        }
        return $map;
    }

    public static function patientForms(): array
    {
        $forms = [
            'form_new_patient_en' => 'New Patient Forms — English',
            'form_new_patient_es' => 'New Patient Forms — Spanish',
            'form_accident_en' => 'Accident Forms — English',
            'form_accident_es' => 'Accident Forms — Spanish',
            'form_pain_questionnaire' => 'Pain Treatment Questionnaire Forms',
        ];
        $out = [];
        foreach ($forms as $k => $label) {
            $file = (string)setting($k, '');
            $out[] = ['key' => $k, 'label' => $label, 'url' => $file ? media_url($file) : '', 'available' => $file !== ''];
        }
        return $out;
    }

    public static function hours(array $loc): array
    {
        return json_list($loc['hours'] ?? '[]');
    }

    public static function mapsDirections(array $loc): string
    {
        if (!empty($loc['directions_url'])) {
            return $loc['directions_url'];
        }
        $q = $loc['address'] . ', ' . $loc['city'] . ', ' . $loc['state'] . ' ' . $loc['zip'];
        return 'https://www.google.com/maps/dir/?api=1&destination=' . rawurlencode($q);
    }

    public static function mapEmbed(array $loc): string
    {
        if (!empty($loc['map_embed'])) {
            if (preg_match('~src="([^"]+)"~', $loc['map_embed'], $m)) {
                return html_entity_decode($m[1]);
            }
            return $loc['map_embed'];
        }
        $q = $loc['address'] . ', ' . $loc['city'] . ', ' . $loc['state'] . ' ' . $loc['zip'];
        return 'https://www.google.com/maps?q=' . rawurlencode('All Star Health, ' . $q) . '&output=embed';
    }

    public static function fullAddress(array $loc): string
    {
        return $loc['address'] . ', ' . $loc['city'] . ', ' . $loc['state'] . ' ' . $loc['zip'];
    }
}
