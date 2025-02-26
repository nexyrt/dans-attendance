<!-- resources/views/livewire/director-attendances.blade.php -->
<div class="p-4 sm:p-6 lg:p-8">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Attendances</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                View and monitor employee attendances across all departments
            </p>
        </div>
        <div class="mt-4 sm:mt-0 sm:flex-shrink-0 flex space-x-2">
            <button type="button" wire:click="toggleViewMode"
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20"
                    fill="currentColor">
                    @if ($viewMode === 'list')
                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z" />
                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z" />
                    @else
                        <path
                            d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    @endif
                </svg>
                {{ $viewMode === 'list' ? 'Dashboard View' : 'List View' }}
            </button>
            <button type="button" wire:click="export"
                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:bg-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-gray-500 dark:text-gray-400"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export
            </button>
        </div>
    </div>

    <!-- Dashboard View -->
    @if ($viewMode === 'dashboard')
        <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Overall Statistics -->
            <div class="bg-white overflow-hidden shadow rounded-lg dark:bg-gray-800">
                <div class="p-5">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Today's Attendance Overview
                    </h3>
                    <div class="mt-5 grid grid-cols-2 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg dark:bg-blue-900">
                            <p class="text-sm font-medium text-blue-600 dark:text-blue-200">Present</p>
                            <p class="mt-2 text-3xl font-bold text-blue-900 dark:text-blue-100">
                                {{ $stats['presentToday'] }}</p>
                            <p class="mt-1 text-sm text-blue-500 dark:text-blue-300">of {{ $stats['totalEmployees'] }}
                                employees</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg dark:bg-yellow-900">
                            <p class="text-sm font-medium text-yellow-600 dark:text-yellow-200">Late</p>
                            <p class="mt-2 text-3xl font-bold text-yellow-900 dark:text-yellow-100">
                                {{ $stats['lateToday'] }}</p>
                            <p class="mt-1 text-sm text-yellow-500 dark:text-yellow-300">
                                {{ $stats['lateToday'] > 0 ? round(($stats['lateToday'] / $stats['totalEmployees']) * 100) . '%' : '0%' }}
                                of workforce</p>
                        </div>
                        <div class="bg-red-50 p-4 rounded-lg dark:bg-red-900">
                            <p class="text-sm font-medium text-red-600 dark:text-red-200">Absent</p>
                            <p class="mt-2 text-3xl font-bold text-red-900 dark:text-red-100">
                                {{ $stats['absentToday'] }}</p>
                            <p class="mt-1 text-sm text-red-500 dark:text-red-300">
                                {{ $stats['absentToday'] > 0 ? round(($stats['absentToday'] / $stats['totalEmployees']) * 100) . '%' : '0%' }}
                                of workforce</p>
                        </div>
                        <div class="bg-orange-50 p-4 rounded-lg dark:bg-orange-900">
                            <p class="text-sm font-medium text-orange-600 dark:text-orange-200">Early Leave</p>
                            <p class="mt-2 text-3xl font-bold text-orange-900 dark:text-orange-100">
                                {{ $stats['earlyLeave'] }}</p>
                            <p class="mt-1 text-sm text-orange-500 dark:text-orange-300">
                                {{ $stats['earlyLeave'] > 0 ? round(($stats['earlyLeave'] / $stats['totalEmployees']) * 100) . '%' : '0%' }}
                                of workforce</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Department Breakdown -->
            <div class="bg-white overflow-hidden shadow rounded-lg dark:bg-gray-800">
                <div class="p-5">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Department Breakdown</h3>
                    <div class="mt-5 space-y-4">
                        @foreach ($departmentStats as $dept)
                            <div>
                                <div class="flex justify-between items-center">
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $dept['name'] }}
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $dept['present'] }}/{{ $dept['total'] }} Present</p>
                                </div>
                                <div class="mt-2 relative h-4 rounded-full overflow-hidden">
                                    <div class="absolute inset-0 bg-gray-200 dark:bg-gray-700"></div>
                                    <div class="absolute inset-y-0 left-0 bg-green-500"
                                        style="width: {{ ($dept['present'] / $dept['total']) * 100 }}%"></div>
                                    <div class="absolute inset-y-0 left-0 bg-yellow-500"
                                        style="width: {{ ($dept['late'] / $dept['total']) * 100 }}%; 
                                        margin-left: {{ (($dept['present'] - $dept['late']) / $dept['total']) * 100 }}%">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Weekly Trend -->
            <div class="bg-white overflow-hidden shadow rounded-lg dark:bg-gray-800">
                <div class="p-5">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Weekly Attendance Trend
                        </h3>
                        <div>
                            <label for="startDate" class="sr-only">Start Date</label>
                            <input type="date" id="startDate" wire:model.live="dateRange.start"
                                class="text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">

                            <label for="endDate" class="sr-only">End Date</label>
                            <input type="date" id="endDate" wire:model.live="dateRange.end"
                                class="text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                    </div>
                    <div class="mt-5">
                        <div class="h-64 -ml-4"> <!-- Simple chart representation -->
                            <div class="h-full flex items-end space-x-4">
                                @foreach ($weeklyStats as $day)
                                    <div class="flex-1 flex flex-col items-center">
                                        <div class="w-full space-y-1">
                                            <div class="bg-red-400 h-2 rounded-t"
                                                style="height: {{ $day['total'] > 0 ? ($day['early_leave'] / $day['total']) * 100 : 0 }}px">
                                            </div>
                                            <div class="bg-yellow-400 h-2"
                                                style="height: {{ $day['total'] > 0 ? ($day['late'] / $day['total']) * 100 : 0 }}px">
                                            </div>
                                            <div class="bg-green-400 h-2"
                                                style="height: {{ $day['total'] > 0 ? ($day['present'] / $day['total']) * 100 : 0 }}px">
                                            </div>
                                        </div>
                                        <span
                                            class="mt-2 text-xs text-gray-500 dark:text-gray-400">{{ $day['date'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="mt-4 flex justify-center space-x-4">
                            <div class="flex items-center">
                                <span class="h-3 w-3 bg-green-400 rounded-full"></span>
                                <span class="ml-1 text-xs text-gray-500 dark:text-gray-400">Present</span>
                            </div>
                            <div class="flex items-center">
                                <span class="h-3 w-3 bg-yellow-400 rounded-full"></span>
                                <span class="ml-1 text-xs text-gray-500 dark:text-gray-400">Late</span>
                            </div>
                            <div class="flex items-center">
                                <span class="h-3 w-3 bg-red-400 rounded-full"></span>
                                <span class="ml-1 text-xs text-gray-500 dark:text-gray-400">Early Leave</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- List View Filters -->
    <div class="mt-6 bg-white dark:bg-gray-800 shadow px-4 py-5 sm:rounded-lg sm:p-6">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-4 items-end">
            <div>
                <label for="department"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Department</label>
                <div class="mt-1">
                    <x-input.select wire:model.live="selectedDepartment" id="department" name="department"
                        :options="$departments->pluck('id', 'name')" placeholder="All Departments">
                        @slot('options')
                            <option value="">All Departments</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        @endslot
                    </x-input.select>
                </div>
            </div>

            <div>
                <label for="status"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                <div class="mt-1">
                    <x-input.select wire:model.live="selectedStatus" id="status" name="status" :options="$statuses"
                        placeholder="All Statuses">
                        @slot('options')
                            <option value="">All Statuses</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}">{{ str_replace('_', ' ', ucfirst($status)) }}
                                </option>
                            @endforeach
                        @endslot
                    </x-input.select>
                </div>
            </div>

            <div>
                <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                <div class="mt-1">
                    <input type="date" wire:model.live="selectedDate" id="date"
                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>
            </div>

            <div>
                <label for="search"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Search</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input type="text" wire:model.live.debounce.300ms="searchTerm" id="search"
                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-10 sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        placeholder="Name or email">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance List -->
    <div class="mt-6 bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md">
        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse ($attendances as $attendance)
                <li>
                    <button wire:click="viewAttendanceDetails({{ $attendance->id }})"
                        class="w-full text-left hover:bg-gray-50 dark:hover:bg-gray-700 block py-4 px-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    @if ($attendance->user && $attendance->user->image)
                                        <img class="h-10 w-10 rounded-full"
                                            src="{{ asset('storage/' . $attendance->user->image) }}"
                                            alt="{{ $attendance->user->name }}">
                                    @else
                                        <div
                                            class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                            <span class="text-sm font-medium text-indigo-800">
                                                {{ $attendance->user ? substr($attendance->user->name, 0, 2) : 'NA' }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $attendance->user ? $attendance->user->name : 'Unknown User' }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $attendance->user && $attendance->user->department ? $attendance->user->department->name : 'No Department' }}
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="mr-6 text-sm text-gray-500 dark:text-gray-400">
                                    <span>{{ \Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}</span>
                                </div>

                                <div class="mr-6">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $attendance->status === 'present'
                                            ? 'bg-green-100 text-green-800'
                                            : ($attendance->status === 'late'
                                                ? 'bg-yellow-100 text-yellow-800'
                                                : ($attendance->status === 'early_leave'
                                                    ? 'bg-orange-100 text-orange-800'
                                                    : ($attendance->status === 'holiday'
                                                        ? 'bg-blue-100 text-blue-800'
                                                        : 'bg-gray-100 text-gray-800'))) }}">
                                        {{ str_replace('_', ' ', ucfirst($attendance->status)) }}
                                    </span>
                                </div>

                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                    <div class="flex items-center mr-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                        </svg>
                                        <span>{{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') : 'N/A' }}</span>
                                    </div>

                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        <span>{{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i') : 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </button>
                </li>
            @empty
                <li class="py-10">
                    <div class="flex justify-center">
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No attendance records
                                found</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Try adjusting your search or filter parameters.
                            </p>
                        </div>
                    </div>
                </li>
            @endforelse
        </ul>
    </div>

    <div class="mt-4">
        {{ $attendances->links() }}
    </div>

    <!-- Attendance Details Modal -->
    <x-modals.modal name="attendance-details" maxWidth="xl">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    Attendance Details
                </h3>
                <button wire:click="$dispatch('close-modal', 'attendance-details')"
                    class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            @if ($selectedAttendance)
                <div class="mt-6">
                    <div
                        class="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 rounded-t-lg">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Employee</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2 flex items-center">
                            @if ($selectedAttendance->user && $selectedAttendance->user->image)
                                <img class="h-8 w-8 rounded-full mr-2"
                                    src="{{ asset('storage/' . $selectedAttendance->user->image) }}"
                                    alt="{{ $selectedAttendance->user->name }}">
                            @else
                                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center mr-2">
                                    <span class="text-xs font-medium text-indigo-800">
                                        {{ $selectedAttendance->user ? substr($selectedAttendance->user->name, 0, 2) : 'NA' }}
                                    </span>
                                </div>
                            @endif
                            {{ $selectedAttendance->user->name ?? 'Unknown' }}
                        </dd>
                    </div>
                    <div class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Department</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">
                            {{ $selectedAttendance->user && $selectedAttendance->user->department ? $selectedAttendance->user->department->name : 'N/A' }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Date</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">
                            {{ \Carbon\Carbon::parse($selectedAttendance->date)->format('F d, Y') }}
                        </dd>
                    </div>
                    <div class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Status</dt>
                        <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $selectedAttendance->status === 'present'
                                    ? 'bg-green-100 text-green-800'
                                    : ($selectedAttendance->status === 'late'
                                        ? 'bg-yellow-100 text-yellow-800'
                                        : ($selectedAttendance->status === 'early_leave'
                                            ? 'bg-orange-100 text-orange-800'
                                            : ($selectedAttendance->status === 'holiday'
                                                ? 'bg-blue-100 text-blue-800'
                                                : 'bg-gray-100 text-gray-800'))) }}">
                                {{ str_replace('_', ' ', ucfirst($selectedAttendance->status)) }}
                            </span>
                        </dd>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Check In</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">
                            {{ $selectedAttendance->check_in ? \Carbon\Carbon::parse($selectedAttendance->check_in)->format('h:i A') : 'Not checked in' }}
                            @if ($selectedAttendance->check_in_office_id)
                                <span class="text-gray-500 dark:text-gray-400 ml-2">
                                    at
                                    {{ $selectedAttendance->checkInOffice ? $selectedAttendance->checkInOffice->name : 'Unknown location' }}
                                </span>
                            @endif
                        </dd>
                    </div>
                    <div class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Check Out</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">
                            {{ $selectedAttendance->check_out ? \Carbon\Carbon::parse($selectedAttendance->check_out)->format('h:i A') : 'Not checked out' }}
                            @if ($selectedAttendance->check_out_office_id)
                                <span class="text-gray-500 dark:text-gray-400 ml-2">
                                    at
                                    {{ $selectedAttendance->checkOutOffice ? $selectedAttendance->checkOutOffice->name : 'Unknown location' }}
                                </span>
                            @endif
                        </dd>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Working Hours</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">
                            {{ $selectedAttendance->working_hours ?? 'N/A' }} hours
                            @if ($selectedAttendance->late_hours)
                                <span class="text-red-500 ml-2">({{ $selectedAttendance->late_hours }} hours
                                    late)</span>
                            @endif
                        </dd>
                    </div>
                    <div class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Device</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">
                            {{ $selectedAttendance->device_type ?? 'Unknown device' }}
                        </dd>
                    </div>
                    @if ($selectedAttendance->notes || $selectedAttendance->early_leave_reason)
                        <div
                            class="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 rounded-b-lg">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">
                                {{ $selectedAttendance->early_leave_reason ? 'Early Leave Reason' : 'Notes' }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">
                                {{ $selectedAttendance->early_leave_reason ?? ($selectedAttendance->notes ?? 'N/A') }}
                            </dd>
                        </div>
                    @endif

                    @if ($selectedAttendance->check_in_latitude && $selectedAttendance->check_in_longitude)
                        <div class="mt-6">
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-300 mb-2">Check-in Location
                            </h4>
                            <div
                                class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 h-32 flex items-center justify-center">
                                <div class="text-center">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        Lat: {{ $selectedAttendance->check_in_latitude }}, Long:
                                        {{ $selectedAttendance->check_in_longitude }}
                                    </p>
                                    <p class="mt-2 text-sm text-gray-900 dark:text-white">
                                        Map view would be displayed here
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($selectedAttendance->check_out_latitude && $selectedAttendance->check_out_longitude)
                        <div class="mt-6">
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-300 mb-2">Check-out Location
                            </h4>
                            <div
                                class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 h-32 flex items-center justify-center">
                                <div class="text-center">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        Lat: {{ $selectedAttendance->check_out_latitude }}, Long:
                                        {{ $selectedAttendance->check_out_longitude }}
                                    </p>
                                    <p class="mt-2 text-sm text-gray-900 dark:text-white">
                                        Map view would be displayed here
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Additional actions -->
                    <div class="mt-6 flex justify-end space-x-3">
                        @if ($selectedAttendance->status === 'pending present')
                            <button type="button"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Approve Attendance
                            </button>
                        @endif

                        @if (!$selectedAttendance->notes)
                            <button type="button"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:bg-gray-600">
                                Add Note
                            </button>
                        @endif

                        <button wire:click="$dispatch('close-modal', 'attendance-details')" type="button"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:bg-gray-600">
                            Close
                        </button>
                    </div>
                </div>
            @else
                <div class="mt-6 text-center py-4">
                    <p class="text-gray-500 dark:text-gray-400">Loading attendance details...</p>
                </div>
            @endif
        </div>
    </x-modals.modal>

    <!-- Pending Approvals Section -->
    @if ($viewMode === 'dashboard')
        <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Pending Attendance Approvals
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                    Employees with pending attendance confirmation
                </p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Employee
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Department
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Date
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @forelse ($attendances->where('status', 'pending present') as $pending)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if ($pending->user && $pending->user->image)
                                                <img class="h-10 w-10 rounded-full"
                                                    src="{{ asset('storage/' . $pending->user->image) }}"
                                                    alt="{{ $pending->user->name }}">
                                            @else
                                                <div
                                                    class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                    <span class="text-sm font-medium text-indigo-800">
                                                        {{ $pending->user ? substr($pending->user->name, 0, 2) : 'NA' }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $pending->user ? $pending->user->name : 'Unknown User' }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $pending->user ? $pending->user->email : '' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $pending->user && $pending->user->department ? $pending->user->department->name : 'No Department' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ \Carbon\Carbon::parse($pending->date)->format('M d, Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        Check-in:
                                        {{ $pending->check_in ? \Carbon\Carbon::parse($pending->check_in)->format('h:i A') : 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending Approval
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="viewAttendanceDetails({{ $pending->id }})"
                                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                        Review
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"
                                    class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500 dark:text-gray-400">
                                    No pending approvals
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Attendance Reports -->
    @if ($viewMode === 'dashboard')
        <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Attendance Reports</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                    Generate custom attendance reports
                </p>
            </div>
            <div class="p-4 sm:p-6">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                        <h4 class="text-base font-medium text-gray-700 dark:text-gray-300">Monthly Summary</h4>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Monthly attendance statistics by department
                        </p>
                        <button type="button"
                            class="mt-4 w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Generate Report
                        </button>
                    </div>

                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                        <h4 class="text-base font-medium text-gray-700 dark:text-gray-300">Employee Tardiness</h4>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Late arrivals and early departures
                        </p>
                        <button type="button"
                            class="mt-4 w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Generate Report
                        </button>
                    </div>

                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                        <h4 class="text-base font-medium text-gray-700 dark:text-gray-300">Overtime Analysis</h4>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Working hours beyond schedule
                        </p>
                        <button type="button"
                            class="mt-4 w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Generate Report
                        </button>
                    </div>

                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                        <h4 class="text-base font-medium text-gray-700 dark:text-gray-300">Custom Report</h4>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Create a customized attendance report
                        </p>
                        <button type="button"
                            class="mt-4 w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Configure Report
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
