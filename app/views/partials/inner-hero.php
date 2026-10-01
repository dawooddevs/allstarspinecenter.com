<?php
/** @var string $title */
$crumbs = $crumbs ?? [];
$eyebrow = $eyebrow ?? '';
$text = $text ?? '';
$image = $image ?? '';
$artIcon = $artIcon ?? 'heart-pulse';
$artVariant = $artVariant ?? 'medical';
$showActions = $showActions ?? true;
$imagePosition = $imagePosition ?? '50% 50%';
Seo::$breadcrumbs = array_merge([['Home', '']], $crumbs);
?>
<section class="ihero">
  <div class="ihero__bg" aria-hidden="true"><span></span><span></span></div>
  <div class="container ihero__inner<?= $image || !empty($withArt) ? ' ihero__inner--media' : '' ?>">
    <div class="ihero__content" data-reveal>
      <nav class="crumbs" aria-label="Breadcrumb">
        <ol>
          <li><a href="<?= e(url('')) ?>">Home</a></li>
          <?php foreach ($crumbs as $i => [$label, $href]): ?>
          <li><?= icon('chevron-right') ?><?php if ($i === count($crumbs) - 1): ?><span aria-current="page"><?= e($label) ?></span><?php else: ?><a href="<?= e(url($href)) ?>"><?= e($label) ?></a><?php endif; ?></li>
          <?php endforeach; ?>
        </ol>
      </nav>
      <?php if ($eyebrow): ?><p class="eyebrow"><?= e($eyebrow) ?></p><?php endif; ?>
      <h1 class="ihero__title"><?= e($title) ?></h1>
      <?php if ($text): ?><p class="ihero__text"><?= e($text) ?></p><?php endif; ?>
      <?php if (!empty($badge)): ?><p class="ihero__badge"><?= $badge ?></p><?php endif; ?>
      <?php if ($showActions): ?>
      <div class="btn-row">
        <a class="btn btn--accent btn--lg" href="<?= e(url('make-appointment/')) ?>">Request Appointment <?= icon('arrow-right') ?></a>
        <a class="btn btn--ghost btn--lg" href="<?= e(tel_href(setting('phone'))) ?>"><?= icon('phone') ?>Call <?= e(setting('phone')) ?></a>
      </div>
      <?php endif; ?>
    </div>
    <?php if ($image): ?>
    <div class="ihero__media" data-reveal="mask">
      <?= img($image, $title, ['loading' => 'eager', 'fetchpriority' => 'high', 'style' => 'object-position:' . $imagePosition]) ?>
    </div>
    <?php elseif (!empty($withArt)): ?>
    <div class="ihero__media" data-reveal="mask">
      <?php partial('art', ['icon' => $artIcon, 'variant' => $artVariant, 'label' => $eyebrow, 'large' => true]); ?>
    </div>
    <?php endif; ?>
  </div>
</section>
