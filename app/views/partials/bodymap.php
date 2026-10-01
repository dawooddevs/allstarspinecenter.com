<?php
/** Interactive "Where does it hurt?" body-area selector. */
$areas = Content::BODY_AREAS;
$map = Content::bodyAreaMap();
$spots = [
    'neck' => [150, 104], 'shoulder' => [204, 140], 'back' => [150, 250], 'hip' => [184, 312],
    'knee' => [121, 452], 'elbow' => [76, 228], 'wrist-hand' => [58, 322], 'leg' => [182, 510], 'ankle-foot' => [190, 566],
];
$default = 'back';
?>
<div class="bodymap" data-bodymap>
  <script type="application/json" data-bodymap-data><?= json_encode($map, JSON_HEX_TAG | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
  <div class="bodymap__figure">
    <svg viewBox="0 0 300 600" class="bodymap__svg" role="img" aria-label="Body diagram — select an area below">
      <defs>
        <linearGradient id="bodyG" x1="0" y1="0" x2="0" y2="1">
          <stop offset="0" stop-color="#dfe8f7"/>
          <stop offset="1" stop-color="#c9d7ee"/>
        </linearGradient>
      </defs>
      <g class="bodymap__body" fill="url(#bodyG)" stroke="url(#bodyG)" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="150" cy="58" r="34" stroke="none"/>
        <path d="M150 92 V118" stroke-width="26" fill="none"/>
        <path stroke="none" d="M104 126 Q150 114 196 126 Q216 132 214 160 L202 300 Q198 334 150 338 Q102 334 98 300 L86 160 Q84 132 104 126 Z"/>
        <path d="M100 140 L76 228 L60 312" stroke-width="24" fill="none"/>
        <path d="M200 140 L224 228 L240 312" stroke-width="24" fill="none"/>
        <circle cx="57" cy="330" r="14" stroke="none"/>
        <circle cx="243" cy="330" r="14" stroke="none"/>
        <path d="M128 320 L121 452 L117 556" stroke-width="32" fill="none"/>
        <path d="M172 320 L179 452 L184 556" stroke-width="32" fill="none"/>
        <ellipse cx="110" cy="574" rx="20" ry="10" stroke="none"/>
        <ellipse cx="191" cy="574" rx="20" ry="10" stroke="none"/>
      </g>
      <?php foreach ($spots as $key => [$x, $y]): ?>
      <g class="bodymap__spot<?= $key === $default ? ' is-active' : '' ?>" data-area="<?= e($key) ?>" transform="translate(<?= $x ?> <?= $y ?>)">
        <circle class="bodymap__halo" r="22"/>
        <circle class="bodymap__dot" r="8"/>
      </g>
      <?php endforeach; ?>
    </svg>
  </div>
  <div class="bodymap__panel">
    <div class="bodymap__chips" role="group" aria-label="Choose an area">
      <?php foreach ($areas as $key => $label): ?>
      <button type="button" class="chip<?= $key === $default ? ' is-active' : '' ?>" data-area="<?= e($key) ?>" aria-pressed="<?= $key === $default ? 'true' : 'false' ?>"><?= e($label) ?></button>
      <?php endforeach; ?>
    </div>
    <div class="bodymap__results" aria-live="polite">
      <p class="bodymap__heading"><span data-bodymap-label><?= e($areas[$default]) ?></span> — treatments that may help</p>
      <ul class="bodymap__list" data-bodymap-list>
        <?php foreach ($map[$default] as $s): ?>
        <li><a href="<?= e($s['url']) ?>"><span><strong><?= e($s['title']) ?></strong><small><?= e($s['category']) ?></small></span><?= icon('arrow-right') ?></a></li>
        <?php endforeach; ?>
      </ul>
      <p class="bodymap__note">Not sure? <a href="<?= e(url('make-appointment/')) ?>">Request an evaluation</a> and our team will help find the right place to start.</p>
    </div>
  </div>
</div>
