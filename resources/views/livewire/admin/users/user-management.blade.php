<div x-data  = "{ editModal : false,createModal : false,currUser : null }">
    {{-- Stats Cards with Gradient Backgrounds --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div
            class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Employees</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['total_employees'] }}</p>
                </div>
                <div class="bg-blue-400/30 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div
            class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Departments</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['departments'] }}</p>
                </div>
                <div class="bg-purple-400/30 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div
            class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl p-6 text-white shadow-lg transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-100 text-sm font-medium">Positions</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['positions'] }}</p>
                </div>
                <div class="bg-emerald-400/30 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>
    </div>


    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        {{-- Header Section --}}
        <div class="p-6 border-b border-gray-100">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <h2 class="text-xl font-semibold text-gray-800">Employee Management</h2>
                <div class="flex gap-3">
                    {{-- Excel Export Button --}}
                    <a href="{{ route('admin.users.export', ['department' => $department, 'position' => $position, 'name' => $name]) }}"
                        class="inline-flex items-center px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Export Excel
                    </a>

                    {{-- Add Employee Button --}}
                    <button type="button" @click="createModal = true"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition-colors duration-150 ease-in-out">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Employee
                    </button>
                </div>
            </div>
        </div>


        <!-- Enhanced Table Section -->
        <div class="overflow-x-auto bg-white rounded-xl shadow-sm border border-gray-100">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Employee Information
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Role Details
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50/50 transition-all duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img class="h-12 w-12 rounded-full object-cover ring-2 ring-gray-100"
                                            src="{{ asset($user->image) }}" alt="{{ $user->name }} image">
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                        <div class="text-xs text-gray-400 mt-1">ID: #{{ $user->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 font-medium">{{ $user->position }}</div>
                                <div
                                    class="inline-flex items-center px-2.5 py-1 mt-1 rounded-full text-xs font-medium bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-sm">
                                    {{ $user->department->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></div>
                                    <span class="text-sm font-medium text-gray-700">Active</span>
                                </div>
                                <div class="text-xs text-gray-400 mt-1">Last active: Today</div>
                            </td>
                            <!-- Action Buttons -->
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <!-- Edit Button -->
                                    <button @click = "editModal = true;currUser = {{ $user }}"
                                        class="p-2 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-all duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>

                                    <!-- Delete Button -->
                                    <button
                                        @click="$dispatch('open-delete-modal', { userId: {{ $user->id }}, userName: '{{ $user->name }}' })"
                                        class="p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg transition-all duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="rounded-full bg-gray-100 p-3 mb-4">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-1">No Employees Found</h3>
                                    <p class="text-gray-500 text-sm">Try adjusting your search or filters</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        <div x-data="{ activeTab: 'personal' }" x-show="createModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto"
            style="display: none;">
            <div class="flex min-h-screen items-center justify-center p-4">
                <!-- Background overlay with blur -->
                <div class="fixed inset-0 bg-gray-500/75 backdrop-blur-sm transition-opacity">
                </div>

                <!-- Modal panel -->
                <div
                    class="relative w-full max-w-3xl transform overflow-hidden rounded-xl bg-white shadow-2xl transition-all">
                    <!-- Modal Header with Tabs -->
                    <div class="border-b border-gray-100">
                        <div class="flex items-center justify-between px-4 py-3">
                            <h3 class="text-lg font-semibold text-gray-900">Create New Employee</h3>
                            <button @click="createModal = false"
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
                    <form method="POST" class="px-4 py-4" action="{{ route('admin.users.store') }}"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- Personal Info Tab -->
                        <div x-show="activeTab === 'personal'" class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs font-medium text-gray-600">Full Name</label>
                                    <input type="text" name="name" required
                                        class="mt-1 block w-full rounded-md border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-600">Email Address</label>
                                    <input type="email" name="email" required maxlength="255"
                                        class="mt-1 block w-full rounded-md border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-600">Password</label>
                                    <input type="password" name="password" required minlength="8"
                                        class="mt-1 block w-full rounded-md border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-600">Phone Number</label>
                                    <input type="tel" name="phone_number" maxlength="15"
                                        class="mt-1 block w-full rounded-md border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-600">Birth Date</label>
                                    <input type="date" name="birthdate"
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
                                        <select name="department" required
                                            class="block w-full appearance-none rounded-md border-gray-200 bg-white pl-3 pr-10 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                            <option value="">Select Department</option>
                                            @foreach ($departments as $dept)
                                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                            @endforeach
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="text-xs font-medium text-gray-600">Position</label>
                                    <div class="relative mt-1">
                                        <select name="position" required
                                            class="block w-full appearance-none rounded-md border-gray-200 bg-white pl-3 pr-10 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                            <option value="">Select Position</option>
                                            <option value="Direktur">Director</option>
                                            <option value="Manager">Manager</option>
                                            <option value="Staff">Staff</option>
                                            <option value="Supervisi">Supervisor</option>
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="text-xs font-medium text-gray-600">Role</label>
                                    <div class="relative mt-1">
                                        <select name="role" required
                                            class="block w-full appearance-none rounded-md border-gray-200 bg-white pl-3 pr-10 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                            <option value="Admin">Admin</option>
                                            <option value="Manajer">Manager</option>
                                            <option value="Staff">Staff</option>
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="text-xs font-medium text-gray-600">Salary</label>
                                    <div class="relative mt-1">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-gray-500 sm:text-sm">Rp</span>
                                        </div>
                                        <input type="number" name="salary" step="0.01"
                                            class="block w-full rounded-md border-gray-200 pl-10 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Other Details Tab -->
                        <div x-show="activeTab === 'other'" class="space-y-4">
                            <div>
                                <label class="text-xs font-medium text-gray-600">Address</label>
                                <textarea name="address" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                    placeholder="Enter complete address"></textarea>
                            </div>

                            <!-- Compact Image Upload -->
                            <div>
                                <label class="text-xs font-medium text-gray-600">Profile Image</label>
                                <div class="mt-1 flex items-center space-x-4">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-center w-full">
                                            <label for="dropzone-file"
                                                class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                                <div class="flex flex-col items-center justify-center pt-5 pb-6"
                                                    id="upload-text">
                                                    <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 20 16">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                                    </svg>
                                                    <p class="mb-2 text-sm text-gray-500">
                                                        <span class="font-semibold">Click to upload</span>
                                                        or drag and drop
                                                    </p>
                                                    <p class="text-xs text-gray-500">
                                                        SVG, PNG, JPG or GIF (MAX. 800x400px)
                                                    </p>
                                                </div>
                                                <input id="dropzone-file" name="image" type="file"
                                                    class="hidden" accept="image/*" />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="mt-6 flex justify-end space-x-2 border-t border-gray-100 pt-4">
                            <button @click="createModal = false" type="button"
                                class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit"
                                class="inline-flex items-center rounded-md border border-transparent bg-blue-600 px-3 py-2 text-xs font-medium text-white shadow-sm hover:bg-blue-700">
                                Create Employee
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Enhanced Edit Modal -->
        <div x-data="{ activeTab: 'personal' }" x-show="editModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto"
            style="display: none;">
            <div class="flex min-h-screen items-center justify-center p-4">
                <!-- Background overlay with blur -->
                <div class="fixed inset-0 bg-gray-500/75 backdrop-blur-sm transition-opacity">
                </div>

                <!-- Modal panel -->
                <div
                    class="relative w-full max-w-3xl transform overflow-hidden rounded-xl bg-white shadow-2xl transition-all">
                    <!-- Modal Header with Tabs -->
                    <div class="border-b border-gray-100">
                        <div class="flex items-center justify-between px-4 py-3">
                            <h3 class="text-lg font-semibold text-gray-900">Edit Employee
                            </h3>
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
                    <form method = "POST" class="px-4 py-4"
                        x-bind:action="'{{ route('admin.users.update', '') }}/' + currUser.id"
                        enctype="multipart/form-data">
                        @csrf

                        @method('PUT')

                        <!-- Personal Info Tab -->
                        <div x-show="activeTab === 'personal'" class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs font-medium text-gray-600">Full
                                        Name</label>
                                    <input type="text" :value="currUser.name" name = "name"
                                        class="mt-1 block w-full rounded-md border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-600">
                                        Email Address
                                    </label>
                                    <input type="email" name="email" :value="currUser.email" required
                                        maxlength="255"
                                        class="mt-1 block w-full rounded-md border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">

                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-600">Phone
                                        Number</label>
                                    <!-- Phone Number - nullable|string|max:15 -->
                                    <input type="tel" name="phone_number" :value="currUser.phone_number"
                                        maxlength="15"
                                        class="mt-1 block w-full rounded-md border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">

                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-600">Birth
                                        Date</label>
                                    <input type="date" name="birthdate" :value="currUser.birthdate"
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
                                        <select name="department_id" required :value="currUser.department_id"
                                            class="block w-full appearance-none rounded-md border-gray-200 bg-white pl-3 pr-10 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                            <option value="">Select Department</option>
                                            @foreach ($departments as $dept)
                                                <option value="{{ $dept->id }}" name ="department_id">
                                                    {{ $dept->name }}</option>
                                            @endforeach
                                        </select>

                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="text-xs font-medium text-gray-600">Position</label>
                                    <div class="relative mt-1">
                                        <select name="position" required :value="currUser.position"
                                            class="block w-full appearance-none rounded-md border-gray-200 bg-white pl-3 pr-10 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                            <option value="">Select Position</option>
                                            <option value="Direktur">Director</option>
                                            <option value="Manager">Manager</option>
                                            <option value="Staff">Staff</option>
                                            <option value="Supervisi">Supervisor</option>
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="text-xs font-medium text-gray-600">Role</label>
                                    <div class="relative mt-1">
                                        <select name="role" required :value="currUser.role"
                                            class="block w-full appearance-none rounded-md border-gray-200 bg-white pl-3 pr-10 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                            <option value="admin">Admin</option>
                                            <option value="manajer">Manager</option>
                                            <option value="staff">Staff</option>
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="text-xs font-medium text-gray-600">Salary</label>
                                    <div class="relative mt-1">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-gray-500 sm:text-sm">Rp</span>
                                        </div>
                                        <input type="number" name="salary" :value="currUser.salary" step="0.01"
                                            class="block w-full rounded-md border-gray-200 pl-10 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Other Details Tab -->
                        <div x-show="activeTab === 'other'" class="space-y-4">
                            <div>
                                <label class="text-xs font-medium text-gray-600">Address</label>
                                <textarea name="address" :value="currUser.address" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-200 text-sm shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                    placeholder="Enter complete address"></textarea>
                            </div>

                            <!-- Compact Image Upload -->
                            <div>
                                <label class="text-xs font-medium text-gray-600">Profile
                                    Image</label>
                                <div class="mt-1 flex items-center space-x-4">
                                    @if ($user->image)
                                        <div class="flex-shrink-0">
                                            <img src="{{ asset($user->image) }}" alt="Current profile photo"
                                                class="h-16 w-16 rounded-full object-cover">
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <div class="flex items-center justify-center w-full">
                                            <label for="dropzone-file"
                                                class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50  dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600 relative">
                                                <div class="flex flex-col items-center justify-center pt-5 pb-6"
                                                    id="upload-text">
                                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 20 16">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                                    </svg>
                                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                                        <span class="font-semibold">Click to
                                                            upload</span>
                                                        or
                                                        drag and drop
                                                    </p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        SVG,
                                                        PNG, JPG or GIF (MAX. 800x400px)</p>
                                                </div>
                                                <input id="dropzone-file" name="image" type="file"
                                                    class="hidden" accept="image/*" />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="mt-6 flex justify-end space-x-2 border-t border-gray-100 pt-4">
                            <button @click="editModal = false"
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

        <!-- Loading Indicator -->
        <div wire:loading class="w-full">
            <div class="flex justify-center items-center p-4">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
            </div>
        </div>


        <!-- Pagination -->
        <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <!-- Items Per Page Dropdown - Stacks on mobile, inline on desktop -->
                <div class="flex items-center gap-2">
                    <label class="text-sm text-gray-600">Show</label>
                    <select wire:model.live="perPage"
                        class="h-9 w-20 rounded-md border-none bg-gray-100 px-3 py-1 text-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-200">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <label class="text-sm text-gray-600">entries</label>
                </div>


            </div>
        </div>
    </div>
