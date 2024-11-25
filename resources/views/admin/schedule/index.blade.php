<x-layouts.admin>
    <div class="" x-data="{
        schedule: null,
        showModal: false,
        handleScheduleSelect(event) {
            this.schedule = event.detail;
            Livewire.dispatch('handle-schedule-update', { data: event.detail });
            this.showModal = true; // Open modal when schedule is selected
        }
    }" @schedule-selected.window="handleScheduleSelect($event)">
        <div class="">
            <livewire:admin.schedules.schedule-calendar before-calendar-view="calendar/before-calendar-view" />
        </div>

        <div x-show="showModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50" @click="showModal = false">

            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="w-full max-w-xl mx-auto text-left transition-all transform bg-white shadow-lg rounded-lg"
                    @click.stop>

                    <!-- Modal Header -->
                    <div class="flex items-center justify-between px-6 py-4 border-b">
                        <h3 class="text-xl font-medium text-gray-900">
                            Edit event
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
                        <form @submit.prevent="">
                            <!-- Title Section -->
                            <div class="flex items-center space-x-4 py-3">
                                <div class="text-lg text-gray-400 w-5">T</div>
                                <input type="text" x-ref="title" :value="schedule?title"
                                    class="flex-1 border-0 p-1.5 text-sm rounded focus:ring-0 focus:border-0 placeholder-gray-400 focus:bg-gray-100 transition-colors"
                                    placeholder="Add title">
                            </div>

                            <!-- Time Section -->
                            <div class="flex items-start space-x-4 py-3 border-t">
                                <div class="pt-1.5 w-5">
                                    <i class='bx bx-time text-lg text-gray-400'></i>
                                </div>
                                <div class="flex-1 space-y-2">
                                    <!-- Time Inputs -->
                                    <div class="flex items-center space-x-2" x-data="{
                                        times: Array.from({ length: 96 }, (_, i) => {
                                            const hour = Math.floor(i / 4);
                                            const minute = (i % 4) * 15;
                                            const value = `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
                                            const displayHour = hour === 0 ? 12 : hour > 12 ? hour - 12 : hour;
                                            const ampm = hour < 12 ? 'AM' : 'PM';
                                            return {
                                                value,
                                                display: `${displayHour}:${minute.toString().padStart(2, '0')}${ampm}`
                                            };
                                        }),
                                        startOpen: false,
                                        endOpen: false,
                                        selectedStart: '09:00',
                                        selectedEnd: '10:00',
                                        getDisplayTime(value) {
                                            return this.times.find(t => t.value === value)?.display || value;
                                        }
                                    }">
                                        <!-- Start Time Dropdown -->
                                        <div class="relative flex-1">
                                            <button @click="startOpen = !startOpen; endOpen = false" type="button"
                                                class="w-full flex items-center px-3 py-2.5 text-xs  border-gray-300 rounded hover:bg-gray-50 focus:border-blue-500 focus:ring-0">
                                                <span x-text="getDisplayTime(selectedStart)"></span>
                                                <i class='bx bx-chevron-down text-gray-400 ml-auto'></i>
                                            </button>

                                            <!-- Dropdown Panel -->
                                            <div x-show="startOpen"
                                                x-transition:enter="transition ease-out duration-100"
                                                x-transition:enter-start="transform opacity-0 scale-95"
                                                x-transition:enter-end="transform opacity-100 scale-100"
                                                x-transition:leave="transition ease-in duration-75"
                                                x-transition:leave-start="transform opacity-100 scale-100"
                                                x-transition:leave-end="transform opacity-0 scale-95"
                                                @click.away="startOpen = false"
                                                class="absolute z-50 mt-1 w-full bg-white rounded-md shadow-lg border border-gray-200">
                                                <div
                                                    class="max-h-60 overflow-y-auto overscroll-contain scrollbar-thin scrollbar-thumb-gray-200 scrollbar-track-gray-50">
                                                    <div class="py-1">
                                                        <template x-for="time in times" :key="time.value">
                                                            <button type="button"
                                                                @click="selectedStart = time.value; startOpen = false"
                                                                class="w-full px-3 py-1.5 text-xs text-left hover:bg-gray-100 flex items-center space-x-2"
                                                                :class="{ 'bg-blue-50': selectedStart === time.value }">
                                                                <span x-text="time.display"></span>
                                                                <i class='bx bx-check text-blue-500 ml-auto'
                                                                    x-show="selectedStart === time.value"></i>
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
                                                class="w-full flex items-center px-3 py-1 text-xs border border-gray-300 rounded hover:bg-gray-50 focus:border-blue-500 focus:ring-0">
                                                <span x-text="getDisplayTime(selectedEnd)"></span>
                                                <i class='bx bx-chevron-down text-gray-400 ml-auto'></i>
                                            </button>

                                            <!-- Dropdown Panel -->
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
                                                                @click="selectedEnd = time.value; endOpen = false"
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
                        </form>
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
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
