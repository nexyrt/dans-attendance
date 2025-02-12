{{-- resources/views/livewire/date-range-picker.blade.php --}}
<div class="relative" x-data="{ open: @entangle('isOpen') }">
    {{-- Trigger Button --}}
    <button type="button" @click="open = !open"
        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        <svg class="mr-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        {{ $this->formattedDateRange }}
    </button>

    {{-- Calendar Dropdown --}}
    <div x-show="open" @click.away="open = false"
        class="absolute mt-2 w-80 bg-white border shadow-lg rounded-xl overflow-hidden dark:bg-neutral-900 dark:border-neutral-700 z-99"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95">
        
        <div class="p-3 space-y-0.5">
            {{-- Month/Year Navigation --}}
            <div class="grid grid-cols-5 items-center gap-x-3 mx-1.5 pb-3">
                {{-- Previous Month Button --}}
                <div class="col-span-1">
                    <button wire:click="previousMonth" type="button"
                        class="size-8 flex justify-center items-center text-gray-800 hover:bg-gray-100 rounded-full focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-800">
                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                </div>

                {{-- Month/Year Selectors --}}
                <div class="col-span-3 flex justify-center items-center gap-x-1">
                    <select wire:model.live="currentMonth"
                        class="form-select py-0.5 pl-2 pr-8 border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md text-sm dark:bg-neutral-800 dark:border-neutral-600 dark:text-neutral-200">
                        @foreach($months as $month)
                            <option value="{{ $month['value'] }}">{{ $month['label'] }}</option>
                        @endforeach
                    </select>

                    <span class="text-gray-800 dark:text-neutral-200">/</span>

                    <select wire:model.live="currentYear"
                        class="form-select py-0.5 pl-2 pr-8 border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md text-sm dark:bg-neutral-800 dark:border-neutral-600 dark:text-neutral-200">
                        @foreach($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Next Month Button --}}
                <div class="col-span-1 flex justify-end">
                    <button wire:click="nextMonth" type="button"
                        class="size-8 flex justify-center items-center text-gray-800 hover:bg-gray-100 rounded-full focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-800">
                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Weekday Headers --}}
            <div class="flex pb-1.5">
                @foreach(['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'] as $day)
                    <span class="m-px w-10 block text-center text-sm text-gray-500 dark:text-neutral-500">
                        {{ $day }}
                    </span>
                @endforeach
            </div>

            {{-- Calendar Grid --}}
            @foreach($calendar as $week)
                <div class="flex">
                    @foreach($week as $day)
                        <div @class([
                            'bg-gray-100 dark:bg-neutral-800' => $day['isSelected'],
                            'first:rounded-s-full' => $loop->first && $day['isSelected'],
                            'last:rounded-e-full' => $loop->last && $day['isSelected'],
                        ])>
                            <button 
                                wire:click="selectDate('{{ $day['date'] }}')"
                                type="button"
                                @class([
                                    'm-px size-10 flex justify-center items-center border border-transparent text-sm rounded-full focus:outline-none',
                                    'bg-blue-600 text-white font-medium' => $day['isStart'] || $day['isEnd'],
                                    'text-gray-800 dark:text-neutral-200' => !$day['isSelected'] || ($day['isSelected'] && !$day['isStart'] && !$day['isEnd']),
                                    'hover:border-blue-600 hover:text-blue-600' => $day['isCurrentMonth'],
                                    'opacity-50 pointer-events-none' => !$day['isCurrentMonth'],
                                    'ring-2 ring-blue-600' => $day['isToday'],
                                ])
                            >
                                {{ $day['day'] }}
                            </button>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        {{-- Footer Buttons --}}
        <div class="py-3 px-4 flex items-center justify-end gap-x-2 border-t border-gray-200 dark:border-neutral-700">
            <button 
                @click="open = false"
                type="button"
                class="py-2 px-3 inline-flex items-center gap-x-2 text-xs font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700"
            >
                Cancel
            </button>
            <button 
                wire:click="applyDates"
                type="button"
                class="py-2 px-3 inline-flex justify-center items-center gap-x-2 text-xs font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                Apply
            </button>
        </div>
    </div>
</div>