<?php
/**
 * Adds the product video from the old site to the Theramine, Trepadone and Percura pages
 * (end of "What is …"), unless it is already there.
 */
return function (): array {
    $video = <<<'HTML'
<h3>Watch: medical foods explained</h3>
<div class="video-embed"><iframe src="https://www.youtube-nocookie.com/embed/A6EAz_GVfg0" title="Medical foods video" loading="lazy" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
HTML;
    $log = [];
    foreach (['theramine', 'trepadone', 'percura'] as $slug) {
        $row = DB::one('SELECT id, what_is FROM services WHERE slug = ?', [$slug]);
        if (!$row) {
            $log[] = "{$slug}: not found";
            continue;
        }
        if (str_contains((string)$row['what_is'], 'A6EAz_GVfg0')) {
            $log[] = "{$slug}: video already present";
            continue;
        }
        DB::update('services', ['what_is' => Html::clean(trim((string)$row['what_is']) . "\n" . $video), 'updated_at' => now()], 'id = ?', [$row['id']]);
        $log[] = "{$slug}: video added";
    }
    return $log;
};
