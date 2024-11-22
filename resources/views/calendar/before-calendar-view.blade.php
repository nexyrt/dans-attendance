<div class="bg-white p-4 rounded-t-md  shadow-sm">
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
        <!-- Title and Navigation -->
        <div class="flex items-center gap-4">
            <h2 class="text-2xl font-semibold text-gray-800">Calendar</h2>
            <div class="flex items-center gap-2">
                <button class="p-2 hover:bg-gray-100 rounded-lg" wire:click = "prevMonth">
                    <i class='bx bx-chevron-left text-xl'></i>
                </button>
                <span class="text-lg font-medium">{{ $this->startsAt->format('F Y')  }}</span>
                <button class="p-2 hover:bg-gray-100 rounded-lg" wire:click = "nextMonth">
                    <i class='bx bx-chevron-right text-xl'></i>
                </button>
            </div>
        </div>

        <!-- Controls -->
        <div class="flex items-center gap-3">
            <div class="flex bg-gray-100 rounded-lg p-1">
                <button class="px-3 py-1 rounded-md text-sm font-medium hover:bg-white hover:shadow-sm">Month</button>
                <button class="px-3 py-1 rounded-md text-sm font-medium hover:bg-white hover:shadow-sm">Week</button>
                <button class="px-3 py-1 rounded-md text-sm font-medium hover:bg-white hover:shadow-sm">Day</button>
            </div>
            <button class="px-4 py-2 bg-blue-500 text-white rounded-lg text-sm font-medium hover:bg-blue-600">
                Add Event
            </button>
        </div>
    </div>
</div>