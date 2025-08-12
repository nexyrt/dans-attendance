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

// Simple Dialog-Based Audio System
// Add this code to your resources/js/app.js file

document.addEventListener('DOMContentLoaded', function() {
    console.log('🎵 Simple Audio System with Dialog initialized');
    
    // Audio configuration
    let audio = null;
    let isAudioReady = false;
    let userHasInteracted = false;
    
    // Check if user has already made a choice
    const audioPreference = localStorage.getItem('backgroundAudioEnabled');
    const hasChosenBefore = localStorage.getItem('audioChoiceMade');
    
    // Create audio element
    function createAudioElement() {
        audio = document.createElement('audio');
        audio.id = 'background-audio';
        audio.loop = true;
        audio.preload = 'auto';
        audio.volume = 0.4;
        
        // Add source
        const source = document.createElement('source');
        source.src = '/audio/background-music.mp3';
        source.type = 'audio/mpeg';
        audio.appendChild(source);
        
        // Add to DOM
        document.body.appendChild(audio);
        
        // Event listeners
        audio.addEventListener('canplaythrough', function() {
            isAudioReady = true;
            console.log('✅ Audio file loaded and ready');
        });
        
        audio.addEventListener('error', function(e) {
            console.error('❌ Audio loading error:', e);
            console.error('Check if file exists: /audio/background-music.mp3');
        });
        
        audio.addEventListener('play', function() {
            console.log('🎵 Audio started playing');
        });
        
        audio.addEventListener('pause', function() {
            console.log('⏸️ Audio paused');
        });
        
        return audio;
    }
    
    // Show confirmation dialog
    function showAudioDialog() {
        const userWantsAudio = confirm(
            "🎵 Ingin mendengarkan background music?\n\n" +
            "• Klik OK untuk memutar musik\n" +
            "• Klik Cancel untuk browsing tanpa musik\n\n" +
            "Pilihan ini akan diingat untuk kunjungan berikutnya."
        );
        
        // Save user preference
        localStorage.setItem('audioChoiceMade', 'true');
        localStorage.setItem('backgroundAudioEnabled', userWantsAudio.toString());
        
        if (userWantsAudio) {
            startAudio();
        } else {
            console.log('🔇 User declined background music');
        }
        
        return userWantsAudio;
    }
    
    // Start audio playback
    function startAudio() {
        if (!audio) {
            console.error('❌ Audio element not found');
            return;
        }
        
        // Wait for audio to be ready
        const attemptPlay = () => {
            if (isAudioReady) {
                audio.play().then(() => {
                    console.log('🎵 Background music started successfully');
                }).catch((error) => {
                    console.error('❌ Audio play failed:', error);
                    
                    // Retry after short delay
                    setTimeout(() => {
                        audio.play().catch(() => {
                            console.warn('⚠️ Audio autoplay blocked by browser. This is normal.');
                        });
                    }, 1000);
                });
            } else {
                // Wait a bit more for audio to load
                setTimeout(attemptPlay, 500);
            }
        };
        
        attemptPlay();
    }
    
    // Handle user interaction
    function handleFirstInteraction() {
        if (userHasInteracted) return;
        userHasInteracted = true;
        
        console.log('👆 First user interaction detected');
        
        // Check previous choice
        if (hasChosenBefore === 'true') {
            if (audioPreference === 'true') {
                console.log('🎵 Auto-starting audio based on previous choice');
                startAudio();
            } else {
                console.log('🔇 Audio disabled based on previous choice');
            }
        } else {
            // First time - show dialog
            console.log('💬 Showing audio confirmation dialog');
            showAudioDialog();
        }
        
        // Remove interaction listeners
        removeInteractionListeners();
    }
    
    // Add interaction event listeners
    function addInteractionListeners() {
        const events = ['click', 'keydown', 'touchstart'];
        
        events.forEach(eventType => {
            document.addEventListener(eventType, handleFirstInteraction, { once: true });
        });
        
        console.log('👆 Waiting for user interaction...');
    }
    
    // Remove interaction event listeners
    function removeInteractionListeners() {
        const events = ['click', 'keydown', 'touchstart'];
        
        events.forEach(eventType => {
            document.removeEventListener(eventType, handleFirstInteraction);
        });
    }
    
    // Global audio controls
    window.audioControls = {
        // Play audio
        play: function() {
            if (audio && audio.paused) {
                startAudio();
            }
        },
        
        // Pause audio
        pause: function() {
            if (audio && !audio.paused) {
                audio.pause();
                console.log('⏸️ Audio paused manually');
            }
        },
        
        // Toggle play/pause
        toggle: function() {
            if (audio) {
                if (audio.paused) {
                    this.play();
                } else {
                    this.pause();
                }
            }
        },
        
        // Set volume (0.0 to 1.0)
        setVolume: function(volume) {
            if (audio) {
                audio.volume = Math.max(0, Math.min(1, volume));
                console.log(`🔊 Volume set to ${Math.round(audio.volume * 100)}%`);
            }
        },
        
        // Get current status
        getStatus: function() {
            if (!audio) return { error: 'Audio not initialized' };
            
            return {
                isPlaying: !audio.paused,
                volume: audio.volume,
                currentTime: audio.currentTime,
                duration: audio.duration,
                isReady: isAudioReady,
                userPreference: audioPreference,
                hasChosen: hasChosenBefore === 'true'
            };
        },
        
        // Reset user preferences
        resetPreferences: function() {
            localStorage.removeItem('backgroundAudioEnabled');
            localStorage.removeItem('audioChoiceMade');
            console.log('🔄 Audio preferences reset');
            
            // Reload page to start fresh
            if (confirm('Preferensi audio telah direset. Reload halaman untuk mengatur ulang?')) {
                location.reload();
            }
        },
        
        // Force show dialog again
        showDialog: function() {
            showAudioDialog();
        }
    };
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(event) {
        // Ctrl + M to toggle audio
        if (event.ctrlKey && event.key === 'm') {
            event.preventDefault();
            window.audioControls.toggle();
        }
        
        // Ctrl + Shift + A to reset audio preferences
        if (event.ctrlKey && event.shiftKey && event.key === 'A') {
            event.preventDefault();
            window.audioControls.resetPreferences();
        }
    });
    
    // Handle page visibility changes
    document.addEventListener('visibilitychange', function() {
        if (audio && audioPreference === 'true') {
            if (document.hidden) {
                audio.pause();
                console.log('⏸️ Audio paused (tab hidden)');
            } else if (userHasInteracted) {
                setTimeout(() => {
                    startAudio();
                    console.log('🎵 Audio resumed (tab visible)');
                }, 300);
            }
        }
    });
    
    // Initialize audio element
    createAudioElement();
    
    // Start listening for interactions
    addInteractionListeners();
    
    // Debug info
    console.log('📊 Audio System Status:');
    console.log('   • Has chosen before:', hasChosenBefore === 'true');
    console.log('   • Audio preference:', audioPreference);
    console.log('   • Ready for interaction');
    
    // Helpful console commands info
    console.log('🎛️ Available commands:');
    console.log('   • window.audioControls.getStatus() - Check status');
    console.log('   • window.audioControls.toggle() - Toggle play/pause');
    console.log('   • window.audioControls.resetPreferences() - Reset choices');
    console.log('   • Ctrl+M - Toggle audio');
});