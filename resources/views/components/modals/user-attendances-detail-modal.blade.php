<!-- Detail Modal -->
<div x-data="{ open: @entangle('showDetailModal') }" 
     x-show="open" 
     class="fixed inset-0 z-50 overflow-y-auto" 
     style="display: none;">
    
    <!-- Backdrop - No transition -->
    <div x-show="open"
         class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm" 
         x-on:click="open = false"></div>

    <!-- Content with transition -->
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-90"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-90"
                 class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-lg w-full p-6">
                
                <!-- Close Button -->
                <div class="absolute top-4 right-4">
                    <button x-on:click="open = false" 
                            class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Content -->
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    {{ ucfirst($detailType) }} Attendance Details
                </h3>

                <div class="space-y-4">
                    @foreach ($detailData as $record)
                        <div class="flex items-center gap-4 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <img class="h-10 w-10 rounded-full object-cover" 
                                 src="{{ asset($record->user->image) }}"
                                 alt="">
                            <div>
                                <div class="font-medium text-gray-900 dark:text-white">
                                    {{ $record->user->name }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ Carbon\Carbon::parse($record->check_in)->format('h:i A') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>