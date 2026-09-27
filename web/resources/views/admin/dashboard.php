<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Admin Console - VWMS OS</title>
    <meta name="description"
        content="VWMS Administrator Console - Overview analytics, user management, system settings, backups, notifications log, and core workshop records.">

    <!-- Google Fonts: Inter & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            orange: '#F05A28',
                            'orange-hover': '#D94819',
                            'orange-light': '#FFF7ED',
                            'orange-border': '#FFEDD5',
                        },
                        navy: {
                            900: '#0F172A',
                            800: '#1E293B',
                            700: '#334155',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    }
                }
            }
        }
    </script>

    <style>
        /* Active nav item highlight */
        .nav-item-active {
            background: #F05A28;
            color: #FFFFFF;
        }

        /* Sri Lankan License Plate Badge */
        .sl-plate-badge {
            display: inline-flex;
            align-items: center;
            background-color: #0F172A;
            color: #FFFFFF;
            font-family: 'JetBrains Mono', monospace;
            font-weight: 700;
            border-radius: 4px;
            padding: 2px 6px;
            letter-spacing: 0.05em;
            font-size: 11px;
            line-height: 1.2;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            border: 1px solid #334155;
        }

        .sl-plate-badge .province {
            color: #F05A28;
            margin-right: 4px;
            font-size: 10px;
            font-weight: 800;
        }

        /* Subtle scrollbars */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #F8FAFC;
        }

        ::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94A3B8;
        }
    </style>
</head>

