// resources/js/qr-attendance.js
import QRCode from 'qrcode';
import { Html5Qrcode } from 'html5-qrcode';

class QRAttendanceSystem {
    constructor() {
        this.html5QrcodeScanner = null;
        this.currentQRCanvas = null;
        this.scannerConfig = {
            fps: 10,
            qrbox: { width: 450, height: 450 },
            aspectRatio: 1.0,
            disableFlip: false,
            videoConstraints: {
                facingMode: "environment" // Use back camera on mobile
            }
        };
        this.init();
    }

    init() {
        this.bindEvents();
        this.setupLivewireListeners();
        this.createScannerOverlay();
    }

    bindEvents() {
        // QR Code download button
        const downloadBtn = document.getElementById('download-qr');
        if (downloadBtn) {
            downloadBtn.addEventListener('click', () => this.downloadQRCode());
        }

        // Scanner control buttons
        const startBtn = document.getElementById('start-scanner');
        const stopBtn = document.getElementById('stop-scanner');
        
        if (startBtn) {
            startBtn.addEventListener('click', () => this.startScanner());
        }
        
        if (stopBtn) {
            stopBtn.addEventListener('click', () => this.stopScanner());
        }
    }

    createScannerOverlay() {
        const qrReader = document.getElementById('qr-reader');
        if (!qrReader) return;

        // Create overlay container
        const overlay = document.createElement('div');
        overlay.id = 'qr-scanner-overlay';
        overlay.style.cssText = `
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 10;
            display: none;
        `;

        // Create bounding box
        const boundingBox = document.createElement('div');
        boundingBox.id = 'qr-bounding-box';
        boundingBox.style.cssText = `
            position: absolute;
            top: 50%;
            left: 50%;
            width: 450px;
            height: 450px;
            margin-left: -225px;
            margin-top: -225px;
            border: 5px solid #00ff00;
            border-radius: 20px;
            box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.7);
            animation: pulse 2s infinite;
        `;

        // Create corner indicators
        const corners = ['top-left', 'top-right', 'bottom-left', 'bottom-right'];
        corners.forEach(corner => {
            const cornerDiv = document.createElement('div');
            cornerDiv.className = `corner-${corner}`;
            
            let cornerStyles = `
                position: absolute;
                width: 40px;
                height: 40px;
                border: 5px solid #00ff00;
                background: rgba(0, 255, 0, 0.4);
            `;

            switch(corner) {
                case 'top-left':
                    cornerStyles += `
                        top: -5px;
                        left: -5px;
                        border-right: none;
                        border-bottom: none;
                        border-radius: 20px 0 0 0;
                    `;
                    break;
                case 'top-right':
                    cornerStyles += `
                        top: -5px;
                        right: -5px;
                        border-left: none;
                        border-bottom: none;
                        border-radius: 0 20px 0 0;
                    `;
                    break;
                case 'bottom-left':
                    cornerStyles += `
                        bottom: -5px;
                        left: -5px;
                        border-right: none;
                        border-top: none;
                        border-radius: 0 0 0 20px;
                    `;
                    break;
                case 'bottom-right':
                    cornerStyles += `
                        bottom: -5px;
                        right: -5px;
                        border-left: none;
                        border-top: none;
                        border-radius: 0 0 20px 0;
                    `;
                    break;
            }

            cornerDiv.style.cssText = cornerStyles;
            boundingBox.appendChild(cornerDiv);
        });

        // Create scan line animation
        const scanLine = document.createElement('div');
        scanLine.id = 'scan-line';
        scanLine.style.cssText = `
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, transparent, #00ff00, transparent);
            animation: scan 2s linear infinite;
            box-shadow: 0 0 15px #00ff00;
        `;

        // Create instruction text
        const instructionText = document.createElement('div');
        instructionText.id = 'scan-instruction';
        instructionText.style.cssText = `
            position: absolute;
            bottom: -70px;
            left: 50%;
            transform: translateX(-50%);
            color: #00ff00;
            font-weight: bold;
            font-size: 18px;
            text-align: center;
            background: rgba(0, 0, 0, 0.9);
            padding: 15px 25px;
            border-radius: 30px;
            white-space: nowrap;
            box-shadow: 0 6px 20px rgba(0, 255, 0, 0.4);
            border: 2px solid #00ff00;
        `;
        instructionText.textContent = 'Align QR code within the frame';

        // Add CSS animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes pulse {
                0% { border-color: #00ff00; }
                50% { border-color: #00aa00; }
                100% { border-color: #00ff00; }
            }
            
            @keyframes scan {
                0% { top: 0; opacity: 1; }
                50% { opacity: 0.7; }
                100% { top: calc(100% - 4px); opacity: 1; }
            }
            
            .corner-top-left, .corner-top-right, .corner-bottom-left, .corner-bottom-right {
                animation: cornerPulse 1.5s ease-in-out infinite alternate;
            }
            
            @keyframes cornerPulse {
                0% { background: rgba(0, 255, 0, 0.2); }
                100% { background: rgba(0, 255, 0, 0.5); }
            }
        `;
        document.head.appendChild(style);

        // Assemble overlay
        boundingBox.appendChild(scanLine);
        boundingBox.appendChild(instructionText);
        overlay.appendChild(boundingBox);

        // Make qr-reader container relative for overlay positioning
        qrReader.style.position = 'relative';
        qrReader.appendChild(overlay);
    }

    showScannerOverlay() {
        const overlay = document.getElementById('qr-scanner-overlay');
        if (overlay) {
            overlay.style.display = 'block';
        }
    }

    hideScannerOverlay() {
        const overlay = document.getElementById('qr-scanner-overlay');
        if (overlay) {
            overlay.style.display = 'none';
        }
    }

    updateScanInstruction(message, color = '#00ff00') {
        const instruction = document.getElementById('scan-instruction');
        if (instruction) {
            instruction.textContent = message;
            instruction.style.color = color;
        }
    }

    setupLivewireListeners() {
        // Listen for Livewire events
        window.addEventListener('generateQRCode', (event) => {
            const qrData = event.detail[0];
            const userName = event.detail[1];
            this.generateQRCode(qrData, userName);
        });

        window.addEventListener('clearQRCode', () => {
            this.clearQRCode();
        });

        window.addEventListener('saveQRCodeAsFile', (event) => {
            this.saveQRCodeAsFile(event.detail[0]);
        });
    }

    generateQRCode(qrDataJson, userName = 'attendance') {
        const qrContainer = document.getElementById('qrcode');
        const qrContainerWrapper = document.getElementById('qrcode-container');
        
        if (!qrContainer || !qrContainerWrapper) {
            console.error('QR code container elements not found');
            return;
        }
        
        // Clear previous QR code
        qrContainer.innerHTML = '';
        
        // Generate QR code using QRCode.js with larger size and simpler design
        QRCode.toCanvas(qrDataJson, {
            width: 400,
            height: 400,
            margin: 3,
            color: {
                dark: '#000000',
                light: '#FFFFFF'
            },
            errorCorrectionLevel: 'L' // Low error correction for simpler pattern
        }, (error, canvas) => {
            if (error) {
                console.error('Error generating QR code:', error);
                this.showMessage('Error generating QR code', 'error');
                return;
            }
            
            // Add canvas to container
            qrContainer.appendChild(canvas);
            qrContainerWrapper.classList.remove('hidden');
            
            // Store canvas reference for download
            this.currentQRCanvas = canvas;
            
            // Auto-download the QR code
            this.autoDownloadQRCode(userName);
        });
    }

    clearQRCode() {
        const qrContainer = document.getElementById('qrcode');
        const qrContainerWrapper = document.getElementById('qrcode-container');
        
        if (qrContainer) qrContainer.innerHTML = '';
        if (qrContainerWrapper) qrContainerWrapper.classList.add('hidden');
        
        this.currentQRCanvas = null;
    }

    autoDownloadQRCode(userName) {
        if (!this.currentQRCanvas) {
            console.error('No QR canvas available for auto-download');
            return;
        }

        // Generate filename with current date and time
        const now = new Date();
        const dateStr = now.toISOString().split('T')[0]; // YYYY-MM-DD
        const timeStr = now.toTimeString().split(' ')[0].replace(/:/g, '-'); // HH-MM-SS
        const sanitizedUserName = userName.replace(/[^a-zA-Z0-9]/g, '_');
        
        const fileName = `QR_${sanitizedUserName}_${dateStr}_${timeStr}.png`;

        // Create and trigger download
        const link = document.createElement('a');
        link.download = fileName;
        link.href = this.currentQRCanvas.toDataURL('image/png', 1.0);
        
        // Append to body, click, then remove
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        this.showMessage(`QR code auto-downloaded as: ${fileName}`, 'success');
        console.log('QR code auto-downloaded:', fileName);
    }

    downloadQRCode() {
        if (!this.currentQRCanvas) {
            this.showMessage('No QR code to download', 'error');
            return;
        }

        // Manual download with timestamp
        const timestamp = new Date().getTime();
        const link = document.createElement('a');
        link.download = `qr-code-attendance-${timestamp}.png`;
        link.href = this.currentQRCanvas.toDataURL('image/png', 1.0);
        
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        this.showMessage('QR code downloaded successfully', 'success');
    }

    saveQRCodeAsFile(data) {
        if (!this.currentQRCanvas) {
            this.showMessage('No QR code to save', 'error');
            return;
        }
        
        // Convert canvas to blob
        this.currentQRCanvas.toBlob((blob) => {
            const formData = new FormData();
            formData.append('qr_image', blob, `user_${data.userId}_qr.png`);
            formData.append('user_id', data.userId);
            formData.append('action', data.action);
            
            // Send to server
            fetch('/api/qr-codes/save', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': this.getCSRFToken()
                },
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    this.showMessage('QR Code saved successfully', 'success');
                } else {
                    this.showMessage('Failed to save QR Code', 'error');
                }
            })
            .catch(error => {
                console.error('Error saving QR code:', error);
                this.showMessage('Failed to save QR Code', 'error');
            });
        });
    }

    // Scanner Methods
    startScanner() {
        if (this.html5QrcodeScanner) {
            this.showMessage('Scanner is already running', 'info');
            return;
        }

        this.html5QrcodeScanner = new Html5Qrcode("qr-reader");
        
        Html5Qrcode.getCameras().then(devices => {
            if (devices && devices.length) {
                // Try to use back camera first (environment), then front camera
                const backCamera = devices.find(device => 
                    device.label.toLowerCase().includes('back') || 
                    device.label.toLowerCase().includes('rear') ||
                    device.label.toLowerCase().includes('environment')
                );
                const cameraId = backCamera ? backCamera.id : devices[0].id;
                
                console.log('Using camera:', cameraId);
                
                this.html5QrcodeScanner.start(
                    cameraId,
                    this.scannerConfig,
                    (decodedText, decodedResult) => this.onScanSuccess(decodedText, decodedResult),
                    (error) => this.onScanFailure(error)
                ).then(() => {
                    this.showMessage('Scanner started successfully', 'success');
                    this.showScannerOverlay();
                    this.updateScanInstruction('Align QR code within the frame');
                }).catch(err => {
                    console.error('Error starting scanner:', err);
                    this.showMessage('Failed to start scanner', 'error');
                    this.html5QrcodeScanner = null;
                });
            } else {
                this.showMessage('No cameras found', 'error');
                this.html5QrcodeScanner = null;
            }
        }).catch(err => {
            console.error('Error getting cameras:', err);
            this.showMessage('Camera access denied or not available', 'error');
            this.html5QrcodeScanner = null;
        });
    }

    stopScanner() {
        if (this.html5QrcodeScanner) {
            this.html5QrcodeScanner.stop().then(() => {
                this.html5QrcodeScanner.clear();
                this.html5QrcodeScanner = null;
                this.hideScannerOverlay();
                this.showMessage('Scanner stopped', 'info');
            }).catch(err => {
                console.error('Error stopping scanner:', err);
                this.showMessage('Error stopping scanner', 'error');
            });
        } else {
            this.showMessage('No scanner is running', 'info');
            this.hideScannerOverlay();
        }
    }

    onScanSuccess(decodedText, decodedResult) {
        console.log('QR Code scanned:', decodedText);
        
        // Update instruction
        this.updateScanInstruction('QR Code detected! Processing...', '#ffff00');
        
        // Stop scanner after successful scan
        this.stopScanner();
        
        // Process the scanned QR code
        this.processQRCode(decodedText);
    }

    onScanFailure(error) {
        // Handle scan failure - usually ignore unless it's a critical error
        if (error && !error.includes('No QR code found') && !error.includes('QR code parse error')) {
            console.warn('QR scan error:', error);
        }
    }

    processQRCode(qrData) {
        try {
            // QR data is now a URL like: https://domain.com/api/attendance/universal?user_id=1
            const qrUrl = qrData.trim();
            
            // Check if it's a valid URL
            if (!qrUrl.includes('/api/attendance/universal') || !qrUrl.includes('user_id=')) {
                this.showMessage('Invalid QR code - not a valid attendance URL', 'error');
                return;
            }

            // Extract user ID from URL
            const urlParams = new URLSearchParams(qrUrl.split('?')[1]);
            const userId = parseInt(urlParams.get('user_id'));
            
            if (!userId || isNaN(userId)) {
                this.showMessage('Invalid QR code - no valid user ID found', 'error');
                return;
            }

            // Determine action based on current time
            const action = this.determineActionByTime();
            
            // Call attendance API with the user ID
            this.callSimpleAttendanceAPI(userId, action);
            
        } catch (error) {
            console.error('Error processing QR code:', error);
            this.showMessage('Invalid QR code format', 'error');
        }
    }

    determineActionByTime() {
        const now = new Date();
        const currentHour = now.getHours();
        
        // Define time ranges (you can adjust these)
        const morningStart = 6;   // 6:00 AM
        const morningEnd = 12;    // 12:00 PM (noon)
        const eveningStart = 14;  // 2:00 PM
        const eveningEnd = 22;    // 10:00 PM
        
        if (currentHour >= morningStart && currentHour < morningEnd) {
            return 'check-in';
        } else if (currentHour >= eveningStart && currentHour < eveningEnd) {
            return 'check-out';
        } else if (currentHour >= morningEnd && currentHour < eveningStart) {
            // Lunch time - could be either, check if user already checked in today
            return 'check-out'; // Default to check-out during lunch
        } else {
            // Late night/early morning - could be night shift
            return 'check-in'; // Default to check-in for night shifts
        }
    }

    getTimeBasedMessage(action) {
        const now = new Date();
        const timeStr = now.toLocaleTimeString('en-US', { 
            hour12: false, 
            hour: '2-digit', 
            minute: '2-digit' 
        });
        
        if (action === 'check-in') {
            return `Good morning! Check-in at ${timeStr}`;
        } else {
            return `Good evening! Check-out at ${timeStr}`;
        }
    }

    validateQRHash(data) {
        // Basic timestamp validation (QR code should be used within 10 minutes)
        const currentTime = Math.floor(Date.now() / 1000);
        const qrTime = data.timestamp;
        const timeDiff = currentTime - qrTime;
        
        // Allow 10 minutes (600 seconds) tolerance
        if (timeDiff > 600) {
            console.warn('QR code is too old');
            return false;
        }
        
        return true;
    }

    async callSimpleAttendanceAPI(userId, action) {
        try {
            this.showMessage('Processing attendance...', 'info');
            
            // Get user's location if geolocation is available
            const location = await this.getCurrentLocation();
            
            // Use the universal endpoint with POST method
            const endpoint = '/api/attendance/universal';
            
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.getCSRFToken()
                },
                body: JSON.stringify({
                    user_id: userId,
                    latitude: location.latitude,
                    longitude: location.longitude,
                    device_type: 'web_qr'
                })
            });

            // Check if response is ok
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            // Check if response is JSON
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                throw new Error('Response is not JSON');
            }

            const result = await response.json();
            
            if (result.success) {
                // Show time-based success message
                const timeBasedMessage = this.getTimeBasedMessage(action);
                this.showMessage(timeBasedMessage, 'success');
                
                // Show additional info if available
                if (result.data) {
                    setTimeout(() => {
                        this.showAttendanceDetails(result.data, action);
                    }, 2000);
                }
            } else {
                this.showMessage(result.message || 'Failed to process attendance', 'error');
            }
            
        } catch (error) {
            console.error('API call error:', error);
            
            // More specific error messages
            if (error.message.includes('404')) {
                this.showMessage('API endpoint not found. Please check your routes.', 'error');
            } else if (error.message.includes('not JSON')) {
                this.showMessage('Server returned HTML instead of JSON. Check API endpoint.', 'error');
            } else if (error.message.includes('Failed to fetch')) {
                this.showMessage('Network error. Please check your connection.', 'error');
            } else {
                this.showMessage('Failed to process attendance - ' + error.message, 'error');
            }
        }
    }

    async getCurrentLocation() {
        return new Promise((resolve) => {
            if (!navigator.geolocation) {
                console.warn('Geolocation is not supported');
                resolve({ latitude: null, longitude: null });
                return;
            }

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    resolve({
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude
                    });
                },
                (error) => {
                    console.warn('Geolocation error:', error);
                    resolve({ latitude: null, longitude: null });
                },
                {
                    timeout: 5000,
                    enableHighAccuracy: false
                }
            );
        });
    }

    showMessage(message, type) {
        const resultDiv = document.getElementById('scan-result');
        const messageContainer = document.getElementById('scan-message-container');
        const messageP = document.getElementById('scan-message');
        
        if (!resultDiv || !messageContainer || !messageP) {
            console.error('Message display elements not found');
            return;
        }
        
        messageP.textContent = message;
        
        // Set appropriate styling based on type
        messageContainer.className = 'px-4 py-3 rounded ';
        switch(type) {
            case 'success':
                messageContainer.className += 'bg-green-100 border border-green-400 text-green-700';
                break;
            case 'error':
                messageContainer.className += 'bg-red-100 border border-red-400 text-red-700';
                break;
            case 'info':
                messageContainer.className += 'bg-blue-100 border border-blue-400 text-blue-700';
                break;
            case 'warning':
                messageContainer.className += 'bg-yellow-100 border border-yellow-400 text-yellow-700';
                break;
            default:
                messageContainer.className += 'bg-gray-100 border border-gray-400 text-gray-700';
        }
        
        resultDiv.classList.remove('hidden');
        
        // Auto-hide after specified time (except for info messages)
        if (type !== 'info') {
            const hideTime = type === 'success' ? 3000 : 5000;
            setTimeout(() => {
                resultDiv.classList.add('hidden');
            }, hideTime);
        }
    }

    showAttendanceDetails(data, action) {
        const actionText = action === 'check-in' ? 'Check-in' : 'Check-out';
        let detailMessage = `${actionText} Time: ${data.check_in_time || data.check_out_time}`;
        
        if (data.working_hours && action === 'check-out') {
            detailMessage += ` | Total Working Hours: ${data.working_hours}h`;
        }
        
        if (data.user && data.user !== 'Unknown') {
            detailMessage = `${data.user} - ${detailMessage}`;
        }
        
        this.showMessage(detailMessage, 'info');
    }

    getCSRFToken() {
        const token = document.querySelector('meta[name="csrf-token"]');
        return token ? token.getAttribute('content') : '';
    }

    // Utility method to reinitialize if needed
    reinitialize() {
        this.stopScanner();
        this.clearQRCode();
        this.init();
    }

    // Cleanup method
    destroy() {
        this.stopScanner();
        this.clearQRCode();
        
        // Remove event listeners if needed
        window.removeEventListener('generateQRCode', this.generateQRCode);
        window.removeEventListener('clearQRCode', this.clearQRCode);
        window.removeEventListener('saveQRCodeAsFile', this.saveQRCodeAsFile);
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Only initialize if we're on the QR attendance page
    if (document.getElementById('qrcode-container')) {
        console.log('Starting QR Code scanner...');
        window.qrAttendanceSystem = new QRAttendanceSystem();
    }
});

// Export for module use if needed
if (typeof module !== 'undefined' && module.exports) {
    module.exports = QRAttendanceSystem;
}