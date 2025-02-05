@extends('dashboard.template')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('jobPost') }}" class="inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 mb-4">
                Back to Job Listings
            </a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($jobSeeker)
                        <h2 class="text-2xl font-bold mb-6">{{ $jobSeeker->full_name }}'s Profile</h2>
                        <p class="mb-4"><strong>Email:</strong> {{ $jobSeeker->user->email }}</p>
                        <p class="mb-4"><strong>Phone:</strong> {{ $jobSeeker->contact }}</p>
                        <p class="mb-4"><strong>Address:</strong> {{ $jobSeeker->address }}</p>
                        <p class="mb-4"><strong>Date of Birth:</strong> {{ $jobSeeker->date_of_birth }}</p>
                        <p class="mb-4"><strong>Gender:</strong> {{ $jobSeeker->gender }}</p>
                        <p class="mb-4"><strong>Bio:</strong> {{ $jobSeeker->bio }}</p>
                        <p class="mb-4"><strong>Skills:</strong> {{ $jobSeeker->skills }}</p>
                        <p class="mb-4"><strong>Experience:</strong> {{ $jobSeeker->experience }}</p>
                        <p class="mb-4"><strong>Education:</strong> {{ $jobSeeker->education_history }}</p>
                        @if($jobSeeker->certificates)
                            <p class="mb-4"><strong>Certificates:</strong> <a href="{{ asset('storage/' . $jobSeeker->certificates) }}" target="_blank" class="text-blue-500 hover:underline">View Certificate</a></p>
                        @endif
                    @else
                        <p class="text-red-500">Job Seeker profile not found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection