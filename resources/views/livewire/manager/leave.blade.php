<div class="max-w-7xl mx-auto py-6 px-4">
    <!-- Include the Flash Message Component -->
    <x-shared.flash-message />
    
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Leave Approval Dashboard</h1>
        <p class="mt-1 text-sm text-gray-500">Manage leave requests from your department staff</p>
    </div>
    
    <!-- Filters and Search -->
    <div class="bg-white shadow-sm rounded-lg px-4 py-3 mb-6">
        <div class="flex flex-col md:flex-row gap-3 justify-between">
            <!-- Filter Tabs -->
            <div class="flex space-x-1 rounded-md p-1 bg-gray-100 flex-shrink-0">
                <button wire:click="updateFilter('pending')" 
                    class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors {{ $filter === 'pending' ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-200' }}">
                    Pending
                </button>
                <button wire:click="updateFilter('approved')" 
                    class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors {{ $filter === 'approved' ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-200' }}">
                    Approved
                </button>
                <button wire:click="updateFilter('rejected')" 
                    class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors {{ $filter === 'rejected' ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-200' }}">
                    Rejected
                </button>
                <button wire:click="updateFilter('all')" 
                    class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors {{ $filter === 'all' ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-200' }}">
                    All
                </button>
            </div>
            
            <!-- Search Box -->
            <div class="relative flex-grow max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input wire:model.live.debounce.300ms="searchQuery" wire:keydown.enter="search" type="text" placeholder="Search by name or ID..." 
                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm">
            </div>
        </div>
    </div>
    
    <!-- Leave Requests Table -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        @if(count($leaveRequests) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap cursor-pointer" wire:click="sortBy('id')">
                                ID
                                @if($sortField === 'id')
                                    <svg class="inline-block ml-1 w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        @if($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        @endif
                                    </svg>
                                @endif
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('user_id')">
                                Employee
                                @if($sortField === 'user_id')
                                    <svg class="inline-block ml-1 w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        @if($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        @endif
                                    </svg>
                                @endif
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('type')">
                                Type
                                @if($sortField === 'type')
                                    <svg class="inline-block ml-1 w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        @if($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        @endif
                                    </svg>
                                @endif
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('start_date')">
                                Duration
                                @if($sortField === 'start_date')
                                    <svg class="inline-block ml-1 w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        @if($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        @endif
                                    </svg>
                                @endif
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('status')">
                                Status
                                @if($sortField === 'status')
                                    <svg class="inline-block ml-1 w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        @if($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        @endif
                                    </svg>
                                @endif
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('created_at')">
                                Requested
                                @if($sortField === 'created_at')
                                    <svg class="inline-block ml-1 w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        @if($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        @endif
                                    </svg>
                                @endif
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($leaveRequests as $leave)
                            @php
                                $statusColor = match($leave->status) {
                                    'pending_manager' => 'bg-yellow-100 text-yellow-800',
                                    'pending_hr', 'pending_director' => 'bg-blue-100 text-blue-800',
                                    'approved' => 'bg-green-100 text-green-800',
                                    'rejected_manager', 'rejected_hr', 'rejected_director' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                                
                                $typeColor = match($leave->type) {
                                    'sick' => 'bg-red-100 text-red-800',
                                    'annual' => 'bg-blue-100 text-blue-800',
                                    'important' => 'bg-purple-100 text-purple-800',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                                
                                $statusText = match($leave->status) {
                                    'pending_manager' => 'Pending',
                                    'pending_hr' => 'HR Review',
                                    'pending_director' => 'Director Review',
                                    'approved' => 'Approved',
                                    'rejected_manager' => 'Rejected',
                                    'rejected_hr' => 'Rejected by HR',
                                    'rejected_director' => 'Rejected by Director',
                                    'cancel' => 'Cancelled',
                                    default => $leave->status
                                };
                                
                                // Calculate days
                                $start = \Carbon\Carbon::parse($leave->start_date);
                                $end = \Carbon\Carbon::parse($leave->end_date);
                                $days = $start->diffInDays($end) + 1;
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ str_pad($leave->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium text-gray-900">{{ $leave->user->name }}</div>
                                    </div>
                                    <div class="text-xs text-gray-500">{{ $leave->user->department ? $leave->user->department->name : 'No Department' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $typeColor }}">
                                        {{ ucfirst($leave->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ Carbon\Carbon::parse($leave->start_date)->format('M d') }}
                                    @if($leave->start_date != $leave->end_date)
                                     - {{ Carbon\Carbon::parse($leave->end_date)->format('M d, Y') }}
                                    @else
                                     (1 day)
                                    @endif
                                    <div class="text-xs text-gray-500 mt-1">{{ $days }} {{ Str::plural('day', $days) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $leave->created_at->format('M d, Y') }}
                                    <div class="text-xs text-gray-500">{{ $leave->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="viewLeave({{ $leave->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        View
                                    </button>
                                    @if($leave->status === 'pending_manager')
                                        <div class="inline-flex rounded-md shadow-sm" role="group">
                                            <button wire:click="prepareForRejection({{ $leave->id }})" class="text-red-600 hover:text-red-900">
                                                Reject
                                            </button>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No leave requests found</h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if($filter === 'pending')
                        There are no pending leave requests to review.
                    @elseif($filter === 'approved')
                        No approved leave requests.
                    @elseif($filter === 'rejected')
                        No rejected leave requests.
                    @else
                        No leave requests match your criteria.
                    @endif
                </p>
            </div>
        @endif
    </div>
    
    <!-- View Leave Request Modal -->
    <x-modals.modal name="view-leave-modal" maxWidth="lg">
        <div>
            <div class="border-b border-gray-200 bg-gray-50 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Leave Request Details</h3>
                <button wire:click="cancelViewLeave" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            @if($selectedLeave)
                <div class="p-6">
                    <!-- Employee & Leave Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                            <h4 class="text-sm font-medium text-gray-500 mb-2">EMPLOYEE DETAILS</h4>
                            <div class="mb-2">
                                <p class="text-base font-medium text-gray-900">{{ $selectedLeave->user->name }}</p>
                                <p class="text-sm text-gray-600">{{ $selectedLeave->user->department ? $selectedLeave->user->department->name : 'No Department' }}</p>
                            </div>
                            <div class="flex text-sm text-gray-600 items-center">
                                <svg class="h-4 w-4 text-gray-400 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                                {{ $selectedLeave->user->email }}
                            </div>
                        </div>
                        
                        <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                            <h4 class="text-sm font-medium text-gray-500 mb-2">LEAVE DETAILS</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Type</p>
                                    <p class="font-medium text-gray-900">{{ ucfirst($selectedLeave->type) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Duration</p>
                                    <p class="font-medium text-gray-900">
                                        @php
                                            $start = \Carbon\Carbon::parse($selectedLeave->start_date);
                                            $end = \Carbon\Carbon::parse($selectedLeave->end_date);
                                            $days = $start->diffInDays($end) + 1;
                                            $workingDays = 0;
                                            
                                            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                                                if (!in_array($date->dayOfWeek, [0, 6])) {
                                                    $workingDays++;
                                                }
                                            }
                                        @endphp
                                        {{ $workingDays }} {{ Str::plural('working day', $workingDays) }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">From</p>
                                    <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($selectedLeave->start_date)->format('M d, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">To</p>
                                    <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($selectedLeave->end_date)->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Reason Box -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Reason</label>
                        <div class="bg-gray-50 border border-gray-200 rounded-md p-3 text-gray-800">
                            {{ $selectedLeave->reason }}
                        </div>
                    </div>
                    
                    @if($selectedLeave->attachment_path)
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Attachment</label>
                            <a href="{{ Storage::url($selectedLeave->attachment_path) }}" target="_blank" 
                                class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="mr-2 -ml-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                                View Attachment
                            </a>
                        </div>
                    @endif
                    
                    @if($selectedLeave->status === 'pending_manager')
                        <!-- Signature Pad for Approval -->
                        <div x-data="signaturePad()" class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Your Signature</label>
                            <p class="text-sm text-gray-500 mb-2">Sign below to approve this leave request</p>
                            
                            <div class="border border-gray-300 rounded-lg shadow-sm overflow-hidden bg-white">
                                <canvas x-ref="signature_canvas" class="w-full h-52"></canvas>
                            </div>
                            
                            <div class="mt-2 flex justify-end">
                                <button @click="clearSignature()" type="button" class="mr-2 px-3 py-2 border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50">
                                    Clear
                                </button>
                            </div>
                            @error('signature') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="mt-8 flex justify-end gap-3">
                            <button wire:click="prepareForRejection({{ $selectedLeave->id }})" type="button" 
                                class="px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Reject
                            </button>
                            <button wire:click="approveLeave" type="button" 
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Approve
                            </button>
                        </div>
                    @else
                        <!-- Status Information -->
                        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">STATUS</h4>
                            <div class="flex items-center">
                                @php
                                    $statusColor = match($selectedLeave->status) {
                                        'pending_manager' => 'text-yellow-600',
                                        'pending_hr', 'pending_director' => 'text-blue-600',
                                        'approved' => 'text-green-600',
                                        'rejected_manager', 'rejected_hr', 'rejected_director' => 'text-red-600',
                                        default => 'text-gray-600'
                                    };
                                    
                                    $statusText = match($selectedLeave->status) {
                                        'pending_manager' => 'Pending Your Approval',
                                        'pending_hr' => 'Pending HR Approval',
                                        'pending_director' => 'Pending Director Approval',
                                        'approved' => 'Approved',
                                        'rejected_manager' => 'Rejected by You',
                                        'rejected_hr' => 'Rejected by HR',
                                        'rejected_director' => 'Rejected by Director',
                                        'cancel' => 'Cancelled by Employee',
                                        default => $selectedLeave->status
                                    };
                                @endphp
                                <span class="font-semibold {{ $statusColor }}">{{ $statusText }}</span>
                            </div>
                            
                            @if(str_contains($selectedLeave->status, 'rejected') && $selectedLeave->rejection_reason)
                                <div class="mt-3">
                                    <h5 class="text-sm font-medium text-gray-700">Rejection Reason:</h5>
                                    <p class="text-sm text-gray-600 bg-white border border-gray-200 rounded-md p-2 mt-1">
                                        {{ $selectedLeave->rejection_reason }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @else
                <div class="p-6">
                    <div class="text-center text-gray-500">
                        Loading leave request...
                    </div>
                </div>
            @endif
        </div>
    </x-modals.modal>
    
    <!-- Reject Leave Request Modal -->
    <x-modals.modal name="reject-leave-modal" maxWidth="md">
        <div>
            <div class="border-b border-gray-200 bg-gray-50 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Reject Leave Request</h3>
                <button wire:click="cancelRejection" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="p-6">
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                You are about to reject this leave request. This action cannot be undone.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="mb-5">
                    <label for="rejection-reason" class="block text-sm font-medium text-gray-700 mb-1">
                        Reason for Rejection <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        wire:model="rejectionReason" 
                        id="rejection-reason" 
                        rows="4" 
                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                        placeholder="Please provide a reason for rejecting this leave request..."></textarea>
                    @error('rejectionReason') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                
                <div class="mt-8 flex justify-end gap-3">
                    <button wire:click="cancelRejection" type="button" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <button wire:click="rejectLeave" type="button" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Reject Leave Request
                    </button>
                </div>
            </div>
        </div>
    </x-modals.modal>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('signaturePad', () => ({
                signaturePadInstance: null,

                init() {
                    this.$nextTick(() => {
                        this.initSignaturePad();
                        
                        // Handle modal open event to initialize signature pad
                        document.addEventListener('open-modal', (event) => {
                            if (event.detail === 'view-leave-modal') {
                                setTimeout(() => {
                                    this.initSignaturePad();
                                    this.resizeCanvas();
                                }, 100);
                            }
                        });
                        
                        window.addEventListener('resize', () => this.resizeCanvas());
                    });
                },

                initSignaturePad() {
                    const canvas = this.$refs.signature_canvas;
                    if (!canvas) return;
                    
                    if (this.signaturePadInstance) this.signaturePadInstance.off();
                    
                    this.signaturePadInstance = new SignaturePad(canvas, {
                        penColor: 'rgb(0, 0, 128)'
                    });
                    
                    // Handle existing signature if available
                    if (@this.get('signature')) {
                        this.signaturePadInstance.fromDataURL(@this.get('signature'));
                    }
                    
                    // Save signature to Livewire on end of drawing
                    this.signaturePadInstance.addEventListener("endStroke", () => {
                        @this.set('signature', this.signaturePadInstance.toDataURL('image/png'));
                    });
                    
                    this.resizeCanvas();
                },

                resizeCanvas() {
                    if (!this.signaturePadInstance) return;
                    
                    const canvas = this.signaturePadInstance.canvas;
                    const ratio = Math.max(window.devicePixelRatio || 1, 1);
                    const width = canvas.offsetWidth;
                    const height = canvas.offsetHeight;
                    const data = this.signaturePadInstance.toDataURL();
                    
                    canvas.width = width * ratio;
                    canvas.height = height * ratio;
                    canvas.getContext("2d").scale(ratio, ratio);
                    this.signaturePadInstance.clear();
                    
                    if (data !== this.signaturePadInstance.toDataURL()) {
                        this.signaturePadInstance.fromDataURL(data);
                    }
                },

                clearSignature() {
                    if (this.signaturePadInstance) {
                        this.signaturePadInstance.clear();
                        @this.set('signature', null);
                    }
                }
            }));
        });
        
        window.addEventListener('leave-approved', event => {
            window.location.reload();
        });
    </script>
</div>