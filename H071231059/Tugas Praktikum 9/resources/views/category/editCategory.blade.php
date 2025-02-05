@extends('templates/master')

@section('content')    
    <section>
        <div class="py-4 px-4 mx-auto max-w-2xl ">
            <h2 class="mb-4 text-xl font-bold text-white">Edit category</h2>
            <form action="{{ url("/category/$category->id") }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                    <div class="sm:col-span-2">
                        <label for="name" class="block mb-2 text-sm font-medium text-white">Category Name</label>
                        <input type="text" name="name" id="name" value="{{ $category->name }}" class="border text-sm rounded-lg focus:ring-slate-300 focus:border-slate-300 block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white" placeholder="Type product name">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="description" class="block mb-2 text-sm font-medium text-white">Description</label>
                        <textarea name="description" id="description" rows="8" class="block p-2.5 w-full text-sm rounded-lg border focus:ring-slate-300 focus:border-slate-300 bg-gray-700 border-gray-600 placeholder-gray-400 text-white" placeholder="Your description here">{{ $category->description }}</textarea>
                    </div>
                </div>
                <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center bg-slate-200 hover:bg-slate-300 rounded-lg focus:ring-4 focus:ring-slate-700">
                    Save Category
                </button>
            </form>
        </div>
    </section>
@endsection