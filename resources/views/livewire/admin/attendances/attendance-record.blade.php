<div>
    <x-layouts.admin>

        <!-- Time Period Selector -->
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

        <!-- Statistics Cards -->
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4 mb-6">
            <!-- Present Today Card -->
            <div wire:click="showDetail('present')" class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-lg border border-gray-200 dark:border-gray-700 p-4 
                transition-all duration-300 hover:shadow-lg hover:scale-105 cursor-pointer group">
                <div class="flex items-center justify-between mb-3">
                    <h3
                        class="text-sm font-medium text-gray-600 dark:text-gray-300 group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
                        Present Today</h3>
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
                        {{ $statistics['total_present'] }}
                    </span>
                    <span class="text-xs font-medium text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/30 px-2.5 py-0.5 rounded-full
                         group-hover:bg-green-100 dark:group-hover:bg-green-900/50 transition-colors">
                        On Time
                    </span>
                </div>
            </div>

            <!-- Late Arrivals Card -->
            <div wire:click="showDetail('late')" class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-lg border border-gray-200 dark:border-gray-700 p-4 
                transition-all duration-300 hover:shadow-lg hover:scale-105 cursor-pointer group">
                <div class="flex items-center justify-between mb-3">
                    <h3
                        class="text-sm font-medium text-gray-600 dark:text-gray-300 group-hover:text-yellow-600 dark:group-hover:text-yellow-400 transition-colors">
                        Late Arrivals</h3>
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
                        {{ $statistics['total_late'] }}
                    </span>
                    <span class="text-xs font-medium text-yellow-600 dark:text-yellow-400 bg-yellow-50 dark:bg-yellow-900/30 px-2.5 py-0.5 rounded-full
                         group-hover:bg-yellow-100 dark:group-hover:bg-yellow-900/50 transition-colors">
                        Late Today
                    </span>
                </div>
            </div>

            <!-- Average Check-in Card -->
            <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-lg border border-gray-200 dark:border-gray-700 p-4 
                transition-all duration-300 hover:shadow-lg hover:scale-105 group">
                <div class="flex items-center justify-between mb-3">
                    <h3
                        class="text-sm font-medium text-gray-600 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                        Average Check-in</h3>
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
                        {{ $statistics['average_check_in']
                        ? Carbon\Carbon::parse($statistics['average_check_in'])->format('h:i A')
                        : 'N/A' }}
                    </span>
                    <span class="text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 px-2.5 py-0.5 rounded-full
                         group-hover:bg-blue-100 dark:group-hover:bg-blue-900/50 transition-colors">
                        Average
                    </span>
                </div>
            </div>

            <!-- Pending Checkouts Card -->
            <div wire:click="showDetail('pending')" class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-lg border border-gray-200 dark:border-gray-700 p-4 
                transition-all duration-300 hover:shadow-lg hover:scale-105 cursor-pointer group">
                <div class="flex items-center justify-between mb-3">
                    <h3
                        class="text-sm font-medium text-gray-600 dark:text-gray-300 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors">
                        Pending Checkouts</h3>
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
                        {{ $statistics['pending_checkouts'] }}
                    </span>
                    <span class="text-xs font-medium text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/30 px-2.5 py-0.5 rounded-full
                         group-hover:bg-red-100 dark:group-hover:bg-red-900/50 transition-colors">
                        Pending
                    </span>
                </div>
            </div>
        </div>
        @include('components.modals.user-attendances-detail-modal')



        <!-- Table Container -->
        <div
            class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-xl shadow-sm border border-gray-100 dark:border-gray-800">
            <!-- Header and Actions -->
            <div
                class="flex flex-col md:flex-row items-center justify-between p-4 border-b border-gray-100 dark:border-gray-800">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Filter Options</h3>
                <div class="flex items-center gap-2">
                    <button wire:click="resetFilters"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset
                    </button>
                    <button wire:click="applyFilters"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Apply Filters
                    </button>
                </div>
            </div>

            <!-- Filter Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 p-4">
                <!-- Department Filter -->
                <div x-data="{ 
                    open: false, 
                    selected: [], 
                    departments: @js($departments->map(fn($dept) => ['id' => $dept->id, 'name' => $dept->name])->toArray())
                }" class="relative">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Department</label>
                    <div class="relative">
                        <!-- Custom Select Button -->
                        <button @click="open = !open" type="button"
                            class="relative w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg py-2.5 px-4 text-left text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <span class="block truncate text-sm"
                                x-text="selected.length ? selected.map(id => departments.find(d => d.id === parseInt(id))?.name).join(', ') : 'Select Department...'">
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
                                        <template x-for="dept in departments" :key="dept.id">
                                            <label
                                                class="relative flex items-center p-2 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer">
                                                <input type="checkbox" :value="dept.id"
                                                    :checked="selected.includes(dept.id.toString())" @change="
                                                        $event.target.checked 
                                                            ? selected.push(dept.id.toString()) 
                                                            : selected = selected.filter(i => i !== dept.id.toString());
                                                        $wire.set('filters.department', selected)
                                                    "
                                                    class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                                <span
                                                    class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300 capitalize"
                                                    x-text="dept.name"></span>
                                            </label>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Date Range Filter Section -->
                <div x-data="{ isOpen: false }" class="relative">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date</label>

                    <button @click="isOpen = !isOpen"
                        class="w-full flex items-center justify-between gap-x-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1D4ED8]">
                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                        {{ Carbon\Carbon::parse($filters['startDate'])->format('M d, Y') }} -
                        {{ Carbon\Carbon::parse($filters['endDate'])->format('M d, Y') }}
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

                <!-- Status Filter -->
                <div x-data="{ open: false, selected: [] }" class="relative">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <div class="relative">
                        <!-- Custom Select Button -->
                        <button @click="open = !open" type="button"
                            class="relative w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg py-2.5 px-4 text-left text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <span class="block truncate text-sm"
                                x-text="selected.length ? selected.map(s => s.charAt(0).toUpperCase() + s.slice(1)).join(', ') : 'Select status...'">
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
                                        <template x-for="status in ['present', 'late', 'pending']" :key="status">
                                            <label
                                                class="relative flex items-center p-2 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer">
                                                <input type="checkbox" :checked="selected.includes(status)" @change="$event.target.checked ? selected.push(status) : selected = selected.filter(i => i !== status);
                                                        $wire.set('filters.status', selected)"
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
                    <!-- Department Filters -->
                    @if (!empty($activeFilters['department']))
                    @foreach ((array)$activeFilters['department'] as $deptId)
                    @php
                    $dept = $departments->find($deptId);
                    @endphp
                    @if($dept)
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                        Department: {{ $dept->name }}
                        <button wire:click="removeFilterValue('department', '{{ $deptId }}')"
                            class="ml-1 inline-flex items-center">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </span>
                    @endif
                    @endforeach
                    @endif

                    <!-- Status Filters -->
                    @if (!empty($activeFilters['status']))
                    @foreach ((array)$activeFilters['status'] as $status)
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

                    <!-- Date Range Filter -->
                    @if (!empty($activeFilters['startDate']) && !empty($activeFilters['endDate']))
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                        Date: {{ Carbon\Carbon::parse($activeFilters['startDate'])->format('M d, Y') }} -
                        {{ Carbon\Carbon::parse($activeFilters['endDate'])->format('M d, Y') }}
                        <button wire:click="removeFilter('startDate')" class="ml-1 inline-flex items-center">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </span>
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

            <!-- Table Toolbar -->
            <div>
                <div
                    class="flex flex-col md:flex-row items-center justify-between p-4 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Attendance Records</h3>
                    <div class="flex items-center gap-3">
                        <!-- Export Button -->
                        <button wire:click="exportToCSV" wire:loading.attr="disabled"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            <span wire:loading.remove wire:target="exportToCSV">Export</span>
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
                            <th scope="col" class="px-6 py-4 font-medium">Position & Department</th>
                            <th scope="col" class="px-6 py-4 font-medium whitespace-nowrap">Date</th>
                            <th scope="col" class="px-6 py-4 font-medium whitespace-nowrap">Check In</th>
                            <th scope="col" class="px-6 py-4 font-medium whitespace-nowrap">Check Out</th>
                            <th scope="col" class="px-6 py-4 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse ($attendances as $attendance)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition duration-150">
                            <!-- Employee Column -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <img class="h-10 w-10 rounded-full object-cover ring-2 ring-gray-100 dark:ring-gray-800"
                                        src="{{ asset($attendance->user->image) }}" alt="{{ $attendance->user->name }}">
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-white">
                                            {{ $attendance->user->name }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $attendance->user->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Position & Department Column -->
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    <div class="font-medium text-gray-900 dark:text-white">
                                        {{ $attendance->user->position }}
                                    </div>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                        {{ $attendance->user->department->name }}
                                    </span>
                                </div>
                            </td>

                            <!-- Date Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-gray-900 dark:text-white">
                                    {{ Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ Carbon\Carbon::parse($attendance->date)->format('l') }}
                                </div>
                            </td>

                            <!-- Check In Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-gray-900 dark:text-white">
                                    {{ Carbon\Carbon::parse($attendance->check_in)->format('h:i A') }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ Carbon\Carbon::parse($attendance->check_in)->diffForHumans() }}
                                </div>
                            </td>

                            <!-- Check Out Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($attendance->check_out)
                                <div class="text-gray-900 dark:text-white">
                                    {{ Carbon\Carbon::parse($attendance->check_out)->format('h:i A') }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ Carbon\Carbon::parse($attendance->check_out)->diffForHumans() }}
                                </div>
                                @else
                                <span class="text-gray-500 dark:text-gray-400">Not checked out</span>
                                @endif
                            </td>

                            <!-- Status Column -->
                            <td class="px-6 py-4">
                                @if ($attendance->status === 'present')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    On Time
                                </span>
                                @else
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Late
                                </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12">
                                <div class="flex flex-col items-center justify-center text-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No
                                        records
                                        found
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        No attendance records for the selected filters.
                                    </p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100 dark:border-gray-800">
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-700 dark:text-gray-300">
                        Showing
                        <span class="font-medium">
                            {{ $attendances->firstItem() ?? 0 }}
                        </span>
                        to
                        <span class="font-medium">
                            {{ $attendances->lastItem() ?? 0 }}
                        </span>
                        of
                        <span class="font-medium">
                            {{ $attendances->total() }}
                        </span>
                        results
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    {{ $attendances->links(data: ['scrollTo' => false]) }}
                </div>
            </div>

            {{--
            <!-- Hidden Print Template -->
            <template id="print-template">
                <style>
                    @media print {
                        table {
                            width: 100%;
                            border-collapse: collapse;
                        }

                        th,
                        td {
                            padding: 8px;
                            text-align: left;
                            border-bottom: 1px solid #ddd;
                        }

                        th {
                            background-color: #f3f4f6;
                        }

                        @page {
                            size: landscape;
                        }
                    }
                </style>
            </template>

            <!-- Print Script -->
            @push('scripts')
            <script>
                document.addEventListener('livewire:initialized', () => {
                        @this.on('print-attendance', (event) => {
                            const attendances = event.attendances;
                            const printWindow = window.open('', '_blank');

                            let content = attendances.map(record => `
                        <tr>
                            <td>
                                <div>${record.name}</div>
                                <div style="font-size: 0.875rem; color: #666;">${record.email}</div>
                            </td>
                            <td>
                                <div>${record.position}</div>
                                <div style="font-size: 0.875rem; color: #666;">${record.department}</div>
                            </td>
                            <td>${record.date}</td>
                            <td>${record.check_in}</td>
                            <td>${record.check_out}</td>
                            <td>${record.status}</td>
                        </tr>
                    `).join('');

                            printWindow.document.write(`
                        <!DOCTYPE html>
                        <html>
                        <head>
                            <title>Attendance Records</title>
                            ${document.getElementById('print-template').innerHTML}
                        </head>
                        <body>
                            <h1 style="text-align: center; margin-bottom: 20px;">Attendance Records</h1>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Position & Department</th>
                                        <th>Date</th>
                                        <th>Check In</th>
                                        <th>Check Out</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>${content}</tbody>
                            </table>
                        </body>
                        </html>
                    `);

                            printWindow.document.close();
                            printWindow.focus();
                            setTimeout(() => {
                                printWindow.print();
                                printWindow.close();
                            }, 250);
                        });
                    });
            </script>
            @endpush --}}
        </div>
    </x-layouts.admin>


</div>