<div
    @if ($pollMillis !== null && $pollAction !== null) wire:poll.{{ $pollMillis }}ms="{{ $pollAction }}"
    @elseif($pollMillis !== null)
        wire:poll.{{ $pollMillis }}ms @endif>

    <div class="flex">
        <div>
            <div>
                @includeIf($beforeCalendarView)
            </div>


            <div class="overflow-x-auto w-full">
                <div class="inline-block min-w-full">
                    <div class="grid grid-cols-7 gap-0">
                        <!-- Days of Week Headers -->
                        @foreach ($monthGrid->first() as $day)
                            @include($dayOfWeekView, ['day' => $day])
                        @endforeach

                        <!-- Calendar Days -->
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
