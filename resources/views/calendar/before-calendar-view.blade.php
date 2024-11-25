<div class="bg-white rounded-t-md">
    <div class="px-4 lg:px-6 py-6">
        {{-- Main Container --}}
        <div class="space-y-8">
            {{-- Top Row: Date Navigation and Add Event --}}
            <div class="flex flex-col items-center justify-between md:flex-row gap-2">
                {{-- Month Navigation - Date between arrows --}}
                <div class="flex items-center space-x-3">
                    <button class="p-2 hover:bg-gray-100 rounded-full transition-colors" wire:click="prevMonth">
                        <i class='bx bx-chevron-left text-xl text-gray-600'></i>
                    </button>
                    
                    <h2 class="text-2xl font-bold text-gray-900">
                        {{ $this->startsAt->format('F Y') }}
                    </h2>
                    
                    <button class="p-2 hover:bg-gray-100 rounded-full transition-colors" wire:click="nextMonth">
                        <i class='bx bx-chevron-right text-xl text-gray-600'></i>
                    </button>
                </div>

                {{-- Add Event Button --}}
                <button class="w-full inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors shadow-sm hover:shadow group md:w-max">
                    <i class='bx bx-plus text-lg transition-transform group-hover:scale-110'></i>
                    <span class="inline">Create New Event</span>
                </button>
            </div>

            {{-- Second Row: View Controls and Search --}}
            <div class="flex flex-col items-center gap-4 md:flex-row">
                {{-- View Switcher --}}
                <div class="bg-gray-100/80 p-1 rounded-xl flex items-center">
                    <button class="px-6 py-2 rounded-lg text-sm font-medium bg-white shadow-sm text-gray-900 transition-all">
                        Month
                    </button>
                    <button class="px-6 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-white/50 transition-all">
                        Week
                    </button>
                    <button class="px-6 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-white/50 transition-all">
                        Day
                    </button>
                </div>

                {{-- Search --}}
                <div class="relative flex-1 w-full">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class='bx bx-search text-gray-400'></i>
                    </div>
                    <input type="text" 
                        placeholder="Search events..." 
                        class="block w-full pl-10 pr-4 py-2.5 text-sm text-gray-900 bg-gray-100/80 rounded-xl border-0 focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all"
                    >
                </div>
            </div>

            {{-- Stats Bar --}}
            <div class="flex flex-wrap items-center gap-x-8 gap-y-4 pt-6 border-t">
                {{-- Event Types --}}
                <div class="flex flex-wrap items-center gap-6">
                    <div class="flex items-center gap-2.5">
                        <span class="flex h-2.5 w-2.5 rounded-full bg-blue-600 ring-4 ring-blue-100"></span>
                        <span class="text-sm font-medium text-gray-700">12 Events</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <span class="flex h-2.5 w-2.5 rounded-full bg-green-600 ring-4 ring-green-100"></span>
                        <span class="text-sm font-medium text-gray-700">8 Completed</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <span class="flex h-2.5 w-2.5 rounded-full bg-amber-600 ring-4 ring-amber-100"></span>
                        <span class="text-sm font-medium text-gray-700">4 Pending</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>