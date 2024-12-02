<div>
    <x-layouts.admin>
        <!-- Header/Quick Info Section -->
        <div class="p-4 sm:p-6">
            <!-- Profile Header Card -->
            <div class="relative overflow-hidden">
                <!-- Top Pattern -->
                <div class="absolute inset-0 bg-gradient-to-r from-violet-600/10 to-indigo-600/10 backdrop-blur-sm">
                    <div class="absolute inset-0 opacity-20"
                        style="background-image: radial-gradient(circle at 1px 1px, rgba(255, 255, 255, 0.15) 1px, transparent 0); background-size: 20px 20px;">
                    </div>
                </div>

                <!-- Content -->
                <div class="relative px-6 py-6">
                    <!-- Main Content -->
                    <div class="flex flex-col items-center text-center">
                        <!-- Profile Image -->
                        <div class="relative group mb-4">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-violet-500 to-indigo-500 rounded-2xl blur opacity-50 group-hover:opacity-75 transition-opacity">
                            </div>
                            <div class="relative">
                                <img src="{{ asset($user->image) }}"
                                    class="w-20 h-20 rounded-2xl object-cover ring-4 ring-white shadow-lg transform group-hover:scale-105 transition-all"
                                    alt="{{ $user->name }}">
                                <!-- Online Status -->
                                <div class="absolute bottom-0 right-0 transform translate-x-1/4 translate-y-1/4">
                                    <div class="w-4 h-4 rounded-full bg-white flex items-center justify-center">
                                        <div class="w-3 h-3 rounded-full bg-green-500">
                                            <div
                                                class="absolute inset-0 rounded-full bg-green-500 animate-ping opacity-75">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- User Info -->
                        <div class="mb-4">
                            <div class="flex items-center justify-center gap-2 mb-1">
                                <h1 class="text-xl font-bold">{{ $user->name }}</h1>
                                <div class="group relative">
                                    <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <!-- Tooltip -->
                                    <div class="absolute -top-10 left-1/2 -translate-x-1/2 hidden group-hover:block">
                                        <div class="px-2 py-1 text-xs text-white bg-gray-900 rounded">Verified</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-center gap-2 mb-2">
                                <span class="text-gray-600">{{ $user->position }}</span>
                                <div class="px-2.5 py-1 bg-blue-100 text-blue-700 text-sm rounded-full">Finance</div>
                            </div>
                        </div>

                        <!-- Info Row -->
                        <div class="flex items-center justify-center gap-4 text-sm text-gray-500">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Joined Jan 2024
                            </div>
                            <div class="w-1 h-1 rounded-full bg-gray-300"></div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                                Jakarta, Indonesia
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-3 mt-5">
                            <button
                                class="group relative px-5 py-2 bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:border-gray-300 hover:bg-gray-50 transition-all">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Message
                                    <span
                                        class="absolute -top-2 -right-2 px-2 py-1 text-xs text-white bg-red-500 rounded-full">3</span>
                                </div>
                            </button>
                            <button
                                class="px-5 py-2 bg-blue-600 rounded-xl text-sm font-medium text-white hover:bg-blue-700 transition-all flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                Edit Profile
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards Grid -->
            <!-- Stats Cards Grid -->
            <!-- Stats Cards Grid -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <!-- Attendance Card -->
                <div
                    class="group relative bg-white rounded-xl sm:rounded-2xl border border-gray-100 hover:border-blue-100 hover:shadow-[0_8px_30px_rgb(59,130,246,0.15)] transition-all duration-300">
                    <!-- Subtle Background Pattern -->
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-blue-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>

                    <div class="relative p-4 sm:p-6">
                        <!-- Icon with Animation -->
                        <div
                            class="w-10 sm:w-12 h-10 sm:h-12 rounded-lg sm:rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 text-white flex items-center justify-center mb-3 sm:mb-4 group-hover:scale-110 transition-all duration-300">
                            <svg class="w-5 sm:w-6 h-5 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>

                        <!-- Stat Content -->
                        <div class="mb-4">
                            <div
                                class="text-2xl sm:text-3xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                98%
                                <span class="text-xs text-blue-500 font-normal ml-1">▲2%</span>
                            </div>
                            <div class="text-xs sm:text-sm text-gray-600 mt-1">Attendance Rate</div>
                        </div>

                        <!-- Mini Stats -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="text-center">
                                <div class="text-xs font-medium text-gray-500">Daily</div>
                                <div class="text-sm font-semibold text-gray-700">100%</div>
                            </div>
                            <div class="text-center">
                                <div class="text-xs font-medium text-gray-500">Monthly</div>
                                <div class="text-sm font-semibold text-gray-700">96%</div>
                            </div>
                            <div class="text-center">
                                <div class="text-xs font-medium text-gray-500">Yearly</div>
                                <div class="text-sm font-semibold text-gray-700">98%</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Projects Card -->
                <div
                    class="group relative bg-white rounded-xl sm:rounded-2xl border border-gray-100 hover:border-purple-100 hover:shadow-[0_8px_30px_rgb(147,51,234,0.15)] transition-all duration-300">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-purple-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>

                    <div class="relative p-4 sm:p-6">
                        <div
                            class="w-10 sm:w-12 h-10 sm:h-12 rounded-lg sm:rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 text-white flex items-center justify-center mb-3 sm:mb-4 group-hover:scale-110 transition-all duration-300">
                            <svg class="w-5 sm:w-6 h-5 sm:h-6" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                            </svg>
                        </div>

                        <div class="mb-4">
                            <div
                                class="text-2xl sm:text-3xl font-bold text-gray-900 group-hover:text-purple-600 transition-colors">
                                24
                                <span class="text-xs text-purple-500 font-normal ml-1">+3</span>
                            </div>
                            <div class="text-xs sm:text-sm text-gray-600 mt-1">Projects</div>
                        </div>

                        <!-- Mini Stats -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="text-center">
                                <div class="text-xs font-medium text-gray-500">Active</div>
                                <div class="text-sm font-semibold text-gray-700">8</div>
                            </div>
                            <div class="text-center">
                                <div class="text-xs font-medium text-gray-500">Completed</div>
                                <div class="text-sm font-semibold text-gray-700">14</div>
                            </div>
                            <div class="text-center">
                                <div class="text-xs font-medium text-gray-500">Pending</div>
                                <div class="text-sm font-semibold text-gray-700">2</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Experience Card -->
                <div
                    class="group relative bg-white rounded-xl sm:rounded-2xl border border-gray-100 hover:border-emerald-100 hover:shadow-[0_8px_30px_rgb(16,185,129,0.15)] transition-all duration-300">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-emerald-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>

                    <div class="relative p-4 sm:p-6">
                        <div
                            class="w-10 sm:w-12 h-10 sm:h-12 rounded-lg sm:rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 text-white flex items-center justify-center mb-3 sm:mb-4 group-hover:scale-110 transition-all duration-300">
                            <svg class="w-5 sm:w-6 h-5 sm:h-6" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>

                        <div class="mb-4">
                            <div
                                class="text-2xl sm:text-3xl font-bold text-gray-900 group-hover:text-emerald-600 transition-colors">
                                3.5
                                <span class="text-lg sm:text-xl ml-1">yrs</span>
                            </div>
                            <div class="text-xs sm:text-sm text-gray-600 mt-1">Experience</div>
                        </div>

                        <!-- Mini Stats -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="text-center">
                                <div class="text-xs font-medium text-gray-500">Projects</div>
                                <div class="text-sm font-semibold text-gray-700">45+</div>
                            </div>
                            <div class="text-center">
                                <div class="text-xs font-medium text-gray-500">Teams</div>
                                <div class="text-sm font-semibold text-gray-700">12</div>
                            </div>
                            <div class="text-center">
                                <div class="text-xs font-medium text-gray-500">Roles</div>
                                <div class="text-sm font-semibold text-gray-700">3</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Awards Card -->
                <div
                    class="group relative bg-white rounded-xl sm:rounded-2xl border border-gray-100 hover:border-amber-100 hover:shadow-[0_8px_30px_rgb(245,158,11,0.15)] transition-all duration-300">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-amber-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>

                    <div class="relative p-4 sm:p-6">
                        <div
                            class="w-10 sm:w-12 h-10 sm:h-12 rounded-lg sm:rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 text-white flex items-center justify-center mb-3 sm:mb-4 group-hover:scale-110 transition-all duration-300">
                            <svg class="w-5 sm:w-6 h-5 sm:h-6" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                        </div>

                        <div class="mb-4">
                            <div
                                class="text-2xl sm:text-3xl font-bold text-gray-900 group-hover:text-amber-600 transition-colors">
                                12
                                <span class="text-xs text-amber-500 font-normal ml-1">+3</span>
                            </div>
                            <div class="text-xs sm:text-sm text-gray-600 mt-1">Awards</div>
                        </div>

                        <!-- Mini Stats -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="text-center">
                                <div class="text-xs font-medium text-gray-500">Gold</div>
                                <div class="text-sm font-semibold text-gray-700">5</div>
                            </div>
                            <div class="text-center">
                                <div class="text-xs font-medium text-gray-500">Silver</div>
                                <div class="text-sm font-semibold text-gray-700">4</div>
                            </div>
                            <div class="text-center">
                                <div class="text-xs font-medium text-gray-500">Bronze</div>
                                <div class="text-sm font-semibold text-gray-700">3</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-layouts.admin>
</div>
