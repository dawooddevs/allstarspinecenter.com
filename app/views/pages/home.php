<?php
Seo::set([
    'title' => setting('site_name') . ' | Non-Surgical Spine, Joint & Pain Care in Gilbert & Tempe, AZ',
    'description' => setting('seo_default_description'),
    'canonical' => abs_url(''),
]);
$phone = setting('phone');
$heroImage = setting('hero_image');
$badges = lines(setting('hero_badges'));
$stats = json_list(setting('stats'));
$providers = Content::providers();
$locations = Content::locations();
$testimonials = Content::testimonials(true);
$faqs = Content::faqs('home');
$communities = csv_list(setting('communities'));
$svc = fn($slug) => url('service/' . $slug . '/');
?>

<!-- 3. Hero -->
<section class="hero">
  <div class="hero__bg" aria-hidden="true">
    <span class="hero__blob hero__blob--1"></span>
    <span class="hero__blob hero__blob--2"></span>
    <span class="hero__blob hero__blob--3"></span>
    <span class="hero__grid"></span>
  </div>
  <div class="container hero__inner">
    <div class="hero__content">
      <p class="eyebrow hero__eyebrow" data-hero-in style="--d:0"><span class="pulse-dot"></span><?= e(setting('tagline')) ?></p>
      <h1 class="hero__title">
        <span class="hero__line"><span data-hero-in style="--d:1"><?= e(setting('hero_line1')) ?></span></span>
        <span class="hero__line hero__line--accent"><span data-hero-in style="--d:2"><?= e(setting('hero_line2')) ?></span></span>
      </h1>
      <p class="hero__copy" data-hero-in style="--d:3"><?= e(setting('hero_copy')) ?></p>
      <div class="btn-row" data-hero-in style="--d:4">
        <a class="btn btn--accent btn--lg" href="<?= e(url('make-appointment/')) ?>">Request An Appointment <?= icon('arrow-right') ?></a>
        <a class="btn btn--outline btn--lg" href="<?= e(url('pain-treatments/')) ?>">Explore Treatments</a>
      </div>
      <a class="hero__call" href="<?= e(tel_href($phone)) ?>" data-hero-in style="--d:5"><span class="hero__call-icon"><?= icon('phone') ?></span><span>Or call <strong><?= e($phone) ?></strong></span></a>
      <ul class="hero__badges" data-hero-in style="--d:6">
        <?php foreach ($badges as $b): ?><li><?= icon('check-circle') ?><?= e($b) ?></li><?php endforeach; ?>
      </ul>
    </div>
    <div class="hero__visual" data-hero-in style="--d:2">
      <div class="hero__panel<?= $heroImage ? ' hero__panel--photo' : '' ?>">
        <?php if ($heroImage): ?>
          <?= img($heroImage, 'Patient care at ' . setting('site_short_name'), ['loading' => 'eager', 'fetchpriority' => 'high', 'class' => 'hero__img']) ?>
        <?php else: ?>
          <div class="hero__rings" aria-hidden="true"><span></span><span></span><span></span></div>
          <?php partial('spine'); ?>
        <?php endif; ?>
      </div>
      <a class="float-chip float-chip--1" href="<?= e($svc('regenerative-medicine')) ?>"><span><?= icon('flask') ?></span>Regenerative Medicine</a>
      <a class="float-chip float-chip--2" href="<?= e($svc('chiropractic-therapy')) ?>"><span><?= icon('spine') ?></span>Chiropractic Care</a>
      <a class="float-chip float-chip--3" href="<?= e($svc('shockwave-therapy')) ?>"><span><?= icon('radio') ?></span>Shockwave Therapy</a>
      <a class="float-chip float-chip--4" href="<?= e($svc('spinal-decompression-therapy')) ?>"><span><?= icon('move') ?></span>Spinal Decompression</a>
      <div class="hero__card">
        <span class="hero__card-icon"><?= icon('calendar-check') ?></span>
        <span><strong>Same-day appointments</strong><small>Gilbert &amp; Tempe · when available</small></span>
      </div>
    </div>
  </div>
</section>

