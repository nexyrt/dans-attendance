export default function datePicker(modelValue, configs = {}) {
    return {
        value: modelValue,
        instance: null,
        defaultConfigs: {
            dateFormat: 'Y-m-d',
            altFormat: 'F j, Y',
            altInput: true,
            disableMobile: true,
            monthSelectorType: 'static',
            yearSelectorType: 'static',
            showMonths: 1,
            prevArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M5.4 10.8l1.4-1.4-4-4 4-4L5.4 0 0 5.4z" /></svg>',
            nextArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M1.4 10.8L0 9.4l4-4-4-4L1.4 0l5.4 5.4z" /></svg>',
        },

        init() {
            // Merge default configs with provided configs
            const mergedConfigs = {
                ...this.defaultConfigs,
                ...configs,
                onChange: (selectedDates, dateStr) => {
                    this.value = dateStr;
                    this.$dispatch('datepicker-change', { date: dateStr });
                },
            };

            // Initialize flatpickr
            this.instance = flatpickr(this.$refs.input, mergedConfigs);

            // Set initial value if exists
            if (this.value) {
                this.instance.setDate(this.value);
            }

            // Cleanup on component destroy
            this.$watch('value', (value) => {
                if (this.instance.selectedDates[0]?.toISOString().split('T')[0] !== value) {
                    this.instance.setDate(value);
                }
            });

            this.$cleanup = () => this.instance.destroy();
        }
    };
}