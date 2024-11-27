<div
    @if ($pollMillis !== null && $pollAction !== null) wire:poll.{{ $pollMillis }}ms="{{ $pollAction }}"
    @elseif($pollMillis !== null)
        wire:poll.{{ $pollMillis }}ms @endif>


    <script>
        window.countdown = function(datetime) {
            return {
                days: '00',
                hours: '00',
                minutes: '00',
                seconds: '00',
                init() {
                    this.updateTimer();
                    setInterval(() => this.updateTimer(), 1000);
                },
                updateTimer() {
                    try {
                        const now = new Date().getTime();
                        const target = new Date(datetime).getTime();
                        const distance = target - now;

                        if (distance < 0 || isNaN(distance)) {
                            this.days = '00';
                            this.hours = '00';
                            this.minutes = '00';
                            this.seconds = '00';
                            return;
                        }

                        this.days = Math.floor(distance / (1000 * 60 * 60 * 24)).toString().padStart(2, '0');
                        this.hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString()
                            .padStart(2, '0');
                        this.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2,
                            '0');
                        this.seconds = Math.floor((distance % (1000 * 60)) / 1000).toString().padStart(2, '0');
                    } catch (e) {
                        console.error('Countdown error:', e);
                        this.days = '00';
                        this.hours = '00';
                        this.minutes = '00';
                        this.seconds = '00';
                    }
                }
            }
        }
    </script>

    <!-- Top Stats Cards -->
    <!-- Top Stats Section -->
    <div class="space-y-4 mb-6">
        <!-- Main Stats Grid -->
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <!-- Event Overview & Stats -->
            <!-- Event Overview Card -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Event Overview</h3>
                    <span class="px-3 py-1 text-sm font-medium bg-blue-50 text-blue-600 rounded-full">
                        {{ now()->format('F Y') }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Total Events -->
                    <div
                        class="relative bg-blue-50/50 rounded-xl p-4 overflow-hidden group hover:bg-blue-100/50 transition-all">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-lg">
                                <i class='bx bx-calendar text-xl text-blue-600'></i>
                            </div>
                            <span class="text-sm font-medium text-gray-600">Total Events</span>
                        </div>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalEvents }}</p>
                        <!-- Decorative Element -->
                        <div
                            class="absolute -right-2 -bottom-2 w-16 h-16 bg-blue-600/5 rounded-full group-hover:scale-150 transition-transform">
                        </div>
                    </div>

                    <!-- Today's Events -->
                    <div
                        class="relative bg-emerald-50/50 rounded-xl p-4 overflow-hidden group hover:bg-emerald-100/50 transition-all">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="flex items-center justify-center w-10 h-10 bg-emerald-100 rounded-lg">
                                <i class='bx bx-calendar-check text-xl text-emerald-600'></i>
                            </div>
                            <span class="text-sm font-medium text-gray-600">Today</span>
                        </div>
                        <p class="text-3xl font-bold text-gray-900">{{ $todayEvents }}</p>
                        <!-- Decorative Element -->
                        <div
                            class="absolute -right-2 -bottom-2 w-16 h-16 bg-emerald-600/5 rounded-full group-hover:scale-150 transition-transform">
                        </div>
                    </div>

                    <!-- Upcoming Events -->
                    <div
                        class="relative bg-indigo-50/50 rounded-xl p-4 overflow-hidden group hover:bg-indigo-100/50 transition-all">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="flex items-center justify-center w-10 h-10 bg-indigo-100 rounded-lg">
                                <i class='bx bx-calendar-star text-xl text-indigo-600'></i>
                            </div>
                            <span class="text-sm font-medium text-gray-600">Upcoming</span>
                        </div>
                        <p class="text-3xl font-bold text-gray-900">{{ $upcomingEvents }}</p>
                        <!-- Decorative Element -->
                        <div
                            class="absolute -right-2 -bottom-2 w-16 h-16 bg-indigo-600/5 rounded-full group-hover:scale-150 transition-transform">
                        </div>
                    </div>

                    <!-- Completed Events -->
                    <div
                        class="relative bg-gray-50/50 rounded-xl p-4 overflow-hidden group hover:bg-gray-100/50 transition-all">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-lg">
                                <i class='bx bx-check-circle text-xl text-gray-600'></i>
                            </div>
                            <span class="text-sm font-medium text-gray-600">Completed</span>
                        </div>
                        <p class="text-3xl font-bold text-gray-900">{{ $completedEvents }}</p>
                        <!-- Decorative Element -->
                        <div
                            class="absolute -right-2 -bottom-2 w-16 h-16 bg-gray-600/5 rounded-full group-hover:scale-150 transition-transform">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Next Event Card -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-white">Next Event</h3>
                    @if ($nextEvent)
                        <span class="px-3 py-1 text-xs font-medium bg-white/20 rounded-full text-white">
                            {{ $nextEvent['date']->format('d M Y') }}
                        </span>
                    @endif
                </div>

                @if ($nextEvent)
                    <div class="mb-8">
                        <h4 class="text-2xl font-bold text-white mb-2">{{ $nextEvent['title'] }}</h4>
                        <div class="flex items-center gap-2 text-blue-100">
                            <i class='bx bx-time'></i>
                            <span>
                                {{ $nextEvent['start_time']->format('H:i') }} -
                                {{ $nextEvent['end_time']->format('H:i') }}
                            </span>
                        </div>
                    </div>

                    <div x-data="countdown('{{ $nextEvent['date']->format('Y-m-d') }} {{ $nextEvent['start_time']->format('H:i:s') }}')" x-init="init()" class="grid grid-cols-4 gap-3">
                        <div class="text-center bg-white/10 rounded-lg p-3">
                            <span x-text="days" class="text-2xl font-bold text-white block">00</span>
                            <span class="text-xs text-blue-100">Days</span>
                        </div>
                        <div class="text-center bg-white/10 rounded-lg p-3">
                            <span x-text="hours" class="text-2xl font-bold text-white block">00</span>
                            <span class="text-xs text-blue-100">Hours</span>
                        </div>
                        <div class="text-center bg-white/10 rounded-lg p-3">
                            <span x-text="minutes" class="text-2xl font-bold text-white block">00</span>
                            <span class="text-xs text-blue-100">Minutes</span>
                        </div>
                        <div class="text-center bg-white/10 rounded-lg p-3">
                            <span x-text="seconds" class="text-2xl font-bold text-white block">00</span>
                            <span class="text-xs text-blue-100">Seconds</span>
                        </div>
                    </div>
                @else
                    <div class="flex items-center justify-center h-48">
                        <p class="text-blue-100">No upcoming events</p>
                    </div>
                @endif
            </div>

            <!-- Monthly Progress -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Monthly Progress</h3>
                    <span class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full">
                        {{ now()->format('F Y') }}
                    </span>
                </div>

                @php
                    $totalDays = $startsAt->daysInMonth;
                    $currentDay = now()->day;
                    $progress = ($currentDay / $totalDays) * 100;
                @endphp

                <div class="flex justify-center mb-8">
                    <div class="relative">
                        <svg class="w-36 h-36 transform -rotate-90">
                            <circle class="text-gray-100" stroke-width="6" stroke="currentColor" fill="transparent"
                                r="62" cx="72" cy="72" />
                            <circle class="text-blue-500" stroke-width="6" stroke="currentColor" fill="transparent"
                                r="62" cx="72" cy="72"
                                stroke-dasharray="{{ 389.6 * ($progress / 100) }} 389.6" stroke-dashoffset="0" />
                        </svg>
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center">
                            <span class="text-3xl font-bold text-gray-900">{{ number_format($progress, 0) }}%</span>
                            <span class="text-sm text-gray-500 block">Complete</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Days Remaining</span>
                        <span class="text-sm font-medium text-gray-900">{{ $totalDays - $currentDay }} days</span>
                    </div>
                    <div class="h-px bg-gray-100"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Events This Month</span>
                        <span class="text-sm font-medium text-gray-900">{{ $events->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
        <!-- Main Calendar Section -->
        <div class="xl:col-span-3">
            <livewire:admin.schedules.schedules-exception-modal />

            <div class="bg-white rounded-xl shadow-sm border border-gray-100" wire:poll.10s>
                <div>
                    <div>
                        @includeIf($beforeCalendarView)
                    </div>

                    <div class="overflow-x-auto">
                        <div class="inline-block min-w-full">
                            <div class="grid grid-cols-7 gap-0">
                                @foreach ($monthGrid->first() as $day)
                                    @include($dayOfWeekView, ['day' => $day])
                                @endforeach

                                @foreach ($monthGrid as $week)
                                    @foreach ($week as $day)
                                        @include($dayView, [
                                            'componentId' => $componentId,
                                            'day' => $day,
                                            'dayInMonth' => $day->isSameMonth($startsAt),
                                            'isToday' => $day->isToday(),
                                            'events' => $getEventsForDay($day, $events),
                                        ])
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                @includeIf($afterCalendarView)
            </div>
        </div>

        <!-- Right Sidebar -->
        <!-- Right Sidebar -->
        <div class="xl:col-span-1 space-y-6">
            <!-- Monthly Progress -->
            <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Monthly Progress</h3>
                    <div class="inline-flex items-center px-2.5 py-1 rounded-lg text-sm bg-gray-100 text-gray-700">
                        {{ now()->format('F Y') }}
                    </div>
                </div>

                @php
                    $totalDays = $startsAt->daysInMonth;
                    $currentDay = now()->day;
                    $progress = ($currentDay / $totalDays) * 100;
                @endphp

                <!-- Progress Circle -->
                <div class="flex justify-center mb-6">
                    <div class="relative inline-flex items-center justify-center">
                        <svg class="w-24 h-24">
                            <circle class="text-gray-100" stroke="currentColor" stroke-width="4" fill="none"
                                r="38" cx="48" cy="48" />
                            <circle class="text-blue-500" stroke="currentColor" stroke-width="4"
                                stroke-linecap="round" stroke-dasharray="{{ $progress * 2.4 }},1000" fill="none"
                                r="38" cx="48" cy="48" />
                        </svg>
                        <span
                            class="absolute text-xl font-bold text-gray-900">{{ number_format($progress, 0) }}%</span>
                    </div>
                </div>

                <!-- Distribution Stats -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class='bx bx-calendar-check text-emerald-500'></i>
                            <span class="text-sm text-gray-600">Today</span>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ $todayEvents }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class='bx bx-calendar-star text-blue-500'></i>
                            <span class="text-sm text-gray-600">Upcoming</span>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ $upcomingEvents }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class='bx bx-check-circle text-gray-500'></i>
                            <span class="text-sm text-gray-600">Completed</span>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ $completedEvents }}</span>
                    </div>
                </div>
            </div>

            <!-- Today's Events -->
            @if ($todayEvents > 0)
                <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Today's Schedule</h3>
                        <div
                            class="inline-flex items-center px-2.5 py-1 rounded-lg text-sm bg-emerald-100 text-emerald-700">
                            {{ now()->format('d M') }}
                        </div>
                    </div>

                    <div class="space-y-4">
                        @foreach ($events->filter(fn($event) => \Carbon\Carbon::parse($event['date'])->isToday())->sortBy('start_time') as $event)
                            <div class="flex gap-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex-shrink-0 w-1 self-stretch rounded-full"
                                    style="background-color: {{ $event['backgroundColor'] }}">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-medium text-gray-900 truncate">{{ $event['title'] }}</h4>
                                    <div class="mt-1 flex items-center gap-2 text-xs text-gray-500">
                                        <i class='bx bx-time-five'></i>
                                        {{ \Carbon\Carbon::parse($event['start_time'])->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($event['end_time'])->format('H:i') }}
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium"
                                        style="background-color: {{ $event['backgroundColor'] }}; color: {{ $event['textColor'] }}">
                                        {{ ucfirst($event['status']) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>


</div>
