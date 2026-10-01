<?php
$light = !empty($light);
$logo = $light ? (setting('logo_light') ?: '') : setting('logo');
if ($logo): ?>
<?= img($logo, setting('site_name'), ['class' => 'brand__img', 'loading' => 'eager', 'decoding' => 'sync']) ?>
<?php else: ?>
<span class="brand__mark" aria-hidden="true">
  <svg viewBox="0 0 48 48" width="44" height="44"><defs><linearGradient id="bm<?= $light ? 'l' : 'd' ?>" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="var(--accent)"/><stop offset="1" stop-color="#ff6b5b"/></linearGradient></defs><rect width="48" height="48" rx="14" fill="url(#bm<?= $light ? 'l' : 'd' ?>)"/><path d="M24 9.5l4.2 8.6 9.5 1.4-6.9 6.7 1.6 9.4L24 31.2l-8.5 4.4 1.6-9.4-6.9-6.7 9.5-1.4z" fill="#fff"/></svg>
</span>
<span class="brand__text">
  <span class="brand__name">All Star Health</span>
  <span class="brand__sub">Spine &amp; Joint Care</span>
</span>
<?php endif; ?>
