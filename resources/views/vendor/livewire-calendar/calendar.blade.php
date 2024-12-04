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
                                            <div
                                                class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
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
                                        <div x-data="countdown('{{ \Carbon\Carbon::parse($event['date'])->format('Y-m-d') }} {{ \Carbon\Carbon::parse($event['end_time'])->format('H:i:s') }}')" x-init="init()">
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
                                                <div
                                                    class="w-10 h-10 rounded-lg bg-gray-200 flex items-center justify-center">
                                                    <i
                                                        class="bx {{ $event['status'] === 'Regular' ? 'bx-calendar' : 'bx-calendar-star' }} text-xl text-gray-600"></i>
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h5 class="font-medium text-gray-900 mb-1">{{ $event['title'] }}</h5>
                                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                                    <i class='bx bx-time'></i>
                                                    <span>{{ \Carbon\Carbon::parse($event['start_time'])->format('H:i') }}</span>
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
                                            <div
                                                class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center">
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

            <div class="bg-white rounded-xl shadow-sm">
                <div x-data="{ hasEvent: false }" x-on:schedule-selected.window="hasEvent = true">
                    <!-- Default State -->
                    <div x-show="!hasEvent" class="text-center p-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-50 rounded-full mb-4">
                            <i class='bx bx-calendar-plus text-2xl text-blue-500'></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Event Selected</h3>
                        <p class="text-sm text-gray-500">Click on an event to view its details</p>
                    </div>
            
                    <!-- Event Details -->
                    @if ($schedule)
                        <div x-show="hasEvent">
                            <!-- Header Section -->
                            <div class="bg-blue-600 rounded-t-xl p-6 text-white">
                                <div class="mb-4">
                                    <h2 class="text-2xl font-semibold mb-2">{{ $schedule->title }}</h2>
                                    <div class="flex items-center gap-2 text-blue-100">
                                        <i class='bx bx-calendar text-xl'></i>
                                        <span>{{ $schedule->date->format('d M Y') }}</span>
                                    </div>
                                </div>
            
                                @php
                                    $now = now();
                                    $startTime = $schedule->date->setTimeFrom($schedule->start_time);
                                    $endTime = $schedule->date->setTimeFrom($schedule->end_time);
                                    
                                    if ($now->lt($startTime)) {
                                        $status = 'upcoming';
                                        $statusIcon = 'bx-time-five';
                                    } elseif ($now->between($startTime, $endTime)) {
                                        $status = 'ongoing';
                                        $statusIcon = 'bx-broadcast';
                                    } else {
                                        $status = 'completed';
                                        $statusIcon = 'bx-check-circle';
                                    }
                                @endphp
            
                                <div class="flex items-center gap-2">
                                    <div class="flex items-center gap-1 bg-white/20 px-3 py-1 rounded-full text-sm">
                                        <i class='bx {{ $statusIcon }} {{ $status === 'ongoing' ? 'animate-pulse' : '' }}'></i>
                                        <span class="capitalize">{{ $status }}</span>
                                    </div>
                                </div>
                            </div>
            
                            <div class="p-6 space-y-5">
                                <!-- Schedule Time -->
                                <div class="bg-blue-50 rounded-xl p-4">
                                    <h3 class="text-sm font-medium text-blue-600 mb-2">Schedule Time</h3>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2 text-gray-900">
                                            <i class='bx bx-time text-blue-500'></i>
                                            <span class="font-medium">
                                                {{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}
                                            </span>
                                        </div>
                                        <span class="text-sm text-blue-600">{{ $schedule->status }}</span>
                                    </div>
                                </div>
            
                                <!-- Department -->
                                @if($schedule->department)
                                    <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl">
                                        <i class='bx bx-buildings text-xl text-gray-500'></i>
                                        <div>
                                            <h3 class="text-sm font-medium text-gray-600">Department</h3>
                                            <p class="text-gray-900">{{ $schedule->department->name }}</p>
                                        </div>
                                    </div>
                                @endif
            
                                <!-- Description -->
                                @if($schedule->note)
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-600 mb-2">Description</h3>
                                        <div class="bg-gray-50 rounded-xl p-4">
                                            <p class="text-gray-700">{{ $schedule->note }}</p>
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
