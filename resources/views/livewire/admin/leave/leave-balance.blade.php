<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <x-layouts.admin>
        <!-- Statistics Cards -->
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4 mb-6">
            <!-- Total Employees -->
            <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-lg border border-gray-200 dark:border-gray-700 p-4 
                transition-all duration-300 hover:shadow-lg hover:scale-105 group">
                <div class="flex items-center justify-between mb-3">
                    <h3
                        class="text-sm font-medium text-gray-600 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                        Total Employees
                    </h3>
                    <div
                        class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg group-hover:bg-blue-100 dark:group-hover:bg-blue-900/50 transition-colors">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span
                        class="text-2xl font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                        {{ $statistics['total_employees'] }}
                    </span>
                    <span
                        class="text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 px-2.5 py-0.5 rounded-full">
                        Employees
                    </span>
                </div>
            </div>

            <!-- Total Leave Balance -->
            <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-lg border border-gray-200 dark:border-gray-700 p-4 
                transition-all duration-300 hover:shadow-lg hover:scale-105 group">
                <div class="flex items-center justify-between mb-3">
                    <h3
                        class="text-sm font-medium text-gray-600 dark:text-gray-300 group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
                        Total Leave Balance
                    </h3>
                    <div
                        class="p-2 bg-green-50 dark:bg-green-900/30 rounded-lg group-hover:bg-green-100 dark:group-hover:bg-green-900/50 transition-colors">
                        <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span
                        class="text-2xl font-semibold text-gray-900 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
                        {{ $statistics['total_leave_balance'] }}
                    </span>
                    <span
                        class="text-xs font-medium text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/30 px-2.5 py-0.5 rounded-full">
                        Total Days
                    </span>
                </div>
            </div>

            <!-- Used Balance -->
            <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-lg border border-gray-200 dark:border-gray-700 p-4 
                transition-all duration-300 hover:shadow-lg hover:scale-105 group">
                <div class="flex items-center justify-between mb-3">
                    <h3
                        class="text-sm font-medium text-gray-600 dark:text-gray-300 group-hover:text-yellow-600 dark:group-hover:text-yellow-400 transition-colors">
                        Used Balance
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
                        {{ $statistics['total_used_balance'] }}
                    </span>
                    <span
                        class="text-xs font-medium text-yellow-600 dark:text-yellow-400 bg-yellow-50 dark:bg-yellow-900/30 px-2.5 py-0.5 rounded-full">
                        Used Days
                    </span>
                </div>
            </div>

            <!-- Remaining Balance -->
            <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-lg border border-gray-200 dark:border-gray-700 p-4 
                transition-all duration-300 hover:shadow-lg hover:scale-105 group">
                <div class="flex items-center justify-between mb-3">
                    <h3
                        class="text-sm font-medium text-gray-600 dark:text-gray-300 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                        Remaining Balance
                    </h3>
                    <div
                        class="p-2 bg-purple-50 dark:bg-purple-900/30 rounded-lg group-hover:bg-purple-100 dark:group-hover:bg-purple-900/50 transition-colors">
                        <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span
                        class="text-2xl font-semibold text-gray-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                        {{ $statistics['total_remaining_balance'] }}
                    </span>
                    <span
                        class="text-xs font-medium text-purple-600 dark:text-purple-400 bg-purple-50 dark:bg-purple-900/30 px-2.5 py-0.5 rounded-full">
                        Available Days
                    </span>
                </div>
            </div>
        </div>
        <div
            class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-xl shadow-sm border border-gray-100 dark:border-gray-800">
            <div
                class="flex flex-col md:flex-row items-center justify-between p-4 border-b border-gray-100 dark:border-gray-800">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Leave Balances</h3>
            </div>

            <!-- Filters Section -->
            <div class="w-full p-4">
                <div class="flex flex-col sm:flex-row gap-4">
                    <!-- Search Employee -->
                    <div class="w-full sm:w-2/3">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Search Employee
                        </label>
                        <div class="relative">
                            <input type="text" wire:model.live.debounce.300ms="filters.search"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-gray-700 dark:text-gray-300 focus:ring-blue-500 focus:border-blue-500 pl-10"
                                placeholder="Search name or email...">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Year Select -->
                    <div class="w-full sm:w-1/3">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Year
                        </label>
                        <select wire:model.live="filters.year"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-gray-700 dark:text-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            @foreach($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead
                        class="text-xs uppercase tracking-wider text-gray-700 dark:text-gray-300 bg-gray-50/50 dark:bg-gray-800/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-medium">Employee</th>
                            <th scope="col" class="px-6 py-4 font-medium">Department</th>
                            <th scope="col" class="px-6 py-4 font-medium">Year</th>
                            <th scope="col" class="px-6 py-4 font-medium">Total Balance</th>
                            <th scope="col" class="px-6 py-4 font-medium">Used Balance</th>
                            <th scope="col" class="px-6 py-4 font-medium">Remaining Balance</th>
                            <th scope="col" class="px-6 py-4 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse ($balances as $balance)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition duration-150">
                            <!-- Employee -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <img class="h-10 w-10 rounded-full object-cover ring-2 ring-gray-100 dark:ring-gray-800"
                                        src="{{ asset($balance->user->image) }}" alt="{{ $balance->user->name }}">
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-white">
                                            {{ $balance->user->name }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $balance->user->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Department -->
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                    {{ $balance->user->department->name }}
                                </span>
                            </td>

                            <!-- Year -->
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-900 dark:text-white">
                                    {{ $balance->year }}
                                </span>
                            </td>

                            <!-- Total Balance -->
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                    {{ $balance->total_balance }} days
                                </span>
                            </td>

                            <!-- Used Balance -->
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-50 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">
                                    {{ $balance->used_balance }} days
                                </span>
                            </td>

                            <!-- Remaining Balance -->
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                    {{ $balance->remaining_balance }} days
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 text-right">
                                <div class="relative" x-data="{ open: false }">
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

                                        <!-- Edit & Delete -->
                                        <div class="py-1">
                                            <button wire:click="editBalance({{ $balance->id }})" @click="open = false"
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
                                                @click="$dispatch('open-delete-modal', { id: {{ $balance->id }} }); open = false"
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
                            <td colspan="7" class="px-6 py-12">
                                <div class="flex flex-col items-center justify-center text-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No records found
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        No leave balances match your current filters.
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
                        <span class="font-medium">{{ $balances->firstItem() ?? 0 }}</span>
                        to
                        <span class="font-medium">{{ $balances->lastItem() ?? 0 }}</span>
                        of
                        <span class="font-medium">{{ $balances->total() }}</span>
                        results
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    {{ $balances->links(data: ['scrollTo' => false]) }}
                </div>
            </div>
        </div>
    </x-layouts.admin>
</div>