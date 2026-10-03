<?php
/** @var array $page Generic content page (also used for drafts in preview mode). */
Seo::set([
    'title' => $page['meta_title'] ?: $page['title'],
    'description' => $page['meta_description'] ?: $page['intro'],
    'canonical' => abs_url($page['slug'] . '/'),
    'image' => $page['image'],
]);
if (in_array($page['slug'], ['thank-you', 'new-patient-thank-you'], true)) {
    Seo::$noindex = true; // form confirmation pages stay out of search results
}
partial('inner-hero', [
    'title' => $page['title'],
    'eyebrow' => $page['eyebrow'],
    'text' => $page['intro'],
    'crumbs' => [[$page['title'], $page['slug'] . '/']],
    'image' => $page['image'],
    'showActions' => $page['template'] !== 'legal',
]);
?>
<section class="section section--article">
  <div class="container<?= $page['template'] === 'legal' ? ' container--narrow' : ' article-layout' ?>">
    <article class="article">
      <div class="prose prose--lg" data-reveal><?= Html::clean($page['content']) ?></div>
    </article>
    <?php if ($page['template'] !== 'legal'): ?>
    <aside class="sidebar">
      <div class="sidecard sidecard--primary">
        <p class="eyebrow eyebrow--light">Patient Center</p>
        <h2 class="sidecard__title">Ready when you are</h2>
        <a class="btn btn--accent btn--block" href="<?= e(url('make-appointment/')) ?>">Request Appointment</a>
        <a class="btn btn--glass btn--block" href="<?= e(tel_href(setting('phone'))) ?>"><?= icon('phone') ?><?= e(setting('phone')) ?></a>
        <a class="sidecard__link" href="<?= e(url('billing-and-insurance/#benefits-check')) ?>"><?= icon('shield-check') ?>Check my insurance benefits</a>
      </div>
      <?php partial('forms-card'); ?>
    </aside>
    <?php endif; ?>
  </div>
</section>
<?php if ((int)$page['show_cta']) partial('cta'); ?>
