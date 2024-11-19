<x-admin-layout>
    

    <livewire:admin.attendance-table />

    {{-- Modal Pop Up Condition --}}
    @if (now()->hour >= 3 && now()->hour < 20.0 && !$attendanceRecordExists)
        <x-modals.checkInOutModal :user="$user" :checkOutModal="$checkOutModal = false" />
    @elseif (now()->hour >= 16 && now()->hour < 23 && !$hasCheckedOut)
        <x-modals.checkInOutModal :user="$user" :checkOutModal="$checkOutModal = true" />
    @endif
</x-admin-layout>
