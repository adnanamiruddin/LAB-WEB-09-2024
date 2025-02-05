<nav class="bg-white shadow">
    <div class="container mx-auto px-4">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="/" class="text-2xl font-bold text-gray-800">
                    Car Store
                </a>
            </div>
            
            <div class="flex items-center space-x-6">
                @auth
                    @if (Auth::user()->role === 'admin')
                        {{-- Admin Links --}}
                        <a href="{{ route('dashboard') }}"
                           class="text-gray-600 hover:text-gray-900">
                            Dashboard
                        </a>
                        <a href="{{ route('products.index') }}"
                           class="text-gray-600 hover:text-gray-900">
                            Products
                        </a>
                    @else
                        {{-- User Links --}}
                        <a href="{{ route('dashboard') }}"
                           class="text-gray-600 hover:text-gray-900">
                            Dashboard
                        </a>
                        <a href="{{ route('products.index') }}"
                           class="text-gray-600 hover:text-gray-900">
                            Shop
                        </a>
                        <a href="{{ route('cart.index') }}"
                           class="text-gray-600 hover:text-gray-900">
                            Cart
                        </a>
                    @endif

                    {{-- Common Links for Both Roles --}}
                    <a href="{{ route('profile.edit') }}"
                       class="text-gray-600 hover:text-gray-900">
                        Profile
                    </a>

                    {{-- Logout Link --}}
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-900">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">Login</a>
                    <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-900">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>