<?php
$phone = setting('phone');
$locs = Content::locations();
$byCat = Content::servicesByCategory();
$menuServices = fn($cat) => array_values(array_filter($byCat[$cat] ?? [], fn($s) => (int)$s['show_in_menu'] === 1));
$forms = Content::patientForms();
$formUrl = fn($f) => $f['url'];
$cur = fn($p) => rtrim($path ?? '', '/') === rtrim($p, '/') ? ' aria-current="page"' : '';
$about = [
    ['About All Star Health', 'about-us/', 'Our story, mission and integrated approach', 'heart-pulse'],
    ['Meet Our Providers', 'our-doctor/', 'Physicians, PAs and chiropractors', 'users'],
    ['Testimonials', 'testimonials/', 'Stories from our patients', 'quote'],
];
$contact = [
    ['Contact Us', 'contact-us/', 'Call, text or send a message', 'message-square'],
    ['Locations', 'locations/', 'Gilbert & Tempe offices, hours and maps', 'map-pin'],
];
?>
<div class="utility">
  <div class="container utility__inner">
    <ul class="utility__locs">
      <?php foreach ($locs as $l): ?>
      <li><a href="<?= e(url('locations/#' . $l['slug'])) ?>"><?= icon('map-pin') ?><strong><?= e($l['name']) ?>:</strong> <?= e(Content::fullAddress($l)) ?></a></li>
      <?php endforeach; ?>
    </ul>
    <div class="utility__right">
      <a href="<?= e(tel_href($phone)) ?>"><?= icon('phone') ?>Call: <?= e($phone) ?></a>
      <a class="utility__pill" href="<?= e(url('billing-and-insurance/')) ?>"><?= icon('shield-check') ?>Billing &amp; Insurance</a>
    </div>
  </div>
</div>

<header class="site-header" data-header>
  <div class="container header__inner">
    <a class="brand" href="<?= e(url('')) ?>" aria-label="<?= e(setting('site_name')) ?> — Home">
      <?php partial('logo'); ?>
    </a>

    <nav class="nav" aria-label="Main navigation" data-nav>
      <ul class="nav__list">
        <li class="nav__item has-drop">
          <button class="nav__link" type="button" aria-expanded="false" aria-controls="dd-about">About Us<?= icon('chevron-down', 'icon nav__chev') ?></button>
          <div class="dropdown" id="dd-about">
            <ul class="dropdown__list">
              <?php foreach ($about as [$label, $href, $desc, $ic]): ?>
              <li><a class="dropdown__link" href="<?= e(url($href)) ?>"<?= $cur('/' . $href) ?>><span class="dropdown__icon"><?= icon($ic) ?></span><span><strong><?= e($label) ?></strong><small><?= e($desc) ?></small></span></a></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </li>

        <li class="nav__item has-drop">
          <button class="nav__link" type="button" aria-expanded="false" aria-controls="dd-treatments">Pain Treatments<?= icon('chevron-down', 'icon nav__chev') ?></button>
          <div class="dropdown" id="dd-treatments">
            <ul class="dropdown__list">
              <?php foreach (Content::CATEGORIES as $key => $c): $items = $menuServices($key); if (!$items) continue; ?>
              <li class="dropdown__item has-sub">
                <a class="dropdown__link" href="<?= e(url('pain-treatments/?category=' . $key)) ?>" aria-haspopup="true"><span class="dropdown__icon"><?= icon($c['icon']) ?></span><span><strong><?= e($c['label']) ?></strong><small><?= e(plural(count($items), 'treatment', 'treatments')) ?></small></span><?= icon('chevron-right', 'icon dropdown__chev') ?></a>
                <div class="dropdown__sub">
                  <p class="dropdown__sub-title"><?= e($c['label']) ?></p>
                  <ul>
                    <?php foreach ($items as $sv):
                        $label = preg_replace('/\s*—\s*Coming Soon$/i', '', $sv['menu_label'] ?: $sv['title']); ?>
                    <li><a href="<?= e(Content::serviceUrl($sv)) ?>"<?= $cur('/service/' . $sv['slug'] . '/') ?>><?= e($label) ?><?php if ((int)$sv['coming_soon']): ?> <span class="tag tag--soon">Coming soon</span><?php endif; ?></a></li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              </li>
              <?php endforeach; ?>
            </ul>
            <a class="dropdown__all" href="<?= e(url('pain-treatments/')) ?>">View all treatments <?= icon('arrow-right') ?></a>
          </div>
        </li>

        <li class="nav__item has-drop">
          <button class="nav__link" type="button" aria-expanded="false" aria-controls="dd-patients">Patient Center<?= icon('chevron-down', 'icon nav__chev') ?></button>
          <div class="dropdown dropdown--wide" id="dd-patients">
            <div class="dropdown__cols">
              <ul class="dropdown__list">
                <li><a class="dropdown__link" href="<?= e(url('make-appointment/')) ?>"><span class="dropdown__icon"><?= icon('calendar-check') ?></span><span><strong>New Patient / First Visit</strong><small>Request an appointment and prepare</small></span></a></li>
                <li><a class="dropdown__link" href="<?= e(url('billing-and-insurance/')) ?>"<?= $cur('/billing-and-insurance/') ?>><span class="dropdown__icon"><?= icon('shield-check') ?></span><span><strong>Billing &amp; Insurance</strong><small>Complimentary benefits check</small></span></a></li>
                <li><a class="dropdown__link" href="<?= e(url('your-first-visit/')) ?>"<?= $cur('/your-first-visit/') ?>><span class="dropdown__icon"><?= icon('clipboard') ?></span><span><strong>Your First Visit</strong><small>What to expect and what to bring</small></span></a></li>
              </ul>
              <div class="dropdown__forms">
                <p class="dropdown__heading"><?= icon('file-text') ?>Patient Forms</p>
                <ul>
                  <?php foreach ($forms as $f): ?>
                  <li><a href="<?= e($formUrl($f)) ?>"<?= $f['download'] ? ' target="_blank" rel="noopener"' : '' ?>><?= icon($f['download'] ? 'download' : 'file-text') ?><?= e($f['label']) ?></a></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
          </div>
        </li>

        <li class="nav__item has-drop">
          <button class="nav__link" type="button" aria-expanded="false" aria-controls="dd-contact">Contact<?= icon('chevron-down', 'icon nav__chev') ?></button>
          <div class="dropdown dropdown--right" id="dd-contact">
            <ul class="dropdown__list">
              <?php foreach ($contact as [$label, $href, $desc, $ic]): ?>
              <li><a class="dropdown__link" href="<?= e(url($href)) ?>"<?= $cur('/' . $href) ?>><span class="dropdown__icon"><?= icon($ic) ?></span><span><strong><?= e($label) ?></strong><small><?= e($desc) ?></small></span></a></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </li>
      </ul>
    </nav>

    <div class="header__actions">
      <a class="header__phone" href="<?= e(tel_href($phone)) ?>">
        <span class="header__phone-icon"><?= icon('phone') ?></span>
        <span class="header__phone-text"><small>Call / Text</small><strong><?= e($phone) ?></strong></span>
      </a>
      <a class="btn btn--accent header__cta" href="<?= e(url('make-appointment/')) ?>">Request Appointment</a>
      <button class="menu-toggle" type="button" aria-controls="mobile-nav" aria-expanded="false" data-menu-open>
        <?= icon('menu') ?><span class="sr-only">Open menu</span>
      </button>
    </div>
  </div>
</header>

<?php partial('mobile-nav', ['forms' => $forms, 'formUrl' => $formUrl, 'byCat' => $byCat, 'about' => $about, 'contact' => $contact]); ?>
