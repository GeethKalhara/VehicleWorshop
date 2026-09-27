<?php
/**
 * @var string $activeRoute
 */
$activeRoute = $activeRoute ?? 'overview';
?>
<aside id="sidebar" class="fixed top-0 bottom-0 left-0 w-64 lg:w-[260px] bg-[#0D131F] text-white z-50 flex flex-col justify-between transition-transform duration-300 -translate-x-full lg:translate-x-0 lg:static lg:z-auto">
    <div class="flex flex-col">
        <div class="px-6 py-6 border-b border-slate-800/60 flex items-center justify-between">
            <a href="/customer/dashboard" class="flex items-center gap-3 group">
                <div class="w-9 h-9 rounded-xl bg-orange-500 flex items-center justify-center shadow-lg shadow-orange-500/25 group-hover:scale-105 transition-transform duration-200">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-white font-bold text-base tracking-tight leading-none">VWMS</span>
                    <span class="text-[10px] text-slate-400 font-semibold tracking-wider uppercase mt-1 leading-none">CUSTOMER PORTAL</span>
                </div>
            </a>
        </div>

        <nav class="px-4 py-5 space-y-1" aria-label="Customer Navigation">
            <div class="px-3 pb-2 text-[11px] font-semibold text-slate-400 tracking-wider uppercase">OPERATIONS</div>

            <a href="/customer/dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= $activeRoute === 'overview' ? 'bg-white/5 text-orange-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/40' ?> font-medium text-sm transition-colors">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1.5"></rect><rect x="14" y="3" width="7" height="7" rx="1.5"></rect><rect x="14" y="14" width="7" height="7" rx="1.5"></rect><rect x="3" y="14" width="7" height="7" rx="1.5"></rect></svg>
                <span>Overview</span>
            </a>

            <a href="/customer/vehicles" class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= $activeRoute === 'vehicles' ? 'bg-white/5 text-orange-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/40' ?> font-medium text-sm transition-colors">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 16H9m10 0h3v-3.15a1 1 0 0 0-.84-.99L16 11l-2.7-3.6a1 1 0 0 0-.8-.4H8.5a1 1 0 0 0-.8.4L5 11l-5.16.86a1 1 0 0 0-.84.99V16h3"></path><circle cx="6.5" cy="16.5" r="2.5"></circle><circle cx="16.5" cy="16.5" r="2.5"></circle></svg>
                <span>My Vehicles</span>
            </a>

            <a href="/customer/appointments" class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= $activeRoute === 'appointments' ? 'bg-white/5 text-orange-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/40' ?> font-medium text-sm transition-colors">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                <span>Appointments</span>
            </a>

            <a href="/customer/service-history" class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= $activeRoute === 'service-history' ? 'bg-white/5 text-orange-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/40' ?> font-medium text-sm transition-colors">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <span>Service History</span>
            </a>

            <a href="/customer/profile" class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= $activeRoute === 'profile' ? 'bg-white/5 text-orange-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/40' ?> font-medium text-sm transition-colors">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                <span>Profile</span>
            </a>
        </nav>
    </div>

    <div class="p-4 border-t border-slate-800/60">
        <a href="/login" class="flex items-center gap-3 px-3 py-2 text-xs text-slate-400 hover:text-white rounded-lg hover:bg-slate-800/30 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            <span>Log Out of Portal</span>
        </a>
    </div>
</aside>
