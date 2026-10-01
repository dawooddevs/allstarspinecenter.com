<div class="sidecard" id="patient-forms-card">
  <h2 class="sidecard__h">Patient Forms</h2>
  <ul class="doc-list">
    <?php foreach (Content::patientForms() as $f): ?>
    <li>
      <?php if ($f['available']): ?>
      <a href="<?= e($f['url']) ?>" target="_blank" rel="noopener"><span class="doc-list__icon"><?= icon('file-text') ?></span><span><?= e($f['label']) ?><small>Download PDF</small></span><?= icon('download') ?></a>
      <?php else: ?>
      <span class="doc-list__item is-pending"><span class="doc-list__icon"><?= icon('file-text') ?></span><span><?= e($f['label']) ?><small>Available at check-in · or call <?= e(setting('phone')) ?></small></span></span>
      <?php endif; ?>
    </li>
    <?php endforeach; ?>
  </ul>
</div>
