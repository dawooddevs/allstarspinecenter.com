<?php
/** @var array $page /our-doctor/ directory */
Seo::set([
    'title' => $page['meta_title'] ?: $page['title'],
    'description' => $page['meta_description'] ?: $page['intro'],
    'canonical' => abs_url('our-doctor/'),
]);
$providers = Content::providers();
$types = array_unique(array_column($providers, 'type'));
partial('inner-hero', [
    'title' => $page['title'],
    'eyebrow' => $page['eyebrow'],
    'text' => $page['intro'],
    'crumbs' => [[$page['title'], 'our-doctor/']],
    'showActions' => false,
]);
?>
<section class="section section--tight" data-pindex>
  <div class="container">
    <div class="filters" data-reveal>
      <div class="tabs tabs--wrap" role="group" aria-label="Filter providers">
        <button class="tab is-active" data-filter="all" aria-pressed="true">All Providers</button>
        <?php foreach (['chiropractor', 'family_medicine', 'physician_assistant', 'other'] as $t): if (!in_array($t, $types, true)) continue; ?>
        <button class="tab" data-filter="<?= e($t) ?>" aria-pressed="false"><?= e(Content::PROVIDER_TYPES[$t]) ?></button>
        <?php endforeach; ?>
      </div>
      <label class="search search--sm">
        <?= icon('search') ?><span class="sr-only">Search providers</span>
        <input type="search" placeholder="Search by name" data-psearch autocomplete="off">
      </label>
    </div>
    <div class="pgrid" data-pgrid>
      <?php foreach ($providers as $p) partial('provider-card', ['p' => $p]); ?>
    </div>
    <div class="empty" data-pempty hidden><h2 class="h4">No providers match your search</h2></div>
  </div>
</section>
<?php if (trim(strip_tags((string)$page['content'])) !== ''): ?>
<section class="section section--tight"><div class="container container--narrow prose prose--lg"><?= Html::clean($page['content']) ?></div></section>
<?php endif; ?>
<?php partial('cta'); ?>
