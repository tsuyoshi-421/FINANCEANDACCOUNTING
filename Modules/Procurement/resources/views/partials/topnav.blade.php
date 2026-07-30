@php
    $navUserName = session('employee_name', auth()->user()->name ?? 'Employee');
    $navUserEmail = auth()->user()->email ?? session('employee_email', '');
    $navUserRole = ucfirst(str_replace('_', ' ', auth()->user()->role ?? session('employee_role', 'Employee')));
    $navParts = preg_split('/\s+/', trim($navUserName)) ?: [];
    $navInitials = strtoupper(substr($navParts[0] ?? 'E', 0, 1) . (count($navParts) > 1 ? substr(end($navParts), 0, 1) : ''));
@endphp
<header class="flex min-h-24 flex-col items-center justify-center gap-4 bg-[#0B1E3D] px-4 py-4 shadow-lg lg:h-32 lg:flex-row lg:justify-between lg:pl-4 lg:pr-12 lg:py-0" style="border-bottom: 2px solid #1B3A6B; z-index:100;">
    <x-client-brand :nexora-src="asset('images/procurement-banner.png')" />

    <div class="flex w-full flex-wrap items-center justify-center gap-4 sm:gap-6 lg:w-auto lg:flex-nowrap lg:justify-end lg:gap-16">
        <strong class="text-white text-lg tracking-wide hidden lg:block">Procurement</strong>

        <div class="relative" data-user-menu>
            <button type="button" class="flex items-center transition hover:scale-105 rounded-full overflow-hidden w-9 h-9 border border-white/20 bg-[#4A9EE8]/20 text-white justify-center" data-user-menu-button aria-label="Open profile menu" onclick="toggleProfileMenu(event)">
                <span class="text-sm font-semibold">{{ $navInitials }}</span>
            </button>
            <div class="profile-dropdown" id="profile-dropdown" style="margin-top:10px;">
                <div class="profile-header">
                    <span class="avatar-initials lg">{{ $navInitials }}</span>
                    <div class="profile-id">
                        <strong>{{ $navUserName }}</strong>
                        @if($navUserEmail)<div class="profile-email">{{ $navUserEmail }}</div>@endif
                        <span class="profile-role">{{ $navUserRole }}</span>
                    </div>
                </div>

                <button type="button" class="theme-switch-row" onclick="toggleTheme()">
                    <span class="tsr-label">
                        <svg class="theme-icon-sun" width="16" height="16" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="4.2" stroke="currentColor" stroke-width="2"/><path d="M12 2v2.5M12 19.5V22M4.2 4.2l1.8 1.8M18 18l1.8 1.8M2 12h2.5M19.5 12H22M4.2 19.8l1.8-1.8M18 6l1.8-1.8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        <svg class="theme-icon-moon" width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M21 12.8A8.5 8.5 0 1 1 11.2 3a6.6 6.6 0 0 0 9.8 9.8z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
                        Dark Mode
                    </span>
                    <span class="theme-switch"><span class="theme-switch-knob"></span></span>
                </button>

                <form method="POST" action="{{ route('procurement.logout') }}">
                    @csrf
                    <button type="submit" class="profile-logout">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
