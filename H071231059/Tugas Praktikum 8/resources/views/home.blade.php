@extends('layouts.master')

@section('title', 'Home Page')
    
@section('content')
    <section class="bg-cover bg-center bg-[url('/images/swiss-bg.jpg')] ">
        <div class="px-4 mx-auto max-w-screen-xl text-center py-24 lg:py-56">
            <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl">
            Discover the Beauty of Switzerland
            </h1>
            <p class="mb-8 text-lg font-normal text-gray-300 lg:text-xl sm:px-16 lg:px-48">
            captures the essence of Switzerland as both a beautiful and technologically advanced nation.
            </p>
            <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0">
                <a href="{{ route('about')}}" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300">
                    about
                    <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                    </svg>
                </a>
                <a href="{{ route('contact')}}" class="inline-flex justify-center hover:text-gray-900 items-center py-3 px-5 sm:ms-4 text-base font-medium text-center text-white rounded-lg border border-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">
                    contact
                </a>  
            </div>
        </div>
    </section>

    <section>
    <div class="bg-white flex items-center justify-center p-4">
        <img src="/images/swiss1.jpg" alt="Deskripsi Gambar" class="w-3/12 h-auto mr-16 rounded-md">
        <p class="text-gray-500 text-lg text-justify mr-7"><a href="#" class="font-medium text-red-600 underlinehover:no-underline" data-popover-target="popover-image">Switzerland</a> is renowned for its breathtaking natural landscapes, where majestic snow-capped mountains, shimmering lakes, and lush green valleys come together to create a scene of unparalleled beauty. The Swiss Alps, with their towering peaks and rugged cliffs, offer awe-inspiring vistas and are a paradise for hikers and skiers alike. Clear, pristine lakes like Lake Geneva and Lake Lucerne reflect the surrounding mountains, providing tranquil spots that feel almost magical. Switzerland's countryside is dotted with charming villages nestled among rolling hills and vibrant meadows filled with wildflowers in spring and summer. In autumn, the forests blaze with warm colors, while winter blankets the landscape in serene white. This diverse natural beauty makes Switzerland a dream destination for nature lovers year-round.</p>
        <div id="popover-image" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-96">
            <div class="grid grid-cols-6">
                <div class="col-span-3 p-3">
                    <div class="space-y-2">
                        <h3 class="font-semibold text-gray-900">About Switzerland</h3>
                        <p>Switzerland is renowned for its breathtaking natural landscapes, where majestic snow-capped mountains, shimmering lakes, and lush green valleys come together to create a scene of unparalleled beauty.</p>
                        <a href="/about" class="flex items-center font-medium text-red-600 hover:text-red-700 hover:underline">Read more <svg class="w-2 h-2 ms-1.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
        </svg></a>
                    </div>
                </div>
                <img src="/images/swiss2.jpg" class="h-full col-span-3" alt="Italy map" />
            </div>
            <div data-popper-arrow></div>
        </div>
    </div>

    <div class="bg-cover bg-center bg-[url('/images/swiss3.jpg')] h-96"></div>
    </section>
@endsection