<div class="py-12">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Attendance Status Card -->
            <x-shared.card class="bg-gradient-to-br from-slate-50 via-white to-slate-50">
                <div class="flex flex-col h-full">
                    <div class="flex items-center justify-between mb-6">
                        @if ($todayAttendance?->check_in && !$todayAttendance->check_out)
                            <div
                                class="flex items-center gap-2 px-4 py-1.5 bg-emerald-50 rounded-full border border-emerald-100">
                                <div class="h-2 w-2 bg-emerald-500 rounded-full animate-pulse"></div>
                                <span class="text-sm font-medium text-emerald-700">Currently Working</span>
                            </div>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <!-- Check In Status -->
                        <div
                            class="relative flex flex-col items-center p-6 rounded-2xl bg-gradient-to-b from-gray-50 to-white border border-gray-100">
                            <div
                                class="absolute -top-3 left-1/2 transform -translate-x-1/2 px-4 py-1 bg-white border border-gray-100 rounded-full">
                                <span class="text-xs font-medium text-gray-500">Check In</span>
                            </div>
                            <div class="w-full text-center">
                                <div class="mb-2">
                                    <span
                                        class="font-mono text-4xl font-bold {{ $todayAttendance?->check_in ? 'text-blue-600' : 'text-gray-300' }}">
                                        {{ $formattedCheckIn }}
                                    </span>
                                </div>
                                @if ($todayAttendance?->check_in)
                                    <span class="inline-flex items-center gap-1 text-sm font-medium text-blue-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Checked In
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Check Out Status -->
                        <div
                            class="relative flex flex-col items-center p-6 rounded-2xl bg-gradient-to-b from-gray-50 to-white border border-gray-100">
                            <div
                                class="absolute -top-3 left-1/2 transform -translate-x-1/2 px-4 py-1 bg-white border border-gray-100 rounded-full">
                                <span class="text-xs font-medium text-gray-500">Check Out</span>
                            </div>
                            <div class="w-full text-center">
                                <div class="mb-2">
                                    <span
                                        class="font-mono text-4xl font-bold {{ $todayAttendance?->check_out ? 'text-blue-600' : 'text-gray-300' }}">
                                        {{ $formattedCheckOut }}
                                    </span>
                                </div>
                                @if ($todayAttendance?->check_out)
                                    <span class="inline-flex items-center gap-1 text-sm font-medium text-blue-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Checked Out
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </x-shared.card>

            <!-- Work Duration Card -->
            <x-shared.card class="bg-gradient-to-br from-blue-50 to-indigo-50">
                <div class="flex flex-col h-full justify-center space-y-8">
                    <div class="flex items-center justify-center gap-3">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="w-5 h-5 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 6v6l4 2" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Work Duration</h3>
                            <p class="text-sm text-gray-600">{{ $scheduleRange }}</p>
                        </div>
                    </div>

                    <div class="text-center space-y-2">
                        <div class="font-mono text-4xl font-bold text-blue-700 tracking-wider"
                            wire:poll.1s="calculateWorkingDuration">
                            {{ str_replace([':', ' '], ['h', 'm'], $workingDuration) . 's' }}
                        </div>
                        @if ($todayAttendance?->check_in && !$todayAttendance->check_out)
                            <div class="flex items-center justify-center gap-2">
                                <span class="inline-block h-2 w-2 bg-blue-500 rounded-full animate-pulse"></span>
                                <span class="text-sm font-medium text-blue-700">In Progress</span>
                            </div>
                        @endif
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="font-medium text-gray-700">Daily Progress</span>
                            <span class="font-medium text-blue-700">{{ $progressPercentage }}%</span>
                        </div>
                        <div class="h-2 bg-blue-100 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-500 rounded-full transition-all duration-300"
                                style="width: {{ $progressPercentage }}%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500">
                            <span>{{ $scheduleStart }}</span>
                            <span>{{ $scheduleEnd }}</span>
                        </div>
                    </div>
                </div>
            </x-shared.card>
        </div>
    </div>
</div>
