@php
    $navLink = 'text-white no-underline text-xl py-2.5 px-[18px] flex items-center gap-2 rounded-full transition-all duration-250 hover:text-[#66A6FF] hover:bg-[#1B3A6B] hover:-translate-y-px hover:font-bold active:scale-[.97]';
    $navActive = 'text-[#66A6FF] bg-[#1B3A6B] font-bold';
    $dropLink = 'block no-underline text-[#C9DAF8] py-[11px] px-3.5 rounded-[10px] text-[13px] font-medium transition-all duration-200 hover:bg-white/10 hover:backdrop-blur-md hover:text-[#66A6FF]';
    $dropActive = 'bg-white/10 backdrop-blur-md text-[#66A6FF]';
    $dropdownPanel = 'absolute top-[120%] left-1/2 -translate-x-1/2 translate-y-2.5 w-[220px] bg-white/[.06] backdrop-blur-xl border border-white/10 rounded-[18px] shadow-[0_20px_45px_rgba(0,0,0,.35),inset_0_1px_0_rgba(255,255,255,.05)] p-2.5 opacity-0 invisible transition-all duration-300 z-[999] group-hover:opacity-100 group-hover:visible group-hover:translate-y-0';

    $isDashboard = request()->routeIs('hr.dashboard');
    $isWorkforce = request()->routeIs('hr.employees.*') || request()->routeIs('hr.departments.*');
    $isEmployees = request()->routeIs('hr.employees.index') || request()->routeIs('hr.employees.show') || request()->routeIs('hr.employees.create');
    $isDepartments = request()->routeIs('hr.departments.*');
    $isOnboarding = request()->routeIs('hr.onboarding.*');
    $isReports = request()->routeIs('hr.reports-analytics.*');
    $isAttendance = request()->routeIs('hr.reports-analytics.attendance-overview') || request()->routeIs('hr.reports-analytics.employee-attendance');
    $isLeave = request()->routeIs('hr.reports-analytics.leave');

    $isEmployeeManagement = request()->routeIs('hr.leave-management.*');
    $isLeaveManagement = request()->routeIs('hr.leave-management.*');
@endphp

<header class="flex min-h-24 flex-col items-center justify-center gap-4 bg-[#0B1E3D] px-4 py-4 shadow-lg lg:h-32 lg:flex-row lg:justify-between lg:pl-4 lg:pr-12 lg:py-0 border-b border-white/5 sticky top-0 z-[1000]">
    <x-client-brand :nexora-src="asset('images/logo.png')" />

    <div class="flex w-full flex-wrap items-center justify-center gap-4 sm:gap-6 lg:w-auto lg:flex-nowrap lg:justify-end lg:gap-16">
        <nav class="flex flex-wrap items-center justify-center gap-x-4 gap-y-2 text-sm font-medium sm:gap-x-6 sm:text-base lg:flex-nowrap lg:gap-8">
            <div class="relative group">
                <a href="{{ route('hr.dashboard') }}"
                   class="{{ $isDashboard ? 'font-bold text-[#60A5FA]' : 'text-white/70 transition hover:text-white' }}">
                    Dashboard
                </a>
            </div>

            <div class="relative group">
                <a href="#"
                   class="flex items-center gap-1 {{ $isWorkforce ? 'font-bold text-[#60A5FA]' : 'text-white/70 transition hover:text-white' }}">
                    Workforce
                    <svg class="w-3.5 h-3.5 opacity-80 transition-transform duration-300 origin-center group-hover:rotate-180 group-hover:opacity-100" viewBox="0 0 24 24" fill="none">
                        <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <div class="{{ $dropdownPanel }}">
                    <a href="{{ route('hr.employees.index') }}"
                       class="{{ $dropLink }} {{ $isEmployees ? $dropActive : '' }}">Employee List</a>
                    <a href="{{ route('hr.departments.index') }}"
                       class="{{ $dropLink }} {{ $isDepartments ? $dropActive : '' }}">Department List</a>
                </div>
            </div>

            <div class="relative group">
                <a href="{{ route('hr.onboarding.step1') }}"
                   class="{{ $isOnboarding ? 'font-bold text-[#60A5FA]' : 'text-white/70 transition hover:text-white' }}">
                    Employee Onboarding
                </a>
            </div>

            <div class="relative group">
                <a href="#"
                   class="flex items-center gap-1 {{ $isReports ? 'font-bold text-[#60A5FA]' : 'text-white/70 transition hover:text-white' }}">
                    Reports and Analytics
                    <svg class="w-3.5 h-3.5 opacity-80 transition-transform duration-300 origin-center group-hover:rotate-180 group-hover:opacity-100" viewBox="0 0 24 24" fill="none">
                        <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <div class="{{ $dropdownPanel }}">
                    <a href="{{ route('hr.reports-analytics.attendance-overview') }}"
                       class="{{ $dropLink }} {{ $isAttendance ? $dropActive : '' }}">Attendance Record</a>
                    <a href="{{ route('hr.reports-analytics.leave') }}"
                       class="{{ $dropLink }} {{ $isLeave ? $dropActive : '' }}">Leave Record</a>
                </div>
            </div>

            <div class="relative group">
                <a href="#"
                   class="flex items-center gap-1 {{ $isEmployeeManagement ? 'font-bold text-[#60A5FA]' : 'text-white/70 transition hover:text-white' }}">
                    Employee Management
                    <svg class="w-3.5 h-3.5 opacity-80 transition-transform duration-300 origin-center group-hover:rotate-180 group-hover:opacity-100" viewBox="0 0 24 24" fill="none">
                        <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <div class="{{ $dropdownPanel }}">
                 <a href="{{ route('hr.leave-management.index') }}"
   class="{{ $dropLink }} {{ $isLeaveManagement ? $dropActive : '' }}">
    Leave Management
</a>
                    <div class="relative group/tooltip">
                        <span class="{{ $dropLink }} cursor-not-allowed opacity-70 block">
                            Resignation Management
                        </span>
                        <div class="absolute left-1/2 -translate-x-1/2 top-[115%] bg-[#132B52]/90 backdrop-blur-md text-[#C9DAF8] text-[12px] px-3 py-2 rounded-lg whitespace-nowrap shadow-lg border border-white/10 opacity-0 invisible transition-all duration-300 group-hover/tooltip:opacity-100 group-hover/tooltip:visible z-[999]">
                            This page is under construction
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="relative group" data-user-menu>
            <button type="button" class="flex items-center transition hover:scale-105" data-user-menu-button aria-label="Open user menu">
                <img src="{{ asset('images/icon.png') }}" alt="User" class="h-9 w-9 object-contain">
            </button>

            <div class="invisible absolute right-0 top-12 z-[1100] w-[200px] translate-y-[-10px] overflow-hidden rounded-lg bg-white opacity-0 shadow-2xl transition group-hover:visible group-hover:translate-y-0 group-hover:opacity-100" data-user-menu-dropdown>
                <a href="{{ route('employee.portal') }}" class="block px-5 py-4 text-sm font-semibold text-[#0B1E3D] transition hover:bg-slate-100">Employee Dashboard</a>
                <form method="POST" action="{{ route('hr.logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-5 py-4 text-sm font-semibold text-[#DC2626] transition hover:bg-slate-100">Log Out</button>
                </form>
            </div>
        </div>
    </div>
</header>
