<?php
 /* Reads stats.json and renders metric cards dynamically. */

$jsonFile = __DIR__ . '/stats.json';

// load & parse JSON
if (!file_exists($jsonFile)) {
    die('<p style="color:red;font-family:sans-serif;padding:2rem;">Error: stats.json not found in the same directory.</p>');
}

$raw  = file_get_contents($jsonFile);
$data = json_decode($raw, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die('<p style="color:red;font-family:sans-serif;padding:2rem;">Error: Invalid JSON — ' . json_last_error_msg() . '</p>');
}

$title       = htmlspecialchars($data['dashboard_title'] ?? 'Dashboard');
$lastUpdated = htmlspecialchars($data['last_updated']    ?? '');
$metrics     = $data['metrics'] ?? [];

// formating large numbers nicely
function formatValue(int|float $value, string $unit): string {
    if ($unit !== '') {
        // Already has a custom unit (e.g. "Bn L", "%")
        return number_format($value) . ' ' . htmlspecialchars($unit);
    }
    if ($value >= 1_000_000) {
        return number_format($value / 1_000_000, 1) . 'M';
    }
    if ($value >= 1_000) {
        return number_format($value / 1_000, 1) . 'K';
    }
    return number_format($value);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $title ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,700;1,9..144,400&family=DM+Mono:wght@400;500&family=Instrument+Sans:wght@400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="styles.css">
</head>
<body>

  <!-- Header data from JSON -->
  <header class="dashboard-header">
    <div>
      <div class="brand">
        <div class="brand-leaf">🌱</div>
        <div class="brand-name">Clim<span>Agro</span></div>
      </div>
      <h1 class="dashboard-title"><?= $title ?></h1>
    </div>
    <?php if ($lastUpdated): ?>
    <div class="meta">
      <span class="live-dot"></span>
      Data as of <?= $lastUpdated ?>
    </div>
    <?php endif; ?>
  </header>

  <main class="grid">
    <?php foreach ($metrics as $i => $m):
      $value    = $m['value']          ?? 0;
      $unit     = $m['unit']           ?? '';
      $label    = htmlspecialchars($m['label']       ?? 'Metric');
      $icon     = htmlspecialchars($m['icon']        ?? '📊');
      $desc     = htmlspecialchars($m['description'] ?? '');
      $trend    = htmlspecialchars($m['trend']       ?? '');
      $positive = $m['trend_positive'] ?? true;
      $color    = htmlspecialchars($m['color']       ?? '#6fcf7f');
      $display  = formatValue($value, $unit);
      $delay    = $i * 60; // staggered animation
    ?>
    <article
      class="card"
      style="--card-color: <?= $color ?>; animation-delay: <?= $delay ?>ms;"
      aria-label="<?= $label ?>: <?= $display ?>"
    >
      <div class="card-icon"><?= $icon ?></div>
      <div class="card-label"><?= $label ?></div>
      <div class="card-value"><?= $display ?></div>
      <?php if ($desc): ?>
      <p class="card-description"><?= $desc ?></p>
      <?php endif; ?>
      <?php if ($trend): ?>
      <span class="card-trend <?= $positive ? '' : 'negative' ?>">
        <em class="trend-arrow"><?= $positive ? '↑' : '↓' ?></em>
        <?= $trend ?>
      </span>
      <?php endif; ?>
    </article>
    <?php endforeach; ?>
  </main>

  <!-- Footer -->
  <footer class="dashboard-footer">
    <span class="footer-note">
      Source: <code>stats.json</code> — edit this file to update this dashboard automatically.
    </span>
    <span class="footer-note">
      <?= count($metrics) ?> metrics loaded &nbsp;·&nbsp; ClimAgro  <?= date('Y') ?>
    </span>
  </footer>

</body>
</html>
