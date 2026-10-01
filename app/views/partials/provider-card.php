<?php
/** @var array $p */
$initials = implode('', array_map(fn($w) => mb_substr($w, 0, 1), array_slice(array_values(array_filter(explode(' ', preg_replace('/^(Dr\.?\s+)/i', '', $p['name'])), fn($w) => strlen($w) > 2 || ctype_alpha($w))), 0, 2)));
?>
<article class="pcard" data-type="<?= e($p['type']) ?>" data-search="<?= e(strtolower($p['name'] . ' ' . $p['title'] . ' ' . (Content::PROVIDER_TYPES[$p['type']] ?? ''))) ?>">
  <a class="pcard__link" href="<?= e(Content::providerUrl($p)) ?>">
    <div class="pcard__media">
      <?php if ($p['photo']): ?>
        <?= img($p['photo'], $p['name'] . ', ' . $p['title'], ['style' => 'object-position:' . ($p['photo_position'] ?: '50% 20%')]) ?>
      <?php else: ?>
        <div class="pcard__avatar" aria-hidden="true"><span><?= e(strtoupper($initials)) ?></span></div>
      <?php endif; ?>
    </div>
    <div class="pcard__body">
      <p class="pcard__role"><?= e(Content::PROVIDER_TYPES[$p['type']] ?? 'Provider') ?></p>
      <h3 class="pcard__name"><?= e($p['name']) ?><?= $p['credentials'] ? '<span>, ' . e($p['credentials']) . '</span>' : '' ?></h3>
      <p class="pcard__title"><?= e($p['title']) ?></p>
      <span class="pcard__more">View Profile <?= icon('arrow-right') ?></span>
    </div>
  </a>
</article>
