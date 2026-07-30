<header class="flex min-h-24 flex-col items-center justify-center gap-4 bg-[#0B1E3D] px-4 py-4 shadow-lg lg:h-32 lg:flex-row lg:justify-between lg:pl-4 lg:pr-12 lg:py-0" style="border-bottom:1px solid rgba(255,255,255,0.06); position:sticky; top:0; z-index:100;">
    <div class="flex items-center gap-4 flex-shrink-0">
        <button type="button" onclick="toggleNav()" class="text-[#9bb0d1] hover:text-white hover:bg-white/10 p-2 rounded-md transition-all flex items-center justify-center" aria-label="Toggle navigation">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="6" x2="21" y2="6"/>
                <line x1="3" y1="12" x2="21" y2="12"/>
                <line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
        </button>
        <x-client-brand :nexora-src="asset('images/nexora-banner.png')" />
    </div>

    <div class="flex w-full flex-wrap items-center justify-center gap-4 sm:gap-6 lg:w-auto lg:flex-nowrap lg:justify-end lg:gap-16">
        <nav class="flex flex-wrap items-center justify-center gap-x-4 gap-y-2 text-sm font-medium sm:gap-x-6 sm:text-base lg:flex-nowrap lg:gap-8">
            <strong class="text-white text-lg tracking-wide hidden lg:block">Inventory</strong>
        </nav>

        <div class="relative" data-user-menu>
            <button type="button" class="flex items-center transition hover:scale-105 rounded-full overflow-hidden w-9 h-9 border border-white/20 bg-[#4A9EE8]/20 text-white justify-center" onclick="toggleProfileDropdown()" id="profileTrigger" aria-label="Open profile menu">
                <img src="{{ asset('images/icon.png') }}" alt="User avatar" class="h-9 w-9 object-contain">
            </button>
            <div class="profile-dropdown" id="profileDropdown">
                <button type="button" class="profile-dropdown-close" onclick="toggleProfileDropdown()">&times;</button>
                <div class="profile-dropdown-email">{{ session('employee_email', '') }}</div>
                <div class="profile-dropdown-avatar-wrap">
                    <div class="profile-dropdown-avatar">
                        <img src="{{ asset('images/icon.png') }}" alt="User avatar">
                    </div>
                </div>
                <div class="profile-dropdown-greeting">Hi, {{ session('employee_name', 'User') }}!</div>
                <ul class="profile-dropdown-menu">
                    <li>
                        <a href="{{ route('employee.portal') }}">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Employee Portal
                        </a>
                    </li>
                    <li class="logout">
                        <form method="POST" action="{{ route('inventory.logout') }}" style="margin:0;padding:0;">
                            @csrf
                            <button type="submit">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
