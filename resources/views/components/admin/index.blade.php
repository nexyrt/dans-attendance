<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
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

            <div class="relative w-[50%]">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="search" type="text" id="employeeName" name="employeeName"
                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search Employees" required />
            </div>
        </form>

        <form id="exportForm" action="{{ route('export-table') }}" method="post">
            @csrf
            <input type="hidden" name="department" id="exportDepartment">
            <input type="hidden" name="position" id="exportPosition">
            <!-- Add more hidden input fields for other filter values if needed -->
            <button id="exportButton" type="submit"
                class="bg-green-600 rounded-xl text-white p-3 h-fit w-24 hover:bg-green-800">Export</button>
        </form>

    </div>
    <div class="p-6 text-gray-900 dark:text-gray-100 mb-5">
        <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="overflow-hidden">
                        <table id="dataTable" class="min-w-full">
                            <thead>
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                        Name</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                        Department</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                        Position</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                        Activity Log</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                        Date</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                        Check-In</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                        Check-Out</th>
                                </tr>
                            </thead>
                            <tbody id="table-body" class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($dataVariable as $item)
                                    <tr>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">
                                            {{ $item->employee->name }}</td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                            <p class="bg-blue-500 p-1.5 text-white rounded-md w-fit">
                                                {{ $item->employee->department }}</p>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                            <p class="bg-orange-500 p-1.5 text-white rounded-md w-fit">
                                                {{ $item->employee->position }}</p>

                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                            {{ $item->activity_log }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap  text-end text-sm font-medium">
                                            {{ $item->date }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-green-700 text-end text-sm font-medium">
                                            {{ $item->check_in }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-red-700 text-end text-sm font-medium">
                                            {{ $item->check_out }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const exportButton = document.getElementById('exportButton');
        exportButton.addEventListener('click', function() {
            event.preventDefault();
            populateExportForm();
            document.getElementById('exportForm').submit();
        });

        function populateExportForm() {
            const department = document.getElementById('departmentSelect').value;
            const position = document.getElementById('positionSelect').value;
            document.getElementById('exportDepartment').value = department;
            document.getElementById('exportPosition').value = position;
        }

        // Fetch data when the page loads
        const inputElement = document.getElementById('filterForm');
        inputElement.addEventListener('change', function() {
            fetchData();
        })

        const textElement = document.getElementById('filterForm');
        inputElement.addEventListener('input', function() {
            fetchData();
        })

        function fetchData() {
            const department = document.getElementById('departmentSelect').value;
            const position = document.getElementById('positionSelect').value;
            const employeeName = document.getElementById('employeeName').value;
            $.ajax({
                url: '/fetch-data',
                type: 'GET',
                data: {
                    department: department,
                    employee_name: employeeName,
                    position: position,
                },
                success: function(response) {
                    renderTable(response);
                }
            });
        }

        function renderTable(data) {
            // Render your table rows based on the fetched data
            const tableBody = document.getElementById('table-body');
            tableBody.innerHTML = ''; // Clear existing table rows

            data.forEach(item => {
                const row = document.createElement('tr');

                // Create and populate table cells with data from each item
                const nameCell = createTableCell(item.employee.name,
                    'px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200'
                );
                const departmentCell = createTableCell(
                    `<p class="bg-blue-500 p-1.5 text-white rounded-md w-fit">${item.employee.department}</p>`,
                    'px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200');
                const positionCell = createTableCell(
                    `<p class="bg-orange-500 p-1.5 text-white rounded-md w-fit">${item.employee.position}</p>`,
                    'px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200');
                const activityLogCell = createTableCell(item.activity_log,
                    'px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200');
                const dateCell = createTableCell(item.date,
                    'px-6 py-4 whitespace-nowrap text-end text-sm font-medium');
                const checkInCell = createTableCell(item.check_in,
                    'px-6 py-4 whitespace-nowrap text-green-700 text-end text-sm font-medium');
                const checkOutCell = createTableCell(item.check_out,
                    'px-6 py-4 whitespace-nowrap text-red-700 text-end text-sm font-medium');

                // Append the table cells to the table row
                row.appendChild(nameCell);
                row.appendChild(departmentCell);
                row.appendChild(positionCell);
                row.appendChild(activityLogCell);
                row.appendChild(dateCell);
                row.appendChild(checkInCell);
                row.appendChild(checkOutCell);

                // Append the row to the table body
                tableBody.appendChild(row);
            });
        }

        function createTableCell(content, classes) {
            const cell = document.createElement('td');
            cell.innerHTML = content;
            cell.className = classes;
            return cell;
        }

        // function getTableData() {
        //     const tableData = [];
        //     const rows = document.querySelectorAll('#dataTable tbody tr');
        //     rows.forEach(row => {
        //         const rowData = [];
        //         row.querySelectorAll('td').forEach(cell => {
        //             rowData.push(cell.textContent.trim());
        //         });
        //         tableData.push(rowData);
        //     });
        //     return tableData
        // }
    });
</script>
