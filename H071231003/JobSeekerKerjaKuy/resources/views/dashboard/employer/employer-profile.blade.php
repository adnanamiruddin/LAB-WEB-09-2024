@extends('dashboard.template')

@section('header')
    Company Profile
@endsection

@section('content')
<div class="container py-8">
    <div class="card shadow-lg rounded-xl border-none">
        <div class="card-body p-6">
            @if(isset($employer) && $employer->id)
                <div class="text-center mb-8">
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $employer->profile_picture) }}" alt="Company Logo" 
                            class="w-48 h-48 rounded-full border-4 border-green-600 mx-auto object-cover">
                    </div>
                    <h2 class="text-3xl font-semibold text-gray-800 mb-3">{{ $employer->company_name }}</h2>
                    <span class="inline-block bg-green-600 text-white px-4 py-2 rounded-full">{{ $employer->industry }}</span>
                </div>

                <div class="bg-gray-100 p-6 rounded-lg mb-8 shadow-sm">
                    <h4 class="text-lg font-semibold text-green-600 mb-4">Company Information</h4>

                    <div class="mb-6">
                        <label class="font-medium text-gray-700">Description</label>
                        <p class="text-gray-600">{{ $employer->company_description }}</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="font-medium text-gray-700">Website</label>
                            <p class="text-gray-600">
                                <i class="fas fa-globe text-green-600 mr-2"></i>
                                <a href="{{ $employer->website }}" target="_blank" class="text-green-600 hover:underline">{{ $employer->website }}</a>
                            </p>
                        </div>
                        
                    </div>

                    <div class="mb-6">
                        <label class="font-medium text-gray-700">Address</label>
                        <p class="text-gray-600">
                            <i class="fas fa-map-marker-alt text-green-600 mr-2"></i>
                            {{ $employer->address }}
                        </p>
                    </div>
                    <div class="mb-6">
                            <label class="font-medium text-gray-700">Phone Number</label>
                            <p class="text-gray-600">
                                <i class="fas fa-phone text-green-600 mr-2"></i>
                                {{ $employer->contact }}
                            </p>
                    </div>
                </div>

                <div class="text-center">
                    <a href="{{ route('employer.edit', $employer->id) }}" 
                        class="btn bg-green-600 text-white px-6 py-3 rounded-lg text-lg hover:bg-green-700 transition duration-300">
                        <i class="fas fa-edit mr-2"></i>Edit Profile
                    </a>
                </div>
            @else
                <form action="{{ route('employer.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-lg">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger mb-6 bg-red-100 text-red-700 p-4 rounded-lg">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-6 text-center">
                        <label for="profile_picture" class="font-medium text-gray-700">Company Logo</label>
                        <input type="file" class="form-control mt-2 p-2 border border-gray-300 rounded-lg w-full" id="profile_picture" name="profile_picture">
                    </div>
                    
                    <div class="mb-6">
                        <label for="company_name" class="font-medium text-gray-700">Company Name</label>
                        <input type="text" class="form-control mt-2 p-3 border border-gray-300 rounded-lg w-full" id="company_name" name="company_name" 
                            value="{{ old('company_name') }}" required>
                    </div>

                    <div class="mb-6">
                        <label for="company_description" class="font-medium text-gray-700">Company Description</label>
                        <textarea class="form-control mt-2 p-3 border border-gray-300 rounded-lg w-full" id="company_description" name="company_description" rows="4">{{ old('company_description') }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label for="industry" class="font-medium text-gray-700">Industry</label>
                        <input type="text" class="form-control mt-2 p-3 border border-gray-300 rounded-lg w-full" id="industry" name="industry" 
                            value="{{ old('industry') }}">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="website" class="font-medium text-gray-700">Website</label>
                            <input type="url" class="form-control mt-2 p-3 border border-gray-300 rounded-lg w-full" id="website" name="website" 
                                value="{{ old('website') }}">
                        </div>
                        <div>
                            <label for="contact" class="font-medium text-gray-700">Phone Number</label>
                            <input type="tel" class="form-control mt-2 p-3 border border-gray-300 rounded-lg w-full" id="contact" name="contact" 
                                value="{{ old('contact') }}">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="address" class="font-medium text-gray-700">Address</label>
                        <textarea class="form-control mt-2 p-3 border border-gray-300 rounded-lg w-full" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn bg-green-600 text-white px-6 py-3 rounded-lg text-lg hover:bg-green-700 transition duration-300">
                            <i class="fas fa-save mr-2"></i>Save
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
