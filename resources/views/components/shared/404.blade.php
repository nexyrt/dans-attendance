<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>404 - Page Not Found | {{ config('app.name') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" href="{{ asset('images/jkb.png') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            @keyframes float {
                0% {
                    transform: translate(0px, 0px) rotate(0deg);
                }

                50% {
                    transform: translate(15px, 15px) rotate(5deg);
                }

                100% {
                    transform: translate(0px, 0px) rotate(0deg);
                }
            }

            @keyframes float-reverse {
                0% {
                    transform: translate(0px, 0px) rotate(0deg);
                }

                50% {
                    transform: translate(-15px, 15px) rotate(-5deg);
                }

                100% {
                    transform: translate(0px, 0px) rotate(0deg);
                }
            }

            .float-animation {
                animation: float 6s ease-in-out infinite;
            }

            .float-reverse-animation {
                animation: float-reverse 7s ease-in-out infinite;
            }

            .circles {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                overflow: hidden;
                z-index: 1;
            }

            .circles li {
                position: absolute;
                display: block;
                list-style: none;
                width: 20px;
                height: 20px;
                background: rgba(255, 255, 255, 0.1);
                animation: animate 25s linear infinite;
                bottom: -150px;
                border-radius: 50%;
            }

            .btn-primary {
                position: relative;
                overflow: hidden;
                transition: all 0.3s ease;
            }

            .btn-primary::before {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                width: 300px;
                height: 300px;
                background: rgba(255, 255, 255, 0.2);
                border-radius: 50%;
                transform: translate(-50%, -50%) scale(0);
                transition: transform 0.5s ease;
            }

            .btn-primary:hover::before {
                transform: translate(-50%, -50%) scale(1);
            }

            .btn-secondary {
                position: relative;
                overflow: hidden;
                transition: all 0.3s ease;
            }

            .btn-secondary::after {
                content: '';
                position: absolute;
                width: 100%;
                height: 2px;
                bottom: 0;
                left: 0;
                background: currentColor;
                transform: scaleX(0);
                transform-origin: right;
                transition: transform 0.3s ease;
            }

            .btn-secondary:hover::after {
                transform: scaleX(1);
                transform-origin: left;
            }

            @keyframes animate {
                0% {
                    transform: translateY(0) rotate(0deg);
                    opacity: 1;
                    border-radius: 0;
                }

                100% {
                    transform: translateY(-1000px) rotate(720deg);
                    opacity: 0;
                    border-radius: 50%;
                }
            }
        </style>
    </head>

    <body class="antialiased">
        <div
            class="relative min-h-screen bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 flex items-center justify-center px-6">
            <!-- Animated Background Elements -->
            <ul class="circles">
                <li style="left: 25%; width: 80px; height: 80px; animation-delay: 0s;"></li>
                <li style="left: 10%; width: 20px; height: 20px; animation-delay: 2s; animation-duration: 12s;"></li>
                <li style="left: 70%; width: 40px; height: 40px; animation-delay: 4s;"></li>
                <li style="left: 40%; width: 60px; height: 60px; animation-delay: 0s; animation-duration: 18s;"></li>
                <li style="left: 65%; width: 20px; height: 20px; animation-delay: 0s;"></li>
                <li style="left: 75%; width: 110px; height: 110px; animation-delay: 3s;"></li>
                <li style="left: 35%; width: 150px; height: 150px; animation-delay: 7s;"></li>
                <li style="left: 50%; width: 25px; height: 25px; animation-delay: 15s; animation-duration: 45s;"></li>
                <li style="left: 20%; width: 15px; height: 15px; animation-delay: 2s; animation-duration: 35s;"></li>
                <li style="left: 85%; width: 150px; height: 150px; animation-delay: 0s; animation-duration: 11s;"></li>
            </ul>

            <!-- Main Content -->
            <div class="relative z-10 text-center">
                <!-- Logo -->
                <div class="mb-8 float-animation">
                    <div
                        class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-white/10 backdrop-blur-sm">
                        <img src="{{ asset('images/jkb.png') }}" alt="JKB" class="w-12 h-12">
                    </div>
                </div>

                <!-- Error Message -->
                <div class="max-w-md mx-auto mb-8 space-y-8">
                    <h1 class="relative text-[120px] font-bold leading-none text-white opacity-25">
                        404
                    </h1>

                    <div
                        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 float-reverse-animation">
                        <img src="{{ asset('images/jkb.png') }}" alt="404 Illustration" class="w-32 h-32 opacity-50">
                    </div>

                    <div class="relative space-y-4">
                        <h2 class="text-2xl font-bold text-white">Link nya salah cuy, balik sono!</h2>
                        <p class="text-blue-100">
                            Sa ae pentil kuda!
                        </p>
                    </div>
                </div>

                <!-- Modified Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    @auth
                        @if (auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                                class="btn-primary px-8 py-3 bg-white text-blue-600 font-semibold rounded-lg shadow-md hover:shadow-lg hover:transform hover:-translate-y-0.5 transition-all">
                                Back to Admin Dashboard
                            </a>
                        @elseif(auth()->user()->role === 'staff')
                            <a href="{{ route('staff.dashboard') }}"
                                class="btn-primary px-8 py-3 bg-white text-blue-600 font-semibold rounded-lg shadow-md hover:shadow-lg hover:transform hover:-translate-y-0.5 transition-all">
                                Back to Staff Dashboard
                            </a>
                        @elseif(auth()->user()->role === 'manager')
                            <a href="{{ route('manager.dashboard') }}"
                                class="btn-primary px-8 py-3 bg-white text-blue-600 font-semibold rounded-lg shadow-md hover:shadow-lg hover:transform hover:-translate-y-0.5 transition-all">
                                Back to Manager Dashboard
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                            class="btn-primary px-8 py-3 bg-white text-blue-600 font-semibold rounded-lg shadow-md hover:shadow-lg hover:transform hover:-translate-y-0.5 transition-all">
                            Login
                        </a>
                    @endauth

                    <button onclick="window.history.back()"
                        class="btn-secondary px-8 py-3 bg-transparent text-white font-semibold rounded-lg hover:bg-white/10 transition-all">
                        Go Back
                    </button>
                </div>


                <!-- Support Link -->
                <p class="mt-8 text-sm text-blue-100">
                    Butuh bantuan?? <a href="#" class="underline hover:text-white">Hubungin rizky lah!</a>
                </p>
            </div>
        </div>
    </body>

</html>
