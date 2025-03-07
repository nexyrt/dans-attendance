<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="icon" href="{{ asset('images/jkb.png') }}">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @notifyCss

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 h-screen">

    <!-- Background -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-blue-800" style="height: 45%; z-index: -1;"></div>

    <div class="flex h-full">
        <!-- Sidebar with Alpine.js -->
        <div x-data="{ open: false, activeMenu: null }" x-cloak @toggle-sidebar.window="open = !open"
            :class="{ 'translate-x-0': open, '-translate-x-[280px]': !open }"
            class="fixed top-4 bottom-4 left-2 w-[270px] bg-white dark:bg-gray-800 shadow-xl rounded-xl z-10 transition-all duration-300 lg:translate-x-0">

            <!-- Mobile Overlay -->
            <div x-show="open" x-transition.opacity @click="open = false"
                class="fixed inset-0 bg-white rounded-xl backdrop-blur-sm z-0 lg:hidden">
            </div>

            <!-- Sidebar Content -->
            <div class="relative h-full flex flex-col z-10">
                <!-- Sidebar Header -->
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <a href="/" class="flex items-center space-x-3">
                            <div
                                class="flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-br from-blue-600 to-blue-700">
                                <img src="{{ asset('images/icon-jkb.png') }}" alt="DANS" class="h-6 w-6">
                            </div>
                            <span
                                class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-blue-800">
                                JKB
                            </span>
                        </a>
                        <button @click="open = false" class="lg:hidden p-2 rounded-lg hover:bg-gray-100">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="px-4 py-2">
                    <div class="flex items-center space-x-3 px-3 py-2 rounded-lg bg-blue-50 dark:bg-gray-700">
                        <div class="flex-shrink-0">
                            <img src="{{ Auth::user()->profile }}" class="w-10 h-10 rounded-full">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                {{ Auth::user()->name }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                {{ Auth::user()->email }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-3 space-y-1 overflow-y-auto">
                    <div class="py-2">
                        <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            Main Menu
                        </p>

                        <!-- Dashboard -->
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center px-3 py-2 mt-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'text-blue-700 bg-blue-50 dark:text-white dark:bg-gray-700' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
                            <i class='bx bx-home text-xl mr-3'></i>
                            <span>Dashboard</span>
                        </a>

                        <!-- Management Section -->
                        <p class="px-3 mt-6 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            Management
                        </p>

                        <!-- Users -->
                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center px-3 py-2 mt-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.users.*') ? 'text-blue-700 bg-blue-50 dark:text-white dark:bg-gray-700' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
                            <i class='bx bx-user text-xl mr-3'></i>
                            <span>Users</span>
                        </a>

                        <!-- Attendance -->
                        <a href="{{ route('admin.attendances.index') }}"
                            class="flex items-center px-3 py-2 mt-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.attendances.*') ? 'text-blue-700 bg-blue-50 dark:text-white dark:bg-gray-700' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
                            <i class='bx bx-time-five text-xl mr-3'></i>
                            <span>Attendance</span>
                        </a>

                        <a href="{{ route('admin.office.index') }}"
                            class="flex items-center px-3 py-2 mt-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.office.*') ? 'text-blue-700 bg-blue-50 dark:text-white dark:bg-gray-700' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
                            <i class='bx bx-map text-xl mr-3'></i>
                            <span>Office</span>
                        </a>

                        <!-- Leave Section -->
                        <p class="px-3 mt-6 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            Leave
                        </p>
                        <div x-data="{ open: {{ request()->routeIs('admin.leave.*') ? 'true' : 'false' }} }">
                            <button @click="open = !open"
                                class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium rounded-lg transition-colors hover:bg-gray-100 dark:hover:bg-gray-700"
                                :class="{'text-blue-700 bg-blue-50 dark:text-white dark:bg-gray-700': {{ request()->routeIs('admin.leave.*') ? 'true' : 'false' }} }">
                                <div class="flex items-center">
                                    <i class='bx bx-calendar-exclamation text-xl mr-3'></i>
                                    <span>Leave Management</span>
                                </div>
                                <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100" class="mt-1 pl-10 space-y-1">
                                <a href="{{ route('admin.leave.dashboard') }}"
                                    class="block px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.leave.dashboard') ? 'text-blue-700 bg-blue-50 dark:text-white dark:bg-gray-700' : 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700' }}">
                                    Dashboard
                                </a>

                                <!-- Leave Requests -->
                                <a href="{{ route('admin.leave.leave-request') }}"
                                    class="flex items-center px-3 py-2 mt-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.leave.leave-request') ? 'text-blue-700 bg-blue-50 dark:text-white dark:bg-gray-700' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
                                    <span>Leave Requests</span>
                                </a>

                                <!-- Leave Balance -->
                                <a href="{{ route('admin.leave.leave-balance') }}"
                                    class="flex items-center px-3 py-2 mt-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.leave.leave-balance') ? 'text-blue-700 bg-blue-50 dark:text-white dark:bg-gray-700' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
                                    <span>Leave Balance</span>
                                </a>
                            </div>
                        </div>


                        <!-- Schedule Section -->
                        <p class="px-3 mt-6 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            Schedule
                        </p>

                        <!-- Schedule Management -->
                        <div x-data="{ open: false }">
                            <button @click="open = !open"
                                class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium rounded-lg transition-colors hover:bg-gray-100 dark:hover:bg-gray-700">
                                <div class="flex items-center">
                                    <i class='bx bx-calendar text-xl mr-3'></i>
                                    <span>Schedule Management</span>
                                </div>
                                <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100" class="mt-1 pl-10 space-y-1">
                                <a href="{{ route('admin.schedules.dashboard') }}"
                                    class="block px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.schedules.dashboard') ? 'text-blue-700 bg-blue-50 dark:text-white dark:bg-gray-700' : 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700' }}">
                                    Dashboard
                                </a>
                                <a href="{{ route('admin.schedules.default-schedules') }}"
                                    class="block px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.schedules.default-schedules') ? 'text-blue-700 bg-blue-50 dark:text-white dark:bg-gray-700' : 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700' }}">
                                    Default Schedules
                                </a>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Footer -->
                <div class="p-4 border-t dark:border-gray-700">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="flex items-center w-full px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 lg:ml-[290px] relative overflow-y-auto p-4 mt-5">
            <!-- Top Bar -->
            <div class="flex justify-between items-center mb-6">
                <!-- Hamburger Button for Mobile -->
                <button x-data @click="$dispatch('toggle-sidebar')"
                    class="lg:hidden p-2 rounded-lg bg-white shadow-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Dynamic Breadcrumbs -->
                @php
                $segments = collect(request()->segments());
                $segments = $segments->slice(1); // Remove 'admin' from the segments
                $url = url('/admin');
                @endphp

                <nav class="hidden lg:flex text-white" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.dashboard') }}"
                                class="inline-flex items-center text-sm font-medium hover:text-blue-200 transition-colors">
                                <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                </svg>
                                Dashboard
                            </a>
                        </li>

                        @if($segments->isNotEmpty())
                        @foreach($segments as $segment)
                        @php
                        $url .= '/'.$segment;
                        // Clean up the segment text
                        $formattedSegment = ucwords(str_replace(['-', '_'], ' ', $segment));
                        // Handle common admin route patterns
                        if ($formattedSegment === 'Index') {
                        continue;
                        }
                        if ($loop->last && is_numeric($segment)) {
                        $formattedSegment = 'Details';
                        }
                        @endphp

                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                @if($loop->last)
                                <span class="ms-1 text-sm font-medium">{{ $formattedSegment }}</span>
                                @else
                                <a href="{{ $url }}"
                                    class="ms-1 text-sm font-medium hover:text-blue-200 transition-colors">
                                    {{ $formattedSegment }}
                                </a>
                                @endif
                            </div>
                        </li>
                        @endforeach
                        @endif
                    </ol>
                </nav>
            </div>

            <!-- Flash Messages -->
            <x-shared.flash-message />

            <!-- Page Content -->
            {{ $slot }}
        </div>
    </div>

    {{--
    <livewire:shared.check-in-modal /> --}}

    <x-notify::notify />
    {{-- @notifyJs --}}
    @livewireScripts
    @livewireCalendarScripts
    {{-- <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('   ', () => {
                setTimeout(() => {
                    Livewire.dispatch('closeModal');
                });
            });

            Livewire.on('error-checkin', () => {
                Livewire.dispatch('closeModal');
            });
        });
    </script> --}}
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
</body>

</html>