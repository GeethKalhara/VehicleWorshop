<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>My Vehicles - VWMS Customer Portal</title>
    <meta name="description"
        content="Manage your registered garage vehicles, view inspection intervals, and schedule bookings on VWMS Customer Portal.">

    <!-- Google Fonts: Inter -->
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

            0%,
            100% {
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

    <!-- Mobile Sidebar Backdrop Overlay -->
    <div id="sidebarBackdrop"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 hidden transition-opacity duration-300 lg:hidden"
        onclick="toggleMobileSidebar(false)"></div>

    <!-- Main Application Shell -->
    <div class="flex-1 flex min-h-screen">

        <!-- ======================================================== -->
        <!-- SIDEBAR NAVIGATION                                       -->
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
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/40 font-medium text-sm transition-colors duration-150 group">
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-white" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7" rx="1.5"></rect>
                            <rect x="14" y="3" width="7" height="7" rx="1.5"></rect>
                            <rect x="14" y="14" width="7" height="7" rx="1.5"></rect>
                            <rect x="3" y="14" width="7" height="7" rx="1.5"></rect>
                        </svg>
                        <span>Overview</span>
                    </a>

                    <!-- 2. My Vehicles (Active) -->
                    <a href="/customer/vehicles"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-white/5 text-orange-500 font-medium text-sm transition-all duration-150 relative group">
                        <!-- Active Indicator Glow -->
                        <span
                            class="w-1.5 h-4 bg-orange-500 rounded-full absolute left-0 top-1/2 -translate-y-1/2 shadow-[0_0_8px_#F97316]"></span>
                        <svg class="w-5 h-5 text-orange-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"
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
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/40 font-medium text-sm transition-colors duration-150 group">
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-white" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span>Appointments</span>
                    </a>

                    <!-- 4. Service History -->
                    <a href="/customer/service-history"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/40 font-medium text-sm transition-colors duration-150 group">
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-white" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span>Service History</span>
                    </a>

                    <!-- 5. Invoices -->
                    <a href="dashboard.html#invoices"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/40 font-medium text-sm transition-colors duration-150 group">
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-white" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/40 font-medium text-sm transition-colors duration-150 group">
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-white" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                        <span class="text-slate-900 font-semibold">My Vehicles</span>
                    </nav>
                </div>

                <!-- Center: Search Input Bar -->
                <div class="flex-1 max-w-md mx-2 sm:mx-4">
                    <div class="relative">
                        <span
                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </span>
                        <input type="text" id="vehicleSearchInput" onkeyup="filterVehicleCards()"
                            placeholder="Search license plate or model"
                            class="w-full pl-9 pr-4 py-1.5 sm:py-2 text-xs sm:text-sm bg-white border border-slate-200 rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/10 transition-all shadow-sm">
                    </div>
                </div>

                <!-- Right: Notifications & Profile -->
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
                        <!-- Orange Unread Dot Indicator -->
                        <span
                            class="absolute top-2 right-2 w-2 h-2 bg-orange-500 rounded-full ring-2 ring-white"></span>
                    </button>

                    <!-- Client Profile Badge & Dropdown -->
                    <div class="relative">
                        <button type="button" id="profileDropdownBtn" onclick="toggleProfileDropdown()"
                            class="flex items-center gap-2.5 pl-1 sm:pl-2 cursor-pointer group focus:outline-none">
                            <!-- Avatar with Status Dot -->
                            <div class="relative">
                                <div
                                    class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[#9A3412] text-white flex items-center justify-center font-bold text-xs sm:text-sm shadow-sm overflow-hidden">
                                    <span>KP</span>
                                </div>
                                <span
                                    class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-white rounded-full"></span>
                            </div>

                            <!-- Name & Role -->
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
                            class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 py-1.5 z-50 text-xs text-slate-700">
                            <div class="px-3.5 py-2 border-b border-slate-100">
                                <div class="font-semibold text-slate-900">Kasun Perera</div>
                                <div class="text-[11px] text-slate-400 truncate">kasun.perera@example.com</div>
                            </div>
                            <a href="/customer/profile"
                                class="flex items-center gap-2 px-3.5 py-2 hover:bg-slate-50 transition-colors">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>My Account</span>
                            </a>
                            <a href="/login"
                                class="flex items-center gap-2 px-3.5 py-2 text-rose-600 hover:bg-rose-50 transition-colors border-t border-slate-100">
                                <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                <span>Sign Out</span>
                            </a>
                        </div>
                    </div>

                </div>
            </header>

            <!-- Main Page Content Canvas -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto space-y-6">

                <!-- ======================================================== -->
                <!-- 1. HEADER SECTION                                        -->
                <!-- ======================================================== -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">My Vehicles</h1>
                        <p class="text-sm text-slate-500 mt-1">Manage your registered garage vehicles, view inspection
                            intervals, and schedule bookings.</p>
                    </div>

                    <!-- Register New Vehicle CTA -->
                    <button type="button" onclick="openAddVehicleModal()"
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg bg-orange-500 hover:bg-orange-600 active:translate-y-0.5 text-white font-semibold text-sm shadow-sm shadow-orange-500/20 transition-all duration-150 shrink-0">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        <span>Register Vehicle</span>
                    </button>
                </div>

                <!-- ======================================================== -->
                <!-- 2. METRICS STAT BAR                                      -->
                <!-- ======================================================== -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">

                    <!-- Stat 1: Registered -->
                    <div
                        class="bg-white rounded-2xl p-5 border border-slate-200 shadow-card flex items-center justify-between group hover:border-slate-300 transition-all duration-200">
                        <div class="flex items-center gap-4">
                            <!-- Vehicle Icon Box -->
                            <div
                                class="w-12 h-12 rounded-xl bg-orange-50 border border-orange-100 flex items-center justify-center text-orange-500 shrink-0">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M14 16H9m10 0h3v-3.15a1 1 0 0 0-.84-.99L16 11l-2.7-3.6a1 1 0 0 0-.8-.4H8.5a1 1 0 0 0-.8.4L5 11l-5.16.86a1 1 0 0 0-.84.99V16h3">
                                    </path>
                                    <circle cx="6.5" cy="16.5" r="2.5"></circle>
                                    <circle cx="16.5" cy="16.5" r="2.5"></circle>
                                </svg>
                            </div>
                            <div>
                                <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">
                                    REGISTERED
                                </div>
                                <div class="text-2xl sm:text-3xl font-bold text-slate-900 mt-0.5">
                                    3 Units
                                </div>
                            </div>
                        </div>
                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                            Active Fleet
                        </span>
                    </div>

                    <!-- Stat 2: Active Service -->
                    <div
                        class="bg-white rounded-2xl p-5 border border-slate-200 shadow-card flex items-center justify-between group hover:border-slate-300 transition-all duration-200">
                        <div class="flex items-center gap-4">
                            <!-- Service Icon Box -->
                            <div
                                class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">
                                    ACTIVE SERVICE
                                </div>
                                <div class="text-2xl sm:text-3xl font-bold text-slate-900 mt-0.5">
                                    1 Active
                                </div>
                            </div>
                        </div>
                        <!-- Live Pulse Status Badge -->
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-600 border border-blue-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-600 pulse-active"></span>
                            Bay #04 in shop
                        </span>
                    </div>

                </div>

                <!-- ======================================================== -->
                <!-- 3. VEHICLE CARDS GRID (DATA DRIVEN — NO IMAGES)          -->
                <!-- ======================================================== -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" id="vehiclesGrid">

                    <!-- CARD 1: 2018 Toyota Axio (Scheduled Upcoming) -->
                    <div class="vehicle-card bg-white rounded-2xl border border-slate-200 shadow-card flex flex-col justify-between hover:border-slate-300 hover:shadow-md transition-all duration-200 overflow-hidden"
                        data-search="2018 toyota axio wp cba-4321 pearl white hybrid">

                        <!-- Colored Header Section (Vehicle Number & Make Model) -->
                        <div class="bg-slate-900 text-white p-5 sm:p-6 pb-4 relative">
                            <!-- Top Accent Color Bar -->
                            <div
                                class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-orange-500 via-amber-500 to-orange-500">
                            </div>

                            <!-- Top Row: License Plate Badge & Context Menu -->
                            <div class="flex items-center justify-between mb-3 pt-0.5">
                                <span
                                    class="px-3 py-1 rounded-md bg-slate-800 text-amber-400 border border-slate-700 font-mono text-xs font-bold tracking-wider shadow-xs">
                                    WP CBA-4321
                                </span>

                                <div class="relative">
                                    <button type="button" onclick="toggleVehicleMenu('vmenu-1', event)"
                                        class="p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors"
                                        aria-label="Vehicle options">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="1.5"></circle>
                                            <circle cx="12" cy="5" r="1.5"></circle>
                                            <circle cx="12" cy="19" r="1.5"></circle>
                                        </svg>
                                    </button>
                                    <!-- Context Popover -->
                                    <div id="vmenu-1"
                                        class="vehicle-dropdown hidden absolute right-0 mt-1 w-44 bg-white rounded-xl shadow-lg border border-slate-100 py-1.5 z-40 text-xs text-slate-700">
                                        <button type="button"
                                            onclick="showVehicleModal('2018 Toyota Axio', 'WP CBA-4321', '45,200 km', '1.5L Hybrid e-CVT')"
                                            class="w-full flex items-center gap-2 px-3.5 py-2 hover:bg-slate-50 transition-colors text-left">
                                            <svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                            <span>Full Specs</span>
                                        </button>
                                        <a href="/customer/appointments"
                                            class="flex items-center gap-2 px-3.5 py-2 hover:bg-slate-50 transition-colors">
                                            <svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                            </svg>
                                            <span>Appointments</span>
                                        </a>
                                        <button type="button" onclick="promptEditVehicle('WP CBA-4321')"
                                            class="w-full flex items-center gap-2 px-3.5 py-2 text-slate-700 hover:bg-slate-50 transition-colors border-t border-slate-100 text-left">
                                            <svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                </path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                </path>
                                            </svg>
                                            <span>Edit Details</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Identity Area: Large Prominent Vehicle Title -->
                            <div>
                                <h3 class="text-lg font-bold text-white tracking-tight leading-snug">
                                    2018 Toyota Axio
                                </h3>
                                <p class="text-xs text-slate-400 mt-0.5 font-medium">Sedan • Chassis: NKE165-71024</p>
                            </div>
                        </div>

                        <!-- Card Body (Specs & Actions) -->
                        <div class="p-5 sm:p-6 pt-4 flex-1 flex flex-col justify-between space-y-4">
                            <div class="space-y-4">
                                <!-- Key Feature Badges: Powertrain & Active Status -->
                                <div class="flex flex-wrap items-center gap-2">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200/60">
                                        1.5L Hybrid e-CVT
                                    </span>
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-600 border border-blue-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                                        Booked (Oct 12)
                                    </span>
                                </div>

                                <!-- Specifications Grid: Color Swatch, Mileage (Interval Removed) -->
                                <div class="pt-3 border-t border-slate-100 grid grid-cols-2 gap-3 text-xs">
                                    <!-- Color Swatch -->
                                    <div class="space-y-1">
                                        <span
                                            class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">COLOR</span>
                                        <div class="flex items-center gap-1.5 font-medium text-slate-800">
                                            <span
                                                class="w-3 h-3 rounded-full bg-slate-100 border border-slate-300 shadow-xs inline-block"></span>
                                            <span>Pearl White</span>
                                        </div>
                                    </div>

                                    <!-- Mileage Block -->
                                    <div class="space-y-1">
                                        <span
                                            class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">MILEAGE</span>
                                        <div class="font-bold text-slate-900 font-mono">
                                            45,200 km
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Footer Actions: Book Service & View History -->
                            <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-3 mt-4">
                                <a href="/customer/service-history"
                                    class="text-xs font-semibold text-slate-600 hover:text-slate-900 hover:underline inline-flex items-center gap-1">
                                    <span>View History</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                                <button type="button"
                                    onclick="openVehicleBookingModal('2018 Toyota Axio (WP CBA-4321)')"
                                    class="px-4 py-2 rounded-lg bg-orange-500 hover:bg-orange-600 active:translate-y-0.5 text-white text-xs font-semibold shadow-xs transition-all">
                                    Book Service
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- CARD 2: Toyota Land Cruiser Prado (Active In-Shop Bay #04) -->
                    <div class="vehicle-card bg-white rounded-2xl border-2 border-orange-500/50 shadow-card flex flex-col justify-between hover:border-orange-500 transition-all duration-200 relative overflow-hidden"
                        data-search="toyota land cruiser prado wp cab-7892 metallic black diesel in service">

                        <!-- Colored Header Section (Vehicle Number & Make Model) -->
                        <div class="bg-slate-900 text-white p-5 sm:p-6 pb-4 relative">
                            <!-- Top Accent Color Bar -->
                            <div
                                class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-orange-500 via-amber-500 to-orange-600">
                            </div>

                            <!-- Top Row: License Plate Badge & Context Menu -->
                            <div class="flex items-center justify-between mb-3 pt-0.5">
                                <span
                                    class="px-3 py-1 rounded-md bg-slate-800 text-orange-400 border border-slate-700 font-mono text-xs font-bold tracking-wider shadow-xs">
                                    WP CAB-7892
                                </span>

                                <div class="relative">
                                    <button type="button" onclick="toggleVehicleMenu('vmenu-2', event)"
                                        class="p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors"
                                        aria-label="Vehicle options">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="1.5"></circle>
                                            <circle cx="12" cy="5" r="1.5"></circle>
                                            <circle cx="12" cy="19" r="1.5"></circle>
                                        </svg>
                                    </button>
                                    <!-- Context Popover -->
                                    <div id="vmenu-2"
                                        class="vehicle-dropdown hidden absolute right-0 mt-1 w-44 bg-white rounded-xl shadow-lg border border-slate-100 py-1.5 z-40 text-xs text-slate-700">
                                        <button type="button"
                                            onclick="showVehicleModal('Toyota Land Cruiser Prado', 'WP CAB-7892', '62,800 km', '2.8L D-4D Turbo Diesel')"
                                            class="w-full flex items-center gap-2 px-3.5 py-2 hover:bg-slate-50 transition-colors text-left">
                                            <svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                            <span>Full Specs</span>
                                        </button>
                                        <a href="/customer/dashboard"
                                            class="flex items-center gap-2 px-3.5 py-2 hover:bg-slate-50 transition-colors">
                                            <svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <polyline points="12 6 12 12 16 14"></polyline>
                                            </svg>
                                            <span>Live Progress</span>
                                        </a>
                                        <button type="button" onclick="promptEditVehicle('WP CAB-7892')"
                                            class="w-full flex items-center gap-2 px-3.5 py-2 text-slate-700 hover:bg-slate-50 transition-colors border-t border-slate-100 text-left">
                                            <svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                </path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                </path>
                                            </svg>
                                            <span>Edit Details</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Identity Area: Large Prominent Vehicle Title -->
                            <div>
                                <h3 class="text-lg font-bold text-white tracking-tight leading-snug">
                                    Land Cruiser Prado
                                </h3>
                                <p class="text-xs text-slate-400 mt-0.5 font-medium">SUV 4x4 • Chassis: GDJ150-00812</p>
                            </div>
                        </div>

                        <!-- Card Body (Specs & Actions) -->
                        <div class="p-5 sm:p-6 pt-4 flex-1 flex flex-col justify-between space-y-4">
                            <div class="space-y-4">
                                <!-- Key Feature Badges: Powertrain & Active Status -->
                                <div class="flex flex-wrap items-center gap-2">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200/60">
                                        2.8L D-4D Turbo Diesel
                                    </span>
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-600 border border-blue-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 pulse-active"></span>
                                        In Service (65%)
                                    </span>
                                </div>

                                <!-- Specifications Grid: Color Swatch, Mileage (Step Field Removed) -->
                                <div class="pt-3 border-t border-slate-100 grid grid-cols-2 gap-3 text-xs">
                                    <!-- Color Swatch -->
                                    <div class="space-y-1">
                                        <span
                                            class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">COLOR</span>
                                        <div class="flex items-center gap-1.5 font-medium text-slate-800">
                                            <span
                                                class="w-3 h-3 rounded-full bg-slate-900 border border-slate-700 shadow-xs inline-block"></span>
                                            <span>Attitude Black</span>
                                        </div>
                                    </div>

                                    <!-- Mileage Block -->
                                    <div class="space-y-1">
                                        <span
                                            class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">MILEAGE</span>
                                        <div class="font-bold text-slate-900 font-mono">
                                            62,800 km
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Footer Actions: Book Service & View History -->
                            <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-3 mt-4">
                                <a href="/customer/dashboard"
                                    class="text-xs font-semibold text-orange-600 hover:text-orange-700 hover:underline inline-flex items-center gap-1">
                                    <span>Track Live Bay</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                                <button type="button"
                                    onclick="alert('This vehicle is currently undergoing repair in Bay #04. Check dashboard for live status.')"
                                    class="px-4 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-all">
                                    In Progress
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- CARD 3: 2015 Honda Fit (Ready / Optimal) -->
                    <div class="vehicle-card bg-white rounded-2xl border border-slate-200 shadow-card flex flex-col justify-between hover:border-slate-300 hover:shadow-md transition-all duration-200 overflow-hidden"
                        data-search="2015 honda fit nw wp-9876 metallic blue i-vtec ready">

                        <!-- Colored Header Section (Vehicle Number & Make Model) -->
                        <div class="bg-slate-900 text-white p-5 sm:p-6 pb-4 relative">
                            <!-- Top Accent Color Bar -->
                            <div
                                class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-blue-500 via-indigo-500 to-cyan-500">
                            </div>

                            <!-- Top Row: License Plate Badge & Context Menu -->
                            <div class="flex items-center justify-between mb-3 pt-0.5">
                                <span
                                    class="px-3 py-1 rounded-md bg-slate-800 text-cyan-400 border border-slate-700 font-mono text-xs font-bold tracking-wider shadow-xs">
                                    NW WP-9876
                                </span>

                                <div class="relative">
                                    <button type="button" onclick="toggleVehicleMenu('vmenu-3', event)"
                                        class="p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors"
                                        aria-label="Vehicle options">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="1.5"></circle>
                                            <circle cx="12" cy="5" r="1.5"></circle>
                                            <circle cx="12" cy="19" r="1.5"></circle>
                                        </svg>
                                    </button>
                                    <!-- Context Popover -->
                                    <div id="vmenu-3"
                                        class="vehicle-dropdown hidden absolute right-0 mt-1 w-44 bg-white rounded-xl shadow-lg border border-slate-100 py-1.5 z-40 text-xs text-slate-700">
                                        <button type="button"
                                            onclick="showVehicleModal('2015 Honda Fit', 'NW WP-9876', '78,400 km', '1.3L i-VTEC Automatic')"
                                            class="w-full flex items-center gap-2 px-3.5 py-2 hover:bg-slate-50 transition-colors text-left">
                                            <svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                            <span>Full Specs</span>
                                        </button>
                                        <a href="dashboard.html#invoices"
                                            class="flex items-center gap-2 px-3.5 py-2 hover:bg-slate-50 transition-colors">
                                            <svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z">
                                                </path>
                                                <polyline points="14 2 14 8 20 8"></polyline>
                                            </svg>
                                            <span>Past Invoices</span>
                                        </a>
                                        <button type="button" onclick="promptEditVehicle('NW WP-9876')"
                                            class="w-full flex items-center gap-2 px-3.5 py-2 text-slate-700 hover:bg-slate-50 transition-colors border-t border-slate-100 text-left">
                                            <svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                </path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                </path>
                                            </svg>
                                            <span>Edit Details</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Identity Area: Large Prominent Vehicle Title -->
                            <div>
                                <h3 class="text-lg font-bold text-white tracking-tight leading-snug">
                                    2015 Honda Fit
                                </h3>
                                <p class="text-xs text-slate-400 mt-0.5 font-medium">Hatchback • Chassis: GK3-30041</p>
                            </div>
                        </div>

                        <!-- Card Body (Specs & Actions) -->
                        <div class="p-5 sm:p-6 pt-4 flex-1 flex flex-col justify-between space-y-4">
                            <div class="space-y-4">
                                <!-- Key Feature Badges: Powertrain & Active Status -->
                                <div class="flex flex-wrap items-center gap-2">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200/60">
                                        1.3L i-VTEC Automatic
                                    </span>
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Ready / Optimal
                                    </span>
                                </div>

                                <!-- Specifications Grid: Color Swatch, Mileage (Interval Removed) -->
                                <div class="pt-3 border-t border-slate-100 grid grid-cols-2 gap-3 text-xs">
                                    <!-- Color Swatch -->
                                    <div class="space-y-1">
                                        <span
                                            class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">COLOR</span>
                                        <div class="flex items-center gap-1.5 font-medium text-slate-800">
                                            <span
                                                class="w-3 h-3 rounded-full bg-blue-600 border border-blue-400 shadow-xs inline-block"></span>
                                            <span>Vivid Sky Blue</span>
                                        </div>
                                    </div>

                                    <!-- Mileage Block -->
                                    <div class="space-y-1">
                                        <span
                                            class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">MILEAGE</span>
                                        <div class="font-bold text-slate-900 font-mono">
                                            78,400 km
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Footer Actions: Book Service & View History -->
                            <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-3 mt-4">
                                <a href="/customer/service-history"
                                    class="text-xs font-semibold text-slate-600 hover:text-slate-900 hover:underline inline-flex items-center gap-1">
                                    <span>View History</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                                <button type="button" onclick="openVehicleBookingModal('2015 Honda Fit (NW WP-9876)')"
                                    class="px-4 py-2 rounded-lg bg-orange-500 hover:bg-orange-600 active:translate-y-0.5 text-white text-xs font-semibold shadow-xs transition-all">
                                    Book Service
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- ======================================================== -->
                <!-- 4. BOTTOM ACTIVITY SLOT: RECENT SERVICE LOGS / HISTORY   -->
                <!-- ======================================================== -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-card p-6 space-y-5">

                    <!-- Header with Title & Filter Link -->
                    <div
                        class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 border-b border-slate-100 pb-4">
                        <div class="flex items-center gap-2.5">
                            <div
                                class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-700">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900">Recent Vehicle Service Logs &amp; Booking
                                    History</h3>
                                <p class="text-xs text-slate-400">Complete historical diagnostic milestones across your
                                    registered vehicles</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="text-xs font-medium text-slate-500">Filter vehicle:</span>
                            <select id="logVehicleFilter" onchange="filterServiceLogs(this.value)"
                                class="text-xs bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1.5 text-slate-700 focus:outline-none focus:border-orange-500">
                                <option value="all">All Vehicles (3)</option>
                                <option value="WP CAB-7892">WP CAB-7892 (Prado)</option>
                                <option value="WP CBA-4321">WP CBA-4321 (Axio)</option>
                                <option value="NW WP-9876">NW WP-9876 (Fit)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Activity Log List -->
                    <div class="space-y-3 divide-y divide-slate-100/80">

                        <!-- Log 1: Prado Intake & Diagnostics -->
                        <div class="log-item pt-3 first:pt-0 flex flex-col sm:flex-row sm:items-center justify-between gap-3 group"
                            data-vehicle="WP CAB-7892">
                            <div class="flex items-start sm:items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 border border-blue-100 mt-0.5 sm:mt-0">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5">
                                        <polyline points="23 4 23 10 17 10"></polyline>
                                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div
                                        class="text-sm font-semibold text-slate-800 group-hover:text-orange-600 transition-colors">
                                        Diagnostic Scan &amp; Suspension Assembly in Progress
                                    </div>
                                    <div class="text-xs text-slate-400 flex items-center gap-2 mt-0.5">
                                        <span class="font-mono font-medium text-slate-600">WP CAB-7892</span>
                                        <span>•</span>
                                        <span>Lead: Rohan Mendis (Bay #04)</span>
                                        <span>•</span>
                                        <span>Job Card #JC-9842</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 text-right">
                                <span
                                    class="px-2 py-0.5 rounded text-[11px] font-semibold bg-blue-50 text-blue-700 border border-blue-100/80">
                                    In Shop
                                </span>
                                <span class="text-xs text-slate-400 whitespace-nowrap">25m ago</span>
                            </div>
                        </div>

                        <!-- Log 2: Axio Appointment Scheduled -->
                        <div class="log-item pt-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3 group"
                            data-vehicle="WP CBA-4321">
                            <div class="flex items-start sm:items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center shrink-0 border border-orange-100 mt-0.5 sm:mt-0">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                    </svg>
                                </div>
                                <div>
                                    <div
                                        class="text-sm font-semibold text-slate-800 group-hover:text-orange-600 transition-colors">
                                        Full Periodic Maintenance Booked for Oct 12, 2026
                                    </div>
                                    <div class="text-xs text-slate-400 flex items-center gap-2 mt-0.5">
                                        <span class="font-mono font-medium text-slate-600">WP CBA-4321</span>
                                        <span>•</span>
                                        <span>Scheduled: 09:00 AM</span>
                                        <span>•</span>
                                        <span>Target: 50,000 km Inspection</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 text-right">
                                <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-700">
                                    Scheduled
                                </span>
                                <span class="text-xs text-slate-400 whitespace-nowrap">2h ago</span>
                            </div>
                        </div>

                        <!-- Log 3: Fit Brake Pad Replacement Completed -->
                        <div class="log-item pt-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3 group"
                            data-vehicle="NW WP-9876">
                            <div class="flex items-start sm:items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100 mt-0.5 sm:mt-0">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </div>
                                <div>
                                    <div
                                        class="text-sm font-semibold text-slate-800 group-hover:text-orange-600 transition-colors">
                                        Front Ceramic Brake Pads &amp; Fluid Flush Completed
                                    </div>
                                    <div class="text-xs text-slate-400 flex items-center gap-2 mt-0.5">
                                        <span class="font-mono font-medium text-slate-600">NW WP-9876</span>
                                        <span>•</span>
                                        <span>Invoice #INV-2024-880 Paid (LKR 28,500)</span>
                                        <span>•</span>
                                        <span>Warranty: 10,000 km</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 text-right">
                                <span
                                    class="px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                    Completed
                                </span>
                                <span class="text-xs text-slate-400 whitespace-nowrap">Sep 01</span>
                            </div>
                        </div>

                    </div>

                </div>

            </main>

            <!-- Bottom Sticky Navigation Bar for Mobile (< lg) -->
            <nav
                class="lg:hidden sticky bottom-0 bg-white border-t border-slate-200 px-4 py-2 flex items-center justify-around z-30 shadow-lg">
                <a href="/customer/dashboard"
                    class="flex flex-col items-center gap-1 text-slate-500 hover:text-slate-800 text-[11px] font-medium">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" rx="1.5"></rect>
                        <rect x="14" y="3" width="7" height="7" rx="1.5"></rect>
                        <rect x="14" y="14" width="7" height="7" rx="1.5"></rect>
                        <rect x="3" y="14" width="7" height="7" rx="1.5"></rect>
                    </svg>
                    <span>Overview</span>
                </a>
                <a href="/customer/vehicles"
                    class="flex flex-col items-center gap-1 text-orange-600 font-semibold text-[11px]">
                    <svg class="w-5 h-5 text-orange-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path
                            d="M14 16H9m10 0h3v-3.15a1 1 0 0 0-.84-.99L16 11l-2.7-3.6a1 1 0 0 0-.8-.4H8.5a1 1 0 0 0-.8.4L5 11l-5.16.86a1 1 0 0 0-.84.99V16h3">
                        </path>
                        <circle cx="6.5" cy="16.5" r="2.5"></circle>
                        <circle cx="16.5" cy="16.5" r="2.5"></circle>
                    </svg>
                    <span>Vehicles</span>
                </a>
                <button type="button" onclick="openAddVehicleModal()" class="flex flex-col items-center gap-1 -mt-4">
                    <div
                        class="w-11 h-11 rounded-full bg-orange-500 text-white flex items-center justify-center shadow-lg shadow-orange-500/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </div>
                    <span class="text-[10px] font-semibold text-orange-600">Register</span>
                </button>
                <a href="/customer/appointments"
                    class="flex flex-col items-center gap-1 text-slate-500 hover:text-slate-800 text-[11px] font-medium">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    <span>Appts</span>
                </a>
                <a href="/customer/profile"
                    class="flex flex-col items-center gap-1 text-slate-500 hover:text-slate-800 text-[11px] font-medium">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span>Profile</span>
                </a>
            </nav>

        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL 1: REGISTER NEW VEHICLE                            -->
    <!-- ======================================================== -->
    <div id="addVehicleModal"
        class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div
            class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-modal border border-slate-200 relative animate-fade-in">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-orange-50 text-orange-500 flex items-center justify-center">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path
                                d="M14 16H9m10 0h3v-3.15a1 1 0 0 0-.84-.99L16 11l-2.7-3.6a1 1 0 0 0-.8-.4H8.5a1 1 0 0 0-.8.4L5 11l-5.16.86a1 1 0 0 0-.84.99V16h3">
                            </path>
                            <circle cx="6.5" cy="16.5" r="2.5"></circle>
                            <circle cx="16.5" cy="16.5" r="2.5"></circle>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Register New Vehicle</h3>
                        <p class="text-xs text-slate-400">Add vehicle details for service tracking and booking</p>
                    </div>
                </div>
                <button type="button" onclick="closeAddVehicleModal()" class="text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <form onsubmit="handleAddVehicleSubmit(event)" class="mt-4 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label
                            class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">License
                            Plate</label>
                        <input type="text" id="regPlate" required placeholder="e.g. WP CAA-1234"
                            class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:border-orange-500 font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Year,
                            Make &amp; Model</label>
                        <input type="text" id="regTitle" required placeholder="e.g. 2021 Toyota Corolla"
                            class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:border-orange-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label
                            class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Powertrain
                            / Engine</label>
                        <input type="text" id="regEngine" required placeholder="e.g. 1.8L Hybrid Automatic"
                            class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:border-orange-500">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Current
                            Mileage (km)</label>
                        <input type="text" id="regMileage" required placeholder="e.g. 28,000 km"
                            class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:border-orange-500 font-mono">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Body
                            Color</label>
                        <input type="text" id="regColor" required placeholder="e.g. Silver Metallic"
                            class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:border-orange-500">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Chassis /
                            VIN (Optional)</label>
                        <input type="text" id="regChassis" placeholder="e.g. ZRE212-9012"
                            class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:border-orange-500 font-mono">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                    <button type="button" onclick="closeAddVehicleModal()"
                        class="px-4 py-2 rounded-lg text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-5 py-2 rounded-lg bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold shadow-sm transition-all">
                        Register Vehicle
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL 2: VEHICLE QUICK BOOKING MODAL                     -->
    <!-- ======================================================== -->
    <div id="bookingModal"
        class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div
            class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-modal border border-slate-200 relative animate-fade-in">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-orange-50 text-orange-500 flex items-center justify-center">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Schedule Service Booking</h3>
                        <p id="bookingModalVehicleLabel" class="text-xs text-orange-600 font-semibold"></p>
                    </div>
                </div>
                <button type="button" onclick="closeBookingModal()" class="text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <form onsubmit="handleBookingConfirm(event)" class="mt-4 space-y-4">
                <input type="hidden" id="selectedBookingVehicle">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label
                            class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Preferred
                            Date</label>
                        <input type="date" id="bookingDate" value="2026-10-25" required
                            class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none focus:border-orange-500">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Preferred
                            Time</label>
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
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Select
                        Service Package</label>
                    <select
                        class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none focus:border-orange-500">
                        <option>Periodic Maintenance (Comprehensive Inspection)</option>
                        <option>Full Brake System Inspection &amp; Pad Replacement</option>
                        <option>Suspension &amp; Wheel Alignment</option>
                        <option>Hybrid Battery Health Check &amp; Cooling Service</option>
                        <option>Engine Oil &amp; Filter Express Service</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Notes or
                        Symptoms</label>
                    <textarea rows="2"
                        placeholder="Mention any specific issue (e.g. vibration at 80 km/h, brake squeal)..."
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

    <!-- Toast Notification for Dynamic Feedback -->
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

        // 3. Vehicle Action Dropdown Toggle
        function toggleVehicleMenu(menuId, event) {
            event.stopPropagation();
            const targetMenu = document.getElementById(menuId);
            const isCurrentlyHidden = targetMenu.classList.contains('hidden');
            document.querySelectorAll('.vehicle-dropdown').forEach(d => d.classList.add('hidden'));
            if (isCurrentlyHidden) {
                targetMenu.classList.remove('hidden');
            }
        }

        window.addEventListener('click', (e) => {
            const btn = document.getElementById('profileDropdownBtn');
            const menu = document.getElementById('profileMenu');
            if (btn && menu && !btn.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }

            if (!e.target.closest('.vehicle-dropdown') && !e.target.closest('button[onclick*="toggleVehicleMenu"]')) {
                document.querySelectorAll('.vehicle-dropdown').forEach(d => d.classList.add('hidden'));
            }
        });

        // 4. Vehicle Search Filter
        function filterVehicleCards() {
            const query = (document.getElementById('vehicleSearchInput')?.value || '').toLowerCase().trim();
            const cards = document.querySelectorAll('.vehicle-card');

            cards.forEach(card => {
                const searchData = (card.getAttribute('data-search') || '').toLowerCase();
                if (!query || searchData.includes(query)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // 5. Activity Log Filter
        function filterServiceLogs(vehiclePlate) {
            const items = document.querySelectorAll('.log-item');
            items.forEach(item => {
                const plate = item.getAttribute('data-vehicle');
                if (vehiclePlate === 'all' || plate === vehiclePlate) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        // 6. Booking Modal Handlers
        function openVehicleBookingModal(vehicleName) {
            window.location.href = `appointments.html?open=booking&vehicle=${encodeURIComponent(vehicleName)}`;
        }

        function closeBookingModal() {
            document.getElementById('bookingModal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        function handleBookingConfirm(e) {
            e.preventDefault();
            const vehicle = document.getElementById('selectedBookingVehicle').value;
            const date = document.getElementById('bookingDate').value;
            closeBookingModal();
            showToast(`Service appointment booked for ${vehicle} on ${date}!`);
        }

        // 7. Add Vehicle Modal Handlers
        function openAddVehicleModal() {
            document.getElementById('addVehicleModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeAddVehicleModal() {
            document.getElementById('addVehicleModal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        function handleAddVehicleSubmit(e) {
            e.preventDefault();
            const plate = document.getElementById('regPlate').value.trim();
            const title = document.getElementById('regTitle').value.trim();
            const engine = document.getElementById('regEngine').value.trim();
            const mileage = document.getElementById('regMileage').value.trim();
            const color = document.getElementById('regColor').value.trim();

            closeAddVehicleModal();

            // Append new vehicle card dynamically
            const grid = document.getElementById('vehiclesGrid');
            const newCard = document.createElement('div');
            newCard.className = 'vehicle-card bg-white rounded-2xl border border-slate-200 shadow-card flex flex-col justify-between hover:border-slate-300 hover:shadow-md transition-all duration-200 overflow-hidden animate-fade-in';
            newCard.setAttribute('data-search', `${title} ${plate} ${color} ${engine}`);
            newCard.innerHTML = `
                <!-- Colored Header Section (Vehicle Number & Make Model) -->
                <div class="bg-slate-900 text-white p-5 sm:p-6 pb-4 relative">
                    <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-emerald-500 to-teal-500"></div>
                    <div class="flex items-center justify-between mb-3 pt-0.5">
                        <span class="px-3 py-1 rounded-md bg-slate-800 text-emerald-400 border border-slate-700 font-mono text-xs font-bold tracking-wider shadow-xs">
                            ${plate}
                        </span>
                        <span class="text-xs font-semibold text-emerald-400 bg-emerald-950/70 border border-emerald-800 px-2 py-0.5 rounded">Newly Registered</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white tracking-tight leading-snug">${title}</h3>
                        <p class="text-xs text-slate-400 mt-0.5 font-medium">Passenger Vehicle</p>
                    </div>
                </div>
                <!-- Card Body (Specs & Actions) -->
                <div class="p-5 sm:p-6 pt-4 flex-1 flex flex-col justify-between space-y-4">
                    <div class="space-y-4">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200/60">
                                ${engine}
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Ready
                            </span>
                        </div>
                        <div class="pt-3 border-t border-slate-100 grid grid-cols-2 gap-3 text-xs">
                            <div class="space-y-1">
                                <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">COLOR</span>
                                <div class="flex items-center gap-1.5 font-medium text-slate-800">
                                    <span class="w-3 h-3 rounded-full bg-slate-300 border border-slate-400 shadow-xs inline-block"></span>
                                    <span>${color}</span>
                                </div>
                            </div>
                            <div class="space-y-1">
                                <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">MILEAGE</span>
                                <div class="font-bold text-slate-900 font-mono">${mileage}</div>
                            </div>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-3 mt-4">
                        <span class="text-xs font-semibold text-emerald-600">Active Record</span>
                        <button type="button" onclick="openVehicleBookingModal('${title} (${plate})')"
                            class="px-4 py-2 rounded-lg bg-orange-500 hover:bg-orange-600 active:translate-y-0.5 text-white text-xs font-semibold shadow-xs transition-all">
                            Book Service
                        </button>
                    </div>
                </div>
            `;
            grid.prepend(newCard);
            showToast(`${title} (${plate}) registered successfully!`);
        }

        // 8. Vehicle Specs / Edit Helpers
        function showVehicleModal(title, plate, mileage, engine) {
            alert(`Vehicle Specifications:\n\nModel: ${title}\nPlate: ${plate}\nMileage: ${mileage}\nEngine: ${engine}\nStatus: Verified on VWMS Garage Registry`);
        }

        function promptEditVehicle(plate) {
            const newMil = prompt(`Update recorded mileage for ${plate}:`, '50,000 km');
            if (newMil) {
                showToast(`Mileage updated for ${plate}`);
            }
        }

        // 9. Toast Helper
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