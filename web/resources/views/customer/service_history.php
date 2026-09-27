<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Service History - VWMS Customer Portal</title>
    <meta name="description"
        content="Comprehensive logs, replaced OEM parts, and certified technician records for all garage vehicles on VWMS Customer Portal.">

    <!-- Google Fonts: Inter & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            orange: '#F97316',
                            'orange-hover': '#EA580C',
                            'orange-light': '#FFF7ED',
                            'orange-border': '#FFEDD5',
                        },
                        navy: {
                            sidebar: '#0D131F',
                            surface: '#111827',
                            highlight: '#1E293B',
                            hover: '#182133',
                        },
                        slate: {
                            heading: '#0F172A',
                            body: '#64748B',
                            subtle: '#94A3B8',
                            border: '#E2E8F0',
                            bg: '#F8FAFC',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    boxShadow: {
                        'soft': '0 1px 3px 0 rgba(0, 0, 0, 0.04), 0 1px 2px 0 rgba(0, 0, 0, 0.02)',
                        'card': '0 1px 3px 0 rgba(15, 23, 42, 0.05)',
                        'modal': '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
                    }
                }
            }
        }
    </script>

    <!-- Custom Micro-styling & Keyframes -->
    <style>
        * {
            -webkit-font-smoothing: antialiased;
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 9999px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94A3B8;
        }

        @keyframes pulseDot {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0.4;
                transform: scale(0.85);
            }
        }

        .pulse-active {
            animation: pulseDot 2s infinite ease-in-out;
        }
    </style>
</head>

