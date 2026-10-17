<?php
/**
 * Customer Login screen
 *
 * @var string $csrf
 * @var array<string, string> $assets
 * @var string|null $error
 * @var string|null $success
 * @var string|null $mobile
 * @var string|null $actionUrl
 * @var string|null $signupUrl
 * @var string|null $registerUrl
 * @var string|null $forgotPasswordUrl
 */
?>

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
                <h2 class="auth-form-heading">
                    Sign In
                </h2>
                <p class="auth-form-subheading">
                    Access your vehicle service history, track repairs, and manage bookings.
                </p>

                <!-- Feedback Messages -->
                <?php if (!empty($error)): ?>
                    <div class="alert-error" role="alert">
                        <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium"><?= htmlspecialchars($error) ?></span>
                    </div>
                <?php endif; ?>

                <?php if (!empty($success)): ?>
                    <div class="alert-success" role="alert">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium"><?= htmlspecialchars($success) ?></span>
                    </div>
                <?php endif; ?>

                <!-- Customer Login Form -->
                <form method="POST" action="<?= htmlspecialchars($actionUrl ?? '/customer/login') ?>" class="space-y-4 sm:space-y-5" id="customer-login-form">
                    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf ?? '') ?>">

                    <!-- Field 1: Mobile Number -->
                    <div class="form-group">
                        <label for="mobile" class="auth-form-label">
                            Mobile Number
                        </label>
                        <input
                            type="tel"
                            id="mobile"
                            name="mobile"
                            required
                            autocomplete="tel"
                            placeholder="07XXXXXXXX"
                            value="<?= htmlspecialchars($old['mobile'] ?? $mobile ?? '') ?>"
                            class="form-input"
                        >
                    </div>

                    <!-- Field 2: Password with Integrated Forgot Password -->
                    <div class="form-group">
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="auth-form-label !mb-0">
                                Password
                            </label>
                            <a href="<?= htmlspecialchars($forgotPasswordUrl ?? '/customer/forgot-password') ?>"
                               class="text-xs font-semibold text-orange-600 hover:text-orange-700 hover:underline transition-colors">
                                Forgot password?
                            </a>
                        </div>
                        <div class="relative flex items-center">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Password"
                                class="form-input-password"
                            >
                            <button
                                type="button"
                                id="toggle-password"
                                aria-label="Toggle password visibility"
                                class="btn-password-toggle">
                                <svg id="eye-icon" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eye-off-icon" class="w-4 h-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Submit CTA Button -->
                    <div class="pt-2 sm:pt-3">
                        <button type="submit" id="submit-login-btn" class="btn-primary">
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            <span>Sign In</span>
                        </button>
                    </div>

                    <!-- Sign Up Switch Prompt -->
                    <div class="auth-switch-prompt">
                        <p>
                            Don't have an account?
                            <a href="<?= htmlspecialchars($registerUrl ?? $signupUrl ?? '/customer/register') ?>" class="auth-switch-link">
                                Sign Up
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Footer: Copyright & Links -->
            <div class="w-full pt-4 sm:pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-500 gap-3">
                <div class="flex items-center gap-5">
                    <a href="<?= htmlspecialchars($contactUrl ?? '#') ?>" class="hover:text-gray-900 transition-colors">Contact Us</a>
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
