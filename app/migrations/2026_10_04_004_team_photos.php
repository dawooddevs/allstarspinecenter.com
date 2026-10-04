<?php
/**
 * Sets each provider's photo from the team images uploaded to the Media Library, matched by the
 * team member's name in the file name (Content::providerPhotoMatch). The photo field feeds every
 * place a provider appears: profile pages, Our Providers, the homepage and About Us team sections,
 * and sidebars. Returns false (retry next deploy, max 3) while any provider has no photo.
 */
return function (): array|false {
    $images = DB::all("SELECT * FROM media WHERE kind = 'image' ORDER BY id ASC");
    $log = [];
    $missing = 0;
    foreach (DB::all("SELECT id, slug, name, photo FROM providers ORDER BY sort_order") as $p) {
        $m = Content::providerPhotoMatch($p, $images);
        if (!$m) {
            $missing++;
            $log[] = "{$p['name']}: no image with this name found" . ($p['photo'] ? " (keeps {$p['photo']})" : '');
            continue;
        }
        if ($p['photo'] === $m['path']) {
            $log[] = "{$p['name']}: already uses {$m['path']}";
            continue;
        }
        DB::update('providers', ['photo' => $m['path'], 'updated_at' => now()], 'id = ?', [$p['id']]);
        if (trim((string)$m['alt']) === '') {
            DB::update('media', ['alt' => $p['name']], 'id = ?', [$m['id']]);
        }
        $log[] = "{$p['name']}: photo set to {$m['path']} (from \"{$m['original_name']}\")";
    }
    if ($missing) {
        foreach ($log as $line) echo "  - {$line}\n";
        echo "  Images in the Media Library: " . implode(', ', array_map(fn($m) => $m['original_name'], $images)) . "\n";
        return false;
    }
    return $log;
};
