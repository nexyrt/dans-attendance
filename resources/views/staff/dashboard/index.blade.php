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
                            <span class="px-3 py-1 text-xs font-medium bg-green-50 text-green-700 rounded-full">On
                                Time</span>
                        </div>

                        <div class="pl-[52px]">
                            <div class="flex items-baseline space-x-2">
                                <p class="text-3xl font-bold text-gray-900">08:13</p>
                                <p class="text-gray-500">WIB</p>
                            </div>
                            <div class="flex items-center space-x-2 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                                <p class="text-sm text-gray-500">24 November 2024</p>
                            </div>
                        </div>

                        <div class="pl-[52px] pt-2 border-t">
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
                                <p class="text-sm font-medium">Office Building</p>
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
                                class="px-3 py-1 text-xs font-medium bg-gray-50 text-gray-600 rounded-full">Pending</span>
                        </div>

                        <div class="pl-[52px]">
                            <div class="flex items-baseline space-x-2">
                                <p class="text-3xl font-bold text-gray-400">--:--</p>
                                <p class="text-gray-400">WIB</p>
                            </div>
                            <div class="flex items-center space-x-2 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                                <p class="text-sm text-gray-500">24 November 2024</p>
                            </div>
                        </div>

                        <div class="pl-[52px] pt-2 border-t">
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
                                <p class="text-sm font-medium text-gray-400">Not checked out yet</p>
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

                <div class="grid grid-cols-3 gap-4 mb-6">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Hours Today</p>
                        <p class="text-2xl font-semibold text-gray-900">7.5h</p>
                        <div class="flex items-center mt-2">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 85%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Week Total</p>
                        <p class="text-2xl font-semibold text-gray-900">32.5h</p>
                        <div class="flex items-center mt-2">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: 65%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Overtime</p>
                        <p class="text-2xl font-semibold text-gray-900">2.5h</p>
                        <div class="flex items-center mt-2">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-purple-500 h-2 rounded-full" style="width: 15%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Today's Tasks --}}
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
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
                            <p class="text-sm text-gray-500">24 November 2024</p>
                        </div>
                    </div>
                    <button
                        class="px-3 py-1.5 text-sm text-purple-600 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors">
                        + Add Task
                    </button>
                </div>

                <div class="space-y-3">
                    <!-- High Priority Task -->
                    <div class="relative flex items-center p-4 bg-red-50/50 rounded-lg border border-red-100">
                        <span class="absolute top-0 left-0 w-1 h-full bg-red-500 rounded-l-lg"></span>
                        <div class="ml-3 flex-1">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <h3 class="font-medium text-gray-900">Client Progress Meeting</h3>
                                    <span class="px-2 py-0.5 text-xs bg-red-100 text-red-600 rounded-full">09:30
                                        AM</span>
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-600">Meeting Room A</p>
                        </div>
                    </div>

                    <!-- Medium Priority Task -->
                    <div class="relative flex items-center p-4 bg-yellow-50/50 rounded-lg border border-yellow-100">
                        <span class="absolute top-0 left-0 w-1 h-full bg-yellow-500 rounded-l-lg"></span>
                        <div class="ml-3 flex-1">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <h3 class="font-medium text-gray-900">Weekly Report</h3>
                                    <span class="px-2 py-0.5 text-xs bg-yellow-100 text-yellow-600 rounded-full">02:00
                                        PM</span>
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-600">Submit progress report</p>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t flex justify-between items-center">
                    <p class="text-sm text-gray-500">2 tasks remaining</p>
                    <a href="#"
                        class="text-sm text-purple-600 hover:text-purple-700 flex items-center space-x-1">
                        <span>View All</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                </div>
            </div>
            
            
        </div>

        {{-- Sidebar (33.3%) --}}
        <div class="lg:col-span-4 space-y-5">
            {{-- Calendar Widget --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <x-mini-calendar :events="$events" />
            </div>

            {{-- Schedule Change Notifications --}}
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
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

                <div class="space-y-3">
                    <div class="p-3 bg-blue-50/50 rounded-lg border border-blue-100">
                        <p class="text-sm font-medium text-gray-900">Team Meeting Rescheduled</p>
                        <p class="text-xs text-gray-500 mt-1">Moved from 2:00 PM to 3:30 PM</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.staff>
