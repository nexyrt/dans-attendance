<div>
    <h1>Payroll</h1>
    
    <div>
        <livewire:date-range-picker 
            :start-date="$startDate"
            :end-date="$endDate"
        />
    </div>

    <div class="mt-4">
        Selected date range: {{ $startDate }} to {{ $endDate }}
    </div>
</div>