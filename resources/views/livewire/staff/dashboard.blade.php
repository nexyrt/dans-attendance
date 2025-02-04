<div class="p-4 md:p-8">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
            <!-- Attendance Card -->
            <x-shared.card class="bg-white h-[300px]">
                <div class="flex flex-col h-full">
                    <!-- Status Badge -->
                    <div class="mb-6 text-center">
                        @if (!$todayAttendance)
                            <div class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-50 rounded-full">
                                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-base font-medium text-gray-600">Waiting for Check-in</span>
                            </div>
                        @elseif($todayAttendance?->check_in && !$todayAttendance->check_out)
                            <div class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-50 rounded-full">
                                <div class="h-2 w-2 bg-emerald-500 rounded-full animate-pulse"></div>
                                <span class="text-base font-medium text-emerald-700">Currently Working</span>
                            </div>
                        @else
                            <div class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-50 rounded-full">
                                <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-base font-medium text-blue-700">Day Completed</span>
                            </div>
                        @endif
                    </div>

                    <!-- Check-in/out Information -->
                    <div class="flex-1 grid grid-cols-2 gap-4">
                        <!-- Check In Details -->
                        <div class="flex flex-col items-center">
                            <span class="text-sm font-medium text-gray-900 mb-2">Check In</span>
                            @if ($todayAttendance?->check_in)
                                <span
                                    class="text-2xl font-bold text-blue-600 mb-2">{{ \Cake\Chronos\Chronos::parse($todayAttendance->check_in)->format('H:i') }}</span>
                                <div class="text-xs text-gray-500">
                                    @if (
                                        \Cake\Chronos\Chronos::parse($todayAttendance->check_in)->timestamp >
                                            \Cake\Chronos\Chronos::parse($scheduleStart)->timestamp)
                                        <span class="text-yellow-600">
                                            {{ \Cake\Chronos\Chronos::parse($todayAttendance->check_in)->diff(\Cake\Chronos\Chronos::parse($scheduleStart))->format('%h hours %i minutes') }}
                                            late
                                        </span>
                                    @else
                                        <span class="text-green-600">On Time</span>
                                    @endif
                                </div>
                            @else
                                <div class="h-14 flex items-center justify-center">
                                    <span class="text-lg text-gray-400">--:--</span>
                                </div>
                            @endif
                        </div>

                        <!-- Check Out Details -->
                        <div class="flex flex-col items-center">
                            <span class="text-sm font-medium text-gray-900 mb-2">Check Out</span>
                            @if ($todayAttendance?->check_out)
                                <span
                                    class="text-2xl font-bold text-blue-600 mb-2">{{ \Cake\Chronos\Chronos::parse($todayAttendance->check_out)->format('H:i') }}</span>
                                <div class="text-xs text-gray-500">
                                    @if ($todayAttendance->status === 'early_leave')
                                        <span class="text-blue-600">
                                            Left
                                            {{ \Cake\Chronos\Chronos::parse($todayAttendance->check_out)->diff(\Cake\Chronos\Chronos::parse($scheduleEnd))->format('%h hours %i minutes') }}
                                            early
                                        </span>
                                    @else
                                        <span class="text-gray-600">Complete Day</span>
                                    @endif
                                </div>
                            @else
                                <div class="h-14 flex items-center justify-center">
                                    <span class="text-lg text-gray-400">--:--</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="mt-auto pt-4 border-t border-gray-100">
                        <div class="grid grid-cols-2 gap-2">
                            <div class="flex flex-col items-center p-2 rounded-lg bg-gray-50">
                                <span class="text-sm font-medium text-gray-900">Location</span>
                                <span
                                    class="text-xs text-gray-600">{{ $todayAttendance?->checkInOffice->name ?? 'Not checked in' }}</span>
                            </div>
                            <div class="flex flex-col items-center p-2 rounded-lg bg-gray-50">
                                <span class="text-sm font-medium text-gray-900">Device</span>
                                <span
                                    class="text-xs text-gray-600">{{ $todayAttendance?->device_type ?? 'Not checked in' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </x-shared.card>

            <!-- Work Duration Card -->
            <x-shared.card class="bg-blue-50 h-[300px]">
                <div class="flex flex-col h-full">
                    <!-- Header -->
                    <div class="flex justify-between items-start mb-8">
                        <div class="flex items-center gap-2">
                            <div class="text-blue-600">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M12 6v6l4 2" />
                                </svg>
                            </div>
                            <span class="text-lg">Work Duration</span>
                        </div>
                        <span class="text-sm text-gray-600">{{ $scheduleRange }}</span>
                    </div>

                    <!-- Duration Display -->
                    <div class="text-center mb-8">
                        <div class="text-4xl md:text-5xl font-mono font-bold text-blue-600"
                            wire:poll.1s="calculateWorkingDuration">
                            {{ $workingDuration }}
                        </div>
                        @if ($todayAttendance?->check_in && !$todayAttendance->check_out)
                            <div class="flex items-center justify-center gap-2 mt-2">
                                <span class="h-2 w-2 bg-blue-500 rounded-full animate-pulse"></span>
                                <span class="text-sm text-blue-600">In Progress</span>
                            </div>
                        @endif
                    </div>

                    <!-- Progress Bar - Always at bottom -->
                    <div class="mt-auto">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">Daily Progress</span>
                            <span class="text-blue-600">{{ $progressPercentage }}%</span>
                        </div>
                        <div class="h-2 bg-blue-100 rounded-full overflow-hidden mb-2">
                            <div class="h-full bg-blue-600 rounded-full transition-all duration-300"
                                style="width: {{ $progressPercentage }}%">
                            </div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500">
                            <span>{{ $scheduleStart }}</span>
                            <span>{{ $scheduleEnd }}</span>
                        </div>
                    </div>
                </div>
            </x-shared.card>

            {{-- Calendar Component --}}
            <div class="py-6 lg:col-span-2">
                <livewire:calendar-component />
            </div>
        </div>
    </div>
</div>
