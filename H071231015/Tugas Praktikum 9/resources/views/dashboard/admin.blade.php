@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold">Total Products</h3>
                        <p class="text-3xl">{{ $stats['total_products'] }}</p>
                    </div>
                </div>
            </div>

            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold">Total Value</h3>
                        <p class="text-3xl">${{ number_format($stats['products_value'], 2) }}</p>
                    </div>
                </div>
            </div>

            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold">Available Products</h3>
                        <p class="text-3xl">{{ $stats['available_products'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Recent Products</h3>
                <div class="space-y-4">
                    @foreach($stats['products'] as $product)
                        <div class="flex justify-between items-center text-gray-900 dark:text-white">
                            <span>{{ $product->name }}</span>
                            <span>${{ number_format($product->price, 2) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection