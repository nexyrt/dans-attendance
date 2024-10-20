<div>
    <div class="bg-white p-5 ps-6 rounded-t-md mt-5 flex justify-between items-center">
        <p class="text-md text-gray-600 font-medium">Employee Table</p>
        <div class="flex gap-x-3">
            <!-- Button to download Excel -->
            <a href="{{ route('admin.users.export', ['department' => $department, 'position' => $position, 'name' => $name]) }}"
                class="flex items-center gap-x-3 py-2 px-4 bg-green-500 hover:bg-green-700 rounded-md text-white text-sm">
                <i class='bx bx-download text-white'></i>Download Excel
            </a>

            {{-- Button to add staff --}}
            <x-modals.admin-form-modal title='Tambah Karyawan' bg='bg-blue-500' text='text-white'
                class="rounded-md hover:bg-blue-600 text-sm">
                <form action="{{ route('admin.users.store') }}" method="POST" id="userForm"
                    enctype="multipart/form-data" class="mt-2">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Role</label>
                            <select name="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                required>
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
                            <select name="department" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                required>
                                <option value="Jasa & Keuangan">Jasa & Keuangan</option>
                                <option value="Digital">Digital</option>
                                <option value="Marketing">Marketing</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Position</label>
                            <select name="position" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                required>
                                <option value="Direktur">Direktur</option>
                                <option value="Manager">Manager</option>
                                <option value="Staff">Staff</option>
                                <option value="Supervisi">Supervisi</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="text" name="phone_number"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Birthdate</label>
                            <input type="date" name="birthdate"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Address</label>
                            <textarea name="address" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Image</label>
                            <div class="flex items-center justify-center w-full">
                                <label for="dropzone-file"
                                    class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50  dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600 relative">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6" id="upload-text">
                                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                            <span class="font-semibold">Click to upload</span> or
                                            drag and drop
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG,
                                            PNG, JPG or GIF (MAX. 800x400px)</p>
                                    </div>
                                    <input id="dropzone-file" name="image" type="file" class="hidden"
                                        accept="image/*" />
                                    <img id="preview-image"
                                        class="absolute inset-0 object-cover w-full h-full rounded-lg hidden" />
                                </label>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Salary</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span
                                    class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">Rp.</span>
                                <input type="text" name="salary"
                                    class="flex-1 block w-full rounded-none rounded-r-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="0">
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-6">
                        <button type="submit"
                            class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm">Simpan</button>
                    </div>
                </form>
            </x-modals.admin-form-modal>
        </div>
    </div>

    <div class="flex gap-4 p-5 bg-white">
        <select wire:model.live="department"
            class="form-select dropdown-custom border-none bg-gray-100 hover:bg-gray-200 rounded-lg focus:outline-none focus:ring-blue-400 focus:ring-opacity-50 focus:shadow-blur-spread">
            <option value="">All Departments</option>
            <option value="Jasa & Keuangan">Jasa & Keuangan</option>
            <option value="Digital">Digital</option>
            <option value="Marketing">Marketing</option>
        </select>
        <select wire:model.live="position"
            class="form-select dropdown-custom border-none bg-gray-100 hover:bg-gray-200 rounded-lg focus:outline-none focus:ring-blue-400 focus:ring-opacity-50 focus:shadow-blur-spread">
            <option value="" class="p-5">All Positions</option>
            <option value="Direktur">Direktur</option>
            <option value="Manager">Manager</option>
            <option value="Staff">Staff</option>
            <option value="Supervisi">Supervisi</option>
        </select>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input type="text" wire:model="name"
                class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Search by Name" />
        </div>
    </div>

    <table class="w-full bg-white divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach ($users as $user)
                <tr>
                    <td class="px-6 py-4 flex whitespace-nowrap">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset($user->image) }}"
                            alt="{{ $user->name }} image">
                        <div class="ps-3">
                            <div class="text-base font-semibold">{{ $user->name }}</div>
                            <div class="font-normal text-gray-500">{{ $user->email }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <p class="text-gray-500 font-medium">{{ $user->position }}</p>
                        <p
                            class="bg-gradient-to-r from-blue-500 to-purple-500 text-white text-xs p-1.5 rounded-md w-fit">
                            {{ $user->department }}</p>
                    </td>
                    <td class="px-6 py-4 flex items-center gap-x-3 whitespace-nowrap"><i
                            class='bx bxs-circle text-green-500'></i>Active</td>
                    <td class="text-blue-400 px-6 py-4 whitespace-nowrap">
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="flex"
                            onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                        </form>
                        <x-modals.admin-form-modal title='Edit' text='text-blue-400 '
                            class="rounded-md hover:text-blue-500 text-md p-0">
                            <form method="POST" action="{{ route('admin.users.update', $user->id) }}"
                                id="edit-user-form" class="w-full">
                                @csrf
                                @method('PUT')

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Name</label>
                                        <input type="text" name="name" value="{{$user->name}}"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Email</label>
                                        <input type="email" name="email" value="{{$user->email}}"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Password</label>
                                        <input type="password" name="password" value="{{$user->password}}"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Role</label>
                                        <select name="role"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
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
                                        <select name="department"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                            <option value="Jasa & Keuangan">Jasa & Keuangan</option>
                                            <option value="Digital">Digital</option>
                                            <option value="Marketing">Marketing</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Position</label>
                                        <select name="position"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                            <option value="Direktur">Direktur</option>
                                            <option value="Manager">Manager</option>
                                            <option value="Staff">Staff</option>
                                            <option value="Supervisi">Supervisi</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                                        <input type="text" name="phone_number"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Birthdate</label>
                                        <input type="date" name="birthdate"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    </div>
                                    <div class="col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Address</label>
                                        <textarea name="address" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                                    </div>
                                    <div class="col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Image</label>
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
                                                        <span class="font-semibold">Click to upload</span> or
                                                        drag and drop
                                                    </p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">SVG,
                                                        PNG, JPG or GIF (MAX. 800x400px)</p>
                                                </div>
                                                <input id="dropzone-file" name="image" type="file"
                                                    class="hidden" accept="image/*" />
                                                <img id="preview-image"
                                                    class="absolute inset-0 object-cover w-full h-full rounded-lg hidden" />
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Salary</label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <span
                                                class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">Rp.</span>
                                            <input type="text" name="salary"
                                                class="flex-1 block w-full rounded-none rounded-r-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                placeholder="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-5 sm:mt-6">
                                    <button type="submit"
                                        class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm">Simpan</button>
                                </div>
                            </form>
                        </x-modals.admin-form-modal>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
