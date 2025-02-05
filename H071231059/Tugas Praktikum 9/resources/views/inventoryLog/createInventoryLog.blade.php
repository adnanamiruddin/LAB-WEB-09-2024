@extends('templates/master')

@section('content')    
    <section>
        <div class="py-4 px-4 mx-auto max-w-2xl ">
            <h2 class="mb-4 text-xl font-bold text-white">Add a new Log</h2>
            <form action="{{ url('/inventorylog') }}" method="POST">
                @csrf
                <div class="grid gap-4 mb-4 sm:grid-cols-2">
                    <div>
                        <label for="product_id" class="block mb-2 text-sm font-medium text-white">Product</label>
                        <select name="product_id" id="product_id" class="border text-sm rounded-lg focus:ring-slate-300 focus:border-slate-300 block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white">
                            <option selected="">Select Product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}"> {{ $product->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="type" class="block mb-2 text-sm font-medium text-white">Type</label>
                        <select name="type" id="type" class="border text-sm rounded-lg focus:ring-slate-300 focus:border-slate-300 block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white">
                            <option selected="">Select Type</option>
                            <option value="sold">Sold</option>
                            <option value="restock">Restock</option>
                        </select>
                    </div>
                    <div>
                        <label for="date" class="block mb-2 text-sm font-medium text-white">Date</label>
                        <div class="relative max-w-sm">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                            <input name="date" value="{{ old('date') }}" id="datepicker-autohide" datepicker datepicker-autohide type="text" class="border text-sm rounded-lg block w-full ps-10 p-2.5  bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-slate-300 focus:border-slate-300" placeholder="Select date">
                        </div>
                    </div>
                    <div>
                        <label for="quantity" class="block mb-2 text-sm font-medium text-white">quantity</label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" class="border text-sm rounded-lg focus:ring-slate-300 focus:border-slate-300 block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white" required="" min="1">
                    </div>
                </div>
                  <button type="submit" class=" bg-slate-200 hover:bg-slate-300 focus:ring-slate-700 text-slate-900 inline-flex items-center  focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                      <svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                      Add new log
                  </button>
            </form>
        </div>
    </section>
@endsection