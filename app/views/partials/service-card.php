<?php
/** @var array $s */
$cat = Content::CATEGORIES[$s['category']] ?? ['short' => '', 'icon' => 'activity'];
$soon = (int)$s['coming_soon'] === 1;
?>
<article class="tcard<?= !empty($class) ? ' ' . e($class) : '' ?>" data-cat="<?= e($s['category']) ?>" data-featured="<?= (int)$s['featured'] ?>" data-search="<?= e(strtolower($s['title'] . ' ' . $s['menu_label'] . ' ' . $cat['short'] . ' ' . str_replace("\n", ' ', (string)$s['conditions']) . ' ' . $s['excerpt'])) ?>">
  <a class="tcard__link" href="<?= e(Content::serviceUrl($s)) ?>">
    <div class="tcard__media">
      <?php if ($s['image']): ?>
        <?= img($s['image'], $s['title'], ['sizes' => '(min-width: 1024px) 25vw, 90vw']) ?>
      <?php else: ?>
        <?php partial('art', ['icon' => Content::serviceIcon($s), 'variant' => $s['category']]); ?>
      <?php endif; ?>
      <span class="tcard__tag"><?= e($cat['short']) ?></span>
      <?php if ($soon): ?><span class="tcard__soon">Coming soon</span><?php endif; ?>
    </div>
    <div class="tcard__body">
      <h3 class="tcard__title"><?= e(preg_replace('/\s*—\s*Coming Soon$/i', '', $s['title'])) ?></h3>
      <p class="tcard__text"><?= e(str_limit((string)$s['excerpt'], 120)) ?></p>
      <span class="tcard__more">Learn more <span class="tcard__arrow"><?= icon('arrow-right') ?></span></span>
    </div>
  </a>
</article>
