@extends('dashboard.template')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-6">Edit Job Seeker Profile</h2>
                    <form action="{{ route('jobSeeker.update', $jobSeeker->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="profile_picture" class="block text-sm font-medium text-gray-700">Profile Picture</label>
                            <input type="file" name="profile_picture" id="profile_picture" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @if(isset($jobSeeker) && $jobSeeker->profile_picture)
                                <img src="{{ asset('storage/' . $jobSeeker->profile_picture) }}" alt="Profile Picture" class="mt-2 w-20 h-20 rounded-full">
                            @else
                                <div class="mt-2 w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center text-gray-700 text-xl">
                                    {{ strtoupper(substr($jobSeeker->full_name ?? 'NA', 0, 2)) }}
                                </div>
                            @endif
                        </div>
                        <div class="mb-4">
                            <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $jobSeeker->full_name ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div class="mb-4">
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $jobSeeker->date_of_birth ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div class="mb-4">
                            <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                            <select name="gender" id="gender" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender', $jobSeeker->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $jobSeeker->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="contact" class="block text-sm font-medium text-gray-700">Phone</label>
                            <input type="text" name="contact" id="contact" value="{{ old('contact', $jobSeeker->contact ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div class="mb-4">
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <input type="text" name="address" id="address" value="{{ old('address', $jobSeeker->address ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div class="mb-4">
                            <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                            <textarea name="bio" id="bio" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('bio', $jobSeeker->bio ?? '') }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="skills" class="block text-sm font-medium text-gray-700">Skills</label>
                            <textarea name="skills" id="skills" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('skills', $jobSeeker->skills ?? '') }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="education_history" class="block text-sm font-medium text-gray-700">Education</label>
                            <textarea name="education_history" id="education_history" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('education_history', $jobSeeker->education_history ?? '') }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="certificates" class="block text-sm font-medium text-gray-700">Certificates</label>
                            <input type="file" name="certificates" id="certificates" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @if(isset($jobSeeker) && $jobSeeker->certificates)
                                <a href="{{ asset('storage/' . $jobSeeker->certificates) }}" target="_blank" class="text-blue-500 hover:underline">View Current Certificate</a>
                            @endif
                        </div>
                        <div class="mb-4">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
