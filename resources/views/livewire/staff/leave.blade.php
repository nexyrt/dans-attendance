<!-- resources/views/livewire/staff/leave.blade.php -->
<div class="max-w-7xl mx-auto" 
    x-data="{ 
        activeTab: 'apply',
        setActiveTab(tab) {
            this.activeTab = tab;
            @this.set('activeTab', tab);
        }
    }"
>
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Tab Navigation -->
    <div class="border-b border-gray-200 mb-6">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
            <li class="mr-2">
                <button 
                    @click="setActiveTab('apply')" 
                    :class="{'border-b-2 border-blue-600 text-blue-600': activeTab === 'apply', 'border-transparent hover:border-gray-300 hover:text-gray-600': activeTab !== 'apply'}"
                    class="inline-block p-4 rounded-t-lg"
                >
                    Apply for Leave
                </button>
            </li>
            <li class="mr-2">
                <button 
                    @click="setActiveTab('history')" 
                    :class="{'border-b-2 border-blue-600 text-blue-600': activeTab === 'history', 'border-transparent hover:border-gray-300 hover:text-gray-600': activeTab !== 'history'}"
                    class="inline-block p-4 rounded-t-lg"
                >
                    Leave History
                </button>
            </li>
            <li>
                <button 
                    @click="setActiveTab('balance')" 
                    :class="{'border-b-2 border-blue-600 text-blue-600': activeTab === 'balance', 'border-transparent hover:border-gray-300 hover:text-gray-600': activeTab !== 'balance'}"
                    class="inline-block p-4 rounded-t-lg"
                >
                    Leave Balance
                </button>
            </li>
        </ul>
    </div>

    <!-- Apply for Leave Tab -->
    <div x-show="activeTab === 'apply'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Apply for Leave</h2>
            <form wire:submit="submit">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Leave Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Leave Type</label>
                        <select id="type" wire:model="type" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="annual">Annual Leave</option>
                            <option value="sick">Sick Leave</option>
                            <option value="important">Important Leave</option>
                            <option value="other">Other</option>
                        </select>
                        @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Start Date -->
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <input type="date" id="start_date" wire:model.live="start_date" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- End Date -->
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <input type="date" id="end_date" wire:model.live="end_date" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Calculated Days -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Total Days</label>
                        <div class="bg-gray-100 p-2 rounded-md">
                            <span class="font-medium">{{ $calculatedDays }} {{ Str::plural('day', $calculatedDays) }}</span>
                        </div>
                    </div>

                    <!-- Reason -->
                    <div class="md:col-span-2">
                        <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Reason</label>
                        <textarea id="reason" wire:model="reason" rows="3" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" placeholder="Please provide a detailed reason for your leave request"></textarea>
                        @error('reason') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Attachment -->
                    <div>
                        <label for="attachment" class="block text-sm font-medium text-gray-700 mb-1">Attachment (Optional)</label>
                        <input type="file" id="attachment" wire:model="attachment" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="mt-1 text-xs text-gray-500">Upload supporting documents (PDF, DOC, DOCX, JPG, PNG)</p>
                        @error('attachment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Signature -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Signature</label>
                        @if($signature)
                            <div class="mb-2">
                                <img src="{{ $signature }}" alt="Your signature" class="border h-20 bg-white">
                            </div>
                        @endif
                        <button 
                            type="button" 
                            @click="$dispatch('open-modal', 'signature-modal')" 
                            class="mt-1 px-4 py-2 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        >
                            {{ $signature ? 'Change Signature' : 'Add Signature' }}
                        </button>
                        @error('signature') <span class="text-red-500 text-sm block mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Submit Leave Request
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Leave History Tab -->
    <div x-show="activeTab === 'history'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Leave History</h2>
        
        @if(count($leaveRequests) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Days</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($leaveRequests as $request)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="capitalize">{{ $request->type }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($request->start_date)->format('M d, Y') }}
                                    @if($request->start_date != $request->end_date)
                                        - {{ \Carbon\Carbon::parse($request->end_date)->format('M d, Y') }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($request->start_date)->diffInDays(\Carbon\Carbon::parse($request->end_date)) + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClasses = [
                                            'pending_manager' => 'bg-yellow-100 text-yellow-800',
                                            'pending_hr' => 'bg-blue-100 text-blue-800',
                                            'pending_director' => 'bg-purple-100 text-purple-800',
                                            'approved' => 'bg-green-100 text-green-800',
                                            'rejected_manager' => 'bg-red-100 text-red-800',
                                            'rejected_hr' => 'bg-red-100 text-red-800',
                                            'rejected_director' => 'bg-red-100 text-red-800',
                                            'cancel' => 'bg-gray-100 text-gray-800',
                                        ];
                                        $statusText = [
                                            'pending_manager' => 'Pending Manager',
                                            'pending_hr' => 'Pending HR',
                                            'pending_director' => 'Pending Director',
                                            'approved' => 'Approved',
                                            'rejected_manager' => 'Rejected by Manager',
                                            'rejected_hr' => 'Rejected by HR',
                                            'rejected_director' => 'Rejected by Director',
                                            'cancel' => 'Cancelled',
                                        ];
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses[$request->status] }}">
                                        {{ $statusText[$request->status] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @if(in_array($request->status, ['pending_manager', 'pending_hr', 'pending_director']))
                                        <button 
                                            wire:click="cancelLeaveRequest({{ $request->id }})" 
                                            class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('Are you sure you want to cancel this leave request?')"
                                        >
                                            Cancel
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-gray-50 p-4 rounded-md text-center">
                <p class="text-gray-500">No leave requests found</p>
            </div>
        @endif
    </div>

    <!-- Leave Balance Tab -->
    <div x-show="activeTab === 'balance'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Leave Balance</h2>
        
        @if($leaveBalance)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-blue-50 p-6 rounded-lg">
                    <p class="text-sm text-blue-600 font-medium">Total Annual Leave</p>
                    <p class="text-3xl font-bold mt-2">{{ $leaveBalance->total_balance }}</p>
                    <p class="text-sm text-gray-500 mt-1">days for {{ $leaveBalance->year }}</p>
                </div>
                
                <div class="bg-yellow-50 p-6 rounded-lg">
                    <p class="text-sm text-yellow-600 font-medium">Used</p>
                    <p class="text-3xl font-bold mt-2">{{ $leaveBalance->used_balance }}</p>
                    <p class="text-sm text-gray-500 mt-1">days</p>
                </div>
                
                <div class="bg-green-50 p-6 rounded-lg">
                    <p class="text-sm text-green-600 font-medium">Remaining</p>
                    <p class="text-3xl font-bold mt-2">{{ $leaveBalance->remaining_balance }}</p>
                    <p class="text-sm text-gray-500 mt-1">days available</p>
                </div>
            </div>
            
            <div class="mt-6">
                <h3 class="font-semibold mb-2">Upcoming Leaves</h3>
                @php
                    $upcomingLeaves = $leaveRequests->where('status', 'approved')
                        ->where('end_date', '>=', now())
                        ->sortBy('start_date')
                        ->take(3);
                @endphp
                
                @if(count($upcomingLeaves) > 0)
                    <ul class="space-y-2">
                        @foreach($upcomingLeaves as $leave)
                            <li class="border-l-4 border-blue-500 pl-4 py-2">
                                <div class="text-sm font-medium">{{ \Carbon\Carbon::parse($leave->start_date)->format('M d') }} - {{ \Carbon\Carbon::parse($leave->end_date)->format('M d, Y') }}</div>
                                <div class="text-gray-500 text-sm">{{ \Carbon\Carbon::parse($leave->start_date)->diffInDays(\Carbon\Carbon::parse($leave->end_date)) + 1 }} days · {{ ucfirst($leave->type) }}</div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 text-sm">No upcoming approved leaves</p>
                @endif
            </div>
        @else
            <div class="bg-yellow-50 p-6 rounded-md">
                <p class="text-yellow-700">Leave balance information is not available. Please contact HR.</p>
            </div>
        @endif
    </div>

    <!-- Signature Modal (Using your exact implementation) -->
    <x-modals.modal name="signature-modal" maxWidth="md">
        <div x-data="signaturePad()">
            <h1 class="text-xl font-semibold text-gray-700 flex items-center justify-between">
                <div>
                    <canvas x-ref="signature_canvas" class="border rounded shadow">
                    </canvas>
                </div>
            </h1>
            <button x-on:click="upload" class="text-black bg-blue-500 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M10 1a9 9 0 100 18 9 9 0 000-18zm1 14.414V11h3.586l-4.293-4.293L8.414 7.586l4.293 4.293H11v4.414z"/>
                </svg>
                Submit
            </button>
        </div>
    </x-modals.modal>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('signaturePad', () => ({
                signaturePadInstance: null,
                init() {
                    this.signaturePadInstance = new SignaturePad(this.$refs.signature_canvas);
                    
                    // Add listener for modal open to initialize pad if needed
                    document.addEventListener('open-modal', (event) => {
                        if (event.detail === 'signature-modal') {
                            setTimeout(() => {
                                if (this.signaturePadInstance) {
                                    this.signaturePadInstance.clear();
                                } else {
                                    this.signaturePadInstance = new SignaturePad(this.$refs.signature_canvas);
                                }
                            }, 100);
                        }
                    });
                },
                upload(){
                    @this.set('signature', this.signaturePadInstance.toDataURL('image/png'));
                    
                    // Close the modal after setting the signature
                    const closeEvent = new CustomEvent('close-modal', {
                        detail: 'signature-modal'
                    });
                    window.dispatchEvent(closeEvent);
                }
            }))
        })
    </script>
</div>