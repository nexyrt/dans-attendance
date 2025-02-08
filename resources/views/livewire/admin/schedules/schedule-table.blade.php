<div class="min-h-screen">

    <!-- Header Section with Stats -->
    <div class="mb-6">
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Schedule Management</h2>
                    <p class="text-gray-600 mt-1">Manage your weekly schedule and tolerance settings</p>
                </div>
                <div class="hidden sm:block">
                    <span class="relative inline-flex">
                        <button type="button"
                            class="inline-flex items-center px-4 py-2 rounded-md bg-blue-50 text-blue-600 text-sm font-medium hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="bx bx-download mr-2"></i> Export Schedule
                        </button>
                    </span>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Average Start Time Card -->
            <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 rounded-lg bg-blue-50">
                        <i class="bx bx-time text-2xl text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Average Start Time</p>
                        <h3 class="text-lg font-semibold text-gray-900">08:00 AM</h3>
                    </div>
                </div>
            </div>

            <!-- Average End Time Card -->
            <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 rounded-lg bg-purple-50">
                        <i class="bx bx-time-five text-2xl text-purple-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Average End Time</p>
                        <h3 class="text-lg font-semibold text-gray-900">05:00 PM</h3>
                    </div>
                </div>
            </div>

            <!-- Average Work Hours Card -->
            <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 rounded-lg bg-green-50">
                        <i class="bx bx-timer text-2xl text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Daily Work Hours</p>
                        <h3 class="text-lg font-semibold text-gray-900">9 hours</h3>
                    </div>
                </div>
            </div>

            <!-- Tolerance Info Card -->
            <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 rounded-lg bg-yellow-50">
                        <i class="bx bx-shield-quarter text-2xl text-yellow-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Avg. Tolerance</p>
                        <h3 class="text-lg font-semibold text-gray-900">15 minutes</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Table Section -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Weekly Schedule</h3>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="Search schedule..."
                            class="w-64 pr-10 pl-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <i class="bx bx-search text-gray-400"></i>
                        </div>
                    </div>
                    <div>
                        <select
                            class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg">
                            <option>All Days</option>
                            <option>Weekdays</option>
                            <option>Weekend</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-50">
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Day of Week
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Start Time
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            End Time
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Duration
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Late Tolerance
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($schedules as $schedule)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div
                                    class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-lg {{ $this->getDayColor($schedule->day_of_week) }}">
                                    <i class="bx bx-calendar text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ ucfirst($schedule->day_of_week) }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        Working Day
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <i class="bx bx-time-five text-gray-500 mr-2"></i>
                                <div>
                                    <div class="text-sm text-gray-900">{{ $schedule->start_time->format('H:i') }}
                                    </div>
                                    <div class="text-xs text-gray-500">Check-in Time</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <i class="bx bx-time text-gray-500 mr-2"></i>
                                <div>
                                    <div class="text-sm text-gray-900">{{ $schedule->end_time->format('H:i') }}
                                    </div>
                                    <div class="text-xs text-gray-500">Check-out Time</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">9 hours</div>
                            <div class="text-xs text-gray-500">Standard Shift</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <span
                                    class="px-3 py-1 inline-flex text-sm leading-5 font-medium rounded-full bg-green-100 text-green-800">
                                    {{ $schedule->late_tolerance }} minutes
                                </span>
                                <i class="bx bx-info-circle ml-2 text-gray-400 cursor-help" x-data="{}"
                                    x-tooltip="Grace period for late arrival"></i>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                Active
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center space-x-3">
                                <button wire:click="edit({{ $schedule->id }})"
                                    class="text-blue-600 hover:text-blue-800 font-medium focus:outline-none focus:underline">
                                    <i class="bx bx-edit-alt mr-1"></i> Edit
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Table Footer with Pagination -->
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            <div class="flex items-center justify-between">
                <div class="flex-1 flex justify-between sm:hidden">
                    <a href="#"
                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Previous
                    </a>
                    <a href="#"
                        class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Next
                    </a>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing <span class="font-medium">1</span> to <span class="font-medium">5</span> of
                            <span class="font-medium">5</span> schedules
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <a href="#"
                                class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Previous</span>
                                <i class="bx bx-chevron-left"></i>
                            </a>
                            <a href="#"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                1
                            </a>
                            <a href="#"
                                class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Next</span>
                                <i class="bx bx-chevron-right"></i>
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Modal -->
        <div x-show="$wire.showModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"
                    x-show="$wire.showModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"></div>

                <!-- Modal panel -->
                <div
                    class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-xl shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <!-- Modal Header -->
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <div class="p-2 bg-blue-100 rounded-lg">
                                    <i class="bx bx-calendar text-xl text-blue-600"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">
                                    Edit Schedule
                                </h3>
                            </div>
                            <button wire:click="toggleModal"
                                class="text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500 transition-colors">
                                <i class="bx bx-x text-2xl"></i>
                            </button>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            Modify the schedule details below. All times are in 24-hour format.
                        </p>
                    </div>

                    <!-- Modal Body -->
                    <div class="px-6 py-4">
                        <div class="space-y-6">
                            <!-- Day of Week (Read-only) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Day of Week</label>
                                <div class="mt-1 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-8 w-8 flex items-center justify-center rounded-lg {{ $this->getDayColor($schedule->day_of_week ?? 'monday') }}">
                                            <i class="bx bx-calendar text-lg"></i>
                                        </div>
                                        <span class="ml-3 text-sm text-gray-700">
                                            {{ ucfirst($schedule->day_of_week ?? 'Monday') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Time Range Section -->
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Start Time -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        Start Time
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <div class="mt-1 relative">
                                        <input type="time" wire:model="start_time"
                                            class="block w-full pr-10 pl-3 py-2 border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <i class="bx bx-time-five text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('start_time')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- End Time -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        End Time
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <div class="mt-1 relative">
                                        <input type="time" wire:model="end_time"
                                            class="block w-full pr-10 pl-3 py-2 border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <i class="bx bx-time text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('end_time')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Late Tolerance -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Late Tolerance
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1">
                                    <div class="relative">
                                        <input type="number" wire:model="late_tolerance" min="0" max="120"
                                            class="block w-full pr-16 pl-3 py-2 border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            placeholder="Enter tolerance time">
                                        <div class="absolute inset-y-0 right-0 flex items-center">
                                            <label class="sr-only">Tolerance Unit</label>
                                            <span
                                                class="h-full inline-flex items-center px-3 rounded-r-lg border border-l-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                                minutes
                                            </span>
                                        </div>
                                    </div>
                                    @error('late_tolerance')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <p class="mt-1 text-xs text-gray-500">
                                    Allowed range: 0-120 minutes
                                </p>
                            </div>

                            <!-- Information Box -->
                            <div class="rounded-lg bg-blue-50 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-info-circle text-blue-400 text-xl"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-blue-800">Schedule Information</h3>
                                        <div class="mt-2 text-sm text-blue-700">
                                            <ul class="list-disc pl-5 space-y-1">
                                                <li>Start time must be before end time</li>
                                                <li>Late tolerance affects attendance calculations</li>
                                                <li>Changes will be effective immediately</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                        <div
                            class="flex flex-col sm:flex-row-reverse sm:space-x-2 sm:space-x-reverse space-y-2 sm:space-y-0">
                            <button wire:click="save"
                                class="inline-flex justify-center items-center w-full sm:w-auto px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="bx bx-save mr-2"></i>
                                Save Changes
                            </button>
                            <button wire:click="toggleModal"
                                class="inline-flex justify-center items-center w-full sm:w-auto px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="bx bx-x mr-2"></i>
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>