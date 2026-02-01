<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paw Haven | {{ $food->name }}</title>
    <link rel="icon" type="image/x-icon" href="/images/paw.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #f5f5f7;
            color: #1d1d1f;
        }
        .blur-bg {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.8);
        }
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .food-image-main {
            height: 384px;
            object-fit: cover;
            border-radius: 12px;
        }
        .food-image-thumb {
            height: 64px;
            object-fit: cover;
            border-radius: 8px;
            transition: opacity 0.2s;
        }
        .food-image-thumb:hover {
            opacity: 0.9;
        }
        .detail-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e8e8ed;
        }
        .detail-icon {
            width: 16px;
            height: 16px;
            color: #6b7280;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .status-available {
            background-color: #e8f0e9;
            color: #166534;
        }
        .status-out-of-stock {
            background-color: #e8e8ed;
            color: #374151;
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- Primary Navigation (Fixed) -->
    <div class="flex justify-center items-center">
        <nav x-data="{ open: false, dropdownOpen: false }" id="primary-nav" class="flex justify-between items-center px-4 py-3 bg-white blur-bg shadow-sm rounded-xl mx-auto w-11/12 max-w-7xl fixed top-0 z-50">
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

    <!-- Secondary Navigation (Hide/Show on Scroll) -->
    <nav id="secondary-nav" class="flex items-center justify-between px-6 py-4 bg-white shadow-sm sticky top-16 z-40 max-w-7xl mx-auto transition-transform duration-300">
        <div class="flex items-center space-x-3">
            <a href="{{ route('user.food.index') }}">
                <svg class="w-5 h-5 text-gray-600 hover:text-blue-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-2xl font-semibold text-gray-900">{{ $food->name }}</h1>
        </div>
        <div class="flex items-center">
            <a href="{{ route('user.cart.index') }}">
                <svg class="w-6 h-6 text-gray-600 hover:text-blue-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-6 pt-28 pb-12 z-20">
        <div class="bg-white rounded-xl shadow-sm overflow-hidden fade-in">
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Food Images -->
                    <div>
                        <div class="mb-4 rounded-xl overflow-hidden">
                            <img src="{{ $food->image1 ? asset('storage/' . $food->image1) : asset('images/default-food.png') }}" 
                                 alt="{{ $food->name }}" 
                                 id="main-image" 
                                 class="food-image-main w-full fade-in">
                        </div>
                        @if($food->image2 || $food->image3 || $food->image4 || $food->image5)
                            <div class="grid grid-cols-4 gap-2">
                                @if($food->image2)
                                    <div>
                                        <img src="{{ asset('storage/' . $food->image2) }}" 
                                             alt="{{ $food->name }} - Image 2" 
                                             class="food-image-thumb w-full cursor-pointer" 
                                             data-image="{{ asset('storage/' . $food->image2) }}">
                                    </div>
                                @endif
                                @if($food->image3)
                                    <div>
                                        <img src="{{ asset('storage/' . $food->image3) }}" 
                                             alt="{{ $food->name }} - Image 3" 
                                             class="food-image-thumb w-full cursor-pointer" 
                                             data-image="{{ asset('storage/' . $food->image3) }}">
                                    </div>
                                @endif
                                @if($food->image4)
                                    <div>
                                        <img src="{{ asset('storage/' . $food->image4) }}" 
                                             alt="{{ $food->name }} - Image 4" 
                                             class="food-image-thumb w-full cursor-pointer" 
                                             data-image="{{ asset('storage/' . $food->image4) }}">
                                    </div>
                                @endif
                                @if($food->image5)
                                    <div>
                                        <img src="{{ asset('storage/' . $food->image5) }}" 
                                             alt="{{ $food->name }} - Image 5" 
                                             class="food-image-thumb w-full cursor-pointer" 
                                             data-image="{{ asset('storage/' . $food->image5) }}">
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Food Details -->
                    <div class="fade-in">
                        <div class="flex justify-between items-start">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">{{ $food->name }}</h2>
                                <p class="text-sm text-gray-600 mt-1">{{ $food->brand }} • {{ $food->pet_type }}</p>
                            </div>
                            <span class="status-badge {{ $food->stock > 0 ? 'status-available' : 'status-out-of-stock' }}">
                                {{ $food->stock > 0 ? 'Available' : 'Out of Stock' }}
                            </span>
                        </div>

                        <div class="mt-6 bg-white rounded-xl shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Details</h3>
                            <div class="space-y-2">
                                <div class="detail-item">
                                    <svg class="detail-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3a4 4 0 110 8 4 4 0 010-8z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-xs text-gray-500">Pet Type</p>
                                        <p class="text-sm font-medium text-gray-900">{{ $food->pet_type }}</p>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <svg class="detail-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M3 3v18M3 3l18 18M21 3v18"></path>
                                    </svg>
                                    <div>
                                        <p class="text-xs text-gray-500">Stock</p>
                                        <p class="text-sm font-medium text-gray-900">{{ $food->stock }} in stock</p>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <svg class="detail-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div>
                                        <p class="text-xs text-gray-500">Price</p>
                                        <p class="text-sm font-medium text-gray-900">₱{{ number_format($food->price, 2) }}</p>
                                    </div>
                                </div>
                                @if($food->weight)
                                    <div class="detail-item">
                                        <svg class="detail-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-4m6 2l-3 9m-3-9l-6 4m9-1l3 9a5.002 5.002 0 006.001 0M18 7l3 9" />
                                        </svg>
                                        <div>
                                            <p class="text-xs text-gray-500">Weight</p>
                                            <p class="text-sm font-medium text-gray-900">{{ $food->weight }} kg</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if($food->description)
                            <div class="mt-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                                <p class="text-sm text-gray-600">{{ $food->description }}</p>
                            </div>
                        @endif

                        <form action="{{ route('user.food.add-to-cart', $food) }}" method="POST" class="mt-8">
                            @csrf
                            <div class="flex flex-col sm:flex-row gap-4">
                                <div class="w-full sm:w-24">
                                    <label for="quantity" class="sr-only">Quantity</label>
                                    <input type="number" 
                                           name="quantity" 
                                           id="quantity" 
                                           min="1" 
                                           max="{{ $food->stock }}" 
                                           value="1"
                                           class="w-full px-3 py-2 border border-gray-200 rounded-full text-sm focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200"
                                           {{ $food->stock == 0 ? 'disabled' : '' }}>
                                </div>
                                <div class="flex-1">
                                    <button type="submit" 
                                            class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-full text-sm font-medium hover:bg-blue-700 transition duration-200"
                                            {{ $food->stock == 0 ? 'disabled' : '' }}>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </form>

                        <form action="{{ route('user.cart.checkout') }}" method="GET" class="mt-4">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $food->id }}">
                            <input type="hidden" name="product_type" value="food">
                            <input type="hidden" name="quantity" id="checkout_quantity" value="1">
                            <button type="submit" 
                                    class="w-full flex items-center justify-center px-4 py-2 bg-gray-600 text-white rounded-full text-sm font-medium hover:bg-gray-700 transition duration-200">
                                Checkout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main><br>
