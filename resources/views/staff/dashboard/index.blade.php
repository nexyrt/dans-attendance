<x-layouts.staff>
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
        {{-- Main Content (66.6%) --}}
        <div class="lg:col-span-8 space-y-5">
            {{-- Attendance Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Check-In Card --}}
                <div
                    class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
                    <div class="space-y-5">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-blue-50 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6 text-blue-500">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Check-in</p>
                                    <p class="text-sm text-gray-500">Morning attendance</p>
                                </div>
                            </div>
                            @if ($todayAttendance && $todayAttendance->check_in)
                                <span
                                    class="px-3 py-1 text-xs font-medium {{ $todayAttendance->status === 'pending present' ? 'bg-green-50 text-green-700' : 'bg-yellow-50 text-yellow-700' }} rounded-full">
                                    {{ ucfirst($todayAttendance->status) }}
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-medium bg-gray-50 text-gray-600 rounded-full">Not
                                    Checked In</span>
                            @endif
                        </div>

                        <div class="pl-[52px]">
                            <div class="flex items-baseline space-x-2">
                                @if ($todayAttendance && $todayAttendance->check_in)
                                    <p class="text-3xl font-bold text-gray-900">
                                        {{ Carbon\Carbon::parse($todayAttendance->check_in)->format('H:i') }}</p>
                                @else
                                    <p class="text-3xl font-bold text-gray-400">--:--</p>
                                @endif
                                <p class="text-gray-500">WIB</p>
                            </div>
                            <div class="flex items-center space-x-2 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                                <p class="text-sm text-gray-500">{{ now()->format('d F Y') }}</p>
                            </div>
                        </div>

                        <div class="pl-[52px] pt-2">
                            <div class="flex items-center space-x-2 text-gray-600">
                                <div class="p-1.5 bg-gray-50 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-4 text-gray-500">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-medium">
                                    {{ $todayAttendance && $todayAttendance->check_in ? 'Office Building' : 'Not checked in yet' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Check-Out Card --}}
                <div
                    class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
                    <div class="space-y-5">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-red-50 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6 text-red-500">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Check-out</p>
                                    <p class="text-sm text-gray-500">Evening attendance</p>
                                </div>
                            </div>
                            <span
                                class="px-3 py-1 text-xs font-medium {{ $todayAttendance && $todayAttendance->check_out ? 'bg-green-50 text-green-700' : 'bg-gray-50 text-gray-600' }} rounded-full">
                                {{ $todayAttendance && $todayAttendance->check_out ? 'Completed' : 'Pending' }}
                            </span>
                        </div>

                        <div class="pl-[52px]">
                            <div class="flex items-baseline space-x-2">
                                @if ($todayAttendance && $todayAttendance->check_out)
                                    <p class="text-3xl font-bold text-gray-900">
                                        {{ Carbon\Carbon::parse($todayAttendance->check_out)->format('H:i') }}</p>
                                @else
                                    <p class="text-3xl font-bold text-gray-400">--:--</p>
                                @endif
                                <p class="text-gray-500">WIB</p>
                            </div>
                            <div class="flex items-center space-x-2 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                                <p class="text-sm text-gray-500">{{ now()->format('d F Y') }}</p>
                            </div>
                        </div>

                        <div class="pl-[52px] pt-2">
                            <div class="flex items-center space-x-2 text-gray-600">
                                <div class="p-1.5 bg-gray-50 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-4 text-gray-500">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-medium">
                                    {{ $todayAttendance && $todayAttendance->check_out ? 'Office Building' : 'Not checked out yet' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Week's Summary --}}
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-green-50 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-5 text-green-500">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="font-medium text-gray-900">Time Tracking</h2>
                            <p class="text-sm text-gray-500">This week's summary</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Hours Today</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['todayHours'] }}h</p>
                        <div class="flex items-center mt-2">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full"
                                    style="width: {{ $stats['todayProgress'] }}%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Week Total</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['weekTotal'] }}h</p>
                        <div class="flex items-center mt-2">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full"
                                    style="width: {{ $stats['weekProgress'] }}%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Overtime</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['overtime'] }}h</p>
                        <div class="flex items-center mt-2">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-purple-500 h-2 rounded-full"
                                    style="width: {{ $stats['overtimeProgress'] }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Today's Tasks Section (Coming Soon) --}}
            <div class="relative bg-white rounded-xl p-6 shadow-sm border border-gray-100 overflow-hidden">
                <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm flex items-center justify-center z-10">
                    <div class="text-center">
                        <span
                            class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            Coming Soon
                        </span>
                        <p class="mt-2 text-white">Task Management Feature</p>
                    </div>
                </div>

                {{-- Blurred Background Content --}}
                <div class="opacity-50">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-purple-50 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 text-purple-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="font-medium text-gray-900">Today's Tasks</h2>
                                <p class="text-sm text-gray-500">{{ now()->format('d F Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                            <p class="text-gray-600">Task management features will be available soon...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar (33.3%) --}}
        <div class="lg:col-span-4 space-y-5">
            {{-- Calendar Widget (Coming Soon) --}}
            <div class="relative bg-white rounded-xl p-6 shadow-sm border border-gray-100 overflow-hidden">
                <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm flex items-center justify-center z-10">
                    <div class="text-center">
                        <span
                            class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            Coming Soon
                        </span>
                        <p class="mt-2 text-white">Calendar Integration</p>
                    </div>
                </div>

                {{-- Blurred Background Content --}}
                <div class="opacity-50">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-600">Calendar widget will be available soon...</p>
                    </div>
                </div>
            </div>

            {{-- Schedule Updates (Coming Soon) --}}
            <div class="relative bg-white rounded-xl p-6 shadow-sm border border-gray-100 overflow-hidden">
                <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm flex items-center justify-center z-10">
                    <div class="text-center">
                        <span
                            class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            Coming Soon
                        </span>
                        <p class="mt-2 text-white">Schedule Updates</p>
                    </div>
                </div>

                {{-- Blurred Background Content --}}
                <div class="opacity-50">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-blue-50 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 text-blue-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="font-medium text-gray-900">Schedule Updates</h2>
                                <p class="text-sm text-gray-500">Recent changes</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-600">Schedule updates will be available soon...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Include Check-in Modal Component --}}
    <livewire:shared.check-in-modal />

    {{-- Include Check-out Modal Component --}}
    <livewire:shared.check-out-modal />
</x-layouts.staff>
