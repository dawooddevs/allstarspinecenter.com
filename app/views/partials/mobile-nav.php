<?php $phone = setting('phone'); ?>
<div class="mnav" id="mobile-nav" data-mnav hidden>
  <div class="mnav__backdrop" data-menu-close></div>
  <div class="mnav__panel" role="dialog" aria-modal="true" aria-label="Menu">
    <div class="mnav__top">
      <a class="brand brand--sm" href="<?= e(url('')) ?>"><?php partial('logo'); ?></a>
      <button class="mnav__close" type="button" data-menu-close><?= icon('x') ?><span class="sr-only">Close menu</span></button>
    </div>
    <nav class="mnav__body" aria-label="Mobile navigation">
      <div class="mnav__section">
        <button class="mnav__toggle" type="button" aria-expanded="false">About Us<?= icon('chevron-down') ?></button>
        <div class="mnav__sub" hidden>
          <?php foreach ($about as [$label, $href]): ?>
          <a href="<?= e(url($href)) ?>"><?= e($label) ?></a>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="mnav__section">
        <button class="mnav__toggle" type="button" aria-expanded="false">Pain Treatments<?= icon('chevron-down') ?></button>
        <div class="mnav__sub" hidden>
          <a class="mnav__all" href="<?= e(url('pain-treatments/')) ?>">View All Treatments <?= icon('arrow-right') ?></a>
          <?php foreach (Content::CATEGORIES as $key => $cat):
              $items = array_filter($byCat[$key] ?? [], fn($s) => (int)$s['show_in_menu'] === 1);
              if (!$items) continue; ?>
          <div class="mnav__section mnav__section--nested">
            <button class="mnav__toggle mnav__toggle--nested" type="button" aria-expanded="false"><span class="mnav__cat-icon"><?= icon($cat['icon']) ?></span><?= e($cat['label']) ?><?= icon('chevron-down') ?></button>
            <div class="mnav__sub" hidden>
              <?php foreach ($items as $s): ?>
              <a href="<?= e(Content::serviceUrl($s)) ?>"><?= e(preg_replace('/\s*—\s*Coming Soon$/i', '', $s['menu_label'] ?: $s['title'])) ?><?= (int)$s['coming_soon'] ? ' <span class="tag tag--soon">Soon</span>' : '' ?></a>
              <?php endforeach; ?>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="mnav__section">
        <button class="mnav__toggle" type="button" aria-expanded="false">Patient Center<?= icon('chevron-down') ?></button>
        <div class="mnav__sub" hidden>
          <a href="<?= e(url('make-appointment/')) ?>">New Patient / First Visit</a>
          <a href="<?= e(url('your-first-visit/')) ?>">Your First Visit</a>
          <a href="<?= e(url('billing-and-insurance/')) ?>">Billing &amp; Insurance</a>
          <p class="mnav__label">Patient Forms</p>
          <?php foreach ($forms as $f): ?>
          <a href="<?= e($formUrl($f)) ?>"<?= $f['download'] ? ' target="_blank" rel="noopener"' : '' ?>><?= icon($f['download'] ? 'download' : 'file-text') ?><?= e($f['label']) ?></a>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="mnav__section">
        <button class="mnav__toggle" type="button" aria-expanded="false">Contact<?= icon('chevron-down') ?></button>
        <div class="mnav__sub" hidden>
          <?php foreach ($contact as [$label, $href]): ?>
          <a href="<?= e(url($href)) ?>"><?= e($label) ?></a>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="mnav__quick">
        <a href="<?= e(url('locations/')) ?>"><?= icon('map-pin') ?>Locations</a>
        <a href="<?= e(url('billing-and-insurance/')) ?>"><?= icon('shield-check') ?>Billing &amp; Insurance</a>
      </div>
    </nav>
    <div class="mnav__foot">
      <a class="btn btn--accent btn--block btn--lg" href="<?= e(url('make-appointment/')) ?>"><?= icon('calendar-check') ?>Request Appointment</a>
      <div class="mnav__foot-row">
        <a class="btn btn--outline btn--block" href="<?= e(tel_href($phone)) ?>"><?= icon('phone') ?>Call</a>
        <a class="btn btn--outline btn--block" href="<?= e(sms_href(setting('sms_phone') ?: $phone)) ?>"><?= icon('message') ?>Text</a>
      </div>
    </div>
  </div>
</div>
