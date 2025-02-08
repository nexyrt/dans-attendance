<div>
    <div x-data="{ showModal: @entangle('showModal') }" x-cloak x-show="showModal"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50" @click="showModal = false">

        <div class="flex items-center justify-center min-h-screen p-4">
            <form wire:submit.prevent="save"
                class="w-full max-w-md mx-auto text-left transition-all transform bg-white shadow-lg rounded-lg"
                @click.stop>

                <!-- Modal Header -->
                <div class="flex items-center justify-between px-6 py-4 border-b">
                    <h3 class="text-xl font-medium text-gray-900">
                        {{ $isEditing ? 'Edit Event' : 'Create Event' }}
                    </h3>
                    <button @click="showModal = false" type="button" class="p-2 hover:bg-gray-100 rounded-full">
                        <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-4 text-sm">
                    <!-- Title Section -->
                    <div class="flex items-center space-x-4 py-3">
                        <div class="text-lg text-gray-400 w-5">T</div>
                        <input type="text" wire:model="title"
                            class="flex-1 border-0 p-2 text-sm rounded focus:ring-0 focus:border-0 placeholder-gray-400 focus:bg-gray-100 transition-colors"
                            placeholder="Add title">
                    </div>

                    <!-- Time Section -->
                    <div class="flex items-start justify-start space-x-4 py-3 border-t">
                        <div class="pt-1.5 w-5">
                            <i class='bx bx-time text-lg text-gray-400'></i>
                        </div>
                        <div class="flex-1 space-y-2">
                            <div class="flex items-center space-x-2" x-data="{
                                times: Array.from({ length: 96 }, (_, i) => {
                                    const hour = Math.floor(i / 4);
                                    const minute = (i % 4) * 15;
                                    const value = `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
                                    const displayHour = hour === 0 ? 12 : hour > 12 ? hour - 12 : hour;
                                    const ampm = hour < 12 ? 'AM' : 'PM';
                                    return {
                                        value,
                                        display: `${displayHour}:${minute.toString().padStart(2, '0')} ${ampm}`
                                    };
                                }),
                                startOpen: false,
                                endOpen: false,
                                wireStartTime: @entangle('start_time'),
                                wireEndTime: @entangle('end_time'),
                                getDisplayTime(value) {
                                    return this.times.find(t => t.value === value)?.display || '9:00 AM';
                                }
                            }">
                                <!-- Start Time Dropdown -->
                                <div class="relative flex-1">
                                    <button @click="startOpen = !startOpen; endOpen = false" type="button"
                                        class="w-full flex items-center px-3 py-2.5 text-xs border-gray-300 rounded hover:bg-gray-50 focus:border-blue-500 focus:ring-0">
                                        <span x-text="getDisplayTime(wireStartTime)"></span>
                                        <i class='bx bx-chevron-down text-gray-400 ml-auto'></i>
                                    </button>

                                    <div x-show="startOpen" @click.away="startOpen = false"
                                        class="absolute z-50 mt-1 w-full bg-white rounded-md shadow-lg border border-gray-200">
                                        <div class="max-h-60 overflow-y-auto">
                                            <div class="py-1">
                                                <template x-for="time in times" :key="time.value">
                                                    <button type="button"
                                                        @click="wireStartTime = time.value; startOpen = false"
                                                        class="w-full px-3 py-1.5 text-xs text-left hover:bg-gray-100 flex items-center space-x-2"
                                                        :class="{ 'bg-blue-50': wireStartTime === time.value }">
                                                        <span x-text="time.display"></span>
                                                        <i class='bx bx-check text-blue-500 ml-auto'
                                                            x-show="wireStartTime === time.value"></i>
                                                    </button>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <span class="text-gray-400 text-xs">–</span>

                                <!-- End Time Dropdown -->
                                <div class="relative flex-1">
                                    <button @click="endOpen = !endOpen; startOpen = false" type="button"
                                        class="w-full flex items-center px-3 py-2.5 text-xs border-gray-300 rounded hover:bg-gray-50 focus:border-blue-500 focus:ring-0">
                                        <span x-text="getDisplayTime(wireEndTime)"></span>
                                        <i class='bx bx-chevron-down text-gray-400 ml-auto'></i>
                                    </button>

                                    <div x-show="endOpen" @click.away="endOpen = false"
                                        class="absolute z-50 mt-1 w-full bg-white rounded-md shadow-lg border border-gray-200">
                                        <div class="max-h-60 overflow-y-auto">
                                            <div class="py-1">
                                                <template x-for="time in times" :key="time.value">
                                                    <button type="button"
                                                        @click="wireEndTime = time.value; endOpen = false"
                                                        class="w-full px-3 py-1.5 text-xs text-left hover:bg-gray-100 flex items-center space-x-2"
                                                        :class="{ 'bg-blue-50': wireEndTime === time.value }">
                                                        <span x-text="time.display"></span>
                                                        <i class='bx bx-check text-blue-500 ml-auto'
                                                            x-show="wireEndTime === time.value"></i>
                                                    </button>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Date Section -->
                    <div class="flex items-start justify-start space-x-4 py-3">
                        <div class="pt-1.5 w-5">
                            <i class='bx bx-calendar text-lg text-gray-400'></i>
                        </div>
                        <input type="date" wire:model="selectedDate"
                            class="w-full border-0 px-3 py-2.5 text-xs rounded hover:bg-gray-50 focus:bg-gray-50 focus:ring-0 cursor-pointer">
                    </div>

                    <!-- Department Section -->
                    <!-- Department Section -->
                    <div class="flex items-start justify-start space-x-4 py-3 border-t" x-data="{
                            open: false,
                            search: '',
                            selectedDepartments: @entangle('selectedDepartments'),
                            selectedDepartmentNames: @entangle('selectedDepartmentNames'),
                            filteredDepartments() {
                                return this.departments.filter(dept => 
                                    dept.name.toLowerCase().includes(this.search.toLowerCase())
                                );
                            }
                        }" @click.away="open = false">
                        <div class="pt-1.5 w-5">
                            <i class='bx bx-building text-lg text-gray-400'></i>
                        </div>
                        <div class="flex-1">
                            <!-- Selected Departments Tags -->
                            <div class="relative">
                                <div class="min-h-[42px] w-full px-3 py-2 bg-white border border-gray-200 rounded-lg cursor-pointer flex items-center flex-wrap gap-2"
                                    @click="open = !open">
                                    <template x-if="selectedDepartmentNames.length === 0">
                                        <span class="text-sm text-gray-400">Select departments...</span>
                                    </template>
                                    <template x-for="(name, index) in selectedDepartmentNames" :key="index">
                                        <span
                                            class="inline-flex items-center px-2 py-1 bg-blue-50 text-blue-600 rounded-md text-sm">
                                            <span x-text="name"></span>
                                            <button type="button" @click.stop="
                            $wire.removeDepartment(name);
                            selectedDepartmentNames = selectedDepartmentNames.filter(n => n !== name);"
                                                class="ml-1 hover:text-blue-800">
                                                <i class='bx bx-x'></i>
                                            </button>
                                        </span>
                                    </template>
                                    <i class='bx bx-chevron-down ml-auto text-gray-400'
                                        :class="{ 'transform rotate-180': open }"></i>
                                </div>

                                <!-- Dropdown Menu -->
                                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 transform scale-95"
                                    x-transition:enter-end="opacity-100 transform scale-100"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 transform scale-100"
                                    x-transition:leave-end="opacity-0 transform scale-95"
                                    class="absolute z-50 w-full mt-2 bg-white rounded-lg shadow-lg border border-gray-200">

                                    <!-- Search Box -->
                                    <div class="p-2 border-b">
                                        <div class="relative">
                                            <i
                                                class='bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
                                            <input type="text" x-model="search"
                                                class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-md focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                                placeholder="Search departments...">
                                        </div>
                                    </div>

                                    <!-- Options List -->
                                    <div class="max-h-60 overflow-y-auto p-2">
                                        @foreach($departments as $dept)
                                        <div class="flex items-center px-3 py-2 text-sm hover:bg-gray-50 rounded-md cursor-pointer"
                                            wire:key="dept-{{ $dept->id }}" @click.stop="
                                if (selectedDepartments.includes('{{ $dept->id }}')) {
                                    $wire.removeDepartment('{{ $dept->name }}');
                                } else {
                                    selectedDepartments.push('{{ $dept->id }}');
                                    selectedDepartmentNames.push('{{ $dept->name }}');
                                }">
                                            <div class="flex items-center flex-1">
                                                <div class="w-4 h-4 border-2 rounded mr-2 flex items-center justify-center"
                                                    :class="{
                                         'border-blue-500 bg-blue-500': selectedDepartments.includes('{{ $dept->id }}'),
                                         'border-gray-300': !selectedDepartments.includes('{{ $dept->id }}')
                                     }">
                                                    <i class='bx bx-check text-white text-sm'
                                                        x-show="selectedDepartments.includes('{{ $dept->id }}')"></i>
                                                </div>
                                                <span>{{ $dept->name }}</span>
                                            </div>
                                            <span class="text-xs text-gray-400">{{ $dept->code }}</span>
                                        </div>
                                        @endforeach
                                    </div>

                                    <!-- Empty State -->
                                    <div x-show="search && !filteredDepartments.length"
                                        class="p-4 text-center text-sm text-gray-500">
                                        No departments found
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="flex items-start justify-start space-x-4 py-3 border-t">
                        <div class="pt-1.5 w-5">
                            <i class='bx bx-building text-lg text-gray-400'></i>
                        </div>
                        <select wire:model="status"
                            class="text-xs mt-2 flex-1 border-0 p-2 rounded focus:ring-0 focus:border-0 placeholder-gray-400 hover:bg-gray-100 focus:bg-gray-100 transition-colors">
                            <option value="regular">Regular</option>
                            <option value="wfh">WFH</option>
                            <option value="halfday">Halfday</option>
                        </select>
                    </div>

                    <!-- Description Section -->
                    <div class="flex items-start justify-start space-x-4 py-3 border-t">
                        <div class="pt-1.5 w-5">
                            <i class='bx bx-align-left text-lg text-gray-400'></i>
                        </div>
                        <textarea wire:model="description"
                            class="flex-1 border-0 p-1.5 text-sm rounded focus:ring-0 focus:border-0 placeholder-gray-400 focus:bg-gray-100 transition-colors"
                            rows="3" placeholder="Add description"></textarea>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-3 bg-gray-50 rounded-b-lg flex justify-end space-x-2">
                    <button type="button" @click="showModal = false"
                        class="px-4 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-1.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded shadow-sm">
                        {{ $isEditing ? 'Update' : 'Create' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>