<!-- 5. About / integrated care -->
<section class="section about-home" aria-labelledby="about-title">
  <div class="container split">
    <div class="split__media about-home__media">
      <div class="about-home__photo" data-reveal="mask">
        <?php if (setting('about_image')): ?>
        <?= img(setting('about_image'), 'The All Star Health care team') ?>
        <?php else: ?>
        <?php partial('art', ['icon' => 'heart-pulse', 'variant' => 'medical', 'label' => 'Integrated care', 'large' => true]); ?>
        <?php endif; ?>
      </div>
      <?php if ($stats): ?>
      <div class="about-stats" aria-label="Experience">
        <?php foreach ($stats as $i => $st): ?>
        <div class="about-stat about-stat--<?= $i % 3 ?>" data-reveal style="--d:<?= $i ?>">
          <p class="about-stat__num"><span data-count="<?= (int)$st['value'] ?>"><?= (int)$st['value'] ?></span><?= e($st['suffix'] ?? '') ?></p>
          <p class="about-stat__label"><?= e($st['label']) ?></p>
        </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
    <div class="split__content" data-reveal>
      <p class="eyebrow">Integrated care</p>
      <h2 id="about-title" class="h2">Not Just Better Healthcare. <em>A Better Healthcare Experience.</em></h2>
      <p class="lead">Pain symptoms may be common, but the cause is different for every person.</p>
      <p>That's why our team evaluates the whole patient — then provides integrated, non-surgical care focused on pain relief, mobility, function and education. Medical providers, chiropractors and rehabilitation professionals work together under one roof, so your plan is built around you.</p>
      <ul class="pill-list" aria-label="Communities we serve">
        <?php foreach ($communities as $c): ?><li><?= icon('map-pin') ?><?= e($c) ?></li><?php endforeach; ?>
        <li>+ surrounding Arizona communities</li>
      </ul>
      <a class="btn btn--dark" href="<?= e(url('about-us/')) ?>">About All Star Health <?= icon('arrow-right') ?></a>
    </div>
  </div>
</section>

<!-- 7. Treatment explorer -->
<section class="section explorer" aria-labelledby="explorer-title">
  <div class="container">
    <div class="section-head" data-reveal>
      <div>
        <p class="eyebrow">Treatment explorer</p>
        <h2 id="explorer-title" class="h2">Care Built Around <em>the Cause of Your Pain</em></h2>
      </div>
      <a class="btn btn--outline" href="<?= e(url('pain-treatments/')) ?>">Explore All Treatments <?= icon('arrow-right') ?></a>
    </div>
    <div class="tabs" role="tablist" aria-label="Treatment categories" data-explorer-tabs data-api="<?= e(url('api/treatments')) ?>" data-all="<?= e(url('pain-treatments/')) ?>">
      <button class="tab is-active" role="tab" aria-selected="true" data-filter="featured">Featured</button>
      <?php foreach (Content::CATEGORIES as $k => $c): ?>
      <button class="tab" role="tab" aria-selected="false" data-filter="<?= e($k) ?>"><?= e($c['short'] === 'Medical' ? 'Medical Treatments' : $c['short']) ?></button>
      <?php endforeach; ?>
    </div>
    <?php $exItems = Content::explorerServices('featured'); ?>
    <div class="tgrid" data-explorer-grid data-total="<?= count($exItems) ?>" aria-live="polite">
      <?php foreach (array_slice($exItems, 0, 3) as $s) partial('service-card', ['s' => $s]); ?>
    </div>
    <div class="explorer__more"<?= count($exItems) > 3 ? '' : ' hidden' ?> data-explorer-more-wrap>
      <a class="btn btn--outline btn--lg" href="<?= e(url('pain-treatments/')) ?>" data-explorer-more data-next="3">Show More <?= icon('chevron-down') ?></a>
    </div>
  </div>
</section>

<!-- 8. Where does it hurt? -->
<section class="section section--soft hurt" aria-labelledby="hurt-title">
  <div class="container">
    <div class="section-head section-head--center" data-reveal>
      <p class="eyebrow">Where does it hurt?</p>
      <h2 id="hurt-title" class="h2">Start With <em>Where You Feel It</em></h2>
      <p class="section-head__text">Choose an area to see treatments our team may recommend after an evaluation.</p>
    </div>
    <div data-reveal><?php partial('bodymap'); ?></div>
  </div>
