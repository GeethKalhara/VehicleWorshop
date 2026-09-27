<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Active Jobs Kanban - VWMS OS</title>
    <meta name="description"
        content="Live interactive Kanban workshop floor management dashboard with drag and drop job cards on VWMS OS.">

    <!-- Google Fonts: Inter & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600;700;800&display=swap"
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
                            'orange-light': '#FFF5F1',
                            'orange-border': '#FFD4C2',
                        },
                        sidebar: {
                            bg: '#0F172A',
                            border: '#1E293B',
                            hover: '#1E293B',
                            active: '#1E293B',
                        }
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
            background: rgba(240, 90, 40, 0.12);
            color: #F05A28;
            border-left: 3px solid #F05A28;
        }

        /* Front Desk Kanban Card Styles (Drag Restricted) */
        .kanban-card {
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
            user-select: none;
        }

        .kanban-card:hover {
            transform: translateY(-1px);
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
        <!-- 1. LEFT SIDEBAR: DARK OPERATIONS NAVIGATION             -->
        <!-- ======================================================== -->
        <aside id="sidebar"
            class="fixed top-0 bottom-0 left-0 w-64 bg-[#0F172A] text-white z-50 flex flex-col justify-between transition-transform duration-300 -translate-x-full lg:translate-x-0 lg:static lg:z-auto border-r border-slate-800">

            <!-- Top Container: Logo + Menu Items -->
            <div class="flex flex-col">
                <!-- Top Brand: VWMS OS -->
                <div class="px-5 py-5 border-b border-slate-800/80 flex items-center justify-between">
                    <a href="/frontdesk/dashboard" class="flex items-center gap-2.5 group">
                        <!-- Orange Icon -->
                        <div
                            class="w-8 h-8 rounded-lg bg-[#F05A28] flex items-center justify-center shadow-md shadow-orange-500/20 group-hover:scale-105 transition-transform duration-200">
                            <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path
                                    d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                </path>
                            </svg>
                        </div>
                        <!-- Logo Typography: VWMS + OS -->
                        <div class="flex items-center text-lg font-bold tracking-tight">
                            <span class="text-white">VWMS</span>
                            <span class="text-[#F05A28] ml-1.5 font-extrabold">OS</span>
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
                <nav class="px-3 py-5 space-y-1.5" aria-label="Front Desk Navigation">
                    <!-- Section Title -->
                    <div class="px-3 pb-2 text-[10px] font-bold text-slate-400 tracking-widest uppercase">
                        OPERATIONS
                    </div>

                    <!-- 1. Intake -->
                    <a href="/frontdesk/dashboard"
                        class="flex items-center gap-3 px-3 py-2 rounded-md text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 font-medium text-sm transition-colors duration-150">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="12" y1="18" x2="12" y2="12"></line>
                            <polyline points="9 15 12 12 15 15"></polyline>
                        </svg>
                        <span>Intake</span>
                    </a>

                    <!-- 2. Active Jobs (ACTIVE) -->
                    <a href="/frontdesk/active-jobs"
                        class="nav-item-active flex items-center gap-3 px-3 py-2 rounded-md font-semibold text-sm transition-all duration-150">
                        <svg class="w-4 h-4 text-[#F05A28]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z">
                            </path>
                        </svg>
                        <span>Active Jobs</span>
                    </a>

                    <!-- 3. Invoicing -->
                    <a href="#invoicing" onclick="showToast('Navigating to Invoicing...')"
                        class="flex items-center gap-3 px-3 py-2 rounded-md text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 font-medium text-sm transition-colors duration-150">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                            <line x1="6" y1="8" x2="10" y2="8"></line>
                            <line x1="6" y1="12" x2="18" y2="12"></line>
                            <line x1="6" y1="16" x2="14" y2="16"></line>
                        </svg>
                        <span>Invoicing</span>
                    </a>

                    <!-- 4. Customers & Vehicles -->
                    <a href="/frontdesk/customers"
                        class="flex items-center gap-3 px-3 py-2 rounded-md text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 font-medium text-sm transition-colors duration-150">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.2 1 12 1 13v3c0 .6.4 1 1 1h2"></path>
                            <circle cx="7" cy="17" r="2"></circle>
                            <path d="M9 17h6"></path>
                            <circle cx="17" cy="17" r="2"></circle>
                        </svg>
                        <span>Customers & Vehicles</span>
                    </a>
                </nav>
            </div>

            <!-- Bottom Section: Front Desk Agent Profile Card -->
            <div class="p-3 border-t border-slate-800">
                <div
                    class="border border-dashed border-slate-700/80 rounded-lg p-2.5 flex items-center justify-between bg-slate-900/40">
                    <div class="flex items-center gap-2.5">
                        <div class="relative flex-shrink-0">
                            <div
                                class="w-8 h-8 rounded-full bg-[#EA580C] text-white flex items-center justify-center text-xs font-bold shadow-sm">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <!-- Live Online Dot -->
                            <span
                                class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-[#0F172A] rounded-full"></span>
                        </div>
                        <div class="flex flex-col min-w-0">
                            <span class="text-xs font-semibold text-white truncate leading-tight">Front Desk Agent</span>
                            <span class="text-[11px] text-slate-400 truncate leading-tight mt-0.5">Intake Station 01</span>
                        </div>
                    </div>

                    <!-- Station Lock -->
                    <button type="button" onclick="lockStation()"
                        class="p-1.5 text-slate-500 hover:text-slate-200 transition-colors" title="Lock Workstation">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                    </button>
                </div>
            </div>

        </aside>

        <!-- Mobile Sidebar Overlay Backdrop -->
        <div id="sidebarBackdrop" class="fixed inset-0 bg-slate-900/60 z-40 lg:hidden hidden backdrop-blur-sm"
            onclick="toggleMobileSidebar(false)"></div>

        <!-- ======================================================== -->
        <!-- 2. MAIN WORKSPACE CONTENT AREA                           -->
        <!-- ======================================================== -->
        <div class="flex-1 flex flex-col min-w-0">

            <!-- Top Header Bar -->
            <header
                class="bg-white border-b border-slate-200 sticky top-0 z-30 px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
                <!-- Left: Mobile Menu Trigger + Breadcrumb -->
                <div class="flex items-center gap-3">
                    <button type="button" class="lg:hidden p-2 text-slate-500 hover:text-slate-700"
                        onclick="toggleMobileSidebar(true)" aria-label="Open navigation">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <!-- Breadcrumbs -->
                    <div class="flex items-center gap-2 text-xs text-slate-500">
                        <svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                            <line x1="8" y1="21" x2="16" y2="21"></line>
                            <line x1="12" y1="17" x2="12" y2="21"></line>
                        </svg>
                        <a href="/frontdesk/dashboard" class="hover:text-slate-800 transition-colors">Front Desk</a>
                        <span class="text-slate-300">/</span>
                        <span class="font-bold text-slate-800">Active Jobs</span>
                    </div>
                </div>

                <!-- Right: Omnibar Search + Notifications + Profile -->
                <div class="flex items-center gap-3 sm:gap-4">
                    <!-- Search Omnibar -->
                    <div class="relative hidden sm:block w-72 md:w-80">
                        <span
                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.35-4.35"></path>
                            </svg>
                        </span>
                        <input type="text" id="globalSearchInput" onkeyup="handleGlobalSearch(event)"
                            placeholder="Search Vehicle"
                            class="w-full pl-9 pr-4 py-1.5 text-xs bg-slate-50 hover:bg-white focus:bg-white border border-slate-200 rounded-md focus:outline-none focus:ring-1 focus:ring-[#F05A28] focus:border-[#F05A28] text-slate-700 transition-all placeholder:text-slate-400">
                    </div>

                    <!-- Notification Bell with Count Pill -->
                    <div class="relative">
                        <button type="button" onclick="showToast('Floor update: 1 vehicle moved to QA')"
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
                    </div>

                    <!-- Profile Circle Button -->
                    <button type="button" onclick="showToast('Front Desk Station #01 Active')"
                        class="w-8 h-8 rounded-full bg-[#B45309] text-white flex items-center justify-center text-xs font-bold ring-2 ring-white shadow-sm hover:opacity-95 transition-opacity"
                        aria-label="Agent Account">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </button>
                </div>
            </header>

            <!-- Main Workspace Container -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-[1600px] w-full mx-auto space-y-5">

                <!-- Page Headline & Action Toolbar -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex flex-wrap items-center gap-3">
                        <h1 class="text-2xl font-extrabold text-[#0F172A] tracking-tight">Active Jobs</h1>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200 shadow-2xs">
                            <svg class="w-3 h-3 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            Front Desk View • Stage Progression Restricted
                        </span>
                    </div>

                    <div class="flex items-center gap-2.5">
                        <!-- Local Kanban Plate Search Filter -->
                        <div class="relative w-60 sm:w-64">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-2.5 pointer-events-none text-slate-400">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <path d="m21 21-4.35-4.35"></path>
                                </svg>
                            </span>
                            <input type="text" id="kanbanFilterInput" oninput="filterKanbanCards()"
                                placeholder="Search job or plate..."
                                class="w-full pl-8 pr-3 py-1.5 text-xs bg-white border border-slate-200 rounded-md focus:outline-none focus:ring-1 focus:ring-[#F05A28] focus:border-[#F05A28] text-slate-700 placeholder:text-slate-400">
                        </div>

                        <!-- CTA Button: + New Job Card -->
                        <button type="button" onclick="openNewJobModal()"
                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-md bg-[#F05A28] hover:bg-[#D94819] text-white text-xs font-semibold shadow-sm transition-colors duration-150 whitespace-nowrap">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            <span>+ New Job Card</span>
                        </button>
                    </div>
                </div>

                <!-- ==================================================== -->
                <!-- METRICS RIBBON BAR                                   -->
                <!-- ==================================================== -->
                <div class="bg-white rounded-xl border border-slate-200/90 shadow-sm p-4 grid grid-cols-2 md:grid-cols-4 divide-y md:divide-y-0 md:divide-x divide-slate-100 gap-3 md:gap-0">
                    <!-- Metric 1: Vehicles On Floor -->
                    <div class="px-3 sm:px-5 py-1 flex items-center justify-between">
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">VEHICLES ON FLOOR</span>
                        <span id="statFloorCount" class="text-base font-extrabold text-[#0F172A]">8</span>
                    </div>

                    <!-- Metric 2: Technicians Active -->
                    <div class="px-3 sm:px-5 py-1 flex items-center justify-between pt-2.5 md:pt-0">
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">TECHNICIANS ACTIVE</span>
                        <span class="text-base font-extrabold text-[#0F172A]">5 / 6</span>
                    </div>

                    <!-- Metric 3: Pending QA -->
                    <div class="px-3 sm:px-5 py-1 flex items-center justify-between pt-2.5 md:pt-0">
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">PENDING QA</span>
                        <span id="statPendingQa" class="text-base font-extrabold text-[#0F172A]">1</span>
                    </div>

                    <!-- Metric 4: Ready for Handover -->
                    <div class="px-3 sm:px-5 py-1 flex items-center justify-between pt-2.5 md:pt-0">
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">READY FOR HANDOVER</span>
                        <span id="statReadyCount" class="text-base font-extrabold text-[#0F172A]">2</span>
                    </div>
                </div>

                <!-- ==================================================== -->
                <!-- KANBAN BOARD (FRONT DESK VIEW: DRAG RESTRICTED)      -->
                <!-- ==================================================== -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 items-start" id="kanbanBoard">

                    <!-- ================================================ -->
                    <!-- COLUMN 1: IN QUEUE                               -->
                    <!-- ================================================ -->
                    <div class="bg-slate-50/80 rounded-xl border border-slate-200/80 p-3 flex flex-col min-h-[560px]">
                        <!-- Column Header -->
                        <div class="flex items-center justify-between px-1.5 py-1.5 mb-2.5">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-slate-500"></span>
                                <h3 class="font-bold text-slate-800 text-xs sm:text-sm">In Queue</h3>
                            </div>
                            <span id="count-in-queue"
                                class="w-5 h-5 rounded-full bg-white border border-slate-200 text-slate-700 text-[11px] font-bold flex items-center justify-center shadow-xs">
                                2
                            </span>
                        </div>

                        <!-- Column Body -->
                        <div class="kanban-column-body flex-1 space-y-2.5 p-1 rounded-lg transition-colors" data-column-id="in-queue">

                            <!-- CARD 1 -->
                            <div id="card-cba1234" draggable="false"
                                onclick="openJobDetails('WP CBA-1234', null, 'Brake pad replacement & disc skimming', 'in-queue')"
                                class="kanban-card bg-white rounded-lg border border-slate-200 p-3 shadow-xs hover:shadow-md transition-all">
                                <!-- Dark Header Bar (Marked Area) with White Letters -->
                                <div class="bg-[#0F172A] text-white p-2.5 rounded-md flex items-center justify-between gap-2 mb-2.5 card-header-bar">
                                    <div class="font-mono font-bold text-white text-xs sm:text-sm tracking-tight card-plate">WP CBA-1234</div>
                                    <span class="card-status-badge px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-slate-800 text-slate-100 border border-slate-700">
                                        QUEUED
                                    </span>
                                </div>
                                <!-- Technician Info: Not Assigned for Jobs in Queue -->
                                <div class="card-tech-row pt-1.5 border-t border-slate-100 flex items-center gap-1.5 text-slate-400 text-[11px]">
                                    <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line>
                                    </svg>
                                    <span>Not Assigned</span>
                                </div>
                            </div>

                            <!-- CARD 2 -->
                            <div id="card-cab7892" draggable="false"
                                onclick="openJobDetails('WP CAB-7892', null, '40k Service & Engine Tune-up', 'in-queue')"
                                class="kanban-card bg-white rounded-lg border border-slate-200 p-3 shadow-xs hover:shadow-md transition-all">
                                <!-- Dark Header Bar (Marked Area) with White Letters -->
                                <div class="bg-[#0F172A] text-white p-2.5 rounded-md flex items-center justify-between gap-2 mb-2.5 card-header-bar">
                                    <div class="font-mono font-bold text-white text-xs sm:text-sm tracking-tight card-plate">WP CAB-7892</div>
                                    <span class="card-status-badge px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-slate-800 text-slate-100 border border-slate-700">
                                        QUEUED
                                    </span>
                                </div>
                                <!-- Technician Info: Not Assigned for Jobs in Queue -->
                                <div class="card-tech-row pt-1.5 border-t border-slate-100 flex items-center gap-1.5 text-slate-400 text-[11px]">
                                    <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line>
                                    </svg>
                                    <span>Not Assigned</span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- ================================================ -->
                    <!-- COLUMN 2: IN PROGRESS                            -->
                    <!-- ================================================ -->
                    <div class="bg-slate-50/80 rounded-xl border border-slate-200/80 p-3 flex flex-col min-h-[560px]">
                        <!-- Column Header -->
                        <div class="flex items-center justify-between px-1.5 py-1.5 mb-2.5">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                                <h3 class="font-bold text-slate-800 text-xs sm:text-sm">In Progress</h3>
                            </div>
                            <span id="count-in-progress"
                                class="w-5 h-5 rounded-full bg-white border border-slate-200 text-slate-700 text-[11px] font-bold flex items-center justify-center shadow-xs">
                                3
                            </span>
                        </div>

                        <!-- Column Body -->
                        <div class="kanban-column-body flex-1 space-y-2.5 p-1 rounded-lg transition-colors" data-column-id="in-progress">

                            <!-- CARD 3 -->
                            <div id="card-wp9870" draggable="false"
                                data-tech="M. Kumara" data-initials="MK"
                                onclick="openJobDetails('NW WP-9871', 'M. Kumara', 'Transmission Flush & Gearbox Diagnostics', 'in-progress')"
                                class="kanban-card bg-white rounded-lg border border-slate-200 p-3 shadow-xs hover:shadow-md transition-all">
                                <div class="bg-[#0F172A] text-white p-2.5 rounded-md flex items-center justify-between gap-2 mb-2.5 card-header-bar">
                                    <div class="font-mono font-bold text-white text-xs sm:text-sm tracking-tight card-plate">NW WP-9871</div>
                                    <span class="card-status-badge px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-blue-600/30 text-blue-200 border border-blue-500/50">
                                        IN PROGRESS
                                    </span>
                                </div>
                                <div class="flex items-center gap-2.5 pt-1.5 border-t border-slate-100 card-tech-row">
                                    <div class="w-6 h-6 rounded-full bg-slate-100 border border-slate-200 text-slate-700 text-[10px] font-bold flex items-center justify-center flex-shrink-0 card-tech-avatar">
                                        MK
                                    </div>
                                    <div class="flex flex-col min-w-0">
                                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider leading-none mb-0.5">Technician</span>
                                        <span class="truncate text-xs font-semibold text-slate-800 leading-tight card-tech-name">M. Kumara</span>
                                    </div>
                                </div>
                            </div>

                            <!-- CARD 4 -->
                            <div id="card-cad5521" draggable="false"
                                data-tech="A. Saman" data-initials="AS"
                                onclick="openJobDetails('WP CAD-5521', 'A. Saman', 'Suspension Overhaul & Bushing Replacement', 'in-progress')"
                                class="kanban-card bg-white rounded-lg border border-slate-200 p-3 shadow-xs hover:shadow-md transition-all">
                                <div class="bg-[#0F172A] text-white p-2.5 rounded-md flex items-center justify-between gap-2 mb-2.5 card-header-bar">
                                    <div class="font-mono font-bold text-white text-xs sm:text-sm tracking-tight card-plate">WP CAD-5521</div>
                                    <span class="card-status-badge px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-blue-600/30 text-blue-200 border border-blue-500/50">
                                        IN PROGRESS
                                    </span>
                                </div>
                                <div class="flex items-center gap-2.5 pt-1.5 border-t border-slate-100 card-tech-row">
                                    <div class="w-6 h-6 rounded-full bg-slate-100 border border-slate-200 text-slate-700 text-[10px] font-bold flex items-center justify-center flex-shrink-0 card-tech-avatar">
                                        AS
                                    </div>
                                    <div class="flex flex-col min-w-0">
                                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider leading-none mb-0.5">Technician</span>
                                        <span class="truncate text-xs font-semibold text-slate-800 leading-tight card-tech-name">A. Saman</span>
                                    </div>
                                </div>
                            </div>

                            <!-- CARD 5 -->
                            <div id="card-caa8040" draggable="false"
                                data-tech="D. Kulatunga" data-initials="DK"
                                onclick="openJobDetails('CP CAA-8040', 'D. Kulatunga', 'Radiator & Coolant System Overhaul', 'in-progress')"
                                class="kanban-card bg-white rounded-lg border border-slate-200 p-3 shadow-xs hover:shadow-md transition-all">
                                <div class="bg-[#0F172A] text-white p-2.5 rounded-md flex items-center justify-between gap-2 mb-2.5 card-header-bar">
                                    <div class="font-mono font-bold text-white text-xs sm:text-sm tracking-tight card-plate">CP CAA-8040</div>
                                    <span class="card-status-badge px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-blue-600/30 text-blue-200 border border-blue-500/50">
                                        IN PROGRESS
                                    </span>
                                </div>
                                <div class="flex items-center gap-2.5 pt-1.5 border-t border-slate-100 card-tech-row">
                                    <div class="w-6 h-6 rounded-full bg-slate-100 border border-slate-200 text-slate-700 text-[10px] font-bold flex items-center justify-center flex-shrink-0 card-tech-avatar">
                                        DK
                                    </div>
                                    <div class="flex flex-col min-w-0">
                                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider leading-none mb-0.5">Technician</span>
                                        <span class="truncate text-xs font-semibold text-slate-800 leading-tight card-tech-name">D. Kulatunga</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- ================================================ -->
                    <!-- COLUMN 3: PENDING QA                             -->
                    <!-- ================================================ -->
                    <div class="bg-slate-50/80 rounded-xl border border-slate-200/80 p-3 flex flex-col min-h-[560px]">
                        <!-- Column Header -->
                        <div class="flex items-center justify-between px-1.5 py-1.5 mb-2.5">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                                <h3 class="font-bold text-slate-800 text-xs sm:text-sm">Pending QA</h3>
                            </div>
                            <span id="count-pending-qa"
                                class="w-5 h-5 rounded-full bg-white border border-slate-200 text-slate-700 text-[11px] font-bold flex items-center justify-center shadow-xs">
                                1
                            </span>
                        </div>

                        <!-- Column Body -->
                        <div class="kanban-column-body flex-1 space-y-2.5 p-1 rounded-lg transition-colors" data-column-id="pending-qa">

                            <!-- CARD 6 -->
                            <div id="card-bc4912" draggable="false"
                                data-tech="S. Nisanka" data-initials="SN"
                                onclick="openJobDetails('SP BC-4912', 'S. Nisanka', 'Steering Calibration & Test Drive', 'pending-qa')"
                                class="kanban-card bg-white rounded-lg border border-slate-200 p-3 shadow-xs hover:shadow-md transition-all">
                                <div class="bg-[#0F172A] text-white p-2.5 rounded-md flex items-center justify-between gap-2 mb-2.5 card-header-bar">
                                    <div class="font-mono font-bold text-white text-xs sm:text-sm tracking-tight card-plate">SP BC-4912</div>
                                    <span class="card-status-badge px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-amber-600/30 text-amber-200 border border-amber-500/50">
                                        PENDING QA
                                    </span>
                                </div>
                                <div class="flex items-center gap-2.5 pt-1.5 border-t border-slate-100 card-tech-row">
                                    <div class="w-6 h-6 rounded-full bg-slate-100 border border-slate-200 text-slate-700 text-[10px] font-bold flex items-center justify-center flex-shrink-0 card-tech-avatar">
                                        SN
                                    </div>
                                    <div class="flex flex-col min-w-0">
                                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider leading-none mb-0.5">Technician</span>
                                        <span class="truncate text-xs font-semibold text-slate-800 leading-tight card-tech-name">S. Nisanka</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- ================================================ -->
                    <!-- COLUMN 4: READY FOR CHECKOUT                     -->
                    <!-- ================================================ -->
                    <div class="bg-slate-50/80 rounded-xl border border-slate-200/80 p-3 flex flex-col min-h-[560px]">
                        <!-- Column Header -->
                        <div class="flex items-center justify-between px-1.5 py-1.5 mb-2.5">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                                <h3 class="font-bold text-slate-800 text-xs sm:text-sm">Ready for Checkout</h3>
                            </div>
                            <span id="count-ready"
                                class="w-5 h-5 rounded-full bg-white border border-slate-200 text-slate-700 text-[11px] font-bold flex items-center justify-center shadow-xs">
                                2
                            </span>
                        </div>

                        <!-- Column Body -->
                        <div class="kanban-column-body flex-1 space-y-2.5 p-1 rounded-lg transition-colors" data-column-id="ready">

                            <!-- CARD 7 -->
                            <div id="card-kx3108" draggable="false"
                                data-tech="M. Kumara" data-initials="MK"
                                onclick="openJobDetails('WP KX-3108', 'M. Kumara', 'Express Detailing & AC Sanitization', 'ready')"
                                class="kanban-card bg-white rounded-lg border border-slate-200 p-3 shadow-xs hover:shadow-md transition-all">
                                <div class="bg-[#0F172A] text-white p-2.5 rounded-md flex items-center justify-between gap-2 mb-2.5 card-header-bar">
                                    <div class="font-mono font-bold text-white text-xs sm:text-sm tracking-tight card-plate">WP KX-3108</div>
                                    <span class="card-status-badge px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-emerald-600/30 text-emerald-200 border border-emerald-500/50">
                                        READY
                                    </span>
                                </div>
                                <div class="flex items-center gap-2.5 pt-1.5 border-t border-slate-100 card-tech-row">
                                    <div class="w-6 h-6 rounded-full bg-slate-100 border border-slate-200 text-slate-700 text-[10px] font-bold flex items-center justify-center flex-shrink-0 card-tech-avatar">
                                        MK
                                    </div>
                                    <div class="flex flex-col min-w-0">
                                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider leading-none mb-0.5">Technician</span>
                                        <span class="truncate text-xs font-semibold text-slate-800 leading-tight card-tech-name">M. Kumara</span>
                                    </div>
                                </div>
                            </div>

                            <!-- CARD 8 -->
                            <div id="card-cbb6701" draggable="false"
                                data-tech="A. Saman" data-initials="AS"
                                onclick="openJobDetails('WP CBB-6701', 'A. Saman', 'Full Body Polish & Hybrid Battery Check', 'ready')"
                                class="kanban-card bg-white rounded-lg border border-slate-200 p-3 shadow-xs hover:shadow-md transition-all">
                                <div class="bg-[#0F172A] text-white p-2.5 rounded-md flex items-center justify-between gap-2 mb-2.5 card-header-bar">
                                    <div class="font-mono font-bold text-white text-xs sm:text-sm tracking-tight card-plate">WP CBB-6701</div>
                                    <span class="card-status-badge px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-emerald-600/30 text-emerald-200 border border-emerald-500/50">
                                        READY
                                    </span>
                                </div>
                                <div class="flex items-center gap-2.5 pt-1.5 border-t border-slate-100 card-tech-row">
                                    <div class="w-6 h-6 rounded-full bg-slate-100 border border-slate-200 text-slate-700 text-[10px] font-bold flex items-center justify-center flex-shrink-0 card-tech-avatar">
                                        AS
                                    </div>
                                    <div class="flex flex-col min-w-0">
                                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider leading-none mb-0.5">Technician</span>
                                        <span class="truncate text-xs font-semibold text-slate-800 leading-tight card-tech-name">A. Saman</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </main>

        </div>

    </div>

    <!-- ======================================================== -->
    <!-- 3. MODAL: CREATE NEW JOB CARD                            -->
    <!-- ======================================================== -->
    <div id="newJobModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden" role="dialog" aria-modal="true">
        <div class="bg-white rounded-xl shadow-2xl border border-slate-200 w-full max-w-lg overflow-hidden transform transition-all">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-md bg-orange-100 text-[#F05A28] flex items-center justify-center">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 leading-tight">Create New Workshop Job Card</h3>
                        <p class="text-[11px] text-slate-500">Assign vehicle to bay and technician</p>
                    </div>
                </div>
                <button type="button" onclick="closeNewJobModal()" class="text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Form -->
            <form onsubmit="handleCreateJobCard(event)" class="p-6 space-y-4 text-xs">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label for="jobPlate" class="block font-semibold text-slate-700 mb-1">Registration Plate No *</label>
                        <input type="text" id="jobPlate" required placeholder="WP CAR-9988"
                            class="w-full px-3 py-2 border border-slate-200 rounded-md focus:ring-1 focus:ring-[#F05A28] focus:border-[#F05A28] outline-none font-mono uppercase font-bold text-slate-800">
                    </div>
                    <div>
                        <label for="jobInitialColumn" class="block font-semibold text-slate-700 mb-1">Initial Status Column *</label>
                        <select id="jobInitialColumn" onchange="handleModalColumnChange(this.value)" class="w-full px-3 py-2 border border-slate-200 rounded-md focus:ring-1 focus:ring-[#F05A28] focus:border-[#F05A28] outline-none font-medium">
                            <option value="in-queue" selected>In Queue</option>
                            <option value="in-progress">In Progress</option>
                            <option value="pending-qa">Pending QA</option>
                        </select>
                    </div>
                    <div>
                        <label for="jobTech" class="block font-semibold text-slate-700 mb-1">Lead Technician</label>
                        <select id="jobTech" class="w-full px-3 py-2 border border-slate-200 rounded-md focus:ring-1 focus:ring-[#F05A28] focus:border-[#F05A28] outline-none font-medium">
                            <option value="none" selected>Not Assigned (Floor Queue)</option>
                            <option value="MK - M. Kumara">MK - M. Kumara (Bay 01)</option>
                            <option value="AS - A. Saman">AS - A. Saman (Bay 02)</option>
                            <option value="DK - D. Kulatunga">DK - D. Kulatunga (Bay 03)</option>
                            <option value="SN - S. Nisanka">SN - S. Nisanka (Bay 04)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="jobVehicleModel" class="block font-semibold text-slate-700 mb-1">Vehicle Model</label>
                    <input type="text" id="jobVehicleModel" placeholder="e.g. Toyota Aqua / Suzuki WagonR"
                        class="w-full px-3 py-2 border border-slate-200 rounded-md focus:ring-1 focus:ring-[#F05A28] focus:border-[#F05A28] outline-none">
                </div>

                <div>
                    <label for="jobScope" class="block font-semibold text-slate-700 mb-1">Scope of Work & Diagnostics *</label>
                    <textarea id="jobScope" rows="2" required placeholder="e.g. 50,000 km periodic service, front brake disc resurfacing, multi-point electronic scan..."
                        class="w-full px-3 py-2 border border-slate-200 rounded-md focus:ring-1 focus:ring-[#F05A28] focus:border-[#F05A28] outline-none"></textarea>
                </div>

                <!-- Actions -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" onclick="closeNewJobModal()"
                        class="px-4 py-2 rounded-md border border-slate-200 text-slate-600 hover:bg-slate-50 font-medium">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 rounded-md bg-[#F05A28] hover:bg-[#D94819] text-white font-bold shadow-sm transition-colors">
                        Add to Floor Board
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 4. MODAL: JOB CARD QUICK DETAILS & ACTION DRAWER         -->
    <!-- ======================================================== -->
    <div id="jobDetailsModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden" role="dialog" aria-modal="true">
        <div class="bg-white rounded-xl shadow-2xl border border-slate-200 w-full max-w-md overflow-hidden transform transition-all">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div class="flex items-center gap-2">
                    <span id="detailStatusDot" class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                    <h3 id="detailPlate" class="font-mono font-bold text-slate-900 text-sm">WP CBA-1234</h3>
                </div>
                <button type="button" onclick="closeJobDetails()" class="text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6 space-y-3.5 text-xs text-slate-600">
                <div>
                    <span class="block text-[11px] font-semibold text-slate-400 uppercase">Current Stage</span>
                    <span id="detailStage" class="font-bold text-slate-800 text-xs">In Progress</span>
                </div>
                <div>
                    <span class="block text-[11px] font-semibold text-slate-400 uppercase">Assigned Technician</span>
                    <span id="detailTech" class="font-bold text-slate-800 text-xs">D. Kulatunga</span>
                </div>
                <div>
                    <span class="block text-[11px] font-semibold text-slate-400 uppercase">Work Order Tasks</span>
                    <p id="detailScope" class="text-slate-700 bg-slate-50 p-2.5 rounded border border-slate-100 mt-1 leading-relaxed">
                        Full inspection and required services under manufacturer checklist.
                    </p>
                </div>
                <!-- Role Notice: Stage Drag Restricted for Front Desk -->
                <div class="p-3 rounded-lg bg-slate-50 border border-slate-200/80 text-[11px] text-slate-600 flex items-start gap-2.5">
                    <svg class="w-4 h-4 text-slate-500 flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                    <div>
                        <span class="font-bold text-slate-800 block">Stage Progression Restricted</span>
                        Front desk view is read-only. Stage movements (Queue → Bay → QA → Checkout) are managed by the Workshop Floor Lead & Technicians.
                    </div>
                </div>
            </div>
            <div class="p-4 border-t border-slate-100 bg-slate-50/50 text-right">
                <button type="button" onclick="closeJobDetails()" class="px-4 py-1.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-md font-semibold text-xs transition-colors">
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast"
        class="fixed bottom-5 right-5 z-50 bg-[#0F172A] text-white text-xs px-4 py-3 rounded-lg shadow-xl border border-slate-700 flex items-center gap-2.5 transform translate-y-20 opacity-0 transition-all duration-300 pointer-events-none">
        <svg class="w-4 h-4 text-emerald-400 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <polyline points="20 6 9 17 4 12"></polyline>
        </svg>
        <span id="toastMsg">Card moved successfully!</span>
    </div>

    <!-- ======================================================== -->
    <!-- 5. DRAG & DROP JAVASCRIPT ENGINE                         -->
    <!-- ======================================================== -->
    <script>
        // Column status configuration
        const COLUMN_CONFIG = {
            'in-queue': {
                name: 'In Queue',
                badgeText: 'QUEUED',
                badgeClass: 'bg-slate-800 text-slate-100 border border-slate-700',
                dotClass: 'bg-slate-500'
            },
            'in-progress': {
                name: 'In Progress',
                badgeText: 'IN PROGRESS',
                badgeClass: 'bg-blue-600/30 text-blue-200 border border-blue-500/50',
                dotClass: 'bg-blue-500'
            },
            'pending-qa': {
                name: 'Pending QA',
                badgeText: 'PENDING QA',
                badgeClass: 'bg-amber-600/30 text-amber-200 border border-amber-500/50',
                dotClass: 'bg-amber-500'
            },
            'ready': {
                name: 'Ready for Checkout',
                badgeText: 'READY',
                badgeClass: 'bg-emerald-600/30 text-emerald-200 border border-emerald-500/50',
                dotClass: 'bg-emerald-500'
            }
        };

        let draggedCard = null;
        let selectedJobCardId = null;

        // Mobile drawer toggle
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

        // Handle Modal Initial Column Change
        function handleModalColumnChange(col) {
            const techSelect = document.getElementById('jobTech');
            if (col === 'in-queue') {
                techSelect.value = 'none';
            } else if (techSelect.value === 'none') {
                techSelect.value = 'MK - M. Kumara';
            }
        }

        // Drag operation restricted for Front Desk role
        function handleDragStart(e) {
            e.preventDefault();
            showToast('Stage drag restricted: Progression is authorized by Workshop Floor Lead & QA.');
            return false;
        }

        // Update card badge styling and technician visibility
        function updateCardVisuals(card, columnId) {
            const config = COLUMN_CONFIG[columnId];
            if (!config) return;

            const badge = card.querySelector('.card-status-badge');
            if (badge) {
                badge.textContent = config.badgeText;
                badge.className = `card-status-badge px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider ${config.badgeClass}`;
            }

            const techRow = card.querySelector('.card-tech-row');
            if (techRow) {
                if (columnId === 'in-queue') {
                    // Do not show assigned technician for jobs in queue
                    techRow.className = 'card-tech-row pt-1.5 border-t border-slate-100 flex items-center gap-1.5 text-slate-400 text-[11px]';
                    techRow.innerHTML = `
                        <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line>
                        </svg>
                        <span>Not Assigned</span>
                    `;
                } else {
                    // Restore technician name and Technician title above name
                    const assignedTech = card.getAttribute('data-tech') || 'M. Kumara';
                    const initials = card.getAttribute('data-initials') || assignedTech.split(' ').map(n => n[0]).join('').slice(0, 2);
                    techRow.className = 'flex items-center gap-2.5 pt-1.5 border-t border-slate-100 card-tech-row';
                    techRow.innerHTML = `
                        <div class="w-6 h-6 rounded-full bg-slate-100 border border-slate-200 text-slate-700 text-[10px] font-bold flex items-center justify-center flex-shrink-0 card-tech-avatar">
                            ${initials}
                        </div>
                        <div class="flex flex-col min-w-0">
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider leading-none mb-0.5">Technician</span>
                            <span class="truncate text-xs font-semibold text-slate-800 leading-tight card-tech-name">${assignedTech}</span>
                        </div>
                    `;
                }
            }
        }

        // Calculate and update all column count pills and metrics ribbon
        function updateAllCounters() {
            let totalFloor = 0;
            let pendingQaCount = 0;
            let readyCount = 0;

            Object.keys(COLUMN_CONFIG).forEach(colId => {
                const colBody = document.querySelector(`.kanban-column-body[data-column-id="${colId}"]`);
                const countBadge = document.getElementById(`count-${colId}`);
                const count = colBody ? colBody.querySelectorAll('.kanban-card').length : 0;

                if (countBadge) {
                    countBadge.textContent = count;
                }

                totalFloor += count;
                if (colId === 'pending-qa') pendingQaCount = count;
                if (colId === 'ready') readyCount = count;
            });

            // Update ribbon metrics
            document.getElementById('statFloorCount').textContent = totalFloor;
            document.getElementById('statPendingQa').textContent = pendingQaCount;
            document.getElementById('statReadyCount').textContent = readyCount;
        }

        // Search filtering across all cards
        function filterKanbanCards() {
            const query = document.getElementById('kanbanFilterInput').value.toLowerCase().trim();
            const cards = document.querySelectorAll('.kanban-card');

            cards.forEach(card => {
                const text = card.innerText.toLowerCase();
                if (!query || text.includes(query)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Global search header
        function handleGlobalSearch(e) {
            const query = e.target.value;
            const filterInput = document.getElementById('kanbanFilterInput');
            filterInput.value = query;
            filterKanbanCards();
        }

        // Station lock trigger
        function lockStation() {
            if (confirm('Lock Front Desk Intake Station #01 and return to staff login?')) {
                window.location.href = '/login';
            }
        }

        // Modal: New Job Card
        function openNewJobModal() {
            document.getElementById('newJobModal').classList.remove('hidden');
            document.getElementById('jobPlate').focus();
        }

        function closeNewJobModal() {
            document.getElementById('newJobModal').classList.add('hidden');
        }

        // Handle Job Card Creation
        function handleCreateJobCard(e) {
            e.preventDefault();
            const plate = document.getElementById('jobPlate').value.trim();
            const techFull = document.getElementById('jobTech').value;
            const initialCol = document.getElementById('jobInitialColumn').value;
            const scope = document.getElementById('jobScope').value.trim();

            const isQueue = initialCol === 'in-queue' || techFull === 'none';
            const techInitials = isQueue ? '' : techFull.split(' - ')[0];
            const techName = isQueue ? '' : techFull.split(' - ')[1].split(' (')[0];

            const cardId = 'card-' + plate.toLowerCase().replace(/[^a-z0-9]/g, '');
            const config = COLUMN_CONFIG[initialCol];

            const card = document.createElement('div');
            card.id = cardId;
            card.draggable = false;
            if (!isQueue) {
                card.setAttribute('data-tech', techName);
                card.setAttribute('data-initials', techInitials);
            }
            card.className = 'kanban-card bg-white rounded-lg border border-slate-200 p-3 shadow-xs hover:shadow-md transition-all';
            card.onclick = () => openJobDetails(plate, isQueue ? null : techName, scope, initialCol);

            const techHtml = isQueue
                ? `
                <div class="card-tech-row pt-1.5 border-t border-slate-100 flex items-center gap-1.5 text-slate-400 text-[11px]">
                    <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line>
                    </svg>
                    <span>Not Assigned</span>
                </div>`
                : `
                <div class="flex items-center gap-2.5 pt-1.5 border-t border-slate-100 card-tech-row">
                    <div class="w-6 h-6 rounded-full bg-slate-100 border border-slate-200 text-slate-700 text-[10px] font-bold flex items-center justify-center flex-shrink-0 card-tech-avatar">
                        ${techInitials}
                    </div>
                    <div class="flex flex-col min-w-0">
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider leading-none mb-0.5">Technician</span>
                        <span class="truncate text-xs font-semibold text-slate-800 leading-tight card-tech-name">${techName}</span>
                    </div>
                </div>`;

            card.innerHTML = `
                <div class="bg-[#0F172A] text-white p-2.5 rounded-md flex items-center justify-between gap-2 mb-2.5 card-header-bar">
                    <div class="font-mono font-bold text-white text-xs sm:text-sm tracking-tight card-plate">${plate}</div>
                    <span class="card-status-badge px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider ${config.badgeClass}">
                        ${config.badgeText}
                    </span>
                </div>
                ${techHtml}
            `;

            const targetCol = document.querySelector(`.kanban-column-body[data-column-id="${initialCol}"]`);
            if (targetCol) {
                targetCol.prepend(card);
            }

            closeNewJobModal();
            e.target.reset();
            updateAllCounters();
            showToast(`Created Job Card for ${plate} in ${config.name}`);
        }

        // Job Details Drawer / Modal
        function openJobDetails(plate, tech, scope, colId) {
            selectedJobCardId = plate;
            const modal = document.getElementById('jobDetailsModal');
            document.getElementById('detailPlate').textContent = plate;
            document.getElementById('detailScope').textContent = scope || 'Standard workshop maintenance procedure.';
            
            // Find current column of the card
            let currentColumn = colId;
            const allCards = document.querySelectorAll('.kanban-card');
            allCards.forEach(c => {
                if (c.querySelector('.card-plate')?.textContent === plate) {
                    currentColumn = c.closest('.kanban-column-body')?.getAttribute('data-column-id') || colId;
                }
            });

            document.getElementById('detailStage').textContent = COLUMN_CONFIG[currentColumn]?.name || currentColumn;
            const dot = document.getElementById('detailStatusDot');
            dot.className = `w-2.5 h-2.5 rounded-full ${COLUMN_CONFIG[currentColumn]?.dotClass || 'bg-slate-400'}`;

            // Do not show an assigned technician for jobs in queue
            const techEl = document.getElementById('detailTech');
            if (currentColumn === 'in-queue' || !tech || tech === 'none') {
                techEl.innerHTML = '<span class="text-slate-400 font-semibold italic">Not Assigned</span>';
            } else {
                techEl.textContent = tech;
            }

            modal.classList.remove('hidden');
        }

        function closeJobDetails() {
            document.getElementById('jobDetailsModal').classList.add('hidden');
        }

        // Toast feedback
        function showToast(msg) {
            const toast = document.getElementById('toast');
            const toastMsg = document.getElementById('toastMsg');
            toastMsg.textContent = msg;
            toast.classList.remove('translate-y-20', 'opacity-0');
            setTimeout(() => {
                toast.classList.add('translate-y-20', 'opacity-0');
            }, 3500);
        }

        // Keyboard escape handler
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeNewJobModal();
                closeJobDetails();
                toggleMobileSidebar(false);
            }
        });

        // Initialize counters on load
        document.addEventListener('DOMContentLoaded', () => {
            updateAllCounters();
        });
    </script>
</body>

</html>
