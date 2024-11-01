<header>
      <nav class="fixed top-0 left-0 w-full z-10 bg-white bg-opacity-10 backdrop-blur-sm">
          <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="https://en.wikipedia.org/wiki/Switzerland" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="images/swiss-flag2.png" class="h-10" alt="Flowbite Logo" />
                <span class="self-center text-2xl font-thin whitespace-nowrap font-serif">Switzerland</span>
            </a>
            <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
              <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0">
                <li>
                  <a href="{{ route('home') }}" class="block py-2 px-3 md:p-0 {{ request()->is('/') ? 'text-white bg-red-600 rounded md:bg-transparent md:text-red-600' : 'text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-red-600' }}" Home  " aria-current="page">
                    Home
                  </a>
                </li>
                <li>
                  <a href="{{ route('about')}}" class="block py-2 px-3  md:p-0  {{ request()->is('about') ? 'text-white bg-red-600 rounded md:bg-transparent md:text-red-600' : 'text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-red-600' }}">
                    About
                  </a>
                </li>
                <li>
                  <a href="{{ route('contact')}}" class="block py-2 px-3 md:p-0 {{ request()->is('contact') ? 'text-white bg-red-600 rounded md:bg-transparent md:text-red-600' : 'text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-red-600' }}">
                    Contact
                  </a>
                </li>
              </ul>
            </div>
          </div>
      </nav>
    </header>