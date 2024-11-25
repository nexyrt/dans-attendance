@props(['startDateProp' => null, 'endDateProp' => null])

<div x-data="{
    startDate: null,
    endDate: null,
    isOpen: false,
    selectedMonth: new Date().getMonth(),
    selectedYear: new Date().getFullYear(),
    days: [],
    isSelecting: false,
    
    init() {
        this.generateCalendar();
        
        // Inisialisasi tanggal dari prop jika ada
        if('{{ $startDateProp }}') {
            this.startDate = '{{ $startDateProp }}';
        }
        if('{{ $endDateProp }}') {
            this.endDate = '{{ $endDateProp }}';
        }
    },
    
    generateCalendar() {
        const firstDay = new Date(this.selectedYear, this.selectedMonth, 1).getDay();
        const daysInMonth = new Date(this.selectedYear, this.selectedMonth + 1, 0).getDate();
        
        this.days = [];
        
        // Add empty days for padding
        for(let i = 0; i < firstDay; i++) {
            this.days.push(null);
        }
        
        // Add actual days
        for(let i = 1; i <= daysInMonth; i++) {
            this.days.push(i);
        }
    },
    
    formatDate(date) {
        if(!date) return '';
        return new Date(date).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    },
    
    isDateInRange(day) {
        if(!day || !this.startDate || !this.endDate) return false;
        
        const currentDate = new Date(this.selectedYear, this.selectedMonth, day);
        const start = new Date(this.startDate);
        const end = new Date(this.endDate);
        
        return currentDate >= start && currentDate <= end;
    },
    
    selectDate(day) {
        if(!day) return;
        
        const selectedDate = new Date(this.selectedYear, this.selectedMonth, day);
        const formattedDate = selectedDate.toISOString().split('T')[0];
        
        if(!this.startDate || (this.startDate && this.endDate)) {
            this.startDate = formattedDate;
            this.endDate = null;
            $wire.set('startDate', formattedDate);
        } else {
            if(selectedDate < new Date(this.startDate)) {
                this.endDate = this.startDate;
                this.startDate = formattedDate;
            } else {
                this.endDate = formattedDate;
            }
            $wire.set('startDate', this.startDate);
            $wire.set('endDate', this.endDate);
        }
    },
    
    nextMonth() {
        this.selectedMonth++;
        if(this.selectedMonth > 11) {
            this.selectedMonth = 0;
            this.selectedYear++;
        }
        this.generateCalendar();
    },
    
    prevMonth() {
        this.selectedMonth--;
        if(this.selectedMonth < 0) {
            this.selectedMonth = 11;
            this.selectedYear--;
        }
        this.generateCalendar();
    }
}" 
class="relative"
@click.away="isOpen = false">
    
    {{-- Input Display --}}
    <button 
        @click="isOpen = !isOpen"
        class="flex items-center justify-between w-full gap-2 px-3 py-2 text-sm border rounded-lg bg-white focus:ring-2 focus:ring-blue-500">
        <span x-text="startDate && endDate ? 
            formatDate(startDate) + ' - ' + formatDate(endDate) : 
            'Select date range'">
            Select date range
        </span>
        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
    </button>

    {{-- Calendar Dropdown --}}
    <div x-show="isOpen" 
        x-transition
        class="absolute left-0 z-10 mt-2 bg-white rounded-lg shadow-lg">
        
        {{-- Calendar Header --}}
        <div class="flex items-center justify-between p-4 border-b">
            <button @click="prevMonth" class="p-1 hover:bg-gray-100 rounded-full">&lt;</button>
            <span x-text="new Date(selectedYear, selectedMonth).toLocaleDateString('en-US', { month: 'long', year: 'numeric' })"></span>
            <button @click="nextMonth" class="p-1 hover:bg-gray-100 rounded-full">&gt;</button>
        </div>

        {{-- Calendar Grid --}}
        <div class="p-4">
            {{-- Weekday Headers --}}
            <div class="grid grid-cols-7 mb-2">
                <template x-for="day in ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa']">
                    <div class="text-center text-gray-500 text-sm" x-text="day"></div>
                </template>
            </div>

            {{-- Days Grid --}}
            <div class="grid grid-cols-7 gap-1">
                <template x-for="day in days">
                    <button 
                        @click="selectDate(day)"
                        :disabled="!day"
                        class="w-8 h-8 text-sm rounded-full flex items-center justify-center"
                        :class="{
                            'hover:bg-blue-100': day,
                            'text-gray-400': !day,
                            'bg-blue-500 text-white': day && isDateInRange(day),
                            'cursor-pointer': day,
                            'cursor-default': !day
                        }"
                        x-text="day">
                    </button>
                </template>
            </div>
        </div>

        {{-- Footer Actions --}}
        <div class="flex justify-end gap-2 p-4 border-t">
            <button 
                @click="startDate = null; endDate = null; $wire.set('startDate', null); $wire.set('endDate', null); isOpen = false"
                class="px-3 py-1 text-sm text-gray-600 hover:text-gray-800">
                Clear
            </button>
            <button 
                @click="isOpen = false"
                class="px-3 py-1 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">
                Apply
            </button>
        </div>
    </div>
</div>