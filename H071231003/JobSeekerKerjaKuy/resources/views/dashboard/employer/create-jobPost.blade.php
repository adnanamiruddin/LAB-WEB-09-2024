@extends('dashboard.template')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('jobPost.store') }}" method="POST">
            @csrf
            <input type="hidden" name="employer_id" value="{{ Auth::user()->id }}">
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Nama Pekerjaan</label>
                <input type="text" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" id="title" name="title" required>
            </div>

            <div class="mb-4">
                <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                <input type="text" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" id="location" name="location" required>
            </div>

            <div class="mb-4">
                <label for="job_type" class="block text-sm font-medium text-gray-700 mb-1">Tipe Pekerjaan</label>
                <select class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" id="job_type" name="job_type" required>
                    <option value="full-time">Full Time</option>
                    <option value="part-time">Part Time</option>
                    <option value="freelance">Freelance</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="payday" class="block text-sm font-medium text-gray-700 mb-1">Target Pembayaran</label>
                <select class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" id="payday" name="payday" required>
                    <option value="yearly">Yearly</option>
                    <option value="monthly">Monthly</option>
                    <option value="weekly">Weekly</option>
                    <option value="daily">Daily</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" id="description" name="description" required></textarea>
            </div>

            <div class="mb-4">
                <label for="requirements" class="block text-sm font-medium text-gray-700 mb-1">Persyaratan</label>
                <textarea class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" id="requirements" name="requirements" required></textarea>
            </div>

            <div class="mb-4">
                <label for="salary" class="block text-sm font-medium text-gray-700 mb-1">Gaji</label>
                <input type="number" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" id="salary" name="salary" required>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection