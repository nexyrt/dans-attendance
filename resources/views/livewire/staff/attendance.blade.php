<div class="p-6">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <!-- Header & Filters -->
        <div class="p-4 border-b border-gray-200">
            <div class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:items-center sm:justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Attendance History</h2>

                <!-- Filters -->
                <div class="flex flex-wrap items-center gap-3">
                    <x-input.dropdown :items="$monthsDropdown" align="right" width="48" wire="month">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center px-3 py-1.5 text-sm border border-gray-300 rounded-lg hover:bg-gray-50">
                                <span
                                    class="mr-2">{{ \Cake\Chronos\Chronos::create(null, $month)->format('F') }}</span>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </x-slot>
                    </x-input.dropdown>

                    <x-input.dropdown :items="$yearsDropdown" align="right" width="36" wire="year">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center px-3 py-1.5 text-sm border border-gray-300 rounded-lg hover:bg-gray-50">
                                <span class="mr-2">{{ $year }}</span>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </x-slot>
                    </x-input.dropdown>
                </div>
            </div>
        </div>

        <!-- Attendance Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-3.5 text-left">
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Date</span>
                        </th>
                        <th class="px-6 py-3.5 text-left">
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Check In</span>
                        </th>
                        <th class="px-6 py-3.5 text-left">
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Check Out</span>
                        </th>
                        <th class="px-6 py-3.5 text-left">
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Working
                                Hours</span>
                        </th>
                        <th class="px-6 py-3.5 text-left">
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Status</span>
                        </th>
                        <th class="px-6 py-3.5 text-left">
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($attendances as $attendance)
                        <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ \Cake\Chronos\Chronos::parse($attendance->date)->format('d F Y') }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ \Cake\Chronos\Chronos::parse($attendance->date)->format('l') }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if ($attendance->check_in)
                                    <div class="text-sm text-gray-900">
                                        {{ \Cake\Chronos\Chronos::parse($attendance->check_in)->format('H:i:s') }}
                                    </div>
                                @else
                                    <span class="text-sm text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if ($attendance->check_out)
                                    <div class="text-sm text-gray-900">
                                        {{ \Cake\Chronos\Chronos::parse($attendance->check_out)->format('H:i:s') }}
                                    </div>
                                @else
                                    <span class="text-sm text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{ $attendance->working_hours ? number_format($attendance->working_hours, 2) . ' hrs' : '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span @class([
                                    'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                    'bg-green-100 text-green-800' => $attendance->status === 'present',
                                    'bg-yellow-100 text-yellow-800' => $attendance->status === 'late',
                                    'bg-red-100 text-red-800' => $attendance->status === 'early_leave',
                                    'bg-gray-100 text-gray-800' => $attendance->status === 'holiday',
                                    'bg-blue-100 text-blue-800' => $attendance->status === 'pending present',
                                ])>
                                    {{ str_replace('_', ' ', ucfirst($attendance->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($attendance->notes)
                                    <span class="text-sm text-gray-500">{{ $attendance->notes }}</span>
                                @else
                                    <span class="text-sm text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center">
                                <div class="text-gray-500 text-sm">No attendance records found for this period</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($attendances->hasPages())
            <div class="px-6 py-3 border-t border-gray-200">
                {{ $attendances->links() }}
            </div>
        @endif
    </div>
</div>
