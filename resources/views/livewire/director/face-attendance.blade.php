<div class="bg-white shadow-lg rounded-lg overflow-hidden">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Header --}}
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
        <h2 class="text-xl font-semibold text-white">Face Recognition Attendance</h2>
        <p class="text-blue-100 text-sm mt-1">Position your face in the camera view for attendance verification</p>
    </div>

    {{-- Camera Section --}}
    <div class="p-6">
        {{-- Camera Container --}}
        <div class="relative bg-black rounded-lg overflow-hidden mb-6">
            {{-- Video Element with increased height --}}
            <video id="video" class="w-full h-[600px] object-cover" autoplay muted playsinline>
            </video>

            {{-- Overlay Canvas for Face Detection --}}
            <canvas id="overlay" class="absolute top-0 left-0 w-full h-full pointer-events-none">
            </canvas>

            {{-- Camera Status Indicator --}}
            <div id="camera-status" class="absolute top-4 left-4 hidden">
                <div class="flex items-center space-x-2 bg-black bg-opacity-50 text-white px-3 py-2 rounded-lg">
                    <div class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></div>
                    <span class="text-sm">Camera Active</span>
                </div>
            </div>

            {{-- Loading Indicator --}}
            <div id="loading-indicator"
                class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-75">
                <div class="text-center text-white">
                    <div
                        class="inline-block w-8 h-8 border-4 border-white border-t-transparent rounded-full animate-spin mb-4">
                    </div>
                    <p id="loading-text" class="text-sm">Initializing System...</p>
                </div>
            </div>


            {{-- No Camera Message --}}
            <div id="no-camera" class="absolute inset-0 flex items-center justify-center bg-gray-800 text-white hidden">
                <div class="text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                        </path>
                    </svg>
                    <h3 class="text-lg font-semibold mb-2">Camera Not Available</h3>
                    <p class="text-sm text-gray-300">Please allow camera access or check your camera connection</p>
                </div>
            </div>

            {{-- Face Detection Status --}}
            <div id="face-status" class="absolute top-4 right-4 hidden">
                <div class="bg-green-500 bg-opacity-90 text-white px-3 py-2 rounded-lg text-sm font-medium">
                    <span id="face-status-text">Face Detected</span>
                </div>
            </div>

            <div id="auto-checkin-status" class="absolute bottom-4 left-4 hidden">
                <div class="bg-blue-600 bg-opacity-90 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                        <span id="auto-checkin-text">Auto Check-in Active</span>
                    </div>
                </div>
            </div>

            {{-- Add this after the Face Enrollment Section (around line 130): --}}

            {{-- Today's Check-ins Display --}}
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <h4 class="font-semibold text-green-900 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Today's Check-ins
                </h4>
                <div id="todays-checkins" class="space-y-2">
                    <p class="text-green-700 text-sm">No check-ins recorded yet today.</p>
                </div>
            </div>

            {{-- Center Guide for Face Positioning --}}
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                <div class="border-2 border-white border-dashed rounded-full w-64 h-80 opacity-30"></div>
            </div>
        </div>

        {{-- Control Buttons --}}
        <div class="flex justify-center space-x-4 mb-6">
            <button id="start-camera"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center space-x-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                    </path>
                </svg>
                <span>Start Camera</span>
            </button>

            <button id="stop-camera"
                class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg flex items-center space-x-2 transition-colors hidden">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path>
                </svg>
                <span>Stop Camera</span>
            </button>

            <button id="capture-attendance"
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg flex items-center space-x-2 transition-colors hidden">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>Capture Attendance</span>
            </button>
        </div>

        {{-- Face Enrollment Section --}}
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
            <h4 class="font-semibold text-yellow-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Face Enrollment
            </h4>
            <p class="text-yellow-800 text-sm mb-4">Save your face for future attendance recognition</p>

            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <label for="username" class="block text-sm font-medium text-yellow-900 mb-2">Username</label>
                    <input type="text" id="username" placeholder="Enter your username"
                        class="w-full px-4 py-2 border border-yellow-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                </div>
                <div class="flex items-end">
                    <button id="save-face"
                        class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-2 rounded-lg flex items-center space-x-2 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                            </path>
                        </svg>
                        <span>Save Face</span>
                    </button>
                </div>
            </div>

            {{-- Save Status --}}
            <div id="save-status" class="mt-4 hidden">
                <div class="flex items-center space-x-2 text-green-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span id="save-message">Face saved successfully!</span>
                </div>
            </div>
        </div>

        {{-- Instructions --}}
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h4 class="font-semibold text-blue-900 mb-2">Instructions:</h4>
            <ul class="text-sm text-blue-800 space-y-1">
                <li class="flex items-start space-x-2">
                    <span class="w-2 h-2 bg-blue-500 rounded-full mt-1.5 flex-shrink-0"></span>
                    <span>Click "Start Camera" to begin face recognition</span>
                </li>
                <li class="flex items-start space-x-2">
                    <span class="w-2 h-2 bg-blue-500 rounded-full mt-1.5 flex-shrink-0"></span>
                    <span>Position your face clearly within the dashed circle guide</span>
                </li>
                <li class="flex items-start space-x-2">
                    <span class="w-2 h-2 bg-blue-500 rounded-full mt-1.5 flex-shrink-0"></span>
                    <span>Face detection will automatically identify and verify your identity</span>
                </li>
                <li class="flex items-start space-x-2">
                    <span class="w-2 h-2 bg-blue-500 rounded-full mt-1.5 flex-shrink-0"></span>
                    <span>Ensure good lighting for best results</span>
                </li>
                <li class="flex items-start space-x-2">
                    <span class="w-2 h-2 bg-blue-500 rounded-full mt-1.5 flex-shrink-0"></span>
                    <span>Click "Capture Attendance" when your face is detected</span>
                </li>
            </ul>
        </div>
    </div>



    <script>
        // Initialize when component loads
        document.addEventListener('DOMContentLoaded', function() {
            // Wait for the FaceAttendanceSystem to be available
            if (typeof window.FaceAttendanceSystem !== 'undefined') {
                initializeFaceAttendance();
            } else {
                // Wait a bit for the module to load
                setTimeout(() => {
                    if (typeof window.FaceAttendanceSystem !== 'undefined') {
                        initializeFaceAttendance();
                    } else {
                        console.error('FaceAttendanceSystem not loaded');
                    }
                }, 1000);
            }
        });
        
        function initializeFaceAttendance() {
            // Initialize the face attendance system
            const faceAttendance = new window.FaceAttendanceSystem();
            
            // Set up button event listeners
            const startButton = document.getElementById('start-camera');
            const stopButton = document.getElementById('stop-camera');
            const captureButton = document.getElementById('capture-attendance');
            const saveFaceButton = document.getElementById('save-face');
            const usernameInput = document.getElementById('username');
            const faceStatus = document.getElementById('face-status');
            const saveStatus = document.getElementById('save-status');
            const saveMessage = document.getElementById('save-message');

            const loadingIndicator = document.getElementById('loading-indicator');
            const loadingText = loadingIndicator.querySelector('p');

            loadingIndicator.classList.remove('hidden');
            
            // Track if face is currently detected
            let faceDetected = false;

            loadTodaysCheckins();

            // Disable start button initially and show loading state
            startButton.disabled = true;
            startButton.querySelector('span').textContent = '⏳ Initializing...';

            document.addEventListener('initializationProgress', (event) => {
                const { message, type, isInitialized } = event.detail;
                console.log(`📊 ${message}`);
                
                const buttonText = startButton.querySelector('span');
                
                // Update loading indicator text
                if (type === 'error') {
                    loadingText.textContent = '❌ ' + message;
                    loadingText.className = 'text-sm text-red-300';
                    // Hide loading indicator after 3 seconds on error
                    setTimeout(() => {
                        loadingIndicator.classList.add('hidden');
                    }, 3000);
                    
                    startButton.disabled = true;
                    buttonText.textContent = '❌ Failed to Initialize';
                    startButton.classList.add('opacity-50', 'cursor-not-allowed');
                    startButton.classList.remove('hover:bg-blue-700');
                } else if (isInitialized) {
                    loadingText.textContent = '✅ System Ready!';
                    loadingText.className = 'text-sm text-green-300';
                    
                    // Hide loading indicator after showing success
                    setTimeout(() => {
                        loadingIndicator.classList.add('hidden');
                    }, 1500);
                    
                    startButton.disabled = false;
                    buttonText.textContent = 'Start Camera';
                    startButton.classList.remove('opacity-50', 'cursor-not-allowed');
                    startButton.classList.add('hover:bg-blue-700');
                    console.log('🎉 System ready! You can now start the camera.');
                } else {
                    loadingText.textContent = message;
                    loadingText.className = 'text-sm text-white';
                    buttonText.textContent = `⏳ ${message}`;
                    startButton.disabled = true;
                }
            });
            
            startButton.addEventListener('click', async () => {
                startButton.classList.add('hidden');
                loadingIndicator.classList.remove('hidden');
                loadingText.textContent = 'Starting Camera...';
                loadingText.className = 'text-sm text-white';
                
                try {
                    await faceAttendance.startCamera();
                    loadingIndicator.classList.add('hidden');
                    document.getElementById('camera-status').classList.remove('hidden');
                    stopButton.classList.remove('hidden');
                    captureButton.classList.remove('hidden');
                    updateSaveFaceButton();
                } catch (error) {
                    console.error('Error starting camera:', error);
                    loadingText.textContent = '❌ Camera access denied or unavailable';
                    loadingText.className = 'text-sm text-red-300';
                    
                    // Show error for 3 seconds, then hide and show start button
                    setTimeout(() => {
                        loadingIndicator.classList.add('hidden');
                        document.getElementById('no-camera').classList.remove('hidden');
                        startButton.classList.remove('hidden');
                    }, 3000);
                }
                setTimeout(() => {
                    const autoCheckinStatus = document.getElementById('auto-checkin-status');
                    const autoCheckinText = document.getElementById('auto-checkin-text');
                    
                    autoCheckinStatus.classList.remove('hidden');
                    autoCheckinText.textContent = 'Auto Check-in Active - Show your face to check in';
                    autoCheckinStatus.querySelector('div').className = 'bg-blue-600 bg-opacity-90 text-white px-4 py-2 rounded-lg text-sm font-medium';
                }, 1000);
            });

            
            stopButton.addEventListener('click', () => {
                faceAttendance.stopCamera();
                document.getElementById('camera-status').classList.add('hidden');
                faceStatus.classList.add('hidden');
                startButton.classList.remove('hidden');
                stopButton.classList.add('hidden');
                captureButton.classList.add('hidden');
                faceDetected = false;
                updateSaveFaceButton();
            });

            captureButton.addEventListener('click', () => {
                faceAttendance.captureAttendance();
            });

            // Save face functionality
            saveFaceButton.addEventListener('click', async () => {
                const username = usernameInput.value.trim();
                
                if (!username) {
                    alert('Please enter a username');
                    usernameInput.focus();
                    return;
                }
                
                if (!faceDetected) {
                    alert('No face detected. Please position your face in the camera view.');
                    return;
                }

                // Disable button during save
                saveFaceButton.disabled = true;
                saveFaceButton.innerHTML = `
                `;

                try {
                    await faceAttendance.saveFaceImage(username);
                    
                    // Refresh reference faces for recognition
                    await faceAttendance.refreshReferenceFaces();
                    
                    // Show success message
                    saveMessage.textContent = `Face saved successfully for ${username}!`;
                    saveStatus.classList.remove('hidden');
                    
                    // Clear username input
                    usernameInput.value = '';
                    
                    // Hide success message after 3 seconds
                    setTimeout(() => {
                        saveStatus.classList.add('hidden');
                    }, 3000);
                    
                } catch (error) {
                    console.error('Error saving face:', error);
                    alert('Failed to save face. Please try again.');
                } finally {
                    // Re-enable button
                    saveFaceButton.disabled = false;
                    saveFaceButton.innerHTML = `
                    `;
                    updateSaveFaceButton();
                }
            });

            document.addEventListener('initializationProgress', (event) => {
                const { message, type, isInitialized } = event.detail;
                console.log(`📊 ${message}`);
                
                const buttonText = startButton.querySelector('span');
                const buttonIcon = startButton.querySelector('svg, div');
                
                if (type === 'error') {
                    startButton.disabled = true;
                    buttonText.textContent = 'Initialization Failed';
                    if (buttonIcon) {
                        buttonIcon.outerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>`;
                    }
                    startButton.className = "bg-red-600 text-white px-6 py-3 rounded-lg flex items-center space-x-2 cursor-not-allowed opacity-50";
                } else if (isInitialized) {
                    // Enable the start button when initialization is complete
                    startButton.disabled = false;
                    buttonText.textContent = 'Start Camera';
                    if (buttonIcon) {
                        buttonIcon.outerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>`;
                    }
                    startButton.className = "bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center space-x-2 transition-colors";
                    console.log('🎉 System ready! You can now start the camera.');
                } else {
                    // Show progress message
                    buttonText.textContent = message;
                    if (buttonIcon) {
                        buttonIcon.outerHTML = '<div class="inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>';
                    }
                }
            });

            // Enable/disable save face button based on conditions
            function updateSaveFaceButton() {
                const username = usernameInput.value.trim();
                const canSave = faceDetected && username.length > 0;
                saveFaceButton.disabled = !canSave;
            }

            // Listen for username input changes
            usernameInput.addEventListener('input', updateSaveFaceButton);
            
            // Listen for face detection events
            document.addEventListener('faceDetected', (event) => {
                faceDetected = true;
                faceStatus.classList.remove('hidden');
                
                const { confidence, recognition } = event.detail;
                let statusText = `Face Detected (${confidence}% confidence)`;
                
                if (recognition) {
                    if (recognition.isKnown) {
                        statusText = `${recognition.label} (${recognition.confidence}% match)`;
                        faceStatus.querySelector('div').className = 'bg-green-500 bg-opacity-90 text-white px-3 py-2 rounded-lg text-sm font-medium';
                    } else {
                        statusText = `Unknown Person (${confidence}% detected)`;
                        faceStatus.querySelector('div').className = 'bg-red-500 bg-opacity-90 text-white px-3 py-2 rounded-lg text-sm font-medium';
                    }
                }
                
                document.getElementById('face-status-text').textContent = statusText;
                updateSaveFaceButton();
            });

            document.addEventListener('faceNotDetected', () => {
                faceDetected = false;
                faceStatus.classList.add('hidden');
                updateSaveFaceButton();
            });
            
            // Cleanup when component is destroyed
            document.addEventListener('livewire:navigating', () => {
                faceAttendance.stopCamera();
            });
            
            // Make faceAttendance available globally for debugging
            window.faceAttendance = faceAttendance;
        }

    document.addEventListener('automaticCheckIn', (event) => {
        const { username, confidence, timestamp, result } = event.detail;
        console.log(`🎉 Automatic check-in completed for ${username}!`);
        
        // Update today's check-ins display
        updateTodaysCheckinsDisplay(username, timestamp, confidence);
        
        // Show success status
        const autoCheckinStatus = document.getElementById('auto-checkin-status');
        const autoCheckinText = document.getElementById('auto-checkin-text');
        
        autoCheckinStatus.classList.remove('hidden');
        autoCheckinText.textContent = `✅ ${username} checked in automatically!`;
        autoCheckinStatus.querySelector('div').className = 'bg-green-600 bg-opacity-90 text-white px-4 py-2 rounded-lg text-sm font-medium';
        
        // Hide after 5 seconds
        setTimeout(() => {
            autoCheckinStatus.classList.add('hidden');
        }, 5000);
    });


    function updateTodaysCheckinsDisplay(username, timestamp, confidence) {
        const container = document.getElementById('todays-checkins');
        const time = new Date(timestamp).toLocaleTimeString();
        
 
        
        // Remove "no check-ins" message if it exists
        const noCheckinsMsg = container.querySelector('p');
        if (noCheckinsMsg && noCheckinsMsg.textContent.includes('No check-ins')) {
            noCheckinsMsg.remove();
        }
        
        // Add new entry at the top
        container.insertBefore(entry, container.firstChild);
    }

    async function loadTodaysCheckins() {
    try {
        const today = new Date().toISOString().split('T')[0];
        const response = await fetch(`/api/attendance/today?date=${today}`);
        
        if (response.ok) {
            const data = await response.json();
            if (data.success && data.attendances && data.attendances.length > 0) {
                const container = document.getElementById('todays-checkins');
                container.innerHTML = ''; // Clear existing content
                
                data.attendances.forEach(attendance => {
                    const time = new Date(attendance.check_in || attendance.created_at).toLocaleTimeString();
                    updateTodaysCheckinsDisplay(
                        attendance.user_name || attendance.username, 
                        attendance.check_in || attendance.created_at,
                        attendance.confidence || 'N/A'
                    );
                });
            }
        }
    } catch (error) {
        console.warn('Could not load today\'s check-ins:', error);
    }
    }
    </script>
</div>