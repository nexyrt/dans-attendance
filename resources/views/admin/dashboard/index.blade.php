<x-layouts.admin>
    
    <livewire:admin.attendance-table />

    {{-- Modal Pop Up Condition --}}
    @if (now()->hour >= 17 && now()->hour < 20 && !$attendanceRecordExists)
        <x-modals.checkInOutModal :user="$user" :checkOutModal="$checkOutModal = false" />
    @elseif (now()->hour >= 22 && now()->hour < 23 && !$hasCheckedOut)
        <x-modals.checkInOutModal :user="$user" :checkOutModal="$checkOutModal = true" />
    @endif
</x-layouts.admin>
