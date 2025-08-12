import 'preline'
import 'flowbite';

import './attendance-modal';
import './leave-flowbite-components';

// Import Quill
import Quill from 'quill';
import 'quill/dist/quill.snow.css';

// Make Quill available globally
window.Quill = Quill;

document.addEventListener('livewire:init', () => {
    Livewire.on('refresh-preline', () => {
        setTimeout(() => {
            HSStaticMethods.autoInit();
        });
    });
});

// Global Audio System for Laravel Application
// Add this code to your resources/js/app.js file

// Alternative Global Audio System - Simpler Approach
// Add this code to your resources/js/app.js file

document.addEventListener('DOMContentLoaded', function () {
    console.log('🎵 Initializing Alternative Audio System...');

    // Audio configuration
    const audioConfig = {
        src: '/audio/background-music.mp3',
        volume: 0.3,
        fadeInDuration: 2000,
        retryAttempts: 3
    };

    let audioContext = null;
    let audioBuffer = null;
    let audioSource = null;
    let gainNode = null;
    let isPlaying = false;
    let isInitialized = false;

    // Alternative 1: Web Audio API approach
    function initWebAudio() {
        try {
            audioContext = new (window.AudioContext || window.webkitAudioContext)();
            gainNode = audioContext.createGain();
            gainNode.connect(audioContext.destination);
            gainNode.gain.value = 0; // Start with 0 volume for fade in

            console.log('✅ Web Audio API initialized');
            return true;
        } catch (error) {
            console.warn('❌ Web Audio API not supported:', error);
            return false;
        }
    }

    // Load audio file using fetch
    async function loadAudioFile() {
        try {
            console.log('📥 Loading audio file...');
            const response = await fetch(audioConfig.src);

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }

            const arrayBuffer = await response.arrayBuffer();
            audioBuffer = await audioContext.decodeAudioData(arrayBuffer);

            console.log('✅ Audio file loaded successfully');
            return true;
        } catch (error) {
            console.error('❌ Failed to load audio file:', error);
            return false;
        }
    }

    // Play audio with Web Audio API
    function playWebAudio() {
        if (!audioContext || !audioBuffer) return false;

        try {
            // Stop previous source if exists
            if (audioSource) {
                audioSource.stop();
            }

            // Create new source
            audioSource = audioContext.createBufferSource();
            audioSource.buffer = audioBuffer;
            audioSource.loop = true;
            audioSource.connect(gainNode);

            // Resume audio context if suspended
            if (audioContext.state === 'suspended') {
                audioContext.resume();
            }

            // Start playing
            audioSource.start();

            // Fade in effect
            gainNode.gain.setValueAtTime(0, audioContext.currentTime);
            gainNode.gain.linearRampToValueAtTime(audioConfig.volume, audioContext.currentTime + (audioConfig.fadeInDuration / 1000));

            isPlaying = true;
            console.log('🎵 Web Audio started with fade-in effect');
            return true;
        } catch (error) {
            console.error('❌ Web Audio play failed:', error);
            return false;
        }
    }

    // Alternative 2: Enhanced HTML5 Audio approach
    function initHTML5Audio() {
        const audio = document.createElement('audio');
        audio.id = 'backup-audio-player';
        audio.preload = 'auto';
        audio.loop = true;
        audio.volume = 0;

        // Multiple source formats for better compatibility
        const sources = [
            { src: '/audio/background-music.mp3', type: 'audio/mpeg' },
            { src: '/audio/background-music.ogg', type: 'audio/ogg' },
            { src: '/audio/background-music.wav', type: 'audio/wav' }
        ];

        sources.forEach(source => {
            const sourceElement = document.createElement('source');
            sourceElement.src = source.src;
            sourceElement.type = source.type;
            audio.appendChild(sourceElement);
        });

        document.body.appendChild(audio);

        // Event listeners
        audio.addEventListener('canplaythrough', () => {
            console.log('✅ HTML5 Audio ready to play');
        });

        audio.addEventListener('error', (e) => {
            console.error('❌ HTML5 Audio error:', e);
        });

        return audio;
    }

    // Fade in function for HTML5 audio
    function fadeInHTML5Audio(audioElement) {
        const fadeSteps = 50;
        const fadeInterval = audioConfig.fadeInDuration / fadeSteps;
        const volumeStep = audioConfig.volume / fadeSteps;
        let currentStep = 0;

        const fadeTimer = setInterval(() => {
            currentStep++;
            audioElement.volume = Math.min(volumeStep * currentStep, audioConfig.volume);

            if (currentStep >= fadeSteps) {
                clearInterval(fadeTimer);
                console.log('🎵 HTML5 Audio fade-in completed');
            }
        }, fadeInterval);
    }

    // Try to play HTML5 audio
    async function playHTML5Audio(audioElement) {
        try {
            audioElement.currentTime = 0;
            await audioElement.play();
            fadeInHTML5Audio(audioElement);
            isPlaying = true;
            console.log('🎵 HTML5 Audio started successfully');
            return true;
        } catch (error) {
            console.error('❌ HTML5 Audio play failed:', error);
            return false;
        }
    }

    // Alternative 3: Howler.js fallback (if available)
    function tryHowlerAudio() {
        if (typeof Howl !== 'undefined') {
            try {
                const howlAudio = new Howl({
                    src: [audioConfig.src],
                    loop: true,
                    volume: audioConfig.volume,
                    autoplay: false
                });

                howlAudio.play();
                isPlaying = true;
                console.log('🎵 Howler.js audio started');
                return true;
            } catch (error) {
                console.error('❌ Howler.js failed:', error);
                return false;
            }
        }
        return false;
    }

    // Main audio initialization function
    async function initializeAudio() {
        if (isInitialized) return;

        console.log('🎵 Starting audio initialization...');
        isInitialized = true;

        // Method 1: Try Web Audio API
        if (initWebAudio()) {
            if (await loadAudioFile()) {
                if (playWebAudio()) {
                    localStorage.setItem('audioMethod', 'webapi');
                    return;
                }
            }
        }

        // Method 2: Try HTML5 Audio
        console.log('🔄 Falling back to HTML5 Audio...');
        const html5Audio = initHTML5Audio();

        // Wait a bit for audio to load
        setTimeout(async () => {
            if (await playHTML5Audio(html5Audio)) {
                localStorage.setItem('audioMethod', 'html5');
                return;
            }

            // Method 3: Try Howler.js (if available)
            console.log('🔄 Trying Howler.js fallback...');
            if (tryHowlerAudio()) {
                localStorage.setItem('audioMethod', 'howler');
                return;
            }

            // Method 4: Manual user interaction prompt
            console.log('🔄 All automatic methods failed, requiring manual interaction...');
            showManualAudioPrompt();
        }, 1000);
    }

    // Manual audio prompt as last resort
    function showManualAudioPrompt() {
        const promptDiv = document.createElement('div');
        promptDiv.id = 'audio-prompt';
        promptDiv.innerHTML = `
            <div style="
                position: fixed;
                top: 20px;
                right: 20px;
                background: rgba(0,0,0,0.8);
                color: white;
                padding: 15px 20px;
                border-radius: 10px;
                z-index: 9999;
                font-family: sans-serif;
                font-size: 14px;
                cursor: pointer;
                transition: all 0.3s ease;
            " onclick="window.manualStartAudio()">
                🎵 Klik untuk memutar musik background
            </div>
        `;

        document.body.appendChild(promptDiv);

        // Auto hide after 10 seconds
        setTimeout(() => {
            if (promptDiv.parentNode) {
                promptDiv.parentNode.removeChild(promptDiv);
            }
        }, 10000);
    }

    // Manual audio start function
    window.manualStartAudio = function () {
        const promptDiv = document.getElementById('audio-prompt');
        if (promptDiv) promptDiv.remove();

        const audio = document.getElementById('backup-audio-player');
        if (audio) {
            playHTML5Audio(audio);
        }
    };

    // Enhanced interaction detection
    const interactionEvents = ['click', 'touchstart', 'keydown'];
    let interactionDetected = false;

    function handleInteraction() {
        if (interactionDetected) return;
        interactionDetected = true;

        console.log('👆 User interaction detected, starting audio...');
        setTimeout(initializeAudio, 100);

        // Remove listeners
        interactionEvents.forEach(event => {
            document.removeEventListener(event, handleInteraction);
        });
    }

    // Add interaction listeners
    interactionEvents.forEach(event => {
        document.addEventListener(event, handleInteraction, { once: true });
    });

    // Global controls
    window.audioControl = {
        start: initializeAudio,
        stop: function () {
            if (audioSource) audioSource.stop();
            const audio = document.getElementById('backup-audio-player');
            if (audio) audio.pause();
            isPlaying = false;
            console.log('⏹️ Audio stopped');
        },
        getStatus: function () {
            return {
                isPlaying,
                isInitialized,
                method: localStorage.getItem('audioMethod') || 'none'
            };
        }
    };

    // Try auto-init for returning users
    if (localStorage.getItem('audioMethod')) {
        setTimeout(() => {
            if (!interactionDetected) {
                console.log('🔄 Attempting auto-resume for returning user...');
                initializeAudio();
            }
        }, 2000);
    }

    console.log('🎵 Alternative Audio System ready. Waiting for user interaction...');
});