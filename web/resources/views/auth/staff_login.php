<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Staff Portal Login - VWMS</title>
    <meta name="description"
        content="Role-Based Access Control (RBAC) internal staff portal for technicians, service advisors, and workshop managers at VWMS.">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">

    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="/assets/index.css">
    <link rel="stylesheet" href="/assets/index.css">

    <style>
        /* Staff Hero Image Override */
        .split-card__visual--staff {
            background: url('../../resources/male-mechanics-working-together-car-shop.jpg') center center / cover no-repeat !important;
        }

        .split-card__visual--staff::before {
            background: linear-gradient(180deg, rgba(13, 19, 31, 0.72) 0%, rgba(13, 19, 31, 0.38) 40%, rgba(13, 19, 31, 0.94) 100%) !important;
        }

        /* Success Animation Toast */
        .auth-toast {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            background: #0D131F;
            color: #FFFFFF;
            padding: 0.85rem 1.25rem;
            border-radius: 12px;
            font-size: 0.82rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.25);
            z-index: 100;
            border: 1px solid #334155;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .auth-toast.show {
            transform: translateY(0);
            opacity: 1;
        }
    </style>
</head>

<body class="split-auth-page">

    <div class="split-layout-wrapper">
        <main class="split-card">

            <!-- ======================================================== -->
            <!-- 1. LEFT COLUMN: VISUAL & BRAND HERO PANEL (~45%)         -->
            <!-- ======================================================== -->
            <aside class="split-card__visual split-card__visual--staff" aria-label="Staff Portal Brand Showcase">
                <!-- Top Header Bar inside Visual Hero -->
                <div class="visual-header">
                    <!-- Brand Logo -->
                    <a href="login.html" class="visual-header__logo" aria-label="VWMS Staff Portal">
                        <div class="visual-header__logo-icon">
                            <svg viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="28" height="28" rx="6" fill="#F05A28" />
                                <!-- Stylized VW Monogram & Workshop Precision Mark -->
                                <path d="M6.5 9.5L11 20H13.2L17 11" stroke="#FFFFFF" stroke-width="2.2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M15 9.5L17.5 15.5L21.5 9.5" stroke="#FFFFFF" stroke-width="2.2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <span class="visual-header__logo-text">VWMS</span>
                    </a>

                    <!-- Portal Badge & Customer Switch Link -->
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <div class="badge badge--portal" style="background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(8px); border: 1px solid rgba(255, 255, 255, 0.2); color: #fff;">
                            <span class="badge__indicator" style="background: #10B981; box-shadow: 0 0 8px #10B981;"></span>
                            <span class="badge__text" style="font-weight: 700; font-size: 11px; letter-spacing: 0.5px;">STAFF PORTAL</span>
                        </div>
                        <a href="../customer/login.html" class="visual-header__btn" style="background: rgba(15, 23, 42, 0.55); border: 1px solid rgba(255, 255, 255, 0.2); color: #fff; padding: 0.35rem 0.7rem; border-radius: 8px; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 0.35rem; text-decoration: none;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            <span>Customer Portal</span>
                        </a>
                    </div>
                </div>

            </aside>

            <!-- ======================================================== -->
            <!-- 2. RIGHT COLUMN: FORM & ACTION PANEL (~55%)              -->
            <!-- ======================================================== -->
            <section class="split-card__form-panel">
                <form action="#" method="POST" class="split-form" id="staffLoginForm" novalidate onsubmit="handleStaffLogin(event)">
                    <!-- CSRF Token -->
                    <input type="hidden" name="csrf_token" value="csrf_token_staff_auth">

                    <!-- SECTION 1: TITLE & ACCESS NOTICE -->
                    <div class="split-form__header" style="margin-bottom: 1.5rem;">
                        <h1 class="split-form__title" style="font-size: 1.75rem; font-weight: 800; color: #0F172A;">Staff Sign In</h1>
                    </div>

                    <!-- SECTION 2: FORM INPUTS (USERNAME & PASSWORD) -->
                    <!-- Field 1: USERNAME -->
                    <div class="form-group" style="margin-bottom: 1.15rem;">
                        <label for="username" class="form-group__label" style="font-weight: 600; font-size: 0.82rem; color: #334155;">
                            Username or Staff ID
                        </label>
                        <div class="form-input">
                            <span class="form-input__icon-left" aria-hidden="true">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </span>
                            <input type="text" id="username" name="username" class="form-input__control"
                                placeholder="e.g. sranatunga or EMP-402" required autocomplete="username" autofocus>
                        </div>
                        <span class="form-group__error" id="usernameError" style="display: none; font-size: 0.75rem; color: #E11D48; margin-top: 0.25rem;">Please enter your staff username or ID.</span>
                    </div>

                    <!-- Field 2: PASSWORD -->
                    <div class="form-group" style="margin-bottom: 1.15rem;">
                        <div class="form-row-between" style="margin: 0 0 0.35rem 0; display: flex; justify-content: space-between; align-items: center;">
                            <label for="password" class="form-group__label" style="font-weight: 600; font-size: 0.82rem; color: #334155; margin: 0;">Password</label>
                            <a href="/staff/reset-password" class="auth-card__forgot-link" style="font-size: 0.8rem; font-weight: 600; color: #F97316; text-decoration: none;">Forgot password?</a>
                        </div>
                        <div class="form-input">
                            <span class="form-input__icon-left" aria-hidden="true">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </span>
                            <input type="password" id="password" name="password" class="form-input__control"
                                placeholder="••••••••••••" required autocomplete="current-password">
                            <button type="button" class="form-input__toggle-password" data-password-toggle="#password"
                                aria-label="Toggle password visibility">
                                <svg class="icon-eye" width="17" height="17" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                        <span class="form-group__error" id="passwordError" style="display: none; font-size: 0.75rem; color: #E11D48; margin-top: 0.25rem;">Please enter your password.</span>
                    </div>

                    <!-- SECTION 3: WORKSTATION REMEMBER ME -->
                    <div class="form-checkbox" style="margin-bottom: 1.25rem;">
                        <label class="form-checkbox__label">
                            <input type="checkbox" name="remember_workstation" value="1" class="form-checkbox__input" checked>
                            <span class="form-checkbox__box">
                                <svg width="11" height="9" viewBox="0 0 12 10" fill="none">
                                    <path d="M1.5 5L4.5 8L10.5 2" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </span>
                            <span class="form-checkbox__text" style="font-size: 0.8rem; color: #475569;">Keep me signed in</span>
                        </label>
                    </div>

                    <!-- SECTION 4: SUBMIT CTA BUTTON -->
                    <button type="submit" class="btn btn--primary btn--block" id="staffSubmitBtn" style="padding: 0.85rem; font-weight: 700; font-size: 0.92rem;">
                        <span id="staffBtnText">Sign In to Staff Portal</span>
                        <svg class="btn__icon-right" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </button>

                    <!-- Customer Portal Switch Card -->
                    <div style="margin-top: 1.5rem; padding: 0.85rem 1rem; border-radius: 12px; background: #F8FAFC; border: 1px dashed #CBD5E1; display: flex; align-items: center; justify-content: space-between; gap: 0.75rem;">
                        <div style="width: 34px; height: 34px; border-radius: 8px; background: #FFF7ED; color: #F05A28; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <div style="flex: 1; display: flex; flex-direction: column; text-align: left; font-size: 0.76rem; line-height: 1.35;">
                            <strong style="color: #0F172A; font-size: 0.81rem;">Looking for Customer Access?</strong>
                            <span style="color: #64748B;">Track repairs, bookings &amp; view digital estimates</span>
                        </div>
                        <a href="../customer/login.html" style="background: #FFFFFF; border: 1px solid #CBD5E1; color: #0F172A; font-size: 0.76rem; font-weight: 700; padding: 0.45rem 0.75rem; border-radius: 8px; text-decoration: none; white-space: nowrap; transition: all 0.15s ease;">
                            Customer Portal &rarr;
                        </a>
                    </div>
                </form>
            </section>

        </main>
    </div>

    <!-- Notification Toast -->
    <div id="authToast" class="auth-toast" role="status" aria-live="polite">
        <svg class="w-5 h-5 text-emerald-400" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2.5">
            <polyline points="20 6 9 17 4 12"></polyline>
        </svg>
        <span id="authToastMessage">Staff authenticated successfully! Redirecting...</span>
    </div>

    <!-- Interactive Client Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Password Visibility Toggle
            document.querySelectorAll('[data-password-toggle]').forEach(button => {
                button.addEventListener('click', () => {
                    const targetSelector = button.getAttribute('data-password-toggle');
                    const input = document.querySelector(targetSelector);
                    if (!input) return;
                    const isPassword = input.getAttribute('type') === 'password';
                    input.setAttribute('type', isPassword ? 'text' : 'password');
                    button.classList.toggle('is-visible', isPassword);
                });
            });
        });

        // Form Submit Handler
        function handleStaffLogin(e) {
            e.preventDefault();
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            const userError = document.getElementById('usernameError');
            const passError = document.getElementById('passwordError');
            const submitBtn = document.getElementById('staffSubmitBtn');
            const btnText = document.getElementById('staffBtnText');

            let isValid = true;

            if (!username) {
                userError.style.display = 'block';
                isValid = false;
            } else {
                userError.style.display = 'none';
            }

            if (!password) {
                passError.style.display = 'block';
                isValid = false;
            } else {
                passError.style.display = 'none';
            }

            if (!isValid) return;

            // Simulate authentication with loading state
            submitBtn.disabled = true;
            btnText.textContent = 'Authenticating Role & Permissions...';

            setTimeout(() => {
                showToast(`Welcome, ${username}! RBAC session established.`);
                setTimeout(() => {
                    const lowerUser = username.toLowerCase();
                    // Route based on RBAC role
                    if (lowerUser.includes('admin') || lowerUser.includes('samantha')) {
                        window.location.href = '../Admin/index.html';
                    } else if (lowerUser.includes('super') || lowerUser.includes('asanka')) {
                        window.location.href = '../Supervisor/index.html';
                    } else if (lowerUser.includes('tech') || lowerUser.includes('dishan')) {
                        window.location.href = '../Technician/index.html';
                    } else {
                        window.location.href = '../Front desk/index.html';
                    }
                }, 1000);
            }, 600);
        }

        function showToast(message) {
            const toast = document.getElementById('authToast');
            const msgEl = document.getElementById('authToastMessage');
            if (toast && msgEl) {
                msgEl.textContent = message;
                toast.classList.add('show');
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 3500);
            }
        }
    </script>
</body>

</html>
