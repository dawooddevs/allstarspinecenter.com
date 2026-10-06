<?php
/**
 * Sets the two homepage column images from uploads named after their sections:
 * "Not Just Better Healthcare…" → Integrated Care (about_image) and
 * "Patient Satisfaction Is Our Working Motivation…" → Testimonials (testimonials_image).
 * The newest matching image wins; returns false (retry next deploy) if one isn't uploaded yet.
 */
return function (): array|false {
    $want = [
        'about_image' => 'not-just-better-healthcare',
        'testimonials_image' => 'patient-satisfaction',
    ];
    $images = DB::all("SELECT * FROM media WHERE kind = 'image' ORDER BY id ASC");
    $log = [];
    $missing = 0;
    foreach ($want as $key => $needle) {
        $hit = null;
        foreach ($images as $m) {
            $names = slugify(pathinfo((string)$m['original_name'], PATHINFO_FILENAME)) . ' ' . slugify(pathinfo((string)$m['path'], PATHINFO_FILENAME));
            if (str_contains($names, $needle)) $hit = $m; // newest wins
        }
        if (!$hit) {
            $missing++;
            echo "  - {$key}: no image named like \"{$needle}\" yet\n";
            continue;
        }
        Settings::set($key, $hit['path']);
        if (trim((string)$hit['alt']) === '') {
            DB::update('media', ['alt' => $key === 'about_image' ? 'The All Star Health care team' : 'A patient with an All Star Health provider'], 'id = ?', [$hit['id']]);
        }
        $log[] = "{$key} → {$hit['path']} (\"{$hit['original_name']}\")";
    }
    if ($missing) {
        foreach ($log as $l) echo "  - {$l}\n";
        return false;
    }
    return $log;
};
