<?php
/** Procedurally drawn spine illustration used in the hero when no photo is set. */
$n = 24;
$top = 40;
$bottom = 560;
$cx = 200;
$parts = [];
for ($i = 0; $i < $n; $i++) {
    $t = $i / ($n - 1);
    $y = $top + $t * ($bottom - $top);
    // Natural S-curve: cervical lordosis, thoracic kyphosis, lumbar lordosis
    $x = $cx + 26 * sin($t * M_PI * 2.1 - 0.4) + 10 * sin($t * M_PI * 4);
    $dx = 26 * cos($t * M_PI * 2.1 - 0.4) * M_PI * 2.1 + 10 * cos($t * M_PI * 4) * M_PI * 4;
    $angle = rad2deg(atan2($dx, $bottom - $top)) * -0.6;
    $w = 34 + 46 * pow($t, 0.9);
    $h = 13 + 9 * $t;
    $parts[] = [$x, $y, $w, $h, $angle, $t];
}
?>
<svg class="spine" viewBox="0 0 400 600" aria-hidden="true" focusable="false">
  <defs>
    <linearGradient id="spineG" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0" stop-color="#ffffff" stop-opacity=".95"/>
      <stop offset="1" stop-color="#9cc3ff" stop-opacity=".75"/>
    </linearGradient>
    <radialGradient id="spineGlow">
      <stop offset="0" stop-color="var(--accent)" stop-opacity=".9"/>
      <stop offset="1" stop-color="var(--accent)" stop-opacity="0"/>
    </radialGradient>
  </defs>
  <path class="spine__cord" d="M<?php foreach ($parts as $i => $p) { echo ($i ? ' L' : '') . round($p[0], 1) . ' ' . round($p[1], 1); } ?>" fill="none" stroke="rgba(255,255,255,.25)" stroke-width="3" stroke-linecap="round"/>
  <?php foreach ($parts as $i => [$x, $y, $w, $h, $a, $t]): ?>
  <g class="spine__v" style="--i:<?= $i ?>" transform="translate(<?= round($x, 1) ?> <?= round($y, 1) ?>) rotate(<?= round($a, 1) ?>)">
    <rect x="<?= round(-$w / 2, 1) ?>" y="<?= round(-$h / 2, 1) ?>" width="<?= round($w, 1) ?>" height="<?= round($h, 1) ?>" rx="<?= round($h / 2.2, 1) ?>" fill="url(#spineG)"/>
    <rect x="<?= round(-$w / 2 - 12 - 6 * $t, 1) ?>" y="-2.5" width="<?= round(10 + 6 * $t, 1) ?>" height="5" rx="2.5" fill="rgba(255,255,255,.45)"/>
    <rect x="<?= round($w / 2 + 2, 1) ?>" y="-2.5" width="<?= round(10 + 6 * $t, 1) ?>" height="5" rx="2.5" fill="rgba(255,255,255,.45)"/>
  </g>
  <?php endforeach; ?>
  <?php foreach ([3, 15, 20] as $k => $idx): $p = $parts[$idx]; ?>
  <g class="spine__pulse" style="--k:<?= $k ?>">
    <circle cx="<?= round($p[0], 1) ?>" cy="<?= round($p[1], 1) ?>" r="34" fill="url(#spineGlow)"/>
    <circle cx="<?= round($p[0], 1) ?>" cy="<?= round($p[1], 1) ?>" r="5" fill="#fff"/>
  </g>
  <?php endforeach; ?>
</svg>
