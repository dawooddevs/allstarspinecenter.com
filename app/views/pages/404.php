<?php
Seo::set(['title' => 'Page not found', 'noindex' => true]);
?>
<section class="section notfound">
  <div class="container container--narrow center">
    <p class="notfound__code" aria-hidden="true">404</p>
    <h1 class="h2">We couldn't find that page</h1>
    <p class="lead">The page may have moved. Try searching our treatments or use one of the links below.</p>
    <form class="search search--lg" action="<?= e(url('pain-treatments/')) ?>" method="get" role="search">
      <?= icon('search') ?><label class="sr-only" for="nf-q">Search treatments</label>
      <input id="nf-q" name="q" type="search" placeholder="Search by treatment or concern">
    </form>
    <div class="btn-row btn-row--center">
      <a class="btn btn--accent" href="<?= e(url('make-appointment/')) ?>">Request Appointment</a>
      <a class="btn btn--outline" href="<?= e(url('pain-treatments/')) ?>">All Treatments</a>
      <a class="btn btn--outline" href="<?= e(url('')) ?>">Home</a>
    </div>
  </div>
</section>
