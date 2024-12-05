@extends('dashboard.template')

@section('header')
    Job Posts
@endsection

@section('content')
<form action="{{ route('jobPost.store') }}" method="POST">
    @csrf
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <a href="{{ route('jobPost.create') }}" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
            Add Job Post
        </a>
        <br>
        <div class="overflow-auto max-h-96"> <!-- Added wrapper div for scrollable table -->
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Job Title
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Location
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Job Type
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Payment Target
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Delete</span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">View Applicants</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp

                    @foreach ($jobPosts as $jobPost)
                    <tr> <!-- Added tr tag to wrap table row -->
                        <td class="border px-4 py-2">
                            <a href="{{ route('jobPost.show', $jobPost->id) }}" class=" hover:text-blue-500">
                                {{ $jobPost->title }}
                            </a>
                        </td>
                        <td class="border px-4 py-2">{{ $jobPost->location }}</td>
                        <td class="border px-4 py-2">{{ $jobPost->job_type }}</td>
                        <td class="border px-4 py-2">{{ $jobPost->status }}</td>
                        <td class="border px-4 py-2">{{ $jobPost->payday }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('jobPost.edit', $jobPost->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        </td>
                        <td class="border px-4 py-2">
                            <form action="{{ route('jobPost.destroy', $jobPost->id) }}" method="POST" onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('employer.aplication', ['id' => $jobPost->id]) }}" class="text-indigo-600 hover:text-indigo-900">View Applicants</a>
                        </td>
                    </tr> <!-- End of tr tag -->
                    @endforeach
                </tbody>
            </table>
        </div> <!-- End of wrapper div -->
    </div>
</form>

<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this job post?');
    }
</script>
@endsection
