<div>
    <div class="mb-4">
        <input wire:model.live="searchName" type="text" placeholder="Search by Name" class="form-control mb-2">
        <input wire:model.live="searchPosition" type="text" placeholder="Search by Position" class="form-control mb-2">

        <!-- Dropdown for Department -->
        <div x-data="{ open: false }" class="relative inline-block text-left">
            <button id="dropdownDepartmentButton" @click="open = !open"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                type="button">
                {{ $searchDepartment ?: 'Search by Department' }}
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                </svg>
            </button>

            <!-- Dropdown menu -->
            <div id="dropdown" x-show="open" @click.away="open = false"
                class="z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDepartmentButton">
                    <li>
                        <a href="#" wire:click.prevent="setDepartment('')"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">None
                        </a>
                    </li>
                    <li>
                        <a href="#" wire:click.prevent="setDepartment('Digital')"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Digital</a>
                    </li>
                    <li>
                        <a href="#" wire:click.prevent="setDepartment('Digital Marketing')"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Digital
                            Marketing</a>
                    </li>
                    <li>
                        <a href="#" wire:click.prevent="setDepartment('Finance')"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Finance</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Position</th>
                <th>Department</th>
                <th>Salary</th>
                <th>Birthdate</th>
                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->position }}</td>
                    <td>{{ $user->department }}</td>
                    <td>{{ $user->salary }}</td>
                    <td>{{ $user->birthdate }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $users->links() }}
</div>
