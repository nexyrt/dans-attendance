{{-- resources/views/staff/attendance/index.blade.php --}}
<x-layouts.staff>
    <div class="space-y-6">
        {{-- Quick Actions Card --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Today's Status Card --}}
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Today's Status</h2>
                    <span class="text-sm text-gray-500">{{ now()->format('l, d F Y') }}</span>
                </div>

                @if ($todayAttendance)
                    <div class="grid grid-cols-2 gap-4">
                        {{-- Check In Info --}}
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center space-x-3">
                                <div class="bg-green-100 rounded-full p-2">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Check In</p>
                                    <p class="text-lg font-semibold text-gray-900">
                                        {{ $todayAttendance->check_in ? date('H:i', strtotime($todayAttendance->check_in)) : '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Check Out Info --}}
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center space-x-3">
                                <div class="bg-red-100 rounded-full p-2">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Check Out</p>
                                    <p class="text-lg font-semibold text-gray-900">
                                        {{ $todayAttendance->check_out ? date('H:i', strtotime($todayAttendance->check_out)) : '--:--' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No attendance recorded for today</h3>
                    </div>
                @endif
            </div>

            {{-- Schedule Info Card --}}
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Work Schedule</h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Working Hours</span>
                        <span class="text-sm font-medium">09:00 - 17:00</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Break Time</span>
                        <span class="text-sm font-medium">12:00 - 13:00</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Late Tolerance</span>
                        <span class="text-sm font-medium">30 minutes</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Attendance History --}}
        <livewire:staff.attendance-history />

    </div>
</x-layouts.staff>
