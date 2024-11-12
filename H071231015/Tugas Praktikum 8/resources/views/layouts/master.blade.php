<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Website Default Title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @vite('resources/css/app.css')
</head>
<body class="font-sans min-h-screen flex flex-col">

    @include('components.navbar')

    <main class="flex-grow container mx-auto px-4 py-8">
        @yield('content')
    </main>

    @include('components.footer')
</body>
</html>