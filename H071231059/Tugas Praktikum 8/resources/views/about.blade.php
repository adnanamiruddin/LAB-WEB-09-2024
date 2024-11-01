@extends('layouts.master')

@section('title', 'About Page')

@section('content')
    <section>
        <div id="default-carousel" class="relative w-full" data-carousel="slide">
            <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="/images/carousel1.jpg" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                </div>
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="/images/carousel2.jpg" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                </div>
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="/images/carousel3.jpg" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                </div>
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="/images/carousel4.jpg" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                </div>
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="/images/carousel5.jpg" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                </div>
            </div>

            <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
                <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
                <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
                <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 4" data-carousel-slide-to="3"></button>
                <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 5" data-carousel-slide-to="4"></button>
            </div>

            <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30">
                    <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30">
                    <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
        </div>
    </section>
  
    <section>
        <div class="px-5 mt-10 mb-10">
            <h1 class="mb-4 text-3xl font-extrabold text-gray-900 md:text-5xl lg:text-6xl">The beauty of <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-red-300 ">Switzerland</span></h1>
            <p class="text-lg text-justify font-normal text-gray-500 lg:text-xl">
                Switzerland is renowned for its breathtaking landscapes, offering a stunning blend of towering snow-capped mountains, crystal-clear lakes, and lush green valleys. The Alps, with their rugged beauty, dominate the country’s terrain and provide some of the most awe-inspiring views in Europe. From the iconic Matterhorn to the sweeping vistas of the Jungfrau region, Switzerland’s mountains are a haven for both adventurers and those seeking serene natural beauty. The pristine lakes, such as Lake Geneva, Lake Lucerne, and Lake Thun, reflect the mountains' grandeur and are surrounded by charming villages and scenic trails that invite visitors to explore and unwind.
            </p>
            <p class="mt-2 text-lg text-justify font-normal text-gray-500 lg:text-xl">
                Beyond the mountains, Switzerland’s nature shines through its dense forests, colorful meadows, and cascading waterfalls. In spring and summer, the Swiss countryside bursts with vibrant wildflowers, creating a picturesque landscape that looks like something out of a fairytale. Autumn brings a magical transformation, with forests donning rich shades of orange, yellow, and red. Switzerland’s protected nature reserves, such as the Swiss National Park, showcase the country’s commitment to preserving its diverse flora and fauna, making it a paradise for nature lovers and photographers.
            </p>
        </div>

        <div class="bg-cover bg-center bg-[url('/images/about1.jpg')] h-96"></div>
    
        <div class="px-5 mt-10 mb-10">
            <p class="mb-3 text-gray-500 first-letter:text-7xl first-letter:font-bold first-letter:text-gray-900 first-letter:me-3 first-letter:float-start">
                Switzerland’s diverse ecosystems make it a year-round destination with stunning seasonal transformations. In the winter, the country becomes a snowy wonderland, attracting skiers, snowboarders, and winter sports enthusiasts from around the world. Picturesque alpine villages like Zermatt, St. Moritz, and Grindelwald are tucked amidst the mountains, offering cozy chalets, pristine ski slopes, and vibrant holiday markets that capture the festive spirit of the season. Even for non-skiers, winter in Switzerland offers the chance to experience scenic train journeys, like the Glacier Express, which weaves through snow-covered valleys and reveals some of the country’s most spectacular winter landscapes.
            </p>
            <p class="text-gray-500">
                In the warmer months, Switzerland’s natural beauty transforms as meadows bloom and trails open for hiking, cycling, and mountain climbing. The numerous walking paths around places like the Lauterbrunnen Valley reveal idyllic waterfalls and lush green fields, perfect for a peaceful escape into nature. Switzerland is also home to charming lakeside towns like Montreux and Lugano, where Mediterranean breezes meet alpine views, providing a unique setting to enjoy the outdoors. Here, visitors can relax along the shores, take boat rides, or indulge in the local cuisine while surrounded by Switzerland’s pristine natural beauty, making it a truly refreshing experience in every season.
            </p>
        </div>  
    </section>
  
    <section>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 px-5">
            <div>
                <img class="h-auto max-w-full rounded-lg transition-all duration-300 cursor-pointer filter grayscale hover:grayscale-0" src="/images/gallery1.jpg" alt="">
            </div>
            <div>
                <img class="h-auto max-w-full rounded-lg transition-all duration-300 cursor-pointer filter grayscale hover:grayscale-0" src="/images/gallery2.jpg" alt="">
            </div>
            <div>
                <img class="h-auto max-w-full rounded-lg transition-all duration-300 cursor-pointer filter grayscale hover:grayscale-0" src="/images/gallery3.jpg" alt="">
            </div>
            <div>
                <img class="h-auto max-w-full rounded-lg transition-all duration-300 cursor-pointer filter grayscale hover:grayscale-0" src="/images/gallery4.jpg" alt="">
            </div>
            <div>
                <img class="h-auto max-w-full rounded-lg transition-all duration-300 cursor-pointer filter grayscale hover:grayscale-0" src="/images/gallery5.jpg" alt="">
            </div>
            <div>
                <img class="h-auto max-w-full rounded-lg transition-all duration-300 cursor-pointer filter grayscale hover:grayscale-0" src="/images/gallery6.jpg" alt="">
            </div>
            <div>
                <img class="h-auto max-w-full rounded-lg transition-all duration-300 cursor-pointer filter grayscale hover:grayscale-0" src="/images/gallery7.jpg" alt="">
            </div>
            <div>
                <img class="h-auto max-w-full rounded-lg transition-all duration-300 cursor-pointer filter grayscale hover:grayscale-0" src="/images/gallery8.jpg" alt="">
            </div>
            <div>
                <img class="h-auto max-w-full rounded-lg transition-all duration-300 cursor-pointer filter grayscale hover:grayscale-0" src="/images/gallery9.jpg" alt="">
            </div>
        </div>
    </section>  
@endsection