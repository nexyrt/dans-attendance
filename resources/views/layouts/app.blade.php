<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />

        <!-- Scripts -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>

        @notifyCss
        @livewireStyles

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <x-notify::notify />
        @notifyJs
        @livewireScripts
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
        {{-- Export & Filter --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const exportButton = document.getElementById('exportButton');
                exportButton.addEventListener('click', function() {
                    populateExportForm();
                    document.getElementById('exportForm').submit();
                });

                function populateExportForm() {
                    const department = document.getElementById('departmentSelect').value;
                    const position = document.getElementById('positionSelect').value;
                    const user_name = document.getElementById('user_name').value;
                    const startDate = document.getElementById('startDate').value;
                    const endDate = document.getElementById('endDate').value;
                    document.getElementById('exportDepartment').value = department;
                    document.getElementById('exportPosition').value = position;
                    document.getElementById('exportuser_name').value = user_name;
                    document.getElementById('exportstartDate').value = startDate;
                    document.getElementById('exportendDate').value = endDate;
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
                    const user_name = document.getElementById('user_name').value;
                    const startDate = document.getElementById('startDate').value;
                    const endDate = document.getElementById('endDate').value;

                    $.ajax({
                        url: '/fetch-data',
                        type: 'GET',
                        data: {
                            department: department,
                            user_name: user_name,
                            position: position,
                            startDate: startDate,
                            endDate: endDate,
                        },
                        success: function(response) {
                            console.log(response);
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
                        const nameCell = createTableCell(item.user.name,
                            'px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200'
                        );
                        const departmentCell = createTableCell(
                            `<p class="bg-blue-500 p-1.5 text-white rounded-md w-fit">${item.user.department}</p>`,
                            'px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200');
                        const positionCell = createTableCell(
                            `<p class="bg-orange-500 p-1.5 text-white rounded-md w-fit">${item.user.position}</p>`,
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
            });
        </script>
        {{-- Display activity log --}}
        <script>
            // Define a function to apply list styles
            function applyListStyles() {
                // Select all ol and ul elements
                const listElements = document.querySelectorAll('ol, ul');

                // Loop through each list element
                listElements.forEach((list) => {
                    // Determine the appropriate list-style-type and add the classes
                    const listStyleType = list.tagName === 'OL' ? 'list-decimal' : 'list-disc';
                    list.classList.add(listStyleType, 'list-inside');
                });
            }

            // Create a MutationObserver instance
            const observer = new MutationObserver((mutationsList, observer) => {
                // Call the applyListStyles function whenever a mutation occurs
                applyListStyles();
            });

            // Start observing mutations on the body element
            observer.observe(document.body, {
                subtree: true,
                childList: true
            });

            // Initial call to applyListStyles when the DOM content is loaded
            document.addEventListener('DOMContentLoaded', function() {
                applyListStyles();
            });
        </script>
        {{-- Alpine --}}
        <script>
            function sendData() {
                let data = {
                    dataToSend: this.dataToSend
                };

                // Send an AJAX POST request to the Laravel route
                fetch('/send-data', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for Laravel
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data[0].name);
                        this.data = data[0].name; // Handle the response from the server
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        </script>

    </body>

</html>
