<div>
    {{-- Filter Section --}}
    <div class="bg-white p-4 mb-4 rounded-lg shadow-sm space-y-4">
        <div class="flex flex-col md:flex-row gap-4">
            {{-- Month Filter --}}
            <div class="flex-1">
                <label for="month" class="block text-sm font-medium text-gray-700 mb-1">Select Month</label>
                <select wire:model.live="selectedMonth"
                    class="block w-full py-2 pl-3 pr-10 border border-gray-300 rounded-md leading-5 bg-white focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @foreach ($availableMonths as $month)
                        <option value="{{ $month['value'] }}">{{ $month['label'] }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Search Filter --}}
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search by Name</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="search"
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        placeholder="Search employees...">
                </div>
            </div>

            {{-- Department Filter --}}
            <div class="flex-1">
                <label for="department" class="block text-sm font-medium text-gray-700 mb-1">Filter by
                    Department</label>
                <select wire:model.live="department"
                    class="block w-full py-2 pl-3 pr-10 border border-gray-300 rounded-md leading-5 bg-white focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">All Departments</option>
                    @foreach ($departments as $dept)
                        <option value="{{ $dept }}">{{ $dept }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Active Filters --}}
        <div class="flex items-center gap-2 text-sm text-gray-600">
            <span>Active Filters:</span>
            <span
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                Month: {{ Carbon\Carbon::createFromFormat('Y-m', $selectedMonth)->format('F Y') }}
            </span>
            @if ($search)
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    Name: {{ $search }}
                    <button wire:click="$set('search', '')" class="ml-1 text-blue-500 hover:text-blue-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </span>
            @endif
            @if ($department)
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                    Department: {{ $department }}
                    <button wire:click="$set('department', '')" class="ml-1 text-purple-500 hover:text-purple-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </span>
            @endif
        </div>

        {{-- Summary Section --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4 border-t">
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="text-sm font-medium text-gray-500">Total Attendance</div>
                <div class="mt-1 text-2xl font-semibold text-gray-900">{{ $attendances->count() }}</div>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="text-sm font-medium text-gray-500">On Time</div>
                <div class="mt-1 text-2xl font-semibold text-green-600">
                    {{ $attendances->where('status', 'present')->count() }}
                </div>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="text-sm font-medium text-gray-500">Late</div>
                <div class="mt-1 text-2xl font-semibold text-red-600">
                    {{ $attendances->where('status', 'late')->count() }}
                </div>
            </div>
        </div>
    </div>

    <x-table.container class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left mt-5 rtl:text-right text-gray-500 dark:text-gray-400">
            <x-table.thead>
                <tr>
                    <x-table.th class="p-4 rounded-tl-lg">Name</x-table.th>
                    <x-table.th>Position</x-table.th>
                    <x-table.th>Date</x-table.th>
                    <x-table.th>Check-In</x-table.th>
                    <x-table.th class="px-6 py-3 rounded-tr-lg">Check-Out</x-table.th>
                </tr>
            </x-table.thead>

            <tbody>
                @if ($attendances->isEmpty())
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No attendance records found
                        </td>
                    </tr>
                @else
                    @foreach ($attendances as $attendance)
                        <x-table.tr>
                            <x-table.td scope="row"
                                class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                <img class="w-10 h-10 rounded-full object-cover"
                                    src={{ asset($attendance->user->image) }} alt="Jese image">
                                <div class="ps-3">
                                    <div class="text-base font-semibold">{{ $attendance->user->name }}</div>
                                    <div class="font-normal text-gray-500">{{ $attendance->user->email }}</div>
                                </div>
                            </x-table.td>

                            <x-table.td>
                                <p class="text-black">{{ $attendance->user->position }}</p>
                                <p
                                    class="bg-gradient-to-r from-blue-500 to-purple-500 text-white text-xs p-1.5 rounded-md w-fit">
                                    {{ $attendance->user->department }}</p>
                            </x-table.td>

                            <x-table.td> {{ $attendance->date }} </x-table.td>

                            <x-table.td>
                                <p class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                    {{ $attendance->check_in }}</p>
                            </x-table.td>

                            <x-table.td>
                                <p class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                    {{ $attendance->check_out }}</p>
                            </x-table.td>
                        </x-table.tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </x-table.container>

    {{-- Loading State --}}
    <div wire:loading class="fixed top-0 left-0 right-0">
        <div class="bg-blue-500 text-white text-sm py-2 text-center">
            Loading...
        </div>
    </div>
</div>
