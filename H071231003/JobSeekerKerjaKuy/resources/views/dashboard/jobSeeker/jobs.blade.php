@extends('dashboard.template')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form method="GET" action="{{ route('jobseeker.job.list') }}" class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <input type="text" name="search" placeholder="Search jobs..." class="form-input w-full" value="{{ request('search') }}">
                <select name="location" class="form-select w-full">
                    <option value="">All Locations</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>{{ $location }}</option>
                    @endforeach
                </select>
                <select name="job_type" class="form-select w-full">
                    <option value="">All Job Types</option>
                    @foreach ($jobTypes as $jobType)
                        <option value="{{ $jobType }}" {{ request('job_type') == $jobType ? 'selected' : '' }}>{{ $jobType }}</option>
                    @endforeach
                </select>
                <select name="salary" class="form-select w-full">
                    <option value="">All Salaries</option>
                    <option value="0-5000" {{ request('salary') == '0-5000' ? 'selected' : '' }}>0 - 5000</option>
                    <option value="5000-10000" {{ request('salary') == '5000-10000' ? 'selected' : '' }}>5000 - 10000</option>
                    <option value="10000-20000" {{ request('salary') == '10000-20000' ? 'selected' : '' }}>10000 - 20000</option>
                    <option value="20000+" {{ request('salary') == '20000+' ? 'selected' : '' }}>20000+</option>
                </select>
                <button type="submit" class="bg-[#218838] text-white px-4 py-2 rounded hover:bg-[#1a6c2e]">Filter</button>
            </div>
        </form>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($jobs as $job)
            @if ($job->status !== 'closed' && !$appliedJobs->contains($job->id))
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2">{{ $job->title }}</h3>
                    <p class="text-gray-600 mb-2">{{ $job->employer->company_name }}</p>
                    <div class="flex items-center text-sm text-gray-500 mb-2">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>{{ $job->location }}</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>{{ $job->job_type }}</span>
                    </div>
                    <a href="{{ route('jobseeker.job.details', $job->id) }}" 
                        class="inline-block bg-[#218838] text-white px-4 py-2 rounded hover:bg-[#1a6c2e]">
                        View Details
                    </a>
                    <form action="{{ route('jobseeker.apply', $job->id) }}" method="POST" enctype="multipart/form-data" class="mt-4" onsubmit="return validateForm(this)">
                        @csrf
                        <div class="mb-4">
                            <label for="cv" class="block text-sm font-medium text-gray-700">Upload CV (Required)</label>
                            <input type="file" name="cv" id="cv" class="mt-1 block w-full" onchange="handleFileSelect(this)">
                            <p class="text-red-500 text-sm hidden mt-1" id="cvError">Please upload your CV first</p>
                        </div>
                        <button type="submit" class="bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed" id="submitBtn" disabled>
                            Apply
                        </button>
                    </form>

                </div>
            </div>
            @endif
            @endforeach
        </div>
        {{ $jobs->links() }}
        <h2 class="text-2xl font-bold mt-8 mb-4">Jobs You've Applied For</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($jobs as $job)
            @if ($appliedJobs->contains($job->id))
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2">{{ $job->title }}</h3>
                    <p class="text-gray-600 mb-2">{{ $job->employer->company_name }}</p>
                    <div class="flex items-center text-sm text-gray-500 mb-2">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>{{ $job->location }}</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>{{ $job->job_type }}</span>
                    </div>
                    <a href="{{ route('jobseeker.job.details', $job->id) }}" 
                        class="inline-block bg-[#218838] text-white px-4 py-2 rounded hover:bg-[#1a6c2e]">
                        View Details
                    </a>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</div>
<script>
function handleFileSelect(input) {
    const submitBtn = input.closest('form').querySelector('#submitBtn');
    const cvError = input.closest('form').querySelector('#cvError');
    
    if (input.files.length > 0) {
        submitBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
        submitBtn.classList.add('bg-[#218838]', 'hover:bg-[#1a6c2e]');
        submitBtn.disabled = false;
        cvError.classList.add('hidden');
    } else {
        submitBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
        submitBtn.classList.remove('bg-[#218838]', 'hover:bg-[#1a6c2e]');
        submitBtn.disabled = true;
    }
}

function validateForm(form) {
    const fileInput = form.querySelector('input[type="file"]');
    const cvError = form.querySelector('#cvError');
    
    if (!fileInput.files.length) {
        cvError.classList.remove('hidden');
        return false;
    }
    return true;
}
</script>
@endsection