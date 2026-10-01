<?php $phone = setting('phone'); ?>
<nav class="mbar" aria-label="Quick actions">
  <a href="<?= e(tel_href($phone)) ?>"><?= icon('phone') ?><span>Call</span></a>
  <a href="<?= e(sms_href(setting('sms_phone') ?: $phone)) ?>"><?= icon('message') ?><span>Text</span></a>
  <a class="mbar__primary" href="<?= e(url('make-appointment/')) ?>"><?= icon('calendar-check') ?><span>Appointment</span></a>
</nav>
