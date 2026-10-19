<?php
/**
 * @var string $title
 * @var string $csrf
 * @var string $content
 * @var string $content_name
 * @var array<string, string> $assets
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= htmlspecialchars($csrf) ?>">

    <title><?= htmlspecialchars($title) ?></title>

    <!-- layout assets -->
    <link rel="stylesheet" href="<?= $assets['css/blank.css'] ?>">
    <script src="<?= $assets['ts/blank.ts'] ?>"></script>

    <!-- content css -->
    <?php if ($content_css = $assets["css/$content_name.css"] ?? false): ?>
        <link rel="stylesheet" href="<?= $content_css ?>">
    <?php endif; ?>
    <!-- content ts -->
    <?php if ($content_ts = $assets["ts/$content_name.ts"] ?? false): ?>
        <script src="<?= $content_ts ?>"></script>
    <?php endif; ?>
</head>
<body>
    <h1>Hello Blank</h1>
    <main>
        <?= $content ?>
    </main>
</body>
</html>
