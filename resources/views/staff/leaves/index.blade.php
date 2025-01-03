<x-layouts.staff>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Leave Management</h2>
                    <p class="mt-1 text-sm text-gray-600">Manage your leave requests and view your leave history</p>
                </div>
                <button x-data @click="$dispatch('open-modal', 'create-leave')"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create Leave Request
                </button>
            </div>

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    x-data="{ show: true }" x-show="show" x-transition>
                    <div class="flex justify-between items-center">
                        <p class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            {{ session('success') }}
                        </p>
                        <button @click="show = false" class="text-green-700">×</button>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                    x-data="{ show: true }" x-show="show" x-transition>
                    <div class="flex justify-between items-center">
                        <p class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ session('error') }}
                        </p>
                        <button @click="show = false" class="text-red-700">×</button>
                    </div>
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Leave Balance Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Annual Leave Balance</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $leaveBalance->remaining_balance ?? 0 }} Days
                            </p>
                            <p class="text-sm text-gray-500 mt-1">of {{ $leaveBalance->total_balance ?? 0 }} days total
                            </p>
                        </div>
                        <div class="rounded-full bg-blue-50 p-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 bg-gray-50 rounded-lg p-3">
                        @php
                            $percentage = $leaveBalance
                                ? ($leaveBalance->used_balance / $leaveBalance->total_balance) * 100
                                : 0;
                        @endphp
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 rounded-full h-2" style="width: {{ $percentage }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Used {{ $leaveBalance->used_balance ?? 0 }} days this year
                        </p>
                    </div>
                </div>

                <!-- Pending Requests Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Pending Requests</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $pendingCount ?? 0 }}</p>
                            <p class="text-sm text-gray-500 mt-1">awaiting approval</p>
                        </div>
                        <div class="rounded-full bg-yellow-50 p-3">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex justify-between items-start mb-4">
                        <p class="text-sm font-medium text-gray-600">Recent Activity</p>
                        <div class="rounded-full bg-green-50 p-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                    @if ($recentActivity && $recentActivity->count() > 0)
                        <div class="space-y-3">
                            @foreach ($recentActivity as $activity)
                                <div class="flex items-center text-sm">
                                    <span
                                        class="w-2 h-2 rounded-full mr-2 {{ $activity->status === 'approved' ? 'bg-green-500' : ($activity->status === 'rejected' ? 'bg-red-500' : ($activity->status === 'pending' ? 'bg-yellow-500' : 'bg-gray-500')) }}">
                                    </span>
                                    <span class="text-gray-600">{{ $activity->type }} leave -
                                        {{ ucfirst($activity->status) }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No recent activity</p>
                    @endif
                </div>
            </div>

            <!-- Leave Requests Table -->
            <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-medium text-gray-900">Leave History</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Duration
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reason</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($leaveRequests as $request)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="capitalize font-medium text-gray-900">{{ $request->type }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="text-sm text-gray-900">
                                                {{ \Cake\Chronos\Chronos::parse($request->start_date)->format('M d, Y') }}
                                            </span>
                                            <span class="text-sm text-gray-500">
                                                to
                                                {{ \Cake\Chronos\Chronos::parse($request->end_date)->format('M d, Y') }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span @class([
                                            'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
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
                                            class="text-sm text-gray-900 hover:text-blue-600 truncate max-w-xs">
                                            {{ Str::limit($request->reason, 50) }}
                                        </button>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if ($request->status === 'pending')
                                            <button type="button"
                                                @click="$dispatch('open-modal', 'cancel-leave-{{ $request->id }}')"
                                                class="text-red-600 hover:text-red-900 font-medium">
                                                Cancel Request
                                            </button>
                                        @endif
                                    </td>
                                </tr>

                                <!-- View Details Modal -->
                                <x-modals.modal name="view-reason-{{ $request->id }}" :show="false">
                                    <div class="p-6">
                                        <h2 class="text-lg font-medium text-gray-900 mb-4">Leave Request Details</h2>
                                        <dl class="space-y-4">
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Type</dt>
                                                <dd class="mt-1 text-sm text-gray-900 capitalize">{{ $request->type }}
                                                </dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Duration</dt>
                                                <dd class="mt-1 text-sm text-gray-900">
                                                    {{ \Cake\Chronos\Chronos::parse($request->start_date)->format('M d, Y') }}
                                                    to
                                                    {{ \Cake\Chronos\Chronos::parse($request->end_date)->format('M d, Y') }}
                                                    ({{ $request->getDurationInDays() }} days)
                                                </dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Reason</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $request->reason }}</dd>
                                            </div>
                                            @if ($request->attachment_path)
                                                <div>
                                                    <dt class="text-sm font-medium text-gray-500">Attachment</dt>
                                                    <dd class="mt-1">
                                                        <a href="{{ Storage::url($request->attachment_path) }}"
                                                            target="_blank"
                                                            class="inline-flex items-center text-sm text-blue-600 hover:text-blue-700">
                                                            <svg class="w-4 h-4 mr-1" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 10v6m0 0l-3-3m3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                            </svg>
                                                            View Attachment
                                                        </a>
                                                    </dd>
                                                </div>
                                            @endif
                                        </dl>
                                        <div class="mt-6">
                                            <button type="button"
                                                @click="$dispatch('close-modal', 'view-reason-{{ $request->id }}')"
                                                class="w-full inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200">
                                                Close
                                            </button>
                                        </div>
                                    </div>
                                </x-modals.modal>

                                <!-- Cancel Request Modal -->
                                @if ($request->status === 'pending')
                                    <x-modals.modal name="cancel-leave-{{ $request->id }}" :show="false">
                                        <div class="p-6">
                                            <h2 class="text-lg font-semibold text-gray-900 mb-2">Cancel Leave Request
                                            </h2>
                                            <p class="text-sm text-gray-600 mb-6">Are you sure you want to cancel this
                                                leave request?</p>

                                            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                                                <dl class="space-y-2">
                                                    <div>
                                                        <dt class="text-sm font-medium text-gray-500">Leave Type</dt>
                                                        <dd class="mt-1 text-sm text-gray-900 capitalize">
                                                            {{ $request->type }}</dd>
                                                    </div>
                                                    <div>
                                                        <dt class="text-sm font-medium text-gray-500">Duration</dt>
                                                        <dd class="mt-1 text-sm text-gray-900">
                                                            {{ \Cake\Chronos\Chronos::parse($request->start_date)->format('M d, Y') }}
                                                            to
                                                            {{ \Cake\Chronos\Chronos::parse($request->end_date)->format('M d, Y') }}
                                                        </dd>
                                                    </div>
                                                </dl>
                                            </div>

                                            <form method="POST"
                                                action="{{ route('staff.leave.cancel', $request) }}">
                                                @csrf
                                                <div class="flex justify-end gap-3">
                                                    <button type="button"
                                                        @click="$dispatch('close-modal', 'cancel-leave-{{ $request->id }}')"
                                                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                                        No, Keep It
                                                    </button>
                                                    <button type="submit"
                                                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">
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
        </div>
    </div>

    <!-- Create Leave Request Modal -->
    <x-modals.modal name="create-leave" :show="false" maxWidth="md">
        <div class="p-6">
            <div class="mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Create New Leave Request</h2>
                <p class="mt-1 text-sm text-gray-600">Please fill in the details for your leave request</p>
            </div>

            <form method="POST" action="{{ route('staff.leave.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="space-y-6">
                    <!-- Leave Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Leave Type</label>
                        <select id="type" name="type"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
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
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                            <input type="date" id="start_date" name="start_date" min="{{ date('Y-m-d') }}"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('start_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                            <input type="date" id="end_date" name="end_date" min="{{ date('Y-m-d') }}"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('end_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Reason -->
                    <div>
                        <label for="reason" class="block text-sm font-medium text-gray-700">Reason</label>
                        <textarea id="reason" name="reason" rows="4"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Please provide a detailed reason for your leave request"></textarea>
                        @error('reason')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Attachment -->
                    <div>
                        <label for="attachment" class="block text-sm font-medium text-gray-700">
                            Attachment <span class="text-gray-500">(optional)</span>
                        </label>
                        <input type="file" id="attachment" name="attachment"
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="mt-1 text-xs text-gray-500">Upload supporting documents (max 10MB)</p>
                        @error('attachment')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="$dispatch('close-modal', 'create-leave')"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                        Submit Request
                    </button>
                </div>
            </form>
        </div>
    </x-modals.modal>
</x-layouts.staff>
