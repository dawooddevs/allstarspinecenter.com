<?php $phone = setting('phone'); ?>
<section class="section section--cta">
  <div class="container">
    <div class="cta" data-reveal>
      <div class="cta__bg" aria-hidden="true"><span></span><span></span><span></span></div>
      <div class="cta__content">
        <p class="eyebrow eyebrow--light">Request an appointment</p>
        <h2 class="cta__title"><?= e($headline ?? setting('cta_headline')) ?></h2>
        <p class="cta__text"><?= e($copy ?? setting('cta_copy')) ?></p>
        <div class="btn-row">
          <a class="btn btn--accent btn--lg" href="<?= e(url('make-appointment/')) ?>"><?= e($button ?? 'Request An Appointment') ?> <?= icon('arrow-right') ?></a>
          <a class="btn btn--glass btn--lg" href="<?= e(tel_href($phone)) ?>"><?= icon('phone') ?>Call <?= e($phone) ?></a>
        </div>
        <p class="cta__small"><?= e(setting('cta_small_print')) ?></p>
      </div>
    </div>
  </div>
</section>
