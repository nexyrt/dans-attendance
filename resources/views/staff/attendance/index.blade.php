<x-layouts.staff>
    {{-- Main Grid Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 overflow-y-auto">
        {{-- Left Column: Status Cards --}}
        <div class="lg:col-span-2">
            {{-- Current Status Card --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                {{-- Card Header --}}
                <div class="bg-[#1D4ED8] p-6">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-white/10 backdrop-blur-sm rounded-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <h2 class="text-lg font-semibold text-white">Current Status</h2>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="text-sm text-white/90">{{ now()->format('l') }}</span>
                            <span class="text-2xl font-bold text-white">{{ now()->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Card Content --}}
                <div class="p-6 bg-gray-50">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Check In Status --}}
                        <div class="relative">
                            <div class="absolute -top-10 left-4">
                                <div class="p-3 bg-white shadow-lg rounded-xl">
                                    <svg class="w-6 h-6 {{ $todayAttendance?->status === 'late' ? 'text-red-500' : 'text-green-500' }}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                </div>
                            </div>
                            <div class="bg-white rounded-xl p-6 pt-12 shadow-sm">
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-medium text-gray-500">Check In</span>
                                        @if ($todayAttendance?->check_in)
                                            <span
                                                class="px-2 py-1 text-xs rounded-full {{ $todayAttendance->status === 'late' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                                {{ $todayAttendance->status === 'late' ? 'Late' : 'On Time' }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex items-baseline space-x-2">
                                        <span
                                            class="text-4xl font-bold {{ $todayAttendance?->status === 'late' ? 'text-red-600' : 'text-gray-900' }}">
                                            {{ $todayAttendance?->check_in ? $todayAttendance->check_in->format('H:i') : '--:--' }}
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            {{ $todayAttendance?->check_in ? $todayAttendance->check_in->format('A') : '' }}
                                        </span>
                                    </div>
                                    @if ($todayAttendance?->check_in)
                                        <p class="text-sm text-gray-500">
                                            Checked in {{ $todayAttendance->check_in->diffForHumans() }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Check Out Status --}}
                        <div class="relative">
                            <div class="absolute -top-10 left-4">
                                <div class="p-3 bg-white shadow-lg rounded-xl">
                                    <svg class="w-6 h-6 {{ $todayAttendance?->status === 'early_leave' ? 'text-orange-500' : 'text-blue-500' }}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                </div>
                            </div>
                            <div class="bg-white rounded-xl p-6 pt-12 shadow-sm">
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-medium text-gray-500">Check Out</span>
                                        @if ($todayAttendance?->check_out)
                                            <span
                                                class="px-2 py-1 text-xs rounded-full {{ $todayAttendance->status === 'early_leave' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700' }}">
                                                {{ $todayAttendance->status === 'early_leave' ? 'Early Leave' : 'Regular' }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex items-baseline space-x-2">
                                        <span
                                            class="text-4xl font-bold {{ $todayAttendance?->status === 'early_leave' ? 'text-orange-600' : 'text-gray-900' }}">
                                            {{ $todayAttendance?->check_out ? $todayAttendance->check_out->format('H:i') : '--:--' }}
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            {{ $todayAttendance?->check_out ? $todayAttendance->check_out->format('A') : '' }}
                                        </span>
                                    </div>
                                    @if ($todayAttendance?->check_out)
                                        <p class="text-sm text-gray-500">
                                            Checked out {{ $todayAttendance->check_out->diffForHumans() }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Work Duration Card --}}
        <div class="bg-blue-50 rounded-2xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-100 rounded-full p-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-blue-900">Work Duration</h3>
                        <p class="text-xs text-blue-600">Total working time today</p>
                    </div>
                </div>
                <span class="text-sm text-blue-600">
                    {{ $todayAttendance?->check_in?->format('H:i') ?? '--:--' }} -
                    {{ $todayAttendance?->check_out?->format('H:i') ?? 'Now' }}
                </span>
            </div>

            {{-- Duration Counter with Seconds --}}
            <div class="text-center mb-8" x-data="{
                checkInTime: '{{ $todayAttendance?->check_in }}',
                checkOutTime: '{{ $todayAttendance?->check_out }}',
                hours: 0,
                minutes: 0,
                seconds: 0,
                timer: null,
            
                startTimer() {
                    if (!this.checkInTime || this.checkOutTime) return;
            
                    this.updateTime();
                    this.timer = setInterval(() => {
                        this.updateTime();
                    }, 1000);
                },
            
                updateTime() {
                    const start = new Date(this.checkInTime);
                    const now = new Date();
                    const diff = Math.floor((now - start) / 1000);
            
                    this.hours = Math.floor(diff / 3600);
                    this.minutes = Math.floor((diff % 3600) / 60);
                    this.seconds = diff % 60;
                },
            
                formatNumber(num) {
                    return num.toString().padStart(2, '0');
                }
            }" x-init="startTimer()">
                <div class="flex items-center justify-center space-x-1">
                    <span class="text-6xl font-mono font-bold text-blue-600" x-text="formatNumber(hours)"></span>
                    <span class="text-6xl font-mono font-bold text-blue-600">h</span>
                    <span class="text-6xl font-mono font-bold text-blue-600" x-text="formatNumber(minutes)"></span>
                    <span class="text-6xl font-mono font-bold text-blue-600">m</span>
                    <span class="text-6xl font-mono font-bold text-blue-600" x-text="formatNumber(seconds)"></span>
                    <span class="text-6xl font-mono font-bold text-blue-600">s</span>
                </div>
                @if (!$todayAttendance?->check_out)
                    <div class="mt-2">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <span class="animate-pulse mr-1.5 h-2 w-2 rounded-full bg-blue-500"></span>
                            In Progress
                        </span>
                    </div>
                @endif
            </div>

            {{-- Progress Bar --}}
            <div class="space-y-3">
                <div class="flex justify-between items-center text-sm">
                    <span class="text-blue-900">Daily Progress</span>
                    <span class="font-medium text-blue-600">{{ $currentProgress }}%</span>
                </div>
                <div class="h-2 bg-blue-100 rounded-full overflow-hidden">
                    <div class="h-full bg-blue-500 rounded-full transition-all duration-500"
                        style="width: {{ $currentProgress }}%">
                    </div>
                </div>
                <div class="flex justify-between text-xs text-blue-600">
                    <span>{{ $scheduleStart->format('H:i') }}</span>
                    <span>{{ $scheduleEnd->format('H:i') }} ({{ $regularWorkHours }}h)</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Schedule Information Section --}}
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Working Hours Card --}}
        <div class="bg-blue-600 rounded-2xl shadow-sm overflow-hidden hover:shadow-lg transition-all duration-300">
            <div class="p-5">
                <div class="flex items-center space-x-4">
                    <div class="bg-white/10 backdrop-blur-sm p-3 rounded-xl">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white">Working Hours</h3>
                        <p class="text-sm text-blue-100">Regular shift</p>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-between">
                    <div class="bg-white/10 backdrop-blur-sm p-4 rounded-2xl flex-1">
                        <span class="block text-sm text-blue-100 mb-1">Start Time</span>
                        <div class="flex items-baseline">
                            <span class="text-2xl font-bold text-white">{{ $scheduleStart->format('H:i') }}</span>
                            <span class="ml-1 text-xs text-blue-200">{{ $scheduleStart->format('A') }}</span>
                        </div>
                    </div>
                    <div class="px-4">
                        <div class="w-8 h-[2px] bg-white/30"></div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm p-4 rounded-2xl flex-1">
                        <span class="block text-sm text-blue-100 mb-1">End Time</span>
                        <div class="flex items-baseline">
                            <span class="text-2xl font-bold text-white">{{ $scheduleEnd->format('H:i') }}</span>
                            <span class="ml-1 text-xs text-blue-200">{{ $scheduleEnd->format('A') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Break Time Card --}}
        <div class="bg-[#6366F1] rounded-2xl shadow-sm overflow-hidden hover:shadow-lg transition-all duration-300">
            <!-- Changed to a violet/indigo color -->
            <div class="p-5">
                <div class="flex items-center space-x-4">
                    <div class="bg-white p-3 rounded-xl">
                        <svg class="w-7 h-7 text-[#6366F1]" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white">Break Time</h3>
                        <p class="text-sm text-white/80">Lunch break period</p>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-between">
                    <div class="bg-white p-4 rounded-2xl flex-1">
                        <span class="block text-sm text-[#6366F1] font-medium mb-1">Start Time</span>
                        <div class="flex items-baseline">
                            <span class="text-2xl font-bold text-[#6366F1]">{{ $breakStart->format('H:i') }}</span>
                            <span
                                class="ml-1 text-xs font-medium text-[#6366F1]/70">{{ $breakStart->format('A') }}</span>
                        </div>
                    </div>
                    <div class="px-4">
                        <div class="w-8 h-[2px] bg-white/30"></div>
                    </div>
                    <div class="bg-white p-4 rounded-2xl flex-1">
                        <span class="block text-sm text-[#6366F1] font-medium mb-1">End Time</span>
                        <div class="flex items-baseline">
                            <span class="text-2xl font-bold text-[#6366F1]">{{ $breakEnd->format('H:i') }}</span>
                            <span
                                class="ml-1 text-xs font-medium text-[#6366F1]/70">{{ $breakEnd->format('A') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Late Tolerance Card --}}
        <div class="bg-[#2563EB] rounded-2xl shadow-sm overflow-hidden hover:shadow-lg transition-all duration-300">
            <!-- Changed to a different shade of blue -->
            <div class="p-5">
                <div class="flex items-center space-x-4">
                    <div class="bg-white p-3 rounded-xl">
                        <svg class="w-7 h-7 text-[#2563EB]" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white">Late Tolerance</h3>
                        <p class="text-sm text-white/80">Grace period</p>
                    </div>
                </div>
                <div class="mt-6">
                    <div class="bg-white p-6 rounded-2xl text-center">
                        <div class="flex items-baseline justify-center">
                            <span
                                class="text-4xl font-bold text-[#2563EB]">{{ $schedule?->late_tolerance ?? 30 }}</span>
                            <span class="text-lg text-[#2563EB]/80 ml-2">minutes</span>
                        </div>
                        <p class="mt-2 text-sm text-[#2563EB]/70">Maximum allowed delay time</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Attendance History Section --}}
    <div class="mt-6">
        <livewire:staff.attendance-history />
    </div>
</x-layouts.staff>
