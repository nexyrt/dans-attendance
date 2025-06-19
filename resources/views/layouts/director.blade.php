{{-- resources/views/layouts/staff.blade.php --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <x-shared.head-meta />
    </head>

    <body class="bg-gray-50">
        <div x-data="{ isSidebarOpen: false }" class="min-h-screen">
            <!-- Mobile Header -->
            <div class="lg:hidden fixed top-0 left-0 right-0 bg-white h-16 border-b border-gray-100 z-30 px-4">
                <div class="flex items-center justify-between h-full">
                    {{-- Hamburger Button --}}
                    <button @click="isSidebarOpen = !isSidebarOpen"
                        class="p-2 rounded-lg text-gray-600 hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!isSidebarOpen" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            <path x-show="isSidebarOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>

                    {{-- Logo Section --}}
                    <div class="p-1.5 bg-primary-50 rounded-lg">
                        <img src="{{ asset('images/jkb.png') }}" alt="JKB" class="h-8 w-8">
                    </div>

                    {{-- Profile --}}
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center">
                            <img class="h-8 w-8 rounded-full object-cover ring-2 ring-primary-50"
                                src="{{ asset(auth()->user()->image ?? 'images/users/user.png') }}"
                                alt="{{ auth()->user()->name }}">
                        </button>
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100">
                            <div class="py-1">
                                <a href="{{ route('staff.profile.index') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile Settings</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign
                                        out</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex h-screen">
                <!-- Sidebar -->
                <aside
                    class="fixed min-w-72 inset-y-0 left-0 z-20 w-72 bg-white/95 backdrop-blur-sm shadow-lg transition-all duration-300 ease-in-out lg:relative lg:translate-x-0 flex flex-col border-r border-gray-100"
                    :class="{ 'translate-x-0': isSidebarOpen, '-translate-x-full': !isSidebarOpen }">

                    <!-- Logo Section -->
                    <div class="flex justify-center items-center h-16 border-b border-gray-100">
                        <div class="p-1.5 bg-primary-50 rounded-lg">
                            <img src="{{ asset('images/jkb.png') }}" alt="JKB" class="h-8 w-8">
                        </div>
                        <!-- Mobile close button -->
                        <button @click="isSidebarOpen = false"
                            class="lg:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Navigation -->
                    <nav class="flex-1 px-4 py-6 overflow-y-auto flex flex-col">
                        {{-- Navigation Menu --}}
                        <div class="flex-1 space-y-1">
                            @php
                                $navigation = [
                                    [
                                        'route' => 'director.dashboard',
                                        'label' => 'Dashboard',
                                        'icon' =>
                                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />',
                                    ],
                                    [
                                        'route' => 'director.users.index',
                                        'label' => 'Users',
                                        'icon' =>
                                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />',
                                    ],
                                    [
                                        'route' => 'director.attendances.index',
                                        'label' => 'Attendances',
                                        'icon' =>
                                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />',
                                    ],
                                    [
                                        'route' => 'director.leaves.index',
                                        'label' => 'Leaves',
                                        'icon' =>
                                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />',
                                    ],
                                    [
                                        'route' => 'director.office.index',
                                        'label' => 'Office',
                                        'icon' =>
                                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />',
                                    ],
                                ];

                                // Add the new schedules routes
                                $schedulesActive = request()->routeIs('director.schedules.*');
                            @endphp

                            @foreach ($navigation as $nav)
                                <a href="{{ route($nav['route']) }}"
                                    @click.prevent="window.innerWidth < 1024 ? (isSidebarOpen = false, window.location.href = '{{ route($nav['route']) }}') : window.location.href = '{{ route($nav['route']) }}'"
                                    class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 
            {{ request()->routeIs($nav['route'] . '*')
                ? 'bg-primary-50 text-primary-600'
                : 'text-gray-600 hover:bg-gray-50/80' }}">
                                    <div class="flex items-center">
                                        <div
                                            class="{{ request()->routeIs($nav['route'] . '*')
                                                ? 'bg-primary-100/50'
                                                : 'bg-gray-100/50 group-hover:bg-primary-50/50' }} 
                        p-2 rounded-lg transition-colors duration-200">
                                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor">
                                                {!! $nav['icon'] !!}
                                            </svg>
                                        </div>
                                        <span
                                            class="ml-3 transition-transform duration-200 group-hover:translate-x-0.5">
                                            {{ $nav['label'] }}
                                        </span>
                                    </div>

                                    @if (request()->routeIs($nav['route'] . '*'))
                                        <div class="ml-auto w-1 h-6 bg-primary-500 rounded-full"></div>
                                    @endif
                                </a>
                            @endforeach

                            <!-- Schedules Dropdown Menu -->
                            <div x-data="{ open: {{ $schedulesActive ? 'true' : 'false' }} }" class="space-y-1">
                                <!-- Dropdown Toggle -->
                                <button @click="open = !open"
                                    class="w-full group flex items-center justify-between px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200
                {{ $schedulesActive ? 'bg-primary-50 text-primary-600' : 'text-gray-600 hover:bg-gray-50/80' }}">
                                    <div class="flex items-center">
                                        <div
                                            class="{{ $schedulesActive ? 'bg-primary-100/50' : 'bg-gray-100/50 group-hover:bg-primary-50/50' }} 
                        p-2 rounded-lg transition-colors duration-200">
                                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                        </div>
                                        <span
                                            class="ml-3 transition-transform duration-200 group-hover:translate-x-0.5">
                                            Schedules
                                        </span>
                                    </div>

                                    <div class="flex items-center">
                                        @if ($schedulesActive)
                                            <div class="w-1 h-6 bg-primary-500 rounded-full mr-2"></div>
                                        @endif

                                        <svg class="w-4 h-4 transition-transform duration-200"
                                            :class="{ 'rotate-90': open }" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </button>

                                <!-- Dropdown Menu Items -->
                                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100" class="pl-10 space-y-1">

                                    <!-- Default Schedules -->
                                    <a href="{{ route('director.schedules.default') }}"
                                        @click.prevent="window.innerWidth < 1024 ? (isSidebarOpen = false, window.location.href = '{{ route('director.schedules.default') }}') : window.location.href = '{{ route('director.schedules.default') }}'"
                                        class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200
                    {{ request()->routeIs('director.schedules.default') ? 'bg-primary-50 text-primary-600' : 'text-gray-600 hover:bg-gray-50/80' }}">
                                        <span class="truncate">Default Schedules</span>

                                        @if (request()->routeIs('director.schedules.default'))
                                            <div class="ml-auto w-1 h-4 bg-primary-500 rounded-full"></div>
                                        @endif
                                    </a>

                                    <!-- Schedules Calendar -->
                                    <a href="{{ route('director.schedules.calendar') }}"
                                        @click.prevent="window.innerWidth < 1024 ? (isSidebarOpen = false, window.location.href = '{{ route('director.schedules.calendar') }}') : window.location.href = '{{ route('director.schedules.calendar') }}'"
                                        class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200
                    {{ request()->routeIs('director.schedules.calendar') ? 'bg-primary-50 text-primary-600' : 'text-gray-600 hover:bg-gray-50/80' }}">
                                        <span class="truncate">Schedules Calendar</span>

                                        @if (request()->routeIs('director.schedules.calendar'))
                                            <div class="ml-auto w-1 h-4 bg-primary-500 rounded-full"></div>
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>
                    </nav>
                </aside>

                <!-- Main Content Wrapper -->
                <main class="w-full mt-14 lg:mt-0 overflow-y-auto min-h-screen">
                    {{-- Header --}}
                    <header
                        class="bg-white/95 hidden lg:block backdrop-blur-sm shadow-sm sticky top-0 z-10 border-b border-gray-100">
                        <div class="px-6 h-16 flex items-center justify-between">
                            <!-- Left Section: Title Area -->
                            <div class="flex items-center space-x-4">
                                <h1
                                    class="text-xl font-semibold bg-gradient-to-r from-gray-900 to-gray-700 text-transparent bg-clip-text">
                                    {{ $title ?? 'Dashboard' }}
                                </h1>
                            </div>

                            <!-- Right Section: DateTime and Profile -->
                            <div class="hidden lg:flex items-center space-x-6">
                                <!-- DateTime Display -->
                                <div x-data="{
                                    date: '',
                                    time: '',
                                    init() {
                                        this.updateClock();
                                        setInterval(() => this.updateClock(), 1000)
                                    },
                                    updateClock() {
                                        let now = new Date();
                                        this.date = now.toLocaleDateString('en-US', {
                                            weekday: 'long',
                                            month: 'long',
                                            day: 'numeric'
                                        });
                                        this.time = now.toLocaleTimeString('en-US', {
                                            second: '2-digit',
                                            hour: '2-digit',
                                            minute: '2-digit',
                                            hour12: false
                                        });
                                    }
                                }" x-init="init()" class="flex flex-col items-end">
                                    <span class="text-sm text-gray-600" x-text="date"></span>
                                    <span class="text-sm font-medium text-primary-600" x-text="time"></span>
                                </div>

                                <!-- Divider -->
                                <div class="h-6 w-px bg-gray-200"></div>

                                @php
                                    $dropdownItems = [
                                        [
                                            [
                                                'type' => 'link',
                                                'label' => 'Profile Settings',
                                                'href' => route('staff.profile.index'),
                                                'icon' =>
                                                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />',
                                            ],
                                        ],
                                        [
                                            [
                                                'type' => 'button',
                                                'label' => 'Sign out',
                                                'action' => route('logout'),
                                                'method' => 'POST',
                                                'class' => 'text-red-700 hover:bg-red-50',
                                                'iconClass' => 'text-red-400 group-hover:text-red-500',
                                                'icon' =>
                                                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />',
                                            ],
                                        ],
                                    ];
                                @endphp

                                <!-- Profile Dropdown -->
                                <x-input.dropdown :items="$dropdownItems">
                                    <x-slot name="trigger">
                                        <button class="flex items-center space-x-3" x-data="{ open: false }"
                                            @click="open = !open">
                                            <div class="relative">
                                                <img class="h-8 w-8 rounded-full object-cover"
                                                    src="{{ asset(auth()->user()->image ?? 'images/users/user.png') }}"
                                                    alt="{{ auth()->user()->name }}">
                                                <div
                                                    class="absolute -bottom-0.5 -right-0.5 h-2.5 w-2.5 bg-green-500 rounded-full ring-1 ring-white">
                                                </div>
                                            </div>
                                            <div class="flex flex-col items-start">
                                                <span class="text-sm text-gray-700">{{ Auth::user()->name }}</span>
                                                <span class="text-xs text-gray-500">Director</span>
                                            </div>
                                            <svg class="h-4 w-4 text-gray-400 transition-transform duration-200"
                                                :class="{ 'rotate-180': open }" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                    </x-slot>
                                </x-input.dropdown>
                            </div>
                        </div>
                    </header>

                    {{-- Main Content --}}
                    <div class="container mx-auto">
                        {{ $slot }}
                    </div>
                </main>

            </div>
        </div>

        @fluxScripts
        @livewireScripts
        @livewireChartsScripts
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    </body>

</html>
