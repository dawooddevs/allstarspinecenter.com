<?php
/**
 * Read-only content report printed at the end of each deploy: team photos, which old-site
 * videos and patient-form PDFs were found in the Media Library, and the videos uploaded.
 *
 *   php app/cli/report.php
 */
if (PHP_SAPI !== 'cli') {
    exit("CLI only\n");
}
require dirname(__DIR__) . '/bootstrap.php';
if (!is_installed()) {
    exit(0);
}
echo "Team photos:\n";
foreach (DB::all("SELECT name, photo FROM providers ORDER BY sort_order") as $p) {
    printf("  %-22s %s\n", $p['name'], $p['photo'] ?: '(no photo)');
}
echo "Videos used on the site:\n";
foreach (Content::videos() as $key => $v) {
    printf("  %-10s %-8s %s%s\n", $key, $v['source'], $v['file'], $v['url'] ? '  -> ' . $v['url'] : '');
}
echo "Videos in the Media Library:\n";
foreach (DB::all("SELECT path, original_name, size FROM media WHERE kind = 'video' ORDER BY id") as $m) {
    printf("  %s (%s, %.1f MB)\n", $m['original_name'], $m['path'], $m['size'] / 1048576);
}
$counts = [];
foreach (Content::formGroups() as $g) foreach ($g['items'] as $f) $counts[$f['source']] = ($counts[$f['source']] ?? 0) + 1;
echo 'Patient-form PDFs: ' . implode(', ', array_map(fn($k, $n) => "$n $k", array_keys($counts), $counts)) . "\n";
