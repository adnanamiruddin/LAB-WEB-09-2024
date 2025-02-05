@extends('dashboard.template')

@section('header')
    Edit Company Profile
@endsection

@section('content')
    <div class="container mx-auto p-6">
        <div class="card shadow-lg rounded-lg overflow-hidden">
            <div class="card-body p-8">
                <div class="text-center mb-6">
                    <div class="profile-image-container mb-4">
                        <img src="{{ asset('storage/' . $employer->profile_picture) }}" alt="Company Logo"
                            class="rounded-full shadow-lg w-48 h-48 object-cover mx-auto">
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-800">{{ $employer->company_name ?? 'Company Name' }}</h3>
                </div>

                <form action="{{ route('employer.update', $employer->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @if ($errors->any())
                        <div class="alert alert-danger mb-6 bg-red-100 text-red-800 p-4 rounded-lg">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="col-span-1">
                            <label for="profile_picture" class="form-label text-lg font-medium text-gray-700">Company Logo</label>
                            <input type="file" class="form-control mt-2 p-2 border border-gray-300 rounded-lg w-full" id="profile_picture" name="profile_picture">
                        </div>

                        <div class="col-span-1">
                            <label for="company_name" class="form-label text-lg font-medium text-gray-700">Company Name</label>
                            <input type="text" class="form-control mt-2 p-2 border border-gray-300 rounded-lg w-full" id="company_name" name="company_name"
                                value="{{ old('company_name', $employer->company_name ?? '') }}" required>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="company_description" class="form-label text-lg font-medium text-gray-700">Company Description</label>
                        <textarea class="form-control mt-2 p-2 border border-gray-300 rounded-lg w-full" id="company_description" name="company_description" rows="4">{{ old('company_description', $employer->company_description ?? '') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                        <div class="col-span-1">
                            <label for="industry" class="form-label text-lg font-medium text-gray-700">Industry</label>
                            <input type="text" class="form-control mt-2 p-2 border border-gray-300 rounded-lg w-full" id="industry" name="industry"
                                value="{{ old('industry', $employer->industry ?? '') }}">
                        </div>

                        <div class="col-span-1">
                            <label for="website" class="form-label text-lg font-medium text-gray-700">Website</label>
                            <input type="url" class="form-control mt-2 p-2 border border-gray-300 rounded-lg w-full" id="website" name="website"
                                value="{{ old('website', $employer->website ?? '') }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                        <div class="col-span-1">
                            <label for="contact" class="form-label text-lg font-medium text-gray-700">Phone Number</label>
                            <input type="tel" class="form-control mt-2 p-2 border border-gray-300 rounded-lg w-full" id="contact" name="contact"
                                value="{{ old('contact', $employer->contact ?? '') }}">
                        </div>

                        <div class="col-span-1">
                            <label for="address" class="form-label text-lg font-medium text-gray-700">Address</label>
                            <textarea class="form-control mt-2 p-2 border border-gray-300 rounded-lg w-full" id="address" name="address" rows="3">{{ old('address', $employer->address ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="text-center mt-6">
                        <button type="submit" class="btn btn-primary py-2 px-6 bg-green-500 text-white rounded-lg hover:bg-green-600 focus:outline-none focus:ring focus:ring-green-300">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
