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
                            <p class="text-2xl font-bold text-purple-700">{{ $leaveBalance->remaining_balance ?? 0 }} days</p>
                        </div>
                    </div>
                </div>
        
                <!-- Tab Navigation -->
                <div class="mb-6">
                    <nav class="flex space-x-4" aria-label="Tabs">
                        <button 
                            wire:click="setTab('requests')"
                            class="px-3 py-2 text-sm font-medium rounded-md {{ $activeTab === 'requests' ? 'bg-indigo-100 text-indigo-700' : 'text-gray-500 hover:text-gray-700' }}"
                        >
                            My Leave Requests
                        </button>
                        <button 
                            wire:click="setTab('new-request')"
                            class="px-3 py-2 text-sm font-medium rounded-md {{ $activeTab === 'new-request' ? 'bg-indigo-100 text-indigo-700' : 'text-gray-500 hover:text-gray-700' }}"
                        >
                            New Leave Request
                        </button>
                    </nav>
                </div>
        
                <!-- Tab Content -->
                <div>
                    @if($activeTab === 'requests')
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div class="flex-1">
                                <input 
                                    wire:model.live.debounce.300ms="search" 
                                    type="search" 
                                    placeholder="Search by reason..." 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                            </div>
                            <div class="flex flex-wrap gap-4">
                                <select 
                                    wire:model.live="statusFilter"
                                    class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                    <option value="">All Status</option>
                                    @foreach(App\Models\LeaveRequest::STATUSES as $status)
                                        <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                
                                <select 
                                    wire:model.live="typeFilter"
                                    class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                    <option value="">All Types</option>
                                    @foreach(App\Models\LeaveRequest::TYPES as $type)
                                        <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                                    @endforeach
                                </select>
                
                                <button 
                                    wire:click="resetFilters"
                                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                                >
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>
                
                    <!-- Leave Requests Table -->
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="min-w-full divide-y divide-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($leaveRequests as $leave)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize
                                                    {{ match($leave->type) {
                                                        'sick' => 'bg-red-100 text-red-800',
                                                        'annual' => 'bg-blue-100 text-blue-800',
                                                        'important' => 'bg-yellow-100 text-yellow-800',
                                                        default => 'bg-gray-100 text-gray-800',
                                                    } }}">
                                                    {{ $leave->type }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $leave->start_date->format('M d, Y') }}
                                                    @if($leave->start_date != $leave->end_date)
                                                        - {{ $leave->end_date->format('M d, Y') }}
                                                    @endif
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $leave->getDurationInDays() }} day(s)
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize {{ $leave->status_badge }}">
                                                    {{ $leave->status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 max-w-xs truncate">{{ $leave->reason }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                @if($leave->canBeCancelled())
                                                    <button
                                                        wire:click="cancelLeave({{ $leave->id }})"
                                                        wire:confirm="Are you sure you want to cancel this leave request?"
                                                        class="text-red-600 hover:text-red-900"
                                                    >
                                                        Cancel
                                                    </button>
                                                @else
                                                    <span class="text-gray-400">No actions available</span>
                                                @endif
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
                
                        <!-- Pagination -->
                        <div class="px-6 py-4 border-t border-gray-200">
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
