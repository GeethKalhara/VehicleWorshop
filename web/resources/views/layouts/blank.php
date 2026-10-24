<?php
/**
 * @var string $title
 * @var string $csrf
 * @var string $content
 * @var string $content_name
 * @var array<string, string> $assets
 */

$__filename__ = 'layouts/' . basename(__FILE__, '.php');
$__layout_ts__ = $assets["ts/$__filename__.ts"] ?? false;
$__layout_css__ = $assets["css/$__filename__.css"] ?? false;
$__content_ts__ = $assets["ts/$content_name.ts"] ?? false;
$__content_css__ = $assets["css/$content_name.css"] ?? false;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= htmlspecialchars($csrf) ?>">

    <title><?= htmlspecialchars($title) ?></title>

    <?php if ($__layout_css__): ?>
        <link rel="stylesheet" href="<?= $__layout_css__ ?>">
    <?php endif; ?>

    <?php if ($__layout_ts__): ?>
        <script src="<?= $__layout_ts__ ?>"></script>
    <?php endif; ?>

    <?php if ($__content_css__): ?>
        <link rel="stylesheet" href="<?= $__content_css__ ?>">
    <?php endif; ?>

    <?php if ($__content_ts__): ?>
        <script src="<?= $__content_ts__ ?>"></script>
    <?php endif; ?>
    
</head>
<body>
    <h1>Hello Blank</h1>
    <main>
        <?= $content ?>
    </main>
</body>
</html>
