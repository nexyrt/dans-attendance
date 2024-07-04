<!-- resources/views/components/modal.blade.php -->
@props(['isEdit' => false, 'user' => null])

<div x-show="showModal" x-cloak class="fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
            @click.away="showModal = false">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" x-text="isEdit ? 'Edit' : 'Tambah' + ' Karyawan'"></h3>
                        <div class="mt-2">
                            <form id="userForm" enctype="multipart/form-data">
                                @csrf
                                <div class="grid grid-cols-2 gap-4">
                                    <!-- Your form fields here -->
                                    <!-- Name -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Name</label>
                                        <input type="text" name="name"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required
                                            value="{{ $user->name ?? '' }}">
                                    </div>
                                    <!-- Email -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Email</label>
                                        <input type="email" name="email"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required
                                            value="{{ $user->email ?? '' }}">
                                    </div>
                                    <!-- Password -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Password</label>
                                        <input type="password" name="password"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                            x-bind:required="!isEdit">
                                    </div>
                                    <!-- Other fields... -->
                                </div>
                                <div class="mt-5 sm:mt-6">
                                    <button type="submit"
                                        class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" @click="showModal = false"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>
