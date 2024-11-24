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
                                <input type="text" x-ref="title" :value="schedule?.title"
                                    class="flex-1 border-0 p-1 text-base rounded focus:ring-0 focus:border-0 placeholder-gray-400 focus:bg-gray-100 transition-colors"
                                    placeholder="Add title">
                            </div>

                            <!-- Time Section -->
                            <div class="flex items-start space-x-4 py-3 border-t">
                                <div class="pt-1.5 w-5">
                                    <i class='bx bx-time text-lg text-gray-400'></i>
                                </div>
                                <div class="flex-1 space-y-2">
                                    <!-- Time Inputs -->
                                    <div class="flex items-center space-x-2">
                                        <div class="relative">
                                            <input type="time" x-ref="start_time" :value="schedule?.start_time"
                                                class="pl-2 pr-7 py-1 text-sm border border-gray-300 rounded hover:border-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                            <button class="absolute right-1.5 top-1/2 -translate-y-1/2 text-gray-400"
                                                type="button">
                                                <i class='bx bx-chevron-down text-lg'></i>
                                            </button>
                                        </div>
                                        <span class="text-gray-600">–</span>
                                        <div class="relative">
                                            <input type="time" x-ref="end_time" :value="schedule?.end_time"
                                                class="pl-2 pr-7 py-1 text-sm border border-gray-300 rounded hover:border-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                            <button class="absolute right-1.5 top-1/2 -translate-y-1/2 text-gray-400"
                                                type="button">
                                                <i class='bx bx-chevron-down text-lg'></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Date Input -->
                                    <div class="relative">
                                        <input type="date" x-ref="date" :value="schedule?.date"
                                            class="pl-2 pr-7 py-1 text-sm border border-gray-300 rounded hover:border-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                        <button class="absolute right-1.5 top-1/2 -translate-y-1/2 text-gray-400"
                                            type="button">
                                            <i class='bx bx-calendar text-lg'></i>
                                        </button>
                                    </div>

                                    <!-- Options -->
                                    <div class="flex items-center justify-between">
                                        <label class="flex items-center">
                                            <div class="relative inline-block w-7 h-4">
                                                <input type="checkbox" class="hidden peer">
                                                <div
                                                    class="absolute cursor-pointer inset-0 bg-gray-300 peer-checked:bg-blue-500 rounded-full transition-colors before:content-[''] before:absolute before:w-3 before:h-3 before:bg-white before:rounded-full before:top-0.5 before:left-0.5 before:transition-transform peer-checked:before:translate-x-3">
                                                </div>
                                            </div>
                                            <span class="text-sm text-gray-600 ml-2">All-Day</span>
                                        </label>
                                        <button type="button" class="text-sm text-gray-600 hover:text-gray-800">Do not
                                            repeat</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Department Section -->
                            <div class="flex items-start space-x-4 py-3 border-t">
                                <div class="pt-1.5 w-5">
                                    <i class='bx bx-map text-lg text-gray-400'></i>
                                </div>
                                <div class="relative flex-1">
                                    <select x-ref="department" :value="schedule?.department"
                                        class="w-full pl-2 pr-8 py-1 text-sm border border-gray-300 rounded hover:border-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 bg-white appearance-none">
                                        <option value="" disabled selected>Select department</option>
                                        <option value="it">IT Department</option>
                                        <option value="hr">HR Department</option>
                                        <option value="finance">Finance Department</option>
                                    </select>
                                    <div
                                        class="absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                                        <i class='bx bx-chevron-down text-lg'></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Description Section -->
                            <div class="flex items-start space-x-4 py-3 border-t">
                                <div class="pt-1.5 w-5">
                                    <i class='bx bx-align-left text-lg text-gray-400'></i>
                                </div>
                                <textarea x-ref="description" x-text="schedule?.description"
                                    class="flex-1 pl-2 pr-2 py-1 text-sm border border-gray-300 rounded hover:border-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 min-h-[60px] resize-none"
                                    placeholder="Add description"></textarea>
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