<body
    class="bg-[#F8FAFC] text-slate-700 font-sans min-h-screen flex flex-col antialiased selection:bg-orange-500 selection:text-white">

    <!-- ======================================================== -->
    <!-- 1. BACKDROP OVERLAY FOR MOBILE SIDEBAR DRAWER            -->
    <!-- ======================================================== -->
    <div id="sidebarBackdrop"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 hidden transition-opacity duration-300 lg:hidden"
        onclick="toggleMobileSidebar(false)"></div>

    <div class="flex-1 flex min-h-screen">

        <!-- ======================================================== -->
        <!-- 2. DESKTOP & MOBILE DRAWER SIDEBAR                       -->
        <!-- ======================================================== -->
        <aside id="sidebar"
            class="fixed top-0 bottom-0 left-0 w-64 lg:w-[260px] bg-[#0D131F] text-white z-50 flex flex-col justify-between transition-transform duration-300 -translate-x-full lg:translate-x-0 lg:static lg:z-auto">

            <!-- Top Section: Brand Logo & Navigation -->
            <div class="flex flex-col">
                <!-- Brand Header -->
                <div class="px-6 py-6 border-b border-slate-800/60 flex items-center justify-between">
                    <a href="/customer/dashboard" class="flex items-center gap-3 group">
                        <!-- Orange Brand Icon -->
                        <div
                            class="w-9 h-9 rounded-xl bg-orange-500 flex items-center justify-center shadow-lg shadow-orange-500/25 group-hover:scale-105 transition-transform duration-200">
                            <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path
                                    d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                </path>
                            </svg>
                        </div>
                        <!-- Logo Typography -->
                        <div class="flex flex-col">
                            <span class="text-white font-bold text-base tracking-tight leading-none">VWMS</span>
                            <span
                                class="text-[10px] text-slate-400 font-semibold tracking-wider uppercase mt-1 leading-none">CUSTOMER
                                PORTAL</span>
                        </div>
                    </a>

                    <!-- Close Button on Mobile Drawer -->
                    <button type="button" class="lg:hidden text-slate-400 hover:text-white p-1"
                        onclick="toggleMobileSidebar(false)">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Navigation Links List -->
                <nav class="px-4 py-5 space-y-1" aria-label="Customer Navigation">
                    <!-- Category Header -->
                    <div class="px-3 pb-2 text-[11px] font-semibold text-slate-400 tracking-wider uppercase">
                        OPERATIONS
                    </div>

                    <!-- 1. Overview -->
                    <a href="/customer/dashboard"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/40 font-medium text-sm transition-colors duration-150">
                        <svg class="w-5 h-5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7" rx="1.5"></rect>
                            <rect x="14" y="3" width="7" height="7" rx="1.5"></rect>
                            <rect x="14" y="14" width="7" height="7" rx="1.5"></rect>
                            <rect x="3" y="14" width="7" height="7" rx="1.5"></rect>
                        </svg>
                        <span>Overview</span>
                    </a>

                    <!-- 2. My Vehicles -->
                    <a href="/customer/vehicles"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/40 font-medium text-sm transition-colors duration-150">
                        <svg class="w-5 h-5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M14 16H9m10 0h3v-3.15a1 1 0 0 0-.84-.99L16 11l-2.7-3.6a1 1 0 0 0-.8-.4H8.5a1 1 0 0 0-.8.4L5 11l-5.16.86a1 1 0 0 0-.84.99V16h3">
                            </path>
                            <circle cx="6.5" cy="16.5" r="2.5"></circle>
                            <circle cx="16.5" cy="16.5" r="2.5"></circle>
                        </svg>
                        <span>My Vehicles</span>
                    </a>

                    <!-- 3. Appointments -->
                    <a href="/customer/appointments"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/40 font-medium text-sm transition-colors duration-150">
                        <svg class="w-5 h-5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span>Appointments</span>
                    </a>

                    <!-- 4. Service History (ACTIVE) -->
                    <a href="/customer/service-history"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-white/5 text-orange-500 font-medium text-sm transition-all duration-150 relative group">
                        <!-- Active Indicator Glow -->
                        <span
                            class="w-1.5 h-4 bg-orange-500 rounded-full absolute left-0 top-1/2 -translate-y-1/2 shadow-[0_0_8px_#F97316]"></span>
                        <svg class="w-5 h-5 text-orange-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span>Service History</span>
                    </a>

                    <!-- 5. Invoices -->
                    <a href="dashboard.html#invoices"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/40 font-medium text-sm transition-colors duration-150">
                        <svg class="w-5 h-5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        <span>Invoices</span>
                    </a>

                    <!-- 6. Profile -->
                    <a href="/customer/profile"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/40 font-medium text-sm transition-colors duration-150">
                        <svg class="w-5 h-5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span>Profile</span>
                    </a>
                </nav>
            </div>

            <!-- Bottom Support / Sign Out Link -->
            <div class="p-4 border-t border-slate-800/60">
                <a href="/login"
                    class="flex items-center gap-3 px-3 py-2 text-xs text-slate-400 hover:text-white rounded-lg hover:bg-slate-800/30 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    <span>Log Out of Portal</span>
                </a>
            </div>
        </aside>

        <!-- ======================================================== -->
        <!-- MAIN CONTENT AREA                                        -->
        <!-- ======================================================== -->
        <div class="flex-1 flex flex-col min-w-0">

            <!-- Top Header Utility Bar -->
            <header
                class="bg-white border-b border-slate-200 sticky top-0 z-30 px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between gap-4">

                <!-- Left: Mobile Toggle & Breadcrumbs -->
                <div class="flex items-center gap-3 sm:gap-4 min-w-0">
                    <!-- Hamburger button on Mobile -->
                    <button type="button"
                        class="lg:hidden p-1.5 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors"
                        onclick="toggleMobileSidebar(true)" aria-label="Open navigation menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <!-- Breadcrumbs -->
                    <nav class="flex items-center text-sm font-medium text-slate-500 whitespace-nowrap">
                        <a href="/customer/dashboard" class="hover:text-slate-700 transition-colors">Dashboard</a>
                        <svg class="w-4 h-4 mx-2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                        <span class="text-slate-900 font-semibold">Service History</span>
                    </nav>
                </div>

                <!-- Center / Right: Live Status Badge & Notifications & Profile -->
                <div class="flex items-center gap-2 sm:gap-4 shrink-0">

                    <!-- Notification Bell -->
                    <button type="button"
                        class="p-2 rounded-lg text-slate-500 hover:text-slate-800 hover:bg-slate-100 relative transition-colors"
                        aria-label="View notifications">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-orange-500 rounded-full ring-2 ring-white"></span>
                    </button>

                    <!-- Client Profile Badge & Dropdown -->
                    <div class="relative">
                        <button type="button" id="profileDropdownBtn" onclick="toggleProfileDropdown()"
                            class="flex items-center gap-2.5 pl-1 sm:pl-2 cursor-pointer group focus:outline-none">
                            <div class="relative">
                                <div
                                    class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[#9A3412] text-white flex items-center justify-center font-bold text-xs sm:text-sm shadow-sm overflow-hidden">
                                    <span>KP</span>
                                </div>
                                <span
                                    class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-white rounded-full"></span>
                            </div>

                            <div class="hidden sm:flex flex-col text-left leading-tight">
                                <span
                                    class="text-sm font-semibold text-slate-900 group-hover:text-orange-600 transition-colors">Kasun</span>
                                <span class="text-[11px] text-slate-400 font-medium">Client</span>
                            </div>

                            <svg class="hidden sm:block w-3.5 h-3.5 text-slate-400 group-hover:text-slate-600 transition-transform group-hover:translate-y-0.5"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Profile Dropdown Menu -->
                        <div id="profileMenu"
                            class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-slate-100 py-1.5 z-50 text-xs">
                            <div class="px-4 py-2.5 border-b border-slate-100">
                                <p class="font-semibold text-slate-900">Kasun Perera</p>
                                <p class="text-slate-400 truncate">kasun.perera@gmail.com</p>
                            </div>
                            <a href="/customer/profile"
                                class="flex items-center gap-2.5 px-4 py-2 text-slate-700 hover:bg-slate-50 transition-colors">
                                <svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <span>Profile Settings</span>
                            </a>
                            <a href="/customer/appointments"
                                class="flex items-center gap-2.5 px-4 py-2 text-slate-700 hover:bg-slate-50 transition-colors">
                                <svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                </svg>
                                <span>Active Bookings</span>
                            </a>
                            <div class="border-t border-slate-100 my-1"></div>
                            <a href="/login"
                                class="flex items-center gap-2.5 px-4 py-2 text-red-600 hover:bg-red-50 transition-colors font-medium">
                                <svg class="w-4 h-4 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                <span>Sign Out</span>
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Page Content -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto space-y-6">

                <!-- ======================================================== -->
                <!-- 1. HEADER SECTION & PRIMARY ACTION                       -->
                <!-- ======================================================== -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                            Service History
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">
                            Comprehensive logs, replaced OEM parts, and certified technician records for all garage vehicles.
                        </p>
                    </div>

                    <!-- Book Service Button -->
                    <button type="button" onclick="openBookingModal('General Fleet Booking')"
                        class="inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-2.5 rounded-lg bg-orange-500 hover:bg-orange-600 active:translate-y-0.5 text-white font-semibold text-xs sm:text-sm shadow-sm hover:shadow transition-all shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        <span>Book Service</span>
                    </button>
                </div>

                <!-- ======================================================== -->
                <!-- 2. METRICS STAT BAR (3 SUMMARY CARDS)                    -->
                <!-- ======================================================== -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-5">

                    <!-- Stat 1: Total Services Completed -->
                    <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/80 shadow-card flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                                    TOTAL SERVICES COMPLETED
                                </span>
                                <!-- Verified Checkmark Seal Badge -->
                                <div class="w-10 h-10 rounded-xl bg-emerald-100/80 text-emerald-600 flex items-center justify-center">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                        <polyline points="9 12 11 14 15 10"></polyline>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex items-baseline gap-1.5 mt-2">
                                <span class="text-3xl font-extrabold text-slate-900 tracking-tight">14</span>
                                <span class="text-sm font-medium text-slate-500">Records</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center gap-1.5 text-xs font-semibold text-emerald-600">
                            <svg class="w-4 h-4 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            <span>All records verified &amp; archived</span>
                        </div>
                    </div>

                    <!-- Stat 2: Lifetime Maintenance Spend -->
                    <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/80 shadow-card flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                                    LIFETIME MAINTENANCE SPEND
                                </span>
                                <!-- Banknote / Currency Badge -->
                                <div class="w-10 h-10 rounded-xl bg-orange-100/80 text-orange-600 flex items-center justify-center">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="2" y="6" width="20" height="12" rx="2"></rect>
                                        <circle cx="12" cy="12" r="2"></circle>
                                        <path d="M6 12h.01M18 12h.01"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex items-baseline gap-1.5 mt-2">
                                <span class="text-xs font-bold text-slate-500 font-mono">LKR</span>
                                <span class="text-3xl font-extrabold text-slate-900 tracking-tight">482,500</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center gap-1.5 text-xs font-semibold text-amber-600">
                            <svg class="w-4 h-4 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                            </svg>
                            <span>Across 3 registered fleet vehicles</span>
                        </div>
                    </div>

                    <!-- Stat 3: Last Serviced -->
                    <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/80 shadow-card flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                                    LAST SERVICED
                                </span>
                                <!-- Calendar Badge -->
                                <div class="w-10 h-10 rounded-xl bg-blue-100/80 text-blue-600 flex items-center justify-center">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Sep 01, 2026</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center gap-1.5 text-xs font-semibold text-blue-600">
                            <svg class="w-4 h-4 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                            </svg>
                            <span>Brake Replacement - Honda Fit</span>
                        </div>
                    </div>

                </div>

                <!-- ======================================================== -->
                <!-- 3. SEARCH & ADVANCED FILTER BAR                          -->
                <!-- ======================================================== -->
                <div class="bg-white rounded-2xl p-3 sm:p-4 border border-slate-200/80 shadow-soft flex flex-col md:flex-row items-stretch md:items-center gap-3">

                    <!-- Search Input Field -->
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </span>
                        <input type="text" id="historySearchInput" onkeyup="filterHistoryRecords()"
                            placeholder="Filter by plate, job card or parts..."
                            class="w-full pl-10 pr-4 py-2 text-xs sm:text-sm bg-white border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/10 transition-all">
                    </div>

                    <!-- Vehicle Dropdown Filter -->
                    <div class="w-full md:w-56">
                        <div class="relative">
                            <select id="vehicleFilterSelect" onchange="filterHistoryRecords()"
                                class="w-full appearance-none pl-3.5 pr-9 py-2 text-xs sm:text-sm bg-white border border-slate-200 rounded-xl text-slate-800 font-medium focus:outline-none focus:border-orange-500 cursor-pointer transition-all">
                                <option value="all">All Vehicles (3)</option>
                                <option value="NW WP-9876">2015 Honda Fit (NW WP-9876)</option>
                                <option value="WP CBA-4321">2018 Toyota Axio (WP CBA-4321)</option>
                                <option value="WP CAB-7892">2021 Land Cruiser Prado (WP CAB-7892)</option>
                            </select>
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </span>
                        </div>
                    </div>

                    <!-- Date Filter Selector -->
                    <div class="w-full md:w-48">
                        <div class="relative">
                            <select id="dateRangeSelect" onchange="filterHistoryRecords()"
                                class="w-full appearance-none pl-3.5 pr-9 py-2 text-xs sm:text-sm bg-white border border-slate-200 rounded-xl text-slate-800 font-medium focus:outline-none focus:border-orange-500 cursor-pointer transition-all">
                                <option value="all">All-Time Records</option>
                                <option value="2026">Year 2026</option>
                                <option value="2025">Year 2025</option>
                                <option value="last6m">Last 6 Months</option>
                            </select>
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </span>
                        </div>
                    </div>

                </div>

                <!-- ======================================================== -->
                <!-- 4. SERVICE HISTORY TABLE CONTAINER                       -->
                <!-- ======================================================== -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-card overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse min-w-[760px]" id="serviceHistoryTable">
                            <thead>
                                <tr class="border-b border-slate-100 bg-white">
                                    <th class="py-4 px-6 text-[11px] font-semibold text-slate-400 uppercase tracking-wider w-[22%]">
                                        DATE
                                    </th>
                                    <th class="py-4 px-6 text-[11px] font-semibold text-slate-400 uppercase tracking-wider w-[32%]">
                                        VEHICLE
                                    </th>
                                    <th class="py-4 px-6 text-[11px] font-semibold text-slate-400 uppercase tracking-wider w-[30%]">
                                        PRIMARY MECHANIC
                                    </th>
                                    <th class="py-4 px-6 text-[11px] font-semibold text-slate-400 uppercase tracking-wider text-right w-[16%]">
                                        TOTAL COST
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm" id="historyTableBody">

                                <!-- ROW 1: 2015 Honda Fit (Sep 01, 2026) -->
                                <tr class="history-row hover:bg-slate-50/75 transition-colors cursor-pointer"
                                    onclick="openJobCardModal('JC-2026-8902', 'Sep 01, 2026', '2015 Honda Fit', 'NW WP-9876', 'Dishan Karunaratne', 'Master Brake Specialist', 'LKR 38,500.00', ['Front Ceramic Brake Pads (OEM)', 'Dot 4 High-Temp Fluid Flush'], 'Full brake pads renewal and bleeding. Tested under dynamic load on brake dyno.')"
                                    data-search="sep 01 2026 2015 honda fit nw wp-9876 hybrid dishan karunaratne front ceramic brake pads dot 4 fluid flush 38500"
                                    data-vehicle="NW WP-9876" data-year="2026">
                                    <!-- Date -->
                                    <td class="py-5 px-6 align-top">
                                        <div class="font-bold text-slate-900">Sep 01, 2026</div>
                                        <div class="text-xs text-slate-400 font-medium mt-0.5">10:30 AM</div>
                                    </td>

                                    <!-- Vehicle -->
                                    <td class="py-5 px-6 align-top">
                                        <div class="font-bold text-slate-900">2015 Honda Fit</div>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-800 font-mono text-xs font-semibold border border-slate-200">
                                                NW WP-9876
                                            </span>
                                            <span class="text-xs text-slate-400 font-medium">1.5L Hybrid</span>
                                        </div>
                                    </td>

                                    <!-- Primary Mechanic -->
                                    <td class="py-5 px-6 align-top">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-slate-900 text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-xs">
                                                DK
                                            </div>
                                            <div>
                                                <div class="font-semibold text-slate-900">Dishan Karunaratne</div>
                                                <div class="text-xs text-slate-400 font-medium mt-0.5">Master Brake Specialist</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Total Cost -->
                                    <td class="py-5 px-6 align-top text-right">
                                        <div class="font-bold text-slate-900 text-sm whitespace-nowrap">LKR 38,500.00</div>
                                        <div class="mt-1">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                                <svg class="w-3 h-3 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                                <span>Paid</span>
                                            </span>
                                        </div>
                                    </td>
                                </tr>

                                <!-- ROW 2: 2018 Toyota Axio (Jun 14, 2026) -->
                                <tr class="history-row hover:bg-slate-50/75 transition-colors cursor-pointer"
                                    onclick="openJobCardModal('JC-2026-6140', 'Jun 14, 2026', '2018 Toyota Axio', 'WP CBA-4321', 'Sahan Nimesh', 'Senior Powertrain Tech', 'LKR 24,800.00', ['0W-20 Synthetic Oil (4L)', 'Oil Filter', 'Engine Air Filter'], 'Periodic oil service and multi-point health check completed. Hybrid inverter cooling checked.')"
                                    data-search="jun 14 2026 2018 toyota axio wp cba-4321 hybrid sahan nimesh 0w-20 synthetic oil filter engine air filter 24800"
                                    data-vehicle="WP CBA-4321" data-year="2026">
                                    <!-- Date -->
                                    <td class="py-5 px-6 align-top">
                                        <div class="font-bold text-slate-900">Jun 14, 2026</div>
                                        <div class="text-xs text-slate-400 font-medium mt-0.5">02:15 PM</div>
                                    </td>

                                    <!-- Vehicle -->
                                    <td class="py-5 px-6 align-top">
                                        <div class="font-bold text-slate-900">2018 Toyota Axio</div>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-800 font-mono text-xs font-semibold border border-slate-200">
                                                WP CBA-4321
                                            </span>
                                            <span class="text-xs text-slate-400 font-medium">1.5L Hybrid</span>
                                        </div>
                                    </td>

                                    <!-- Primary Mechanic -->
                                    <td class="py-5 px-6 align-top">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-slate-900 text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-xs">
                                                SN
                                            </div>
                                            <div>
                                                <div class="font-semibold text-slate-900">Sahan Nimesh</div>
                                                <div class="text-xs text-slate-400 font-medium mt-0.5">Senior Powertrain Tech</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Total Cost -->
                                    <td class="py-5 px-6 align-top text-right">
                                        <div class="font-bold text-slate-900 text-sm whitespace-nowrap">LKR 24,800.00</div>
                                        <div class="mt-1">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                                <svg class="w-3 h-3 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                                <span>Paid</span>
                                            </span>
                                        </div>
                                    </td>
                                </tr>

                                <!-- ROW 3: 2021 Land Cruiser Prado (Feb 22, 2026) -->
                                <tr class="history-row hover:bg-slate-50/75 transition-colors cursor-pointer"
                                    onclick="openJobCardModal('JC-2026-2281', 'Feb 22, 2026', '2021 Land Cruiser Prado', 'WP CAB-7892', 'Manjula Kulatunga', 'Lead Diesel & Suspension Tech', 'LKR 96,400.00', ['Fuel Filter', 'ATF-WS Transmission Fluid (8L)', 'Differential Oil (Front & Rear)'], 'Major driveline fluids overhaul and fuel system purification. Complete 4WD operational test passed.')"
                                    data-search="feb 22 2026 2021 land cruiser prado wp cab-7892 diesel manjula kulatunga fuel filter atf-ws transmission fluid differential oil 96400"
                                    data-vehicle="WP CAB-7892" data-year="2026">
                                    <!-- Date -->
                                    <td class="py-5 px-6 align-top">
                                        <div class="font-bold text-slate-900">Feb 22, 2026</div>
                                        <div class="text-xs text-slate-400 font-medium mt-0.5">11:00 AM</div>
                                    </td>

                                    <!-- Vehicle -->
                                    <td class="py-5 px-6 align-top">
                                        <div class="font-bold text-slate-900">2021 Land Cruiser Prado</div>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-800 font-mono text-xs font-semibold border border-slate-200">
                                                WP CAB-7892
                                            </span>
                                            <span class="text-xs text-slate-400 font-medium">2.8L D-4D</span>
                                        </div>
                                    </td>

                                    <!-- Primary Mechanic -->
                                    <td class="py-5 px-6 align-top">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-slate-900 text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-xs">
                                                MK
                                            </div>
                                            <div>
                                                <div class="font-semibold text-slate-900">Manjula Kulatunga</div>
                                                <div class="text-xs text-slate-400 font-medium mt-0.5">Lead Diesel &amp; Suspension Tech</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Total Cost -->
                                    <td class="py-5 px-6 align-top text-right">
                                        <div class="font-bold text-slate-900 text-sm whitespace-nowrap">LKR 96,400.00</div>
                                        <div class="mt-1">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                                <svg class="w-3 h-3 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                                <span>Paid</span>
                                            </span>
                                        </div>
                                    </td>
                                </tr>

                                <!-- ROW 4: 2018 Toyota Axio (Nov 18, 2025 - Archived) -->
                                <tr class="history-row hover:bg-slate-50/75 transition-colors cursor-pointer"
                                    onclick="openJobCardModal('JC-2025-1118', 'Nov 18, 2025', '2018 Toyota Axio', 'WP CBA-4321', 'Sahan Nimesh', 'Senior Powertrain Tech', 'LKR 18,200.00', ['Front Brake Discs Skimming', 'Wheel Alignment (4-Wheel Laser)'], 'Brake shudder fixed via precision micro-skimming on lathe. 4-wheel alignment restored.')"
                                    data-search="nov 18 2025 2018 toyota axio wp cba-4321 hybrid sahan nimesh brake discs skimming wheel alignment 18200"
                                    data-vehicle="WP CBA-4321" data-year="2025">
                                    <td class="py-5 px-6 align-top">
                                        <div class="font-bold text-slate-900">Nov 18, 2025</div>
                                        <div class="text-xs text-slate-400 font-medium mt-0.5">09:15 AM</div>
                                    </td>
                                    <td class="py-5 px-6 align-top">
                                        <div class="font-bold text-slate-900">2018 Toyota Axio</div>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-800 font-mono text-xs font-semibold border border-slate-200">
                                                WP CBA-4321
                                            </span>
                                            <span class="text-xs text-slate-400 font-medium">1.5L Hybrid</span>
                                        </div>
                                    </td>
                                    <td class="py-5 px-6 align-top">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-slate-900 text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-xs">
                                                SN
                                            </div>
                                            <div>
                                                <div class="font-semibold text-slate-900">Sahan Nimesh</div>
                                                <div class="text-xs text-slate-400 font-medium mt-0.5">Senior Powertrain Tech</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="py-5 px-6 align-top text-right">
                                        <div class="font-bold text-slate-900 text-sm whitespace-nowrap">LKR 18,200.00</div>
                                        <div class="mt-1">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                                <svg class="w-3 h-3 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                                <span>Paid</span>
                                            </span>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <!-- Empty State for Search Filter -->
                    <div id="noHistoryResults" class="hidden py-12 px-6 text-center">
                        <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </div>
                        <h4 class="text-sm font-bold text-slate-800">No service records match your criteria</h4>
                        <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Try resetting your search query or vehicle selection to view your complete service records.</p>
                        <button type="button" onclick="resetHistoryFilters()"
                            class="mt-3 px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors">
                            Reset Filters
                        </button>
                    </div>

                    <!-- Table Footer Note / Pagination Indicator -->
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                        <div class="flex items-center gap-2">
                            <span>Showing</span>
                            <span id="visibleRowCount" class="font-bold text-slate-800">4</span>
                            <span>of</span>
                            <span class="font-bold text-slate-800">14 total records</span>
                            <span class="text-slate-300">•</span>
                            <span class="text-emerald-600 font-medium">All invoices digital &amp; tax compliant</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="alert('Exporting verified service log history as CSV...')"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium transition-colors shadow-xs">
                                <svg class="w-3.5 h-3.5 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                </svg>
                                <span>Export Log</span>
                            </button>
                        </div>
                    </div>

                </div>

            </main>

            <!-- Bottom Dashboard Footer -->
            <footer class="mt-auto px-4 sm:px-6 lg:px-8 py-5 border-t border-slate-200 bg-white text-xs text-slate-400 flex flex-col sm:flex-row items-center justify-between gap-2">
                <p>&copy; 2026 VWMS Vehicle Management System. All rights reserved.</p>
                <div class="flex items-center gap-4">
                    <a href="/customer/appointments" class="hover:text-slate-600 transition-colors">Book Inspection</a>
                    <span>•</span>
                    <a href="/customer/vehicles" class="hover:text-slate-600 transition-colors">Fleet Registry</a>
                    <span>•</span>
                    <span class="text-emerald-600 font-semibold flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        ISO 9001 Certified Garage
                    </span>
                </div>
            </footer>

        </div>
    </div>

    <!-- ======================================================== -->
    <!-- JOB CARD & INVOICE DETAILS MODAL                         -->
    <!-- ======================================================== -->
    <div id="jobCardModal"
        class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-2xl max-w-xl w-full p-6 shadow-modal border border-slate-200 relative my-8 animate-fade-in">
            <!-- Modal Header -->
            <div class="flex items-start justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-base font-bold text-slate-900" id="modalJobCardId">JC-2026-8902</h3>
                            <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                Verified &amp; Paid
                            </span>
                        </div>
                        <p class="text-xs text-slate-400 mt-0.5" id="modalDateVehicle">Sep 01, 2026 • 2015 Honda Fit (NW WP-9876)</p>
                    </div>
                </div>
                <button type="button" onclick="closeJobCardModal()" class="text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="mt-4 space-y-4 text-xs">
                <!-- Mechanic & Inspection Row -->
                <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100 flex items-center justify-between">
                    <div>
                        <div class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">CERTIFIED MECHANIC</div>
                        <div class="font-bold text-slate-800 text-sm mt-0.5" id="modalMechanic">Dishan Karunaratne</div>
                        <div class="text-slate-400" id="modalRole">Master Brake Specialist</div>
                    </div>
                    <div class="text-right">
                        <div class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">INSPECTION RESULT</div>
                        <div class="font-bold text-emerald-600 text-sm mt-0.5">QC Passed (100%)</div>
                        <div class="text-slate-400">Road Tested 8.5 km</div>
                    </div>
                </div>

                <!-- Replaced Parts List -->
                <div>
                    <div class="text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-2">REPLACED OEM PARTS &amp; CONSUMABLES</div>
                    <ul class="space-y-1.5" id="modalPartsList">
                        <!-- Populated by JS -->
                    </ul>
                </div>

                <!-- Technician Log Notes -->
                <div>
                    <div class="text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-1.5">TECHNICIAN FIELD NOTES</div>
                    <p class="p-3 bg-white border border-slate-200 rounded-lg text-slate-700 leading-relaxed font-sans" id="modalNotes">
                        Full brake pads renewal and bleeding. Tested under dynamic load on brake dyno.
                    </p>
                </div>

                <!-- Total Amount Banner -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-slate-600 font-semibold text-xs">Total Settled Invoice:</span>
                    <span class="text-base font-extrabold text-slate-900 font-mono" id="modalCost">LKR 38,500.00</span>
                </div>
            </div>

            <!-- Modal Footer Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 mt-4">
                <button type="button" onclick="closeJobCardModal()"
                    class="px-4 py-2 rounded-lg text-xs font-semibold text-slate-600 hover:bg-slate-100 transition-colors">
                    Close
                </button>
                <button type="button" onclick="downloadInvoicePDF()"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-orange-500 hover:bg-orange-600 text-white text-xs font-semibold shadow-xs transition-all">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    <span>Download PDF Invoice</span>
                </button>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- SERVICE BOOKING MODAL                                    -->
    <!-- ======================================================== -->
    <div id="bookingModal"
        class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-modal border border-slate-200 relative my-8 animate-fade-in">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Schedule Service Booking</h3>
                        <p id="bookingModalVehicleLabel" class="text-xs text-orange-600 font-semibold">General Fleet Booking</p>
                    </div>
                </div>
                <button type="button" onclick="closeBookingModal()" class="text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form onsubmit="handleBookingConfirm(event)" class="mt-4 space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Select Vehicle</label>
                    <select id="bookingVehicleSelect" required
                        class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none focus:border-orange-500">
                        <option value="2015 Honda Fit (NW WP-9876)">2015 Honda Fit (NW WP-9876)</option>
                        <option value="2018 Toyota Axio (WP CBA-4321)">2018 Toyota Axio (WP CBA-4321)</option>
                        <option value="2021 Land Cruiser Prado (WP CAB-7892)">2021 Land Cruiser Prado (WP CAB-7892)</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Preferred Date</label>
                        <input type="date" id="bookingDate" value="2026-10-15" required
                            class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none focus:border-orange-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Preferred Time</label>
                        <select
                            class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none focus:border-orange-500">
                            <option>09:00 AM</option>
                            <option>11:00 AM</option>
                            <option>01:30 PM</option>
                            <option>03:30 PM</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Service Package</label>
                    <select
                        class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none focus:border-orange-500">
                        <option>Periodic Maintenance (Comprehensive Inspection)</option>
                        <option>Full Brake System Inspection &amp; Pad Replacement</option>
                        <option>Engine Oil &amp; Filter Express Service</option>
                        <option>Suspension &amp; Wheel Alignment</option>
                        <option>Hybrid Battery Health Check &amp; Cooling Service</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Notes or Symptoms</label>
                    <textarea rows="2" placeholder="Mention any specific issue (e.g. vibration, brake squeal)..."
                        class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:border-orange-500"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                    <button type="button" onclick="closeBookingModal()"
                        class="px-4 py-2 rounded-lg text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-5 py-2 rounded-lg bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold shadow-sm transition-all">
                        Confirm Booking
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toastNotification"
        class="fixed bottom-5 right-5 z-50 hidden bg-slate-900 text-white text-xs sm:text-sm px-4 py-3 rounded-xl shadow-xl flex items-center gap-3 transition-transform duration-300">
        <svg class="w-5 h-5 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <polyline points="20 6 9 17 4 12"></polyline>
        </svg>
        <span id="toastMessage">Action completed successfully!</span>
    </div>

    <!-- ======================================================== -->
    <!-- INTERACTIVE JAVASCRIPT CONTROLLERS                       -->
    <!-- ======================================================== -->
    <script>
        // 1. Mobile Sidebar Navigation Toggle
        function toggleMobileSidebar(show) {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            if (show) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
                document.body.style.overflow = '';
            }
        }

        // 2. Profile Dropdown Toggle
        function toggleProfileDropdown() {
            const menu = document.getElementById('profileMenu');
            menu.classList.toggle('hidden');
        }

        window.addEventListener('click', (e) => {
            const btn = document.getElementById('profileDropdownBtn');
            const menu = document.getElementById('profileMenu');
            if (btn && menu && !btn.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });

        // 3. Filter Table Records
        function filterHistoryRecords() {
            const search = (document.getElementById('historySearchInput')?.value || '').toLowerCase().trim();
            const vehicle = document.getElementById('vehicleFilterSelect')?.value || 'all';
            const year = document.getElementById('dateRangeSelect')?.value || 'all';

            const rows = document.querySelectorAll('.history-row');
            let visibleCount = 0;

            rows.forEach(row => {
                const searchData = (row.getAttribute('data-search') || '').toLowerCase();
                const rowVehicle = row.getAttribute('data-vehicle') || '';
                const rowYear = row.getAttribute('data-year') || '';

                const matchesSearch = !search || searchData.includes(search);
                const matchesVehicle = (vehicle === 'all') || (rowVehicle === vehicle);
                const matchesYear = (year === 'all') || (year === rowYear) || (year === 'last6m' && rowYear === '2026');

                if (matchesSearch && matchesVehicle && matchesYear) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            const countEl = document.getElementById('visibleRowCount');
            if (countEl) countEl.textContent = visibleCount;

            const noResults = document.getElementById('noHistoryResults');
            if (noResults) {
                if (visibleCount === 0) {
                    noResults.classList.remove('hidden');
                } else {
                    noResults.classList.add('hidden');
                }
            }
        }

        function resetHistoryFilters() {
            document.getElementById('historySearchInput').value = '';
            document.getElementById('vehicleFilterSelect').value = 'all';
            document.getElementById('dateRangeSelect').value = 'all';
            filterHistoryRecords();
        }

        // 4. Job Card Modal Controller
        function openJobCardModal(jobId, date, vehicle, plate, mechanic, role, cost, parts, notes) {
            document.getElementById('modalJobCardId').textContent = jobId;
            document.getElementById('modalDateVehicle').textContent = `${date} • ${vehicle} (${plate})`;
            document.getElementById('modalMechanic').textContent = mechanic;
            document.getElementById('modalRole').textContent = role;
            document.getElementById('modalCost').textContent = cost;
            document.getElementById('modalNotes').textContent = notes;

            const partsList = document.getElementById('modalPartsList');
            partsList.innerHTML = '';
            parts.forEach(part => {
                const li = document.createElement('li');
                li.className = 'flex items-center justify-between p-2 rounded-lg bg-slate-50 border border-slate-100 text-slate-700';
                li.innerHTML = `
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                        <span class="font-medium">${part}</span>
                    </div>
                    <span class="text-[11px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">Installed &amp; Calibrated</span>
                `;
                partsList.appendChild(li);
            });

            document.getElementById('jobCardModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeJobCardModal() {
            document.getElementById('jobCardModal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        function downloadInvoicePDF() {
            const jobId = document.getElementById('modalJobCardId').textContent;
            showToast(`Generating official PDF invoice for ${jobId}...`);
            setTimeout(() => {
                alert(`PDF Tax Invoice for ${jobId} downloaded successfully! Includes certified technician digital stamp.`);
            }, 1000);
        }

        // 5. Booking Modal Controller
        function openBookingModal(vehicleName) {
            window.location.href = `appointments.html?open=booking&vehicle=${encodeURIComponent(vehicleName || '')}`;
        }

        function closeBookingModal() {
            document.getElementById('bookingModal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        function handleBookingConfirm(e) {
            e.preventDefault();
            const vehicle = document.getElementById('bookingVehicleSelect').value;
            const date = document.getElementById('bookingDate').value;
            closeBookingModal();
            showToast(`Appointment confirmed for ${vehicle} on ${date}!`);
        }

        // 6. Toast Notification Helper
        function showToast(message) {
            const toast = document.getElementById('toastNotification');
            const msgEl = document.getElementById('toastMessage');
            if (toast && msgEl) {
                msgEl.textContent = message;
                toast.classList.remove('hidden');
                setTimeout(() => {
                    toast.classList.add('hidden');
                }, 3500);
            }
        }
    </script>
</body>

</html>
