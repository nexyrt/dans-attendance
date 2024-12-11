<x-layouts.staff>
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-5">
        <!-- Today's Hours -->
        <div
            class="bg-white rounded-xl p-6 border border-gray-100 hover:shadow-lg transition-all duration-300 group relative overflow-hidden">
            <div
                class="absolute inset-0 bg-gradient-to-r from-blue-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            </div>
            <div class="relative">
                <div class="flex justify-between mb-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Today's Hours</p>
                        <div class="flex items-baseline mt-2 space-x-1">
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['todayHours'], 1) }}</p>
                            <p class="text-sm font-medium text-gray-500">/ {{ $stats['targetHours'] }}h</p>
                        </div>
                    </div>
                    <div
                        class="p-3 bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-xl group-hover:scale-105 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-blue-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="w-full mr-3">
                        <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-blue-500 to-blue-600 rounded-full transition-all duration-500 ease-out"
                                style="width: {{ min($stats['todayProgress'], 100) }}%">
                            </div>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-blue-600 whitespace-nowrap">
                        {{ number_format($stats['todayProgress'], 1) }}%</p>
                </div>
            </div>
        </div>

        <!-- Week Total -->
        <div
            class="bg-white rounded-xl p-6 border border-gray-100 hover:shadow-lg transition-all duration-300 group relative overflow-hidden">
            <div
                class="absolute inset-0 bg-gradient-to-r from-emerald-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            </div>
            <div class="relative">
                <div class="flex justify-between mb-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Week Total</p>
                        <div class="flex items-baseline mt-2 space-x-1">
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['weekTotal'], 1) }}</p>
                            <p class="text-sm font-medium text-gray-500">/ {{ 5 * $stats['targetHours'] }}h</p>
                        </div>
                    </div>
                    <div
                        class="p-3 bg-gradient-to-br from-emerald-50 to-emerald-100/50 rounded-xl group-hover:scale-105 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-emerald-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="w-full mr-3">
                        <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-full transition-all duration-500 ease-out"
                                style="width: {{ min($stats['weekProgress'], 100) }}%">
                            </div>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-emerald-600 whitespace-nowrap">
                        {{ number_format($stats['weekProgress'], 1) }}%</p>
                </div>
                @if ($stats['weekProgress'] >= 100)
                    <p class="mt-2 text-xs text-emerald-600">Weekly target achieved! 🎉</p>
                @endif
            </div>
        </div>

        <!-- Leave Balance -->
        <div
            class="bg-white rounded-xl p-6 border border-gray-100 hover:shadow-lg transition-all duration-300 group relative overflow-hidden">
            <div
                class="absolute inset-0 bg-gradient-to-r from-violet-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            </div>
            <div class="relative">
                <div class="flex justify-between mb-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Leave Balance</p>
                        <div class="flex items-baseline mt-2 space-x-1">
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $stats['leaveBalance'] ? $stats['leaveBalance']['remaining'] : 0 }}</p>
                            <p class="text-sm font-medium text-gray-500">days left</p>
                        </div>
                    </div>
                    <div
                        class="p-3 bg-gradient-to-br from-violet-50 to-violet-100/50 rounded-xl group-hover:scale-105 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-violet-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="w-full mr-3">
                        <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                            @if ($stats['leaveBalance'])
                                <div class="h-full bg-gradient-to-r from-violet-500 to-violet-600 rounded-full transition-all duration-500 ease-out"
                                    style="width: {{ ($stats['leaveBalance']['used'] / $stats['leaveBalance']['total']) * 100 }}%">
                                </div>
                            @endif
                        </div>
                    </div>
                    <p class="text-sm font-medium text-violet-600 whitespace-nowrap">
                        {{ $stats['leaveBalance'] ? $stats['leaveBalance']['used'] : 0 }} used
                    </p>
                </div>
                @if ($stats['leaveBalance'] && $stats['leaveBalance']['remaining'] <= 3)
                    <p class="mt-2 text-xs text-amber-600">Low leave balance remaining!</p>
                @endif
            </div>
        </div>

        <!-- Today's Status -->
        <div
            class="bg-white rounded-xl p-6 border border-gray-100 hover:shadow-lg transition-all duration-300 group relative overflow-hidden">
            <div
                class="absolute inset-0 bg-gradient-to-r from-amber-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            </div>
            <div class="relative">
                <div class="flex justify-between mb-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Today's Status</p>
                        <div class="flex items-center mt-2 space-x-2">
                            <div
                                class="flex-shrink-0 size-2.5 rounded-full 
                            {{ !$todayAttendance
                                ? 'bg-gray-300'
                                : (!$todayAttendance->check_out
                                    ? 'bg-amber-400'
                                    : ($todayAttendance->status === 'late'
                                        ? 'bg-red-400'
                                        : 'bg-emerald-400')) }}">
                            </div>
                            <p class="text-2xl font-bold text-gray-900">
                                @if (!$todayAttendance)
                                    Not In
                                @elseif(!$todayAttendance->check_out)
                                    On Duty
                                @else
                                    Completed
                                @endif
                            </p>
                        </div>
                    </div>
                    <div
                        class="p-3 bg-gradient-to-br from-amber-50 to-amber-100/50 rounded-xl group-hover:scale-105 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-amber-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                @if ($todayAttendance)
                    <div class="mt-2">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Last Activity:</span>
                            <span
                                class="font-medium {{ $todayAttendance->status === 'late' ? 'text-red-600' : 'text-gray-900' }}">
                                {{ \Cake\Chronos\Chronos::parse($todayAttendance->updated_at)->diffForHumans() }}
                            </span>
                        </div>
                        @if ($todayAttendance->status === 'late')
                            <p class="mt-2 text-xs text-red-600">Arrived
                                {{ \Cake\Chronos\Chronos::parse($todayAttendance->check_in)->diffInMinutes($schedule->start_time) }}
                                minutes late</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
        <!-- Left Column -->
        <div class="lg:col-span-8 space-y-5">
            <!-- Time Tracking Card -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Time Tracking</h2>
                    <div class="text-sm text-gray-500">{{ now()->format('l, F j, Y') }}</div>
                </div>

                <!-- Check-in/Check-out Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Check-in Status -->
                    <button
                        class="group relative bg-white rounded-xl p-6 border border-gray-100 hover:border-blue-200 hover:shadow-md transition-all duration-300">
                        <div class="absolute top-4 right-4">
                            <span
                                class="px-3 py-1 text-xs font-medium {{ $todayAttendance && $todayAttendance->check_in ? 'bg-green-50 text-green-700' : 'bg-gray-50 text-gray-600' }} rounded-full">
                                {{ $todayAttendance && $todayAttendance->check_in ? 'Checked In' : 'Not Checked In' }}
                            </span>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div
                                class="p-3 bg-blue-50 rounded-lg group-hover:bg-blue-100 transition-colors duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-blue-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xl font-semibold text-gray-900">
                                    {{ $todayAttendance && $todayAttendance->check_in ? Carbon\Carbon::parse($todayAttendance->check_in)->format('H:i') : '--:--' }}
                                </p>
                                <p class="text-sm text-gray-500 mt-1">Check-in Time</p>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-t border-gray-50">
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="text-sm text-gray-500">Office Location</span>
                            </div>
                        </div>
                    </button>

                    <!-- Check-out Status -->
                    <button
                        class="group relative bg-white rounded-xl p-6 border border-gray-100 hover:border-red-200 hover:shadow-md transition-all duration-300">
                        <div class="absolute top-4 right-4">
                            <span
                                class="px-3 py-1 text-xs font-medium {{ $todayAttendance && $todayAttendance->check_out ? 'bg-green-50 text-green-700' : 'bg-gray-50 text-gray-600' }} rounded-full">
                                {{ $todayAttendance && $todayAttendance->check_out ? 'Checked Out' : 'Not Checked Out' }}
                            </span>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div
                                class="p-3 bg-red-50 rounded-lg group-hover:bg-red-100 transition-colors duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-red-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xl font-semibold text-gray-900">
                                    {{ $todayAttendance && $todayAttendance->check_out ? Carbon\Carbon::parse($todayAttendance->check_out)->format('H:i') : '--:--' }}
                                </p>
                                <p class="text-sm text-gray-500 mt-1">Check-out Time</p>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-t border-gray-50">
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm text-gray-500">
                                    {{ $todayAttendance && $todayAttendance->working_hours ? $todayAttendance->working_hours . ' hours today' : 'Duration will appear here' }}
                                </span>
                            </div>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <!-- Header -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <!-- Icon -->
                        <div class="p-2 bg-indigo-50 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-indigo-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <!-- Title -->
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Recent Activity</h2>
                            <p class="text-sm text-gray-500">Your attendance history</p>
                        </div>
                    </div>
                    <!-- View All Link -->
                    <a href="{{ route('staff.attendance.index') }}"
                        class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                        View All
                    </a>
                </div>

                <!-- Activity List -->
                <div class="space-y-4">
                    @forelse($recentActivity as $activity)
                        <div class="relative pl-8 pb-6 border-l-2 border-gray-100 last:border-0">
                            <!-- Status Indicator Dot -->
                            <div @class([
                                'absolute -left-2 top-0 w-4 h-4 rounded-full',
                                'bg-yellow-100 border-2 border-yellow-400' =>
                                    $activity['type'] === 'check_in' && $activity['status'] === 'late',
                                'bg-green-100 border-2 border-green-400' =>
                                    $activity['type'] === 'check_in' && $activity['status'] !== 'late',
                                'bg-red-100 border-2 border-red-400' => $activity['type'] === 'check_out',
                            ])></div>

                            <!-- Activity Header -->
                            <div class="flex items-center justify-between">
                                <!-- Activity Type -->
                                <p class="text-sm font-medium text-gray-900">
                                    @if ($activity['type'] === 'check_in')
                                        {{ $activity['status'] === 'late' ? 'Late Arrival' : 'Checked in' }}
                                    @else
                                        Checked out
                                    @endif
                                </p>

                                <!-- Timestamp -->
                                <time class="text-sm text-gray-500">
                                    {{ Cake\Chronos\Chronos::parse($activity['date'])->isToday()
                                        ? 'Today'
                                        : (Cake\Chronos\Chronos::parse($activity['date'])->isYesterday()
                                            ? 'Yesterday'
                                            : Cake\Chronos\Chronos::parse($activity['date'])->format('D, M j')) }},
                                    {{ Cake\Chronos\Chronos::parse($activity['time'])->format('H:i') }}
                                </time>
                            </div>

                            <!-- Activity Details -->
                            <p class="text-sm text-gray-500 mt-1">
                                @if ($activity['type'] === 'check_in')
                                    {{ $activity['notes'] ?: ($activity['status'] === 'late' ? 'Late arrival to office' : 'On time arrival at office') }}
                                @else
                                    @if ($activity['early_leave_reason'])
                                        Left early: {{ $activity['early_leave_reason'] }}
                                    @else
                                        Completed {{ $activity['working_hours'] }} hours of work
                                    @endif
                                @endif
                            </p>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <p class="text-gray-500">No recent activity found</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Upcoming Tasks Preview -->
            <div class="relative bg-white rounded-xl p-6 shadow-sm border border-gray-100 overflow-hidden">
                <!-- Coming Soon Overlay -->
                <div
                    class="absolute inset-0 backdrop-blur-sm bg-gradient-to-br from-white/50 to-gray-900/30 z-10 flex flex-col items-center justify-center">
                    <div class="transform -rotate-1">
                        <span
                            class="inline-flex items-center justify-center px-6 py-2 rounded-full text-sm font-semibold bg-gradient-to-r from-purple-600/90 to-indigo-600/90 text-white shadow-lg backdrop-blur-sm">
                            Coming Soon
                        </span>
                        <p class="mt-3 text-base font-medium text-white text-center text-shadow">
                            Task Management Features
                        </p>
                    </div>

                    <!-- Decorative Elements -->
                    <div class="absolute top-1/4 -right-6 w-24 h-24 bg-purple-500/10 rounded-full blur-2xl"></div>
                    <div class="absolute bottom-1/4 -left-6 w-32 h-32 bg-indigo-500/10 rounded-full blur-2xl"></div>
                </div>

                <!-- Blurred Content Background -->
                <div class="opacity-50 select-none">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-purple-50 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-purple-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Upcoming Tasks</h2>
                                <p class="text-sm text-gray-500">Your pending assignments</p>
                            </div>
                        </div>
                    </div>

                    <!-- Placeholder Tasks -->
                    <div class="space-y-4">
                        <div class="p-4 bg-gray-50/80 rounded-lg border border-gray-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-4 h-4 rounded border border-gray-300"></div>
                                <div class="flex-1 space-y-1">
                                    <div class="h-4 bg-gray-200/80 rounded w-3/4"></div>
                                    <div class="h-3 bg-gray-200/80 rounded w-1/2"></div>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 bg-gray-50/80 rounded-lg border border-gray-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-4 h-4 rounded border border-gray-300"></div>
                                <div class="flex-1 space-y-1">
                                    <div class="h-4 bg-gray-200/80 rounded w-2/3"></div>
                                    <div class="h-3 bg-gray-200/80 rounded w-2/5"></div>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 bg-gray-50/80 rounded-lg border border-gray-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-4 h-4 rounded border border-gray-300"></div>
                                <div class="flex-1 space-y-1">
                                    <div class="h-4 bg-gray-200/80 rounded w-1/2"></div>
                                    <div class="h-3 bg-gray-200/80 rounded w-1/3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="lg:col-span-4 space-y-5">
            <!-- Schedule Overview -->
            <div
                class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="p-2.5 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-blue-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Today's Schedule</h2>
                            <p class="text-sm text-gray-500">{{ \Cake\Chronos\Chronos::now()->format('l, F j, Y') }}
                            </p>
                        </div>
                    </div>

                    <!-- Current Status Badge -->
                    <span
                        class="px-3 py-1 text-xs font-medium rounded-full {{ $scheduleException ? 'bg-amber-50 text-amber-700 border border-amber-100' : 'bg-emerald-50 text-emerald-700 border border-emerald-100' }}">
                        {{ $scheduleException ? ($scheduleException->status === 'wfh' ? 'Work From Home' : ($scheduleException->status === 'halfday' ? 'Half Day' : 'Modified Schedule')) : 'Regular Schedule' }}
                    </span>
                </div>

                <div class="space-y-5">
                    <!-- Time Card -->
                    <div
                        class="relative overflow-hidden rounded-xl bg-gradient-to-br from-blue-50 via-blue-50 to-indigo-50 p-5">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 size-24 rounded-full bg-blue-100/50"></div>
                        <div class="absolute bottom-0 right-0 -mb-8 -mr-8 size-40 rounded-full bg-indigo-100/30"></div>

                        <div class="relative">
                            <div class="flex items-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-blue-600 mr-2"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="font-medium text-gray-900">Working Hours</h3>
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                <div class="bg-white/60 backdrop-blur-sm rounded-lg p-3">
                                    <p class="text-sm text-gray-500 mb-1">Start Time</p>
                                    <p class="text-lg font-semibold text-gray-900">
                                        {{ $scheduleException && $scheduleException->start_time
                                            ? \Cake\Chronos\Chronos::parse($scheduleException->start_time)->format('H:i')
                                            : ($schedule
                                                ? \Cake\Chronos\Chronos::parse($schedule->start_time)->format('H:i')
                                                : '08:00') }}
                                    </p>
                                </div>
                                <div class="bg-white/60 backdrop-blur-sm rounded-lg p-3">
                                    <p class="text-sm text-gray-500 mb-1">Duration</p>
                                    <p class="text-lg font-semibold text-gray-900">
                                        @php
                                            $startTime =
                                                $scheduleException && $scheduleException->start_time
                                                    ? \Cake\Chronos\Chronos::parse($scheduleException->start_time)
                                                    : ($schedule
                                                        ? \Cake\Chronos\Chronos::parse($schedule->start_time)
                                                        : \Cake\Chronos\Chronos::parse('08:00'));

                                            $endTime =
                                                $scheduleException && $scheduleException->end_time
                                                    ? \Cake\Chronos\Chronos::parse($scheduleException->end_time)
                                                    : ($schedule
                                                        ? \Cake\Chronos\Chronos::parse($schedule->end_time)
                                                        : \Cake\Chronos\Chronos::parse('17:00'));

                                            $duration = $endTime->diffInHours($startTime);
                                        @endphp
                                        {{ $duration }}h
                                    </p>
                                </div>
                                <div class="bg-white/60 backdrop-blur-sm rounded-lg p-3">
                                    <p class="text-sm text-gray-500 mb-1">End Time</p>
                                    <p class="text-lg font-semibold text-gray-900">
                                        {{ $scheduleException && $scheduleException->end_time
                                            ? \Cake\Chronos\Chronos::parse($scheduleException->end_time)->format('H:i')
                                            : ($schedule
                                                ? \Cake\Chronos\Chronos::parse($schedule->end_time)->format('H:i')
                                                : '17:00') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Schedule Details -->
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <div class="bg-gray-50 rounded-xl p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <div class="p-1.5 bg-gray-100 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-600"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">Late Tolerance</span>
                                    </div>
                                    <span
                                        class="text-sm text-gray-600">{{ $schedule ? $schedule->late_tolerance : 30 }}
                                        minutes</span>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-xl p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <div class="p-1.5 bg-gray-100 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-600"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">Department</span>
                                    </div>
                                    <span class="text-sm text-gray-600">{{ $user->department->name }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <div class="bg-gray-50 rounded-xl p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <div class="p-1.5 bg-gray-100 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-600"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">Schedule Type</span>
                                    </div>
                                    <span
                                        class="text-sm text-gray-600">{{ $scheduleException ? 'Modified' : 'Regular' }}</span>
                                </div>
                            </div>

                            @if ($scheduleException && $scheduleException->note)
                                <div class="bg-amber-50 rounded-xl p-4">
                                    <div class="flex space-x-2">
                                        <div class="p-1.5 bg-amber-100 rounded-lg flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-amber-600"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-amber-800 mb-0.5">Note</p>
                                            <p class="text-sm text-amber-600">{{ $scheduleException->note }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
                <div class="grid grid-cols-2 gap-4">
                    <button
                        class="p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors duration-300 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-indigo-500 mx-auto mb-2"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-sm font-medium text-gray-900">Request Leave</span>
                    </button>

                    <button
                        class="p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors duration-300 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-green-500 mx-auto mb-2"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span class="text-sm font-medium text-gray-900">View Reports</span>
                    </button>

                    <button
                        class="p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors duration-300 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-yellow-500 mx-auto mb-2"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-medium text-gray-900">Work Hours</span>
                    </button>

                    <button
                        class="p-4 bg-red-50 rounded-lg hover:bg-red-100 transition-colors duration-300 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-red-500 mx-auto mb-2"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-medium text-gray-900">Support</span>
                    </button>
                </div>
            </div>

            <!-- Upcoming Tasks Preview -->
            <div class="relative bg-white rounded-xl p-6 shadow-sm border border-gray-100 overflow-hidden">
                <!-- Coming Soon Overlay -->
                <div
                    class="absolute inset-0 backdrop-blur-sm bg-gradient-to-br from-white/50 to-gray-900/30 z-10 flex flex-col items-center justify-center">
                    <div class="transform -rotate-1">
                        <span
                            class="inline-flex items-center justify-center px-6 py-2 rounded-full text-sm font-semibold bg-gradient-to-r from-purple-600/90 to-indigo-600/90 text-white shadow-lg backdrop-blur-sm">
                            Coming Soon
                        </span>
                        <p class="mt-3 text-base font-medium text-white text-center text-shadow">
                            Task Management Features
                        </p>
                    </div>

                    <!-- Decorative Elements -->
                    <div class="absolute top-1/4 -right-6 w-24 h-24 bg-purple-500/10 rounded-full blur-2xl"></div>
                    <div class="absolute bottom-1/4 -left-6 w-32 h-32 bg-indigo-500/10 rounded-full blur-2xl"></div>
                </div>

                <!-- Blurred Content Background -->
                <div class="opacity-50 select-none">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-purple-50 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-purple-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Upcoming Tasks</h2>
                                <p class="text-sm text-gray-500">Your pending assignments</p>
                            </div>
                        </div>
                    </div>

                    <!-- Placeholder Tasks -->
                    <div class="space-y-4">
                        <div class="p-4 bg-gray-50/80 rounded-lg border border-gray-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-4 h-4 rounded border border-gray-300"></div>
                                <div class="flex-1 space-y-1">
                                    <div class="h-4 bg-gray-200/80 rounded w-3/4"></div>
                                    <div class="h-3 bg-gray-200/80 rounded w-1/2"></div>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 bg-gray-50/80 rounded-lg border border-gray-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-4 h-4 rounded border border-gray-300"></div>
                                <div class="flex-1 space-y-1">
                                    <div class="h-4 bg-gray-200/80 rounded w-2/3"></div>
                                    <div class="h-3 bg-gray-200/80 rounded w-2/5"></div>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 bg-gray-50/80 rounded-lg border border-gray-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-4 h-4 rounded border border-gray-300"></div>
                                <div class="flex-1 space-y-1">
                                    <div class="h-4 bg-gray-200/80 rounded w-1/2"></div>
                                    <div class="h-3 bg-gray-200/80 rounded w-1/3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Check-in Modal -->
    <livewire:shared.check-in-modal />

    <!-- Check-out Modal -->
    <livewire:shared.check-out-modal />

    <!-- Leave Request Modal -->
    <div x-data="{ open: false }" x-cloak>
        <div x-show="open" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div x-show="open" class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div
                    class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                    <!-- Modal content here -->
                </div>
            </div>
        </div>
    </div>
</x-layouts.staff>
