@extends('layouts.master')
@section('title', $title)
@section('content')
    <div class="max-w-4xl mx-auto text-center">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ $title }}</h1>

        <p class="text-lg text-gray-600 mb-8 leading-relaxed">{{ $message }}</p>

        <button
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg shadow-md 
        transform transition duration-200 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
            Explore
            <span class="ml-2">→</span>
        </button>

        <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">

            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <div class="text-blue-600 mb-4">
                    <!-- Simple icon using emojis -->
                    <span class="text-4xl">🚀</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Fast</h3>
                <p class="text-gray-600">Kami cepat merespon Anda</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <div class="text-blue-600 mb-4">
                    <span class="text-4xl">🛠️</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Flexible</h3>
                <p class="text-gray-600">Kami dapat memenuhi beragam permintaan pelanggan</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <div class="text-blue-600 mb-4">
                    <span class="text-4xl">🔒</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Secure</h3>
                <p class="text-gray-600">Website kami terjamin aman dari serangan cybersecurity</p>
            </div>
        </div>
    </div>
@endsection
