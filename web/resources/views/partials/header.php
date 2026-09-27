<?php
/**
 * @var string $title
 * @var string $userRole
 * @var string $userName
 */
$userName = $userName ?? 'User';
$userRole = $userRole ?? 'Staff';
?>
<header class="bg-white border-b border-slate-200 sticky top-0 z-30 px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between gap-4">
    <div class="flex items-center gap-3 sm:gap-4 min-w-0">
        <button type="button" class="lg:hidden p-1.5 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors" onclick="toggleMobileSidebar(true)" aria-label="Open navigation menu">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <nav class="flex items-center text-sm font-medium text-slate-500 whitespace-nowrap">
            <span class="text-slate-900 font-semibold"><?= htmlspecialchars($title ?? 'Dashboard') ?></span>
        </nav>
    </div>

    <div class="flex-1 max-w-md mx-2 sm:mx-4">
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </span>
            <input type="text" placeholder="Search system records..." class="w-full pl-9 pr-4 py-1.5 sm:py-2 text-xs sm:text-sm bg-white border border-slate-200 rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/10 transition-all shadow-sm">
        </div>
    </div>

    <div class="flex items-center gap-2 sm:gap-4 shrink-0">
        <button type="button" class="p-2 rounded-lg text-slate-500 hover:text-slate-800 hover:bg-slate-100 relative transition-colors" aria-label="Notifications">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
            <span class="absolute top-2 right-2 w-2 h-2 bg-orange-500 rounded-full ring-2 ring-white"></span>
        </button>

        <div class="relative">
            <div class="flex items-center gap-2.5 pl-1 sm:pl-2 cursor-pointer group">
                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xs sm:text-sm shadow-sm overflow-hidden">
                    <span><?= htmlspecialchars(strtoupper(substr($userName, 0, 2))) ?></span>
                </div>
                <div class="hidden sm:flex flex-col text-left leading-tight">
                    <span class="text-sm font-semibold text-slate-900 group-hover:text-orange-600 transition-colors"><?= htmlspecialchars($userName) ?></span>
                    <span class="text-[11px] text-slate-400 font-medium"><?= htmlspecialchars($userRole) ?></span>
                </div>
            </div>
        </div>
    </div>
</header>
