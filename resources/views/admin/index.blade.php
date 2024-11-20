<x-admin-layout>
    {{-- <div class="flex gap-x-5 mt-5">
        <div class="bg-white py-5 flex justify-between px-10 items-center grow gap-x-3 rounded-md">
            <div>
                <p class="text-2xl font-bold text-green-400">12</p>
                <p class="font-semibold text-gray-500">Employees</p>
            </div>
            <i
                class='bx bxs-user-rectangle text-white text-4xl w-16 text-center rounded-full bg-gradient-to-br from-blue-700 to-purple-600 p-3'></i>
        </div>
        <div class="bg-white py-5 flex justify-between px-10 items-center grow gap-x-3 rounded-md">
            <div>
                <p class="text-2xl font-bold text-red-700">56</p>
                <p class="font-semibold text-gray-500">Late Hours</p>
            </div>
            <i
                class='bx bxs-time-five text-white text-4xl w-16 text-center rounded-full bg-gradient-to-br from-orange-700 to-purple-600 p-3'></i>
        </div>
        <div class="bg-white py-5 flex justify-between px-10 items-center grow gap-x-3 rounded-md">
            <div>
                <p class="text-2xl font-bold text-rose-400">42</p>
                <p class="font-semibold text-gray-500">Leave's Day</p>
            </div>
            <i
                class='bx bx-log-out text-white text-4xl w-16 text-center rounded-full bg-gradient-to-br from-rose-700 to-purple-600 p-3'></i>
        </div>
        <div class="bg-white py-5 flex justify-between px-10 items-center grow gap-x-3 rounded-md">
            <div>
                <p class="text-2xl font-bold text-rose-400">30</p>
                <p class="font-semibold text-gray-500">Resign's</p>
            </div>
            <i
                class='bx bxs-user-rectangle text-white text-4xl w-16 text-center rounded-full bg-gradient-to-br from-blue-700 to-purple-600 p-3'></i>
        </div>
    </div> --}}

    <livewire:admin.attendance-table />

    {{-- Modal Pop Up Condition --}}
    @if (now()->hour >= 17 && now()->hour < 20 && !$attendanceRecordExists)
        <x-modals.checkInOutModal :user="$user" :checkOutModal="$checkOutModal = false" />
    @elseif (now()->hour >= 22 && now()->hour < 23 && !$hasCheckedOut)
        <x-modals.checkInOutModal :user="$user" :checkOutModal="$checkOutModal = true" />
    @endif
</x-admin-layout>
