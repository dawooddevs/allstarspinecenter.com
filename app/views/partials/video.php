<?php
/** @var array $v one entry from Content::videos() */
$class = $class ?? '';
?>
<figure class="vcard <?= e($class) ?>">
  <div class="vcard__frame" data-video-frame>
    <video controls playsinline preload="metadata" aria-label="<?= e($v['label']) ?>">
      <source src="<?= e($v['url']) ?>#t=0.1" type="<?= e($v['mime']) ?>">
    </video>
  </div>
  <?php if (!empty($caption)): ?><figcaption class="vcard__cap"><?= icon('play') ?><?= e($v['label']) ?></figcaption><?php endif; ?>
</figure>
