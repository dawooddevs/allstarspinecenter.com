<?php
require dirname(__DIR__) . '/app/bootstrap.php';
if (!is_installed()) {
    redirect(url('install/'));
}
Auth::start();
header('Cache-Control: no-store');
header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: same-origin');
$v = fn($f) => url('admin/assets/' . $f) . '?v=' . substr((string)@filemtime(__DIR__ . '/assets/' . $f), -6);
?><!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, nofollow">
  <title>Dashboard · <?= e(setting('site_short_name')) ?></title>
  <link rel="icon" href="<?= e(setting('favicon') ? media_url(setting('favicon')) : url('assets/img/favicon.svg')) ?>">
  <link rel="preload" href="<?= e(url('assets/fonts/plus-jakarta-sans-normal.woff2')) ?>" as="font" type="font/woff2" crossorigin>
  <link rel="stylesheet" href="<?= e($v('admin.css')) ?>">
  <script>
    (function () { try { var t = localStorage.getItem('ash-theme'); if (t === 'dark' || (!t && matchMedia('(prefers-color-scheme: dark)').matches)) document.documentElement.setAttribute('data-theme', 'dark'); } catch (e) {} })();
  </script>
</head>
<body>
  <div id="app" aria-live="polite">
    <div class="boot"><div class="boot__mark"></div><p>Loading dashboard…</p></div>
  </div>
  <div id="toasts" class="toasts" role="status" aria-live="polite"></div>
  <div id="modal-root"></div>
  <script>
    window.ASH = <?= json_encode([
        'api' => url('admin/api.php'),
        'base' => url(''),
        'csrf' => Auth::csrf(),
        'version' => VERSION,
        'siteName' => setting('site_short_name'),
    ], JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?>;
  </script>
  <script src="<?= e($v('admin.js')) ?>" defer></script>
</body>
</html>
