@extends('layouts.app')
@section('title', 'Car Store Management')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-blue-900 via-gray-900 to-gray-800">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
    <div class="relative max-w-6xl mx-auto px-4 py-20">
        <div class="text-center">
            <h1 class="text-6xl font-bold text-white mb-6 tracking-tight">
                Car Store Management
            </h1>
            <p class="text-2xl text-gray-200 max-w-2xl mx-auto">
                Streamline your automotive business operations with our comprehensive management system
            </p>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-4 py-12">
    <!-- Welcome Message -->
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Welcome to Car Store</h2>
        <p class="text-xl text-gray-600">Manage your automotive business all in one place</p>
    </div>

    <!-- Quick Actions Section - Positioned before cards -->
    <div class="mb-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">
            Quick Actions
        </h2>
        <div class="flex justify-center gap-6">
            <a href="{{ route('products.create') }}" 
               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-800 text-white text-lg font-semibold rounded-xl hover:from-blue-700 hover:to-blue-900 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add New Car
            </a>
            <a href="{{ route('inventory.create') }}" 
               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-emerald-600 to-emerald-800 text-white text-lg font-semibold rounded-xl hover:from-emerald-700 hover:to-emerald-900 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Log Inventory
            </a>
        </div>
    </div>

    <!-- Management Cards -->
    <div class="grid md:grid-cols-3 gap-8">
        <!-- Categories Card -->
        <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-4">
                    <div class="p-4 bg-blue-100 rounded-2xl">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Categories</h2>
                </div>
                <a href="{{ route('categories.index') }}" 
                   class="text-blue-600 hover:text-blue-800 font-semibold flex items-center gap-2">
                    View all
                    <span class="text-xl">→</span>
                </a>
            </div>
            <p class="text-gray-600 text-lg">
                Organize your cars into different categories for better management and tracking
            </p>
        </div>

        <!-- Products Card -->
        <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-4">
                    <div class="p-4 bg-indigo-100 rounded-2xl">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Products</h2>
                </div>
                <a href="{{ route('products.index') }}" 
                   class="text-indigo-600 hover:text-indigo-800 font-semibold flex items-center gap-2">
                    View all
                    <span class="text-xl">→</span>
                </a>
            </div>
            <p class="text-gray-600 text-lg">
                Manage your car listings, pricing strategies, and inventory levels
            </p>
        </div>

        <!-- Inventory Card -->
        <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-4">
                    <div class="p-4 bg-emerald-100 rounded-2xl">
                        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Inventory</h2>
                </div>
                <a href="{{ route('inventory.index') }}" 
                   class="text-emerald-600 hover:text-emerald-800 font-semibold flex items-center gap-2">
                    View all
                    <span class="text-xl">→</span>
                </a>
            </div>
            <p class="text-gray-600 text-lg">
                Track inventory changes and manage stock levels efficiently
            </p>
        </div>
    </div>
</div>
@endsection