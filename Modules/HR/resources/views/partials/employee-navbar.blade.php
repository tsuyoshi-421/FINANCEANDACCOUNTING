    @php
        $navLink = 'text-white no-underline text-xl py-2.5 px-[18px] flex items-center gap-2 rounded-full transition-all duration-250 hover:text-[#66A6FF] hover:bg-[#1B3A6B] hover:-translate-y-px hover:font-bold active:scale-[.97]';
        $navActive = 'text-[#66A6FF] bg-[#1B3A6B] font-bold';
        $dropLink = 'block no-underline text-[#C9DAF8] py-[11px] px-3.5 rounded-[10px] text-[13px] font-medium transition-all duration-200 hover:bg-[#f3f6fb] hover:text-[#2D7EFF]';
        $dropActive = 'bg-[#f3f6fb] text-[#2D7EFF]';

        $isDashboard = request()->routeIs('employee.dashboard');
        $isProfile = request()->routeIs('employee.profile');
        $isEmployees = request()->routeIs('employees.index') || request()->routeIs('employees.show') || request()->routeIs('employees.create');
        $isDepartments = request()->routeIs('hr.departments.*');
        $isOnboarding = request()->routeIs('hr.onboarding.*');
        $isReports = request()->routeIs('hr.reports-analytics.*');
        $isAttendance = request()->routeIs('hr.reports-analytics.attendance-overview') || request()->routeIs('hr.reports-analytics.employee-attendance');
        $isLeave = request()->routeIs('hr.reports-analytics.leave');
    @endphp

    <header class="flex min-h-24 flex-col items-center justify-center gap-4 bg-[#0B1E3D] px-4 py-4 shadow-lg lg:h-32 lg:flex-row lg:justify-between lg:pl-4 lg:pr-12 lg:py-0 border-b border-white/5 sticky top-0 z-[1000]">
    <x-client-brand :nexora-src="asset('images/logo.png')" />

    <div class="flex w-full flex-wrap items-center justify-center gap-4 sm:gap-6 lg:w-auto lg:flex-nowrap lg:justify-end lg:gap-16">
        <nav class="flex flex-wrap items-center justify-center gap-x-4 gap-y-2 text-sm font-medium sm:gap-x-6 sm:text-base lg:flex-nowrap lg:gap-8">
            <div class="relative group">
                <a href="{{ route('hr.employee.dashboard') }}"
                class="{{ $isDashboard ? 'font-bold text-[#60A5FA]' : 'text-white/70 transition hover:text-white' }}">
                    Dashboard
                </a>
            </div>

            <div class="relative group">
                <a href="{{ route('hr.employee.profile') }}"
                class="{{ $isProfile ? 'font-bold text-[#60A5FA]' : 'text-white/70 transition hover:text-white' }}">
                    Profile
                </a>
            </div>

            <div class="relative group">
                <a href="{{ route('hr.employee.attendance') }}"
                class="{{ request()->routeIs('hr.employee.attendance') ? 'font-bold text-[#60A5FA]' : 'text-white/70 transition hover:text-white' }}">
                    Attendance
                </a>
            </div>

            <div class="relative group">
                <a href="{{ route('hr.employee.leave') }}"
                class="{{ request()->routeIs('hr.employee.leave') ? 'font-bold text-[#60A5FA]' : 'text-white/70 transition hover:text-white' }}">
                Leave Management
                </a>
            </div>

            <div class="relative group">
                <span class="text-white/50 cursor-not-allowed transition">
                    Resignation Management
                </span>

                <div class="absolute left-1/2 -translate-x-1/2 top-[115%] bg-[#132B52]/90 backdrop-blur-md text-[#C9DAF8] text-[12px] px-3 py-2 rounded-lg whitespace-nowrap shadow-lg border border-white/10 opacity-0 invisible transition-all duration-300 group-hover:opacity-100 group-hover:visible z-[999]">
                    This page is under construction
                </div>
            </div>
        </nav>

        <div class="relative group" data-user-menu>
            <button type="button" class="flex items-center transition hover:scale-105" data-user-menu-button aria-label="Open user menu">
                <img src="{{ asset('images/icon.png') }}" alt="User" class="h-9 w-9 object-contain">
            </button>

            <div class="invisible absolute right-0 top-12 z-[1100] w-[200px] translate-y-[-10px] overflow-hidden rounded-lg bg-white opacity-0 shadow-2xl transition group-hover:visible group-hover:translate-y-0 group-hover:opacity-100" data-user-menu-dropdown>
                <form method="POST" action="{{ route('hr.logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-5 py-4 text-sm font-semibold text-[#DC2626] transition hover:bg-slate-100">Log Out</button>
                </form>
            </div>
        </div>
    </div>
</header>
