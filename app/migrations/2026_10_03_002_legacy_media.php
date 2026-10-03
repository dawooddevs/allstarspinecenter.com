<?php
/**
 * Copies provider headshots and the current patient-form PDFs from the previous
 * WordPress site into the media library. Best effort: anything already set in the
 * dashboard is left alone, and a failed download is retried on the next deploy.
 * Returning false means "not finished, try again later".
 */
return function (): array|false {
    $old = 'https://allstarspinecenter.com/wp-content/uploads/';
    $photos = [
        'dr-andre-silano' => '2024/09/Dr.-Andre-Silano.png',
        'dr-christopher-boeke' => '2026/01/Dr.-Christopher-Boeke.png',
        'dr-darin-krueger' => '2024/09/Dr.-Krueger.png',
        'dr-scott-griffin' => '2024/09/Dr.-Scott-Griffin.png',
        'dr-todd-dreitzler' => '2024/09/Dr.-Todd-Dreitzler.png',
        'michael-d-prisbrey' => '2024/09/Untitled-design-50.png',
    ];
    $forms = [
        'form_new_patient_en' => '2026/01/Updated-1-13-26-All-Star-Health-New-Patient-Form-English.pdf',
        'form_new_patient_es' => '2026/01/Updated-1-13-26-All-Star-Health-New-Patient-Form-Spanish.pdf',
        'form_accident_en' => '2026/01/Updated-1-13-26-All-Star-Health-New-Patient-Form-with-Accident-info-English.pdf',
        'form_accident_es' => '2026/01/Updated-1-13-26-All-Star-Health-New-Patient-Form-Accident-Spanish.pdf',
    ];
    $userId = (int)DB::val("SELECT id FROM users WHERE role = 'admin' ORDER BY id LIMIT 1");
    $log = [];
    $failed = 0;

    $fetch = function (string $url, string $saveAs) use (&$log): ?array {
        if (!function_exists('curl_init')) {
            $log[] = 'curl is not available on this server';
            return null;
        }
        $tmp = STORAGE . '/legacy-' . bin2hex(random_bytes(6));
        $fh = fopen($tmp, 'wb');
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_FILE => $fh, CURLOPT_FOLLOWLOCATION => true, CURLOPT_MAXREDIRS => 3,
            CURLOPT_CONNECTTIMEOUT => 10, CURLOPT_TIMEOUT => 40,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; AllStarHealthSiteMigration/1.0)',
        ]);
        $ok = curl_exec($ch);
        $code = (int)curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);
        fclose($fh);
        $head = (string)@file_get_contents($tmp, false, null, 0, 8);
        $valid = str_starts_with($head, "\x89PNG") || str_starts_with($head, "\xFF\xD8") || str_starts_with($head, '%PDF');
        if (!$ok || $code !== 200 || !$valid) {
            @unlink($tmp);
            $log[] = "download failed ({$code}" . ($valid ? '' : ', not a file') . "): {$url}";
            return null;
        }
        return ['name' => $saveAs, 'tmp_name' => $tmp, 'size' => (int)filesize($tmp), 'error' => UPLOAD_ERR_OK];
    };

    foreach ($photos as $slug => $file) {
        $p = DB::one('SELECT id, name, photo FROM providers WHERE slug = ?', [$slug]);
        if (!$p || trim((string)$p['photo']) !== '') {
            continue;
        }
        $f = $fetch($old . $file, 'provider-' . $slug . '.' . pathinfo($file, PATHINFO_EXTENSION));
        if (!$f) {
            $failed++;
            continue;
        }
        try {
            $m = Media::upload($f, $userId, 'providers');
            DB::update('media', ['alt' => $p['name'], 'title' => $p['name']], 'id = ?', [$m['id']]);
            DB::update('providers', ['photo' => $m['path'], 'updated_at' => now()], 'id = ?', [$p['id']]);
            $log[] = "photo set: {$p['name']}";
        } catch (Throwable $e) {
            @unlink($f['tmp_name']);
            $failed++;
            $log[] = "photo failed for {$slug}: " . $e->getMessage();
        }
    }

    foreach ($forms as $key => $file) {
        if (trim((string)Settings::get($key, '')) !== '') {
            continue;
        }
        $f = $fetch($old . $file, basename($file));
        if (!$f) {
            $failed++;
            continue;
        }
        try {
            $m = Media::upload($f, $userId, 'patient-forms');
            Settings::set($key, $m['path']);
            $log[] = "form set: {$key}";
        } catch (Throwable $e) {
            @unlink($f['tmp_name']);
            $failed++;
            $log[] = "form failed for {$key}: " . $e->getMessage();
        }
    }

    if ($failed) {
        foreach ($log as $line) echo "  - {$line}\n";
        return false;
    }
    return $log ?: ['nothing to import'];
};
