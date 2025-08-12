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

document.addEventListener('DOMContentLoaded', function () {
    // Create audio element dynamically
    const audio = document.createElement('audio');
    audio.id = 'global-background-music';
    audio.loop = true;
    audio.preload = 'auto';
    audio.volume = 0.3; // Set default volume to 30%

    // Add audio source
    const source = document.createElement('source');
    source.src = '/audio/background-music.mp3'; // Direct path to public/audio
    source.type = 'audio/mpeg';
    audio.appendChild(source);

    // Add to document body
    document.body.appendChild(audio);

    // Audio state management with localStorage
    let audioInitialized = false;
    let userInteracted = false;

    // Check user preference from localStorage
    const userMusicPreference = localStorage.getItem('backgroundMusicEnabled');
    const hasUserChosenBefore = localStorage.getItem('backgroundMusicChoiceMade');

    // Function to initialize audio with user confirmation (only once)
    function initializeAudio() {
        if (audioInitialized || userInteracted) return;

        userInteracted = true;

        // If user has already made a choice before
        if (hasUserChosenBefore === 'true') {
            if (userMusicPreference === 'true') {
                // User previously chose to enable music, auto-play
                playAudioDirectly();
            } else {
                // User previously chose to disable music, stay silent
                console.log('🔇 Background music disabled by user preference');
            }
            return;
        }

        // First time - show dialog
        const userWantsMusic = confirm("🎵 Ingin mendengarkan background music selama browsing?\n\nKlik OK untuk memutar musik, Cancel untuk browsing dalam keheningan.");

        // Save user choice to localStorage
        localStorage.setItem('backgroundMusicChoiceMade', 'true');
        localStorage.setItem('backgroundMusicEnabled', userWantsMusic.toString());

        if (userWantsMusic) {
            playAudioDirectly();
        } else {
            console.log('🔇 User declined background music');

            // Show declined notification (optional)  
            if (typeof window.showToast === 'function') {
                window.showToast('🔇 Background music dinonaktifkan', 'info');
            }
        }
    }

    // Function to play audio directly without dialog
    function playAudioDirectly() {
        audio.play().then(() => {
            audioInitialized = true;
            console.log('🎵 Background music started');

            // Show success notification (optional)
            if (typeof window.showToast === 'function') {
                window.showToast('🎵 Background music dimulai!', 'success');
            }
        }).catch((error) => {
            console.error('Audio play failed:', error);
            // Don't show alert on auto-play, just log
            console.warn('⚠️ Browser blocked audio autoplay');
        });
    }

    // Auto-trigger audio initialization on first meaningful interaction
    function handleFirstInteraction(event) {
        // Only trigger on meaningful interactions (not just mouse movements)
        if (event.type === 'click' || event.type === 'keydown' || event.type === 'touchstart') {
            initializeAudio();

            // Remove listeners after first interaction
            document.removeEventListener('click', handleFirstInteraction);
            document.removeEventListener('keydown', handleFirstInteraction);
            document.removeEventListener('touchstart', handleFirstInteraction);
        }
    }

    // Add event listeners for first interaction
    document.addEventListener('click', handleFirstInteraction);
    document.addEventListener('keydown', handleFirstInteraction);
    document.addEventListener('touchstart', handleFirstInteraction);

    // Global functions for manual audio control (optional)
    window.globalAudioControl = {
        play: function () {
            if (audio.paused) {
                audio.play().then(() => {
                    console.log('🎵 Background music resumed');
                }).catch((error) => {
                    console.error('Audio play failed:', error);
                });
            }
        },
        pause: function () {
            if (!audio.paused) {
                audio.pause();
                console.log('⏸️ Background music paused');
            }
        },
        toggle: function () {
            if (audio.paused) {
                this.play();
            } else {
                this.pause();
            }
        },
        setVolume: function (volume) {
            audio.volume = Math.max(0, Math.min(1, volume));
            console.log(`🔊 Volume set to ${Math.round(audio.volume * 100)}%`);
        },
        getStatus: function () {
            return {
                isPlaying: !audio.paused,
                volume: audio.volume,
                currentTime: audio.currentTime,
                duration: audio.duration
            };
        },
        // Reset user preference (for testing or user settings)
        resetPreference: function () {
            localStorage.removeItem('backgroundMusicEnabled');
            localStorage.removeItem('backgroundMusicChoiceMade');
            console.log('🔄 Audio preferences reset. Dialog will show on next interaction.');
        },
        // Enable music preference programmatically
        enableMusic: function () {
            localStorage.setItem('backgroundMusicChoiceMade', 'true');
            localStorage.setItem('backgroundMusicEnabled', 'true');
            this.play();
        },
        // Disable music preference programmatically  
        disableMusic: function () {
            localStorage.setItem('backgroundMusicChoiceMade', 'true');
            localStorage.setItem('backgroundMusicEnabled', 'false');
            this.pause();
        }
    };

    // Handle page visibility changes (pause when tab is hidden)
    document.addEventListener('visibilitychange', function () {
        if (audioInitialized && userMusicPreference === 'true') {
            if (document.hidden) {
                audio.pause();
                console.log('⏸️ Background music paused (tab hidden)');
            } else {
                audio.play().then(() => {
                    console.log('🎵 Background music resumed (tab visible)');
                }).catch((error) => {
                    console.error('Audio resume failed:', error);
                });
            }
        }
    });

    // Optional: Add keyboard shortcuts
    document.addEventListener('keydown', function (event) {
        // Ctrl + M to toggle music
        if (event.ctrlKey && event.key === 'm') {
            event.preventDefault();
            if (audioInitialized) {
                window.globalAudioControl.toggle();
            } else {
                initializeAudio();
            }
        }

        // Ctrl + Shift + M to reset preferences (for testing)
        if (event.ctrlKey && event.shiftKey && event.key === 'M') {
            event.preventDefault();
            window.globalAudioControl.resetPreference();
        }
    });

    console.log('🎵 Global Audio System initialized. User preference will be remembered across sessions.');
});

// Optional: Helper function for toast notifications (if you're using any toast library)
window.showToast = function (message, type = 'info') {
    // Example implementation for common toast libraries:

    // For TallStackUI (if you're using it):
    // $interaction('toast').success(message).send();

    // For basic browser notification:
    console.log(`${type.toUpperCase()}: ${message}`);

    // You can replace this with your preferred toast notification library
};