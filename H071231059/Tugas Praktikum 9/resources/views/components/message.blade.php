@if (Session::has('success'))
    <div class="pt-3">
        <div class="bg-green-500 text-white p-4 rounded-lg shadow-md">
            {{ Session::get('success') }}
        </div>
    </div>
@endif

@if ($errors->any())
    <div class="pt-3">
        <div class="bg-red-500 text-white p-4 rounded-lg shadow-md">
            <ul>
                @foreach ($errors->all() as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif