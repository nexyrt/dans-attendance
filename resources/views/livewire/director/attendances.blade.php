<!-- resources/views/livewire/director/attendances.blade.php -->
<div class="max-w-6xl mx-auto py-6">
    <!-- Page Header -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
        <div class="flex-1 min-w-0">


        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
            <button wire:click="export" type="button"
                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium 
                    text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export
            </button>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="mb-6 bg-white rounded-lg shadow-sm p-4 border border-gray-200">
        <div class="grid grid-cols-1 gap-y-4 sm:grid-cols-2 sm:gap-x-6 md:grid-cols-3 lg:grid-cols-4 xl:gap-x-8">
            {{-- <div>
                    <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
                    <div class="mt-1">
                        <x-input.select wire:model.live="selectedDepartment" id="department" name="department"
                            placeholder="All Departments" :options="$departments"/>
                    </div>
                </div> --}}

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <div class="mt-1">
                    <x-input.select wire:model.live="selectedStatus" id="status" name="status"
                        placeholder="All Statuses" :options="$statuses" />
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Date Range</label>
                <div class="mt-1">
                    <livewire:date-range-picker :start-date="$startDate" :end-date="$endDate" />
                </div>
            </div>

            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                <div class="mt-1">
                    <x-input.search id="search" wire:model.live.debounce.300ms="searchTerm"
                        placeholder="Search employees..." />
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance List -->
    <div class="bg-white shadow-sm overflow-hidden sm:rounded-lg border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Employee
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date & Status
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Check In/Out
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Working Hours
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($attendances as $attendance)
                        <tr class="hover:bg-gray-50">
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
                                <div class="text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}</div>
                                <div>
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
                                                            : ($attendance->status === 'pending present'
                                                                ? 'bg-indigo-100 text-indigo-800'
                                                                : 'bg-gray-100 text-gray-800')))) }}">
                                        {{ ucfirst(str_replace('_', ' ', $attendance->status)) }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                        </svg>
                                        {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : 'N/A' }}
                                    </div>
                                    <div class="flex items-center mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') : 'N/A' }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $attendance->working_hours ?? 'N/A' }}
                                    @if ($attendance->late_hours)
                                        <span class="text-red-600 ml-1">({{ $attendance->late_hours }} late)</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="viewAttendanceDetails({{ $attendance->id }})"
                                    class="text-primary-600 hover:text-primary-900 mr-3">
                                    View
                                </button>
                                @if ($attendance->status === 'pending present')
                                    <button wire:click="approveAttendance({{ $attendance->id }})"
                                        class="text-green-600 hover:text-green-900">
                                        Approve
                                    </button>
                                @else
                                    <button wire:click="openAddNoteModal({{ $attendance->id }})"
                                        class="text-gray-600 hover:text-gray-900">
                                        {{ $attendance->notes ? 'Edit Note' : 'Add Note' }}
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No attendance records found
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Try adjusting your filters or search term
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $attendances->links() }}
        </div>
    </div>

    <!-- Attendance Details Modal -->
    <x-modals.modal name="attendance-details" maxWidth="2xl">
        @if ($selectedAttendance)
            <div class="p-6">
                <div class="flex justify-between">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Attendance Details
                    </h3>
                    <button @click="$dispatch('close-modal', 'attendance-details')" type="button"
                        class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="mt-4">
                    <div class="flex items-center mb-6">
                        @if ($selectedAttendance->user && $selectedAttendance->user->image)
                            <img class="h-12 w-12 rounded-full object-cover"
                                src="{{ asset($selectedAttendance->user->image) }}"
                                alt="{{ $selectedAttendance->user->name }}">
                        @else
                            <div class="h-12 w-12 rounded-full bg-primary-100 flex items-center justify-center">
                                <span class="text-lg font-medium text-primary-600">
                                    {{ $selectedAttendance->user ? substr($selectedAttendance->user->name, 0, 2) : 'NA' }}
                                </span>
                            </div>
                        @endif
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">
                                {{ $selectedAttendance->user ? $selectedAttendance->user->name : 'Unknown User' }}
                            </h4>
                            <p class="text-sm text-gray-500">
                                {{ $selectedAttendance->user && $selectedAttendance->user->department ? $selectedAttendance->user->department->name : 'No Department' }}
                            </p>
                        </div>
                        <div class="ml-auto">
                            <span
                                class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full 
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

                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($selectedAttendance->date)->format('F d, Y') }}</dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Device Type</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $selectedAttendance->device_type ?? 'Unknown' }}</dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Check In</dt>
                                <dd class="mt-1 text-sm text-gray-900 flex items-center">
                                    {{ $selectedAttendance->check_in ? \Carbon\Carbon::parse($selectedAttendance->check_in)->format('h:i A') : 'Not checked in' }}
                                    @if ($selectedAttendance->check_in_office_id)
                                        <span
                                            class="ml-2 px-2 inline-flex text-xs leading-5 font-medium rounded-full bg-gray-100 text-gray-800">
                                            {{ $selectedAttendance->checkInOffice ? $selectedAttendance->checkInOffice->name : 'Unknown location' }}
                                        </span>
                                    @endif
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Check Out</dt>
                                <dd class="mt-1 text-sm text-gray-900 flex items-center">
                                    {{ $selectedAttendance->check_out ? \Carbon\Carbon::parse($selectedAttendance->check_out)->format('h:i A') : 'Not checked out' }}
                                    @if ($selectedAttendance->check_out_office_id)
                                        <span
                                            class="ml-2 px-2 inline-flex text-xs leading-5 font-medium rounded-full bg-gray-100 text-gray-800">
                                            {{ $selectedAttendance->checkOutOffice ? $selectedAttendance->checkOutOffice->name : 'Unknown location' }}
                                        </span>
                                    @endif
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Working Hours</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $selectedAttendance->working_hours ?? 'N/A' }} hours
                                    @if ($selectedAttendance->late_hours)
                                        <span class="text-red-600 ml-1">({{ $selectedAttendance->late_hours }}
                                            hours late)</span>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>

                    @if ($selectedAttendance->notes || $selectedAttendance->early_leave_reason)
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">
                                {{ $selectedAttendance->early_leave_reason ? 'Early Leave Reason' : 'Notes' }}
                            </h4>
                            <div class="bg-gray-50 rounded-lg p-4 text-sm text-gray-700">
                                {{ $selectedAttendance->early_leave_reason ?? $selectedAttendance->notes }}
                            </div>
                        </div>
                    @endif

                    @if ($selectedAttendance->check_in_latitude && $selectedAttendance->check_in_longitude)
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Check-in Location</h4>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="text-sm text-gray-700">
                                        Latitude: {{ $selectedAttendance->check_in_latitude }}, Longitude:
                                        {{ $selectedAttendance->check_in_longitude }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="mt-6 sm:flex sm:justify-end">
                        @if ($selectedAttendance->status === 'pending present')
                            <button type="button" wire:click="approveAttendance({{ $selectedAttendance->id }})"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Approve
                            </button>
                        @elseif (!$selectedAttendance->notes)
                            <button type="button" wire:click="openAddNoteModal({{ $selectedAttendance->id }})"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Add Note
                            </button>
                        @endif
                        <button type="button" @click="$dispatch('close-modal', 'attendance-details')"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-6">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary-500 mx-auto"></div>
                <p class="mt-2 text-sm text-gray-500">Loading attendance details...</p>
            </div>
        @endif
    </x-modals.modal>

    <!-- Add Note Modal -->
    <x-modals.modal name="add-note-modal" maxWidth="lg">
        <div class="p-6">
            <div class="flex justify-between">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Add Note to Attendance Record
                </h3>
                <button @click="$dispatch('close-modal', 'add-note-modal')" type="button"
                    class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="mt-4">
                <div>
                    <label for="attendance-note" class="block text-sm font-medium text-gray-700">
                        Note
                    </label>
                    <div class="mt-1">
                        <textarea id="attendance-note" wire:model="attendanceNote" rows="4"
                            class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md"
                            placeholder="Enter note about this attendance record..."></textarea>
                        @error('attendanceNote')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 sm:flex sm:justify-end">
                    <button type="button" wire:click="addNote"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Save Note
                    </button>
                    <button type="button" @click="$dispatch('close-modal', 'add-note-modal')"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </x-modals.modal>

    <!-- Notification System -->
    <div id="notification-container" x-data="{ show: false, message: '', type: 'success' }" x-show="show"
        x-on:notify.window="
            show = true;
            message = $event.detail.message;
            type = $event.detail.type;
            setTimeout(() => { show = false }, 3000);
        "
        x-transition:enter="transform ease-out duration-300 transition"
        x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 flex items-end justify-center px-4 py-6 pointer-events-none sm:p-6 sm:items-start sm:justify-end z-50"
        style="display: none;">
        <div
            class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <template x-if="type === 'success'">
                            <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </template>
                        <template x-if="type === 'error'">
                            <svg class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </template>
                        <template x-if="type === 'info'">
                            <svg class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </template>
                    </div>
                    <div class="ml-3 w-0 flex-1 pt-0.5">
                        <p class="text-sm font-medium text-gray-900" x-text="message"></p>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button @click="show = false"
                            class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <span class="sr-only">Close</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
