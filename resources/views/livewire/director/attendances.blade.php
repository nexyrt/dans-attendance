<!-- resources/views/livewire/director/attendances.blade.php -->
<div class="max-w-7xl mx-auto py-8">
    <!-- Page Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <h1 class="text-2xl font-bold text-gray-900 leading-tight">
                Attendance Management
            </h1>
            <p class="mt-1 text-sm text-gray-600">
                Track, manage, and review employee attendance records
            </p>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
            <button wire:click="export" type="button"
                class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm text-sm font-medium 
                    text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export Data
            </button>

            <button
                class="inline-flex items-center px-4 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium 
                text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-white" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Refresh Data
            </button>
        </div>
    </div>

    <!-- Dashboard Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Today's Overview -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex items-center space-x-4">
            <div class="rounded-full bg-blue-100 p-3 flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Today's Check-ins</p>
                <p class="text-2xl font-bold text-gray-900">{{ $todayCheckInsCount ?? 0 }}</p>
            </div>
        </div>

        <!-- Present Employees -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex items-center space-x-4">
            <div class="rounded-full bg-green-100 p-3 flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Present</p>
                <p class="text-2xl font-bold text-gray-900">{{ $presentCount ?? 0 }}</p>
            </div>
        </div>

        <!-- Late Employees -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex items-center space-x-4">
            <div class="rounded-full bg-yellow-100 p-3 flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Late</p>
                <p class="text-2xl font-bold text-gray-900">{{ $lateCount ?? 0 }}</p>
            </div>
        </div>

        <!-- Pending Approvals -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex items-center space-x-4">
            <div class="rounded-full bg-purple-100 p-3 flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Pending Approvals</p>
                <p class="text-2xl font-bold text-gray-900">{{ $pendingApprovalCount ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="mb-8 bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Filters</h2>
        <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-6 md:grid-cols-4 lg:grid-cols-4 xl:gap-x-8">
            <div>
                <label for="department" class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                <div>
                    <x-input.select wire:model.live="selectedDepartment" id="department" name="department"
                        placeholder="All Departments" :options="$departments"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50" />
                </div>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <div>
                    <x-input.select wire:model.live="selectedStatus" id="status" name="status"
                        placeholder="All Statuses" :options="$statuses"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50" />
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date Range</label>
                <div>
                    <livewire:date-range-picker :start-date="$startDate" :end-date="$endDate" />
                </div>
            </div>

            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <div>
                    <x-input.search id="search" wire:model.live.debounce.300ms="searchTerm"
                        placeholder="Search employees..."
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50" />
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance List -->
    <div class="bg-white shadow-sm overflow-hidden rounded-xl border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-50">
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Employee
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date & Status
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Check In/Out
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Working Hours
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($attendances as $attendance)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if ($attendance->user && $attendance->user->image)
                                            <img class="h-10 w-10 rounded-full object-cover"
                                                src="{{ asset($attendance->user->image) }}"
                                                alt="{{ $attendance->user->name }}">
                                        @else
                                            <div
                                                class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center">
                                                <span class="text-sm font-medium text-primary-600">
                                                    {{ $attendance->user ? substr($attendance->user->name, 0, 2) : 'NA' }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $attendance->user ? $attendance->user->name : 'Unknown User' }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $attendance->user && $attendance->user->department ? $attendance->user->department->name : 'No Department' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 mb-1">
                                    {{ \Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}</div>
                                <div>
                                    <span
                                        class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $attendance->status === 'present'
                                                ? 'bg-green-100 text-green-800'
                                                : ($attendance->status === 'late'
                                                    ? 'bg-yellow-100 text-yellow-800'
                                                    : ($attendance->status === 'early_leave'
                                                        ? 'bg-orange-100 text-orange-800'
                                                        : ($attendance->status === 'holiday'
                                                            ? 'bg-blue-100 text-blue-800'
                                                            : ($attendance->status === 'pending present'
                                                                ? 'bg-indigo-100 text-indigo-800'
                                                                : 'bg-gray-100 text-gray-800')))) }}">
                                        {{ ucfirst(str_replace('_', ' ', $attendance->status)) }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col text-sm text-gray-900">
                                    <div class="flex items-center mb-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-green-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                        </svg>
                                        {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : 'Not checked in' }}
                                    </div>
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-red-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') : 'Not checked out' }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    @if ($attendance->working_hours)
                                        <span class="font-medium">{{ $attendance->working_hours }}</span> hours
                                    @else
                                        <span class="text-gray-500">N/A</span>
                                    @endif

                                    @if ($attendance->late_hours)
                                        <div class="mt-1">
                                            <span
                                                class="text-red-600 text-xs font-medium bg-red-50 rounded-md px-2 py-0.5">
                                                {{ $attendance->late_hours }} hours late
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <button wire:click="viewAttendanceDetails({{ $attendance->id }})"
                                        class="bg-primary-50 hover:bg-primary-100 text-primary-600 px-3 py-1.5 rounded-lg transition-colors">
                                        View
                                    </button>
                                    @if ($attendance->status === 'pending present')
                                        <button wire:click="approveAttendance({{ $attendance->id }})"
                                            class="bg-green-50 hover:bg-green-100 text-green-600 px-3 py-1.5 rounded-lg transition-colors">
                                            Approve
                                        </button>
                                    @else
                                        <button wire:click="openAddNoteModal({{ $attendance->id }})"
                                            class="bg-gray-50 hover:bg-gray-100 text-gray-600 px-3 py-1.5 rounded-lg transition-colors">
                                            {{ $attendance->notes ? 'Edit Note' : 'Add Note' }}
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="h-16 w-16 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                    </svg>
                                    <h3 class="mt-3 text-base font-medium text-gray-900">No attendance records found
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Try adjusting your filters or search term
                                    </p>
                                    <button type="button"
                                        class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                        Clear Filters
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $attendances->links() }}
        </div>
    </div>

    <!-- Attendance Details Modal -->
    <x-modals.modal name="attendance-details" maxWidth="4xl">
        @if ($selectedAttendance)
            <div class="p-0">
                <div class="flex justify-between items-center p-6 border-b border-gray-200">
                    <h3 class="text-xl leading-6 font-semibold text-gray-900">
                        Attendance Details
                    </h3>
                    <button @click="$dispatch('close-modal', 'attendance-details')" type="button"
                        class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Left Column: Employee Info and Basic Details -->
                        <div class="md:col-span-1">
                            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                                <!-- Employee Profile Section -->
                                <div class="p-5 border-b border-gray-200 bg-gray-50">
                                    <div class="flex items-center">
                                        @if ($selectedAttendance->user && $selectedAttendance->user->image)
                                            <img class="h-16 w-16 rounded-full object-cover border-4 border-white shadow"
                                                src="{{ asset($selectedAttendance->user->image) }}"
                                                alt="{{ $selectedAttendance->user->name }}">
                                        @else
                                            <div
                                                class="h-16 w-16 rounded-full bg-primary-100 flex items-center justify-center border-4 border-white shadow">
                                                <span class="text-xl font-medium text-primary-600">
                                                    {{ $selectedAttendance->user ? substr($selectedAttendance->user->name, 0, 2) : 'NA' }}
                                                </span>
                                            </div>
                                        @endif
                                        <div class="ml-4">
                                            <h4 class="text-lg font-semibold text-gray-900">
                                                {{ $selectedAttendance->user ? $selectedAttendance->user->name : 'Unknown User' }}
                                            </h4>
                                            <p class="text-sm text-gray-600">
                                                {{ $selectedAttendance->user && $selectedAttendance->user->department ? $selectedAttendance->user->department->name : 'No Department' }}
                                            </p>
                                            <span
                                                class="mt-2 inline-flex px-2.5 py-0.5 text-xs leading-5 font-semibold rounded-full 
                                                {{ $selectedAttendance->status === 'present'
                                                    ? 'bg-green-100 text-green-800'
                                                    : ($selectedAttendance->status === 'late'
                                                        ? 'bg-yellow-100 text-yellow-800'
                                                        : ($selectedAttendance->status === 'early_leave'
                                                            ? 'bg-orange-100 text-orange-800'
                                                            : ($selectedAttendance->status === 'holiday'
                                                                ? 'bg-blue-100 text-blue-800'
                                                                : ($selectedAttendance->status === 'pending present'
                                                                    ? 'bg-indigo-100 text-indigo-800'
                                                                    : 'bg-gray-100 text-gray-800')))) }}">
                                                {{ ucfirst(str_replace('_', ' ', $selectedAttendance->status)) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Time Details Section -->
                                <div class="p-5">
                                    <h5 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Time
                                        Details</h5>

                                    <div class="space-y-4">
                                        <div>
                                            <div class="text-xs font-medium text-gray-500 mb-1">Date</div>
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5 mr-2 text-gray-400" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span
                                                    class="text-sm font-medium">{{ \Carbon\Carbon::parse($selectedAttendance->date)->format('F d, Y') }}</span>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="text-xs font-medium text-gray-500 mb-1">Check In</div>
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5 mr-2 text-green-500" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                                </svg>
                                                <span class="text-sm">
                                                    {{ $selectedAttendance->check_in ? \Carbon\Carbon::parse($selectedAttendance->check_in)->format('h:i A') : 'Not checked in' }}
                                                </span>
                                                @if ($selectedAttendance->check_in_office_id)
                                                    <span
                                                        class="ml-2 px-2 inline-flex text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                                        {{ $selectedAttendance->checkInOffice ? $selectedAttendance->checkInOffice->name : 'Unknown location' }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div>
                                            <div class="text-xs font-medium text-gray-500 mb-1">Check Out</div>
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5 mr-2 text-red-500" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                </svg>
                                                <span class="text-sm">
                                                    {{ $selectedAttendance->check_out ? \Carbon\Carbon::parse($selectedAttendance->check_out)->format('h:i A') : 'Not checked out' }}
                                                </span>
                                                @if ($selectedAttendance->check_out_office_id)
                                                    <span
                                                        class="ml-2 px-2 inline-flex text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                                        {{ $selectedAttendance->checkOutOffice ? $selectedAttendance->checkOutOffice->name : 'Unknown location' }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div>
                                            <div class="text-xs font-medium text-gray-500 mb-1">Working Hours</div>
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5 mr-2 text-blue-500" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span class="text-sm font-medium">
                                                    {{ $selectedAttendance->working_hours ?? 'N/A' }} hours
                                                </span>
                                                @if ($selectedAttendance->late_hours)
                                                    <span
                                                        class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        {{ $selectedAttendance->late_hours }} hours late
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div>
                                            <div class="text-xs font-medium text-gray-500 mb-1">Device</div>
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5 mr-2 text-gray-400" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                </svg>
                                                <span
                                                    class="text-sm">{{ $selectedAttendance->device_type ?? 'Unknown' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Location, Notes, and Early Leave Reason -->
                        <div class="md:col-span-2">
                            <!-- Location Information -->
                            @if ($selectedAttendance->check_in_latitude && $selectedAttendance->check_in_longitude)
                                <div class="bg-white rounded-xl border border-gray-200 shadow-sm mb-6 overflow-hidden">
                                    <div class="border-b border-gray-200 px-5 py-4">
                                        <h5 class="font-medium text-gray-900">Location Information</h5>
                                    </div>

                                    <div class="p-5">
                                        <div class="rounded-lg bg-gray-50 p-4 mb-4">
                                            <div class="flex items-center mb-3">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5 text-blue-500 mr-2" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                <span class="font-medium text-gray-700">Check-in Location</span>
                                            </div>

                                            <div
                                                class="flex flex-col sm:flex-row sm:items-center text-sm text-gray-600">
                                                <div class="mb-2 sm:mb-0 sm:mr-6">
                                                    <span class="font-medium text-gray-700">Lat:</span>
                                                    {{ $selectedAttendance->check_in_latitude }}
                                                </div>
                                                <div>
                                                    <span class="font-medium text-gray-700">Long:</span>
                                                    {{ $selectedAttendance->check_in_longitude }}
                                                </div>

                                                @if ($selectedAttendance->check_in_office_id)
                                                    <div class="mt-2 sm:mt-0 sm:ml-auto">
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                            {{ $selectedAttendance->checkInOffice ? $selectedAttendance->checkInOffice->name : 'Unknown location' }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        @if ($selectedAttendance->check_out_latitude && $selectedAttendance->check_out_longitude)
                                            <div class="rounded-lg bg-gray-50 p-4">
                                                <div class="flex items-center mb-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-5 w-5 text-red-500 mr-2" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    <span class="font-medium text-gray-700">Check-out Location</span>
                                                </div>

                                                <div
                                                    class="flex flex-col sm:flex-row sm:items-center text-sm text-gray-600">
                                                    <div class="mb-2 sm:mb-0 sm:mr-6">
                                                        <span class="font-medium text-gray-700">Lat:</span>
                                                        {{ $selectedAttendance->check_out_latitude }}
                                                    </div>
                                                    <div>
                                                        <span class="font-medium text-gray-700">Long:</span>
                                                        {{ $selectedAttendance->check_out_longitude }}
                                                    </div>

                                                    @if ($selectedAttendance->check_out_office_id)
                                                        <div class="mt-2 sm:mt-0 sm:ml-auto">
                                                            <span
                                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                                {{ $selectedAttendance->checkOutOffice ? $selectedAttendance->checkOutOffice->name : 'Unknown location' }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        <div class="mt-4 text-center">
                                            <button type="button"
                                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                                </svg>
                                                View on Map
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Notes Section with Rich Text Content -->
                            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                                <div class="border-b border-gray-200 px-5 py-4 flex justify-between items-center">
                                    <h5 class="font-medium text-gray-900">
                                        {{ $selectedAttendance->early_leave_reason ? 'Early Leave Reason & Notes' : 'Notes' }}
                                    </h5>

                                    @if (!$selectedAttendance->notes)
                                        <button type="button"
                                            wire:click="openAddNoteModal({{ $selectedAttendance->id }})"
                                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                            Add Note
                                        </button>
                                    @else
                                        <button type="button"
                                            wire:click="openAddNoteModal({{ $selectedAttendance->id }})"
                                            class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                            Edit
                                        </button>
                                    @endif
                                </div>

                                <div class="p-5">
                                    @if ($selectedAttendance->early_leave_reason)
                                        <div class="mb-5 rounded-lg bg-amber-50 border border-amber-200 p-4">
                                            <h6 class="text-sm font-medium text-amber-800 mb-2 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Early Leave Reason
                                            </h6>
                                            <div class="text-sm text-amber-700 prose max-w-none">
                                                {!! nl2br(e($selectedAttendance->early_leave_reason)) !!}
                                            </div>
                                        </div>
                                    @endif

                                    @if ($selectedAttendance->notes)
                                        <div class="prose max-w-none">
                                            {!! $selectedAttendance->notes !!}
                                        </div>
                                    @else
                                        <div class="text-center py-8">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-12 w-12 mx-auto text-gray-300" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <p class="mt-2 text-sm text-gray-500">No notes have been added yet</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        @if ($selectedAttendance->status === 'pending present')
                            <button type="button" wire:click="approveAttendance({{ $selectedAttendance->id }})"
                                class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Approve Attendance
                            </button>
                        @elseif (!$selectedAttendance->notes)
                            <button type="button" wire:click="openAddNoteModal({{ $selectedAttendance->id }})"
                                class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                Add Note
                            </button>
                        @endif
                        <button type="button" @click="$dispatch('close-modal', 'attendance-details')"
                            class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-12">
                <div class="w-20 h-20 relative">
                    <div
                        class="absolute top-0 left-0 w-20 h-20 border-4 border-primary-200 border-t-primary-600 rounded-full animate-spin">
                    </div>
                </div>
                <p class="mt-4 text-base text-gray-600">Loading attendance details...</p>
            </div>
        @endif
    </x-modals.modal>
</div>
