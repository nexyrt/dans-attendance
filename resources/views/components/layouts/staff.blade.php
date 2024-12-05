<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        {{-- Favicon --}}
        <link rel="icon" href="{{ asset('images/dans.png') }}">

        {{-- Fonts --}}
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">

        {{-- Styles --}}
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
        @notifyCss
        @livewireStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
    </head>

    <body class="bg-gray-100 h-screen">
        {{-- Background Gradient --}}
        <div class="absolute inset-0 bg-blue-500" style="height: 45%; z-index: -1;"></div>

        <div class="flex h-full" x-data="{ sidebarOpen: false }">
            {{-- Sidebar --}}
            <div x-cloak :class="{ 'translate-x-0': sidebarOpen, '-translate-x-[350px]': !sidebarOpen }"
                class="fixed top-4 bottom-4 left-6 w-72 bg-white text-gray-800 shadow-lg rounded-lg z-20 transition-transform duration-300 lg:translate-x-0">

                {{-- Mobile Overlay --}}
                <div class="relative h-full flex flex-col">
                    {{-- Sidebar Header --}}
                    <div class="p-6 flex justify-center items-center">
                        <div class="flex items-center">
                            <img src="{{ asset('images/dans.png') }}" alt="DANS"
                                class="h-8 w-8 mr-2 cursor-pointer">
                            <h1 class="text-2xl font-semibold">DANS</h1>
                        </div>

                        <button @click="sidebarOpen = false" class="lg:hidden p-2 hover:bg-gray-100 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent">

                    {{-- Navigation Content --}}
                    <div
                        class="h-full overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300">
                        <nav class="hs-accordion-group p-3 px-5 w-full flex flex-col flex-wrap"
                            data-hs-accordion-always-open>
                            <ul class="flex flex-col space-y-1" data-hs-scrollspy="#scrollspy">
                                {{-- Dashboard --}}
                                <li>
                                    <a class="p-2 flex items-center mt-2 gap-x-3.5 text-sm text-gray-800 hover:bg-gray-100 rounded-lg"
                                        href="{{ route('staff.dashboard') }}">
                                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                            <polyline points="9 22 9 12 15 12 15 22" />
                                        </svg>
                                        Dashboard
                                    </a>
                                </li>

                                {{-- Attendance --}}
                                <li>
                                    <a class="p-2 flex items-center mt-2 gap-x-3.5 text-sm text-gray-800 hover:bg-gray-100 rounded-lg"
                                        href="{{ route('staff.attendance.index') }}">
                                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <rect width="18" height="18" x="3" y="4" rx="2"
                                                ry="2" />
                                            <line x1="16" x2="16" y1="2" y2="6" />
                                            <line x1="8" x2="8" y1="2" y2="6" />
                                            <line x1="3" x2="21" y1="10" y2="10" />
                                        </svg>
                                        Attendance
                                    </a>
                                </li>

                                {{-- Users --}}
                                <li>
                                    <a class="p-2 flex items-center mt-2 gap-x-3.5 text-sm text-gray-800 hover:bg-gray-100 rounded-lg"
                                        href="#users">
                                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                            <circle cx="9" cy="7" r="4" />
                                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                        </svg>
                                        Leave's Management
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    {{-- Check-Out --}}
                    <div class="mt-auto w-full p-4 border-t border-gray-200 bg-white">
                        <button type="button" @click="$dispatch('open-modal', 'modal-name')"
                            class="w-full flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Check Out
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1 lg:ml-80 relative overflow-y-auto p-4">
                <div class="flex justify-between items-center my-3">
                    {{-- Hamburger Button --}}
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="block lg:hidden p-2 rounded-lg bg-white shadow-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    {{-- Breadcrumbs --}}
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
                                    <svg class="rtl:rotate-180 w-3 h-3 mx-1" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 9 4-4-4-4" />
                                    </svg>
                                    <span class="ms-1 text-sm font-medium md:ms-2 dark:text-gray-400">Flowbite</span>
                                </div>
                            </li>
                        </ol>
                    </nav>

                    {{-- Profile Dropdown --}}
                    <div class="hs-dropdown [--placement:bottom-right] relative inline-flex">
                        <button id="hs-dropdown-account" type="button"
                            class="size-[38px] inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 focus:outline-none disabled:opacity-50 disabled:pointer-events-none dark:text-white"
                            aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                            <img class="shrink-0 size-[38px] rounded-full" src="{{ Auth::user()->profile }}"
                                alt="Avatar">
                        </button>

                        <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-60  bg-white shadow-md rounded-lg mt-2 dark:bg-neutral-800 dark:border dark:border-neutral-700 dark:divide-neutral-700 after:h-4 after:absolute after:-bottom-4 after:start-0 after:w-full before:h-4 before:absolute before:-top-4 before:start-0 before:w-full"
                            role="menu" aria-orientation="vertical" aria-labelledby="hs-dropdown-account"
                            style="position: absolute; z-index: 9999;">
                            <div class="py-3 px-5 bg-gray-100 rounded-t-lg dark:bg-neutral-700">
                                <p class="text-sm text-gray-500 dark:text-neutral-500">Signed in as</p>
                                <p class="text-sm font-medium text-gray-800 dark:text-neutral-200">
                                    {{ Auth::user()->name }} </p>
                            </div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-x-3.5 py-2 px-3 text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300">
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                        <circle cx="9" cy="7" r="4" />
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                    </svg>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{ $slot }}
            </div>
        </div>

        {{-- Modals & Notifications --}}
        <livewire:shared.check-in-modal />
        <livewire:shared.check-out-modal />

        {{-- Scripts --}}
        <x-notify::notify />
        {{-- @notifyJs --}}
        @livewireScripts

        <script>
            window.addEventListener('alpine:init', () => {
                Alpine.store('app', {
                    isSidebarOpen: window.innerWidth >= 1024,
                    toggleSidebar() {
                        this.isSidebarOpen = !this.isSidebarOpen;
                    }
                });
            });

            document.addEventListener('livewire:initialized', () => {
                Livewire.on('success-checkin', () => {
                    setTimeout(() => {
                        Livewire.dispatch('closeModal');
                    }, 1500);
                });

                Livewire.on('success-checkout', () => {
                    setTimeout(() => {
                        Livewire.dispatch('closeModal');
                    }, 1500);
                });
            });
        </script>
    </body>

</html>
