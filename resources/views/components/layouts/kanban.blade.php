{{-- resources/views/components/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kanban Board</title>
    
    <!-- Styles -->
    @vite(['resources/css/app.css'])
    
    <!-- Alpine.js -->
     <!-- Add this for smoother animations -->
     <style>
        * {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
    </style>

    <!-- Livewire Styles -->
    @livewireStyles
</head>
<body class="min-h-screen bg-gray-100">
    <div class="min-h-screen">
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <!-- Livewire Scripts -->
    @livewireScripts

    @stack('scripts')

    <!-- Scripts -->
    @vite(['resources/js/app.js'])
</body>
</html>