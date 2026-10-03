<?php
$hex = fn($v, $d) => preg_match('/^#[0-9a-f]{6}$/i', (string)$v) ? $v : $d;
$primary = $hex(setting('color_primary'), '#0c2d5e');
$accent = $hex(setting('color_accent'), '#e23744');
$highlight = $hex(setting('color_highlight'), '#2f7cf6');
$favicon = setting('favicon');
$gaId = preg_replace('/[^A-Za-z0-9\-]/', '', (string)setting('ga_id'));
?><!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <script>document.documentElement.classList.add('js')</script>
  <?= Seo::head() ?>

  <meta name="theme-color" content="<?= e($primary) ?>">
  <link rel="preload" href="<?= e(url('assets/fonts/plus-jakarta-sans-normal.woff2')) ?>" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="<?= e(url('assets/fonts/instrument-serif-italic.woff2')) ?>" as="font" type="font/woff2" crossorigin>
  <link rel="stylesheet" href="<?= e(asset(is_file(ROOT . '/assets/css/site.min.css') ? 'css/site.min.css' : 'css/site.css')) ?>">
  <style>:root{--primary:<?= $primary ?>;--accent:<?= $accent ?>;--highlight:<?= $highlight ?>}</style>
  <?php if ($favicon): ?>
  <link rel="icon" href="<?= e(media_url($favicon)) ?>">
  <?php else: ?>
  <link rel="icon" href="<?= e(url('assets/img/favicon.png')) ?>" type="image/png">
  <?php endif; ?>
  <link rel="apple-touch-icon" href="<?= e(url('assets/img/apple-touch-icon.png')) ?>">
  <?php if ($gaId): ?>
  <script async src="https://www.googletagmanager.com/gtag/js?id=<?= e($gaId) ?>"></script>
  <script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments)}gtag('js',new Date());gtag('config','<?= e($gaId) ?>');</script>
  <?php endif; ?>
  <?= setting('head_scripts') /* trusted: admin-only setting */ ?>
</head>
<body>
  <a class="skip-link" href="#main">Skip to content</a>
  <?php partial('header', ['path' => $path]); ?>
  <main id="main" tabindex="-1">
    <?= $content ?>
  </main>
  <?php partial('footer'); ?>
  <?php partial('mobile-bar'); ?>
  <?php if (setting('cookie_notice') === '1'): ?>
  <div class="cookie" data-cookie hidden>
    <p>We use essential cookies and basic analytics to improve this website. See our <a href="<?= e(url('privacy-policy/')) ?>">Privacy Policy</a>.</p>
    <button class="btn btn--sm btn--dark" type="button" data-cookie-ok>Got it</button>
  </div>
  <?php endif; ?>
  <script src="<?= e(asset(is_file(ROOT . '/assets/js/site.min.js') ? 'js/site.min.js' : 'js/site.js')) ?>" defer></script>
  <?= setting('chat_widget') /* trusted: admin-only setting */ ?>
  <?= setting('body_scripts') /* trusted: admin-only setting */ ?>
</body>
</html>