<x-footer />
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        // Scroll-based hide/show for secondary navbar
        let lastScrollTop = 0;
        const secondaryNav = document.getElementById('secondary-nav');
        window.addEventListener('scroll', () => {
            let currentScroll = window.pageYOffset || document.documentElement.scrollTop;
            if (currentScroll > lastScrollTop && currentScroll > 50) {
                secondaryNav.style.transform = 'translateY(-100%)';
            } else if (currentScroll < lastScrollTop) {
                secondaryNav.style.transform = 'translateY(0)';
            }
            lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
        });

        // Fade-in animations
        document.addEventListener('DOMContentLoaded', () => {
            const elements = document.querySelectorAll('.fade-in');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            elements.forEach(element => observer.observe(element));
        });

        // Thumbnail click to update main image
        document.addEventListener('DOMContentLoaded', () => {
            const thumbs = document.querySelectorAll('.food-image-thumb');
            const mainImage = document.getElementById('main-image');
            thumbs.forEach(thumb => {
                thumb.addEventListener('click', () => {
                    mainImage.src = thumb.dataset.image;
                });
            });
        });

        // Update checkout quantity when cart quantity changes
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInput = document.getElementById('quantity');
            const checkoutQuantity = document.getElementById('checkout_quantity');
            
            if (quantityInput && checkoutQuantity) {
                quantityInput.addEventListener('change', function() {
                    checkoutQuantity.value = this.value;
                });
            }
        });
    </script>
</body>
</html>