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

document.addEventListener('DOMContentLoaded', function() {
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
    
    // Audio state management
    let audioInitialized = false;
    let userInteracted = false;
    
    // Function to initialize audio with user confirmation
    function initializeAudio() {
        if (audioInitialized || userInteracted) return;
        
        // Show browser dialog for user interaction
        const userWantsMusic = confirm("🎵 Ingin mendengarkan background music selama browsing?\n\nKlik OK untuk memutar musik, Cancel untuk browsing dalam keheningan.");
        
        userInteracted = true;
        
        if (userWantsMusic) {
            audio.play().then(() => {
                audioInitialized = true;
                console.log('🎵 Background music started');
                
                // Show success notification (optional)
                if (typeof window.showToast === 'function') {
                    window.showToast('🎵 Background music dimulai!', 'success');
                }
            }).catch((error) => {
                console.error('Audio play failed:', error);
                alert('⚠️ Gagal memutar musik. Browser Anda mungkin memblokir autoplay audio.');
            });
        } else {
            console.log('🔇 User declined background music');
            
            // Show declined notification (optional)  
            if (typeof window.showToast === 'function') {
                window.showToast('🔇 Background music dinonaktifkan', 'info');
            }
        }
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
        play: function() {
            if (audio.paused) {
                audio.play().then(() => {
                    console.log('🎵 Background music resumed');
                }).catch((error) => {
                    console.error('Audio play failed:', error);
                });
            }
        },
        pause: function() {
            if (!audio.paused) {
                audio.pause();
                console.log('⏸️ Background music paused');
            }
        },
        toggle: function() {
            if (audio.paused) {
                this.play();
            } else {
                this.pause();
            }
        },
        setVolume: function(volume) {
            audio.volume = Math.max(0, Math.min(1, volume));
            console.log(`🔊 Volume set to ${Math.round(audio.volume * 100)}%`);
        },
        getStatus: function() {
            return {
                isPlaying: !audio.paused,
                volume: audio.volume,
                currentTime: audio.currentTime,
                duration: audio.duration
            };
        }
    };
    
    // Handle page visibility changes (pause when tab is hidden)
    document.addEventListener('visibilitychange', function() {
        if (audioInitialized) {
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
    document.addEventListener('keydown', function(event) {
        // Ctrl + M to toggle music
        if (event.ctrlKey && event.key === 'm') {
            event.preventDefault();
            if (audioInitialized) {
                window.globalAudioControl.toggle();
            } else {
                initializeAudio();
            }
        }
    });
    
    console.log('🎵 Global Audio System initialized. First interaction will prompt for background music.');
});

// Optional: Helper function for toast notifications (if you're using any toast library)
window.showToast = function(message, type = 'info') {
    // Example implementation for common toast libraries:
    
    // For TallStackUI (if you're using it):
    // $interaction('toast').success(message).send();
    
    // For basic browser notification:
    console.log(`${type.toUpperCase()}: ${message}`);
    
    // You can replace this with your preferred toast notification library
};