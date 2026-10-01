<?php
/** @var array $items */
if (!$items) return;
?>
<div class="tslider" data-slider>
  <div class="tslider__track" data-slider-track tabindex="0" aria-label="Patient testimonials">
    <?php foreach ($items as $t): ?>
    <figure class="tquote">
      <div class="tquote__stars" aria-label="<?= (int)$t['rating'] ?> out of 5 stars"><?= str_repeat(icon('star'), max(1, min(5, (int)$t['rating']))) ?></div>
      <blockquote class="tquote__text"><p><?= nl2br(e($t['content'])) ?></p></blockquote>
      <figcaption class="tquote__by">
        <span class="tquote__avatar" aria-hidden="true"><?= e(mb_substr($t['name'], 0, 1)) ?></span>
        <span><strong><?= e($t['name']) ?></strong><?php if ($t['label']): ?><small><?= e($t['label']) ?></small><?php endif; ?></span>
      </figcaption>
    </figure>
    <?php endforeach; ?>
  </div>
  <div class="tslider__nav">
    <button type="button" class="round-btn" data-slider-prev aria-label="Previous testimonial"><?= icon('arrow-left') ?></button>
    <button type="button" class="round-btn" data-slider-next aria-label="Next testimonial"><?= icon('arrow-right') ?></button>
  </div>
</div>
