<nav class="fixed top-0 z-50 w-full bg-white shadow-sm border-b border-gray-100 dark:bg-gray-900 dark:border-gray-800">
    <div class="px-4 py-3 lg:px-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ url('dashboard') }}" class="flex items-center transform hover:scale-105 transition-transform">
                    <img src="{{ asset('storage/assets/jobhunt.jpg') }}" class="h-10 w-10 rounded-lg shadow-md"
                        alt="Logo">
                    <span
                        class="ml-3 text-2xl font-bold bg-gradient-to-r from-[#218838] to-[#00b24d] bg-clip-text text-transparent">
                        JobHunt
                    </span>
                </a>

                <!-- Navigation Menu -->
                <div class="hidden lg:flex items-center space-x-4">
                    @if (Auth::check() && Auth::user()->role === 'admin')
                        <x-nav-link :href="route('admin.index')" :active="request()->routeIs('admin.index')" class="text-[#218838] hover:text-[#00b24d]">
                            {{ __('Manage Users') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.listEmployers')" :active="request()->routeIs('admin.listEmployers')" class="text-[#218838] hover:text-[#00b24d]">
                            {{ __('Manage Employers') }}
                        </x-nav-link>
                    @endif

                    @if (Auth::check() && Auth::user()->role === 'employer')
                        <x-nav-link :href="route('jobPost')" :active="request()->routeIs('jobPost')" class="text-[#218838] hover:text-[#00b24d]">
                            {{ __('Job Listings') }}
                        </x-nav-link>
                        <x-nav-link :href="route('employer.index')" :active="request()->routeIs('employer.create')" class="text-[#218838] hover:text-[#00b24d]">
                            {{ __('Employer Profile') }}
                        </x-nav-link>
                        <x-nav-link :href="route('employer.applications')" :active="request()->routeIs('employer.applications')" class="text-[#218838] hover:text-[#00b24d]">
                            {{ __('Accepted/Rejected Applicants') }}
                        </x-nav-link>
                    @endif

                    @if (Auth::check() && Auth::user()->role === 'job_seeker')
                        <x-nav-link :href="route('jobSeeker.create')" :active="request()->routeIs('jobSeeker.create')" class="text-[#218838] hover:text-[#00b24d]">
                            {{ __('Personal Profile') }}
                        </x-nav-link>
                        <x-nav-link :href="route('jobseeker.job.list')" :active="request()->routeIs('jobseeker.job.list')" class="text-[#218838] hover:text-[#00b24d]">
                            {{ __('Find Jobs') }}
                        </x-nav-link>
                        <x-nav-link :href="route('jobSeeker.applications')" :active="request()->routeIs('jobSeeker.applications')" class="text-[#218838] hover:text-[#00b24d]">
                            {{ __('Application Status') }}
                        </x-nav-link>
                        <x-nav-link :href="route('jobseeker.favorites')" :active="request()->routeIs('jobseeker.favorites')" class="text-[#218838] hover:text-[#00b24d]">
                            {{ __('Favorite Jobs') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <div class="flex items-center lg:hidden">
                <button class="mobile-menu-button p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>

            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button
                        class="flex items-center space-x-3 px-4 py-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                        @if (Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                                class="h-8 w-8 rounded-full object-cover" alt="Profile Photo">
                        @else
                            <div
                                class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                            </div>
                        @endif
                        <div class="text-gray-700 dark:text-gray-300">{{ Auth::user()->username }}</div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')" class="flex items-center text-[#218838] hover:text-[#00b24d]">
                        <ion-icon name="person-outline" class="w-5 h-5 text-gray-700"></ion-icon>
                        <span class="ms-3">{{ __('Profile') }}</span>
                    </x-dropdown-link>

                    {{-- Authentication --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="flex items-center text-[#218838] hover:text-[#00b24d]">
                            <ion-icon name="log-out-outline" class="w-5 h-5 text-gray-700"></ion-icon>
                            <span class="ms-3">{{ __('Logout') }}</span>
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>

        <!-- Mobile Navigation Menu -->
        <div class="mobile-menu hidden lg:hidden mt-4">
            @if (Auth::check() && Auth::user()->role === 'admin')
                <x-nav-link :href="route('admin.index')" :active="request()->routeIs('admin.index')" class="text-[#218838] hover:text-[#00b24d]">
                    {{ __('Manage Users') }}
                </x-nav-link>
                <x-nav-link :href="route('admin.listEmployers')" :active="request()->routeIs('admin.listEmployers')" class="text-[#218838] hover:text-[#00b24d]">
                    {{ __('Manage Employers') }}
                </x-nav-link>
            @endif

            @if (Auth::check() && Auth::user()->role === 'employer')
                <x-nav-link :href="route('jobPost')" :active="request()->routeIs('jobPost')" class="text-[#218838] hover:text-[#00b24d]">
                    {{ __('Job Listings') }}
                </x-nav-link>
                <x-nav-link :href="route('employer.index')" :active="request()->routeIs('employer.create')" class="text-[#218838] hover:text-[#00b24d]">
                    {{ __('Employer Profile') }}
                </x-nav-link>
                <x-nav-link :href="route('employer.applications')" :active="request()->routeIs('employer.applications')" class="text-[#218838] hover:text-[#00b24d]">
                    {{ __('Accepted/Rejected Applicants') }}
                </x-nav-link>
            @endif

            @if (Auth::check() && Auth::user()->role === 'job_seeker')
                <x-nav-link :href="route('jobSeeker.create')" :active="request()->routeIs('jobSeeker.create')" class="text-[#218838] hover:text-[#00b24d]">
                    {{ __('Personal Profile') }}
                </x-nav-link>
                <x-nav-link :href="route('jobseeker.job.list')" :active="request()->routeIs('jobseeker.job.list')" class="text-[#218838] hover:text-[#00b24d]">
                    {{ __('Find Jobs') }}
                </x-nav-link>
                <x-nav-link :href="route('jobSeeker.applications')" :active="request()->routeIs('jobSeeker.applications')" class="text-[#218838] hover:text-[#00b24d]">
                    {{ __('Application Status') }}
                </x-nav-link>
                <x-nav-link :href="route('jobseeker.favorites')" :active="request()->routeIs('jobseeker.favorites')" class="text-[#218838] hover:text-[#00b24d]">
                    {{ __('Favorite Jobs') }}
                </x-nav-link>
            @endif
        </div>
    </div>
</nav>

<style>
    .x-nav-link {
        @apply px-3 py-2 text-sm font-medium text-[#218838] hover:text-[#00b24d] hover:bg-green-50 rounded-md transition-all;
    }

    .x-nav-link.active {
        @apply text-[#00b24d] bg-green-100;
    }

    @media (max-width: 1024px) {
        .mobile-menu {
            @apply pb-4 space-y-2;
        }

        .mobile-menu .x-nav-link {
            @apply block w-full;
        }
    }
</style>

<script>
    // Add mobile menu toggle functionality
    document.querySelector('.mobile-menu-button').addEventListener('click', function() {
        document.querySelector('.mobile-menu').classList.toggle('hidden');
    });
</script>
