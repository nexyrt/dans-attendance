<x-layouts.staff>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800">Leave Management</h2>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Leave Requests Table -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Leave History</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($leaveRequests as $request)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="capitalize">{{ $request->type }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ \Cake\Chronos\Chronos::parse($request->start_date)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ \Cake\Chronos\Chronos::parse($request->end_date)->format('M d, Y') }}
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
                                        <p class="text-sm text-gray-900 truncate max-w-xs">{{ $request->reason }}</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($request->status === 'pending')
                                            <form method="POST" action="{{ route('staff.leave.cancel', $request) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-sm text-red-600 hover:text-red-900">
                                                    Cancel Request
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        No leave requests found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($leaveRequests->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $leaveRequests->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.staff>