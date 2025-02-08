document.addEventListener('DOMContentLoaded', function() {
    const startInput = document.getElementById('datepicker-range-start');
    const endInput = document.getElementById('datepicker-range-end');

    if (startInput && endInput) {
        startInput.addEventListener('changeDate', function(e) {
            Livewire.dispatch('set-date', {
                name: 'start_date',
                value: this.value
            });
        });

        endInput.addEventListener('changeDate', function(e) {
            Livewire.dispatch('set-date', {
                name: 'end_date',
                value: this.value
            });
        });
    }
});