<!-- resources/views/livewire/director/dashboard.blade.php -->
<div class="min-h-screen">
    <!-- Loading Overlay -->
    <div wire:loading wire:target="render"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-xl shadow-xl flex items-center space-x-4">
            <svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <span class="text-lg font-medium">Loading dashboard...</span>
        </div>
    </div>

    {{-- <flux:modal.trigger name="edit-profile">
        <flux:button>Edit profile</flux:button>
    </flux:modal.trigger>

    <flux:modal name="edit-profile" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Update profile</flux:heading>
                <flux:text class="mt-2">Make changes to your personal details.</flux:text>
            </div>

            <flux:input label="Name" placeholder="Your name" />

            <flux:input label="Date of birth" type="date" />

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary">Save changes</flux:button>
            </div>
        </div>
    </flux:modal> --}}

    <!-- Mobile-optimized content -->
    <div class="pt-4 lg:pt-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            <!-- Enhanced Executive Summary Cards with Question Mark Tooltips -->
            <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 mb-6 lg:mb-8">
                <!-- In Office Card -->
                <div
                    class="relative bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 rounded-xl lg:rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent"></div>
                    <div class="absolute -top-4 -right-4 w-16 h-16 lg:w-24 lg:h-24 bg-white/10 rounded-full blur-xl">
                    </div>
                    <div class="relative p-4 lg:p-6">
                        <div class="flex items-center justify-between mb-3 lg:mb-4">
                            <div class="p-2 lg:p-3 bg-white/20 rounded-lg lg:rounded-xl backdrop-blur-sm">
                                <i class="fas fa-users text-white text-xl lg:text-2xl"></i>
                            </div>
                            <div class="text-right">
                                <div class="w-12 lg:w-16 h-1.5 lg:h-2 bg-white/30 rounded-full overflow-hidden">
                                    <div class="h-full bg-white rounded-full transition-all duration-1000"
                                        style="width: {{ $inOfficeStats['percentage'] }}%"></div>
                                </div>
                                <span class="text-xs text-blue-100 mt-1">{{ $inOfficeStats['percentage'] }}%
                                    Capacity</span>
                            </div>
                        </div>
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <p class="text-blue-100 text-sm font-medium mb-1 lg:mb-2">In Office Now</p>
                                <p class="text-2xl lg:text-4xl font-bold text-white mb-1">
                                    {{ $inOfficeStats['current'] }}<span
                                        class="text-lg lg:text-xl text-blue-200">/{{ $inOfficeStats['total'] }}</span>
                                </p>
                                <p class="text-blue-100 text-xs">
                                    @if ($inOfficeStats['percentage'] >= 90)
                                        Excellent attendance today
                                    @elseif($inOfficeStats['percentage'] >= 75)
                                        Good attendance today
                                    @else
                                        Lower attendance today
                                    @endif
                                </p>
                            </div>
                            <!-- Info Icon with Tooltip -->
                            <div class="group relative ml-2" style="z-index: 9999;">
                                <button
                                    class="w-6 h-6 bg-white/30 hover:bg-white/50 rounded-full flex items-center justify-center cursor-help transition-all duration-200 border border-white/20">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <!-- Tooltip -->
                                <div class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 pointer-events-none"
                                    style="z-index: 99999;">
                                    <div
                                        class="bg-gray-900 text-white text-xs rounded-lg py-3 px-4 shadow-2xl border border-gray-700 w-72 whitespace-normal">
                                        <div class="font-semibold mb-2 text-blue-300">In Office Statistics</div>
                                        <div class="space-y-1.5 text-xs leading-relaxed">
                                            <div class="flex items-start space-x-2">
                                                <span class="text-blue-400 mt-0.5 flex-shrink-0">•</span>
                                                <span><span class="text-blue-300 font-medium">Current:</span> Employees
                                                    checked in but not checked out</span>
                                            </div>
                                            <div class="flex items-start space-x-2">
                                                <span class="text-blue-400 mt-0.5 flex-shrink-0">•</span>
                                                <span><span class="text-blue-300 font-medium">Total:</span> All active
                                                    employees in the system</span>
                                            </div>
                                            <div class="flex items-start space-x-2">
                                                <span class="text-blue-400 mt-0.5 flex-shrink-0">•</span>
                                                <span><span class="text-blue-300 font-medium">Percentage:</span>
                                                    Real-time office occupancy rate</span>
                                            </div>
                                            <div class="border-t border-gray-700 pt-2 mt-3 text-blue-200">
                                                Updates automatically based on attendance data
                                            </div>
                                        </div>
                                        <!-- Arrow pointing up -->
                                        <div class="absolute bottom-full left-1/2 transform -translate-x-1/2">
                                            <div
                                                class="w-0 h-0 border-l-4 border-r-4 border-b-4 border-transparent border-b-gray-900">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Approvals Card -->
                <div
                    class="relative bg-gradient-to-br from-amber-500 via-amber-600 to-orange-600 rounded-xl lg:rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent"></div>
                    <div class="absolute -top-4 -right-4 w-16 h-16 lg:w-24 lg:h-24 bg-white/10 rounded-full blur-xl">
                    </div>
                    <div class="relative p-4 lg:p-6">
                        <div class="flex items-center justify-between mb-3 lg:mb-4">
                            <div class="p-2 lg:p-3 bg-white/20 rounded-lg lg:rounded-xl backdrop-blur-sm">
                                <i class="fas fa-clock text-white text-xl lg:text-2xl"></i>
                            </div>
                            <div class="flex space-x-1">
                                @if ($pendingApprovals['urgent'] > 0)
                                    <div class="w-2 h-2 bg-red-400 rounded-full animate-pulse" title="Urgent approvals">
                                    </div>
                                @endif
                                <div class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse" title="Regular approvals">
                                </div>
                                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse" title="System active">
                                </div>
                            </div>
                        </div>
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <p class="text-amber-100 text-sm font-medium mb-1 lg:mb-2">Pending Approvals</p>
                                <p class="text-2xl lg:text-4xl font-bold text-white mb-1">
                                    {{ $pendingApprovals['total'] }}</p>
                                <p class="text-amber-100 text-xs">
                                    @if ($pendingApprovals['urgent'] > 0)
                                        {{ $pendingApprovals['urgent'] }} urgent, {{ $pendingApprovals['regular'] }}
                                        regular
                                    @else
                                        {{ $pendingApprovals['regular'] }} regular items
                                    @endif
                                </p>
                            </div>
                            <!-- Info Icon with Tooltip -->
                            <div class="group relative ml-2" style="z-index: 9999;">
                                <button
                                    class="w-6 h-6 bg-white/30 hover:bg-white/50 rounded-full flex items-center justify-center cursor-help transition-all duration-200 border border-white/20">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <!-- Tooltip -->
                                <div class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 pointer-events-none"
                                    style="z-index: 99999;">
                                    <div
                                        class="bg-gray-900 text-white text-xs rounded-lg py-3 px-4 shadow-2xl border border-gray-700 w-72 whitespace-normal">
                                        <div class="font-semibold mb-2 text-amber-300">Pending Approvals</div>
                                        <div class="space-y-1.5 text-xs leading-relaxed">
                                            <div class="flex items-start space-x-2">
                                                <span class="text-amber-400 mt-0.5 flex-shrink-0">•</span>
                                                <span><span class="text-amber-300 font-medium">Total:</span> Leave
                                                    requests awaiting director approval</span>
                                            </div>
                                            <div class="flex items-start space-x-2">
                                                <span class="text-amber-400 mt-0.5 flex-shrink-0">•</span>
                                                <span><span class="text-amber-300 font-medium">Urgent:</span> Requests
                                                    submitted more than 3 days ago</span>
                                            </div>
                                            <div class="flex items-start space-x-2">
                                                <span class="text-amber-400 mt-0.5 flex-shrink-0">•</span>
                                                <span><span class="text-amber-300 font-medium">Regular:</span> Recent
                                                    requests within normal timeframe</span>
                                            </div>
                                            <div class="border-t border-gray-700 pt-2 mt-3 text-amber-200">
                                                Source: Leave requests with status "pending_director"
                                            </div>
                                        </div>
                                        <!-- Arrow pointing up -->
                                        <div class="absolute bottom-full left-1/2 transform -translate-x-1/2">
                                            <div
                                                class="w-0 h-0 border-l-4 border-r-4 border-b-4 border-transparent border-b-gray-900">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Company Health Card -->
                <div
                    class="relative bg-gradient-to-br from-purple-500 via-purple-600 to-indigo-600 rounded-xl lg:rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 md:col-span-2 lg:col-span-1">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent"></div>
                    <div class="absolute -top-4 -right-4 w-16 h-16 lg:w-24 lg:h-24 bg-white/10 rounded-full blur-xl">
                    </div>
                    <div class="relative p-4 lg:p-6">
                        <div class="flex items-center justify-between mb-3 lg:mb-4">
                            <div class="p-2 lg:p-3 bg-white/20 rounded-lg lg:rounded-xl backdrop-blur-sm">
                                <i class="fas fa-heartbeat text-white text-xl lg:text-2xl"></i>
                            </div>
                            <div class="w-10 h-10 lg:w-12 lg:h-12 relative">
                                <svg class="w-10 h-10 lg:w-12 lg:h-12 transform -rotate-90" viewBox="0 0 36 36">
                                    <circle cx="18" cy="18" r="14" fill="none"
                                        stroke="rgba(255,255,255,0.2)" stroke-width="3" />
                                    <circle cx="18" cy="18" r="14" fill="none" stroke="white"
                                        stroke-width="3"
                                        stroke-dasharray="{{ ($companyHealthScore['rating'] / 10) * 88 }}"
                                        stroke-dashoffset="0" stroke-linecap="round" />
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span
                                        class="text-xs font-bold text-white">{{ number_format($companyHealthScore['rating'] * 10) }}%</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <p class="text-purple-100 text-sm font-medium mb-1 lg:mb-2">Company Health</p>
                                <p class="text-2xl lg:text-4xl font-bold text-white mb-1">
                                    {{ $companyHealthScore['rating'] }}<span
                                        class="text-lg lg:text-xl text-purple-200">/10</span>
                                </p>
                                <p class="text-purple-100 text-xs">{{ $companyHealthScore['status'] }}</p>
                            </div>
                            <!-- Info Icon with Tooltip -->
                            <div class="group relative ml-2" style="z-index: 9999;">
                                <button
                                    class="w-6 h-6 bg-white/30 hover:bg-white/50 rounded-full flex items-center justify-center cursor-help transition-all duration-200 border border-white/20">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <!-- Tooltip -->
                                <div class="absolute top-full right-0 mt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 pointer-events-none"
                                    style="z-index: 99999;">
                                    <div
                                        class="bg-gray-900 text-white text-xs rounded-lg py-3 px-4 shadow-2xl border border-gray-700 w-80 whitespace-normal">
                                        <div class="font-semibold mb-2 text-purple-300">Company Health Score</div>
                                        <div class="space-y-1.5 text-xs leading-relaxed">
                                            <div class="flex items-start space-x-2">
                                                <span class="text-purple-400 mt-0.5 flex-shrink-0">•</span>
                                                <span><span class="text-purple-300 font-medium">Attendance Rate
                                                        (40%):</span> Daily present vs total employees</span>
                                            </div>
                                            <div class="flex items-start space-x-2">
                                                <span class="text-purple-400 mt-0.5 flex-shrink-0">•</span>
                                                <span><span class="text-purple-300 font-medium">Leave Approval
                                                        (30%):</span> Monthly approved vs total requests</span>
                                            </div>
                                            <div class="flex items-start space-x-2">
                                                <span class="text-purple-400 mt-0.5 flex-shrink-0">•</span>
                                                <span><span class="text-purple-300 font-medium">Productivity
                                                        (30%):</span> Average working hours vs 8-hour standard</span>
                                            </div>
                                            <div class="border-t border-gray-700 pt-2 mt-3">
                                                <div class="text-purple-200 space-y-1">
                                                    <div class="flex items-center space-x-2">
                                                        <span
                                                            class="w-2 h-2 bg-green-500 rounded-full flex-shrink-0"></span>
                                                        <span>8.0+ = Excellent</span>
                                                    </div>
                                                    <div class="flex items-center space-x-2">
                                                        <span
                                                            class="w-2 h-2 bg-yellow-500 rounded-full flex-shrink-0"></span>
                                                        <span>7.0+ = Good</span>
                                                    </div>
                                                    <div class="flex items-center space-x-2">
                                                        <span
                                                            class="w-2 h-2 bg-orange-500 rounded-full flex-shrink-0"></span>
                                                        <span>6.0+ = Fair</span>
                                                    </div>
                                                    <div class="flex items-center space-x-2">
                                                        <span
                                                            class="w-2 h-2 bg-red-500 rounded-full flex-shrink-0"></span>
                                                        <span>&lt;6.0 = Needs Attention</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Arrow pointing up -->
                                        <div class="absolute bottom-full right-6 transform">
                                            <div
                                                class="w-0 h-0 border-l-4 border-r-4 border-b-4 border-transparent border-b-gray-900">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Enhanced Today's Attendance Section -->
            <section class="relative grid grid-cols-1 z-10 lg:grid-cols-3 gap-6 lg:gap-8 mb-6 lg:mb-8">
                <!-- Enhanced Attendance Table -->
                <div
                    class="lg:col-span-2 bg-white/70 backdrop-blur-sm rounded-xl lg:rounded-2xl shadow-xl border border-white/20">
                    <div class="p-4 lg:p-6 border-b border-gray-100">
                        <div
                            class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 lg:mb-6 space-y-4 sm:space-y-0">
                            <div>
                                <h2 class="text-xl lg:text-2xl font-bold text-gray-900 mb-1">Today's Attendance</h2>
                                <p class="text-sm text-gray-500">Real-time employee status monitoring</p>
                            </div>
                            <div class="flex flex-wrap items-center gap-2 lg:gap-4">
                                <div class="flex items-center space-x-2 bg-green-50 px-2 lg:px-3 py-1 rounded-lg">
                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                    <span class="text-xs text-green-700 font-medium">On Time</span>
                                </div>
                                <div class="flex items-center space-x-2 bg-red-50 px-2 lg:px-3 py-1 rounded-lg">
                                    <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                    <span class="text-xs text-red-700 font-medium">Late</span>
                                </div>
                                <div class="flex items-center space-x-2 bg-gray-50 px-2 lg:px-3 py-1 rounded-lg">
                                    <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                                    <span class="text-xs text-gray-700 font-medium">Absent</span>
                                </div>
                            </div>
                        </div>

                        <!-- Enhanced Filter Tabs -->
                        <div
                            class="flex space-x-1 lg:space-x-2 bg-gray-50 rounded-lg lg:rounded-xl p-1 lg:p-2 overflow-x-auto">
                            <button id="tab-all"
                                class="tab-btn flex-shrink-0 flex-1 sm:flex-none py-2 lg:py-3 px-3 lg:px-4 text-xs lg:text-sm font-semibold rounded-lg bg-white text-blue-600 shadow-sm border border-blue-100 transition-all duration-200">
                                <div class="flex items-center justify-center space-x-1 lg:space-x-2 whitespace-nowrap">
                                    <span>All</span>
                                    <span
                                        class="bg-blue-100 text-blue-600 px-1.5 lg:px-2 py-0.5 rounded-full text-xs">{{ count($todayAttendance) }}</span>
                                </div>
                            </button>
                            <button id="tab-ontime"
                                class="tab-btn flex-shrink-0 flex-1 sm:flex-none py-2 lg:py-3 px-3 lg:px-4 text-xs lg:text-sm font-semibold rounded-lg text-gray-600 hover:text-gray-900 hover:bg-white/50 transition-all duration-200">
                                <div class="flex items-center justify-center space-x-1 lg:space-x-2 whitespace-nowrap">
                                    <span>On Time</span>
                                    <span
                                        class="bg-green-100 text-green-600 px-1.5 lg:px-2 py-0.5 rounded-full text-xs">{{ $attendanceStats['total_present'] }}</span>
                                </div>
                            </button>
                            <button id="tab-late"
                                class="tab-btn flex-shrink-0 flex-1 sm:flex-none py-2 lg:py-3 px-3 lg:px-4 text-xs lg:text-sm font-semibold rounded-lg text-gray-600 hover:text-gray-900 hover:bg-white/50 transition-all duration-200">
                                <div class="flex items-center justify-center space-x-1 lg:space-x-2 whitespace-nowrap">
                                    <span>Late</span>
                                    <span
                                        class="bg-red-100 text-red-600 px-1.5 lg:px-2 py-0.5 rounded-full text-xs">{{ $attendanceStats['total_late'] }}</span>
                                </div>
                            </button>
                            <button id="tab-absent"
                                class="tab-btn flex-shrink-0 flex-1 sm:flex-none py-2 lg:py-3 px-3 lg:px-4 text-xs lg:text-sm font-semibold rounded-lg text-gray-600 hover:text-gray-900 hover:bg-white/50 transition-all duration-200">
                                <div class="flex items-center justify-center space-x-1 lg:space-x-2 whitespace-nowrap">
                                    <span>Absent</span>
                                    <span
                                        class="bg-gray-100 text-gray-600 px-1.5 lg:px-2 py-0.5 rounded-full text-xs">{{ $attendanceStats['total_absent'] }}</span>
                                </div>
                            </button>
                        </div>
                    </div>

                    <!-- Enhanced Table -->
                    <div class="overflow-hidden">
                        @if (count($todayAttendance) > 0)
                            <div class="max-h-80 lg:max-h-96 overflow-y-auto">
                                <table class="min-w-full">
                                    <thead class="bg-gray-50/80 sticky top-0 backdrop-blur-sm">
                                        <tr>
                                            <th
                                                class="px-3 lg:px-6 py-3 lg:py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Employee</th>
                                            <th
                                                class="hidden sm:table-cell px-3 lg:px-6 py-3 lg:py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Department</th>
                                            <th
                                                class="px-3 lg:px-6 py-3 lg:py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Check In</th>
                                            <th
                                                class="px-3 lg:px-6 py-3 lg:py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Status</th>
                                            <th
                                                class="hidden lg:table-cell px-3 lg:px-6 py-3 lg:py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Hours</th>
                                        </tr>
                                    </thead>
                                    <tbody id="attendance-table-body" class="divide-y divide-gray-100">
                                        @foreach ($todayAttendance as $attendance)
                                            <tr
                                                class="attendance-row {{ $attendance['status'] === 'present' ? 'on-time' : $attendance['status'] }} hover:bg-{{ $attendance['status_color'] }}-50/50 transition-colors duration-200 group">
                                                <td class="px-3 lg:px-6 py-3 lg:py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="relative">
                                                            <div
                                                                class="w-8 h-8 lg:w-12 lg:h-12 bg-gradient-to-br from-{{ $attendance['department_color'] }}-500 to-{{ $attendance['department_color'] }}-600 rounded-lg lg:rounded-xl flex items-center justify-center text-white font-bold shadow-lg text-xs lg:text-sm">
                                                                {{ $attendance['user']['initials'] }}
                                                            </div>
                                                            <div
                                                                class="absolute -bottom-0.5 lg:-bottom-1 -right-0.5 lg:-right-1 w-3 h-3 lg:w-4 lg:h-4 bg-{{ $attendance['status_color'] }}-500 rounded-full border-1 lg:border-2 border-white">
                                                            </div>
                                                        </div>
                                                        <div class="ml-2 lg:ml-4">
                                                            <div
                                                                class="text-xs lg:text-sm font-semibold text-gray-900">
                                                                {{ $attendance['user']['name'] }}</div>
                                                            <div class="text-xs text-gray-500 sm:hidden lg:block">
                                                                {{ $attendance['user']['position'] }}</div>
                                                            <div class="text-xs text-gray-500 sm:hidden">
                                                                {{ $attendance['user']['department'] }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td
                                                    class="hidden sm:table-cell px-3 lg:px-6 py-3 lg:py-4 whitespace-nowrap">
                                                    <span
                                                        class="inline-flex items-center px-2 lg:px-3 py-1 rounded-lg text-xs font-medium bg-{{ $attendance['department_color'] }}-50 text-{{ $attendance['department_color'] }}-700 border border-{{ $attendance['department_color'] }}-200">
                                                        {{ $attendance['user']['department'] }}
                                                    </span>
                                                </td>
                                                <td
                                                    class="px-3 lg:px-6 py-3 lg:py-4 whitespace-nowrap text-xs lg:text-sm font-medium text-gray-900">
                                                    {{ $attendance['check_in'] ?? '-' }}
                                                </td>
                                                <td class="px-3 lg:px-6 py-3 lg:py-4 whitespace-nowrap">
                                                    @if ($attendance['status'] === 'present')
                                                        <span
                                                            class="inline-flex items-center px-2 lg:px-3 py-1 rounded-lg text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                                                            <div
                                                                class="w-1.5 h-1.5 lg:w-2 lg:h-2 bg-green-500 rounded-full mr-1 lg:mr-2">
                                                            </div>
                                                            <span class="hidden sm:inline">On Time</span>
                                                            <span class="sm:hidden">✓</span>
                                                        </span>
                                                    @elseif($attendance['status'] === 'late')
                                                        <span
                                                            class="inline-flex items-center px-2 lg:px-3 py-1 rounded-lg text-xs font-semibold bg-red-100 text-red-800 border border-red-200">
                                                            <div
                                                                class="w-1.5 h-1.5 lg:w-2 lg:h-2 bg-red-500 rounded-full mr-1 lg:mr-2">
                                                            </div>
                                                            <span class="hidden sm:inline">Late</span>
                                                            <span class="sm:hidden">⚠</span>
                                                            @if ($attendance['late_duration'])
                                                                <span class="hidden lg:inline">
                                                                    ({{ $attendance['late_duration'] }})
                                                                </span>
                                                            @endif
                                                        </span>
                                                    @else
                                                        <span
                                                            class="inline-flex items-center px-2 lg:px-3 py-1 rounded-lg text-xs font-semibold bg-gray-100 text-gray-800 border border-gray-200">
                                                            <div
                                                                class="w-1.5 h-1.5 lg:w-2 lg:h-2 bg-gray-500 rounded-full mr-1 lg:mr-2">
                                                            </div>
                                                            <span class="hidden sm:inline">Absent</span>
                                                            <span class="sm:hidden">✗</span>
                                                            @if (isset($attendance['absence_reason']))
                                                                <span class="hidden lg:inline">
                                                                    ({{ $attendance['absence_reason'] }})</span>
                                                            @endif
                                                        </span>
                                                    @endif
                                                </td>
                                                <td
                                                    class="hidden lg:table-cell px-3 lg:px-6 py-3 lg:py-4 whitespace-nowrap text-xs lg:text-sm font-semibold text-gray-900">
                                                    {{ $attendance['working_hours'] }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <!-- No Data State -->
                            <div class="flex flex-col items-center justify-center py-12 px-4">
                                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-user-clock text-gray-400 text-3xl"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Attendance Data</h3>
                                <p class="text-gray-500 text-center max-w-sm">
                                    There's no attendance data available for today. Employees haven't checked in yet or
                                    data is still being processed.
                                </p>
                            </div>
                        @endif
                    </div>

                    <!-- Enhanced Table Summary -->
                    @if (count($todayAttendance) > 0)
                        <div class="px-4 lg:px-6 py-3 lg:py-4 bg-gray-50/50 border-t border-gray-100">
                            <div
                                class="flex flex-col sm:flex-row sm:items-center justify-between text-xs lg:text-sm space-y-2 sm:space-y-0">
                                <div class="flex items-center space-x-4">
                                    <span class="text-gray-600">Showing <span id="showing-count"
                                            class="font-semibold text-gray-900">{{ count($todayAttendance) }}</span>
                                        of <span class="font-semibold">{{ $inOfficeStats['total'] }}</span>
                                        employees</span>
                                </div>
                                <div
                                    class="flex flex-col sm:flex-row sm:items-center sm:space-x-6 space-y-1 sm:space-y-0">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                        <span class="text-gray-600">Avg Check-in: <span
                                                class="font-semibold text-gray-900">{{ $attendanceStats['avg_check_in'] }}</span></span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                        <span class="text-gray-600">On-time Rate: <span
                                                class="font-semibold text-green-600">{{ $attendanceStats['on_time_rate'] }}%</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Enhanced Charts Section -->
                <div class="space-y-4 lg:space-y-6">
                    <!-- Attendance Overview Chart -->
                    <div
                        class="bg-white/70 backdrop-blur-sm rounded-xl lg:rounded-2xl shadow-xl border border-white/20 p-4 lg:p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-base lg:text-lg font-bold text-gray-900">Today's Overview</h3>
                            <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                        </div>
                        <div id="attendance-donut-chart" class="h-48 lg:h-64"></div>
                    </div>

                    <!-- Check-in Time Chart -->
                    <div
                        class="bg-white/70 backdrop-blur-sm rounded-xl lg:rounded-2xl shadow-xl border border-white/20 p-4 lg:p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-base lg:text-lg font-bold text-gray-900">Check-in Times</h3>
                            <div class="flex items-center space-x-2 text-xs lg:text-sm text-gray-500">
                                <i class="fas fa-clock text-xs"></i>
                                <span class="hidden sm:inline">Peak: 8-9 AM</span>
                            </div>
                        </div>
                        <div id="checkin-time-chart" class="h-36 lg:h-48"></div>
                    </div>
                </div>
            </section>

            <!-- Enhanced Analytics Section -->
            <section class="grid grid-cols-1 gap-6 lg:gap-8 mb-6 lg:mb-8">
                <!-- Attendance Trends -->
                <div
                    class="bg-white/70 backdrop-blur-sm rounded-xl lg:rounded-2xl shadow-xl border border-white/20 p-4 lg:p-6">
                    <div
                        class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 lg:mb-6 space-y-2 sm:space-y-0">
                        <div>
                            <h2 class="text-lg lg:text-xl font-bold text-gray-900">7-Day Attendance Trends</h2>
                            <p class="text-sm text-gray-500 mt-1">Weekly performance overview</p>
                        </div>
                        <div class="flex items-center space-x-2 bg-blue-50 px-3 py-2 rounded-lg">
                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                            <span class="text-xs font-medium text-blue-700">Weekly View</span>
                        </div>
                    </div>
                    <div id="attendance-trend-chart" class="h-48 lg:h-64"></div>
                </div>
            </section>

            <!-- Enhanced Department Performance -->
            <section
                class="bg-white/70 backdrop-blur-sm rounded-xl lg:rounded-2xl shadow-xl border border-white/20 p-4 lg:p-8 mb-6 lg:mb-8">
                <div
                    class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 lg:mb-8 space-y-4 sm:space-y-0">
                    <div>
                        <h2 class="text-lg lg:text-2xl font-bold text-gray-900">Department Performance</h2>
                        <p class="text-sm text-gray-500 mt-1">Comprehensive departmental analysis</p>
                    </div>
                </div>

                @if (count($departmentPerformance) > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4 lg:gap-6">
                        @foreach ($departmentPerformance as $index => $department)
                            @php
                                // Fixed color assignment - each department gets unique color
                                $departmentColors = [
                                    'digital marketing' => 'blue',
                                    'sydital' => 'teal',
                                    'detax' => 'purple',
                                    'hr' => 'indigo',
                                ];

                                $departmentKey = strtolower($department['name']);
                                $baseColor = $departmentColors[$departmentKey] ?? 'slate';

                                // Always use department color first, regardless of performance
                                $finalColor = $baseColor;

                                // Performance status styling - separate from card color
                                $statusConfig = match ($department['performance']['label']) {
                                    'Excellent' => [
                                        'color' => 'emerald',
                                        'icon' => 'fas fa-check-circle',
                                        'pulse' => false,
                                    ],
                                    'Good' => ['color' => 'blue', 'icon' => 'fas fa-thumbs-up', 'pulse' => false],
                                    'Fair' => [
                                        'color' => 'amber',
                                        'icon' => 'fas fa-exclamation-triangle',
                                        'pulse' => false,
                                    ],
                                    'Needs Attention' => [
                                        'color' => 'red',
                                        'icon' => 'fas fa-exclamation-circle',
                                        'pulse' => true,
                                    ],
                                    default => ['color' => 'gray', 'icon' => 'fas fa-minus-circle', 'pulse' => false],
                                };

                                // Fallback colors if department not found
                                $fallbackColors = ['blue', 'teal', 'purple', 'indigo', 'emerald', 'amber'];
                                if ($finalColor === 'slate') {
                                    $finalColor = $fallbackColors[$index % count($fallbackColors)];
                                }
                            @endphp

                            <div
                                class="group relative overflow-hidden bg-gradient-to-br from-{{ $finalColor }}-50 to-{{ $finalColor }}-100 rounded-lg lg:rounded-xl border border-{{ $finalColor }}-200 p-4 lg:p-6 hover:shadow-lg hover:shadow-{{ $finalColor }}-200/50 transition-all duration-300 transform hover:-translate-y-1">
                                <!-- Performance Status Badge -->
                                <div class="absolute top-3 lg:top-4 right-3 lg:right-4">
                                    <span
                                        class="inline-flex items-center px-2 lg:px-3 py-1 rounded-full text-xs font-semibold bg-{{ $statusConfig['color'] }}-100 text-{{ $statusConfig['color'] }}-800 border border-{{ $statusConfig['color'] }}-200">
                                        <i
                                            class="{{ $statusConfig['icon'] }} mr-1 lg:mr-2 text-{{ $statusConfig['color'] }}-600 @if ($statusConfig['pulse']) animate-pulse @endif"></i>
                                        {{ $department['performance']['label'] }}
                                    </span>
                                </div>

                                <!-- Department Header -->
                                <div class="mb-4 lg:mb-6">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <div
                                            class="w-12 h-12 lg:w-14 lg:h-14 bg-gradient-to-br from-{{ $finalColor }}-500 to-{{ $finalColor }}-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                                            <i class="{{ $department['icon'] }} text-lg lg:text-xl"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="text-base lg:text-lg font-bold text-gray-900 leading-tight">
                                                {{ $department['name'] }}</h3>
                                            <p class="text-xs text-gray-500 mt-1">{{ $department['team_size'] }} team
                                                members</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Metrics Grid -->
                                <div class="space-y-3 lg:space-y-4">
                                    <!-- Attendance Rate with Visual Progress -->
                                    <div class="bg-white/50 rounded-lg p-3 border border-{{ $finalColor }}-100">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-xs lg:text-sm font-medium text-gray-700">Attendance
                                                Rate</span>
                                            <span
                                                class="text-sm lg:text-base font-bold text-{{ $finalColor }}-700">{{ $department['attendance_rate'] }}%</span>
                                        </div>
                                        <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-{{ $finalColor }}-400 to-{{ $finalColor }}-600 rounded-full transition-all duration-1000 shadow-sm"
                                                style="width: {{ $department['attendance_rate'] }}%"></div>
                                        </div>
                                        <div class="flex justify-between mt-1 text-xs text-gray-500">
                                            <span>0%</span>
                                            <span>50%</span>
                                            <span>100%</span>
                                        </div>
                                    </div>

                                    <!-- Key Metrics -->
                                    <div class="grid grid-cols-2 gap-3">
                                        <div
                                            class="bg-white/30 rounded-lg p-3 text-center border border-{{ $finalColor }}-100">
                                            <div class="text-xs text-gray-600 mb-1">Avg Hours</div>
                                            <div class="text-lg font-bold text-gray-900">
                                                {{ $department['avg_hours'] }}</div>
                                            <div class="text-xs text-gray-500">per day</div>
                                        </div>
                                        <div
                                            class="bg-white/30 rounded-lg p-3 text-center border border-{{ $finalColor }}-100">
                                            <div class="text-xs text-gray-600 mb-1">Team Size</div>
                                            <div class="text-lg font-bold text-gray-900">
                                                {{ $department['team_size'] }}</div>
                                            <div class="text-xs text-gray-500">people</div>
                                        </div>
                                    </div>

                                    <!-- Performance Score -->
                                    <div class="pt-3 border-t border-{{ $finalColor }}-200">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-xs lg:text-sm font-medium text-gray-700">Performance
                                                Score</span>
                                            <span
                                                class="text-sm font-bold text-{{ $finalColor }}-700">{{ $department['performance']['score'] }}/5</span>
                                        </div>
                                        <div class="flex items-center space-x-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $department['performance']['score'])
                                                    <div
                                                        class="w-3 h-3 bg-{{ $finalColor }}-500 rounded-full shadow-sm">
                                                    </div>
                                                @else
                                                    <div class="w-3 h-3 bg-gray-200 rounded-full"></div>
                                                @endif
                                            @endfor
                                            <span class="ml-2 text-xs text-gray-500">
                                                @if ($department['performance']['score'] >= 4.5)
                                                    Outstanding
                                                @elseif($department['performance']['score'] >= 4.0)
                                                    Excellent
                                                @elseif($department['performance']['score'] >= 3.0)
                                                    Good
                                                @elseif($department['performance']['score'] >= 2.0)
                                                    Needs Work
                                                @else
                                                    Critical
                                                @endif
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Action Indicators -->
                                    @if ($department['performance']['label'] === 'Needs Attention')
                                        <div class="mt-3 p-2 bg-red-50 border border-red-200 rounded-lg">
                                            <div class="flex items-center space-x-2">
                                                <i class="fas fa-exclamation-triangle text-red-500 text-sm"></i>
                                                <span class="text-xs text-red-700 font-medium">Action Required</span>
                                            </div>
                                        </div>
                                    @elseif($department['performance']['label'] === 'Fair')
                                        <div class="mt-3 p-2 bg-amber-50 border border-amber-200 rounded-lg">
                                            <div class="flex items-center space-x-2">
                                                <i class="fas fa-eye text-amber-500 text-sm"></i>
                                                <span class="text-xs text-amber-700 font-medium">Monitor Closely</span>
                                            </div>
                                        </div>
                                    @elseif($department['performance']['label'] === 'Excellent')
                                        <div class="mt-3 p-2 bg-green-50 border border-green-200 rounded-lg">
                                            <div class="flex items-center space-x-2">
                                                <i class="fas fa-check-circle text-green-500 text-sm"></i>
                                                <span class="text-xs text-green-700 font-medium">Performing Well</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="mt-3 p-2 bg-blue-50 border border-blue-200 rounded-lg">
                                            <div class="flex items-center space-x-2">
                                                <i class="fas fa-thumbs-up text-blue-500 text-sm"></i>
                                                <span class="text-xs text-blue-700 font-medium">Good Performance</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Hover Effect Overlay -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-br from-white/0 to-{{ $finalColor }}-100/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none rounded-lg lg:rounded-xl">
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- No Data State -->
                    <div class="flex flex-col items-center justify-center py-12 px-4">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-building text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No Department Data</h3>
                        <p class="text-gray-500 text-center max-w-sm">
                            Department performance data is not available at this time. Please check back later or
                            contact your administrator.
                        </p>
                    </div>
                @endif
            </section>
        </div>
    </div>

    <!-- Simplified JavaScript with TailwindCSS Only -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize components
            initializeAnimations();
            initializeCharts();
            initializeTabs();
        });

        function initializeAnimations() {
            // Simple staggered card animations
            const cards = document.querySelectorAll('section > div');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * (window.innerWidth < 768 ? 50 : 100));
            });
        }

        function initializeCharts() {
            // Real data for charts
            const attendanceData = @json($attendanceStats['chart_data']);
            const checkinData = @json($checkinDistribution);
            const weeklyTrendData = @json($weeklyTrend);

            // Responsive chart heights
            const isLargeScreen = window.innerWidth >= 1024;
            const chartHeight = isLargeScreen ? 250 : 180;
            const smallChartHeight = isLargeScreen ? 180 : 140;

            // Attendance Donut Chart
            const attendanceDonutChart = new ApexCharts(document.querySelector("#attendance-donut-chart"), {
                series: attendanceData,
                chart: {
                    type: 'donut',
                    height: chartHeight,
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800
                    }
                },
                labels: ['On Time', 'Late', 'Absent', 'Not Checked In'],
                colors: ['#10B981', '#F59E0B', '#EF4444', '#9CA3AF'],
                legend: {
                    position: 'bottom',
                    fontSize: isLargeScreen ? '12px' : '10px',
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
                                    fontSize: isLargeScreen ? '14px' : '12px',
                                    fontWeight: 600
                                },
                                value: {
                                    show: true,
                                    fontSize: isLargeScreen ? '24px' : '18px',
                                    fontWeight: 700
                                }
                            }
                        }
                    }
                },
                dataLabels: {
                    enabled: false
                },
                responsive: [{
                    breakpoint: 768,
                    options: {
                        chart: {
                            height: 180
                        },
                        legend: {
                            fontSize: '10px'
                        }
                    }
                }]
            });
            attendanceDonutChart.render();

            // Check-in Time Chart
            const checkinTimeChart = new ApexCharts(document.querySelector("#checkin-time-chart"), {
                series: [{
                    name: 'Employees',
                    data: checkinData
                }],
                chart: {
                    type: 'bar',
                    height: smallChartHeight,
                    toolbar: {
                        show: false
                    },
                    animations: {
                        enabled: true
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
                    ],
                    labels: {
                        style: {
                            fontSize: isLargeScreen ? '11px' : '9px',
                            fontWeight: 500
                        }
                    }
                },
                colors: ['#3B82F6'],
                responsive: [{
                    breakpoint: 768,
                    options: {
                        chart: {
                            height: 140
                        },
                        xaxis: {
                            labels: {
                                style: {
                                    fontSize: '8px'
                                }
                            }
                        }
                    }
                }]
            });
            checkinTimeChart.render();

            // Attendance Trend Chart
            const attendanceTrendChart = new ApexCharts(document.querySelector("#attendance-trend-chart"), {
                series: [{
                    name: 'Present',
                    data: weeklyTrendData.present
                }, {
                    name: 'Late',
                    data: weeklyTrendData.late
                }],
                chart: {
                    type: 'area',
                    height: chartHeight,
                    toolbar: {
                        show: false
                    },
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        opacityFrom: 0.6,
                        opacityTo: 0.1
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    labels: {
                        style: {
                            fontSize: isLargeScreen ? '12px' : '10px',
                            fontWeight: 500
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            fontSize: isLargeScreen ? '12px' : '10px'
                        }
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    fontSize: isLargeScreen ? '12px' : '10px',
                    fontWeight: 500
                },
                colors: ['#10B981', '#F59E0B'],
                responsive: [{
                    breakpoint: 768,
                    options: {
                        chart: {
                            height: 200
                        },
                        legend: {
                            fontSize: '10px'
                        },
                        xaxis: {
                            labels: {
                                style: {
                                    fontSize: '9px'
                                }
                            }
                        },
                        yaxis: {
                            labels: {
                                style: {
                                    fontSize: '9px'
                                }
                            }
                        }
                    }
                }]
            });
            attendanceTrendChart.render();

            // Update charts on resize
            window.addEventListener('resize', debounce(() => {
                const newIsLargeScreen = window.innerWidth >= 1024;
                const newChartHeight = newIsLargeScreen ? 250 : 180;
                const newSmallChartHeight = newIsLargeScreen ? 180 : 140;

                attendanceDonutChart.updateOptions({
                    chart: {
                        height: newChartHeight
                    }
                });
                checkinTimeChart.updateOptions({
                    chart: {
                        height: newSmallChartHeight
                    }
                });
                attendanceTrendChart.updateOptions({
                    chart: {
                        height: newChartHeight
                    }
                });
            }, 250));
        }

        function initializeTabs() {
            const tabButtons = document.querySelectorAll('.tab-btn');
            const attendanceRows = document.querySelectorAll('.attendance-row');
            const showingCount = document.getElementById('showing-count');

            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active state from all tabs
                    tabButtons.forEach(btn => {
                        btn.classList.remove('bg-white', 'text-blue-600', 'shadow-sm', 'border',
                            'border-blue-100');
                        btn.classList.add('text-gray-600');
                    });

                    // Add active state to clicked tab
                    this.classList.add('bg-white', 'text-blue-600', 'shadow-sm', 'border',
                        'border-blue-100');
                    this.classList.remove('text-gray-600');

                    // Filter attendance rows
                    const filterId = this.id;
                    let visibleCount = 0;

                    attendanceRows.forEach(row => {
                        const shouldShow =
                            filterId === 'tab-all' ||
                            (filterId === 'tab-ontime' && row.classList.contains('on-time')) ||
                            (filterId === 'tab-late' && row.classList.contains('late')) ||
                            (filterId === 'tab-absent' && row.classList.contains('absent'));

                        if (shouldShow) {
                            row.style.display = '';
                            row.style.animation = 'fadeInRow 0.3s ease forwards';
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Update showing count
                    if (showingCount) {
                        showingCount.textContent = visibleCount;
                    }
                });
            });
        }

        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Mobile touch optimizations
        if (window.innerWidth < 1024) {
            const cards = document.querySelectorAll('.group');
            cards.forEach(card => {
                card.addEventListener('touchstart', () => {
                    card.style.transform = 'scale(0.98)';
                });

                card.addEventListener('touchend', () => {
                    card.style.transform = '';
                });
            });
        }

        // CSS Animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeInRow {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            /* Enhanced scrollbar for attendance table */
            .overflow-y-auto::-webkit-scrollbar {
                width: 6px;
            }
            
            .overflow-y-auto::-webkit-scrollbar-track {
                background: #f1f5f9;
                border-radius: 3px;
            }
            
            .overflow-y-auto::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 3px;
            }
            
            .overflow-y-auto::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }
            
            /* Mobile optimizations */
            @media (max-width: 640px) {
                .tab-btn {
                    min-width: 80px;
                }
            }
        `;
        document.head.appendChild(style);

        // Error handling for charts
        window.addEventListener('error', (e) => {
            if (e.message.includes('ApexCharts')) {
                console.warn('Chart rendering error, retrying...');
                setTimeout(initializeCharts, 1000);
            }
        });

        // Accessibility improvements
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Tab') {
                document.body.classList.add('keyboard-navigation');
            }
        });

        document.addEventListener('mousedown', () => {
            document.body.classList.remove('keyboard-navigation');
        });

        // Add focus styles for keyboard navigation
        const keyboardStyle = document.createElement('style');
        keyboardStyle.textContent = `
            .keyboard-navigation .tab-btn:focus,
            .keyboard-navigation button:focus {
                outline: 2px solid #3B82F6;
                outline-offset: 2px;
            }
        `;
        document.head.appendChild(keyboardStyle);
    </script>

    <!-- ApexCharts CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>
</div>
