{{-- resources/views/livewire/calendar-component.blade.php --}}
<div class="bg-white rounded-lg shadow">
    <!-- Calendar Header -->
    <div class="p-4 flex items-center justify-between">
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
    </div>

    <!-- Calendar Grid -->
    <div class="border-t border-gray-200">
        <!-- Days header -->
        <div class="grid grid-cols-7 text-center text-xs leading-6 text-gray-500">
            @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                <div class="py-2">{{ $day }}</div>
            @endforeach
        </div>

        <!-- Calendar dates -->
        <div class="grid grid-cols-7 text-sm">
            @foreach ($calendar as $week)
                @foreach ($week as $day)
                    <div wire:click="selectDate('{{ $day['date'] }}')"
                        class="relative py-2 px-3 hover:bg-gray-50 cursor-pointer {{ $day['isSelected'] ? 'bg-blue-50' : '' }} 
                                {{ !$day['isCurrentMonth'] ? 'text-gray-400' : '' }}">

                        <!-- Date number -->
                        <div class="flex items-center justify-center">
                            <span
                                class="{{ $day['isToday'] ? 'bg-blue-600 text-white rounded-full w-7 h-7 flex items-center justify-center' : '' }}">
                                {{ $day['day'] }}
                            </span>
                        </div>

                        <!-- Event indicators -->
                        @if (!empty($day['events']))
                            <div class="flex mt-1 justify-center gap-1">
                                @foreach ($day['events'] as $event)
                                    <div
                                        class="h-1.5 w-1.5 rounded-full 
                                        {{ match ($event['type']) {
                                            'schedule' => 'bg-blue-600',
                                            'holiday' => 'bg-green-600',
                                            'leave' => 'bg-yellow-600',
                                            'exception' => 'bg-purple-600',
                                            default => 'bg-gray-600',
                                        } }}">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>

    <!-- Selected Date Events -->
    @if ($selectedDate)
        <div class="border-t border-gray-200 p-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">{{ $formattedSelectedDate }}</h3>
                <span class="text-sm text-gray-500">{{ $selectedDayName }}</span>
            </div>

            @if (empty($selectedDateEvents))
                <p class="text-sm text-gray-500 text-center py-4">No events scheduled for this day</p>
            @else
                <div class="space-y-3">
                    @foreach ($selectedDateEvents as $event)
                        <div
                            class="p-3 rounded-lg {{ match ($event['type']) {
                                'schedule' => 'bg-blue-50',
                                'holiday' => 'bg-green-50',
                                'leave' => 'bg-yellow-50',
                                'exception' => 'bg-purple-50',
                                default => 'bg-gray-50',
                            } }}">
                            <div class="flex items-center justify-between">
                                <span class="font-medium">{{ $event['title'] }}</span>
                                @if (isset($event['time']))
                                    <span class="text-sm text-gray-600">{{ $event['time'] }}</span>
                                @endif
                            </div>
                            @if (isset($event['description']))
                                <p class="text-sm text-gray-600 mt-1">{{ $event['description'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif
</div>
