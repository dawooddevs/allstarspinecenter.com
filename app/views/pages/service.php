<?php
/** @var array $service */
$s = $service;
$cat = Content::CATEGORIES[$s['category']] ?? ['label' => 'Treatments', 'short' => '', 'icon' => 'activity'];
$title = preg_replace('/\s*—\s*Coming Soon$/i', '', $s['title']);
$conditions = lines($s['conditions']);
$benefits = lines($s['benefits']);
$faqs = json_list($s['faqs']);
$related = Content::related($s, 4);
$phone = setting('phone');
$providers = array_values(array_filter(Content::providers(), fn($p) => in_array($s['slug'], csv_list($p['services']), true)));

Seo::set([
    'title' => $s['meta_title'] ?: $title,
    'description' => $s['meta_description'] ?: $s['excerpt'],
    'canonical' => abs_url('service/' . $s['slug'] . '/'),
    'image' => $s['image'],
]);
Seo::addSchema([
    '@context' => 'https://schema.org',
    '@type' => 'MedicalWebPage',
    'name' => $title,
    'url' => abs_url('service/' . $s['slug'] . '/'),
    'description' => strip_tags((string)$s['excerpt']),
    'about' => ['@type' => 'MedicalTherapy', 'name' => $title],
    'publisher' => ['@id' => abs_url('') . '#organization'],
]);

$sections = [];
if (trim(strip_tags((string)$s['what_is'])) !== '') $sections['what-is'] = 'What Is ' . $title . '?';
if ($conditions) $sections['helps-with'] = 'What Can It Help With?';
if (trim(strip_tags((string)$s['how_it_works'])) !== '') $sections['how-it-works'] = 'How It Works';
if ($benefits) $sections['benefits'] = 'Benefits & Goals';
if (trim(strip_tags((string)$s['what_to_expect'])) !== '') $sections['what-to-expect'] = 'What to Expect';
if ($faqs) $sections['faq'] = 'Frequently Asked Questions';

