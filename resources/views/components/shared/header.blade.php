{{-- resources/views/components/shared/header.blade.php --}}
@props(['title'])

<header class="bg-white border-b border-secondary-200 fixed left-64 right-0 top-0 z-10">
    <div class="px-6 py-4 flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-secondary-900">{{ $title }}</h1>
        
        <div class="flex items-center space-x-4">
            <!-- Notifications -->
            <button type="button" class="p-1 text-secondary-400 hover:text-secondary-500">
                <span class="sr-only">View notifications</span>
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </button>

            <!-- Profile dropdown -->
            <div class="relative">
                <button type="button" class="flex items-center text-sm text-secondary-500 hover:text-secondary-700">
                    <span class="sr-only">Open user menu</span>
                    <span class="mr-2">{{ auth()->user()->name }}</span>
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>