<x-layouts.staff>
    <div>
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-white">Leave Management</h2>
                <p class="mt-1 text-sm text-white/80">Manage your leave requests and view your leave history</p>
            </div>
            <button x-data @click="$dispatch('open-modal', 'create-leave')"
                class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-lg hover:bg-blue-50 transition-colors duration-150">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Create Leave Request
            </button>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative"
                x-data="{ show: true }" x-show="show" x-transition>
                <div class="flex items-center justify-between">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        {{ session('success') }}
                    </span>
                    <button @click="show = false" class="text-green-700 hover:text-green-900">×</button>
                </div>
            </div>
        @endif

        {{-- Add this error notification section --}}
        @if (session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative"
                x-data="{ show: true }" x-show="show" x-transition>
                <div class="flex items-center justify-between">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        {{ session('error') }}
                    </span>
                    <button @click="show = false" class="text-red-700 hover:text-red-900">×</button>
                </div>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Leave Balance Card -->
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-200">
                <div class="flex justify-between mb-4">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Annual Leave Balance</p>
                        <div class="mt-2 flex items-baseline">
                            <p class="text-3xl font-bold text-gray-900">{{ $leaveBalance->remaining_balance ?? 0 }}</p>
                            <p class="ml-1 text-sm text-gray-500">days remaining</p>
                        </div>
                    </div>
                    <div class="bg-blue-50 rounded-full p-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                        <span>Total Balance</span>
                        <span>{{ $leaveBalance->total_balance ?? 0 }} days</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2.5">
                        @php
                            $percentage = $leaveBalance
                                ? ($leaveBalance->used_balance / $leaveBalance->total_balance) * 100
                                : 0;
                        @endphp
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">Used {{ $leaveBalance->used_balance ?? 0 }} days this year</p>
                </div>
            </div>

            <!-- Pending Requests Card -->
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-200">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pending Requests</p>
                        <div class="mt-2 flex items-baseline">
                            <p class="text-3xl font-bold text-gray-900">{{ $pendingCount ?? 0 }}</p>
                            <p class="ml-1 text-sm text-gray-500">requests</p>
                        </div>
                    </div>
                    <div class="bg-yellow-50 rounded-full p-3">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                @if ($pendingCount > 0)
                    <a href="#pending-requests"
                        class="mt-4 inline-flex items-center text-sm text-blue-600 hover:text-blue-700">
                        View pending requests
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                @endif
            </div>

            <!-- Recent Activity Card -->
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-200">
                <div class="flex justify-between mb-4">
                    <p class="text-sm font-medium text-gray-600">Recent Activity</p>
                    <div class="bg-green-50 rounded-full p-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
                @if ($recentActivity && $recentActivity->count() > 0)
                    <div class="space-y-3">
                        @foreach ($recentActivity as $activity)
                            <div class="flex items-center">
                                <div @class([
                                    'w-2 h-2 rounded-full mr-2',
                                    'bg-green-500' => $activity->status === 'approved',
                                    'bg-red-500' => $activity->status === 'rejected',
                                    'bg-yellow-500' => $activity->status === 'pending',
                                    'bg-gray-500' => $activity->status === 'cancel',
                                ])></div>
                                <span class="text-sm text-gray-600">
                                    <span class="font-medium">{{ ucfirst($activity->type) }}</span> leave -
                                    <span class="capitalize">{{ $activity->status }}</span>
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500">No recent activity</p>
                @endif
            </div>
        </div>

        <!-- Leave Requests Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="border-b border-gray-100">
                <div class="px-6 py-4">
                    <h3 class="text-lg font-medium text-gray-900">Leave History</h3>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Duration</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Reason</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($leaveRequests as $request)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div @class([
                                            'w-2 h-2 rounded-full mr-2',
                                            'bg-blue-500' => $request->type === 'annual',
                                            'bg-red-500' => $request->type === 'sick',
                                            'bg-yellow-500' => $request->type === 'important',
                                            'bg-gray-500' => $request->type === 'other',
                                        ])></div>
                                        <span class="font-medium text-gray-900 capitalize">{{ $request->type }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-sm text-gray-900">
                                            {{ \Cake\Chronos\Chronos::parse($request->start_date)->format('M d, Y') }}
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            to {{ \Cake\Chronos\Chronos::parse($request->end_date)->format('M d, Y') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span @class([
                                        'px-2 py-1 text-xs font-medium rounded-full',
                                        'bg-yellow-100 text-yellow-800' => $request->status === 'pending',
                                        'bg-green-100 text-green-800' => $request->status === 'approved',
                                        'bg-red-100 text-red-800' => $request->status === 'rejected',
                                        'bg-gray-100 text-gray-800' => $request->status === 'cancel',
                                    ])>
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <button @click="$dispatch('open-modal', 'view-reason-{{ $request->id }}')"
                                        class="inline-flex items-center text-sm text-gray-900 hover:text-blue-600 group">
                                        <span class="truncate max-w-xs">{{ Str::limit($request->reason, 50) }}</span>
                                        <svg class="w-4 h-4 ml-1 text-gray-400 group-hover:text-blue-600"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex items-center gap-3">
                                        @if ($request->status === 'pending')
                                            <button
                                                @click="$dispatch('open-modal', 'cancel-leave-{{ $request->id }}')"
                                                class="text-red-600 hover:text-red-900 font-medium">
                                                Cancel Request
                                            </button>
                                        @endif
                                        @if ($request->attachment_path)
                                            <a href="{{ Storage::url($request->attachment_path) }}" target="_blank"
                                                class="text-blue-600 hover:text-blue-900">
                                                View Attachment
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- View Details Modal -->
                            <x-modals.modal name="view-reason-{{ $request->id }}" :show="false">
                                <div class="p-6">
                                    <div class="flex items-start justify-between mb-6">
                                        <div>
                                            <h2 class="text-xl font-bold text-gray-900">Leave Request Details</h2>
                                            <p class="mt-1 text-sm text-gray-500">Submitted on
                                                {{ $request->created_at->format('M d, Y \a\t h:i A') }}</p>
                                        </div>
                                        <span @class([
                                            'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
                                            'bg-yellow-100 text-yellow-800' => $request->status === 'pending',
                                            'bg-green-100 text-green-800' => $request->status === 'approved',
                                            'bg-red-100 text-red-800' => $request->status === 'rejected',
                                            'bg-gray-100 text-gray-800' => $request->status === 'cancel',
                                        ])>
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </div>

                                    <div class="space-y-6">
                                        <!-- Leave Information -->
                                        <div class="bg-gray-50 rounded-lg p-4">
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-500">Leave Type</p>
                                                    <div class="mt-1 flex items-center">
                                                        <div @class([
                                                            'w-2 h-2 rounded-full mr-2',
                                                            'bg-blue-500' => $request->type === 'annual',
                                                            'bg-red-500' => $request->type === 'sick',
                                                            'bg-yellow-500' => $request->type === 'important',
                                                            'bg-gray-500' => $request->type === 'other',
                                                        ])></div>
                                                        <p class="text-sm font-medium text-gray-900 capitalize">
                                                            {{ $request->type }}</p>
                                                    </div>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-500">Duration</p>
                                                    <p class="mt-1 text-sm text-gray-900">
                                                        {{ $request->getDurationInDays() }} days</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Date Details -->
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <p class="text-sm font-medium text-gray-500">Start Date</p>
                                                <p class="mt-1 text-sm text-gray-900">
                                                    {{ \Cake\Chronos\Chronos::parse($request->start_date)->format('M d, Y') }}
                                                </p>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-500">End Date</p>
                                                <p class="mt-1 text-sm text-gray-900">
                                                    {{ \Cake\Chronos\Chronos::parse($request->end_date)->format('M d, Y') }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Reason -->
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Reason</p>
                                            <p class="mt-1 text-sm text-gray-900">{{ $request->reason }}</p>
                                        </div>

                                        <!-- Attachment -->
                                        @if ($request->attachment_path)
                                            <div>
                                                <p class="text-sm font-medium text-gray-500">Supporting Document</p>
                                                <a href="{{ Storage::url($request->attachment_path) }}"
                                                    target="_blank"
                                                    class="mt-2 inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    View Document
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Close Button -->
                                    <div class="mt-8">
                                        <button type="button"
                                            @click="$dispatch('close-modal', 'view-reason-{{ $request->id }}')"
                                            class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-100 border border-transparent rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </x-modals.modal>

                            <!-- Cancel Modal -->
                            @if ($request->status === 'pending')
                                <x-modals.modal name="cancel-leave-{{ $request->id }}" :show="false">
                                    <div class="p-6">
                                        <div
                                            class="flex items-center justify-center w-12 h-12 mx-auto mb-4 bg-red-100 rounded-full">
                                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                        </div>

                                        <h3 class="mb-2 text-xl font-bold text-center text-gray-900">Cancel Leave
                                            Request</h3>
                                        <p class="text-sm text-center text-gray-500 mb-6">
                                            Are you sure you want to cancel this leave request? This action cannot be
                                            undone.
                                        </p>

                                        <div class="bg-gray-50 rounded-lg p-4 mb-6">
                                            <dl class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <dt class="text-sm font-medium text-gray-500">Leave Type</dt>
                                                    <dd class="mt-1 text-sm text-gray-900 capitalize">
                                                        {{ $request->type }}</dd>
                                                </div>
                                                <div>
                                                    <dt class="text-sm font-medium text-gray-500">Duration</dt>
                                                    <dd class="mt-1 text-sm text-gray-900">
                                                        {{ $request->getDurationInDays() }} days</dd>
                                                </div>
                                                <div class="col-span-2">
                                                    <dt class="text-sm font-medium text-gray-500">Date Range</dt>
                                                    <dd class="mt-1 text-sm text-gray-900">
                                                        {{ \Cake\Chronos\Chronos::parse($request->start_date)->format('M d, Y') }}
                                                        to
                                                        {{ \Cake\Chronos\Chronos::parse($request->end_date)->format('M d, Y') }}
                                                    </dd>
                                                </div>
                                            </dl>
                                        </div>

                                        <form method="POST" action="{{ route('staff.leave.cancel', $request) }}">
                                            @csrf
                                            <div class="flex justify-end gap-3">
                                                <button type="button"
                                                    @click="$dispatch('close-modal', 'cancel-leave-{{ $request->id }}')"
                                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                                    No, Keep It
                                                </button>
                                                <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Yes, Cancel Request
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </x-modals.modal>
                            @endif
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
            @if ($leaveRequests->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $leaveRequests->links() }}
                </div>
            @endif
        </div>

        {{-- Create Leave Request Modal --}}
        <x-modals.modal name="create-leave" :show="false" maxWidth="md">
            <div class="p-6">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Create Leave Request</h2>
                    <p class="mt-2 text-sm text-gray-600">Please fill in the details for your leave request</p>
                </div>

                <form method="POST" action="{{ route('staff.leave.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-6">
                        <!-- Leave Type -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-900">Leave Type</label>
                            <select id="type" name="type"
                                class="mt-2 block w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                                <option value="" selected disabled>Select leave type</option>
                                <option value="annual">Annual Leave</option>
                                <option value="sick">Sick Leave</option>
                                <option value="important">Important Leave</option>
                                <option value="other">Other</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date Selection -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-900">Start
                                    Date</label>
                                <input type="date" id="start_date" name="start_date" min="{{ date('Y-m-d') }}"
                                    class="mt-2 block w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                                @error('start_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-900">End Date</label>
                                <input type="date" id="end_date" name="end_date" min="{{ date('Y-m-d') }}"
                                    class="mt-2 block w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                                @error('end_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Reason -->
                        <div>
                            <label for="reason" class="block text-sm font-medium text-gray-900">Reason</label>
                            <textarea id="reason" name="reason" rows="4"
                                class="mt-2 block w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
                                placeholder="Please provide a detailed reason for your leave request"></textarea>
                            @error('reason')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- File Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-900">
                                Supporting Document <span class="text-gray-500 text-xs">(optional)</span>
                            </label>
                            <div class="mt-2">
                                <label
                                    class="group relative flex justify-center items-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer hover:bg-gray-50">
                                    <div class="text-center p-6">
                                        <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-gray-500"
                                            stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4-4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600 mt-2">
                                            <span
                                                class="relative rounded-md font-medium text-blue-600 hover:text-blue-700 focus-within:outline-none">
                                                Upload a file
                                            </span>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">PDF, PNG, JPG up to 10MB</p>
                                    </div>
                                    <input type="file" id="attachment" name="attachment"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                </label>
                            </div>
                            @error('attachment')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="mt-8 flex justify-end gap-3">
                        <button type="button" @click="$dispatch('close-modal', 'create-leave')"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </button>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Submit Request
                        </button>
                    </div>
                </form>
            </div>
        </x-modals.modal>
    </div>
</x-layouts.staff>
