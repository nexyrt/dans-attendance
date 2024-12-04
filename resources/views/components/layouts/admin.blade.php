<!-- resources/views/layouts/admin.blade.php -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link rel="icon" href="{{ asset('images/dans.png') }}">
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
        <div class="absolute inset-0 bg-blue-500" style="height: 45%; z-index: -1;"></div>

        <div class="flex h-full">
            <!-- Sidebar with Alpine.js -->
            <div x-data="{ open: false }" x-cloak @toggle-sidebar.window="open = !open"
                @resize.window="open = window.innerWidth >= 1024"
                :class="{ 'translate-x-0': open, '-translate-x-[500px]': !open }"
                class="fixed top-4 bottom-4 left-6 w-72 bg-white text-gray-800 shadow-lg rounded-lg z-10 transition-transform duration-300 lg:translate-x-0">

                <!-- Mobile Overlay -->
                <div x-show="open" x-transition.opacity @click="open = false"
                    class="fixed inset-0 bg-opacity-50 z-0 lg:hidden"></div>

                <!-- Sidebar Content -->
                <div class="relative z-10">
                    <!-- Sidebar Header -->
                    <div class="p-6 flex justify-between items-center">
                        <div class="flex items-center">
                            <img src="{{ asset('images/dans.png') }}" alt="DANS"
                                class="h-8 w-8 mr-2 cursor-pointer">
                            <h1 class="text-2xl font-semibold">DANS</h1>
                        </div>
                        <!-- Mobile Close Button -->
                        <button @click="open = false" class="lg:hidden p-2 hover:bg-gray-100 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent">

                    <!-- Sidebar Navigation -->
                    <div
                        class="h-full overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300">
                        <nav class="hs-accordion-group p-3 px-5 w-full flex flex-col flex-wrap"
                            data-hs-accordion-always-open>
                            <ul class="flex flex-col space-y-1">
                                <!-- Dashboard -->
                                <li>
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="@if (request()->routeIs('admin.dashboard')) bg-gray-200 @endif flex items-center p-2 text-sm text-gray-800 hover:bg-gray-100 rounded-lg">
                                        <i class='bx bx-home text-xl text-gray-700 me-3'></i>
                                        Dashboard
                                    </a>
                                </li>

                                <!-- Users -->
                                <li>
                                    <a href="{{ route('admin.users.index') }}"
                                        class="@if (request()->routeIs('admin.users.index')) bg-gray-200 @endif flex items-center p-2 text-sm text-gray-800 hover:bg-gray-100 rounded-lg">
                                        <i class='bx bx-user text-xl text-gray-700 me-3 '></i>
                                        Users
                                    </a>
                                </li>

                                <!-- Users -->
                                <li>
                                    <a href="{{ route('admin.attendances.index') }}"
                                        class="@if (request()->routeIs('admin.attendances.index')) bg-gray-200 @endif flex items-center p-2 text-sm text-gray-800 hover:bg-gray-100 rounded-lg">
                                        <i class='bx bx-time-five text-xl text-gray-700 me-3'></i>
                                        Attendance
                                    </a>
                                </li>

                                <!-- Schedule Management Dropdown -->
                                <li x-data="{ open: false }">
                                    <button @click="open = !open"
                                        class="w-full flex items-center justify-between p-2 text-sm text-gray-800 hover:bg-gray-100 rounded-lg">
                                        <div class="flex items-center">
                                            <i class='bx bx-calendar text-xl text-gray-700 me-3 '></i>
                                            <span>Schedule</span>
                                        </div>
                                        <svg :class="{ 'rotate-180': open }"
                                            class="w-4 h-4 transition-transform duration-200" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    <!-- Dropdown Menu -->
                                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="pl-10 mt-2 space-y-2">
                                        <a href="{{ route('admin.schedules.dashboard') }}"
                                            class="block py-2 text-sm hover:text-blue-600">
                                            Dashboard
                                        </a>
                                        <a href="{{ route('admin.schedules.default-schedules') }}"
                                            class="block py-2 text-sm hover:text-blue-600">
                                            Jadwal Tetap
                                        </a>

                                        <!-- Time Slots Submenu -->
                                        <div x-data="{ openSub: false }" class="relative">
                                            <button @click="openSub = !openSub"
                                                class="w-full flex items-center justify-between py-2 text-sm hover:text-blue-600">
                                                <span>Time Slots</span>
                                                <svg :class="{ 'rotate-180': openSub }"
                                                    class="w-4 h-4 transition-transform duration-200" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </button>

                                            <div x-show="openSub" class="pl-4 mt-2 space-y-2">
                                                <a href="" class="block py-2 text-sm hover:text-blue-600">
                                                    Create Time Slot
                                                </a>
                                                <a href="" class="block py-2 text-sm hover:text-blue-600">
                                                    Manage Time Slots
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </nav>
                    </div>
                </div>
            </div>


            <!-- Main Content -->
            <div class="flex-1 lg:ml-80 relative overflow-y-auto p-4">
                <!-- Breadcrumbs -->
                <div class="flex justify-between mb-5 ">
                    <!-- Hamburger Button for Mobile -->
                    <button x-data @click="$dispatch('toggle-sidebar')"
                        class="block lg:hidden p-2 rounded-lg bg-white shadow-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <nav class="lg:flex text-white hidden" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                            <li class="inline-flex items-center">
                                <a href="#"
                                    class="inline-flex items-center text-sm font-medium hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                    <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                    </svg>
                                    Home
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="rtl:rotate-180 w-3 h-3 mx-1" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 9 4-4-4-4" />
                                    </svg>
                                    <a href="#"
                                        class="ms-1 text-sm font-medium hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Projects</a>
                                </div>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg class="rtl:rotate-180 w-3 h-3  mx-1" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 9 4-4-4-4" />
                                    </svg>
                                    <span class="ms-1 text-sm font-medium  md:ms-2 dark:text-gray-400">Flowbite</span>
                                </div>
                            </li>
                        </ol>
                    </nav>

                    <div class="hs-dropdown [--placement:bottom-right] relative inline-flex">
                        <button id="hs-dropdown-account" type="button"
                            class="size-[38px] inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 focus:outline-none disabled:opacity-50 disabled:pointer-events-none dark:text-white"
                            aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                            <img class="shrink-0 size-[38px] rounded-full"
                            src="{{ Auth::user()->profile    }}"
                                alt="Avatar">
                        </button>

                        <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-60  bg-white shadow-md rounded-lg mt-2 dark:bg-neutral-800 dark:border dark:border-neutral-700 dark:divide-neutral-700 after:h-4 after:absolute after:-bottom-4 after:start-0 after:w-full before:h-4 before:absolute before:-top-4 before:start-0 before:w-full"
                        role="menu" aria-orientation="vertical" aria-labelledby="hs-dropdown-account" style="position: absolute; z-index: 9999;">
                        <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-60  bg-white shadow-md rounded-lg mt-2 dark:bg-neutral-800 dark:border dark:border-neutral-700 dark:divide-neutral-700 after:h-4 after:absolute after:-bottom-4 after:start-0 after:w-full before:h-4 before:absolute before:-top-4 before:start-0 before:w-full"
                            role="menu" aria-orientation="vertical" aria-labelledby="hs-dropdown-account"
                            style="position: absolute; z-index: 9999;">
                            <div class="py-3 px-5 bg-gray-100 rounded-t-lg dark:bg-neutral-700">
                                <p class="text-sm text-gray-500 dark:text-neutral-500">Signed in as</p>
                                <p class="text-sm font-medium text-gray-800 dark:text-neutral-200">{{ Auth::user()->name }}  </p>
                            </div>
                            <div class="p-1.5 space-y-0.5"> 
                                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300"
                                    href="#">
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9" />
                                        <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" />
                                    </svg>
                                    Newsletter
                                </a>
                                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300"
                                    href="#">
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z" />
                                        <path d="M3 6h18" />
                                        <path d="M16 10a4 4 0 0 1-8 0" />
                                    </svg>
                                    Purchases
                                </a>
                                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300"
                                    href="#">
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242" />
                                        <path d="M12 12v9" />
                                        <path d="m8 17 4 4 4-4" />
                                    </svg>
                                    Downloads
                                </a>
                                <form action="{{ route('logout') }}" method="POST"
                                    class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300">
                                    @csrf
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                        <circle cx="9" cy="7" r="4" />
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                    </svg>
                                    <button type="submit">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{ $slot }}
            </div>
        </div>

        {{-- <livewire:shared.check-in-modal /> --}}

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
    </body>

</html>
