<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Supervisor Operations - VWMS OS</title>
    <meta name="description"
        content="VWMS Supervisor Operations - Oversee active jobs, assign technicians to queued vehicles, inspect QA completions, and view job history.">

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

        /* Drag and Drop Visual Styles */
        .kanban-card {
            cursor: grab;
            transition: transform 0.15s ease, box-shadow 0.15s ease, opacity 0.15s ease;
            user-select: none;
        }

        .kanban-card:active {
            cursor: grabbing;
        }

        .kanban-card.is-dragging {
            opacity: 0.45;
            transform: scale(0.98);
        }

        .kanban-card.locked-card {
            cursor: pointer;
        }

        .kanban-column-body.drag-over {
            background-color: rgba(240, 90, 40, 0.06);
            border: 2px dashed #F05A28 !important;
            border-radius: 12px;
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
        <!-- 1. LEFT SIDEBAR: DARK SUPERVISOR NAVIGATION             -->
        <!-- ======================================================== -->
        <aside id="sidebar"
            class="fixed top-0 bottom-0 left-0 w-64 bg-[#0F172A] text-white z-50 flex flex-col justify-between transition-transform duration-300 -translate-x-full lg:translate-x-0 lg:static lg:z-auto border-r border-slate-800 flex-shrink-0">

            <!-- Top Container: Logo + Menu Items -->
            <div class="flex flex-col">
                <!-- Top Brand: VWMS OS -->
                <div class="px-5 py-5 border-b border-slate-800/80 flex items-center justify-between">
                    <a href="/supervisor/dashboard" class="flex items-center gap-2.5 group">
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
                        <div class="flex flex-col">
                            <div class="flex items-center text-lg font-bold tracking-tight leading-none">
                                <span class="text-white">VWMS</span>
                                <span class="text-[#F05A28] ml-1.5 font-extrabold">OS</span>
                            </div>
                            <span
                                class="text-[9px] font-semibold text-slate-400 uppercase tracking-widest mt-1">SUPERVISOR
                                OPERATIONS</span>
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
                <nav class="px-3 py-5 space-y-1.5" aria-label="Supervisor Navigation">
                    <div class="px-3 pb-2 text-[10px] font-bold text-slate-400 tracking-widest uppercase">
                        OPERATIONS
                    </div>

                    <!-- 1. Active Jobs (Default/Active View - Same as Front Desk Active Jobs) -->
                    <button type="button" onclick="switchSupervisorView('active-jobs')" id="navActiveJobsBtn"
                        class="nav-item-active w-full flex items-center justify-between px-3.5 py-2.5 rounded-lg font-semibold text-sm transition-all duration-150 shadow-sm text-left">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z">
                                </path>
                            </svg>
                            <span>Active Jobs</span>
                        </div>
                        <span id="navBoardCountBadge"
                            class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-black/25 text-white">8</span>
                    </button>

                    <!-- 2. Assign Work (Queued Vehicles Checked-in by Front Desk) -->
                    <button type="button" onclick="switchSupervisorView('assign-work')" id="navAssignWorkBtn"
                        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-lg text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 font-medium text-sm transition-colors duration-150 text-left">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <polyline points="16 11 18 13 22 9"></polyline>
                            </svg>
                            <span>Assign Work</span>
                        </div>
                        <span id="navQueueCountBadge"
                            class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-amber-500/20 text-amber-300 border border-amber-500/30">2</span>
                    </button>

                    <!-- 3. Technicians Roster View -->
                    <button type="button" onclick="switchSupervisorView('technicians')" id="navTechniciansBtn"
                        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-lg text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 font-medium text-sm transition-colors duration-150 text-left">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <span>Technicians</span>
                        </div>
                        <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-slate-800 text-slate-400">5</span>
                    </button>

                    <!-- 4. Job History Archive View (All Recorded Vehicles) -->
                    <button type="button" onclick="switchSupervisorView('job-history')" id="navJobHistoryBtn"
                        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-lg text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 font-medium text-sm transition-colors duration-150 text-left">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Job History</span>
                        </div>
                        <span
                            class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-slate-800 text-slate-400">Archive</span>
                    </button>
                </nav>
            </div>

            <!-- Bottom Section: Supervisor Profile Card -->
            <div class="p-3 border-t border-slate-800">
                <div
                    class="border border-dashed border-slate-700/80 rounded-lg p-2.5 flex items-center justify-between bg-slate-900/40">
                    <div class="flex items-center gap-2.5">
                        <!-- Avatar AM with live green status dot -->
                        <div class="relative flex-shrink-0">
                            <div
                                class="w-8 h-8 rounded-full bg-[#F05A28] text-white flex items-center justify-center text-xs font-bold shadow-sm">
                                AM
                            </div>
                            <span
                                class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-[#0F172A] rounded-full"></span>
                        </div>
                        <!-- User Details -->
                        <div class="flex flex-col min-w-0">
                            <span class="text-xs font-bold text-white truncate leading-tight">Asanka Mendis</span>
                            <span class="text-[11px] text-slate-400 truncate leading-tight mt-0.5">Supervisor</span>
                        </div>
                    </div>

                    <!-- Logout / Workstation Lock Action -->
                    <button type="button" onclick="logoutSupervisor()"
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
                        <span id="topBreadcrumbText" class="font-semibold text-slate-700">Active Jobs</span>
                    </div>
                </div>

                <!-- Right Utilities -->
                <div class="flex items-center gap-3 sm:gap-4">
                    <!-- Notification Bell -->
                    <button type="button"
                        onclick="showToast('QA Inspection Alert: 1 vehicle ready for supervisor review')"
                        class="w-8 h-8 rounded-full border border-slate-200 bg-white flex items-center justify-center text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors relative"
                        aria-label="Notifications">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                        <span
                            class="absolute -top-1 -right-1 w-4 h-4 bg-[#F05A28] text-white text-[10px] font-bold rounded-full flex items-center justify-center leading-none shadow-sm">
                            2
                        </span>
                    </button>

                    <!-- User Identity Badge: Status dot + Name + Supervisor label -->
                    <div
                        class="hidden sm:inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200 shadow-2xs">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span class="font-bold text-slate-800">Asanka Mendis</span>
                        <span class="text-slate-400">•</span>
                        <span class="text-[#F05A28] font-bold">Supervisor</span>
                    </div>

                    <!-- Profile Circle -->
                    <button type="button" onclick="showToast('Logged in as Supervisor: Asanka Mendis')"
                        class="w-8 h-8 rounded-full bg-[#F05A28] text-white flex items-center justify-center text-xs font-bold ring-2 ring-white shadow-sm hover:opacity-95 transition-opacity"
                        aria-label="Supervisor Account">
                        AM
                    </button>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-[1680px] w-full mx-auto space-y-6">

                <!-- ==================================================== -->
                <!-- VIEW 1: ACTIVE JOBS (SAME AS FRONT DESK ACTIVE JOBS) -->
                <!-- ==================================================== -->
                <div id="viewActiveJobs" class="space-y-6">

                    <!-- Page Headline & Action Toolbar -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="flex flex-wrap items-center gap-3">
                            <h1 class="text-2xl font-extrabold text-[#0F172A] tracking-tight">Active Jobs</h1>
                            <span
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200 shadow-2xs">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                Supervisor View • Full Workshop Progress
                            </span>
                        </div>

                        <div class="flex items-center gap-2.5">
                            <!-- Local Kanban Search Filter -->
                            <div class="relative w-60 sm:w-64">
                                <span
                                    class="absolute inset-y-0 left-0 flex items-center pl-2.5 pointer-events-none text-slate-400">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <path d="m21 21-4.35-4.35"></path>
                                    </svg>
                                </span>
                                <input type="text" id="kanbanFilterInput" oninput="filterKanbanCards()"
                                    placeholder="Search job or plate..."
                                    class="w-full pl-8 pr-3 py-1.5 text-xs bg-white border border-slate-200 rounded-md focus:outline-none focus:ring-1 focus:ring-[#F05A28] focus:border-[#F05A28] text-slate-700 placeholder:text-slate-400">
                            </div>

                            <!-- CTA Button: Quick Assign Work -->
                            <button type="button" onclick="switchSupervisorView('assign-work')"
                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-md bg-[#F05A28] hover:bg-[#D94819] text-white text-xs font-semibold shadow-sm transition-colors duration-150 whitespace-nowrap">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <polyline points="16 11 18 13 22 9"></polyline>
                                </svg>
                                <span>Assign Queue Work</span>
                            </button>
                        </div>
                    </div>

                    <!-- METRICS RIBBON BAR (MATCHING ACTIVE JOBS) -->
                    <div
                        class="bg-white rounded-xl border border-slate-200/90 shadow-sm p-4 grid grid-cols-2 md:grid-cols-4 divide-y md:divide-y-0 md:divide-x divide-slate-100 gap-3 md:gap-0">
                        <!-- Metric 1: Vehicles On Floor -->
                        <div class="px-3 sm:px-5 py-1 flex items-center justify-between">
                            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">VEHICLES ON
                                FLOOR</span>
                            <span id="statFloorCount" class="text-base font-extrabold text-[#0F172A]">8</span>
                        </div>

                        <!-- Metric 2: Technicians Active -->
                        <div class="px-3 sm:px-5 py-1 flex items-center justify-between pt-2.5 md:pt-0">
                            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">TECHNICIANS
                                ACTIVE</span>
                            <span class="text-base font-extrabold text-[#0F172A]">5 / 6</span>
                        </div>

                        <!-- Metric 3: Pending QA -->
                        <div class="px-3 sm:px-5 py-1 flex items-center justify-between pt-2.5 md:pt-0">
                            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">PENDING
                                QA</span>
                            <span id="statPendingQa" class="text-base font-extrabold text-[#0F172A]">1</span>
                        </div>

                        <!-- Metric 4: Ready for Handover -->
                        <div class="px-3 sm:px-5 py-1 flex items-center justify-between pt-2.5 md:pt-0">
                            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">READY FOR
                                HANDOVER</span>
                            <span id="statReadyCount" class="text-base font-extrabold text-[#0F172A]">2</span>
                        </div>
                    </div>

                    <!-- KANBAN BOARD: 4 STAGES (IN QUEUE, IN PROGRESS, PENDING QA, READY FOR HANDOVER) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 items-start" id="kanbanBoard">

                        <!-- ================================================ -->
                        <!-- COLUMN 1: IN QUEUE                               -->
                        <!-- ================================================ -->
                        <div
                            class="bg-slate-50/80 rounded-xl border border-slate-200/80 p-3 flex flex-col min-h-[560px]">
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
                            <div class="kanban-column-body flex-1 space-y-2.5 p-1 rounded-lg transition-colors"
                                data-column-id="in-queue" ondragover="handleDragOver(event)"
                                ondragleave="handleDragLeave(event)" ondrop="handleDrop(event, 'in-queue')">

                                <!-- CARD 1: CBA-1234 -->
                                <div id="card-cba1234" draggable="true" ondragstart="handleDragStart(event)"
                                    ondragend="handleDragEnd(event)" data-job-id="CB-1048" data-plate="WP CBA-1234"
                                    data-vehicle="Honda Vezel RU1" data-service="Brake pad replacement & disc skimming"
                                    data-customer="Kamal Perera"
                                    onclick="openJobDetails('WP CBA-1234', null, 'Brake pad replacement & disc skimming', 'in-queue', 'CB-1048')"
                                    class="kanban-card bg-white rounded-lg border border-slate-200 p-3 shadow-xs hover:shadow-md transition-all">
                                    <!-- Dark Header Bar with Plate & Status -->
                                    <div
                                        class="bg-[#0F172A] text-white p-2.5 rounded-md flex items-center justify-between gap-2 mb-2.5 card-header-bar">
                                        <div
                                            class="font-mono font-bold text-white text-xs sm:text-sm tracking-tight card-plate">
                                            WP CBA-1234</div>
                                        <span
                                            class="card-status-badge px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-slate-800 text-slate-100 border border-slate-700">
                                            QUEUED
                                        </span>
                                    </div>
                                    <p class="text-xs font-semibold text-slate-900 mb-1">Honda Vezel RU1</p>
                                    <p class="text-[11px] text-slate-600 line-clamp-2 mb-2">Brake pad replacement & disc
                                        skimming</p>
                                    <!-- Technician Info: Not Assigned for Jobs in Queue -->
                                    <div
                                        class="card-tech-row pt-1.5 border-t border-slate-100 flex items-center justify-between text-slate-400 text-[11px]">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line>
                                            </svg>
                                            <span>Not Assigned</span>
                                        </div>
                                        <button type="button"
                                            onclick="event.stopPropagation(); openAssignModal('CB-1048', 'WP CBA-1234', 'Honda Vezel RU1', 'Brake pad replacement & disc skimming', 'Kamal Perera')"
                                            class="text-[10px] font-bold text-[#F05A28] hover:underline">
                                            Assign →
                                        </button>
                                    </div>
                                </div>

                                <!-- CARD 2: CAB-7892 -->
                                <div id="card-cab7892" draggable="true" ondragstart="handleDragStart(event)"
                                    ondragend="handleDragEnd(event)" data-job-id="CB-1049" data-plate="WP CAB-7892"
                                    data-vehicle="Toyota Land Cruiser Prado"
                                    data-service="40k Major Service & Engine Diagnostics"
                                    data-customer="Dilani Wickramasinghe"
                                    onclick="openJobDetails('WP CAB-7892', null, '40k Major Service & Engine Diagnostics', 'in-queue', 'CB-1049')"
                                    class="kanban-card bg-white rounded-lg border border-slate-200 p-3 shadow-xs hover:shadow-md transition-all">
                                    <div
                                        class="bg-[#0F172A] text-white p-2.5 rounded-md flex items-center justify-between gap-2 mb-2.5 card-header-bar">
                                        <div
                                            class="font-mono font-bold text-white text-xs sm:text-sm tracking-tight card-plate">
                                            WP CAB-7892</div>
                                        <span
                                            class="card-status-badge px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-slate-800 text-slate-100 border border-slate-700">
                                            QUEUED
                                        </span>
                                    </div>
                                    <p class="text-xs font-semibold text-slate-900 mb-1">Toyota Land Cruiser Prado</p>
                                    <p class="text-[11px] text-slate-600 line-clamp-2 mb-2">40k Major Service & Engine
                                        Diagnostics</p>
                                    <div
                                        class="card-tech-row pt-1.5 border-t border-slate-100 flex items-center justify-between text-slate-400 text-[11px]">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line>
                                            </svg>
                                            <span>Not Assigned</span>
                                        </div>
                                        <button type="button"
                                            onclick="event.stopPropagation(); openAssignModal('CB-1049', 'WP CAB-7892', 'Toyota Land Cruiser Prado', '40k Major Service & Engine Diagnostics', 'Dilani Wickramasinghe')"
                                            class="text-[10px] font-bold text-[#F05A28] hover:underline">
                                            Assign →
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- ================================================ -->
                        <!-- COLUMN 2: IN PROGRESS                            -->
                        <!-- ================================================ -->
                        <div
                            class="bg-slate-50/80 rounded-xl border border-slate-200/80 p-3 flex flex-col min-h-[560px]">
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
                            <div class="kanban-column-body flex-1 space-y-2.5 p-1 rounded-lg transition-colors"
                                data-column-id="in-progress" ondragover="handleDragOver(event)"
                                ondragleave="handleDragLeave(event)" ondrop="handleDrop(event, 'in-progress')">

                                <!-- CARD 3: NW WP-9871 -->
                                <div id="card-wp9870" draggable="true" ondragstart="handleDragStart(event)"
                                    ondragend="handleDragEnd(event)" data-job-id="CB-1045" data-plate="NW WP-9871"
                                    data-vehicle="Nissan X-Trail T32"
                                    data-service="Transmission Flush & Gearbox Diagnostics" data-tech="M. Kumara"
                                    data-initials="MK"
                                    onclick="openJobDetails('NW WP-9871', 'M. Kumara', 'Transmission Flush & Gearbox Diagnostics', 'in-progress', 'CB-1045')"
                                    class="kanban-card bg-white rounded-lg border border-slate-200 p-3 shadow-xs hover:shadow-md transition-all">
                                    <div
                                        class="bg-[#0F172A] text-white p-2.5 rounded-md flex items-center justify-between gap-2 mb-2.5 card-header-bar">
                                        <div
                                            class="font-mono font-bold text-white text-xs sm:text-sm tracking-tight card-plate">
                                            NW WP-9871</div>
                                        <span
                                            class="card-status-badge px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-blue-600/30 text-blue-200 border border-blue-500/50">
                                            IN PROGRESS
                                        </span>
                                    </div>
                                    <p class="text-xs font-semibold text-slate-900 mb-1">Nissan X-Trail T32</p>
                                    <p class="text-[11px] text-slate-600 line-clamp-2 mb-2">Transmission Flush & Gearbox
                                        Diagnostics</p>
                                    <div
                                        class="flex items-center gap-2.5 pt-1.5 border-t border-slate-100 card-tech-row">
                                        <div
                                            class="w-6 h-6 rounded-full bg-slate-100 border border-slate-200 text-slate-700 text-[10px] font-bold flex items-center justify-center flex-shrink-0 card-tech-avatar">
                                            MK
                                        </div>
                                        <div class="flex flex-col min-w-0">
                                            <span
                                                class="text-[9px] font-bold text-slate-400 uppercase tracking-wider leading-none mb-0.5">Technician</span>
                                            <span
                                                class="truncate text-xs font-semibold text-slate-800 leading-tight card-tech-name">M.
                                                Kumara</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- CARD 4: WP CAD-5521 -->
                                <div id="card-cad5521" draggable="true" ondragstart="handleDragStart(event)"
                                    ondragend="handleDragEnd(event)" data-job-id="CB-1046" data-plate="WP CAD-5521"
                                    data-vehicle="Toyota Aqua Hybrid"
                                    data-service="Suspension Overhaul & Bushing Replacement" data-tech="A. Saman"
                                    data-initials="AS"
                                    onclick="openJobDetails('WP CAD-5521', 'A. Saman', 'Suspension Overhaul & Bushing Replacement', 'in-progress', 'CB-1046')"
                                    class="kanban-card bg-white rounded-lg border border-slate-200 p-3 shadow-xs hover:shadow-md transition-all">
                                    <div
                                        class="bg-[#0F172A] text-white p-2.5 rounded-md flex items-center justify-between gap-2 mb-2.5 card-header-bar">
                                        <div
                                            class="font-mono font-bold text-white text-xs sm:text-sm tracking-tight card-plate">
                                            WP CAD-5521</div>
                                        <span
                                            class="card-status-badge px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-blue-600/30 text-blue-200 border border-blue-500/50">
                                            IN PROGRESS
                                        </span>
                                    </div>
                                    <p class="text-xs font-semibold text-slate-900 mb-1">Toyota Aqua Hybrid</p>
                                    <p class="text-[11px] text-slate-600 line-clamp-2 mb-2">Suspension Overhaul &
                                        Bushing Replacement</p>
                                    <div
                                        class="flex items-center gap-2.5 pt-1.5 border-t border-slate-100 card-tech-row">
                                        <div
                                            class="w-6 h-6 rounded-full bg-slate-100 border border-slate-200 text-slate-700 text-[10px] font-bold flex items-center justify-center flex-shrink-0 card-tech-avatar">
                                            AS
                                        </div>
                                        <div class="flex flex-col min-w-0">
                                            <span
                                                class="text-[9px] font-bold text-slate-400 uppercase tracking-wider leading-none mb-0.5">Technician</span>
                                            <span
                                                class="truncate text-xs font-semibold text-slate-800 leading-tight card-tech-name">A.
                                                Saman</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- CARD 5: CP CAA-8040 -->
                                <div id="card-caa8040" draggable="true" ondragstart="handleDragStart(event)"
                                    ondragend="handleDragEnd(event)" data-job-id="CB-1047" data-plate="CP CAA-8040"
                                    data-vehicle="Honda Civic Turbo" data-service="Radiator & Coolant System Overhaul"
                                    data-tech="D. Kulatunga" data-initials="DK"
                                    onclick="openJobDetails('CP CAA-8040', 'D. Kulatunga', 'Radiator & Coolant System Overhaul', 'in-progress', 'CB-1047')"
                                    class="kanban-card bg-white rounded-lg border border-slate-200 p-3 shadow-xs hover:shadow-md transition-all">
                                    <div
                                        class="bg-[#0F172A] text-white p-2.5 rounded-md flex items-center justify-between gap-2 mb-2.5 card-header-bar">
                                        <div
                                            class="font-mono font-bold text-white text-xs sm:text-sm tracking-tight card-plate">
                                            CP CAA-8040</div>
                                        <span
                                            class="card-status-badge px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-blue-600/30 text-blue-200 border border-blue-500/50">
                                            IN PROGRESS
                                        </span>
                                    </div>
                                    <p class="text-xs font-semibold text-slate-900 mb-1">Honda Civic Turbo</p>
                                    <p class="text-[11px] text-slate-600 line-clamp-2 mb-2">Radiator & Coolant System
                                        Overhaul</p>
                                    <div
                                        class="flex items-center gap-2.5 pt-1.5 border-t border-slate-100 card-tech-row">
                                        <div
                                            class="w-6 h-6 rounded-full bg-slate-100 border border-slate-200 text-slate-700 text-[10px] font-bold flex items-center justify-center flex-shrink-0 card-tech-avatar">
                                            DK
                                        </div>
                                        <div class="flex flex-col min-w-0">
                                            <span
                                                class="text-[9px] font-bold text-slate-400 uppercase tracking-wider leading-none mb-0.5">Technician</span>
                                            <span
                                                class="truncate text-xs font-semibold text-slate-800 leading-tight card-tech-name">D.
                                                Kulatunga</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- ================================================ -->
                        <!-- COLUMN 3: PENDING QA                             -->
                        <!-- ================================================ -->
                        <div
                            class="bg-slate-50/80 rounded-xl border border-slate-200/80 p-3 flex flex-col min-h-[560px]">
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
                            <div class="kanban-column-body flex-1 space-y-2.5 p-1 rounded-lg transition-colors"
                                data-column-id="pending-qa" ondragover="handleDragOver(event)"
                                ondragleave="handleDragLeave(event)" ondrop="handleDrop(event, 'pending-qa')">

                                <!-- CARD 6: SP BC-4912 -->
                                <div id="card-bc4912" draggable="true" ondragstart="handleDragStart(event)"
                                    ondragend="handleDragEnd(event)" data-job-id="CB-1042" data-plate="SP BC-4912"
                                    data-vehicle="Kia Sportage GT"
                                    data-service="Suspension Arm Bushing & Steering Alignment" data-tech="S. Nisanka"
                                    data-initials="SN"
                                    onclick="openJobDetails('SP BC-4912', 'S. Nisanka', 'Suspension Arm Bushing & Steering Alignment', 'pending-qa', 'CB-1042')"
                                    class="kanban-card bg-white rounded-lg border border-slate-200 p-3 shadow-xs hover:shadow-md transition-all">
                                    <div
                                        class="bg-[#0F172A] text-white p-2.5 rounded-md flex items-center justify-between gap-2 mb-2.5 card-header-bar">
                                        <div
                                            class="font-mono font-bold text-white text-xs sm:text-sm tracking-tight card-plate">
                                            SP BC-4912</div>
                                        <span
                                            class="card-status-badge px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-amber-600/30 text-amber-200 border border-amber-500/50">
                                            PENDING QA
                                        </span>
                                    </div>
                                    <p class="text-xs font-semibold text-slate-900 mb-1">Kia Sportage GT</p>
                                    <p class="text-[11px] text-slate-600 line-clamp-2 mb-2">Suspension Arm Bushing &
                                        Steering Alignment</p>
                                    <div
                                        class="flex items-center justify-between pt-1.5 border-t border-slate-100 card-tech-row">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-6 h-6 rounded-full bg-slate-100 border border-slate-200 text-slate-700 text-[10px] font-bold flex items-center justify-center flex-shrink-0 card-tech-avatar">
                                                SN
                                            </div>
                                            <span
                                                class="truncate text-xs font-semibold text-slate-800 card-tech-name">S.
                                                Nisanka</span>
                                        </div>
                                        <button type="button"
                                            onclick="event.stopPropagation(); approveJobToHandover('card-bc4912')"
                                            class="text-[10px] font-bold text-emerald-600 hover:text-emerald-700 hover:underline">
                                            Pass QA ✓
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- ================================================ -->
                        <!-- COLUMN 4: READY FOR HANDOVER                     -->
                        <!-- ================================================ -->
                        <div
                            class="bg-slate-50/80 rounded-xl border border-slate-200/80 p-3 flex flex-col min-h-[560px]">
                            <!-- Column Header -->
                            <div class="flex items-center justify-between px-1.5 py-1.5 mb-2.5">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                                    <h3 class="font-bold text-slate-800 text-xs sm:text-sm">Ready for Handover</h3>
                                </div>
                                <span id="count-ready"
                                    class="w-5 h-5 rounded-full bg-white border border-slate-200 text-slate-700 text-[11px] font-bold flex items-center justify-center shadow-xs">
                                    2
                                </span>
                            </div>

                            <!-- Column Body -->
                            <div class="kanban-column-body flex-1 space-y-2.5 p-1 rounded-lg transition-colors"
                                data-column-id="ready" ondragover="handleDragOver(event)"
                                ondragleave="handleDragLeave(event)" ondrop="handleDrop(event, 'ready')">

                                <!-- CARD 7: WP CAX-1029 -->
                                <div id="card-cax1029" draggable="false" data-job-id="CB-1038" data-plate="WP CAX-1029"
                                    data-vehicle="Toyota Prius ZVW50" data-service="Hybrid Battery Cell Balance"
                                    data-tech="N. Pradeep" data-initials="NP"
                                    onclick="openJobDetails('WP CAX-1029', 'N. Pradeep', 'Hybrid Battery Cell Balance', 'ready', 'CB-1038')"
                                    class="kanban-card locked-card bg-white rounded-lg border border-slate-200 p-3 shadow-xs hover:shadow-md transition-all">
                                    <div
                                        class="bg-[#0F172A] text-white p-2.5 rounded-md flex items-center justify-between gap-2 mb-2.5 card-header-bar">
                                        <div
                                            class="font-mono font-bold text-white text-xs sm:text-sm tracking-tight card-plate">
                                            WP CAX-1029</div>
                                        <span
                                            class="card-status-badge px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-emerald-600/30 text-emerald-200 border border-emerald-500/50">
                                            READY
                                        </span>
                                    </div>
                                    <p class="text-xs font-semibold text-slate-900 mb-1">Toyota Prius ZVW50</p>
                                    <p class="text-[11px] text-slate-600 line-clamp-2 mb-2">Hybrid Battery Cell Balance
                                    </p>
                                    <div
                                        class="flex items-center justify-between pt-1.5 border-t border-slate-100 card-tech-row">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-6 h-6 rounded-full bg-slate-100 border border-slate-200 text-slate-700 text-[10px] font-bold flex items-center justify-center flex-shrink-0 card-tech-avatar">
                                                NP
                                            </div>
                                            <span
                                                class="truncate text-xs font-semibold text-slate-800 card-tech-name">N.
                                                Pradeep</span>
                                        </div>
                                        <span class="text-[10px] font-bold text-emerald-700 flex items-center gap-0.5">
                                            QA Passed ✓
                                        </span>
                                    </div>
                                </div>

                                <!-- CARD 8: WP CBJ-5049 -->
                                <div id="card-cbj5049" draggable="false" data-job-id="CB-1039" data-plate="WP CBJ-5049"
                                    data-vehicle="Toyota Prado TX-L"
                                    data-service="Front brake disc resurfacing & ceramic pad replacement"
                                    data-tech="Dishan K." data-initials="DK"
                                    onclick="openJobDetails('WP CBJ-5049', 'Dishan K.', 'Front brake disc resurfacing & ceramic pad replacement', 'ready', 'CB-1039')"
                                    class="kanban-card locked-card bg-white rounded-lg border border-slate-200 p-3 shadow-xs hover:shadow-md transition-all">
                                    <div
                                        class="bg-[#0F172A] text-white p-2.5 rounded-md flex items-center justify-between gap-2 mb-2.5 card-header-bar">
                                        <div
                                            class="font-mono font-bold text-white text-xs sm:text-sm tracking-tight card-plate">
                                            WP CBJ-5049</div>
                                        <span
                                            class="card-status-badge px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-emerald-600/30 text-emerald-200 border border-emerald-500/50">
                                            READY
                                        </span>
                                    </div>
                                    <p class="text-xs font-semibold text-slate-900 mb-1">Toyota Prado TX-L</p>
                                    <p class="text-[11px] text-slate-600 line-clamp-2 mb-2">Front brake disc resurfacing
                                        & ceramic pad replacement</p>
                                    <div
                                        class="flex items-center justify-between pt-1.5 border-t border-slate-100 card-tech-row">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-6 h-6 rounded-full bg-slate-100 border border-slate-200 text-slate-700 text-[10px] font-bold flex items-center justify-center flex-shrink-0 card-tech-avatar">
                                                DK
                                            </div>
                                            <span
                                                class="truncate text-xs font-semibold text-slate-800 card-tech-name">Dishan
                                                K.</span>
                                        </div>
                                        <span class="text-[10px] font-bold text-emerald-700 flex items-center gap-0.5">
                                            QA Passed ✓
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>

                <!-- ==================================================== -->
                <!-- VIEW 2: ASSIGN WORK (SUPERVISOR DISPATCH WORKFLOW)   -->
                <!-- ==================================================== -->
                <div id="viewAssignWork" class="hidden space-y-6">

                    <!-- Section Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <div class="flex items-center gap-2.5">
                                <h1 class="text-2xl font-extrabold text-[#0F172A] tracking-tight">Assign Work</h1>
                                <span
                                    class="px-2.5 py-0.5 text-xs font-bold rounded-full bg-orange-100 text-[#F05A28] border border-orange-200"
                                    id="queueHeaderBadge">
                                    2 In Queue
                                </span>
                            </div>
                            <p class="text-xs text-slate-500 mt-1">
                                Front desk checks in vehicles and they move to queue. As supervisor, assign qualified
                                technicians to dispatch work.
                            </p>
                        </div>

                        <div class="flex items-center gap-2">
                            <button type="button" onclick="switchSupervisorView('active-jobs')"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                                ← View Active Jobs Board
                            </button>
                        </div>
                    </div>

                    <!-- Dispatch Status Banner -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div
                            class="bg-white rounded-xl border border-slate-200 p-4 flex items-center gap-3.5 shadow-2xs">
                            <div
                                class="w-10 h-10 rounded-xl bg-orange-100 text-[#F05A28] flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <polyline points="16 11 18 13 22 9"></polyline>
                                </svg>
                            </div>
                            <div>
                                <span
                                    class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Checked-In
                                    Queue</span>
                                <span class="text-lg font-extrabold text-slate-900" id="statQueueCount">2
                                    Vehicles</span>
                            </div>
                        </div>

                        <div
                            class="bg-white rounded-xl border border-slate-200 p-4 flex items-center gap-3.5 shadow-2xs">
                            <div
                                class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                            </div>
                            <div>
                                <span
                                    class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Technicians
                                    Ready</span>
                                <span class="text-lg font-extrabold text-slate-900">1 Available</span>
                            </div>
                        </div>

                        <div
                            class="bg-white rounded-xl border border-slate-200 p-4 flex items-center gap-3.5 shadow-2xs">
                            <div
                                class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Target
                                    Dispatch SLA</span>
                                <span class="text-lg font-extrabold text-slate-900">&lt; 15 Mins</span>
                            </div>
                        </div>
                    </div>

                    <!-- Main Split: Queued Work Cards & Technician Status Side-by-Side -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

                        <!-- Left: Vehicles Waiting in Queue (2 Cols on lg) -->
                        <div class="lg:col-span-2 space-y-4">
                            <div class="flex items-center justify-between">
                                <h3
                                    class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                    Vehicles in Queue Awaiting Technician
                                </h3>
                                <span class="text-xs text-slate-500">Ranked by Arrival Time</span>
                            </div>

                            <div class="space-y-3.5" id="assignQueueList">

                                <!-- QUEUE ITEM 1 -->
                                <div id="queue-cba1234"
                                    class="bg-white rounded-2xl border border-slate-200 p-5 shadow-2xs hover:shadow-md transition-all space-y-3.5">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2.5">
                                        <div class="flex items-center gap-3">
                                            <div class="sl-plate-badge">
                                                <span class="province">WP</span>CBA-1234
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-slate-900 text-sm">Honda Vezel RU1</h4>
                                                <p class="text-[11px] text-slate-400">Customer: Kamal Perera • +94 77
                                                    123 4567</p>
                                            </div>
                                        </div>
                                        <span
                                            class="self-start sm:self-auto px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                            Checked In: 08:30 AM
                                        </span>
                                    </div>

                                    <!-- Service Description -->
                                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                                        <span
                                            class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-0.5">Required
                                            Service / Complaints</span>
                                        <p class="font-medium text-slate-800">Brake pad replacement & disc skimming
                                            (Customer reported vibration at 60km/h)</p>
                                    </div>

                                    <!-- Actions & Status -->
                                    <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                                        <div class="flex items-center gap-1.5 text-xs text-slate-500">
                                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                            <span>In Queue • Unassigned</span>
                                        </div>
                                        <button type="button"
                                            onclick="openAssignModal('CB-1048', 'WP CBA-1234', 'Honda Vezel RU1', 'Brake pad replacement & disc skimming', 'Kamal Perera')"
                                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-[#F05A28] hover:bg-[#D94819] text-white text-xs font-bold shadow-sm transition-all">
                                            <span>Assign Technician</span>
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2.5">
                                                <polyline points="9 18 15 12 9 6"></polyline>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- QUEUE ITEM 2 -->
                                <div id="queue-cab7892"
                                    class="bg-white rounded-2xl border border-slate-200 p-5 shadow-2xs hover:shadow-md transition-all space-y-3.5">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2.5">
                                        <div class="flex items-center gap-3">
                                            <div class="sl-plate-badge">
                                                <span class="province">WP</span>CAB-7892
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-slate-900 text-sm">Toyota Land Cruiser Prado
                                                </h4>
                                                <p class="text-[11px] text-slate-400">Customer: Dilani Wickramasinghe •
                                                    Fleet Client</p>
                                            </div>
                                        </div>
                                        <span
                                            class="self-start sm:self-auto px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                            Checked In: 09:00 AM
                                        </span>
                                    </div>

                                    <!-- Service Description -->
                                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                                        <span
                                            class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-0.5">Required
                                            Service / Complaints</span>
                                        <p class="font-medium text-slate-800">40k Major Service & Engine Diagnostics
                                            (Full fluid flush, filters, electronic triage)</p>
                                    </div>

                                    <!-- Actions & Status -->
                                    <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                                        <div class="flex items-center gap-1.5 text-xs text-slate-500">
                                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                            <span>In Queue • Unassigned</span>
                                        </div>
                                        <button type="button"
                                            onclick="openAssignModal('CB-1049', 'WP CAB-7892', 'Toyota Land Cruiser Prado', '40k Major Service & Engine Diagnostics', 'Dilani Wickramasinghe')"
                                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-[#F05A28] hover:bg-[#D94819] text-white text-xs font-bold shadow-sm transition-all">
                                            <span>Assign Technician</span>
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2.5">
                                                <polyline points="9 18 15 12 9 6"></polyline>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Right: Live Technician Availability -->
                        <div class="space-y-4">
                            <h3
                                class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                Technician Availability
                            </h3>

                            <div
                                class="bg-white rounded-2xl border border-slate-200 p-4 space-y-3 shadow-2xs divide-y divide-slate-100">

                                <!-- TECH 1: Kasun Perera (Available) -->
                                <div class="pt-2 first:pt-0 flex items-center justify-between text-xs">
                                    <div class="flex items-center gap-2.5">
                                        <div
                                            class="w-8 h-8 rounded-full bg-emerald-600 text-white font-bold text-xs flex items-center justify-center">
                                            KP
                                        </div>
                                        <div>
                                            <span class="font-bold text-slate-900 block">Kasun Perera</span>
                                            <span class="text-[11px] text-slate-400">Suspension & Steering</span>
                                        </div>
                                    </div>
                                    <span
                                        class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                        Free (0 Jobs)
                                    </span>
                                </div>

                                <!-- TECH 2: Nuwan Pradeep (Active) -->
                                <div class="pt-3 flex items-center justify-between text-xs">
                                    <div class="flex items-center gap-2.5">
                                        <div
                                            class="w-8 h-8 rounded-full bg-blue-600 text-white font-bold text-xs flex items-center justify-center">
                                            NP
                                        </div>
                                        <div>
                                            <span class="font-bold text-slate-900 block">Nuwan Pradeep</span>
                                            <span class="text-[11px] text-slate-400">Hybrid / EV Diagnostics</span>
                                        </div>
                                    </div>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-700">
                                        1 Active Job
                                    </span>
                                </div>

                                <!-- TECH 3: Dishan Karunaratne (Active) -->
                                <div class="pt-3 flex items-center justify-between text-xs">
                                    <div class="flex items-center gap-2.5">
                                        <div
                                            class="w-8 h-8 rounded-full bg-[#EA580C] text-white font-bold text-xs flex items-center justify-center">
                                            DK
                                        </div>
                                        <div>
                                            <span class="font-bold text-slate-900 block">Dishan Karunaratne</span>
                                            <span class="text-[11px] text-slate-400">Heavy Mechanical & Brakes</span>
                                        </div>
                                    </div>
                                    <span
                                        class="px-2 py-0.5 rounded text-[10px] font-bold bg-orange-50 text-orange-700">
                                        2 Active Jobs
                                    </span>
                                </div>

                                <!-- TECH 4: Ruwan Jayasuriya (On Leave) -->
                                <div class="pt-3 flex items-center justify-between text-xs opacity-70">
                                    <div class="flex items-center gap-2.5">
                                        <div
                                            class="w-8 h-8 rounded-full bg-slate-400 text-white font-bold text-xs flex items-center justify-center">
                                            RJ
                                        </div>
                                        <div>
                                            <span class="font-bold text-slate-700 block">Ruwan Jayasuriya</span>
                                            <span class="text-[11px] text-slate-400">Returns Tomorrow</span>
                                        </div>
                                    </div>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600">
                                        On Leave
                                    </span>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>

                <!-- ==================================================== -->
                <!-- VIEW 3: TECHNICIANS ROSTER VIEW                     -->
                <!-- ==================================================== -->
                <div id="viewTechnicians" class="hidden space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <h2 class="text-2xl font-extrabold text-[#0F172A] tracking-tight">Technicians Roster</h2>
                            <p class="text-xs text-slate-500">Live operational status, assignments, and workload
                                distribution across all technicians.</p>
                        </div>
                        <button type="button" onclick="switchSupervisorView('active-jobs')"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                            ← Return to Active Jobs
                        </button>
                    </div>

                    <!-- Technicians Grid Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

                        <!-- TECH 1: Dishan Karunaratne -->
                        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-2xs space-y-4">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-11 h-11 rounded-xl bg-[#EA580C] text-white flex items-center justify-center font-bold text-sm shadow-sm">
                                        DK
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-900 text-sm">Dishan Karunaratne</h3>
                                        <p class="text-xs text-slate-400">Master Technician • Heavy Mechanical</p>
                                    </div>
                                </div>
                                <span
                                    class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-orange-100 text-orange-800 border border-orange-200">
                                    Assigned
                                </span>
                            </div>

                            <div
                                class="grid grid-cols-2 gap-2 text-xs bg-slate-50 p-3 rounded-xl border border-slate-100">
                                <div>
                                    <span class="text-slate-400 block text-[10px] uppercase font-bold">Active
                                        Jobs</span>
                                    <span class="font-bold text-slate-800 text-sm">2 Jobs</span>
                                </div>
                                <div>
                                    <span
                                        class="text-slate-400 block text-[10px] uppercase font-bold">Specialization</span>
                                    <span class="font-bold text-slate-800">Mechanical & Brakes</span>
                                </div>
                            </div>

                            <div class="text-xs space-y-1.5">
                                <span
                                    class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Current
                                    Assignment:</span>
                                <div
                                    class="flex items-center justify-between p-2 rounded-lg bg-orange-50 border border-orange-100 text-orange-950 font-medium">
                                    <span>CB-1045 (Honda Civic RS)</span>
                                    <span class="font-mono text-[10px] font-bold">45m</span>
                                </div>
                            </div>
                        </div>

                        <!-- TECH 2: Nuwan Pradeep -->
                        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-2xs space-y-4">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-11 h-11 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-sm shadow-sm">
                                        NP
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-900 text-sm">Nuwan Pradeep</h3>
                                        <p class="text-xs text-slate-400">Senior Technician • Diagnostic Lead</p>
                                    </div>
                                </div>
                                <span
                                    class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-orange-100 text-orange-800 border border-orange-200">
                                    Assigned
                                </span>
                            </div>

                            <div
                                class="grid grid-cols-2 gap-2 text-xs bg-slate-50 p-3 rounded-xl border border-slate-100">
                                <div>
                                    <span class="text-slate-400 block text-[10px] uppercase font-bold">Active
                                        Jobs</span>
                                    <span class="font-bold text-slate-800 text-sm">1 Job</span>
                                </div>
                                <div>
                                    <span
                                        class="text-slate-400 block text-[10px] uppercase font-bold">Specialization</span>
                                    <span class="font-bold text-slate-800">Hybrid / EV Diagnostics</span>
                                </div>
                            </div>

                            <div class="text-xs space-y-1.5">
                                <span
                                    class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Current
                                    Assignment:</span>
                                <div
                                    class="flex items-center justify-between p-2 rounded-lg bg-blue-50 border border-blue-100 text-blue-950 font-medium">
                                    <span>CB-1046 (Toyota Aqua G)</span>
                                    <span class="font-mono text-[10px] font-bold">1h 10m</span>
                                </div>
                            </div>
                        </div>

                        <!-- TECH 3: Kasun Perera (Available) -->
                        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-2xs space-y-4">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-11 h-11 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-sm shadow-sm">
                                        KP
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-900 text-sm">Kasun Perera</h3>
                                        <p class="text-xs text-slate-400">Technician • Chassis & Suspension</p>
                                    </div>
                                </div>
                                <span
                                    class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    Available
                                </span>
                            </div>

                            <div
                                class="grid grid-cols-2 gap-2 text-xs bg-slate-50 p-3 rounded-xl border border-slate-100">
                                <div>
                                    <span class="text-slate-400 block text-[10px] uppercase font-bold">Active
                                        Jobs</span>
                                    <span class="font-bold text-emerald-600 text-sm">0 Jobs (Free)</span>
                                </div>
                                <div>
                                    <span
                                        class="text-slate-400 block text-[10px] uppercase font-bold">Specialization</span>
                                    <span class="font-bold text-slate-800">Suspension & Steering</span>
                                </div>
                            </div>

                            <div class="text-xs space-y-1.5">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Ready
                                    for Assignment:</span>
                                <div
                                    class="p-2 rounded-lg bg-emerald-50 border border-emerald-100 text-emerald-900 font-medium text-center">
                                    Station Ready for Incoming Work
                                </div>
                            </div>
                        </div>

                        <!-- TECH 4: Ruwan Jayasuriya (On Leave) -->
                        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-2xs space-y-4 opacity-85">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-11 h-11 rounded-xl bg-slate-400 text-white flex items-center justify-center font-bold text-sm shadow-sm">
                                        RJ
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-900 text-sm">Ruwan Jayasuriya</h3>
                                        <p class="text-xs text-slate-400">Technician • AC & Electrical</p>
                                    </div>
                                </div>
                                <span
                                    class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                    On Leave
                                </span>
                            </div>

                            <div
                                class="grid grid-cols-2 gap-2 text-xs bg-slate-50 p-3 rounded-xl border border-slate-100">
                                <div>
                                    <span class="text-slate-400 block text-[10px] uppercase font-bold">Active
                                        Jobs</span>
                                    <span class="font-bold text-slate-500 text-sm">0 Jobs</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block text-[10px] uppercase font-bold">Return
                                        Date</span>
                                    <span class="font-bold text-slate-800">Tomorrow, 08:00 AM</span>
                                </div>
                            </div>
                        </div>

                        <!-- TECH 5: Samantha Wickramasinghe (Off Duty) -->
                        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-2xs space-y-4 opacity-85">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-11 h-11 rounded-xl bg-slate-500 text-white flex items-center justify-center font-bold text-sm shadow-sm">
                                        SW
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-900 text-sm">Samantha Wickramasinghe</h3>
                                        <p class="text-xs text-slate-400">Night Shift Tech • Diagnostics</p>
                                    </div>
                                </div>
                                <span
                                    class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                    Off Duty
                                </span>
                            </div>

                            <div
                                class="grid grid-cols-2 gap-2 text-xs bg-slate-50 p-3 rounded-xl border border-slate-100">
                                <div>
                                    <span class="text-slate-400 block text-[10px] uppercase font-bold">Active
                                        Jobs</span>
                                    <span class="font-bold text-slate-500 text-sm">0 Jobs</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block text-[10px] uppercase font-bold">Shift
                                        Start</span>
                                    <span class="font-bold text-slate-800">Tonight, 06:00 PM</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- ==================================================== -->
                <!-- VIEW 4: JOB HISTORY (ALL RECORDED JOBS & VEHICLES)   -->
                <!-- ==================================================== -->
                <div id="viewJobHistory" class="space-y-6 hidden">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <h2 class="text-2xl font-extrabold text-[#0F172A] tracking-tight">Job History & Vehicle
                                Records</h2>
                            <p class="text-xs text-slate-500">Official recorded archive of all serviced vehicles,
                                supervisor sign-offs, and billing releases.</p>
                        </div>

                        <!-- Filter & Search Controls -->
                        <div class="flex flex-wrap items-center gap-2.5">
                            <div class="relative w-56 sm:w-64">
                                <span
                                    class="absolute inset-y-0 left-0 flex items-center pl-2.5 pointer-events-none text-slate-400">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <path d="m21 21-4.35-4.35"></path>
                                    </svg>
                                </span>
                                <input type="text" id="historySearchInput" oninput="filterJobHistory()"
                                    placeholder="Search vehicle plate, customer..."
                                    class="w-full pl-8 pr-3 py-1.5 text-xs bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#F05A28] focus:border-[#F05A28] text-slate-700 placeholder:text-slate-400">
                            </div>

                            <select id="historyStatusFilter" onchange="filterJobHistory()"
                                class="px-3 py-1.5 text-xs bg-white border border-slate-200 rounded-lg text-slate-700 focus:outline-none focus:ring-1 focus:ring-[#F05A28]">
                                <option value="all">All Records</option>
                                <option value="completed">Completed & Released</option>
                                <option value="in-progress">In Progress</option>
                            </select>
                        </div>
                    </div>

                    <!-- Recorded Jobs Archive Table -->
                    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs" id="historyTable">
                                <thead
                                    class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                                    <tr>
                                        <th class="py-3.5 px-4">VEHICLE & JOB ID</th>
                                        <th class="py-3.5 px-4">CUSTOMER</th>
                                        <th class="py-3.5 px-4">SERVICE SCOPE</th>
                                        <th class="py-3.5 px-4">TECHNICIAN</th>
                                        <th class="py-3.5 px-4">SUPERVISOR QA</th>
                                        <th class="py-3.5 px-4">STATUS / INVOICE</th>
                                        <th class="py-3.5 px-4 text-right">TOTAL (LKR)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 font-medium" id="historyTableBody">
                                    <!-- RECORD 1 -->
                                    <tr class="hover:bg-slate-50 transition-colors cursor-pointer"
                                        onclick="openJobSheet('CB-1039')">
                                        <td class="py-3.5 px-4">
                                            <div class="flex items-center gap-2">
                                                <div class="sl-plate-badge">
                                                    <span class="province">WP</span>CBJ-5049
                                                </div>
                                                <span class="font-mono text-xs font-bold text-slate-600">CB-1039</span>
                                            </div>
                                            <span class="text-[11px] text-slate-500 block mt-1">Toyota Prado TX-L
                                                2020</span>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="font-bold text-slate-900">Dr. Harsha Alwis</div>
                                            <span class="text-[11px] text-slate-400">+94 77 220 1199</span>
                                        </td>
                                        <td class="py-3.5 px-4 text-slate-700">Front brake disc resurfacing & Ferodo
                                            ceramic pad replacement</td>
                                        <td class="py-3.5 px-4">
                                            <span class="font-bold text-slate-800">Dishan Karunaratne</span>
                                            <span class="text-[10px] text-slate-400 block">Station 03</span>
                                        </td>
                                        <td class="py-3.5 px-4 text-emerald-700 font-semibold">
                                            ✔ Approved by Asanka Mendis
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <span
                                                class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                INV-2691 • Paid
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4 text-right font-bold font-mono text-slate-900">41,900
                                        </td>
                                    </tr>

                                    <!-- RECORD 2 -->
                                    <tr class="hover:bg-slate-50 transition-colors cursor-pointer"
                                        onclick="openJobSheet('CB-1031')">
                                        <td class="py-3.5 px-4">
                                            <div class="flex items-center gap-2">
                                                <div class="sl-plate-badge">
                                                    <span class="province">WP</span>KX-3108
                                                </div>
                                                <span class="font-mono text-xs font-bold text-slate-600">CB-1031</span>
                                            </div>
                                            <span class="text-[11px] text-slate-500 block mt-1">Toyota Hilux Revo
                                                2019</span>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="font-bold text-slate-900">Rohan De Silva</div>
                                            <span class="text-[11px] text-slate-400">+94 77 654 3210</span>
                                        </td>
                                        <td class="py-3.5 px-4 text-slate-700">40k Drivetrain service, differential &
                                            transfer gear oils</td>
                                        <td class="py-3.5 px-4">
                                            <span class="font-bold text-slate-800">Nuwan Pradeep</span>
                                            <span class="text-[10px] text-slate-400 block">Station 02</span>
                                        </td>
                                        <td class="py-3.5 px-4 text-emerald-700 font-semibold">
                                            ✔ Approved by Asanka Mendis
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <span
                                                class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                INV-2688 • Paid
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4 text-right font-bold font-mono text-slate-900">48,200
                                        </td>
                                    </tr>

                                    <!-- RECORD 3 -->
                                    <tr class="hover:bg-slate-50 transition-colors cursor-pointer"
                                        onclick="openJobSheet('CB-1025')">
                                        <td class="py-3.5 px-4">
                                            <div class="flex items-center gap-2">
                                                <div class="sl-plate-badge">
                                                    <span class="province">CP</span>CAA-1122
                                                </div>
                                                <span class="font-mono text-xs font-bold text-slate-600">CB-1025</span>
                                            </div>
                                            <span class="text-[11px] text-slate-500 block mt-1">Mitsubishi Montero Sport</span>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="font-bold text-slate-900">Sunil Shantha</div>
                                            <span class="text-[11px] text-slate-400">+94 71 888 4433</span>
                                        </td>
                                        <td class="py-3.5 px-4 text-slate-700">Timing belt kit replacement & water pump overhaul</td>
                                        <td class="py-3.5 px-4">
                                            <span class="font-bold text-slate-800">Kasun Perera</span>
                                            <span class="text-[10px] text-slate-400 block">Station 01</span>
                                        </td>
                                        <td class="py-3.5 px-4 text-emerald-700 font-semibold">
                                            ✔ Approved by Asanka Mendis
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <span
                                                class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                INV-2675 • Paid
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4 text-right font-bold font-mono text-slate-900">86,500
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 3. MODAL: ASSIGN TECHNICIAN TO QUEUED VEHICLE            -->
    <!-- ======================================================== -->
    <div id="assignTechnicianModal"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden"
        role="dialog" aria-modal="true">
        <div
            class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-md overflow-hidden transform transition-all animate-fade-in">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/70">
                <div class="flex items-center gap-2.5">
                    <div
                        class="w-8 h-8 rounded-lg bg-orange-100 text-[#F05A28] flex items-center justify-center font-bold">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <polyline points="16 11 18 13 22 9"></polyline>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-sm">Assign Technician</h3>
                        <p class="text-[11px] text-slate-500">Dispatch checked-in queued vehicle to station.</p>
                    </div>
                </div>
                <button type="button" onclick="closeAssignModal()" class="text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <div class="p-6 space-y-4 text-xs">
                <!-- Vehicle Card Summary -->
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                    <div class="flex items-center justify-between">
                        <span id="assignModalPlate" class="font-mono font-bold text-slate-900 text-sm">WP CBA-1234</span>
                        <span id="assignModalJobId" class="font-mono text-[10px] text-slate-400">CB-1048</span>
                    </div>
                    <p id="assignModalVehicle" class="font-semibold text-slate-700">Honda Vezel RU1</p>
                    <p id="assignModalService" class="text-slate-500 text-[11px]">Brake pad replacement & disc skimming</p>
                </div>

                <!-- Select Technician -->
                <div>
                    <label class="block font-bold text-slate-700 uppercase text-[10px] tracking-wider mb-2">
                        Select Available Technician
                    </label>

                    <div class="space-y-2">
                        <!-- Option 1: Kasun Perera -->
                        <label
                            class="flex items-center justify-between p-3 rounded-xl border border-slate-200 hover:border-[#F05A28] bg-white cursor-pointer transition-colors">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="selectedTech" value="Kasun Perera" data-avatar="KP" checked
                                    class="w-4 h-4 text-[#F05A28] border-slate-300 focus:ring-[#F05A28]">
                                <div
                                    class="w-7 h-7 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs font-bold">
                                    KP
                                </div>
                                <div>
                                    <span class="font-bold text-slate-800 block">Kasun Perera</span>
                                    <span class="text-[10px] text-slate-400">Suspension & Steering • Free</span>
                                </div>
                            </div>
                            <span
                                class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">Available</span>
                        </label>

                        <!-- Option 2: Dishan Karunaratne -->
                        <label
                            class="flex items-center justify-between p-3 rounded-xl border border-slate-200 hover:border-[#F05A28] bg-white cursor-pointer transition-colors">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="selectedTech" value="Dishan Karunaratne" data-avatar="DK"
                                    class="w-4 h-4 text-[#F05A28] border-slate-300 focus:ring-[#F05A28]">
                                <div
                                    class="w-7 h-7 rounded-full bg-[#EA580C] text-white flex items-center justify-center text-xs font-bold">
                                    DK
                                </div>
                                <div>
                                    <span class="font-bold text-slate-800 block">Dishan Karunaratne</span>
                                    <span class="text-[10px] text-slate-400">Mechanical & Brakes • 2 Active Jobs</span>
                                </div>
                            </div>
                            <span
                                class="px-2 py-0.5 rounded text-[10px] font-bold bg-orange-50 text-orange-700 border border-orange-200">Active</span>
                        </label>

                        <!-- Option 3: Nuwan Pradeep -->
                        <label
                            class="flex items-center justify-between p-3 rounded-xl border border-slate-200 hover:border-[#F05A28] bg-white cursor-pointer transition-colors">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="selectedTech" value="Nuwan Pradeep" data-avatar="NP"
                                    class="w-4 h-4 text-[#F05A28] border-slate-300 focus:ring-[#F05A28]">
                                <div
                                    class="w-7 h-7 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold">
                                    NP
                                </div>
                                <div>
                                    <span class="font-bold text-slate-800 block">Nuwan Pradeep</span>
                                    <span class="text-[10px] text-slate-400">Hybrid / EV Diagnostics • 1 Active
                                        Job</span>
                                </div>
                            </div>
                            <span
                                class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">Active</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="p-4 border-t border-slate-100 bg-slate-50/70 flex items-center justify-end gap-2.5">
                <button type="button" onclick="closeAssignModal()"
                    class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-100 font-medium">
                    Cancel
                </button>
                <button type="button" onclick="confirmAssignTechnician()"
                    class="px-4 py-2 rounded-lg bg-[#F05A28] hover:bg-[#D94819] text-white font-bold shadow-xs transition-colors">
                    Confirm & Dispatch Job
                </button>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 4. MODAL: QA REWORK REQUEST NOTES                        -->
    <!-- ======================================================== -->
    <div id="reworkNotesModal"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden"
        role="dialog" aria-modal="true">
        <div
            class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-lg overflow-hidden transform transition-all animate-fade-in">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-amber-50/70">
                <div class="flex items-center gap-2.5">
                    <div
                        class="w-8 h-8 rounded-lg bg-amber-500/20 text-amber-700 flex items-center justify-center font-bold">
                        ⚠️
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-sm">Supervisor QA Rework Request</h3>
                        <p class="text-[11px] text-slate-500">Return job to technician with specific correction notes.
                        </p>
                    </div>
                </div>
                <button type="button" onclick="closeReworkModal()" class="text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <div class="p-6 space-y-4 text-xs">
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                    <div>
                        <span id="reworkModalJobId" class="font-mono font-bold text-slate-900 text-xs">CB-1042</span>
                        <p id="reworkModalVehicle" class="text-slate-600 text-[11px] font-medium">Kia Sportage GT (SP
                            BC-4912)</p>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] text-slate-400 uppercase font-bold block">Assigned Tech</span>
                        <span id="reworkModalTech" class="font-bold text-slate-800">S. Nisanka</span>
                    </div>
                </div>

                <div>
                    <label for="reworkNotesInput"
                        class="block font-bold text-slate-700 uppercase text-[10px] tracking-wider mb-1.5">
                        Mandatory Rework Instructions <span class="text-rose-500">*</span>
                    </label>
                    <textarea id="reworkNotesInput" rows="3" required
                        placeholder="Specify defects found (e.g. Brake pedal soft, steering wheel angle offset 3 deg, torque check required)..."
                        class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl focus:ring-1 focus:ring-[#F05A28] focus:border-[#F05A28] outline-none text-slate-800 text-xs"></textarea>
                    <span id="reworkNotesError" class="text-rose-600 text-[11px] hidden font-semibold mt-1">Please enter
                        rework instructions before returning.</span>
                </div>

                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1.5">Quick
                        Defect Tags</span>
                    <div class="flex flex-wrap gap-1.5">
                        <button type="button" onclick="insertReworkTag('Torque specification verification failed.')"
                            class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-medium transition-colors">
                            + Torque Check Failed
                        </button>
                        <button type="button" onclick="insertReworkTag('Road test steering calibration off-center.')"
                            class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-medium transition-colors">
                            + Steering Calibration Off
                        </button>
                        <button type="button" onclick="insertReworkTag('Fluid level below factory indicator.')"
                            class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-medium transition-colors">
                            + Fluid Level Low
                        </button>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="p-4 border-t border-slate-100 bg-slate-50/70 flex items-center justify-end gap-2.5">
                <button type="button" onclick="closeReworkModal()"
                    class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-100 font-medium">
                    Cancel
                </button>
                <button type="button" onclick="confirmRework()"
                    class="px-4 py-2 rounded-lg bg-amber-600 hover:bg-amber-700 text-white font-bold shadow-xs transition-colors">
                    Send Back for Rework
                </button>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 5. MODAL: JOB DETAILS & QA INSPECTOR                     -->
    <!-- ======================================================== -->
    <div id="jobDetailsModal"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden"
        role="dialog" aria-modal="true">
        <div
            class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-lg overflow-hidden transform transition-all animate-fade-in">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/70">
                <div class="flex items-center gap-2.5">
                    <div class="sl-plate-badge" id="modalPlateBadge">WP CBA-1234</div>
                    <span class="font-mono text-xs text-slate-400" id="modalJobIdText">CB-1048</span>
                </div>
                <button type="button" onclick="closeJobDetails()" class="text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <div class="p-6 space-y-4 text-xs">
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Service
                        Scope</span>
                    <h4 class="font-bold text-slate-900 text-sm mt-0.5" id="modalServiceText">Service Details</h4>
                </div>

                <div class="grid grid-cols-2 gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Assigned Technician</span>
                        <span class="font-bold text-slate-800" id="modalTechText">Not Assigned</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Current Stage</span>
                        <span class="font-bold text-slate-800 uppercase" id="modalStageText">In Queue</span>
                    </div>
                </div>

                <div class="space-y-2">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Supervisor QA
                        Checklist</span>
                    <label
                        class="flex items-center gap-2 p-2 rounded-lg bg-slate-50 border border-slate-100 text-slate-700">
                        <input type="checkbox" checked class="w-4 h-4 text-[#F05A28] rounded">
                        <span>Work completed to manufacturer torque specifications</span>
                    </label>
                    <label
                        class="flex items-center gap-2 p-2 rounded-lg bg-slate-50 border border-slate-100 text-slate-700">
                        <input type="checkbox" checked class="w-4 h-4 text-[#F05A28] rounded">
                        <span>OBD-II Diagnostic Clear & Sensor Verification</span>
                    </label>
                    <label
                        class="flex items-center gap-2 p-2 rounded-lg bg-slate-50 border border-slate-100 text-slate-700">
                        <input type="checkbox" checked class="w-4 h-4 text-[#F05A28] rounded">
                        <span>Cleanliness check & fluid level inspection</span>
                    </label>
                </div>
            </div>

            <div class="p-4 border-t border-slate-100 bg-slate-50/70 flex items-center justify-between">
                <button type="button" onclick="closeJobDetails()"
                    class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-100 font-medium">
                    Close
                </button>
                <div class="flex items-center gap-2" id="modalActionButtons">
                    <!-- Injected dynamically -->
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast"
        class="fixed bottom-5 right-5 z-50 bg-[#0F172A] text-white text-xs px-4 py-3 rounded-lg shadow-xl border border-slate-700 flex items-center gap-2.5 transform translate-y-20 opacity-0 transition-all duration-300 pointer-events-none">
        <svg class="w-4 h-4 text-emerald-400 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2.5">
            <polyline points="20 6 9 17 4 12"></polyline>
        </svg>
        <span id="toastMsg">Action updated!</span>
    </div>

    <!-- ======================================================== -->
    <!-- 6. CLIENT JAVASCRIPT & KANBAN ENGINE                     -->
    <!-- ======================================================== -->
    <script>
        let draggedCard = null;
        let sourceColumnId = null;
        let pendingCardIdToAssign = null;
        let pendingCardIdToRework = null;

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

        // View Switcher: active-jobs | assign-work | technicians | job-history
        function switchSupervisorView(viewName) {
            const views = {
                'active-jobs': { el: document.getElementById('viewActiveJobs'), btn: document.getElementById('navActiveJobsBtn'), breadcrumb: 'Active Jobs' },
                'assign-work': { el: document.getElementById('viewAssignWork'), btn: document.getElementById('navAssignWorkBtn'), breadcrumb: 'Assign Work (Queue)' },
                'technicians': { el: document.getElementById('viewTechnicians'), btn: document.getElementById('navTechniciansBtn'), breadcrumb: 'Technicians Roster' },
                'job-history': { el: document.getElementById('viewJobHistory'), btn: document.getElementById('navJobHistoryBtn'), breadcrumb: 'Job History & Vehicle Records' }
            };

            Object.keys(views).forEach(key => {
                const item = views[key];
                if (!item.el || !item.btn) return;
                if (key === viewName) {
                    item.el.classList.remove('hidden');
                    item.btn.classList.add('nav-item-active');
                    item.btn.classList.remove('text-slate-400');
                    document.getElementById('topBreadcrumbText').textContent = item.breadcrumb;
                } else {
                    item.el.classList.add('hidden');
                    item.btn.classList.remove('nav-item-active');
                    item.btn.classList.add('text-slate-400');
                }
            });
            toggleMobileSidebar(false);
        }

        // Filter Kanban Cards in Active Jobs
        function filterKanbanCards() {
            const query = document.getElementById('kanbanFilterInput').value.toLowerCase().trim();
            const cards = document.querySelectorAll('#kanbanBoard .kanban-card');
            cards.forEach(card => {
                const text = card.innerText.toLowerCase();
                if (!query || text.includes(query)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Filter Job History Table
        function filterJobHistory() {
            const query = document.getElementById('historySearchInput').value.toLowerCase().trim();
            const statusFilter = document.getElementById('historyStatusFilter').value;
            const rows = document.querySelectorAll('#historyTableBody tr');

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                const matchesQuery = !query || text.includes(query);
                let matchesStatus = true;

                if (statusFilter === 'completed') {
                    matchesStatus = text.includes('paid') || text.includes('approved');
                } else if (statusFilter === 'in-progress') {
                    matchesStatus = text.includes('in progress') || text.includes('active');
                }

                if (matchesQuery && matchesStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // ========================================================
        // KANBAN DRAG ENGINE IMPLEMENTATION
        // ========================================================
        function handleDragStart(e) {
            const card = e.currentTarget;
            if (card.closest('.kanban-column-body')?.getAttribute('data-column-id') === 'ready' || card.getAttribute('draggable') === 'false') {
                e.preventDefault();
                showToast('Handover-ready jobs are immutable.');
                return;
            }

            draggedCard = card;
            sourceColumnId = card.closest('.kanban-column-body')?.getAttribute('data-column-id');
            e.dataTransfer.setData('text/plain', card.id);
            e.dataTransfer.effectAllowed = 'move';
            setTimeout(() => {
                if (draggedCard) draggedCard.classList.add('is-dragging');
            }, 0);
        }

        function handleDragEnd(e) {
            if (draggedCard) {
                draggedCard.classList.remove('is-dragging');
            }
            document.querySelectorAll('.kanban-column-body').forEach(col => {
                col.classList.remove('drag-over');
            });
            draggedCard = null;
        }

        function handleDragOver(e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            e.currentTarget.classList.add('drag-over');
        }

        function handleDragLeave(e) {
            e.currentTarget.classList.remove('drag-over');
        }

        function handleDrop(e, targetColumnId) {
            e.preventDefault();
            const col = e.currentTarget;
            col.classList.remove('drag-over');

            const cardId = e.dataTransfer.getData('text/plain');
            const card = document.getElementById(cardId) || draggedCard;
            if (!card) return;

            const fromCol = sourceColumnId || card.closest('.kanban-column-body')?.getAttribute('data-column-id');

            // Same column drop
            if (fromCol === targetColumnId) {
                col.appendChild(card);
                return;
            }

            // In Queue -> In Progress (Must assign technician)
            if (fromCol === 'in-queue' && targetColumnId === 'in-progress') {
                openAssignModal(
                    card.getAttribute('data-job-id'),
                    card.getAttribute('data-plate'),
                    card.getAttribute('data-vehicle'),
                    card.getAttribute('data-service'),
                    card.getAttribute('data-customer')
                );
                return;
            }

            // In Queue -> Pending QA or Ready directly disallowed
            if (fromCol === 'in-queue' && (targetColumnId === 'pending-qa' || targetColumnId === 'ready')) {
                showToast('Vehicles in queue must first be assigned to a technician.');
                return;
            }

            // Pending QA -> Ready (Pass QA)
            if (fromCol === 'pending-qa' && targetColumnId === 'ready') {
                approveJobToHandover(card.id);
                return;
            }

            // Pending QA -> In Progress (Rework)
            if (fromCol === 'pending-qa' && targetColumnId === 'in-progress') {
                openReworkModal(card.id);
                return;
            }

            // In Progress -> Ready directly without QA disallowed
            if (fromCol === 'in-progress' && targetColumnId === 'ready') {
                showToast('Jobs must pass Pending QA inspection before moving to Ready for Handover.');
                return;
            }

            // In Progress -> Pending QA (Technician finishes work)
            if (fromCol === 'in-progress' && targetColumnId === 'pending-qa') {
                col.prepend(card);
                updateCardVisuals(card, 'pending-qa');
                updateColumnCounters();
                showToast(`${card.getAttribute('data-plate')} moved to Pending QA inspection.`);
                return;
            }

            // Default move
            col.prepend(card);
            updateCardVisuals(card, targetColumnId);
            updateColumnCounters();
        }

        // ========================================================
        // MODAL ACTION: ASSIGN TECHNICIAN TO QUEUED JOB
        // ========================================================
        function openAssignModal(jobId, plate, vehicle, service, customer) {
            pendingCardIdToAssign = plate;
            document.getElementById('assignModalPlate').textContent = plate;
            document.getElementById('assignModalVehicle').textContent = vehicle;
            document.getElementById('assignModalJobId').textContent = jobId || 'CB-NEW';
            document.getElementById('assignModalService').textContent = service;
            document.getElementById('assignTechnicianModal').classList.remove('hidden');
        }

        function closeAssignModal() {
            document.getElementById('assignTechnicianModal').classList.add('hidden');
            pendingCardIdToAssign = null;
        }

        function confirmAssignTechnician() {
            const selectedRadio = document.querySelector('input[name="selectedTech"]:checked');
            const techName = selectedRadio ? selectedRadio.value : 'Kasun Perera';
            const techAvatar = selectedRadio ? selectedRadio.getAttribute('data-avatar') : 'KP';

            // Find matching card on Active Jobs Board if exists
            const plateClean = pendingCardIdToAssign.replace(/[^a-zA-Z0-9]/g, '').toLowerCase();
            const card = document.querySelector(`[data-plate*="${pendingCardIdToAssign}"]`) || document.getElementById(`card-${plateClean}`);

            if (card) {
                card.setAttribute('data-tech', techName);
                card.setAttribute('data-initials', techAvatar);
                const inProgressCol = document.querySelector('.kanban-column-body[data-column-id="in-progress"]');
                if (inProgressCol) {
                    inProgressCol.prepend(card);
                    updateCardVisuals(card, 'in-progress', { techName, techAvatar });
                }
            }

            // Remove from Assign Work Queue List if exists
            const queueItem = document.getElementById(`queue-${plateClean}`) || document.querySelector(`[id*="${plateClean}"]`);
            if (queueItem && queueItem.id.startsWith('queue-')) {
                queueItem.style.transition = 'all 0.3s ease';
                queueItem.style.opacity = '0';
                queueItem.style.transform = 'translateX(25px)';
                setTimeout(() => {
                    queueItem.remove();
                    updateQueueBadgeCount();
                }, 300);
            }

            updateColumnCounters();
            closeAssignModal();
            showToast(`${pendingCardIdToAssign} dispatched to ${techName}. Work started!`);
        }

        function updateQueueBadgeCount() {
            const queueItems = document.querySelectorAll('#assignQueueList > div');
            const count = queueItems.length;
            const badge = document.getElementById('navQueueCountBadge');
            const headerBadge = document.getElementById('queueHeaderBadge');
            const statQueue = document.getElementById('statQueueCount');

            if (badge) badge.textContent = count;
            if (headerBadge) headerBadge.textContent = `${count} In Queue`;
            if (statQueue) statQueue.textContent = `${count} Vehicles`;
        }

        // ========================================================
        // MODAL ACTION: QA REWORK
        // ========================================================
        function openReworkModal(cardId) {
            pendingCardIdToRework = cardId;
            const card = document.getElementById(cardId);
            if (card) {
                document.getElementById('reworkModalJobId').textContent = card.getAttribute('data-job-id') || 'CB-1042';
                document.getElementById('reworkModalVehicle').textContent = `${card.getAttribute('data-vehicle')} (${card.getAttribute('data-plate')})`;
                document.getElementById('reworkModalTech').textContent = card.getAttribute('data-tech') || 'Assigned Tech';
            }
            document.getElementById('reworkNotesInput').value = '';
            document.getElementById('reworkNotesError').classList.add('hidden');
            document.getElementById('reworkNotesModal').classList.remove('hidden');
        }

        function closeReworkModal() {
            document.getElementById('reworkNotesModal').classList.add('hidden');
            pendingCardIdToRework = null;
        }

        function insertReworkTag(text) {
            const input = document.getElementById('reworkNotesInput');
            if (input.value) {
                input.value += ' ' + text;
            } else {
                input.value = text;
            }
        }

        function confirmRework() {
            const notes = document.getElementById('reworkNotesInput').value.trim();
            const errorEl = document.getElementById('reworkNotesError');

            if (!notes) {
                errorEl.classList.remove('hidden');
                return;
            }
            errorEl.classList.add('hidden');

            const card = document.getElementById(pendingCardIdToRework);
            if (card) {
                const inProgressCol = document.querySelector('.kanban-column-body[data-column-id="in-progress"]');
                if (inProgressCol) {
                    inProgressCol.prepend(card);
                    updateCardVisuals(card, 'in-progress', { reworkNote: notes });
                }
                showToast(`${card.getAttribute('data-plate')} returned for rework with supervisor instructions.`);
            }

            updateColumnCounters();
            closeReworkModal();
            closeJobDetails();
        }

        // Approve Job to Handover
        function approveJobToHandover(cardId) {
            const card = document.getElementById(cardId);
            if (!card) return;

            const readyCol = document.querySelector('.kanban-column-body[data-column-id="ready"]');
            if (readyCol) {
                readyCol.prepend(card);
                card.setAttribute('draggable', 'false');
                card.classList.add('locked-card');

                const statusBadge = card.querySelector('.card-status-badge');
                if (statusBadge) {
                    statusBadge.className = 'card-status-badge px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-emerald-600/30 text-emerald-200 border border-emerald-500/50';
                    statusBadge.textContent = 'READY';
                }

                const techRow = card.querySelector('.card-tech-row');
                if (techRow) {
                    const passBtn = techRow.querySelector('button');
                    if (passBtn) {
                        passBtn.outerHTML = '<span class="text-[10px] font-bold text-emerald-700">QA Passed ✓</span>';
                    }
                }
            }

            updateColumnCounters();
            closeJobDetails();
            showToast(`✔ QA Passed! ${card.getAttribute('data-plate')} approved for customer handover.`);
        }

        // Card Visual Updater
        function updateCardVisuals(card, columnId, options = {}) {
            const statusBadge = card.querySelector('.card-status-badge');
            if (!statusBadge) return;

            if (columnId === 'in-progress') {
                statusBadge.className = 'card-status-badge px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-blue-600/30 text-blue-200 border border-blue-500/50';
                statusBadge.textContent = options.reworkNote ? 'REWORKING' : 'IN PROGRESS';

                if (options.techName) {
                    const techRow = card.querySelector('.card-tech-row');
                    if (techRow) {
                        techRow.innerHTML = `
                            <div class="w-6 h-6 rounded-full bg-slate-100 border border-slate-200 text-slate-700 text-[10px] font-bold flex items-center justify-center flex-shrink-0 card-tech-avatar">
                                ${options.techAvatar}
                            </div>
                            <div class="flex flex-col min-w-0">
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider leading-none mb-0.5">Technician</span>
                                <span class="truncate text-xs font-semibold text-slate-800 leading-tight card-tech-name">${options.techName}</span>
                            </div>
                        `;
                    }
                }
            } else if (columnId === 'pending-qa') {
                statusBadge.className = 'card-status-badge px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-amber-600/30 text-amber-200 border border-amber-500/50';
                statusBadge.textContent = 'PENDING QA';
            }
        }

        // Job Details Modal
        function openJobDetails(plate, tech, service, stage, jobId) {
            document.getElementById('modalPlateBadge').textContent = plate;
            document.getElementById('modalJobIdText').textContent = jobId || '';
            document.getElementById('modalServiceText').textContent = service;
            document.getElementById('modalTechText').textContent = tech || 'Not Assigned (In Queue)';
            document.getElementById('modalStageText').textContent = stage.replace('-', ' ');

            const actionContainer = document.getElementById('modalActionButtons');
            actionContainer.innerHTML = '';

            if (stage === 'in-queue') {
                actionContainer.innerHTML = `
                    <button type="button" onclick="closeJobDetails(); openAssignModal('${jobId}', '${plate}', '', '${service}', '')"
                        class="px-4 py-2 rounded-lg bg-[#F05A28] text-white font-bold text-xs shadow-sm hover:bg-[#D94819]">
                        Assign Technician
                    </button>
                `;
            } else if (stage === 'pending-qa') {
                actionContainer.innerHTML = `
                    <button type="button" onclick="openReworkModal('${plate.replace(/[^a-zA-Z0-9]/g, '').toLowerCase()}')"
                        class="px-3.5 py-2 rounded-lg bg-amber-600 text-white font-bold text-xs hover:bg-amber-700">
                        Request Rework
                    </button>
                    <button type="button" onclick="approveJobToHandover('${plate.replace(/[^a-zA-Z0-9]/g, '').toLowerCase()}')"
                        class="px-4 py-2 rounded-lg bg-emerald-600 text-white font-bold text-xs hover:bg-emerald-700 shadow-sm">
                        Approve QA ✓
                    </button>
                `;
            }

            document.getElementById('jobDetailsModal').classList.remove('hidden');
        }

        function closeJobDetails() {
            document.getElementById('jobDetailsModal').classList.add('hidden');
        }

        function openJobSheet(jobId) {
            showToast(`Loading recorded Job Sheet & Vehicle History for ${jobId}...`);
        }

        // Column Counter Updater
        function updateColumnCounters() {
            const cols = [
                { id: 'in-queue', badge: 'count-in-queue' },
                { id: 'in-progress', badge: 'count-in-progress' },
                { id: 'pending-qa', badge: 'count-pending-qa' },
                { id: 'ready', badge: 'count-ready' }
            ];

            let totalFloor = 0;
            cols.forEach(item => {
                const col = document.querySelector(`.kanban-column-body[data-column-id="${item.id}"]`);
                const badge = document.getElementById(item.badge);
                if (col && badge) {
                    const count = col.querySelectorAll('.kanban-card').length;
                    badge.textContent = count;
                    totalFloor += count;
                }
            });

            document.getElementById('statFloorCount').textContent = totalFloor;
            document.getElementById('navBoardCountBadge').textContent = totalFloor;

            const qaCol = document.querySelector('.kanban-column-body[data-column-id="pending-qa"]');
            if (qaCol) {
                document.getElementById('statPendingQa').textContent = qaCol.querySelectorAll('.kanban-card').length;
            }

            const readyCol = document.querySelector('.kanban-column-body[data-column-id="ready"]');
            if (readyCol) {
                document.getElementById('statReadyCount').textContent = readyCol.querySelectorAll('.kanban-card').length;
            }
        }

        // Supervisor Logout
        function logoutSupervisor() {
            if (confirm('Lock Supervisor Workstation and return to staff login?')) {
                window.location.href = '/login';
            }
        }

        // Toast Feedback
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
                closeAssignModal();
                closeReworkModal();
                closeJobDetails();
                toggleMobileSidebar(false);
            }
        });

        // Initialize counters on load
        document.addEventListener('DOMContentLoaded', () => {
            updateColumnCounters();
            updateQueueBadgeCount();
        });
    </script>
</body>

</html>
