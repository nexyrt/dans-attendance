<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <form action="{{ route('filter') }}" method="POST">
        @csrf
        <select name="month">
            <option value="1">January</option>
            <option value="2">February</option>
            <!-- Add options for other months -->
        </select>
        <button type="submit">Filter</button>
    </form>
    <div class="p-6 text-gray-900 dark:text-gray-100 mb-5">
        <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="overflow-hidden">
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                        Name</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                        Department</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                        Position</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                        Activity Log</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                        Date</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                        Check-In</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                        Check-Out</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($dataVariable as $item)
                                    <tr>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">
                                            {{ $item->employee->name }}</td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                            <p class="bg-blue-500 p-1.5 text-white rounded-md w-fit">
                                                {{ $item->employee->department }}</p>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                            <p class="bg-orange-500 p-1.5 text-white rounded-md w-fit">
                                                {{ $item->employee->position }}</p>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                            {{ $item->activity_log }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap  text-end text-sm font-medium">
                                            {{ $item->date }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-green-700 text-end text-sm font-medium">
                                            {{ $item->check_in }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-red-700 text-end text-sm font-medium">
                                            {{ $item->check_out }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
