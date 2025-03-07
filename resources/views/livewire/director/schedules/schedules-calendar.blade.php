<div class="max-w-6xl mx-auto py-6" x-data="{
    schedule: null,
    showModal: false,
    handleScheduleSelect(event) {
        // Store the data
        this.schedule = event.detail[0];
        Livewire.dispatch('handle-schedule-update', { data: event.detail });
        this.showModal = true;
    },
    handleCreate() {
        Livewire.dispatch('open-create-modal');
        this.showModal = true;
    }
}" @schedule-selected.window="handleScheduleSelect($event)"
    @create-schedule.window="handleCreate()">
    <div class="w-full">
        <livewire:admin.schedules.schedule-calendar before-calendar-view="calendar/before-calendar-view" />
    </div>
</div>