<div class="bg-white border-b">
    <!-- Top Bar -->

    <!-- Main Calendar Controls -->
    <div class="px-6 py-4">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
            <!-- Left Section -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-6">
                <!-- Navigation Controls -->
                <div class="flex items-center space-x-4">
                    <div class="flex items-center bg-gray-50 rounded-lg p-1">
                        <button class="p-2 hover:bg-white hover:shadow-sm rounded-md transition-all"
                                wire:click="prevMonth"
                                wire:loading.class="opacity-50">
                            <i class='bx bx-chevron-left text-xl text-gray-600'></i>
                        </button>
                        <button class="px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-white hover:shadow-sm rounded-md mx-2">
                            Today
                        </button>
                        <button class="p-2 hover:bg-white hover:shadow-sm rounded-md transition-all"
                                wire:click="nextMonth"
                                wire:loading.class="opacity-50">
                            <i class='bx bx-chevron-right text-xl text-gray-600'></i>
                        </button>
                    </div>

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex items-center space-x-2 px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200">
                            <span class="text-lg font-semibold">{{ $this->startsAt->format('F Y') }}</span>
                            <i class='bx bx-chevron-down text-gray-500'></i>
                        </button>
                        <!-- Date picker dropdown would go here -->
                    </div>
                </div>

                <!-- View Options with Indicator -->
                <div class="flex items-center bg-gray-50 rounded-lg p-1 relative">
                    <div class="absolute inset-y-1 left-1 w-16 bg-white rounded-md shadow-sm transition-all duration-200"
                         style="transform: translateX(calc(100% * var(--active-tab, 0)))"></div>
                    <button class="relative px-4 py-1.5 text-sm font-medium text-gray-900 rounded-md transition-colors z-10"
                            onclick="document.documentElement.style.setProperty('--active-tab', '0')">
                        Month
                    </button>
                    <button class="relative px-4 py-1.5 text-sm font-medium text-gray-600 hover:text-gray-900 rounded-md transition-colors z-10"
                            onclick="document.documentElement.style.setProperty('--active-tab', '1')">
                        Week
                    </button>
                    <button class="relative px-4 py-1.5 text-sm font-medium text-gray-600 hover:text-gray-900 rounded-md transition-colors z-10"
                            onclick="document.documentElement.style.setProperty('--active-tab', '2')">
                        Day
                    </button>
                </div>
            </div>

            <!-- Right Section -->
            <div class="flex items-center space-x-4 w-full sm:w-auto">
                <!-- Search -->
                <div class="relative flex-grow sm:flex-grow-0">
                    <input type="text" 
                           placeholder="Search events..." 
                           class="w-full pl-10 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400'></i>
                </div>

                <!-- Actions -->
                <div class="flex items-center space-x-3">
                    <button class="inline-flex items-center space-x-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors shadow-sm">
                        <i class='bx bx-plus'></i>
                        <span>Add Event</span>
                    </button>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-50 rounded-lg">
                            <i class='bx bx-dots-vertical-rounded text-xl'></i>
                        </button>
                        <!-- Dropdown menu would go here -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats Bar -->
        <div class="flex flex-wrap items-center gap-6 mt-4 pt-4 border-t">
            <div class="flex items-center space-x-6">
                <span class="flex items-center space-x-2">
                    <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                    <span class="text-sm text-gray-600">Events (12)</span>
                </span>
                <span class="flex items-center space-x-2">
                    <span class="w-3 h-3 rounded-full bg-green-500"></span>
                    <span class="text-sm text-gray-600">Completed (8)</span>
                </span>
                <span class="flex items-center space-x-2">
                    <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                    <span class="text-sm text-gray-600">Pending (4)</span>
                </span>
            </div>

            <div class="flex-grow"></div>

            <!-- View Options -->
            <div class="flex items-center space-x-3 text-sm text-gray-600">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" class="rounded text-blue-600 focus:ring-blue-500">
                    <span>Show weekends</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" class="rounded text-blue-600 focus:ring-blue-500">
                    <span>Show completed</span>
                </label>
            </div>
        </div>
    </div>
</div>

<style>
    /* Add this to your CSS */
    @property --active-tab {
        syntax: '<number>';
        initial-value: 0;
        inherits: false;
    }
</style>