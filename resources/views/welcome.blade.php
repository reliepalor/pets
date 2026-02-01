<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paw Haven - Pet shop</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/paw.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <script src="{{ asset('javascript/welcome.js') }}"></script>
    <script src="{{ asset('javascript/welcome-scroll.js') }}" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>
<body class="font-sans">
  <div class="flex flex-col justify-center items-center">
    <nav x-data="{ open: false }" class="nav-container bg-white shadow-md border border-gray-300 rounded-xl mx-auto w-4/5 fixed top-0 z-50 mt-5">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <!-- Logo -->
          <div class="flex items-center">
            <a href="{{ auth()->check() ? (auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard')) : route('welcome') }}" class="flex items-center">
              <img src="/images/paw.png" alt="Paw Logo" class="w-8 h-8">
              <span class="text-xl font-semibold text-gray-900 ml-2">Paw Haven</span>
            </a>
          </div>

          <!-- Desktop Menu -->
          <div class="hidden md:flex md:items-center md:space-x-6">
            @auth
              @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="text-gray-900 hover:text-gray-600 transition-colors duration-300 {{ request()->routeIs('admin.dashboard') ? 'font-semibold' : '' }}">Admin Dashboard</a>
                <a href="{{ route('admin.pets.index') }}" class="text-gray-900 hover:text-gray-600 transition-colors duration-300 {{ request()->routeIs('admin.pets.index') ? 'font-semibold' : '' }}">Manage Pets</a>
                <a href="{{ route('admin.accessories.index') }}" class="text-gray-900 hover:text-gray-600 transition-colors duration-300 {{ request()->routeIs('admin.accessories.index') ? 'font-semibold' : '' }}">Manage Accessories</a>
              @else
                <a href="{{ route('user.dashboard') }}" class="text-gray-900 hover:text-gray-600 transition-colors duration-300 {{ request()->routeIs('user.dashboard') ? 'font-semibold' : '' }}">Home</a>
                <a href="{{ route('user.pets.index') }}" class="text-gray-900 hover:text-gray-600 transition-colors duration-300 {{ request()->routeIs('user.pets.index') ? 'font-semibold' : '' }}">Pets</a>
                <a href="{{ route('user.accessories.index') }}" class="text-gray-900 hover:text-gray-600 transition-colors duration-300 {{ request()->routeIs('user.accessories.index') ? 'font-semibold' : '' }}">Accessories</a>
                <a href="{{ route('user.accessories.index') }}" class="text-gray-900 hover:text-gray-600 transition-colors duration-300 {{ request()->routeIs('user.accessories.index') ? 'font-semibold' : '' }}">Foods</a>
              @endif
            @else
              <a href="{{ route('user.dashboard') }}" class="text-gray-900 hover:text-gray-600 transition-colors duration-300 {{ request()->routeIs('user.dashboard') ? 'font-semibold' : '' }}">Home</a>
              <a href="{{ route('user.pets.index') }}" class="text-gray-900 hover:text-gray-600 transition-colors duration-300 {{ request()->routeIs('user.pets.index') ? 'font-semibold' : '' }}">Pets</a>
              <a href="{{ route('user.accessories.index') }}" class="text-gray-900 hover:text-gray-600 transition-colors duration-300 {{ request()->routeIs('user.accessories.index') ? 'font-semibold' : '' }}">Accessories</a>
              <a href="{{ route('user.accessories.index') }}" class="text-gray-900 hover:text-gray-600 transition-colors duration-300 {{ request()->routeIs('user.accessories.index') ? 'font-semibold' : '' }}">Foods</a>
            @endauth
          </div>

          <!-- Desktop User Actions -->
          <div class="hidden md:flex md:items-center md:space-x-4">
            @auth
              <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center space-x-2 text-gray-900 hover:text-gray-600 transition-colors duration-300">
                  @if(Auth::user()->profile_image)
                    <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile Image" class="w-8 h-8 rounded-full object-cover">
                  @endif
                  <span>{{ Auth::user()->name }}</span>
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </button>
                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
                  <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Log Out</button>
                  </form>
                </div>
              </div>
            @else
              <a href="{{ route('login') }}" class="text-gray-900 hover:text-gray-600 transition-colors duration-300">Sign In</a>
              <a href="{{ route('login') }}" class="text-gray-900 hover:text-gray-600 transition-colors duration-300">Cart</a>
            @endauth
          </div>

          <!-- Mobile Menu Button -->
          <div class="md:hidden">
            <button @click="open = !open" class="text-gray-600 hover:text-gray-800 focus:outline-none">
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Mobile Menu -->
      <div x-show="open" 
           x-transition:enter="transition ease-out duration-200"
           x-transition:enter-start="opacity-0 -translate-y-1"
           x-transition:enter-end="opacity-100 translate-y-0"
           x-transition:leave="transition ease-in duration-150"
           x-transition:leave-start="opacity-100 translate-y-0"
           x-transition:leave-end="opacity-0 -translate-y-1"
           class="md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
          @auth
            @if(auth()->user()->role === 'admin')
              <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-100 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100' : '' }}">Admin Dashboard</a>
              <a href="{{ route('admin.pets.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-100 {{ request()->routeIs('admin.pets.index') ? 'bg-gray-100' : '' }}">Manage Pets</a>
              <a href="{{ route('admin.accessories.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-100 {{ request()->routeIs('admin.accessories.index') ? 'bg-gray-100' : '' }}">Manage Accessories</a>
            @else
              <a href="{{ route('user.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-100 {{ request()->routeIs('user.dashboard') ? 'bg-gray-100' : '' }}">Home</a>
              <a href="{{ route('user.pets.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-100 {{ request()->routeIs('user.pets.index') ? 'bg-gray-100' : '' }}">Pets</a>
              <a href="{{ route('user.accessories.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-100 {{ request()->routeIs('user.accessories.index') ? 'bg-gray-100' : '' }}">Accessories</a>
              <a href="{{ route('user.accessories.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-100 {{ request()->routeIs('user.accessories.index') ? 'bg-gray-100' : '' }}">Foods</a>
            @endif
            <div class="pt-4 pb-3 border-t border-gray-200">
              <div class="flex items-center px-5">
                @if(Auth::user()->profile_image)
                  <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile Image" class="w-10 h-10 rounded-full object-cover">
                @endif
                <div class="ml-3">
                  <div class="text-base font-medium text-gray-900">{{ Auth::user()->name }}</div>
                  <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                </div>
              </div>
              <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-100">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-100">Log Out</button>
                </form>
              </div>
            </div>
          @else
            <a href="{{ route('user.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-100">Home</a>
            <a href="{{ route('user.pets.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-100">Pets</a>
            <a href="{{ route('user.accessories.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-100">Accessories</a>
            <a href="{{ route('user.accessories.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-100">Foods</a>
            <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-100">Sign In</a>
            <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-100">Cart</a>
          @endauth
        </div>
      </div>
    </nav>
    
  <!-- Mobile Menu -->
  <div id="mobile-menu" class="hidden md:hidden w-1/2 bg-white border border-gray-300 rounded-xl shadow-md p-4 transition-all duration-300 opacity-0 absolute top-16 right-5 z-50">
    <a href="#" class="block py-2 hover:text-gray-600 transition-colors duration-300">Home</a>
    <a href="#" class="block py-2 hover:text-gray-600 transition-colors duration-300">Services</a>
    <a href="#" class="block py-2 hover:text-gray-600 transition-colors duration-300">Contact</a>
    <a href="#" class="block py-2 hover:text-gray-600 transition-colors duration-300">About</a>
    <a href="{{ route('login') }}" class="block py-2 hover:text-gray-600 transition-colors duration-300">Sign In</a>
    <a href="#" class="block py-2 hover:text-gray-600 transition-colors duration-300">Cart</a>
  </div>
  </div>
  

    <!----------------------- Hero Section ---------------------------->
    <div class="px-4 sm:px-6 py-3">
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
                      <a href="#products" class="group flex items-center px-4 sm:px-6 py-2 sm:py-3 rounded-full text-sm font-medium text-white hover:shadow-lg hover:brightness-110 transition-all duration-300 transform hover:scale-[1.02] border-none cursor-pointer w-auto sm:w-auto" style="background: linear-gradient(to right, #c202c2, #ff7ebe, #feba3c);">
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

    <!----------------------- PAW HAVEN---------------------------->
    <section class="fade-in w-full min-h-[50vh] sm:h-[80vh] py-8 sm:py-12">
        <h2 class="text-2xl sm:text-3xl font-bold text-center text-gray-800 mb-6 sm:mb-12">Paw Haven</h2>
        <div class="flex flex-col sm:flex-row justify-center items-center gap-4 sm:gap-5 px-4 sm:px-6">
            <div class="w-full sm:w-[40%]">
                <p class="text-base sm:text-xl text-center text-gray-700" style="font-weight: 400; line-height: 2rem; sm:line-height: 3rem;">
                    Discover a wide range of adorable pets and quality accessories all in one place.
                    Whether you're looking to adopt, shop, or simply explore, we're here to make pet parenting joyful and easy.
                    Our mission is to connect happy pets with loving homes.
                    Start your journey today and give your furry friend the life they deserve!
                </p>
            </div>
            <div class="h-[200px] sm:h-full w-full sm:w-1/2 flex justify-center items-center">
                <video autoplay muted loop playsinline class="left-0 w-full h-full object-cover rounded-lg">
                    <source src="/videos/catvideo.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
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
                  <a href="{{ route('user.accessories.index') }}" class="inline-flex px-4 py-2 bg-blue-600 text-white rounded-full text-sm font-medium hover:bg-blue-700 transition duration-200">Try Now</a>
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
    <!-- New Products Section -->
    <section class="px-6 py-12 bg-white fade-in">
      <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-6">Featured Pets & Accessories</h2>
        <!-- Search Bar -->
        <div class="relative mb-8 max-w-md mx-auto">
          <div class="relative">
            <input 
              type="text" 
              id="searchInput" 
              placeholder="Search pets or accessories..." 
              class="w-full px-4 py-2 pl-10 text-gray-700 bg-gray-100 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-300 ease-in-out"
            >
            <svg class="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </div>
        </div>
        <!-- Pets Horizontal Scroll -->
        <div class="relative mb-12 flex items-center">
          <button id="scrollLeftPets" class="z-10 bg-white rounded-full shadow p-2 hover:bg-gray-100 mr-4">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
          </button>
          <div id="petsContainer" class="flex space-x-6 overflow-x-hidden snap-x snap-mandatory py-4 flex-1 transition-opacity duration-300">
            @foreach($pets as $pet)
            <div class="card bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 min-w-[220px] max-w-[220px] flex-shrink-0 snap-center" data-name="{{ strtolower($pet->name) }}" data-breed="{{ strtolower($pet->breed) }}" data-category="{{ strtolower($pet->category) }}">
              <div class="relative h-40 w-full">
                <img src="{{ asset('storage/' . $pet->pet_image1) }}" alt="{{ $pet->name }}" class="pet-image h-full w-full object-cover rounded-t-xl">
                <div class="absolute top-3 right-3">
                  <span class="px-3 py-1 text-xs font-semibold rounded-full 
                    @if($pet->status === 'Available') bg-green-100 text-green-800
                    @elseif($pet->status === 'Adopted') bg-gray-100 text-gray-800
                    @else bg-yellow-100 text-yellow-800 @endif">
                    {{ $pet->status }}
                  </span>
                </div>
              </div>
              <div class="p-4">
                <h3 class="text-lg font-semibold">{{ $pet->name }}</h3>
                <p class="text-sm text-gray-600 mt-1">{{ $pet->breed }} • {{ $pet->category }}</p>
                <p class="text-md font-medium mt-2">₱{{ number_format($pet->price, 2) }}</p>
                <div class="mt-3 grid grid-cols-2 gap-3 text-xs text-gray-600">
                  <div class="flex items-center">
                    <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>{{ $pet->age }}y</span>
                  </div>
                  <div class="flex items-center">
                    <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>{{ $pet->gender }}</span>
                  </div>
                  <div class="flex items-center col-span-2">
                    <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                    </svg>
                    <span>{{ $pet->color }}</span>
                  </div>
                </div>
                <div class="mt-4">
                  <a href="{{ route('login') }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white py-1 px-3 rounded-lg text-xs font-medium transition">Login to View Details</a>
                </div>
              </div>
            </div>
            @endforeach
          </div>
          <button id="scrollRightPets" class="z-10 bg-white rounded-full shadow p-2 hover:bg-gray-100 ml-4">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </button>
        </div>
        <!-- Accessories Horizontal Scroll -->
        <div class="relative flex items-center">
          <button id="scrollLeftAccessories" class="z-10 bg-white rounded-full shadow p-2 hover:bg-gray-100 mr-4">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
          </button>
          <div id="accessoriesContainer" class="flex space-x-6 overflow-x-hidden snap-x snap-mandatory py-4 flex-1 transition-opacity duration-300">
            @foreach($accessories as $accessory)
            <div class="accessory-card bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 min-w-[220px] max-w-[220px] snap-center" data-name="{{ strtolower($accessory->name) }}" data-category="{{ strtolower($accessory->category) }}">
              <div class="relative">
                <div class="accessory-image-wrapper w-full h-40 overflow-hidden rounded-t-lg">
                  <img src="{{ asset('storage/' . $accessory->image1) }}" alt="{{ $accessory->name }}" class="accessory-image w-full h-full object-cover">
                </div>
                <div class="absolute top-3 right-3">
                  <span class="status-badge 
                    @if($accessory->stock > 0) status-available
                    @else status-unavailable @endif">
                    @if($accessory->stock > 0) <span class="rounded-xl bg-green-200 px-3 py-1 text-[12px] text-gray-700" style="font-weight: 600">In Stock</span> @else Out of Stock @endif
                  </span> 
                </div>
              </div>      
              <div class="p-4"> 
                <div class="flex justify-between items-start">
                  <div>
                    <h3 class="text-lg font-semibold">{{ $accessory->name }}</h3>
                    <p class="text-md font-medium">₱{{ number_format($accessory->price, 2) }}</p>
                    <p class="text-sm text-gray-600 mt-1">{{ $accessory->category }}</p>
                  </div>
                </div>
                <div class="mt-4 grid grid-cols-2 gap-3 text-xs text-gray-600">
                  <div class="flex items-center">
                    <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                    </svg>
                    <span>{{ $accessory->color }}</span>
                  </div>
                  <div class="flex items-center">
                    <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                    </svg>
                    <span>{{ $accessory->size }}</span>
                  </div>
                </div>
                <div class="mt-4">
                  <a href="{{ route('login') }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white py-1 px-3 rounded-lg text-xs font-medium transition">Login to View Details</a>
                </div>
              </div>
            </div>
            @endforeach
          </div>
          <button id="scrollRightAccessories" class="z-10 bg-white rounded-full shadow p-2 hover:bg-gray-100 ml-4">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </button>
        </div>
      </div>
    </section>

    <!-- Testimonials Section -->
    <section class="px-6 py-12 bg-gray-50 fade-in">
      <div class="max-w-7xl mx-auto">
          <h2 class="text-3xl font-bold text-center text-gray-900 mb-8">What Our Customers Say</h2>
          <div class="relative overflow-hidden h-[600px] testimonial-container">
              <div class="animate-scroll">
                  <!-- First set of testimonials -->
                  <div class="columns-1 md:columns-3 gap-5">
                      @foreach($testimonials as $testimonial)
                          <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 mb-5 break-inside-avoid hover-scale">
                              <p class="text-gray-600 italic">"{{ $testimonial->comment }}"</p>
                              <div class="flex mt-2">
                                  {{-- Display star rating --}}
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
                  </div>
                  <!-- Duplicate set for seamless looping -->
                  <div class="columns-1 md:columns-3 gap-5">
                      @foreach($testimonials as $testimonial)
                          <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 mb-5 break-inside-avoid hover-scale">
                              <p class="text-gray-600 italic">"{{ $testimonial->comment }}"</p>
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
                  </div>
              </div>
          </div>
      </div>
    </section>


      <x-footer />

    <!-- Back to Top Button -->
    <button
        x-data="{ hovering: false }"
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        @mouseenter="hovering = true"
        @mouseleave="hovering = false"
        :class="hovering ? 'w-36 px-4' : 'w-12 px-0'"
        class="fixed bottom-8 right-8 bg-blue-300 hover:bg-blue-600 text-white rounded-full shadow-lg h-12 flex items-center justify-center overflow-hidden transition-all duration-300 ease-in-out"
        aria-label="Back to top"
    >
        <!-- Up Arrow Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0 transition-all duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
        </svg>

        <!-- Back to Top Text -->
        <span
            class="ml-2 whitespace-nowrap transition-all duration-300 ease-in-out"
            :class="hovering ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-2'"
        >
            Back to top
        </span>
    </button>
</body>

</html>
