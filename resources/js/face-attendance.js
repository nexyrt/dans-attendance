

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
        this.detectionHistory = new Map(); // Store detection history for each person
        this.requiredDetections = 5; // Number of consecutive detections needed
        this.detectionWindow = 3000; // Time window in ms (3 seconds)
        this.checkedInToday = new Set(); // Track who has already checked in today
        this.lastProcessedAttendance = new Map(); // Prevent duplicate processing

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
            console.log('🚀 STEP 1: SYSTEM INITIALIZATION STARTED');
            console.log('├── Current time:', new Date().toISOString());
            console.log('├── Document ready state:', document.readyState);

            this.updateInitializationStatus('Initializing Face Attendance System...');

            // Get DOM elements
            console.log('├── Getting DOM elements...');
            this.video = document.getElementById('video');
            this.canvas = document.getElementById('overlay');

            if (!this.video || !this.canvas) {
                console.error('❌ STEP 1 FAILED: Required DOM elements not found');
                console.error('├── Video element:', this.video);
                console.error('└── Canvas element:', this.canvas);
                this.updateInitializationStatus('Error: Required DOM elements not found', 'error');
                return;
            }

            console.log('✅ STEP 1a: DOM elements found');
            console.log('├── Video element ID:', this.video.id);
            console.log('└── Canvas element ID:', this.canvas.id);

            this.updateInitializationStatus('DOM elements found');

            // Load face-api.js models
            console.log('🔄 STEP 1b: Loading models...');
            await this.loadModels();

            console.log('🔄 STEP 1c: Loading today\'s attendance...');
            await this.loadTodaysAttendance();

            this.isInitialized = true;
            console.log('🎉 STEP 1 COMPLETED: Face Attendance System initialized successfully');
            console.log('└── isInitialized:', this.isInitialized);

            this.updateInitializationStatus('Face Attendance System initialized successfully', 'success', true);

        } catch (error) {
            console.error('❌ STEP 1 FAILED: Failed to initialize Face Attendance System');
            console.error('├── Error:', error.message);
            console.error('└── Stack:', error.stack);
            this.updateInitializationStatus('Failed to initialize: ' + error.message, 'error');
        }
    }



    /**
     * Load face-api.js models
     */
    async loadModels() {
        console.log('📦 STEP 2: MODEL LOADING STARTED');

        try {
            const MODEL_URL = '/models';
            console.log('├── Model URL:', MODEL_URL);

            // Test model accessibility
            console.log('├── Testing model file accessibility...');
            try {
                const testResponse = await fetch(`${MODEL_URL}/ssd_mobilenetv1_model-weights_manifest.json`);
                console.log('├── Model test response status:', testResponse.status);
                if (!testResponse.ok) {
                    throw new Error(`Model files not accessible. Status: ${testResponse.status}`);
                }
                console.log('✅ STEP 2a: Model files are accessible');
            } catch (fetchError) {
                console.error('❌ STEP 2a FAILED: Cannot access model files');
                console.error('├── URL tested:', `${MODEL_URL}/ssd_mobilenetv1_model-weights_manifest.json`);
                console.error('└── Error:', fetchError.message);
                throw fetchError;
            }

            console.log('⏳ STEP 2b: Loading face-api.js models...');
            this.updateInitializationStatus('Loading face detection models...');

            const modelLoadStart = performance.now();
            await Promise.all([
                faceapi.nets.ssdMobilenetv1.loadFromUri(MODEL_URL),
                faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL),
                faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL)
            ]);
            const modelLoadEnd = performance.now();

            console.log('✅ STEP 2b: Models loaded successfully');
            console.log('├── Load time:', Math.round(modelLoadEnd - modelLoadStart) + 'ms');
            console.log('├── SSD MobileNet loaded:', faceapi.nets.ssdMobilenetv1.isLoaded);
            console.log('├── Face Landmark loaded:', faceapi.nets.faceLandmark68Net.isLoaded);
            console.log('└── Face Recognition loaded:', faceapi.nets.faceRecognitionNet.isLoaded);

            console.log('🔄 STEP 2c: Loading reference faces...');
            await this.loadReferenceFaces();

            this.isModelLoaded = true;
            console.log('🎉 STEP 2 COMPLETED: All models loaded');
            console.log('└── isRecognitionReady:', this.isRecognitionReady);

        } catch (error) {
            console.error('❌ STEP 2 FAILED: Error loading models');
            console.error('├── Error:', error.message);
            console.error('└── Stack:', error.stack);
            throw error;
        }
    }

    async loadTodaysAttendance() {
        console.log('📋 STEP 3: LOADING TODAY\'S ATTENDANCE');

        try {
            const today = new Date().toISOString().split('T')[0];
            console.log('├── Date:', today);

            const url = `/api/attendance/today?date=${today}`;
            console.log('├── API URL:', url);

            const response = await fetch(url);
            console.log('├── Response status:', response.status);
            console.log('├── Response ok:', response.ok);

            if (response.ok) {
                const data = await response.json();
                console.log('├── API Response success:', data.success);

                if (data.success && data.data && data.data.attendances) {
                    console.log('├── Total attendances found:', data.data.attendances.length);

                    data.data.attendances.forEach((attendance, index) => {
                        if (attendance.user_name) {
                            this.checkedInToday.add(attendance.user_name.toLowerCase());
                            console.log(`├── [${index + 1}] Added to checkedIn:`, attendance.user_name.toLowerCase());
                        }
                    });

                    console.log('✅ STEP 3 COMPLETED: Loaded existing check-ins');
                    console.log('└── Total checked in today:', this.checkedInToday.size);
                    console.log('└── Checked in users:', Array.from(this.checkedInToday));
                } else {
                    console.log('├── No attendances found or API returned error');
                    console.log('└── Data structure:', data);
                }
            } else {
                console.warn('⚠️ STEP 3 WARNING: Failed to load today\'s attendance');
                console.warn('└── Status:', response.status);
            }
        } catch (error) {
            console.warn('⚠️ STEP 3 WARNING: Could not load today\'s attendance');
            console.warn('└── Error:', error.message);
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
        console.log('📹 STEP 4: CAMERA ACTIVATION STARTED');

        if (!this.isModelLoaded) {
            console.error('❌ STEP 4 FAILED: Models not loaded yet');
            console.error('└── isModelLoaded:', this.isModelLoaded);
            this.showMessage('Please wait for models to load first.', 'warning');
            return;
        }

        try {
            const constraints = {
                video: {
                    width: { ideal: 1280 },
                    height: { ideal: 720 },
                    facingMode: 'user'
                }
            };
            console.log('├── Camera constraints:', constraints);

            console.log('├── Requesting camera access...');
            this.currentStream = await navigator.mediaDevices.getUserMedia(constraints);
            console.log('✅ STEP 4a: Camera access granted');
            console.log('├── Stream tracks:', this.currentStream.getTracks().length);

            this.video.srcObject = this.currentStream;

            return new Promise((resolve) => {
                this.video.addEventListener('loadedmetadata', () => {
                    console.log('✅ STEP 4b: Video metadata loaded');
                    console.log('├── Video dimensions:', this.video.videoWidth + 'x' + this.video.videoHeight);

                    this.canvas.width = this.video.videoWidth;
                    this.canvas.height = this.video.videoHeight;
                    console.log('├── Canvas dimensions set:', this.canvas.width + 'x' + this.canvas.height);

                    console.log('🔄 STEP 4c: Starting face detection...');
                    this.startFaceDetection();

                    console.log('🎉 STEP 4 COMPLETED: Camera started successfully');
                    resolve();
                });
            });

        } catch (error) {
            console.error('❌ STEP 4 FAILED: Error starting camera');
            console.error('├── Error name:', error.name);
            console.error('├── Error message:', error.message);
            console.error('└── Possible causes:');
            console.error('    - Camera permissions denied');
            console.error('    - No camera available');
            console.error('    - Camera in use by another app');
            console.error('    - Not using HTTPS (required for camera)');
            this.showMessage('Unable to access camera. Please grant camera permissions.', 'error');
            throw error;
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
        this.detectionHistory.clear();
        this.lastProcessedAttendance.clear();
        console.log('Camera stopped');
    }

    /**
     * Start face detection loop
     */
    startFaceDetection() {
        if (this.isDetecting) {
            console.warn('⚠️ STEP 5: Face detection already running');
            return;
        }

        this.isDetecting = true;
        console.log('🔍 STEP 5: FACE DETECTION LOOP STARTED');
        console.log('├── Detection interval: 200ms');
        console.log('├── Min confidence:', this.faceDetectionOptions.minConfidence);
        console.log('└── Max results:', this.faceDetectionOptions.maxResults);

        let detectionCount = 0;

        const detectFaces = async () => {
            if (!this.isDetecting || !this.video.videoWidth) return;

            detectionCount++;
            // Log every 25th detection to avoid spam (every 5 seconds)
            const shouldLog = detectionCount % 25 === 0;

            if (shouldLog) {
                console.log(`🔄 STEP 5 LOOP: Detection #${detectionCount} (every 5s log)`);
            }

            try {
                const detectionStart = performance.now();

                const detections = await faceapi
                    .detectAllFaces(this.video, this.faceDetectionOptions)
                    .withFaceLandmarks()
                    .withFaceDescriptors();

                const detectionEnd = performance.now();

                if (shouldLog) {
                    console.log(`├── Detection time: ${Math.round(detectionEnd - detectionStart)}ms`);
                    console.log(`├── Faces found: ${detections.length}`);
                }

                const ctx = this.canvas.getContext('2d');
                ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

                if (detections.length > 0) {
                    const detection = detections[0];
                    const confidence = Math.round(detection.detection.score * 100);

                    console.log(`👤 STEP 5a: FACE DETECTED - Confidence: ${confidence}%`);

                    if (!detection.detection) {
                        console.error('❌ STEP 5a ERROR: Invalid detection structure');
                        console.error('└── Detection object:', detection);
                        return;
                    }

                    let recognitionResult = null;
                    try {
                        console.log('🧠 STEP 5b: Running face recognition...');
                        recognitionResult = this.recognizeFace(detection);
                        console.log('├── Recognition result:', recognitionResult);
                    } catch (recognitionError) {
                        console.warn('⚠️ STEP 5b WARNING: Face recognition failed');
                        console.warn('└── Error:', recognitionError.message);
                        recognitionResult = {
                            label: 'Unknown',
                            confidence: 0,
                            distance: 1,
                            isKnown: false
                        };
                    }

                    const resizedDetection = faceapi.resizeResults([detection], {
                        width: this.canvas.width,
                        height: this.canvas.height
                    })[0];

                    this.drawDetection(resizedDetection, recognitionResult);

                    console.log('🎯 STEP 5c: Processing for attendance...');
                    this.processFaceForAttendance(detection, recognitionResult);

                    document.dispatchEvent(new CustomEvent('faceDetected', {
                        detail: {
                            confidence: confidence,
                            recognition: recognitionResult
                        }
                    }));
                } else {
                    if (shouldLog) {
                        console.log('👻 STEP 5: No faces detected');
                    }
                    document.dispatchEvent(new CustomEvent('faceNotDetected'));
                }

            } catch (error) {
                console.error('❌ STEP 5 ERROR: Face detection loop error');
                console.error('├── Error:', error.message);
                console.error('└── Continuing detection...');
            }
        };

        this.detectionInterval = setInterval(detectFaces, 200);
        console.log('✅ STEP 5: Detection interval started');
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

        let box, score;

        if (detection.detection) {
            box = detection.detection.box;
            score = detection.detection.score;
        } else if (detection.box) {
            box = detection.box;
            score = detection.score;
        } else {
            console.error('Unknown detection object structure:', detection);
            return;
        }

        const { x, y, width, height } = box;

        // Determine colors based on recognition result and check-in status
        let boxColor = '#10b981';
        let textBgColor = '#10b981';
        let label = `${Math.round(score * 100)}%`;

        if (recognitionResult) {
            if (recognitionResult.isKnown) {
                const username = recognitionResult.label.toLowerCase();
                const isCheckedIn = this.checkedInToday.has(username);

                if (isCheckedIn) {
                    // Already checked in - blue color
                    boxColor = '#3b82f6';
                    textBgColor = '#3b82f6';
                    label = `${recognitionResult.label} (Already checked in)`;
                } else {
                    // Not checked in yet - green color
                    boxColor = '#10b981';
                    textBgColor = '#10b981';

                    // Show detection progress
                    const userDetections = this.detectionHistory.get(username);
                    const detectionCount = userDetections ? userDetections.length : 0;

                    label = `${recognitionResult.label} (${detectionCount}/${this.requiredDetections})`;
                }
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

        let labelY = y - textHeight - padding;
        if (labelY < 0) {
            labelY = y + height + textHeight + padding;
        }

        ctx.fillStyle = textBgColor;
        ctx.fillRect(x, labelY - textHeight - padding / 2, textWidth + padding, textHeight + padding);

        ctx.fillStyle = 'white';
        ctx.fillText(label, x + padding / 2, labelY - padding / 2);

        // Add confidence indicator for known faces
        if (recognitionResult && recognitionResult.isKnown) {
            const confidenceText = `${recognitionResult.confidence}% match`;
            ctx.font = '12px Arial';
            const confMetrics = ctx.measureText(confidenceText);

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
        const currentTime = Date.now();

        console.log('⚡ STEP 6: PROCESSING FACE FOR ATTENDANCE');
        console.log('├── Face confidence:', Math.round(confidence * 100) + '%');
        console.log('├── Recognition result:', recognitionResult);
        console.log('├── Current time:', new Date(currentTime).toISOString());

        // Check qualification criteria
        const meetsConfidence = confidence >= 0.8;
        const isKnown = recognitionResult && recognitionResult.isKnown;
        const meetsRecognitionConfidence = recognitionResult && recognitionResult.confidence >= 50;

        console.log('├── Qualification check:');
        console.log('    ├── Face confidence ≥ 80%:', meetsConfidence, `(${Math.round(confidence * 100)}%)`);
        console.log('    ├── Is known person:', isKnown);
        console.log('    └── Recognition confidence ≥ 70%:', meetsRecognitionConfidence,
            recognitionResult ? `(${recognitionResult.confidence}%)` : '(N/A)');

        if (meetsConfidence && isKnown && meetsRecognitionConfidence) {
            const username = recognitionResult.label.toLowerCase();

            console.log('✅ STEP 6a: QUALIFIED FACE DETECTED');
            console.log('├── Username:', username);
            console.log('├── Original label:', recognitionResult.label);

            // Check if already checked in
            if (this.checkedInToday.has(username)) {
                console.log('🔵 STEP 6b: USER ALREADY CHECKED IN TODAY');
                console.log('└── Skipping attendance processing');
                return;
            }

            console.log('🟢 STEP 6c: USER NOT CHECKED IN - TRACKING DETECTIONS');

            // Initialize detection history
            if (!this.detectionHistory.has(username)) {
                this.detectionHistory.set(username, []);
                console.log('├── Created new detection history for:', username);
            }

            const userDetections = this.detectionHistory.get(username);

            // Add current detection
            userDetections.push({
                timestamp: currentTime,
                confidence: recognitionResult.confidence
            });

            console.log('├── Added detection #' + userDetections.length);

            // Remove old detections
            const validDetections = userDetections.filter(
                det => currentTime - det.timestamp <= this.detectionWindow
            );
            this.detectionHistory.set(username, validDetections);

            console.log('├── Valid detections in window:', validDetections.length + '/' + this.requiredDetections);
            console.log('├── Detection window:', this.detectionWindow + 'ms');

            // Check if enough detections
            if (validDetections.length >= this.requiredDetections) {
                console.log('🎯 STEP 6d: SUFFICIENT DETECTIONS - CHECKING COOLDOWN');

                const lastProcessed = this.lastProcessedAttendance.get(username) || 0;
                const cooldownRemaining = 10000 - (currentTime - lastProcessed);

                console.log('├── Last processed:', new Date(lastProcessed).toISOString());
                console.log('├── Cooldown remaining:', cooldownRemaining + 'ms');

                if (cooldownRemaining > 0) {
                    console.log('⏰ STEP 6d: COOLDOWN ACTIVE - SKIPPING');
                    return;
                }

                console.log('🚀 STEP 6e: TRIGGERING AUTOMATIC ATTENDANCE');
                this.lastProcessedAttendance.set(username, currentTime);
                this.processAutomaticAttendance(recognitionResult.label, validDetections);
                this.detectionHistory.delete(username);

            } else {
                console.log('⏳ STEP 6d: NEED MORE DETECTIONS');
                console.log('└── Progress:', validDetections.length + '/' + this.requiredDetections);
            }
        } else {
            if (confidence >= 0.8 && (!recognitionResult || !recognitionResult.isKnown)) {
                console.log('🔴 STEP 6: HIGH CONFIDENCE UNKNOWN FACE');
                console.log('└── Confidence:', Math.round(confidence * 100) + '%');
            } else {
                console.log('⚪ STEP 6: FACE DOES NOT MEET CRITERIA');
            }
        }
    }

    /**
     * Process automatic attendance check-in
     */
    async processAutomaticAttendance(username, detections) {
        console.log('🎯 STEP 7: AUTOMATIC ATTENDANCE PROCESSING STARTED');
        console.log('├── Username:', username);
        console.log('├── Detection count:', detections.length);

        try {
            console.log('📤 STEP 7a: Showing processing notification...');
            this.showAttendanceNotification(username, 'processing');

            // Calculate average confidence
            const avgConfidence = Math.round(
                detections.reduce((sum, det) => sum + det.confidence, 0) / detections.length
            );
            console.log('├── Average confidence:', avgConfidence + '%');
            console.log('├── Individual confidences:', detections.map(d => d.confidence + '%'));

            console.log('📸 STEP 7b: Capturing current frame...');
            const captureStart = performance.now();
            const imageBlob = await this.captureCurrentFrame();
            const captureEnd = performance.now();

            console.log('├── Capture time:', Math.round(captureEnd - captureStart) + 'ms');
            console.log('├── Image blob size:', Math.round(imageBlob.size / 1024) + 'KB');

            console.log('🌐 STEP 7c: Sending to server...');
            const serverStart = performance.now();
            const result = await this.sendAttendanceData(imageBlob, username, avgConfidence);
            const serverEnd = performance.now();

            console.log('├── Server response time:', Math.round(serverEnd - serverStart) + 'ms');
            console.log('├── Server response:', result);

            if (result.success) {
                console.log('✅ STEP 7d: ATTENDANCE RECORDED SUCCESSFULLY');

                this.checkedInToday.add(username.toLowerCase());
                console.log('├── Added to checkedInToday:', username.toLowerCase());
                console.log('├── Total checked in today:', this.checkedInToday.size);

                this.showAttendanceNotification(username, 'success');

                document.dispatchEvent(new CustomEvent('automaticCheckIn', {
                    detail: {
                        username: username,
                        confidence: avgConfidence,
                        timestamp: new Date().toISOString(),
                        result: result
                    }
                }));

                console.log('🎉 STEP 7 COMPLETED: Automatic check-in successful');
                console.log('└── Attendance ID:', result.data?.attendance_id);
            } else {
                throw new Error(result.message || 'Failed to record attendance');
            }

        } catch (error) {
            console.error('❌ STEP 7 FAILED: Error processing automatic attendance');
            console.error('├── Username:', username);
            console.error('├── Error message:', error.message);
            console.error('└── Stack:', error.stack);
            this.showAttendanceNotification(username, 'error', error.message);
        }
    }


    showAttendanceNotification(username, status, message = '') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transition-all duration-300';

        let bgColor, icon, text;
        switch (status) {
            case 'processing':
                bgColor = 'bg-blue-500';
                icon = '⏳';
                text = `Processing check-in for ${username}...`;
                break;
            case 'success':
                bgColor = 'bg-green-500';
                icon = '✅';
                text = `${username} checked in successfully!`;
                break;
            case 'error':
                bgColor = 'bg-red-500';
                icon = '❌';
                text = `Check-in failed for ${username}${message ? ': ' + message : ''}`;
                break;
        }

        notification.className += ` ${bgColor} text-white`;
        notification.innerHTML = `
            <div class="flex items-center space-x-3">
                <span class="text-xl">${icon}</span>
                <span class="font-medium">${text}</span>
            </div>
        `;

        document.body.appendChild(notification);

        // Auto remove after 4 seconds
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 4000);
    }

    /**
     * Capture current frame as blob
     */
    async captureCurrentFrame() {
        return new Promise((resolve) => {
            const captureCanvas = document.createElement('canvas');
            captureCanvas.width = this.video.videoWidth;
            captureCanvas.height = this.video.videoHeight;

            const captureCtx = captureCanvas.getContext('2d');
            captureCtx.drawImage(this.video, 0, 0);

            captureCanvas.toBlob(resolve, 'image/jpeg', 0.8);
        });
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
    async sendAttendanceData(imageBlob, username = null, confidence = null) {
        console.log('📡 STEP 8: SENDING ATTENDANCE DATA TO SERVER');
        console.log('├── Username:', username);
        console.log('├── Confidence:', confidence);
        console.log('├── Image size:', Math.round(imageBlob.size / 1024) + 'KB');

        const formData = new FormData();
        formData.append('image', imageBlob, 'attendance.jpg');
        
        const now = new Date();
        const makassarTime = new Date(now.getTime() + (8 * 60 * 60 * 1000));
        // FIXED: Get proper Makassar timestamp
        const makassarTimestamp = makassarTime.toISOString();
        formData.append('timestamp', makassarTimestamp);
        
        console.log('├── Timestamp being sent:', makassarTimestamp);

        if (username) {
            formData.append('username', username);
            formData.append('confidence', confidence);
            formData.append('auto_checkin', '1');
            console.log('├── Auto check-in mode: 1');
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        console.log('├── CSRF token found:', !!csrfToken);
        
        if (csrfToken) {
            formData.append('_token', csrfToken);
        }

        // Debug: Log all FormData entries
        console.log('├── FormData contents:');
        for (let [key, value] of formData.entries()) {
            if (key === 'image') {
                console.log(`    ${key}: [File object - ${Math.round(value.size / 1024)}KB]`);
            } else {
                console.log(`    ${key}: ${value}`);
            }
        }

        console.log('├── Sending POST request to: /api/attendance/face-recognition');
        
        try {
            const response = await fetch('/api/attendance/face-recognition', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            console.log('├── Response status:', response.status);
            console.log('├── Response ok:', response.ok);

            if (!response.ok) {
                const errorText = await response.text();
                console.error('❌ STEP 8 FAILED: Server returned error');
                console.error('├── Status:', response.status);
                console.error('├── Status text:', response.statusText);
                console.error('└── Response body:', errorText);
                throw new Error('Failed to submit attendance: ' + response.status);
            }

            const result = await response.json();
            console.log('✅ STEP 8 COMPLETED: Server response received');
            console.log('├── Success:', result.success);
            console.log('├── Message:', result.message);
            console.log('├── Check-in time (Makassar):', result.data?.check_in_time);
            console.log('├── Timezone:', result.data?.timezone);
            console.log('└── Full response data:', result.data);

            if (!username) {
                this.showMessage('Attendance recorded successfully!', 'success');
            }

            return result;

            } catch (error) {
                console.error('❌ STEP 8 FAILED: Network or parsing error');
                console.error('├── Error:', error.message);
                console.error('└── Stack:', error.stack);
                throw error;
            }
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