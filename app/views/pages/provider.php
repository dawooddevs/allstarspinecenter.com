<?php
/** @var array $provider */
$p = $provider;
$phone = setting('phone');
$typeLabel = Content::PROVIDER_TYPES[$p['type']] ?? 'Provider';
$services = Content::servicesBySlugs(csv_list($p['services']));
$focus = lines($p['focus']);
$locSlugs = csv_list($p['locations']);
$locs = array_values(array_filter(Content::locations(), fn($l) => in_array($l['slug'], $locSlugs, true)));
$initials = implode('', array_map(fn($w) => mb_substr($w, 0, 1), array_slice(explode(' ', preg_replace('/^(Dr\.?\s+)/i', '', $p['name'])), 0, 2)));
$url = abs_url('doctor/' . $p['slug'] . '/');

Seo::set([
    'title' => $p['meta_title'] ?: ($p['name'] . ' — ' . $p['title']),
    'description' => $p['meta_description'] ?: str_limit((string)($p['short_bio'] ?: $p['bio']), 160),
    'canonical' => $url,
    'image' => $p['photo'],
    'type' => 'profile',
]);
$schema = [
    '@context' => 'https://schema.org',
    '@type' => ['Physician', 'Person'],
    'name' => $p['name'],
    'jobTitle' => $p['title'],
    'url' => $url,
    'worksFor' => ['@id' => abs_url('') . '#organization'],
    'memberOf' => ['@id' => abs_url('') . '#organization'],
];
if ($p['photo']) $schema['image'] = abs_url($p['photo']);
if ($p['credentials']) $schema['honorificSuffix'] = $p['credentials'];
if ($focus) $schema['knowsAbout'] = $focus;
Seo::addSchema($schema);
Seo::$breadcrumbs = [['Home', ''], ['Meet Our Providers', 'our-doctor/'], [$p['name'], 'doctor/' . $p['slug'] . '/']];

$sections = array_filter([
    'Biography' => $p['bio'],
    'Education' => $p['education'],
    'Experience' => $p['experience'],
    'Treatment Philosophy' => $p['philosophy'],
], fn($v) => trim(strip_tags((string)$v)) !== '');
?>
<section class="phero">
  <div class="ihero__bg" aria-hidden="true"><span></span><span></span></div>
  <div class="container phero__inner">
    <div class="phero__photo" data-reveal="mask">
      <?php if ($p['photo']): ?>
        <?= img($p['photo'], $p['name'] . ', ' . $p['title'], ['loading' => 'eager', 'fetchpriority' => 'high', 'style' => 'object-position:' . ($p['photo_position'] ?: '50% 20%')]) ?>
      <?php else: ?>
        <div class="pcard__avatar pcard__avatar--lg" aria-hidden="true"><span><?= e(strtoupper($initials)) ?></span></div>
      <?php endif; ?>
    </div>
    <div class="phero__content" data-reveal>
      <nav class="crumbs" aria-label="Breadcrumb">
        <ol>
          <li><a href="<?= e(url('')) ?>">Home</a></li>
          <li><?= icon('chevron-right') ?><a href="<?= e(url('our-doctor/')) ?>">Meet Our Providers</a></li>
          <li><?= icon('chevron-right') ?><span aria-current="page"><?= e($p['name']) ?></span></li>
        </ol>
      </nav>
      <p class="eyebrow"><?= e($typeLabel) ?></p>
      <h1 class="ihero__title"><?= e($p['name']) ?><?= $p['credentials'] ? '<span class="phero__cred">, ' . e($p['credentials']) . '</span>' : '' ?></h1>
      <p class="phero__role"><?= e($p['title']) ?></p>
      <?php if ($p['short_bio']): ?><p class="ihero__text"><?= e($p['short_bio']) ?></p><?php endif; ?>
      <?php if ($locs): ?>
      <ul class="pill-list">
        <?php foreach ($locs as $l): ?><li><?= icon('map-pin') ?><?= e($l['name']) ?></li><?php endforeach; ?>
      </ul>
      <?php endif; ?>
      <div class="btn-row">
        <a class="btn btn--accent btn--lg" href="<?= e(url('make-appointment/')) ?>">Request Appointment <?= icon('arrow-right') ?></a>
        <a class="btn btn--ghost btn--lg" href="<?= e(tel_href($phone)) ?>"><?= icon('phone') ?>Call Us</a>
      </div>
    </div>
  </div>
</section>

<section class="section section--article">
  <div class="container article-layout">
    <article class="article">
      <?php foreach ($sections as $label => $html): ?>
      <section class="article__section" data-reveal>
        <h2><?= e($label) ?></h2>
        <div class="prose"><?= Html::clean($html) ?></div>
      </section>
      <?php endforeach; ?>
      <?php if ($focus): ?>
      <section class="article__section" data-reveal>
        <h2>Areas of Focus</h2>
        <ul class="cond-grid"><?php foreach ($focus as $f): ?><li><?= icon('check-circle') ?><?= e($f) ?></li><?php endforeach; ?></ul>
      </section>
      <?php endif; ?>
      <?php if ($services): ?>
      <section class="article__section" data-reveal>
        <h2>Relevant Services</h2>
        <div class="tgrid tgrid--2">
          <?php foreach ($services as $s) partial('service-card', ['s' => $s]); ?>
        </div>
      </section>
      <?php endif; ?>
    </article>
    <aside class="sidebar">
      <div class="sidecard sidecard--primary">
        <p class="eyebrow eyebrow--light">Appointments</p>
        <h2 class="sidecard__title">See <?= e($p['name']) ?></h2>
        <a class="btn btn--accent btn--block" href="<?= e(url('make-appointment/')) ?>">Request Appointment</a>
        <a class="btn btn--glass btn--block" href="<?= e(tel_href($phone)) ?>"><?= icon('phone') ?><?= e($phone) ?></a>
      </div>
      <div class="sidecard">
        <h2 class="sidecard__h">Our providers</h2>
        <ul class="sidecard__list">
          <?php foreach (Content::providers() as $o): ?>
          <li><a href="<?= e(Content::providerUrl($o)) ?>"<?= $o['slug'] === $p['slug'] ? ' aria-current="page"' : '' ?>><?= e($o['name']) ?><?= icon('chevron-right') ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </aside>
  </div>
</section>

<?php partial('cta'); ?>
