<?php
/** @var array $page HTML sitemap */
Seo::set(['title' => $page['meta_title'] ?: $page['title'], 'description' => $page['meta_description'], 'canonical' => abs_url('sitemap/')]);
partial('inner-hero', ['title' => $page['title'], 'eyebrow' => $page['eyebrow'], 'text' => $page['intro'], 'crumbs' => [['Sitemap', 'sitemap/']], 'showActions' => false]);
$pages = DB::all("SELECT slug, title FROM pages WHERE status = 'published' AND slug NOT IN ('thank-you','new-patient-thank-you') ORDER BY sort_order, title");
?>
<section class="section section--tight">
  <div class="container sitemap-grid">
    <div>
      <h2 class="h4">Pages</h2>
      <ul class="sitemap-list">
        <li><a href="<?= e(url('')) ?>">Home</a></li>
        <?php foreach ($pages as $p): ?><li><a href="<?= e(url($p['slug'] . '/')) ?>"><?= e($p['title']) ?></a></li><?php endforeach; ?>
      </ul>
      <h2 class="h4">Providers</h2>
      <ul class="sitemap-list">
        <?php foreach (Content::providers() as $p): ?><li><a href="<?= e(Content::providerUrl($p)) ?>"><?= e($p['name']) ?></a></li><?php endforeach; ?>
      </ul>
    </div>
    <?php foreach (Content::servicesByCategory() as $cat => $items): if (!$items) continue; ?>
    <div>
      <h2 class="h4"><?= e(Content::categoryLabel($cat)) ?></h2>
      <ul class="sitemap-list">
        <?php foreach ($items as $s): ?><li><a href="<?= e(Content::serviceUrl($s)) ?>"><?= e($s['title']) ?></a></li><?php endforeach; ?>
      </ul>
    </div>
    <?php endforeach; ?>
  </div>
</section>
