<div>
    <x-layouts.admin>
        
        <div class="flex min-h-screen" x-data="{ currentTab: 'schedule' }">
            <div class="lg:hidden fixed top-4 left-4 z-50">
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl border border-gray-200/50 dark:border-gray-700/50">
                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

            <!-- Side Profile Panel -->
            <div
                class="w-80 bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl border-r border-gray-200/50 rounded-md dark:border-gray-700/50">
                <!-- Profile Section -->
                <div class="p-6">
                    <div class="flex flex-col items-center">
                        <!-- Profile Image -->
                        <div class="relative group">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full blur-xl opacity-40 group-hover:opacity-75 transition-all duration-300 scale-105">
                            </div>
                            <div class="relative">
                                <div class="p-1 rounded-full bg-gradient-to-r from-blue-500 to-indigo-500">
                                    <div class="relative rounded-full p-1 bg-white dark:bg-gray-900">
                                        <img src="{{ asset($user->image) }}" class="w-32 h-32 rounded-full object-cover"
                                            alt="Employee Photo">
                                        <div class="absolute bottom-2 right-2">
                                            <div
                                                class="w-4 h-4 rounded-full bg-emerald-500 ring-2 ring-white dark:ring-gray-900">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Basic Info -->
                        <h1 class="mt-4 text-xl font-bold text-gray-900 dark:text-white">Alfred Bode MD</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Senior Medical Officer</p>
                        <span
                            class="mt-2 px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                            Department: Cardiology
                        </span>
                    </div>

                    <!-- Quick Navigation -->
                    <nav class="mt-8 space-y-1">
                        <button @click="currentTab = 'overview'"
                            :class="{ 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300': currentTab === 'overview' }"
                            class="w-full flex items-center px-4 py-2 text-sm font-medium rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                            Overview
                        </button>

                        <button @click="currentTab = 'schedule'"
                            :class="{ 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300': currentTab === 'schedule' }"
                            class="w-full flex items-center px-4 py-2 text-sm font-medium rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Schedule
                        </button>

                        <button @click="currentTab = 'tasks'"
                            :class="{ 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300': currentTab === 'tasks' }"
                            class="w-full flex items-center px-4 py-2 text-sm font-medium rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Tasks
                        </button>

                        <button @click="currentTab = 'personal'"
                            :class="{ 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300': currentTab === 'personal' }"
                            class="w-full flex items-center px-4 py-2 text-sm font-medium rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Personal Info
                        </button>

                        <button @click="currentTab = 'files'"
                            :class="{ 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300': currentTab === 'files' }"
                            class="w-full flex items-center px-4 py-2 text-sm font-medium rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                            Files
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 overflow-auto">

                <!-- Dynamic Content Area -->
                <div class="p-8">
                    <!-- Overview Tab -->
                    <div x-show="currentTab === 'overview'" x-cloak>
                        <!-- Stats Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                            <!-- Performance Stats -->
                            <div
                                class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-xl p-6 border border-gray-100 dark:border-gray-800 hover:border-blue-200 dark:hover:border-blue-900/50 transition-colors group">
                                <div class="flex items-center justify-between mb-4">
                                    <div
                                        class="p-3 rounded-lg bg-blue-100 dark:bg-blue-900/30 group-hover:bg-blue-200 dark:group-hover:bg-blue-900/50 transition-colors">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                    </div>
                                </div>
                                <h4
                                    class="text-2xl font-bold text-gray-900 dark:text-white group-hover:text-blue-600 transition-colors">
                                    95%</h4>
                                <p class="text-gray-600 dark:text-gray-400">Task Completion</p>
                                <div class="mt-4 flex items-center text-sm text-blue-600">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                    <span>5% from last month</span>
                                </div>
                            </div>

                            <!-- Projects Stats -->
                            <div
                                class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-xl p-6 border border-gray-100 dark:border-gray-800 hover:border-purple-200 dark:hover:border-purple-900/50 transition-colors group">
                                <div class="flex items-center justify-between mb-4">
                                    <div
                                        class="p-3 rounded-lg bg-purple-100 dark:bg-purple-900/30 group-hover:bg-purple-200 dark:group-hover:bg-purple-900/50 transition-colors">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                                        </svg>
                                    </div>
                                </div>
                                <h4
                                    class="text-2xl font-bold text-gray-900 dark:text-white group-hover:text-purple-600 transition-colors">
                                    8</h4>
                                <p class="text-gray-600 dark:text-gray-400">Active Projects</p>
                                <div class="mt-4 flex items-center text-sm text-purple-600">
                                    <span>3 completed this month</span>
                                </div>
                            </div>

                            <!-- Attendance Stats -->
                            <div
                                class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-xl p-6 border border-gray-100 dark:border-gray-800 hover:border-emerald-200 dark:hover:border-emerald-900/50 transition-colors group">
                                <div class="flex items-center justify-between mb-4">
                                    <div
                                        class="p-3 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 group-hover:bg-emerald-200 dark:group-hover:bg-emerald-900/50 transition-colors">
                                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                                <h4
                                    class="text-2xl font-bold text-gray-900 dark:text-white group-hover:text-emerald-600 transition-colors">
                                    98%</h4>
                                <p class="text-gray-600 dark:text-gray-400">Attendance Rate</p>
                                <div class="mt-4 flex items-center text-sm text-emerald-600">
                                    <span>On-time record: 100%</span>
                                </div>
                            </div>

                            <!-- Performance Review -->
                            <div
                                class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-xl p-6 border border-gray-100 dark:border-gray-800 hover:border-amber-200 dark:hover:border-amber-900/50 transition-colors group">
                                <div class="flex items-center justify-between mb-4">
                                    <div
                                        class="p-3 rounded-lg bg-amber-100 dark:bg-amber-900/30 group-hover:bg-amber-200 dark:group-hover:bg-amber-900/50 transition-colors">
                                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                        </svg>
                                    </div>
                                </div>
                                <h4
                                    class="text-2xl font-bold text-gray-900 dark:text-white group-hover:text-amber-600 transition-colors">
                                    4.8/5</h4>
                                <p class="text-gray-600 dark:text-gray-400">Performance Score</p>
                                <div class="mt-4 flex items-center text-sm text-amber-600">
                                    <span>Last review: Jan 2024</span>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activity -->
                        <div
                            class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-xl p-6 mb-8 border border-gray-100 dark:border-gray-800">
                            <!-- Header -->
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Activity</h3>
                                <div class="flex items-center gap-2">
                                    <button
                                        class="px-3 py-1 text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                                        Filter
                                        <svg class="w-4 h-4 inline-block ml-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                        </svg>
                                    </button>
                                    <button
                                        class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                        View All
                                    </button>
                                </div>
                            </div>

                            <!-- Activity List -->
                            <div class="space-y-6">
                                <!-- Project Update Activity -->
                                <div class="flex items-start space-x-4">
                                    <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">Project
                                                    Update: E-commerce Platform</p>
                                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Completed
                                                    sprint review and updated project timeline</p>
                                            </div>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">2 hours ago</span>
                                        </div>
                                        <div class="mt-2 flex items-center gap-2">
                                            <span
                                                class="px-2 py-1 text-xs rounded-full bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">Sprint
                                                3</span>
                                            <span
                                                class="px-2 py-1 text-xs rounded-full bg-green-50 text-green-600 dark:bg-green-900/30 dark:text-green-400">On
                                                Track</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Task Completion Activity -->
                                <div class="flex items-start space-x-4">
                                    <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">Completed
                                                    API Documentation</p>
                                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Finalized and
                                                    submitted documentation for review</p>
                                            </div>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">Yesterday</span>
                                        </div>
                                        <div class="mt-2 flex items-center gap-2">
                                            <span
                                                class="px-2 py-1 text-xs rounded-full bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400">Documentation</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Meeting Activity -->
                                <div class="flex items-start space-x-4">
                                    <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">Team Sync
                                                    Meeting</p>
                                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Participated
                                                    in weekly team sync and planning</p>
                                            </div>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">2 days ago</span>
                                        </div>
                                        <div class="mt-2 flex items-center gap-2">
                                            <span
                                                class="px-2 py-1 text-xs rounded-full bg-purple-50 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400">Team
                                                Meeting</span>
                                            <span
                                                class="inline-flex items-center text-xs text-gray-500 dark:text-gray-400">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                </svg>
                                                8 participants
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Code Review Activity -->
                                <div class="flex items-start space-x-4">
                                    <div class="p-2 bg-amber-100 dark:bg-amber-900/30 rounded-lg">
                                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">Code
                                                    Review Completed</p>
                                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Reviewed and
                                                    approved authentication module PR</p>
                                            </div>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">3 days ago</span>
                                        </div>
                                        <div class="mt-2 flex items-center gap-2">
                                            <span
                                                class="px-2 py-1 text-xs rounded-full bg-amber-50 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400">Code
                                                Review</span>
                                            <span
                                                class="px-2 py-1 text-xs rounded-full bg-green-50 text-green-600 dark:bg-green-900/30 dark:text-green-400">Approved</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Load More Button -->
                            <div class="mt-6 text-center">
                                <button
                                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                                    Load More Activities
                                    <svg class="w-4 h-4 inline-block ml-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Schedule Tab -->
                    <div x-show="currentTab === 'schedule'" x-cloak>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Today's Schedule -->
                            <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-xl p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Today's Schedule
                                </h3>
                                <div class="space-y-4">
                                    <div class="flex space-x-4">
                                        <div class="w-20 text-sm text-gray-600 dark:text-gray-400">
                                            09:00 AM
                                        </div>
                                        <div class="flex-1 bg-blue-50 dark:bg-blue-900/30 rounded-lg p-3">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">Morning Rounds
                                            </p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">Ward 3, Floor 2</p>
                                        </div>
                                    </div>
                                    <!-- Add more schedule items -->
                                </div>
                            </div>

                            <!-- Upcoming Appointments -->
                            <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-xl p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Upcoming
                                    Appointments</h3>
                                <div class="space-y-4">
                                    <div
                                        class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white">Sarah Johnson</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Follow-up Consultation
                                            </p>
                                        </div>
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Tomorrow, 10:00
                                            AM</span>
                                    </div>
                                    <!-- Add more appointments -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tasks Tab -->
                    <div x-show="currentTab === 'tasks'" x-cloak>
                        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-xl p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Current Tasks</h3>
                                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">Add New
                                    Task</button>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                                    <input type="checkbox" class="mr-4">
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900 dark:text-white">Review Patient Reports</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Due Today</p>
                                    </div>
                                    <span
                                        class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">High
                                        Priority</span>
                                </div>
                                <!-- Add more tasks -->
                            </div>
                        </div>
                    </div>

                    <!-- Personal Info Tab -->
                    <div x-show="currentTab === 'personal'" x-cloak>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Basic Information -->
                            <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-xl p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Basic Information
                                </h3>
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="text-sm text-gray-600 dark:text-gray-400">Full Name</label>
                                            <p class="text-gray-900 dark:text-white">Dr. Alfred Bode</p>
                                        </div>
                                        <div>
                                            <label class="text-sm text-gray-600 dark:text-gray-400">Employee ID</label>
                                            <p class="text-gray-900 dark:text-white">EMP001</p>
                                        </div>
                                        <!-- Add more personal details -->
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-xl p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Contact
                                    Information</h3>
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="text-sm text-gray-600 dark:text-gray-400">Email</label>
                                            <p class="text-gray-900 dark:text-white">alfred.bode@hospital.com</p>
                                        </div>
                                        <div>
                                            <label class="text-sm text-gray-600 dark:text-gray-400">Phone</label>
                                            <p class="text-gray-900 dark:text-white">+1 (555) 123-4567</p>
                                        </div>
                                        <!-- Add more contact details -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Files Tab -->
                    <div x-show="currentTab === 'files'" x-cloak>
                        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-xl p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Documents & Files</h3>
                                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">Upload New
                                    File</button>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <!-- File Card -->
                                <div class="p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">Medical
                                                License</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">PDF • 2.4 MB</p>
                                        </div>
                                        <button class="p-2 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-lg">
                                            <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <!-- Add more file cards -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-layouts.admin>
</div>
