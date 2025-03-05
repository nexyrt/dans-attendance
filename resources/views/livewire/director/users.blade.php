<!-- resources/views/livewire/director/users.blade.php -->
<div class="max-w-6xl mx-auto py-6">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <!-- Header with filters and actions -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <h2 class="text-xl font-semibold text-gray-800"></h2>

                <button type="button" x-data="{}" {{-- x-on:click="$dispatch('open-modal', 'create-user-modal')" --}} wire:click='create'
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Add New User</span>
                    </div>
                </button>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input wire:model.live="search" type="text" id="search"
                        placeholder="Search by name, email, phone..."
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Department Filter -->
                <div>
                    <label for="department_filter"
                        class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                    <x-input.select wire:model.live="department" id="department_filter" :options="$departments->pluck('name')"
                        placeholder="All Departments" />
                </div>

                <!-- Role Filter -->
                <div>
                    <label for="role_filter" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <x-input.select wire:model.live="role" id="role_filter" :options="$roles" placeholder="All Roles" />
                </div>

                <!-- Per Page -->
                <div>
                    <label for="perPage" class="block text-sm font-medium text-gray-700 mb-1">Show</label>
                    <select wire:model="perPage" id="perPage"
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="10">10 per page</option>
                        <option value="25">25 per page</option>
                        <option value="50">50 per page</option>
                        <option value="100">100 per page</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="bg-green-50 border-l-4 border-green-400 p-4 m-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('message') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Users Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('name')">
                            <div class="flex items-center">
                                Name
                                @if ($sortField === 'name')
                                    <span class="ml-1">
                                        @if ($sortDirection === 'asc')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 15l7-7 7 7"></path>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        @endif
                                    </span>
                                @endif
                            </div>
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Department</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('role')">
                            <div class="flex items-center">
                                Role
                                @if ($sortField === 'role')
                                    <span class="ml-1">
                                        @if ($sortDirection === 'asc')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 15l7-7 7 7"></path>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        @endif
                                    </span>
                                @endif
                            </div>
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Contact Info</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Salary</th>
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if ($user->image)
                                        <img class="h-10 w-10 rounded-full mr-3"
                                            src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}">
                                    @else
                                        <div
                                            class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                            <span
                                                class="text-blue-800 font-medium text-lg">{{ substr($user->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $user->department->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if ($user->role == 'director') bg-purple-100 text-purple-800
                                    @elseif($user->role == 'admin') bg-red-100 text-red-800
                                    @elseif($user->role == 'manager') bg-blue-100 text-blue-800
                                    @else bg-green-100 text-green-800 @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $user->phone_number ?? 'N/A' }}</div>
                                @if ($user->birthdate)
                                    <div class="text-sm text-gray-500">Born:
                                        {{ \Cake\Chronos\Chronos::parse($user->birthdate)->format('M d, Y') }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($user->salary)
                                    <div class="text-sm text-gray-900">${{ number_format($user->salary, 2) }}</div>
                                @else
                                    <div class="text-sm text-gray-500">Not set</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                <div class="flex justify-center space-x-2">
                                    <!-- View button for table action -->
                                    <button type="button" wire:click="viewUser({{ $user->id }})"
                                        class="text-blue-600 hover:text-blue-900" title="View Details">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>

                                    <!-- Edit button for table action -->
                                    <button type="button" wire:click="edit({{ $user->id }})"
                                        x-on:click="$dispatch('open-modal', 'edit-user-modal')"
                                        class="text-indigo-600 hover:text-indigo-900" title="Edit User">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>

                                    <!-- Reset Password button for table action -->
                                    <button type="button" wire:click="confirmPasswordReset({{ $user->id }})"
                                        x-on:click="$dispatch('open-modal', 'reset-password-modal')"
                                        class="text-yellow-600 hover:text-yellow-900" title="Reset Password">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                        </svg>
                                    </button>

                                    <!-- Delete button for table action -->
                                    <button type="button" wire:click="confirmUserDeletion({{ $user->id }})"
                                        x-on:click="$dispatch('open-modal', 'delete-user-modal')"
                                        class="text-red-600 hover:text-red-900" title="Delete User">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No users found matching your criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
    </div>

    {{-- MODALS --}}

    <!-- Create User Modal -->
    <x-modals.modal name="create-user-modal" maxWidth="2xl">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Create New User</h2>

            <form wire:submit.prevent="save" class="mt-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Name -->
                    <div>
                        <label for="create_name"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
                        <input wire:model.defer="name" type="text" id="create_name"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Full name">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="create_email"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                        <input wire:model.defer="email" type="email" id="create_email"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Email address">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="create_password"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
                        <input wire:model.defer="password" type="password" id="create_password"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('password') border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Password">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <label for="create_role_select"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Role</label>
                        <select wire:model.defer="role_select" id="create_role_select"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('role_select') border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror">
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                            @endforeach
                        </select>
                        @error('role_select')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Department -->
                    <div>
                        <label for="create_department_id"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Department</label>
                        <select wire:model.defer="department_id" id="create_department_id"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('department_id') border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror">
                            <option value="">Select Department</option>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label for="create_phone_number"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone
                            Number</label>
                        <input wire:model.defer="phone_number" type="text" id="create_phone_number"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('phone_number') border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Phone number">
                        @error('phone_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Birthdate -->
                    <div>
                        <label for="create_birthdate"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Birthdate</label>
                        <input wire:model.defer="birthdate" type="date" id="create_birthdate"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('birthdate') border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror">
                        @error('birthdate')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Salary -->
                    <div>
                        <label for="create_salary"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Salary</label>
                        <input wire:model.defer="salary" type="number" step="0.01" id="create_salary"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('salary') border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Salary amount">
                        @error('salary')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="col-span-1 md:col-span-2">
                        <label for="create_address"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Address</label>
                        <textarea wire:model.defer="address" id="create_address" rows="3"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('address') border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Full address"></textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" x-on:click="$dispatch('close-modal', 'create-user-modal')"
                        class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Cancel
                    </button>
                    <button type="submit"
                        class="rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </x-modals.modal>

    <!-- Edit User Modal -->
    <x-modals.modal name="edit-user-modal" maxWidth="2xl">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Edit User</h2>

            <form wire:submit.prevent="save" class="mt-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Name -->
                    <div>
                        <label for="edit_name"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
                        <input wire:model.defer="name" type="text" id="edit_name"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Full name">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="edit_email"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                        <input wire:model.defer="email" type="email" id="edit_email"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Email address">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="edit_password"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Password (Leave blank to keep current)
                        </label>
                        <input wire:model.defer="password" type="password" id="edit_password"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('password') border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror"
                            placeholder="New password">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <label for="edit_role_select"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Role</label>
                        <select wire:model.defer="role_select" id="edit_role_select"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('role_select') border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror">
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                            @endforeach
                        </select>
                        @error('role_select')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Department -->
                    <div>
                        <label for="edit_department_id"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Department</label>
                        <select wire:model.defer="department_id" id="edit_department_id"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('department_id') border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror">
                            <option value="">Select Department</option>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label for="edit_phone_number"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone
                            Number</label>
                        <input wire:model.defer="phone_number" type="text" id="edit_phone_number"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('phone_number') border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Phone number">
                        @error('phone_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Birthdate -->
                    <div>
                        <label for="edit_birthdate"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Birthdate</label>
                        <input wire:model.defer="birthdate" type="date" id="edit_birthdate"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('birthdate') border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror">
                        @error('birthdate')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Salary -->
                    <div>
                        <label for="edit_salary"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Salary</label>
                        <input wire:model.defer="salary" type="number" step="0.01" id="edit_salary"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('salary') border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Salary amount">
                        @error('salary')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="col-span-1 md:col-span-2">
                        <label for="edit_address"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Address</label>
                        <textarea wire:model.defer="address" id="edit_address" rows="3"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('address') border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Full address"></textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" x-on:click="$dispatch('close-modal', 'edit-user-modal')"
                        class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Cancel
                    </button>
                    <button type="submit"
                        class="rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </x-modals.modal>

    <!-- View User Modal -->
    <x-modals.modal name="view-user-modal" maxWidth="lg">
        <div class="p-6">
            @if ($viewUserId && $userBeingViewed)
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    User Details
                </h2>

                <div class="mt-6">
                    <!-- User Avatar -->
                    <div class="flex justify-center mb-6">
                        @if ($userBeingViewed->image)
                            <img class="h-24 w-24 rounded-full object-cover"
                                src="{{ asset('storage/' . $userBeingViewed->image) }}"
                                alt="{{ $userBeingViewed->name }}">
                        @else
                            <div class="h-24 w-24 rounded-full bg-blue-100 flex items-center justify-center">
                                <span class="text-blue-800 font-medium text-2xl">
                                    {{ substr($userBeingViewed->name, 0, 1) }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- User Information -->
                    <div class="border-t border-gray-200 pt-4">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                            <!-- Personal Information -->
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Full name</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $userBeingViewed->name }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $userBeingViewed->email }}</dd>
                            </div>

                            <!-- Role & Department -->
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Role</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($userBeingViewed->role) }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Department</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $userBeingViewed->department->name ?? 'Not assigned' }}
                                </dd>
                            </div>

                            <!-- Contact Information -->
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $userBeingViewed->phone_number ?? 'Not provided' }}
                                </dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Birthdate</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $userBeingViewed->birthdate ? \Cake\Chronos\Chronos::parse($userBeingViewed->birthdate)->format('F d, Y') : 'Not provided' }}
                                </dd>
                            </div>

                            <!-- Financial & Account Information -->
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Salary</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $userBeingViewed->salary ? '$' . number_format($userBeingViewed->salary, 2) : 'Not set' }}
                                </dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Member since</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ \Cake\Chronos\Chronos::parse($userBeingViewed->created_at)->format('F d, Y') }}
                                </dd>
                            </div>

                            <!-- Address -->
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Address</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $userBeingViewed->address ?? 'Not provided' }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" x-on:click="$dispatch('close-modal', 'view-user-modal')"
                        class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Close
                    </button>
                    <button type="button" wire:click="edit({{ $userBeingViewed->id }})"
                        x-on:click="$dispatch('close-modal', 'view-user-modal'); $nextTick(() => $dispatch('open-modal', 'edit-user-modal'))"
                        class="rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Edit User
                    </button>
                </div>
            @else
                <div class="py-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No user selected</h3>
                    <p class="mt-1 text-sm text-gray-500">Select a user to view details.</p>
                </div>
            @endif
        </div>
    </x-modals.modal>

    <!-- Reset Password Modal -->
    <x-modals.modal name="reset-password-modal" maxWidth="md">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Reset Password
            </h2>

            <form wire:submit.prevent="resetPassword" class="mt-6">
                <div>
                    <label for="newPassword"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">New Password</label>
                    <input wire:model.defer="newPassword" type="password" id="newPassword"
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('newPassword') border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror"
                        placeholder="Enter new password">
                    @error('newPassword')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" x-on:click="$dispatch('close-modal', 'reset-password-modal')"
                        class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Cancel
                    </button>
                    <button type="submit"
                        class="rounded-md border border-transparent bg-yellow-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </x-modals.modal>

    <!-- Delete User Confirmation Modal -->
    <x-modals.modal name="delete-user-modal" maxWidth="md">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Delete User
            </h2>

            <div class="mt-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Are you sure you want to delete this user? All of their data will be permanently removed
                            including attendance records, leave requests, and salary history. This action cannot be
                            undone.
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" x-on:click="$dispatch('close-modal', 'delete-user-modal')"
                    class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Cancel
                </button>
                <button type="button" wire:click="deleteUser"
                    class="rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    Delete User
                </button>
            </div>
        </div>
    </x-modals.modal>
</div>
