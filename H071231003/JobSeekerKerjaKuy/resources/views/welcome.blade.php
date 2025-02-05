<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JobHunt - Find Your Dream Job</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-heading {
            font-family: 'Poppins', sans-serif;
        }
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="antialiased bg-gray-50">
    <!-- Mobile Menu -->
    <div x-data="{ isOpen: false }" class="md:hidden">
        <button @click="isOpen = !isOpen" class="fixed top-4 right-4 z-50">
            <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <div x-show="isOpen" class="fixed inset-0 z-40 bg-white p-4">
            <div class="flex flex-col space-y-4">
                <a href="#" class="text-gray-700 hover:text-green-700">Home</a>
                <a href="#" class="text-gray-700 hover:text-green-700">Jobs</a>
                <a href="#" class="text-gray-700 hover:text-green-700">Companies</a>
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-green-700">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-green-700">Login</a>
                    <a href="{{ route('register') }}" class="bg-green-600 text-white px-4 py-2 rounded-md">Register</a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-green-600 font-heading">JobHunt</h1>
                </div>
                <div class="flex items-center">
                    @if (Route::has('login'))
                        <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-green-700">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-700 hover:text-green-700">Login</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Register</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Pattern -->
    <div class="relative bg-green-700 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <svg class="h-full w-full" viewBox="0 0 150 150" xmlns="http://www.w3.org/2000/svg">
                <pattern id="small-grid" width="15" height="15" patternUnits="userSpaceOnUse">
                    <path d="M 15 0 L 0 0 0 15" fill="none" stroke="white" stroke-width="0.5" />
                </pattern>
                <rect width="100%" height="100%" fill="url(#small-grid)" />
            </svg>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center text-white">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 font-heading">Find Your Dream Job Today</h1>
                <p class="text-xl md:text-2xl mb-8">Connect with top employers and opportunities</p>
                {{-- <div class="max-w-3xl mx-auto bg-white rounded-lg p-2 flex flex-col md:flex-row gap-2"> --}}
                    {{-- <input type="text" placeholder="Job title or keyword" class="flex-1 p-3 border rounded">
                    <input type="text" placeholder="Location" class="flex-1 p-3 border rounded"> --}}
                    {{-- <button class="bg-green-600 text-white px-8 py-3 rounded hover:bg-green-700">
                        Search Jobs
                    </button> --}}
                {{-- </div> --}}
            </div>
        </div>
    </div>

    <!-- Job Categories -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12 font-heading">Popular Job Categories</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="p-6 border rounded-lg text-center hover:shadow-lg transition-shadow">
                    <svg class="h-12 w-12 text-green-600 mx-auto mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <h3 class="font-semibold">Technology</h3>
                    <p class="text-gray-500">1200+ Jobs</p>
                </div>
                <!-- Add more categories similarly -->
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                <!-- Feature 1 -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="text-green-600 mb-4">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 font-heading">Search Jobs</h3>
                    <p class="text-gray-600">Browse through thousands of job listings from top companies.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="text-green-600 mb-4">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 font-heading">Create Profile</h3>
                    <p class="text-gray-600">Build your professional profile and get noticed by employers.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="text-green-600 mb-4">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 font-heading">Apply Instantly</h3>
                    <p class="text-gray-600">Apply to jobs with just one click and track your applications.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Job Listings Section -->
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 font-heading">Latest Job Listings</h2>
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($jobs as $job)
                    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow cursor-pointer">
                        <h3 class="text-xl font-semibold mb-2 font-heading">{{ $job->title }}</h3>
                        <p class="text-gray-600">{{ $job->location }}</p>
                        <p class="text-gray-600">{{ $job->job_type }}</p>
                        <a href="{{ route('login') }}" class="text-green-600 hover:text-green-900 mt-4 block">View
                            Details</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


    <!-- Call to Action -->
    <div class="bg-green-700 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-4 font-heading">Ready to Start Your Career Journey?</h2>
            <p class="text-green-100 mb-8">Join thousands of job seekers who found their dream jobs through our
                platform</p>
            <a href="{{ route('register') }}"
                class="bg-white text-green-600 px-8 py-3 rounded-lg font-semibold hover:bg-green-50">
                Create Your Profile
            </a>
        </div>
    </div>

    <!-- Enhanced Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-white font-semibold mb-4">For Job Seekers</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-white">Browse Jobs</a></li>
                        <li><a href="#" class="hover:text-white">Create Resume</a></li>
                        <li><a href="#" class="hover:text-white">Job Alerts</a></li>
                    </ul>
                </div>
                <!-- Add more footer sections -->
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                <p>© {{ date('Y') }} JobSeeker. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>
