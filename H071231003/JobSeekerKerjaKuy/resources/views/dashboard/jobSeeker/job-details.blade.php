@extends('dashboard.template')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-800">{{ $job->title }}</h2>
                            <p class="text-lg text-[#218838] mt-2 font-medium">{{ $job->employer->company_name }}</p>
                        </div>
                        @if ($cekFavorit)
                            <form action="{{ route('jobseeker.favorite', $job->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-red-500 hover:text-red-600 transition-colors">
                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656l-6.828 6.828a.5.5 0 01-.707 0L3.172 10.828a4 4 0 010-5.656z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        @else
                            <form action="{{ route('jobseeker.favorite', $job->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors">
                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656l-6.828 6.828a.5.5 0 01-.707 0L3.172 10.828a4 4 0 010-5.656z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-base">{{ $job->location }}</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="text-base">{{ $job->job_type }}</span>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg mb-8">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800">Description</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $job->description }}</p>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg mb-8">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800">Requirements</h3>
                        <ul class="list-disc list-inside space-y-2">
                            @foreach (explode("\n", $job->requirements) as $requirement)
                                <li class="text-gray-700">{{ $requirement }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="grid grid-cols-3 gap-6 mb-8">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-800 mb-2">Salary</h4>
                            <p class="text-blue-600">Rp {{ number_format($job->salary, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-green-800 mb-2">Payday</h4>
                            <p class="text-green-600">{{ $job->payday }}</p>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-purple-800 mb-2">Status</h4>
                            <p class="text-purple-600">{{ $job->status }}</p>
                        </div>
                    </div>

                    <div class="flex justify-start">
                        <a href="{{ route('jobseeker.job.list') }}" 
                            class="inline-flex items-center px-6 py-3 bg-green-700 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Job List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
