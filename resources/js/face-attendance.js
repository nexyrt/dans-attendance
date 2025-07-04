

// Import face-api.js from node_modules
import * as faceapi from 'face-api.js';

class FaceAttendanceSystem {
    constructor() {
        this.video = null;
        this.canvas = null;
        this.isModelLoaded = false;
        this.isDetecting = false;
        this.detectionInterval = null;
        this.currentStream = null;
        this.isInitialized = false;
        // Face recognition settings
        this.faceDetectionOptions = new faceapi.SsdMobilenetv1Options({
            minConfidence: 0.6, // Increased confidence for better accuracy
            maxResults: 1 // Only detect one face at a time
        });

        // Face recognition data
        this.faceMatcher = null;
        this.referenceFaces = [];
        this.isRecognitionReady = false;

        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.init());
        } else {
            this.init();
        }
    }

    /**
     * Initialize the face attendance system
     */
    async init() {
        try {
            console.log('🚀 Initializing Face Attendance System...');
            this.updateInitializationStatus('Initializing Face Attendance System...');

            // Get DOM elements
            this.video = document.getElementById('video');
            this.canvas = document.getElementById('overlay');

            if (!this.video || !this.canvas) {
                console.error('❌ Required DOM elements not found');
                this.updateInitializationStatus('Error: Required DOM elements not found', 'error');
                return;
            }

            console.log('✅ DOM elements found');
            this.updateInitializationStatus('DOM elements found');

            // Load face-api.js models
            await this.loadModels();

            this.isInitialized = true;
            console.log('🎉 Face Attendance System initialized successfully');
            this.updateInitializationStatus('Face Attendance System initialized successfully', 'success');

        } catch (error) {
            console.error('❌ Failed to initialize Face Attendance System:', error);
            this.updateInitializationStatus('Failed to initialize: ' + error.message, 'error');
        }
    }

    /**
     * Load face-api.js models
     */
    async loadModels() {
        console.log('📦 Loading face-api.js models...');
        this.updateInitializationStatus('Loading face-api.js models...');

        try {
            // Define model path (adjust according to your Laravel public path)
            const MODEL_URL = '/models'; // You'll need to place models in public/models

            // Try to load face detection and recognition models
            try {
                console.log('⏳ Loading detection models...');
                this.updateInitializationStatus('Loading face detection models...');

                await Promise.all([
                    faceapi.nets.ssdMobilenetv1.loadFromUri(MODEL_URL),
                    faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL),
                    faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL)
                ]);

                console.log('✅ Face detection and recognition models loaded successfully');
                this.updateInitializationStatus('Face detection models loaded');

                // Load reference faces for recognition
                console.log('👥 Loading reference faces...');
                this.updateInitializationStatus('Loading reference faces...');
                await this.loadReferenceFaces();

            } catch (recognitionError) {
                console.warn('⚠️ Failed to load recognition models, falling back to detection only:', recognitionError.message);
                this.updateInitializationStatus('Loading basic face detection...');

                // Fallback to detection only
                await faceapi.nets.ssdMobilenetv1.loadFromUri(MODEL_URL);
                console.log('✅ Face detection model loaded (recognition disabled)');
                this.updateInitializationStatus('Face detection loaded (recognition disabled)');
                this.isRecognitionReady = false;
            }

            this.isModelLoaded = true;

            // Show success message
            const message = this.isRecognitionReady ?
                'Face recognition system ready!' :
                'Face detection ready (recognition disabled)';

            console.log('🎯 ' + message);
            this.updateInitializationStatus(message);

        } catch (error) {
            console.error('❌ Error loading models:', error);
            this.updateInitializationStatus('Error loading models: ' + error.message, 'error');
            this.showMessage('Error loading face detection models. Please check if model files are available.', 'error');
        }
    }

    updateInitializationStatus(message, type = 'info') {
        // Dispatch custom event for UI updates
        document.dispatchEvent(new CustomEvent('initializationProgress', {
            detail: {
                message: message,
                type: type,
                isInitialized: this.isInitialized
            }
        }));
    }
    /**
     * Start camera and face detection
     */
    async startCamera() {
        if (!this.isModelLoaded) {
            this.showMessage('Please wait for models to load first.', 'warning');
            return;
        }

        try {
            // Camera constraints
            const constraints = {
                video: {
                    width: { ideal: 1280 },
                    height: { ideal: 720 },
                    facingMode: 'user'
                }
            };

            // Get user media
            this.currentStream = await navigator.mediaDevices.getUserMedia(constraints);
            this.video.srcObject = this.currentStream;

            // Wait for video to load
            return new Promise((resolve) => {
                this.video.addEventListener('loadedmetadata', () => {
                    // Match canvas dimensions to video
                    this.canvas.width = this.video.videoWidth;
                    this.canvas.height = this.video.videoHeight;

                    // Start face detection
                    this.startFaceDetection();
                    resolve();
                });
            });

        } catch (error) {
            console.error('Error starting camera:', error);
            this.showMessage('Unable to access camera. Please grant camera permissions.', 'error');
        }
    }

    /**
     * Stop camera and face detection
     */
    stopCamera() {
        // Stop face detection
        this.stopFaceDetection();

        // Stop camera stream
        if (this.currentStream) {
            this.currentStream.getTracks().forEach(track => track.stop());
            this.currentStream = null;
            this.video.srcObject = null;
        }

        // Clear canvas
        const ctx = this.canvas.getContext('2d');
        ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

        console.log('Camera stopped');
    }

    /**
     * Start face detection loop
     */
    startFaceDetection() {
        if (this.isDetecting) return;

        this.isDetecting = true;
        console.log('Starting face detection...');

        const detectFaces = async () => {
            if (!this.isDetecting || !this.video.videoWidth) return;

            try {
                // Detect faces with landmarks and descriptors for recognition
                const detections = await faceapi
                    .detectAllFaces(this.video, this.faceDetectionOptions)
                    .withFaceLandmarks()
                    .withFaceDescriptors();

                // Clear previous drawings
                const ctx = this.canvas.getContext('2d');
                ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

                if (detections.length > 0) {
                    // Get only the first (best) detection
                    const detection = detections[0];

                    // Check if detection has the expected structure
                    if (!detection.detection) {
                        console.error('Invalid detection object structure:', detection);
                        return;
                    }

                    // Perform face recognition (with error handling)
                    let recognitionResult = null;
                    try {
                        recognitionResult = this.recognizeFace(detection);
                    } catch (recognitionError) {
                        console.warn('Face recognition error:', recognitionError.message);
                        // Continue with basic face detection if recognition fails
                        recognitionResult = {
                            label: 'Unknown',
                            confidence: 0,
                            distance: 1,
                            isKnown: false
                        };
                    }

                    // Resize detection to match display size
                    const resizedDetection = faceapi.resizeResults([detection], {
                        width: this.canvas.width,
                        height: this.canvas.height
                    })[0];

                    // Draw face detection box with recognition label
                    this.drawDetection(resizedDetection, recognitionResult);

                    // Process face for attendance
                    this.processFaceForAttendance(detection, recognitionResult);

                    // Dispatch face detected event
                    document.dispatchEvent(new CustomEvent('faceDetected', {
                        detail: {
                            confidence: Math.round(detection.detection.score * 100),
                            recognition: recognitionResult
                        }
                    }));
                } else {
                    // Dispatch face not detected event
                    document.dispatchEvent(new CustomEvent('faceNotDetected'));
                }

            } catch (error) {
                console.error('Error in face detection:', error.message);
                // Don't break the detection loop - just log the error
            }
        };

        // Run detection every 200ms for better performance
        this.detectionInterval = setInterval(detectFaces, 200);
    }

    /**
     * Stop face detection loop
     */
    stopFaceDetection() {
        this.isDetecting = false;

        if (this.detectionInterval) {
            clearInterval(this.detectionInterval);
            this.detectionInterval = null;
        }

        console.log('Face detection stopped');
    }

    /**
     * Load reference faces for recognition
     */
    async loadReferenceFaces() {
        try {
            console.log('Loading reference faces...');

            // Fetch enrolled faces from API
            const response = await fetch('/api/face-enrollment');
            if (!response.ok) {
                console.warn('Failed to fetch reference faces, recognition will be disabled');
                this.isRecognitionReady = false;
                return;
            }

            const data = await response.json();
            if (!data.success) {
                console.warn('API returned error:', data.message || 'Failed to load reference faces');
                this.isRecognitionReady = false;
                return;
            }

            const enrolledFaces = data.data || [];
            console.log('Found enrolled faces:', enrolledFaces.length, 'users');

            if (enrolledFaces.length === 0) {
                console.log('No enrolled faces found, recognition will show all faces as unknown');
                this.isRecognitionReady = false;
                return;
            }

            // Load face descriptors for each enrolled face
            const labeledDescriptors = [];

            for (const user of enrolledFaces) {
                const username = user.username;
                const faces = user.faces || [];

                console.log(`Loading ${faces.length} faces for ${username}`);

                const descriptors = [];

                for (const face of faces) {
                    try {
                        const descriptor = await this.loadFaceDescriptor(face.url);
                        if (descriptor) {
                            descriptors.push(descriptor);
                        }
                    } catch (error) {
                        console.warn(`Failed to load descriptor for ${face.filename}:`, error.message);
                        // Continue with other faces
                    }
                }

                if (descriptors.length > 0) {
                    labeledDescriptors.push(
                        new faceapi.LabeledFaceDescriptors(username, descriptors)
                    );
                    console.log(`Loaded ${descriptors.length} descriptors for ${username}`);
                } else {
                    console.warn(`No valid descriptors found for ${username}`);
                }
            }

            if (labeledDescriptors.length > 0) {
                // Create face matcher with threshold for recognition
                this.faceMatcher = new faceapi.FaceMatcher(labeledDescriptors, 0.6); // Adjusted threshold
                this.isRecognitionReady = true;
                console.log(`Face recognition ready with ${labeledDescriptors.length} users`);
            } else {
                console.warn('No valid face descriptors loaded. Recognition will show all faces as unknown.');
                this.isRecognitionReady = false;
            }

        } catch (error) {
            console.error('Error loading reference faces:', error.message);
            this.isRecognitionReady = false;
            // Don't throw error - let the system continue with basic face detection
        }
    }

    /**
     * Load face descriptor from image URL
     */
    async loadFaceDescriptor(imageUrl) {
        try {
            // Create image element with crossOrigin attribute
            const img = new Image();
            img.crossOrigin = 'anonymous';

            // Load image as a promise
            const loadImage = new Promise((resolve, reject) => {
                img.onload = () => resolve(img);
                img.onerror = () => reject(new Error(`Failed to load image: ${imageUrl}`));
                img.src = imageUrl;
            });

            const loadedImg = await loadImage;

            // Detect face and get descriptor
            const detection = await faceapi
                .detectSingleFace(loadedImg)
                .withFaceLandmarks()
                .withFaceDescriptor();

            if (detection && detection.descriptor) {
                return detection.descriptor;
            }

            console.warn('No face detected in reference image:', imageUrl);
            return null;

        } catch (error) {
            console.warn('Failed to load face descriptor from:', imageUrl, error.message);
            return null;
        }
    }

    /**
     * Recognize face using face matcher
     */
    recognizeFace(detection) {
        if (!this.isRecognitionReady || !this.faceMatcher || !detection.descriptor) {
            return {
                label: 'Unknown',
                confidence: 0,
                distance: 1
            };
        }

        try {
            // Find best match
            const bestMatch = this.faceMatcher.findBestMatch(detection.descriptor);

            // Determine if it's a known face or unknown
            const isKnown = bestMatch.label !== 'unknown';
            const confidence = Math.round((1 - bestMatch.distance) * 100);

            return {
                label: isKnown ? bestMatch.label : 'Unknown',
                confidence: confidence,
                distance: bestMatch.distance,
                isKnown: isKnown
            };

        } catch (error) {
            console.error('Error in face recognition:', error);
            return {
                label: 'Unknown',
                confidence: 0,
                distance: 1
            };
        }
    }
    /**
     * Draw single face detection result on canvas with recognition label
     */
    drawDetection(detection, recognitionResult = null) {
        const ctx = this.canvas.getContext('2d');

        // Handle different detection object structures
        let box, score;

        if (detection.detection) {
            // Detection with landmarks/descriptors
            box = detection.detection.box;
            score = detection.detection.score;
        } else if (detection.box) {
            // Direct detection object
            box = detection.box;
            score = detection.score;
        } else {
            console.error('Unknown detection object structure:', detection);
            return;
        }

        const { x, y, width, height } = box;

        // Determine colors based on recognition result
        let boxColor = '#10b981'; // Default green
        let textBgColor = '#10b981';
        let label = `${Math.round(score * 100)}%`;

        if (recognitionResult) {
            if (recognitionResult.isKnown) {
                // Known face - green
                boxColor = '#10b981';
                textBgColor = '#10b981';
                label = `${recognitionResult.label} (${recognitionResult.confidence}%)`;
            } else {
                // Unknown face - red
                boxColor = '#ef4444';
                textBgColor = '#ef4444';
                label = `Unknown (${Math.round(score * 100)}%)`;
            }
        }

        // Draw face bounding box with rounded corners
        ctx.strokeStyle = boxColor;
        ctx.lineWidth = 3;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';

        // Draw rounded rectangle
        const radius = 10;
        ctx.beginPath();
        ctx.moveTo(x + radius, y);
        ctx.lineTo(x + width - radius, y);
        ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
        ctx.lineTo(x + width, y + height - radius);
        ctx.quadraticCurveTo(x + width, y + height, x + width - radius, y + height);
        ctx.lineTo(x + radius, y + height);
        ctx.quadraticCurveTo(x, y + height, x, y + height - radius);
        ctx.lineTo(x, y + radius);
        ctx.quadraticCurveTo(x, y, x + radius, y);
        ctx.closePath();
        ctx.stroke();

        // Draw label with background
        ctx.font = 'bold 14px Arial';
        const textMetrics = ctx.measureText(label);
        const textWidth = textMetrics.width;
        const textHeight = 18;
        const padding = 8;

        // Calculate label position (above the box if possible, otherwise below)
        let labelY = y - textHeight - padding;
        if (labelY < 0) {
            labelY = y + height + textHeight + padding;
        }

        // Background for text
        ctx.fillStyle = textBgColor;
        ctx.fillRect(x, labelY - textHeight - padding / 2, textWidth + padding, textHeight + padding);

        // Text
        ctx.fillStyle = 'white';
        ctx.fillText(label, x + padding / 2, labelY - padding / 2);

        // Add additional info for known faces
        if (recognitionResult && recognitionResult.isKnown) {
            const confidenceText = `Match: ${recognitionResult.confidence}%`;
            ctx.font = '12px Arial';
            const confMetrics = ctx.measureText(confidenceText);

            // Small confidence indicator
            ctx.fillStyle = 'rgba(16, 185, 129, 0.8)';
            ctx.fillRect(x + width - confMetrics.width - padding, y + 5, confMetrics.width + padding / 2, 16);

            ctx.fillStyle = 'white';
            ctx.fillText(confidenceText, x + width - confMetrics.width - padding / 2, y + 16);
        }
    }

    /**
     * Process detected face for attendance
     */
    processFaceForAttendance(detection, recognitionResult = null) {
        const confidence = detection.detection ? detection.detection.score : detection.score;

        // Only process faces with high confidence
        if (confidence >= 0.8) {
            if (recognitionResult && recognitionResult.isKnown) {
                console.log(`Known face detected: ${recognitionResult.label} (${recognitionResult.confidence}% match)`);
                // Here you can add automatic attendance capture for known faces
            } else {
                console.log('Unknown face detected with high confidence:', Math.round(confidence * 100) + '%');
            }
        } else {
            console.log('Face detected with low confidence:', Math.round(confidence * 100) + '%');
        }
    }

    /**
     * Show message to user
     */
    showMessage(message, type = 'info') {
        // You can integrate this with your Laravel notification system
        console.log(`${type.toUpperCase()}: ${message}`);

        // For now, just use browser alert
        // In production, you'd want to use a proper notification system
        if (type === 'error') {
            alert('Error: ' + message);
        }
    }

    /**
     * Capture current frame for attendance
     */
    captureAttendance() {
        if (!this.video.videoWidth) {
            this.showMessage('Camera not ready', 'error');
            return;
        }

        // Create a canvas to capture the current frame
        const captureCanvas = document.createElement('canvas');
        captureCanvas.width = this.video.videoWidth;
        captureCanvas.height = this.video.videoHeight;

        const captureCtx = captureCanvas.getContext('2d');
        captureCtx.drawImage(this.video, 0, 0);

        // Convert to blob and send to server
        captureCanvas.toBlob(async (blob) => {
            try {
                await this.sendAttendanceData(blob);
            } catch (error) {
                console.error('Error sending attendance data:', error);
                this.showMessage('Failed to record attendance', 'error');
            }
        }, 'image/jpeg', 0.8);
    }

    /**
     * Refresh reference faces (call this after new face enrollment)
     */
    async refreshReferenceFaces() {
        console.log('Refreshing reference faces...');
        await this.loadReferenceFaces();
    }

    /**
     * Save current face image with username (cropped to face bounding box)
     */
    async saveFaceImage(username) {
        if (!this.video.videoWidth) {
            throw new Error('Camera not ready');
        }

        // Get the latest face detection
        const detections = await faceapi
            .detectAllFaces(this.video, this.faceDetectionOptions)
            .withFaceLandmarks()
            .withFaceDescriptors();

        if (detections.length === 0) {
            throw new Error('No face detected for saving');
        }

        const detection = detections[0];
        const box = detection.detection.box;

        // Create a canvas to capture and crop the face
        const captureCanvas = document.createElement('canvas');

        // Add padding around the face (20% on each side)
        const padding = 0.2;
        const paddedWidth = box.width * (1 + padding * 2);
        const paddedHeight = box.height * (1 + padding * 2);
        const paddedX = Math.max(0, box.x - box.width * padding);
        const paddedY = Math.max(0, box.y - box.height * padding);

        // Set canvas size to the padded face area
        captureCanvas.width = Math.min(paddedWidth, this.video.videoWidth - paddedX);
        captureCanvas.height = Math.min(paddedHeight, this.video.videoHeight - paddedY);

        const captureCtx = captureCanvas.getContext('2d');

        // Draw only the face area (with padding) from the video
        captureCtx.drawImage(
            this.video,
            paddedX, paddedY, captureCanvas.width, captureCanvas.height, // Source
            0, 0, captureCanvas.width, captureCanvas.height // Destination
        );

        // Convert to blob and send to server
        return new Promise((resolve, reject) => {
            captureCanvas.toBlob(async (blob) => {
                try {
                    const result = await this.sendFaceImageToServer(blob, username);
                    resolve(result);
                } catch (error) {
                    reject(error);
                }
            }, 'image/jpeg', 0.9); // High quality for face storage
        });
    }


    /**
     * Send attendance data to Laravel backend
     */
    async sendAttendanceData(imageBlob) {
        const formData = new FormData();
        formData.append('image', imageBlob, 'attendance.jpg');
        formData.append('timestamp', new Date().toISOString());

        // Add CSRF token for Laravel
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (csrfToken) {
            formData.append('_token', csrfToken);
        }

        const response = await fetch('/api/attendance/face-recognition', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });

        if (!response.ok) {
            throw new Error('Failed to submit attendance');
        }

        const result = await response.json();
        this.showMessage('Attendance recorded successfully!', 'success');

        return result;
    }

    /**
     * Send face image to Laravel backend for saving
     */
    async sendFaceImageToServer(imageBlob, username) {
        const formData = new FormData();

        // Generate unique filename with timestamp
        const timestamp = new Date().toISOString().replace(/[:.]/g, '-');
        const filename = `${username}_${timestamp}.jpg`;

        formData.append('face_image', imageBlob, filename);
        formData.append('username', username);
        formData.append('timestamp', new Date().toISOString());

        // Add CSRF token for Laravel
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (csrfToken) {
            formData.append('_token', csrfToken);
        }

        const response = await fetch('/api/face-enrollment', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });

        if (!response.ok) {
            const errorData = await response.json().catch(() => ({}));
            throw new Error(errorData.message || 'Failed to save face image');
        }

        const result = await response.json();
        console.log('Face image saved successfully:', result);

        return result;
    }
}

// Export the class for use in other modules
export { FaceAttendanceSystem };

// Also make it available globally for debugging
if (typeof window !== 'undefined') {
    window.FaceAttendanceSystem = FaceAttendanceSystem;
}