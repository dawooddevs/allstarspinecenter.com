<div class="sidecard" id="patient-forms-card">
  <h2 class="sidecard__h">Patient Forms</h2>
  <ul class="doc-list">
    <?php foreach (Content::patientForms() as $f): ?>
    <li>
      <a href="<?= e($f['url']) ?>"<?= $f['download'] ? ' target="_blank" rel="noopener"' : '' ?>><span class="doc-list__icon"><?= icon('file-text') ?></span><span><?= e($f['label']) ?><small><?= $f['download'] ? 'Download PDF' : 'View all questionnaires' ?></small></span><?= icon($f['download'] ? 'download' : 'arrow-right') ?></a>
    </li>
    <?php endforeach; ?>
  </ul>
</div>
