<?php
/** @var array $l */
?>
<article class="lcard" id="<?= e($l['slug']) ?>">
  <div class="lcard__map">
    <?php if (!empty($l['image']) && !empty($showImage)): ?>
      <?= img($l['image'], setting('site_short_name') . ' ' . $l['name'] . ' office') ?>
    <?php else: ?>
      <iframe title="Map of the <?= e($l['name']) ?> office" src="<?= e(Content::mapEmbed($l)) ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
    <?php endif; ?>
  </div>
  <div class="lcard__body">
    <p class="eyebrow eyebrow--sm"><?= icon('map-pin') ?>Arizona Office</p>
    <h3 class="lcard__name"><?= e($l['name']) ?></h3>
    <address class="lcard__addr"><?= e($l['address']) ?><br><?= e($l['city'] . ', ' . $l['state'] . ' ' . $l['zip']) ?></address>
    <div class="btn-row">
      <a class="btn btn--dark" href="<?= e(Content::mapsDirections($l)) ?>" target="_blank" rel="noopener"><?= icon('navigation') ?>Directions</a>
      <a class="btn btn--outline" href="<?= e(url('make-appointment/')) ?>">Request Appointment</a>
    </div>
  </div>
</article>
