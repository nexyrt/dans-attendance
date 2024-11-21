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
        <script src="//unpkg.com/alpinejs" defer></script>

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
                <!-- Overlay for mobile -->
                <div x-show="open" x-transition.opacity @click="open = false"
                    class="fixed inset-0 bg-opacity-50 z-0 lg:hidden"></div>

                <!-- Sidebar Content -->
                <div class="relative z-10">
                    <div class="p-6 flex justify-center items-center">
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
                        <a href="{{ route('admin.users.index') }}"
                            class="@if (request()->routeIs('admin.users.index')) bg-gray-200 @endif flex font-medium flex-row items-center px-4 py-2 rounded hover:bg-gray-100">
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
                    <div x-data="{ open: false }" x-cloak class="relative">
                        <div @click="open = !open" class="cursor-pointer flex items-center space-x-3">
                            <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-white">
                                <img src="https://images.unsplash.com/photo-1610397095767-84a5b4736cbd?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80"
                                    alt="Profile Picture" class="w-full h-full object-cover">
                            </div>
                            <div class="font-medium text-white text-lg">
                                {{ Auth::user()->name }}
                            </div>
                        </div>
                        <div x-show="open" @click.away="open = false"
                            class="absolute w-60 px-5 py-3 mt-5 bg-white rounded-lg shadow dark:bg-gray-800">
                            <ul class="space-y-3 dark:text-white">
                                <li>
                                    <a href="{{ route('profile.edit') }}"
                                        class="flex items-center space-x-3 border-r-4 border-transparent hover:border-indigo-700">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span>Account</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="flex items-center space-x-3 border-r-4 border-transparent hover:border-indigo-700">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span>Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST"
                                        class="flex items-center space-x-3 border-r-4 border-transparent hover:border-red-600 text-red-600">
                                        @csrf
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        <button type="submit">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                {{ $slot }}
            </div>
        </div>

        <x-notify::notify />
        @notifyJs
        @livewireScripts
        <script src="//unpkg.com/alpinejs" defer></script>
    </body>

</html>
