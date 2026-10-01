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
$featured = Content::servicesBySlugs(csv_list(setting('featured_services')));
$all = Content::services();
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

<!-- 4. Quick patient actions -->
<section class="section section--tight quick" aria-labelledby="quick-title">
  <div class="container">
    <div class="quick__head" data-reveal>
      <h2 id="quick-title" class="h3">Need Help Getting Started?</h2>
      <p>No medical terms needed — just tell us where you are.</p>
    </div>
    <div class="quick__grid">
      <?php foreach ([
          ["I'm In Pain", 'Explore Treatments', 'pain-treatments/', 'heart-pulse'],
          ['I Was Injured', 'Accident & Injury Care', 'pain-treatments/?category=injury', 'car'],
          ['Check My Insurance', 'Complimentary Benefits Check', 'billing-and-insurance/#benefits-check', 'shield-check'],
          ["I'm Ready", 'Request Appointment', 'make-appointment/', 'calendar-check'],
      ] as $i => [$t, $sub, $href, $ic]): ?>
      <a class="quick__card<?= $i === 3 ? ' quick__card--primary' : '' ?>" href="<?= e(url($href)) ?>" data-reveal style="--d:<?= $i ?>">
        <span class="quick__icon"><?= icon($ic) ?></span>
        <span class="quick__text"><strong><?= e($t) ?></strong><small><?= e($sub) ?></small></span>
        <span class="quick__arrow"><?= icon('arrow-right') ?></span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- 5. About / integrated care -->
<section class="section about-home" aria-labelledby="about-title">
  <div class="container split">
    <div class="split__media" data-reveal="mask">
      <?php if (setting('about_image')): ?>
        <div class="about-home__photo"><?= img(setting('about_image'), 'The All Star Health care team') ?></div>
      <?php else: ?>
      <div class="disciplines">
        <?php foreach ([
            ['Medical Providers', 'Physicians & physician assistants', 'stethoscope'],
            ['Chiropractors', 'Spinal & joint care', 'spine'],
            ['Rehabilitation', 'Soft tissue & movement', 'move'],
            ['Allergy & Family Care', 'Testing & immunotherapy', 'flower'],
        ] as $i => [$t, $s, $ic]): ?>
        <div class="discipline discipline--<?= $i ?>"><span class="discipline__icon"><?= icon($ic) ?></span><strong><?= e($t) ?></strong><small><?= e($s) ?></small></div>
        <?php endforeach; ?>
        <div class="disciplines__center"><span><?= icon('heart-pulse') ?></span><strong>One team.<br>One plan.</strong></div>
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

<!-- 6. Experience statistics -->
<section class="stats" aria-label="Experience">
  <div class="container">
    <div class="stats__grid">
      <?php foreach ($stats as $i => $s): ?>
      <div class="stat" data-reveal style="--d:<?= $i ?>">
        <p class="stat__num"><span data-count="<?= (int)$s['value'] ?>"><?= (int)$s['value'] ?></span><?= e($s['suffix'] ?? '') ?></p>
        <p class="stat__label"><?= e($s['label']) ?></p>
      </div>
      <?php endforeach; ?>
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
    <div class="tabs" role="tablist" aria-label="Treatment categories" data-explorer-tabs>
      <button class="tab is-active" role="tab" aria-selected="true" data-filter="featured">Featured</button>
      <?php foreach (Content::CATEGORIES as $k => $c): ?>
      <button class="tab" role="tab" aria-selected="false" data-filter="<?= e($k) ?>"><?= e($c['short'] === 'Medical' ? 'Medical Treatments' : $c['short']) ?></button>
      <?php endforeach; ?>
    </div>
    <div class="tgrid" data-explorer-grid>
      <?php
      $featuredSlugs = array_column($featured, 'slug');
      foreach ($featured as $s) {
          partial('service-card', ['s' => $s, 'class' => 'is-featured']);
      }
      foreach ($all as $s) {
          if (!in_array($s['slug'], $featuredSlugs, true)) {
              partial('service-card', ['s' => $s, 'class' => 'is-extra']);
          }
      }
      ?>
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
    <div class="pgrid">
      <?php foreach ($providers as $i => $p): ?>
      <div data-reveal style="--d:<?= $i % 3 ?>"><?php partial('provider-card', ['p' => $p]); ?></div>
      <?php endforeach; ?>
    </div>
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
  <div class="container">
    <div class="section-head" data-reveal>
      <div>
        <p class="eyebrow">Patient stories</p>
        <h2 id="t-title" class="h2">What Our <em>Patients Say</em></h2>
      </div>
      <a class="btn btn--outline" href="<?= e(url('testimonials/')) ?>">Read Patient Stories <?= icon('arrow-right') ?></a>
    </div>
    <div data-reveal><?php partial('testimonials', ['items' => $testimonials]); ?></div>
  </div>
</section>
<?php endif; ?>

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