</section>

<!-- 9. Why choose -->
<section class="section why" aria-labelledby="why-title">
  <div class="container">
    <div class="section-head" data-reveal>
      <div>
        <p class="eyebrow">Why All Star Health</p>
        <h2 id="why-title" class="h2">Why Patients Choose <em>All Star Health</em></h2>
      </div>
    </div>
    <div class="why__grid">
      <?php foreach ([
          ['Same-Day Appointments', "Patients in pain shouldn't wait. Same-day service and walk-ins are welcome when possible.", 'clock'],
          ['Affordable & Insurance-Friendly', 'Most major commercial plans and Medicare accepted, with insurance verification offered.', 'shield-check'],
          ['Integrated Care', 'Medical providers and chiropractors work together under one roof.', 'users'],
          ['Fast, Patient-Focused Relief', "Treatment based on each patient's needs and goals — not a generic long-term program.", 'target'],
      ] as $i => [$t, $d, $ic]): ?>
      <article class="why__card why__card--<?= $i ?>" data-reveal style="--d:<?= $i ?>">
        <span class="why__icon"><?= icon($ic) ?></span>
        <h3><?= e($t) ?></h3>
        <p><?= e($d) ?></p>
        <span class="why__num" aria-hidden="true">0<?= $i + 1 ?></span>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- 10. Insurance / benefits check -->
<section class="section section--flush insurance" aria-labelledby="ins-title">
  <div class="container">
    <div class="insurance__panel" data-reveal>
      <div class="insurance__content">
        <p class="eyebrow eyebrow--light">Insurance &amp; benefits</p>
        <h2 id="ins-title" class="h2">Not Sure What Your Insurance Covers?</h2>
        <p class="insurance__sub">Start With a Complimentary Benefits Check</p>
        <ul class="check-list check-list--light">
          <li><?= icon('check') ?>Verify your coverage</li>
          <li><?= icon('check') ?>Explain applicable benefits</li>
          <li><?= icon('check') ?>Help you understand care options</li>
          <li><?= icon('check') ?>Most major plans accepted</li>
          <li><?= icon('check') ?>Medicare accepted</li>
          <li><?= icon('check') ?>Discuss payment options</li>
        </ul>
      </div>
      <div class="insurance__card">
        <span class="insurance__badge"><?= icon('shield-check') ?></span>
        <h3>Complimentary Benefits Check</h3>
        <p>Our insurance team will review your plan before your visit — no cost, no obligation.</p>
        <a class="btn btn--accent btn--block btn--lg" href="<?= e(url('billing-and-insurance/#benefits-check')) ?>">Check My Benefits <?= icon('arrow-right') ?></a>
        <a class="btn btn--outline btn--block" href="<?= e(url('billing-and-insurance/')) ?>">Billing &amp; Insurance</a>
        <p class="insurance__fine">Coverage varies by plan. Benefits are confirmed by our team before treatment.</p>
      </div>
    </div>
  </div>
</section>

<!-- 11. How treatment works -->
<section class="section steps" aria-labelledby="steps-title">
  <div class="container">
    <div class="section-head section-head--center" data-reveal>
      <p class="eyebrow">How it works</p>
      <h2 id="steps-title" class="h2">Your Path to <em>Feeling Better</em></h2>
    </div>
    <ol class="steps__list" data-steps>
      <li class="steps__line" aria-hidden="true"><span data-steps-fill></span></li>
      <?php foreach ([
          ['Complimentary Benefits Check', 'Our insurance team verifies your benefits before your visit.', 'shield-check'],
          ['Your First Visit', 'Patient information, health history and a thorough evaluation.', 'clipboard'],
          ['Personalized Care', 'Treatment built around your condition, symptoms and goals.', 'heart-pulse'],
          ['Ongoing Support', 'Rehab, exercises, stretches, lifestyle guidance or maintenance care where appropriate.', 'route'],
      ] as $i => [$t, $d, $ic]): ?>
      <li class="step" data-reveal style="--d:<?= $i ?>">
        <span class="step__num"><?= icon($ic) ?><em><?= $i + 1 ?></em></span>
        <h3><?= e($t) ?></h3>
        <p><?= e($d) ?></p>
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>

