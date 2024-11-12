@extends('layouts.master')
@section('title', $title)
@section('content')
    <div class="max-w-4xl mx-auto">

        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ $title }}</h1>
            <div class="w-24 h-1 bg-blue-600 mx-auto mb-8"></div>
            <p class="text-lg text-gray-600 leading-relaxed">{{ $message }}</p>
        </div>

        <div class="grid md:grid-cols-2 gap-12 items-center mb-12">

            <div class="rounded-lg overflow-hidden shadow-lg">
                <img src="{{ asset('images/img.png') }}" alt="About Us" class="w-full h-auto">
            </div>

            <div class="space-y-6">
                <h2 class="text-2xl font-semibold text-gray-800">Our Story</h2>
                <p class="text-gray-600">
                    masih pemula puh
                </p>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <span class="text-blue-600 mr-2">✓</span>
                        <span class="text-gray-700">Professional Team</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-blue-600 mr-2">✓</span>
                        <span class="text-gray-700">Quality Service</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-blue-600 mr-2">✓</span>
                        <span class="text-gray-700">24/7 Support</span>
                    </div>
                </div>
                <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg shadow-md 
                    transform transition duration-200 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Learn More
                    <span class="ml-2">→</span>
                </button>
            </div>
        </div>

    </div>
@endsection