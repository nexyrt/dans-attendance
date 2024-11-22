<x-layouts.admin>
    <div class="flex w-full gap-4" x-data="{
        schedule: null,
        handleScheduleSelect(event) {
            this.schedule = event.detail;
            $wire.handleScheduleUpdate(event.detail);
        }
    }" @schedule-selected.window="handleScheduleSelect($event)">
        <div class="basis-3/4">
            <livewire:admin.schedules.schedule-calendar 
                before-calendar-view="calendar/before-calendar-view" 
            />
        </div>
        <div class="basis-1/4 border shadow-md bg-white rounded-md h-max p-4">
            <!-- Schedule Detail Panel -->
            <template x-if="schedule">
                <div>
                    <h3 class="text-lg font-semibold mb-2" x-text="schedule.title"></h3>
                    <div class="space-y-2">
                        <p>
                            <span class="font-medium">Date:</span>
                            <span x-text="schedule.date"></span>
                        </p>
                        <p>
                            <span class="font-medium">Start:</span>
                            <span x-text="schedule.start_time || 'N/A'"></span>
                        </p>
                        <p>
                            <span class="font-medium">End:</span>
                            <span x-text="schedule.end_time || 'N/A'"></span>
                        </p>
                        <p>
                            <span class="font-medium">Department:</span>
                            <span x-text="schedule.department"></span>
                        </p>
                        <template x-if="schedule.description">
                            <p>
                                <span class="font-medium">Notes:</span>
                                <span x-text="schedule.description"></span>
                            </p>
                        </template>

                        <!-- Action Buttons -->
                        <div class="mt-4 space-x-2">
                            <button 
                                class="px-3 py-1.5 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                                @click="$dispatch('open-edit-modal', schedule)"
                            >
                                Edit
                            </button>
                            <button 
                                class="px-3 py-1.5 bg-red-600 text-white rounded-md hover:bg-red-700"
                                @click="$wire.deleteSchedule(schedule.id)"
                            >
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </template>
            <template x-if="!schedule">
                <p class="text-gray-500">Select a schedule to view details</p>
            </template>
        </div>
    </div>
</x-layouts.admin>