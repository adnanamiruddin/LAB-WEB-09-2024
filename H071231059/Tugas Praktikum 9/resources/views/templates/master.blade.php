<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Category</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
</head>
    <body class="bg-gray-900">
        @include('components/message')
        @include('components.navbar')

        <div class="relative mt-5">
            <div class="pb-4 flex justify-between items-center">
                <div class="flex justify-start">
                    <div class="relative ml-5">
                        <h5 class="mr-3 font-semibold text-2xl text-slate-400">
                            @yield('title')
                        </h5>
                        <p class="text-slate-100">@yield('desc') </p>
                    </div>
                </div>
                @yield('header-button')
            </div>
        </div>

        @yield('content')
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    </body>
</html>
