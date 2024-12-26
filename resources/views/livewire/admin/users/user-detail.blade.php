<div>
    <div class="max-w-7xl mx-auto">
        <!-- Enhanced User Profile Header -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Background Banner with Overlay Pattern -->
            <div class="relative h-48 bg-gradient-to-br from-indigo-600 via-blue-700 to-purple-700 overflow-hidden">
                <!-- Animated Decorative Elements -->
                <div class="absolute inset-0">
                    <div class="absolute inset-0 opacity-20 mix-blend-overlay">
                        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                            <defs>
                                <pattern id="header-pattern" x="0" y="0" width="10" height="10"
                                    patternUnits="userSpaceOnUse">
                                    <circle cx="2" cy="2" r="1" fill="currentColor" />
                                </pattern>
                                <linearGradient id="overlay-gradient" x1="0" y1="0" x2="100%"
                                    y2="100%">
                                    <stop offset="0%" stop-color="#fff" stop-opacity="0.1">
                                        <animate attributeName="stop-opacity" values="0.1; 0.3; 0.1" dur="4s"
                                            repeatCount="indefinite" />
                                    </stop>
                                    <stop offset="100%" stop-color="#fff" stop-opacity="0.2">
                                        <animate attributeName="stop-opacity" values="0.2; 0.4; 0.2" dur="4s"
                                            repeatCount="indefinite" />
                                    </stop>
                                </linearGradient>
                            </defs>
                            <rect width="100" height="100" fill="url(#header-pattern)" />
                            <rect width="100" height="100" fill="url(#overlay-gradient)" />
                        </svg>
                    </div>
                    <!-- Floating Particles Effect -->
                    <div class="absolute inset-0 opacity-30">
                        <div class="absolute h-2 w-2 bg-white rounded-full top-1/4 left-1/4 animate-pulse"></div>
                        <div class="absolute h-2 w-2 bg-white rounded-full top-1/3 right-1/3 animate-pulse delay-100">
                        </div>
                        <div class="absolute h-2 w-2 bg-white rounded-full top-2/3 left-1/2 animate-pulse delay-200">
                        </div>
                    </div>
                </div>

                <!-- Enhanced Quick Action Buttons -->
                <div class="absolute top-4 right-4 flex space-x-2">
                    @if (auth()->user()->role === 'admin' || auth()->user()->role === 'manager')
                        <button class="btn-action group relative">
                            <span
                                class="absolute -top-10 right-0 w-max opacity-0 group-hover:opacity-100 transition-opacity bg-black text-white text-xs px-2 py-1 rounded">Edit
                                User</span>
                            <svg class="w-5 h-5 transform group-hover:scale-110 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        <button class="btn-action group relative">
                            <span
                                class="absolute -top-10 right-0 w-max opacity-0 group-hover:opacity-100 transition-opacity bg-black text-white text-xs px-2 py-1 rounded">Change
                                Department</span>
                            <svg class="w-5 h-5 transform group-hover:scale-110 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </button>
                        <button class="btn-action group relative">
                            <span
                                class="absolute -top-10 right-0 w-max opacity-0 group-hover:opacity-100 transition-opacity bg-black text-white text-xs px-2 py-1 rounded">Manage
                                Access</span>
                            <svg class="w-5 h-5 transform group-hover:scale-110 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                        </button>
                    @endif
                </div>

                <!-- Enhanced Profile Image Section -->
                <div class="absolute -bottom-12 left-8 flex items-end">
                    <div class="relative group">
                        <div
                            class="absolute inset-0 rounded-xl bg-gradient-to-br from-blue-500 to-purple-600 opacity-0 group-hover:opacity-20 transition-opacity">
                        </div>
                        @if ($user->image)
                            <img src="{{ asset('storage/' . $user->image) }}"
                                class="w-28 h-28 rounded-xl border-4 border-white object-cover shadow-lg transform transition-all duration-300 group-hover:scale-105 group-hover:shadow-xl"
                                alt="{{ $user->name }}">
                        @else
                            <div
                                class="w-28 h-28 rounded-xl border-4 border-white bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center shadow-lg transform transition-all duration-300 group-hover:scale-105 group-hover:shadow-xl">
                                <span
                                    class="text-3xl font-bold text-gray-500 group-hover:text-gray-600 transition-colors">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </span>
                            </div>
                        @endif
                        @if (auth()->user()->role === 'admin' || $user->id === auth()->id())
                            <button
                                class="absolute bottom-2 right-2 p-1.5 bg-white rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-all duration-300 hover:bg-gray-50 transform hover:scale-110">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- User Info and Stats Section -->
            <div class="pt-16 pb-6 px-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                    <!-- User Basic Info -->
                    <div class="flex-1">
                        <div class="flex items-center space-x-3">
                            <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                            <span
                                class="px-3 py-1 rounded-full text-sm font-medium {{ $user->role === 'admin'
                                    ? 'bg-purple-100 text-purple-800 border border-purple-200'
                                    : ($user->role === 'manager'
                                        ? 'bg-blue-100 text-blue-800 border border-blue-200'
                                        : 'bg-green-100 text-green-800 border border-green-200') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                            @if ($user->email_verified_at)
                                <span class="text-green-500" title="Verified Account">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            @endif
                        </div>

                        <div class="mt-2 flex items-center space-x-4">
                            <div class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $user->position }} · {{ $user->department->name ?? 'No Department' }}</span>
                            </div>
                            @if ($user->phone_number)
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span>{{ $user->phone_number }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="mt-4 md:mt-0 flex space-x-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">
                                {{ $attendanceRate }}%
                            </div>
                            <div class="text-sm text-gray-500">Attendance</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">
                                {{ $tasksCompleted }}
                            </div>
                            <div class="text-sm text-gray-500">Tasks Done</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600">
                                {{ $leaveBalance ?? 0 }}
                            </div>
                            <div class="text-sm text-gray-500">Leave Days</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Left Column - Personal Information -->
            <div class="col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h2>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->phone_number ?? 'Not provided' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Birth Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $user->birthdate ? date('F j, Y', strtotime($user->birthdate)) : 'Not provided' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Address</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->address ?? 'Not provided' }}</dd>
                        </div>
                        @if ($user->salary)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Salary</dt>
                                <dd class="mt-1 text-sm text-gray-900">${{ number_format($user->salary, 2) }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <!-- Leave Balance Card -->
                <div class="mt-8 bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Leave Balance</h2>
                    @if ($user->leaveBalance)
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Total Balance</span>
                                <span
                                    class="text-sm font-medium text-gray-900">{{ $user->leaveBalance->total_balance }}
                                    days</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                @php
                                    $percentage =
                                        ($user->leaveBalance->used_balance / $user->leaveBalance->total_balance) * 100;
                                @endphp
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $percentage }}%">
                                </div>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">Used: {{ $user->leaveBalance->used_balance }}
                                    days</span>
                                <span class="text-gray-500">Remaining:
                                    {{ $user->leaveBalance->remaining_balance }}
                                    days</span>
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No leave balance information available</p>
                    @endif
                </div>
            </div>

            <!-- Middle Column - Attendance Overview -->
            <div class="col-span-2">
                <!-- Attendance Period Selector -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Attendance Overview</h2>
                        <select wire:model.live="attendancePeriod"
                            class="rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="7">Last 7 Days</option>
                            <option value="30">Last 30 Days</option>
                            <option value="90">Last 90 Days</option>
                        </select>
                    </div>

                    <!-- Attendance Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        @php
                            $attendanceStats = $user
                                ->attendance()
                                ->where('date', '>=', now()->subDays($attendancePeriod))
                                ->get();

                            $totalPresent = $attendanceStats->where('status', 'present')->count();
                            $totalLate = $attendanceStats->where('status', 'late')->count();
                            $totalEarlyLeave = $attendanceStats->where('status', 'early_leave')->count();
                            $totalAbsent = $attendancePeriod - $attendanceStats->count();
                        @endphp

                        <div class="bg-green-50 rounded-lg p-4">
                            <dt class="text-sm font-medium text-green-800">Present</dt>
                            <dd class="mt-1 text-2xl font-semibold text-green-900">{{ $totalPresent }}</dd>
                        </div>
                        <div class="bg-yellow-50 rounded-lg p-4">
                            <dt class="text-sm font-medium text-yellow-800">Late</dt>
                            <dd class="mt-1 text-2xl font-semibold text-yellow-900">{{ $totalLate }}</dd>
                        </div>
                        <div class="bg-orange-50 rounded-lg p-4">
                            <dt class="text-sm font-medium text-orange-800">Early Leave</dt>
                            <dd class="mt-1 text-2xl font-semibold text-orange-900">{{ $totalEarlyLeave }}</dd>
                        </div>
                        <div class="bg-red-50 rounded-lg p-4">
                            <dt class="text-sm font-medium text-red-800">Absent</dt>
                            <dd class="mt-1 text-2xl font-semibold text-red-900">{{ $totalAbsent }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Recent Attendance Table -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Recent Attendance</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Check In</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Check Out</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Working Hours</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($user->attendance()->latest('date')->take(10)->get() as $attendance)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ date('M d, Y', strtotime($attendance->date)) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $attendance->check_in ? date('H:i', strtotime($attendance->check_in)) : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $attendance->check_out ? date('H:i', strtotime($attendance->check_out)) : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $attendance->status === 'present'
                                                ? 'bg-green-100 text-green-800'
                                                : ($attendance->status === 'late'
                                                    ? 'bg-yellow-100 text-yellow-800'
                                                    : ($attendance->status === 'early_leave'
                                                        ? 'bg-orange-100 text-orange-800'
                                                        : 'bg-gray-100 text-gray-800')) }}">
                                                {{ ucfirst($attendance->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $attendance->working_hours ?? '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-8 bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Recent Leave Requests</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Type</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Duration</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Reason</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($user->leaveRequests()->latest()->take(5)->get() as $leave)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $leave->type === 'sick'
                                                ? 'bg-red-100 text-red-800'
                                                : ($leave->type === 'annual'
                                                    ? 'bg-blue-100 text-blue-800'
                                                    : ($leave->type === 'important'
                                                        ? 'bg-purple-100 text-purple-800'
                                                        : 'bg-gray-100 text-gray-800')) }}">
                                                {{ ucfirst($leave->type) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div class="flex flex-col">
                                                <span>{{ date('M d, Y', strtotime($leave->start_date)) }}</span>
                                                <span class="text-gray-500 text-xs">to</span>
                                                <span>{{ date('M d, Y', strtotime($leave->end_date)) }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <div class="max-w-xs truncate" title="{{ $leave->reason }}">
                                                {{ $leave->reason }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $leave->status === 'approved'
                                                ? 'bg-green-100 text-green-800'
                                                : ($leave->status === 'pending'
                                                    ? 'bg-yellow-100 text-yellow-800'
                                                    : 'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($leave->status) }}
                                            </span>
                                            @if ($leave->status !== 'pending')
                                                <div class="mt-1 text-xs text-gray-500">
                                                    @if ($leave->approved_by)
                                                        by {{ $leave->approvedBy->name }}
                                                    @endif
                                                    @if ($leave->approved_at)
                                                        <br>{{ $leave->approved_at->format('M d, Y H:i') }}
                                                    @endif
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex space-x-2">
                                                @if ($leave->attachment_path)
                                                    <a href="{{ Storage::url($leave->attachment_path) }}"
                                                        target="_blank" class="text-blue-600 hover:text-blue-900">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                                            </path>
                                                        </svg>
                                                    </a>
                                                @endif

                                                @if ($leave->status === 'pending' && (auth()->user()->role === 'admin' || auth()->user()->role === 'manager'))
                                                    <button wire:click="approveLeave({{ $leave->id }})"
                                                        class="text-green-600 hover:text-green-900"
                                                        title="Approve Leave">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </button>
                                                    <button wire:click="rejectLeave({{ $leave->id }})"
                                                        class="text-red-600 hover:text-red-900" title="Reject Leave">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            No leave requests found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>


</div>
