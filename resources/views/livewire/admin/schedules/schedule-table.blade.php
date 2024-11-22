<div class="p-6">
    <!-- Header Section -->
    <div class="bg-white p-5 rounded-md flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-700">Schedule Management</h2>
    </div>

    <!-- Table Section -->
    <div class="mt-4 bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Day of Week
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Start Time
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            End Time
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Late Tolerance
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($schedules as $schedule)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <!-- Day Icon -->
                                    <div
                                        class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-lg 
                                        {{ $schedule->day_of_week === 'monday'
                                            ? 'bg-blue-100 text-blue-600'
                                            : ($schedule->day_of_week === 'tuesday'
                                                ? 'bg-purple-100 text-purple-600'
                                                : ($schedule->day_of_week === 'wednesday'
                                                    ? 'bg-green-100 text-green-600'
                                                    : ($schedule->day_of_week === 'thursday'
                                                        ? 'bg-yellow-100 text-yellow-600'
                                                        : 'bg-red-100 text-red-600'))) }}">
                                        <i class='bx bx-calendar text-xl'></i>
                                    </div>
                                    <!-- Day Name -->
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ ucfirst($schedule->day_of_week) }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <i class='bx bx-time-five text-gray-500 mr-2'></i>
                                    <span
                                        class="text-sm text-gray-900">{{ $schedule->start_time->format('H:i') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <i class='bx bx-time text-gray-500 mr-2'></i>
                                    <span class="text-sm text-gray-900">{{ $schedule->end_time->format('H:i') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $schedule->late_tolerance }} minutes
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">

                                <x-modals.admin-form-modal title='Edit' text='text-blue-400'
                                    wire:click="edit({{ $schedule->id }})"
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <div>
                                        <!-- Modal Header -->
                                        <div class="sm:flex sm:items-start">
                                            <div
                                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                                                <i class='bx bx-time text-indigo-600 text-xl'></i>
                                            </div>
                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-grow">
                                                <h3 class="text-lg font-medium text-gray-900" id="modal-title">
                                                    Edit Schedule
                                                </h3>
                                                <p class="mt-1 text-sm text-gray-500">
                                                    Configure schedule for {{ ucfirst($schedule->day_of_week) }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Modal Content -->
                                        <div class="mt-6 space-y-4">
                                            <!-- Start Time -->
                                            <div>
                                                <label for="start_time"
                                                    class="block text-sm font-medium text-gray-700">Start
                                                    Time</label>
                                                <div class="mt-1 relative rounded-md shadow-sm">
                                                    <div
                                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <i class='bx bx-time-five text-gray-400'></i>
                                                    </div>
                                                    <input type="time" id="start_time" wire:model="start_time"
                                                        class="pl-10 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                </div>
                                                @error('start_time')
                                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- End Time -->
                                            <div>
                                                <label for="end_time"
                                                    class="block text-sm font-medium text-gray-700">End Time</label>
                                                <div class="mt-1 relative rounded-md shadow-sm">
                                                    <div
                                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <i class='bx bx-time text-gray-400'></i>
                                                    </div>
                                                    <input type="time" id="end_time" wire:model="end_time"
                                                        class="pl-10 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                </div>
                                                @error('end_time')
                                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Late Tolerance -->
                                            <div>
                                                <label for="late_tolerance"
                                                    class="block text-sm font-medium text-gray-700">Late Tolerance
                                                    (minutes)</label>
                                                <div class="mt-1 relative rounded-md shadow-sm">
                                                    <div
                                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <i class='bx bx-timer text-gray-400'></i>
                                                    </div>
                                                    <input type="number" id="late_tolerance"
                                                        wire:model="late_tolerance" min="0" max="120"
                                                        class="pl-10 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                        placeholder="Enter minutes">
                                                </div>
                                                @error('late_tolerance')
                                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="mt-6 py-2 sm:flex sm:flex-row-reverse">
                                            <button type="submit" wire:click='save'
                                                class="w-full inline-flex justify-center items-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                <i class='bx bx-save mr-2'></i>
                                                Save Changes
                                            </button>
                                            <button type="button" @click="$dispatch('close-modal')"
                                                class="mt-3 w-full inline-flex justify-center items-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                                                <i class='bx bx-x mr-2'></i>
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </x-modals.admin-form-modal>


                                {{-- <button wire:click="edit({{ $schedule->id }})"
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    
                                    Edit
                                </button> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
