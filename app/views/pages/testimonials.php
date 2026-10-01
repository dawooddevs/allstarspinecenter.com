<?php
/** @var array $page */
Seo::set([
    'title' => $page['meta_title'] ?: $page['title'],
    'description' => $page['meta_description'] ?: $page['intro'],
    'canonical' => abs_url('testimonials/'),
]);
$items = Content::testimonials();
partial('inner-hero', [
    'title' => $page['title'],
    'eyebrow' => $page['eyebrow'],
    'text' => $page['intro'],
    'crumbs' => [['Testimonials', 'testimonials/']],
]);
?>
<section class="section">
  <div class="container">
    <?php if ($items): ?>
    <div class="masonry">
      <?php foreach ($items as $i => $t): ?>
      <figure class="tquote tquote--card" data-reveal style="--d:<?= $i % 3 ?>">
        <div class="tquote__stars" aria-label="<?= (int)$t['rating'] ?> out of 5 stars"><?= str_repeat(icon('star'), max(1, min(5, (int)$t['rating']))) ?></div>
        <blockquote class="tquote__text"><p><?= nl2br(e($t['content'])) ?></p></blockquote>
        <figcaption class="tquote__by">
          <span class="tquote__avatar" aria-hidden="true"><?= e(mb_substr($t['name'], 0, 1)) ?></span>
          <span><strong><?= e($t['name']) ?></strong><?php if ($t['label']): ?><small><?= e($t['label']) ?></small><?php endif; ?></span>
        </figcaption>
      </figure>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="empty">
      <span class="empty__icon"><?= icon('quote') ?></span>
      <h2 class="h4">Patient stories are on their way</h2>
      <p>We're gathering stories from our patients. In the meantime, our team is happy to answer your questions.</p>
      <div class="btn-row btn-row--center"><a class="btn btn--accent" href="<?= e(url('make-appointment/')) ?>">Request Appointment</a></div>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php partial('cta'); ?>
