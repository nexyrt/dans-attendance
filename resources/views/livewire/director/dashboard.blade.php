<!-- resources/views/livewire/director/dashboard.blade.php -->
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
    <!-- Enhanced Header with Glassmorphism -->
    <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-lg border-b border-white/20 shadow-lg shadow-black/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-chart-line text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">
                            Executive Dashboard
                        </h1>
                        <p class="text-sm text-gray-500 mt-1">Real-time insights for strategic decisions</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2 bg-emerald-50 text-emerald-700 px-4 py-2 rounded-xl border border-emerald-200">
                        <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                        <span class="text-sm font-medium">Live Data</span>
                    </div>
                    <div class="text-sm text-gray-500 bg-white/60 px-3 py-2 rounded-lg">
                        Updated: <span class="font-medium text-gray-900">2 min ago</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        <!-- Enhanced Executive Summary Cards with Animations -->
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- In Office Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent"></div>
                <div class="absolute -top-4 -right-4 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                            <i class="fas fa-users text-white text-2xl"></i>
                        </div>
                        <div class="text-right">
                            <div class="w-16 h-2 bg-white/30 rounded-full overflow-hidden">
                                <div class="w-[90%] h-full bg-white rounded-full"></div>
                            </div>
                            <span class="text-xs text-blue-100 mt-1">90% Capacity</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-blue-100 text-sm font-medium mb-2">In Office Now</p>
                        <p class="text-4xl font-bold text-white mb-1">47<span class="text-xl text-blue-200">/52</span></p>
                        <p class="text-blue-100 text-xs">Excellent attendance today</p>
                    </div>
                </div>
            </div>

            <!-- Payroll Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-emerald-500 via-emerald-600 to-emerald-700 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent"></div>
                <div class="absolute -top-4 -right-4 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                            <i class="fas fa-dollar-sign text-white text-2xl"></i>
                        </div>
                        <div class="flex items-center text-emerald-100 text-sm">
                            <i class="fas fa-arrow-up text-xs mr-1"></i>
                            <span>+2.3%</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-emerald-100 text-sm font-medium mb-2">Monthly Payroll</p>
                        <p class="text-4xl font-bold text-white mb-1">$87.5K</p>
                        <p class="text-emerald-100 text-xs">vs. last month</p>
                    </div>
                </div>
            </div>

            <!-- Pending Approvals Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-amber-500 via-amber-600 to-orange-600 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent"></div>
                <div class="absolute -top-4 -right-4 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                            <i class="fas fa-clock text-white text-2xl"></i>
                        </div>
                        <div class="flex space-x-1">
                            <div class="w-2 h-2 bg-red-400 rounded-full animate-pulse"></div>
                            <div class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse animation-delay-150"></div>
                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse animation-delay-300"></div>
                        </div>
                    </div>
                    <div>
                        <p class="text-amber-100 text-sm font-medium mb-2">Pending Approvals</p>
                        <p class="text-4xl font-bold text-white mb-1">8</p>
                        <p class="text-amber-100 text-xs">3 urgent, 5 regular</p>
                    </div>
                </div>
            </div>

            <!-- Company Health Card -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-purple-500 via-purple-600 to-indigo-600 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent"></div>
                <div class="absolute -top-4 -right-4 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                            <i class="fas fa-heartbeat text-white text-2xl"></i>
                        </div>
                        <div class="w-12 h-12 relative">
                            <svg class="w-12 h-12 transform -rotate-90" viewBox="0 0 36 36">
                                <circle cx="18" cy="18" r="14" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="3"/>
                                <circle cx="18" cy="18" r="14" fill="none" stroke="white" stroke-width="3" 
                                        stroke-dasharray="74" stroke-dashoffset="14" stroke-linecap="round"/>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-xs font-bold text-white">84%</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p class="text-purple-100 text-sm font-medium mb-2">Company Health</p>
                        <p class="text-4xl font-bold text-white mb-1">8.4<span class="text-xl text-purple-200">/10</span></p>
                        <p class="text-purple-100 text-xs">Excellent performance</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Enhanced Today's Attendance Section -->
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Enhanced Attendance Table -->
            <div class="lg:col-span-2 bg-white/70 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-1">Today's Attendance</h2>
                            <p class="text-sm text-gray-500">Real-time employee status monitoring</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center space-x-2 bg-green-50 px-3 py-1 rounded-lg">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                <span class="text-xs text-green-700 font-medium">On Time</span>
                            </div>
                            <div class="flex items-center space-x-2 bg-red-50 px-3 py-1 rounded-lg">
                                <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                <span class="text-xs text-red-700 font-medium">Late</span>
                            </div>
                            <div class="flex items-center space-x-2 bg-gray-50 px-3 py-1 rounded-lg">
                                <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                                <span class="text-xs text-gray-700 font-medium">Absent</span>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Filter Tabs -->
                    <div class="flex space-x-2 bg-gray-50 rounded-xl p-2">
                        <button id="tab-all" class="tab-btn flex-1 py-3 px-4 text-sm font-semibold rounded-lg bg-white text-blue-600 shadow-sm border border-blue-100 transition-all duration-200">
                            <div class="flex items-center justify-center space-x-2">
                                <span>All</span>
                                <span class="bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full text-xs">47</span>
                            </div>
                        </button>
                        <button id="tab-ontime" class="tab-btn flex-1 py-3 px-4 text-sm font-semibold rounded-lg text-gray-600 hover:text-gray-900 hover:bg-white/50 transition-all duration-200">
                            <div class="flex items-center justify-center space-x-2">
                                <span>On Time</span>
                                <span class="bg-green-100 text-green-600 px-2 py-0.5 rounded-full text-xs">35</span>
                            </div>
                        </button>
                        <button id="tab-late" class="tab-btn flex-1 py-3 px-4 text-sm font-semibold rounded-lg text-gray-600 hover:text-gray-900 hover:bg-white/50 transition-all duration-200">
                            <div class="flex items-center justify-center space-x-2">
                                <span>Late</span>
                                <span class="bg-red-100 text-red-600 px-2 py-0.5 rounded-full text-xs">7</span>
                            </div>
                        </button>
                        <button id="tab-absent" class="tab-btn flex-1 py-3 px-4 text-sm font-semibold rounded-lg text-gray-600 hover:text-gray-900 hover:bg-white/50 transition-all duration-200">
                            <div class="flex items-center justify-center space-x-2">
                                <span>Absent</span>
                                <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full text-xs">5</span>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Enhanced Table -->
                <div class="overflow-hidden">
                    <div class="max-h-96 overflow-y-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50/80 sticky top-0 backdrop-blur-sm">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Employee</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Department</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Check In</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Hours</th>
                                </tr>
                            </thead>
                            <tbody id="attendance-table-body" class="divide-y divide-gray-100">
                                <!-- Enhanced Employee Rows -->
                                <tr class="attendance-row on-time hover:bg-blue-50/50 transition-colors duration-200 group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="relative">
                                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg">
                                                    JD
                                                </div>
                                                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-gray-900">John Doe</div>
                                                <div class="text-sm text-gray-500">Senior Developer</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                            Digital Marketing
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">08:15 AM</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                            On Time
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">8.2h</td>
                                </tr>

                                <tr class="attendance-row on-time hover:bg-blue-50/50 transition-colors duration-200 group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="relative">
                                                <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg">
                                                    JS
                                                </div>
                                                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-gray-900">Jane Smith</div>
                                                <div class="text-sm text-gray-500">Marketing Manager</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                            Digital Marketing
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">08:00 AM</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                            On Time
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">8.5h</td>
                                </tr>

                                <!-- Late Employees -->
                                <tr class="attendance-row late hover:bg-red-50/50 transition-colors duration-200 group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="relative">
                                                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg">
                                                    MJ
                                                </div>
                                                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-red-500 rounded-full border-2 border-white"></div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-gray-900">Mike Johnson</div>
                                                <div class="text-sm text-gray-500">Project Manager</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-purple-50 text-purple-700 border border-purple-200">
                                            Detax
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">09:25 AM</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-red-100 text-red-800 border border-red-200">
                                            <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                                            Late (1h 25m)
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">6.8h</td>
                                </tr>

                                <tr class="attendance-row late hover:bg-red-50/50 transition-colors duration-200 group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="relative">
                                                <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg">
                                                    SW
                                                </div>
                                                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-yellow-500 rounded-full border-2 border-white"></div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-gray-900">Sarah Wilson</div>
                                                <div class="text-sm text-gray-500">HR Specialist</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-200">
                                            HR
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">08:45 AM</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                            <div class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></div>
                                            Late (45m)
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">7.5h</td>
                                </tr>

                                <!-- Absent Employees -->
                                <tr class="attendance-row absent hover:bg-gray-50/50 transition-colors duration-200 group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="relative">
                                                <div class="w-12 h-12 bg-gradient-to-br from-gray-400 to-gray-500 rounded-xl flex items-center justify-center text-white font-bold shadow-lg">
                                                    ED
                                                </div>
                                                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-gray-400 rounded-full border-2 border-white"></div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-gray-900">Emily Davis</div>
                                                <div class="text-sm text-gray-500">Content Writer</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                            Digital Marketing
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-gray-100 text-gray-800 border border-gray-200">
                                            <div class="w-2 h-2 bg-gray-500 rounded-full mr-2"></div>
                                            Absent (Sick Leave)
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">0h</td>
                                </tr>

                                <tr class="attendance-row absent hover:bg-gray-50/50 transition-colors duration-200 group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="relative">
                                                <div class="w-12 h-12 bg-gradient-to-br from-gray-400 to-gray-500 rounded-xl flex items-center justify-center text-white font-bold shadow-lg">
                                                    RK
                                                </div>
                                                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-gray-400 rounded-full border-2 border-white"></div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-gray-900">Robert Kim</div>
                                                <div class="text-sm text-gray-500">UI Designer</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-teal-50 text-teal-700 border border-teal-200">
                                            Sydital
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-gray-100 text-gray-800 border border-gray-200">
                                            <div class="w-2 h-2 bg-gray-500 rounded-full mr-2"></div>
                                            Absent (Annual Leave)
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">0h</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Enhanced Table Summary -->
                <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100">
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center space-x-4">
                            <span class="text-gray-600">Showing <span id="showing-count" class="font-semibold text-gray-900">6</span> of <span class="font-semibold">52</span> employees</span>
                        </div>
                        <div class="flex items-center space-x-6">
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                <span class="text-gray-600">Avg Check-in: <span class="font-semibold text-gray-900">8:15 AM</span></span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                <span class="text-gray-600">On-time Rate: <span class="font-semibold text-green-600">74%</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Charts Section -->
            <div class="space-y-6">
                <!-- Attendance Overview Chart -->
                <div class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Today's Overview</h3>
                        <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                    </div>
                    <div id="attendance-donut-chart" class="h-64">
                        </div>

                <!-- Check-in Time Chart -->
                <div class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Check-in Times</h3>
                        <div class="flex items-center space-x-2 text-sm text-gray-500">
                            <i class="fas fa-clock text-xs"></i>
                            <span>Peak: 8-9 AM</span>
                        </div>
                    </div>
                    <div id="checkin-time-chart" class="h-48"></div>
                </div>
            </div>
        </section>

        <!-- Enhanced Analytics Section -->
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Attendance Trends -->
            <div class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">7-Day Attendance Trends</h2>
                        <p class="text-sm text-gray-500 mt-1">Weekly performance overview</p>
                    </div>
                    <div class="flex items-center space-x-2 bg-blue-50 px-3 py-2 rounded-lg">
                        <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                        <span class="text-xs font-medium text-blue-700">Trending Up</span>
                    </div>
                </div>
                <div id="attendance-trend-chart" class="h-64"></div>
            </div>

            <!-- Productivity Hours -->
            <div class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Peak Productivity Hours</h2>
                        <p class="text-sm text-gray-500 mt-1">Optimal working time analysis</p>
                    </div>
                    <div class="flex items-center space-x-2 bg-purple-50 px-3 py-2 rounded-lg">
                        <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                        <span class="text-xs font-medium text-purple-700">9 AM Peak</span>
                    </div>
                </div>
                <div id="productivity-hours-chart" class="h-64"></div>
            </div>
        </section>

        <!-- Enhanced Department Performance -->
        <section class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Department Performance</h2>
                    <p class="text-sm text-gray-500 mt-1">Comprehensive departmental analysis</p>
                </div>
                <div class="flex items-center space-x-2">
                    <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium text-gray-700 transition-colors duration-200">
                        <i class="fas fa-download mr-2"></i>Export
                    </button>
                    <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-sm font-medium text-white transition-colors duration-200">
                        <i class="fas fa-eye mr-2"></i>View Details
                    </button>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Digital Marketing Department -->
                <div class="group relative overflow-hidden bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border border-blue-200 p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute top-4 right-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                            Excellent
                        </span>
                    </div>
                    <div class="mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white mb-3">
                            <i class="fas fa-bullhorn text-xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Digital Marketing</h3>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Attendance Rate</span>
                            <div class="flex items-center space-x-2">
                                <div class="w-16 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="w-[94%] h-full bg-green-500 rounded-full"></div>
                                </div>
                                <span class="text-sm font-semibold text-green-600">94%</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Team Size</span>
                            <span class="text-sm font-semibold text-gray-900">15 people</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Avg Hours</span>
                            <span class="text-sm font-semibold text-gray-900">8.2h/day</span>
                        </div>
                        <div class="pt-2 border-t border-blue-200">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-500">Performance Score</span>
                                <div class="flex items-center space-x-1">
                                    <div class="flex space-x-1">
                                        <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                        <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                        <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                        <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                        <div class="w-2 h-2 bg-blue-300 rounded-full"></div>
                                    </div>
                                    <span class="text-xs font-medium text-blue-600">4.2/5</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sydital Department -->
                <div class="group relative overflow-hidden bg-gradient-to-br from-teal-50 to-teal-100 rounded-xl border border-teal-200 p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute top-4 right-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">
                            <div class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></div>
                            Good
                        </span>
                    </div>
                    <div class="mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center text-white mb-3">
                            <i class="fas fa-code text-xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Sydital</h3>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Attendance Rate</span>
                            <div class="flex items-center space-x-2">
                                <div class="w-16 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="w-[87%] h-full bg-yellow-500 rounded-full"></div>
                                </div>
                                <span class="text-sm font-semibold text-yellow-600">87%</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Team Size</span>
                            <span class="text-sm font-semibold text-gray-900">18 people</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Avg Hours</span>
                            <span class="text-sm font-semibold text-gray-900">7.8h/day</span>
                        </div>
                        <div class="pt-2 border-t border-teal-200">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-500">Performance Score</span>
                                <div class="flex items-center space-x-1">
                                    <div class="flex space-x-1">
                                        <div class="w-2 h-2 bg-teal-500 rounded-full"></div>
                                        <div class="w-2 h-2 bg-teal-500 rounded-full"></div>
                                        <div class="w-2 h-2 bg-teal-500 rounded-full"></div>
                                        <div class="w-2 h-2 bg-teal-300 rounded-full"></div>
                                        <div class="w-2 h-2 bg-teal-200 rounded-full"></div>
                                    </div>
                                    <span class="text-xs font-medium text-teal-600">3.6/5</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detax Department -->
                <div class="group relative overflow-hidden bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl border border-purple-200 p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute top-4 right-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                            Excellent
                        </span>
                    </div>
                    <div class="mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center text-white mb-3">
                            <i class="fas fa-calculator text-xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Detax</h3>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Attendance Rate</span>
                            <div class="flex items-center space-x-2">
                                <div class="w-16 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="w-[96%] h-full bg-green-500 rounded-full"></div>
                                </div>
                                <span class="text-sm font-semibold text-green-600">96%</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Team Size</span>
                            <span class="text-sm font-semibold text-gray-900">12 people</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Avg Hours</span>
                            <span class="text-sm font-semibold text-gray-900">8.5h/day</span>
                        </div>
                        <div class="pt-2 border-t border-purple-200">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-500">Performance Score</span>
                                <div class="flex items-center space-x-1">
                                    <div class="flex space-x-1">
                                        <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                                        <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                                        <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                                        <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                                        <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                                    </div>
                                    <span class="text-xs font-medium text-purple-600">4.8/5</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- HR Department -->
                <div class="group relative overflow-hidden bg-gradient-to-br from-red-50 to-red-100 rounded-xl border border-red-200 p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute top-4 right-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 border border-red-200">
                            <div class="w-2 h-2 bg-red-500 rounded-full mr-2 animate-pulse"></div>
                            Needs Attention
                        </span>
                    </div>
                    <div class="mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center text-white mb-3">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">HR</h3>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Attendance Rate</span>
                            <div class="flex items-center space-x-2">
                                <div class="w-16 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="w-[78%] h-full bg-red-500 rounded-full"></div>
                                </div>
                                <span class="text-sm font-semibold text-red-600">78%</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Team Size</span>
                            <span class="text-sm font-semibold text-gray-900">7 people</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Avg Hours</span>
                            <span class="text-sm font-semibold text-gray-900">7.2h/day</span>
                        </div>
                        <div class="pt-2 border-t border-red-200">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-500">Performance Score</span>
                                <div class="flex items-center space-x-1">
                                    <div class="flex space-x-1">
                                        <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                        <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                        <div class="w-2 h-2 bg-red-300 rounded-full"></div>
                                        <div class="w-2 h-2 bg-red-200 rounded-full"></div>
                                        <div class="w-2 h-2 bg-red-200 rounded-full"></div>
                                    </div>
                                    <span class="text-xs font-medium text-red-600">2.8/5</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Quick Actions & Insights -->
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Quick Actions -->
            <div class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Quick Actions</h3>
                <div class="space-y-3">
                    <button class="w-full flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 rounded-xl border border-blue-200 transition-all duration-200 group">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-download text-white"></i>
                            </div>
                            <div class="text-left">
                                <div class="font-semibold text-blue-900">Export Report</div>
                                <div class="text-xs text-blue-600">Monthly attendance data</div>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-blue-400 group-hover:text-blue-600 transition-colors duration-200"></i>
                    </button>

                    <button class="w-full flex items-center justify-between p-4 bg-gradient-to-r from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 rounded-xl border border-green-200 transition-all duration-200 group">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-white"></i>
                            </div>
                            <div class="text-left">
                                <div class="font-semibold text-green-900">Team Meeting</div>
                                <div class="text-xs text-green-600">Schedule with managers</div>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-green-400 group-hover:text-green-600 transition-colors duration-200"></i>
                    </button>

                    <button class="w-full flex items-center justify-between p-4 bg-gradient-to-r from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 rounded-xl border border-purple-200 transition-all duration-200 group">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-chart-line text-white"></i>
                            </div>
                            <div class="text-left">
                                <div class="font-semibold text-purple-900">Analytics</div>
                                <div class="text-xs text-purple-600">Detailed insights</div>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-purple-400 group-hover:text-purple-600 transition-colors duration-200"></i>
                    </button>
                </div>
            </div>

            <!-- System Status -->
            <div class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6">System Status</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg border border-green-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            <span class="font-medium text-green-900">All Systems</span>
                        </div>
                        <span class="text-sm text-green-600">Operational</span>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                            <span class="font-medium text-blue-900">Data Sync</span>
                        </div>
                        <span class="text-sm text-blue-600">Real-time</span>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
                            <span class="font-medium text-gray-900">Last Backup</span>
                        </div>
                        <span class="text-sm text-gray-600">2 hours ago</span>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Recent Activity</h3>
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-2 h-2 bg-red-500 rounded-full mt-2"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">High overtime detected</p>
                            <p class="text-xs text-gray-500">Mike Johnson - 15h this week</p>
                            <p class="text-xs text-gray-400">2 min ago</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-3">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full mt-2"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Leave request submitted</p>
                            <p class="text-xs text-gray-500">Sarah Wilson - Annual leave</p>
                            <p class="text-xs text-gray-400">15 min ago</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-3">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Department meeting</p>
                            <p class="text-xs text-gray-500">All Hands - Dec 15, 2:00 PM</p>
                            <p class="text-xs text-gray-400">1 hour ago</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Enhanced JavaScript with Better Animations -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize with staggered animations
            initializeWithAnimations();
            initializeCharts();
            initializeTabs();
            initializeRealTimeUpdates();
        });

        function initializeWithAnimations() {
            // Animate cards on load
            const cards = document.querySelectorAll('section > div');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        }

        function initializeCharts() {
            // Enhanced Attendance Donut Chart
            const attendanceDonutChart = new ApexCharts(document.querySelector("#attendance-donut-chart"), {
                series: [35, 7, 5, 5],
                chart: {
                    type: 'donut',
                    height: 250,
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800,
                        animateGradually: {
                            enabled: true,
                            delay: 150
                        },
                        dynamicAnimation: {
                            enabled: true,
                            speed: 350
                        }
                    }
                },
                labels: ['On Time', 'Late', 'Absent', 'Not Checked In'],
                colors: ['#10B981', '#F59E0B', '#EF4444', '#9CA3AF'],
                legend: {
                    position: 'bottom',
                    fontSize: '12px',
                    fontWeight: 500
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%',
                            labels: {
                                show: true,
                                name: {
                                    show: true,
                                    fontSize: '14px',
                                    fontWeight: 600,
                                    color: '#374151'
                                },
                                value: {
                                    show: true,
                                    fontSize: '24px',
                                    fontWeight: 700,
                                    color: '#111827'
                                }
                            }
                        }
                    }
                },
                dataLabels: { enabled: false },
                stroke: { width: 0 },
                tooltip: {
                    style: {
                        fontSize: '12px'
                    }
                }
            });
            attendanceDonutChart.render();

            // Enhanced Check-in Time Chart
            const checkinTimeChart = new ApexCharts(document.querySelector("#checkin-time-chart"), {
                series: [{
                    name: 'Employees',
                    data: [2, 8, 15, 12, 7, 3, 0, 0]
                }],
                chart: {
                    type: 'bar',
                    height: 180,
                    toolbar: { show: false },
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800
                    }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 6,
                        columnWidth: '60%',
                        colors: {
                            ranges: [{
                                from: 0,
                                to: 5,
                                color: '#EF4444'
                            }, {
                                from: 6,
                                to: 10,
                                color: '#F59E0B'
                            }, {
                                from: 11,
                                to: 20,
                                color: '#10B981'
                            }]
                        }
                    }
                },
                dataLabels: { enabled: false },
                xaxis: {
                    categories: ['7:00-7:30', '7:30-8:00', '8:00-8:30', '8:30-9:00', '9:00-9:30', '9:30-10:00', '10:00-10:30', '10:30+'],
                    labels: {
                        style: { fontSize: '11px', fontWeight: 500 }
                    }
                },
                yaxis: {
                    labels: {
                        style: { fontSize: '11px' }
                    }
                },
                colors: ['#3B82F6'],
                grid: {
                    borderColor: '#E5E7EB',
                    strokeDashArray: 3
                }
            });
            checkinTimeChart.render();

            // Enhanced Attendance Trend Chart
            const attendanceTrendChart = new ApexCharts(document.querySelector("#attendance-trend-chart"), {
                series: [{
                    name: 'Present',
                    data: [49, 50, 48, 49, 44, 13, 8]
                }, {
                    name: 'Late',
                    data: [3, 2, 4, 3, 8, 2, 1]
                }],
                chart: {
                    type: 'line',
                    height: 250,
                    toolbar: { show: false },
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800,
                        animateGradually: {
                            enabled: true,
                            delay: 150
                        }
                    }
                },
                colors: ['#10B981', '#F59E0B'],
                dataLabels: { enabled: false },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                xaxis: {
                    categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    labels: {
                        style: { fontSize: '12px', fontWeight: 500 }
                    }
                },
                yaxis: {
                    labels: {
                        style: { fontSize: '11px' }
                    }
                },
                legend: {
                    position: 'top',
                    fontSize: '12px',
                    fontWeight: 500
                },
                grid: {
                    borderColor: '#E5E7EB',
                    strokeDashArray: 3
                },
                markers: {
                    size: 4,
                    strokeWidth: 2,
                    fillOpacity: 1,
                    strokeOpacity: 1,
                    hover: {
                        size: 6
                    }
                }
            });
            attendanceTrendChart.render();

            // Enhanced Productivity Hours Chart
            const productivityHoursChart = new ApexCharts(document.querySelector("#productivity-hours-chart"), {
                series: [{
                    name: 'Productivity %',
                    data: [5, 25, 70, 95, 85, 60, 30, 40, 75, 85, 65, 45]
                }],
                chart: {
                    type: 'area',
                    height: 250,
                    toolbar: { show: false },
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800
                    }
                },
                colors: ['#8B5CF6'],
                dataLabels: { enabled: false },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0.1,
                        stops: [0, 90, 100],
                        colorStops: [
                            {
                                offset: 0,
                                color: '#8B5CF6',
                                opacity: 0.4
                            },
                            {
                                offset: 100,
                                color: '#8B5CF6',
                                opacity: 0.1
                            }
                        ]
                    }
                },
                xaxis: {
                    categories: ['6 AM', '7 AM', '8 AM', '9 AM', '10 AM', '11 AM', '12 PM', '1 PM', '2 PM', '3 PM', '4 PM', '5 PM'],
                    labels: {
                        style: { fontSize: '11px', fontWeight: 500 }
                    }
                },
                yaxis: {
                    min: 0,
                    max: 100,
                    labels: {
                        style: { fontSize: '11px' },
                        formatter: function(val) {
                            return val + '%';
                        }
                    }
                },
                grid: {
                    borderColor: '#E5E7EB',
                    strokeDashArray: 3
                },
                annotations: {
                    yaxis: [{
                        y: 80,
                        borderColor: '#10B981',
                        strokeDashArray: 5,
                        label: {
                            borderColor: '#10B981',
                            style: {
                                color: '#fff',
                                background: '#10B981',
                                fontSize: '11px',
                                fontWeight: 600
                            },
                            text: 'Peak Threshold (80%)'
                        }
                    }]
                },
                tooltip: {
                    style: {
                        fontSize: '12px'
                    },
                    y: {
                        formatter: function(val) {
                            return val + '%';
                        }
                    }
                }
            });
            productivityHoursChart.render();
        }

        function initializeTabs() {
            const tabButtons = document.querySelectorAll('.tab-btn');
            const attendanceRows = document.querySelectorAll('.attendance-row');
            const showingCount = document.getElementById('showing-count');

            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Enhanced tab switching with animations
                    tabButtons.forEach(btn => {
                        btn.classList.remove('bg-white', 'text-blue-600', 'shadow-sm', 'border', 'border-blue-100');
                        btn.classList.add('text-gray-600');
                    });

                    this.classList.add('bg-white', 'text-blue-600', 'shadow-sm', 'border', 'border-blue-100');
                    this.classList.remove('text-gray-600');

                    // Filter rows with fade animation
                    const filter = this.id.replace('tab-', '');
                    let visibleCount = 0;

                    attendanceRows.forEach((row, index) => {
                        row.style.transition = 'all 0.3s ease';
                        
                        if (filter === 'all') {
                            setTimeout(() => {
                                row.style.display = '';
                                row.style.opacity = '1';
                                row.style.transform = 'translateY(0)';
                            }, index * 50);
                            visibleCount++;
                        } else if (row.classList.contains(filter === 'ontime' ? 'on-time' : filter)) {
                            setTimeout(() => {
                                row.style.display = '';
                                row.style.opacity = '1';
                                row.style.transform = 'translateY(0)';
                            }, index * 50);
                            visibleCount++;
                        } else {
                            row.style.opacity = '0';
                            row.style.transform = 'translateY(-10px)';
                            setTimeout(() => {
                                row.style.display = 'none';
                            }, 200);
                        }
                    });

                    // Animate count change
                    setTimeout(() => {
                        showingCount.style.transition = 'all 0.3s ease';
                        showingCount.style.transform = 'scale(1.1)';
                        showingCount.textContent = visibleCount;
                        setTimeout(() => {
                            showingCount.style.transform = 'scale(1)';
                        }, 200);
                    }, 300);
                });
            });
        }

        function initializeRealTimeUpdates() {
            // Enhanced real-time updates with smooth animations
            setInterval(function() {
                const timestamp = document.querySelector('header .text-gray-500 span');
                if (timestamp) {
                    const minutes = Math.floor(Math.random() * 5) + 1;
                    timestamp.style.transition = 'all 0.3s ease';
                    timestamp.style.opacity = '0';
                    setTimeout(() => {
                        timestamp.textContent = `${minutes} min ago`;
                        timestamp.style.opacity = '1';
                    }, 150);
                }
            }, 30000);

            // Enhanced hover effects
            const cards = document.querySelectorAll('.shadow-xl, .shadow-lg');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-4px) scale(1.02)';
                    this.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                    this.style.boxShadow = '0 25px 50px -12px rgba(0, 0, 0, 0.25)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                    this.style.boxShadow = '';
                });
            });

            // Animate progress bars
            const progressBars = document.querySelectorAll('[class*="w-["]');
            progressBars.forEach(bar => {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            bar.style.transition = 'width 1s ease-in-out';
                            bar.style.width = '0%';
                            setTimeout(() => {
                                bar.style.width = bar.getAttribute('data-width') || bar.className.match(/w-\[(\d+)%\]/)?.[1] + '%' || '';
                            }, 100);
                        }
                    });
                });
                observer.observe(bar);
            });

            // Pulse animations for status indicators
            const pulseElements = document.querySelectorAll('.animate-pulse');
            pulseElements.forEach(element => {
                setInterval(() => {
                    element.style.transform = 'scale(1.1)';
                    setTimeout(() => {
                        element.style.transform = 'scale(1)';
                    }, 200);
                }, 2000);
            });

            // Smooth scroll behavior
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Auto-refresh charts with fade effect
            setInterval(function() {
                // Simulate data refresh
                const chartContainers = document.querySelectorAll('[id$="-chart"]');
                chartContainers.forEach(container => {
                    container.style.transition = 'opacity 0.5s ease';
                    container.style.opacity = '0.7';
                    setTimeout(() => {
                        container.style.opacity = '1';
                    }, 500);
                });
            }, 300000); // 5 minutes

            // Loading states for interactive elements
            const buttons = document.querySelectorAll('button');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    if (!this.classList.contains('loading')) {
                        this.classList.add('loading');
                        this.style.position = 'relative';
                        this.style.overflow = 'hidden';
                        
                        const ripple = document.createElement('div');
                        ripple.style.position = 'absolute';
                        ripple.style.borderRadius = '50%';
                        ripple.style.backgroundColor = 'rgba(255, 255, 255, 0.6)';
                        ripple.style.transform = 'scale(0)';
                        ripple.style.animation = 'ripple 0.6s linear';
                        
                        const rect = this.getBoundingClientRect();
                        const size = Math.max(rect.width, rect.height);
                        ripple.style.width = ripple.style.height = size + 'px';
                        ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
                        ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
                        
                        this.appendChild(ripple);
                        
                        setTimeout(() => {
                            ripple.remove();
                            this.classList.remove('loading');
                        }, 600);
                    }
                });
            });
        }

        // Add CSS animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
            
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            .animation-delay-150 {
                animation-delay: 150ms;
            }
            
            .animation-delay-300 {
                animation-delay: 300ms;
            }
            
            .backdrop-blur-sm {
                backdrop-filter: blur(4px);
            }
            
            .backdrop-blur-lg {
                backdrop-filter: blur(16px);
            }
        `;
        document.head.appendChild(style);
    </script>
</div>
        