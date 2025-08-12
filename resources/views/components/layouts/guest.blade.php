<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        {{-- Favicon --}}
        <link rel="icon" href="{{ asset('images/jkb.png') }}">

        {{-- Fonts --}}
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">

        {{-- Styles --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Background Animations */
            @keyframes gradientWave {
                0% {
                    background-position: 0% 50%;
                }

                50% {
                    background-position: 100% 50%;
                }

                100% {
                    background-position: 0% 50%;
                }
            }

            @keyframes float {
                0% {
                    transform: translateY(0px) rotate(0deg);
                }

                33% {
                    transform: translateY(-30px) rotate(120deg);
                }

                66% {
                    transform: translateY(20px) rotate(240deg);
                }

                100% {
                    transform: translateY(0px) rotate(360deg);
                }
            }

            @keyframes pulse {

                0%,
                100% {
                    opacity: 0.3;
                    transform: scale(1);
                }

                50% {
                    opacity: 0.8;
                    transform: scale(1.1);
                }
            }

            @keyframes slideIn {
                0% {
                    transform: translateX(-100%);
                    opacity: 0;
                }

                100% {
                    transform: translateX(0%);
                    opacity: 1;
                }
            }

            @keyframes zigzag {
                0% {
                    transform: translateX(0) translateY(0);
                }

                25% {
                    transform: translateX(30px) translateY(-20px);
                }

                50% {
                    transform: translateX(-20px) translateY(-40px);
                }

                75% {
                    transform: translateX(40px) translateY(-60px);
                }

                100% {
                    transform: translateX(0) translateY(-80px);
                }
            }

            .animated-bg {
                background: linear-gradient(-45deg, #667eea, #764ba2, #f093fb, #f5576c, #4facfe, #00f2fe);
                background-size: 400% 400%;
                animation: gradientWave 15s ease infinite;
            }

            .floating-shape {
                position: absolute;
                animation: float 20s ease-in-out infinite;
                opacity: 0.1;
            }

            .pulsing-circle {
                position: absolute;
                border-radius: 50%;
                animation: pulse 4s ease-in-out infinite;
            }

            .sliding-bar {
                position: absolute;
                height: 2px;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.6), transparent);
                animation: slideIn 3s ease-in-out infinite;
            }

            .particle {
                position: absolute;
                width: 4px;
                height: 4px;
                background: white;
                border-radius: 50%;
                opacity: 0.3;
                animation: zigzag 8s linear infinite;
            }

            /* Glass morphism effect */
            .glass-card {
                backdrop-filter: blur(20px);
                background: rgba(255, 255, 255, 0.25);
                border: 1px solid rgba(255, 255, 255, 0.18);
                box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            }

            /* Smooth card entrance */
            @keyframes cardEntrance {
                0% {
                    transform: translateY(30px);
                    opacity: 0;
                }

                100% {
                    transform: translateY(0);
                    opacity: 1;
                }
            }

            .card-entrance {
                animation: cardEntrance 0.8s ease-out forwards;
            }

            /* Responsive floating shapes */
            .shape-1 {
                animation-delay: -2s;
            }

            .shape-2 {
                animation-delay: -4s;
            }

            .shape-3 {
                animation-delay: -6s;
            }

            .shape-4 {
                animation-delay: -8s;
            }

            .shape-5 {
                animation-delay: -10s;
            }

            .pulse-1 {
                animation-delay: -1s;
            }

            .pulse-2 {
                animation-delay: -2s;
            }

            .pulse-3 {
                animation-delay: -3s;
            }

            .particle-1 {
                animation-delay: -1s;
            }

            .particle-2 {
                animation-delay: -3s;
            }

            .particle-3 {
                animation-delay: -5s;
            }

            .particle-4 {
                animation-delay: -7s;
            }

            /* Bouncing Photos */
            .bouncing-photo {
                position: absolute;
                width: 120px;
                height: 120px;
                border-radius: 50%;
                object-fit: cover;
                z-index: 1;
                opacity: 0.9;
                animation: spin 8s linear infinite;
            }

            .bouncing-photo:hover {
                transform: scale(1.1);
                box-shadow: 0 6px 25px rgba(0, 0, 0, 0.4);
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }

            @keyframes bounceScale {
                0% {
                    transform: scale(1) rotate(var(--rotation, 0deg));
                }

                50% {
                    transform: scale(1.2) rotate(var(--rotation, 0deg));
                }

                100% {
                    transform: scale(1) rotate(var(--rotation, 0deg));
                }
            }

            /* Dark mode support */
            .dark .glass-card {
                background: rgba(17, 24, 39, 0.25);
                border: 1px solid rgba(75, 85, 99, 0.18);
            }
        </style>
    </head>

    <body class="font-sans antialiased">
        <!-- Animated Background -->
        <div class="min-h-screen animated-bg relative overflow-hidden">

            <!-- Bouncing Photos -->
            <img src="{{ asset('images/rizky.png') }}" alt="Photo 1" class="bouncing-photo" id="photo1">
            <img src="{{ asset('images/dodi.png') }}" alt="Photo 2" class="bouncing-photo" id="photo2">
            <img src="{{ asset('images/alex.png') }}" alt="Photo 3" class="bouncing-photo" id="photo3">
            <img src="{{ asset('images/masjo.png') }}" alt="Photo 4" class="bouncing-photo" id="photo4">
            <img src="{{ asset('images/rama.png') }}" alt="Photo 4" class="bouncing-photo" id="photo4">
            <img src="{{ asset('images/goji.png') }}" alt="Photo 4" class="bouncing-photo" id="photo4">
            <img src="{{ asset('images/iqal.png') }}" alt="Photo 4" class="bouncing-photo" id="photo4">
            <img src="{{ asset('images/arjun.png') }}" alt="Photo 4" class="bouncing-photo" id="photo4">

            <!-- Floating Geometric Shapes -->
            <div class="floating-shape shape-1 top-10 left-10 w-20 h-20">
                <div class="w-full h-full bg-white rounded-lg transform rotate-45"></div>
            </div>
            <div class="floating-shape shape-2 top-32 right-20 w-16 h-16">
                <div class="w-full h-full bg-white rounded-full"></div>
            </div>
            <div class="floating-shape shape-3 bottom-32 left-20 w-24 h-24">
                <div class="w-full h-full bg-white" style="clip-path: polygon(50% 0%, 0% 100%, 100% 100%)"></div>
            </div>
            <div class="floating-shape shape-4 top-1/2 right-10 w-12 h-12">
                <div class="w-full h-full bg-white rounded-lg transform rotate-12"></div>
            </div>
            <div class="floating-shape shape-5 bottom-10 right-1/3 w-18 h-18">
                <div class="w-full h-full bg-white rounded-full"></div>
            </div>

            <!-- Pulsing Circles -->
            <div class="pulsing-circle pulse-1 top-20 left-1/4 w-32 h-32 bg-white"></div>
            <div class="pulsing-circle pulse-2 bottom-20 right-1/4 w-24 h-24 bg-white"></div>
            <div class="pulsing-circle pulse-3 top-1/3 left-1/2 w-40 h-40 bg-white"></div>

            <!-- Sliding Bars -->
            <div class="sliding-bar top-40 w-64" style="animation-delay: -1s;"></div>
            <div class="sliding-bar bottom-40 w-48" style="animation-delay: -2s;"></div>
            <div class="sliding-bar top-2/3 w-32" style="animation-delay: -3s;"></div>

            <!-- Floating Particles -->
            <div class="particle particle-1 top-1/4 left-10"></div>
            <div class="particle particle-2 top-1/3 right-20"></div>
            <div class="particle particle-3 bottom-1/4 left-1/3"></div>
            <div class="particle particle-4 bottom-1/3 right-1/3"></div>

            <!-- Login Card Container -->
            <div class="min-h-screen flex items-center justify-center p-4">
                <div class="w-full max-w-md">
                    <!-- Login Card -->
                    <div class="glass-card rounded-2xl p-8 card-entrance">
                        <!-- Logo Area -->
                        <div class="text-center mb-8">
                            <div class="inline-flex items-center space-x-3 mb-4">
                                <div class="p-2 bg-white bg-opacity-20 rounded-xl backdrop-blur-sm">
                                    <img src="{{ asset('images/jkb.png') }}" class="h-8 w-auto" alt="Logo">
                                </div>
                                <span class="text-xl font-bold text-white">
                                    {{ config('app.name', 'Laravel') }}
                                </span>
                            </div>
                        </div>

                        <!-- Login Content -->
                        <div class="space-y-6">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Background Elements -->
            <div class="absolute inset-0 pointer-events-none">
                <!-- Grid Overlay -->
                <div class="absolute inset-0 opacity-5">
                    <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <defs>
                            <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                                <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5" />
                            </pattern>
                        </defs>
                        <rect width="100" height="100" fill="url(#grid)" />
                    </svg>
                </div>
            </div>
        </div>

        <script>
            // Bouncing Photos Animation
            class BouncingPhoto {
                constructor(element) {
                    this.element = element;
                    this.x = Math.random() * (window.innerWidth - 120);
                    this.y = Math.random() * (window.innerHeight - 120);
                    this.speedX = (Math.random() - 0.5) * 4; // Random speed between -2 and 2
                    this.speedY = (Math.random() - 0.5) * 4;
                    this.size = 120;

                    // Ensure minimum speed
                    if (Math.abs(this.speedX) < 1) this.speedX = this.speedX > 0 ? 1 : -1;
                    if (Math.abs(this.speedY) < 1) this.speedY = this.speedY > 0 ? 1 : -1;

                    this.updatePosition();
                }

                updatePosition() {
                    this.element.style.left = this.x + 'px';
                    this.element.style.top = this.y + 'px';
                }

                move() {
                    // Update position
                    this.x += this.speedX;
                    this.y += this.speedY;

                    // Bounce off edges
                    if (this.x <= 0 || this.x >= window.innerWidth - this.size) {
                        this.speedX = -this.speedX;
                        this.x = Math.max(0, Math.min(this.x, window.innerWidth - this.size));

                        // Add bounce effect (scale only, preserve spin)
                        this.element.style.animation = 'spin 8s linear infinite, bounceScale 0.3s ease';
                        setTimeout(() => {
                            this.element.style.animation = 'spin 8s linear infinite';
                        }, 300);
                    }

                    if (this.y <= 0 || this.y >= window.innerHeight - this.size) {
                        this.speedY = -this.speedY;
                        this.y = Math.max(0, Math.min(this.y, window.innerHeight - this.size));

                        // Add bounce effect (scale only, preserve spin)
                        this.element.style.animation = 'spin 8s linear infinite, bounceScale 0.3s ease';
                        setTimeout(() => {
                            this.element.style.animation = 'spin 8s linear infinite';
                        }, 300);
                    }

                    this.updatePosition();
                }

                resize() {
                    // Handle window resize
                    this.x = Math.min(this.x, window.innerWidth - this.size);
                    this.y = Math.min(this.y, window.innerHeight - this.size);
                    this.updatePosition();
                }
            }

            // Initialize bouncing photos
            let bouncingPhotos = [];

            document.addEventListener('DOMContentLoaded', function() {
                // Create bouncing photo instances
                const photoElements = document.querySelectorAll('.bouncing-photo');
                photoElements.forEach(photo => {
                    bouncingPhotos.push(new BouncingPhoto(photo));
                });

                // Animation loop
                function animate() {
                    bouncingPhotos.forEach(photo => photo.move());
                    requestAnimationFrame(animate);
                }

                // Start animation
                animate();

                // Handle window resize
                window.addEventListener('resize', () => {
                    bouncingPhotos.forEach(photo => photo.resize());
                });

                // Add some dynamic interactivity
                let mouseParticles = [];

                document.addEventListener('mousemove', function(e) {
                    // Limit particle creation
                    if (mouseParticles.length < 5) {
                        createMouseParticle(e.clientX, e.clientY);
                    }
                });

                function createMouseParticle(x, y) {
                    const particle = document.createElement('div');
                    particle.className = 'absolute w-2 h-2 bg-white rounded-full opacity-30 pointer-events-none';
                    particle.style.left = x + 'px';
                    particle.style.top = y + 'px';
                    particle.style.animation = 'zigzag 3s linear forwards';

                    document.body.appendChild(particle);
                    mouseParticles.push(particle);

                    // Remove particle after animation
                    setTimeout(() => {
                        if (particle.parentNode) {
                            particle.parentNode.removeChild(particle);
                        }
                        mouseParticles = mouseParticles.filter(p => p !== particle);
                    }, 3000);
                }

                // Add random twinkling stars
                function createTwinklingStar() {
                    const star = document.createElement('div');
                    star.className = 'absolute w-1 h-1 bg-white rounded-full opacity-0';
                    star.style.left = Math.random() * window.innerWidth + 'px';
                    star.style.top = Math.random() * window.innerHeight + 'px';
                    star.style.animation = 'pulse 2s ease-in-out';

                    document.body.appendChild(star);

                    setTimeout(() => {
                        if (star.parentNode) {
                            star.parentNode.removeChild(star);
                        }
                    }, 2000);
                }

                // Create twinkling stars periodically
                setInterval(createTwinklingStar, 1500);
            });
        </script>
    </body>

</html>
