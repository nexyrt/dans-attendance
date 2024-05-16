<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />

    @notifyCss
    @livewireStyles

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 h-screen">

    <!-- Background -->
    <div class="absolute inset-0 bg-blue-500" style="height: 50%; z-index: -1;"></div>

    <div class="flex h-full">

        <!-- Sidebar -->
        <div class="fixed top-4 bottom-4 left-4 w-64 bg-white text-gray-800 shadow-lg rounded-lg z-10">
            <div class="p-6 flex justify-center items-center">
                <img src="{{ asset('images/dans.png') }}" alt="DANS" class="h-8 w-8 mr-2">
                <h1 class="text-2xl font-semibold">DANS</h1>
            </div>

            <hr
                class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent">

            <nav class="flex-1 mt-3 px-4 space-y-2 overflow-y-auto">
                <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Dashboard</a>
                <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Users</a>
                <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Settings</a>
                <!-- Add more navigation items here -->
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 ml-72 relative overflow-y-auto p-4">
            {{ $slot }}
        </div>
    </div>

    <x-notify::notify />
    @notifyJs
    @livewireScripts

</body>




</html>
