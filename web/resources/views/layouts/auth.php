<?php
/**
 * Authentication Layout
 *
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
<html lang="en" class="h-full bg-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= htmlspecialchars($csrf) ?>">
    <title><?= htmlspecialchars($title) ?></title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <?php if ($__layout_css__): ?>
        <link rel="stylesheet" href="<?= $__layout_css__ ?>">
    <?php endif; ?>

    <?php if ($__layout_ts__): ?>
        <script src="<?= $__layout_ts__ ?>" defer></script>
    <?php endif; ?>

    <?php if ($__content_css__): ?>
        <link rel="stylesheet" href="<?= $__content_css__ ?>">
    <?php endif; ?>

    <?php if ($__content_ts__): ?>
        <script src="<?= $__content_ts__ ?>" defer></script>
    <?php endif; ?>

</head>
<body>
    <div class="min-h-screen w-full flex items-center justify-center p-4 sm:p-6 lg:p-8 bg-slate-950 relative overflow-hidden">
        <!-- 3D Car Perspective Background Canvas -->
        <canvas id="car-bg-canvas" class="fixed inset-0 pointer-events-none z-0 w-full h-full"></canvas>

        <!-- Main Card Container -->
        <div class="auth-card">

            <!-- ======================================================== -->
            <!-- LEFT PANEL: Dark Brand Showcase                          -->
            <!-- ======================================================== -->
            <div class="auth-left-panel">
                <!-- Decorative concentric orbit rings -->
                <div class="orbit-ring orbit-ring-1 opacity-60"></div>
                <div class="orbit-ring orbit-ring-2 opacity-40"></div>
                <div class="orbit-ring orbit-ring-3 opacity-20"></div>
                <div class="ambient-glow top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"></div>

                <!-- Top Tagline -->
                <div class="relative z-10">
                    <p class="text-xs sm:text-sm text-gray-400 font-normal tracking-wide">
                        Vehicle care made effortless — smart workshop solutions for you.
                    </p>
                </div>

                <!-- Showcase Content: Headline + Subtitle + Animation Slot -->
                <div class="relative z-10 my-auto py-4 flex flex-col items-start w-full">
                    <h1 class="auth-left-heading">
                        Welcome to<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-amber-400">AutoCare</span>
                    </h1>
                    <p class="auth-left-subheading">
                        Vehicle Workshop Management System
                    </p>

                    <!-- Reserved Animation Slot -->

                </div>

                <!-- Bottom Spacer -->
                <div class="relative z-10"></div>
            </div>

            <!-- ======================================================== -->
            <!-- RIGHT PANEL: Clean Form Panel                            -->
            <!-- ======================================================== -->
            <div class="auth-right-panel">

                <!-- Top Bar: Brand Logo -->
                <div class="flex items-center justify-between w-full">
                    <a href="/" class="flex items-center gap-2.5 group">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-orange-500 to-amber-500 flex items-center justify-center shadow-md shadow-orange-500/20 group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <span class="text-2xl font-bold tracking-tight text-gray-900">AutoCare</span>
                    </a>
                </div>

                <!-- Form Body Area -->
                <div class="auth-form-container">
                    <?= $content ?>
                </div>

                <!-- Footer: Copyright & Links -->
                <div class="w-full pt-4 sm:pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-500 gap-3">
                    <div class="flex items-center gap-5">
                        <a href="#" class="hover:text-gray-900 transition-colors">Contact Us</a>
                        <div class="flex items-center gap-1 cursor-pointer hover:text-gray-900 transition-colors">
                            <span>English</span>
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

</body>
</html>
