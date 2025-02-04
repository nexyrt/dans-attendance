{{-- resources/views/livewire/staff/attendance.blade.php --}}
<div class="p-4 md:p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Days -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center gap-4">
                    <div class="p-2 bg-gray-50 rounded-lg">
                        <svg class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Days</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalDays }}</p>
                    </div>
                </div>
            </div>

            <!-- Present Days -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center gap-4">
                    <div class="p-2 bg-green-50 rounded-lg">
                        <svg class="w-6 h-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Present Days</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $presentDays }}</p>
                    </div>
                </div>
            </div>

            <!-- Late Days -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center gap-4">
                    <div class="p-2 bg-yellow-50 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Late Days</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $lateDays }}</p>
                    </div>
                </div>
            </div>

            <!-- Working Hours -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center gap-4">
                    <div class="p-2 bg-blue-50 rounded-lg">
                        <svg class="w-6 h-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Hours</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalHours }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters & Table -->
        <div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-100">
            <!-- Filters Section -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex flex-col md:flex-row gap-4">
                    <!-- Date Range Selector -->
                    <div class="w-full md:w-48">
                        <select wire:model.live="dateRange" class="w-full rounded-lg border-gray-200 text-sm">
                            @foreach ($dateRanges as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Custom Date Range (shows only when 'custom' is selected) -->
                    @if ($dateRange === 'custom')
                        <div class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
                            <input type="date" wire:model.live="customStartDate"
                                class="w-full md:w-40 rounded-lg border-gray-200 text-sm" placeholder="Start Date">

                            <span class="hidden md:flex items-center text-gray-500">to</span>

                            <input type="date" wire:model.live="customEndDate"
                                class="w-full md:w-40 rounded-lg border-gray-200 text-sm" placeholder="End Date">
                        </div>
                    @endif

                    <!-- Status Filter -->
                    <div class="w-full md:w-40">
                        <select wire:model.live="filterStatus" class="w-full rounded-lg border-gray-200 text-sm">
                            @foreach ($statuses as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between border-t border-gray-100 px-6 py-4">
                <div class="text-sm text-gray-500">
                    @if ($this->dateRange === 'custom')
                        {{ \Cake\Chronos\Chronos::parse($this->customStartDate)->format('d F Y') }} -
                        {{ \Cake\Chronos\Chronos::parse($this->customEndDate)->format('d F Y') }}
                    @else
                        {{ \Cake\Chronos\Chronos::parse($this->getDateRangeValues()[0])->format('d F Y') }} -
                        {{ \Cake\Chronos\Chronos::parse($this->getDateRangeValues()[1])->format('d F Y') }}
                    @endif
                </div>

                <button wire:click="export"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition-colors duration-200">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export to Excel
                    <div wire:loading wire:target="export" class="animate-spin w-4 h-4">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>
                </button>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Location</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Working Hours</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Notes</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($attendances as $attendance)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-900">
                                            {{ \Cake\Chronos\Chronos::parse($attendance->date)->format('d F Y') }}
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            {{ \Cake\Chronos\Chronos::parse($attendance->date)->format('l') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <div class="w-16 text-xs text-gray-500">Check In</div>
                                            @if ($attendance->check_in)
                                                <span class="text-sm text-gray-900">
                                                    {{ \Cake\Chronos\Chronos::parse($attendance->check_in)->format('H:i') }}
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                    Pending
                                                </span>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <div class="w-16 text-xs text-gray-500">Check Out</div>
                                            @if ($attendance->check_out)
                                                <span class="text-sm text-gray-900">
                                                    {{ \Cake\Chronos\Chronos::parse($attendance->check_out)->format('H:i') }}
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                    Not Yet
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $this->getStatusBadgeColor($attendance->status) }}">
                                        {{ str_replace('_', ' ', \Illuminate\Support\Str::title($attendance->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 text-xs text-gray-500">In</div>
                                            @if ($attendance->checkInOffice)
                                                <div class="flex items-center gap-1.5">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    <span
                                                        class="text-sm text-gray-900">{{ $attendance->checkInOffice->name }}</span>
                                                </div>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                                    No Data
                                                </span>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 text-xs text-gray-500">Out</div>
                                            @if ($attendance->checkOutOffice)
                                                <div class="flex items-center gap-1.5">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    <span
                                                        class="text-sm text-gray-900">{{ $attendance->checkOutOffice->name }}</span>
                                                </div>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                                    No Data
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($attendance->working_hours)
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 {{ $this->getWorkingHoursColor($attendance->working_hours) }}"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span
                                                class="text-sm font-medium {{ $this->getWorkingHoursColor($attendance->working_hours) }}">
                                                {{ number_format($attendance->working_hours, 2) }} hours
                                            </span>
                                        </div>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                            Not Available
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($attendance->notes)
                                        <div class="max-w-xs">
                                            <p class="text-sm text-gray-900 truncate"
                                                title="{{ $attendance->notes }}">
                                                {{ $attendance->notes }}
                                            </p>
                                        </div>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                            No Notes
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 whitespace-nowrap">
                                    <div class="flex flex-col items-center justify-center text-center">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">No Attendance Records</h3>
                                        <p class="mt-1 text-sm text-gray-500">
                                            No attendance records found for the selected period.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $attendances->links() }}
            </div>
        </div>
    </div>
</div>
