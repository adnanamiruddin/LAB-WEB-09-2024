@extends('dashboard.template')

@php
    function formatRupiah($angka)
    {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }
@endphp

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-green-50 to-green-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="bg-white rounded-2xl shadow-lg">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Job Listings for
                                {{ $employer->company_name }}</h2>
                            <p class="mt-2 text-gray-600">Manage all available positions</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="bg-[#218838]/10 px-4 py-2 rounded-full">
                                <span class="text-[#218838] font-semibold">{{ $jobPosts->count() }} active positions</span>
                            </div>
                            <a href="{{ route('admin.listEmployers') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Back to Employers
                            </a>
                        </div>
                    </div>

                    @if ($jobPosts->isEmpty())
                        <div class="text-center py-16">
                            <div class="bg-gray-50 rounded-2xl p-10 inline-block">
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <p class="text-gray-500 text-xl font-medium">No job listings available</p>
                                <p class="text-gray-400 mt-2">Posted jobs will appear here</p>
                            </div>
                        </div>
                    @else
                        <div class="grid gap-6">
                            @foreach ($jobPosts as $jobPost)
                                <div
                                    class="bg-white border border-gray-100 hover:border-[#218838] rounded-xl p-6 transition-all duration-200 hover:shadow-lg transform hover:-translate-y-1">
                                    <div class="sm:flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-start space-x-4">
                                                <div
                                                    class="w-16 h-16 rounded-xl flex items-center justify-center overflow-hidden bg-gradient-to-br from-green-50 to-green-100">
                                                    @if ($jobPost->employer->profile_picture)
                                                        <img src="{{ asset('storage/' . $jobPost->employer->profile_picture) }}"
                                                            alt="{{ $jobPost->employer->company_name }}"
                                                            class="w-full h-full object-cover">
                                                    @else
                                                        <div
                                                            class="w-full h-full flex items-center justify-center text-[#218838] font-bold text-2xl">
                                                            {{ substr($jobPost->employer->company_name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="flex-1">
                                                    <h3
                                                        class="text-xl font-bold text-gray-900 hover:text-[#218838] transition">
                                                        {{ $jobPost->title }}
                                                    </h3>
                                                    <p class="text-[#218838] font-semibold">
                                                        {{ $jobPost->employer->company_name }}</p>

                                                    <div class="mt-4 flex flex-wrap gap-3">
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                            </svg>
                                                            {{ $jobPost->location }}
                                                        </span>
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            {{ $jobPost->job_type }}
                                                        </span>
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                            {{ formatRupiah($jobPost->salary) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-4 text-gray-600 line-clamp-2">
                                                {{ $jobPost->description }}
                                            </div>
                                            <p class="mt-2 text-sm text-gray-500">Posted on:
                                                {{ $jobPost->created_at->format('d M Y, H:i') }}</p>
                                        </div>

                                        <div class="mt-6 sm:mt-0 sm:ml-6 flex-shrink-0">
                                            <div class="flex flex-col items-end space-y-3">
                                                <span
                                                    class="bg-green-100 text-green-800 text-sm font-semibold px-4 py-1.5 rounded-full">
                                                    {{ $jobPost->jobAplications->count() }} applicant
                                                </span>
                                                <a href="{{ route('admin.job.applicants', $jobPost->id) }}"
                                                    class="inline-flex items-center px-4 py-2 border border-[#218838] rounded-lg text-[#218838] hover:bg-[#218838] hover:text-white transition-colors duration-200">
                                                    View Applicants
                                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
