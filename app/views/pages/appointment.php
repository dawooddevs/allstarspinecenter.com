<?php
/** @var array $page /make-appointment/ */
Seo::set([
    'title' => $page['meta_title'] ?: $page['title'],
    'description' => $page['meta_description'] ?: $page['intro'],
    'canonical' => abs_url('make-appointment/'),
]);
$phone = setting('phone');
$sms = setting('sms_phone') ?: $phone;
$firstVisit = Content::page('your-first-visit');
$phases = Content::page('phase-of-relief');
partial('inner-hero', [
    'title' => $page['title'],
    'eyebrow' => $page['eyebrow'],
    'text' => $page['intro'],
    'crumbs' => [['Request an Appointment', 'make-appointment/']],
    'showActions' => false,
]);
?>
<section class="section section--tight" id="form">
  <div class="container appt">
    <div class="appt__form card card--form" data-reveal>
      <div class="card__head">
        <span class="card__icon"><?= icon('calendar-check') ?></span>
        <div>
          <h2 class="h4">Request Your Appointment</h2>
          <p>Takes about a minute. We'll call or text to confirm.</p>
        </div>
      </div>
      <?php partial('form', ['type' => 'appointment']); ?>
      <p class="fine"><?= icon('info') ?><?= e(setting('cta_small_print')) ?></p>
    </div>
    <aside class="appt__side">
      <a class="side-action side-action--accent" href="<?= e(url('billing-and-insurance/#benefits-check')) ?>" data-reveal>
        <span class="side-action__icon"><?= icon('shield-check') ?></span>
        <span><strong>Complimentary Benefits Check</strong><small>We'll verify your insurance before your visit</small></span><?= icon('arrow-right') ?>
      </a>
      <a class="side-action" href="<?= e(tel_href($phone)) ?>" data-reveal>
        <span class="side-action__icon"><?= icon('phone') ?></span>
        <span><strong>Phone Support</strong><small><?= e($phone) ?></small></span><?= icon('arrow-right') ?>
      </a>
      <a class="side-action" href="<?= e(sms_href($sms)) ?>" data-text-us data-reveal>
        <span class="side-action__icon"><?= icon('message') ?></span>
        <span><strong>Text Us</strong><small>Send a text to <?= e($sms) ?></small></span><?= icon('arrow-right') ?>
      </a>
      <div class="sidecard" data-reveal>
        <h2 class="sidecard__h">Locations</h2>
        <ul class="sidecard__locs">
          <?php foreach (Content::locations() as $l): ?>
          <li><a href="<?= e(url('locations/#' . $l['slug'])) ?>"><?= icon('map-pin') ?><span><strong><?= e($l['name']) ?></strong><small><?= e(Content::fullAddress($l)) ?></small></span></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </aside>
  </div>
</section>

<section class="section section--soft" id="patient-guide">
  <div class="container">
    <div class="section-head section-head--center" data-reveal>
      <p class="eyebrow">Patient guide</p>
      <h2 class="h2">Prepare for <em>Your Visit</em></h2>
    </div>
    <div class="guide" data-tabs>
      <div class="tabs tabs--center" role="tablist" aria-label="Patient guide">
        <button class="tab is-active" role="tab" id="tab-visit" aria-controls="panel-visit" aria-selected="true">Your First Visit</button>
        <button class="tab" role="tab" id="tab-phases" aria-controls="panel-phases" aria-selected="false" tabindex="-1">Phase of Relief</button>
        <button class="tab" role="tab" id="tab-forms" aria-controls="panel-forms" aria-selected="false" tabindex="-1">Patient Forms</button>
      </div>
      <div class="guide__panel card" role="tabpanel" id="panel-visit" aria-labelledby="tab-visit">
        <div class="prose"><?= $firstVisit ? Html::clean($firstVisit['content']) : '' ?></div>
      </div>
      <div class="guide__panel card" role="tabpanel" id="panel-phases" aria-labelledby="tab-phases" hidden>
        <div class="prose"><?= $phases ? Html::clean($phases['content']) : '' ?></div>
      </div>
      <div class="guide__panel card" role="tabpanel" id="panel-forms" aria-labelledby="tab-forms" hidden>
        <div id="patient-forms">
          <p>Save time at check-in by downloading and completing your forms before your visit.</p>
          <ul class="doc-grid">
            <?php foreach (Content::patientForms() as $f): ?>
            <li>
              <?php if ($f['available']): ?>
              <a class="doc" href="<?= e($f['url']) ?>" target="_blank" rel="noopener"><span class="doc__icon"><?= icon('file-text') ?></span><span class="doc__label"><?= e($f['label']) ?></span><span class="doc__action"><?= icon('download') ?>Download</span></a>
              <?php else: ?>
              <div class="doc is-pending"><span class="doc__icon"><?= icon('file-text') ?></span><span class="doc__label"><?= e($f['label']) ?></span><span class="doc__action">Available at check-in</span></div>
              <?php endif; ?>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
<?php if (trim(strip_tags((string)$page['content'])) !== ''): ?>
<section class="section section--tight"><div class="container container--narrow prose prose--lg"><?= Html::clean($page['content']) ?></div></section>
<?php endif; ?>
