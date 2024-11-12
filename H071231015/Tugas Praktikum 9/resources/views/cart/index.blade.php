@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-6">Your Shopping Cart</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                @if($cartItems->count() > 0)
                    <div class="space-y-4">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($cartItems as $item)
                                    @php 
                                        $subtotal = $item['price'] * $item['quantity'];
                                    @endphp
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $item['name'] }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            ${{ number_format($item['price'], 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="flex items-center">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" 
                                                       name="quantity" 
                                                       value="{{ $item['quantity'] }}" 
                                                       min="1"
                                                       class="w-20 rounded border-gray-300">
                                                <button type="submit" 
                                                        class="ml-2 text-sm text-blue-600 hover:text-blue-900">
                                                    Update
                                                </button>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            ${{ number_format($subtotal, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form action="{{ route('cart.destroy', $item['id']) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-900">
                                                    Remove
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-6 flex justify-between items-center">
                            <div class="flex space-x-4">
                                <a href="{{ route('products.index') }}" 
                                   class="text-blue-600 hover:text-blue-900">
                                    Continue Shopping
                                </a>
                                <form action="{{ route('cart.clear') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        Clear Cart
                                    </button>
                                </form>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-semibold">
                                    Total: ${{ number_format($total, 2) }}
                                </div>
                                <button class="mt-4 bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                                    Checkout
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-gray-500">Your cart is empty</p>
                    <a href="{{ route('products.index') }}" 
                       class="inline-block mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Continue Shopping
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection