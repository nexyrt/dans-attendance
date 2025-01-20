<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" href="{{ asset('images/icons/icon-72x72.png') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            @keyframes float {
                0% {
                    transform: translateY(0px);
                }

                50% {
                    transform: translateY(-20px);
                }

                100% {
                    transform: translateY(0px);
                }
            }

            .floating {
                animation: float 6s ease-in-out infinite;
            }

            @keyframes gradientBG {
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

            .animated-bg {
                background: linear-gradient(-45deg, #3b82f6, #1d4ed8, #2563eb, #3b82f6);
                background-size: 400% 400%;
                animation: gradientBG 15s ease infinite;
            }

            .glass-effect {
                backdrop-filter: blur(10px);
                background: rgba(255, 255, 255, 0.1);
            }

            .text-glow {
                text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
            }
        </style>
    </head>

    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col md:flex-row">
            <!-- Left Section - Login Form -->
            <div class="w-full md:w-1/2 p-8 md:p-12 lg:p-16 flex flex-col bg-white dark:bg-gray-900">
                <!-- Logo Area -->
                <div class="mb-12 flex items-center space-x-3">
                    <div class="p-2 bg-gradient-to-tr from-blue-600 to-blue-800 rounded-xl shadow-lg">
                        <img src="{{ asset('dans.png') }}" class="h-8 w-auto" alt="Logo">
                    </div>
                    <span
                        class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-blue-800">
                        Dans Attendance
                    </span>
                </div>

                <!-- Main Content Area -->
                <div class="flex-grow flex flex-col justify-center max-w-md mx-auto w-full">
                    {{ $slot }}
                </div>
            </div>

            <!-- Right Section - Dynamic Content -->
            <div class="hidden md:block md:w-1/2 relative overflow-hidden animated-bg">
                <!-- Overlay Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid slice">
                        <defs>
                            <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                                <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5" />
                            </pattern>
                        </defs>
                        <rect width="100" height="100" fill="url(#grid)" />
                    </svg>
                </div>

                <!-- Floating Elements -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="relative w-full h-full">
                        <!-- Abstract Shapes -->
                        <div class="absolute top-1/4 left-1/4 w-32 h-32 floating" style="animation-delay: -2s">
                            <div class="absolute inset-0 rounded-full bg-white opacity-10 transform rotate-45"></div>
                        </div>
                        <div class="absolute bottom-1/4 right-1/4 w-40 h-40 floating" style="animation-delay: -1s">
                            <div class="absolute inset-0 rounded-full bg-white opacity-10"></div>
                        </div>
                        <div class="absolute top-1/3 right-1/3 w-24 h-24 floating" style="animation-delay: -3s">
                            <div class="absolute inset-0 rounded-lg bg-white opacity-10 transform -rotate-12"></div>
                        </div>

                        <!-- Content Cards -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="glass-effect rounded-2xl p-8 max-w-sm mx-4 transform transition-all duration-500"
                                id="content-cards">
                                <div class="text-white space-y-4 text-center">
                                    <h2 class="text-3xl font-bold text-glow card-title">Welcome Back!</h2>
                                    <p class="text-lg text-blue-100 card-description">Track your time effortlessly with
                                        Dans
                                        Attendance</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Content rotation
            const contents = [{
                    title: "Welcome Back!",
                    description: "Track your time effortlessly with Dans Attendance"
                },
                {
                    title: "Stay Organized",
                    description: "Manage your schedule with ease and precision"
                },
                {
                    title: "Boost Productivity",
                    description: "Make every minute count in your workday"
                }
            ];

            let currentIndex = 0;
            const cardTitle = document.querySelector('.card-title');
            const cardDescription = document.querySelector('.card-description');

            function updateContent() {
                const content = contents[currentIndex];

                // Fade out
                cardTitle.style.opacity = 0;
                cardDescription.style.opacity = 0;

                setTimeout(() => {
                    // Update content
                    cardTitle.textContent = content.title;
                    cardDescription.textContent = content.description;

                    // Fade in
                    cardTitle.style.opacity = 1;
                    cardDescription.style.opacity = 1;

                    // Update index
                    currentIndex = (currentIndex + 1) % contents.length;
                }, 500);
            }

            // Initial delay then start rotation
            setTimeout(() => {
                setInterval(updateContent, 5000);
            }, 2000);

            // Add transition styles
            cardTitle.style.transition = 'opacity 0.5s ease';
            cardDescription.style.transition = 'opacity 0.5s ease';
        </script>
    </body>

</html>
