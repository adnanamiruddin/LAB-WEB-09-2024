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

        <!-- Additional Fonts & Icons -->
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .morphic-bg {
                background: linear-gradient(135deg, #218838 0%, #4dbf6b 100%);
                position: relative;
                overflow: hidden;
            }
            .morphic-shape {
                position: absolute;
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(5px);
                border-radius: 50%;
                animation: float 8s infinite;
            }
            @keyframes float {
                0%, 100% { transform: translate(0, 0); }
                50% { transform: translate(-20px, -20px); }
            }

            /* Green Text and Hover Effects */
            .text-green-custom {
                color: #218838;
            }
            .hover\:text-green-custom:hover {
                color: #218838;
            }
            .bg-green-custom {
                background-color: #218838;
            }
            .bg-green-custom-light {
                background-color: #4dbf6b;
            }
            .hover\:bg-green-custom-light:hover {
                background-color: #4dbf6b;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen morphic-bg flex flex-col items-center justify-center p-4">
            <!-- Animated Background Shapes -->
            <div class="morphic-shape w-72 h-72 top-0 left-0 opacity-30"></div>
            <div class="morphic-shape w-96 h-96 bottom-0 right-0 opacity-20" style="animation-delay: 2s"></div>
            
            <!-- Logo Section -->
            <div class="relative z-10 mb-8 text-center">
                <h1 class="text-4xl font-bold text-white mb-2">
                    <i class="fas fa-briefcase mr-2"></i>JobHunt
                </h1>
                <p class="text-white/80">Find the Right Job for You</p>
            </div>

            <!-- Main Content Card -->
            <div class="relative z-10 w-full max-w-md">
                <div class="backdrop-blur-xl bg-white/10 p-8 rounded-2xl shadow-2xl border border-white/20">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer -->
            <div class="relative z-10 mt-8 text-white/70 text-sm text-center">
                <p>&copy; {{ date('Y') }} JobHunt. All rights reserved.</p>
                <div class="mt-2 space-x-4">
                    <a href="#" class="hover:text-green-custom transition-colors">Terms</a>
                    <a href="#" class="hover:text-green-custom transition-colors">Privacy</a>
                    <a href="#" class="hover:text-green-custom transition-colors">Support</a>
                </div>
            </div>
        </div>
    </body>
</html>
