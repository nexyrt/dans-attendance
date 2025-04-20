<!-- resources/views/livewire/manager/leave.blade.php -->
<div class="max-w-7xl mx-auto py-6 px-4" x-data="leaveManagement()">
    <!-- Include the Flash Message Component -->
    <x-shared.flash-message />

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Leave Approval Dashboard</h1>
            <p class="mt-1 text-sm text-gray-600">Manage leave requests from staff in your department</p>
        </div>

        <!-- Summary Stats -->
        <div class="flex mt-4 md:mt-0 space-x-3 overflow-x-auto">
            <div class="bg-white shadow rounded-lg px-4 py-2 flex items-center w-auto min-w-[140px]">
                <div class="bg-yellow-100 p-2 rounded-full mr-3">
                    <svg class="h-5 w-5 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Pending</p>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ $leaveRequests->where('status', 'pending_manager')->count() }}
                    </p>
                </div>
            </div>
            <div class="bg-white shadow rounded-lg px-4 py-2 flex items-center w-auto min-w-[140px]">
                <div class="bg-blue-100 p-2 rounded-full mr-3">
                    <svg class="h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">With HR</p>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ $leaveRequests->where('status', 'pending_hr')->count() }}
                    </p>
                </div>
            </div>
            <div class="bg-white shadow rounded-lg px-4 py-2 flex items-center w-auto min-w-[140px]">
                <div class="bg-green-100 p-2 rounded-full mr-3">
                    <svg class="h-5 w-5 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Approved</p>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ $leaveRequests->where('status', 'approved')->count() }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="bg-white shadow-md rounded-lg mb-6">
        <div class="md:px-6 md:py-4 border-b border-gray-200 bg-gray-50 px-4 py-3">
            <h2 class="text-lg font-medium text-gray-900">Filters</h2>
        </div>
        <div class="p-4 md:p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label for="searchTerm" class="block text-sm font-medium text-gray-700 mb-1">Search Staff</label>
                    <div class="relative">
                        <input type="text" id="searchTerm" wire:model.live.debounce.300ms="searchTerm"
                            class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                            placeholder="Name or email">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="status" wire:model.live="status"
                        class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        <option value="">All Statuses</option>
                        <option value="pending_manager">Pending Approval</option>
                        <option value="pending_hr">Pending HR</option>
                        <option value="pending_director">Pending Director</option>
                        <option value="approved">Approved</option>
                        <option value="rejected_manager">Rejected by Manager</option>
                        <option value="rejected_hr">Rejected by HR</option>
                        <option value="rejected_director">Rejected by Director</option>
                        <option value="cancel">Cancelled</option>
                    </select>
                </div>

                <!-- Date Range Picker -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                    <livewire:date-range-picker :start-date="$start_date" :end-date="$end_date"
                        wire:key="manager-leave-date-picker" />
                </div>

                <!-- Reset Button -->
                <div class="flex items-end">
                    <button wire:click="resetFilters" type="button"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset Filters
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Leave Requests Table -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="md:px-6 md:py-4 border-b border-gray-200 bg-gray-50 px-4 py-3">
            <h2 class="text-lg font-medium text-gray-900">Leave Requests</h2>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            @if (count($leaveRequests) > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Staff
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Leave Type
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Period
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Duration
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($leaveRequests as $request)
                            @php
                                // Calculate working days
                                $leaveStart = \Carbon\Carbon::parse($request->start_date);
                                $leaveEnd = \Carbon\Carbon::parse($request->end_date);
                                $workDays = 0;

                                for ($date = $leaveStart->copy(); $date->lte($leaveEnd); $date->addDay()) {
                                    if (!in_array($date->dayOfWeek, [0, 6])) {
                                        $workDays++;
                                    }
                                }

                                // Status classes
                                $statusInfo = [
                                    'pending_manager' => [
                                        'bg' => 'bg-yellow-100',
                                        'text' => 'text-yellow-800',
                                        'label' => 'Pending Approval',
                                        'icon' =>
                                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                    ],
                                    'pending_hr' => [
                                        'bg' => 'bg-blue-100',
                                        'text' => 'text-blue-800',
                                        'label' => 'Pending HR',
                                        'icon' =>
                                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                    ],
                                    'pending_director' => [
                                        'bg' => 'bg-purple-100',
                                        'text' => 'text-purple-800',
                                        'label' => 'Pending Director',
                                        'icon' =>
                                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                    ],
                                    'approved' => [
                                        'bg' => 'bg-green-100',
                                        'text' => 'text-green-800',
                                        'label' => 'Approved',
                                        'icon' =>
                                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                    ],
                                    'rejected_manager' => [
                                        'bg' => 'bg-red-100',
                                        'text' => 'text-red-800',
                                        'label' => 'Rejected by Manager',
                                        'icon' =>
                                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                    ],
                                    'rejected_hr' => [
                                        'bg' => 'bg-red-100',
                                        'text' => 'text-red-800',
                                        'label' => 'Rejected by HR',
                                        'icon' =>
                                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                    ],
                                    'rejected_director' => [
                                        'bg' => 'bg-red-100',
                                        'text' => 'text-red-800',
                                        'label' => 'Rejected by Director',
                                        'icon' =>
                                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                    ],
                                    'cancel' => [
                                        'bg' => 'bg-gray-100',
                                        'text' => 'text-gray-800',
                                        'label' => 'Cancelled',
                                        'icon' =>
                                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />',
                                    ],
                                ];

                                $typeColors = [
                                    'annual' => [
                                        'bg' => 'bg-blue-100',
                                        'text' => 'text-blue-600',
                                        'label' => 'Annual',
                                    ],
                                    'sick' => [
                                        'bg' => 'bg-red-100',
                                        'text' => 'text-red-600',
                                        'label' => 'Sick',
                                    ],
                                    'important' => [
                                        'bg' => 'bg-purple-100',
                                        'text' => 'text-purple-600',
                                        'label' => 'Important',
                                    ],
                                    'other' => [
                                        'bg' => 'bg-gray-100',
                                        'text' => 'text-gray-600',
                                        'label' => 'Other',
                                    ],
                                ];
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <!-- Staff -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if ($request->user->image)
                                                <img class="h-10 w-10 rounded-full object-cover"
                                                    src="{{ Storage::url($request->user->image) }}"
                                                    alt="{{ $request->user->name }}">
                                            @else
                                                <div
                                                    class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                    <span
                                                        class="text-gray-500 font-medium">{{ substr($request->user->name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $request->user->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">{{ $request->user->email }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Leave Type -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $typeColors[$request->type]['bg'] }} {{ $typeColors[$request->type]['text'] }}">
                                        {{ $typeColors[$request->type]['label'] }}
                                    </span>
                                </td>

                                <!-- Period -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($request->start_date)->format('M d, Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        to {{ \Carbon\Carbon::parse($request->end_date)->format('M d, Y') }}
                                    </div>
                                </td>

                                <!-- Duration -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $workDays }} {{ Str::plural('day', $workDays) }}
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusInfo[$request->status]['bg'] }} {{ $statusInfo[$request->status]['text'] }}">
                                        <svg class="mr-1 h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            {!! $statusInfo[$request->status]['icon'] !!}
                                        </svg>
                                        {{ $statusInfo[$request->status]['label'] }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        @if ($request->status === 'pending_manager')
                                            <button @click="openApprovalModal({{ $request->id }})"
                                                class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 rounded px-2 py-1 transition-colors duration-200 flex items-center">
                                                <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Approve
                                            </button>
                                            <button @click="openRejectionModal({{ $request->id }})"
                                                class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 rounded px-2 py-1 transition-colors duration-200 flex items-center">
                                                <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Reject
                                            </button>
                                        @endif
                                        <!-- View Details Button -->
                                        <button @click="downloadPdf({{ $request->id }})"
                                            class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 rounded px-2 py-1 transition-colors duration-200 flex items-center">
                                            <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            PDF
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $leaveRequests->links() }}
                </div>
            @else
                <div class="py-12 flex flex-col items-center justify-center">
                    <svg class="h-12 w-12 text-gray-400 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="text-base font-medium text-gray-900">No leave requests found</h3>
                    <p class="text-sm text-gray-500 mb-4">No leave requests match your current filters</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Approval Modal -->
    <div x-show="approvalModalOpen" x-cloak class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
        <div @click.away="closeApprovalModal" x-data="signaturePad()" class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="border-b border-gray-200 bg-gray-50 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Approve Leave Request</h3>
                <button @click="closeApprovalModal" class="text-gray-500 hover:text-gray-700">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-6">
                <!-- Approval Form -->
                <div class="mb-4">
                    <p class="text-sm text-gray-600">Please sign below to approve this leave request.</p>
                    <p class="text-sm text-gray-600 mt-1">After your approval, this request will be sent to HR for
                        further review.</p>
                </div>

                <div class="border border-gray-300 rounded-lg shadow-sm overflow-hidden bg-white w-full mx-auto">
                    <canvas x-ref="signature_canvas" class="w-full h-64"></canvas>
                </div>

                <div x-show="approvalError" class="mt-2 text-sm text-red-600" x-text="approvalError"></div>

                <div class="mt-4 flex justify-between">
                    <button @click="clearSignature()"
                        class="px-3 py-2 border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="inline-block mr-1 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                                clip-rule="evenodd" />
                        </svg>
                        Clear Signature
                    </button>
                    <div>
                        <button @click="closeApprovalModal"
                            class="inline-flex justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 mr-3">
                            Cancel
                        </button>
                        <button @click="submitApproval" :disabled="approvalSubmitting"
                            class="inline-flex justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 disabled:opacity-75 disabled:cursor-not-allowed">
                            <span x-show="approvalSubmitting" class="inline-block mr-2">
                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </span>
                            Approve Request
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rejection Modal -->
    <div x-show="rejectionModalOpen" x-cloak class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
        <div @click.away="closeRejectionModal" class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="border-b border-gray-200 bg-gray-50 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Reject Leave Request</h3>
                <button @click="closeRejectionModal" class="text-gray-500 hover:text-gray-700">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-6">
                <!-- Rejection Form -->
                <div class="mb-4">
                    <label for="rejectionReason" class="block text-sm font-medium text-gray-700">
                        Reason for Rejection
                    </label>
                    <p class="text-sm text-gray-500 mb-2">Please provide a detailed explanation for rejecting this
                        leave request.</p>
                    <textarea id="rejectionReason" x-model="rejectionReason" rows="4"
                        class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                        placeholder="Enter reason for rejection"></textarea>
                    <div x-show="rejectionReasonError" class="mt-1 text-sm text-red-600" x-text="rejectionReasonError"></div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button @click="closeRejectionModal"
                        class="inline-flex justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 mr-3">
                        Cancel
                    </button>
                    <button @click="submitRejection" :disabled="rejectionSubmitting"
                        class="inline-flex justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 disabled:opacity-75 disabled:cursor-not-allowed">
                        <span x-show="rejectionSubmitting" class="inline-block mr-2">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                        Reject Request
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('leaveManagement', () => ({
                approvalModalOpen: false,
                rejectionModalOpen: false,
                currentLeaveId: null,
                rejectionReason: '',
                rejectionReasonError: '',
                rejectionSubmitting: false,
                approvalSubmitting: false,
                approvalError: '',
                
                // Open the approval modal
                openApprovalModal(leaveId) {
                    this.currentLeaveId = leaveId;
                    this.approvalModalOpen = true;
                    this.approvalError = '';
                    this.approvalSubmitting = false;
                },
                
                // Open the rejection modal
                openRejectionModal(leaveId) {
                    this.currentLeaveId = leaveId;
                    this.rejectionReason = '';
                    this.rejectionReasonError = '';
                    this.rejectionModalOpen = true;
                    this.rejectionSubmitting = false;
                },
                
                // Close approval modal
                closeApprovalModal() {
                    this.approvalModalOpen = false;
                    this.currentLeaveId = null;
                    this.approvalError = '';
                    this.approvalSubmitting = false;
                },
                
                // Close rejection modal
                closeRejectionModal() {
                    this.rejectionModalOpen = false;
                    this.currentLeaveId = null;
                    this.rejectionReason = '';
                    this.rejectionReasonError = '';
                    this.rejectionSubmitting = false;
                },
                
                // Submit the approval with signature
                async submitApproval() {
                    // Get signature from the component
                    const signatureComponent = Alpine.$data(document.querySelector('[x-data="signaturePad()"]'));
                    
                    if (!signatureComponent.signaturePadInstance || signatureComponent.signaturePadInstance.isEmpty()) {
                        this.approvalError = 'Please sign before approving';
                        return;
                    }
                    
                    try {
                        this.approvalSubmitting = true;
                        this.approvalError = '';
                        
                        const signature = signatureComponent.signaturePadInstance.toDataURL('image/png');
                        
                        // Call the server using fetch API
                        const response = await fetch('/api/manager/leave/approve', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                leaveId: this.currentLeaveId,
                                signature: signature
                            })
                        });
                        
                        const result = await response.json();
                        
                        if (!response.ok) {
                            throw new Error(result.message || 'Failed to approve leave request');
                        }
                        
                        // Show success notification
                        this.showNotification('Leave request approved successfully. It has been forwarded to HR for review.', 'success');
                        
                        // Close the modal and refresh the component
                        this.closeApprovalModal();
                        Livewire.dispatch('refresh');
                        
                    } catch (error) {
                        this.approvalError = error.message || 'Failed to approve leave request. Please try again.';
                    } finally {
                        this.approvalSubmitting = false;
                    }
                },
                
                // Submit the rejection with reason
                async submitRejection() {
                    // Validate rejection reason
                    if (!this.rejectionReason || this.rejectionReason.length < 5) {
                        this.rejectionReasonError = 'Please provide a reason for rejection (at least 5 characters)';
                        return;
                    }
                    
                    try {
                        this.rejectionSubmitting = true;
                        this.rejectionReasonError = '';
                        
                        // Call the server using fetch API
                        const response = await fetch('/api/manager/leave/reject', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                leaveId: this.currentLeaveId,
                                reason: this.rejectionReason
                            })
                        });
                        
                        const result = await response.json();
                        
                        if (!response.ok) {
                            throw new Error(result.message || 'Failed to reject leave request');
                        }
                        
                        // Show success notification
                        this.showNotification('Leave request has been rejected', 'success');
                        
                        // Close the modal and refresh the component
                        this.closeRejectionModal();
                        Livewire.dispatch('refresh');
                        
                    } catch (error) {
                        this.rejectionReasonError = error.message || 'Failed to reject leave request. Please try again.';
                    } finally {
                        this.rejectionSubmitting = false;
                    }
                },
                
                // Download PDF
                async downloadPdf(leaveId) {
                    try {
                        window.location.href = `/manager/leave/${leaveId}/pdf`;
                    } catch (error) {
                        this.showNotification('Failed to download PDF. Please try again.', 'error');
                    }
                },
                
                // Show notification
                showNotification(message, type = 'success') {
                    const event = type === 'success' ? 'notify-success' : 'notify-error';
                    window.dispatchEvent(new CustomEvent(event, { 
                        detail: { message } 
                    }));
                }
            }));
            
            Alpine.data('signaturePad', () => ({
                signaturePadInstance: null,

                init() {
                    this.$nextTick(() => {
                        this.initSignaturePad();
                    });
                    
                    // Re-initialize when approvalModalOpen changes
                    this.$watch('$parent.approvalModalOpen', (value) => {
                        if (value) {
                            setTimeout(() => {
                                this.initSignaturePad();
                            }, 100);
                        }
                    });
                },

                initSignaturePad() {
                    const canvas = this.$refs.signature_canvas;
                    if (!canvas) return;

                    // Clean up previous instance if it exists
                    if (this.signaturePadInstance) {
                        this.signaturePadInstance.off();
                    }

                    // Set canvas dimensions to match the container
                    const ratio = Math.max(window.devicePixelRatio || 1, 1);
                    canvas.width = canvas.offsetWidth * ratio;
                    canvas.height = canvas.offsetHeight * ratio;
                    canvas.getContext("2d").scale(ratio, ratio);

                    // Initialize signature pad
                    this.signaturePadInstance = new SignaturePad(canvas, {
                        penColor: 'rgb(0, 0, 128)',
                        backgroundColor: 'rgb(255, 255, 255)'
                    });
                },

                clearSignature() {
                    if (this.signaturePadInstance) {
                        this.signaturePadInstance.clear();
                    }
                }
            }));
        });
    </script>
</div>
