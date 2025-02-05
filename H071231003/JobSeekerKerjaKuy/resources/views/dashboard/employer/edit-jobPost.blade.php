@extends('dashboard.template')

@section('header')
    Edit Job Post
@endsection

@section('content')
<form action="{{ route('jobPost.update', $selectedEmployer->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Job Title</label>
            <input type="text" name="title" id="title" value="{{ $selectedEmployer->title }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>
        <div class="mb-4">
            <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
            <input type="text" name="location" id="location" value="{{ $selectedEmployer->location }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>
        <div class="mb-4">
            <label for="job_type" class="block text-sm font-medium text-gray-700">Job Type</label>
            <select name="job_type" id="job_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="full-time" {{ $selectedEmployer->job_type == 'full-time' ? 'selected' : '' }}>Full-time</option>
                <option value="part-time" {{ $selectedEmployer->job_type == 'part-time' ? 'selected' : '' }}>Part-time</option>
                <option value="freelance" {{ $selectedEmployer->job_type == 'freelance' ? 'selected' : '' }}>Freelance</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $selectedEmployer->description }}</textarea>
        </div>
        <div class="mb-4">
            <label for="requirements" class="block text-sm font-medium text-gray-700">Requirements</label>
            <textarea name="requirements" id="requirements" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $selectedEmployer->requirements }}</textarea>
        </div>
        <div class="mb-4">
            <label for="salary" class="block text-sm font-medium text-gray-700">Salary</label>
            <input type="number" name="salary" id="salary" value="{{ $selectedEmployer->salary }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>
        <div class="mb-4">
            <label for="payday" class="block text-sm font-medium text-gray-700">Payment Target</label>
            <select name="payday" id="payday" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="yearly" {{ $selectedEmployer->payday == 'yearly' ? 'selected' : '' }}>Yearly</option>
                <option value="monthly" {{ $selectedEmployer->payday == 'monthly' ? 'selected' : '' }}>Monthly</option>
                <option value="weekly" {{ $selectedEmployer->payday == 'weekly' ? 'selected' : '' }}>Weekly</option>
                <option value="daily" {{ $selectedEmployer->payday == 'daily' ? 'selected' : '' }}>Daily</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="active" {{ $selectedEmployer->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="closed" {{ $selectedEmployer->status == 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="text-white bg-[#218838] hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Update</button>
        </div>
    </div>
</form>
@endsection
