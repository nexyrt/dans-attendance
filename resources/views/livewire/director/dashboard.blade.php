<!-- resources/views/livewire/director/dashboard.blade.php -->
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Executive Dashboard</h1>
                    <p class="text-sm text-gray-500 mt-1">Real-time insights for strategic decisions</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                        <i class="fas fa-circle text-green-500 mr-1"></i>Live Data
                    </div>
                    <div class="text-sm text-gray-500">
                        Last updated: <span class="font-medium">2 min ago</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Executive Summary Cards -->
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">In Office Now</p>
                        <p class="text-3xl font-bold">47<span class="text-lg">/52</span></p>
                        <p class="text-blue-100 text-xs mt-1">90% attendance today</p>
                    </div>
                    <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Monthly Payroll</p>
                        <p class="text-3xl font-bold">$87.5K</p>
                        <p class="text-green-100 text-xs mt-1">+2.3% from last month</p>
                    </div>
                    <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                        <i class="fas fa-dollar-sign text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-amber-100 text-sm font-medium">Pending Approvals</p>
                        <p class="text-3xl font-bold">8</p>
                        <p class="text-amber-100 text-xs mt-1">3 urgent, 5 regular</p>
                    </div>
                    <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                        <i class="fas fa-clock text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Company Health</p>
                        <p class="text-3xl font-bold">8.4<span class="text-lg">/10</span></p>
                        <p class="text-purple-100 text-xs mt-1">Excellent performance</p>
                    </div>
                    <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                        <i class="fas fa-heartbeat text-2xl"></i>
                    </div>
                </div>
            </div>
        </section>

        <!-- Today's Attendance Section -->
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Attendance Table -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Today's Attendance</h2>
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            <span class="text-xs text-gray-600">On Time</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                            <span class="text-xs text-gray-600">Late</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
                            <span class="text-xs text-gray-600">Absent</span>
                        </div>
                    </div>
                </div>

                <!-- Filter Tabs -->
                <div class="flex space-x-1 mb-4 bg-gray-100 rounded-lg p-1">
                    <button id="tab-all"
                        class="tab-btn flex-1 py-2 px-3 text-sm font-medium rounded-md bg-white text-blue-600 shadow-sm">
                        All (47)
                    </button>
                    <button id="tab-ontime"
                        class="tab-btn flex-1 py-2 px-3 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900">
                        On Time (35)
                    </button>
                    <button id="tab-late"
                        class="tab-btn flex-1 py-2 px-3 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900">
                        Late (7)
                    </button>
                    <button id="tab-absent"
                        class="tab-btn flex-1 py-2 px-3 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900">
                        Absent (5)
                    </button>
                </div>

                <!-- Table -->
                <div class="overflow-hidden">
                    <div class="max-h-96 overflow-y-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 sticky top-0">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Employee</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Department</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Check In</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Working Hours</th>
                                </tr>
                            </thead>
                            <tbody id="attendance-table-body" class="bg-white divide-y divide-gray-200">
                                <!-- On Time Employees -->
                                <tr class="attendance-row on-time hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                                JD</div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">John Doe</div>
                                                <div class="text-sm text-gray-500">Senior Developer</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">Digital Marketing</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">08:15 AM</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <div class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1"></div>On Time
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">8.2h</td>
                                </tr>

                                <tr class="attendance-row on-time hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                                JS</div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">Jane Smith</div>
                                                <div class="text-sm text-gray-500">Marketing Manager</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">Digital Marketing</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">08:00 AM</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <div class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1"></div>On Time
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">8.5h</td>
                                </tr>

                                <!-- Late Employees -->
                                <tr class="attendance-row late hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                                MJ</div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">Mike Johnson</div>
                                                <div class="text-sm text-gray-500">Project Manager</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">Detax</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">09:25 AM</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <div class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1"></div>Late (1h 25m)
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">6.8h</td>
                                </tr>

                                <tr class="attendance-row late hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 bg-pink-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                                SW</div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">Sarah Wilson</div>
                                                <div class="text-sm text-gray-500">HR Specialist</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">HR</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">08:45 AM</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <div class="w-1.5 h-1.5 bg-yellow-500 rounded-full mr-1"></div>Late (45m)
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">7.5h</td>
                                </tr>

                                <!-- Absent Employees -->
                                <tr class="attendance-row absent hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 bg-gray-400 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                                ED</div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">Emily Davis</div>
                                                <div class="text-sm text-gray-500">Content Writer</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">Digital Marketing
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">-</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <div class="w-1.5 h-1.5 bg-gray-500 rounded-full mr-1"></div>Absent (Sick
                                            Leave)
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">0h</td>
                                </tr>

                                <tr class="attendance-row absent hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 bg-gray-400 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                                RK</div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">Robert Kim</div>
                                                <div class="text-sm text-gray-500">UI Designer</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">Sydital</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">-</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <div class="w-1.5 h-1.5 bg-gray-500 rounded-full mr-1"></div>Absent (Annual
                                            Leave)
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">0h</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Table Summary -->
                <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                    <span>Showing <span id="showing-count">6</span> of 52 employees</span>
                    <div class="flex items-center space-x-4">
                        <span>Average Check-in: <span class="font-medium text-gray-900">8:15 AM</span></span>
                        <span>On-time Rate: <span class="font-medium text-green-600">74%</span></span>
                    </div>
                </div>
            </div>

            <!-- Attendance Charts -->
            <div class="space-y-6">
                <!-- Attendance Overview Chart -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Today's Overview</h3>
                    <div id="attendance-donut-chart" class="h-64"></div>
                </div>

                <!-- Check-in Time Chart -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Check-in Times</h3>
                    <div id="checkin-time-chart" class="h-48"></div>
                </div>
            </div>
        </section>

        <!-- Analytics Section -->
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Attendance Trends -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">7-Day Attendance Trends</h2>
                </div>
                <div id="attendance-trend-chart" class="h-64"></div>
            </div>

            <!-- Productivity Hours -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Peak Productivity Hours</h2>
                <div id="productivity-hours-chart" class="h-64"></div>
            </div>
        </section>

        <!-- Department Performance -->
        <section class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Department Performance</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-semibold text-gray-900">Digital Marketing</h3>
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Excellent</span>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Attendance Rate:</span>
                            <span class="font-medium text-green-600">94%</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Employees:</span>
                            <span class="font-medium">15</span>
                        </div>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-semibold text-gray-900">Sydital</h3>
                        <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">Good</span>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Attendance Rate:</span>
                            <span class="font-medium text-yellow-600">87%</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Employees:</span>
                            <span class="font-medium">18</span>
                        </div>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-semibold text-gray-900">Detax</h3>
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Excellent</span>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Attendance Rate:</span>
                            <span class="font-medium text-green-600">96%</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Employees:</span>
                            <span class="font-medium">12</span>
                        </div>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-semibold text-gray-900">HR</h3>
                        <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">Needs Attention</span>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Attendance Rate:</span>
                            <span class="font-medium text-red-600">78%</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Employees:</span>
                            <span class="font-medium">7</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Charts
            initializeCharts();

            // Initialize Tab Functionality
            initializeTabs();

            // Initialize Real-time Updates
            initializeRealTimeUpdates();
        });

        function initializeCharts() {
            // Attendance Donut Chart
            const attendanceDonutChart = new ApexCharts(document.querySelector("#attendance-donut-chart"), {
                series: [35, 7, 5, 5],
                chart: {
                    type: 'donut',
                    height: 250
                },
                labels: ['On Time', 'Late', 'Absent', 'Not Checked In'],
                colors: ['#10B981', '#F59E0B', '#EF4444', '#9CA3AF'],
                legend: {
                    position: 'bottom'
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%'
                        }
                    }
                },
                dataLabels: {
                    enabled: false
                }
            });
            attendanceDonutChart.render();

            // Check-in Time Distribution Chart
            const checkinTimeChart = new ApexCharts(document.querySelector("#checkin-time-chart"), {
                series: [{
                    name: 'Employees',
                    data: [2, 8, 15, 12, 7, 3, 0, 0]
                }],
                chart: {
                    type: 'bar',
                    height: 180,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        columnWidth: '60%'
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: ['7:00-7:30', '7:30-8:00', '8:00-8:30', '8:30-9:00', '9:00-9:30', '9:30-10:00',
                        '10:00-10:30', '10:30+'
                    ]
                },
                colors: ['#3B82F6']
            });
            checkinTimeChart.render();

            // Attendance Trend Chart
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
                    toolbar: {
                        show: false
                    }
                },
                colors: ['#10B981', '#F59E0B'],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                xaxis: {
                    categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                },
                legend: {
                    position: 'top'
                }
            });
            attendanceTrendChart.render();

            // Productivity Hours Chart
            const productivityHoursChart = new ApexCharts(document.querySelector("#productivity-hours-chart"), {
                series: [{
                    name: 'Productivity %',
                    data: [5, 25, 70, 95, 85, 60, 30, 40, 75, 85, 65, 45]
                }],
                chart: {
                    type: 'area',
                    height: 250,
                    toolbar: {
                        show: false
                    }
                },
                colors: ['#8B5CF6'],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.3
                    }
                },
                xaxis: {
                    categories: ['6 AM', '7 AM', '8 AM', '9 AM', '10 AM', '11 AM', '12 PM', '1 PM', '2 PM', '3 PM',
                        '4 PM', '5 PM'
                    ]
                },
                yaxis: {
                    min: 0,
                    max: 100
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
                    // Reset all tabs
                    tabButtons.forEach(btn => {
                        btn.classList.remove('bg-white', 'text-blue-600', 'shadow-sm');
                        btn.classList.add('text-gray-600');
                    });

                    // Activate clicked tab
                    this.classList.add('bg-white', 'text-blue-600', 'shadow-sm');
                    this.classList.remove('text-gray-600');

                    // Filter rows
                    const filter = this.id.replace('tab-', '');
                    let visibleCount = 0;

                    attendanceRows.forEach(row => {
                        if (filter === 'all') {
                            row.style.display = '';
                            visibleCount++;
                        } else if (row.classList.contains(filter === 'ontime' ? 'on-time' :
                            filter)) {
                            row.style.display = '';
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    showingCount.textContent = visibleCount;
                });
            });
        }

        function initializeRealTimeUpdates() {
            // Simulate real-time updates every 30 seconds
            setInterval(function() {
                const timestamp = document.querySelector('header .text-gray-500 span');
                if (timestamp) {
                    const minutes = Math.floor(Math.random() * 5) + 1;
                    timestamp.textContent = `${minutes} min ago`;
                }
            }, 30000);

            // Add hover effects to cards
            const cards = document.querySelectorAll('.shadow-lg');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                    this.style.transition = 'transform 0.2s ease';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        }
    </script>
</div>
