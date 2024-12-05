@extends('dashboard.template')

@section('header')
    Accepted/Rejected Applicants
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (!$employer)
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Profile Incomplete!</strong>
                <span class="block sm:inline">Please complete your profile before accessing this page.</span>
            </div>
        @else
            @foreach ($jobPosts as $jobPost)
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg mb-6 p-6 border-t-4 border-green-500">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-800">{{ $jobPost->title }}</h2>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Accepted Applicants</h3>
                        <div class="overflow-x-auto rounded-lg shadow-sm">
                            <table class="min-w-full bg-white border border-gray-300 mb-6">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Name</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Email</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Date of Birth</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Gender</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">CV</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Actions</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jobPost->jobAplications as $application)
                                        @if ($application->status === 'accepted')
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 border-b text-sm text-gray-700">{{ $application->jobSeeker->full_name }}</td>
                                                <td class="px-6 py-4 border-b text-sm text-gray-700">{{ $application->jobSeeker->user->email }}</td>
                                                <td class="px-6 py-4 border-b text-sm text-gray-700">{{ $application->jobSeeker->date_of_birth }}</td>
                                                <td class="px-6 py-4 border-b text-sm text-gray-700">{{ ucfirst($application->jobSeeker->gender) }}</td>
                                                <td class="px-6 py-4 border-b text-sm">
                                                    <a href="{{ asset('storage/' . $application->cv) }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                                        View CV
                                                    </a>
                                                </td>
                                                <td class="px-6 py-4 border-b text-sm">
                                                    <a href="{{ route('employer.profile', $application->jobSeeker->id) }}" class="text-blue-600 hover:text-blue-800">
                                                        View Profile
                                                    </a>
                                                </td>
                                                <td class="px-6 py-4 border-b text-center">
                                                    <span class="text-green-500 font-semibold">Accepted</span>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Rejected Applicants</h3>
                        <div class="overflow-x-auto rounded-lg shadow-sm">
                            <table class="min-w-full bg-white border border-gray-300">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Name</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Email</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Date of Birth</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Gender</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">CV</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Actions</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jobPost->jobAplications as $application)
                                        @if ($application->status === 'rejected')
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 border-b text-sm text-gray-700">{{ $application->jobSeeker->full_name }}</td>
                                                <td class="px-6 py-4 border-b text-sm text-gray-700">{{ $application->jobSeeker->user->email }}</td>
                                                <td class="px-6 py-4 border-b text-sm text-gray-700">{{ $application->jobSeeker->date_of_birth }}</td>
                                                <td class="px-6 py-4 border-b text-sm text-gray-700">{{ ucfirst($application->jobSeeker->gender) }}</td>
                                                <td class="px-6 py-4 border-b text-sm">
                                                    <a href="{{ asset('storage/' . $application->cv) }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                                        View CV
                                                    </a>
                                                </td>
                                                <td class="px-6 py-4 border-b text-sm">
                                                    <a href="{{ route('employer.profile', $application->jobSeeker->id) }}" class="text-blue-600 hover:text-blue-800">
                                                        View Profile
                                                    </a>
                                                </td>
                                                <td class="px-6 py-4 border-b text-center">
                                                    <span class="text-red-500 font-semibold">Rejected</span>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
