<!-- Enhanced Edit Modal -->
<div x-data="{ show: @entangle('editModal'), activeTab: 'personal' }" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="flex min-h-screen items-center justify-center p-4">
        <!-- Background overlay with blur -->
        <div class="fixed inset-0 bg-gray-500/75 backdrop-blur-sm transition-opacity"></div>

        <!-- Modal panel -->
        <div class="relative w-full max-w-3xl transform overflow-hidden rounded-xl bg-white shadow-2xl transition-all">
            <!-- Modal Header with Tabs -->
            <div class="border-b border-gray-100">
                <div class="flex items-center justify-between px-4 py-3">
                    <h3 class="text-lg font-semibold text-gray-900">Edit Employee</h3>
                    <button @click="editModal = false"
                        class="rounded-lg p-1 text-gray-400 hover:bg-gray-50 hover:text-gray-500">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Enhanced Tabs -->
                <div class="flex px-4">
                    <button @click="activeTab = 'personal'"
                        :class="{
                            'text-blue-600 border-b-2 border-blue-600': activeTab === 'personal',
                            'text-gray-500 hover:text-gray-700': activeTab !== 'personal'
                        }"
                        class="px-4 py-2 text-sm font-medium transition-colors">
                        Personal Info
                    </button>
                    <button @click="activeTab = 'employment'"
                        :class="{
                            'text-blue-600 border-b-2 border-blue-600': activeTab === 'employment',
                            'text-gray-500 hover:text-gray-700': activeTab !== 'employment'
                        }"
                        class="px-4 py-2 text-sm font-medium transition-colors">
                        Employment
                    </button>
                    <button @click="activeTab = 'other'"
                        :class="{
                            'text-blue-600 border-b-2 border-blue-600': activeTab === 'other',
                            'text-gray-500 hover:text-gray-700': activeTab !== 'other'
                        }"
                        class="px-4 py-2 text-sm font-medium transition-colors">
                        Other Details
                    </button>
                </div>
            </div>

            <!-- Form Content -->
            <form wire:submit.prevent="save" class="px-4 py-4">
                <!-- Personal Info Tab -->
                <div x-show="activeTab === 'personal'" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-medium text-gray-600">Full Name</label>
                            <input type="text" wire:model="name" value="{{ old('name', $user->name) }}"
                                class="mt-1 block w-full rounded-md border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-600">Email Address</label>
                            <input type="email" wire:model="email" value="{{ old('email', $user->email) }}"
                                class="mt-1 block w-full rounded-md border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-600">Phone Number</label>
                            <input type="tel" wire:model="phone_number"
                                value="{{ old('phone_number', $user->phone_number) }}"
                                class="mt-1 block w-full rounded-md border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-600">Birth Date</label>
                            <input type="date" wire:model="birthdate"
                                value="{{ old('birthdate', optional($user->birthdate)->format('Y-m-d')) }}"
                                class="mt-1 block w-full rounded-md border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Employment Tab -->
                <div x-show="activeTab === 'employment'" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Enhanced Select Dropdown -->
                        <div>
                            <label class="text-xs font-medium text-gray-600">Department</label>
                            <div class="relative mt-1">
                                <select wire:model="department_id"
                                    class="block w-full appearance-none rounded-md border-gray-200 bg-white pl-3 pr-10 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                    <option value="">Select Department</option>
                                    @foreach ($departments as $dept)
                                        <option value="{{ $dept->id }}"
                                            {{ old('department_id', $user->department_id) == $dept->id ? 'selected' : '' }}>
                                            {{ $dept->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="text-xs font-medium text-gray-600">Position</label>
                            <div class="relative mt-1">
                                <select wire:model="position"
                                    class="block w-full appearance-none rounded-md border-gray-200 bg-white pl-3 pr-10 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                    <option value="">Select Position</option>
                                    <option value="Direktur"
                                        {{ old('position', $user->position) === 'Direktur' ? 'selected' : '' }}>
                                        Director</option>
                                    <option value="Manager"
                                        {{ old('position', $user->position) === 'Manager' ? 'selected' : '' }}>
                                        Manager</option>
                                    <option value="Staff"
                                        {{ old('position', $user->position) === 'Staff' ? 'selected' : '' }}>
                                        Staff</option>
                                    <option value="Supervisi"
                                        {{ old('position', $user->position) === 'Supervisi' ? 'selected' : '' }}>
                                        Supervisor</option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="text-xs font-medium text-gray-600">Role</label>
                            <div class="relative mt-1">
                                <select wire:model="role"
                                    class="block w-full appearance-none rounded-md border-gray-200 bg-white pl-3 pr-10 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                    <option value="admin"
                                        {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin
                                    </option>
                                    <option value="manajer"
                                        {{ old('role', $user->role) === 'manajer' ? 'selected' : '' }}>Manager
                                    </option>
                                    <option value="staff"
                                        {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>Staff
                                    </option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="text-xs font-medium text-gray-600">Salary</label>
                            <div class="relative mt-1">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" wire:model="salary" value="{{ old('salary', $user->salary) }}"
                                    class="block w-full rounded-md border-gray-200 pl-10 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Other Details Tab -->
                <div x-show="activeTab === 'other'" class="space-y-4">
                    <div>
                        <label class="text-xs font-medium text-gray-600">Address</label>
                        <textarea wire:model="address" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                            placeholder="Enter complete address">{{ old('address', $user->address) }}</textarea>
                    </div>

                    <!-- Compact Image Upload -->
                    <div>
                        <label class="text-xs font-medium text-gray-600">Profile Image</label>
                        <div class="mt-1 flex items-center space-x-4">
                            @if ($user->image)
                                <div class="flex-shrink-0">
                                    <img src="{{ asset($user->image) }}" alt="Current profile photo"
                                        class="h-16 w-16 rounded-full object-cover">
                                </div>
                            @endif
                            <div class="flex-1">
                                <div
                                    class="flex justify-center rounded-md border-2 border-dashed border-gray-300 px-6 py-4">
                                    <div class="text-center">
                                        <svg class="mx-auto h-8 w-8 text-gray-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <div class="mt-2 flex text-xs text-gray-600">
                                            <label class="relative cursor-pointer text-blue-600 hover:text-blue-500">
                                                <span>Change photo</span>
                                                <input wire:model="image" type="file" class="sr-only"
                                                    accept="image/*">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="mt-6 flex justify-end space-x-2 border-t border-gray-100 pt-4">
                    <button type="button" @click="editModal = false"
                        class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit"
                        class="inline-flex items-center rounded-md border border-transparent bg-blue-600 px-3 py-2 text-xs font-medium text-white shadow-sm hover:bg-blue-700">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