<!-- 12. Accident & injury care -->
<section class="section section--soft injury" aria-labelledby="injury-title">
  <div class="container injury__inner">
    <div class="injury__content" data-reveal>
      <p class="eyebrow">Accident &amp; injury care</p>
      <h2 id="injury-title" class="h2">Hurt in an <em>Accident?</em></h2>
      <p class="lead">Get evaluated promptly and start a coordinated recovery plan with our medical and chiropractic team.</p>
      <div class="btn-row">
        <a class="btn btn--dark" href="<?= e(url('pain-treatments/?category=injury')) ?>">Explore Injury Care <?= icon('arrow-right') ?></a>
        <a class="btn btn--accent" href="<?= e(url('make-appointment/')) ?>">Request Appointment</a>
      </div>
    </div>
    <div class="injury__cards">
      <?php foreach ([
          ['Car Accident', 'Treatment after an automobile injury.', 'car-accident-injury-treatment', 'car'],
          ['Work Injury', 'Evaluation and care for work-related injuries.', 'work-injury-compensation', 'briefcase'],
          ['Sports Injury', 'Recovery, function and return to activity.', 'sports-injuries-and-physical-fitness', 'dumbbell'],
      ] as $i => [$t, $d, $slug, $ic]): ?>
      <a class="icard" href="<?= e($svc($slug)) ?>" data-reveal style="--d:<?= $i ?>">
        <span class="icard__icon"><?= icon($ic) ?></span>
        <span class="icard__text"><strong><?= e($t) ?></strong><small><?= e($d) ?></small></span>
        <span class="icard__arrow"><?= icon('arrow-up-right') ?></span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- 13. Provider team -->
<?php if ($providers): ?>
<section class="section providers-home" aria-labelledby="team-title">
  <div class="container">
    <div class="section-head" data-reveal>
      <div>
        <p class="eyebrow">Our providers</p>
        <h2 id="team-title" class="h2">Meet the Team <em>Behind Your Care</em></h2>
      </div>
      <a class="btn btn--outline" href="<?= e(url('our-doctor/')) ?>">Meet Our Providers <?= icon('arrow-right') ?></a>
    </div>
    <div class="pgrid" data-more-group>
      <?php foreach ($providers as $i => $p): ?>
      <div<?= $i < 3 ? ' data-reveal style="--d:' . $i . '"' : ' class="is-more" hidden' ?>><?php partial('provider-card', ['p' => $p]); ?></div>
      <?php endforeach; ?>
    </div>
    <?php if (count($providers) > 3): ?>
    <div class="explorer__more" data-more-wrap>
      <a class="btn btn--outline btn--lg" href="<?= e(url('our-doctor/')) ?>" data-more-btn>Show More <?= icon('chevron-down') ?></a>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<!-- 14. Locations -->
<section class="section section--soft" aria-labelledby="loc-title">
  <div class="container">
    <div class="section-head" data-reveal>
      <div>
        <p class="eyebrow">Locations</p>
        <h2 id="loc-title" class="h2">Two Convenient <em>Arizona Offices</em></h2>
      </div>
      <a class="btn btn--outline" href="<?= e(url('locations/')) ?>">All Location Details <?= icon('arrow-right') ?></a>
    </div>
    <div class="lgrid">
      <?php foreach ($locations as $i => $l): ?>
      <div data-reveal style="--d:<?= $i ?>"><?php partial('location-card', ['l' => $l]); ?></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- 15. Testimonials -->
