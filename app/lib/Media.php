<?php
/**
 * Media library: uploads, image optimisation (resize + WebP + thumbnail) and lookups.
 */
final class Media
{
    public const MAX_BYTES = 100 * 1024 * 1024;
    public const MAX_DIMENSION = 2400;

    private const TYPES = [
        'jpg' => ['image/jpeg', 'image'], 'jpeg' => ['image/jpeg', 'image'], 'png' => ['image/png', 'image'],
        'gif' => ['image/gif', 'image'], 'webp' => ['image/webp', 'image'], 'avif' => ['image/avif', 'image'],
        'pdf' => ['application/pdf', 'document'], 'doc' => ['application/msword', 'document'],
        'docx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'document'],
        'xls' => ['application/vnd.ms-excel', 'document'], 'xlsx' => ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'document'],
        'mp4' => ['video/mp4', 'video'], 'webm' => ['video/webm', 'video'], 'mov' => ['video/quicktime', 'video'],
    ];

    private static ?array $map = null;

    public static function allowedExtensions(): array
    {
        return array_keys(self::TYPES);
    }

    /** Find a media row by its stored path (cached for the request). */
    public static function lookup(string $path): ?array
    {
        if (!DB::connected() || preg_match('~^(https?:)?//~', $path)) {
            return null;
        }
        if (self::$map === null) {
            self::$map = [];
            try {
                foreach (DB::all('SELECT path, webp, width, height, alt FROM media') as $r) {
                    self::$map[$r['path']] = $r;
                }
            } catch (Throwable $e) {
            }
        }
        return self::$map[ltrim($path, '/')] ?? null;
    }

    public static function upload(array $file, int $userId, string $folder = ''): array
    {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            $codes = [
                UPLOAD_ERR_INI_SIZE => 'File exceeds the server upload limit (' . ini_get('upload_max_filesize') . ').',
                UPLOAD_ERR_FORM_SIZE => 'File is too large.',
                UPLOAD_ERR_PARTIAL => 'File was only partially uploaded.',
                UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
            ];
            throw new RuntimeException($codes[$file['error'] ?? 4] ?? 'Upload failed.');
        }
        if ($file['size'] > self::MAX_BYTES) {
            throw new RuntimeException('File is larger than 100 MB.');
        }
        $original = basename((string)$file['name']);
        $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));
        if (!isset(self::TYPES[$ext])) {
            throw new RuntimeException('File type .' . $ext . ' is not allowed.');
        }
        [$mime, $kind] = self::TYPES[$ext];
        $detected = function_exists('mime_content_type') ? (string)@mime_content_type($file['tmp_name']) : '';
        if ($kind === 'image' && $detected !== '' && !str_starts_with($detected, 'image/')) {
            throw new RuntimeException('That file does not look like a valid image.');
        }
        if ($ext === 'pdf' && $detected !== '' && !in_array($detected, ['application/pdf', 'application/x-pdf', 'application/octet-stream'], true)) {
            throw new RuntimeException('That file does not look like a valid PDF.');
        }

        $sub = 'uploads/' . date('Y/m');
        $dir = ROOT . '/' . $sub;
        if (!is_dir($dir) && !mkdir($dir, 0755, true)) {
            throw new RuntimeException('Could not create the uploads folder. Check permissions on /uploads.');
        }
        $base = slugify(pathinfo($original, PATHINFO_FILENAME)) ?: 'file';
        $base = substr($base, 0, 60);
        $name = $base . '.' . $ext;
        $i = 1;
        while (file_exists($dir . '/' . $name)) {
            $name = $base . '-' . (++$i) . '.' . $ext;
        }
        $dest = $dir . '/' . $name;
        if (!move_uploaded_file($file['tmp_name'], $dest) && !rename($file['tmp_name'], $dest)) {
            throw new RuntimeException('Could not save the uploaded file.');
        }
        @chmod($dest, 0644);

        $row = [
            'path' => $sub . '/' . $name,
            'webp' => '',
            'thumb' => '',
            'original_name' => mb_substr($original, 0, 250),
            'mime' => $mime,
            'kind' => $kind,
            'size' => (int)filesize($dest),
            'width' => 0,
            'height' => 0,
            'alt' => '',
            'title' => ucwords(str_replace('-', ' ', $base)),
            'folder' => substr(slugify($folder), 0, 80),
            'uploaded_by' => $userId,
            'created_at' => now(),
        ];
        if ($kind === 'image') {
            $row = array_merge($row, self::processImage($dest, $sub, pathinfo($name, PATHINFO_FILENAME), $ext));
            $row['size'] = (int)filesize($dest);
        }
        $row['id'] = DB::insert('media', $row);
        self::$map = null;
        return $row;
    }

    private static function processImage(string $file, string $sub, string $base, string $ext): array
    {
        $out = ['width' => 0, 'height' => 0, 'webp' => '', 'thumb' => ''];
        $info = @getimagesize($file);
        if (!$info) {
            return $out;
        }
        [$w, $h] = $info;
        $out['width'] = $w;
        $out['height'] = $h;
        if (!extension_loaded('gd') || in_array($ext, ['gif', 'avif'], true)) {
            return $out;
        }
        $src = match ($ext) {
            'jpg', 'jpeg' => @imagecreatefromjpeg($file),
            'png' => @imagecreatefrompng($file),
            'webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($file) : false,
            default => false,
        };
        if (!$src) {
            return $out;
        }
        if (in_array($ext, ['jpg', 'jpeg'], true) && function_exists('exif_read_data')) {
            $exif = @exif_read_data($file);
            $o = (int)($exif['Orientation'] ?? 1);
            $rot = [3 => 180, 6 => -90, 8 => 90][$o] ?? 0;
            if ($rot) {
                $r = imagerotate($src, $rot, 0);
                if ($r) {
                    imagedestroy($src);
                    $src = $r;
                    $w = imagesx($src);
                    $h = imagesy($src);
                    $out['width'] = $w;
                    $out['height'] = $h;
                }
            }
        }
        // Downscale very large originals in place
        if ($w > self::MAX_DIMENSION || $h > self::MAX_DIMENSION) {
            $scale = self::MAX_DIMENSION / max($w, $h);
            $resized = self::resample($src, (int)round($w * $scale), (int)round($h * $scale));
            imagedestroy($src);
            $src = $resized;
            $w = imagesx($src);
            $h = imagesy($src);
            $out['width'] = $w;
            $out['height'] = $h;
            if (in_array($ext, ['jpg', 'jpeg'], true)) {
                imagejpeg($src, $file, 84);
            } elseif ($ext === 'png') {
                imagepng($src, $file, 7);
            } elseif ($ext === 'webp') {
                imagewebp($src, $file, 82);
            }
        }
        if (function_exists('imagewebp')) {
            if ($ext !== 'webp') {
                $webp = $sub . '/' . $base . '.webp';
                if (!file_exists(ROOT . '/' . $webp) && @imagewebp($src, ROOT . '/' . $webp, 80)) {
                    $out['webp'] = $webp;
                }
            }
            $tw = 480;
            if ($w > $tw) {
                $thumb = self::resample($src, $tw, (int)round($h * $tw / $w));
                $tp = $sub . '/' . $base . '-thumb.webp';
                if (@imagewebp($thumb, ROOT . '/' . $tp, 78)) {
                    $out['thumb'] = $tp;
                }
                imagedestroy($thumb);
            }
        }
        imagedestroy($src);
        return $out;
    }

    private static function resample($src, int $nw, int $nh)
    {
        $dst = imagecreatetruecolor($nw, $nh);
        imagealphablending($dst, false);
        imagesavealpha($dst, true);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, imagesx($src), imagesy($src));
        return $dst;
    }

    public static function deleteFiles(array $row): void
    {
        foreach (['path', 'webp', 'thumb'] as $k) {
            $p = (string)($row[$k] ?? '');
            if ($p !== '' && str_starts_with($p, 'uploads/') && !str_contains($p, '..')) {
                @unlink(ROOT . '/' . $p);
            }
        }
        self::$map = null;
    }

    public static function present(array $r): array
    {
        $r['id'] = (int)$r['id'];
        $r['size'] = (int)$r['size'];
        $r['width'] = (int)$r['width'];
        $r['height'] = (int)$r['height'];
        $r['url'] = media_url($r['path']);
        $r['thumb_url'] = media_url($r['thumb'] ?: ($r['webp'] ?: $r['path']));
        $r['abs_url'] = abs_url($r['path']);
        return $r;
    }
}
