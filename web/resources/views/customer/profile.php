<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Profile Details - VWMS Customer Portal</title>
    <meta name="description"
        content="Manage your personal account details, contact information, and security credentials on VWMS Customer Portal.">

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
    </style>
</head>

<body class="bg-[#F8FAFC] text-slate-700 font-sans min-h-screen flex flex-col antialiased selection:bg-orange-500 selection:text-white">

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
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
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
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/40 font-medium text-sm transition-colors duration-150 group">
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-white" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span>Service History</span>
                    </a>

                    <!-- 5. Invoices -->
                    <a href="dashboard.html#invoices"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/40 font-medium text-sm transition-colors duration-150 group">
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        <span>Invoices</span>
                    </a>

                    <!-- 6. Profile (Active) -->
                    <a href="/customer/profile"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-white/5 text-orange-500 font-medium text-sm transition-all duration-150 relative group">
                        <!-- Active Indicator Glow -->
                        <span
                            class="w-1.5 h-4 bg-orange-500 rounded-full absolute left-0 top-1/2 -translate-y-1/2 shadow-[0_0_8px_#F97316]"></span>
                        <svg class="w-5 h-5 text-orange-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"
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
                        <span class="text-slate-900 font-semibold">Profile</span>
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
                        <input type="text" id="globalSearchInput" placeholder="Search license plate"
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
                                <div id="headerAvatar"
                                    class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[#9A3412] text-white flex items-center justify-center font-bold text-xs sm:text-sm shadow-sm overflow-hidden">
                                    <span>KP</span>
                                </div>
                                <span
                                    class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-white rounded-full"></span>
                            </div>

                            <!-- Name & Role -->
                            <div class="hidden sm:flex flex-col text-left leading-tight">
                                <span id="headerProfileName"
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
                                <div id="dropdownFullName" class="font-semibold text-slate-900">Kasun Perera</div>
                                <div id="dropdownEmail" class="text-[11px] text-slate-400 truncate">kasun.perera@example.com</div>
                            </div>
                            <a href="/customer/profile"
                                class="flex items-center gap-2 px-3.5 py-2 bg-slate-50 text-orange-600 font-medium transition-colors">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor"
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
            <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-4xl w-full mx-auto space-y-6">

                <!-- Page Header Block -->
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Profile Details</h1>
                    <p class="text-sm text-slate-500 mt-1">Manage your personal account details, contact information, and security credentials.</p>
                </div>

                <!-- ======================================================== -->
                <!-- PROFILE DETAILS CARD CONTAINER                           -->
                <!-- ======================================================== -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-card p-6 sm:p-8">
                    
                    <form id="profileForm" onsubmit="handleProfileSubmit(event)" class="space-y-8">

                        <!-- Top Identity Block: Big Avatar + Name + Verified Badge -->
                        <div class="flex items-center gap-4">
                            <!-- Initials Avatar Badge -->
                            <div class="relative">
                                <div id="cardAvatar"
                                    class="w-16 h-16 rounded-full bg-[#9A3412] text-white flex items-center justify-center font-bold text-xl tracking-tight shadow-sm select-none">
                                    KP
                                </div>
                                <!-- Online Status Badge -->
                                <span
                                    class="absolute bottom-0.5 right-0.5 w-3.5 h-3.5 bg-emerald-500 border-2 border-white rounded-full shadow-xs"></span>
                            </div>

                            <!-- Name & Verified Check -->
                            <div>
                                <div class="flex items-center gap-2">
                                    <span id="cardFullName" class="text-xl font-bold text-slate-900 tracking-tight">Kasun Perera</span>
                                    <!-- Verified Badge -->
                                    <span title="Verified Account" class="inline-flex text-blue-500">
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Divider Line -->
                        <div class="border-t border-slate-100"></div>

                        <!-- SECTION 1: Personal Information -->
                        <div class="space-y-4">
                            <div>
                                <h2 class="text-base font-bold text-slate-900">Personal Information</h2>
                                <p class="text-xs text-slate-400 mt-0.5">Primary contact details linked to your service and billing profile.</p>
                            </div>

                            <div class="space-y-4 pt-1">
                                <!-- Field 1: Full Name -->
                                <div>
                                    <label for="fullNameInput" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                        Full Name
                                    </label>
                                    <input type="text" id="fullNameInput" value="Kasun Perera" required
                                        class="w-full px-3.5 py-2.5 text-sm bg-white border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/10 transition-all">
                                </div>

                                <!-- Field 2: Email Address -->
                                <div>
                                    <label for="emailInput" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                        Email Address
                                    </label>
                                    <div class="relative flex items-center">
                                        <input type="email" id="emailInput" value="kasun.perera@example.com" required
                                            class="w-full pl-3.5 pr-28 py-2.5 text-sm bg-white border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/10 transition-all">
                                        <!-- Verified Status Pill on Right -->
                                        <span class="absolute right-3 inline-flex items-center gap-1 px-2.5 py-0.5 rounded text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100 select-none pointer-events-none">
                                            <svg class="w-3.5 h-3.5 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                            <span>Verified</span>
                                        </span>
                                    </div>
                                </div>

                                <!-- Field 3: Mobile Number -->
                                <div>
                                    <label for="mobileInput" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                        Mobile Number
                                    </label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                            </svg>
                                        </span>
                                        <input type="tel" id="mobileInput" value="+94 77 123 4567" required
                                            class="w-full pl-10 pr-3.5 py-2.5 text-sm bg-white border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/10 transition-all font-mono sm:font-sans">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Divider Line -->
                        <div class="border-t border-slate-100"></div>

                        <!-- SECTION 2: Security & Password -->
                        <div class="space-y-4">
                            <div>
                                <h2 class="text-base font-bold text-slate-900">Security &amp; Password</h2>
                                <p class="text-xs text-slate-400 mt-0.5">Ensure your account is using a long, random password to stay secure.</p>
                            </div>

                            <div class="space-y-4 pt-1">
                                <!-- Field 1: Current Password -->
                                <div>
                                    <label for="currentPasswordInput" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                        Current Password
                                    </label>
                                    <div class="relative">
                                        <input type="password" id="currentPasswordInput" value="supersecurepwd123"
                                            class="w-full pl-3.5 pr-10 py-2.5 text-sm bg-white border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/10 transition-all tracking-widest font-mono">
                                        <!-- Show/Hide Toggle -->
                                        <button type="button" onclick="togglePasswordVisibility('currentPasswordInput', this)"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition-colors"
                                            aria-label="Toggle password visibility">
                                            <svg class="w-4 h-4 eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                            <svg class="w-4 h-4 eye-closed hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                                <line x1="1" y1="1" x2="23" y2="23"></line>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Field 2: New Password -->
                                <div>
                                    <label for="newPasswordInput" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                        New Password
                                    </label>
                                    <div class="relative">
                                        <input type="password" id="newPasswordInput" placeholder="Enter new password (min. 8 characters)"
                                            class="w-full pl-3.5 pr-10 py-2.5 text-sm bg-white border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/10 transition-all font-mono">
                                        <!-- Show/Hide Toggle -->
                                        <button type="button" onclick="togglePasswordVisibility('newPasswordInput', this)"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition-colors"
                                            aria-label="Toggle password visibility">
                                            <svg class="w-4 h-4 eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                            <svg class="w-4 h-4 eye-closed hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                                <line x1="1" y1="1" x2="23" y2="23"></line>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Divider Line -->
                        <div class="border-t border-slate-100"></div>

                        <!-- Bottom Action Buttons: Cancel & Save Changes -->
                        <div class="flex items-center justify-end gap-3 pt-2">
                            <button type="button" onclick="handleCancel()"
                                class="px-5 py-2 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-700 text-sm font-semibold transition-colors">
                                Cancel
                            </button>
                            <button type="submit" id="saveBtn"
                                class="px-6 py-2 rounded-lg bg-orange-500 hover:bg-orange-600 active:translate-y-0.5 text-white text-sm font-semibold shadow-sm shadow-orange-500/20 transition-all">
                                Save Changes
                            </button>
                        </div>

                    </form>

                </div>

            </main>

            <!-- Bottom Sticky Navigation Bar for Mobile (< lg) -->
            <nav
                class="lg:hidden sticky bottom-0 bg-white border-t border-slate-200 px-4 py-2 flex items-center justify-around z-30 shadow-lg">
                <a href="/customer/dashboard"
                    class="flex flex-col items-center gap-1 text-slate-500 hover:text-slate-800 text-[11px] font-medium">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" rx="1.5"></rect>
                        <rect x="14" y="3" width="7" height="7" rx="1.5"></rect>
                        <rect x="14" y="14" width="7" height="7" rx="1.5"></rect>
                        <rect x="3" y="14" width="7" height="7" rx="1.5"></rect>
                    </svg>
                    <span>Overview</span>
                </a>
                <a href="/customer/vehicles"
                    class="flex flex-col items-center gap-1 text-slate-500 hover:text-slate-800 text-[11px] font-medium">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path
                            d="M14 16H9m10 0h3v-3.15a1 1 0 0 0-.84-.99L16 11l-2.7-3.6a1 1 0 0 0-.8-.4H8.5a1 1 0 0 0-.8.4L5 11l-5.16.86a1 1 0 0 0-.84.99V16h3">
                        </path>
                        <circle cx="6.5" cy="16.5" r="2.5"></circle>
                        <circle cx="16.5" cy="16.5" r="2.5"></circle>
                    </svg>
                    <span>Vehicles</span>
                </a>
                <a href="/customer/appointments"
                    class="flex flex-col items-center gap-1 text-slate-500 hover:text-slate-800 text-[11px] font-medium">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    <span>Appts</span>
                </a>
                <a href="/customer/profile"
                    class="flex flex-col items-center gap-1 text-orange-600 font-semibold text-[11px]">
                    <svg class="w-5 h-5 text-orange-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span>Profile</span>
                </a>
            </nav>

        </div>
    </div>

    <!-- Toast Notification for Dynamic Feedback -->
    <div id="toastNotification"
        class="fixed bottom-5 right-5 z-50 hidden bg-slate-900 text-white text-xs sm:text-sm px-4 py-3 rounded-xl shadow-xl flex items-center gap-3 transition-transform duration-300">
        <svg class="w-5 h-5 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <polyline points="20 6 9 17 4 12"></polyline>
        </svg>
        <span id="toastMessage">Profile details saved successfully!</span>
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

        // 3. Password Show/Hide Toggle
        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            const eyeOpen = btn.querySelector('.eye-open');
            const eyeClosed = btn.querySelector('.eye-closed');

            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }

        // 4. Form Submit Handler (Save Changes)
        function handleProfileSubmit(e) {
            e.preventDefault();
            const fullName = document.getElementById('fullNameInput').value.trim();
            const email = document.getElementById('emailInput').value.trim();
            const newPassword = document.getElementById('newPasswordInput').value;

            if (newPassword && newPassword.length < 8) {
                alert('New password must be at least 8 characters long.');
                return;
            }

            // Compute initials from Full Name (e.g. Kasun Perera -> KP)
            const parts = fullName.split(' ').filter(Boolean);
            let initials = 'KP';
            if (parts.length >= 2) {
                initials = (parts[0][0] + parts[parts.length - 1][0]).toUpperCase();
            } else if (parts.length === 1) {
                initials = parts[0].substring(0, 2).toUpperCase();
            }

            // Update UI elements dynamically
            document.getElementById('cardFullName').textContent = fullName;
            document.getElementById('headerProfileName').textContent = parts[0] || fullName;
            document.getElementById('dropdownFullName').textContent = fullName;
            document.getElementById('dropdownEmail').textContent = email;
            document.getElementById('cardAvatar').textContent = initials;
            document.getElementById('headerAvatar').querySelector('span').textContent = initials;

            // Clear new password input
            document.getElementById('newPasswordInput').value = '';

            // Show Toast
            showToast('Profile details updated successfully!');
        }

        // 5. Cancel Handler (Reset to defaults)
        function handleCancel() {
            if (confirm('Discard changes and reset form?')) {
                document.getElementById('fullNameInput').value = 'Kasun Perera';
                document.getElementById('emailInput').value = 'kasun.perera@example.com';
                document.getElementById('mobileInput').value = '+94 77 123 4567';
                document.getElementById('currentPasswordInput').value = 'supersecurepwd123';
                document.getElementById('newPasswordInput').value = '';
                showToast('Changes discarded.');
            }
        }

        // 6. Toast Helper
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
