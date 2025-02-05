@if (session('message'))
    <div class="notification">
        {{session('message')}}
    </div>
@endif