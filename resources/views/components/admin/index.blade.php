<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

    {{-- Filter & Export --}}
    <div class="flex justify-between mx-8 items-center">

        <form id="filterForm" class="my-8 flex gap-x-5">
            @csrf


            <select name="department" id="departmentSelect"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5  dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <option class="px-4 py-5 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" value="">
                    All Department</option>
                <option class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                    value="Keuangan">
                    Keuangan</option>
                <option class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                    value="Digital">
                    Digital</option>
                <option class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                    value="Digital">
                    Digital Marketing</option>
            </select>

            <select name="position" id="positionSelect"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5  dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <option class="px-4 py-5 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" value="">
                    All Position</option>
                <option class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" value="Staff">
                    Staff</option>
                <option class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                    value="Manager">
                    Manager</option>
                <option class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                    value="Director">
                    Director</option>
            </select>

            <input name="startDate" id="startDate" type="date"
                class="w-[30%] bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Start date">

            <input name="endDate" id="endDate" type="date"
                class="w-[30%] bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="End date">

            <div class="relative w-[50%]">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="search" type="text" id="user_name" name="user_name"
                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search Employees" required />
            </div>
        </form>

        <form id="exportForm" action="{{ route('export-table') }}" method="post">
            @csrf
            <input type="hidden" name="department" id="exportDepartment">
            <input type="hidden" name="position" id="exportPosition">
            <input type="hidden" name="startDate" id="exportstartDate">
            <input type="hidden" name="endDate" id="exportendDate">
            <input type="hidden" name="user_name" id="exportuser_name">
            <!-- Add more hidden input fields for other filter values if needed -->
            <button id="exportButton" type="submit"
                class="bg-green-600 rounded-xl text-white p-3 h-fit w-24 hover:bg-green-800">Export</button>
        </form>

    </div>

    {{-- Table --}}
    @livewire('table', ['model' => \App\Models\Attendance::class, 'columns' => ['name', 'date', 'check_in', 'check_out', 'activity_log']])

    {{-- Alpine --}}

    {{-- Dropdown --}}
    {{-- <div x-data="{ isOpen: false, selectedOption: null }" class="relative">
        <!-- Trigger button -->
        <p @click="isOpen = !isOpen"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 py-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5  text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            <span x-text="selectedOption ? selectedOption : 'A'"></span>
            <svg :class="{ 'transform rotate-180': isOpen }" class="w-5 h-5 text-gray-400"
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd"
                    d="M6.293 7.293a1 1 0 011.414 0L10 9.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
            </svg>
        </p>

        <!-- Dropdown menu -->
        <div x-show="isOpen" @click.away="isOpen = false"
            class="absolute top-full left-0 z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
            <a @click="selectedOption = 'Option 1'; isOpen = false" href="#"
                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Option 1</a>
            <a @click="selectedOption = 'Option 2'; isOpen = false" href="#"
                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Option 2</a>
            <a @click="selectedOption = 'Option 3'; isOpen = false" href="#"
                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Option 3</a>
        </div>
    </div> --}}

    <div x-data="{ dataToSend: 'Sterling Cummings', data: '' }">
        <button @click="sendData">Send Data</button>
        <p x-show='data ? true:false' x-text='data'></p>
    </div>
