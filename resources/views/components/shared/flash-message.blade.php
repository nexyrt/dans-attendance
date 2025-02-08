<?php
    $messages = [
        'message' => [
            'icon' => 'check-circle',
            'color' => 'green',
        ],
        'error' => [
            'icon' => 'x-circle',
            'color' => 'red',
        ],
        'warning' => [
            'icon' => 'exclamation',
            'color' => 'yellow',
        ],
        'info' => [
            'icon' => 'information-circle',
            'color' => 'blue',
        ],
    ];

    $type = 'message';
    foreach ($messages as $key => $value) {
        if (session()->has($key)) {
            $type = $key;
            break;
        }
    }

    $message = session($type);
    $config = $messages[$type];
?>
<div aria-live="assertive" class="pointer-events-none fixed inset-0 flex items-start justify-center px-4 py-6 sm:p-6"
    style="z-index: 99999; position: fixed; top: 0; left: 0; right: 0;">
    <div class="flex w-full flex-col items-end space-y-4 sm:items-end" style="position: relative; z-index: inherit;">
        @if (session()->has($type))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            x-transition:enter="transform ease-out duration-300 transition"
            x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
            x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white dark:bg-gray-800 shadow-lg ring-1 ring-black ring-opacity-5"
            style="position: relative; z-index: inherit;">
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        @if ($config['icon'] === 'check-circle')
                        <svg class="h-6 w-6 text-{{ $config['color'] }}-400" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        @elseif ($config['icon'] === 'x-circle')
                        <svg class="h-6 w-6 text-{{ $config['color'] }}-400" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        @elseif ($config['icon'] === 'exclamation')
                        <svg class="h-6 w-6 text-{{ $config['color'] }}-400" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        @else
                        <svg class="h-6 w-6 text-{{ $config['color'] }}-400" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                        @endif
                    </div>
                    <div class="ml-3 w-0 flex-1 pt-0.5">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                            {{ $message }}
                        </p>
                    </div>
                    <div class="ml-4 flex flex-shrink-0">
                        <button @click="show = false" type="button"
                            class="inline-flex rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <span class="sr-only">Close</span>
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>