<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Paw Haven | Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <script src="{{ asset('javascript/welcome.js') }}"></script>
    <script src="{{ asset('javascript/welcome-scroll.js') }}" defer></script>
    <link rel="icon" type="image/x-icon" href="/images/paw.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100">
    <!-- Primary Navigation (Fixed) -->
    <div class="flex justify-center items-center">
        <nav x-data="{ open: false, dropdownOpen: false }" id="primary-nav" class="flex justify-between items-center px-4 py-3 bg-white blur-bg shadow-sm rounded-xl mx-auto w-11/12 max-w-7xl fixed top-5 z-50">
            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <a href="{{ auth()->check() ? (auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard')) : route('welcome') }}" class="flex items-center">
                    <img src="/images/paw.png" alt="Paw Logo" class="w-8 h-8">
                    <span class="text-xl font-semibold text-gray-900">Paw Haven</span>
                </a>
            </div>
            <!-- Desktop Menu -->
            <div class="hidden md:flex md:space-x-8 md:items-center">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-gray-900 hover:text-blue-600 transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'text-blue-600' : '' }}">Admin Dashboard</a>
                        <a href="{{ route('admin.pets.index') }}" class="text-sm font-medium text-gray-900 hover:text-blue-600 transition-colors duration-200 {{ request()->routeIs('admin.pets.index') ? 'text-blue-600' : '' }}">Manage Pets</a>
                        <a href="{{ route('admin.accessories.index') }}" class="text-sm font-medium text-gray-900 hover:text-blue-600 transition-colors duration-200 {{ request()->routeIs('admin.accessories.index') ? 'text-blue-600' : '' }}">Manage Accessories</a>
                    @else
                        <a href="{{ route('user.dashboard') }}" class="text-sm font-medium text-gray-900 hover:text-blue-600 transition-colors duration-200 {{ request()->routeIs('user.dashboard') ? 'text-blue-600' : '' }}">Home</a>
                        <a href="{{ route('user.pets.index') }}" class="text-sm font-medium text-gray-900 hover:text-blue-600 transition-colors duration-200 {{ request()->routeIs('user.pets.index') ? 'text-blue-600' : '' }}">Pets</a>
                        <a href="{{ route('user.accessories.index') }}" class="text-sm font-medium text-gray-900 hover:text-blue-600 transition-colors duration-200 {{ request()->routeIs('user.accessories.index') ? 'text-blue-600' : '' }}">Accessories</a>
                        <a href="{{ route('user.food.index') }}" class="text-sm font-medium text-gray-900 hover:text-blue-600 transition-colors duration-200 {{ request()->routeIs('user.food.index') ? 'text-blue-600' : '' }}">Foods</a>
                    @endif
                @else
                    <a href="{{ route('welcome') }}" class="text-sm font-medium text-gray-900 hover:text-blue-600 transition-colors duration-200">Home</a>
                    <a href="{{ route('services') }}" class="text-sm font-medium text-gray-900 hover:text-blue-600 transition-colors duration-200">Services</a>
                    <a href="#" class="text-sm font-medium text-gray-900 hover:text-blue-600 transition-colors duration-200">Contact</a>
                    <a href="#" class="text-sm font-medium text-gray-900 hover:text-blue-600 transition-colors duration-200">About</a>
                @endauth
            </div>
            <!-- Desktop User Actions -->
            <div class="hidden md:flex md:space-x-6 md:items-center relative">
                @auth
                    <button @click="dropdownOpen = !dropdownOpen" class="flex items-center text-sm font-medium text-gray-900 hover:text-blue-600 transition-colors duration-200">
                        @if(Auth::user()->profile_image && Auth::user()->profile_image !== 'images/default-profile.png')
                            <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile Image" class="w-6 h-6 rounded-full mr-2 object-cover">
                        @else
                            <img src="{{ asset('images/default-profile.png') }}" alt="Profile Image" class="w-6 h-6 rounded-full mr-2 object-cover">
                        @endif
                        <span>{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4 ml-1 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="dropdownOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-48 rounded-lg shadow-md bg-white ring-1 ring-gray-200 z-50" @click.away="dropdownOpen = false">
                        <div class="py-1">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-900 hover:bg-gray-100">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-sm text-gray-900 hover:bg-gray-100">Log Out</a>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-900 hover:text-blue-600 transition-colors duration-200">Sign In</a>
                    <a href="{{ route('register') }}" class="text-sm font-medium text-gray-900 hover:text-blue-600 transition-colors duration-200">Sign Up</a>
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-900 hover:text-blue-600 transition-colors duration-200">Cart</a>
                @endauth
            </div>
            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <button @click="open = !open" id="menu-btn" class="text-gray-600 hover:text-gray-900 focus:outline-none p-2">
                    <svg :class="{ 'hidden': open }" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                    <svg :class="{ 'hidden': !open }" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <!-- Mobile Menu -->
            <div :class="{'block': open, 'hidden': !open}" class="md:hidden absolute top-16 left-0 right-0 bg-white blur-bg shadow-md rounded-b-lg w-[95%] mx-auto z-40">
                <div class="px-4 py-4 space-y-3">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100' : '' }}">Admin Dashboard</a>
                            <a href="{{ route('admin.pets.index') }}" class="block px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 rounded-lg {{ request()->routeIs('admin.pets.index') ? 'bg-gray-100' : '' }}">Manage Pets</a>
                            <a href="{{ route('admin.accessories.index') }}" class="block px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 rounded-lg {{ request()->routeIs('admin.accessories.index') ? 'bg-gray-100' : '' }}">Manage Accessories</a>
                        @else
                            <a href="{{ route('user.dashboard') }}" class="block px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 rounded-lg {{ request()->routeIs('user.dashboard') ? 'bg-gray-100' : '' }}">Home</a>
                            <a href="{{ route('user.pets.index') }}" class="block px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 rounded-lg {{ request()->routeIs('user.pets.index') ? 'bg-gray-100' : '' }}">Pets</a>
                            <a href="{{ route('user.accessories.index') }}" class="block px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 rounded-lg {{ request()->routeIs('user.accessories.index') ? 'bg-gray-100' : '' }}">Accessories</a>
                            <a href="{{ route('user.food.index') }}" class="block px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 rounded-lg {{ request()->routeIs('user.food.index') ? 'bg-gray-100' : '' }}">Foods</a>
                        @endif
                        <div class="pt-4 border-t border-gray-200">
                            <div class="px-3">
                                <div class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-gray-600">{{ Auth::user()->email }}</div>
                            </div>
                            <div class="mt-2 space-y-1">
                                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-sm text-gray-900 hover:bg-gray-100 rounded-lg">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-3 py-2 text-sm text-gray-900 hover:bg-gray-100 rounded-lg">Log Out</a>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('welcome') }}" class="block px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 rounded-lg">Home</a>
                        <a href="{{ route('services') }}" class="block px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 rounded-lg">Services</a>
                        <a href="#" class="block px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 rounded-lg">Contact</a>
                        <a href="#" class="block px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 rounded-lg">About</a>
                        <a href="{{ route('login') }}" class="block px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 rounded-lg">Sign In</a>
                        <a href="{{ route('register') }}" class="block px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 rounded-lg">Sign Up</a>
                        <a href="{{ route('login') }}" class="block px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 rounded-lg">Cart</a>
                    @endauth
                </div>
            </div>
        </nav>
    </div>

    <!-- Hero Section -->
    <div class="px-4 sm:px-6 py-3 mt-20">
        <section class="flex justify-center relative px-4 sm:px-6 py-8 sm:py-16 mb-5 mx-auto animate-fade-in bg-blue-100 rounded-[20px] sm:rounded-[40px]">
            <div class="flex flex-col justify-center mt-16 sm:mt-20">
                <div class="flex flex-col justify-center mt-1">
                    <div class="flex flex-col justify-center text-center mb-8 sm:mb-12 mx-4 sm:mx-10">
                        <div class="flex justify-center items-center rounded-full py-2 px-4">
                            <div class="flex items-center space-x-2 sm:space-x-3 shadow-sm border border-gray-50 rounded-full px-1 py-1 hover:bg-blue-100 transition-all duration-300 hover:border-gray-400 cursor-pointer">
                                <span class="bg-white rounded-full px-2 sm:px-3 py-1 text-xs sm:text-sm text-gray-800 border border-gray-200 hover:bg-gray-700 hover:text-gray-200 cursor-pointer transition-transform duration-300 ease-in-out transform hover:scale-110">
                                    5.0 ✨
                                </span>
                                <span class="text-sm sm:text-base text-gray-800">Top Rated Pets</span>
                                <!-- Pet Icons -->
                                <div class="flex space-x-1">
                                    <!-- Dog Icon -->
                                    <div class="w-6 h-6 sm:w-8 sm:h-8 bg-gray-800 rounded-full flex items-center justify-center transition-transform duration-200 ease-in-out transform hover:scale-110">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 4c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 6c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm0 10c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4zm-6-4c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm12 0c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
                                        </svg>
                                    </div>
                                    <!-- Cat Icon -->
                                    <div class="w-6 h-6 sm:w-8 sm:h-8 bg-blue-600 rounded-full flex items-center justify-center transition-transform duration-200 ease-in-out transform hover:scale-110">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 3c-2.5 0-4.5 2-4.5 4.5 0 1.5 1 2.8 2.4 3.6-2.5.5-4.4 2.8-4.4 5.4 0 3 2.5 5.5 5.5 5.5s5.5-2.5 5.5-5.5c0-2.6-1.9-4.9-4.4-5.4 1.4-.8 2.4-2.1 2.4-3.6C16.5 5 14.5 3 12 3zm0 2c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm-2 10h4v2h-4v-2z"/>
                                        </svg>
                                    </div>
                                    <!-- Paw Print Icon -->
                                    <div class="w-6 h-6 sm:w-8 sm:h-8 bg-indigo-600 rounded-full flex items-center justify-center transition-transform duration-200 ease-in-out transform hover:scale-110">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 10c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm-4-4c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm8 0c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-4 8c-2.5 0-4.5 2-4.5 4.5 0 1.5 1 2.8 2.4 3.6-2.5.5-4.4 2.8-4.4 5.4h2c0-2.5 2-4.5 4.5-4.5s4.5 2 4.5 4.5h2c0-2.6-1.9-4.9-4.4-5.4 1.4-.8 2.4-2.1 2.4-3.6 0-2.5-2-4.5-4.5-4.5z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-7xl font-bold leading-tight mb-4 sm:mb-6 mt-4 sm:mt-5">
                            Bringing Joy to <span class="gradient-purple-pink-orange">People Where</span> <br class="hidden sm:block">
                            <span class="mx-0 sm:mx-3">Happy <span class="gradient-purple-pink-orange">Pets Meet Happy Homes</span></span>
                        </h1>      
                        
                        <div class="flex justify-center w-full mt-4 sm:mt-5">
                            <p class="text-base sm:text-lg md:text-xl text-center text-gray-600 max-w-2xl mx-auto px-4 sm:px-0">
                                Quality products for pets of all shapes and sizes.<br class="hidden sm:block"> 
                                Easy shopping, fast delivery, and<br class="hidden sm:block"> 
                                wag-worthy happiness.
                            </p>
                        </div>

                        <div class="flex justify-center w-full mt-6 sm:mt-8">
                            <a href="{{route('user.pets.index')}}" class="group flex items-center px-4 sm:px-6 py-2 sm:py-3 rounded-full text-sm font-medium text-white hover:shadow-lg hover:brightness-110 transition-all duration-300 transform hover:scale-[1.02] border-none cursor-pointer w-auto sm:w-auto" style="background: linear-gradient(to right, #c202c2, #ff7ebe, #feba3c);">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 transition-transform duration-300 group-hover:translate-x-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 4c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 6c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm0 10c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4zm-6-4c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm12 0c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
                                </svg>
                                <span class="whitespace-nowrap">Browse Lovable Pets</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Badges Section -->
    <section class="bg-gray-100 py-8 sm:py-12 fade-in">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 text-center">
            <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-3 sm:mb-4">Trusted by Thousands of Pet Parents</h2>
            <p class="text-xs sm:text-sm text-gray-600 mb-6 sm:mb-10">Loved for quality, care, and a paw-sitive shopping experience.</p>
            <div class="relative overflow-hidden">
                <div class="flex w-max scrolling-wrapper space-x-6 sm:space-x-12">
                    <div class="badge-group flex space-x-6 sm:space-x-12">
                        <div class="badge flex flex-col items-center text-xs sm:text-sm text-gray-700 min-w-[80px] sm:min-w-[100px] bg-white rounded-lg shadow-sm p-3 sm:p-4 border border-gray-100">
                            <img src="/images/badges/fast-delivery.png" alt="car delivery" class="w-8 h-8 sm:w-10 sm:h-10">
                            <span>Fast Delivery</span>
                        </div>
                        <div class="badge flex flex-col items-center text-xs sm:text-sm text-gray-700 min-w-[80px] sm:min-w-[100px] bg-white rounded-lg shadow-sm p-3 sm:p-4 border border-gray-100">
                            <img src="/images/badges/five-star-rating.png" alt="car delivery" class="w-8 h-8 sm:w-10 sm:h-10">
                            <span>5-Star Reviews</span>
                        </div>
                        <div class="badge flex flex-col items-center text-xs sm:text-sm text-gray-700 min-w-[80px] sm:min-w-[100px] bg-white rounded-lg shadow-sm p-3 sm:p-4 border border-gray-100">
                            <img src="/images/badges/veterinary.png" alt="car delivery" class="w-8 h-8 sm:w-10 sm:h-10">
                            <span>Vet Approved</span>
                        </div>
                        <div class="badge flex flex-col items-center text-xs sm:text-sm text-gray-700 min-w-[80px] sm:min-w-[100px] bg-white rounded-lg shadow-sm p-3 sm:p-4 border border-gray-100">
                            <img src="/images/badges/biodegradable.png" alt="car delivery" class="w-8 h-8 sm:w-10 sm:h-10 mb-1">
                            <span>Eco-Friendly</span>
                        </div>
                        <div class="badge flex flex-col items-center text-xs sm:text-sm text-gray-700 min-w-[80px] sm:min-w-[100px] bg-white rounded-lg shadow-sm p-3 sm:p-4 border border-gray-100">
                            <img src="/images/badges/return.png" alt="car delivery" class="w-8 h-8 sm:w-10 sm:h-10 mb-1">
                            <span>Easy Returns</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    


    
    

    <!-- Products Section -->
    <section class="py-12 fade-in">
      <div class="max-w-7xl mx-auto px-6">
          <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">The Best Pet Products</h2>
          <!-- Pets -->
          <div class="flex flex-col md:flex-row items-center mb-16 gap-8  p-6 transition-all duration-300">
              <div class="md:w-1/2 mb-6 md:mb-0">
                  <img src="/images/dogo.png" alt="Pets" class="w-full h-64 object-cover rounded-xl hover:scale-102 transition-transform duration-300">
              </div>
              <div class="md:w-1/2">
                  <span class="inline-block bg-blue-100 text-blue-800 text-sm font-semibold rounded-full px-3 py-1 mb-2">01</span>
                  <h3 class="text-2xl font-semibold text-gray-900 mb-2">Pets</h3>
                  <p class="text-md text-gray-600 mb-6">Discover our wide range of pets. We can help you find the perfect companion, from playful puppies to cuddly kittens, and make your home feel lively and pet-friendly.</p>
                  <a href="{{ route('user.pets.index') }}" class="inline-flex px-4 py-2 bg-blue-600 text-white rounded-full text-sm font-medium hover:bg-blue-700 transition duration-200">Try Now</a>
              </div>
          </div>
          <!-- Accessories -->
          <div class="flex flex-col md:flex-row-reverse items-center mb-16 gap-8  p-6 transition-all duration-300">
              <div class="md:w-1/2 mb-6 md:mb-0">
                  <img src="/images/accessories.jpg" alt="Accessories" class="w-full h-64 object-cover rounded-xl">
              </div>
              <div class="md:w-1/2">
                  <span class="inline-block bg-blue-100 text-blue-800 text-sm font-semibold rounded-full px-3 py-1 mb-2">02</span>
                  <h3 class="text-2xl font-semibold text-gray-900 mb-2">Accessories</h3>
                  <p class="text-md text-gray-600 mb-6">From cozy beds to fun toys and stylish collars, we've got the essentials to keep your pet happy and comfortable. Designed for everyday use with care and durability in mind.</p>
                  <a href="{{ route('user.accessories.index') }}" class="inline-flex px-4 py-2 bg-blue-600 text-white rounded-full text-sm font-medium hover:bg-blue-700 transition duration-200">Try Now</a>
              </div>
          </div>
          <!-- Foods -->
          <div class="flex flex-col md:flex-row items-center mb-16 gap-8 p-6 transition-all duration-300">
              <div class="md:w-1/2 mb-6 md:mb-0">
                  <img src="/images/catfood.png" alt="Foods" class="w-full h-64 object-cover rounded-xl">
              </div>
              <div class="md:w-1/2">
                  <span class="inline-block bg-blue-100 text-blue-800 text-sm font-semibold rounded-full px-3 py-1 mb-2">03</span>
                  <h3 class="text-2xl font-semibold text-gray-900 mb-2">Foods</h3>
                  <p class="text-md text-gray-600 mb-6">Fuel your pet's health with high-quality food and treats they'll actually enjoy. Balanced, nutritious, and trusted by pet parents everywhere.</p>
                  <a href="{{ route('user.food.index') }}" class="inline-flex px-4 py-2 bg-blue-600 text-white rounded-full text-sm font-medium hover:bg-blue-700 transition duration-200">Try Now</a>
              </div>
          </div>
      </div>
  </section>
  
    <section class="p-6 mx-auto">
          <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Our Best Categories</h2>
        <div class="grid grid-cols-7 grid-rows-6 gap-5 max-w-7xl mx-auto">
           <div class="col-span-3 row-span-6 bg-white shadow-md rounded-3xl overflow-hidden relative h-[35rem] hover:scale-[1.02] transition-transform duration-300">
                    <img src="/images/bento2.png" alt="Foods" class="absolute inset-0 w-full h-full object-cover">
                
                <p class="absolute top-10 left-6 z-10 text-gray-700 font-extrabold text-4xl md:text-5xl px-6 pt-6 drop-shadow-lg font-cursive">
                    Find more joy with Pets
                </p>
            </div>

            <div class="col-span-4 row-span-3 col-start-4 bg-white shadow-md h-[20rem] rounded-3xl overflow-hidden relative hover:scale-[1.02] transition-transform duration-300">
                <img src="/images/bento5.jpg" alt="Foods" class="absolute inset-0 w-full h-full object-cover">
                <p class="absolute top-[13rem] left-8 z-10 text-gray-600 font-cursive font-extrabold md:text-3xl px-5 pt-4 drop-shadow-lg">
                    Pets<span class="text-gray-400">:</span> Dogs and Cats
                </p>
                <span class="absolute top-[17rem] left-8 bg-gray-600 p-[.5px] w-[40rem]"></span>
            </div>

            <div class="col-span-2 row-span-3 col-start-4 row-start-4 bg-white shadow-md h-52 rounded-3xl overflow-hidden relative hover:scale-[1.02] transition-transform duration-300">
                <img src="/images/bentoacce.jpg" alt="Foods" class="absolute inset-0 w-full h-full object-cover">
            </div>

            <div class="col-span-2 row-span-3 col-start-6 row-start-4 bg-white shadow-md h-52 rounded-3xl overflow-hidden relative hover:scale-[1.02] transition-transform duration-300">
                <img src="/images/bentofood.jpg" alt="Foods" class="absolute inset-0 w-full h-full object-cover">
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="px-6 py-12 bg-gray-50 fade-in">
      <div class="max-w-7xl mx-auto">
          <h2 class="text-3xl font-bold text-center text-gray-900 mb-8">What Our Customers Say</h2>
          <div class="relative overflow-hidden h-[600px] testimonial-container">
              <div class="animate-scroll">
                  <div class="columns-1 md:columns-3 gap-5">
                      @isset($testimonials)
                      @foreach($testimonials as $testimonial)
                          <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 mb-5 break-inside-avoid hover-scale">
                              <p class="text-gray-600 italic">"{{ $testimonial->comment }}"</p>
                              <div class="flex mt-2">
                                  <div class="flex text-yellow-400">
                                      @for ($i = 1; $i <= 5; $i++)
                                          @if ($i <= $testimonial->rating)
                                              <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.95a1 1 0 00.95.69h4.15c.969 0 1.371 1.24.588 1.81l-3.36 2.44a1 1 0 00-.364 1.118l1.286 3.95c.3.921-.755 1.688-1.54 1.118L10 13.347l-3.36 2.44c-.784.57-1.838-.197-1.54-1.118l1.286-3.95a1 1 0 00-.364-1.118L3.722 9.377c-.783-.57-.38-1.81.588-1.81h4.15a1 1 0 00.95-.69l1.286-3.95z" />
                                              </svg>
                                          @else
                                              <svg class="w-5 h-5 fill-current text-gray-300" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.95a1 1 0 00.95.69h4.15c.969 0 1.371 1.24.588 1.81l-3.36 2.44a1 1 0 00-.364 1.118l1.286 3.95c.3.921-.755 1.688-1.54 1.118L10 13.347l-3.36 2.44c-.784.57-1.838-.197-1.54-1.118l1.286-3.95a1 1 0 00-.364-1.118L3.722 9.377c-.783-.57-.38-1.81.588-1.81h4.15a1 1 0 00.95-.69l1.286-3.95z" />
                                              </svg>
                                          @endif
                                      @endfor
                                  </div>
                              </div>
                              <div class="flex items-center mt-4">
                                  @if($testimonial->user && $testimonial->user->profile_image)
                                      <img src="{{ asset('storage/' . $testimonial->user->profile_image) }}" alt="{{ $testimonial->user->name }}" class="w-12 h-12 rounded-full mr-4 object-cover border border-gray-300">
                                  @else
                                      <img src="https://via.placeholder.com/48" alt="User Image" class="w-12 h-12 rounded-full mr-4 object-cover border border-gray-300">
                                  @endif
                                  <div>
                                      <h4 class="font-bold text-gray-900">{{ $testimonial->user ? $testimonial->user->name : 'Anonymous' }}</h4>
                                      <p class="text-sm text-gray-500">Pet Owner</p>
                                  </div>
                              </div>
                          </div>
                      @endforeach
                      @endisset
                  </div>
              </div>
          </div>
      </div>
    </section>

   
    <x-footer />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var openBtn = document.getElementById('openTestimonialModal');
            var closeBtn = document.getElementById('closeTestimonialModal');
            var modal = document.getElementById('testimonialModal');
            if (openBtn && closeBtn && modal) {
                openBtn.addEventListener('click', function() {
                    modal.classList.remove('hidden');
                });
                closeBtn.addEventListener('click', function() {
                    modal.classList.add('hidden');
                });
                window.addEventListener('click', function(event) {
                    if (event.target === modal) {
                        modal.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>
</html>