<?php if ($testimonials): ?>
<section class="section testimonials" aria-labelledby="t-title">
  <div class="container tshow">
    <div class="tshow__media" data-reveal>
      <div class="tshow__photo">
        <?php if (setting('testimonials_image')): ?>
        <?= img(setting('testimonials_image'), 'A patient with an All Star Health provider') ?>
        <?php else: ?>
        <?php partial('art', ['icon' => 'heart-pulse', 'variant' => 'soft-tissue', 'label' => 'Patient stories', 'large' => true]); ?>
        <?php endif; ?>
      </div>
      <?php if ($first = $stats[0] ?? null): ?>
      <div class="tshow__badge">
        <p class="tshow__badge-num"><span data-count="<?= (int)$first['value'] ?>"><?= (int)$first['value'] ?></span><sup><?= e($first['suffix'] ?? '') ?></sup></p>
        <p class="tshow__badge-label"><?= e($first['label']) ?></p>
      </div>
      <?php endif; ?>
      <span class="tshow__quote-mark" aria-hidden="true"><?= icon('quote') ?></span>
    </div>
    <div class="tshow__content" data-reveal style="--d:1">
      <p class="eyebrow">Patient testimonials</p>
      <h2 id="t-title" class="h2">Patient Satisfaction Is <em>Our Working Motivation</em></h2>
      <div class="tshow__stars" aria-hidden="true"><?= str_repeat(icon('star'), 5) ?></div>
      <?php if ($testimonials): ?>
      <div class="tshow__card" data-tshow aria-roledescription="carousel" aria-label="Patient testimonials">
        <div class="tshow__slides" aria-live="polite">
          <?php foreach ($testimonials as $i => $t): ?>
          <figure class="tshow__slide<?= $i === 0 ? ' is-active' : '' ?>" role="group" aria-roledescription="slide" aria-label="<?= $i + 1 ?> of <?= count($testimonials) ?>"<?= $i === 0 ? '' : ' hidden' ?>>
            <blockquote class="tshow__text"><p>“<?= e(preg_replace('/^[\s"“”]+|[\s"“”]+$/u', '', (string)$t['content'])) ?>”</p></blockquote>
            <figcaption class="tshow__by"><?= e(mb_strtoupper($t['name'])) ?><?php if ($t['label'] && $t['label'] !== 'Patient'): ?><small><?= e($t['label']) ?></small><?php endif; ?></figcaption>
          </figure>
          <?php endforeach; ?>
        </div>
        <div class="tshow__nav">
          <span class="tshow__count"><span data-tshow-current>1</span> / <?= count($testimonials) ?></span>
          <button type="button" class="tshow__btn" data-tshow-prev aria-label="Previous testimonial"><?= icon('arrow-left') ?></button>
          <button type="button" class="tshow__btn" data-tshow-next aria-label="Next testimonial"><?= icon('arrow-right') ?></button>
        </div>
      </div>
      <?php endif; ?>
      <a class="tshow__all" href="<?= e(url('testimonials/')) ?>">Read all patient stories <?= icon('arrow-right') ?></a>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- 15b. Book a visit (contact details + appointment form) -->
