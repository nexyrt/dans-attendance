<div class="p-4 md:p-8">
    <div class="max-w-7xl mx-auto">

        <div class="py-6">
            <div class="mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Leave Balance Overview -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Total Balance Card -->
                    <div class="relative group">
                        <div
                            class="h-full bg-white rounded-xl shadow-sm border border-gray-100 p-6 transition-all duration-200 hover:shadow-lg">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Total Balance</p>
                                    <div class="mt-2 flex items-baseline">
                                        <p class="text-3xl font-bold text-gray-900">
                                            {{ $leaveBalance->total_balance ?? 0 }}</p>
                                        <p class="ml-1 text-lg text-gray-500">days</p>
                                    </div>
                                </div>
                                <div class="p-3 bg-green-50 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mt-4">
                                <div class="relative pt-1">
                                    <div class="overflow-hidden h-2 text-xs flex rounded-full bg-gray-100">
                                        <div class="w-full bg-green-100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hover Card -->
                        <div
                            class="hidden group-hover:block absolute top-full left-0 mt-2 w-72 p-4 bg-white rounded-lg shadow-xl border border-gray-100 z-10">
                            <h4 class="text-sm font-semibold text-gray-900">About Total Balance</h4>
                            <p class="mt-2 text-sm text-gray-600">This is your annual leave allocation for
                                {{ now()->year }}. It represents the total number of leave days you're entitled to
                                this year.</p>
                        </div>
                    </div>

                    <!-- Used Balance Card -->
                    <div class="relative group">
                        <div
                            class="h-full bg-white rounded-xl shadow-sm border border-gray-100 p-6 transition-all duration-200 hover:shadow-lg">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Used Leave</p>
                                    <div class="mt-2 flex items-baseline">
                                        <p class="text-3xl font-bold text-gray-900">
                                            {{ $leaveBalance->used_balance ?? 0 }}</p>
                                        <p class="ml-1 text-lg text-gray-500">days</p>
                                    </div>
                                </div>
                                <div class="p-3 bg-blue-50 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mt-4">
                                <div class="relative pt-1">
                                    <div class="overflow-hidden h-2 text-xs flex rounded-full bg-gray-100">
                                        <div style="width: {{ ($leaveBalance->used_balance / $leaveBalance->total_balance) * 100 }}%"
                                            class="bg-blue-100 rounded-full"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hover Card -->
                        <div
                            class="hidden group-hover:block absolute top-full left-0 mt-2 w-72 p-4 bg-white rounded-lg shadow-xl border border-gray-100 z-10">
                            <h4 class="text-sm font-semibold text-gray-900">About Used Leave</h4>
                            <p class="mt-2 text-sm text-gray-600">This shows how many leave days you've used so far this
                                year. It includes all approved leave requests.</p>
                            <div class="mt-3 text-xs text-gray-500">
                                <p>Last leave taken:
                                    <span class="font-medium text-gray-900">
                                        {{ optional(auth()->user()->leaveRequests()->where('status', 'approved')->latest()->first())->start_date?->format('M d, Y') ?? 'No leave taken yet' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Remaining Balance Card -->
                    <div class="relative group">
                        <div
                            class="h-full bg-white rounded-xl shadow-sm border border-gray-100 p-6 transition-all duration-200 hover:shadow-lg">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Remaining Balance</p>
                                    <div class="mt-2 flex items-baseline">
                                        <p class="text-3xl font-bold text-gray-900">
                                            {{ $leaveBalance->remaining_balance ?? 0 }}</p>
                                        <p class="ml-1 text-lg text-gray-500">days</p>
                                    </div>
                                </div>
                                <div class="p-3 bg-purple-50 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mt-4">
                                <div class="relative pt-1">
                                    <div class="overflow-hidden h-2 text-xs flex rounded-full bg-gray-100">
                                        <div style="width: {{ ($leaveBalance->remaining_balance / $leaveBalance->total_balance) * 100 }}%"
                                            class="bg-purple-100 rounded-full"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Info for Low Balance -->
                            @if ($leaveBalance && $leaveBalance->remaining_balance < 5)
                                <div class="mt-3 flex items-center text-sm text-amber-600">
                                    <svg class="h-5 w-5 mr-1.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    Low balance alert
                                </div>
                            @endif
                        </div>

                        <!-- Hover Card -->
                        <div
                            class="hidden group-hover:block absolute top-full left-0 mt-2 w-72 p-4 bg-white rounded-lg shadow-xl border border-gray-100 z-10">
                            <h4 class="text-sm font-semibold text-gray-900">About Remaining Balance</h4>
                            <p class="mt-2 text-sm text-gray-600">This is the number of leave days you still have
                                available to use this year.</p>
                            @if ($leaveBalance && $leaveBalance->remaining_balance < 5)
                                <div class="mt-3 p-2 bg-amber-50 rounded-md">
                                    <p class="text-xs text-amber-800">You're running low on leave days. Plan your
                                        remaining leaves carefully.</p>
                                </div>
                            @endif
                            <div class="mt-3 text-xs text-gray-500">
                                <p>Pending requests:
                                    <span class="font-medium text-gray-900">
                                        {{ auth()->user()->leaveRequests()->pending()->count() }} day(s)
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab Navigation -->
                <div class="mb-6">
                    <nav class="flex space-x-4" aria-label="Tabs">
                        <button wire:click="setTab('requests')"
                            class="px-3 py-2 text-sm font-medium rounded-md {{ $activeTab === 'requests' ? 'bg-indigo-100 text-indigo-700' : 'text-gray-500 hover:text-gray-700' }}">
                            My Leave Requests
                        </button>
                        <button wire:click="setTab('new-request')"
                            class="px-3 py-2 text-sm font-medium rounded-md {{ $activeTab === 'new-request' ? 'bg-indigo-100 text-indigo-700' : 'text-gray-500 hover:text-gray-700' }}">
                            New Leave Request
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div>
                    {{-- Table --}}
                    @if ($activeTab === 'requests')
                        <!-- Table Container -->
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <!-- Enhanced Filters Section -->
                            <div class="bg-white rounded-lg shadow-sm mb-6">
                                <div class="p-4 sm:p-6">
                                    <!-- Search and Filter Controls -->
                                    <div class="md:flex justify-between">
                                        <!-- Search Box -->
                                        <div class="min-w-sm">
                                            <div class="relative rounded-md shadow-sm">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <svg class="h-5 w-5 text-gray-400"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <input wire:model.live.debounce.300ms="search" type="search"
                                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                    placeholder="Search leave requests...">
                                            </div>
                                        </div>

                                        <div class="flex space-x-3">
                                            <!-- Leave Type Dropdown -->
                                            <div class="w-full sm:w-[200px]">
                                                <select wire:model.live="typeFilter"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                    <option value="">Leave Type</option>
                                                    @foreach (App\Models\LeaveRequest::TYPES as $type)
                                                        <option value="{{ $type }}">{{ ucfirst($type) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Status Dropdown -->
                                            <div class="w-full sm:w-[200px]">
                                                <select wire:model.live="statusFilter"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                    <option value="">Status</option>
                                                    @foreach (App\Models\LeaveRequest::STATUSES as $status)
                                                        <option value="{{ $status }}">{{ ucfirst($status) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Active Filters & Reset -->
                                    @if ($search || $typeFilter || $statusFilter)
                                        <div
                                            class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200">
                                            <div class="flex items-center space-x-2">
                                                <span class="text-sm text-gray-700">Active filters:</span>
                                                <div class="flex flex-wrap gap-2">
                                                    @if ($search)
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                            Search: "{{ $search }}"
                                                        </span>
                                                    @endif
                                                    @if ($typeFilter)
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                            Type: {{ ucfirst($typeFilter) }}
                                                        </span>
                                                    @endif
                                                    @if ($statusFilter)
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                            Status: {{ ucfirst($statusFilter) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <button wire:click="resetFilters"
                                                class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                                Reset all filters
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Responsive Table -->
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Type</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Duration</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Reason</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Approver</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($leaveRequests as $leave)
                                            <tr class="hover:bg-gray-50">
                                                {{-- Type --}}
                                                <td class="px-6 py-4 text-center">
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize
                                                                {{ match ($leave->type) {
                                                                    'sick' => 'bg-red-100 text-red-800 border border-red-200',
                                                                    'annual' => 'bg-blue-100 text-blue-800 border border-blue-200',
                                                                    'important' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                                                                    default => 'bg-gray-100 text-gray-800 border border-gray-200',
                                                                } }}">
                                                        {{ $leave->type }}
                                                    </span>
                                                </td>

                                                {{-- Duration --}}
                                                <td class="px-6 py-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $leave->start_date->format('M d, Y') }}
                                                    </div>
                                                    @if ($leave->start_date != $leave->end_date)
                                                        <div class="text-sm text-gray-500">
                                                            to {{ $leave->end_date->format('M d, Y') }}
                                                        </div>
                                                    @endif
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        {{ $leave->getDurationInDays() }} day(s)
                                                    </div>
                                                </td>

                                                {{-- Status --}}
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize
                                {{ match ($leave->status) {
                                    'pending' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                                    'approved' => 'bg-green-100 text-green-800 border border-green-200',
                                    'rejected' => 'bg-red-100 text-red-800 border border-red-200',
                                    'cancel' => 'bg-gray-100 text-gray-800 border border-gray-200',
                                } }}">
                                                        {{ $leave->status }}
                                                    </span>
                                                </td>

                                                {{-- Reason --}}
                                                <td class="px-6 py-4">
                                                    <div class="max-w-xs">
                                                        <div class="text-sm text-gray-900 line-clamp-2"
                                                            title="{{ $leave->reason }}">
                                                            {{ $leave->reason }}
                                                        </div>
                                                    </div>
                                                </td>

                                                {{-- Approved By --}}
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if ($leave->approved_by)
                                                        <div class="flex items-center">
                                                            @if ($leave->approvedBy->image)
                                                                <img class="h-8 w-8 rounded-full object-cover"
                                                                    src="{{ asset('storage/' . $leave->approvedBy->image) }}"
                                                                    alt="">
                                                            @else
                                                                <div
                                                                    class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                                                    <span class="text-sm font-medium text-indigo-600">
                                                                        {{ substr($leave->approvedBy->name, 0, 1) }}
                                                                    </span>
                                                                </div>
                                                            @endif
                                                            <div class="ml-3">
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    {{ $leave->approvedBy->name }}
                                                                </div>
                                                                <div class="text-xs text-gray-500">
                                                                    {{ $leave->approved_at ? $leave->approved_at->format('M d, Y H:i') : '' }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="text-sm text-gray-500 italic">Pending
                                                            approval</span>
                                                    @endif
                                                </td>

                                                {{-- Actions --}}
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    @if ($leave->canBeCancelled())
                                                        <button wire:click="cancelLeave({{ $leave->id }})"
                                                            wire:confirm="Are you sure you want to cancel this leave request?"
                                                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-4 w-4 mr-1.5" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                            Cancel
                                                        </button>
                                                    @else
                                                        <span class="text-sm text-gray-400 italic">No actions</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                                    <div class="flex flex-col items-center">
                                                        <svg class="h-12 w-12 text-gray-400 mb-3" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="1"
                                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                                        </svg>
                                                        <p class="text-gray-500 text-base">No leave requests found</p>
                                                        <p class="text-gray-400 text-sm mt-1">Try adjusting your search
                                                            or filters</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                                {{ $leaveRequests->links() }}
                            </div>
                        </div>
                    @else
                        <div class="bg-white rounded-lg shadow-sm">
                            <!-- Form Header -->
                            <div class="px-6 py-4 border-b border-gray-200">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="p-2 bg-indigo-50 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">New Leave Request</h3>
                                        <p class="text-sm text-gray-500">Fill in the details below to submit your leave
                                            request</p>
                                    </div>
                                </div>
                            </div>

                            <form wire:submit="submitForm">
                                <div class="p-6 space-y-6">
                                    @if ($errors->has('general'))
                                        <div class="rounded-md bg-red-50 p-4">
                                            <div class="flex">
                                                <div class="shrink-0">
                                                    <svg class="h-5 w-5 text-red-400"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div class="ml-3">
                                                    <h3 class="text-sm font-medium text-red-800">
                                                        {{ $errors->first('general') }}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    @endif


                                    <div class="relative max-w-sm">
                                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                          <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                          </svg>
                                        </div>
                                        <input datepicker id="default-datepicker" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                                      </div>
                                      

                                    <!-- Form Sections -->
                                    <div class="grid grid-cols-1 gap-8">

                                        <!-- Attachment Section -->
                                        <div class="bg-gray-50 rounded-lg p-4">
                                            <h4 class="text-sm font-medium text-gray-900 mb-4">Supporting Document</h4>
                                            <div class="flex items-center justify-center">
                                                <label for="attachment" class="w-full cursor-pointer">
                                                    <div
                                                        class="p-4 border-2 border-gray-300 border-dashed rounded-lg text-center hover:border-indigo-500 transition-colors">
                                                        <div class="flex flex-col items-center">
                                                            @if ($attachment)
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-8 w-8 text-green-500" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                                <span class="mt-2 text-sm text-gray-900">File selected:
                                                                    {{ $attachment->getClientOriginalName() }}</span>
                                                            @else
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-8 w-8 text-gray-400" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                                </svg>
                                                                <span class="mt-2 text-sm text-gray-500">Drop files
                                                                    here or click to upload</span>
                                                            @endif
                                                            <input type="file" wire:model="attachment"
                                                                id="attachment" class="hidden"
                                                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                                        </div>
                                                        <p class="mt-1 text-xs text-gray-500">Supported formats: PDF,
                                                            DOC, DOCX, JPG, PNG (max 5MB)</p>
                                                    </div>
                                                </label>
                                            </div>
                                            @error('attachment')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div
                                    class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-lg flex justify-end space-x-3">
                                    <button type="button" wire:click="setTab('requests')"
                                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg wire:loading wire:target="submitForm"
                                            class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none"
                                            viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        Submit Request
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
