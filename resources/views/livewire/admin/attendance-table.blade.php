<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <div>

    </div>
    <table class="w-full text-sm text-left mt-5 rtl:text-right text-gray-500 dark:text-gray-400">
        <x-table.thead>
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
        </x-table.thead>

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