<section class="section book" id="book" aria-labelledby="book-title">
  <div class="book__glow" aria-hidden="true"></div>
  <div class="container book__grid">
    <div class="book__info" data-reveal>
      <p class="eyebrow eyebrow--light">Book your visit</p>
      <h2 id="book-title" class="h2 book__title">Choose a Preferred Time. <em>We'll Confirm It With You.</em></h2>
      <p class="book__lead">Requests are held for 48 hours until confirmed by our office.</p>
      <?php $sms = setting('sms_phone') ?: $phone; $email = setting('email'); $hoursRows = Content::hoursTable($locations); ?>
      <div class="book__panels">
        <div class="book__panel">
          <p class="book__panel-title"><?= icon('message-square') ?>Get in touch</p>
          <a class="book__row" href="<?= e(tel_href($phone)) ?>"><span class="book__row-icon"><?= icon('phone') ?></span><span class="book__row-text"><small>Call us</small><strong><?= e($phone) ?></strong></span><?= icon('arrow-right', 'icon book__row-arrow') ?></a>
          <a class="book__row" href="<?= e(sms_href($sms)) ?>"><span class="book__row-icon"><?= icon('message') ?></span><span class="book__row-text"><small>Text us 24/7</small><strong><?= e($sms) ?></strong></span><?= icon('arrow-right', 'icon book__row-arrow') ?></a>
          <?php if ($email): ?>
          <a class="book__row" href="mailto:<?= e($email) ?>"><span class="book__row-icon"><?= icon('mail') ?></span><span class="book__row-text"><small>Email</small><strong><?= str_replace(['@', '-'], ['<wbr>@', '&#8209;'], e($email)) ?></strong></span><?= icon('arrow-right', 'icon book__row-arrow') ?></a>
          <?php endif; ?>
        </div>
        <div class="book__panel">
          <p class="book__panel-title"><?= icon('map-pin') ?>Our offices</p>
          <div class="book__offices">
            <?php foreach ($locations as $l): ?>
            <a class="book__office" href="<?= e(Content::mapsDirections($l)) ?>" target="_blank" rel="noopener">
              <span class="book__office-head"><span class="book__row-icon"><?= icon('building') ?></span><span class="book__office-name"><?= e($l['name']) ?></span></span>
              <span class="book__office-addr"><?= e($l['address']) ?></span>
              <span class="book__office-city"><?= e($l['city'] . ', ' . $l['state'] . ' ' . $l['zip']) ?></span>
              <span class="book__office-link">Get directions <?= icon('arrow-up-right') ?></span>
            </a>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <div class="book__panel book__panel--hours">
        <p class="book__panel-title"><?= icon('clock') ?>Office hours</p>
        <?php if ($hoursRows): ?>
        <table class="book__table">
          <thead><tr><th scope="col"><span class="sr-only">Days</span></th><?php foreach ($locations as $l): ?><th scope="col"><?= e($l['name']) ?></th><?php endforeach; ?></tr></thead>
          <tbody>
            <?php foreach ($hoursRows as $r): ?>
            <tr data-iso-days="<?= e(implode(',', $r['iso'])) ?>">
              <th scope="row"><?= e($r['days']) ?><span class="book__today">Today</span></th>
              <?php foreach ($locations as $l): $t = $r['times'][$l['slug']] ?? null; ?>
              <td<?= $t ? '' : ' class="is-closed"' ?>><?= e($t ?? 'Closed') ?></td>
              <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <?php else: ?>
        <div class="book__hours-list">
          <?php foreach ($locations as $l): ?>
          <dl><dt><?= e($l['name']) ?></dt><?php foreach (Content::hours($l) as $h): ?><dd><span><?= e($h['days']) ?></span><span><?= e($h['time']) ?></span></dd><?php endforeach; ?></dl>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>
      <h3 class="book__subhead">Benefits of scheduling an appointment</h3>
      <ul class="book__benefits">
        <?php foreach (['We analyze the problems you are facing', 'Complimentary benefits check', 'Flexible scheduling', 'Appointments without extended waiting', 'Text support at any time', 'Choose providers you trust'] as $b): ?>
        <li><span class="book__benefit-icon"><?= icon('check') ?></span><?= e($b) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="book__form" data-reveal style="--d:1">
      <div class="book__form-head">
        <span class="book__form-icon"><?= icon('calendar-check') ?></span>
        <?php $ghl = trim((string)setting('ghl_appointment_embed')) !== ''; ?>
        <div>
          <h3><?= $ghl ? 'Book your appointment' : 'Enter your details' ?></h3>
          <p><?= $ghl ? 'Pick a date and time, then add your details. We\'ll confirm by phone or text.' : 'Takes about a minute. We\'ll call or text to confirm.' ?></p>
        </div>
      </div>
      <?php partial('form', ['type' => 'appointment']); ?>
    </div>
  </div>
</section>

<!-- 16. FAQ -->
<?php if ($faqs): ?>
<section class="section faq-section" aria-labelledby="faq-title">
  <div class="container faq-layout">
    <div class="faq-layout__intro" data-reveal>
      <p class="eyebrow">FAQ</p>
      <h2 id="faq-title" class="h2">Questions? <em>We're Here to Help.</em></h2>
      <p>Can't find what you're looking for? Our team is happy to help.</p>
      <div class="btn-row">
        <a class="btn btn--dark" href="<?= e(tel_href($phone)) ?>"><?= icon('phone') ?>Call <?= e($phone) ?></a>
        <a class="btn btn--outline" href="<?= e(sms_href(setting('sms_phone') ?: $phone)) ?>"><?= icon('message') ?>Text Our Team</a>
      </div>
    </div>
    <div data-reveal><?php partial('faq', ['faqs' => $faqs, 'id' => 'home-faq']); ?></div>
  </div>
</section>
<?php endif; ?>

<!-- 17. Appointment CTA -->
<?php partial('cta'); ?>
