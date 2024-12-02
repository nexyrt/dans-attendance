<div>
    <x-layouts.admin>
        <!-- Table Container -->
        <div
            class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-xl shadow-sm border border-gray-100 dark:border-gray-800">
            <!-- Table Toolbar -->
            <div
                class="flex flex-col md:flex-row items-center justify-between p-4 border-b border-gray-100 dark:border-gray-800">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Attendance Records</h3>
                <div class="flex items-center gap-3">
                    <!-- Export Button -->
                    <button
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Export
                    </button>
                    <!-- Print Button -->
                    <button
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Print
                    </button>
                </div>
            </div>

            <!-- Table Container -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead
                        class="text-xs uppercase tracking-wider text-gray-700 dark:text-gray-300 bg-gray-50/50 dark:bg-gray-800/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-medium">Employee</th>
                            <th scope="col" class="px-6 py-4 font-medium">Position & Department</th>
                            <th scope="col" class="px-6 py-4 font-medium whitespace-nowrap">Date</th>
                            <th scope="col" class="px-6 py-4 font-medium whitespace-nowrap">Check In</th>
                            <th scope="col" class="px-6 py-4 font-medium whitespace-nowrap">Check Out</th>
                            <th scope="col" class="px-6 py-4 font-medium">Status</th>
                            <th scope="col" class="px-6 py-4 font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse ($attendances as $attendance)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition duration-150">
                                <!-- Employee Column -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <img class="h-10 w-10 rounded-full object-cover ring-2 ring-gray-100 dark:ring-gray-800"
                                            src="{{ asset($attendance->user->image) }}"
                                            alt="{{ $attendance->user->name }}">
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-white">
                                                {{ $attendance->user->name }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $attendance->user->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Position & Department Column -->
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        <div class="font-medium text-gray-900 dark:text-white">
                                            {{ $attendance->user->position }}
                                        </div>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                            {{ $attendance->user->department->name }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Date Column -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-gray-900 dark:text-white">
                                        {{ Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ Carbon\Carbon::parse($attendance->date)->format('l') }}
                                    </div>
                                </td>

                                <!-- Check In Column -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-gray-900 dark:text-white">
                                        {{ Carbon\Carbon::parse($attendance->check_in)->format('h:i A') }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ Carbon\Carbon::parse($attendance->check_in)->diffForHumans() }}
                                    </div>
                                </td>

                                <!-- Check Out Column -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($attendance->check_out)
                                        <div class="text-gray-900 dark:text-white">
                                            {{ Carbon\Carbon::parse($attendance->check_out)->format('h:i A') }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ Carbon\Carbon::parse($attendance->check_out)->diffForHumans() }}
                                        </div>
                                    @else
                                        <span class="text-gray-500 dark:text-gray-400">Not checked out</span>
                                    @endif
                                </td>

                                <!-- Status Column -->
                                <td class="px-6 py-4">
                                    @if ($attendance->status === 'present')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            On Time
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Late
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions Column -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <button
                                            class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        <button
                                            class="p-2 text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12">
                                    <div class="flex flex-col items-center justify-center text-center">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No
                                            records
                                            found
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            No attendance records for the selected filters.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100 dark:border-gray-800">
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-700 dark:text-gray-300">
                        Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of
                        <span class="font-medium">20</span> results
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <button
                        class="px-3 py-1 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50">
                        Previous
                    </button>
                    <button
                        class="px-3 py-1 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                        Next
                    </button>
                </div>
            </div>
        </div>
    </x-layouts.admin>
</div>
