<?php
$phone = setting('phone');
$social = array_filter([
    'facebook' => setting('social_facebook'),
    'x-social' => setting('social_x'),
    'instagram' => setting('social_instagram'),
]);
$socialLabels = ['facebook' => 'Facebook', 'x-social' => 'X (Twitter)', 'instagram' => 'Instagram'];
?>
<footer class="footer">
  <div class="footer__glow" aria-hidden="true"></div>
  <div class="container">
    <div class="footer__grid">
      <div class="footer__brand">
        <a class="brand brand--light" href="<?= e(url('')) ?>"><?php partial('logo', ['light' => true]); ?></a>
        <p><?= e(setting('brand_description')) ?></p>
        <?php if ($social): ?>
        <ul class="footer__social">
          <?php foreach ($social as $k => $href): ?>
          <li><a href="<?= e($href) ?>" target="_blank" rel="noopener" aria-label="<?= e($socialLabels[$k]) ?>"><?= icon($k) ?></a></li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
      </div>
      <div>
        <h2 class="footer__title">Patients</h2>
        <ul class="footer__links">
          <li><a href="<?= e(url('make-appointment/')) ?>">Request Appointment</a></li>
          <li><a href="<?= e(url('your-first-visit/')) ?>">First Visit</a></li>
          <li><a href="<?= e(url('make-appointment/#patient-forms')) ?>">Patient Forms</a></li>
          <li><a href="<?= e(url('billing-and-insurance/')) ?>">Billing &amp; Insurance</a></li>
          <li><a href="<?= e(url('locations/')) ?>">Locations</a></li>
          <li><a href="<?= e(url('contact-us/')) ?>">Contact</a></li>
        </ul>
      </div>
      <div>
        <h2 class="footer__title">Treatments</h2>
        <ul class="footer__links">
          <?php foreach (Content::CATEGORIES as $k => $c): ?>
          <li><a href="<?= e(url('pain-treatments/?category=' . $k)) ?>"><?= e($c['label']) ?></a></li>
          <?php endforeach; ?>
          <li><a class="footer__more" href="<?= e(url('pain-treatments/')) ?>">View All Treatments <?= icon('arrow-right') ?></a></li>
        </ul>
      </div>
      <div>
        <h2 class="footer__title">Locations</h2>
        <ul class="footer__locs">
          <?php foreach (Content::locations() as $l): ?>
          <li>
            <strong><?= e($l['name']) ?></strong>
            <a href="<?= e(Content::mapsDirections($l)) ?>" target="_blank" rel="noopener"><?= e($l['address']) ?><br><?= e($l['city'] . ', ' . $l['state'] . ' ' . $l['zip']) ?></a>
          </li>
          <?php endforeach; ?>
          <li><a class="footer__phone" href="<?= e(tel_href($phone)) ?>"><?= icon('phone') ?><?= e($phone) ?></a></li>
        </ul>
      </div>
    </div>
    <div class="footer__bar">
      <p>&copy; <?= date('Y') ?> <strong><?= e(setting('site_name')) ?></strong>. All rights reserved.</p>
      <ul>
        <li><a href="<?= e(url('privacy-policy/')) ?>">Privacy Policy</a></li>
        <li><a href="<?= e(url('terms-and-conditions/')) ?>">Terms &amp; Conditions</a></li>
        <li><a href="<?= e(url('sitemap/')) ?>">Sitemap</a></li>
        <?php if (setting('cookie_notice') === '1'): ?><li><button type="button" class="linklike" data-cookie-reset>Cookie settings</button></li><?php endif; ?>
      </ul>
    </div>
  </div>
</footer>
