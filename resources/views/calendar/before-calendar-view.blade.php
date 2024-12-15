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

                <button @click="$dispatch('create-schedule')"
                    class="w-full inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors shadow-sm hover:shadow group md:w-max">
                    <i class='bx bx-plus text-lg transition-transform group-hover:scale-110'></i>
                    <span class="inline">Create New Event</span>
                </button>
            </div>

            {{-- Second Row: View Controls and Search --}}
            <div class="flex flex-col items-center gap-4 md:flex-row">
                {{-- View Switcher --}}
                <div class="bg-gray-100/80 p-1 rounded-xl flex items-center">
                    <button
                        class="px-6 py-2 rounded-lg text-sm font-medium bg-white shadow-sm text-gray-900 transition-all">
                        Month
                    </button>
                    <button
                        class="px-6 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-white/50 transition-all">
                        Week
                    </button>
                    <button
                        class="px-6 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-white/50 transition-all">
                        Day
                    </button>
                </div>

                {{-- Search with Loading States --}}
                <div class="relative flex-1 w-full">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class='bx bx-search text-gray-400'></i>
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="search"
                        placeholder="Search events by title..."
                        class="block w-full pl-10 pr-4 py-2.5 text-sm text-gray-900 bg-gray-100/80 rounded-xl border-0 focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all">
                    @if ($search)
                        <button wire:click="clearSearch" type="button"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                            <i class='bx bx-x'></i>
                        </button>
                    @endif
                </div>
            </div>

            {{-- Stats Bar with Dynamic Counts --}}
            {{-- Stats Bar --}}
            <div class="flex flex-wrap items-center justify-between gap-4 pt-6 border-t">
                {{-- Event Types --}}
                <div class="flex flex-wrap items-center gap-4">
                    {{-- All Events --}}
                    <button wire:click="setFilter('all')"
                        class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors {{ $activeFilter === 'all' ? 'bg-gray-100' : 'hover:bg-gray-50' }}">
                        <span class="flex h-2.5 w-2.5 rounded-full bg-gray-900 ring-4 ring-gray-100"></span>
                        <span class="text-sm font-medium text-gray-900">All Events</span>
                        <span
                            class="inline-flex items-center justify-center px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-900">
                            {{ $totalEvents }}
                        </span>
                    </button>

                    {{-- Upcoming Events --}}
                    <button wire:click="setFilter('upcoming')"
                        class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors {{ $activeFilter === 'upcoming' ? 'bg-blue-50' : 'hover:bg-gray-50' }}">
                        <span class="flex h-2.5 w-2.5 rounded-full bg-blue-500 ring-4 ring-blue-100"></span>
                        <span class="text-sm font-medium text-gray-700">Upcoming</span>
                        <span
                            class="inline-flex items-center justify-center px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">
                            {{ $upcomingEvents }}
                        </span>
                    </button>

                    {{-- Today's Events --}}
                    <button wire:click="setFilter('today')"
                        class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors {{ $activeFilter === 'today' ? 'bg-emerald-50' : 'hover:bg-gray-50' }}">
                        <span class="flex h-2.5 w-2.5 rounded-full bg-emerald-600 ring-4 ring-emerald-100"></span>
                        <span class="text-sm font-medium text-gray-700">Today</span>
                        <span
                            class="inline-flex items-center justify-center px-2 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-700">
                            {{ $todayEvents }}
                        </span>
                    </button>

                    {{-- Completed Events --}}
                    <button wire:click="setFilter('completed')"
                        class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors {{ $activeFilter === 'completed' ? 'bg-gray-100' : 'hover:bg-gray-50' }}">
                        <span class="flex h-2.5 w-2.5 rounded-full bg-gray-500 ring-4 ring-gray-100"></span>
                        <span class="text-sm font-medium text-gray-700">Completed</span>
                        <span
                            class="inline-flex items-center justify-center px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-700">
                            {{ $completedEvents }}
                        </span>
                    </button>
                </div>

                {{-- Optional: Clear Filter Button (shows only when a filter is active) --}}
                @if ($activeFilter !== 'all')
                    <button wire:click="setFilter('all')"
                        class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1">
                        <i class='bx bx-x-circle'></i>
                        Clear Filter
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
