<x-admin-layout>
    <div class="flex gap-x-5 mt-5">
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
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left mt-5 rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 rounded-xl">
                <tr>
                    <th scope="col" class="p-4 rounded-tl-lg">
                        <div class="flex items-center">
                            <input id="checkbox-all-search" type="checkbox"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-all-search" class="sr-only">checkbox</label>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Position
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Date
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Check-In
                    </th>
                    <th scope="col" class="px-6 py-3 rounded-tr-lg">
                        Check-Out
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attendances as $attendance)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input id="checkbox-table-search-1" type="checkbox"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <td scope="row"
                            class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                            <img class="w-10 h-10 rounded-full object-cover" src={{ asset($attendance->user->image) }}
                                alt="Jese image">
                            <div class="ps-3">
                                <div class="text-base font-semibold">{{ $attendance->user->name }}</div>
                                <div class="font-normal text-gray-500">{{ $attendance->user->email }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-black">{{ $attendance->user->position }}</p>
                            <p
                                class="bg-gradient-to-r from-blue-500 to-purple-500 text-white text-xs p-1.5 rounded-md w-fit">
                                {{ $attendance->user->department }}</p>
                        </td>
                        <td class="px-6 py-4">
                            {{ $attendance->date }}
                        </td>
                        <td class="px-6 py-4">
                            <a href="#"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $attendance->check_in }}</a>
                        </td>
                        <td class="px-6 py-4">
                            <a href="#"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $attendance->check_out }}</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    {{-- Modal Pop Up Condition --}}
    @if (now()->hour >= 3 && now()->hour < 20.00 && !$attendanceRecordExists)
        <x-modals.checkInOutModal :user="$user" :checkOutModal="$checkOutModal = false" />
    @elseif (now()->hour >= 16 && now()->hour < 23 && !$hasCheckedOut)
        <x-modals.checkInOutModal :user="$user" :checkOutModal="$checkOutModal = true" />
    @endif
</x-admin-layout>
