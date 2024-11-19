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

        @notifyCss
        @livewireStyles

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="bg-gray-100 h-screen">

        <!-- Background -->
        <div class="absolute inset-0 bg-blue-500" style="height: 45%; z-index: -1;"></div>

        <div class="flex h-full">
            <!-- Hamburger Button for Mobile -->
            <button x-data @click="$dispatch('toggle-sidebar')"
                class="lg:hidden fixed top-4 left-4 z-20 p-2 rounded-lg bg-white shadow-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Sidebar with Alpine.js -->
            <div x-data="{ open: true }" @toggle-sidebar.window="open = !open"
                @resize.window="open = window.innerWidth >= 1024"
                :class="{ 'translate-x-0': open, '-translate-x-[500px]': !open }"
                class="fixed top-4 bottom-4 left-6 w-72 bg-white text-gray-800 shadow-lg rounded-lg z-10 transition-transform duration-300 lg:translate-x-0">
                <!-- Overlay for mobile -->
                <div x-show="open" x-transition.opacity @click="open = false"
                    class="fixed inset-0 bg-black bg-opacity-50 z-0 lg:hidden"></div>

                <!-- Sidebar Content -->
                <div class="relative z-10">
                    <div class="p-6 flex justify-between items-center">
                        <div class="flex items-center">
                            <img src="{{ asset('images/dans.png') }}" alt="DANS"
                                class="h-8 w-8 mr-2 cursor-pointer">
                            <h1 class="text-2xl font-semibold">DANS</h1>
                        </div>
                        <!-- Close button for mobile -->
                        <button @click="open = false" class="lg:hidden p-2 hover:bg-gray-100 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent">

                    <nav class="flex-1 mt-3 px-4 space-y-2 overflow-y-auto">
                        <a href="{{ route('admin.dashboard') }}"
                            class="@if (request()->routeIs('admin.dashboard')) bg-gray-200 @endif flex font-medium flex-row items-center px-4 py-2 rounded hover:bg-gray-100">
                            <i class='bx bx-home text-2xl text-blue-700 me-5'></i>Dashboard
                        </a>
                        <a href="{{ route('admin.users') }}"
                            class="@if (request()->routeIs('admin.users')) bg-gray-200 @endif flex font-medium flex-row items-center px-4 py-2 rounded hover:bg-gray-100">
                            <i class='bx bx-user text-2xl text-orange-400 me-5'></i>Users
                        </a>
                        <a href="#"
                            class="flex font-medium flex-row items-center px-4 py-2 rounded hover:bg-gray-100">
                            <i class='bx bx-cog text-2xl text-rose-400 me-5'></i>Settings
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1 lg:ml-80 relative overflow-y-auto p-4">
                {{ $slot }}
            </div>
        </div>

        <x-notify::notify />
        @notifyJs
        @livewireScripts
    </body>

</html>
