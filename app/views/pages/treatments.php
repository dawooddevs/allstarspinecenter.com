<?php
/** @var array $page /pain-treatments/ index */
Seo::set([
    'title' => $page['meta_title'] ?: $page['title'],
    'description' => $page['meta_description'] ?: $page['intro'],
    'canonical' => abs_url('pain-treatments/'),
]);
$services = Content::services();
$active = isset($_GET['category'], Content::CATEGORIES[$_GET['category']]) ? $_GET['category'] : 'all';
$items = [];
foreach ($services as $i => $s) {
    $items[] = ['@type' => 'ListItem', 'position' => $i + 1, 'url' => abs_url('service/' . $s['slug'] . '/'), 'name' => $s['title']];
}
Seo::addSchema(['@context' => 'https://schema.org', '@type' => 'ItemList', 'name' => 'Pain Treatments', 'itemListElement' => $items]);
partial('inner-hero', [
    'title' => $page['title'],
    'eyebrow' => $page['eyebrow'],
    'text' => $page['intro'],
    'crumbs' => [[$page['title'], 'pain-treatments/']],
    'showActions' => false,
]);
?>
<section class="section section--tight treatments-index" data-tindex>
  <div class="container">
    <div class="filters" data-reveal>
      <label class="search">
        <?= icon('search') ?>
        <span class="sr-only">Search treatments</span>
        <input type="search" placeholder="Search by treatment or concern" data-tsearch autocomplete="off">
      </label>
      <div class="tabs tabs--wrap" role="group" aria-label="Filter by category">
        <button class="tab<?= $active === 'all' ? ' is-active' : '' ?>" data-filter="all" aria-pressed="<?= $active === 'all' ? 'true' : 'false' ?>">All <span class="tab__count"><?= count($services) ?></span></button>
        <?php foreach (Content::CATEGORIES as $k => $c):
            $n = count(array_filter($services, fn($s) => $s['category'] === $k)); ?>
        <button class="tab<?= $active === $k ? ' is-active' : '' ?>" data-filter="<?= e($k) ?>" aria-pressed="<?= $active === $k ? 'true' : 'false' ?>"><?= e($c['short']) ?> <span class="tab__count"><?= $n ?></span></button>
        <?php endforeach; ?>
      </div>
    </div>
    <p class="results-count" aria-live="polite" data-tcount></p>
    <div class="tgrid" data-tgrid data-initial="<?= e($active) ?>">
      <?php foreach ($services as $s) partial('service-card', ['s' => $s]); ?>
    </div>
    <div class="empty" data-tempty hidden>
      <span class="empty__icon"><?= icon('search') ?></span>
      <h2 class="h4">No treatments match your search</h2>
      <p>Try a different word, or let our team help you find the right place to start.</p>
      <div class="btn-row btn-row--center">
        <a class="btn btn--accent" href="<?= e(url('make-appointment/')) ?>">Request Appointment</a>
        <a class="btn btn--outline" href="<?= e(tel_href(setting('phone'))) ?>"><?= icon('phone') ?>Call <?= e(setting('phone')) ?></a>
      </div>
    </div>
  </div>
</section>
<section class="section section--soft section--tight">
  <div class="container">
    <div class="cat-grid">
      <?php foreach (Content::CATEGORIES as $k => $c): ?>
      <a class="cat-card" href="?category=<?= e($k) ?>" data-reveal>
        <span class="cat-card__icon"><?= icon($c['icon']) ?></span>
        <strong><?= e($c['label']) ?></strong>
        <small><?= e($c['blurb']) ?></small>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php partial('cta', ['headline' => 'Not Sure Which Treatment You Need?', 'copy' => 'We can help determine the right place to start. Request an evaluation and our team will guide you.']); ?>
