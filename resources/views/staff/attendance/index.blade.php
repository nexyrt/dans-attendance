{{-- resources/views/staff/attendance/index.blade.php --}}
<x-layouts.staff>
    {{-- Status Overview Section --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        {{-- Current Status Card --}}
        <div class="bg-white rounded-xl shadow-sm h-full">
            <div class="p-6">
                {{-- Header --}}
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-lg font-semibold text-gray-900">Current Status</h2>
                    <span class="text-sm text-gray-500">{{ now()->format('l, d F Y') }}</span>
                </div>

                {{-- Check In/Out Grid --}}
                <div class="grid grid-cols-2 gap-8">
                    {{-- Check In Card --}}
                    <div class="relative overflow-hidden bg-gradient-to-br from-green-50 to-white rounded-xl p-5 border border-green-100">
                        <div class="flex flex-col space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-600">Check In</span>
                                <div class="p-1.5 bg-white rounded-full shadow-sm">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex items-baseline space-x-2">
                                <span class="text-4xl font-bold text-green-600">08:42</span>
                                <span class="text-sm text-green-600">AM</span>
                            </div>
                            <div class="inline-flex items-center mt-1">
                                <svg class="w-3.5 h-3.5 mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-sm font-medium text-green-600">On Time</span>
                            </div>
                        </div>
                        <div class="absolute top-0 right-0 w-24 h-24 opacity-10">
                            <svg class="w-full h-full text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                        </div>
                    </div>
                
                    {{-- Check Out Card --}}
                    <div class="relative overflow-hidden bg-gradient-to-br from-orange-50 to-white rounded-xl p-5 border border-orange-100">
                        <div class="flex flex-col space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-600">Check Out</span>
                                <div class="p-1.5 bg-white rounded-full shadow-sm">
                                    <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex items-baseline space-x-2">
                                <span class="text-4xl font-bold text-orange-600">11:28</span>
                                <span class="text-sm text-orange-600">AM</span>
                            </div>
                            <span class="text-sm text-gray-500">Regular check-out</span>
                        </div>
                        <div class="absolute top-0 right-0 w-24 h-24 opacity-10">
                            <svg class="w-full h-full text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Additional Information --}}
                <div class="mt-8 space-y-6">
                    {{-- Work Duration --}}
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-600">Work Duration</span>
                            <span class="text-sm font-medium text-blue-600">2h 46m</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: 35%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Schedule Information Card --}}
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-blue-50 rounded-lg">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">Today's Schedule</h2>
                    </div>
                    <span class="text-sm text-gray-500">{{ now()->format('D, M d') }}</span>
                </div>

                <div class="space-y-4">
                    {{-- Working Hours --}}
                    <div
                        class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-green-50 rounded-lg">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Working Hours</p>
                                <p class="text-sm text-gray-500">Regular shift</p>
                            </div>
                        </div>
                        <span class="text-sm font-medium text-gray-900">00:25 - 11:28</span>
                    </div>

                    {{-- Break Time --}}
                    <div
                        class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-orange-50 rounded-lg">
                                <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Break Time</p>
                                <p class="text-sm text-gray-500">Lunch break</p>
                            </div>
                        </div>
                        <span class="text-sm font-medium text-gray-900">12:00 - 13:00</span>
                    </div>

                    {{-- Late Tolerance --}}
                    <div
                        class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-purple-50 rounded-lg">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Late Tolerance</p>
                                <p class="text-sm text-gray-500">Grace period</p>
                            </div>
                        </div>
                        <span class="text-sm font-medium text-gray-900">30 minutes</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Attendance History Section --}}
    <div class="mt-6">
        <livewire:staff.attendance-history />
    </div>

    {{-- Livewire Script for Real-time Updates --}}
    @push('scripts')
        <script>
            window.addEventListener('attendance-marked', event => {
                Toast.fire({
                    icon: 'success',
                    title: event.detail.message
                });
            });
        </script>
    @endpush
</x-layouts.staff>
