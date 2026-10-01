<?php
/** @var array $page /locations/ */
Seo::set([
    'title' => $page['meta_title'] ?: $page['title'],
    'description' => $page['meta_description'] ?: $page['intro'],
    'canonical' => abs_url('locations/'),
]);
$locs = Content::locations();
partial('inner-hero', [
    'title' => $page['title'],
    'eyebrow' => $page['eyebrow'],
    'text' => $page['intro'],
    'crumbs' => [['Locations', 'locations/']],
]);
?>
<section class="section">
  <div class="container">
    <div class="loc-stack">
      <?php foreach ($locs as $i => $l): ?>
      <div class="loc-row<?= $i % 2 ? ' loc-row--flip' : '' ?>" data-reveal>
        <div class="loc-row__media">
          <?php if ($l['image']): ?>
            <?= img($l['image'], setting('site_short_name') . ' ' . $l['name'] . ' office') ?>
          <?php else: ?>
            <?php partial('art', ['icon' => 'building', 'variant' => $i % 2 ? 'soft-tissue' : 'medical', 'label' => $l['name'] . ' Office', 'large' => true]); ?>
          <?php endif; ?>
        </div>
        <?php partial('location-card', ['l' => $l]); ?>
      </div>
      <?php if ($l['description']): ?><p class="loc-row__desc"><?= e($l['description']) ?></p><?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<section class="section section--soft section--tight">
  <div class="container container--narrow center">
    <p class="eyebrow">Communities we serve</p>
    <h2 class="h3">Proudly serving <?= e(implode(', ', csv_list(setting('communities')))) ?> and surrounding Arizona communities</h2>
  </div>
</section>
<?php if (trim(strip_tags((string)$page['content'])) !== ''): ?>
<section class="section section--tight"><div class="container container--narrow prose prose--lg"><?= Html::clean($page['content']) ?></div></section>
<?php endif; ?>
<?php partial('cta'); ?>
