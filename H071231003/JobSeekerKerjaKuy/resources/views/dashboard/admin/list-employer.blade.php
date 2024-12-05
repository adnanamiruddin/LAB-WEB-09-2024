@extends('dashboard.template')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-green-50 to-[#e8f5e9]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Header Section -->
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Employer Directory</h2>
                        <p class="mt-2 text-gray-600">Manage and monitor registered employers</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="bg-[#e8f5e9] px-4 py-2 rounded-xl">
                            <span class="text-[#218838] font-semibold">{{ $employers->total() }}</span>
                            <span class="text-[#218838] ml-1">Employers</span>
                        </div>
                    </div>
                </div>

                <!-- Search and Filter Section -->
                <div class="mt-8">
                    <form method="GET" action="{{ route('admin.listEmployers') }}">
                        <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0">
                            <div class="flex-1">
                                <div class="relative">
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search employers..." 
                                        class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 focus:border-[#218838] focus:ring-2 focus:ring-[#e8f5e9] transition-all duration-200">
                                    <svg class="w-6 h-6 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex space-x-4">
                                
                                <button type="submit" class="px-4 py-3 bg-[#218838] text-white rounded-xl hover:bg-[#1a6e2e] transition-colors duration-200">
                                    Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Employer List Section -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                @if($employers->isEmpty())
                    <div class="text-center py-16">
                        <div class="bg-gray-50 rounded-2xl p-10">
                            <img src="https://illustrations.popsy.co/gray/work-from-home.svg" class="w-48 h-48 mx-auto" alt="No employers">
                            <h3 class="mt-6 text-2xl font-bold text-gray-900">No employers found</h3>
                            <p class="mt-2 text-gray-500">Start by adding your first employer to the platform</p>
                            <button class="mt-6 bg-[#218838] text-white px-6 py-3 rounded-xl hover:bg-[#1a6e2e] transition-colors duration-200">
                                Add First Employer
                            </button>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        @foreach ($employers as $employer)
                            <div class="group bg-white border border-gray-100 rounded-xl p-6 hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-r from-green-50 to-[#e8f5e9] opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <div class="relative flex space-x-4">
                                    <div class="w-24 h-24 rounded-xl flex-shrink-0 overflow-hidden bg-gradient-to-br from-[#e8f5e9] to-[#c8e6c9] border-2 border-white shadow-inner">
                                        @if($employer->profile_picture)
                                            <img src="{{ asset('storage/' . $employer->profile_picture) }}" 
                                                alt="{{ $employer->company_name }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-[#218838] font-bold text-4xl">
                                                {{ substr($employer->company_name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="text-xl font-bold text-gray-900 group-hover:text-[#218838] transition-colors duration-200">
                                                    {{ $employer->company_name }}
                                                </h3>
                                                <div class="flex items-center mt-2 space-x-2">
                                                    <span class="bg-[#e8f5e9] text-[#218838] px-3 py-1 rounded-full text-sm">
                                                        {{ $employer->industry }}
                                                    </span>
                                                    <span class="text-gray-500 text-sm">•</span>
                                                    <span class="text-gray-600 text-sm">
                                                        Added {{ $employer->created_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 flex flex-wrap gap-3">
                                            <a href="{{ route('admin.employer.jobs', $employer->id) }}" 
                                               class="inline-flex items-center px-4 py-2 bg-white border border-[#218838] text-[#218838] text-sm font-medium rounded-lg hover:bg-[#218838] hover:text-white transition-all duration-200">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                </svg>
                                                View Jobs
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-8">
                        {{ $employers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@php
function formatRupiah($number)
{
    return 'Rp ' . number_format($number, 0, ',', '.');
}
@endphp
