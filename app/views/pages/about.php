<?php
/** @var array $page /about-us/ */
Seo::set([
    'title' => $page['meta_title'] ?: $page['title'],
    'description' => $page['meta_description'] ?: $page['intro'],
    'canonical' => abs_url('about-us/'),
    'image' => $page['image'],
]);
$stats = json_list(setting('stats'));
$providers = Content::providers();
partial('inner-hero', [
    'title' => $page['title'],
    'eyebrow' => $page['eyebrow'],
    'text' => $page['intro'],
    'crumbs' => [['About Us', 'about-us/']],
    'image' => $page['image'],
    'withArt' => true,
    'artIcon' => 'heart-pulse',
]);
?>
<section class="stats stats--inline" aria-label="Experience">
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
<section class="section">
  <div class="container container--narrow">
    <div class="prose prose--lg" data-reveal><?= Html::clean($page['content']) ?></div>
  </div>
</section>
<section class="section section--soft">
  <div class="container">
    <div class="mv-grid">
      <article class="mv mv--dark" data-reveal>
        <span class="mv__icon"><?= icon('target') ?></span>
        <p class="eyebrow eyebrow--light">Our mission</p>
        <p class="mv__text">To provide comprehensive care combining non-surgical orthopedic intervention, chiropractic care and tailored physiotherapy to relieve pain, restore mobility and improve quality of life.</p>
      </article>
      <article class="mv" data-reveal style="--d:1">
        <span class="mv__icon"><?= icon('sparkles') ?></span>
        <p class="eyebrow">Our vision</p>
        <p class="mv__text">Patients should understand their conditions and take part in their care — rather than simply adapt to acute or chronic pain.</p>
      </article>
    </div>
  </div>
</section>
<?php if ($providers): ?>
<section class="section">
  <div class="container">
    <div class="section-head" data-reveal>
      <div><p class="eyebrow">Our team</p><h2 class="h2">Meet the Team <em>Behind Your Care</em></h2></div>
      <a class="btn btn--outline" href="<?= e(url('our-doctor/')) ?>">Meet Our Providers <?= icon('arrow-right') ?></a>
    </div>
    <div class="pgrid"><?php foreach ($providers as $i => $p): ?><div data-reveal style="--d:<?= $i % 3 ?>"><?php partial('provider-card', ['p' => $p]); ?></div><?php endforeach; ?></div>
  </div>
</section>
<?php endif; ?>
<?php partial('patient-stories'); ?>
<?php partial('cta'); ?>
