@extends('layouts.master')
@section('title', $title)
@section('content')
    <div class="max-w-2xl mx-auto px-4">

        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ $title }}</h1>
            <p class="text-lg text-gray-600">{{ $message }}</p>
        </div>

        @if (session('sukses'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('sukses') }}
            </div>
        @endif

        @if (session('data'))
            <div class="mb-6 p-6 bg-blue-50 rounded-lg">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Data yang baru saja Anda kirim:</h3>
                <div class="space-y-2">
                    <p class="text-gray-700"><span class="font-medium">Nama:</span> {{ session('data')['name'] }}</p>
                    <p class="text-gray-700"><span class="font-medium">Email:</span> {{ session('data')['email'] }}</p>
                    <p class="text-gray-700"><span class="font-medium">Subject:</span> {{ session('data')['subject'] }}</p>
                    <p class="text-gray-700"><span class="font-medium">Pesan:</span> {{ session('data')['pesan'] }}</p>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-400 text-red-700 rounded-lg">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('submit.contact') }}" method="POST" class="bg-white shadow-lg rounded-lg p-6">
            @csrf
            <div class="space-y-6">

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        placeholder="Your name">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        placeholder="your.email@example.com">
                </div>

                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                    <input type="text" name="subject" id="subject" value="{{ old('subject') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        placeholder="Message subject">
                </div>

                <div>
                    <label for="pesan" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                    <textarea name="pesan" id="pesan" rows="5"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition resize-none"
                        placeholder="Your message here">{{ old('pesan') }}</textarea>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg
                            shadow-md transition duration-200 hover:scale-105 focus:outline-none focus:ring-2 
                            focus:ring-blue-500 focus:ring-opacity-50">
                    Send Message
                </button>
            </div>
        </form>



        <!-- Contact Info -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6 text-center">

            <div class="p-4">
                <div class="text-2xl mb-2">📍</div>
                <h3 class="font-semibold text-gray-800">Alamat</h3>
                <p class="text-gray-600">FMIPA Tamalanrea</p>
            </div>

            <div class="p-4">
                <div class="text-2xl mb-2">📞</div>
                <h3 class="font-semibold text-gray-800">No.Telp</h3>
                <p class="text-gray-600">+123456789</p>
            </div>

            <div class="p-4">
                <div class="text-2xl mb-2">✉️</div>
                <h3 class="font-semibold text-gray-800">Email</h3>
                <p class="text-gray-600">rudy@gmail.com</p>
            </div>
        </div>
    </div>
@endsection
