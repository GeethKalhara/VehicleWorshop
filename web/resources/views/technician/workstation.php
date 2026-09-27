<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>My Jobs - Technician Workstation | VWMS</title>
    <meta name="description"
        content="VWMS Technician Workstation - Manage active bay jobs, track work timers, log parts used, and submit completed work for QA.">

    <!-- Google Fonts: Inter & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@500;600;700&display=swap"
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

        .kanban-column-body.drag-over {
            background-color: rgba(240, 90, 40, 0.06);
            border: 2px dashed #F05A28 !important;
            border-radius: 12px;
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
        <!-- 1. LEFT SIDEBAR: DARK TECHNICIAN WORKSTATION NAVIGATION -->
        <!-- ======================================================== -->
        <aside id="sidebar"
            class="fixed top-0 bottom-0 left-0 w-64 bg-[#0F172A] text-white z-50 flex flex-col justify-between transition-transform duration-300 -translate-x-full lg:translate-x-0 lg:static lg:z-auto border-r border-slate-800 flex-shrink-0">

            <!-- Top Container: Logo + Menu Items -->
            <div class="flex flex-col">
                <!-- Top Brand: VWMS OS -->
                <div class="px-5 py-5 border-b border-slate-800/80 flex items-center justify-between">
                    <a href="/technician/workstation" class="flex items-center gap-2.5 group">
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
                            <span class="text-[9px] font-semibold text-slate-400 uppercase tracking-widest mt-1">SERVICE
                                DESK</span>
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

                <!-- Navigation List (Matching Screenshot) -->
                <nav class="px-3 py-5 space-y-1.5" aria-label="Technician Navigation">
                    <div class="px-3 pb-2 text-[10px] font-bold text-slate-400 tracking-widest uppercase">
                        OPERATIONS
                    </div>

                    <!-- 1. My Jobs (Active Tab - Matching Screenshot) -->
                    <a href="/technician/workstation" id="navMyJobsBtn" onclick="showMyJobsView(event)"
                        class="nav-item-active flex items-center gap-3 px-3.5 py-2.5 rounded-lg font-semibold text-sm transition-all duration-150 shadow-sm">
                        <!-- Wrench Icon -->
                        <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z">
                            </path>
                        </svg>
                        <span>My Jobs</span>
                    </a>

                    <!-- 2. Job History (Matching Screenshot) -->
                    <button type="button" onclick="toggleJobHistoryView()" id="navJobHistoryBtn"
                        class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 font-medium text-sm transition-colors duration-150">
                        <!-- Clock History Icon -->
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                            <path d="M3 3v5h5"></path>
                            <polyline points="12 7 12 12 15 15"></polyline>
                        </svg>
                        <span>Job History</span>
                    </button>
                </nav>
            </div>

            <!-- Bottom Section: Dishan K. Technician Profile Card (Matching Screenshot) -->
            <div class="p-3 border-t border-slate-800">
                <div
                    class="border border-dashed border-slate-700/80 rounded-lg p-2.5 flex items-center justify-between bg-slate-900/40">
                    <div class="flex items-center gap-2.5">
                        <!-- Avatar DK with live green status dot -->
                        <div class="relative flex-shrink-0">
                            <div
                                class="w-8 h-8 rounded-full bg-[#EA580C] text-white flex items-center justify-center text-xs font-bold shadow-sm">
                                DK
                            </div>
                            <span
                                class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-[#0F172A] rounded-full"></span>
                        </div>
                        <!-- Agent Details -->
                        <div class="flex flex-col min-w-0">
                            <span class="text-xs font-bold text-white truncate leading-tight">Dishan K.</span>
                            <span class="text-[11px] text-slate-400 truncate leading-tight mt-0.5">Technician</span>
                        </div>
                    </div>

                    <!-- Station Lock / Logout Action -->
                    <button type="button" onclick="lockTechnicianStation()"
                        class="p-1.5 text-slate-500 hover:text-slate-200 transition-colors" title="Lock Workstation">
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

                    <!-- Breadcrumbs (Matching Screenshot) -->
                    <div class="flex items-center gap-1.5 text-xs text-slate-400">
                        <span class="text-slate-400">/</span>
                        <span id="pageBreadcrumb" class="font-semibold text-slate-700">My Jobs</span>
                    </div>
                </div>

                <!-- Right Utilities (Matching Screenshot) -->
                <div class="flex items-center gap-3 sm:gap-4">
                    <!-- Notification Bell -->
                    <button type="button" onclick="showToast('Floor notice: 1 pending job assigned')"
                        class="w-8 h-8 rounded-full border border-slate-200 bg-white flex items-center justify-center text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors relative"
                        aria-label="Notifications">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                        <span
                            class="absolute -top-1 -right-1 w-4 h-4 bg-[#F05A28] text-white text-[10px] font-bold rounded-full flex items-center justify-center leading-none shadow-sm">
                            1
                        </span>
                    </button>

                    <!-- Profile Circle -->
                    <button type="button" onclick="showToast('Technician: Dishan Karunaratne')"
                        class="w-8 h-8 rounded-full bg-[#EA580C] text-white flex items-center justify-center text-xs font-bold ring-2 ring-white shadow-sm hover:opacity-95 transition-opacity"
                        aria-label="Technician Account">
                        DK
                    </button>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-[1600px] w-full mx-auto space-y-6">

                <!-- Page Headline with Name Pill (Matching Screenshot) -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex items-center gap-3 flex-wrap">
                        <h1 id="pageHeading" class="text-2xl sm:text-3xl font-extrabold text-[#0F172A] tracking-tight">My Jobs</h1>

                        <!-- Technician Pill (Exact Match to Screenshot) -->
                        <div
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200 shadow-2xs">
                            <span class="w-2 h-2 rounded-full bg-[#F05A28]"></span>
                            <span>Dishan Karunaratne • Technician</span>
                        </div>
                    </div>

                    <!-- Right Quick Actions -->
                    <div class="flex items-center gap-2.5">
                        <button type="button" onclick="openPartsRequisitionModal()"
                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold shadow-2xs transition-colors">
                            <svg class="w-3.5 h-3.5 text-slate-500" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path
                                    d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                </path>
                                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                <line x1="12" y1="22.08" x2="12" y2="12"></line>
                            </svg>
                            <span>Request Parts</span>
                        </button>
                    </div>
                </div>

                <!-- ==================================================== -->
                <!-- 3-COLUMN KANBAN BOARD (MATCHING SCREENSHOT)          -->
                <!-- ==================================================== -->
                <div id="activeBoardSection" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 items-start">

                    <!-- ================================================ -->
                    <!-- COLUMN 1: PENDING (COUNT: 2)                     -->
                    <!-- ================================================ -->
                    <div
                        class="bg-slate-50/80 rounded-2xl border border-slate-200/90 p-4 flex flex-col min-h-[580px] shadow-2xs">

                        <!-- Column Header (Grey Dot + Count) -->
                        <div class="flex items-center justify-between px-1 mb-3.5">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-slate-400"></span>
                                <h3 class="font-bold text-slate-800 text-sm">Pending</h3>
                                <span id="count-pending" class="text-xs font-bold text-slate-500 ml-0.5">2</span>
                            </div>
                        </div>

                        <!-- Drop Zone Body -->
                        <div class="kanban-column-body flex-1 space-y-3 p-1 rounded-xl transition-colors"
                            data-column-id="pending" ondragover="handleDragOver(event)"
                            ondragleave="handleDragLeave(event)" ondrop="handleDrop(event, 'pending')">

                            <!-- CARD 1: WP CAB-7892 (Exact Match to Screenshot) -->
                            <div id="card-cab7892" draggable="true" ondragstart="handleDragStart(event)"
                                ondragend="handleDragEnd(event)"
                                onclick="openJobInspectionModal('WP CAB-7892', 'Front lower control arm bush replacement & re-alignment', 'Nissan Leaf EV 2017', 'Pradeep Kumara', 'pending')"
                                class="kanban-card bg-white rounded-xl border border-slate-200 p-4 shadow-2xs hover:shadow-md transition-all border-l-4 border-l-slate-700 space-y-2.5">

                                <div class="flex items-center justify-between gap-2">
                                    <!-- Black Plate with Orange Dot -->
                                    <span
                                        class="inline-flex items-center gap-1.5 font-mono font-bold text-white text-xs bg-[#0F172A] px-2.5 py-1 rounded tracking-tight shadow-xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#F05A28]"></span>
                                        WP CAB-7892
                                    </span>
                                </div>

                                <p class="text-xs font-medium text-slate-700 leading-relaxed">
                                    Front lower control arm bush replacement & re-alignment
                                </p>
                            </div>

                            <!-- CARD 2: NW WP-9876 (Exact Match to Screenshot) -->
                            <div id="card-wp9876" draggable="true" ondragstart="handleDragStart(event)"
                                ondragend="handleDragEnd(event)"
                                onclick="openJobInspectionModal('NW WP-9876', 'Full hybrid inverter coolant flush & diagnostics', 'Toyota Aqua G 2018', 'Dilshan Fernando', 'pending')"
                                class="kanban-card bg-white rounded-xl border border-slate-200 p-4 shadow-2xs hover:shadow-md transition-all space-y-2.5">

                                <div class="flex items-center justify-between gap-2">
                                    <!-- Black Plate -->
                                    <span
                                        class="inline-flex items-center font-mono font-bold text-white text-xs bg-[#0F172A] px-2.5 py-1 rounded tracking-tight shadow-xs">
                                        NW WP-9876
                                    </span>
                                </div>

                                <p class="text-xs font-medium text-slate-700 leading-relaxed">
                                    Full hybrid inverter coolant flush & diagnostics
                                </p>
                            </div>

                        </div>
                    </div>

                    <!-- ================================================ -->
                    <!-- COLUMN 2: IN PROGRESS (ORANGE BORDER - COUNT: 1) -->
                    <!-- ================================================ -->
                    <div
                        class="bg-orange-50/20 rounded-2xl border-2 border-[#F05A28]/85 p-4 flex flex-col min-h-[580px] shadow-sm">

                        <!-- Column Header (Orange Dot + Count) -->
                        <div class="flex items-center justify-between px-1 mb-3.5">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-[#F05A28]"></span>
                                <h3 class="font-bold text-slate-800 text-sm">In Progress</h3>
                                <span id="count-in-progress" class="text-xs font-bold text-[#F05A28] ml-0.5">1</span>
                            </div>
                        </div>

                        <!-- Drop Zone Body -->
                        <div class="kanban-column-body flex-1 space-y-3 p-1 rounded-xl transition-colors"
                            data-column-id="in-progress" ondragover="handleDragOver(event)"
                            ondragleave="handleDragLeave(event)" ondrop="handleDrop(event, 'in-progress')">

                            <!-- CARD 3: WP CBA-1234 (Exact Match to Screenshot) -->
                            <div id="card-cba1234" draggable="true" ondragstart="handleDragStart(event)"
                                ondragend="handleDragEnd(event)"
                                onclick="openJobInspectionModal('WP CBA-1234', 'Brake pad replacement & rotor refacing (Front axle)', 'Honda Civic RS 2019', 'Sachintha Rajapaksha', 'in-progress')"
                                class="kanban-card bg-white rounded-xl border border-slate-200 p-4 shadow-2xs hover:shadow-md transition-all border-l-4 border-l-[#F05A28] space-y-2.5">

                                <div class="flex items-center justify-between gap-2">
                                    <!-- Black Plate with Orange Dot -->
                                    <span
                                        class="inline-flex items-center gap-1.5 font-mono font-bold text-white text-xs bg-[#0F172A] px-2.5 py-1 rounded tracking-tight shadow-xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#F05A28]"></span>
                                        WP CBA-1234
                                    </span>

                                    <!-- Working Badge (Exact Match to Screenshot) -->
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-orange-100 text-orange-800 border border-orange-200">
                                        <svg class="w-3 h-3 text-[#F05A28]" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.5">
                                            <line x1="4" y1="21" x2="4" y2="14"></line>
                                            <line x1="4" y1="10" x2="4" y2="3"></line>
                                            <line x1="12" y1="21" x2="12" y2="12"></line>
                                            <line x1="12" y1="8" x2="12" y2="3"></line>
                                            <line x1="20" y1="21" x2="20" y2="16"></line>
                                            <line x1="20" y1="12" x2="20" y2="3"></line>
                                            <line x1="1" y1="14" x2="7" y2="14"></line>
                                            <line x1="9" y1="8" x2="15" y2="8"></line>
                                            <line x1="17" y1="16" x2="23" y2="16"></line>
                                        </svg>
                                        Working
                                    </span>
                                </div>

                                <p class="text-xs font-medium text-slate-700 leading-relaxed">
                                    Brake pad replacement & rotor refacing (Front axle)
                                </p>
                            </div>

                        </div>
                    </div>

                    <!-- ================================================ -->
                    <!-- COLUMN 3: READY FOR QA (GREEN BORDER - COUNT: 1) -->
                    <!-- ================================================ -->
                    <div
                        class="bg-emerald-50/20 rounded-2xl border-2 border-emerald-500/85 p-4 flex flex-col min-h-[580px] shadow-sm">

                        <!-- Column Header (Green Dot + Count) -->
                        <div class="flex items-center justify-between px-1 mb-3.5">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                                <h3 class="font-bold text-slate-800 text-sm">Ready for QA</h3>
                                <span id="count-ready-qa" class="text-xs font-bold text-emerald-600 ml-0.5">1</span>
                            </div>
                        </div>

                        <!-- Drop Zone Body -->
                        <div class="kanban-column-body flex-1 space-y-3 p-1 rounded-xl transition-colors"
                            data-column-id="ready-qa" ondragover="handleDragOver(event)"
                            ondragleave="handleDragLeave(event)" ondrop="handleDrop(event, 'ready-qa')">

                            <!-- CARD 4: SP CAA-4819 (Exact Match to Screenshot) -->
                            <div id="card-caa4819" draggable="true" ondragstart="handleDragStart(event)"
                                ondragend="handleDragEnd(event)"
                                onclick="openJobInspectionModal('SP CAA-4819', 'Multi-point safety inspection & synthetic oil service', 'Kia Sportage GT 2020', 'Anushka Wickramasinghe', 'ready-qa')"
                                class="kanban-card bg-white rounded-xl border border-slate-200 p-4 shadow-2xs hover:shadow-md transition-all border-l-4 border-l-emerald-500 space-y-2.5">

                                <div class="flex items-center justify-between gap-2">
                                    <!-- Black Plate -->
                                    <span
                                        class="inline-flex items-center font-mono font-bold text-white text-xs bg-[#0F172A] px-2.5 py-1 rounded tracking-tight shadow-xs">
                                        SP CAA-4819
                                    </span>

                                    <!-- Ready QA Badge (Exact Match to Screenshot) -->
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <svg class="w-3 h-3 text-emerald-600" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.5">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg>
                                        Ready QA
                                    </span>
                                </div>

                                <p class="text-xs font-medium text-slate-700 leading-relaxed">
                                    Multi-point safety inspection & synthetic oil service
                                </p>
                            </div>

                        </div>
                    </div>

                </div>

                <!-- ==================================================== -->
                <!-- COMPLETED JOB HISTORY SECTION (RECENT VEHICLES LOG)  -->
                <!-- ==================================================== -->
                <div id="jobHistorySection" class="hidden space-y-5">

                    <!-- Section Header Bar with Quick Toggle & Prominent Full History Button -->
                    <div
                        class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs p-5 sm:p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2.5 flex-wrap">
                                <h2 class="text-xl font-bold text-[#0F172A] tracking-tight">Recent Vehicles Serviced</h2>
                                <span
                                    class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    6 Completed Vehicles
                                </span>
                            </div>
                            <p class="text-xs text-slate-500">
                                Table log of recently serviced vehicles by Dishan Karunaratne. <span class="text-slate-800 font-semibold underline decoration-orange-300">Click any vehicle row</span> to inspect its official Job Card.
                            </p>
                        </div>

                        <!-- Top Action Buttons -->
                        <div class="flex items-center gap-2.5 flex-wrap">
                            <button type="button" onclick="toggleJobHistoryView()"
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="15 18 9 12 15 6"></polyline>
                                </svg>
                                <span>Return to Board</span>
                            </button>

                            <!-- Prominent Additional Button to View Full History -> All Vehicles List -->
                            <a href="/technician/job-history"
                                class="inline-flex items-center gap-2 px-4 py-2 text-xs font-bold rounded-xl bg-[#F05A28] hover:bg-[#D94819] text-white shadow-sm shadow-orange-500/25 transition-all transform hover:translate-y-[-1px]">
                                <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                    <rect x="3" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="14" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect>
                                </svg>
                                <span>View Full History (All Vehicles)</span>
                                <svg class="w-3.5 h-3.5 text-white/90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M5 12h14M12 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Filter Search Bar -->
                    <div class="bg-white rounded-xl border border-slate-200/90 shadow-2xs p-3.5">
                        <div class="relative w-full max-w-md">
                            <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <input type="text" id="recentVehicleSearch" oninput="filterRecentVehiclesTable()"
                                placeholder="Filter recent vehicles by plate, model, customer..."
                                class="w-full pl-9 pr-4 py-2 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-1 focus:ring-[#F05A28] focus:border-[#F05A28] outline-none transition-all">
                        </div>
                    </div>

                    <!-- Recent Vehicles Table Log -->
                    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs">
                                <thead
                                    class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200 select-none">
                                    <tr>
                                        <th class="py-3.5 px-4">VEHICLE & PLATE</th>
                                        <th class="py-3.5 px-4">CUSTOMER</th>
                                        <th class="py-3.5 px-4">WORK SCOPE / REPAIR</th>
                                        <th class="py-3.5 px-4">BAY TIME</th>
                                        <th class="py-3.5 px-4">QA SIGN OFF</th>
                                        <th class="py-3.5 px-4">STATUS</th>
                                        <th class="py-3.5 px-4 text-right">JOB CARD</th>
                                    </tr>
                                </thead>
                                <tbody id="recentVehiclesTableBody" class="divide-y divide-slate-100 font-medium">

                                    <!-- VEHICLE 1: WP CBJ-5049 -->
                                    <tr onclick="openCompletedJobCard('JC-2026-0941')"
                                        class="recent-vehicle-row hover:bg-orange-50/40 cursor-pointer transition-colors group">
                                        <td class="py-3.5 px-4">
                                            <div class="flex items-center gap-2.5">
                                                <span
                                                    class="inline-flex items-center gap-1.5 font-mono font-bold text-white text-xs bg-[#0F172A] px-2.5 py-1 rounded tracking-tight shadow-2xs group-hover:ring-1 group-hover:ring-[#F05A28] transition-all">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-[#F05A28]"></span>
                                                    WP CBJ-5049
                                                </span>
                                                <div class="flex flex-col min-w-0">
                                                    <span class="font-bold text-slate-900 group-hover:text-[#F05A28] transition-colors truncate">Toyota Land Cruiser Prado TX-L</span>
                                                    <span class="text-[11px] text-slate-400">2020 • 2.7L Dual VVT-i</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="flex flex-col">
                                                <span class="font-bold text-slate-800">Dr. Nalaka Jayasuriya</span>
                                                <span class="text-[11px] text-slate-400">+94 77 123 4567</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 max-w-xs">
                                            <p class="text-slate-700 truncate" title="Front brake disc resurfacing & Ferodo ceramic pad replacement">
                                                Front brake disc resurfacing & Ferodo pad install
                                            </p>
                                            <span class="text-[10px] text-slate-400">Brake & Chassis</span>
                                        </td>
                                        <td class="py-3.5 px-4 whitespace-nowrap">
                                            <div class="flex flex-col">
                                                <span class="font-bold text-slate-800">1h 45m</span>
                                                <span class="text-[10px] text-slate-400">Today, 14:15</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 whitespace-nowrap">
                                            <div class="flex items-center gap-1.5 text-emerald-700">
                                                <svg class="w-3.5 h-3.5 text-emerald-600 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg>
                                                <span class="font-semibold text-xs">Passed (M. Seneviratne)</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 whitespace-nowrap">
                                            <span
                                                class="px-2.5 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                Delivered
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 group-hover:bg-[#F05A28] text-slate-700 group-hover:text-white transition-all shadow-2xs">
                                                <span>View Card</span>
                                                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                                    <polyline points="15 3 21 3 21 9"></polyline>
                                                    <line x1="10" y1="14" x2="21" y2="3"></line>
                                                </svg>
                                            </span>
                                        </td>
                                    </tr>

                                    <!-- VEHICLE 2: WP KX-3108 -->
                                    <tr onclick="openCompletedJobCard('JC-2026-0938')"
                                        class="recent-vehicle-row hover:bg-orange-50/40 cursor-pointer transition-colors group">
                                        <td class="py-3.5 px-4">
                                            <div class="flex items-center gap-2.5">
                                                <span
                                                    class="inline-flex items-center gap-1.5 font-mono font-bold text-white text-xs bg-[#0F172A] px-2.5 py-1 rounded tracking-tight shadow-2xs group-hover:ring-1 group-hover:ring-[#F05A28] transition-all">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-[#F05A28]"></span>
                                                    WP KX-3108
                                                </span>
                                                <div class="flex flex-col min-w-0">
                                                    <span class="font-bold text-slate-900 group-hover:text-[#F05A28] transition-colors truncate">Toyota Hilux Revo 2.8D</span>
                                                    <span class="text-[11px] text-slate-400">2019 • 4x4 Automatic</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="flex flex-col">
                                                <span class="font-bold text-slate-800">Rohan Wickramasinghe</span>
                                                <span class="text-[11px] text-slate-400">+94 71 889 2311</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 max-w-xs">
                                            <p class="text-slate-700 truncate" title="40,000 km Major Service: Differential fluids & Fuel filter">
                                                40k Drivetrain service, diff fluid & fuel filter
                                            </p>
                                            <span class="text-[10px] text-slate-400">Major Periodic Service</span>
                                        </td>
                                        <td class="py-3.5 px-4 whitespace-nowrap">
                                            <div class="flex flex-col">
                                                <span class="font-bold text-slate-800">2h 20m</span>
                                                <span class="text-[10px] text-slate-400">Yesterday, 16:40</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 whitespace-nowrap">
                                            <div class="flex items-center gap-1.5 text-emerald-700">
                                                <svg class="w-3.5 h-3.5 text-emerald-600 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg>
                                                <span class="font-semibold text-xs">Passed (K. Ranasinghe)</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 whitespace-nowrap">
                                            <span
                                                class="px-2.5 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                Delivered
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 group-hover:bg-[#F05A28] text-slate-700 group-hover:text-white transition-all shadow-2xs">
                                                <span>View Card</span>
                                                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                                    <polyline points="15 3 21 3 21 9"></polyline>
                                                    <line x1="10" y1="14" x2="21" y2="3"></line>
                                                </svg>
                                            </span>
                                        </td>
                                    </tr>

                                    <!-- VEHICLE 3: WP CAG-9912 -->
                                    <tr onclick="openCompletedJobCard('JC-2026-0932')"
                                        class="recent-vehicle-row hover:bg-orange-50/40 cursor-pointer transition-colors group">
                                        <td class="py-3.5 px-4">
                                            <div class="flex items-center gap-2.5">
                                                <span
                                                    class="inline-flex items-center gap-1.5 font-mono font-bold text-white text-xs bg-[#0F172A] px-2.5 py-1 rounded tracking-tight shadow-2xs group-hover:ring-1 group-hover:ring-[#F05A28] transition-all">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-[#F05A28]"></span>
                                                    WP CAG-9912
                                                </span>
                                                <div class="flex flex-col min-w-0">
                                                    <span class="font-bold text-slate-900 group-hover:text-[#F05A28] transition-colors truncate">Honda Vezel e:HEV RS</span>
                                                    <span class="text-[11px] text-slate-400">2021 • i-DCD Hybrid</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="flex flex-col">
                                                <span class="font-bold text-slate-800">Dinithi Gunasekera</span>
                                                <span class="text-[11px] text-slate-400">+94 76 450 1199</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 max-w-xs">
                                            <p class="text-slate-700 truncate" title="Dual-clutch actuator fluid replacement & Honda i-DCD clutch adaptation">
                                                Dual-clutch actuator fluid flush & clutch adaptation
                                            </p>
                                            <span class="text-[10px] text-slate-400">Hybrid / EV Driveline</span>
                                        </td>
                                        <td class="py-3.5 px-4 whitespace-nowrap">
                                            <div class="flex flex-col">
                                                <span class="font-bold text-slate-800">1h 55m</span>
                                                <span class="text-[10px] text-slate-400">Yesterday, 11:30</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 whitespace-nowrap">
                                            <div class="flex items-center gap-1.5 text-emerald-700">
                                                <svg class="w-3.5 h-3.5 text-emerald-600 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg>
                                                <span class="font-semibold text-xs">Passed (M. Seneviratne)</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 whitespace-nowrap">
                                            <span
                                                class="px-2.5 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                Handed Over
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 group-hover:bg-[#F05A28] text-slate-700 group-hover:text-white transition-all shadow-2xs">
                                                <span>View Card</span>
                                                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                                    <polyline points="15 3 21 3 21 9"></polyline>
                                                    <line x1="10" y1="14" x2="21" y2="3"></line>
                                                </svg>
                                            </span>
                                        </td>
                                    </tr>

                                    <!-- VEHICLE 4: NW WP-9871 -->
                                    <tr onclick="openCompletedJobCard('JC-2026-0925')"
                                        class="recent-vehicle-row hover:bg-orange-50/40 cursor-pointer transition-colors group">
                                        <td class="py-3.5 px-4">
                                            <div class="flex items-center gap-2.5">
                                                <span
                                                    class="inline-flex items-center gap-1.5 font-mono font-bold text-white text-xs bg-[#0F172A] px-2.5 py-1 rounded tracking-tight shadow-2xs group-hover:ring-1 group-hover:ring-[#F05A28] transition-all">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-[#F05A28]"></span>
                                                    NW WP-9871
                                                </span>
                                                <div class="flex flex-col min-w-0">
                                                    <span class="font-bold text-slate-900 group-hover:text-[#F05A28] transition-colors truncate">Mitsubishi Montero Sport</span>
                                                    <span class="text-[11px] text-slate-400">2018 • 3.2 DiD 4WD</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="flex flex-col">
                                                <span class="font-bold text-slate-800">Sanath Dissanayake</span>
                                                <span class="text-[11px] text-slate-400">+94 77 334 8920</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 max-w-xs">
                                            <p class="text-slate-700 truncate" title="Automatic transmission flush & valve body solenoid inspection">
                                                ATF complete flush, pan filter & solenoid inspection
                                            </p>
                                            <span class="text-[10px] text-slate-400">Transmission & Drivetrain</span>
                                        </td>
                                        <td class="py-3.5 px-4 whitespace-nowrap">
                                            <div class="flex flex-col">
                                                <span class="font-bold text-slate-800">3h 10m</span>
                                                <span class="text-[10px] text-slate-400">24 Sep, 15:10</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 whitespace-nowrap">
                                            <div class="flex items-center gap-1.5 text-emerald-700">
                                                <svg class="w-3.5 h-3.5 text-emerald-600 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg>
                                                <span class="font-semibold text-xs">Passed (S. Perera)</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 whitespace-nowrap">
                                            <span
                                                class="px-2.5 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                Delivered
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 group-hover:bg-[#F05A28] text-slate-700 group-hover:text-white transition-all shadow-2xs">
                                                <span>View Card</span>
                                                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                                    <polyline points="15 3 21 3 21 9"></polyline>
                                                    <line x1="10" y1="14" x2="21" y2="3"></line>
                                                </svg>
                                            </span>
                                        </td>
                                    </tr>

                                    <!-- VEHICLE 5: WP CAD-5521 -->
                                    <tr onclick="openCompletedJobCard('JC-2026-0919')"
                                        class="recent-vehicle-row hover:bg-orange-50/40 cursor-pointer transition-colors group">
                                        <td class="py-3.5 px-4">
                                            <div class="flex items-center gap-2.5">
                                                <span
                                                    class="inline-flex items-center gap-1.5 font-mono font-bold text-white text-xs bg-[#0F172A] px-2.5 py-1 rounded tracking-tight shadow-2xs group-hover:ring-1 group-hover:ring-[#F05A28] transition-all">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-[#F05A28]"></span>
                                                    WP CAD-5521
                                                </span>
                                                <div class="flex flex-col min-w-0">
                                                    <span class="font-bold text-slate-900 group-hover:text-[#F05A28] transition-colors truncate">Suzuki Swift RS Turbo</span>
                                                    <span class="text-[11px] text-slate-400">2022 • Boosterjet 1.0T</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="flex flex-col">
                                                <span class="font-bold text-slate-800">Kasun Weerakkody</span>
                                                <span class="text-[11px] text-slate-400">+94 70 223 9988</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 max-w-xs">
                                            <p class="text-slate-700 truncate" title="Lower control arm bush replacement & Hunter laser alignment">
                                                Control arm bushes, stabilizer links & alignment
                                            </p>
                                            <span class="text-[10px] text-slate-400">Steering & Suspension</span>
                                        </td>
                                        <td class="py-3.5 px-4 whitespace-nowrap">
                                            <div class="flex flex-col">
                                                <span class="font-bold text-slate-800">2h 05m</span>
                                                <span class="text-[10px] text-slate-400">23 Sep, 17:00</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 whitespace-nowrap">
                                            <div class="flex items-center gap-1.5 text-emerald-700">
                                                <svg class="w-3.5 h-3.5 text-emerald-600 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg>
                                                <span class="font-semibold text-xs">Passed (K. Ranasinghe)</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 whitespace-nowrap">
                                            <span
                                                class="px-2.5 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                Delivered
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 group-hover:bg-[#F05A28] text-slate-700 group-hover:text-white transition-all shadow-2xs">
                                                <span>View Card</span>
                                                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                                    <polyline points="15 3 21 3 21 9"></polyline>
                                                    <line x1="10" y1="14" x2="21" y2="3"></line>
                                                </svg>
                                            </span>
                                        </td>
                                    </tr>

                                    <!-- VEHICLE 6: SP CAA-3319 -->
                                    <tr onclick="openCompletedJobCard('JC-2026-0914')"
                                        class="recent-vehicle-row hover:bg-orange-50/40 cursor-pointer transition-colors group">
                                        <td class="py-3.5 px-4">
                                            <div class="flex items-center gap-2.5">
                                                <span
                                                    class="inline-flex items-center gap-1.5 font-mono font-bold text-white text-xs bg-[#0F172A] px-2.5 py-1 rounded tracking-tight shadow-2xs group-hover:ring-1 group-hover:ring-[#F05A28] transition-all">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-[#F05A28]"></span>
                                                    SP CAA-3319
                                                </span>
                                                <div class="flex flex-col min-w-0">
                                                    <span class="font-bold text-slate-900 group-hover:text-[#F05A28] transition-colors truncate">Mercedes-Benz C200 AMG</span>
                                                    <span class="text-[11px] text-slate-400">2017 • 9G-Tronic W205</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="flex flex-col">
                                                <span class="font-bold text-slate-800">Chaminda Alahakoon</span>
                                                <span class="text-[11px] text-slate-400">+94 77 665 4411</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 max-w-xs">
                                            <p class="text-slate-700 truncate" title="Auxiliary backup battery replacement & Star diagnostic fault clear">
                                                Aux battery replacement & Xentry Star coding
                                            </p>
                                            <span class="text-[10px] text-slate-400">Electrical & Diagnostics</span>
                                        </td>
                                        <td class="py-3.5 px-4 whitespace-nowrap">
                                            <div class="flex flex-col">
                                                <span class="font-bold text-slate-800">1h 15m</span>
                                                <span class="text-[10px] text-slate-400">22 Sep, 14:20</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 whitespace-nowrap">
                                            <div class="flex items-center gap-1.5 text-emerald-700">
                                                <svg class="w-3.5 h-3.5 text-emerald-600 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg>
                                                <span class="font-semibold text-xs">Passed (M. Seneviratne)</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 whitespace-nowrap">
                                            <span
                                                class="px-2.5 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                Delivered
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 group-hover:bg-[#F05A28] text-slate-700 group-hover:text-white transition-all shadow-2xs">
                                                <span>View Card</span>
                                                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                                    <polyline points="15 3 21 3 21 9"></polyline>
                                                    <line x1="10" y1="14" x2="21" y2="3"></line>
                                                </svg>
                                            </span>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Wide Additional CTA Card for Full History -->
                    <div
                        class="bg-gradient-to-r from-[#0F172A] via-slate-900 to-slate-800 rounded-2xl p-5 sm:p-6 text-white shadow-md flex flex-col md:flex-row items-center justify-between gap-5 border border-slate-700">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-[#F05A28]/20 border border-[#F05A28]/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-[#F05A28]" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M12 8v4l3 3"></path>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-sm sm:text-base text-white">Need vehicle records from past weeks or all historical fleet data?</h3>
                                <p class="text-xs text-slate-300 mt-0.5">Access the complete archive of all 48 vehicles serviced by Dishan Karunaratne with advanced multi-filter and job card lookups.</p>
                            </div>
                        </div>

                        <a href="/technician/job-history"
                            class="flex-shrink-0 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#F05A28] hover:bg-[#D94819] text-white font-bold text-xs shadow-md shadow-orange-500/25 transition-all transform hover:scale-[1.02]">
                            <span>Explore Full History (All Vehicles)</span>
                            <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </a>
                    </div>

                </div>

            </main>

        </div>

    </div>

    <!-- ======================================================== -->
    <!-- 3. MODAL: JOB INSPECTION, TASKS & PROGRESSION DRAWER     -->
    <!-- ======================================================== -->
    <div id="jobInspectionModal"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden"
        role="dialog" aria-modal="true">
        <div
            class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-xl overflow-hidden transform transition-all">

            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/70">
                <div class="flex items-center gap-3">
                    <span id="modalPlateBadge"
                        class="font-mono font-bold text-white text-xs bg-[#0F172A] px-3 py-1 rounded shadow-xs tracking-tight">
                        WP CBA-1234
                    </span>
                    <span id="modalStageBadge"
                        class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-orange-100 text-orange-800 border border-orange-200">
                        In Progress
                    </span>
                </div>
                <button type="button" onclick="closeJobInspectionModal()"
                    class="text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-4 text-xs text-slate-600 max-h-[75vh] overflow-y-auto">

                <!-- Vehicle & Customer Quick Details -->
                <div class="grid grid-cols-2 gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                    <div>
                        <span class="block text-[10px] font-bold text-slate-400 uppercase">Vehicle Model</span>
                        <span id="modalVehicleModel" class="font-bold text-slate-800 text-xs">Honda Civic RS 2019</span>
                    </div>
                    <div>
                        <span class="block text-[10px] font-bold text-slate-400 uppercase">Customer</span>
                        <span id="modalCustomerName" class="font-bold text-slate-800 text-xs">Sachintha
                            Rajapaksha</span>
                    </div>
                </div>

                <!-- Scope of Work Description -->
                <div>
                    <span class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Assigned
                        Scope of Work</span>
                    <p id="modalScopeText"
                        class="text-slate-700 bg-white p-3 rounded-lg border border-slate-200 leading-relaxed font-medium">
                        Brake pad replacement & rotor refacing (Front axle)
                    </p>
                </div>

                <!-- Step Checklist -->
                <div>
                    <span class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-2">Technician
                        Execution Checklist</span>
                    <div class="space-y-2 bg-slate-50/80 p-3 rounded-xl border border-slate-100">
                        <label class="flex items-center gap-2.5 cursor-pointer">
                            <input type="checkbox" checked
                                class="w-4 h-4 text-[#F05A28] rounded border-slate-300 focus:ring-[#F05A28]">
                            <span class="text-slate-800 font-medium">Vehicle lifted & wheels dismounted safely</span>
                        </label>
                        <label class="flex items-center gap-2.5 cursor-pointer">
                            <input type="checkbox" checked
                                class="w-4 h-4 text-[#F05A28] rounded border-slate-300 focus:ring-[#F05A28]">
                            <span class="text-slate-800 font-medium">Front brake calipers & pad thickness
                                inspected</span>
                        </label>
                        <label class="flex items-center gap-2.5 cursor-pointer">
                            <input type="checkbox"
                                class="w-4 h-4 text-[#F05A28] rounded border-slate-300 focus:ring-[#F05A28]">
                            <span class="text-slate-800 font-medium">Disc rotors skimmed & re-measured to spec (min
                                22mm)</span>
                        </label>
                        <label class="flex items-center gap-2.5 cursor-pointer">
                            <input type="checkbox"
                                class="w-4 h-4 text-[#F05A28] rounded border-slate-300 focus:ring-[#F05A28]">
                            <span class="text-slate-800 font-medium">Torque wheel nuts to manufacturer 108 Nm</span>
                        </label>
                    </div>
                </div>

                <!-- Floor Notes -->
                <div>
                    <label for="technicianNotesInput"
                        class="block font-bold text-slate-700 uppercase text-[11px] mb-1">Bay Notes &
                        Observations</label>
                    <textarea id="technicianNotesInput" rows="2"
                        placeholder="Record torque specs, fluid levels, or defects found during inspection..."
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:ring-1 focus:ring-[#F05A28] focus:border-[#F05A28] outline-none text-slate-800"></textarea>
                </div>

                <!-- Direct Stage Movement Options for Technician -->
                <div class="pt-2 border-t border-slate-100">
                    <span class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Advance Job
                        Stage</span>
                    <div id="modalStageActions" class="grid grid-cols-2 gap-2.5">
                        <!-- Populated dynamically -->
                    </div>
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="p-4 border-t border-slate-100 bg-slate-50/70 flex items-center justify-end gap-2.5">
                <button type="button" onclick="closeJobInspectionModal()"
                    class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-100 font-medium">
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- COMPLETED VEHICLE JOB CARD / SERVICE SUMMARY MODAL       -->
    <!-- ======================================================== -->
    <div id="completedJobCardModal"
        class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-slate-900/70 backdrop-blur-sm hidden"
        role="dialog" aria-modal="true">
        <div
            class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-4xl overflow-hidden transform transition-all flex flex-col max-h-[92vh]">

            <!-- Modal Header (Dark Workshop Navy) -->
            <div class="px-6 py-4 bg-[#0F172A] text-white flex items-center justify-between border-b border-slate-800 flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-[#F05A28] flex items-center justify-center shadow-md shadow-orange-500/20">
                        <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold uppercase tracking-widest text-[#F05A28]">VWMS OFFICIAL SERVICE LOG</span>
                            <span class="text-slate-400 text-xs">•</span>
                            <span id="jcCardNumber" class="font-mono text-xs font-bold text-slate-300">JC-2026-0941</span>
                        </div>
                        <h2 class="text-base sm:text-lg font-extrabold text-white tracking-tight">Completed Vehicle Job Card</h2>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button type="button" onclick="printJobCard()"
                        class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold border border-slate-700 transition-colors">
                        <svg class="w-3.5 h-3.5 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 6 2 18 2 18 9"></polyline>
                            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                            <rect x="6" y="14" width="12" height="8"></rect>
                        </svg>
                        <span>Print Job Card</span>
                    </button>
                    <button type="button" onclick="closeCompletedJobCard()"
                        class="text-slate-400 hover:text-white p-1.5 rounded-lg hover:bg-slate-800 transition-colors" aria-label="Close modal">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Job Card Content Body (Scrollable) -->
            <div id="jobCardPrintArea" class="p-5 sm:p-6 space-y-5 text-xs text-slate-700 overflow-y-auto flex-1">

                <!-- Meta Ribbon -->
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-3.5 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <span id="jcPlateBadge"
                            class="inline-flex items-center gap-1.5 font-mono font-bold text-white text-xs bg-[#0F172A] px-3 py-1.5 rounded shadow-xs tracking-tight">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#F05A28]"></span>
                            WP CBJ-5049
                        </span>
                        <span id="jcStatusBadge"
                            class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            Delivered & Closed
                        </span>
                        <span id="jcQaBadge"
                            class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-blue-50 text-blue-800 border border-blue-200 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                            QA Verified (100% Passed)
                        </span>
                    </div>

                    <div class="flex items-center gap-4 text-xs text-slate-500">
                        <div>
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Completed On</span>
                            <span id="jcCompletedDate" class="font-bold text-slate-800">26 Sep 2026, 14:15</span>
                        </div>
                        <div class="border-l border-slate-200 pl-4">
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Bay Elapsed Time</span>
                            <span id="jcBayTime" class="font-bold text-slate-800">1h 45m</span>
                        </div>
                    </div>
                </div>

                <!-- 2-Column Specs: Vehicle Information & Customer/Staff -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- Vehicle Specification Card -->
                    <div class="bg-white rounded-xl border border-slate-200 p-4 space-y-2.5 shadow-2xs">
                        <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                            <span class="text-[11px] font-bold text-slate-900 uppercase tracking-wider flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-[#F05A28]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="1" y="3" width="15" height="13"></rect>
                                    <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                    <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                    <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                </svg>
                                Vehicle Information
                            </span>
                            <span id="jcEngine" class="text-[10px] font-semibold text-slate-500 bg-slate-100 px-2 py-0.5 rounded">2.7L Petrol</span>
                        </div>

                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div>
                                <span class="block text-[10px] font-bold text-slate-400 uppercase">Make & Model</span>
                                <span id="jcVehicleModel" class="font-bold text-slate-800">Toyota Land Cruiser Prado TX-L 2020</span>
                            </div>
                            <div>
                                <span class="block text-[10px] font-bold text-slate-400 uppercase">Chassis / VIN</span>
                                <span id="jcVin" class="font-mono text-slate-800 font-semibold">TRJ150-0084921</span>
                            </div>
                            <div>
                                <span class="block text-[10px] font-bold text-slate-400 uppercase">Mileage / Odometer</span>
                                <span id="jcMileage" class="font-bold text-slate-800">58,420 km</span>
                            </div>
                            <div>
                                <span class="block text-[10px] font-bold text-slate-400 uppercase">Service Category</span>
                                <span id="jcCategory" class="font-bold text-[#F05A28]">Brake & Chassis</span>
                            </div>
                        </div>
                    </div>

                    <!-- Customer & Workshop Assignment Card -->
                    <div class="bg-white rounded-xl border border-slate-200 p-4 space-y-2.5 shadow-2xs">
                        <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                            <span class="text-[11px] font-bold text-slate-900 uppercase tracking-wider flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-[#F05A28]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                Customer & Personnel
                            </span>
                            <span id="jcBay" class="text-[10px] font-bold text-slate-700 bg-orange-50 border border-orange-200 px-2 py-0.5 rounded">Bay 03</span>
                        </div>

                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div>
                                <span class="block text-[10px] font-bold text-slate-400 uppercase">Customer Name</span>
                                <span id="jcCustomerName" class="font-bold text-slate-800">Dr. Nalaka Jayasuriya</span>
                            </div>
                            <div>
                                <span class="block text-[10px] font-bold text-slate-400 uppercase">Contact Number</span>
                                <span id="jcCustomerPhone" class="font-semibold text-slate-800">+94 77 123 4567</span>
                            </div>
                            <div>
                                <span class="block text-[10px] font-bold text-slate-400 uppercase">Service Advisor</span>
                                <span id="jcAdvisor" class="font-semibold text-slate-800">Malik Alwis (Front Desk)</span>
                            </div>
                            <div>
                                <span class="block text-[10px] font-bold text-slate-400 uppercase">Lead Technician</span>
                                <span id="jcTechnician" class="font-bold text-slate-900 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#F05A28]"></span>
                                    Dishan Karunaratne (TK-402)
                                </span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Customer Concern & Diagnostics -->
                <div class="bg-amber-50/50 border border-amber-200/80 rounded-xl p-4 space-y-2">
                    <div>
                        <span class="text-[10px] font-bold text-amber-800 uppercase tracking-wider block">Customer Reported Issue / Symptom</span>
                        <p id="jcConcern" class="text-xs text-slate-800 font-medium mt-0.5">
                            Customer reported front wheel brake squeal at low speeds and steering vibration during hard braking above 60 km/h.
                        </p>
                    </div>
                    <div class="pt-2 border-t border-amber-200/60">
                        <span class="text-[10px] font-bold text-slate-600 uppercase tracking-wider block">Technical Diagnostic Findings</span>
                        <p id="jcDiagnostics" class="text-xs text-slate-700 mt-0.5">
                            Front brake rotor runout exceeded 0.08mm causing pulsation. Inner brake pads worn to 3.2mm (replacement threshold 3.0mm). Caliper slide pins dry.
                        </p>
                    </div>
                </div>

                <!-- Completed Work Checklist -->
                <div>
                    <span class="block text-[11px] font-bold text-slate-800 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="9 11 12 14 22 4"></polyline>
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                        </svg>
                        Service Operations & Technical Steps Completed
                    </span>
                    <div id="jcChecklistContainer" class="space-y-1.5 bg-slate-50 border border-slate-200 rounded-xl p-3">
                        <!-- Injected dynamically -->
                    </div>
                </div>

                <!-- Requisitioned Parts & Consumables Log -->
                <div>
                    <span class="block text-[11px] font-bold text-slate-800 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-[#F05A28]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                        </svg>
                        Parts & Consumables Replaced from Inventory
                    </span>
                    <div class="overflow-hidden border border-slate-200 rounded-xl bg-white">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[9px] tracking-wider border-b border-slate-200">
                                <tr>
                                    <th class="py-2.5 px-3">PART #</th>
                                    <th class="py-2.5 px-3">DESCRIPTION</th>
                                    <th class="py-2.5 px-3">QTY</th>
                                    <th class="py-2.5 px-3 text-right">UNIT PRICE</th>
                                </tr>
                            </thead>
                            <tbody id="jcPartsTableBody" class="divide-y divide-slate-100 font-medium">
                                <!-- Injected dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Technician Notes & QA Sign-Off Seal -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2">
                    <div class="md:col-span-2 bg-slate-50 border border-slate-200 rounded-xl p-3.5 space-y-1.5">
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Lead Technician Bay Observations</span>
                        <p id="jcTechNotes" class="text-xs text-slate-700 italic">
                            Rotors resurfaced within safety limits. Caliper pistons retracted smoothly with no seal degradation. Anti-seize compound applied to wheel hub mounting faces.
                        </p>
                    </div>

                    <!-- Official QA Certification Stamp -->
                    <div class="bg-emerald-50/60 border-2 border-dashed border-emerald-300 rounded-xl p-3 flex flex-col justify-between text-center">
                        <div class="flex items-center justify-center gap-1 text-emerald-800 font-extrabold text-[11px] uppercase tracking-wider">
                            <svg class="w-4 h-4 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                            <span>QA Sign-off Approved</span>
                        </div>
                        <div class="my-1.5">
                            <span class="text-[10px] text-slate-500 block">Inspected by:</span>
                            <span id="jcQaInspector" class="font-bold text-xs text-slate-900 block">M. Seneviratne</span>
                            <span class="text-[9px] font-semibold text-emerald-700 uppercase">Bay 03 Inspection Pass 100%</span>
                        </div>
                        <span class="text-[9px] text-slate-400 font-mono">VWMS-CERT-APPROVED</span>
                    </div>
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="p-4 border-t border-slate-100 bg-slate-50/80 flex items-center justify-between gap-3 flex-shrink-0">
                <span class="text-[11px] text-slate-400 hidden sm:inline">
                    VWMS Workshop Operating System • Dishan Karunaratne Workstation
                </span>

                <div class="flex items-center gap-2.5 ml-auto">
                    <button type="button" onclick="printJobCard()"
                        class="px-4 py-2 rounded-xl border border-slate-200 bg-white hover:bg-slate-100 text-slate-700 font-bold text-xs flex items-center gap-1.5 transition-colors shadow-2xs">
                        <svg class="w-3.5 h-3.5 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 6 2 18 2 18 9"></polyline>
                            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                            <rect x="6" y="14" width="12" height="8"></rect>
                        </svg>
                        <span>Print Job Card</span>
                    </button>
                    <button type="button" onclick="closeCompletedJobCard()"
                        class="px-5 py-2 rounded-xl bg-[#0F172A] hover:bg-slate-800 text-white font-bold text-xs transition-colors shadow-xs">
                        Close
                    </button>
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
    <!-- 4. CLIENT JAVASCRIPT & DRAG ENGINE                       -->
    <!-- ======================================================== -->
    <script>
        const TECH_COLUMN_CONFIG = {
            'pending': {
                name: 'Pending',
                dotClass: 'bg-slate-400',
                badgeText: 'Pending',
                badgeClass: 'bg-slate-100 text-slate-700 border-slate-200'
            },
            'in-progress': {
                name: 'In Progress',
                dotClass: 'bg-[#F05A28]',
                badgeText: 'Working',
                badgeClass: 'bg-orange-100 text-orange-800 border-orange-200'
            },
            'ready-qa': {
                name: 'Ready for QA',
                dotClass: 'bg-emerald-500',
                badgeText: 'Ready QA',
                badgeClass: 'bg-emerald-50 text-emerald-700 border-emerald-200'
            }
        };

        let draggedCard = null;
        let selectedPlate = null;

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

        // Drag start
        function handleDragStart(e) {
            draggedCard = e.currentTarget;
            e.dataTransfer.setData('text/plain', draggedCard.id);
            e.dataTransfer.effectAllowed = 'move';
            setTimeout(() => {
                draggedCard.classList.add('is-dragging');
            }, 0);
        }

        // Drag end
        function handleDragEnd(e) {
            if (draggedCard) {
                draggedCard.classList.remove('is-dragging');
            }
            document.querySelectorAll('.kanban-column-body').forEach(col => {
                col.classList.remove('drag-over');
            });
            draggedCard = null;
        }

        // Drag over column
        function handleDragOver(e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            const col = e.currentTarget;
            col.classList.add('drag-over');
        }

        // Drag leave column
        function handleDragLeave(e) {
            const col = e.currentTarget;
            col.classList.remove('drag-over');
        }

        // Drop on column
        function handleDrop(e, targetColumnId) {
            e.preventDefault();
            const col = e.currentTarget;
            col.classList.remove('drag-over');

            const cardId = e.dataTransfer.getData('text/plain');
            const card = document.getElementById(cardId) || draggedCard;

            if (card && col) {
                col.appendChild(card);
                updateCardVisuals(card, targetColumnId);
                updateColumnCounters();
                const plate = card.querySelector('.font-mono')?.textContent?.trim() || 'Vehicle';
                showToast(`${plate} moved to ${TECH_COLUMN_CONFIG[targetColumnId]?.name}`);
            }
        }

        // Update visuals on move
        function updateCardVisuals(card, columnId) {
            // Update left accent line
            card.classList.remove('border-l-4', 'border-l-slate-700', 'border-l-[#F05A28]', 'border-l-emerald-500');

            const headerRow = card.querySelector('div');

            if (columnId === 'pending') {
                card.classList.add('border-l-4', 'border-l-slate-700');
                // Remove working/ready tag if present
                const tag = headerRow.querySelector('span:nth-child(2)');
                if (tag) tag.remove();
            } else if (columnId === 'in-progress') {
                card.classList.add('border-l-4', 'border-l-[#F05A28]');
                // Add Working tag if missing
                let tag = headerRow.querySelector('span:nth-child(2)');
                if (!tag) {
                    tag = document.createElement('span');
                    headerRow.appendChild(tag);
                }
                tag.className = 'inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-orange-100 text-orange-800 border border-orange-200';
                tag.innerHTML = `
                    <svg class="w-3 h-3 text-[#F05A28]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="4" y1="21" x2="4" y2="14"></line>
                        <line x1="4" y1="10" x2="4" y2="3"></line>
                        <line x1="12" y1="21" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12" y2="3"></line>
                        <line x1="20" y1="21" x2="20" y2="16"></line>
                        <line x1="20" y1="12" x2="20" y2="3"></line>
                    </svg>
                    Working
                `;
            } else if (columnId === 'ready-qa') {
                card.classList.add('border-l-4', 'border-l-emerald-500');
                let tag = headerRow.querySelector('span:nth-child(2)');
                if (!tag) {
                    tag = document.createElement('span');
                    headerRow.appendChild(tag);
                }
                tag.className = 'inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200';
                tag.innerHTML = `
                    <svg class="w-3 h-3 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="m9 12 2 2 4-4"></path>
                    </svg>
                    Ready QA
                `;
            }
        }

        // Update counters
        function updateColumnCounters() {
            Object.keys(TECH_COLUMN_CONFIG).forEach(colId => {
                const col = document.querySelector(`.kanban-column-body[data-column-id="${colId}"]`);
                const badge = document.getElementById(`count-${colId}`);
                if (col && badge) {
                    badge.textContent = col.querySelectorAll('.kanban-card').length;
                }
            });
        }

        // Open Job Inspection & Action Modal
        function openJobInspectionModal(plate, scope, model, customer, colId) {
            selectedPlate = plate;
            const modal = document.getElementById('jobInspectionModal');
            document.getElementById('modalPlateBadge').textContent = plate;
            document.getElementById('modalVehicleModel').textContent = model;
            document.getElementById('modalCustomerName').textContent = customer;
            document.getElementById('modalScopeText').textContent = scope;

            // Find current column
            let currentCol = colId;
            const allCards = document.querySelectorAll('.kanban-card');
            allCards.forEach(c => {
                if (c.innerText.includes(plate)) {
                    currentCol = c.closest('.kanban-column-body')?.getAttribute('data-column-id') || colId;
                }
            });

            const config = TECH_COLUMN_CONFIG[currentCol];
            const badge = document.getElementById('modalStageBadge');
            badge.textContent = config?.name || currentCol;
            badge.className = `px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider ${config?.badgeClass}`;

            // Generate Action buttons based on current stage
            const actionsContainer = document.getElementById('modalStageActions');
            actionsContainer.innerHTML = '';

            if (currentCol === 'pending') {
                actionsContainer.innerHTML = `
                    <button type="button" onclick="moveJobStage('${plate}', 'in-progress')"
                        class="col-span-2 py-2.5 px-3 rounded-lg bg-[#F05A28] hover:bg-[#D94819] text-white font-bold flex items-center justify-center gap-2 shadow-xs transition-colors">
                        <span>▶ Start Job (Move to In Progress)</span>
                    </button>
                `;
            } else if (currentCol === 'in-progress') {
                actionsContainer.innerHTML = `
                    <button type="button" onclick="moveJobStage('${plate}', 'pending')"
                        class="py-2.5 px-3 rounded-lg border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-700 font-bold flex items-center justify-center gap-1.5 transition-colors">
                        <span>⏸ Pause & Put on Hold</span>
                    </button>
                    <button type="button" onclick="moveJobStage('${plate}', 'ready-qa')"
                        class="py-2.5 px-3 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold flex items-center justify-center gap-1.5 shadow-xs transition-colors">
                        <span>✔ Mark Ready for QA</span>
                    </button>
                `;
            } else if (currentCol === 'ready-qa') {
                actionsContainer.innerHTML = `
                    <button type="button" onclick="moveJobStage('${plate}', 'in-progress')"
                        class="col-span-2 py-2.5 px-3 rounded-lg border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-700 font-bold flex items-center justify-center gap-1.5 transition-colors">
                        <span>↺ Re-open Job in Bay</span>
                    </button>
                `;
            }

            modal.classList.remove('hidden');
        }

        function closeJobInspectionModal() {
            document.getElementById('jobInspectionModal').classList.add('hidden');
        }

        // Move job stage via button
        function moveJobStage(plate, targetColId) {
            const allCards = document.querySelectorAll('.kanban-card');
            let targetCard = null;
            allCards.forEach(c => {
                if (c.innerText.includes(plate)) {
                    targetCard = c;
                }
            });

            if (targetCard) {
                const targetColumn = document.querySelector(`.kanban-column-body[data-column-id="${targetColId}"]`);
                if (targetColumn) {
                    targetColumn.prepend(targetCard);
                    updateCardVisuals(targetCard, targetColId);
                    updateColumnCounters();
                    closeJobInspectionModal();
                    showToast(`${plate} progressed to ${TECH_COLUMN_CONFIG[targetColId]?.name}`);
                }
            }
        }

        // ========================================================
        // COMPLETED JOB CARDS DATA & MODAL ENGINE
        // ========================================================
        const JOB_CARDS_DATABASE = {
            'JC-2026-0941': {
                id: 'JC-2026-0941',
                plate: 'WP CBJ-5049',
                model: 'Toyota Land Cruiser Prado TX-L 2020',
                vin: 'TRJ150-0084921',
                mileage: '58,420 km',
                engine: '2.7L Petrol Dual VVT-i / 6-Speed Auto',
                customer: 'Dr. Nalaka Jayasuriya',
                phone: '+94 77 123 4567',
                advisor: 'Malik Alwis (Front Desk)',
                technician: 'Dishan Karunaratne (TK-402)',
                bay: 'Bay 03 - Mechanical Lift',
                completedDate: 'Today, 14:15',
                bayTime: '1h 45m',
                status: 'Delivered & Closed',
                category: 'Brake & Chassis',
                qaStatus: 'Passed (100% Score)',
                qaInspector: 'M. Seneviratne (Chief Workshop QA)',
                customerConcern: 'Customer reported front wheel brake squeal at low speeds and steering vibration during hard braking above 60 km/h.',
                diagnosticFindings: 'Front brake rotor runout exceeded 0.08mm causing pulsation. Inner brake pads worn to 3.2mm (replacement threshold 3.0mm). Caliper slide pins dry.',
                workScope: 'Front brake disc resurfacing & Ferodo ceramic pad replacement',
                checklist: [
                    { task: 'Vehicle raised and wheels dismounted safely on two-post lift', time: '12:35' },
                    { task: 'Caliper slide pins and guide boots inspected & cleaned of road grime', time: '12:55' },
                    { task: 'Brake disc rotors skimmed on in-bay lathe: Initial 27.8mm → Post 26.9mm (Min 25.0mm)', time: '13:20' },
                    { task: 'Ferodo Formula ceramic pads installed with anti-squeal shims and ceramic grease', time: '13:40' },
                    { task: 'Brake fluid flushed & hydraulic lines bled with Motul DOT 4 fluid', time: '13:55' },
                    { task: 'Torque wheel lug nuts to manufacturer specification 112 Nm with torque wrench', time: '14:05' },
                    { task: '5 km dynamic road test: Zero vibration, pedal feel firm, brake efficiency 82%', time: '14:15' }
                ],
                parts: [
                    { code: 'FD-78401', desc: 'Ferodo Formula Ceramic Front Brake Pad Set', qty: '1 Set', price: 'LKR 28,500' },
                    { code: 'BR-SKIM-02', desc: 'Precision In-Bay Disc Rotor Skimming Service', qty: '2 Discs', price: 'LKR 8,000' },
                    { code: 'MO-DOT4-1L', desc: 'Motul DOT 4 High-Performance Brake Fluid (1L)', qty: '1 Can', price: 'LKR 4,200' },
                    { code: 'LUB-SL-50', desc: 'High-Temp Synthetic Caliper Slide Pin Silicone Grease', qty: '1 App', price: 'LKR 1,200' }
                ],
                techNotes: 'Rotors resurfaced within safety limits. Caliper pistons retracted smoothly with no seal degradation. Anti-seize compound applied to wheel hub mounting faces. Customer advised on 150 km bed-in period.'
            },
            'JC-2026-0938': {
                id: 'JC-2026-0938',
                plate: 'WP KX-3108',
                model: 'Toyota Hilux Revo 2.8D 4x4 2019',
                vin: 'MR0BA3CD200-58190',
                mileage: '40,150 km',
                engine: '1GD-FTV 2.8L Turbo Diesel / 6-Speed Auto 4WD',
                customer: 'Rohan Wickramasinghe',
                phone: '+94 71 889 2311',
                advisor: 'Malik Alwis (Front Desk)',
                technician: 'Dishan Karunaratne (TK-402)',
                bay: 'Bay 03 - Mechanical Lift',
                completedDate: 'Yesterday, 16:40',
                bayTime: '2h 20m',
                status: 'Delivered & Closed',
                category: 'Major Service',
                qaStatus: 'Passed (100% Score)',
                qaInspector: 'K. Ranasinghe (Senior QA Inspector)',
                customerConcern: '40,000 km Scheduled Major Drivetrain Maintenance Service & vehicle underbody inspection.',
                diagnosticFindings: 'Routine scheduled replacement. Rear differential magnetic plug contained normal fine ferrous fuzz, no metal chips. Fuel filter element life at 90% capacity.',
                workScope: 'Toyota Hilux 40k differential fluid service, transfer case & fuel filter replacement',
                checklist: [
                    { task: 'Front differential drained and filled with Toyota 75W-90 GL-5 (1.6L)', time: '14:30' },
                    { task: 'Rear differential drained, magnetic plug cleaned, refilled with 75W-90 (2.6L)', time: '15:00' },
                    { task: 'Transfer case fluid replaced with Toyota Genuine 75W Transfer Oil (1.4L)', time: '15:35' },
                    { task: 'Diesel primary & secondary fuel filter elements replaced and primed with hand pump', time: '16:05' },
                    { task: 'Propeller shaft and universal joints greased at 6 grease nipple points', time: '16:20' },
                    { task: 'Engine bay cleaned, idle speed checked, no fuel or driveline leaks detected', time: '16:40' }
                ],
                parts: [
                    { code: 'TOY-DIFF-7590', desc: 'Toyota Genuine Differential Gear Oil 75W-90 GL-5 (5L)', qty: '5 Litres', price: 'LKR 26,000' },
                    { code: 'TOY-TC-75W', desc: 'Toyota Transfer Gear Oil 75W (2L)', qty: '2 Litres', price: 'LKR 11,500' },
                    { code: 'TOY-23390-0L070', desc: 'Toyota Hilux Genuine Diesel Fuel Filter Element', qty: '1 Pc', price: 'LKR 8,900' },
                    { code: 'CRUSH-W-04', desc: 'Driveline Drain/Fill Aluminum Crush Washers (Set of 6)', qty: '1 Set', price: 'LKR 1,800' }
                ],
                techNotes: 'Driveline fluids renewed. Transfer case actuator shifted smoothly between 2H, 4H, and 4L during bay test. Propeller slip joint greased with lithium molybdenum disulfide.'
            },
            'JC-2026-0932': {
                id: 'JC-2026-0932',
                plate: 'WP CAG-9912',
                model: 'Honda Vezel e:HEV RS 2021',
                vin: 'RV5-1002341',
                mileage: '34,800 km',
                engine: '1.5L e:HEV Hybrid / e-CVT Transmission',
                customer: 'Dinithi Gunasekera',
                phone: '+94 76 450 1199',
                advisor: 'Kavindu Senanayake (Front Desk)',
                technician: 'Dishan Karunaratne (TK-402)',
                bay: 'Bay 03 - Mechanical Lift',
                completedDate: 'Yesterday, 11:30',
                bayTime: '1h 55m',
                status: 'Handed Over',
                category: 'Hybrid/EV',
                qaStatus: 'Passed (100% Score)',
                qaInspector: 'M. Seneviratne (Chief Workshop QA)',
                customerConcern: 'Slight judder when pulling away from dead stop; requested hybrid drivetrain service.',
                diagnosticFindings: 'Clutch actuator reservoir fluid deteriorated and discolored. High moisture content (3.8%). No mechanical clutch wear detected.',
                workScope: 'Dual-clutch actuator fluid replacement & Honda i-DCD clutch adaptation learning',
                checklist: [
                    { task: 'Connected Honda HDS Diagnostic Scanner to OBD-II port', time: '09:40' },
                    { task: 'Clutch actuator reservoir drained and pressure flushed with fresh fluid', time: '10:15' },
                    { task: 'Reverse pressure bleeding performed on clutch actuator slave cylinder', time: '10:45' },
                    { task: 'Executed HDS Clutch Point Teach-In / Adaptation calibration routine', time: '11:05' },
                    { task: 'Road test 4 km with stop-and-go driving: Engagement seamless, zero shudder', time: '11:30' }
                ],
                parts: [
                    { code: 'HND-ATF-DW1', desc: 'Honda Genuine Ultra ATF-DW1 Fluid (2L)', qty: '2 Litres', price: 'LKR 14,800' },
                    { code: 'HND-BF-DOT4', desc: 'Honda Genuine DOT 4 Ultra Brake Fluid (1L)', qty: '1 Litre', price: 'LKR 4,600' },
                    { code: 'DIAG-CAL-01', desc: 'Honda HDS Hybrid ECU Software Calibration Routine', qty: '1 Session', price: 'LKR 6,500' }
                ],
                techNotes: 'Clutch adaptation calibrated successfully. Hybrid high-voltage interlocks verified secure. Software version updated to latest factory release.'
            },
            'JC-2026-0925': {
                id: 'JC-2026-0925',
                plate: 'NW WP-9871',
                model: 'Mitsubishi Montero Sport 3.2 DiD 2018',
                vin: 'MMBJR45009-11204',
                mileage: '92,100 km',
                engine: '4M41 3.2L Turbo Diesel / 5-Speed Auto',
                customer: 'Sanath Dissanayake',
                phone: '+94 77 334 8920',
                advisor: 'Malik Alwis (Front Desk)',
                technician: 'Dishan Karunaratne (TK-402)',
                bay: 'Bay 03 - Mechanical Lift',
                completedDate: '24 Sep, 15:10',
                bayTime: '3h 10m',
                status: 'Delivered & Closed',
                category: 'Engine/Transmission',
                qaStatus: 'Passed (100% Score)',
                qaInspector: 'S. Perera (Senior QA Inspector)',
                customerConcern: 'Harsh 2nd to 3rd gear upshift when cold and delayed reverse gear engagement.',
                diagnosticFindings: 'ATF burnt smell and brown discoloration. Line pressure at 5.2 bar (spec is 6.5 - 7.2 bar). Solenoid B resistance slightly high at 14.8 ohms (normal 11-15 ohms).',
                workScope: 'Automatic transmission fluid flush, pan cleaning & valve body solenoid inspection',
                checklist: [
                    { task: 'Transmission oil pan dropped, magnets inspected and cleaned of metallic sludge', time: '12:20' },
                    { task: 'Replaced internal transmission filter strainer and rubber pan gasket', time: '12:55' },
                    { task: 'Valve body shift solenoid harness inspected and terminal pins deoxified', time: '13:30' },
                    { task: 'Connected flush machine for 10L fluid exchange with Mitsubishi ATF SP-III', time: '14:20' },
                    { task: 'Fluid level checked at 75°C operating temp; line pressure verified at 6.8 bar', time: '14:50' },
                    { task: 'Extensive road test: Smooth gear transitions in cold and hot operating cycles', time: '15:10' }
                ],
                parts: [
                    { code: 'MIT-SP3-ATF', desc: 'Mitsubishi Diamond ATF SP-III Automatic Fluid (10L)', qty: '10 Litres', price: 'LKR 42,000' },
                    { code: 'MIT-FILTER-AT', desc: 'Montero Sport Internal ATF Transmission Filter Strainer', qty: '1 Pc', price: 'LKR 12,500' },
                    { code: 'MIT-GASK-PAN', desc: 'Mitsubishi OEM Transmission Pan Rubber Gasket', qty: '1 Pc', price: 'LKR 4,800' }
                ],
                techNotes: 'Line pressure recovered to 6.8 bar. Shift flare completely eliminated. Coolant heat exchanger flushed through lines to ensure zero restriction.'
            },
            'JC-2026-0919': {
                id: 'JC-2026-0919',
                plate: 'WP CAD-5521',
                model: 'Suzuki Swift RS Turbo 1.0 Boosterjet 2022',
                vin: 'ZC13S-105942',
                mileage: '28,300 km',
                engine: 'K10C 1.0L Turbo 3-Cylinder / 6-Speed Auto',
                customer: 'Kasun Weerakkody',
                phone: '+94 70 223 9988',
                advisor: 'Kavindu Senanayake (Front Desk)',
                technician: 'Dishan Karunaratne (TK-402)',
                bay: 'Bay 03 - Mechanical Lift',
                completedDate: '23 Sep, 17:00',
                bayTime: '2h 05m',
                status: 'Delivered & Closed',
                category: 'Brake & Chassis',
                qaStatus: 'Passed (100% Score)',
                qaInspector: 'K. Ranasinghe (Senior QA Inspector)',
                customerConcern: 'Clunking noise from front left over rough potholes; vehicle pulling slightly to left.',
                diagnosticFindings: 'Left front lower control arm rear hydro-bush ruptured and leaking fluid. Front stabilizer link boot torn with ball joint play.',
                workScope: 'Lower control arm bush replacement, stabilizer link kit & 4-wheel Hunter laser alignment',
                checklist: [
                    { task: 'Front subframe and lower control arms dismantled safely', time: '15:15' },
                    { task: 'Hydraulic shop press used to extract torn bushes and press in new OEM rubber bushes', time: '15:50' },
                    { task: 'New heavy-duty stabilizer link rods fitted on both left and right sides', time: '16:15' },
                    { task: 'Mounted on Hunter Hawkeye Elite 4-Wheel Laser Alignment bay', time: '16:40' },
                    { task: 'Camber adjusted to -0.30°, Toe dialed to +0.02°, steering angle centered', time: '17:00' }
                ],
                parts: [
                    { code: 'SZ-LCA-BUSH', desc: 'Suzuki Genuine Front Lower Control Arm Bush Kit (L+R)', qty: '1 Set', price: 'LKR 16,800' },
                    { code: 'SZ-STAB-LINK', desc: 'Front Sway Bar End Link Assemblies (Pair)', qty: '2 Pcs', price: 'LKR 9,400' },
                    { code: 'HUNTER-ALIGN', desc: 'Hunter 3D Laser 4-Wheel Alignment & Steering Angle Sensor Reset', qty: '1 Service', price: 'LKR 4,500' }
                ],
                techNotes: 'Clunk eliminated. Front suspension geometry aligned to factory specs. Alignment printout attached to customer invoice.'
            },
            'JC-2026-0914': {
                id: 'JC-2026-0914',
                plate: 'SP CAA-3319',
                model: 'Mercedes-Benz C200 AMG Line 2017',
                vin: 'WDD2050422R-209118',
                mileage: '64,500 km',
                engine: 'M274 2.0L Turbo Petrol / 9G-Tronic Auto',
                customer: 'Chaminda Alahakoon',
                phone: '+94 77 665 4411',
                advisor: 'Malik Alwis (Front Desk)',
                technician: 'Dishan Karunaratne (TK-402)',
                bay: 'Bay 03 - Mechanical Lift',
                completedDate: '22 Sep, 14:20',
                bayTime: '1h 15m',
                status: 'Delivered & Closed',
                category: 'Engine/Transmission',
                qaStatus: 'Passed (100% Score)',
                qaInspector: 'M. Seneviratne (Chief Workshop QA)',
                customerConcern: '"Auxiliary Battery Malfunction" warning on digital instrument cluster. Eco Start/Stop non-functional.',
                diagnosticFindings: 'Star Xentry fault code B21DC01: Auxiliary capacitor / battery internal resistance too high. Voltage test at 9.2V under load.',
                workScope: 'Auxiliary backup battery replacement & Star diagnostic fault code clear',
                checklist: [
                    { task: 'Connected Mercedes-Benz Star Xentry Diagnostic interface', time: '13:10' },
                    { task: 'Removed front passenger footwell kick panel and HVAC ducting to access battery', time: '13:30' },
                    { task: 'Removed depleted capacitor/battery unit and installed OEM Varta backup unit', time: '13:50' },
                    { task: 'Programmed battery registration into SAM (Signal Acquisition Module)', time: '14:05' },
                    { task: 'Cleared diagnostic DTCs; verified active Eco Start/Stop function', time: '14:20' }
                ],
                parts: [
                    { code: 'MB-VARTA-AUX', desc: 'OEM Varta Mercedes-Benz Auxiliary Battery 12V 1.2Ah', qty: '1 Pc', price: 'LKR 31,500' },
                    { code: 'STAR-DIAG-MB', desc: 'Xentry Mercedes-Benz Electronic Diagnostic Scan & SAM Coding', qty: '1 Session', price: 'LKR 8,500' }
                ],
                techNotes: 'Warning message cleared. Main 12V AGM starter battery state of health tested at 91% (Good). Alternator charging output stable at 14.2V.'
            }
        };

        // Open Completed Job Card Modal
        function openCompletedJobCard(jcId) {
            const card = JOB_CARDS_DATABASE[jcId];
            if (!card) {
                showToast(`Job card ${jcId} details not found`);
                return;
            }

            document.getElementById('jcCardNumber').textContent = card.id;
            document.getElementById('jcPlateBadge').innerHTML = `
                <span class="w-1.5 h-1.5 rounded-full bg-[#F05A28]"></span>
                ${card.plate}
            `;
            document.getElementById('jcStatusBadge').innerHTML = `
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                ${card.status}
            `;
            document.getElementById('jcQaBadge').innerHTML = `
                <svg class="w-3.5 h-3.5 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                </svg>
                ${card.qaStatus}
            `;
            document.getElementById('jcCompletedDate').textContent = card.completedDate;
            document.getElementById('jcBayTime').textContent = card.bayTime;

            document.getElementById('jcEngine').textContent = card.engine;
            document.getElementById('jcVehicleModel').textContent = card.model;
            document.getElementById('jcVin').textContent = card.vin;
            document.getElementById('jcMileage').textContent = card.mileage;
            document.getElementById('jcCategory').textContent = card.category;

            document.getElementById('jcCustomerName').textContent = card.customer;
            document.getElementById('jcCustomerPhone').textContent = card.phone;
            document.getElementById('jcAdvisor').textContent = card.advisor;
            document.getElementById('jcTechnician').innerHTML = `
                <span class="w-1.5 h-1.5 rounded-full bg-[#F05A28]"></span>
                ${card.technician}
            `;
            document.getElementById('jcBay').textContent = card.bay;

            document.getElementById('jcConcern').textContent = card.customerConcern;
            document.getElementById('jcDiagnostics').textContent = card.diagnosticFindings;

            // Render Checklist
            const checkContainer = document.getElementById('jcChecklistContainer');
            checkContainer.innerHTML = card.checklist.map(item => `
                <div class="flex items-center justify-between py-1 px-2 rounded-lg hover:bg-white text-xs transition-colors">
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0">
                            <svg class="w-2.5 h-2.5 stroke-current stroke-[3]" fill="none" viewBox="0 0 24 24">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </span>
                        <span class="text-slate-800 font-medium">${item.task}</span>
                    </div>
                    <span class="text-[10px] font-mono text-slate-400 whitespace-nowrap pl-2">${item.time}</span>
                </div>
            `).join('');

            // Render Parts Table
            const partsTable = document.getElementById('jcPartsTableBody');
            partsTable.innerHTML = card.parts.map(p => `
                <tr class="hover:bg-slate-50">
                    <td class="py-2 px-3 font-mono font-bold text-slate-900">${p.code}</td>
                    <td class="py-2 px-3 text-slate-700">${p.desc}</td>
                    <td class="py-2 px-3 text-slate-600 font-semibold">${p.qty}</td>
                    <td class="py-2 px-3 text-right font-bold text-slate-900">${p.price}</td>
                </tr>
            `).join('');

            document.getElementById('jcTechNotes').textContent = card.techNotes;
            document.getElementById('jcQaInspector').textContent = card.qaInspector;

            document.getElementById('completedJobCardModal').classList.remove('hidden');
        }

        function closeCompletedJobCard() {
            document.getElementById('completedJobCardModal').classList.add('hidden');
        }

        // Print Job Card trigger
        function printJobCard() {
            window.print();
        }

        // Filter Recent Vehicles Table
        function filterRecentVehiclesTable() {
            const query = document.getElementById('recentVehicleSearch').value.toLowerCase().trim();
            const rows = document.querySelectorAll('#recentVehiclesTableBody tr');
            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                if (text.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Switch back to My Jobs Kanban Board
        function showMyJobsView(e) {
            if (e) e.preventDefault();
            const board = document.getElementById('activeBoardSection');
            const history = document.getElementById('jobHistorySection');
            board.classList.remove('hidden');
            history.classList.add('hidden');

            document.getElementById('navMyJobsBtn').classList.add('nav-item-active');
            document.getElementById('navJobHistoryBtn').classList.remove('nav-item-active');

            const breadcrumb = document.getElementById('pageBreadcrumb');
            if (breadcrumb) breadcrumb.textContent = 'My Jobs';

            const heading = document.getElementById('pageHeading');
            if (heading) heading.textContent = 'My Jobs';
        }

        // Toggle Job History view
        function toggleJobHistoryView() {
            const board = document.getElementById('activeBoardSection');
            const history = document.getElementById('jobHistorySection');
            const isBoardVisible = !board.classList.contains('hidden');

            const navMyJobs = document.getElementById('navMyJobsBtn');
            const navHistory = document.getElementById('navJobHistoryBtn');
            const breadcrumb = document.getElementById('pageBreadcrumb');
            const heading = document.getElementById('pageHeading');

            if (isBoardVisible) {
                board.classList.add('hidden');
                history.classList.remove('hidden');
                if (navHistory) navHistory.classList.add('nav-item-active');
                if (navMyJobs) navMyJobs.classList.remove('nav-item-active');
                if (breadcrumb) breadcrumb.textContent = 'Job History (Recent)';
                if (heading) heading.textContent = 'Job History';
            } else {
                board.classList.remove('hidden');
                history.classList.add('hidden');
                if (navHistory) navHistory.classList.remove('nav-item-active');
                if (navMyJobs) navMyJobs.classList.add('nav-item-active');
                if (breadcrumb) breadcrumb.textContent = 'My Jobs';
                if (heading) heading.textContent = 'My Jobs';
            }
        }

        // Request parts quick action
        function openPartsRequisitionModal() {
            const partName = prompt('Enter Part Name or Part # to requisition from Central Stores:');
            if (partName) {
                showToast(`Requisition sent to Parts Inventory: ${partName}`);
            }
        }

        // Station lock trigger
        function lockTechnicianStation() {
            if (confirm('Lock Dishan K. Technician Workstation and return to login?')) {
                window.location.href = '/login';
            }
        }

        // Toast feedback
        function showToast(msg) {
            const toast = document.getElementById('toast');
            const toastMsg = document.getElementById('toastMsg');
            toastMsg.textContent = msg;
            toast.classList.remove('translate-y-20', 'opacity-0');
            setTimeout(() => {
                toast.classList.add('translate-y-20', 'opacity-0');
            }, 3000);
        }


        // Escape Key Listener
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeJobInspectionModal();
                closeCompletedJobCard();
                toggleMobileSidebar(false);
            }
        });

        // Initialize counters on load
        document.addEventListener('DOMContentLoaded', () => {
            updateColumnCounters();
        });
    </script>
</body>

</html>