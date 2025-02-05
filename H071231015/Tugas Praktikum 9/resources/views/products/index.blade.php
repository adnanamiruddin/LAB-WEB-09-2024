@extends('layouts.app')
@section('title', 'Products')
@section('content')

<div class="py-12">
    <div class="max-w-7xl mx-auto">
        @if(Auth::user()->role === 'admin')
            {{-- Admin View --}}
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Manage Products</h1>
                <a href="{{ route('products.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Add New Product
                </a>
            </div>

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($products as $product)
                            <tr>
                                <td class="px-6 py-4">{{ $product->name }}</td>
                                <td class="px-6 py-4">${{ number_format($product->price, 2) }}</td>
                                <td class="px-6 py-4">{{ $product->stock }}</td>
                                <td class="px-6 py-4 flex gap-2">
                                    <a href="{{ route('products.edit', $product->id) }}" 
                                       class="text-blue-600 hover:text-blue-900">Edit</a>
                                    <form action="{{ route('products.destroy', $product->id) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            {{-- User View --}}
            <div class="mb-6">
                <h1 class="text-2xl font-bold">Available Cars</h1>
            </div>

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" x-data="{ quantity: 1 }">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $product->name }}</h3>
                            <p class="text-gray-600 mt-2">{{ $product->description }}</p>

                            <div class="mt-4">
                                <span class="text-2xl font-bold text-gray-900">
                                    ${{ number_format($product->price, 2) }}
                                </span>

                                @if($product->stock > 0)
                                    <div class="mt-2 text-sm text-gray-600">
                                        In stock: {{ $product->stock }} units
                                    </div>
                                    <form action="{{ route('cart.store') }}" method="POST" class="mt-4">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <div class="flex items-center gap-4">
                                            <input type="number" 
                                                   name="quantity" 
                                                   x-model="quantity"
                                                   min="1" 
                                                   max="{{ $product->stock }}"
                                                   class="w-20 rounded border-gray-300">
                                            <button type="submit"
                                                    x-bind:disabled="quantity < 1 || quantity > {{ $product->stock }}"
                                                    x-bind:class="{ 'opacity-50 cursor-not-allowed': quantity < 1 || quantity > {{ $product->stock }} }"
                                                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                                Add to Cart
                                            </button>
                                        </div>
                                    </form>
                                @else
                                    <div class="mt-4">
                                        <span class="inline-block px-4 py-2 bg-red-100 text-red-800 rounded">
                                            Sold Out
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endcan

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>
</div>

@endsection