<body class="bg-[#F8FAFC] text-slate-800 font-sans antialiased min-h-screen flex flex-col">

    <div class="flex-1 flex min-h-screen">

        <!-- ======================================================== -->
        <!-- 1. LEFT SIDEBAR: DARK ADMIN NAVIGATION                  -->
        <!-- ======================================================== -->
        <aside id="sidebar"
            class="fixed top-0 bottom-0 left-0 w-64 bg-[#0F172A] text-white z-50 flex flex-col justify-between transition-transform duration-300 -translate-x-full lg:translate-x-0 lg:static lg:z-auto border-r border-slate-800 flex-shrink-0">

            <!-- Top Container: Logo + Menu Items -->
            <div class="flex flex-col">
                <!-- Top Brand: VWMS OS -->
                <div class="px-5 py-5 border-b border-slate-800/80 flex items-center justify-between">
                    <a href="/admin/dashboard" class="flex items-center gap-2.5 group">
                        <div
                            class="w-8 h-8 rounded-lg bg-[#F05A28] flex items-center justify-center shadow-md shadow-orange-500/20 group-hover:scale-105 transition-transform duration-200">
                            <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2L2 7l10 5 10-5-10-5z"></path>
                                <path d="M2 17l10 5 10-5"></path>
                                <path d="M2 12l10 5 10-5"></path>
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <div class="flex items-center text-lg font-bold tracking-tight leading-none">
                                <span class="text-white">VWMS</span>
                                <span class="text-[#F05A28] ml-1.5 font-extrabold">OS</span>
                            </div>
                            <span class="text-[9px] font-semibold text-slate-400 uppercase tracking-widest mt-1">ADMIN
                                CONSOLE</span>
                        </div>
                    </a>

                    <!-- Mobile Drawer Close Button -->
                    <button type="button" class="lg:hidden text-slate-400 hover:text-white p-1"
                        onclick="toggleMobileSidebar(false)">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Navigation List -->
                <nav class="px-3 py-4 space-y-4" aria-label="Admin Navigation">

                    <!-- Group 1: Operations -->
                    <div>
                        <div
                            class="px-3 pb-2 text-[10px] font-bold text-slate-400 tracking-widest uppercase flex items-center justify-between">
                            <span>OPERATIONS</span>
                            <span class="text-[9px] font-semibold text-slate-500">WORKSHOP</span>
                        </div>
                        <div class="space-y-1">
                            <!-- Screen 1: Overview -->
                            <button type="button" onclick="switchAdminScreen('screen-overview')" id="navScreenOverview"
                                class="nav-item-active w-full flex items-center justify-between px-3.5 py-2.5 rounded-lg font-semibold text-sm transition-all duration-150 shadow-sm text-left">
                                <div class="flex items-center gap-3">
                                    <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <rect x="3" y="3" width="7" height="9"></rect>
                                        <rect x="14" y="3" width="7" height="5"></rect>
                                        <rect x="14" y="12" width="7" height="9"></rect>
                                        <rect x="3" y="16" width="7" height="5"></rect>
                                    </svg>
                                    <span>Overview</span>
                                </div>
                                <span
                                    class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-black/25 text-white">Live</span>
                            </button>

                            <!-- Screen: Inventory & Suppliers -->
                            <button type="button" onclick="switchAdminScreen('screen-inventory')"
                                id="navScreenInventory"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-lg text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 font-medium text-sm transition-colors duration-150 text-left">
                                <div class="flex items-center gap-3">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                        </path>
                                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                    </svg>
                                    <span>Inventory &amp; Suppliers</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span
                                        class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-rose-950 text-rose-300 border border-rose-800/40"
                                        id="sidebarLowStockBadge">3 Low</span>
                                </div>
                            </button>
                        </div>
                    </div>

                    <!-- Group 2: Administration -->
                    <div>
                        <div class="px-3 pb-2 text-[10px] font-bold text-slate-400 tracking-widest uppercase">
                            ADMINISTRATION
                        </div>
                        <div class="space-y-1">
                            <!-- Screen 2: User Management -->
                            <button type="button" onclick="switchAdminScreen('screen-users')" id="navScreenUsers"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-lg text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 font-medium text-sm transition-colors duration-150 text-left">
                                <div class="flex items-center gap-3">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                    <span>User Management</span>
                                </div>
                                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-slate-800 text-slate-400"
                                    id="sidebarUserCount">8</span>
                            </button>

                            <!-- Screen 3: System Settings -->
                            <button type="button" onclick="switchAdminScreen('screen-settings')" id="navScreenSettings"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-lg text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 font-medium text-sm transition-colors duration-150 text-left">
                                <div class="flex items-center gap-3">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="3"></circle>
                                        <path
                                            d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                        </path>
                                    </svg>
                                    <span>System Settings</span>
                                </div>
                            </button>

                            <!-- Screen 4: Backups & Exports -->
                            <button type="button" onclick="switchAdminScreen('screen-backups')" id="navScreenBackups"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-lg text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 font-medium text-sm transition-colors duration-150 text-left">
                                <div class="flex items-center gap-3">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                    </svg>
                                    <span>Backups &amp; Exports</span>
                                </div>
                            </button>

                            <!-- Screen 5: Notifications Log -->
                            <button type="button" onclick="switchAdminScreen('screen-notifications')"
                                id="navScreenNotifications"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-lg text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 font-medium text-sm transition-colors duration-150 text-left">
                                <div class="flex items-center gap-3">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                    </svg>
                                    <span>Notifications Log</span>
                                </div>
                                <span
                                    class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-orange-950 text-orange-300 border border-orange-800/40"
                                    id="sidebarNotifBadge">1 Fail</span>
                            </button>

                            <!-- Screen 6: Records -->
                            <button type="button" onclick="switchAdminScreen('screen-records')" id="navScreenRecords"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-lg text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 font-medium text-sm transition-colors duration-150 text-left">
                                <div class="flex items-center gap-3">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg>
                                    <span>Records Archive</span>
                                </div>
                            </button>
                        </div>
                    </div>
                </nav>
            </div>

            <!-- Bottom Section: Administrator Profile Card -->
            <div class="p-3 border-t border-slate-800">
                <div
                    class="border border-dashed border-slate-700/80 rounded-lg p-2.5 flex items-center justify-between bg-slate-900/40">
                    <div class="flex items-center gap-2.5">
                        <div class="relative flex-shrink-0">
                            <div
                                class="w-8 h-8 rounded-full bg-[#EA580C] text-white flex items-center justify-center text-xs font-bold shadow-sm">
                                JP
                            </div>
                            <span
                                class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-[#0F172A] rounded-full"></span>
                        </div>
                        <div class="flex flex-col min-w-0">
                            <span class="text-xs font-bold text-white truncate leading-tight">Jagath Perera</span>
                            <span class="text-[11px] text-slate-400 truncate leading-tight mt-0.5">Workshop
                                Administrator</span>
                        </div>
                    </div>

                    <!-- Logout / Lock -->
                    <button type="button" onclick="logoutAdmin()"
                        class="p-1.5 text-slate-500 hover:text-slate-200 transition-colors"
                        title="Lock Workstation & Logout">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                    </button>
                </div>
            </div>

        </aside>

        <!-- Mobile Sidebar Overlay Backdrop -->
        <div id="sidebarBackdrop" class="fixed inset-0 bg-slate-900/60 z-40 lg:hidden hidden backdrop-blur-sm"
            onclick="toggleMobileSidebar(false)"></div>

        <!-- ======================================================== -->
        <!-- 2. MAIN WORKSPACE CONTAINER                             -->
        <!-- ======================================================== -->
        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">

            <!-- Top Header Bar -->
            <header
                class="bg-white border-b border-slate-200/90 h-16 px-4 sm:px-6 lg:px-8 flex items-center justify-between sticky top-0 z-30 shadow-2xs">

                <div class="flex items-center gap-3">
                    <button type="button"
                        class="lg:hidden text-slate-600 hover:text-slate-900 p-1.5 rounded-md hover:bg-slate-100"
                        onclick="toggleMobileSidebar(true)" aria-label="Open menu">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <!-- Breadcrumbs -->
                    <div class="flex items-center gap-1.5 text-xs text-slate-400">
                        <span class="text-slate-400">/</span>
                        <span id="topBreadcrumbText" class="font-semibold text-slate-800">Overview (Operations
                            Dashboard)</span>
                    </div>
                </div>

                <!-- Right Utilities -->
                <div class="flex items-center gap-3 sm:gap-4">
                    <!-- Notification Bell -->
                    <button type="button" onclick="switchAdminScreen('screen-notifications')"
                        class="w-8 h-8 rounded-full border border-slate-200 bg-white flex items-center justify-center text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors relative"
                        aria-label="Notifications">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                        <span
                            class="absolute -top-1 -right-1 w-4 h-4 bg-[#F05A28] text-white text-[10px] font-bold rounded-full flex items-center justify-center leading-none shadow-sm">
                            3
                        </span>
                    </button>

                    <!-- User Identity Badge: Status dot + Name + Admin label -->
                    <div
                        class="hidden md:inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200 shadow-2xs">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span class="font-bold text-slate-800">Jagath Perera</span>
                        <span class="text-slate-400">•</span>
                        <span class="text-[#F05A28] font-bold">Admin</span>
                    </div>

                    <!-- Profile Circle -->
                    <button type="button" onclick="showToast('Logged in as Administrator (Jagath Perera)')"
                        class="w-8 h-8 rounded-full bg-[#F05A28] text-white flex items-center justify-center text-xs font-bold ring-2 ring-white shadow-sm hover:opacity-95 transition-opacity"
                        aria-label="Admin Account">
                        JP
                    </button>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-[1680px] w-full mx-auto space-y-6">

                <!-- ==================================================== -->
                <!-- SCREEN 1: OVERVIEW (ANALYTICS DASHBOARD)             -->
                <!-- ==================================================== -->
                <div id="viewScreenOverview" class="space-y-6">

                    <!-- Page Headline & Quick Actions -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <h1 class="text-2xl font-extrabold text-[#0F172A] tracking-tight">Workshop Operations
                                Overview</h1>
                            <p class="text-xs text-slate-500 mt-0.5">Live shop floor throughput, job stages, technician
                                workload, and critical system alerts.</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="refreshAnalytics()"
                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold shadow-2xs transition-colors">
                                <svg class="w-3.5 h-3.5 text-slate-500" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <polyline points="23 4 23 10 17 10"></polyline>
                                    <polyline points="1 20 1 14 7 14"></polyline>
                                    <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15">
                                    </path>
                                </svg>
                                <span>Sync Operations</span>
                            </button>
                            <button type="button" onclick="switchAdminScreen('screen-backups')"
                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-[#0F172A] hover:bg-slate-800 text-white text-xs font-bold shadow-xs transition-colors">
                                <span>Create System Snapshot</span>
                            </button>
                        </div>
                    </div>

                    <!-- 1. TOP STAT CARDS -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

                        <!-- Stat 1: Active Jobs (total across all statuses) -->
                        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-2xs space-y-2">
                            <div
                                class="flex items-center justify-between text-xs text-slate-500 font-bold uppercase tracking-wider">
                                <span>Active Jobs</span>
                                <span class="p-1.5 rounded-lg bg-orange-50 text-[#F05A28]">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5">
                                        <path
                                            d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                            <div class="flex items-baseline justify-between">
                                <span class="text-2xl font-black font-mono text-slate-900 tracking-tight">24
                                    Total</span>
                                <span class="text-xs font-bold text-orange-600 bg-orange-50 px-2 py-0.5 rounded-full">18
                                    In Progress</span>
                            </div>
                            <p class="text-[11px] text-slate-400">Across queue, floor stations & QA inspection</p>
                        </div>

                        <!-- Stat 2: Jobs Pending QA -->
                        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-2xs space-y-2">
                            <div
                                class="flex items-center justify-between text-xs text-slate-500 font-bold uppercase tracking-wider">
                                <span>Jobs Pending QA</span>
                                <span class="p-1.5 rounded-lg bg-purple-50 text-purple-600">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5">
                                        <path d="M9 11l3 3L22 4"></path>
                                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                    </svg>
                                </span>
                            </div>
                            <div class="flex items-baseline justify-between">
                                <span class="text-2xl font-black font-mono text-purple-700 tracking-tight">5
                                    Vehicles</span>
                                <span
                                    class="text-xs font-bold text-purple-600 bg-purple-50 px-2 py-0.5 rounded-full">Supervisor
                                    Action</span>
                            </div>
                            <p class="text-[11px] text-slate-400">Repairs completed, awaiting final inspection sign-off
                            </p>
                        </div>

                        <!-- Stat 3: Active Technicians -->
                        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-2xs space-y-2">
                            <div
                                class="flex items-center justify-between text-xs text-slate-500 font-bold uppercase tracking-wider">
                                <span>Active Technicians</span>
                                <span class="p-1.5 rounded-lg bg-blue-50 text-blue-600">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </span>
                            </div>
                            <div class="flex items-baseline justify-between">
                                <span class="text-2xl font-black font-mono text-slate-900 tracking-tight">5 / 6 On
                                    Duty</span>
                                <span
                                    class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">83%
                                    Staffed</span>
                            </div>
                            <p class="text-[11px] text-slate-400">4 Stations active • 1 On scheduled leave</p>
                        </div>

                        <!-- Stat 4: Low-Stock Parts Alerts -->
                        <div onclick="switchAdminScreen('screen-inventory'); switchInventoryTab('parts'); filterPartsStatus('low');"
                            class="bg-white rounded-2xl border border-slate-200/90 hover:border-rose-300 p-5 shadow-2xs space-y-2 cursor-pointer transition-all duration-150 group">
                            <div
                                class="flex items-center justify-between text-xs text-slate-500 font-bold uppercase tracking-wider">
                                <span>Low-Stock Parts Alerts</span>
                                <span
                                    class="p-1.5 rounded-lg bg-rose-50 text-rose-600 group-hover:scale-110 transition-transform">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5">
                                        <path
                                            d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z">
                                        </path>
                                        <line x1="12" y1="9" x2="12" y2="13"></line>
                                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                                    </svg>
                                </span>
                            </div>
                            <div class="flex items-baseline justify-between">
                                <span class="text-2xl font-black font-mono text-rose-600 tracking-tight"
                                    id="overviewLowStockCount">3 Critical
                                    SKUs</span>
                                <span
                                    class="text-xs font-bold text-rose-700 bg-rose-50 px-2 py-0.5 rounded-full border border-rose-200">Alert</span>
                            </div>
                            <p class="text-[11px] text-slate-400 flex items-center justify-between">
                                <span>Breached safe threshold</span>
                                <span class="text-rose-600 font-semibold group-hover:underline text-[10px]">Open Console
                                    →</span>
                            </p>
                        </div>
                    </div>

                    <!-- 2. FOUR OPERATIONAL PANELS (2x2 GRID) -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                        <!-- Panel 1: Job Status Breakdown -->
                        <div class="bg-white rounded-2xl border border-slate-200/90 p-6 shadow-2xs space-y-5">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                                <div>
                                    <h3 class="font-bold text-slate-900 text-sm">Job Status Breakdown</h3>
                                    <p class="text-xs text-slate-400">Total job distribution across floor workflow
                                        stages</p>
                                </div>
                                <span
                                    class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700 font-mono">
                                    24 Active Jobs
                                </span>
                            </div>

                            <!-- Stacked Progress Bar Representation -->
                            <div class="space-y-2">
                                <div class="w-full h-3.5 bg-slate-100 rounded-full overflow-hidden flex shadow-inner">
                                    <div class="bg-amber-400 h-full transition-all" style="width: 17%"
                                        title="Unassigned: 4 (17%)"></div>
                                    <div class="bg-[#F05A28] h-full transition-all" style="width: 37%"
                                        title="In Progress: 9 (37%)"></div>
                                    <div class="bg-purple-600 h-full transition-all" style="width: 21%"
                                        title="Pending QA: 5 (21%)"></div>
                                    <div class="bg-emerald-500 h-full transition-all" style="width: 25%"
                                        title="Completed: 6 (25%)"></div>
                                </div>
                                <div
                                    class="flex items-center justify-between text-[11px] text-slate-500 pt-1 font-medium">
                                    <span class="flex items-center gap-1.5"><span
                                            class="w-2.5 h-2.5 rounded bg-amber-400"></span> Unassigned (4)</span>
                                    <span class="flex items-center gap-1.5"><span
                                            class="w-2.5 h-2.5 rounded bg-[#F05A28]"></span> In Progress (9)</span>
                                    <span class="flex items-center gap-1.5"><span
                                            class="w-2.5 h-2.5 rounded bg-purple-600"></span> Pending QA (5)</span>
                                    <span class="flex items-center gap-1.5"><span
                                            class="w-2.5 h-2.5 rounded bg-emerald-500"></span> Completed (6)</span>
                                </div>
                            </div>

                            <!-- Detailed Stage Breakdown Cards -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1 text-xs">
                                <div class="p-3.5 rounded-xl bg-amber-50/60 border border-amber-200/80 space-y-1">
                                    <div class="flex items-center justify-between font-bold text-amber-900">
                                        <span class="flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                            Unassigned (Queue)
                                        </span>
                                        <span class="font-mono text-amber-800 text-sm">4 Jobs</span>
                                    </div>
                                    <p class="text-[11px] text-amber-700 leading-snug">Checked-in vehicles waiting in
                                        queue for technician allocation.</p>
                                </div>

                                <div class="p-3.5 rounded-xl bg-orange-50/60 border border-orange-200/80 space-y-1">
                                    <div class="flex items-center justify-between font-bold text-orange-900">
                                        <span class="flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full bg-[#F05A28]"></span>
                                            In Progress
                                        </span>
                                        <span class="font-mono text-orange-800 text-sm">9 Jobs</span>
                                    </div>
                                    <p class="text-[11px] text-orange-700 leading-snug">Active mechanical, electrical,
                                        and service repairs underway.</p>
                                </div>

                                <div class="p-3.5 rounded-xl bg-purple-50/60 border border-purple-200/80 space-y-1">
                                    <div class="flex items-center justify-between font-bold text-purple-900">
                                        <span class="flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full bg-purple-600"></span>
                                            Pending QA
                                        </span>
                                        <span class="font-mono text-purple-800 text-sm">5 Jobs</span>
                                    </div>
                                    <p class="text-[11px] text-purple-700 leading-snug">Work completed by technician;
                                        awaiting supervisor road test & sign-off.</p>
                                </div>

                                <div class="p-3.5 rounded-xl bg-emerald-50/60 border border-emerald-200/80 space-y-1">
                                    <div class="flex items-center justify-between font-bold text-emerald-900">
                                        <span class="flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                                            Completed
                                        </span>
                                        <span class="font-mono text-emerald-800 text-sm">6 Jobs</span>
                                    </div>
                                    <p class="text-[11px] text-emerald-700 leading-snug">Quality verified & released
                                        today; ready for customer handoff.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Panel 2: Technician Workload -->
                        <div class="bg-white rounded-2xl border border-slate-200/90 p-6 shadow-2xs space-y-4">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                                <div>
                                    <h3 class="font-bold text-slate-900 text-sm">Technician Workload</h3>
                                    <p class="text-xs text-slate-400">Current assigned job count & floor capacity per
                                        technician</p>
                                </div>
                                <button type="button" onclick="switchAdminScreen('screen-users')"
                                    class="text-xs font-semibold text-[#F05A28] hover:underline">
                                    Manage Staff →
                                </button>
                            </div>

                            <div class="space-y-3 pt-1 text-xs">
                                <!-- Dishan Karunaratne -->
                                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-7 h-7 rounded-lg bg-[#F05A28]/10 text-[#F05A28] font-bold flex items-center justify-center text-xs">
                                                DK</div>
                                            <div>
                                                <span class="font-bold text-slate-900 block leading-tight">Dishan
                                                    Karunaratne</span>
                                                <span class="text-[10px] text-slate-400">Master Technician • Station
                                                    03</span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="font-mono font-bold text-orange-600 text-sm">4 Jobs</span>
                                            <span class="block text-[10px] font-semibold text-orange-600">Near Capacity
                                                (80%)</span>
                                        </div>
                                    </div>
                                    <div class="w-full bg-slate-200 rounded-full h-2">
                                        <div class="bg-[#F05A28] h-2 rounded-full" style="width: 80%"></div>
                                    </div>
                                </div>

                                <!-- Nuwan Pradeep -->
                                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 font-bold flex items-center justify-center text-xs">
                                                NP</div>
                                            <div>
                                                <span class="font-bold text-slate-900 block leading-tight">Nuwan
                                                    Pradeep</span>
                                                <span class="text-[10px] text-slate-400">Diagnostics Lead • Station
                                                    02</span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="font-mono font-bold text-blue-600 text-sm">3 Jobs</span>
                                            <span class="block text-[10px] font-semibold text-blue-600">Optimal Load
                                                (60%)</span>
                                        </div>
                                    </div>
                                    <div class="w-full bg-slate-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: 60%"></div>
                                    </div>
                                </div>

                                <!-- Kasun Perera -->
                                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 font-bold flex items-center justify-center text-xs">
                                                KP</div>
                                            <div>
                                                <span class="font-bold text-slate-900 block leading-tight">Kasun
                                                    Perera</span>
                                                <span class="text-[10px] text-slate-400">Chassis & Suspension • Station
                                                    01</span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="font-mono font-bold text-emerald-600 text-sm">2 Jobs</span>
                                            <span class="block text-[10px] font-semibold text-emerald-600">Available
                                                (40%)</span>
                                        </div>
                                    </div>
                                    <div class="w-full bg-slate-200 rounded-full h-2">
                                        <div class="bg-emerald-500 h-2 rounded-full" style="width: 40%"></div>
                                    </div>
                                </div>

                                <!-- M. Kumara -->
                                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 font-bold flex items-center justify-center text-xs">
                                                MK</div>
                                            <div>
                                                <span class="font-bold text-slate-900 block leading-tight">M.
                                                    Kumara</span>
                                                <span class="text-[10px] text-slate-400">Senior Technician • Station
                                                    04</span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="font-mono font-bold text-blue-600 text-sm">3 Jobs</span>
                                            <span class="block text-[10px] font-semibold text-blue-600">Optimal Load
                                                (60%)</span>
                                        </div>
                                    </div>
                                    <div class="w-full bg-slate-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: 60%"></div>
                                    </div>
                                </div>

                                <!-- Ruwan Jayasuriya -->
                                <div
                                    class="p-3 rounded-xl bg-slate-50/60 border border-slate-200/60 space-y-2 opacity-70">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-7 h-7 rounded-lg bg-slate-200 text-slate-500 font-bold flex items-center justify-center text-xs">
                                                RJ</div>
                                            <div>
                                                <span class="font-bold text-slate-700 block leading-tight">Ruwan
                                                    Jayasuriya</span>
                                                <span class="text-[10px] text-slate-400">Electrical & AC</span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="font-mono font-bold text-slate-500 text-sm">0 Jobs</span>
                                            <span class="block text-[10px] font-semibold text-slate-500">On Scheduled
                                                Leave</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Panel 3: Alerts Panel (Non-Financial System Alerts) -->
                        <div class="bg-white rounded-2xl border border-slate-200/90 p-6 shadow-2xs space-y-4">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                                <div>
                                    <h3 class="font-bold text-slate-900 text-sm">Operational & System Alerts</h3>
                                    <p class="text-xs text-slate-400">Inventory alerts, dispatch health, and floor load
                                        warnings</p>
                                </div>
                                <span
                                    class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                                    3 Critical Alerts
                                </span>
                            </div>

                            <div class="space-y-3 pt-1 text-xs">
                                <!-- Alert 1: Overloaded Tech -->
                                <div
                                    class="p-3.5 rounded-xl bg-orange-50/70 border border-orange-200 flex items-start gap-3">
                                    <div class="p-1.5 rounded-lg bg-orange-100 text-[#F05A28] shrink-0 mt-0.5">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2.2">
                                            <path
                                                d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z">
                                            </path>
                                            <line x1="12" y1="9" x2="12" y2="13"></line>
                                            <line x1="12" y1="17" x2="12.01" y2="17"></line>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-bold text-orange-900">Technician Overloaded Warning</span>
                                            <span class="text-[10px] text-orange-700 font-mono">Floor Notice</span>
                                        </div>
                                        <p class="text-orange-800 text-[11px] mt-0.5 leading-relaxed">
                                            Dishan Karunaratne has reached 4 concurrent jobs (80% ceiling). Recommend
                                            routing incoming vehicles to Kasun Perera (Station 01).
                                        </p>
                                        <div class="mt-2">
                                            <button type="button" onclick="switchAdminScreen('screen-users')"
                                                class="text-xs font-bold text-[#F05A28] hover:underline inline-flex items-center gap-1">
                                                Review Floor Staff Allocations →
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Alert 2: Low-Stock Inventory -->
                                <div
                                    class="p-3.5 rounded-xl bg-rose-50/70 border border-rose-200 flex items-start gap-3">
                                    <div class="p-1.5 rounded-lg bg-rose-100 text-rose-600 shrink-0 mt-0.5">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2.2">
                                            <path
                                                d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                            </path>
                                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-bold text-rose-900">Low Stock Buffer Depleted</span>
                                            <span class="text-[10px] text-rose-700 font-semibold">Low Stock</span>
                                        </div>
                                        <p class="text-rose-800 text-[11px] mt-0.5 leading-relaxed">
                                            Ferodo Brake Pads (2 units remaining), Castrol 5W-30 (3L remaining), and
                                            DOT-4 Fluid (1L remaining) have breached safe reorder limits.
                                        </p>
                                        <div class="mt-2">
                                            <button type="button"
                                                onclick="switchAdminScreen('screen-inventory'); switchInventoryTab('parts'); filterPartsStatus('low');"
                                                class="text-xs font-bold text-rose-700 hover:underline inline-flex items-center gap-1">
                                                Manage Inventory &amp; Restock &rarr;
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Alert 3: Failed Notification Dispatch -->
                                <div
                                    class="p-3.5 rounded-xl bg-amber-50/70 border border-amber-200 flex items-start gap-3">
                                    <div class="p-1.5 rounded-lg bg-amber-100 text-amber-700 shrink-0 mt-0.5">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2.2">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" y1="8" x2="12" y2="12"></line>
                                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-bold text-amber-900">Failed Notification Dispatch</span>
                                            <span class="text-[10px] text-amber-700 font-mono">Gateway Alert</span>
                                        </div>
                                        <p class="text-amber-800 text-[11px] mt-0.5 leading-relaxed">
                                            SMS notification to customer Sunil Fernando (+94 77 982 1104) failed due to
                                            Telco Gateway timeout. Dispatch queued for retry.
                                        </p>
                                        <div class="mt-2">
                                            <button type="button" onclick="switchAdminScreen('screen-notifications')"
                                                class="text-xs font-bold text-amber-800 hover:underline inline-flex items-center gap-1">
                                                Review & Retry Dispatch in Notifications Log →
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Panel 4: Recent System Activity -->
                        <div class="bg-white rounded-2xl border border-slate-200/90 p-6 shadow-2xs space-y-4">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                                <div>
                                    <h3 class="font-bold text-slate-900 text-sm">Recent System Activity</h3>
                                    <p class="text-xs text-slate-400">Chronological feed of key administrative & shop
                                        events</p>
                                </div>
                                <span
                                    class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600">Audit
                                    Stream</span>
                            </div>

                            <div class="space-y-3.5 pt-1 text-xs">
                                <div class="flex items-start gap-3">
                                    <span class="w-2 h-2 rounded-full bg-orange-500 mt-1.5 shrink-0"></span>
                                    <div class="flex-1">
                                        <p class="text-slate-800"><strong class="font-semibold text-slate-900">Job
                                                Created:</strong> Vehicle WP CAB-2041 (Toyota Prius) checked in and
                                            placed into queue for 40,000 km general service.</p>
                                        <span class="text-[10px] text-slate-400 font-mono">8 minutes ago •
                                            Reception</span>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3">
                                    <span class="w-2 h-2 rounded-full bg-purple-500 mt-1.5 shrink-0"></span>
                                    <div class="flex-1">
                                        <p class="text-slate-800"><strong class="font-semibold text-slate-900">Job
                                                Passed QA:</strong> Supervisor Asanka Mendis approved vehicle inspection
                                            and QA sign-off for WP KX-3108.</p>
                                        <span class="text-[10px] text-slate-400 font-mono">24 minutes ago • QA
                                            Floor</span>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3">
                                    <span class="w-2 h-2 rounded-full bg-blue-500 mt-1.5 shrink-0"></span>
                                    <div class="flex-1">
                                        <p class="text-slate-800"><strong
                                                class="font-semibold text-slate-900">Technician Assigned:</strong>
                                            Queued vehicle NW WP-9871 assigned to Technician Dishan Karunaratne (Station
                                            03).</p>
                                        <span class="text-[10px] text-slate-400 font-mono">42 minutes ago • Work
                                            Dispatch</span>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 mt-1.5 shrink-0"></span>
                                    <div class="flex-1">
                                        <p class="text-slate-800"><strong class="font-semibold text-slate-900">User
                                                Added:</strong> New staff profile created for Kasun Perera with
                                            Technician role by Administrator.</p>
                                        <span class="text-[10px] text-slate-400 font-mono">1 hour ago • User
                                            Management</span>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 mt-1.5 shrink-0"></span>
                                    <div class="flex-1">
                                        <p class="text-slate-800"><strong class="font-semibold text-slate-900">Backup
                                                Generated:</strong> Automated system snapshot (24.8 MB, SQL) archived to
                                            encrypted storage.</p>
                                        <span class="text-[10px] text-slate-400 font-mono">3 hours ago • Backup
                                            Scheduler</span>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3">
                                    <span class="w-2 h-2 rounded-full bg-amber-500 mt-1.5 shrink-0"></span>
                                    <div class="flex-1">
                                        <p class="text-slate-800"><strong class="font-semibold text-slate-900">Parts
                                                Requisitioned:</strong> Front brake pad kit and brake fluid checked out
                                            from parts store for job #JOB-1079.</p>
                                        <span class="text-[10px] text-slate-400 font-mono">4 hours ago • Inventory
                                            Store</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- ==================================================== -->
                <!-- SCREEN: INVENTORY & SUPPLIERS                        -->
                <!-- ==================================================== -->
                <div id="viewScreenInventory" class="hidden space-y-6">

                    <!-- Top Page Headline & Primary Actions -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <h1 class="text-2xl font-extrabold text-[#0F172A] tracking-tight">Inventory &amp; Suppliers
                            </h1>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" id="inventoryPrimaryActionBtn"
                                onclick="handleInventoryPrimaryAction()"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[#F05A28] hover:bg-[#D94819] text-white text-xs font-bold shadow-sm transition-all duration-150">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <span id="inventoryPrimaryActionText">+ Add New Part</span>
                            </button>
                            <button type="button" onclick="exportInventoryData()"
                                class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold shadow-2xs transition-colors"
                                title="Export current tab records to CSV">
                                <svg class="w-3.5 h-3.5 text-slate-500" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                </svg>
                                <span class="hidden sm:inline">Export</span>
                            </button>
                        </div>
                    </div>

                    <!-- Top KPI Stat Cards (3 Cards) -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <!-- Stat 1: Total SKUs & Units -->
                        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-2xs space-y-2">
                            <div
                                class="flex items-center justify-between text-xs text-slate-500 font-bold uppercase tracking-wider">
                                <span>Catalog SKUs</span>
                                <span class="p-1.5 rounded-lg bg-blue-50 text-blue-600">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <path
                                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                        </path>
                                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                    </svg>
                                </span>
                            </div>
                            <div class="flex items-baseline justify-between">
                                <span class="text-2xl font-black font-mono text-slate-900 tracking-tight"
                                    id="kpiTotalSKUs">10 Parts</span>
                                <span class="text-xs font-semibold text-slate-500 font-mono" id="kpiTotalUnits">148
                                    Units</span>
                            </div>
                            <p class="text-[11px] text-slate-400">Total active spare parts across warehouse bins</p>
                        </div>

                        <!-- Stat 2: Low-Stock Alerts -->
                        <div onclick="switchInventoryTab('parts'); filterPartsStatus('low');"
                            class="bg-white rounded-2xl border border-slate-200/90 hover:border-rose-300 p-5 shadow-2xs space-y-2 cursor-pointer transition-all duration-150 group">
                            <div
                                class="flex items-center justify-between text-xs text-slate-500 font-bold uppercase tracking-wider">
                                <span>Low-Stock Alerts</span>
                                <span
                                    class="p-1.5 rounded-lg bg-rose-50 text-rose-600 group-hover:scale-110 transition-transform relative">
                                    <span
                                        class="absolute -top-0.5 -right-0.5 w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5">
                                        <path
                                            d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z">
                                        </path>
                                        <line x1="12" y1="9" x2="12" y2="13"></line>
                                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                                    </svg>
                                </span>
                            </div>
                            <div class="flex items-baseline justify-between">
                                <span class="text-2xl font-black font-mono text-rose-600 tracking-tight"
                                    id="kpiLowStockCount">3 Critical</span>
                            </div>
                            <p class="text-[11px] text-slate-400">Stock &le; critical threshold</p>
                        </div>

                        <!-- Stat 3: Active Suppliers -->
                        <div onclick="switchInventoryTab('suppliers')"
                            class="bg-white rounded-2xl border border-slate-200/90 hover:border-orange-300 p-5 shadow-2xs space-y-2 cursor-pointer transition-all duration-150 group">
                            <div
                                class="flex items-center justify-between text-xs text-slate-500 font-bold uppercase tracking-wider">
                                <span>Active Suppliers</span>
                                <span
                                    class="p-1.5 rounded-lg bg-orange-50 text-[#F05A28] group-hover:scale-110 transition-transform">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </span>
                            </div>
                            <div class="flex items-baseline justify-between">
                                <span class="text-2xl font-black font-mono text-slate-900 tracking-tight"
                                    id="kpiActiveSuppliers">5 Vendors</span>
                                <span
                                    class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">All
                                    Verified</span>
                            </div>
                            <p class="text-[11px] text-slate-400 flex items-center justify-between">
                                <span>OEM parts distributors</span>
                                <span class="text-[#F05A28] font-semibold group-hover:underline text-[10px]">View
                                    Vendors &rarr;</span>
                            </p>
                        </div>
                    </div>

                    <!-- 3 Screen Navigation Tabs -->
                    <div class="flex items-center border-b border-slate-200 gap-2">
                        <button type="button" onclick="switchInventoryTab('parts')" id="tabInvParts"
                            class="px-4 py-2.5 font-bold text-xs border-b-2 border-[#F05A28] text-[#F05A28] flex items-center gap-2 transition-colors">
                            <span>Parts Inventory</span>
                            <span id="tabBadgePartsCount"
                                class="text-[10px] font-bold px-1.5 py-0.2 rounded-full bg-orange-100 text-[#F05A28]">10</span>
                        </button>
                        <button type="button" onclick="switchInventoryTab('suppliers')" id="tabInvSuppliers"
                            class="px-4 py-2.5 font-medium text-xs border-b-2 border-transparent text-slate-500 hover:text-slate-800 flex items-center gap-2 transition-colors">
                            <span>Suppliers</span>
                            <span id="tabBadgeSuppliersCount"
                                class="text-[10px] font-bold px-1.5 py-0.2 rounded-full bg-slate-100 text-slate-600">5</span>
                        </button>
                        <button type="button" onclick="switchInventoryTab('movements')" id="tabInvMovements"
                            class="px-4 py-2.5 font-medium text-xs border-b-2 border-transparent text-slate-500 hover:text-slate-800 flex items-center gap-2 transition-colors">
                            <span>Stock Movement Log</span>
                            <span
                                class="text-[10px] font-bold px-1.5 py-0.2 rounded-full bg-slate-100 text-slate-600">Audit
                                Trail</span>
                        </button>
                    </div>

                    <!-- ============================================== -->
                    <!-- TAB 1: PARTS INVENTORY                         -->
                    <!-- ============================================== -->
                    <div id="tabContentParts" class="space-y-4">

                        <!-- Parts Filter & Search Bar -->
                        <div
                            class="bg-white rounded-2xl border border-slate-200/90 p-4 shadow-2xs flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
                            <div class="flex-1 flex flex-wrap items-center gap-2.5">
                                <!-- Search -->
                                <div class="relative min-w-[220px] flex-1 max-w-sm">
                                    <span
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <path d="m21 21-4.35-4.35"></path>
                                        </svg>
                                    </span>
                                    <input type="text" id="partsSearchInput" oninput="filterPartsTable()"
                                        placeholder="Search by part name, SKU, or supplier..."
                                        class="w-full pl-9 pr-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#F05A28] text-slate-800">
                                </div>

                                <!-- Status Filter -->
                                <select id="partsStatusFilter" onchange="filterPartsTable()"
                                    class="text-xs px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-700 outline-none focus:ring-1 focus:ring-[#F05A28]">
                                    <option value="ALL">All Stock Statuses</option>
                                    <option value="LOW">Low Stock Only</option>
                                    <option value="OK">In Stock / Healthy</option>
                                </select>

                                <!-- Category Filter -->
                                <select id="partsCategoryFilter" onchange="filterPartsTable()"
                                    class="text-xs px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-700 outline-none focus:ring-1 focus:ring-[#F05A28]">
                                    <option value="ALL">All Categories</option>
                                    <option value="Braking">Braking</option>
                                    <option value="Fluids">Fluids &amp; Lubricants</option>
                                    <option value="Filters">Filters</option>
                                    <option value="Ignition">Ignition &amp; Electrical</option>
                                    <option value="Suspension">Suspension &amp; Steering</option>
                                    <option value="Engine">Engine &amp; Belts</option>
                                </select>

                                <!-- Supplier Filter -->
                                <select id="partsSupplierFilter" onchange="filterPartsTable()"
                                    class="text-xs px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-700 outline-none focus:ring-1 focus:ring-[#F05A28]">
                                    <option value="ALL">All Linked Suppliers</option>
                                    <!-- Populated dynamically via JS -->
                                </select>

                                <button type="button" onclick="resetPartsFilters()"
                                    class="text-xs text-slate-500 hover:text-slate-800 font-semibold px-2 py-1 rounded hover:bg-slate-100 transition-colors"
                                    title="Reset all filters">
                                    Reset
                                </button>
                            </div>

                            <div class="text-xs text-slate-400 shrink-0">
                                Showing <span id="partsCountDisplay"
                                    class="font-bold text-slate-700 font-mono">10</span> parts
                            </div>
                        </div>

                        <!-- Parts Table -->
                        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-xs" id="partsTable">
                                    <thead
                                        class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                                        <tr>
                                            <th class="py-3 px-4">PART NAME &amp; CATEGORY</th>
                                            <th class="py-3 px-4">SKU / LOCATION</th>
                                            <th class="py-3 px-4">STOCK COUNT</th>
                                            <th class="py-3 px-4">COST PRICE</th>
                                            <th class="py-3 px-4">SELLING PRICE &amp; MARGIN</th>
                                            <th class="py-3 px-4">LINKED SUPPLIER</th>
                                            <th class="py-3 px-4">THRESHOLD</th>
                                            <th class="py-3 px-4">STATUS</th>
                                            <th class="py-3 px-4 text-right">ACTIONS (FULL CONTROL)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 font-medium" id="partsTableBody">
                                        <!-- Injected dynamically via JS -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <!-- ============================================== -->
                    <!-- TAB 2: SUPPLIERS                               -->
                    <!-- ============================================== -->
                    <div id="tabContentSuppliers" class="hidden space-y-4">

                        <!-- Suppliers Filter & Search Bar -->
                        <div
                            class="bg-white rounded-2xl border border-slate-200/90 p-4 shadow-2xs flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                            <div class="flex-1 flex flex-wrap items-center gap-2.5">
                                <div class="relative min-w-[240px] flex-1 max-w-sm">
                                    <span
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <path d="m21 21-4.35-4.35"></path>
                                        </svg>
                                    </span>
                                    <input type="text" id="suppliersSearchInput" oninput="filterSuppliersTable()"
                                        placeholder="Search supplier, contact person, phone, email..."
                                        class="w-full pl-9 pr-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#F05A28] text-slate-800">
                                </div>

                                <select id="suppliersStatusFilter" onchange="filterSuppliersTable()"
                                    class="text-xs px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-700 outline-none focus:ring-1 focus:ring-[#F05A28]">
                                    <option value="ALL">All Supplier Statuses</option>
                                    <option value="Active">Active Only</option>
                                    <option value="Inactive">Inactive / Suspended</option>
                                </select>
                            </div>

                            <div class="flex items-center gap-2.5">
                                <span class="text-xs text-slate-400">
                                    Showing <span id="suppliersCountDisplay"
                                        class="font-bold text-slate-700 font-mono">5</span> vendors
                                </span>
                                <button type="button" onclick="openAddSupplierModal()"
                                    class="px-3.5 py-1.5 rounded-lg bg-[#F05A28] hover:bg-[#D94819] text-white text-xs font-bold shadow-2xs transition-colors">
                                    + Add Supplier
                                </button>
                            </div>
                        </div>

                        <!-- Suppliers Table -->
                        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-xs" id="suppliersTable">
                                    <thead
                                        class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                                        <tr>
                                            <th class="py-3 px-4">SUPPLIER COMPANY &amp; CATEGORY</th>
                                            <th class="py-3 px-4">PRIMARY CONTACT PERSON</th>
                                            <th class="py-3 px-4">CONTACT CHANNELS</th>
                                            <th class="py-3 px-4">PARTS SUPPLIED (CATALOG)</th>
                                            <th class="py-3 px-4">STATUS</th>
                                            <th class="py-3 px-4 text-right">ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 font-medium" id="suppliersTableBody">
                                        <!-- Injected dynamically via JS -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <!-- ============================================== -->
                    <!-- TAB 3: STOCK MOVEMENT LOG (AUDIT TRAIL)        -->
                    <!-- ============================================== -->
                    <div id="tabContentMovements" class="hidden space-y-4">

                        <div class="bg-blue-50/70 border border-blue-200 rounded-xl p-3.5 flex items-start gap-3">
                            <span class="p-1.5 rounded-lg bg-blue-100 text-blue-700 shrink-0 mt-0.5">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="16" x2="12" y2="12"></line>
                                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                </svg>
                            </span>
                            <div class="text-xs text-blue-900 leading-relaxed">
                                <span class="font-bold">Permanent Audit Trail:</span> Every spare part restock receipt,
                                floor job checkout, manual adjustment (+/-), and write-off is logged below with
                                timestamps and administrator attribution.
                            </div>
                        </div>

                        <!-- Movements Filter & Search Bar -->
                        <div
                            class="bg-white rounded-2xl border border-slate-200/90 p-4 shadow-2xs flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
                            <div class="flex-1 flex flex-wrap items-center gap-2.5">
                                <div class="relative min-w-[240px] flex-1 max-w-sm">
                                    <span
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <path d="m21 21-4.35-4.35"></path>
                                        </svg>
                                    </span>
                                    <input type="text" id="movementsSearchInput" oninput="filterMovementsTable()"
                                        placeholder="Search part, SKU, reference job #, reason, staff..."
                                        class="w-full pl-9 pr-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#F05A28] text-slate-800">
                                </div>

                                <select id="movementsTypeFilter" onchange="filterMovementsTable()"
                                    class="text-xs px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-700 outline-none focus:ring-1 focus:ring-[#F05A28]">
                                    <option value="ALL">All Movement Reasons</option>
                                    <option value="RESTOCK">Restock / Supplier Receipt (+)</option>
                                    <option value="JOB">Used in Job (-)</option>
                                    <option value="MANUAL">Manual Adjustment (+/-)</option>
                                    <option value="INITIAL">Initial Provision (+)</option>
                                    <option value="DAMAGED">Damaged / Expired Write-off (-)</option>
                                </select>
                            </div>

                            <div class="flex items-center gap-2.5">
                                <span class="text-xs text-slate-400">
                                    Showing <span id="movementsCountDisplay"
                                        class="font-bold text-slate-700 font-mono">12</span> entries
                                </span>
                                <button type="button" onclick="openAdjustStockModal()"
                                    class="px-3.5 py-1.5 rounded-lg bg-[#0F172A] hover:bg-slate-800 text-white text-xs font-bold shadow-2xs transition-colors">
                                    + Adjust Stock
                                </button>
                            </div>
                        </div>

                        <!-- Movements Table -->
                        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-xs" id="movementsTable">
                                    <thead
                                        class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                                        <tr>
                                            <th class="py-3 px-4">TIMESTAMP</th>
                                            <th class="py-3 px-4">SPARE PART &amp; SKU</th>
                                            <th class="py-3 px-4">STOCK CHANGE</th>
                                            <th class="py-3 px-4">BALANCE (BEFORE &rarr; AFTER)</th>
                                            <th class="py-3 px-4">REASON &amp; REFERENCE</th>
                                            <th class="py-3 px-4 text-right">BY WHOM</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 font-medium" id="movementsTableBody">
                                        <!-- Injected dynamically via JS -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- ==================================================== -->
                <!-- SCREEN 2: USER MANAGEMENT                            -->
                <!-- ==================================================== -->
                <div id="viewScreenUsers" class="hidden space-y-6">

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <h1 class="text-2xl font-extrabold text-[#0F172A] tracking-tight">Staff & User Management
                            </h1>
                            <p class="text-xs text-slate-500 mt-0.5">Control role-based access, account status, security
                                resets, and staff credentials.</p>
                        </div>
                        <button type="button" onclick="openAddUserModal()"
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-[#F05A28] hover:bg-[#D94819] text-white text-xs font-bold shadow-sm transition-colors">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            <span>+ Add User</span>
                        </button>
                    </div>

                    <!-- Search & Filter Bar -->
                    <div
                        class="bg-white rounded-2xl border border-slate-200/90 p-4 shadow-2xs flex flex-wrap items-center justify-between gap-3">
                        <div class="relative w-72">
                            <span
                                class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <path d="m21 21-4.35-4.35"></path>
                                </svg>
                            </span>
                            <input type="text" id="userSearchInput" oninput="filterUserTable()"
                                placeholder="Search user name, email, or role..."
                                class="w-full pl-9 pr-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#F05A28] focus:border-[#F05A28] text-slate-800">
                        </div>

                        <!-- Role Filter Chips -->
                        <div class="flex flex-wrap items-center gap-1.5 text-xs">
                            <span class="text-[11px] font-bold text-slate-400 mr-1 uppercase">Role:</span>
                            <button type="button" onclick="filterUserByRole('ALL')" id="roleFilterAll"
                                class="px-2.5 py-1 rounded-lg bg-[#F05A28] text-white font-semibold shadow-2xs transition-colors">All</button>
                            <button type="button" onclick="filterUserByRole('Admin')" id="roleFilterAdmin"
                                class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold transition-colors">Admin</button>
                            <button type="button" onclick="filterUserByRole('Supervisor')" id="roleFilterSupervisor"
                                class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold transition-colors">Supervisor</button>
                            <button type="button" onclick="filterUserByRole('Front Desk')" id="roleFilterFrontDesk"
                                class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold transition-colors">Front
                                Desk</button>
                            <button type="button" onclick="filterUserByRole('Technician')" id="roleFilterTechnician"
                                class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold transition-colors">Technician</button>
                        </div>
                    </div>

                    <!-- User Table -->
                    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs" id="userTable">
                                <thead
                                    class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                                    <tr>
                                        <th class="py-3.5 px-4">USER</th>
                                        <th class="py-3.5 px-4">ROLE ASSIGNMENT</th>
                                        <th class="py-3.5 px-4">ACCOUNT STATUS</th>
                                        <th class="py-3.5 px-4">LAST LOGIN</th>
                                        <th class="py-3.5 px-4 text-right">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 font-medium" id="userTableBody">
                                    <!-- Populated dynamically via JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Role Permissions Reference Panel (Read-only Summary) -->
                    <div class="bg-white rounded-2xl border border-slate-200/90 p-6 shadow-2xs space-y-4">
                        <div class="flex items-center gap-2 border-b border-slate-100 pb-3">
                            <svg class="w-4 h-4 text-[#F05A28]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <h3 class="font-bold text-slate-900 text-sm">Role Permissions Reference Matrix (Read-Only)
                            </h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-xs">
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                                <span
                                    class="font-bold text-purple-700 bg-purple-100 px-2 py-0.5 rounded text-[10px] uppercase">Admin</span>
                                <p class="text-slate-600 leading-relaxed text-[11px]">Full workshop authorization:
                                    system configuration, user role provisioning, database backups, financial reporting,
                                    and gateway credentials.</p>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                                <span
                                    class="font-bold text-blue-700 bg-blue-100 px-2 py-0.5 rounded text-[10px] uppercase">Supervisor</span>
                                <p class="text-slate-600 leading-relaxed text-[11px]">Shop floor management: active jobs
                                    board, queued vehicle technician assignments, QA inspection approvals, rework
                                    requests, and vehicle records.</p>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                                <span
                                    class="font-bold text-orange-700 bg-orange-100 px-2 py-0.5 rounded text-[10px] uppercase">Front
                                    Desk</span>
                                <p class="text-slate-600 leading-relaxed text-[11px]">Customer & vehicle reception:
                                    vehicle check-in, customer registrations, daily booking schedule, service triage,
                                    and checkout invoicing.</p>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                                <span
                                    class="font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded text-[10px] uppercase">Technician</span>
                                <p class="text-slate-600 leading-relaxed text-[11px]">Floor execution: assigned jobs
                                    list, job time-tracking, parts requisition, completion checklists, and handoff to
                                    supervisor QA.</p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- ==================================================== -->
                <!-- SCREEN 3: SYSTEM SETTINGS                            -->
                <!-- ==================================================== -->
                <div id="viewScreenSettings" class="hidden space-y-6">

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <h1 class="text-2xl font-extrabold text-[#0F172A] tracking-tight">System Settings</h1>
                            <p class="text-xs text-slate-500 mt-0.5">Workshop identity, security policies, messaging
                                gateways, payment processing, and quotation rates.</p>
                        </div>
                        <button type="button" onclick="saveSystemSettings()"
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-[#F05A28] hover:bg-[#D94819] text-white text-xs font-bold shadow-sm transition-colors">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            <span>Save All Settings</span>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 text-xs">

                        <!-- 1. Workshop Profile Info -->
                        <div class="bg-white rounded-2xl border border-slate-200/90 p-6 shadow-2xs space-y-4">
                            <h3
                                class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#F05A28]" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                </svg>
                                Workshop Profile Information
                            </h3>

                            <div class="space-y-3">
                                <div>
                                    <label class="block font-semibold text-slate-700 mb-1">Workshop Trading Name</label>
                                    <input type="text" id="settingWorkshopName" value="VWMS Auto Care Center (Pvt) Ltd"
                                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-slate-800 focus:ring-1 focus:ring-[#F05A28] outline-none">
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block font-semibold text-slate-700 mb-1">Business Registration /
                                            VAT No.</label>
                                        <input type="text" id="settingTaxId" value="PV-98214 / VAT-11498231"
                                            class="w-full px-3 py-2 border border-slate-200 rounded-lg text-slate-800 focus:ring-1 focus:ring-[#F05A28] outline-none font-mono">
                                    </div>
                                    <div>
                                        <label class="block font-semibold text-slate-700 mb-1">Hotline Contact</label>
                                        <input type="text" id="settingHotline" value="+94 11 268 9900"
                                            class="w-full px-3 py-2 border border-slate-200 rounded-lg text-slate-800 focus:ring-1 focus:ring-[#F05A28] outline-none font-mono">
                                    </div>
                                </div>
                                <div>
                                    <label class="block font-semibold text-slate-700 mb-1">Workshop Street
                                        Address</label>
                                    <input type="text" id="settingAddress"
                                        value="No. 45/2, Baseline Road, Colombo 09, Sri Lanka"
                                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-slate-800 focus:ring-1 focus:ring-[#F05A28] outline-none">
                                </div>
                                <div>
                                    <label class="block font-semibold text-slate-700 mb-1">Operating Business
                                        Hours</label>
                                    <input type="text" id="settingHours"
                                        value="Mon - Sat: 07:30 AM - 06:30 PM | Sun: Closed"
                                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-slate-800 focus:ring-1 focus:ring-[#F05A28] outline-none">
                                </div>
                            </div>
                        </div>

                        <!-- 2. Security Settings -->
                        <div class="bg-white rounded-2xl border border-slate-200/90 p-6 shadow-2xs space-y-4">
                            <h3
                                class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#F05A28]" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                                Security & Authentication Policies
                            </h3>

                            <div class="space-y-3.5 pt-1">
                                <div>
                                    <label class="block font-semibold text-slate-700 mb-1">Workstation Inactivity
                                        Session Timeout</label>
                                    <select id="settingTimeout"
                                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-slate-800 focus:ring-1 focus:ring-[#F05A28] outline-none">
                                        <option value="15">15 Minutes (Strict Security)</option>
                                        <option value="30" selected>30 Minutes (Recommended)</option>
                                        <option value="60">60 Minutes</option>
                                        <option value="shift">Keep active for entire 8-hour shift</option>
                                    </select>
                                </div>

                                <div
                                    class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                                    <div>
                                        <span class="font-bold text-slate-800 block">Enforce Strong Password
                                            Policy</span>
                                        <span class="text-[11px] text-slate-400">Min 8 chars, uppercase, numerical
                                            digit, and special symbol</span>
                                    </div>
                                    <input type="checkbox" id="settingPasswordPolicy" checked
                                        class="w-4 h-4 text-[#F05A28] rounded">
                                </div>

                                <div
                                    class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                                    <div>
                                        <span class="font-bold text-slate-800 block">Mandatory 2FA for Admin
                                            Accounts</span>
                                        <span class="text-[11px] text-slate-400">Requires OTP verification when logging
                                            in from new IP address</span>
                                    </div>
                                    <input type="checkbox" id="setting2FA" checked
                                        class="w-4 h-4 text-[#F05A28] rounded">
                                </div>
                            </div>
                        </div>

                        <!-- 3. Notification Channel Config (SMS, WhatsApp, Email) -->
                        <div class="bg-white rounded-2xl border border-slate-200/90 p-6 shadow-2xs space-y-4">
                            <h3
                                class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#F05A28]" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                                Notification Channels & API Gateways
                            </h3>

                            <div class="space-y-3.5">
                                <!-- SMS Gateway -->
                                <div class="p-3 rounded-xl border border-slate-200 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-slate-800 flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                            SMS Gateway (Dialog / Mobitel Enterprise)
                                        </span>
                                        <input type="checkbox" id="settingEnableSMS" checked
                                            class="w-4 h-4 text-[#F05A28] rounded">
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <input type="text" placeholder="Sender ID (e.g. VWMS-ALERT)" value="VWMS-ALERT"
                                            class="px-2.5 py-1.5 border border-slate-200 rounded text-slate-800">
                                        <input type="password" placeholder="API Key / Auth Token"
                                            value="d92847291048291038"
                                            class="px-2.5 py-1.5 border border-slate-200 rounded font-mono text-slate-800">
                                    </div>
                                </div>

                                <!-- WhatsApp Business API -->
                                <div class="p-3 rounded-xl border border-slate-200 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-slate-800 flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                            WhatsApp Cloud Business API
                                        </span>
                                        <input type="checkbox" id="settingEnableWA" checked
                                            class="w-4 h-4 text-[#F05A28] rounded">
                                    </div>
                                    <input type="password" placeholder="System User Access Token"
                                        value="EAAC310892487192"
                                        class="w-full px-2.5 py-1.5 border border-slate-200 rounded font-mono text-slate-800">
                                </div>

                                <!-- Email Gateway -->
                                <div class="p-3 rounded-xl border border-slate-200 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-slate-800 flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                            Email Gateway (SMTP TLS)
                                        </span>
                                        <input type="checkbox" id="settingEnableEmail" checked
                                            class="w-4 h-4 text-[#F05A28] rounded">
                                    </div>
                                    <div class="grid grid-cols-3 gap-2">
                                        <input type="text" placeholder="smtp.service.lk" value="smtp.vwms.lk"
                                            class="px-2.5 py-1.5 border border-slate-200 rounded">
                                        <input type="text" placeholder="Port" value="587"
                                            class="px-2.5 py-1.5 border border-slate-200 rounded font-mono">
                                        <input type="text" placeholder="no-reply@vwms.lk" value="alerts@vwms.lk"
                                            class="px-2.5 py-1.5 border border-slate-200 rounded">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Payment Gateway & Tax / Labor Defaults -->
                        <div class="bg-white rounded-2xl border border-slate-200/90 p-6 shadow-2xs space-y-4">
                            <h3
                                class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#F05A28]" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                    <line x1="1" y1="10" x2="23" y2="10"></line>
                                </svg>
                                Payment Gateway & Quotation Rates
                            </h3>

                            <div class="space-y-3">
                                <!-- PayHere Settings -->
                                <div class="p-3 rounded-xl bg-orange-50/50 border border-orange-200 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-orange-950">PayHere Merchant Gateway</span>
                                        <span
                                            class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">Verified
                                            Live</span>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <span class="text-[10px] text-slate-500 font-semibold block">Merchant
                                                ID</span>
                                            <input type="text" value="1224890"
                                                class="w-full px-2.5 py-1.5 border border-slate-200 rounded font-mono bg-white text-slate-800">
                                        </div>
                                        <div>
                                            <span class="text-[10px] text-slate-500 font-semibold block">Merchant
                                                Secret</span>
                                            <input type="password" value="849204928103928104"
                                                class="w-full px-2.5 py-1.5 border border-slate-200 rounded font-mono bg-white text-slate-800">
                                        </div>
                                    </div>
                                </div>

                                <!-- Tax & Labor Rate Defaults -->
                                <div class="grid grid-cols-2 gap-3 pt-1">
                                    <div>
                                        <label class="block font-semibold text-slate-700 mb-1">Standard Labor Rate (LKR
                                            / hr)</label>
                                        <input type="number" id="settingLaborRate" value="2500"
                                            class="w-full px-3 py-2 border border-slate-200 rounded-lg font-mono text-slate-800">
                                    </div>
                                    <div>
                                        <label class="block font-semibold text-slate-700 mb-1">Standard VAT Rate
                                            (%)</label>
                                        <input type="number" id="settingVatRate" value="18"
                                            class="w-full px-3 py-2 border border-slate-200 rounded-lg font-mono text-slate-800">
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block font-semibold text-slate-700 mb-1">SSCL Levy Rate
                                            (%)</label>
                                        <input type="number" id="settingSsclRate" value="2.5" step="0.5"
                                            class="w-full px-3 py-2 border border-slate-200 rounded-lg font-mono text-slate-800">
                                    </div>
                                    <div>
                                        <label class="block font-semibold text-slate-700 mb-1">Emergency Diagnostics Fee
                                            (LKR)</label>
                                        <input type="number" id="settingDiagRate" value="3500"
                                            class="w-full px-3 py-2 border border-slate-200 rounded-lg font-mono text-slate-800">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- ==================================================== -->
                <!-- SCREEN 4: BACKUPS & EXPORTS                         -->
                <!-- ==================================================== -->
                <div id="viewScreenBackups" class="hidden space-y-6">

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <h1 class="text-2xl font-extrabold text-[#0F172A] tracking-tight">Database Backups &
                                System Exports</h1>
                            <p class="text-xs text-slate-500 mt-0.5">Generate single-click system dumps, schedule
                                automated snapshots, and export database archives.</p>
                        </div>
                    </div>

                    <!-- Single-Click Generate Backup Panel -->
                    <div class="bg-white rounded-2xl border border-slate-200/90 p-6 shadow-2xs space-y-5">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                <h3 class="font-bold text-slate-900 text-sm">Generate Immediate Snapshot Backup</h3>
                                <p class="text-xs text-slate-500 mt-0.5">Instantly packages all workshop tables, job
                                    cards, vehicle profiles, and invoices.</p>
                            </div>

                            <!-- Format Selector -->
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-semibold text-slate-600">Dump Format:</span>
                                <div
                                    class="flex items-center bg-slate-100 p-1 rounded-lg border border-slate-200 text-xs">
                                    <button type="button" onclick="setBackupFormat('SQL')" id="fmtSQL"
                                        class="px-3 py-1 rounded-md font-bold bg-white text-slate-900 shadow-2xs">SQL</button>
                                    <button type="button" onclick="setBackupFormat('JSON')" id="fmtJSON"
                                        class="px-3 py-1 rounded-md text-slate-500 hover:text-slate-900">JSON</button>
                                    <button type="button" onclick="setBackupFormat('TOML')" id="fmtTOML"
                                        class="px-3 py-1 rounded-md text-slate-500 hover:text-slate-900">TOML</button>
                                    <button type="button" onclick="setBackupFormat('CSV')" id="fmtCSV"
                                        class="px-3 py-1 rounded-md text-slate-500 hover:text-slate-900">CSV</button>
                                </div>
                            </div>
                        </div>

                        <!-- CTA Button -->
                        <div
                            class="pt-2 flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-t border-slate-100">
                            <span class="text-xs text-slate-400 font-mono">Includes: 1,482 customers • 2,190 vehicles •
                                3,890 job sheets</span>
                            <button type="button" onclick="triggerImmediateBackup()" id="generateBackupBtn"
                                class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl bg-[#F05A28] hover:bg-[#D94819] text-white text-xs font-bold shadow-md shadow-orange-500/20 active:translate-y-0.5 transition-all">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                </svg>
                                <span id="generateBackupText">Generate Backup Now</span>
                            </button>
                        </div>
                    </div>

                    <!-- Schedule Status Banner -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                        <div class="bg-white rounded-xl border border-slate-200 p-4 space-y-1">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Automated
                                Cron Schedule</span>
                            <span class="font-bold text-slate-900 block">Daily at 02:00 AM (UTC+5:30)</span>
                            <span class="text-[11px] text-emerald-600 font-medium">Status: Active & Verified</span>
                        </div>
                        <div class="bg-white rounded-xl border border-slate-200 p-4 space-y-1">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Storage
                                Target</span>
                            <span class="font-bold text-slate-900 block">Encrypted S3 Cloud + Local Node</span>
                            <span class="text-[11px] text-slate-500">256-bit AES Encryption</span>
                        </div>
                        <div class="bg-white rounded-xl border border-slate-200 p-4 space-y-1">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Retention
                                Window</span>
                            <span class="font-bold text-slate-900 block">30 Daily + 12 Monthly Snapshots</span>
                            <span class="text-[11px] text-slate-500">Next cycle in 3h 25m</span>
                        </div>
                    </div>

                    <!-- List of Past Backups -->
                    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                            <h3 class="font-bold text-slate-900 text-sm">Archived Backup History</h3>
                            <span class="text-xs text-slate-400">Total: 4 Verified Archives</span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs" id="backupsTable">
                                <thead
                                    class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                                    <tr>
                                        <th class="py-3 px-4">BACKUP ARCHIVE</th>
                                        <th class="py-3 px-4">FORMAT</th>
                                        <th class="py-3 px-4">FILE SIZE</th>
                                        <th class="py-3 px-4">TIMESTAMP</th>
                                        <th class="py-3 px-4">TRIGGERED BY</th>
                                        <th class="py-3 px-4 text-right">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 font-medium" id="backupsTableBody">
                                    <tr>
                                        <td class="py-3.5 px-4 font-mono font-bold text-slate-900">
                                            vwms_backup_2026_09_26_0200.sql</td>
                                        <td class="py-3.5 px-4"><span
                                                class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-700">SQL</span>
                                        </td>
                                        <td class="py-3.5 px-4 font-mono text-slate-600">24.8 MB</td>
                                        <td class="py-3.5 px-4 text-slate-500">Today, 02:00 AM</td>
                                        <td class="py-3.5 px-4 text-slate-500">System Cron</td>
                                        <td class="py-3.5 px-4 text-right">
                                            <button type="button"
                                                onclick="downloadBackupMock('vwms_backup_2026_09_26_0200.sql')"
                                                class="px-3 py-1 text-xs font-semibold text-[#F05A28] hover:bg-orange-50 rounded border border-orange-200 transition-colors">
                                                Download ↓
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-3.5 px-4 font-mono font-bold text-slate-900">
                                            vwms_backup_2026_09_25_0200.sql</td>
                                        <td class="py-3.5 px-4"><span
                                                class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-700">SQL</span>
                                        </td>
                                        <td class="py-3.5 px-4 font-mono text-slate-600">24.6 MB</td>
                                        <td class="py-3.5 px-4 text-slate-500">Yesterday, 02:00 AM</td>
                                        <td class="py-3.5 px-4 text-slate-500">System Cron</td>
                                        <td class="py-3.5 px-4 text-right">
                                            <button type="button"
                                                onclick="downloadBackupMock('vwms_backup_2026_09_25_0200.sql')"
                                                class="px-3 py-1 text-xs font-semibold text-[#F05A28] hover:bg-orange-50 rounded border border-orange-200 transition-colors">
                                                Download ↓
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-3.5 px-4 font-mono font-bold text-slate-900">
                                            vwms_export_weekly_dump.json</td>
                                        <td class="py-3.5 px-4"><span
                                                class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700">JSON</span>
                                        </td>
                                        <td class="py-3.5 px-4 font-mono text-slate-600">18.2 MB</td>
                                        <td class="py-3.5 px-4 text-slate-500">2026-09-21, 10:15 AM</td>
                                        <td class="py-3.5 px-4 text-slate-500">Admin (Manual)</td>
                                        <td class="py-3.5 px-4 text-right">
                                            <button type="button"
                                                onclick="downloadBackupMock('vwms_export_weekly_dump.json')"
                                                class="px-3 py-1 text-xs font-semibold text-[#F05A28] hover:bg-orange-50 rounded border border-orange-200 transition-colors">
                                                Download ↓
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-3.5 px-4 font-mono font-bold text-slate-900">
                                            vwms_monthly_ledger_august.csv</td>
                                        <td class="py-3.5 px-4"><span
                                                class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-50 text-amber-700">CSV</span>
                                        </td>
                                        <td class="py-3.5 px-4 font-mono text-slate-600">8.4 MB</td>
                                        <td class="py-3.5 px-4 text-slate-500">2026-08-31, 11:59 PM</td>
                                        <td class="py-3.5 px-4 text-slate-500">Audit Ledger</td>
                                        <td class="py-3.5 px-4 text-right">
                                            <button type="button"
                                                onclick="downloadBackupMock('vwms_monthly_ledger_august.csv')"
                                                class="px-3 py-1 text-xs font-semibold text-[#F05A28] hover:bg-orange-50 rounded border border-orange-200 transition-colors">
                                                Download ↓
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <!-- ==================================================== -->
                <!-- SCREEN 5: NOTIFICATIONS LOG                          -->
                <!-- ==================================================== -->
                <div id="viewScreenNotifications" class="hidden space-y-6">

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <h1 class="text-2xl font-extrabold text-[#0F172A] tracking-tight">System Notifications Log
                            </h1>
                            <p class="text-xs text-slate-500 mt-0.5">Audit log of customer and staff notifications
                                dispatched via SMS, WhatsApp, and Email.</p>
                        </div>
                        <button type="button" onclick="testNotificationEvent()"
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold shadow-sm transition-colors">
                            <span>Trigger Test Alert</span>
                        </button>
                    </div>

                    <!-- Filters -->
                    <div
                        class="bg-white rounded-2xl border border-slate-200/90 p-4 shadow-2xs flex flex-wrap items-center justify-between gap-3">
                        <div class="flex flex-wrap items-center gap-3">
                            <select id="notifEventTypeFilter" onchange="filterNotificationLog()"
                                class="px-3 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-lg text-slate-700 outline-none focus:ring-1 focus:ring-[#F05A28]">
                                <option value="ALL">All Event Types</option>
                                <option value="Vehicle Repaired">Vehicle Repaired</option>
                                <option value="Vehicle Checked In">Vehicle Checked In</option>
                                <option value="Out-of-Stock Parts Arrived">Out-of-Stock Parts Arrived</option>
                                <option value="Invoice Ready">Invoice Ready</option>
                            </select>

                            <select id="notifStatusFilter" onchange="filterNotificationLog()"
                                class="px-3 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-lg text-slate-700 outline-none focus:ring-1 focus:ring-[#F05A28]">
                                <option value="ALL">All Statuses</option>
                                <option value="Sent">Sent (Delivered)</option>
                                <option value="Failed">Failed (Requires Retry)</option>
                                <option value="Queued">Queued</option>
                            </select>
                        </div>

                        <div class="text-xs text-slate-400">
                            Showing <span id="notifCountDisplay" class="font-bold text-slate-700">5</span> events
                        </div>
                    </div>

                    <!-- Notifications Table -->
                    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs" id="notifTable">
                                <thead
                                    class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                                    <tr>
                                        <th class="py-3 px-4">EVENT TYPE</th>
                                        <th class="py-3 px-4">TARGET RECIPIENT</th>
                                        <th class="py-3 px-4">CHANNEL</th>
                                        <th class="py-3 px-4">STATUS</th>
                                        <th class="py-3 px-4">TIMESTAMP</th>
                                        <th class="py-3 px-4 text-right">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 font-medium" id="notifTableBody">
                                    <!-- Populated via JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <!-- ==================================================== -->
                <!-- SCREEN 6: RECORDS (CUSTOMERS, VEHICLES, INVOICES, PARTS) -->
                <!-- ==================================================== -->
                <div id="viewScreenRecords" class="hidden space-y-6">

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <h1 class="text-2xl font-extrabold text-[#0F172A] tracking-tight">Core Workshop Records</h1>
                            <p class="text-xs text-slate-500 mt-0.5">Centralized read-only records database with
                                correction tools and data exports.</p>
                        </div>
                        <button type="button" onclick="exportCurrentRecords()"
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-sm transition-colors">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                            <span>Export Current Table</span>
                        </button>
                    </div>

                    <!-- Entity Navigation Tabs -->
                    <div class="flex items-center border-b border-slate-200 gap-2">
                        <button type="button" onclick="switchRecordsEntity('customers')" id="tabEntityCustomers"
                            class="px-4 py-2.5 font-bold text-xs border-b-2 border-[#F05A28] text-[#F05A28] transition-colors">
                            Customers (6)
                        </button>
                        <button type="button" onclick="switchRecordsEntity('vehicles')" id="tabEntityVehicles"
                            class="px-4 py-2.5 font-medium text-xs border-b-2 border-transparent text-slate-500 hover:text-slate-800 transition-colors">
                            Vehicles (8)
                        </button>
                        <button type="button" onclick="switchRecordsEntity('invoices')" id="tabEntityInvoices"
                            class="px-4 py-2.5 font-medium text-xs border-b-2 border-transparent text-slate-500 hover:text-slate-800 transition-colors">
                            Invoices (4)
                        </button>
                        <button type="button" onclick="switchRecordsEntity('inventory')" id="tabEntityInventory"
                            class="px-4 py-2.5 font-medium text-xs border-b-2 border-transparent text-slate-500 hover:text-slate-800 transition-colors">
                            Inventory Parts (5)
                        </button>
                    </div>

                    <!-- Search Filter -->
                    <div class="bg-white rounded-2xl border border-slate-200/90 p-4 shadow-2xs">
                        <div class="relative max-w-md">
                            <span
                                class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <path d="m21 21-4.35-4.35"></path>
                                </svg>
                            </span>
                            <input type="text" id="recordsSearchInput" oninput="filterRecordsTable()"
                                placeholder="Search records..."
                                class="w-full pl-9 pr-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#F05A28] text-slate-800">
                        </div>
                    </div>

                    <!-- Dynamic Entity Records Table -->
                    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs" id="recordsTable">
                                <thead
                                    class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200"
                                    id="recordsTableHead">
                                    <!-- Injected dynamically -->
                                </thead>
                                <tbody class="divide-y divide-slate-100 font-medium" id="recordsTableBody">
                                    <!-- Injected dynamically -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </main>

        </div>

    </div>

    <!-- ======================================================== -->
    <!-- MODALS                                                   -->
    <!-- ======================================================== -->

    <!-- 1. ADD USER MODAL -->
    <div id="addUserModal"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden"
        role="dialog" aria-modal="true">
        <div
            class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-md overflow-hidden transform transition-all">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/70">
                <h3 class="font-bold text-slate-900 text-sm">Add New System User</h3>
                <button type="button" onclick="closeAddUserModal()" class="text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <form onsubmit="handleCreateUser(event)" class="p-6 space-y-3.5 text-xs">
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Full Name *</label>
                    <input type="text" id="newUserName" required placeholder="e.g. Asoka Bandara"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">NIC (National Identity Card) *</label>
                        <input type="text" id="newUserNIC" required placeholder="e.g. 199012345678 or 901234567V"
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Contact Phone Number *</label>
                        <input type="tel" id="newUserPhone" required placeholder="e.g. +94 77 123 4567"
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Staff Email Address *</label>
                        <input type="email" id="newUserEmail" required placeholder="e.g. asoka.b@vwms.lk"
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Assigned Role *</label>
                        <select id="newUserRole"
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                            <option value="Technician">Technician</option>
                            <option value="Front Desk">Front Desk Agent</option>
                            <option value="Supervisor">Supervisor</option>
                            <option value="Admin">Administrator</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Residential Address *</label>
                    <textarea id="newUserAddress" required rows="2" placeholder="e.g. No. 45/2, Temple Road, Colombo 03"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28] resize-none"></textarea>
                </div>
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Temporary Password</label>
                    <input type="text" id="newUserPass" value="VWMS@2026Temp"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg font-mono outline-none">
                </div>
                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" onclick="closeAddUserModal()"
                        class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold">Cancel</button>
                    <button type="submit"
                        class="px-5 py-2 rounded-lg bg-[#F05A28] hover:bg-[#D94819] text-white font-bold shadow-xs">Provision
                        Account</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 2. EDIT ROLE MODAL -->
    <div id="editRoleModal"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden"
        role="dialog" aria-modal="true">
        <div
            class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-sm overflow-hidden transform transition-all">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/70">
                <h3 class="font-bold text-slate-900 text-sm">Modify Role Assignment</h3>
                <button type="button" onclick="closeEditRoleModal()" class="text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="p-6 space-y-4 text-xs">
                <div>
                    <span class="text-slate-400 block text-[10px] uppercase font-bold">Selected User</span>
                    <span class="font-bold text-slate-900 text-sm" id="editRoleUserName">Kasun Perera</span>
                </div>
                <div>
                    <label class="block font-semibold text-slate-700 mb-1.5">New Role</label>
                    <select id="editRoleSelect"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                        <option value="Technician">Technician</option>
                        <option value="Front Desk">Front Desk</option>
                        <option value="Supervisor">Supervisor</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>
                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button type="button" onclick="closeEditRoleModal()"
                        class="px-3.5 py-1.5 rounded-lg border border-slate-200 text-slate-600">Cancel</button>
                    <button type="button" onclick="confirmRoleUpdate()"
                        class="px-4 py-1.5 rounded-lg bg-[#F05A28] text-white font-bold">Save Role</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. DATA CORRECTION MODAL (FOR RECORDS) -->
    <div id="correctRecordModal"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden"
        role="dialog" aria-modal="true">
        <div
            class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-md overflow-hidden transform transition-all">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/70">
                <h3 class="font-bold text-slate-900 text-sm">Correct Data Record (Audit Tracked)</h3>
                <button type="button" onclick="closeCorrectRecordModal()"
                    class="text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="p-6 space-y-3.5 text-xs">
                <div>
                    <label class="block font-semibold text-slate-700 mb-1" id="correctFieldLabel">Primary Value</label>
                    <input type="text" id="correctRecordInput"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                </div>
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Reason for Administrative Correction
                        *</label>
                    <input type="text" id="correctRecordReason" placeholder="e.g. Corrected typo in customer phone"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                </div>
                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" onclick="closeCorrectRecordModal()"
                        class="px-3.5 py-1.5 rounded-lg border border-slate-200 text-slate-600">Cancel</button>
                    <button type="button" onclick="saveRecordCorrection()"
                        class="px-4 py-1.5 rounded-lg bg-[#F05A28] text-white font-bold">Apply Correction</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- INVENTORY & SUPPLIERS MODALS                             -->
    <!-- ======================================================== -->

    <!-- 4. ADD NEW PART MODAL -->
    <div id="addPartModal"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden"
        role="dialog" aria-modal="true">
        <div
            class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-lg overflow-hidden transform transition-all max-h-[90vh] flex flex-col">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/70">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#F05A28]"></span>
                    <h3 class="font-bold text-slate-900 text-sm">+ Add New Spare Part</h3>
                </div>
                <button type="button" onclick="closeAddPartModal()" class="text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <form onsubmit="handleCreatePart(event)" class="p-6 space-y-3.5 text-xs overflow-y-auto">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="sm:col-span-2">
                        <label class="block font-semibold text-slate-700 mb-1">Part Name &amp; Specification *</label>
                        <input type="text" id="newPartName" required placeholder="e.g. Bosch Iridium Spark Plug FR7D"
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Part SKU *</label>
                        <input type="text" id="newPartSKU" required placeholder="e.g. PLG-BOS-003"
                            style="text-transform: uppercase;"
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg font-mono font-bold outline-none focus:ring-1 focus:ring-[#F05A28]">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Component Category *</label>
                        <select id="newPartCategory" required
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                            <option value="Braking">Braking</option>
                            <option value="Fluids">Fluids &amp; Lubricants</option>
                            <option value="Filters">Filters</option>
                            <option value="Ignition">Ignition &amp; Electrical</option>
                            <option value="Suspension">Suspension &amp; Steering</option>
                            <option value="Engine">Engine &amp; Belts</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Warehouse Bin / Location</label>
                        <input type="text" id="newPartBin" placeholder="e.g. Rack B-04 / Shelf 2"
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Initial Stock Count *</label>
                        <input type="number" id="newPartStock" required min="0" value="10"
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg font-mono outline-none focus:ring-1 focus:ring-[#F05A28]">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Critical Threshold *</label>
                        <input type="number" id="newPartThreshold" required min="1" value="5"
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg font-mono outline-none focus:ring-1 focus:ring-[#F05A28]"
                            title="If stock falls to or below this count, a critical low-stock warning is flagged.">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Cost Price (LKR) *</label>
                        <input type="number" id="newPartCost" required min="0" step="50" placeholder="e.g. 8500"
                            oninput="calcAddMargin()"
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg font-mono outline-none focus:ring-1 focus:ring-[#F05A28]">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Selling Price (LKR) *</label>
                        <input type="number" id="newPartSelling" required min="0" step="50" placeholder="e.g. 11900"
                            oninput="calcAddMargin()"
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg font-mono outline-none focus:ring-1 focus:ring-[#F05A28]">
                    </div>
                </div>

                <!-- Margin Live Preview Card -->
                <div
                    class="p-3 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-between text-xs">
                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Estimated Unit Margin</span>
                        <span class="font-bold text-slate-800 font-mono text-sm" id="addPartUnitProfit">LKR 0.00
                            profit</span>
                    </div>
                    <div class="text-right">
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Gross Margin %</span>
                        <span class="px-2 py-0.5 rounded font-mono font-extrabold text-xs bg-slate-200 text-slate-700"
                            id="addPartMarginBadge">0.0%</span>
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Supplier Assignment *</label>
                    <select id="newPartSupplier" required
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                        <!-- Populated dynamically via JS -->
                    </select>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" onclick="closeAddPartModal()"
                        class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold">Cancel</button>
                    <button type="submit"
                        class="px-5 py-2 rounded-lg bg-[#F05A28] hover:bg-[#D94819] text-white font-bold shadow-xs">
                        Save &amp; Provision Part
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- 5. EDIT PART MODAL -->
    <div id="editPartModal"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden"
        role="dialog" aria-modal="true">
        <div
            class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-lg overflow-hidden transform transition-all max-h-[90vh] flex flex-col">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/70">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                    <h3 class="font-bold text-slate-900 text-sm">Edit Spare Part &amp; Pricing (Admin)</h3>
                </div>
                <button type="button" onclick="closeEditPartModal()" class="text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <form onsubmit="handleUpdatePart(event)" class="p-6 space-y-3.5 text-xs overflow-y-auto">
                <input type="hidden" id="editPartId">

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="sm:col-span-2">
                        <label class="block font-semibold text-slate-700 mb-1">Part Name &amp; Description *</label>
                        <input type="text" id="editPartName" required
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Part SKU *</label>
                        <input type="text" id="editPartSKU" required style="text-transform: uppercase;"
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg font-mono font-bold outline-none focus:ring-1 focus:ring-[#F05A28]">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Category</label>
                        <select id="editPartCategory" required
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                            <option value="Braking">Braking</option>
                            <option value="Fluids">Fluids &amp; Lubricants</option>
                            <option value="Filters">Filters</option>
                            <option value="Ignition">Ignition &amp; Electrical</option>
                            <option value="Suspension">Suspension &amp; Steering</option>
                            <option value="Engine">Engine &amp; Belts</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Storage Bin / Shelf</label>
                        <input type="text" id="editPartBin"
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Current Stock On Hand</label>
                        <div
                            class="px-3 py-2 bg-slate-100 border border-slate-200 rounded-lg font-mono font-bold text-slate-800 flex items-center justify-between">
                            <span id="editPartStockDisplay">0 units</span>
                            <span class="text-[10px] text-slate-500 font-normal">Use [Adjust Stock] for audits</span>
                        </div>
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Critical Threshold *</label>
                        <input type="number" id="editPartThreshold" required min="1"
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg font-mono outline-none focus:ring-1 focus:ring-[#F05A28]">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Cost Price (LKR) *</label>
                        <input type="number" id="editPartCost" required min="0" step="50" oninput="calcEditMargin()"
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg font-mono outline-none focus:ring-1 focus:ring-[#F05A28]">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Selling Price (LKR) *</label>
                        <input type="number" id="editPartSelling" required min="0" step="50" oninput="calcEditMargin()"
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg font-mono outline-none focus:ring-1 focus:ring-[#F05A28]">
                    </div>
                </div>

                <!-- Margin Live Preview Card -->
                <div
                    class="p-3 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-between text-xs">
                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Calculated Unit Margin</span>
                        <span class="font-bold text-slate-800 font-mono text-sm" id="editPartUnitProfit">LKR 0.00
                            profit</span>
                    </div>
                    <div class="text-right">
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Gross Margin %</span>
                        <span class="px-2 py-0.5 rounded font-mono font-extrabold text-xs bg-slate-200 text-slate-700"
                            id="editPartMarginBadge">0.0%</span>
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Linked Supplier *</label>
                    <select id="editPartSupplier" required
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                        <!-- Populated dynamically via JS -->
                    </select>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" onclick="closeEditPartModal()"
                        class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold">Cancel</button>
                    <button type="submit"
                        class="px-5 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-bold shadow-xs">
                        Save Part Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- 6. ADJUST STOCK MODAL (+/- MANUAL AUDIT OR RESTOCK) -->
    <div id="adjustStockModal"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden"
        role="dialog" aria-modal="true">
        <div
            class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-md overflow-hidden transform transition-all">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/70">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    <h3 class="font-bold text-slate-900 text-sm">Manual Stock Adjustment (+/-)</h3>
                </div>
                <button type="button" onclick="closeAdjustStockModal()" class="text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <form onsubmit="handleAdjustStock(event)" class="p-6 space-y-4 text-xs">
                <!-- Part Select / Target -->
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Target Spare Part *</label>
                    <select id="adjustStockPartSelect" onchange="onAdjustStockPartChange()" required
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                        <!-- Populated dynamically via JS -->
                    </select>
                </div>

                <!-- Current Balance vs New Preview -->
                <div class="grid grid-cols-2 gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl">
                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Current On-Hand</span>
                        <span class="font-black text-slate-900 font-mono text-base" id="adjustCurrentStockDisplay">0
                            units</span>
                    </div>
                    <div class="text-right">
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Updated Balance</span>
                        <span class="font-black text-[#F05A28] font-mono text-base" id="adjustPreviewStockDisplay">0
                            units</span>
                    </div>
                </div>

                <!-- Adjustment Type Selector -->
                <div>
                    <label class="block font-semibold text-slate-700 mb-1.5">Adjustment Direction &amp; Operation
                        *</label>
                    <div class="grid grid-cols-2 gap-2">
                        <button type="button" id="adjustTypeAdd" onclick="setAdjustType('ADD')"
                            class="px-3 py-2 rounded-lg border font-bold text-xs flex items-center justify-center gap-1.5 transition-all bg-emerald-50 text-emerald-700 border-emerald-300">
                            <span class="text-sm font-black">+</span> Stock Addition (Restock)
                        </button>
                        <button type="button" id="adjustTypeDeduct" onclick="setAdjustType('DEDUCT')"
                            class="px-3 py-2 rounded-lg border font-bold text-xs flex items-center justify-center gap-1.5 transition-all bg-white text-slate-600 border-slate-200 hover:bg-slate-50">
                            <span class="text-sm font-black">-</span> Deduction / Usage
                        </button>
                    </div>
                </div>

                <!-- Quantity with Quick Buttons -->
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="font-semibold text-slate-700">Quantity To Adjust *</label>
                        <span class="text-[10px] text-slate-400">Quick increments:</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="number" id="adjustStockQty" required min="1" value="5"
                            oninput="calcAdjustPreview()"
                            class="flex-1 px-3 py-2 border border-slate-200 rounded-lg font-mono font-bold text-sm outline-none focus:ring-1 focus:ring-[#F05A28]">
                        <button type="button" onclick="quickAdjustQty(1)"
                            class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-mono font-bold text-xs">+1</button>
                        <button type="button" onclick="quickAdjustQty(5)"
                            class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-mono font-bold text-xs">+5</button>
                        <button type="button" onclick="quickAdjustQty(10)"
                            class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-mono font-bold text-xs">+10</button>
                    </div>
                </div>

                <!-- Reason & Reference -->
                <div class="space-y-2">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Reason for Audit Log *</label>
                        <select id="adjustStockReasonSelect" onchange="onAdjustReasonSelectChange()" required
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                            <option value="Restock from Supplier">Restock shipment from Supplier</option>
                            <option value="Manual Inventory Audit">Manual stock count audit reconciliation</option>
                            <option value="Used in Workshop Job">Consumed in customer repair job</option>
                            <option value="Damaged / Expired Write-off">Defective / damaged stock write-off</option>
                            <option value="Return to Vendor">Return / credit note to supplier</option>
                            <option value="Other">Other (Custom specification)</option>
                        </select>
                    </div>
                    <div id="adjustStockCustomReasonContainer" class="hidden">
                        <input type="text" id="adjustStockCustomReason"
                            placeholder="Describe manual adjustment reason..."
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Reference / PO / Job # (Optional)</label>
                    <input type="text" id="adjustStockRef" placeholder="e.g. PO-2026-948 or JOB-1082"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg font-mono outline-none focus:ring-1 focus:ring-[#F05A28]">
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" onclick="closeAdjustStockModal()"
                        class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold">Cancel</button>
                    <button type="submit"
                        class="px-5 py-2 rounded-lg bg-[#0F172A] hover:bg-slate-800 text-white font-bold shadow-xs">
                        Confirm &amp; Log Adjustment
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- 7. ADD SUPPLIER MODAL -->
    <div id="addSupplierModal"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden"
        role="dialog" aria-modal="true">
        <div
            class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-lg overflow-hidden transform transition-all max-h-[90vh] flex flex-col">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/70">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#F05A28]"></span>
                    <h3 class="font-bold text-slate-900 text-sm">+ Add New Parts Supplier</h3>
                </div>
                <button type="button" onclick="closeAddSupplierModal()" class="text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <form onsubmit="handleCreateSupplier(event)" class="p-6 space-y-3.5 text-xs overflow-y-auto">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Company / Vendor Name *</label>
                        <input type="text" id="newSupplierName" required placeholder="e.g. Denso Lanka (Pvt) Ltd"
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Primary Contact Person *</label>
                        <input type="text" id="newSupplierContact" required placeholder="e.g. Sanjeewa Silva (Manager)"
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Direct Phone Number *</label>
                        <input type="tel" id="newSupplierPhone" required placeholder="e.g. +94 11 234 5678"
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Procurement Email *</label>
                        <input type="email" id="newSupplierEmail" required placeholder="e.g. orders@densolanka.lk"
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Supply Category / Focus *</label>
                        <input type="text" id="newSupplierCategory" required
                            placeholder="e.g. OEM Electrical &amp; Starters"
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Supplier Status *</label>
                        <select id="newSupplierStatus" required
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                            <option value="Active">Active Supplier</option>
                            <option value="Inactive">Inactive / Suspended</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Physical Warehouse / Office Address *</label>
                    <textarea id="newSupplierAddress" required rows="2"
                        placeholder="e.g. No. 128, Sri Jayawardenepura Mawatha, Rajagiriya"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28] resize-none"></textarea>
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Initial Linked Catalog Parts
                        (Optional)</label>
                    <p class="text-[11px] text-slate-400 mb-2">Check any existing parts to immediately link to this
                        supplier:</p>
                    <div id="newSupplierPartsChecklist"
                        class="max-h-36 overflow-y-auto p-2.5 bg-slate-50 border border-slate-200 rounded-lg space-y-1.5">
                        <!-- Populated dynamically via JS -->
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" onclick="closeAddSupplierModal()"
                        class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold">Cancel</button>
                    <button type="submit"
                        class="px-5 py-2 rounded-lg bg-[#F05A28] hover:bg-[#D94819] text-white font-bold shadow-xs">
                        Register Supplier
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- 8. EDIT SUPPLIER MODAL -->
    <div id="editSupplierModal"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden"
        role="dialog" aria-modal="true">
        <div
            class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-lg overflow-hidden transform transition-all max-h-[90vh] flex flex-col">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/70">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                    <h3 class="font-bold text-slate-900 text-sm">Edit Supplier Details (Admin)</h3>
                </div>
                <button type="button" onclick="closeEditSupplierModal()"
                    class="text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <form onsubmit="handleUpdateSupplier(event)" class="p-6 space-y-3.5 text-xs overflow-y-auto">
                <input type="hidden" id="editSupplierId">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Company / Vendor Name *</label>
                        <input type="text" id="editSupplierName" required
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Primary Contact Person *</label>
                        <input type="text" id="editSupplierContact" required
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Phone Number *</label>
                        <input type="tel" id="editSupplierPhone" required
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Email Address *</label>
                        <input type="email" id="editSupplierEmail" required
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Category / Specialty</label>
                        <input type="text" id="editSupplierCategory"
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Status</label>
                        <select id="editSupplierStatus" required
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28]">
                            <option value="Active">Active Supplier</option>
                            <option value="Inactive">Inactive / Suspended</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Office / Depot Address</label>
                    <textarea id="editSupplierAddress" required rows="2"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none focus:ring-1 focus:ring-[#F05A28] resize-none"></textarea>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" onclick="closeEditSupplierModal()"
                        class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold">Cancel</button>
                    <button type="submit"
                        class="px-5 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-bold shadow-xs">
                        Save Supplier Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Notification Toast -->
    <div id="toast"
        class="fixed bottom-5 right-5 z-50 bg-[#0F172A] text-white text-xs px-4 py-3 rounded-lg shadow-xl border border-slate-700 flex items-center gap-2.5 transform translate-y-20 opacity-0 transition-all duration-300 pointer-events-none">
        <svg class="w-4 h-4 text-emerald-400 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2.5">
            <polyline points="20 6 9 17 4 12"></polyline>
        </svg>
        <span id="toastMsg">Operation successful!</span>
    </div>

    <!-- ======================================================== -->
    <!-- 7. CLIENT LOGIC & DATA CONTROLLERS                       -->
    <!-- ======================================================== -->
    <script>
        // Mobile Sidebar Drawer
        function toggleMobileSidebar(open) {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            if (open) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }

        // Screen Switcher
        function switchAdminScreen(screenId) {
            const screens = [
                { id: 'screen-overview', el: document.getElementById('viewScreenOverview'), btn: document.getElementById('navScreenOverview'), title: 'Overview (Operations Dashboard)' },
                { id: 'screen-inventory', el: document.getElementById('viewScreenInventory'), btn: document.getElementById('navScreenInventory'), title: 'Inventory & Suppliers' },
                { id: 'screen-users', el: document.getElementById('viewScreenUsers'), btn: document.getElementById('navScreenUsers'), title: 'User Management' },
                { id: 'screen-settings', el: document.getElementById('viewScreenSettings'), btn: document.getElementById('navScreenSettings'), title: 'System Settings' },
                { id: 'screen-backups', el: document.getElementById('viewScreenBackups'), btn: document.getElementById('navScreenBackups'), title: 'Backups & Exports' },
                { id: 'screen-notifications', el: document.getElementById('viewScreenNotifications'), btn: document.getElementById('navScreenNotifications'), title: 'Notifications Log' },
                { id: 'screen-records', el: document.getElementById('viewScreenRecords'), btn: document.getElementById('navScreenRecords'), title: 'Core Workshop Records' }
            ];

            screens.forEach(s => {
                if (s.id === screenId) {
                    s.el.classList.remove('hidden');
                    s.btn.classList.add('nav-item-active');
                    s.btn.classList.remove('text-slate-400');
                    document.getElementById('topBreadcrumbText').textContent = s.title;
                } else {
                    s.el.classList.add('hidden');
                    s.btn.classList.remove('nav-item-active');
                    s.btn.classList.add('text-slate-400');
                }
            });
            toggleMobileSidebar(false);
        }

        // ========================================================
        // SCREEN: INVENTORY & SUPPLIERS DATA & CONTROLLERS
        // ========================================================

        // 1. SUPPLIERS DATA
        let suppliersData = [
            {
                id: 1,
                name: 'Toyota Lanka (Pvt) Ltd',
                contact: 'Prasanna Alwis (Key Accounts)',
                phone: '+94 11 246 8000',
                email: 'oem.sales@toyota.lk',
                address: 'No. 337, Negombo Road, Wattala',
                category: 'Genuine Toyota / Denso OEM',
                status: 'Active'
            },
            {
                id: 2,
                name: 'McLarens Lubricants Ltd',
                contact: 'Dhammika Gunasekara',
                phone: '+94 11 258 7100',
                email: 'orders@mclarens.lk',
                address: 'No. 284, Vauxhall Street, Colombo 02',
                category: 'Mobil 1 / Synthetic Fluids',
                status: 'Active'
            },
            {
                id: 3,
                name: 'Ferodo Braking Systems LK',
                contact: 'Channa Hettiarachchi',
                phone: '+94 77 345 9901',
                email: 'sales@ferodobraking.lk',
                address: 'No. 48, Nawala Road, Nugegoda',
                category: 'Friction Material & Hydraulics',
                status: 'Active'
            },
            {
                id: 4,
                name: 'NGK Spark Plugs Ceylon',
                contact: 'Kavinda Rathnayake',
                phone: '+94 11 472 3890',
                email: 'procurement@ngkceylon.lk',
                address: 'No. 12, Prince of Wales Avenue, Colombo 14',
                category: 'Ignition & Glow Plugs',
                status: 'Active'
            },
            {
                id: 5,
                name: 'United Motors Lanka PLC',
                contact: 'Suranga Wijesinghe',
                phone: '+94 11 244 8411',
                email: 'spares@unitedmotors.lk',
                address: 'No. 100, Hyde Park Corner, Colombo 02',
                category: 'Japanese & European Spares',
                status: 'Active'
            }
        ];

        // 2. PARTS INVENTORY DATA
        let partsData = [
            {
                id: 1,
                sku: 'BRK-FER-001',
                name: 'Ferodo Ceramic Brake Pads (Front)',
                category: 'Braking',
                bin: 'Bay A-03',
                stock: 2,
                threshold: 5,
                costPrice: 10500,
                sellingPrice: 14500,
                supplierId: 3
            },
            {
                id: 2,
                sku: 'OIL-MOB-5W30',
                name: 'Mobil 1 Fully Synthetic 5W-30 (4L)',
                category: 'Fluids',
                bin: 'Bay D-01',
                stock: 3,
                threshold: 8,
                costPrice: 13500,
                sellingPrice: 18200,
                supplierId: 2
            },
            {
                id: 3,
                sku: 'FLT-TOY-OIL',
                name: 'Genuine Toyota Oil Filter C-110',
                category: 'Filters',
                bin: 'Bay B-02',
                stock: 24,
                threshold: 10,
                costPrice: 1600,
                sellingPrice: 2400,
                supplierId: 1
            },
            {
                id: 4,
                sku: 'PLG-NGK-IRID',
                name: 'NGK Laser Iridium Spark Plug (Set of 4)',
                category: 'Ignition',
                bin: 'Bay C-01',
                stock: 16,
                threshold: 6,
                costPrice: 3200,
                sellingPrice: 4800,
                supplierId: 4
            },
            {
                id: 5,
                sku: 'HYB-INV-COOL',
                name: 'Toyota Super Long Life Coolant (4L)',
                category: 'Fluids',
                bin: 'Bay D-04',
                stock: 1,
                threshold: 4,
                costPrice: 6800,
                sellingPrice: 9500,
                supplierId: 1
            },
            {
                id: 6,
                sku: 'FLT-DEN-AIR',
                name: 'Denso Cabin Air Filter Micro-Clean',
                category: 'Filters',
                bin: 'Bay B-05',
                stock: 14,
                threshold: 5,
                costPrice: 2800,
                sellingPrice: 4200,
                supplierId: 1
            },
            {
                id: 7,
                sku: 'BRK-DISC-VENT',
                name: 'Vented Front Brake Rotor Set (Pair)',
                category: 'Braking',
                bin: 'Bay A-08',
                stock: 6,
                threshold: 4,
                costPrice: 22000,
                sellingPrice: 31500,
                supplierId: 3
            },
            {
                id: 8,
                sku: 'SUS-LNK-FRNT',
                name: 'Front Stabilizer Sway Bar Link Kit',
                category: 'Suspension',
                bin: 'Bay E-02',
                stock: 12,
                threshold: 4,
                costPrice: 5500,
                sellingPrice: 8200,
                supplierId: 5
            },
            {
                id: 9,
                sku: 'ENG-BELT-SERP',
                name: 'Bando Serpentine Ribbed Drive Belt 6PK',
                category: 'Engine',
                bin: 'Bay C-06',
                stock: 9,
                threshold: 4,
                costPrice: 4200,
                sellingPrice: 6500,
                supplierId: 5
            },
            {
                id: 10,
                sku: 'FLD-DOT4-BRK',
                name: 'Castrol React Performance DOT-4 Brake Fluid (1L)',
                category: 'Fluids',
                bin: 'Bay D-06',
                stock: 1,
                threshold: 5,
                costPrice: 2100,
                sellingPrice: 3400,
                supplierId: 2
            }
        ];

        // 3. STOCK MOVEMENTS LOG (PERMANENT AUDIT TRAIL)
        let stockMovementsData = [
            {
                id: 101,
                timestamp: 'Today, 08:35 AM',
                partName: 'Ferodo Ceramic Brake Pads (Front)',
                sku: 'BRK-FER-001',
                change: -2,
                prevStock: 4,
                newStock: 2,
                reason: 'Used in Job #JOB-1079 (Honda Vezel WP CBA-1234)',
                by: 'Jagath Perera (Admin)',
                ref: 'JOB-1079'
            },
            {
                id: 102,
                timestamp: 'Today, 08:10 AM',
                partName: 'Mobil 1 Fully Synthetic 5W-30 (4L)',
                sku: 'OIL-MOB-5W30',
                change: -1,
                prevStock: 4,
                newStock: 3,
                reason: 'Used in Job #JOB-1075 (Toyota Prado WP CAB-7892)',
                by: 'Dishan Karunaratne (Tech)',
                ref: 'JOB-1075'
            },
            {
                id: 103,
                timestamp: 'Today, 07:45 AM',
                partName: 'Genuine Toyota Oil Filter C-110',
                sku: 'FLT-TOY-OIL',
                change: +20,
                prevStock: 4,
                newStock: 24,
                reason: 'Restock shipment received from Toyota Lanka (PO #4410)',
                by: 'Jagath Perera (Admin)',
                ref: 'PO-4410'
            },
            {
                id: 104,
                timestamp: 'Yesterday, 04:30 PM',
                partName: 'Castrol React Performance DOT-4 Brake Fluid (1L)',
                sku: 'FLD-DOT4-BRK',
                change: -3,
                prevStock: 4,
                newStock: 1,
                reason: 'Used in Job #JOB-1068 (Hydraulic Flush)',
                by: 'Kasun Perera (Tech)',
                ref: 'JOB-1068'
            },
            {
                id: 105,
                timestamp: 'Yesterday, 02:15 PM',
                partName: 'NGK Laser Iridium Spark Plug (Set of 4)',
                sku: 'PLG-NGK-IRID',
                change: +10,
                prevStock: 6,
                newStock: 16,
                reason: 'Direct delivery from NGK Ceylon Depot',
                by: 'Jagath Perera (Admin)',
                ref: 'PO-4398'
            },
            {
                id: 106,
                timestamp: '2026-09-25, 11:20 AM',
                partName: 'Toyota Super Long Life Coolant (4L)',
                sku: 'HYB-INV-COOL',
                change: -1,
                prevStock: 2,
                newStock: 1,
                reason: 'Used in Job #JOB-1062 (Inverter Coolant Service)',
                by: 'Nuwan Pradeep (Tech)',
                ref: 'JOB-1062'
            },
            {
                id: 107,
                timestamp: '2026-09-24, 03:00 PM',
                partName: 'Denso Cabin Air Filter Micro-Clean',
                sku: 'FLT-DEN-AIR',
                change: +12,
                prevStock: 2,
                newStock: 14,
                reason: 'Routine Restock delivery from Toyota Lanka',
                by: 'Jagath Perera (Admin)',
                ref: 'PO-4380'
            },
            {
                id: 108,
                timestamp: '2026-09-23, 09:40 AM',
                partName: 'Ferodo Ceramic Brake Pads (Front)',
                sku: 'BRK-FER-001',
                change: +5,
                prevStock: -1,
                newStock: 4,
                reason: 'Emergency store replenishment',
                by: 'Jagath Perera (Admin)',
                ref: 'PO-4375'
            },
            {
                id: 109,
                timestamp: '2026-09-22, 05:15 PM',
                partName: 'Vented Front Brake Rotor Set (Pair)',
                sku: 'BRK-DISC-VENT',
                change: -1,
                prevStock: 7,
                newStock: 6,
                reason: 'Defective packaging write-off',
                by: 'Jagath Perera (Admin)',
                ref: 'SCRAP-08'
            },
            {
                id: 110,
                timestamp: '2026-09-21, 10:00 AM',
                partName: 'Front Stabilizer Sway Bar Link Kit',
                sku: 'SUS-LNK-FRNT',
                change: +8,
                prevStock: 4,
                newStock: 12,
                reason: 'Warehouse stock intake',
                by: 'Jagath Perera (Admin)',
                ref: 'PO-4360'
            },
            {
                id: 111,
                timestamp: '2026-09-20, 08:30 AM',
                partName: 'Bando Serpentine Ribbed Drive Belt 6PK',
                sku: 'ENG-BELT-SERP',
                change: +5,
                prevStock: 4,
                newStock: 9,
                reason: 'Restock shipment received from United Motors',
                by: 'Jagath Perera (Admin)',
                ref: 'PO-4352'
            },
            {
                id: 112,
                timestamp: '2026-09-18, 09:00 AM',
                partName: 'Mobil 1 Fully Synthetic 5W-30 (4L)',
                sku: 'OIL-MOB-5W30',
                change: +10,
                prevStock: 0,
                newStock: 10,
                reason: 'Initial inventory provision for quarter',
                by: 'Jagath Perera (Admin)',
                ref: 'INIT-2026'
            }
        ];

        // State trackers
        let currentInventoryTab = 'parts';
        let currentAdjustType = 'ADD'; // 'ADD' or 'DEDUCT'
        let editingPartId = null;
        let editingSupplierId = null;

        // Initialize Inventory Module
        function initInventoryModule() {
            populateSupplierSelectDropdowns();
            renderPartsTable();
            renderSuppliersTable();
            renderMovementsTable();
            updateInventoryKPIs();
        }

        // Tab Switcher for Inventory Screen
        function switchInventoryTab(tabName) {
            currentInventoryTab = tabName;

            const tabs = [
                { id: 'parts', btn: document.getElementById('tabInvParts'), content: document.getElementById('tabContentParts') },
                { id: 'suppliers', btn: document.getElementById('tabInvSuppliers'), content: document.getElementById('tabContentSuppliers') },
                { id: 'movements', btn: document.getElementById('tabInvMovements'), content: document.getElementById('tabContentMovements') }
            ];

            tabs.forEach(t => {
                if (t.id === tabName) {
                    t.content.classList.remove('hidden');
                    t.btn.className = 'px-4 py-2.5 font-bold text-xs border-b-2 border-[#F05A28] text-[#F05A28] flex items-center gap-2 transition-colors';
                } else {
                    t.content.classList.add('hidden');
                    t.btn.className = 'px-4 py-2.5 font-medium text-xs border-b-2 border-transparent text-slate-500 hover:text-slate-800 flex items-center gap-2 transition-colors';
                }
            });

            // Update Primary Action button depending on active tab
            const primaryBtn = document.getElementById('inventoryPrimaryActionBtn');
            const primaryText = document.getElementById('inventoryPrimaryActionText');

            if (tabName === 'parts') {
                primaryText.textContent = '+ Add New Part';
                primaryBtn.className = 'inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[#F05A28] hover:bg-[#D94819] text-white text-xs font-bold shadow-sm transition-all duration-150';
            } else if (tabName === 'suppliers') {
                primaryText.textContent = '+ Add Supplier';
                primaryBtn.className = 'inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[#F05A28] hover:bg-[#D94819] text-white text-xs font-bold shadow-sm transition-all duration-150';
            } else if (tabName === 'movements') {
                primaryText.textContent = '+ Quick Adjust Stock';
                primaryBtn.className = 'inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[#0F172A] hover:bg-slate-800 text-white text-xs font-bold shadow-sm transition-all duration-150';
            }
        }

        // Handle Primary Action Click
        function handleInventoryPrimaryAction() {
            if (currentInventoryTab === 'parts') {
                openAddPartModal();
            } else if (currentInventoryTab === 'suppliers') {
                openAddSupplierModal();
            } else if (currentInventoryTab === 'movements') {
                openAdjustStockModal();
            }
        }

        // Helper: Calculate Margin Percentage & Profit
        function calculateMargin(cost, selling) {
            cost = parseFloat(cost) || 0;
            selling = parseFloat(selling) || 0;
            const profit = selling - cost;
            const margin = selling > 0 ? ((profit / selling) * 100) : 0;
            return {
                profit: profit,
                marginPct: margin.toFixed(1)
            };
        }

        // Populate Supplier Dropdowns across modals and filters
        function populateSupplierSelectDropdowns() {
            const selects = [
                document.getElementById('newPartSupplier'),
                document.getElementById('editPartSupplier'),
                document.getElementById('partsSupplierFilter')
            ];

            const activeSuppliers = suppliersData.filter(s => s.status === 'Active');

            selects.forEach(sel => {
                if (!sel) return;
                const isFilter = sel.id === 'partsSupplierFilter';
                const currentVal = sel.value;

                let html = isFilter ? '<option value="ALL">All Linked Suppliers</option>' : '';
                html += activeSuppliers.map(s => `<option value="${s.id}">${s.name}</option>`).join('');
                sel.innerHTML = html;
                if (currentVal) sel.value = currentVal;
            });

            // Populate checklist in Add Supplier modal (parts to link)
            const checklist = document.getElementById('newSupplierPartsChecklist');
            if (checklist) {
                checklist.innerHTML = partsData.map(p => `
                    <label class="flex items-center gap-2 text-slate-700 hover:text-slate-900 cursor-pointer">
                        <input type="checkbox" name="supplierParts" value="${p.id}" class="rounded text-[#F05A28] focus:ring-0">
                        <span class="font-mono text-[11px] font-bold text-slate-900">${p.sku}</span>
                        <span class="truncate">${p.name}</span>
                    </label>
                `).join('');
            }
        }

        // Update KPI Summary Metrics
        function updateInventoryKPIs() {
            const totalSKUs = partsData.length;
            const totalUnits = partsData.reduce((sum, p) => sum + p.stock, 0);
            const lowStockParts = partsData.filter(p => p.stock <= p.threshold);
            const lowStockCount = lowStockParts.length;

            const totalCostValuation = partsData.reduce((sum, p) => sum + (p.costPrice * p.stock), 0);
            const totalRetailValuation = partsData.reduce((sum, p) => sum + (p.sellingPrice * p.stock), 0);
            const overallMargin = totalRetailValuation > 0
                ? (((totalRetailValuation - totalCostValuation) / totalRetailValuation) * 100).toFixed(1)
                : 0;

            const activeSuppliersCount = suppliersData.filter(s => s.status === 'Active').length;

            // DOM updates
            document.getElementById('kpiTotalSKUs').textContent = `${totalSKUs} Parts`;
            document.getElementById('kpiTotalUnits').textContent = `${totalUnits} Units`;

            document.getElementById('kpiLowStockCount').textContent = `${lowStockCount} Critical`;
            document.getElementById('sidebarLowStockBadge').textContent = `${lowStockCount} Low`;
            const overviewEl = document.getElementById('overviewLowStockCount');
            if (overviewEl) overviewEl.textContent = `${lowStockCount} Critical SKUs`;

            document.getElementById('kpiActiveSuppliers').textContent = `${activeSuppliersCount} Vendors`;

            document.getElementById('tabBadgePartsCount').textContent = totalSKUs;
            document.getElementById('tabBadgeSuppliersCount').textContent = suppliersData.length;
        }

        // ========================================================
        // TAB 1 CONTROLLER: PARTS INVENTORY
        // ========================================================

        function renderPartsTable() {
            const tbody = document.getElementById('partsTableBody');
            const search = document.getElementById('partsSearchInput')?.value.toLowerCase().trim() || '';
            const statusFilter = document.getElementById('partsStatusFilter')?.value || 'ALL';
            const categoryFilter = document.getElementById('partsCategoryFilter')?.value || 'ALL';
            const supplierFilter = document.getElementById('partsSupplierFilter')?.value || 'ALL';

            const filtered = partsData.filter(p => {
                const supplier = suppliersData.find(s => s.id === p.supplierId);
                const supplierName = supplier ? supplier.name.toLowerCase() : '';

                const matchesSearch = !search ||
                    p.name.toLowerCase().includes(search) ||
                    p.sku.toLowerCase().includes(search) ||
                    (p.bin && p.bin.toLowerCase().includes(search)) ||
                    supplierName.includes(search);

                const isLow = p.stock <= p.threshold;
                const matchesStatus = statusFilter === 'ALL' ||
                    (statusFilter === 'LOW' && isLow) ||
                    (statusFilter === 'OK' && !isLow);

                const matchesCategory = categoryFilter === 'ALL' || p.category === categoryFilter;
                const matchesSupplier = supplierFilter === 'ALL' || p.supplierId.toString() === supplierFilter;

                return matchesSearch && matchesStatus && matchesCategory && matchesSupplier;
            });

            if (filtered.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="9" class="py-8 text-center text-slate-400">
                            <div class="flex flex-col items-center justify-center gap-1.5">
                                <svg class="w-8 h-8 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <path d="m21 21-4.35-4.35"></path>
                                </svg>
                                <span class="font-semibold text-slate-600">No spare parts match your filter criteria</span>
                                <button type="button" onclick="resetPartsFilters()" class="text-xs text-[#F05A28] font-bold hover:underline mt-1">Reset all filters</button>
                            </div>
                        </td>
                    </tr>
                `;
            } else {
                tbody.innerHTML = filtered.map(p => {
                    const supplier = suppliersData.find(s => s.id === p.supplierId);
                    const isLowStock = p.stock <= p.threshold;
                    const margin = calculateMargin(p.costPrice, p.sellingPrice);

                    const categoryBadge = p.category === 'Braking' ? 'bg-rose-50 text-rose-700 border-rose-200' :
                        p.category === 'Fluids' ? 'bg-amber-50 text-amber-700 border-amber-200' :
                            p.category === 'Filters' ? 'bg-blue-50 text-blue-700 border-blue-200' :
                                p.category === 'Ignition' ? 'bg-purple-50 text-purple-700 border-purple-200' :
                                    p.category === 'Suspension' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' :
                                        'bg-slate-100 text-slate-700 border-slate-200';

                    // Visual flag for low-stock rows
                    const rowClass = isLowStock
                        ? 'bg-rose-50/70 hover:bg-rose-100/50 border-l-4 border-rose-500 transition-colors'
                        : 'hover:bg-slate-50 border-l-4 border-transparent transition-colors';

                    const statusBadge = isLowStock
                        ? `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-rose-100 text-rose-800 border border-rose-300">
                               <span class="w-1.5 h-1.5 rounded-full bg-rose-600 animate-pulse"></span>
                               Low Stock
                           </span>`
                        : `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                               <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                               OK
                           </span>`;

                    const stockCountDisplay = isLowStock
                        ? `<div class="flex items-center gap-1.5">
                               <span class="font-mono font-black text-rose-700 text-sm">${p.stock} units</span>
                               <span class="text-[10px] text-rose-500 font-semibold">(Min: ${p.threshold})</span>
                           </div>`
                        : `<div class="flex items-center gap-1.5">
                               <span class="font-mono font-black text-slate-900 text-sm">${p.stock} units</span>
                           </div>`;

                    return `
                        <tr class="${rowClass}">
                            <!-- Part Name & Category -->
                            <td class="py-3 px-4">
                                <div class="font-bold text-slate-900">${p.name}</div>
                                <div class="mt-1 flex items-center gap-1.5">
                                    <span class="px-2 py-0.2 rounded text-[10px] font-bold border ${categoryBadge}">${p.category}</span>
                                </div>
                            </td>

                            <!-- SKU & Bin -->
                            <td class="py-3 px-4">
                                <span class="font-mono font-bold text-slate-800 bg-slate-100 px-1.5 py-0.5 rounded text-[11px] border border-slate-200">${p.sku}</span>
                                <div class="text-[10px] text-slate-400 mt-1 font-mono">${p.bin || 'Unassigned'}</div>
                            </td>

                            <!-- Stock Count -->
                            <td class="py-3 px-4">
                                ${stockCountDisplay}
                            </td>

                            <!-- Cost Price -->
                            <td class="py-3 px-4 font-mono text-slate-600">
                                LKR ${p.costPrice.toLocaleString()}
                            </td>

                            <!-- Selling Price & Margin -->
                            <td class="py-3 px-4">
                                <div class="font-mono font-bold text-slate-900">LKR ${p.sellingPrice.toLocaleString()}</div>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    <span class="text-[10px] font-bold px-1.5 py-0.2 rounded bg-emerald-50 text-emerald-700 border border-emerald-200 font-mono">
                                        +${margin.marginPct}%
                                    </span>
                                    <span class="text-[10px] text-slate-400 font-mono">(+${margin.profit.toLocaleString()})</span>
                                </div>
                            </td>

                            <!-- Supplier -->
                            <td class="py-3 px-4">
                                ${supplier ? `
                                    <div class="font-bold text-slate-800">${supplier.name}</div>
                                    <div class="text-[10px] text-slate-400">${supplier.phone}</div>
                                ` : '<span class="text-slate-400 italic">Unassigned</span>'}
                            </td>

                            <!-- Critical Threshold -->
                            <td class="py-3 px-4 font-mono font-bold text-slate-700">
                                ${p.threshold} units
                            </td>

                            <!-- Status -->
                            <td class="py-3 px-4 whitespace-nowrap">
                                ${statusBadge}
                            </td>

                            <!-- Actions (Full Control) -->
                            <td class="py-3 px-4 text-right space-x-1.5 whitespace-nowrap">
                                <button type="button" onclick="openAdjustStockModal(${p.id})"
                                    class="px-2.5 py-1 text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded border border-emerald-200 transition-colors"
                                    title="Adjust physical stock (+/-)">
                                    &plusmn; Adjust
                                </button>
                                <button type="button" onclick="openEditPartModal(${p.id})"
                                    class="px-2.5 py-1 text-xs font-bold text-[#F05A28] bg-orange-50 hover:bg-orange-100 rounded border border-orange-200 transition-colors"
                                    title="Edit part specifications and pricing">
                                    Edit
                                </button>
                                <button type="button" onclick="deletePart(${p.id})"
                                    class="px-2 py-1 text-xs font-bold text-rose-600 hover:text-rose-800 hover:bg-rose-50 rounded border border-transparent hover:border-rose-200 transition-colors"
                                    title="Delete spare part record (Admin)">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    `;
                }).join('');
            }

            document.getElementById('partsCountDisplay').textContent = filtered.length;
        }

        function filterPartsTable() {
            renderPartsTable();
        }

        function filterPartsStatus(status) {
            const select = document.getElementById('partsStatusFilter');
            if (select) select.value = status.toUpperCase();
            renderPartsTable();
        }

        function filterPartsSupplier(supplierId) {
            const select = document.getElementById('partsSupplierFilter');
            if (select) select.value = supplierId.toString();
            renderPartsTable();
        }

        function resetPartsFilters() {
            const sInput = document.getElementById('partsSearchInput');
            const sStatus = document.getElementById('partsStatusFilter');
            const sCat = document.getElementById('partsCategoryFilter');
            const sSupp = document.getElementById('partsSupplierFilter');
            if (sInput) sInput.value = '';
            if (sStatus) sStatus.value = 'ALL';
            if (sCat) sCat.value = 'ALL';
            if (sSupp) sSupp.value = 'ALL';
            renderPartsTable();
        }

        // Live Margin Calculation in Add Modal
        function calcAddMargin() {
            const cost = parseFloat(document.getElementById('newPartCost').value) || 0;
            const selling = parseFloat(document.getElementById('newPartSelling').value) || 0;
            const res = calculateMargin(cost, selling);

            document.getElementById('addPartUnitProfit').textContent = `LKR ${res.profit.toLocaleString()} profit`;
            const badge = document.getElementById('addPartMarginBadge');
            badge.textContent = `${res.marginPct}%`;

            if (parseFloat(res.marginPct) >= 25) {
                badge.className = 'px-2 py-0.5 rounded font-mono font-extrabold text-xs bg-emerald-100 text-emerald-800 border border-emerald-300';
            } else if (parseFloat(res.marginPct) >= 10) {
                badge.className = 'px-2 py-0.5 rounded font-mono font-extrabold text-xs bg-amber-100 text-amber-800 border border-amber-300';
            } else {
                badge.className = 'px-2 py-0.5 rounded font-mono font-extrabold text-xs bg-rose-100 text-rose-800 border border-rose-300';
            }
        }

        // Live Margin Calculation in Edit Modal
        function calcEditMargin() {
            const cost = parseFloat(document.getElementById('editPartCost').value) || 0;
            const selling = parseFloat(document.getElementById('editPartSelling').value) || 0;
            const res = calculateMargin(cost, selling);

            document.getElementById('editPartUnitProfit').textContent = `LKR ${res.profit.toLocaleString()} profit`;
            const badge = document.getElementById('editPartMarginBadge');
            badge.textContent = `${res.marginPct}%`;

            if (parseFloat(res.marginPct) >= 25) {
                badge.className = 'px-2 py-0.5 rounded font-mono font-extrabold text-xs bg-emerald-100 text-emerald-800 border border-emerald-300';
            } else if (parseFloat(res.marginPct) >= 10) {
                badge.className = 'px-2 py-0.5 rounded font-mono font-extrabold text-xs bg-amber-100 text-amber-800 border border-amber-300';
            } else {
                badge.className = 'px-2 py-0.5 rounded font-mono font-extrabold text-xs bg-rose-100 text-rose-800 border border-rose-300';
            }
        }

        // Add Part Modal Handlers
        function openAddPartModal() {
            populateSupplierSelectDropdowns();
            document.getElementById('addPartModal').classList.remove('hidden');
        }

        function closeAddPartModal() {
            document.getElementById('addPartModal').classList.add('hidden');
        }

        function handleCreatePart(e) {
            e.preventDefault();
            const name = document.getElementById('newPartName').value.trim();
            const sku = document.getElementById('newPartSKU').value.trim().toUpperCase();
            const category = document.getElementById('newPartCategory').value;
            const bin = document.getElementById('newPartBin').value.trim() || 'Bay Main-01';
            const stock = parseInt(document.getElementById('newPartStock').value) || 0;
            const threshold = parseInt(document.getElementById('newPartThreshold').value) || 5;
            const costPrice = parseFloat(document.getElementById('newPartCost').value) || 0;
            const sellingPrice = parseFloat(document.getElementById('newPartSelling').value) || 0;
            const supplierId = parseInt(document.getElementById('newPartSupplier').value);

            // SKU Uniqueness check
            if (partsData.some(p => p.sku === sku)) {
                alert(`Error: A part with SKU "${sku}" already exists in the catalog!`);
                return;
            }

            const newPart = {
                id: Date.now(),
                sku,
                name,
                category,
                bin,
                stock,
                threshold,
                costPrice,
                sellingPrice,
                supplierId
            };

            partsData.unshift(newPart);

            // Log Initial Stock in movements
            if (stock > 0) {
                stockMovementsData.unshift({
                    id: Date.now() + 1,
                    timestamp: 'Just now',
                    partName: name,
                    sku: sku,
                    change: stock,
                    prevStock: 0,
                    newStock: stock,
                    reason: 'Initial catalog provision & inventory intake',
                    by: 'Jagath Perera (Admin)',
                    ref: 'INIT-NEW'
                });
            }

            e.target.reset();
            closeAddPartModal();
            populateSupplierSelectDropdowns();
            renderPartsTable();
            renderMovementsTable();
            updateInventoryKPIs();
            showToast(`Part "${name}" (${sku}) successfully cataloged.`);
        }

        // Edit Part Modal Handlers
        function openEditPartModal(id) {
            const part = partsData.find(p => p.id === id);
            if (!part) return;

            editingPartId = id;
            populateSupplierSelectDropdowns();

            document.getElementById('editPartId').value = part.id;
            document.getElementById('editPartName').value = part.name;
            document.getElementById('editPartSKU').value = part.sku;
            document.getElementById('editPartCategory').value = part.category;
            document.getElementById('editPartBin').value = part.bin || '';
            document.getElementById('editPartStockDisplay').textContent = `${part.stock} units`;
            document.getElementById('editPartThreshold').value = part.threshold;
            document.getElementById('editPartCost').value = part.costPrice;
            document.getElementById('editPartSelling').value = part.sellingPrice;
            document.getElementById('editPartSupplier').value = part.supplierId;

            calcEditMargin();
            document.getElementById('editPartModal').classList.remove('hidden');
        }

        function closeEditPartModal() {
            document.getElementById('editPartModal').classList.add('hidden');
            editingPartId = null;
        }

        function handleUpdatePart(e) {
            e.preventDefault();
            if (!editingPartId) return;

            const part = partsData.find(p => p.id === editingPartId);
            if (!part) return;

            const sku = document.getElementById('editPartSKU').value.trim().toUpperCase();
            // Verify uniqueness if SKU changed
            if (partsData.some(p => p.id !== editingPartId && p.sku === sku)) {
                alert(`Error: A part with SKU "${sku}" already exists!`);
                return;
            }

            part.name = document.getElementById('editPartName').value.trim();
            part.sku = sku;
            part.category = document.getElementById('editPartCategory').value;
            part.bin = document.getElementById('editPartBin').value.trim();
            part.threshold = parseInt(document.getElementById('editPartThreshold').value) || 5;
            part.costPrice = parseFloat(document.getElementById('editPartCost').value) || 0;
            part.sellingPrice = parseFloat(document.getElementById('editPartSelling').value) || 0;
            part.supplierId = parseInt(document.getElementById('editPartSupplier').value);

            closeEditPartModal();
            renderPartsTable();
            renderSuppliersTable();
            updateInventoryKPIs();
            showToast(`Part "${part.name}" updated successfully.`);
        }

        // Delete Part Handler (Admin Control)
        function deletePart(id) {
            const part = partsData.find(p => p.id === id);
            if (!part) return;

            const confirmMsg = part.stock > 0
                ? `Delete "${part.name}" (${part.sku})?\n\nWARNING: There are currently ${part.stock} units in warehouse stock. Removing this part will write off the on-hand inventory in the audit log.`
                : `Delete "${part.name}" (${part.sku}) from catalog?`;

            if (confirm(confirmMsg)) {
                if (part.stock > 0) {
                    stockMovementsData.unshift({
                        id: Date.now(),
                        timestamp: 'Just now',
                        partName: part.name,
                        sku: part.sku,
                        change: -part.stock,
                        prevStock: part.stock,
                        newStock: 0,
                        reason: `Catalog deletion by Admin (Write-off of ${part.stock} units)`,
                        by: 'Jagath Perera (Admin)',
                        ref: 'DEL-WRITEOFF'
                    });
                }

                partsData = partsData.filter(p => p.id !== id);
                renderPartsTable();
                renderSuppliersTable();
                renderMovementsTable();
                updateInventoryKPIs();
                showToast(`Part "${part.name}" deleted from warehouse inventory.`);
            }
        }

        // ========================================================
        // ADJUST STOCK CONTROLLER (+/- WITH AUDIT TRAIL)
        // ========================================================

        function openAdjustStockModal(partId) {
            const select = document.getElementById('adjustStockPartSelect');
            select.innerHTML = partsData.map(p => `
                <option value="${p.id}">${p.sku} — ${p.name} (On-Hand: ${p.stock})</option>
            `).join('');

            if (partId) {
                select.value = partId.toString();
            }

            setAdjustType('ADD');
            document.getElementById('adjustStockQty').value = 5;
            document.getElementById('adjustStockReasonSelect').value = 'Restock from Supplier';
            document.getElementById('adjustStockCustomReasonContainer').classList.add('hidden');
            document.getElementById('adjustStockCustomReason').value = '';
            document.getElementById('adjustStockRef').value = '';

            onAdjustStockPartChange();
            document.getElementById('adjustStockModal').classList.remove('hidden');
        }

        function closeAdjustStockModal() {
            document.getElementById('adjustStockModal').classList.add('hidden');
        }

        function setAdjustType(type) {
            currentAdjustType = type;
            const btnAdd = document.getElementById('adjustTypeAdd');
            const btnDeduct = document.getElementById('adjustTypeDeduct');

            if (type === 'ADD') {
                btnAdd.className = 'px-3 py-2 rounded-lg border font-bold text-xs flex items-center justify-center gap-1.5 transition-all bg-emerald-50 text-emerald-700 border-emerald-300';
                btnDeduct.className = 'px-3 py-2 rounded-lg border font-bold text-xs flex items-center justify-center gap-1.5 transition-all bg-white text-slate-600 border-slate-200 hover:bg-slate-50';
                document.getElementById('adjustStockReasonSelect').value = 'Restock from Supplier';
            } else {
                btnDeduct.className = 'px-3 py-2 rounded-lg border font-bold text-xs flex items-center justify-center gap-1.5 transition-all bg-rose-50 text-rose-700 border-rose-300';
                btnAdd.className = 'px-3 py-2 rounded-lg border font-bold text-xs flex items-center justify-center gap-1.5 transition-all bg-white text-slate-600 border-slate-200 hover:bg-slate-50';
                document.getElementById('adjustStockReasonSelect').value = 'Used in Workshop Job';
            }

            onAdjustReasonSelectChange();
            calcAdjustPreview();
        }

        function quickAdjustQty(delta) {
            const input = document.getElementById('adjustStockQty');
            let val = parseInt(input.value) || 0;
            val += delta;
            if (val < 1) val = 1;
            input.value = val;
            calcAdjustPreview();
        }

        function onAdjustStockPartChange() {
            const select = document.getElementById('adjustStockPartSelect');
            const partId = parseInt(select.value);
            const part = partsData.find(p => p.id === partId);
            if (part) {
                document.getElementById('adjustCurrentStockDisplay').textContent = `${part.stock} units`;
            }
            calcAdjustPreview();
        }

        function onAdjustReasonSelectChange() {
            const sel = document.getElementById('adjustStockReasonSelect').value;
            const custom = document.getElementById('adjustStockCustomReasonContainer');
            if (sel === 'Other') {
                custom.classList.remove('hidden');
            } else {
                custom.classList.add('hidden');
            }
        }

        function calcAdjustPreview() {
            const select = document.getElementById('adjustStockPartSelect');
            const partId = parseInt(select.value);
            const part = partsData.find(p => p.id === partId);
            if (!part) return;

            const qty = parseInt(document.getElementById('adjustStockQty').value) || 0;
            const newBal = currentAdjustType === 'ADD' ? (part.stock + qty) : (part.stock - qty);

            const display = document.getElementById('adjustPreviewStockDisplay');
            display.textContent = `${newBal} units`;

            if (newBal <= part.threshold) {
                display.className = 'font-black text-rose-600 font-mono text-base';
            } else {
                display.className = 'font-black text-emerald-600 font-mono text-base';
            }
        }

        function handleAdjustStock(e) {
            e.preventDefault();
            const select = document.getElementById('adjustStockPartSelect');
            const partId = parseInt(select.value);
            const part = partsData.find(p => p.id === partId);
            if (!part) return;

            const qty = parseInt(document.getElementById('adjustStockQty').value) || 0;
            if (qty <= 0) {
                alert('Please enter a valid quantity to adjust.');
                return;
            }

            if (currentAdjustType === 'DEDUCT' && qty > part.stock) {
                if (!confirm(`Warning: Deducting ${qty} units will cause negative inventory balance (${part.stock - qty}). Do you wish to proceed?`)) {
                    return;
                }
            }

            let reason = document.getElementById('adjustStockReasonSelect').value;
            if (reason === 'Other') {
                reason = document.getElementById('adjustStockCustomReason').value.trim() || 'Administrative adjustment';
            }

            const ref = document.getElementById('adjustStockRef').value.trim();
            const fullReason = ref ? `${reason} (${ref})` : reason;

            const prevStock = part.stock;
            const delta = currentAdjustType === 'ADD' ? qty : -qty;
            const newStock = prevStock + delta;

            part.stock = newStock;

            // Prepend to Movement Audit Trail
            stockMovementsData.unshift({
                id: Date.now(),
                timestamp: 'Just now',
                partName: part.name,
                sku: part.sku,
                change: delta,
                prevStock: prevStock,
                newStock: newStock,
                reason: fullReason,
                by: 'Jagath Perera (Admin)',
                ref: ref || 'MANUAL-ADJ'
            });

            closeAdjustStockModal();
            renderPartsTable();
            renderMovementsTable();
            updateInventoryKPIs();
            showToast(`Adjusted stock for "${part.sku}": ${delta > 0 ? '+' : ''}${delta} units (New Balance: ${newStock})`);
        }

        // ========================================================
        // TAB 2 CONTROLLER: SUPPLIERS
        // ========================================================

        function renderSuppliersTable() {
            const tbody = document.getElementById('suppliersTableBody');
            const search = document.getElementById('suppliersSearchInput')?.value.toLowerCase().trim() || '';
            const statusFilter = document.getElementById('suppliersStatusFilter')?.value || 'ALL';

            const filtered = suppliersData.filter(s => {
                const matchesSearch = !search ||
                    s.name.toLowerCase().includes(search) ||
                    s.contact.toLowerCase().includes(search) ||
                    s.phone.toLowerCase().includes(search) ||
                    s.email.toLowerCase().includes(search) ||
                    (s.address && s.address.toLowerCase().includes(search));

                const matchesStatus = statusFilter === 'ALL' || s.status === statusFilter;
                return matchesSearch && matchesStatus;
            });

            if (filtered.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-400">
                            No supplier records match your criteria.
                        </td>
                    </tr>
                `;
            } else {
                tbody.innerHTML = filtered.map(s => {
                    const suppliedParts = partsData.filter(p => p.supplierId === s.id);
                    const partsCount = suppliedParts.length;

                    const statusPill = s.status === 'Active'
                        ? '<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Active</span>'
                        : '<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200"><span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>Inactive</span>';

                    const toggleText = s.status === 'Active' ? 'Deactivate' : 'Activate';
                    const toggleClass = s.status === 'Active' ? 'text-amber-600 hover:text-amber-800' : 'text-emerald-600 hover:text-emerald-800';

                    // Parts Chips
                    const partsBadges = suppliedParts.slice(0, 3).map(p => `
                        <span class="inline-block px-1.5 py-0.2 bg-slate-100 text-slate-700 rounded text-[10px] font-mono font-semibold" title="${p.name}">
                            ${p.sku}
                        </span>
                    `).join('');

                    const extraCount = partsCount > 3 ? `<span class="text-[10px] text-slate-400 font-semibold">+${partsCount - 3} more</span>` : '';

                    return `
                        <tr class="hover:bg-slate-50 transition-colors">
                            <!-- Supplier Company -->
                            <td class="py-3 px-4">
                                <div class="font-bold text-slate-900">${s.name}</div>
                                <div class="text-[10px] text-[#F05A28] font-semibold mt-0.5">${s.category || 'Automotive Spares'}</div>
                            </td>

                            <!-- Contact Person -->
                            <td class="py-3 px-4">
                                <div class="font-semibold text-slate-800">${s.contact}</div>
                            </td>

                            <!-- Channels -->
                            <td class="py-3 px-4 font-mono text-[11px]">
                                <div class="text-slate-800 font-bold">${s.phone}</div>
                                <div class="text-slate-400 text-[10px] truncate max-w-[180px]">${s.email}</div>
                                <div class="text-slate-400 text-[10px] truncate max-w-[200px] mt-0.5" title="${s.address}">${s.address}</div>
                            </td>

                            <!-- Parts Supplied -->
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-1.5 mb-1">
                                    <span class="font-bold text-xs text-slate-800 font-mono">${partsCount}</span>
                                    <span class="text-[11px] text-slate-500">parts linked</span>
                                </div>
                                <div class="flex flex-wrap items-center gap-1">
                                    ${partsBadges} ${extraCount}
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="py-3 px-4">
                                ${statusPill}
                            </td>

                            <!-- Actions -->
                            <td class="py-3 px-4 text-right space-x-2 whitespace-nowrap">
                                <button type="button" onclick="openEditSupplierModal(${s.id})"
                                    class="text-xs font-semibold text-[#F05A28] hover:underline">
                                    Edit
                                </button>
                                <span class="text-slate-300">•</span>
                                <button type="button" onclick="toggleSupplierStatus(${s.id})"
                                    class="text-xs font-semibold ${toggleClass} hover:underline">
                                    ${toggleText}
                                </button>
                                <span class="text-slate-300">•</span>
                                <button type="button" onclick="deleteSupplier(${s.id})"
                                    class="text-xs font-semibold text-rose-600 hover:text-rose-800 hover:underline">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    `;
                }).join('');
            }

            document.getElementById('suppliersCountDisplay').textContent = filtered.length;
        }

        function filterSuppliersTable() {
            renderSuppliersTable();
        }

        function openAddSupplierModal() {
            populateSupplierSelectDropdowns();
            document.getElementById('addSupplierModal').classList.remove('hidden');
        }

        function closeAddSupplierModal() {
            document.getElementById('addSupplierModal').classList.add('hidden');
        }

        function handleCreateSupplier(e) {
            e.preventDefault();
            const name = document.getElementById('newSupplierName').value.trim();
            const contact = document.getElementById('newSupplierContact').value.trim();
            const phone = document.getElementById('newSupplierPhone').value.trim();
            const email = document.getElementById('newSupplierEmail').value.trim();
            const category = document.getElementById('newSupplierCategory').value.trim();
            const status = document.getElementById('newSupplierStatus').value;
            const address = document.getElementById('newSupplierAddress').value.trim();

            const newId = Date.now();
            const newSupplier = {
                id: newId,
                name,
                contact,
                phone,
                email,
                category,
                status,
                address
            };

            suppliersData.push(newSupplier);

            // Link selected parts
            const checkedBoxes = document.querySelectorAll('#newSupplierPartsChecklist input[type="checkbox"]:checked');
            checkedBoxes.forEach(cb => {
                const partId = parseInt(cb.value);
                const part = partsData.find(p => p.id === partId);
                if (part) part.supplierId = newId;
            });

            e.target.reset();
            closeAddSupplierModal();
            populateSupplierSelectDropdowns();
            renderSuppliersTable();
            renderPartsTable();
            updateInventoryKPIs();
            showToast(`Supplier "${name}" registered with ID SUP-${newId.toString().slice(-4)}.`);
        }

        function openEditSupplierModal(id) {
            const supplier = suppliersData.find(s => s.id === id);
            if (!supplier) return;

            editingSupplierId = id;
            document.getElementById('editSupplierId').value = supplier.id;
            document.getElementById('editSupplierName').value = supplier.name;
            document.getElementById('editSupplierContact').value = supplier.contact;
            document.getElementById('editSupplierPhone').value = supplier.phone;
            document.getElementById('editSupplierEmail').value = supplier.email;
            document.getElementById('editSupplierCategory').value = supplier.category || '';
            document.getElementById('editSupplierStatus').value = supplier.status;
            document.getElementById('editSupplierAddress').value = supplier.address || '';

            document.getElementById('editSupplierModal').classList.remove('hidden');
        }

        function closeEditSupplierModal() {
            document.getElementById('editSupplierModal').classList.add('hidden');
            editingSupplierId = null;
        }

        function handleUpdateSupplier(e) {
            e.preventDefault();
            if (!editingSupplierId) return;

            const supplier = suppliersData.find(s => s.id === editingSupplierId);
            if (!supplier) return;

            supplier.name = document.getElementById('editSupplierName').value.trim();
            supplier.contact = document.getElementById('editSupplierContact').value.trim();
            supplier.phone = document.getElementById('editSupplierPhone').value.trim();
            supplier.email = document.getElementById('editSupplierEmail').value.trim();
            supplier.category = document.getElementById('editSupplierCategory').value.trim();
            supplier.status = document.getElementById('editSupplierStatus').value;
            supplier.address = document.getElementById('editSupplierAddress').value.trim();

            closeEditSupplierModal();
            populateSupplierSelectDropdowns();
            renderSuppliersTable();
            renderPartsTable();
            updateInventoryKPIs();
            showToast(`Supplier "${supplier.name}" updated successfully.`);
        }

        function toggleSupplierStatus(id) {
            const supplier = suppliersData.find(s => s.id === id);
            if (!supplier) return;

            supplier.status = supplier.status === 'Active' ? 'Inactive' : 'Active';
            populateSupplierSelectDropdowns();
            renderSuppliersTable();
            updateInventoryKPIs();
            showToast(`Supplier "${supplier.name}" is now marked ${supplier.status}.`);
        }

        function deleteSupplier(id) {
            const supplier = suppliersData.find(s => s.id === id);
            if (!supplier) return;

            const linkedParts = partsData.filter(p => p.supplierId === id);
            if (linkedParts.length > 0) {
                if (!confirm(`Warning: "${supplier.name}" is linked to ${linkedParts.length} parts in your catalog.\n\nDeleting will unassign this supplier from those parts. Do you wish to continue?`)) {
                    return;
                }
                // Unlink parts
                linkedParts.forEach(p => p.supplierId = null);
            } else {
                if (!confirm(`Are you sure you want to delete supplier "${supplier.name}"?`)) {
                    return;
                }
            }

            suppliersData = suppliersData.filter(s => s.id !== id);
            populateSupplierSelectDropdowns();
            renderSuppliersTable();
            renderPartsTable();
            updateInventoryKPIs();
            showToast(`Supplier "${supplier.name}" removed from vendor directory.`);
        }

        // ========================================================
        // TAB 3 CONTROLLER: STOCK MOVEMENT LOG (AUDIT TRAIL)
        // ========================================================

        function renderMovementsTable() {
            const tbody = document.getElementById('movementsTableBody');
            const search = document.getElementById('movementsSearchInput')?.value.toLowerCase().trim() || '';
            const typeFilter = document.getElementById('movementsTypeFilter')?.value || 'ALL';

            const filtered = stockMovementsData.filter(m => {
                const matchesSearch = !search ||
                    m.partName.toLowerCase().includes(search) ||
                    m.sku.toLowerCase().includes(search) ||
                    m.reason.toLowerCase().includes(search) ||
                    (m.ref && m.ref.toLowerCase().includes(search)) ||
                    m.by.toLowerCase().includes(search);

                const matchesType = typeFilter === 'ALL' ||
                    (typeFilter === 'RESTOCK' && m.change > 0 && m.reason.toLowerCase().includes('restock')) ||
                    (typeFilter === 'JOB' && m.change < 0 && m.reason.toLowerCase().includes('job')) ||
                    (typeFilter === 'MANUAL' && m.reason.toLowerCase().includes('audit')) ||
                    (typeFilter === 'INITIAL' && m.reason.toLowerCase().includes('initial')) ||
                    (typeFilter === 'DAMAGED' && m.reason.toLowerCase().includes('defective') || m.reason.toLowerCase().includes('write-off'));

                return matchesSearch && matchesType;
            });

            if (filtered.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-400">
                            No stock movement records match your search filter.
                        </td>
                    </tr>
                `;
            } else {
                tbody.innerHTML = filtered.map(m => {
                    const changeBadge = m.change > 0
                        ? `<span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-black font-mono bg-emerald-50 text-emerald-700 border border-emerald-200">+${m.change} units</span>`
                        : `<span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-black font-mono bg-rose-50 text-rose-700 border border-rose-200">${m.change} units</span>`;

                    return `
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3 px-4 font-mono text-[11px] text-slate-500 whitespace-nowrap">
                                ${m.timestamp}
                            </td>
                            <td class="py-3 px-4">
                                <div class="font-bold text-slate-900">${m.partName}</div>
                                <div class="text-[10px] text-slate-400 font-mono mt-0.5">${m.sku}</div>
                            </td>
                            <td class="py-3 px-4">
                                ${changeBadge}
                            </td>
                            <td class="py-3 px-4 font-mono text-xs text-slate-700 whitespace-nowrap">
                                <span class="text-slate-400">${m.prevStock}</span> &rarr; <span class="font-bold text-slate-900">${m.newStock} units</span>
                            </td>
                            <td class="py-3 px-4 text-xs text-slate-800">
                                <div>${m.reason}</div>
                                ${m.ref ? `<span class="text-[10px] font-mono text-slate-400 bg-slate-100 px-1 py-0.2 rounded mt-0.5 inline-block">Ref: ${m.ref}</span>` : ''}
                            </td>
                            <td class="py-3 px-4 text-right font-mono text-xs font-semibold text-slate-600 whitespace-nowrap">
                                ${m.by}
                            </td>
                        </tr>
                    `;
                }).join('');
            }

            document.getElementById('movementsCountDisplay').textContent = filtered.length;
        }

        function filterMovementsTable() {
            renderMovementsTable();
        }

        // Export data from current inventory tab
        function exportInventoryData() {
            if (currentInventoryTab === 'parts') {
                showToast(`Exported ${partsData.length} spare parts catalog records to CSV format.`);
            } else if (currentInventoryTab === 'suppliers') {
                showToast(`Exported ${suppliersData.length} suppliers records to CSV format.`);
            } else {
                showToast(`Exported ${stockMovementsData.length} audit trail movements to CSV format.`);
            }
        }

        // ========================================================
        // SCREEN 2: USERS DATA & ACTIONS
        // ========================================================
        let usersData = [
            { id: 1, name: 'Jagath Perera', nic: '197814502931', phone: '+94 77 123 4567', address: 'No. 14/A, Alfred Place, Colombo 03', email: 'jagath.p@vwms.lk', role: 'Admin', status: 'Active', lastLogin: 'Today, 09:14 AM (IP: 192.168.1.10)' },
            { id: 2, name: 'Asanka Mendis', nic: '198234109822', phone: '+94 71 890 1234', address: '45/2, Baseline Road, Dematagoda', email: 'asanka.m@vwms.lk', role: 'Supervisor', status: 'Active', lastLogin: 'Today, 07:45 AM (IP: 192.168.1.15)' },
            { id: 3, name: 'Front Desk Agent 01', nic: '199578120349', phone: '+94 76 345 6789', address: '18/C, Galle Road, Dehiwala', email: 'reception@vwms.lk', role: 'Front Desk', status: 'Active', lastLogin: 'Today, 07:30 AM (IP: 192.168.1.20)' },
            { id: 4, name: 'Dishan Karunaratne', nic: '199023456789', phone: '+94 70 567 8901', address: '78/1, High Level Road, Maharagama', email: 'dishan.k@vwms.lk', role: 'Technician', status: 'Active', lastLogin: 'Today, 08:00 AM (Station 03)' },
            { id: 5, name: 'Nuwan Pradeep', nic: '199211340981', phone: '+94 75 678 9012', address: '12, Temple Avenue, Kelaniya', email: 'nuwan.p@vwms.lk', role: 'Technician', status: 'Active', lastLogin: 'Today, 07:55 AM (Station 02)' },
            { id: 6, name: 'Kasun Perera', nic: '198945678123', phone: '+94 77 890 2345', address: '93/4, Negombo Road, Wattala', email: 'kasun.p@vwms.lk', role: 'Technician', status: 'Active', lastLogin: 'Today, 08:10 AM (Station 01)' },
            { id: 7, name: 'Ruwan Jayasuriya', nic: '199120938475', phone: '+94 78 901 3456', address: '22/B, Old Kottawa Road, Pannipitiya', email: 'ruwan.j@vwms.lk', role: 'Technician', status: 'Active', lastLogin: '2026-09-24, 05:30 PM (On Leave)' },
            { id: 8, name: 'Sunil Weerasinghe', nic: '198539201948', phone: '+94 72 012 4567', address: '104, Horana Road, Bandaragama', email: 'sunil.w@temp.lk', role: 'Front Desk', status: 'Suspended', lastLogin: '2026-08-14, 09:00 AM' }
        ];

        let activeUserRoleFilter = 'ALL';
        let editingUserId = null;

        function renderUsersTable() {
            const tbody = document.getElementById('userTableBody');
            const search = document.getElementById('userSearchInput')?.value.toLowerCase() || '';

            const filtered = usersData.filter(u => {
                const matchesRole = activeUserRoleFilter === 'ALL' || u.role === activeUserRoleFilter;
                const matchesSearch = !search ||
                    u.name.toLowerCase().includes(search) ||
                    u.email.toLowerCase().includes(search) ||
                    u.role.toLowerCase().includes(search) ||
                    (u.phone && u.phone.toLowerCase().includes(search)) ||
                    (u.nic && u.nic.toLowerCase().includes(search)) ||
                    (u.address && u.address.toLowerCase().includes(search));
                return matchesRole && matchesSearch;
            });

            tbody.innerHTML = filtered.map(u => {
                const roleColor = u.role === 'Admin' ? 'bg-purple-100 text-purple-800 border-purple-200' :
                    u.role === 'Supervisor' ? 'bg-blue-100 text-blue-800 border-blue-200' :
                        u.role === 'Front Desk' ? 'bg-orange-100 text-orange-800 border-orange-200' :
                            'bg-emerald-100 text-emerald-800 border-emerald-200';

                const statusPill = u.status === 'Active'
                    ? '<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Active</span>'
                    : '<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200"><span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>Suspended</span>';

                const toggleActionText = u.status === 'Active' ? 'Suspend' : 'Activate';
                const toggleActionClass = u.status === 'Active' ? 'text-amber-600 hover:text-amber-800' : 'text-emerald-600 hover:text-emerald-800';

                return `
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4">
                            <div class="font-bold text-slate-900">${u.name}</div>
                            <div class="text-[11px] text-slate-500 font-mono flex items-center gap-1.5 mt-0.5">
                                <span class="bg-slate-100 text-slate-700 px-1.5 py-0.2 rounded font-semibold text-[10px]">NIC: ${u.nic || 'N/A'}</span>
                                <span class="text-slate-300">•</span>
                                <span class="text-slate-700 font-semibold">${u.phone || 'N/A'}</span>
                            </div>
                            <div class="text-[11px] text-slate-400 mt-0.5 flex items-center gap-1.5">
                                <span>${u.email}</span>
                                <span class="text-slate-300">•</span>
                                <span class="text-slate-400 truncate max-w-[200px]" title="${u.address || ''}">${u.address || 'Address pending'}</span>
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold border ${roleColor}">${u.role}</span>
                        </td>
                        <td class="py-3 px-4">${statusPill}</td>
                        <td class="py-3 px-4 text-slate-500 font-mono text-[11px]">${u.lastLogin}</td>
                        <td class="py-3 px-4 text-right space-x-2 whitespace-nowrap">
                            <button type="button" onclick="openEditRoleModal(${u.id})" class="text-xs font-semibold text-[#F05A28] hover:underline">Edit Role</button>
                            <span class="text-slate-300">•</span>
                            <button type="button" onclick="toggleUserStatus(${u.id})" class="text-xs font-semibold ${toggleActionClass} hover:underline">${toggleActionText}</button>
                            <span class="text-slate-300">•</span>
                            <button type="button" onclick="resetUserPassword(${u.id})" class="text-xs font-semibold text-slate-500 hover:text-slate-800 hover:underline">Reset Pass</button>
                        </td>
                    </tr>
                `;
            }).join('');

            document.getElementById('sidebarUserCount').textContent = usersData.length;
        }

        function filterUserTable() {
            renderUsersTable();
        }

        function filterUserByRole(role) {
            activeUserRoleFilter = role;
            ['All', 'Admin', 'Supervisor', 'FrontDesk', 'Technician'].forEach(r => {
                const btn = document.getElementById(`roleFilter${r}`);
                if (btn) {
                    if ((role === 'ALL' && r === 'All') || (role === 'Front Desk' && r === 'FrontDesk') || (role === r)) {
                        btn.className = 'px-2.5 py-1 rounded-lg bg-[#F05A28] text-white font-semibold shadow-2xs transition-colors';
                    } else {
                        btn.className = 'px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold transition-colors';
                    }
                }
            });
            renderUsersTable();
        }

        function openAddUserModal() {
            document.getElementById('addUserModal').classList.remove('hidden');
        }
        function closeAddUserModal() {
            document.getElementById('addUserModal').classList.add('hidden');
        }

        function handleCreateUser(e) {
            e.preventDefault();
            const name = document.getElementById('newUserName').value.trim();
            const nic = document.getElementById('newUserNIC').value.trim();
            const phone = document.getElementById('newUserPhone').value.trim();
            const email = document.getElementById('newUserEmail').value.trim();
            const address = document.getElementById('newUserAddress').value.trim();
            const role = document.getElementById('newUserRole').value;

            usersData.push({
                id: Date.now(),
                name,
                nic,
                phone,
                email,
                address,
                role,
                status: 'Active',
                lastLogin: 'Never (Account Pending First Login)'
            });

            e.target.reset();
            closeAddUserModal();
            renderUsersTable();
            showToast(`User ${name} (${phone}) registered with ${role} permissions.`);
        }

        function openEditRoleModal(id) {
            editingUserId = id;
            const user = usersData.find(u => u.id === id);
            if (!user) return;
            document.getElementById('editRoleUserName').textContent = user.name;
            document.getElementById('editRoleSelect').value = user.role;
            document.getElementById('editRoleModal').classList.remove('hidden');
        }
        function closeEditRoleModal() {
            document.getElementById('editRoleModal').classList.add('hidden');
            editingUserId = null;
        }

        function confirmRoleUpdate() {
            if (!editingUserId) return;
            const newRole = document.getElementById('editRoleSelect').value;
            const user = usersData.find(u => u.id === editingUserId);
            if (user) {
                user.role = newRole;
                renderUsersTable();
                showToast(`Updated ${user.name}'s role to ${newRole}.`);
            }
            closeEditRoleModal();
        }

        function toggleUserStatus(id) {
            const user = usersData.find(u => u.id === id);
            if (!user) return;
            user.status = user.status === 'Active' ? 'Suspended' : 'Active';
            renderUsersTable();
            showToast(`Account for ${user.name} is now ${user.status}.`);
        }

        function resetUserPassword(id) {
            const user = usersData.find(u => u.id === id);
            if (!user) return;
            showToast(`Password reset link & temporary token dispatched to ${user.email}.`);
        }

        // ========================================================
        // SCREEN 3: SYSTEM SETTINGS
        // ========================================================
        function saveSystemSettings() {
            showToast('System settings, tax rates, and gateway keys saved successfully!');
        }

        // ========================================================
        // SCREEN 4: BACKUPS & EXPORTS
        // ========================================================
        let selectedBackupFormat = 'SQL';
        function setBackupFormat(fmt) {
            selectedBackupFormat = fmt;
            ['SQL', 'JSON', 'TOML', 'CSV'].forEach(f => {
                const btn = document.getElementById(`fmt${f}`);
                if (btn) {
                    if (f === fmt) {
                        btn.className = 'px-3 py-1 rounded-md font-bold bg-white text-slate-900 shadow-2xs';
                    } else {
                        btn.className = 'px-3 py-1 rounded-md text-slate-500 hover:text-slate-900';
                    }
                }
            });
        }

        function triggerImmediateBackup() {
            const btn = document.getElementById('generateBackupBtn');
            const btnText = document.getElementById('generateBackupText');
            btn.disabled = true;
            btnText.textContent = `Packaging ${selectedBackupFormat} Database Dump...`;

            setTimeout(() => {
                const now = new Date();
                const ts = now.toISOString().replace(/[-:T.]/g, '_').substring(0, 15);
                const fileName = `vwms_backup_manual_${ts}.${selectedBackupFormat.toLowerCase()}`;

                const tbody = document.getElementById('backupsTableBody');
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="py-3.5 px-4 font-mono font-bold text-slate-900">${fileName}</td>
                    <td class="py-3.5 px-4"><span class="px-2 py-0.5 rounded text-[10px] font-bold bg-orange-50 text-orange-700">${selectedBackupFormat}</span></td>
                    <td class="py-3.5 px-4 font-mono text-slate-600">25.1 MB</td>
                    <td class="py-3.5 px-4 text-slate-500">Just now</td>
                    <td class="py-3.5 px-4 text-slate-500">Admin (Manual Snapshot)</td>
                    <td class="py-3.5 px-4 text-right">
                        <button type="button" onclick="downloadBackupMock('${fileName}')"
                            class="px-3 py-1 text-xs font-semibold text-[#F05A28] hover:bg-orange-50 rounded border border-orange-200 transition-colors">
                            Download ↓
                        </button>
                    </td>
                `;
                tbody.prepend(tr);

                btn.disabled = false;
                btnText.textContent = 'Generate Backup Now';
                showToast(`Snapshot ${fileName} created and verified!`);
            }, 1200);
        }

        function downloadBackupMock(file) {
            showToast(`Downloading verified archive: ${file}`);
        }

        // ========================================================
        // SCREEN 5: NOTIFICATIONS LOG
        // ========================================================
        let notificationsLog = [
            { id: 101, event: 'Vehicle Repaired', target: 'Kamal Perera (+94 77 123 4567)', channel: 'SMS', status: 'Sent', time: '15m ago' },
            { id: 102, event: 'Invoice Ready', target: 'Dr. Harsha Alwis (harsha.a@med.lk)', channel: 'Email', status: 'Sent', time: '42m ago' },
            { id: 103, event: 'Vehicle Checked In', target: 'Dilani Wickramasinghe (+94 77 445 0918)', channel: 'WhatsApp', status: 'Sent', time: '1h 10m ago' },
            { id: 104, event: 'Out-of-Stock Parts Arrived', target: 'Floor Supervisor & Front Desk', channel: 'SMS', status: 'Failed', time: '2h 05m ago' },
            { id: 105, event: 'Vehicle Repaired', target: 'Rohan De Silva (+94 77 654 3210)', channel: 'SMS', status: 'Sent', time: '3h 30m ago' }
        ];

        function renderNotificationsTable() {
            const tbody = document.getElementById('notifTableBody');
            const eventFilter = document.getElementById('notifEventTypeFilter')?.value || 'ALL';
            const statusFilter = document.getElementById('notifStatusFilter')?.value || 'ALL';

            const filtered = notificationsLog.filter(n => {
                const matchesEvent = eventFilter === 'ALL' || n.event === eventFilter;
                const matchesStatus = statusFilter === 'ALL' || n.status === statusFilter;
                return matchesEvent && matchesStatus;
            });

            tbody.innerHTML = filtered.map(n => {
                const channelBadge = n.channel === 'SMS' ? 'bg-blue-50 text-blue-700 border-blue-200' :
                    n.channel === 'WhatsApp' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' :
                        'bg-purple-50 text-purple-700 border-purple-200';

                const statusBadge = n.status === 'Sent' ? '<span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Sent ✓</span>' :
                    n.status === 'Failed' ? '<span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">Failed ✗</span>' :
                        '<span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">Queued</span>';

                const action = n.status === 'Failed'
                    ? `<button type="button" onclick="retryNotification(${n.id})" class="px-2.5 py-1 text-xs font-bold text-rose-700 bg-rose-50 hover:bg-rose-100 rounded border border-rose-200">Retry ↻</button>`
                    : `<button type="button" onclick="showToast('Dispatch delivered to target gateway.')" class="text-xs font-medium text-slate-400 hover:text-slate-600">View Payload</button>`;

                return `
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 font-bold text-slate-900">${n.event}</td>
                        <td class="py-3 px-4 text-slate-700">${n.target}</td>
                        <td class="py-3 px-4"><span class="px-2 py-0.5 rounded text-[10px] font-bold border ${channelBadge}">${n.channel}</span></td>
                        <td class="py-3 px-4">${statusBadge}</td>
                        <td class="py-3 px-4 font-mono text-slate-500 text-[11px]">${n.time}</td>
                        <td class="py-3 px-4 text-right">${action}</td>
                    </tr>
                `;
            }).join('');

            document.getElementById('notifCountDisplay').textContent = filtered.length;
        }

        function filterNotificationLog() {
            renderNotificationsTable();
        }

        function retryNotification(id) {
            const item = notificationsLog.find(n => n.id === id);
            if (!item) return;
            item.status = 'Sent';
            renderNotificationsTable();
            showToast(`Notification for "${item.event}" redelivered via ${item.channel}!`);
        }

        function testNotificationEvent() {
            notificationsLog.unshift({
                id: Date.now(),
                event: 'Out-of-Stock Parts Arrived',
                target: 'Admin & Workshop Floor Staff',
                channel: 'SMS',
                status: 'Sent',
                time: 'Just now'
            });
            renderNotificationsTable();
            showToast('Test notification alert dispatched to staff channel.');
        }

        // ========================================================
        // SCREEN 6: CORE RECORDS (CUSTOMERS, VEHICLES, INVOICES, INVENTORY)
        // ========================================================
        let currentRecordEntity = 'customers';

        const recordsData = {
            customers: [
                { id: 'C-1001', name: 'Kamal Perera', phone: '+94 77 123 4567', email: 'kamal.p@gmail.com', vehicles: 2, spend: 'LKR 142,500' },
                { id: 'C-1051', name: 'Dilani Wickramasinghe', phone: '+94 77 445 0918', email: 'dilani.w@dialog.lk', vehicles: 4, spend: 'LKR 480,000' },
                { id: 'C-1052', name: 'Sunil Rathnayake', phone: '+94 76 332 9940', email: 'sunil.r@ceylonrubber.com', vehicles: 1, spend: 'LKR 38,900' },
                { id: 'C-1054', name: 'Chathurika Jayawardena', phone: '+94 77 908 1222', email: 'chathurika.j@yahoo.com', vehicles: 1, spend: 'LKR 84,200' },
                { id: 'C-1055', name: 'Dr. Harsha Alwis', phone: '+94 77 220 1199', email: 'harsha.a@med.lk', vehicles: 2, spend: 'LKR 219,000' },
                { id: 'C-1056', name: 'Rohan De Silva', phone: '+94 77 654 3210', email: 'rohan.desilva@lankaauto.lk', vehicles: 3, spend: 'LKR 310,000' }
            ],
            vehicles: [
                { plate: 'WP CBA-1234', make: 'Honda Vezel RU1', year: 2018, owner: 'Kamal Perera', mileage: '48,500 km', jobs: 5 },
                { plate: 'WP CAB-7892', make: 'Toyota Prado TX-L', year: 2020, owner: 'Dilani Wickramasinghe', mileage: '62,100 km', jobs: 8 },
                { plate: 'NW WP-9871', make: 'Nissan X-Trail T32', year: 2017, owner: 'Sunil Rathnayake', mileage: '82,400 km', jobs: 3 },
                { plate: 'WP CAD-5521', make: 'Toyota Aqua Hybrid', year: 2016, owner: 'Nimal Siriwardena', mileage: '110,000 km', jobs: 9 },
                { plate: 'CP CAA-8040', make: 'Honda Civic Turbo', year: 2019, owner: 'Chathurika Jayawardena', mileage: '41,200 km', jobs: 4 },
                { plate: 'SP BC-4912', make: 'Kia Sportage GT', year: 2020, owner: 'Dr. Harsha Alwis', mileage: '35,000 km', jobs: 2 },
                { plate: 'WP KX-3108', make: 'Toyota Hilux Revo', year: 2019, owner: 'Rohan De Silva', mileage: '94,500 km', jobs: 7 },
                { plate: 'WP CBJ-5049', make: 'Toyota Prado TX-L', year: 2020, owner: 'Dr. Harsha Alwis', mileage: '53,200 km', jobs: 6 }
            ],
            invoices: [
                { invId: 'INV-2691', date: '2026-09-26', customer: 'Dr. Harsha Alwis', plate: 'WP CBJ-5049', amount: 'LKR 41,900', method: 'PayHere Online', status: 'Paid' },
                { invId: 'INV-2688', date: '2026-09-25', customer: 'Rohan De Silva', plate: 'WP KX-3108', amount: 'LKR 48,200', method: 'Credit Card', status: 'Paid' },
                { invId: 'INV-2670', date: '2026-09-23', customer: 'Dialog Fleet', plate: 'WP CAB-4321', amount: 'LKR 62,500', method: 'Direct Bank Wire', status: 'Paid' },
                { invId: 'INV-2665', date: '2026-09-20', customer: 'Kamal Perera', plate: 'WP CBA-1234', amount: 'LKR 28,400', method: 'Cash', status: 'Paid' }
            ],
            inventory: [
                { sku: 'BRK-FER-001', name: 'Ferodo Ceramic Brake Pads (Front)', category: 'Braking', qty: 2, price: 'LKR 14,500', alert: 'Low Stock' },
                { sku: 'OIL-MOB-5W30', name: 'Mobil 1 Fully Synthetic 5W-30 (4L)', category: 'Fluids', qty: 3, price: 'LKR 18,200', alert: 'Low Stock' },
                { sku: 'FLT-TOY-OIL', name: 'Genuine Toyota Oil Filter C-110', category: 'Filters', qty: 24, price: 'LKR 2,400', alert: 'In Stock' },
                { sku: 'PLG-NGK-IRID', name: 'NGK Laser Iridium Spark Plug', category: 'Ignition', qty: 16, price: 'LKR 4,800', alert: 'In Stock' },
                { sku: 'HYB-INV-COOL', name: 'Toyota Super Long Life Coolant', category: 'Fluids', qty: 1, price: 'LKR 9,500', alert: 'Critical Low' }
            ]
        };

        let correctingEntity = '';
        let correctingKey = '';

        function switchRecordsEntity(entity) {
            currentRecordEntity = entity;
            ['customers', 'vehicles', 'invoices', 'inventory'].forEach(e => {
                const tab = document.getElementById(`tabEntity${e.charAt(0).toUpperCase() + e.slice(1)}`);
                if (tab) {
                    if (e === entity) {
                        tab.className = 'px-4 py-2.5 font-bold text-xs border-b-2 border-[#F05A28] text-[#F05A28] transition-colors';
                    } else {
                        tab.className = 'px-4 py-2.5 font-medium text-xs border-b-2 border-transparent text-slate-500 hover:text-slate-800 transition-colors';
                    }
                }
            });
            renderRecordsTable();
        }

        function renderRecordsTable() {
            const thead = document.getElementById('recordsTableHead');
            const tbody = document.getElementById('recordsTableBody');
            const query = document.getElementById('recordsSearchInput')?.value.toLowerCase() || '';

            if (currentRecordEntity === 'customers') {
                thead.innerHTML = `
                    <tr>
                        <th class="py-3 px-4">CUSTOMER ID & NAME</th>
                        <th class="py-3 px-4">CONTACT PHONE</th>
                        <th class="py-3 px-4">EMAIL</th>
                        <th class="py-3 px-4">REGISTERED VEHICLES</th>
                        <th class="py-3 px-4">LIFETIME SPEND</th>
                        <th class="py-3 px-4 text-right">CORRECT DATA</th>
                    </tr>
                `;
                const filtered = recordsData.customers.filter(c => !query || c.name.toLowerCase().includes(query) || c.phone.includes(query) || c.email.toLowerCase().includes(query));
                tbody.innerHTML = filtered.map(c => `
                    <tr class="hover:bg-slate-50">
                        <td class="py-3 px-4"><span class="font-mono text-slate-400 mr-1.5">${c.id}</span> <span class="font-bold text-slate-900">${c.name}</span></td>
                        <td class="py-3 px-4 font-mono text-slate-600">${c.phone}</td>
                        <td class="py-3 px-4 text-slate-500">${c.email}</td>
                        <td class="py-3 px-4 font-bold text-slate-700">${c.vehicles} vehicle(s)</td>
                        <td class="py-3 px-4 font-mono font-bold text-slate-900">${c.spend}</td>
                        <td class="py-3 px-4 text-right">
                            <button type="button" onclick="openCorrectRecordModal('customers', '${c.id}', 'Customer Phone', '${c.phone}')" class="text-xs font-semibold text-[#F05A28] hover:underline">Correct Phone</button>
                        </td>
                    </tr>
                `).join('');
            } else if (currentRecordEntity === 'vehicles') {
                thead.innerHTML = `
                    <tr>
                        <th class="py-3 px-4">LICENSE PLATE</th>
                        <th class="py-3 px-4">MAKE & MODEL</th>
                        <th class="py-3 px-4">YEAR</th>
                        <th class="py-3 px-4">REGISTERED OWNER</th>
                        <th class="py-3 px-4">CURRENT MILEAGE</th>
                        <th class="py-3 px-4 text-right">ACTION</th>
                    </tr>
                `;
                const filtered = recordsData.vehicles.filter(v => !query || v.plate.toLowerCase().includes(query) || v.make.toLowerCase().includes(query) || v.owner.toLowerCase().includes(query));
                tbody.innerHTML = filtered.map(v => `
                    <tr class="hover:bg-slate-50">
                        <td class="py-3 px-4"><div class="sl-plate-badge">${v.plate}</div></td>
                        <td class="py-3 px-4 font-bold text-slate-900">${v.make}</td>
                        <td class="py-3 px-4 font-mono text-slate-500">${v.year}</td>
                        <td class="py-3 px-4 text-slate-700">${v.owner}</td>
                        <td class="py-3 px-4 font-mono text-slate-600">${v.mileage}</td>
                        <td class="py-3 px-4 text-right">
                            <button type="button" onclick="openCorrectRecordModal('vehicles', '${v.plate}', 'Mileage', '${v.mileage}')" class="text-xs font-semibold text-[#F05A28] hover:underline">Adjust Mileage</button>
                        </td>
                    </tr>
                `).join('');
            } else if (currentRecordEntity === 'invoices') {
                thead.innerHTML = `
                    <tr>
                        <th class="py-3 px-4">INVOICE NUMBER</th>
                        <th class="py-3 px-4">DATE</th>
                        <th class="py-3 px-4">CUSTOMER</th>
                        <th class="py-3 px-4">VEHICLE</th>
                        <th class="py-3 px-4">PAYMENT METHOD</th>
                        <th class="py-3 px-4 text-right">TOTAL</th>
                    </tr>
                `;
                const filtered = recordsData.invoices.filter(i => !query || i.invId.toLowerCase().includes(query) || i.customer.toLowerCase().includes(query) || i.plate.toLowerCase().includes(query));
                tbody.innerHTML = filtered.map(i => `
                    <tr class="hover:bg-slate-50">
                        <td class="py-3 px-4 font-mono font-bold text-slate-900">${i.invId}</td>
                        <td class="py-3 px-4 font-mono text-slate-500">${i.date}</td>
                        <td class="py-3 px-4 font-bold text-slate-800">${i.customer}</td>
                        <td class="py-3 px-4 font-mono text-xs text-slate-600">${i.plate}</td>
                        <td class="py-3 px-4"><span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700">${i.method}</span></td>
                        <td class="py-3 px-4 text-right font-mono font-bold text-slate-900">${i.amount}</td>
                    </tr>
                `).join('');
            } else if (currentRecordEntity === 'inventory') {
                thead.innerHTML = `
                    <tr>
                        <th class="py-3 px-4">PART SKU</th>
                        <th class="py-3 px-4">DESCRIPTION</th>
                        <th class="py-3 px-4">CATEGORY</th>
                        <th class="py-3 px-4">QTY ON HAND</th>
                        <th class="py-3 px-4">UNIT RETAIL</th>
                        <th class="py-3 px-4 text-right">STATUS</th>
                    </tr>
                `;
                const filtered = partsData.filter(p => !query || p.sku.toLowerCase().includes(query) || p.name.toLowerCase().includes(query) || p.category.toLowerCase().includes(query));
                tbody.innerHTML = filtered.map(p => {
                    const isLow = p.stock <= p.threshold;
                    const alertBadge = isLow ? 'bg-rose-50 text-rose-700 border-rose-200' : 'bg-emerald-50 text-emerald-700 border-emerald-200';
                    const alertText = isLow ? 'Low Stock' : 'In Stock';
                    return `
                        <tr class="hover:bg-slate-50 cursor-pointer" onclick="switchAdminScreen('screen-inventory'); switchInventoryTab('parts');" title="Click to manage in full-control Inventory & Suppliers console">
                            <td class="py-3 px-4 font-mono font-bold text-slate-900">${p.sku}</td>
                            <td class="py-3 px-4 font-semibold text-slate-800">${p.name}</td>
                            <td class="py-3 px-4 text-slate-500">${p.category}</td>
                            <td class="py-3 px-4 font-mono font-bold text-slate-900">${p.stock} units</td>
                            <td class="py-3 px-4 font-mono text-slate-700">LKR ${p.sellingPrice.toLocaleString()}</td>
                            <td class="py-3 px-4 text-right"><span class="px-2 py-0.5 rounded text-[10px] font-bold border ${alertBadge}">${alertText}</span></td>
                        </tr>
                    `;
                }).join('');
            }
        }

        function filterRecordsTable() {
            renderRecordsTable();
        }

        function openCorrectRecordModal(entity, key, label, val) {
            correctingEntity = entity;
            correctingKey = key;
            document.getElementById('correctFieldLabel').textContent = `${label} for ${key}`;
            document.getElementById('correctRecordInput').value = val;
            document.getElementById('correctRecordReason').value = '';
            document.getElementById('correctRecordModal').classList.remove('hidden');
        }
        function closeCorrectRecordModal() {
            document.getElementById('correctRecordModal').classList.add('hidden');
        }

        function saveRecordCorrection() {
            const reason = document.getElementById('correctRecordReason').value.trim();
            const newVal = document.getElementById('correctRecordInput').value.trim();
            if (!reason) {
                showToast('Please specify a reason for this audit correction');
                return;
            }

            if (correctingEntity === 'customers') {
                const c = recordsData.customers.find(item => item.id === correctingKey);
                if (c) c.phone = newVal;
            } else if (correctingEntity === 'vehicles') {
                const v = recordsData.vehicles.find(item => item.plate === correctingKey);
                if (v) v.mileage = newVal;
            }

            renderRecordsTable();
            closeCorrectRecordModal();
            showToast(`Record updated in audit log: "${reason}"`);
        }

        function exportCurrentRecords() {
            showToast(`Exported ${currentRecordEntity} database table to CSV archive.`);
        }

        // ========================================================
        // GENERAL UTILITIES & LIFECYCLE
        // ========================================================
        function refreshAnalytics() {
            showToast('Live floor operations & workload metrics synchronized!');
        }

        function logoutAdmin() {
            if (confirm('Lock Admin Console and return to staff login?')) {
                window.location.href = '/login';
            }
        }

        function showToast(msg) {
            const toast = document.getElementById('toast');
            const toastMsg = document.getElementById('toastMsg');
            toastMsg.textContent = msg;
            toast.classList.remove('translate-y-20', 'opacity-0');
            setTimeout(() => {
                toast.classList.add('translate-y-20', 'opacity-0');
            }, 3200);
        }

        // Close on Escape Key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeAddUserModal();
                closeEditRoleModal();
                closeCorrectRecordModal();
                closeAddPartModal();
                closeEditPartModal();
                closeAdjustStockModal();
                closeAddSupplierModal();
                closeEditSupplierModal();
                toggleMobileSidebar(false);
            }
        });

        // Initialize on Load
        document.addEventListener('DOMContentLoaded', () => {
            initInventoryModule();
            renderUsersTable();
            renderNotificationsTable();
            renderRecordsTable();
        });
    </script>
</body>

</html>