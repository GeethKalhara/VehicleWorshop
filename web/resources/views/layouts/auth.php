<?php
/**
 * Authentication Layout
 *
 * @var string $title
 * @var string $csrf
 * @var string $content
 * @var array<string, string> $assets
 */
?>
<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= htmlspecialchars($csrf ?? '') ?>">
    <title><?= htmlspecialchars($title ?? 'Sign In - AutoCare Customer Portal') ?></title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS & JS Assets -->
    <link rel="stylesheet" href="<?= $assets['css/customer.css'] ?? '/assets/customer.css' ?>">
    <script defer src="<?= $assets['ts/customer.ts'] ?? '/assets/customer.js' ?>"></script>
</head>
<body class="h-full min-h-screen bg-slate-950 text-slate-900 antialiased font-sans selection:bg-orange-500 selection:text-white">
    <?= $content ?>
</body>
</html>
