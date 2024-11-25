<div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <div class="flex justify-between items-center space-x-3">
                {{-- Judul Table --}}
                <div class="flex items-center gap-x-3">
                    <div class="p-2 bg-indigo-50 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5 text-indigo-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-medium text-gray-900">Attendance History</h2>
                        <p class="text-sm text-gray-500">Your attendance records</p>
                    </div>
                </div>
                {{-- Judul Table --}}

                {{-- Filter Table --}}
                <div class="flex items-center gap-x-3">
                    {{-- Date Range Filter --}}
                    <div x-data="{ isOpen: false }" class="relative">
                        {{-- Trigger Button --}}
                        <button @click="isOpen = ! isOpen" type="button"
                            class="flex items-center gap-x-2 px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                            </svg>
                            <span>
                                {{ Carbon\Carbon::parse($startDate)->format('M d, Y') }} -
                                {{ Carbon\Carbon::parse($endDate)->format('M d, Y') }}
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-500"
                                :class="{ 'rotate-180 transform': isOpen }">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>

                        {{-- Dropdown Panel --}}
                        <div x-show="isOpen" @click.outside="isOpen = false"
                            class="absolute right-0 z-10 mt-2 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden"
                            style="display: none; width: 600px;">
                            <div class="p-4">
                                <div class="flex items-center justify-between space-x-4">
                                    {{-- Start Date --}}
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                                        <input type="date" wire:model.live="startDate"
                                            class="block w-full rounded-md border border-gray-300 bg-white py-2 pl-3 pr-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                                    </div>

                                    {{-- End Date --}}
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                                        <input type="date" wire:model.live="endDate"
                                            class="block w-full rounded-md border border-gray-300 bg-white py-2 pl-3 pr-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                                    </div>
                                </div>

                                {{-- Quick Select Buttons --}}
                                <div class="mt-4">
                                    <div class="text-xs font-medium text-gray-700 mb-2">Quick Select</div>
                                    <div class="grid grid-cols-4 gap-2">
                                        <button wire:click="setDateRange('today')" @click="isOpen = false"
                                            type="button"
                                            class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Today
                                        </button>
                                        <button wire:click="setDateRange('yesterday')" @click="isOpen = false"
                                            type="button"
                                            class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Yesterday
                                        </button>
                                        <button wire:click="setDateRange('thisWeek')" @click="isOpen = false"
                                            type="button"
                                            class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            This Week
                                        </button>
                                        <button wire:click="setDateRange('lastWeek')" @click="isOpen = false"
                                            type="button"
                                            class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Last Week
                                        </button>
                                        <button wire:click="setDateRange('thisMonth')" @click="isOpen = false"
                                            type="button"
                                            class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            This Month
                                        </button>
                                        <button wire:click="setDateRange('lastMonth')" @click="isOpen = false"
                                            type="button"
                                            class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Last Month
                                        </button>
                                        <button wire:click="setDateRange('last30Days')" @click="isOpen = false"
                                            type="button"
                                            class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Last 30 Days
                                        </button>
                                        <button wire:click="setDateRange('last90Days')" @click="isOpen = false"
                                            type="button"
                                            class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Last 90 Days
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Status Filter --}}
                    <x-input.dropdown label="Filter Status" name="status" :options="[
                        ['value' => 'all', 'label' => 'All Status'],
                        ['value' => 'present', 'label' => 'Present'],
                        ['value' => 'late', 'label' => 'Late'],
                        ['value' => 'early_leave', 'label' => 'Early Leave'],
                    ]" :selected="$status"
                        :isLivewire="true" />

                    {{-- Reset Button --}}
                    <button wire:click="resetFilters" type="button"
                        class="inline-flex items-center gap-x-1.5 px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        Reset
                    </button>
                </div>

            </div>
        </div>

        <x-table.container>
            <table class="w-full text-sm text-left">
                <x-table.thead>
                    <tr>
                        <x-table.th>Date</x-table.th>
                        <x-table.th>Check In</x-table.th>
                        <x-table.th>Check Out</x-table.th>
                        <x-table.th>Status</x-table.th>
                        <x-table.th>Working Hours</x-table.th>
                    </tr>
                </x-table.thead>
                <tbody>
                    @forelse($attendances as $attendance)
                        <x-table.tr>
                            <x-table.td>
                                {{ $attendance->date->format('d M Y') }}
                            </x-table.td>
                            <x-table.td>
                                {{ $attendance->check_in?->format('H:i') ?? '--:--' }}
                            </x-table.td>
                            <x-table.td>
                                {{ $attendance->check_out?->format('H:i') ?? '--:--' }}
                            </x-table.td>
                            <x-table.td>
                                <span @class([
                                    'px-2.5 py-1 text-xs font-medium rounded-full',
                                    'bg-green-100 text-green-800' => $attendance->status === 'present',
                                    'bg-red-100 text-red-800' => $attendance->status === 'late',
                                    'bg-yellow-100 text-yellow-800' => $attendance->status === 'early_leave',
                                ])>
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            </x-table.td>
                            <x-table.td>
                                {{ $attendance->working_hours ?? '--' }} Hours
                            </x-table.td>
                        </x-table.tr>
                    @empty
                        <x-table.tr>
                            <x-table.td colspan="5" class="text-center text-gray-500">
                                No attendance records found
                            </x-table.td>
                        </x-table.tr>
                    @endforelse
                </tbody>
            </table>
        </x-table.container>
    </div>
</div>
