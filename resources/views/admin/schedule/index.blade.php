<x-layouts.admin>
    <div class="" x-data="{
        schedule: null,
        handleScheduleSelect(event) {
            this.schedule = event.detail;
            $wire.handleScheduleUpdate(event.detail);
        }
    }" @schedule-selected.window="handleScheduleSelect($event)">
        <div class="">
            <livewire:admin.schedules.schedule-calendar 
                before-calendar-view="calendar/before-calendar-view"
            />
        </div>
        
    </div>
</x-layouts.admin>