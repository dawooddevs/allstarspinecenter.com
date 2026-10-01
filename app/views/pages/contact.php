<?php
/** @var array $page /contact-us/ */
Seo::set([
    'title' => $page['meta_title'] ?: $page['title'],
    'description' => $page['meta_description'] ?: $page['intro'],
    'canonical' => abs_url('contact-us/'),
]);
$phone = setting('phone');
$sms = setting('sms_phone') ?: $phone;
$locs = Content::locations();
$social = array_filter(['facebook' => setting('social_facebook'), 'x-social' => setting('social_x'), 'instagram' => setting('social_instagram')]);
$labels = ['facebook' => 'Facebook', 'x-social' => 'X / Twitter', 'instagram' => 'Instagram'];
partial('inner-hero', [
    'title' => $page['title'],
    'eyebrow' => $page['eyebrow'],
    'text' => $page['intro'],
    'crumbs' => [['Contact Us', 'contact-us/']],
    'showActions' => false,
]);
?>
<section class="section section--tight">
  <div class="container">
    <div class="contact-cards">
      <a class="ccard" href="<?= e(tel_href($phone)) ?>" data-reveal><span class="ccard__icon"><?= icon('phone') ?></span><small>Call us</small><strong><?= e($phone) ?></strong></a>
      <a class="ccard" href="<?= e(sms_href($sms)) ?>" data-reveal style="--d:1"><span class="ccard__icon"><?= icon('message') ?></span><small>Text us</small><strong><?= e($sms) ?></strong></a>
      <div class="ccard" data-reveal style="--d:2"><span class="ccard__icon"><?= icon('printer') ?></span><small>Fax</small>
        <strong class="ccard__multi"><?php foreach ($locs as $l): if (!$l['fax']) continue; ?><span><?= e($l['name']) ?> <?= e($l['fax']) ?></span><?php endforeach; ?></strong>
      </div>
      <?php if (setting('email')): ?>
      <a class="ccard" href="mailto:<?= e(setting('email')) ?>" data-reveal style="--d:3"><span class="ccard__icon"><?= icon('mail') ?></span><small>Email</small><strong><?= e(setting('email')) ?></strong></a>
      <?php endif; ?>
    </div>
  </div>
</section>
<section class="section section--tight" id="form">
  <div class="container appt">
    <div class="card card--form" data-reveal>
      <div class="card__head">
        <span class="card__icon"><?= icon('message-square') ?></span>
        <div><h2 class="h4">Send Us a Message</h2><p>We typically respond within one business day.</p></div>
      </div>
      <?php partial('form', ['type' => 'contact']); ?>
    </div>
    <aside class="appt__side">
      <?php foreach ($locs as $l): ?>
      <div class="sidecard" data-reveal>
        <h2 class="sidecard__h"><?= e($l['name']) ?> Office</h2>
        <p class="sidecard__addr"><?= e($l['address']) ?><br><?= e($l['city'] . ', ' . $l['state'] . ' ' . $l['zip']) ?></p>
        <dl class="lcard__hours lcard__hours--sm">
          <?php foreach (Content::hours($l) as $h): ?><div><dt><?= e($h['days']) ?></dt><dd><?= e($h['time']) ?></dd></div><?php endforeach; ?>
        </dl>
        <a class="sidecard__link" href="<?= e(Content::mapsDirections($l)) ?>" target="_blank" rel="noopener"><?= icon('navigation') ?>Get directions</a>
      </div>
      <?php endforeach; ?>
      <?php if ($social): ?>
      <div class="sidecard" data-reveal>
        <h2 class="sidecard__h">Follow us</h2>
        <ul class="social-row">
          <?php foreach ($social as $k => $href): ?><li><a href="<?= e($href) ?>" target="_blank" rel="noopener"><?= icon($k) ?><?= e($labels[$k]) ?></a></li><?php endforeach; ?>
        </ul>
      </div>
      <?php endif; ?>
    </aside>
  </div>
</section>
<section class="section section--soft section--tight">
  <div class="container">
    <div class="map-grid">
      <?php foreach ($locs as $l): ?>
      <figure class="map-card" data-reveal>
        <iframe title="Map of the <?= e($l['name']) ?> office" src="<?= e(Content::mapEmbed($l)) ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
        <figcaption><strong><?= e($l['name']) ?></strong> · <?= e(Content::fullAddress($l)) ?></figcaption>
      </figure>
      <?php endforeach; ?>
    </div>
  </div>
</section>
