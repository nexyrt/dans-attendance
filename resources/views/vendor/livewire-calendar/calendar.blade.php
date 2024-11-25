<div
    @if ($pollMillis !== null && $pollAction !== null) wire:poll.{{ $pollMillis }}ms="{{ $pollAction }}"
    @elseif($pollMillis !== null)
        wire:poll.{{ $pollMillis }}ms @endif>
  
    <div class="w-full">
        <div>
            <div>
                @includeIf($beforeCalendarView)
            </div>


            <div class="overflow-x-auto">
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


    <div x-cloak x-show="showModal" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50"
        @click="showModal = false">

        <div class="flex items-center justify-center min-h-screen p-4">
            <form wire:submit.prevent="update"
                class="w-full max-w-md mx-auto text-left transition-all transform bg-white shadow-lg rounded-lg"
                @click.stop>

                <!-- Modal Header -->
                <div class="flex items-center justify-between px-6 py-4 border-b">
                    <h3 class="text-xl font-medium text-gray-900">
                        Edit Event
                    </h3>
                    <button @click="showModal = false" class="p-2 hover:bg-gray-100 rounded-full">
                        <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-4 text-sm">

                    <!-- Title Section -->
                    <div class="flex items-center space-x-4 py-3">
                        <div class="text-lg text-gray-400 w-5">T</div>
                        <input type="text" wire:model = "title"
                            class="flex-1 border-0 p-2 text-sm rounded focus:ring-0 focus:border-0 placeholder-gray-400 focus:bg-gray-100 transition-colors"
                            placeholder="Add title" :value="schedule ? schedule.title : ''">
                    </div>

                    <!-- Time Section -->
                    <div class="flex items-start justify-start space-x-4 py-3 border-t">
                        <div class="pt-1.5 w-5">
                            <i class='bx bx-time text-lg text-gray-400'></i>
                        </div>
                        <div class="flex-1 space-y-2">
                            <div class="flex items-center space-x-2" x-data="{
                                times: Array.from({ length: 96 }, (_, i) => {
                                    const hour = Math.floor(i / 4);
                                    const minute = (i % 4) * 15;
                                    const value = `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
                                    const displayHour = hour === 0 ? 12 : hour > 12 ? hour - 12 : hour;
                                    const ampm = hour < 12 ? 'AM' : 'PM';
                                    return {
                                        value,
                                        display: `${displayHour}:${minute.toString().padStart(2, '0')} ${ampm}`
                                    };
                                }),
                                startOpen: false,
                                endOpen: false,
                                selectedStart: '', // Default to empty
                                selectedEnd: '', // Default to empty
                                schedule, // Assuming `schedule` is passed to Alpine
                                init() {
                                    // Set initial values from schedule
                                    this.selectedStart = schedule?.start_time || '09:00';
                                    this.selectedEnd = schedule?.end_time || '10:00';
                            
                                    // Sync with Livewire
                                    $wire.set('start_time', this.selectedStart);
                                    $wire.set('end_time', this.selectedEnd);
                                },
                                getDisplayTime(value) {
                                    return this.times.find(t => t.value === value)?.display || value;
                                }
                            }">
                                <!-- Start Time Dropdown -->
                                <div class="relative flex-1">
                                    <button @click="startOpen = !startOpen; endOpen = false" type="button"
                                        class="w-full flex items-center px-3 py-2.5 text-xs border-gray-300 rounded hover:bg-gray-50 focus:border-blue-500 focus:ring-0">
                                        <span
                                            x-text="times.find(t => t.value === $wire.start_time)?.display || '9:00 AM'"></span>
                                        <i class='bx bx-chevron-down text-gray-400 ml-auto'></i>
                                    </button>

                                    <div x-show="startOpen" @click.away="startOpen = false"
                                        class="absolute z-50 mt-1 w-full bg-white rounded-md shadow-lg border border-gray-200">
                                        <div class="max-h-60 overflow-y-auto">
                                            <div class="py-1">
                                                <template x-for="time in times" :key="time.value">
                                                    <button type="button"
                                                        @click="$wire.set('start_time', time.value); startOpen = false"
                                                        class="w-full px-3 py-1.5 text-xs text-left hover:bg-gray-100 flex items-center space-x-2"
                                                        :class="{ 'bg-blue-50': $wire.start_time === time.value }">
                                                        <span x-text="time.display"></span>
                                                        <i class='bx bx-check text-blue-500 ml-auto'
                                                            x-show="$wire.start_time === time.value"></i>
                                                    </button>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <span class="text-gray-400 text-xs">–</span>

                                <!-- End Time Dropdown -->
                                <div class="relative flex-1">
                                    <button @click="endOpen = !endOpen; startOpen = false" type="button"
                                        class="w-full flex items-center px-3 py-2.5 text-xs border-gray-300 rounded hover:bg-gray-50 focus:border-blue-500 focus:ring-0">
                                        <span x-text="getDisplayTime(selectedEnd)"></span>
                                        <i class='bx bx-chevron-down text-gray-400 ml-auto'></i>
                                    </button>

                                    <div x-show="endOpen" x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        @click.away="endOpen = false"
                                        class="absolute z-50 mt-1 w-full bg-white rounded-md shadow-lg border border-gray-200">
                                        <div
                                            class="max-h-60 overflow-y-auto overscroll-contain scrollbar-thin scrollbar-thumb-gray-200 scrollbar-track-gray-50">
                                            <div class="py-1">
                                                <template x-for="time in times" :key="time.value">
                                                    <button type="button"
                                                        @click="selectedEnd = time.value; endOpen = false; $wire.set('end_time', time.value)"
                                                        class="w-full px-3 py-1.5 text-xs text-left hover:bg-gray-100 flex items-center space-x-2"
                                                        :class="{ 'bg-blue-50': selectedEnd === time.value }">
                                                        <span x-text="time.display"></span>
                                                        <i class='bx bx-check text-blue-500 ml-auto'
                                                            x-show="selectedEnd === time.value"></i>
                                                    </button>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Date Section -->
                    <div class="flex items-start justify-start space-x-4 py-3">
                        <div class="pt-1.5 w-5">
                            <i class='bx bx-calendar text-lg text-gray-400'></i>
                        </div>
                        <input type="date" wire:model="selectedDate"
                            class="w-full border-0 px-3 py-2.5 text-xs rounded hover:bg-gray-50 focus:bg-gray-50 focus:ring-0 cursor-pointer">
                    </div>

                    <!-- Department Section -->
                    <div class="flex items-start justify-start space-x-4 py-3 border-t">
                        <div class="pt-1.5 w-5">
                            <i class='bx bx-building text-lg text-gray-400'></i>
                        </div>
                        <select wire:model.defer="department"
                            class="text-xs mt-2 flex-1 border-0 p-2 rounded focus:ring-0 focus:border-0 placeholder-gray-400 hover:bg-gray-100 focus:bg-gray-100 transition-colors">
                            <option value="">Select department</option>
                            
                            @foreach ($departments as $dept)
                                <option value="{{ $dept->name }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="flex items-start justify-start space-x-4 py-3 border-t">
                        <div class="pt-1.5 w-5">
                            <i class='bx bx-building text-lg text-gray-400'></i>
                        </div>
                        <select wire:model="status"
                            class="text-xs mt-2 flex-1 border-0 p-2 rounded focus:ring-0 focus:border-0 placeholder-gray-400 hover:bg-gray-100 focus:bg-gray-100 transition-colors">
                            <option value="regular">Regular</option>
                            <option value="wfh">WFH</option>
                            <option value="halfday">Halfday</option>
                        </select>
                    </div>

                    <!-- Description Section -->
                    <div class="flex items-start justify-start space-x-4 py-3 border-t">
                        <div class="pt-1.5 w-5">
                            <i class='bx bx-align-left text-lg text-gray-400'></i>
                        </div>
                        <textarea wire:model="description"
                            class="flex-1 border-0 p-1.5 text-sm rounded focus:ring-0 focus:border-0 placeholder-gray-400 focus:bg-gray-100 transition-colors"
                            rows="3" placeholder="Add description"></textarea>
                    </div> 
                </div>


                <!-- Modal Footer -->
                <div class="px-6 py-3 bg-gray-50 rounded-b-lg flex justify-end space-x-2">
                    <button type="button" @click="showModal = false"
                        class="px-4 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-1.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded shadow-sm">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
