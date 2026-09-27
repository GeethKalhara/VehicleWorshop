<?php
/**
 * @var string $activeRoute
 * @var string $userRole
 */
$activeRoute = $activeRoute ?? 'dashboard';
$userRole = $userRole ?? 'FrontDesk';
?>
<aside id="sidebar" class="fixed top-0 bottom-0 left-0 w-64 lg:w-[260px] bg-[#0D131F] text-white z-50 flex flex-col justify-between transition-transform duration-300 -translate-x-full lg:translate-x-0 lg:static lg:z-auto">
    <div class="flex flex-col">
        <div class="px-6 py-6 border-b border-slate-800/60 flex items-center justify-between">
            <a href="/staff/dashboard" class="flex items-center gap-3 group">
                <div class="w-9 h-9 rounded-xl bg-orange-500 flex items-center justify-center shadow-lg shadow-orange-500/25 group-hover:scale-105 transition-transform duration-200">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-white font-bold text-base tracking-tight leading-none">VWMS</span>
                    <span class="text-[10px] text-slate-400 font-semibold tracking-wider uppercase mt-1 leading-none">STAFF PORTAL</span>
                </div>
            </a>
        </div>

        <nav class="px-4 py-5 space-y-1" aria-label="Staff Navigation">
            <div class="px-3 pb-2 text-[11px] font-semibold text-slate-400 tracking-wider uppercase">TERMINAL ACCESS</div>

            <?php if ($userRole === 'FrontDesk' || $userRole === 'Admin'): ?>
            <a href="/frontdesk/dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= $activeRoute === 'frontdesk' ? 'bg-white/5 text-orange-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/40' ?> font-medium text-sm transition-colors">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
                <span>Front Desk Intake</span>
            </a>
            <a href="/frontdesk/active-jobs" class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= $activeRoute === 'active-jobs' ? 'bg-white/5 text-orange-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/40' ?> font-medium text-sm transition-colors">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"></rect></svg>
                <span>Active Workshop Jobs</span>
            </a>
            <a href="/frontdesk/customers" class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= $activeRoute === 'customers' ? 'bg-white/5 text-orange-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/40' ?> font-medium text-sm transition-colors">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                <span>Customer Directory</span>
            </a>
            <?php endif; ?>

            <?php if ($userRole === 'Technician' || $userRole === 'Admin'): ?>
            <a href="/technician/workstation" class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= $activeRoute === 'technician' ? 'bg-white/5 text-orange-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/40' ?> font-medium text-sm transition-colors">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
                <span>Tech Workstation</span>
            </a>
            <a href="/technician/job-history" class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= $activeRoute === 'tech-history' ? 'bg-white/5 text-orange-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/40' ?> font-medium text-sm transition-colors">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <span>Completed Job Log</span>
            </a>
            <?php endif; ?>

            <?php if ($userRole === 'Supervisor' || $userRole === 'Admin'): ?>
            <a href="/supervisor/dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= $activeRoute === 'supervisor' ? 'bg-white/5 text-orange-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/40' ?> font-medium text-sm transition-colors">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                <span>QA & Floor Inspection</span>
            </a>
            <?php endif; ?>

            <?php if ($userRole === 'Admin'): ?>
            <a href="/admin/dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= $activeRoute === 'admin' ? 'bg-white/5 text-orange-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/40' ?> font-medium text-sm transition-colors">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                <span>Admin & System Config</span>
            </a>
            <?php endif; ?>
        </nav>
    </div>

    <div class="p-4 border-t border-slate-800/60">
        <a href="/staff/login" class="flex items-center gap-3 px-3 py-2 text-xs text-slate-400 hover:text-white rounded-lg hover:bg-slate-800/30 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            <span>Sign Out of Staff Terminal</span>
        </a>
    </div>
</aside>
