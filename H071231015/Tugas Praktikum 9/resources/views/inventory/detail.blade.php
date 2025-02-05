@extends('layouts.app')
@section('title', 'Inventory Log Details')
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Inventory Log Details</h1>
        <a href="{{ route('inventory.index') }}" 
           class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
            Back to List
        </a>
    </div>
    
    <div class="bg-white shadow-sm rounded-lg p-6">
        <dl class="grid grid-cols-1 gap-4">
            <div>
                <dt class="text-sm font-medium text-gray-500">Product</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $log->product->name }}</dd>
            </div>
            
            <div>
                <dt class="text-sm font-medium text-gray-500">Type</dt>
                <dd class="mt-1">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        {{ $log->type === 'restock' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ ucfirst($log->type) }}
                    </span>
                </dd>
            </div>
            
            <div>
                <dt class="text-sm font-medium text-gray-500">Quantity</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $log->quantity }}</dd>
            </div>
            
            <div>
                <dt class="text-sm font-medium text-gray-500">Date</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $log->date }}</dd>
            </div>
            
            <div>
                <dt class="text-sm font-medium text-gray-500">Created At</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $log->created_at->format('F j, Y H:i') }}</dd>
            </div>
        </dl>
    </div>
</div>
@endsection