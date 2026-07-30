<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nexora – Manufacturing</title>
    <link rel="icon" type="image/png" href="{{ asset('manufacturing/images/Nexora_Logo_Transparent.png') }}">
    <link rel="stylesheet" href="{{ asset('manufacturing/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('manufacturing/css/dark-mode.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('manufacturing/js/shared.js') }}"></script>
    <script src="{{ asset('manufacturing/js/table-sort.js') }}"></script>
    <script>
        tailwind.config = {
            darkMode: ['selector', '[data-theme="dark"]'],
            theme: {
                extend: {
                    colors: {
                        'nexora': {
                            'deep-navy':  '#0B1E3D',
                            'navy':       '#132B52',
                            'navy-mid':   '#1B3A6B',
                            'corporate':  '#1B6FC8',

                            'sky':        '#4A9EE8',
                            'light-blue': '#7BBEF0',
                            'ice':        '#D6ECFC',
                            'steel-blue': '#869FB1',

                            'off-white':  '#F4F6FA',
                            'slate-200':  '#E2E8F0',
                            'slate-500':  '#5B7A9D',
                            'white':      '#FFFFFF',
                            'gray':       '#9D9D9D',

                            'success':    '#16A34A',
                            'caution':    '#FBD035',
                            'warning':    '#D97706',
                            'danger':     '#DC2626',
                            'info':       '#0EA5E9',

                            'stat-green' :'#15803D',
                            'stat-yellow':'#cda101',
                            'stat-orange':'#92400E',
                            'stat-red':   '#991B1B',
                            'stat-blue':  '#1E40AF',
                        }
                    },
                    fontFamily: {
                        'heading': ['Inter Medium', 'sans-serif'],
                        'body':    ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { background-color: #1B3A6B; }
        html, body { height: 100%; }
    </style>
    @php
        $tempData = app(\Modules\Manufacturing\Services\ManufacturingDataService::class)->loadAll();

        $workOrders       = $tempData['workOrders'];
        $workers          = $tempData['workers'];
        $statusStyles     = config('manufacturing.statusStyles');
        $partStyles       = config('manufacturing.partStyles');
        $rangeStyles      = config('manufacturing.rangeStyles');
        $benchmarkTargets = $tempData['benchmarkTargets'];
        $qcSessions       = $tempData['qcSessions'];
        $reworkOrders     = $tempData['reworkOrders'];
        $requisitions     = $tempData['requisitions'];

        $tempData['statusStyles'] = $statusStyles;
        $tempData['partStyles']   = $partStyles;
        $tempData['rangeStyles']  = $rangeStyles;
        $curPage = request()->get('page', 'dashboard');
        $curSub  = request()->get('sub', '');
    @endphp
</head>
<body class="font-body text-white flex flex-col h-full bg-white dark:bg-[#0F1923] transition-colors duration-150">

    {{-- Header --}}
    <header class="flex min-h-24 flex-col items-center justify-center gap-4 bg-[#0B1E3D] px-4 py-4 shadow-lg lg:h-32 lg:flex-row lg:justify-between lg:pl-4 lg:pr-12 lg:py-0" style="border-bottom: 2px solid #1B3A6B; z-index:100; width:100%;">
        <div class="flex items-center gap-4">
            <x-client-brand :nexora-src="asset('manufacturing/images/Banner Transparent.png')" nexora-href="" />
        </div>

        <div class="flex w-full flex-wrap items-center justify-center gap-4 sm:gap-6 lg:w-auto lg:flex-nowrap lg:justify-end lg:gap-16">
            <nav class="flex flex-wrap items-center justify-center gap-x-4 gap-y-2 text-sm font-medium sm:gap-x-6 sm:text-base lg:flex-nowrap lg:gap-8">
                @php
                    $navItems = [
                        ['label' => 'Dashboard',    'href' => '?page=dashboard', 'active' => $curPage === 'dashboard'],
                        ['label' => 'Quality Check','href' => '?page=qc',        'active' => $curPage === 'qc'],
                        ['label' => 'Work Orders',  'href' => '?page=orders',    'active' => $curPage === 'orders'],
                        ['label' => 'Reports',      'href' => '?page=reports',   'active' => $curPage === 'reports'],
                    ];
                @endphp

                @foreach($navItems as $item)
                    <a href="{{ $item['href'] }}" class="{{ $item['active'] ? 'font-bold text-[#60A5FA]' : 'text-white/70 transition hover:text-white' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="relative group" data-user-menu>
                <button type="button" class="flex items-center transition hover:scale-105 rounded-full overflow-hidden w-9 h-9 border border-white/20 bg-[#4A9EE8]/20 text-white justify-center" onclick="toggleProfileDropdown()" id="profileTrigger" aria-label="Open profile menu">
                    <img src="{{ asset('images/icon.png') }}" alt="User avatar" class="h-9 w-9 object-contain">
                </button>
            </div>
        </div>
    </header>

    {{-- Sidebar/Main --}}
    <div class="flex flex-1 overflow-hidden gap-1 max-h-[98%] max-w-[99%] m-4">
    @if($curPage != 'dashboard' && $curPage != 'reports')
        {{-- Sidebar --}}
        <aside class="w-44 bg-nexora-off-white dark:bg-[#1A2332] border-[1px] border-nexora-corporate dark:border-[#334155] flex flex-col flex-shrink-0 rounded-lg max-w-full min-h-full mx-auto ml-1">
            <nav class="flex-1 flex flex-col pt-[40%] px-3 space-y-0.5 text-sm">
                {{-- Quality Check Sub Tabs --}}
                @if($curPage === 'qc')
                    <script src="{{ asset('manufacturing/js/benchmark.js') }}"></script>
                    @php
                        $qcSubs = [
                            ['label' => 'Benchmark',  'sub' => 'benchmark'],
                            ['label' => 'Rework',     'sub' => 'rework'],
                            ['label' => 'Analytics',  'sub' => 'analytics'],
                        ];
                    @endphp
                    @foreach($qcSubs as $tab)
                        <a href="?page=qc&sub={{ $tab['sub'] }}"
                           class="flex gap-4 pb-4 px-3 py-2 rounded-md font-medium transition-colors duration-150
                                  {{ ($curSub === $tab['sub'] || ($curSub === '' && $tab['sub'] === 'benchmark'))
                                      ? 'bg-nexora-sky text-white'
                                      : 'text-nexora-slate-500 hover:bg-nexora-light-blue hover:text-white hover:shadow-md hover:-translate-y-[1px]' }}">
                            @if ($tab['label'] === 'Benchmark')
                                <span class="inline-block" aria-hidden="true">&#8226;</span>
                            @elseif ($tab['label'] === 'Rework')
                                <span class="inline-block" aria-hidden="true">&#8226;</span>
                            @elseif ($tab['label'] === 'Analytics')
                                <span class="inline-block" aria-hidden="true">&#8226;</span>
                            @endif
                            {{ $tab['label'] }}
                        </a>
                    @endforeach
                @endif

                {{-- Work Orders Sub Tabs --}}
                @if($curPage === 'orders')
                    <script src="{{ asset('manufacturing/js/status.js') }}"></script>
                    <script src="{{ asset('manufacturing/js/assignment.js') }}"></script>
                    <script src="{{ asset('manufacturing/js/schedule.js') }}"></script>
                    @php
                        $orderSubs = [
                            ['label' => 'All Orders', 'sub' => 'all'],
                            ['label' => 'Status', 'sub' => 'status'],
                            ['label' => 'Schedule',   'sub' => 'schedule'],
                            ['label' => 'BOMs',       'sub' => 'boms'],
                            ['label' => 'Assignment', 'sub' => 'assignment'],
                        ];
                    @endphp

                    @foreach($orderSubs as $tab)
                        <a href="{{ '?page=orders&sub='.$tab['sub'] }}"
                           class="flex gap-4 px-3 py-2 pb-4 items-center rounded-md font-medium transition-colors duration-150
                                  {{ ($curSub === $tab['sub'] || ($curSub === '' && $tab['sub'] === 'all'))
                                      ? 'bg-nexora-sky text-white'
                                      : 'text-nexora-slate-500 hover:bg-nexora-light-blue hover:text-white hover:shadow-md hover:-translate-y-[1px]' }}">
                            @if ($tab['label'] === 'All Orders')
                                <span class="inline-block" aria-hidden="true">&#8226;</span>
                            @elseif ($tab['label'] === 'Status')
                                <span class="inline-block" aria-hidden="true">&#8226;</span>
                            @elseif ($tab['label'] === 'Schedule')
                                <span class="inline-block" aria-hidden="true">&#8226;</span>
                            @elseif ($tab['label'] === 'BOMs')
                                <span class="inline-block" aria-hidden="true">&#8226;</span>
                            @elseif ($tab['label'] === 'Assignment')
                                <span class="inline-block" aria-hidden="true">&#8226;</span>
                            @endif
                            {{ $tab['label'] }}
                        </a>
                    @endforeach
                @endif

            </nav>
        </aside>
    @endif
        {{-- Main Content --}}
        <main class="flex flex-col h-full h-full mx-auto w-full">
            <div class="flex-1 h-full p-4 bg-nexora-off-white border-[1px] border-nexora-corporate rounded-lg overflow-y-auto [&::-webkit-scrollbar]:hidden">
                {{-- Dashboard --}}
                @if($curPage === 'dashboard')
                    @include('manufacturing::dashboard')
                    {{-- Reports --}}
                @elseif($curPage === 'reports')
                    @include('manufacturing::reports')
                {{-- Work Orders --}}
                @elseif($curPage === 'orders')
                @php
                    $subName = 'All Orders';

                    foreach ($orderSubs as $tab) {
                        if ($tab['sub'] === $curSub) {
                            $subName = $tab['label'];
                            break;
                        }
                    }
                @endphp
                    {{-- All Orders --}}
                    @if($curSub === 'all' || $curSub === '')
                        @include('manufacturing::workorder.allorder')
                    {{-- Status --}}
                    @elseif ($curSub === 'status')
                        @include('manufacturing::workorder.status')
                    {{-- Schedule --}}
                    @elseif($curSub === 'schedule')
                        @include('manufacturing::workorder.schedule')
                    {{-- BOMs --}}
                    @elseif($curSub === 'boms')
                            @include('manufacturing::workorder.bom')
                    {{-- Assignment --}}
                    @elseif($curSub === 'assignment')
                        @include('manufacturing::workorder.assignment')
                    @endif

                {{-- Quality Check --}}
                @elseif($curPage === 'qc')
                    @if($curSub === 'benchmark' || $curSub === '')
                        @include('manufacturing::Quality Check.benchmark')
                    @elseif($curSub === 'rework')
                        @include('manufacturing::Quality Check.rework')
                    @elseif($curSub === 'analytics')
                        @include('manufacturing::Quality Check.analytics')
                    @endif

                @endif
            </div>
        </main>
    </div>

    @include('manufacturing::modals')

    {{-- ── UNIVERSAL SUCCESS NOTIFICATION ──────────────────────────────────── --}}
    <div id="success-notif" class="fixed inset-0 bg-black/50 flex items-center justify-center z-[999] hidden">
        <div class="bg-white rounded-2xl shadow-2xl px-6 py-5 flex flex-col items-center gap-3 max-w-xs mx-4">
            <div class="w-10 h-10 rounded-full bg-nexora-success/15 flex items-center justify-center">
                <span class="text-nexora-success text-xl">✓</span>
            </div>
            <p id="success-text" class="text-sm text-nexora-deep-navy text-center"></p>
            <button onclick="closeSuccessNotif()"
                    class="px-4 py-1.5 rounded-full text-xs font-semibold bg-nexora-corporate text-white
                           hover:bg-nexora-navy-mid transition-colors">
                OK
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
</body>
</html>
