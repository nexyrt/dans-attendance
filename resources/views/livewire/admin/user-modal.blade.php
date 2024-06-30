<div>
    <!-- Modal -->
    <div id="userModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                {{ $userId ? 'Edit' : 'Tambah' }} Karyawan
                            </h3>
                            <div class="mt-2">
                                <form wire:submit.prevent="saveUser" id="userForm" enctype="multipart/form-data">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="col-span-2">
                                            <h4 class="text-lg font-medium">User Information</h4>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Name</label>
                                            <input type="text" wire:model="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Email</label>
                                            <input type="email" wire:model="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Password</label>
                                            <input type="password" wire:model="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Role</label>
                                            <select wire:model="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                                <option value="Admin">Admin</option>
                                                <option value="Manajer">Manajer</option>
                                                <option value="Staff">Staff</option>
                                            </select>
                                        </div>
                                        <div class="col-span-2 mt-4">
                                            <h4 class="text-lg font-medium">Contact Information</h4>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Department</label>
                                            <select wire:model="department" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                                <option value="Jasa & Keuangan">Jasa & Keuangan</option>
                                                <option value="Digital">Digital</option>
                                                <option value="Marketing">Marketing</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Position</label>
                                            <select wire:model="position" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                                <option value="Direktur">Direktur</option>
                                                <option value="Manager">Manager</option>
                                                <option value="Staff">Staff</option>
                                                <option value="Supervisi">Supervisi</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                                            <input type="text" wire:model="phone_number" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Birthdate</label>
                                            <input type="date" wire:model="birthdate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                        </div>
                                        <div class="col-span-2">
                                            <label class="block text-sm font-medium text-gray-700">Address</label>
                                            <textarea wire:model="address" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                                        </div>
                                        <div class="col-span-2">
                                            <label class="block text-sm font-medium text-gray-700">Image</label>
                                            <div class="flex items-center justify-center w-full">
                                                <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600 relative">
                                                    <div class="flex flex-col items-center justify-center pt-5 pb-6" id="upload-text">
                                                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                                        </svg>
                                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                                            <span class="font-semibold">Click to upload</span> or drag and drop
                                                        </p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                                                    </div>
                                                    <input id="dropzone-file" name="image" type="file" wire:model="image" class="hidden" />
                                                    <img id="preview-image" class="absolute inset-0 object-cover w-full h-full rounded-lg hidden" />
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Salary</label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">Rp.</span>
                                                <input type="text" wire:model="salary" class="flex-1 block w-full rounded-none rounded-r-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-5 sm:mt-6">
                                        <button type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" id="closeModalBtn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
