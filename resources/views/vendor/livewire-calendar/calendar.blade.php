<div @if ($pollMillis !==null && $pollAction !==null) wire:poll.{{ $pollMillis }}ms="{{ $pollAction }}"
    @elseif($pollMillis !==null) wire:poll.{{ $pollMillis }}ms @endif>


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

                <div x-data="countdown('{{ $nextEvent['date']->format('Y-m-d') }} {{ $nextEvent['start_time']->format('H:i:s') }}')"
                    x-init="init()" class="grid grid-cols-4 gap-3">
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
                                r="62" cx="72" cy="72" stroke-dasharray="{{ 389.6 * ($progress / 100) }} 389.6"
                                stroke-dashoffset="0" />
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

    <!-- Today's Schedule -->


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
        <div class="xl:col-span-1 space-y-6">
            <!-- Today's Live Schedule -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <!-- Header Section -->
                <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-blue-500 to-blue-600 rounded-t-xl">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <i class='bx bx-time-five text-xl text-white'></i>
                            </div>
                            <h3 class="text-lg font-semibold text-white">Live Schedule</h3>
                        </div>
                        <div class="flex items-center gap-2 bg-white/20 px-3 py-1 rounded-full">
                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-sm text-white">{{ now()->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Scrollable Schedule List -->
                <div class="overflow-y-auto max-h-[calc(100vh-20rem)] custom-scrollbar">
                    <!-- Current Time Indicator -->
                    <div
                        class="sticky top-0 z-10 bg-gradient-to-r from-amber-50 to-orange-50 p-3 border-b border-orange-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <i class='bx bx-broadcast text-lg text-orange-500 animate-pulse'></i>
                                <span class="text-sm font-medium text-orange-600">Current Time</span>
                            </div>
                            <span class="text-sm font-bold text-orange-600">{{ now()->format('H:i') }}</span>
                        </div>
                    </div>

                    <div class="p-4 space-y-4">
                        @php
                        $currentTime = now();
                        $todayEvents = $events
                        ->filter(fn($event) => \Carbon\Carbon::parse($event['date'])->isToday())
                        ->sortBy('start_time');

                        // Group events by status (ongoing, upcoming, completed)
                        $groupedEvents = $todayEvents->groupBy(function ($event) use ($currentTime) {
                        $startTime = \Carbon\Carbon::parse($event['start_time']);
                        $endTime = \Carbon\Carbon::parse($event['end_time']);

                        if ($currentTime->between($startTime, $endTime)) {
                        return 'ongoing';
                        }
                        return $currentTime->lt($startTime) ? 'upcoming' : 'completed';
                        });
                        @endphp

                        <!-- Ongoing Events -->
                        @if (isset($groupedEvents['ongoing']) && $groupedEvents['ongoing']->count() > 0)
                        <div class="space-y-3">
                            <h4 class="flex items-center gap-2 text-sm font-medium text-blue-600">
                                <i class='bx bx-play-circle animate-pulse'></i>
                                Ongoing Now
                            </h4>
                            @foreach ($groupedEvents['ongoing'] as $event)
                            <div class="relative p-4 bg-blue-50 rounded-lg">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                                        <i class='bx bx-calendar text-lg text-blue-600'></i>
                                    </div>
                                    <div>
                                        <h5 class="font-medium text-gray-900">{{ $event['title'] }}</h5>
                                        <div class="flex items-center gap-1 text-sm text-gray-600">
                                            <i class='bx bx-time text-sm'></i>
                                            <span>
                                                {{ \Carbon\Carbon::parse($event['start_time'])->format('H:i') }}
                                                -
                                                {{ \Carbon\Carbon::parse($event['end_time'])->format('H:i') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Countdown Timer -->
                                <div x-data="countdown('{{ \Carbon\Carbon::parse($event['date'])->format('Y-m-d') }} {{ \Carbon\Carbon::parse($event['end_time'])->format('H:i:s') }}')"
                                    x-init="init()">
                                    <div class="text-sm text-blue-600 mb-1">Ends in:</div>
                                    <div class="flex items-baseline gap-1">
                                        <span x-text="hours.toString().padStart(2, '0')"
                                            class="text-lg font-semibold text-blue-700">00</span>
                                        <span class="text-xs text-blue-600">h</span>

                                        <span x-text="minutes.toString().padStart(2, '0')"
                                            class="text-lg font-semibold text-blue-700 ml-2">00</span>
                                        <span class="text-xs text-blue-600">m</span>

                                        <span x-text="seconds.toString().padStart(2, '0')"
                                            class="text-lg font-semibold text-blue-700 ml-2">00</span>
                                        <span class="text-xs text-blue-600">s</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        <!-- Upcoming Events -->
                        @if (isset($groupedEvents['upcoming']) && $groupedEvents['upcoming']->count() > 0)
                        <div class="space-y-3">
                            <h4 class="flex items-center gap-2 text-sm font-medium text-gray-600">
                                <i class='bx bx-time-five'></i>
                                Coming Up
                            </h4>
                            @foreach ($groupedEvents['upcoming'] as $event)
                            <div class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-lg bg-gray-200 flex items-center justify-center">
                                            <i
                                                class="bx {{ $event['status'] === 'Regular' ? 'bx-calendar' : 'bx-calendar-star' }} text-xl text-gray-600"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h5 class="font-medium text-gray-900 mb-1">{{ $event['title'] }}</h5>
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <i class='bx bx-time'></i>
                                            <span>{{ \Carbon\Carbon::parse($event['start_time'])->format('H:i')
                                                }}</span>
                                        </div>
                                        @if ($event['department'])
                                        <div class="mt-2 flex items-center gap-2 text-sm text-gray-500">
                                            <i class='bx bx-buildings'></i>
                                            <span>{{ $event['department'] }}</span>
                                        </div>
                                        @endif
                                    </div>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                        style="background-color: {{ $event['backgroundColor'] }}40; color: {{ $event['backgroundColor'] }}">
                                        {{ $event['status'] }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        <!-- Completed Events -->
                        @if (isset($groupedEvents['completed']) && $groupedEvents['completed']->count() > 0)
                        <div class="space-y-3">
                            <h4 class="flex items-center gap-2 text-sm font-medium text-gray-500">
                                <i class='bx bx-check-circle'></i>
                                Completed
                            </h4>
                            @foreach ($groupedEvents['completed'] as $event)
                            <div class="p-4 bg-gray-50/50 rounded-lg opacity-75">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center">
                                        <i class='bx bx-check text-lg text-gray-500'></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h5 class="font-medium text-gray-700 line-through">
                                            {{ $event['title'] }}</h5>
                                        <span class="text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($event['start_time'])->format('H:i') }} -
                                            {{ \Carbon\Carbon::parse($event['end_time'])->format('H:i') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        @if ($todayEvents->count() === 0)
                        <div class="text-center py-8">
                            <div
                                class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                                <i class='bx bx-calendar text-3xl text-gray-400'></i>
                            </div>
                            <h4 class="text-gray-600 font-medium">No Events Today</h4>
                            <p class="text-sm text-gray-500 mt-1">Your schedule is clear</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div x-data="{ hasEvent: false }" x-on:schedule-selected.window="hasEvent = true">
                    <!-- Default State -->
                    <div x-show="!hasEvent" class="text-center p-12">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center justify-center animate-pulse">
                                <div class="w-24 h-24 bg-blue-50 rounded-full"></div>
                            </div>
                            <div class="relative flex flex-col items-center">
                                <i class='bx bx-calendar-plus text-3xl text-blue-500 mb-4'></i>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Event Selected</h3>
                                <p class="text-sm text-gray-500">Select an event from the calendar to view details</p>
                            </div>
                        </div>
                    </div>

                    <!-- Event Details -->
                    @if ($schedule)
                    <div x-show="hasEvent">
                        <!-- Header Section -->
                        <!-- Header Section -->
                        <div class="relative overflow-hidden bg-blue-600 p-8 text-white">
                            <!-- Decorative Background Elements -->
                            <div class="absolute inset-0 opacity-10">
                                <div class="absolute -right-20 -top-20 w-64 h-64 rounded-full bg-white"></div>
                                <div class="absolute -left-20 -bottom-20 w-48 h-48 rounded-full bg-white"></div>
                            </div>

                            <!-- Content -->
                            <div class="relative">
                                <!-- Title and Status -->
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="flex items-center justify-center w-12 h-12 rounded-xl bg-white/10 backdrop-blur-sm">
                                            <i class='bx bx-calendar-edit text-2xl'></i>
                                        </div>
                                        <h2 class="text-2xl font-bold">{{ $schedule->title }}</h2>
                                    </div>

                                    @php
                                    $now = now();
                                    $startTime = $schedule->date->setTimeFrom($schedule->start_time);
                                    $endTime = $schedule->date->setTimeFrom($schedule->end_time);

                                    if ($now->lt($startTime)) {
                                    $status = 'upcoming';
                                    $statusIcon = 'bx-time-five';
                                    $statusClass = 'bg-yellow-400/20 text-yellow-50 border border-yellow-400/30';
                                    } elseif ($now->between($startTime, $endTime)) {
                                    $status = 'ongoing';
                                    $statusIcon = 'bx-broadcast';
                                    $statusClass = 'bg-green-400/20 text-green-50 border border-green-400/30';
                                    } else {
                                    $status = 'completed';
                                    $statusIcon = 'bx-check-circle';
                                    $statusClass = 'bg-blue-400/20 text-blue-50 border border-blue-400/30';
                                    }
                                    @endphp
                                    <div
                                        class="flex items-center gap-2 {{ $statusClass }} px-4 py-2 rounded-full backdrop-blur-sm">
                                        <i class='bx {{ $statusIcon }} {{ $status === ' ongoing' ? 'animate-pulse' : ''
                                            }}'></i>
                                        <span class="text-sm font-medium capitalize">{{ $status }}</span>
                                    </div>
                                </div>

                                <!-- Date and Time Info -->
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <!-- Date -->
                                    <div
                                        class="flex items-center gap-3 px-4 py-3 bg-white/10 rounded-xl backdrop-blur-sm">
                                        <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-white/10">
                                            <i class='bx bx-calendar text-xl'></i>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm text-blue-100">Date</span>
                                            <span class="font-medium">{{ $schedule->date->format('l, d M Y') }}</span>
                                        </div>
                                    </div>

                                    <!-- Time -->
                                    <div
                                        class="flex items-center gap-3 px-4 py-3 bg-white/10 rounded-xl backdrop-blur-sm">
                                        <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-white/10">
                                            <i class='bx bx-time text-xl'></i>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm text-blue-100">Time</span>
                                            <div class="font-medium">
                                                {{ $schedule->start_time->format('H:i') }}
                                                <span class="text-blue-200 mx-2">to</span>
                                                {{ $schedule->end_time->format('H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 space-y-6">
                            <!-- Event Type -->
                            <div class="flex items-center gap-4 p-4 bg-blue-50 rounded-xl">
                                <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg">
                                    <i class='bx bx-calendar-event text-2xl text-blue-600'></i>
                                </div>
                                <div>
                                    <p class="text-sm text-blue-600 font-medium mb-1">Event Type</p>
                                    <p class="text-lg font-semibold text-gray-900 capitalize">{{ $schedule->status }}
                                    </p>
                                </div>
                            </div>

                            <!-- Departments -->
                            <div class="rounded-xl border border-gray-100">
                                <div class="px-6 py-4 border-b border-gray-100">
                                    <h3 class="text-sm font-semibold text-gray-900">Participating Departments</h3>
                                </div>
                                <div class="p-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        @foreach($schedule->departments as $department)
                                        <div
                                            class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                            <div
                                                class="flex-shrink-0 w-10 h-10 flex items-center justify-center bg-white rounded-lg shadow-sm">
                                                <i class='bx bx-buildings text-gray-500'></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $department->name }}</p>
                                                <p class="text-sm text-gray-500">{{ $department->code }}</p>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            @if($schedule->note)
                            <div class="rounded-xl border border-gray-100">
                                <div class="px-6 py-4 border-b border-gray-100">
                                    <h3 class="text-sm font-semibold text-gray-900">Description</h3>
                                </div>
                                <div class="p-6">
                                    <p class="text-gray-700 leading-relaxed">{{ $schedule->note }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-data="{ 
            showDeleteModal: false,
            eventId: null,
            eventTitle: '',
            isDeleting: false
        }" @open-delete-modal.window="
                showDeleteModal = true;
                eventId = $event.detail.id;
                eventTitle = $event.detail.title;
            " x-show="showDeleteModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">

        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" x-show="showDeleteModal"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="showDeleteModal = false">
        </div>

        <!-- Modal Panel -->
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div x-show="showDeleteModal" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all">

                <!-- Modal Content -->
                <div class="p-6">
                    <!-- Warning Icon -->
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-50 mb-6">
                        <i class='bx bx-error-circle text-3xl text-red-500'></i>
                    </div>

                    <div class="text-center">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            Delete Event
                        </h3>
                        <p class="text-sm text-gray-500 mb-6">
                            Are you sure you want to delete <span class="font-medium text-gray-900"
                                x-text="eventTitle"></span>? This action cannot be undone.
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" @click="showDeleteModal = false"
                            class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-800 bg-white hover:bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            Cancel
                        </button>
                        <button type="button" @click="isDeleting = true; $wire.deleteEvent(eventId)"
                            :disabled="isDeleting"
                            class="relative px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                            <span x-show="!isDeleting">Delete Event</span>
                            <span x-show="isDeleting" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Deleting...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: rgba(156, 163, 175, 0.5) transparent;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: rgba(156, 163, 175, 0.5);
            border-radius: 20px;
        }
    </style>

</div>