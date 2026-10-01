<?php
/** @var array $page /billing-and-insurance/ */
Seo::set([
    'title' => $page['meta_title'] ?: $page['title'],
    'description' => $page['meta_description'] ?: $page['intro'],
    'canonical' => abs_url('billing-and-insurance/'),
]);
$faqs = Content::faqs('billing');
partial('inner-hero', [
    'title' => $page['title'],
    'eyebrow' => $page['eyebrow'],
    'text' => $page['intro'],
    'crumbs' => [['Billing & Insurance', 'billing-and-insurance/']],
    'showActions' => false,
    'image' => $page['image'],
]);
?>
<section class="section section--tight">
  <div class="container">
    <div class="feature-grid">
      <?php foreach ([
          ['Complimentary Benefits Check', 'We review your plan before your visit at no cost.', 'shield-check'],
          ['Insurance Verification', 'Our team confirms coverage and explains applicable benefits.', 'clipboard'],
          ['Most Major Plans Accepted', 'We work with most major commercial insurance plans.', 'credit-card'],
          ['Medicare Accepted', 'Medicare patients are welcome at both offices.', 'check-circle'],
          ['Flexible Payment Options', 'Flexible payment options may be available.', 'heart'],
          ['Same-Day Appointments', 'Available when the schedule allows — including walk-ins.', 'clock'],
          ['Personalized Treatment Planning', 'Care plans built around your needs and goals.', 'target'],
      ] as $i => [$t, $d, $ic]): ?>
      <div class="feature" data-reveal style="--d:<?= $i % 4 ?>"><span class="feature__icon"><?= icon($ic) ?></span><h3><?= e($t) ?></h3><p><?= e($d) ?></p></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<section class="section section--soft" id="benefits-check">
  <div class="container appt">
    <div class="appt__intro" data-reveal>
      <p class="eyebrow">Complimentary benefits check</p>
      <h2 class="h2">Check Your <em>Benefits</em></h2>
      <div class="prose"><?= Html::clean($page['content']) ?></div>
      <ul class="check-list">
        <li><?= icon('check') ?>No cost, no obligation</li>
        <li><?= icon('check') ?>We'll explain what may be covered</li>
        <li><?= icon('check') ?>Coverage is confirmed before treatment</li>
      </ul>
    </div>
    <div class="card card--form" data-reveal>
      <div class="card__head">
        <span class="card__icon"><?= icon('shield-check') ?></span>
        <div><h3 class="h4">Request a Benefits Check</h3><p>Our insurance team will reach out to review your plan.</p></div>
      </div>
      <?php partial('form', ['type' => 'benefits']); ?>
    </div>
  </div>
</section>
<?php if ($faqs): ?>
<section class="section">
  <div class="container faq-layout">
    <div class="faq-layout__intro" data-reveal>
      <p class="eyebrow">FAQ</p>
      <h2 class="h2">Billing &amp; Insurance <em>Questions</em></h2>
      <p>Have a question about your plan? Call <a href="<?= e(tel_href(setting('phone'))) ?>"><?= e(setting('phone')) ?></a>.</p>
    </div>
    <div data-reveal><?php partial('faq', ['faqs' => $faqs, 'id' => 'billing-faq']); ?></div>
  </div>
</section>
<?php endif; ?>
<?php partial('cta'); ?>
