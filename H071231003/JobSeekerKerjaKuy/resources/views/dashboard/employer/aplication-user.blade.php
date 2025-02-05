@extends('dashboard.template')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('jobPost') }}"
                class="inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 mb-4">
                Back to Job Listings
            </a>
            @if ($jobPost)
                <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                    <h2 class="text-2xl font-bold mb-4">{{ $jobPost->title }}</h2>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <p><strong>Company:</strong> {{ $jobPost->employer->company_name }}</p>
                        <p><strong>Location:</strong> {{ $jobPost->location }}</p>
                        <p><strong>Job Type:</strong> {{ $jobPost->job_type }}</p>
                        <p><strong>Salary:</strong> Rp {{ number_format($jobPost->salary, 0, ',', '.') }}</p>
                        <p><strong>Experience Required:</strong> {{ $jobPost->experience }}</p>
                        <p><strong>Posted Date:</strong> {{ $jobPost->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="mt-4">
                        <h3 class="text-lg font-semibold mb-2">Job Description:</h3>
                        <p class="text-gray-700">{{ $jobPost->description }}</p>
                    </div>
                    <div class="mt-4">
                        <h3 class="text-lg font-semibold mb-2">Requirements:</h3>
                        <p class="text-gray-700">{{ $jobPost->requirements }}</p>
                    </div>
                </div>

                <h3 class="text-xl font-bold mb-4">Pending Applications</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($jobPost->jobAplications as $applicant)
                        @if ($applicant->status == 'pending')
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6">
                                    <h3 class="text-xl font-bold mb-2">{{ $applicant->jobSeeker->name }}</h3>
                                    <p class="text-gray-600 mb-2">{{ $applicant->jobSeeker->email }}</p>
                                    <p class="text-gray-600 mb-2"><strong>Cover Letter:</strong>
                                        {{ $applicant->cover_letter }}</p>
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ asset('storage/' . $applicant->cv) }}" target="_blank"
                                            class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                            View CV
                                        </a>
                                        <a href="{{ route('employer.profile', $applicant->jobSeeker->id) }}"
                                            target="_blank"
                                            class="inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                                            View Profile
                                        </a>
                                        <form action="{{ route('employer.acceptApplicant', $applicant->id) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                                                Accept
                                            </button>
                                        </form>
                                        <form action="{{ route('employer.rejectApplicant', $applicant->id) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <h2 class="text-2xl font-bold mb-6">Job post not found.</h2>
            @endif
        </div>
    </div>
@endsection
