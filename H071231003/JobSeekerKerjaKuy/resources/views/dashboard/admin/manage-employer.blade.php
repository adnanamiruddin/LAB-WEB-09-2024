@extends('dashboard.template')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-[#218838] leading-tight mb-6">Manage Employers</h2>
        <div class="mt-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($employers as $employer)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-[#218838]/20 hover:shadow-md transition-all duration-300">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 text-[#218838]">{{ $employer->company_name }}</h3>
                        <p class="text-gray-600 mb-4">{{ $employer->email }}</p>
                        <a href="{{ route('admin.employer.jobs', $employer->id) }}" 
                            class="inline-block bg-[#218838] text-white px-4 py-2 rounded hover:bg-[#1e7732] transition-all duration-200 hover:shadow-lg">
                            View Jobs
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
