@php
    use App\Helpers\DateTimeHelper;
@endphp

<div>
    <div class="bg-white rounded-xl shadow-sm">
        {{-- Header Section --}}
        <div class="p-6 border-b">
            {{-- Title and Filter Container --}}
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                {{-- Left Side: Title --}}
                <div class="flex items-center space-x-4">
                    <div class="p-2 bg-[#1D4ED8] rounded-xl">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Attendance History</h2>
                        <p class="text-sm text-gray-500">Your attendance records</p>
                    </div>
                </div>

                {{-- Right Side: Filters --}}
                <div class="flex flex-wrap items-center gap-3">
                    {{-- Date Range Filter --}}
                    <div x-data="{ isOpen: false }" class="relative">
                        <button @click="isOpen = !isOpen"
                            class="flex items-center gap-x-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1D4ED8]">
                            <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                            </svg>
                            {{ Carbon\Carbon::parse($startDate)->format('M d, Y') }} -
                            {{ Carbon\Carbon::parse($endDate)->format('M d, Y') }}
                            <svg class="w-4 h-4 text-gray-400" :class="{ 'rotate-180': isOpen }" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>

                        {{-- Dropdown Panel (Keep existing content) --}}
                        <div x-show="isOpen" @click.outside="isOpen = false"
                            class="absolute right-0 z-10 mt-2 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden min-w-[320px] sm:w-[600px]">
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
                    <button wire:click="resetFilters"
                        class="inline-flex items-center gap-x-1.5 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#1D4ED8]">
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        Reset
                    </button>
                </div>
            </div>
        </div>

        {{-- Table Section --}}
        <div class="overflow-x-auto">
            <table class="w-full">
                <!-- Header remains the same -->
                <tbody class="divide-y divide-gray-200">
                    @forelse($attendances as $attendance)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <span
                                    class="font-medium">{{ DateTimeHelper::parse($attendance->date)->format('d M Y') }}</span>
                                <span
                                    class="block text-xs text-gray-500">{{ DateTimeHelper::parse($attendance->date)->format('l') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div @class([
                                        'w-2 h-2 rounded-full mr-2',
                                        'bg-green-400' => $attendance->status === 'present',
                                        'bg-red-400' => $attendance->status === 'late',
                                        'bg-yellow-400' => $attendance->status === 'early_leave',
                                    ])></div>
                                    <span class="text-sm font-medium text-gray-900">
                                        {{ $attendance->check_in ? DateTimeHelper::parse($attendance->check_in)->format('H:i') : '--:--' }}
                                        <span class="text-xs text-gray-500">
                                            {{ $attendance->check_in ? DateTimeHelper::parse($attendance->check_in)->format('A') : '' }}
                                        </span>
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-gray-900">
                                    {{ $attendance->check_out ? DateTimeHelper::parse($attendance->check_out)->format('H:i') : '--:--' }}
                                    <span class="text-xs text-gray-500">
                                        {{ $attendance->check_out ? DateTimeHelper::parse($attendance->check_out)->format('A') : '' }}
                                    </span>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span @class([
                                    'inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium',
                                    'bg-green-50 text-green-700' => $attendance->status === 'present',
                                    'bg-red-50 text-red-700' => $attendance->status === 'late',
                                    'bg-yellow-50 text-yellow-700' => $attendance->status === 'early_leave',
                                ])>
                                    <span @class([
                                        'w-1 h-1 mr-1.5 rounded-full',
                                        'bg-green-400' => $attendance->status === 'present',
                                        'bg-red-400' => $attendance->status === 'late',
                                        'bg-yellow-400' => $attendance->status === 'early_leave',
                                    ])></span>
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-gray-900">
                                    {{ $attendance->working_hours ?? '--' }}
                                    <span class="text-xs text-gray-500">Hours</span>
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-sm text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-medium">No attendance records found</span>
                                    <p class="text-gray-400 mt-1">Try adjusting your search filters</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
