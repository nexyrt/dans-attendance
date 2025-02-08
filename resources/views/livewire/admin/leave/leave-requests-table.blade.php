<div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <x-layouts.admin>
        <div class="flex justify-end mb-4">
            <div
                class="inline-flex bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-lg border border-gray-200 dark:border-gray-700 p-1">
                @foreach (['today', 'week', 'month'] as $period)
                <button wire:click="$set('selectedPeriod', '{{ $period }}')" class="px-3 py-1.5 text-sm font-medium rounded-md transition-all duration-200 
                        {{ $selectedPeriod === $period
                            ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400'
                            : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
                    {{ ucfirst($period) }}
                </button>
                @endforeach
            </div>
        </div>
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4 mb-6">
            <!-- Pending Requests Card -->
            <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-lg border border-gray-200 dark:border-gray-700 p-4 
                transition-all duration-300 hover:shadow-lg hover:scale-105 cursor-pointer group">
                <div class="flex items-center justify-between mb-3">
                    <h3
                        class="text-sm font-medium text-gray-600 dark:text-gray-300 group-hover:text-yellow-600 dark:group-hover:text-yellow-400 transition-colors">
                        Pending Requests
                    </h3>
                    <div
                        class="p-2 bg-yellow-50 dark:bg-yellow-900/30 rounded-lg group-hover:bg-yellow-100 dark:group-hover:bg-yellow-900/50 transition-colors">
                        <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span
                        class="text-2xl font-semibold text-gray-900 dark:text-white group-hover:text-yellow-600 dark:group-hover:text-yellow-400 transition-colors">
                        {{ $statistics['pending_requests'] }}
                    </span>
                    <span class="text-xs font-medium text-yellow-600 dark:text-yellow-400 bg-yellow-50 dark:bg-yellow-900/30 px-2.5 py-0.5 rounded-full
                        group-hover:bg-yellow-100 dark:group-hover:bg-yellow-900/50 transition-colors">
                        Pending
                    </span>
                </div>
            </div>

            <!-- Approved Requests Card -->
            <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-lg border border-gray-200 dark:border-gray-700 p-4 
                transition-all duration-300 hover:shadow-lg hover:scale-105 cursor-pointer group">
                <div class="flex items-center justify-between mb-3">
                    <h3
                        class="text-sm font-medium text-gray-600 dark:text-gray-300 group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
                        Approved This Month
                    </h3>
                    <div
                        class="p-2 bg-green-50 dark:bg-green-900/30 rounded-lg group-hover:bg-green-100 dark:group-hover:bg-green-900/50 transition-colors">
                        <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span
                        class="text-2xl font-semibold text-gray-900 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
                        {{ $statistics['approved_requests'] }}
                    </span>
                    <span class="text-xs font-medium text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/30 px-2.5 py-0.5 rounded-full
                        group-hover:bg-green-100 dark:group-hover:bg-green-900/50 transition-colors">
                        Approved
                    </span>
                </div>
            </div>

            <!-- Total Leaves Card -->
            <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-lg border border-gray-200 dark:border-gray-700 p-4 
                transition-all duration-300 hover:shadow-lg hover:scale-105 group">
                <div class="flex items-center justify-between mb-3">
                    <h3
                        class="text-sm font-medium text-gray-600 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                        Total Leaves
                    </h3>
                    <div
                        class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg group-hover:bg-blue-100 dark:group-hover:bg-blue-900/50 transition-colors">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span
                        class="text-2xl font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                        {{ $statistics['total_leaves'] }}
                    </span>
                    <span class="text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 px-2.5 py-0.5 rounded-full
                        group-hover:bg-blue-100 dark:group-hover:bg-blue-900/50 transition-colors">
                        This Month
                    </span>
                </div>
            </div>

            <!-- Rejected Requests Card -->
            <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-lg border border-gray-200 dark:border-gray-700 p-4 
                transition-all duration-300 hover:shadow-lg hover:scale-105 cursor-pointer group">
                <div class="flex items-center justify-between mb-3">
                    <h3
                        class="text-sm font-medium text-gray-600 dark:text-gray-300 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors">
                        Rejected Requests
                    </h3>
                    <div
                        class="p-2 bg-red-50 dark:bg-red-900/30 rounded-lg group-hover:bg-red-100 dark:group-hover:bg-red-900/50 transition-colors">
                        <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span
                        class="text-2xl font-semibold text-gray-900 dark:text-white group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors">
                        {{ $statistics['rejected_requests'] }}
                    </span>
                    <span class="text-xs font-medium text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/30 px-2.5 py-0.5 rounded-full
                        group-hover:bg-red-100 dark:group-hover:bg-red-900/50 transition-colors">
                        This Month
                    </span>
                </div>
            </div>
        </div>


        <div
            class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-xl shadow-sm border border-gray-100 dark:border-gray-800">

            <div
                class="flex flex-col md:flex-row items-center justify-between p-4 border-b border-gray-100 dark:border-gray-800">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Filter Options</h3>
                <div class="flex items-center gap-2">
                    <button wire:click="$set('showCreateModal', true)"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create Leave Request
                    </button>
                    <button wire:click="resetFilters"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset
                    </button>
                </div>
            </div>

            <!-- Filter Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 p-4">
                <div x-data="{ open: false, selected: [] }" class="relative">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Leave Type</label>
                    <div class="relative">
                        <!-- Custom Select Button -->
                        <button @click="open = !open" type="button"
                            class="relative w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg py-2.5 px-4 text-left text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <span class="block truncate text-sm"
                                x-text="selected.length ? selected.map(s => s.charAt(0).toUpperCase() + s.slice(1)).join(', ') : 'Select leave types...'">
                            </span>
                            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        </button>

                        <!-- Dropdown Panel -->
                        <div x-show="open" @click.away="open = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute z-50 mt-1 w-full bg-white dark:bg-gray-800 shadow-lg rounded-lg py-1 text-base ring-1 ring-black ring-opacity-5 focus:outline-none">

                            <!-- Options List -->
                            <div class="max-h-60 overflow-auto">
                                <div class="relative py-2 px-4">
                                    <div class="space-y-1">
                                        <template x-for="type in ['sick', 'annual', 'important', 'other']" :key="type">
                                            <label
                                                class="relative flex items-center p-2 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer">
                                                <input type="checkbox" :checked="selected.includes(type)" @change="
                                                        $event.target.checked ? selected.push(type) : selected = selected.filter(i => i !== type);
                                                        $wire.set('filters.leavetype', selected)
                                                    "
                                                    class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                                <span
                                                    class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300 capitalize"
                                                    x-text="type"></span>
                                            </label>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div x-data="{ isOpen: false }" class="relative">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date</label>

                    <button @click="isOpen = !isOpen"
                        class="w-full flex items-center justify-between gap-x-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1D4ED8]">
                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                        {{ Cake\Chronos\Chronos::parse($filters['startDate'])->format('M d, Y') }} -
                        {{ Cake\Chronos\Chronos::parse($filters['endDate'])->format('M d, Y') }}
                        <svg class="w-4 h-4 text-gray-400" :class="{ 'rotate-180': isOpen }" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>

                    {{-- Dropdown Panel (Keep existing content) --}}
                    <div x-show="isOpen" @click.outside="isOpen = false"
                        class="absolute right-0 z-10 mt-2 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden min-w-[320px] sm:w-[600px]">
                        <div class="p-4">
                            <div class="flex items-center justify-between space-x-4">
                                {{-- Start Date --}}
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                                    <input type="date" wire:model.live="filters.startDate"
                                        class="block w-full rounded-md border border-gray-300 bg-white py-2 pl-3 pr-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                                </div>

                                {{-- End Date --}}
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                                    <input type="date" wire:model.live="filters.endDate"
                                        class="block w-full rounded-md border border-gray-300 bg-white py-2 pl-3 pr-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                                </div>
                            </div>

                            {{-- Quick Select Buttons --}}
                            <div class="mt-4">
                                <div class="text-xs font-medium text-gray-700 mb-2">Quick Select</div>
                                <div class="grid grid-cols-4 gap-2">
                                    <button wire:click="setDateRange('today')" @click="isOpen = false" type="button"
                                        class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Today
                                    </button>
                                    <button wire:click="setDateRange('yesterday')" @click="isOpen = false" type="button"
                                        class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Yesterday
                                    </button>
                                    <button wire:click="setDateRange('thisWeek')" @click="isOpen = false" type="button"
                                        class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        This Week
                                    </button>
                                    <button wire:click="setDateRange('lastWeek')" @click="isOpen = false" type="button"
                                        class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Last Week
                                    </button>
                                    <button wire:click="setDateRange('thisMonth')" @click="isOpen = false" type="button"
                                        class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        This Month
                                    </button>
                                    <button wire:click="setDateRange('lastMonth')" @click="isOpen = false" type="button"
                                        class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Last Month
                                    </button>
                                    <button wire:click="setDateRange('last30Days')" @click="isOpen = false"
                                        type="button"
                                        class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Last 30 Days
                                    </button>
                                    <button wire:click="setDateRange('last90Days')" @click="isOpen = false"
                                        type="button"
                                        class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Last 90 Days
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div x-data="{ open: false, selected: [] }" class="relative">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <div class="relative">
                        <!-- Custom Select Button -->
                        <button @click="open = !open" type="button"
                            class="relative w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg py-2.5 px-4 text-left text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <span class="block truncate text-sm"
                                x-text="selected.length ? selected.map(s => s.charAt(0).toUpperCase() + s.slice(1)).join(', ') : 'Select statuses...'">
                            </span>
                            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        </button>

                        <!-- Dropdown Panel -->
                        <div x-show="open" @click.away="open = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute z-50 mt-1 w-full bg-white dark:bg-gray-800 shadow-lg rounded-lg py-1 text-base ring-1 ring-black ring-opacity-5 focus:outline-none">

                            <!-- Options List -->
                            <div class="max-h-60 overflow-auto">
                                <div class="relative py-2 px-4">
                                    <div class="space-y-1">
                                        <template x-for="status in ['pending', 'approved', 'rejected']" :key="status">
                                            <label
                                                class="relative flex items-center p-2 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer">
                                                <input type="checkbox" :checked="selected.includes(status)" @change="
                                                        $event.target.checked ? selected.push(status) : selected = selected.filter(i => i !== status);
                                                        $wire.set('filters.status', selected)
                                                    "
                                                    class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                                <span
                                                    class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300 capitalize"
                                                    x-text="status"></span>
                                            </label>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search
                        Employee</label>
                    <div class="relative">
                        <input type="text" wire:model.live.debounce.300ms="filters.search"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-gray-700 dark:text-gray-300 focus:ring-blue-500 focus:border-blue-500 pl-10"
                            placeholder="Search name or email...">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Filters Display -->
            <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-800">
                <div class="flex flex-wrap gap-2">
                    @if (!empty($activeFilters))
                    <!-- Date Range Filter -->
                    @if (!empty($activeFilters['startDate']) && !empty($activeFilters['endDate']))
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                        Date: {{ Cake\Chronos\Chronos::parse($activeFilters['startDate'])->format('M d, Y') }} - {{
                        Cake\Chronos\Chronos::parse($activeFilters['endDate'])->format('M d, Y') }}
                        <button wire:click="removeFilter('startDate')" class="ml-1 inline-flex items-center">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </span>
                    @endif

                    <!-- Leave Type Filter -->
                    @if (!empty($activeFilters['leavetype']))
                    @foreach ($activeFilters['leavetype'] as $type)
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                        Leave Type: {{ ucfirst($type) }}
                        <button wire:click="removeFilterValue('leavetype', '{{ $type }}')"
                            class="ml-1 inline-flex items-center">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </span>
                    @endforeach
                    @endif

                    <!-- Status Filter -->
                    @if (!empty($activeFilters['status']))
                    @foreach ($activeFilters['status'] as $status)
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                        Status: {{ ucfirst($status) }}
                        <button wire:click="removeFilterValue('status', '{{ $status }}')"
                            class="ml-1 inline-flex items-center">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </span>
                    @endforeach
                    @endif

                    <!-- Search Filter -->
                    @if (!empty($activeFilters['search']))
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                        Search: {{ $activeFilters['search'] }}
                        <button wire:click="removeFilter('search')" class="ml-1 inline-flex items-center">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </span>
                    @endif
                    @else
                    <span class="text-sm text-gray-500 dark:text-gray-400">No active filters</span>
                    @endif
                </div>
            </div>

            <!-- Table Header -->
            <div>
                <div
                    class="flex flex-col md:flex-row items-center justify-between p-4 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Leave Requests</h3>
                    <div class="flex items-center gap-3">
                        <!-- Export Button -->
                        <button wire:click="exportToExcell" wire:loading.attr="disabled"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            <span wire:loading.remove wire:target="exportToExcell">Export</span>
                        </button>

                        <!-- Print Button -->
                        <button wire:click="printData" wire:loading.attr="disabled"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            <span wire:loading.remove wire:target="printData">Print</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table Container -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead
                        class="text-xs uppercase tracking-wider text-gray-700 dark:text-gray-300 bg-gray-50/50 dark:bg-gray-800/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-medium">Employee</th>
                            <th scope="col" class="px-6 py-4 font-medium">Leave Type</th>
                            <th scope="col" class="px-6 py-4 font-medium whitespace-nowrap">Date Range</th>
                            <th scope="col" class="px-6 py-4 font-medium whitespace-nowrap">Status</th>
                            <th scope="col" class="px-6 py-4 font-medium whitespace-nowrap">Approved By</th>
                            <th scope="col" class="px-6 py-4 font-medium">Reason</th>
                            <th scope="col" class="px-6 py-4 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse ($leaveRequests as $request)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition duration-150">
                            <!-- Employee Column -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <img class="h-10 w-10 rounded-full object-cover ring-2 ring-gray-100 dark:ring-gray-800"
                                        src="{{ asset($request->user->image) }}" alt="{{ $request->user->name }}">
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-white">
                                            {{ $request->user->name }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $request->user->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Leave Type Column -->
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @switch($request->type)
                                        @case('sick')
                                            bg-red-50 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                            @break
                                        @case('annual')
                                            bg-green-50 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                            @break
                                        @case('important')
                                            bg-yellow-50 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                            @break
                                        @default
                                            bg-gray-50 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300
                                    @endswitch
                                    ">
                                    {{ ucfirst($request->type) }}
                                </span>
                            </td>

                            <!-- Date Range Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-gray-900 dark:text-white">
                                    {{ Cake\Chronos\Chronos::parse($request->start_date)->format('M d, Y') }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    to {{ Cake\Chronos\Chronos::parse($request->end_date)->format('M d, Y') }}
                                </div>
                            </td>

                            <!-- Status Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        @switch($request->status)
                            @case('approved')
                                bg-green-50 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                @break
                            @case('rejected')
                                bg-red-50 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                @break
                            @default
                                bg-yellow-50 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                        @endswitch
                    ">
                                    {{ ucfirst($request->status) }}
                                </span>
                            </td>

                            <!-- Approved By Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($request->approvedBy)
                                <div class="text-gray-900 dark:text-white">
                                    {{ $request->approvedBy->name }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ Cake\Chronos\Chronos::parse($request->approved_at)->format('M d, Y h:i A') }}
                                </div>
                                @else
                                <span class="text-gray-500 dark:text-gray-400">Pending</span>
                                @endif
                            </td>

                            <!-- Reason Column -->
                            <td class="px-6 py-4">
                                <div class="max-w-xs truncate text-gray-500 dark:text-gray-400">
                                    {{ $request->reason }}
                                </div>
                            </td>
                            <!-- Add this cell to your table row -->
                            <td class="px-6 py-4 text-right">
                                <div class="relative" x-data="{ open: false }">
                                    <!-- Three dots button -->
                                    <button @click="open = !open" @click.away="open = false"
                                        class="inline-flex items-center justify-center w-8 h-8 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 rounded-full transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12 3c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 14c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-7c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
                                        </svg>
                                    </button>

                                    <!-- Dropdown menu -->
                                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-lg bg-white dark:bg-gray-800 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none divide-y divide-gray-100 dark:divide-gray-700">

                                        <!-- Status Change -->
                                        <div class="py-1">
                                            <button wire:click="changeStatus({{ $request->id }})" @click="open = false"
                                                class="group flex w-full items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50">
                                                <svg class="mr-3 h-5 w-5 
                                                    @if($request->status === 'pending')
                                                        text-yellow-500 dark:text-yellow-400
                                                    @elseif($request->status === 'approved')
                                                        text-green-500 dark:text-green-400
                                                    @else
                                                        text-red-500 dark:text-red-400
                                                    @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                                {{ ucfirst($request->status) }}
                                            </button>
                                        </div>

                                        <!-- Edit & Delete -->
                                        <div class="py-1">
                                            <button wire:click="editRequest({{ $request->id }})" @click="open = false"
                                                class="group flex w-full items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50">
                                                <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Edit
                                            </button>

                                            <button
                                                @click="$dispatch('open-delete-modal', { id: {{ $request->id }} }); open = false"
                                                class="group flex w-full items-center px-4 py-2 text-sm text-red-700 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700/50">
                                                <svg class="mr-3 h-5 w-5 text-red-400 group-hover:text-red-500"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12">
                                <div class="flex flex-col items-center justify-center text-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No records found
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        No leave requests match your current filters.
                                    </p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Pagination -->
                <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100 dark:border-gray-800">
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-700 dark:text-gray-300">
                            Showing
                            <span class="font-medium">
                                {{ $leaveRequests->firstItem() ?? 0 }}
                            </span>
                            to
                            <span class="font-medium">
                                {{ $leaveRequests->lastItem() ?? 0 }}
                            </span>
                            of
                            <span class="font-medium">
                                {{ $leaveRequests->total() }}
                            </span>
                            results
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        {{ $leaveRequests->links(data: ['scrollTo' => false]) }}
                    </div>
                </div>
            </div>


        </div>
    </x-layouts.admin>

    <!-- Status Change Modal -->
    <div x-data="{ show: @entangle('showStatusModal') }" x-show="show" x-cloak
        class="fixed inset-0 z-50 overflow-y-auto bg-gray-500 bg-opacity-75 backdrop-blur-sm transition-all"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        <div class="flex min-h-screen items-center justify-center p-4">
            <!-- Modal Panel -->
            <div class="relative w-full max-w-xl transform overflow-hidden rounded-2xl bg-white dark:bg-gray-800 shadow-2xl transition-all"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Update Leave Request Status
                        </h3>
                        <button @click="show = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                @if($selectedRequest)
                <!-- Current Status Display -->
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                @switch($selectedRequest->status)
                                @case('pending')
                                <div
                                    class="w-10 h-10 rounded-full bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                @break
                                @case('approved')
                                <div
                                    class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                @break
                                @case('rejected')
                                <div
                                    class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </div>
                                @break
                                @endswitch
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Current Status</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ ucfirst($selectedRequest->status)
                                    }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/30">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        @if($selectedRequest->status !== 'approved')
                        <button wire:click="updateStatus('approved')"
                            class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Approve
                        </button>
                        @endif

                        @if($selectedRequest->status !== 'rejected')
                        <button wire:click="updateStatus('rejected')"
                            class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Reject
                        </button>
                        @endif

                        @if($selectedRequest->status !== 'pending')
                        <button wire:click="updateStatus('pending')"
                            class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-yellow-600 rounded-lg hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Set Pending
                        </button>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-data="{ show: @entangle('showEditModal') }" x-show="show" x-cloak
        class="fixed inset-0 z-50 overflow-y-auto bg-gray-500 bg-opacity-75 backdrop-blur-sm transition-all"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        <div class="flex min-h-screen items-center justify-center p-4">
            <!-- Modal Panel -->
            <div class="relative w-full max-w-xl transform rounded-2xl bg-white dark:bg-gray-800 shadow-2xl transition-all"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                <!-- Modal Header -->
                <div class="flex items-center justify-between border-b border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Edit Leave Request
                    </h3>
                    <button @click="show = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <form wire:submit.prevent="updateRequest" class="space-y-6">
                        <!-- Leave Type -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                Leave Type
                            </label>
                            <div class="relative">
                                <select wire:model="editForm.type"
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700/50 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm pl-4 pr-10 py-2.5">
                                    <option value="sick">Sick Leave</option>
                                    <option value="annual">Annual Leave</option>
                                    <option value="important">Important Leave</option>
                                    <option value="other">Other</option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Date Range -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    Start Date
                                </label>
                                <div class="relative">
                                    <input type="date" wire:model="editForm.start_date"
                                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700/50 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm pl-4 pr-10 py-2.5">
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500 dark:text-gray-400">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    End Date
                                </label>
                                <div class="relative">
                                    <input type="date" wire:model="editForm.end_date"
                                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700/50 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm pl-4 pr-10 py-2.5">
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500 dark:text-gray-400">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reason -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                Reason
                            </label>
                            <textarea wire:model="editForm.reason" rows="4"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700/50 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm resize-none"
                                placeholder="Please provide your reason here..."></textarea>
                        </div>
                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-end gap-3 border-t border-gray-200 dark:border-gray-700 p-6">
                    <button type="button" @click="show = false"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" wire:click="updateRequest"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Update Request
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- Create Modal -->
    <div x-data="{ show: @entangle('showCreateModal') }" x-show="show" x-cloak
        class="fixed inset-0 z-50 overflow-y-auto bg-gray-500 bg-opacity-75 backdrop-blur-sm transition-all"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        <div class="flex min-h-screen items-center justify-center p-4">
            <!-- Modal Panel -->
            <div class="relative w-full max-w-xl transform rounded-2xl bg-white dark:bg-gray-800 shadow-2xl transition-all"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                <!-- Modal Header -->
                <div class="flex items-center justify-between border-b border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Create Leave Request
                    </h3>
                    <button @click="show = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <form wire:submit.prevent="createRequest" class="space-y-6">
                        <!-- User Selection -->
                        <div class="space-y-2" x-data="{ 
                                open: false, 
                                searchTerm: '',
                                closeOnSelect: () => {
                                    open = false;
                                    searchTerm = '';
                                }
                            }">
                            <label class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                Select User
                            </label>
                            <div class="relative">
                                <button @click="open = !open" type="button"
                                    class="w-full bg-white dark:bg-gray-700/50 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2.5 text-left focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <div class="flex items-center">
                                        @if($createForm['user_id'])
                                        @php
                                        $selectedUser = $users->where('id', $createForm['user_id'])->first();
                                        @endphp
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-6 w-6 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                                <span class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                                    {{ $selectedUser ? substr($selectedUser->name, 0, 1) : '' }}
                                                </span>
                                            </div>
                                            <span class="ml-2 text-gray-900 dark:text-gray-100">
                                                {{ $selectedUser ? $selectedUser->name : 'Select User' }}
                                            </span>
                                        </div>
                                        @else
                                        <span class="text-gray-500">Select User</span>
                                        @endif
                                        <span class="ml-auto">
                                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    </div>
                                </button>

                                <!-- Dropdown -->
                                <div x-show="open" @click.away="closeOnSelect()"
                                    class="absolute z-10 w-full mt-1 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">

                                    <!-- Search Box -->
                                    <div class="p-2 border-b border-gray-200 dark:border-gray-700">
                                        <input type="text" x-model="searchTerm"
                                            class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700/50 pl-8 pr-4 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="Search user...">
                                    </div>

                                    <!-- Users List -->
                                    <div class="max-h-60 overflow-y-auto py-1">
                                        @foreach($users as $user)
                                        <template
                                            x-if="'{{ strtolower($user->name) }}'.includes(searchTerm.toLowerCase()) || searchTerm === ''">
                                            <button type="button"
                                                wire:click="$set('createForm.user_id', {{ $user->id }})"
                                                @click="closeOnSelect()"
                                                class="w-full px-4 py-2 text-left hover:bg-gray-100 dark:hover:bg-gray-700/50 flex items-center space-x-3">
                                                <div
                                                    class="flex-shrink-0 h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                                        {{ substr($user->name, 0, 1) }}
                                                    </span>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{
                                                        $user->name }}</p>
                                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                                </div>
                                                @if($createForm['user_id'] == $user->id)
                                                <svg class="h-5 w-5 text-blue-600" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                @endif
                                            </button>
                                        </template>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @error('createForm.user_id')
                            <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Leave Type -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                Leave Type
                            </label>
                            <div class="relative">
                                <select wire:model="createForm.type"
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700/50 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm pl-4 pr-10 py-2.5">
                                    <option value="">Select Type</option>
                                    <option value="sick">Sick Leave</option>
                                    <option value="annual">Annual Leave</option>
                                    <option value="important">Important Leave</option>
                                    <option value="other">Other</option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            @error('createForm.type')
                            <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Date Range -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    Start Date
                                </label>
                                <div class="relative">
                                    <input type="date" wire:model="createForm.start_date"
                                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700/50 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm pl-4 pr-10 py-2.5">
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500 dark:text-gray-400">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                                @error('createForm.start_date')
                                <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    End Date
                                </label>
                                <div class="relative">
                                    <input type="date" wire:model="createForm.end_date"
                                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700/50 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm pl-4 pr-10 py-2.5">
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500 dark:text-gray-400">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                                @error('createForm.end_date')
                                <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Reason -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                Reason
                            </label>
                            <textarea wire:model="createForm.reason" rows="4"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700/50 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm resize-none"
                                placeholder="Please provide your reason here..."></textarea>
                            @error('createForm.reason')
                            <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="space-y-2" x-data="{ 
                            open: false, 
                            searchTerm: '',
                            closeOnSelect: () => {
                                open = false;
                                searchTerm = '';
                            }
                        }">
                            <label class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                Approver
                            </label>
                            <div class="relative">
                                <!-- Main Button -->
                                <button @click="open = !open" type="button"
                                    class="w-full bg-white dark:bg-gray-700/50 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2.5 text-left focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <div class="flex items-center">
                                        @if($createForm['approved_by'])
                                        @php
                                        $selectedManager = $managers->where('id', $createForm['approved_by'])->first();
                                        @endphp
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-6 w-6 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                                <span class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                                    {{ $selectedManager ? substr($selectedManager->name, 0, 1) : '' }}
                                                </span>
                                            </div>
                                            <span class="ml-2 text-gray-900 dark:text-gray-100">
                                                {{ $selectedManager ? $selectedManager->name : 'Select Approver' }}
                                            </span>
                                        </div>
                                        @else
                                        <span class="text-gray-500">Select Approver</span>
                                        @endif
                                        <span class="ml-auto">
                                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    </div>
                                </button>

                                <!-- Dropdown -->
                                <div x-show="open" @click.away="closeOnSelect()"
                                    class="absolute z-10 w-full mt-1 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95">

                                    <!-- Search Box -->
                                    <div class="p-2 border-b border-gray-200 dark:border-gray-700">
                                        <div class="relative">
                                            <input type="text" x-model="searchTerm"
                                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700/50 pl-8 pr-4 py-2 text-sm text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500"
                                                placeholder="Search approver..." @click.stop>
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Options List -->
                                    <div class="max-h-60 overflow-y-auto py-1">
                                        @forelse($managers as $manager)
                                        <template
                                            x-if="'{{ strtolower($manager->name) }}'.includes(searchTerm.toLowerCase()) || searchTerm === ''">
                                            <button type="button"
                                                wire:click="$set('createForm.approved_by', {{ $manager->id }})"
                                                @click="closeOnSelect()"
                                                class="w-full px-4 py-2 text-left hover:bg-gray-100 dark:hover:bg-gray-700/50 flex items-center"
                                                :class="{'bg-blue-50 dark:bg-blue-900/50': {{ $createForm['approved_by'] }} == {{ $manager->id }}}">
                                                <!-- Avatar/Initial -->
                                                <div
                                                    class="flex-shrink-0 h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                                        {{ substr($manager->name, 0, 1) }}
                                                    </span>
                                                </div>
                                                <!-- Manager Info -->
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{
                                                        $manager->name }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{
                                                        $manager->email }}</p>
                                                </div>
                                                @if($createForm['approved_by'] == $manager->id)
                                                <svg class="ml-auto h-5 w-5 text-blue-600 dark:text-blue-400"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                @endif
                                            </button>
                                        </template>
                                        @empty
                                        <div class="px-4 py-2 text-sm text-gray-500 dark:text-gray-400 text-center">
                                            No managers found
                                        </div>
                                        @endforelse

                                        <!-- No Results Message -->
                                        <div x-show="searchTerm !== '' && !$el.querySelector('button')"
                                            class="px-4 py-2 text-sm text-gray-500 dark:text-gray-400 text-center">
                                            No results found for "<span x-text="searchTerm"></span>"
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @error('createForm.approved_by')
                            <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                            @enderror
                        </div>

                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-end gap-3 border-t border-gray-200 dark:border-gray-700 p-6">
                    <button type="button" @click="show = false"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" wire:click="createRequest"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg wire:loading wire:target="createRequest" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span wire:loading.remove wire:target="createRequest">Create Request</span>
                        <span wire:loading wire:target="createRequest">Creating...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- Delete Confirmation Modal -->
    <div x-data="{ show: false, requestId: null }" @open-delete-modal.window="show = true; requestId = $event.detail.id"
        x-show="show" class="fixed inset-0 z-[99] overflow-y-auto" x-cloak>
        <!-- Backdrop -->
        <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/75 backdrop-blur-sm"></div>

        <!-- Modal Panel -->
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div x-show="show" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <!-- Modal Content -->
                    <div class="bg-white dark:bg-gray-800 px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-white">
                                    Delete Leave Request
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Are you sure you want to delete this leave request? This action cannot be undone
                                        and all associated data will be permanently removed.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="bg-gray-50 dark:bg-gray-800/50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                        <!-- Delete Button -->
                        <button type="button" wire:click="deleteRequest(requestId)" @click="show = false"
                            class="inline-flex w-full justify-center items-center rounded-lg bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:w-auto relative overflow-hidden group">
                            <span class="relative flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete Request
                            </span>
                        </button>

                        <!-- Cancel Button -->
                        <button type="button" @click="show = false"
                            class="mt-3 inline-flex w-full justify-center rounded-lg bg-white dark:bg-gray-700 px-3 py-2 text-sm font-semibold text-gray-900 dark:text-gray-200 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 sm:mt-0 sm:w-auto">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('reset-filters', () => {
                // Reset Alpine.js states
                document.querySelectorAll('[x-data]').forEach(el => {
                    if (el.__x) {
                        el.__x.getUnobservedData().selected = [];
                    }
                });
            });
        });
    </script>
</div>