<div>
    <!-- Full Width Filter Section -->
    <div
        class="w-full bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl border-b border-gray-100 dark:border-gray-800 mb-6 rounded-lg">
        <div class="max-w-[1600px] mx-auto">
            <!-- Filter Content -->
            <div class="p-6">
                <!-- Filter Grid -->
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Month Filter -->
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Month</label>
                        <div class="relative">
                            <select wire:model.live="selectedMonth"
                                class="block w-full rounded-lg border-0 py-3 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:bg-gray-800 dark:text-white dark:ring-gray-700 dark:focus:ring-blue-500">
                                @foreach ($availableMonths as $month)
                                    <option value="{{ $month['value'] }}">{{ $month['label'] }}</option>
                                @endforeach
                            </select>
                            <!-- Dropdown Icon -->
                        </div>
                    </div>

                    <!-- Search Filter -->
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search</label>
                        <div class="relative">
                            <input type="text" wire:model.live.debounce.300ms="search"
                                class="block w-full rounded-lg border-0 py-3 pl-12 pr-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:bg-gray-800 dark:text-white dark:ring-gray-700 dark:focus:ring-blue-500"
                                placeholder="Search employees...">
                            <!-- Search Icon -->
                        </div>
                    </div>

                    <!-- Department Filter -->
                    <div class="flex-1">
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Department</label>
                        <div class="relative">
                            <select wire:model.live="department"
                                class="block w-full rounded-lg border-0 py-3 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 dark:bg-gray-800 dark:text-white dark:ring-gray-700 dark:focus:ring-blue-500">
                                <option value="">All Departments</option>
                                @foreach ($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                            <!-- Dropdown Icon -->
                        </div>
                    </div>
                </div>

                <!-- Active Filters -->
                <div class="flex flex-wrap items-center gap-2 mt-4 text-sm">
                    <span class="text-gray-600 dark:text-gray-400">Active Filters:</span>
                    <div
                        class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ Carbon\Carbon::createFromFormat('Y-m', $selectedMonth)->format('F Y') }}
                    </div>
                    @if ($search)
                        <div
                            class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium bg-purple-50 text-purple-700 dark:bg-purple-900/50 dark:text-purple-300">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            {{ $search }}
                            <button wire:click="$set('search', '')"
                                class="ml-2 hover:text-purple-900 dark:hover:text-purple-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endif
                    @if ($department)
                        <div
                            class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium bg-emerald-50 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            {{ $department }}
                            <button wire:click="$set('department', '')"
                                class="ml-2 hover:text-emerald-900 dark:hover:text-emerald-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6 border-t border-gray-100 dark:border-gray-800">
                <!-- Total Attendance Card -->
                <div
                    class="group bg-white dark:bg-gray-900 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-800 hover:shadow-lg hover:border-blue-200 dark:hover:border-blue-900/50 transition-all duration-300 cursor-pointer">
                    <div class="flex items-center justify-between">
                        <div class="space-y-3">
                            <div class="space-y-1">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Attendance</p>
                                <p
                                    class="text-2xl font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                    {{ $attendances->count() }}
                                </p>
                            </div>
                            <div class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Today's Records
                            </div>
                        </div>
                        <div
                            class="p-3 bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-lg group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                    <!-- Progress Bar -->
                    <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                        <div class="relative h-2 bg-blue-100 dark:bg-blue-900/30 rounded-full overflow-hidden">
                            <div class="absolute inset-y-0 left-0 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full"
                                style="width: 100%"></div>
                        </div>
                    </div>
                </div>

                <!-- On Time Card -->
                <div
                    class="group bg-white dark:bg-gray-900 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-800 hover:shadow-lg hover:border-emerald-200 dark:hover:border-emerald-900/50 transition-all duration-300 cursor-pointer">
                    <div class="flex items-center justify-between">
                        <div class="space-y-3">
                            <div class="space-y-1">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">On Time</p>
                                <p
                                    class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 group-hover:text-emerald-500">
                                    {{ $attendances->where('status', 'present')->count() }}
                                </p>
                            </div>
                            <div
                                class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                </svg>
                                {{ number_format(($attendances->where('status', 'present')->count() / max($attendances->count(), 1)) * 100, 1) }}%
                                Rate
                            </div>
                        </div>
                        <div
                            class="p-3 bg-gradient-to-br from-emerald-50 to-green-50 dark:from-emerald-900/30 dark:to-green-900/30 rounded-lg group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <!-- Progress Bar -->
                    <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                        <div class="relative h-2 bg-emerald-100 dark:bg-emerald-900/30 rounded-full overflow-hidden">
                            <div class="absolute inset-y-0 left-0 bg-gradient-to-r from-emerald-500 to-green-500 rounded-full"
                                style="width: {{ ($attendances->where('status', 'present')->count() / max($attendances->count(), 1)) * 100 }}%">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Late Card -->
                <div
                    class="group bg-white dark:bg-gray-900 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-800 hover:shadow-lg hover:border-red-200 dark:hover:border-red-900/50 transition-all duration-300 cursor-pointer">
                    <div class="flex items-center justify-between">
                        <div class="space-y-3">
                            <div class="space-y-1">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Late</p>
                                <p class="text-2xl font-bold text-red-600 dark:text-red-400 group-hover:text-red-500">
                                    {{ $attendances->where('status', 'late')->count() }}
                                </p>
                            </div>
                            <div
                                class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-300">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                                {{ number_format(($attendances->where('status', 'late')->count() / max($attendances->count(), 1)) * 100, 1) }}%
                                Rate
                            </div>
                        </div>
                        <div
                            class="p-3 bg-gradient-to-br from-red-50 to-rose-50 dark:from-red-900/30 dark:to-rose-900/30 rounded-lg group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <!-- Progress Bar -->
                    <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                        <div class="relative h-2 bg-red-100 dark:bg-red-900/30 rounded-full overflow-hidden">
                            <div class="absolute inset-y-0 left-0 bg-gradient-to-r from-red-500 to-rose-500 rounded-full"
                                style="width: {{ ($attendances->where('status', 'late')->count() / max($attendances->count(), 1)) * 100 }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="max-w-[1600px] mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Content (Table) -->
            <div class="lg:col-span-2">
                <div
                    class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-xl shadow-sm border border-gray-100 dark:border-gray-800">
                    <!-- Table Toolbar -->
                    <div
                        class="flex flex-col md:flex-row items-center justify-between p-4 border-b border-gray-100 dark:border-gray-800">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Attendance Records</h3>
                        <div class="flex items-center gap-3">
                            <!-- Export Button -->
                            <button
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Export
                            </button>
                            <!-- Print Button -->
                            <button
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                                Print
                            </button>
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
                                    <th scope="col" class="px-6 py-4 font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @forelse ($attendances as $attendance)
                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition duration-150">
                                        <!-- Employee Column -->
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-4">
                                                <img class="h-10 w-10 rounded-full object-cover ring-2 ring-gray-100 dark:ring-gray-800"
                                                    src="{{ asset($attendance->user->image) }}"
                                                    alt="{{ $attendance->user->name }}">
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
                                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    On Time
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    Late
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Actions Column -->
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <button
                                                    class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </button>
                                                <button
                                                    class="p-2 text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-200">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12">
                                            <div class="flex flex-col items-center justify-center text-center">
                                                <svg class="w-12 h-12 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
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
                    <div
                        class="flex items-center justify-between px-6 py-4 border-t border-gray-100 dark:border-gray-800">
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-700 dark:text-gray-300">
                                Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of
                                <span class="font-medium">20</span> results
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button
                                class="px-3 py-1 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50">
                                Previous
                            </button>
                            <button
                                class="px-3 py-1 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                                Next
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Content (Charts) -->
            <div class="lg:col-span-1 space-y-6">
                <div class="lg:col-span-1 space-y-6">
                    <!-- Pie Chart Card -->
                    <div
                        class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Attendance Distribution
                            </h3>
                            <select wire:model.live="selectedPeriod"
                                class="text-sm rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                <option value="today">Today</option>
                                <option value="week">This Week</option>
                                <option value="month">This Month</option>
                            </select>
                        </div>
                        <div wire:ignore id="attendancePieChart" class="w-full h-[300px]"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Full Width Monthly Records Section -->
    <div
        class="w-full bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl border-t border-gray-100 dark:border-gray-800 rounded-lg mt-4">
        <div class="max-w-[1600px] mx-auto">
            <!-- Header -->
            <div class="p-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Monthly Records</h3>
                <button class="text-sm text-blue-600 dark:text-blue-400 hover:underline">View All</button>
            </div>

            <!-- Records Grid -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($attendances->groupBy('user_id') as $userId => $userAttendances)
                    @php
                        $user = $userAttendances->first()->user;
                        $onTimeCount = $userAttendances->where('status', 'present')->count();
                        $lateCount = $userAttendances->where('status', 'late')->count();
                        $totalDays = $userAttendances->count();
                        $attendanceRate = $totalDays > 0 ? ($onTimeCount / $totalDays) * 100 : 0;
                    @endphp

                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-100 dark:border-gray-700 hover:shadow-md transition-all">
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset($user->image) }}"
                                class="w-12 h-12 rounded-full object-cover ring-2 ring-gray-100 dark:ring-gray-700"
                                alt="{{ $user->name }}">

                            <div class="flex-1 min-w-0">
                                <h4 class="font-medium text-gray-900 dark:text-white truncate">{{ $user->name }}
                                </h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ $user->position }}</p>
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="mt-4 grid grid-cols-3 gap-2 text-center text-xs">
                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-2">
                                <div class="font-medium text-blue-600 dark:text-blue-400">{{ $totalDays }}</div>
                                <div class="text-gray-500 dark:text-gray-400">Total Days</div>
                            </div>
                            <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-2">
                                <div class="font-medium text-green-600 dark:text-green-400">{{ $onTimeCount }}</div>
                                <div class="text-gray-500 dark:text-gray-400">On Time</div>
                            </div>
                            <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-2">
                                <div class="font-medium text-red-600 dark:text-red-400">{{ $lateCount }}</div>
                                <div class="text-gray-500 dark:text-gray-400">Late</div>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mt-4">
                            <div class="flex items-center justify-between text-xs mb-1">
                                <span class="text-gray-500 dark:text-gray-400">Attendance Rate</span>
                                <span
                                    class="font-medium text-blue-600 dark:text-blue-400">{{ number_format($attendanceRate, 1) }}%</span>
                            </div>
                            <div class="h-1.5 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full"
                                    style="width: {{ $attendanceRate }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        let pieChart;
        let barChart;

        document.addEventListener('livewire:initialized', async function() {
            // Wait for initial data from Livewire component
            try {
                // First get the data
                const initialData = await @this.getChartData();
                if (!initialData) {
                    console.error('No initial chart data available');
                    return;
                }

                // Initialize charts with the data
                initializeCharts(initialData);

                // Listen for subsequent updates
                Livewire.on('updateCharts', (newData) => {
                    if (newData && newData[0]) {
                        updateCharts(newData[0]);
                    }
                });

            } catch (error) {
                console.error('Error initializing charts:', error);
            }
        });

        async function initializeCharts(chartData) {
            // Validate chart data
            if (!chartData || !chartData.pieChart || !chartData.barChart) {
                console.error('Invalid chart data structure:', chartData);
                return;
            }

            // Destroy existing charts if they exist
            if (pieChart) {
                pieChart.destroy();
            }
            if (barChart) {
                barChart.destroy();
            }

            const isDarkMode = document.documentElement.classList.contains('dark');
            const textColor = isDarkMode ? '#94a3b8' : '#64748b';

            // Pie Chart Configuration
            const pieChartOptions = {
                chart: {
                    type: 'donut',
                    height: 350,
                    animations: {
                        enabled: true
                    }
                },
                series: chartData.pieChart.series,
                labels: chartData.pieChart.labels,
                colors: ['#10b981', '#ef4444'],
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return Math.round(val) + '%';
                    }
                },
                legend: {
                    position: 'bottom',
                    labels: {
                        colors: textColor
                    }
                }
            };

            // Bar Chart Configuration
            const barChartOptions = {
                chart: {
                    type: 'bar',
                    height: 350,
                    animations: {
                        enabled: true
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        borderRadius: 4
                    }
                },
                dataLabels: {
                    enabled: false
                },
                series: chartData.barChart.series,
                xaxis: {
                    categories: chartData.barChart.categories,
                    labels: {
                        style: {
                            colors: textColor
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: textColor
                        }
                    }
                },
                colors: ['#3b82f6', '#ef4444'],
                legend: {
                    position: 'bottom',
                    labels: {
                        colors: textColor
                    }
                }
            };

            try {
                pieChart = new ApexCharts(document.querySelector("#attendancePieChart"), pieChartOptions);
                barChart = new ApexCharts(document.querySelector("#attendanceBarChart"), barChartOptions);

                await Promise.all([
                    pieChart.render(),
                    barChart.render()
                ]);
            } catch (error) {
                console.error('Error rendering charts:', error);
            }
        }

        function updateCharts(data) {
            if (!data || !data.pieChart || !data.barChart) {
                console.error('Invalid update data:', data);
                return;
            }

            try {
                if (pieChart) {
                    pieChart.updateOptions({
                        series: data.pieChart.series,
                        labels: data.pieChart.labels
                    });
                }

                if (barChart) {
                    barChart.updateOptions({
                        series: data.barChart.series,
                        xaxis: {
                            categories: data.barChart.categories
                        }
                    });
                }
            } catch (error) {
                console.error('Error updating charts:', error);
            }
        }
    </script>
</div>
