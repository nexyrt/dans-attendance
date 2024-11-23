<x-layouts.admin>
    <div class="flex w-full gap-4" x-data="{
        schedule: null,
        handleScheduleSelect(event) {
            this.schedule = event.detail;
            $wire.handleScheduleUpdate(event.detail);
        }
    }" @schedule-selected.window="handleScheduleSelect($event)">
        <div class="basis-1 w-full">
            <livewire:admin.schedules.schedule-calendar 
                before-calendar-view="calendar/before-calendar-view"
            />
        </div>
        
    </div>
</x-layouts.admin>