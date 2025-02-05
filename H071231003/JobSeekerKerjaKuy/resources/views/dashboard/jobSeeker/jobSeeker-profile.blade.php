@extends('dashboard.template')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-6">Job Seeker</h2>
                    @if(!isset($jobSeeker) || !$jobSeeker->full_name)
                        <form action="{{ route('jobSeeker.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                    @endif
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Profile Picture</label>
                        @if(isset($jobSeeker) && $jobSeeker->profile_picture)
                            <img src="{{ asset('storage/' . $jobSeeker->profile_picture) }}" alt="Profile Picture" class="mt-2 w-20 h-20 rounded-full">
                        @else
                            @if(!isset($jobSeeker) || !$jobSeeker->full_name)
                                <input type="file" name="profile_picture" class="mt-2">
                            @else
                                <div class="mt-2 w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center text-gray-700 text-xl">
                                    {{ strtoupper(substr($jobSeeker->full_name ?? 'NA', 0, 2)) }}
                                </div>
                            @endif
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="full_name" value="{{ $jobSeeker->full_name ?? '' }}" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                            {{ (isset($jobSeeker) && $jobSeeker->full_name) ? 'readonly' : '' }}>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                        <input type="date" name="date_of_birth" value="{{ $jobSeeker->date_of_birth ?? '' }}" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            {{ (isset($jobSeeker) && $jobSeeker->full_name) ? 'readonly' : '' }}>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Gender</label>
                        @if(!isset($jobSeeker) || !$jobSeeker->full_name)
                            <select name="gender" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        @else
                            <input type="text" value="{{ ucfirst($jobSeeker->gender ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" readonly>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Phone</label>
                        <input type="text" name="contact" value="{{ $jobSeeker->contact ?? '' }}" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                            {{ (isset($jobSeeker) && $jobSeeker->full_name) ? 'readonly' : '' }}>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Address</label>
                        <input type="text" name="address" value="{{ $jobSeeker->address ?? '' }}" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                            {{ (isset($jobSeeker) && $jobSeeker->full_name) ? 'readonly' : '' }}>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Bio</label>
                        <textarea rows="4" name="bio" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                            {{ (isset($jobSeeker) && $jobSeeker->full_name) ? 'readonly' : '' }}>{{ $jobSeeker->bio ?? '' }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Skills</label>
                        <textarea rows="4" name="skills" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                            {{ (isset($jobSeeker) && $jobSeeker->full_name) ? 'readonly' : '' }}>{{ $jobSeeker->skills ?? '' }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Education</label>
                        <textarea rows="4" name="education_history" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                            {{ (isset($jobSeeker) && $jobSeeker->full_name) ? 'readonly' : '' }}>{{ $jobSeeker->education_history ?? '' }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Certificates</label>
                        @if(isset($jobSeeker) && $jobSeeker->certificates)
                            <a href="{{ asset('storage/' . $jobSeeker->certificates) }}" target="_blank" class="text-blue-500 hover:underline">View Current Certificate</a>
                        @else
                            <input type="file" name="certificates" class="mt-2">
                        @endif
                    </div>

                    @if(!isset($jobSeeker) || !$jobSeeker->full_name)
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mb-4 inline-block">Save Profile</button>
                        </form>
                    @else
                        <a href="{{ route('jobSeeker.edit', $jobSeeker->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4 inline-block">Edit Profile</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection