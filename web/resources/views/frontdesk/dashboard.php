<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Front Desk Intake - VWMS OS</title>
    <meta name="description"
        content="Front Desk Intake workstation for vehicle check-in triage, incoming bookings, and express job card handoff on VWMS.">

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
        /* Sri Lankan Vehicle Registration Plate Badge */
        .sl-plate-badge {
            display: inline-flex;
            align-items: center;
            background: #0B0F19;
            color: #FFFFFF;
            border: 1px solid #1E293B;
            border-radius: 4px;
            padding: 2px 7px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.72rem;
            letter-spacing: 0.08em;
            font-weight: 700;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            line-height: 1.25;
        }

        .sl-plate-badge .province {
            font-size: 0.58rem;
            color: #94A3B8;
            margin-right: 5px;
            font-weight: 600;
            letter-spacing: 0.05em;
        }

        /* Subtle scrollbar */
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

        /* Active nav item highlight */
        .nav-item-active {
            background: rgba(240, 90, 40, 0.12);
            color: #F05A28;
            border-left: 3px solid #F05A28;
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
                <!-- Top Brand: VWMS OS (Replaced WorkshopPro with VWMS) -->
                <div class="px-5 py-5 border-b border-slate-800/80 flex items-center justify-between">
                    <a href="/frontdesk/dashboard" class="flex items-center gap-2.5 group">
                        <!-- Orange Icon -->
                        <div
                            class="w-8 h-8 rounded-lg bg-[#F05A28] flex items-center justify-center shadow-md shadow-orange-500/20 group-hover:scale-105 transition-transform duration-200">
                            <!-- Distinctive Mark Icon matching screenshot -->
                            <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path
                                    d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                </path>
                            </svg>
                        </div>
                        <!-- Logo Typography: VWMS (white) + OS (orange) -->
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

                    <!-- 1. Intake (Active) -->
                    <a href="/frontdesk/dashboard"
                        class="nav-item-active flex items-center gap-3 px-3 py-2 rounded-md font-semibold text-sm transition-all duration-150">
                        <!-- Box-arrow intake icon -->
                        <svg class="w-4 h-4 text-[#F05A28]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="12" y1="18" x2="12" y2="12"></line>
                            <polyline points="9 15 12 12 15 15"></polyline>
                        </svg>
                        <span>Intake</span>
                    </a>

                    <!-- 2. Active Jobs -->
                    <a href="/frontdesk/active-jobs"
                        class="flex items-center gap-3 px-3 py-2 rounded-md text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 font-medium text-sm transition-colors duration-150">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z">
                            </path>
                        </svg>
                        <span>Active Jobs</span>
                    </a>

                    <!-- 3. Invoicing -->
                    <a href="#invoicing" onclick="showToast('Navigating to Invoicing...')"
                        class="flex items-center gap-3 px-3 py-2 rounded-md text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 font-medium text-sm transition-colors duration-150">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
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
                            <path
                                d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.2 1 12 1 13v3c0 .6.4 1 1 1h2">
                            </path>
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
                        <!-- Avatar with green status dot -->
                        <div class="relative flex-shrink-0">
                            <div
                                class="w-8 h-8 rounded-full bg-[#EA580C] text-white flex items-center justify-center text-xs font-bold shadow-sm">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <!-- Live Online Dot -->
                            <span
                                class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-[#0F172A] rounded-full"></span>
                        </div>
                        <!-- Agent Details -->
                        <div class="flex flex-col min-w-0">
                            <span class="text-xs font-semibold text-white truncate leading-tight">Front Desk
                                Agent</span>
                            <span class="text-[11px] text-slate-400 truncate leading-tight mt-0.5">Intake Station
                                01</span>
                        </div>
                    </div>

                    <!-- Station Lock / Logout Action -->
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
                        <span class="hover:text-slate-800 transition-colors">Front Desk</span>
                        <span class="text-slate-300">/</span>
                        <span class="font-bold text-slate-800">Intake</span>
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
                        <button type="button" onclick="showToast('You have 3 incoming vehicle alerts')"
                            class="w-8 h-8 rounded-full border border-slate-200 bg-white flex items-center justify-center text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors relative"
                            aria-label="Notifications">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                            </svg>
                            <!-- Notification Counter Badge -->
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

            <!-- Main Content Container -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto space-y-6">

                <!-- Page Headline -->
                <div>
                    <h1 class="text-2xl font-extrabold text-[#0F172A] tracking-tight">Front Desk Intake</h1>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
                        Live stream of incoming booked vehicles, customer check-in triage, and express job card handoff.
                    </p>
                </div>

                <!-- ==================================================== -->
                <!-- TODAY'S ARRIVALS DATA CARD                           -->
                <!-- ==================================================== -->
                <div class="bg-white rounded-xl border border-slate-200/90 shadow-sm overflow-hidden">

                    <!-- Card Header Toolbar -->
                    <div
                        class="p-4 sm:p-5 border-b border-slate-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <!-- Left: Title + Active Badge -->
                        <div class="flex items-center gap-2.5">
                            <h2 class="text-base sm:text-lg font-bold text-[#0F172A]">Today's Arrivals</h2>
                            <span id="activeCountBadge"
                                class="px-2 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                3 active
                            </span>
                        </div>

                        <!-- Right Controls: Filter Input, Dropdown & CTA Button -->
                        <div class="flex flex-wrap items-center gap-2.5 sm:gap-3">
                            <!-- Filter Search Box -->
                            <div class="relative min-w-[200px]">
                                <span
                                    class="absolute inset-y-0 left-0 flex items-center pl-2.5 pointer-events-none text-slate-400">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <path d="m21 21-4.35-4.35"></path>
                                    </svg>
                                </span>
                                <input type="text" id="filterInput" oninput="filterTableRows()"
                                    placeholder="Filter plate or customer..."
                                    class="w-full pl-8 pr-3 py-1.5 text-xs bg-white border border-slate-200 rounded-md focus:outline-none focus:ring-1 focus:ring-[#F05A28] focus:border-[#F05A28] text-slate-700 placeholder:text-slate-400">
                            </div>

                            <!-- Dropdown Select -->
                            <div class="relative">
                                <select id="timeSlotSelect" onchange="filterTableRows()"
                                    class="appearance-none pl-3 pr-8 py-1.5 text-xs font-medium bg-white border border-slate-200 rounded-md text-slate-700 focus:outline-none focus:ring-1 focus:ring-[#F05A28] cursor-pointer">
                                    <option value="morning">All Morning Slots</option>
                                    <option value="afternoon">All Afternoon Slots</option>
                                    <option value="all">All Day (Full Stream)</option>
                                </select>
                                <span
                                    class="absolute inset-y-0 right-0 flex items-center pr-2.5 pointer-events-none text-slate-400">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </span>
                            </div>

                            <!-- Primary CTA Button -->
                            <button type="button" onclick="openRegisterModal()"
                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-md bg-[#F05A28] hover:bg-[#D94819] text-white text-xs font-semibold shadow-sm transition-colors duration-150">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="8" x2="12" y2="16"></line>
                                    <line x1="8" y1="12" x2="16" y2="12"></line>
                                </svg>
                                <span>Register New Vehicle/Customer</span>
                            </button>
                        </div>
                    </div>

                    <!-- Responsive Arrivals Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse" id="arrivalsTable">
                            <thead>
                                <tr
                                    class="border-b border-slate-100 bg-[#F8FAFC]/75 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                                    <th scope="col" class="py-3 px-4 sm:px-6 w-28">TIME</th>
                                    <th scope="col" class="py-3 px-4 sm:px-6 w-64">CUSTOMER</th>
                                    <th scope="col" class="py-3 px-4 sm:px-6 w-56">LICENSE NO</th>
                                    <th scope="col" class="py-3 px-4 sm:px-6">DESCRIPTION</th>
                                    <th scope="col" class="py-3 px-4 sm:px-6 text-right w-24">ACTION</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs text-slate-700" id="arrivalsTableBody">

                                <!-- ROW 1: Kamal Perera -->
                                <tr class="hover:bg-slate-50/70 transition-colors arrival-row cursor-pointer"
                                    onclick="handleRowAction('WP CAK-9021', 'Kamal Perera', 'Honda Vezel RU1', 'Periodic 40,000 km Service + Brake Inspection')">
                                    <!-- TIME -->
                                    <td class="py-3.5 px-4 sm:px-6 whitespace-nowrap">
                                        <div class="font-bold text-[#0F172A] text-xs">08:30 AM</div>
                                    </td>
                                    <!-- CUSTOMER -->
                                    <td class="py-3.5 px-4 sm:px-6">
                                        <div class="font-bold text-[#0F172A] text-xs">Kamal Perera</div>
                                        <div class="text-[11px] text-slate-400 font-mono mt-0.5">+94 77 123 4567</div>
                                    </td>
                                    <!-- LICENSE NO -->
                                    <td class="py-3.5 px-4 sm:px-6 whitespace-nowrap">
                                        <div class="sl-plate-badge">
                                            <span class="province">WP</span>CAK-9021
                                        </div>
                                        <div class="text-[11px] text-slate-500 mt-1">Honda Vezel RU1</div>
                                    </td>
                                    <!-- DESCRIPTION -->
                                    <td class="py-3.5 px-4 sm:px-6">
                                        <div class="text-slate-800 font-medium">Periodic 40,000 km Service + Brake Ins
                                        </div>
                                    </td>
                                    <!-- ACTION -->
                                    <td class="py-3.5 px-4 sm:px-6 text-right whitespace-nowrap"
                                        onclick="event.stopPropagation()">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <button type="button"
                                                onclick="handleCheckIn(this, 'WP CAK-9021', 'Kamal Perera', 'Honda Vezel RU1')"
                                                class="px-2.5 py-1 text-[11px] font-bold text-white bg-[#F05A28] hover:bg-[#D94819] rounded shadow-2xs transition-colors">
                                                Check In
                                            </button>
                                            <button type="button"
                                                onclick="openCancelModal(this, 'WP CAK-9021', 'Kamal Perera', 'Honda Vezel RU1')"
                                                class="px-2.5 py-1 text-[11px] font-semibold text-rose-600 hover:text-rose-700 hover:bg-rose-50 rounded border border-rose-200 transition-colors">
                                                Cancel
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- ROW 2: Dilani Wickramasinghe -->
                                <tr class="hover:bg-slate-50/70 transition-colors arrival-row cursor-pointer"
                                    onclick="handleRowAction('WP CAB-4321', 'Dilani Wickramasinghe', 'Toyota Land Cruiser Prado', 'Full Diagnostic Scan & Transmission Fluid Flush')">
                                    <!-- TIME -->
                                    <td class="py-3.5 px-4 sm:px-6 whitespace-nowrap">
                                        <div class="font-bold text-[#0F172A] text-xs">09:00 AM</div>
                                        <div class="text-[10px] text-slate-400 mt-0.5">Scheduled</div>
                                    </td>
                                    <!-- CUSTOMER -->
                                    <td class="py-3.5 px-4 sm:px-6">
                                        <div class="font-bold text-[#0F172A] text-xs">Dilani Wickramasinghe</div>
                                        <div class="text-[11px] text-slate-400 mt-0.5">Fleet Client • Dialog Axiata
                                        </div>
                                    </td>
                                    <!-- LICENSE NO -->
                                    <td class="py-3.5 px-4 sm:px-6 whitespace-nowrap">
                                        <div class="sl-plate-badge">
                                            <span class="province">WP</span>CAB-4321
                                        </div>
                                        <div class="text-[11px] text-slate-500 mt-1">Toyota Land Cruiser Prado</div>
                                    </td>
                                    <!-- DESCRIPTION -->
                                    <td class="py-3.5 px-4 sm:px-6">
                                        <div class="text-slate-800 font-medium">Full Diagnostic Scan & Transmission Flu
                                        </div>
                                    </td>
                                    <!-- ACTION -->
                                    <td class="py-3.5 px-4 sm:px-6 text-right whitespace-nowrap"
                                        onclick="event.stopPropagation()">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <button type="button"
                                                onclick="handleCheckIn(this, 'WP CAB-4321', 'Dilani Wickramasinghe', 'Toyota Land Cruiser Prado')"
                                                class="px-2.5 py-1 text-[11px] font-bold text-white bg-[#F05A28] hover:bg-[#D94819] rounded shadow-2xs transition-colors">
                                                Check In
                                            </button>
                                            <button type="button"
                                                onclick="openCancelModal(this, 'WP CAB-4321', 'Dilani Wickramasinghe', 'Toyota Land Cruiser Prado')"
                                                class="px-2.5 py-1 text-[11px] font-semibold text-rose-600 hover:text-rose-700 hover:bg-rose-50 rounded border border-rose-200 transition-colors">
                                                Cancel
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- ROW 3: Sunil Rathnayake -->
                                <tr class="hover:bg-slate-50/70 transition-colors arrival-row cursor-pointer"
                                    onclick="handleRowAction('WP BBD-7714', 'Sunil Rathnayake', 'Nissan X-Trail T32', 'Suspension Knock Noise Inspection & Vehicle Triage')">
                                    <!-- TIME -->
                                    <td class="py-3.5 px-4 sm:px-6 whitespace-nowrap">
                                        <div class="font-bold text-[#0F172A] text-xs">09:15 AM</div>
                                        <div class="text-[10px] text-slate-400 mt-0.5">Scheduled</div>
                                    </td>
                                    <!-- CUSTOMER -->
                                    <td class="py-3.5 px-4 sm:px-6">
                                        <div class="font-bold text-[#0F172A] text-xs">Sunil Rathnayake</div>
                                        <div class="text-[11px] text-slate-400 mt-0.5">First Time Customer</div>
                                    </td>
                                    <!-- LICENSE NO -->
                                    <td class="py-3.5 px-4 sm:px-6 whitespace-nowrap">
                                        <div class="sl-plate-badge">
                                            <span class="province">WP</span>BBD-7714
                                        </div>
                                        <div class="text-[11px] text-slate-500 mt-1">Nissan X-Trail T32</div>
                                    </td>
                                    <!-- DESCRIPTION -->
                                    <td class="py-3.5 px-4 sm:px-6">
                                        <div class="text-slate-800 font-medium">Suspension Knock Noise Inspection & V
                                        </div>
                                    </td>
                                    <!-- ACTION -->
                                    <td class="py-3.5 px-4 sm:px-6 text-right whitespace-nowrap"
                                        onclick="event.stopPropagation()">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <button type="button"
                                                onclick="handleCheckIn(this, 'WP BBD-7714', 'Sunil Rathnayake', 'Nissan X-Trail T32')"
                                                class="px-2.5 py-1 text-[11px] font-bold text-white bg-[#F05A28] hover:bg-[#D94819] rounded shadow-2xs transition-colors">
                                                Check In
                                            </button>
                                            <button type="button"
                                                onclick="openCancelModal(this, 'WP BBD-7714', 'Sunil Rathnayake', 'Nissan X-Trail T32')"
                                                class="px-2.5 py-1 text-[11px] font-semibold text-rose-600 hover:text-rose-700 hover:bg-rose-50 rounded border border-rose-200 transition-colors">
                                                Cancel
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <!-- Card Footer: Pagination & Full Schedule Link -->
                    <div
                        class="p-4 sm:px-6 bg-white border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-400">
                            Showing <strong class="text-slate-700" id="visibleRowCount">3</strong> of 18 scheduled
                            arrivals today
                        </span>

                        <a href="#fullSchedule" onclick="showFullDaySchedule()"
                            class="inline-flex items-center gap-1 font-semibold text-[#F05A28] hover:text-[#D94819] transition-colors">
                            <span>View Full Day Schedule</span>
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>

                </div>

            </main>

        </div>

    </div>

    <!-- ======================================================== -->
    <!-- 3. MODAL: ADD A NEW VEHICLE                              -->
    <!-- ======================================================== -->
    <div id="registerModal"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden"
        role="dialog" aria-modal="true">
        <div
            class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-2xl max-h-[92vh] overflow-hidden flex flex-col transform transition-all animate-fade-in">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/70">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-orange-100 text-[#F05A28] flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.2 1 12 1 13v3c0 .6.4 1 1 1h2"></path>
                            <circle cx="7" cy="17" r="2"></circle>
                            <path d="M9 17h6"></path>
                            <circle cx="17" cy="17" r="2"></circle>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-bold text-slate-900 leading-tight">Add A New Vehicle</h3>
                        <p class="text-[11px] text-slate-500 mt-0.5">Attach vehicle to an existing customer or register a new customer profile</p>
                    </div>
                </div>
                <button type="button" onclick="closeRegisterModal()" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-100 transition-colors" aria-label="Close modal">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal Form (Scrollable Body) -->
            <form id="newVehicleForm" onsubmit="handleNewRegistration(event)" class="p-6 overflow-y-auto space-y-4 text-xs">

                <!-- 1. CUSTOMER INFORMATION -->
                <div class="p-4 rounded-xl bg-slate-50/80 border border-slate-200/80 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold text-slate-700 uppercase tracking-wider flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-[#F05A28]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            Customer Information
                        </span>

                        <!-- Segmented Mode Switcher -->
                        <div class="flex items-center bg-white border border-slate-200 rounded-lg p-0.5 shadow-2xs">
                            <button type="button" id="tabExistingCust" onclick="setCustomerMode('existing')"
                                class="px-2.5 py-1 rounded-md text-[11px] font-semibold bg-[#F05A28] text-white transition-all shadow-xs">
                                Existing Customer
                            </button>
                            <button type="button" id="tabNewCust" onclick="setCustomerMode('new')"
                                class="px-2.5 py-1 rounded-md text-[11px] font-medium text-slate-600 hover:text-slate-900 transition-all">
                                + New Customer
                            </button>
                        </div>
                    </div>

                    <!-- Mode A: Search Existing Customer -->
                    <div id="existingCustomerSection" class="space-y-2">
                        <label class="block font-semibold text-slate-700">Search Existing Customer</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <path d="m21 21-4.35-4.35"></path>
                                </svg>
                            </span>
                            <input type="text" id="custSearchInput" oninput="searchExistingCustomers(event)"
                                placeholder="Search by customer name, phone (+94...), or email..."
                                class="w-full pl-9 pr-8 py-2 bg-white border border-slate-200 rounded-lg focus:ring-1 focus:ring-[#F05A28] focus:border-[#F05A28] outline-none text-slate-800 placeholder-slate-400">
                            <button type="button" onclick="clearCustomerSearch()" id="clearCustSearchBtn" class="hidden absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Dropdown Results -->
                        <div id="custSearchResults" class="hidden bg-white border border-slate-200 rounded-lg shadow-lg max-h-48 overflow-y-auto divide-y divide-slate-100">
                            <!-- Populated dynamically -->
                        </div>

                        <!-- Selected Customer Preview Card -->
                        <div id="selectedCustCard" class="hidden p-3 rounded-lg bg-emerald-50/80 border border-emerald-200 flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <div id="selectedCustAvatar" class="w-8 h-8 rounded-full bg-emerald-600 text-white font-bold text-xs flex items-center justify-center shrink-0">KP</div>
                                <div class="min-w-0">
                                    <div id="selectedCustName" class="font-bold text-slate-900 text-xs">Kamal Perera</div>
                                    <div class="text-[11px] text-slate-500 flex flex-wrap items-center gap-2 mt-0.5">
                                        <span id="selectedCustPhone">+94 77 123 4567</span>
                                        <span>•</span>
                                        <span id="selectedCustEmail">kamal.p@gmail.com</span>
                                    </div>
                                </div>
                            </div>
                            <button type="button" onclick="clearSelectedCustomer()" class="text-xs text-rose-600 hover:text-rose-700 font-semibold px-2 py-1 rounded hover:bg-rose-50 transition-colors shrink-0">
                                Change
                            </button>
                        </div>

                        <div class="flex items-center justify-between text-[11px] text-slate-500 pt-0.5">
                            <span>Client not found in system?</span>
                            <button type="button" onclick="setCustomerMode('new')" class="text-[#F05A28] font-bold hover:underline">
                                Register new customer details →
                            </button>
                        </div>
                    </div>

                    <!-- Mode B: Add New Customer Details -->
                    <div id="newCustomerSection" class="hidden space-y-3 pt-1">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label for="newCustName" class="block font-semibold text-slate-700 mb-1">Customer Full Name *</label>
                                <input type="text" id="newCustName" placeholder="e.g. Asoka Bandara"
                                    class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg focus:ring-1 focus:ring-[#F05A28] focus:border-[#F05A28] outline-none text-slate-800">
                            </div>
                            <div>
                                <label for="newCustEmail" class="block font-semibold text-slate-700 mb-1">Customer Email *</label>
                                <input type="email" id="newCustEmail" placeholder="e.g. asoka.bandara@gmail.com"
                                    class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg focus:ring-1 focus:ring-[#F05A28] focus:border-[#F05A28] outline-none text-slate-800">
                            </div>
                        </div>
                        <div>
                            <label for="newCustPhone" class="block font-semibold text-slate-700 mb-1">Contact Phone</label>
                            <input type="tel" id="newCustPhone" placeholder="+94 7X XXX XXXX"
                                class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg focus:ring-1 focus:ring-[#F05A28] focus:border-[#F05A28] outline-none font-mono text-slate-800">
                        </div>
                    </div>
                </div>

                <!-- 2. VEHICLE DETAILS -->
                <div class="p-4 rounded-xl bg-slate-50/80 border border-slate-200/80 space-y-3">
                    <span class="text-[11px] font-bold text-slate-700 uppercase tracking-wider flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-[#F05A28]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="6" width="20" height="12" rx="2"></rect>
                            <circle cx="7" cy="18" r="2"></circle>
                            <circle cx="17" cy="18" r="2"></circle>
                        </svg>
                        Vehicle Details
                    </span>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <!-- Number Plate -->
                        <div class="sm:col-span-1">
                            <label for="regPlateNo" class="block font-semibold text-slate-700 mb-1">Number Plate *</label>
                            <input type="text" id="regPlateNo" required placeholder="WP CBA-1234"
                                class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg focus:ring-1 focus:ring-[#F05A28] focus:border-[#F05A28] outline-none font-mono uppercase font-bold text-slate-900 tracking-wider">
                        </div>

                        <!-- Make -->
                        <div class="sm:col-span-1">
                            <label for="regMake" class="block font-semibold text-slate-700 mb-1">Make *</label>
                            <input type="text" id="regMake" required placeholder="e.g. Toyota"
                                class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg focus:ring-1 focus:ring-[#F05A28] focus:border-[#F05A28] outline-none text-slate-800">
                        </div>

                        <!-- Model -->
                        <div class="sm:col-span-1">
                            <label for="regModel" class="block font-semibold text-slate-700 mb-1">Model *</label>
                            <input type="text" id="regModel" required placeholder="e.g. Prius 4th Gen"
                                class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg focus:ring-1 focus:ring-[#F05A28] focus:border-[#F05A28] outline-none text-slate-800">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <!-- Mileage -->
                        <div>
                            <label for="regMileage" class="block font-semibold text-slate-700 mb-1">Mileage (km) *</label>
                            <div class="relative">
                                <input type="number" id="regMileage" required placeholder="e.g. 48500" min="0"
                                    class="w-full pl-3 pr-10 py-2 bg-white border border-slate-200 rounded-lg focus:ring-1 focus:ring-[#F05A28] focus:border-[#F05A28] outline-none font-mono text-slate-800">
                                <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400 font-medium">km</span>
                            </div>
                        </div>

                        <!-- VIN -->
                        <div>
                            <label for="regVIN" class="block font-semibold text-slate-700 mb-1">VIN (Chassis No) *</label>
                            <input type="text" id="regVIN" required placeholder="17-character VIN" maxlength="17"
                                class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg focus:ring-1 focus:ring-[#F05A28] focus:border-[#F05A28] outline-none font-mono uppercase text-slate-800 tracking-wider">
                        </div>
                    </div>
                </div>

                <!-- 3. DESCRIPTION / SERVICES REQUIRED -->
                <div>
                    <label for="regServiceDesc" class="block font-semibold text-slate-700 mb-1">
                        Description / Services Required *
                    </label>
                    <textarea id="regServiceDesc" rows="3" required
                        placeholder="Detail the issues, customer requests, or standard service required (e.g. 40,000 km general service, inspect front brake vibration, suspension diagnostic)..."
                        class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg focus:ring-1 focus:ring-[#F05A28] focus:border-[#F05A28] outline-none text-slate-800 placeholder-slate-400 leading-relaxed"></textarea>
                </div>

                <!-- Modal Actions -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" onclick="closeRegisterModal()"
                        class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-5 py-2 rounded-lg bg-[#F05A28] hover:bg-[#D94819] text-white font-bold shadow-sm shadow-orange-500/20 active:translate-y-0.5 transition-all flex items-center gap-1.5">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span>Add Vehicle & Check-In</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 4. MODAL: SIMPLE CANCEL CONFIRMATION WITH REASON          -->
    <!-- ======================================================== -->
    <div id="cancelConfirmModal"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden"
        role="dialog" aria-modal="true">
        <div
            class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-md overflow-hidden flex flex-col transform transition-all animate-fade-in">
            <!-- Header -->
            <div class="p-5 border-b border-slate-100 flex items-start gap-3 bg-rose-50/50">
                <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-base font-bold text-slate-900">Cancel Appointment</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Are you sure you want to cancel this scheduled vehicle arrival?</p>
                </div>
                <button type="button" onclick="closeCancelModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Body -->
            <div class="p-5 space-y-4 text-xs">
                <!-- Target Vehicle Card -->
                <div class="p-3 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-between">
                    <div>
                        <div class="font-mono font-bold text-slate-900 text-xs tracking-wider" id="cancelTargetPlate">WP CAK-9021</div>
                        <div class="text-[11px] text-slate-500" id="cancelTargetVehicle">Honda Vezel RU1</div>
                    </div>
                    <div class="text-right">
                        <div class="font-semibold text-slate-800" id="cancelTargetCustomer">Kamal Perera</div>
                        <div class="text-[10px] text-slate-400">Scheduled Arrival</div>
                    </div>
                </div>

                <!-- Simple Reason -->
                <div>
                    <label for="cancelReasonInput" class="block font-bold text-slate-700 mb-1.5">
                        Reason for Cancellation <span class="text-rose-500">*</span>
                    </label>
                    <textarea id="cancelReasonInput" rows="2" required
                        placeholder="Please enter the reason for cancellation..."
                        class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg focus:ring-1 focus:ring-rose-500 focus:border-rose-500 outline-none text-slate-800 placeholder-slate-400 leading-relaxed"></textarea>
                    
                    <!-- Quick Reason Chips -->
                    <div class="flex flex-wrap items-center gap-1.5 mt-2">
                        <span class="text-[10px] text-slate-400 font-medium mr-1">Quick select:</span>
                        <button type="button" onclick="setQuickCancelReason('Customer requested cancellation')" class="px-2 py-0.5 rounded bg-slate-100 hover:bg-slate-200 text-slate-600 text-[10px] transition-colors">Customer requested</button>
                        <button type="button" onclick="setQuickCancelReason('Customer no-show')" class="px-2 py-0.5 rounded bg-slate-100 hover:bg-slate-200 text-slate-600 text-[10px] transition-colors">No show</button>
                        <button type="button" onclick="setQuickCancelReason('Vehicle breakdown / unavailable')" class="px-2 py-0.5 rounded bg-slate-100 hover:bg-slate-200 text-slate-600 text-[10px] transition-colors">Vehicle unavailable</button>
                        <button type="button" onclick="setQuickCancelReason('Rescheduled to another date')" class="px-2 py-0.5 rounded bg-slate-100 hover:bg-slate-200 text-slate-600 text-[10px] transition-colors">Rescheduled</button>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <button type="button" onclick="closeCancelModal()"
                    class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-100 font-semibold text-xs transition-colors">
                    Back
                </button>
                <button type="button" onclick="confirmCancelArrival()"
                    class="px-4 py-2 rounded-lg bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-xs transition-colors">
                    Confirm Cancellation
                </button>
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
        <span id="toastMsg">Operation successful!</span>
    </div>

    <!-- Client-side Interactive Script -->
    <script>
        // Mobile Sidebar Drawer Toggle
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

        // Check-in Action
        function handleCheckIn(btn, plate, customer, vehicle) {
            const row = btn ? btn.closest('tr') : null;
            if (row) {
                row.classList.add('bg-emerald-50/50');
                const actionTd = row.querySelector('td:last-child');
                if (actionTd) {
                    actionTd.innerHTML = `
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[11px] font-bold text-emerald-700 bg-emerald-100/80 border border-emerald-300 rounded shadow-2xs">
                            <svg class="w-3 h-3 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            Checked In
                        </span>
                    `;
                }
            }
            showToast(`Checked in ${plate} (${customer}) - Queued for Intake Bay #01`);
        }

        // Cancel Confirmation Modal State & Handlers
        let pendingCancelRow = null;
        let pendingCancelPlate = '';
        let pendingCancelCustomer = '';
        let pendingCancelVehicle = '';

        function openCancelModal(btn, plate, customer, vehicle) {
            pendingCancelRow = btn ? btn.closest('tr') : null;
            pendingCancelPlate = plate;
            pendingCancelCustomer = customer;
            pendingCancelVehicle = vehicle;

            document.getElementById('cancelTargetPlate').textContent = plate;
            document.getElementById('cancelTargetVehicle').textContent = vehicle;
            document.getElementById('cancelTargetCustomer').textContent = customer;
            const reasonInput = document.getElementById('cancelReasonInput');
            reasonInput.value = '';

            document.getElementById('cancelConfirmModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            setTimeout(() => {
                reasonInput.focus();
            }, 60);
        }

        function closeCancelModal() {
            document.getElementById('cancelConfirmModal').classList.add('hidden');
            document.body.style.overflow = '';
            pendingCancelRow = null;
        }

        function setQuickCancelReason(text) {
            const input = document.getElementById('cancelReasonInput');
            if (input) {
                input.value = text;
                input.focus();
            }
        }

        function confirmCancelArrival() {
            const reasonInput = document.getElementById('cancelReasonInput');
            const reason = reasonInput ? reasonInput.value.trim() : '';

            if (!reason) {
                if (reasonInput) reasonInput.focus();
                showToast('Please specify a reason for cancellation');
                return;
            }

            if (pendingCancelRow) {
                pendingCancelRow.style.transition = 'all 0.3s ease';
                pendingCancelRow.style.opacity = '0';
                pendingCancelRow.style.transform = 'translateX(25px)';
                setTimeout(() => {
                    if (pendingCancelRow) {
                        pendingCancelRow.remove();
                        filterTableRows();
                    }
                }, 300);
            }

            showToast(`Arrival for ${pendingCancelPlate} cancelled (${reason})`);
            closeCancelModal();
        }

        // Row Action / Express Check-in
        function handleRowAction(plate, customer, vehicle, description) {
            showToast(`Initiating intake triage for ${customer} (${plate})`);
        }

        // Filter Rows
        function filterTableRows() {
            const query = document.getElementById('filterInput').value.toLowerCase().trim();
            const slot = document.getElementById('timeSlotSelect').value;
            const rows = document.querySelectorAll('#arrivalsTableBody .arrival-row');
            let visibleCount = 0;

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                let matchesQuery = !query || text.includes(query);
                let matchesSlot = true;

                if (slot === 'morning') {
                    matchesSlot = text.includes('am');
                } else if (slot === 'afternoon') {
                    matchesSlot = text.includes('pm');
                }

                if (matchesQuery && matchesSlot) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            document.getElementById('visibleRowCount').textContent = visibleCount;
            document.getElementById('activeCountBadge').textContent = `${visibleCount} active`;
        }

        // Global Search
        function handleGlobalSearch(e) {
            const query = e.target.value;
            const filterInput = document.getElementById('filterInput');
            filterInput.value = query;
            filterTableRows();
        }

        // Full Schedule View Toggle
        function showFullDaySchedule() {
            const timeSelect = document.getElementById('timeSlotSelect');
            timeSelect.value = 'all';
            filterTableRows();
            showToast('Showing all 18 scheduled arrivals across morning & afternoon bays');
        }

        // Station Lock Simulation
        function lockStation() {
            if (confirm('Lock Front Desk Intake Station #01 and return to staff login?')) {
                window.location.href = '/login';
            }
        }

        // Modal Handlers & Customer Database
        const knownCustomers = [
            { id: 'C-1001', name: 'Kamal Perera', phone: '+94 77 123 4567', email: 'kamal.p@gmail.com', initials: 'KP', avatarBg: 'bg-emerald-600' },
            { id: 'C-1051', name: 'Dilshan Fernando', phone: '+94 77 445 0918', email: 'dilshan.f@outlook.com', initials: 'DF', avatarBg: 'bg-blue-600' },
            { id: 'C-1052', name: 'Anushka Wickramasinghe', phone: '+94 76 332 9940', email: 'anushka.w@ceylonrubber.com', initials: 'AW', avatarBg: 'bg-amber-600' },
            { id: 'C-1054', name: 'Chathurika Jayawardena', phone: '+94 77 908 1222', email: 'chathurika.j@yahoo.com', initials: 'CJ', avatarBg: 'bg-slate-800' },
            { id: 'C-1055', name: 'Nimal Siriwardena', phone: '+94 71 556 7788', email: 'nimal.s@sltnet.lk', initials: 'NS', avatarBg: 'bg-purple-600' },
            { id: 'C-1056', name: 'Rohan De Silva', phone: '+94 77 654 3210', email: 'rohan.desilva@lankaauto.lk', initials: 'RD', avatarBg: 'bg-teal-600' }
        ];

        let customerMode = 'existing'; // 'existing' | 'new'
        let selectedCustomer = null;

        function setCustomerMode(mode) {
            customerMode = mode;
            const tabExisting = document.getElementById('tabExistingCust');
            const tabNew = document.getElementById('tabNewCust');
            const existingSec = document.getElementById('existingCustomerSection');
            const newSec = document.getElementById('newCustomerSection');
            const newCustName = document.getElementById('newCustName');
            const newCustEmail = document.getElementById('newCustEmail');

            if (mode === 'existing') {
                tabExisting.className = 'px-2.5 py-1 rounded-md text-[11px] font-semibold bg-[#F05A28] text-white transition-all shadow-xs';
                tabNew.className = 'px-2.5 py-1 rounded-md text-[11px] font-medium text-slate-600 hover:text-slate-900 transition-all';
                existingSec.classList.remove('hidden');
                newSec.classList.add('hidden');
                if (newCustName) newCustName.required = false;
                if (newCustEmail) newCustEmail.required = false;
            } else {
                tabNew.className = 'px-2.5 py-1 rounded-md text-[11px] font-semibold bg-[#F05A28] text-white transition-all shadow-xs';
                tabExisting.className = 'px-2.5 py-1 rounded-md text-[11px] font-medium text-slate-600 hover:text-slate-900 transition-all';
                newSec.classList.remove('hidden');
                existingSec.classList.add('hidden');
                if (newCustName) {
                    newCustName.required = true;
                    newCustName.focus();
                }
                if (newCustEmail) newCustEmail.required = true;
            }
        }

        function searchExistingCustomers(e) {
            const query = (e ? e.target.value : '').toLowerCase().trim();
            const resultsBox = document.getElementById('custSearchResults');
            const clearBtn = document.getElementById('clearCustSearchBtn');
            if (clearBtn) clearBtn.classList.toggle('hidden', !query);

            if (!query) {
                resultsBox.classList.add('hidden');
                resultsBox.innerHTML = '';
                return;
            }

            const matches = knownCustomers.filter(c =>
                c.name.toLowerCase().includes(query) ||
                c.phone.toLowerCase().includes(query) ||
                c.email.toLowerCase().includes(query)
            );

            if (matches.length === 0) {
                resultsBox.innerHTML = `
                    <div class="p-3 text-center text-slate-500">
                        <p>No customer found matching "${query}"</p>
                        <button type="button" onclick="setCustomerMode('new')" class="mt-1 text-xs text-[#F05A28] font-bold hover:underline">
                            + Add as new customer
                        </button>
                    </div>
                `;
                resultsBox.classList.remove('hidden');
                return;
            }

            resultsBox.innerHTML = matches.map(c => `
                <div onclick="selectExistingCustomer('${c.id}')"
                    class="p-2.5 hover:bg-orange-50/50 cursor-pointer flex items-center justify-between transition-colors">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-full ${c.avatarBg} text-white font-bold text-xs flex items-center justify-center shrink-0">
                            ${c.initials}
                        </div>
                        <div>
                            <div class="font-bold text-slate-900">${c.name}</div>
                            <div class="text-[11px] text-slate-500">${c.phone} • ${c.email}</div>
                        </div>
                    </div>
                    <span class="text-[11px] font-semibold text-[#F05A28] bg-orange-50 px-2 py-0.5 rounded border border-orange-200">
                        Select
                    </span>
                </div>
            `).join('');
            resultsBox.classList.remove('hidden');
        }

        function selectExistingCustomer(id) {
            const cust = knownCustomers.find(c => c.id === id);
            if (!cust) return;

            selectedCustomer = cust;
            document.getElementById('custSearchResults').classList.add('hidden');
            document.getElementById('custSearchInput').parentElement.classList.add('hidden');

            const card = document.getElementById('selectedCustCard');
            document.getElementById('selectedCustAvatar').textContent = cust.initials;
            document.getElementById('selectedCustAvatar').className = `w-8 h-8 rounded-full ${cust.avatarBg} text-white font-bold text-xs flex items-center justify-center shrink-0`;
            document.getElementById('selectedCustName').textContent = cust.name;
            document.getElementById('selectedCustPhone').textContent = cust.phone;
            document.getElementById('selectedCustEmail').textContent = cust.email;
            card.classList.remove('hidden');
        }

        function clearSelectedCustomer() {
            selectedCustomer = null;
            document.getElementById('selectedCustCard').classList.add('hidden');
            const searchWrap = document.getElementById('custSearchInput').parentElement;
            searchWrap.classList.remove('hidden');
            const searchInput = document.getElementById('custSearchInput');
            searchInput.value = '';
            searchInput.focus();
            document.getElementById('clearCustSearchBtn')?.classList.add('hidden');
            document.getElementById('custSearchResults').classList.add('hidden');
        }

        function clearCustomerSearch() {
            const searchInput = document.getElementById('custSearchInput');
            searchInput.value = '';
            document.getElementById('clearCustSearchBtn')?.classList.add('hidden');
            document.getElementById('custSearchResults').classList.add('hidden');
            searchInput.focus();
        }

        function openRegisterModal() {
            document.getElementById('registerModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            setCustomerMode('existing');
            if (!selectedCustomer) {
                setTimeout(() => {
                    document.getElementById('custSearchInput')?.focus();
                }, 50);
            }
        }

        function closeRegisterModal() {
            document.getElementById('registerModal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Add New Vehicle Registration to Intake Stream
        function handleNewRegistration(e) {
            e.preventDefault();

            let customerName = '';
            let customerEmail = '';
            let customerPhone = '';

            if (customerMode === 'existing') {
                if (!selectedCustomer) {
                    showToast('Please search & select an existing customer or switch to "+ New Customer"');
                    document.getElementById('custSearchInput')?.focus();
                    return;
                }
                customerName = selectedCustomer.name;
                customerEmail = selectedCustomer.email;
                customerPhone = selectedCustomer.phone;
            } else {
                customerName = document.getElementById('newCustName').value.trim();
                customerEmail = document.getElementById('newCustEmail').value.trim();
                customerPhone = document.getElementById('newCustPhone').value.trim() || '+94 77 000 0000';

                if (!customerName || !customerEmail) {
                    showToast('Please enter both customer name and email');
                    return;
                }
            }

            const plate = document.getElementById('regPlateNo').value.trim().toUpperCase();
            const make = document.getElementById('regMake').value.trim();
            const model = document.getElementById('regModel').value.trim();
            const mileage = document.getElementById('regMileage').value.trim();
            const vin = document.getElementById('regVIN').value.trim().toUpperCase();
            const service = document.getElementById('regServiceDesc').value.trim();

            const fullVehicleName = `${make} ${model}`;

            // Parse plate province e.g. "WP CBA-1234" -> "WP" & "CBA-1234"
            let province = 'WP';
            let plateNum = plate;
            const provinces = ['WP', 'CP', 'SP', 'NW', 'NC', 'SG', 'VA', 'EP', 'NP'];
            for (const p of provinces) {
                if (plate.startsWith(p)) {
                    province = p;
                    plateNum = plate.substring(p.length).trim();
                    break;
                }
            }

            const tbody = document.getElementById('arrivalsTableBody');
            const now = new Date();
            let hours = now.getHours();
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12;
            const timeStr = `${String(hours).padStart(2, '0')}:${minutes} ${ampm}`;

            const tr = document.createElement('tr');
            tr.className = 'hover:bg-slate-50/70 transition-colors arrival-row cursor-pointer bg-orange-50/30';
            tr.onclick = () => handleRowAction(plate, customerName, fullVehicleName, service);
            tr.innerHTML = `
                <td class="py-3.5 px-4 sm:px-6 whitespace-nowrap">
                    <div class="font-bold text-[#0F172A] text-xs">${timeStr}</div>
                    <div class="text-[10px] text-orange-600 font-semibold mt-0.5">Express Check-in</div>
                </td>
                <td class="py-3.5 px-4 sm:px-6">
                    <div class="font-bold text-[#0F172A] text-xs">${customerName}</div>
                    <div class="text-[11px] text-slate-400 font-mono mt-0.5">${customerPhone}</div>
                </td>
                <td class="py-3.5 px-4 sm:px-6 whitespace-nowrap">
                    <div class="sl-plate-badge">
                        <span class="province">${province}</span>${plateNum}
                    </div>
                    <div class="text-[11px] text-slate-500 mt-1">${fullVehicleName}</div>
                </td>
                <td class="py-3.5 px-4 sm:px-6">
                    <div class="text-slate-800 font-medium">${service}</div>
                    <div class="text-[10px] text-slate-400 mt-0.5 font-mono">Mileage: ${parseInt(mileage || 0).toLocaleString()} km • VIN: ${vin}</div>
                </td>
                <td class="py-3.5 px-4 sm:px-6 text-right whitespace-nowrap" onclick="event.stopPropagation()">
                    <div class="flex items-center justify-end gap-1.5">
                        <button type="button" onclick="handleCheckIn(this, '${plate}', '${customerName}', '${fullVehicleName}')"
                            class="px-2.5 py-1 text-[11px] font-bold text-white bg-[#F05A28] hover:bg-[#D94819] rounded shadow-2xs transition-colors">
                            Check In
                        </button>
                        <button type="button" onclick="openCancelModal(this, '${plate}', '${customerName}', '${fullVehicleName}')"
                            class="px-2.5 py-1 text-[11px] font-semibold text-rose-600 hover:text-rose-700 hover:bg-rose-50 rounded border border-rose-200 transition-colors">
                            Cancel
                        </button>
                    </div>
                </td>
            `;

            tbody.prepend(tr);
            closeRegisterModal();
            document.getElementById('newVehicleForm')?.reset();
            clearSelectedCustomer();
            filterTableRows();
            showToast(`Vehicle ${plate} (${fullVehicleName}) registered for ${customerName}!`);
        }

        // Toast Helper
        function showToast(msg) {
            const toast = document.getElementById('toast');
            const toastMsg = document.getElementById('toastMsg');
            toastMsg.textContent = msg;
            toast.classList.remove('translate-y-20', 'opacity-0');
            setTimeout(() => {
                toast.classList.add('translate-y-20', 'opacity-0');
            }, 3500);
        }

        // Close modal on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeRegisterModal();
                closeCancelModal();
                toggleMobileSidebar(false);
            }
        });
    </script>
</body>

</html>