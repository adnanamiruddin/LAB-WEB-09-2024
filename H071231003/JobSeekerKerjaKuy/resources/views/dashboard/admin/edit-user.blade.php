@extends('dashboard.template')

@section('header')
    Edit User
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-500 text-white p-4 mb-4 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-500 text-white p-4 mb-4 rounded">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('admin.update', $user->id) }}"
                        onsubmit="return confirm('Are you sure you want to update this user?');">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="username" class="block font-medium text-sm text-gray-700">Username</label>
                            <input id="username" class="block mt-1 w-full" type="text" name="username"
                                value="{{ $user->username }}" required autofocus />
                        </div>
                        <div class="mt-4">
                            <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                            <input id="email" class="block mt-1 w-full" type="email" name="email"
                                value="{{ $user->email }}" required />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit"
                                class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
