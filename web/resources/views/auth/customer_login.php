<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Customer Portal Sign In - VWMS</title>
    <meta name="description"
        content="Access your vehicle service history, live repair status, and digital invoices on VWMS Customer Portal.">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="/assets/index.css">

    <style>
        /* --------------------------------------------------------------------------
           Portal Switcher & Staff Integration Styles
           -------------------------------------------------------------------------- */
        .portal-segmented-control {
            display: flex;
            background: #F1F5F9;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 4px;
            margin-bottom: 1.5rem;
            gap: 6px;
        }

        .portal-seg-btn {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.6rem 0.9rem;
            border: none;
            border-radius: 9px;
            background: transparent;
            color: #64748B;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            font-family: inherit;
        }

        .portal-seg-btn:hover {
            color: #0F172A;
            background: rgba(255, 255, 255, 0.5);
        }

        .portal-seg-btn.active {
            background: #FFFFFF;
            color: #0F172A;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08), 0 1px 2px rgba(0, 0, 0, 0.04);
            font-weight: 700;
        }

        .portal-seg-btn.active svg {
            stroke: #F05A28;
        }

        .portal-seg-btn.active#segStaffBtn svg {
            stroke: #0F172A;
        }

        .portal-badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #10B981;
            box-shadow: 0 0 6px #10B981;
            display: inline-block;
        }

        .portal-alt-switch {
            margin-top: 1.5rem;
            padding: 0.85rem 1rem;
            border-radius: 12px;
            background: #F8FAFC;
            border: 1px dashed #CBD5E1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
        }

        .portal-alt-switch__icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: #EDE9FE;
            color: #7C3AED;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .portal-alt-switch--customer .portal-alt-switch__icon {
            background: #FFF7ED;
            color: #F05A28;
        }

        .portal-alt-switch__text {
            flex: 1;
            display: flex;
            flex-direction: column;
            text-align: left;
            font-size: 0.76rem;
            line-height: 1.35;
        }

        .portal-alt-switch__text strong {
            color: #0F172A;
            font-size: 0.81rem;
        }

        .portal-alt-switch__text span {
            color: #64748B;
        }

        .portal-alt-switch__btn {
            background: #FFFFFF;
            border: 1px solid #CBD5E1;
            color: #0F172A;
            font-size: 0.76rem;
            font-weight: 700;
            padding: 0.45rem 0.75rem;
            border-radius: 8px;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.15s ease;
            font-family: inherit;
        }

        .portal-alt-switch__btn:hover {
            background: #0F172A;
            color: #FFFFFF;
            border-color: #0F172A;
        }

        /* Customer Hero Visual State */
        .split-card__visual {
            background: url('../../resources/car.jpg') center center / cover no-repeat !important;
        }

        .split-card__visual::before {
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.58) 0%, rgba(15, 23, 42, 0.28) 40%, rgba(15, 23, 42, 0.88) 100%) !important;
        }

        /* Staff Hero Visual State */
        .split-card__visual--staff {
            background: url('../../resources/male-mechanics-working-together-car-shop.jpg') center center / cover no-repeat !important;
        }

        .split-card__visual--staff::before {
            background: linear-gradient(180deg, rgba(13, 19, 31, 0.78) 0%, rgba(13, 19, 31, 0.45) 40%, rgba(13, 19, 31, 0.95) 100%) !important;
        }

        /* Visual Header Portal Badge */
        .visual-header__portal-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #FFFFFF;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .visual-header__portal-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #10B981;
            box-shadow: 0 0 6px #10B981;
        }

        /* Toast */
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
            <aside class="split-card__visual" id="visualHero" aria-label="Brand showcase">
                <!-- Top Header Bar inside Visual Hero -->
                <div class="visual-header">
                    <!-- Brand Logo -->
                    <a href="login.html" class="visual-header__logo" aria-label="VWMS Homepage">
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

                    <!-- Portal Badge (Shown when Staff is active) -->
                    <div id="heroStaffBadge" class="visual-header__portal-badge" style="display: none;">
                        <span class="dot"></span>
                        <span>STAFF PORTAL</span>
                    </div>

                </div>

                <!-- Bottom Alignment Block: Pagination Indicators -->
                <div class="visual-bottom">
                    <!-- Carousel Pagination Indicators -->
                    <div class="visual-bottom__pagination" aria-label="Carousel pagination" role="tablist">
                        <span class="pagination-dash active" aria-label="Slide 1"></span>
                        <span class="pagination-dash" aria-label="Slide 2"></span>
                        <span class="pagination-dash" aria-label="Slide 3"></span>
                    </div>
                </div>
            </aside>

            <!-- ======================================================== -->
            <!-- 2. RIGHT COLUMN: FORM & ACTION PANEL (~55%)              -->
            <!-- ======================================================== -->
            <section class="split-card__form-panel">

                <!-- PORTAL SEGMENTED TOGGLE (CUSTOMER vs STAFF) -->
                <div class="portal-segmented-control" role="tablist" aria-label="Portal Selection">
                    <button type="button" class="portal-seg-btn active" id="segCustomerBtn" onclick="switchPortal('customer')">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span>Customer Portal</span>
                    </button>
                    <button type="button" class="portal-seg-btn" id="segStaffBtn" onclick="switchPortal('staff')">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                        </svg>
                        <span>Staff Sign In</span>
                        <span class="portal-badge-dot" title="Workshop Terminal Access"></span>
                    </button>
                </div>

                <!-- ==================================================== -->
                <!-- VIEW A: CUSTOMER AUTH FORM (LOGIN & REGISTER)        -->
                <!-- ==================================================== -->
                <div id="customerPortalView">
                    <form action="otp-verify.html" method="POST" class="split-form" id="authForm" novalidate>
                        <!-- CSRF Token -->
                        <input type="hidden" name="csrf_token" value="csrf_token_placeholder">

                        <!-- SECTION 1: TITLE & NAVIGATION LINK -->
                        <div class="split-form__header">
                            <h1 class="split-form__title" id="formTitle">Welcome back</h1>
                            <p class="split-form__subtitle" id="formSubtitle">
                                Don't have an account yet?
                                <a href="login.html?mode=register" class="split-form__link" id="authToggleLink">Sign up</a>
                            </p>
                        </div>

                        <!-- SECTION 2: FORM INPUTS -->
                        <!-- Row 1: 2-Column Names (Active in Register Mode) -->
                        <div class="form-row-grid" id="nameRow" style="display: none;">
                            <div class="form-group">
                                <label for="firstName" class="form-group__label">First Name</label>
                                <div class="form-input">
                                    <span class="form-input__icon-left" aria-hidden="true">
                                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                    </span>
                                    <input type="text" id="firstName" name="first_name" class="form-input__control"
                                        placeholder="Marcus" autocomplete="given-name">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="lastName" class="form-group__label">Last Name</label>
                                <div class="form-input">
                                    <span class="form-input__icon-left" aria-hidden="true">
                                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                    </span>
                                    <input type="text" id="lastName" name="last_name" class="form-input__control"
                                        placeholder="Vance" autocomplete="family-name">
                                </div>
                            </div>
                        </div>

                        <!-- Row 2: Email / Username -->
                        <div class="form-group">
                            <label for="email" class="form-group__label" id="emailLabel">Username or Email</label>
                            <div class="form-input">
                                <span class="form-input__icon-left" aria-hidden="true">
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="4"></circle>
                                        <path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path>
                                    </svg>
                                </span>
                                <input type="email" id="email" name="email" class="form-input__control"
                                    placeholder="marcus.vance@example.com" required autocomplete="email" autofocus>
                            </div>
                        </div>

                        <!-- Row 3: Password -->
                        <div class="form-group">
                            <div class="form-row-between" style="margin: 0 0 0.25rem 0;">
                                <label for="password" class="form-group__label">Password</label>
                                <a href="/forgot-password" class="auth-card__forgot-link" id="forgotLink">Forgot password?</a>
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
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- SECTION 3: AGREEMENTS & ACTIONS -->
                        <!-- Checkbox Row: Terms (Active in Register Mode) -->
                        <div class="form-checkbox" id="termsRow" style="display: none;">
                            <label class="form-checkbox__label">
                                <input type="checkbox" name="agree_terms" value="1" class="form-checkbox__input" checked>
                                <span class="form-checkbox__box">
                                    <svg width="11" height="9" viewBox="0 0 12 10" fill="none">
                                        <path d="M1.5 5L4.5 8L10.5 2" stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span class="form-checkbox__text">
                                    I agree to the <a href="/terms" class="form-checkbox__link">Terms &amp; Conditions</a>
                                    and <a href="/privacy" class="form-checkbox__link">Privacy Policy</a>
                                </span>
                            </label>
                        </div>

                        <!-- Checkbox Row: Remember Me (Active in Login Mode) -->
                        <div class="form-checkbox" id="rememberRow">
                            <label class="form-checkbox__label">
                                <input type="checkbox" name="remember_me" value="1" class="form-checkbox__input" checked>
                                <span class="form-checkbox__box">
                                    <svg width="11" height="9" viewBox="0 0 12 10" fill="none">
                                        <path d="M1.5 5L4.5 8L10.5 2" stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span class="form-checkbox__text">Keep me signed in</span>
                            </label>
                        </div>

                        <!-- Primary CTA Button -->
                        <button type="submit" class="btn btn--primary btn--block" id="submitBtn">
                            <span id="submitBtnText">Sign In</span>
                            <svg class="btn__icon-right" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </button>
                    </form>

                    <!-- Staff Switch Helper Box -->
                    <div class="portal-alt-switch">
                        <div class="portal-alt-switch__icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                            </svg>
                        </div>
                        <div class="portal-alt-switch__text">
                            <strong>Workshop Staff Member?</strong>
                            <span>Access technician terminals, job cards &amp; admin tools</span>
                        </div>
                        <button type="button" class="portal-alt-switch__btn" onclick="switchPortal('staff')">
                            Staff Sign In &rarr;
                        </button>
                    </div>
                </div>

                <!-- ==================================================== -->
                <!-- VIEW B: STAFF PORTAL LOGIN FORM                      -->
                <!-- ==================================================== -->
                <div id="staffPortalView" style="display: none;">
                    <form action="#" method="POST" class="split-form" id="staffLoginForm" novalidate onsubmit="handleStaffLogin(event)">
                        <!-- CSRF Token -->
                        <input type="hidden" name="csrf_token" value="csrf_token_staff_auth">

                        <!-- SECTION 1: TITLE & ACCESS NOTICE -->
                        <div class="split-form__header" style="margin-bottom: 1.5rem;">
                            <h1 class="split-form__title" style="color: #0F172A;">Staff Sign In</h1>
                        </div>

                        <!-- SECTION 2: FORM INPUTS (USERNAME & PASSWORD) -->
                        <div class="form-group">
                            <label for="staffUsername" class="form-group__label">Username or Staff ID</label>
                            <div class="form-input">
                                <span class="form-input__icon-left" aria-hidden="true">
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                </span>
                                <input type="text" id="staffUsername" name="username" class="form-input__control"
                                    placeholder="e.g. sranatunga or EMP-402" required autocomplete="username">
                            </div>
                            <span class="form-group__error" id="staffUsernameError" style="display: none; font-size: 0.75rem; color: #E11D48; margin-top: 0.25rem;">Please enter your staff username or ID.</span>
                        </div>

                        <div class="form-group">
                            <div class="form-row-between" style="margin: 0 0 0.25rem 0;">
                                <label for="staffPassword" class="form-group__label">Password</label>
                                <a href="../staff login/reset-password.html" class="auth-card__forgot-link" style="color: #F05A28;">Forgot password?</a>
                            </div>
                            <div class="form-input">
                                <span class="form-input__icon-left" aria-hidden="true">
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                </span>
                                <input type="password" id="staffPassword" name="password" class="form-input__control"
                                    placeholder="••••••••••••" required autocomplete="current-password">
                                <button type="button" class="form-input__toggle-password" data-password-toggle="#staffPassword"
                                    aria-label="Toggle password visibility">
                                    <svg class="icon-eye" width="17" height="17" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                            <span class="form-group__error" id="staffPasswordError" style="display: none; font-size: 0.75rem; color: #E11D48; margin-top: 0.25rem;">Please enter your password.</span>
                        </div>

                        <!-- Checkbox: Shift Session -->
                        <div class="form-checkbox">
                            <label class="form-checkbox__label">
                                <input type="checkbox" name="remember_workstation" value="1" class="form-checkbox__input" checked>
                                <span class="form-checkbox__box">
                                    <svg width="11" height="9" viewBox="0 0 12 10" fill="none">
                                        <path d="M1.5 5L4.5 8L10.5 2" stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span class="form-checkbox__text">Keep me signed in</span>
                            </label>
                        </div>

                        <!-- Primary CTA Button -->
                        <button type="submit" class="btn btn--primary btn--block" id="staffSubmitBtn" style="background: #0F172A; border-color: #0F172A;">
                            <span id="staffBtnText">Sign In to Staff Portal</span>
                            <svg class="btn__icon-right" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </button>
                    </form>

                    <!-- Customer Return Helper Box -->
                    <div class="portal-alt-switch portal-alt-switch--customer">
                        <div class="portal-alt-switch__icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <div class="portal-alt-switch__text">
                            <strong>Are you a Customer?</strong>
                            <span>Track vehicle repair status, job diagnostics &amp; invoices</span>
                        </div>
                        <button type="button" class="portal-alt-switch__btn" onclick="switchPortal('customer')">
                            Customer Portal &rarr;
                        </button>
                    </div>
                </div>

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
        window.currentCustomerMode = 'login'; // 'login' or 'register'
        window.currentPortal = 'customer';    // 'customer' or 'staff'

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

            // Parse URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const portalParam = urlParams.get('portal') || (urlParams.get('role') === 'staff' ? 'staff' : null) || (urlParams.get('staff') === 'true' ? 'staff' : null);
            const modeParam = urlParams.get('mode');

            if (modeParam === 'register') {
                window.currentCustomerMode = 'register';
                applyCustomerMode(false, false);
            } else {
                window.currentCustomerMode = 'login';
                applyCustomerMode(true, false);
            }

            if (portalParam === 'staff') {
                switchPortal('staff', false);
            } else {
                switchPortal('customer', false);
            }

            // Support Browser Back/Forward buttons
            window.addEventListener('popstate', (e) => {
                const params = new URLSearchParams(window.location.search);
                const p = params.get('portal');
                const m = params.get('mode');
                if (m === 'register') {
                    applyCustomerMode(false, false);
                } else {
                    applyCustomerMode(true, false);
                }
                switchPortal(p === 'staff' ? 'staff' : 'customer', false);
            });
        });

        // Switch between Customer Portal and Staff Portal
        function switchPortal(portalName, updateUrl = true) {
            window.currentPortal = portalName;
            const isStaff = portalName === 'staff';
            const customerView = document.getElementById('customerPortalView');
            const staffView = document.getElementById('staffPortalView');
            const segCustomer = document.getElementById('segCustomerBtn');
            const segStaff = document.getElementById('segStaffBtn');
            const visualHero = document.getElementById('visualHero');
            const staffBadge = document.getElementById('heroStaffBadge');

            if (isStaff) {
                customerView.style.display = 'none';
                staffView.style.display = 'block';
                segCustomer.classList.remove('active');
                segStaff.classList.add('active');
                visualHero.classList.add('split-card__visual--staff');
                if (staffBadge) staffBadge.style.display = 'inline-flex';
                document.title = 'Staff Portal Sign In - VWMS';

                if (updateUrl) {
                    const url = new URL(window.location);
                    url.searchParams.set('portal', 'staff');
                    url.searchParams.delete('mode');
                    window.history.pushState({ portal: 'staff' }, '', url);
                }

                const userInp = document.getElementById('staffUsername');
                if (userInp) setTimeout(() => userInp.focus(), 60);
            } else {
                staffView.style.display = 'none';
                customerView.style.display = 'block';
                segStaff.classList.remove('active');
                segCustomer.classList.add('active');
                visualHero.classList.remove('split-card__visual--staff');
                if (staffBadge) staffBadge.style.display = 'none';
                document.title = (window.currentCustomerMode === 'register') ? 'Create an account - VWMS' : 'Customer Portal Sign In - VWMS';

                if (updateUrl) {
                    const url = new URL(window.location);
                    url.searchParams.delete('portal');
                    if (window.currentCustomerMode === 'register') {
                        url.searchParams.set('mode', 'register');
                    } else {
                        url.searchParams.delete('mode');
                    }
                    window.history.pushState({ portal: 'customer' }, '', url);
                }
            }
        }

        // Apply Customer Mode (Login vs Register)
        function applyCustomerMode(isLogin, updateUrl = true) {
            window.currentCustomerMode = isLogin ? 'login' : 'register';
            const formTitle = document.getElementById('formTitle');
            const formSubtitle = document.getElementById('formSubtitle');
            const nameRow = document.getElementById('nameRow');
            const emailLabel = document.getElementById('emailLabel');
            const emailInput = document.getElementById('email');
            const forgotLink = document.getElementById('forgotLink');
            const termsRow = document.getElementById('termsRow');
            const rememberRow = document.getElementById('rememberRow');
            const submitBtnText = document.getElementById('submitBtnText');
            const authForm = document.getElementById('authForm');

            if (isLogin) {
                if (window.currentPortal === 'customer') document.title = 'Customer Portal Sign In - VWMS';
                formTitle.textContent = 'Welcome back';
                formSubtitle.innerHTML = `Don't have an account yet? <a href="login.html?mode=register" class="split-form__link" id="authToggleLink">Sign up</a>`;
                nameRow.style.display = 'none';
                emailLabel.textContent = 'Username or Email';
                emailInput.placeholder = 'marcus.vance@example.com';
                forgotLink.style.display = 'inline';
                termsRow.style.display = 'none';
                rememberRow.style.display = 'flex';
                submitBtnText.textContent = 'Sign In';
                authForm.action = 'dashboard.html';
            } else {
                if (window.currentPortal === 'customer') document.title = 'Create an account - VWMS';
                formTitle.textContent = 'Create an account';
                formSubtitle.innerHTML = `Already have an account? <a href="login.html?mode=login" class="split-form__link" id="authToggleLink">Log in</a>`;
                nameRow.style.display = 'grid';
                emailLabel.textContent = 'Email';
                emailInput.placeholder = 'marcus.vance@example.com';
                forgotLink.style.display = 'none';
                termsRow.style.display = 'block';
                rememberRow.style.display = 'none';
                submitBtnText.textContent = 'Create account';
                authForm.action = 'otp-verify.html';
            }

            if (updateUrl && window.currentPortal === 'customer') {
                const url = new URL(window.location);
                if (isLogin) {
                    url.searchParams.delete('mode');
                } else {
                    url.searchParams.set('mode', 'register');
                }
                window.history.pushState({ mode: isLogin ? 'login' : 'register' }, '', url);
            }

            // Re-bind inline toggle click
            const newToggle = document.getElementById('authToggleLink');
            if (newToggle) {
                newToggle.addEventListener('click', (e) => {
                    e.preventDefault();
                    applyCustomerMode(!isLogin, true);
                });
            }
        }

        // Staff Sign In Handler with RBAC Session Routing
        function handleStaffLogin(e) {
            e.preventDefault();
            const username = document.getElementById('staffUsername').value.trim();
            const password = document.getElementById('staffPassword').value.trim();
            const userError = document.getElementById('staffUsernameError');
            const passError = document.getElementById('staffPasswordError');
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

            submitBtn.disabled = true;
            btnText.textContent = 'Authenticating Role & Terminal...';

            setTimeout(() => {
                showToast(`Welcome, ${username}! RBAC staff session established.`);
                setTimeout(() => {
                    const lowerUser = username.toLowerCase();
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