<div class="p-4 md:p-8">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
            <!-- Attendance Card -->
            <x-shared.card class="bg-white relative">
                <div class="flex flex-col items-center">
                    <!-- Status Badge -->
                    @if($todayAttendance?->check_in && !$todayAttendance->check_out)
                        <div class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-50 rounded-full">
                            <div class="h-2 w-2 bg-emerald-500 rounded-full animate-pulse"></div>
                            <span class="text-base font-medium text-emerald-700">Currently Working</span>
                        </div>
                    @endif

                    <!-- Time Display Grid -->
                    <div class="w-full mt-5 grid grid-cols-2">
                        <!-- Check In -->
                        <div class="flex flex-col items-center">
                            <span class="text-gray-500 text-lg mb-6">Check In</span>
                            <div class="text-4xl font-bold text-blue-600 tracking-wider mb-4">
                                {{ $formattedCheckIn }}
                            </div>
                            @if($todayAttendance?->check_in)
                                <div class="flex items-center gap-2 text-blue-600">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span class="text-base">Checked In</span>
                                </div>
                            @endif
                        </div>

                        <!-- Check Out -->
                        <div class="flex flex-col items-center">
                            <span class="text-gray-500 text-lg mb-6">Check Out</span>
                            <div class="text-4xl font-bold tracking-wider mb-4 {{ $todayAttendance?->check_out ? 'text-blue-600' : 'text-gray-200' }}">
                                {{ $formattedCheckOut }}
                            </div>
                            @if($todayAttendance?->check_out)
                                <div class="flex items-center gap-2 text-blue-600">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span class="text-base">Checked Out</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Additional Info -->
                    @if($todayAttendance?->check_in)
                        <div class="w-full mt-8 pt-6 border-t border-gray-100">
                            <div class="flex justify-center items-center gap-8 text-sm text-gray-500">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    <span>From Device: Mobile</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>Office Location</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </x-shared.card>

            <!-- Work Duration Card -->
            <x-shared.card class="bg-blue-50 min-h-[200px]">
                <div class="flex justify-between items-start mb-12">
                    <div class="flex items-center gap-2">
                        <div class="text-blue-600">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M12 6v6l4 2"/>
                            </svg>
                        </div>
                        <span class="text-lg">Work Duration</span>
                    </div>
                    <span class="text-sm text-gray-600">{{ $scheduleRange }}</span>
                </div>

                <div class="text-center mb-12">
                    <div class="text-4xl md:text-5xl font-mono font-bold text-blue-600" wire:poll.1s="calculateWorkingDuration">
                        {{ $workingDuration }}
                    </div>
                    @if($todayAttendance?->check_in && !$todayAttendance->check_out)
                        <div class="flex items-center justify-center gap-2 mt-2">
                            <span class="h-2 w-2 bg-blue-500 rounded-full animate-pulse"></span>
                            <span class="text-sm text-blue-600">In Progress</span>
                        </div>
                    @endif
                </div>

                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-700">Daily Progress</span>
                        <span class="text-blue-600">{{ $progressPercentage }}%</span>
                    </div>
                    <div class="h-2 bg-blue-100 rounded-full overflow-hidden mb-2">
                        <div class="h-full bg-blue-600 rounded-full transition-all duration-300" 
                             style="width: {{ $progressPercentage }}%"></div>
                    </div>
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>{{ $scheduleStart }}</span>
                        <span>{{ $scheduleEnd }}</span>
                    </div>
                </div>
            </x-shared.card>

            {{-- This is the Calendar Component --}}
            <div class="py-6">
                <div class="mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-900">Schedule Calendar</h2>
                        <p class="mt-1 text-sm text-gray-600">View your work schedule, holidays, and leave requests in one place.</p>
                    </div>
                    
                    <livewire:calendar-component />
                </div>
            </div>
        </div>
    </div>
</div>