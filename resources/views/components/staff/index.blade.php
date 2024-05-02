<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900 dark:text-gray-100 mb-5">
        <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="overflow-hidden">
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                        Date</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                        Activity Log</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                        Check-In</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                        Check-Out</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($dataVariable as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            {{ substr($item->date, 8, 2) }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                            <div id="activityLog{{ $loop->index }}">{!! $item->activity_log !!}</div>
                                            <!-- Container for activity log -->
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