<x-layouts.admin>
    <div class="flex w-full gap-4" x-data="{
        schedule: null,
        updateSchedule(data) {
            this.schedule = data;
            $wire.handleScheduleUpdate(data);
        }
    }">
        <div class="basis-3/4">
            <livewire:admin.schedules.schedule-calendar {{-- day-view="calendar/event-view" --}}
                before-calendar-view="calendar/before-calendar-view" />
        </div>
        <div class="basis-1/4 w-full border shadow-md bg-white rounded-md h-max">
            {{-- {{ $this->schedule }} --}}
        </div>
    </div>

</x-layouts.admin>
