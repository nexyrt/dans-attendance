<!-- resources/views/livewire/q-r-attendance.blade.php -->
<div class="w-full p-6">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Universal QR Code Attendance System</h2>

        <!-- Flash Messages -->
        @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- QR Code Generation Section -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-700">Generate Universal QR Code</h3>

                <!-- Info Banner -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-blue-800">Smart Time Detection</h4>
                            <div class="mt-1 text-sm text-blue-700">
                                <p>• <strong>Morning (6AM - 12PM):</strong> Automatically detects as Check-in</p>
                                <p>• <strong>Evening (2PM - 10PM):</strong> Automatically detects as Check-out</p>
                                <p>• QR code works for both check-in and check-out based on scan time</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select User</label>
                    <select wire:model="selectedUser"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Choose a user...</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->name }} - {{ $user->department->name ?? 'No Department' }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex space-x-3">
                    <button wire:click="generateQRData"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md transition duration-200 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Generate Universal QR Code
                    </button>
                    <button wire:click="clearQR"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition duration-200">
                        Clear
                    </button>
                </div>

                <!-- QR Code Display Container -->
                <div class="mt-6">
                    <div id="qrcode-container" class="hidden text-center">
                        <h4 class="text-md font-medium text-gray-700 mb-3">Universal QR Code Generated</h4>
                        <div id="qrcode" class="flex justify-center p-4 border border-gray-300 rounded-lg bg-gray-50">
                        </div>
                        <p class="text-sm text-gray-500 mt-2">This QR code automatically detects check-in/check-out
                            based on scan time</p>

                        <!-- Download Button (Manual) -->
                        <button id="download-qr"
                            class="mt-3 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md transition duration-200 flex items-center mx-auto">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Download QR Code
                        </button>

                        <!-- Auto-download notification -->
                        <div class="mt-2 text-xs text-green-600 bg-green-50 rounded px-3 py-1 inline-block">
                            📥 QR code automatically downloaded to your device
                        </div>
                    </div>
                </div>

                <!-- Selected User Info -->
                @if($selectedUser)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h5 class="font-medium text-blue-800">Selected User</h5>
                    <p class="text-blue-600">{{ $users->find($selectedUser)->name ?? 'Unknown' }}</p>
                    <p class="text-sm text-blue-500">
                        Department: {{ $users->find($selectedUser)->department->name ?? 'No Department' }}
                    </p>
                    <div class="mt-2 text-xs text-blue-600">
                        <p>✨ Universal QR code will automatically determine:</p>
                        <p>• Check-in for morning scans (6AM-12PM)</p>
                        <p>• Check-out for evening scans (2PM-10PM)</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- QR Code Scanner Section -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-700">Scan QR Code</h3>

                <!-- Current Time Display -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-600">Current Time:</span>
                        <span id="current-time" class="text-sm font-mono text-gray-800"></span>
                    </div>
                    <div class="mt-1">
                        <span class="text-xs text-gray-500">Scanning now will be detected as: </span>
                        <span id="current-action" class="text-xs font-medium"></span>
                    </div>
                </div>

                <!-- Scanner Container -->
                <div id="qr-scanner" class="border border-gray-300 rounded-lg overflow-hidden bg-gray-50">
                    <div id="qr-reader" style="width: 100%; height: 400px;"></div>
                </div>

                <!-- Scanner Controls -->
                <div class="flex space-x-3">
                    <button id="start-scanner"
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md transition duration-200 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-7 4h12l-2 5H9l-2-5z"></path>
                        </svg>
                        Start Scanner
                    </button>
                    <button id="stop-scanner"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition duration-200 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path>
                        </svg>
                        Stop Scanner
                    </button>
                </div>

                <!-- Scanner Result -->
                <div id="scan-result" class="hidden">
                    <div id="scan-message-container" class="px-4 py-3 rounded">
                        <p id="scan-message"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @vite('resources/js/qr-attendance.js')
    <script>
        // Update current time and action detection every second
function updateTimeAndAction() {
    const now = new Date();
    const timeElement = document.getElementById('current-time');
    const actionElement = document.getElementById('current-action');
    
    if (timeElement) {
        timeElement.textContent = now.toLocaleTimeString('en-US', { 
            hour12: false, 
            hour: '2-digit', 
            minute: '2-digit',
            second: '2-digit'
        });
    }
    
    if (actionElement) {
        const currentHour = now.getHours();
        let action = '';
        let color = '';
        
        if (currentHour >= 6 && currentHour < 12) {
            action = 'Check-in (Morning)';
            color = 'text-green-600';
        } else if (currentHour >= 14 && currentHour < 22) {
            action = 'Check-out (Evening)';
            color = 'text-blue-600';
        } else if (currentHour >= 12 && currentHour < 14) {
            action = 'Check-out (Lunch time)';
            color = 'text-orange-600';
        } else {
            action = 'Check-in (Night shift)';
            color = 'text-purple-600';
        }
        
        actionElement.textContent = action;
        actionElement.className = `text-xs font-medium ${color}`;
    }
}

// Update time immediately and then every second
updateTimeAndAction();
setInterval(updateTimeAndAction, 1000);
    </script>

</div>