<!-- resources/views/livewire/director/dashboard.blade.php -->
<div class="max-w-7xl mx-auto">
    <div class="container mx-auto py-8">

        <!-- Loading Overlay -->
        <div wire:loading wire:target="selectedDateRange, selectedDepartment" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl shadow-xl flex items-center space-x-4">
                <svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-lg font-medium">Updating dashboard...</span>
            </div>
        </div>

        <!-- Filters Card with New Select Component -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8 border border-gray-100">
            <div class="flex flex-col md:flex-row md:items-end md:space-x-6">
                <div class="mb-4 md:mb-0 w-full md:w-1/4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                    <x-input.select
                        wire:model.live="selectedDateRange"
                        :options="['this month', 'last month', 'this year']"
                        placeholder="Select date range"
                    />
                </div>

                <div class="mb-4 md:mb-0 w-full md:w-1/4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                    <x-input.select
                        wire:model.live="selectedDepartment"
                        :options="$departments->pluck('id')"
                        placeholder="All Departments"
                    />
                </div>

                <div class="flex-1"></div>

                <div class="flex items-center">
                    <label class="inline-flex items-center">
                        <input type="checkbox" wire:model.live="showDataLabels" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Show Data Labels</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Mobile Tabs - Updated Style -->
        <div class="block md:hidden mb-6">
            <div class="bg-gray-50 rounded-xl overflow-hidden">
                <nav class="flex divide-x divide-gray-200">
                    <button wire:click="changeTab('attendance')" class="flex-1 py-3 px-2 text-center font-medium text-sm {{ $activeTab == 'attendance' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Attendance
                    </button>
                    <button wire:click="changeTab('leave')" class="flex-1 py-3 px-2 text-center font-medium text-sm {{ $activeTab == 'leave' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Leave
                    </button>
                    <button wire:click="changeTab('staff')" class="flex-1 py-3 px-2 text-center font-medium text-sm {{ $activeTab == 'staff' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Staff
                    </button>
                </nav>
            </div>
        </div>

        <!-- Main Stats Panel - Updated with card effects -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 text-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition-transform duration-300 overflow-hidden relative">
                <div class="absolute right-0 top-0 opacity-10">
                    <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-1 opacity-90">Overall Attendance Rate</h3>
                <p class="text-4xl font-extrabold mb-2">{{ number_format($monthlyPerformance['attendance_rate'], 1) }}%</p>
                <p class="text-sm opacity-80">Based on present days vs. total working days</p>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition-transform duration-300 overflow-hidden relative">
                <div class="absolute right-0 top-0 opacity-10">
                    <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-1 opacity-90">Average Working Hours</h3>
                <p class="text-4xl font-extrabold mb-2">{{ $monthlyPerformance['avg_working_hours'] }}</p>
                <p class="text-sm opacity-80">Average daily hours across all staff</p>
            </div>

            <div class="bg-gradient-to-br from-amber-500 to-amber-600 text-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition-transform duration-300 overflow-hidden relative">
                <div class="absolute right-0 top-0 opacity-10">
                    <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-1 opacity-90">Leave Requests</h3>
                <p class="text-4xl font-extrabold mb-2">{{ $monthlyPerformance['leave_utilization'] }}</p>
                <p class="text-sm opacity-80">Approved requests in selected period</p>
            </div>
        </div>

        <!-- Desktop Sections -->
        <div class="hidden md:block">
            <!-- Attendance Section -->
            <div class="mb-12">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Attendance Analytics</h2>
                    <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Live Data</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Attendance Status Chart -->
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-6 h-80">
                        <livewire:livewire-pie-chart key="{{ $attendanceStatusChart->reactiveKey() }}"
                            :pie-chart-model="$attendanceStatusChart" />
                    </div>

                    <!-- Attendance by Status -->
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-6">
                        <h3 class="text-lg font-semibold mb-5 text-gray-800">Attendance Status</h3>
                        <div class="space-y-5">
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="w-3 h-3 rounded-full bg-green-500 mr-3"></div>
                                <span class="flex-1 font-medium">Present</span>
                                <span class="font-bold text-lg">{{ $attendanceStats['total_present'] }}</span>
                            </div>
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="w-3 h-3 rounded-full bg-amber-500 mr-3"></div>
                                <span class="flex-1 font-medium">Late</span>
                                <span class="font-bold text-lg">{{ $attendanceStats['total_late'] }}</span>
                            </div>
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="w-3 h-3 rounded-full bg-red-500 mr-3"></div>
                                <span class="flex-1 font-medium">Early Leave</span>
                                <span class="font-bold text-lg">{{ $attendanceStats['total_early_leave'] }}</span>
                            </div>
                            <div class="flex items-center p-3 bg-indigo-50 rounded-lg">
                                <div class="w-3 h-3 rounded-full bg-indigo-500 mr-3"></div>
                                <span class="flex-1 font-medium">Average Working Hours</span>
                                <span class="font-bold text-lg">{{ $attendanceStats['average_working_hours'] }} hrs</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($selectedDateRange === 'this_year' && $monthlyAttendanceTrendChart)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-6 mb-6 h-96">
                        <livewire:livewire-line-chart key="{{ $monthlyAttendanceTrendChart->reactiveKey() }}"
                            :line-chart-model="$monthlyAttendanceTrendChart" />
                    </div>
                @endif
            </div>

            <!-- Leave Section -->
            <div class="mb-12">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Leave Management</h2>
                    <span class="bg-amber-100 text-amber-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $leaveStats['pending_requests'] }} Pending</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Leave Type Chart -->
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-6 h-80">
                        @if (count($leaveStats['by_type'] ?? []) > 0)
                            <livewire:livewire-pie-chart key="{{ $leaveTypeChart->reactiveKey() }}"
                                :pie-chart-model="$leaveTypeChart" />
                        @else
                            <div class="flex flex-col items-center justify-center h-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="mt-4 text-gray-500 text-center">No leave data available for the selected period</p>
                                <button class="mt-4 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
                                    Try Another Date Range
                                </button>
                            </div>
                        @endif
                    </div>

                    <!-- Leave Request Status -->
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-6">
                        <h3 class="text-lg font-semibold mb-5 text-gray-800">Leave Request Status</h3>
                        <div class="space-y-5">
                            <div class="flex items-center p-3 bg-amber-50 rounded-lg">
                                <div class="w-3 h-3 rounded-full bg-amber-500 mr-3"></div>
                                <span class="flex-1 font-medium">Pending</span>
                                <span class="font-bold text-lg">{{ $leaveStats['pending_requests'] }}</span>
                            </div>
                            <div class="flex items-center p-3 bg-green-50 rounded-lg">
                                <div class="w-3 h-3 rounded-full bg-green-500 mr-3"></div>
                                <span class="flex-1 font-medium">Approved</span>
                                <span class="font-bold text-lg">{{ $leaveStats['approved_requests'] }}</span>
                            </div>
                            <div class="flex items-center p-3 bg-red-50 rounded-lg">
                                <div class="w-3 h-3 rounded-full bg-red-500 mr-3"></div>
                                <span class="flex-1 font-medium">Rejected</span>
                                <span class="font-bold text-lg">{{ $leaveStats['rejected_requests'] }}</span>
                            </div>

                            <!-- Action buttons -->
                            <div class="mt-6">
                                <a href="{{ route('director.leave.index') }}"
                                    class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    View All Leave Requests
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Staff Section -->
            <div>
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Staff Overview</h2>
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $staffStats['total_employees'] ?? 0 }} Employees</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Role Distribution Chart -->
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-6 h-80">
                        <livewire:livewire-pie-chart key="{{ $roleDistributionChart->reactiveKey() }}"
                            :pie-chart-model="$roleDistributionChart" />
                    </div>

                    <!-- Department Distribution Chart -->
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-6 h-80">
                        <livewire:livewire-column-chart key="{{ $departmentDistributionChart->reactiveKey() }}"
                            :column-chart-model="$departmentDistributionChart" />
                    </div>
                </div>

                <!-- Salary Overview -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-6 mb-6">
                    <h3 class="text-lg font-semibold mb-5 text-gray-800">Salary Overview</h3>
                    <div class="grid grid-cols-3 gap-6">
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-100 hover:border-indigo-200 transition-colors">
                            <span class="block text-sm text-gray-500 mb-1">Average Salary</span>
                            <span class="text-2xl font-bold text-gray-800">{{ number_format($staffStats['salary_ranges']['avg'], 2) }}</span>
                        </div>
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-100 hover:border-indigo-200 transition-colors">
                            <span class="block text-sm text-gray-500 mb-1">Minimum Salary</span>
                            <span class="text-2xl font-bold text-gray-800">{{ number_format($staffStats['salary_ranges']['min'], 2) }}</span>
                        </div>
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-100 hover:border-indigo-200 transition-colors">
                            <span class="block text-sm text-gray-500 mb-1">Maximum Salary</span>
                            <span class="text-2xl font-bold text-gray-800">{{ number_format($staffStats['salary_ranges']['max'], 2) }}</span>
                        </div>
                    </div>

                    <!-- Action buttons -->
                    <div class="mt-6">
                        <a href="{{ route('director.users.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Manage Staff
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Sections - with improved styling -->
        <div class="md:hidden">
            <!-- Attendance Section -->
            @if ($activeTab == 'attendance')
                <div>
                    <div class="bg-white rounded-xl shadow-md p-6 mb-6 h-80">
                        <livewire:livewire-pie-chart key="mobile-{{ $attendanceStatusChart->reactiveKey() }}"
                            :pie-chart-model="$attendanceStatusChart" />
                    </div>

                    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                        <h3 class="text-lg font-semibold mb-4">Attendance Status</h3>
                        <div class="space-y-4">
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="w-3 h-3 rounded-full bg-green-500 mr-3"></div>
                                <span class="flex-1 font-medium">Present</span>
                                <span class="font-bold">{{ $attendanceStats['total_present'] }}</span>
                            </div>
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="w-3 h-3 rounded-full bg-amber-500 mr-3"></div>
                                <span class="flex-1 font-medium">Late</span>
                                <span class="font-bold">{{ $attendanceStats['total_late'] }}</span>
                            </div>
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="w-3 h-3 rounded-full bg-red-500 mr-3"></div>
                                <span class="flex-1 font-medium">Early Leave</span>
                                <span class="font-bold">{{ $attendanceStats['total_early_leave'] }}</span>
                            </div>
                            <div class="flex items-center p-3 bg-indigo-50 rounded-lg">
                                <div class="w-3 h-3 rounded-full bg-indigo-500 mr-3"></div>
                                <span class="flex-1 font-medium">Average Working Hours</span>
                                <span class="font-bold">{{ $attendanceStats['average_working_hours'] }} hrs</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Leave Section -->
            @if ($activeTab == 'leave')
                <div>
                    <div class="bg-white rounded-xl shadow-md p-6 mb-6 h-80">
                        @if (count($leaveStats['by_type'] ?? []) > 0)
                            <livewire:livewire-pie-chart key="mobile-{{ $leaveTypeChart->reactiveKey() }}"
                                :pie-chart-model="$leaveTypeChart" />
                        @else
                            <div class="flex flex-col items-center justify-center h-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="mt-4 text-gray-500 text-center">No leave data available</p>
                            </div>
                        @endif
                    </div>

                    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                        <h3 class="text-lg font-semibold mb-4">Leave Request Status</h3>
                        <div class="space-y-4">
                            <div class="flex items-center p-3 bg-amber-50 rounded-lg">
                                <div class="w-3 h-3 rounded-full bg-amber-500 mr-3"></div>
                                <span class="flex-1 font-medium">Pending</span>
                                <span class="font-bold">{{ $leaveStats['pending_requests'] }}</span>
                            </div>
                            <div class="flex items-center p-3 bg-green-50 rounded-lg">
                                <div class="w-3 h-3 rounded-full bg-green-500 mr-3"></div>
                                <span class="flex-1 font-medium">Approved</span>
                                <span class="font-bold">{{ $leaveStats['approved_requests'] }}</span>
                            </div>
                            <div class="flex items-center p-3 bg-red-50 rounded-lg">
                                <div class="w-3 h-3 rounded-full bg-red-500 mr-3"></div>
                                <span class="flex-1 font-medium">Rejected</span>
                                <span class="font-bold">{{ $leaveStats['rejected_requests'] }}</span>
                            </div>

                            <!-- Action buttons -->
                            <div class="mt-6">
                                <a href="{{ route('director.leave.index') }}"
                                    class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    View All Leave Requests
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Staff Section -->
            @if ($activeTab == 'staff')
                <div>
                    <div class="bg-white rounded-xl shadow-md p-6 mb-6 h-80">
                        <livewire:livewire-pie-chart key="mobile-{{ $roleDistributionChart->reactiveKey() }}"
                            :pie-chart-model="$roleDistributionChart" />
                    </div>

                    <div class="bg-white rounded-xl shadow-md p-6 mb-6 h-80">
                        <livewire:livewire-column-chart key="mobile-{{ $departmentDistributionChart->reactiveKey() }}"
                            :column-chart-model="$departmentDistributionChart" />
                    </div>

                    <!-- Salary Overview -->
                    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                        <h3 class="text-lg font-semibold mb-4">Salary Overview</h3>
                        <div class="space-y-4">
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                <span class="block text-sm text-gray-500 mb-1">Average Salary</span>
                                <span class="text-2xl font-bold text-gray-800">{{ number_format($staffStats['salary_ranges']['avg'], 2) }}</span>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                <span class="block text-sm text-gray-500 mb-1">Minimum Salary</span>
                                <span class="text-2xl font-bold text-gray-800">{{ number_format($staffStats['salary_ranges']['min'], 2) }}</span>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                <span class="block text-sm text-gray-500 mb-1">Maximum Salary</span>
                                <span class="text-2xl font-bold text-gray-800">{{ number_format($staffStats['salary_ranges']['max'], 2) }}</span>
                            </div>
                        </div>

                        <!-- Action buttons -->
                        <div class="mt-6">
                            <a href="{{ route('director.users.index') }}"
                                class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                Manage Staff
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>