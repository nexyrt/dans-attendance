{{-- resources/views/livewire/calendar-component.blade.php --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Calendar Section (Takes up 2 columns on large screens) -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow">
        <!-- Calendar Header -->
        <div class="p-4 flex items-center justify-between border-b border-gray-200">
            <div class="flex items-center gap-4">
                <h2 class="text-lg font-semibold text-gray-900">{{ $this->currentMonth }}</h2>
                <div class="flex items-center gap-2">
                    <button wire:click="previousMonth" class="p-1.5 rounded-lg hover:bg-gray-100">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button wire:click="nextMonth" class="p-1.5 rounded-lg hover:bg-gray-100">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
            <button wire:click="goToToday"
                class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                Today
            </button>
        </div>

        <!-- Calendar Grid -->
        <div class="border-gray-200">
            <!-- Days header -->
            <div class="grid grid-cols-7 border-b border-gray-200">
                @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                    <div class="px-2 py-3 text-center">
                        <span class="text-xs font-medium text-gray-600">{{ $day }}</span>
                    </div>
                @endforeach
            </div>

            <!-- Calendar dates -->
            <div class="grid grid-cols-7">
                @foreach ($calendar as $week)
                    @foreach ($week as $day)
                        <div wire:click="selectDate('{{ $day['date'] }}')"
                            class="min-h-[100px] border-b border-r border-gray-200 relative group cursor-pointer
                                {{ $day['isSelected'] ? 'bg-blue-50' : 'hover:bg-gray-50' }}
                                {{ !$day['isCurrentMonth'] ? 'bg-gray-50/50' : '' }}">

                            <!-- Date number -->
                            <div class="p-2">
                                <span
                                    class="flex items-center justify-center w-6 h-6 text-sm
                                    {{ $day['isToday'] ? 'bg-blue-600 text-white rounded-full' : '' }}
                                    {{ !$day['isCurrentMonth'] ? 'text-gray-400' : 'text-gray-900' }}">
                                    {{ $day['day'] }}
                                </span>

                                <!-- Event indicators -->
                                @if (!empty($day['events']))
                                    <div class="mt-2 space-y-1">
                                        @foreach ($day['events'] as $event)
                                            <div
                                                class="text-xs px-1 py-0.5 rounded truncate
                                                {{ match ($event['type']) {
                                                    'schedule' => 'bg-blue-100 text-blue-700',
                                                    'holiday' => 'bg-green-100 text-green-700',
                                                    'leave' => 'bg-yellow-100 text-yellow-700',
                                                    'exception' => 'bg-purple-100 text-purple-700',
                                                    default => 'bg-gray-100 text-gray-700',
                                                } }}">
                                                {{ $event['title'] }}
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>

    <!-- Event Details Sidebar -->
    <div class="bg-white rounded-lg h-fit shadow p-6">
        @if ($selectedDate)
            <div class="space-y-6">
                <!-- Selected Date Header -->
                <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $formattedSelectedDate }}</h3>
                        <p class="text-sm text-gray-500 mt-0.5">{{ $selectedDayName }}</p>
                    </div>
                    @if ($todaySchedule)
                        <div class="px-3 py-1.5 bg-blue-50 rounded-lg text-xs font-medium text-blue-700">
                            Working Day
                        </div>
                    @endif
                </div>

                <!-- Events List -->
                @if (empty($selectedDateEvents))
                    <div class="text-center py-8">
                        <div class="w-12 h-12 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h4 class="text-sm font-medium text-gray-900">No Events Scheduled</h4>
                        <p class="text-sm text-gray-500 mt-1">Enjoy your free time!</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach ($selectedDateEvents as $event)
                            <div class="rounded-lg overflow-hidden">
                                <!-- Event Header -->
                                <div
                                    class="px-4 py-3 {{ match ($event['type']) {
                                        'schedule' => 'bg-blue-50',
                                        'holiday' => 'bg-green-50',
                                        'leave' => 'bg-yellow-50',
                                        'exception' => 'bg-purple-50',
                                        default => 'bg-gray-50',
                                    } }}">
                                    <div class="flex items-center justify-between">
                                        <span class="inline-flex items-center gap-1.5">
                                            <span
                                                class="h-2 w-2 rounded-full {{ match ($event['type']) {
                                                    'schedule' => 'bg-blue-500',
                                                    'holiday' => 'bg-green-500',
                                                    'leave' => 'bg-yellow-500',
                                                    'exception' => 'bg-purple-500',
                                                    default => 'bg-gray-500',
                                                } }}"></span>
                                            <span
                                                class="font-medium text-sm {{ match ($event['type']) {
                                                    'schedule' => 'text-blue-900',
                                                    'holiday' => 'text-green-900',
                                                    'leave' => 'text-yellow-900',
                                                    'exception' => 'text-purple-900',
                                                    default => 'text-gray-900',
                                                } }}">{{ $event['title'] }}</span>
                                        </span>
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ match ($event['type']) {
                                                'schedule' => 'bg-blue-100 text-blue-700',
                                                'holiday' => 'bg-green-100 text-green-700',
                                                'leave' => 'bg-yellow-100 text-yellow-700',
                                                'exception' => 'bg-purple-100 text-purple-700',
                                                default => 'bg-gray-100 text-gray-700',
                                            } }}">
                                            {{ str($event['type'])->headline() }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Event Details -->
                                <div class="px-4 py-3 bg-white border border-t-0 border-gray-100 rounded-b-lg">
                                    @if (isset($event['time']))
                                        <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>{{ $event['time'] }}</span>
                                        </div>
                                    @endif

                                    @if (isset($event['status']))
                                        <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>{{ str($event['status'])->headline() }}</span>
                                        </div>
                                    @endif

                                    @if (isset($event['note']))
                                        <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <span>{{ $event['note'] }}</span>
                                        </div>
                                    @endif

                                    @if (isset($event['description']))
                                        <div class="mt-2 text-sm text-gray-600">
                                            {{ $event['description'] }}
                                        </div>
                                    @endif

                                    @if ($event['type'] === 'leave' && isset($event['approved_by']))
                                        <div class="mt-3 pt-3 border-t border-gray-100">
                                            <div class="flex items-center gap-2">
                                                <div class="flex-shrink-0">
                                                    <img class="h-6 w-6 rounded-full"
                                                        src="{{ $event['approved_by']['image'] }}"
                                                        alt="{{ $event['approved_by']['name'] }}">
                                                </div>
                                                <div class="text-sm">
                                                    <p class="font-medium text-gray-900">
                                                        Approved by {{ $event['approved_by']['name'] }}
                                                    </p>
                                                    <p class="text-gray-500">
                                                        {{ $chronosDate::parse($event['approved_at'])->format('M j, Y \a\t H:i') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <!-- No Date Selected State -->
            <div class="text-center py-12">
                <div class="w-16 h-16 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-sm font-medium text-gray-900">No Date Selected</h3>
                <p class="text-sm text-gray-500 mt-1">Select a date to view events</p>
            </div>
        @endif
    </div>
</div>
