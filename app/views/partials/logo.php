<?php
$light = !empty($light);
$logo = $light ? (setting('logo_light') ?: '') : setting('logo');
if ($logo): ?>
<?= img($logo, setting('site_name'), ['class' => 'brand__img', 'loading' => 'eager', 'decoding' => 'sync']) ?>
<?php else: ?>
<img class="brand__img" src="<?= e(asset('img/' . ($light ? 'logo-light.png' : 'logo.png'))) ?>" alt="<?= e(setting('site_name')) ?>" width="293" height="90" decoding="sync">
<?php endif; ?>
