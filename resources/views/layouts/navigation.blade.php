<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | {{ Auth::user()->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>
    <div class="flex justify-center sticky z-100 top-0 right-0 left-0 z-100">
        <nav x-data="{ open: false, dropdownOpen: false }" class="w-[80%] bg-white dark:bg-white text-black shadow-xl dark:border-gray-700 mt-3 sm:mt-5 mb-3 sm:mb-5 rounded-xl overflow-hidden sticky top-0 z-100 bg-white">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-2 sm:px-4 md:px-6 lg:px-8 text-black">
                <div class="flex justify-evenly h-14 sm:h-16 gap-10">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ auth()->check() ? (auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard')) : route('welcome') }}">
                                <x-application-logo class="block h-7 sm:h-9 w-auto fill-current text-gray-800 dark:text-gray-800" />
                            </a>
                        </div>
                        <!-- Navigation Links -->
                        <div class="hidden space-x-4 sm:space-x-6 md:space-x-8 sm:-my-px sm:ms-6 md:ms-10 sm:flex">
                            @auth
                                @if(auth()->user()->role === 'admin')
                                    <!-- Admin Links -->
                                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                        {{ __('Admin Dashboard') }}
                                    </x-nav-link>
                                    <x-nav-link :href="route('admin.pets.index')" :active="request()->routeIs('admin.pets.index')">
                                        {{ __('Manage Pets') }}
                                    </x-nav-link>
                                    <x-nav-link :href="route('admin.accessories.index')" :active="request()->routeIs('admin.accessories.index')">
                                        {{ __('Manage Accessories') }}
                                    </x-nav-link>
                                @else
                                    <!-- User Links -->
                                    <x-nav-link :href="route('user.dashboard')" :active="request()->routeIs('user.dashboard')">
                                        {{ __('Home') }}
                                    </x-nav-link>
                                    <x-nav-link :href="route('user.pets.index')" :active="request()->routeIs('user.pets.index')">
                                        <span class="text-gray-700">{{ __('Pets') }}</span>
                                    </x-nav-link>
                                    <x-nav-link :href="route('user.accessories.index')" :active="request()->routeIs('user.accessories.index')">
                                        <span class="text-gray-700">{{ __('Accessories') }}</span>
                                    </x-nav-link>
                                    <x-nav-link :href="route('user.accessories.index')" :active="request()->routeIs('user.accessories.index')">
                                        <span class="text-gray-700">{{ __('Foods') }}</span>
                                    </x-nav-link>
                                @endif
                            @endauth
                        </div>
                    </div>
                    <!-- Settings Dropdown (Hidden on Mobile) -->
                    <div class="hidden md:flex md:space-x-6 md:items-center relative">
                        @auth
                            <button @click="dropdownOpen = !dropdownOpen" class="flex items-center text-sm font-medium text-gray-900 hover:text-blue-600 transition-colors duration-200">
                                <img src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('images/default-profile.png') }}" 
                                     alt="Profile Image" 
                                     class="w-6 h-6 rounded-full mr-2 object-cover">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 ml-1 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        @endauth
                    </div>
                    <!-- Hamburger -->
                    <div class="-me-2 flex items-center sm:hidden">
                        <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out relative w-8 h-8">
                            <div :class="{ 'rotate-45 top-4': open }" class="hamburger-line line-1 absolute h-0.5 w-6 bg-current rounded-full top-3 left-1 pointer-events-none transition-transform duration-300"></div>
                            <div :class="{ 'opacity-0': open }" class="hamburger-line line-2 absolute h-0.5 w-6 bg-current rounded-full top-4 left-1 pointer-events-none transition-opacity duration-300"></div>
                            <div :class="{ '-rotate-45 top-4': open }" class="hamburger-line塾 line-3 absolute h-0.5 w-6 bg-current rounded-full top-5 left-1 pointer-events-none transition-transform duration-300"></div>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Responsive Navigation Menu -->
            <div :class="{'block': open, 'hidden': !open}" class="sm:hidden bg-white dark:bg-white rounded-b-lg shadow-xl p-4 absolute w-[90%] right-0 mt-2">
                <div class="space-y-2">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                {{ __('Admin Dashboard') }}
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('admin.pets.index')" :active="request()->routeIs('admin.pets.index')">
                                {{ __('Manage Pets') }}
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('admin.accessories.index')" :active="request()->routeIs('admin.accessories.index')">
                                {{ __('Manage Accessories') }}
                            </x-responsive-nav-link>
                        @else
                            <x-responsive-nav-link :href="route('user.dashboard')" :active="request()->routeIs('user.dashboard')">
                                {{ __('Dashboard') }}
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('user.pets.index')" :active="request()->routeIs('user.pets.index')">
                                {{ __('Pets') }}
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('user.accessories.index')" :active="request()->routeIs('user.accessories.index')">
                                {{ __('Accessories') }}
                            </x-responsive-nav-link>
                        @endif
                    @endauth
                    @guest
                        <x-responsive-nav-link :href="route('login')">
                            {{ __('Login') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('register')">
                            {{ __('Register') }}
                        </x-responsive-nav-link>
                    @endguest
                </div>
                <!-- Responsive Settings Options -->
                @auth
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-600 mt-2">
                        <div class="px-0">
                            <div class="font-medium text-base text-gray-900 dark:text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                        <div class="mt-2 space-y-1">
                            <x-responsive-nav-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-responsive-nav-link>
                            <form method="POST" action="{{ route('logout') }}" @submit.prevent="dropdownOpen = false">
                                @csrf
                                <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-responsive-nav-link>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </nav>
    </div>
</body>
</html>