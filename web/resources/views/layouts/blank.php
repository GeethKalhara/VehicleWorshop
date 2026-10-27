<?php
/**
 * @var string $title
 * @var string $csrf
 * @var string $content
 * @var string $content_name
 * @var array<string, string> $assets
 * @var \Closure(string|false|null $href): string $renderStylesheet
 * @var \Closure(string|false|null $href, bool ...$flags): string $renderScript
 */

$__filename__ = 'layouts/' . basename(__FILE__, '.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= htmlspecialchars($csrf) ?>">

    <title><?= htmlspecialchars($title) ?></title>

    <?= $renderStylesheet($assets["css/$__filename__.css"] ?? null) ?>
    <?= $renderStylesheet($assets["css/$content_name.css"] ?? null) ?>

    <?= $renderScript($assets["ts/$__filename__.ts"] ?? null) ?>
    <?= $renderScript($assets["ts/$content_name.ts"] ?? null) ?>
</head>
<body>
    <main>
        <?= $content ?>
    </main>
</body>
</html>
