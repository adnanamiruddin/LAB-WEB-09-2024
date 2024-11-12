@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-semibold mb-4">Dashboard</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-blue-100 p-4 rounded-lg">
                        <h3 class="font-bold">Total Products</h3>
                        <p class="text-2xl">{{ $stats['products_count'] }}</p>
                    </div>
                    
                    <div class="bg-green-100 p-4 rounded-lg">
                        <h3 class="font-bold">Categories</h3>
                        <p class="text-2xl">{{ $stats['categories_count'] }}</p>
                    </div>
                    
                    <div class="bg-yellow-100 p-4 rounded-lg">
                        <h3 class="font-bold">Inventory Logs</h3>
                        <p class="text-2xl">{{ $stats['inventory_logs_count'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection