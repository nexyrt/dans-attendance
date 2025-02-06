<div class="p-4 md:p-8">
    <div class="max-w-7xl mx-auto">

        <div class="py-6">
            <div class="mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Leave Balance Card -->
                <div class="mb-6 bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Leave Balance Overview</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-green-50 rounded-lg p-4">
                            <p class="text-sm text-green-600 mb-1">Total Balance</p>
                            <p class="text-2xl font-bold text-green-700">{{ $leaveBalance->total_balance ?? 0 }} days</p>
                        </div>
                        <div class="bg-blue-50 rounded-lg p-4">
                            <p class="text-sm text-blue-600 mb-1">Used Leave</p>
                            <p class="text-2xl font-bold text-blue-700">{{ $leaveBalance->used_balance ?? 0 }} days</p>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-4">
                            <p class="text-sm text-purple-600 mb-1">Remaining Balance</p>
                            <p class="text-2xl font-bold text-purple-700">{{ $leaveBalance->remaining_balance ?? 0 }}
                                days</p>
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
                        <p>Hello World</p>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
