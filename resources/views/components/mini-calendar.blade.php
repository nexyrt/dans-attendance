<div class="bg-white rounded-lg shadow">
    {{-- Calendar Header --}}
    <div class="flex items-center justify-between px-6 py-4 border-b">
        <div class="flex items-center">
            <h2 class="text-lg font-semibold text-gray-900">
                {{ Carbon\Carbon::createFromDate($year, $month)->format('F Y') }}
            </h2>
        </div>
        <div class="flex space-x-2">
            <a href="?month={{ $month-1 }}&year={{ $month == 1 ? $year-1 : $year }}" 
               class="p-2 hover:bg-gray-100 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <a href="?month={{ $month+1 }}&year={{ $month == 12 ? $year+1 : $year }}"
               class="p-2 hover:bg-gray-100 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>

    {{-- Calendar Grid --}}
    <div class="p-4">
        {{-- Weekday headers --}}
        <div class="grid grid-cols-7 gap-px mb-2">
            @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                <div class="text-center text-sm font-medium text-gray-500 py-2">
                    {{ $day }}
                </div>
            @endforeach
        </div>

        {{-- Calendar days --}}
        <div class="border rounded-lg overflow-hidden bg-gray-100">
            @foreach($weeks as $week)
                <div class="grid grid-cols-7 gap-px">
                    @foreach($week as $day)
                        <div class="bg-white min-h-[80px] p-2 {{ is_null($day) ? 'bg-gray-50' : '' }}">
                            @if($day)
                                <div class="flex items-center justify-between">
                                    <span class="text-sm {{ Carbon\Carbon::createFromDate($year, $month, $day)->isToday() ? 'bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center' : '' }}">
                                        {{ $day }}
                                    </span>
                                    @php
                                        $currentDate = Carbon\Carbon::createFromDate($year, $month, $day)->format('Y-m-d');
                                    @endphp
                                    @if(isset($events[$currentDate]))
                                        <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                    @endif
                                </div>
                                {{-- Event indicators --}}
                                @if(isset($events[$currentDate]))
                                    <div class="mt-1">
                                        @foreach($events[$currentDate] as $event)
                                            <div class="text-xs truncate rounded bg-blue-50 text-blue-600 px-1 py-0.5 mb-0.5">
                                                {{ $event['title'] }}
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @endif
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>