partial('inner-hero', [
    'title' => $title,
    'eyebrow' => $cat['label'],
    'text' => $s['hero_text'] ?: $s['excerpt'],
    'crumbs' => [['Pain Treatments', 'pain-treatments/'], [$title, 'service/' . $s['slug'] . '/']],
    'image' => $s['image'],
    'withArt' => true,
    'artIcon' => Content::serviceIcon($s),
    'artVariant' => $s['category'],
    'badge' => (int)$s['coming_soon'] ? '<span class="tag tag--soon">Coming soon</span>' : '',
]);
?>
<section class="section section--article">
  <div class="container article-layout">
    <article class="article">
      <?php if (count($sections) > 2): ?>
      <nav class="toc" aria-label="On this page">
        <?php foreach ($sections as $id => $label): ?><a href="#<?= e($id) ?>"><?= e($label) ?></a><?php endforeach; ?>
      </nav>
      <?php endif; ?>

      <?php if (isset($sections['what-is'])): ?>
      <section id="what-is" class="article__section" data-reveal>
        <h2><?= e($sections['what-is']) ?></h2>
        <div class="prose"><?= Html::clean($s['what_is']) ?></div>
      </section>
      <?php endif; ?>

      <?php if ($conditions): ?>
      <section id="helps-with" class="article__section" data-reveal>
        <h2>What Can It Help With?</h2>
        <ul class="cond-grid">
          <?php foreach ($conditions as $c): ?><li><?= icon('check-circle') ?><?= e($c) ?></li><?php endforeach; ?>
        </ul>
      </section>
      <?php endif; ?>

      <?php if (isset($sections['how-it-works'])): ?>
      <section id="how-it-works" class="article__section" data-reveal>
        <h2>How It Works</h2>
        <div class="prose"><?= Html::clean($s['how_it_works']) ?></div>
      </section>
      <?php endif; ?>

      <?php if ($benefits): ?>
      <section id="benefits" class="article__section" data-reveal>
        <h2>Benefits &amp; Goals</h2>
        <ul class="benefit-grid">
          <?php foreach ($benefits as $i => $b): ?>
          <li><span class="benefit-grid__icon"><?= icon(['sparkles', 'activity', 'target', 'heart-pulse', 'check-circle', 'shield-check'][$i % 6]) ?></span><?= e($b) ?></li>
          <?php endforeach; ?>
        </ul>
        <p class="disclaimer"><?= icon('info') ?>Results vary from person to person. Eligibility is determined after evaluation.</p>
      </section>
      <?php endif; ?>

      <?php if (isset($sections['what-to-expect'])): ?>
      <section id="what-to-expect" class="article__section" data-reveal>
        <h2>What to Expect</h2>
        <div class="expect">
          <span class="expect__icon"><?= icon('clipboard') ?></span>
          <div class="prose"><?= Html::clean($s['what_to_expect']) ?></div>
        </div>
      </section>
      <?php endif; ?>

      <?php if ($faqs): ?>
      <section id="faq" class="article__section" data-reveal>
        <h2>Frequently Asked Questions</h2>
        <?php partial('faq', ['faqs' => $faqs, 'id' => 'svc-faq']); ?>
      </section>
      <?php endif; ?>
    </article>

    <aside class="sidebar">
      <div class="sidecard sidecard--primary">
        <p class="eyebrow eyebrow--light">Get started</p>
        <h2 class="sidecard__title">Find Out if <?= e($title) ?> Is Right for You</h2>
        <a class="btn btn--accent btn--block" href="<?= e(url('make-appointment/')) ?>">Request Appointment</a>
        <a class="btn btn--glass btn--block" href="<?= e(tel_href($phone)) ?>"><?= icon('phone') ?><?= e($phone) ?></a>
        <a class="sidecard__link" href="<?= e(url('billing-and-insurance/#benefits-check')) ?>"><?= icon('shield-check') ?>Check my insurance benefits</a>
      </div>
      <div class="sidecard">
        <h2 class="sidecard__h">Available at</h2>
        <ul class="sidecard__locs">
          <?php foreach (Content::locations() as $l): ?>
          <li><a href="<?= e(url('locations/#' . $l['slug'])) ?>"><?= icon('map-pin') ?><span><strong><?= e($l['name']) ?></strong><small><?= e($l['address']) ?></small></span></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="sidecard">
        <h2 class="sidecard__h"><?= e($cat['label']) ?></h2>
        <ul class="sidecard__list">
          <?php foreach (Content::servicesByCategory()[$s['category']] ?? [] as $o): ?>
          <li><a href="<?= e(Content::serviceUrl($o)) ?>"<?= $o['slug'] === $s['slug'] ? ' aria-current="page"' : '' ?>><?= e(preg_replace('/\s*—\s*Coming Soon$/i', '', $o['menu_label'] ?: $o['title'])) ?><?= icon('chevron-right') ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </aside>
  </div>
</section>

<?php if ($providers): ?>
<section class="section section--soft section--tight">
  <div class="container">
    <div class="section-head" data-reveal>
      <div><p class="eyebrow">Your care team</p><h2 class="h3">Providers Who Offer This Treatment</h2></div>
      <a class="btn btn--outline" href="<?= e(url('our-doctor/')) ?>">All Providers <?= icon('arrow-right') ?></a>
    </div>
    <div class="pgrid pgrid--compact">
      <?php foreach (array_slice($providers, 0, 4) as $p): ?><div data-reveal><?php partial('provider-card', ['p' => $p]); ?></div><?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if ($related): ?>
<section class="section section--tight">
  <div class="container">
    <div class="section-head" data-reveal>
      <div><p class="eyebrow">Related treatments</p><h2 class="h3">You May Also Want to Explore</h2></div>
      <a class="btn btn--outline" href="<?= e(url('pain-treatments/')) ?>">All Treatments <?= icon('arrow-right') ?></a>
    </div>
    <div class="tgrid tgrid--4">
      <?php foreach ($related as $r): ?><div data-reveal><?php partial('service-card', ['s' => $r]); ?></div><?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php partial('cta', ['headline' => 'Find Out if This Treatment Is Right for You', 'button' => 'Request Appointment']); ?>
