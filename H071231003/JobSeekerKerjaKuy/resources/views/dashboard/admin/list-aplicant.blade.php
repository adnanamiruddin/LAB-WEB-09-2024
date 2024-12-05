@extends('dashboard.template')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Enhanced Job Header Section -->
        <div
            class="bg-gradient-to-br from-[#218838] via-[#1a6e2e] to-[#145024] rounded-2xl shadow-xl mb-8 transform hover:scale-[1.01] transition-all duration-300">
            <div class="p-8">
                <div class="flex justify-between items-start">
                    <div class="space-y-4">
                        <a href="{{ route('employer.jobs', $jobPost->employer->id) }}"
                            class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-white font-medium transition duration-150 backdrop-blur-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Jobs
                        </a>
                        <h1 class="text-4xl font-bold text-white tracking-tight">{{ $jobPost->title }}</h1>
                        <div class="flex items-center space-x-4 text-white/90">
                            <span class="flex items-center bg-white/10 rounded-full px-4 py-2">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                {{ $jobPost->jobAplications->count() }} Applicants
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Applicants List -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            @if ($jobPost->jobAplications->isEmpty())
                <div class="p-16 text-center">
                    <div class="mx-auto w-32 h-32 bg-[#e8f5e9] rounded-full flex items-center justify-center mb-6">
                        <svg class="w-16 h-16 text-[#218838]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-3">No Applicants Yet</h3>
                    <p class="text-gray-500 max-w-md mx-auto">There are currently no applications for this position. Check
                        back later for updates.</p>
                </div>
            @else
                <div class="divide-y divide-gray-100">
                    @foreach ($jobPost->jobAplications as $application)
                        <div class="p-8 hover:bg-gray-50 transition-all duration-200">
                            <div class="flex items-start space-x-8">
                                <div class="flex-shrink-0">
                                    @if ($application->jobSeeker->profile_picture)
                                        <img src="{{ asset('storage/' . $application->jobSeeker->profile_picture) }}"
                                            alt="Profile"
                                            class="h-20 w-20 rounded-2xl object-cover shadow-md hover:shadow-lg transition-shadow duration-200">
                                    @else
                                        <div
                                            class="h-20 w-20 rounded-2xl bg-gradient-to-br from-[#218838] to-[#145024] flex items-center justify-center shadow-md">
                                            <span class="text-2xl font-bold text-white">
                                                {{ substr($application->jobSeeker->name, 0, 1) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="text-xl font-semibold text-gray-900">
                                            {{ $application->jobSeeker->full_name }}</h3>
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-[#e8f5e9] text-[#218838]">
                                            New
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-500">Applied on:
                                        {{ $application->created_at->format('d M Y, H:i') }}</p>
                                    <div class="grid grid-cols-2 gap-4 mb-4">
                                        <div class="space-y-2">
                                            <p class="text-sm text-gray-600 flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                                {{ $application->jobSeeker->contact ?? 'No phone provided' }}
                                            </p>
                                            <p class="text-sm text-gray-600 flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                                {{ $application->jobSeeker->address ?? 'No address provided' }}
                                            </p>
                                            <p class="text-sm text-gray-600 flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-6 8h6" />
                                                </svg>
                                                {{ $application->jobSeeker->date_of_birth ?? 'No birth date provided' }}
                                            </p>
                                            <p class="text-sm text-gray-600 flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                </svg>
                                                {{ ucfirst($application->jobSeeker->gender ?? 'No gender provided') }}
                                            </p>
                                        </div>
                                        <div class="space-y-2">
                                            @if ($application->jobSeeker->education)
                                                <p class="text-sm text-gray-600 flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path d="M12 14l9-5-9-5-9 5z" />
                                                        <path
                                                            d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                                    </svg>
                                                    {{ $application->jobSeeker->education }}
                                                </p>
                                            @endif
                                            @if ($application->jobSeeker->experience)
                                                <p class="text-sm text-gray-600 flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                    {{ $application->jobSeeker->experience }}
                                                </p>
                                            @endif
                                            @if ($application->jobSeeker->certificates)
                                                <p class="text-sm text-gray-600 flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <a href="{{ asset('storage/' . $application->jobSeeker->certificates) }}"
                                                        target="_blank" class="text-[#218838] hover:underline">View
                                                        Certificate</a>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    @if ($application->jobSeeker->bio)
                                        <div class="mb-4">
                                            <h4 class="text-sm font-medium text-gray-700">Bio</h4>
                                            <p class="text-sm text-gray-600">{{ $application->jobSeeker->bio }}</p>
                                        </div>
                                    @endif
                                    @if ($application->jobSeeker->skills)
                                        <div class="flex flex-wrap gap-2">
                                            @foreach (explode(',', $application->jobSeeker->skills) as $skill)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    {{ trim($skill) }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
