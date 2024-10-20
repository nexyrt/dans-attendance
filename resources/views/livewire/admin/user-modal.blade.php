<div class="fixed z-10 inset-0 overflow-y-auto" style="display: none;" id="employeeModal" wire:ignore.self>
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            {{ $employee_id ? 'Edit Employee' : 'Add Employee' }}
                        </h3>
                        <div class="mt-2">
                            <input type="hidden" wire:model="employee_id">
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                                <input type="text" id="name" wire:model="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                                <input type="email" id="email" wire:model="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="department" class="block text-gray-700 text-sm font-bold mb-2">Department:</label>
                                <input type="text" id="department" wire:model="department" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('department') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
                                <input type="text" id="status" wire:model="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('status') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password:</label>
                                <input type="password" id="password" wire:model="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('password') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="position" class="block text-gray-700 text-sm font-bold mb-2">Position:</label>
                                <input type="text" id="position" wire:model="position" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('position') <span class="text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm" wire:click="save">Save</button>
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="document.getElementById('employeeModal').style.display='none'">Cancel</button>
            </div>
        </div>
    </div>
</div>
