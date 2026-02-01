<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paw Haven | Checkout</title>
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
        .summary-row:hover {
            background-color: #f9fafb;
        }
        .checkout-image {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 8px;
        }
        /* New styles for two-column layout */
        .checkout-container {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
        }
        .left-section {
            flex: 1 1 300px;
            min-width: 280px;
        }
        .right-section {
            flex: 1 1 300px;
            min-width: 280px;
        }
        @media (max-width: 768px) {
            .checkout-container {
                flex-direction: column;
            }
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
                        <a href="{{ route('user.accessories.index') }}" class="text-sm font-medium text-gray-900 hover:text-blue-600 transition-colors duration-200 {{ request()->routeIs('user.accessories.index') ? 'text-blue-600' : '' }}">Foods</a>
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
                            <a href="{{ route('user.accessories.index') }}" class="block px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 rounded-lg {{ request()->routeIs('user.accessories.index') ? 'bg-gray-100' : '' }}">Foods</a>
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
            <a href="{{ route('user.cart.index') }}">
                <svg class="w-5 h-5 text-gray-600 hover:text-blue-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-2xl font-semibold text-gray-900">Checkout</h1>
        </div>
        <div>
            <a href="{{ route('user.cart.index') }}">
                <svg class="w-6 h-6 text-gray-600 hover:text-blue-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-6 pt-28 pb-12 z-20">
        <div class="checkout-container">
            <!-- Left Section - User Address -->
            <div class="left-section">
                <div class="bg-white rounded-xl shadow-sm p-6 lg:p-8 fade-in">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 border-b border-gray-200 pb-4">Shipping Information</h2>
                    
                    @if(auth()->user()->street_address && auth()->user()->city && auth()->user()->province)
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <svg class="w-5 h-5 text-gray-400 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Delivery Address</h3>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ auth()->user()->street_address }}, {{ auth()->user()->city }}, {{ auth()->user()->province }}
                                        @if(auth()->user()->postal_code)
                                            {{ auth()->user()->postal_code }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <svg class="w-5 h-5 text-gray-400 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Email</h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <svg class="w-5 h-5 text-gray-400 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Phone</h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ auth()->user()->phone ?? 'Not provided' }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        Please update your shipping address in your profile before placing an order.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Section - Order Summary -->
            <div class="right-section">
                <div class="bg-white rounded-xl shadow-sm p-6 lg:p-8 fade-in">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 border-b border-gray-200 pb-4">Order Summary</h2>

                    <!-- Order Items -->
                    <div class="space-y-4 mb-6">
                        @foreach($cartItems as $item)
                            <div class="flex items-center space-x-4">
                                @if($item->item_type === 'App\\Models\\Pet')
                                    <img src="{{ asset('storage/' . $item->item->pet_image1) }}" 
                                         alt="{{ $item->item->name }}" 
                                         class="w-16 h-16 object-cover rounded-lg">
                                @elseif($item->item_type === 'App\\Models\\Accessories')
                                    <img src="{{ asset('storage/' . $item->item->image1) }}" 
                                         alt="{{ $item->item->name }}" 
                                         class="w-16 h-16 object-cover rounded-lg">
                                @elseif($item->item_type === 'App\\Models\\Food')
                                    <img src="{{ asset('storage/' . $item->item->image1) }}" 
                                         alt="{{ $item->item->name }}" 
                                         class="w-16 h-16 object-cover rounded-lg">
                                @endif
                                <div class="flex-1">
                                    <h3 class="text-sm font-medium text-gray-900">{{ $item->item->name }}</h3>
                                    <p class="text-sm text-gray-500">Quantity: {{ $item->quantity }}</p>
                                    <p class="text-sm font-medium text-gray-900">₱{{ number_format($item->item->price * $item->quantity, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Total -->
                    <div class="border-t border-gray-200 pt-4 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-medium text-gray-900">Total</span>
                            <span class="text-lg font-medium text-gray-900">₱{{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <form method="POST" action="{{ route('user.cart.checkout') }}" class="space-y-6">
                        @csrf
                        @if($productId)
                            <input type="hidden" name="product_id" value="{{ $productId }}">
                            <input type="hidden" name="product_type" value="{{ $productType }}">
                            <input type="hidden" name="quantity" value="{{ $quantity }}">
                        @else
                            @foreach($cartItems as $item)
                                <input type="hidden" name="selected_items[]" value="{{ $item->id }}">
                            @endforeach
                        @endif

                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900">Payment Method</h3>
                            <div class="space-y-3">
                                <label class="flex items-center space-x-3 p-4 border border-gray-200 rounded-lg hover:border-blue-500 cursor-pointer">
                                    <input type="radio" name="payment_method" value="gcash" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <div>
                                        <span class="text-sm font-medium text-gray-900">GCash</span>
                                        <p class="text-xs text-gray-500 mt-1">Pay using GCash mobile wallet</p>
                                    </div>
                                </label>
                                <label class="flex items-center space-x-3 p-4 border border-gray-200 rounded-lg hover:border-blue-500 cursor-pointer">
                                    <input type="radio" name="payment_method" value="cod" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <div>
                                        <span class="text-sm font-medium text-gray-900">Cash on Delivery</span>
                                        <p class="text-xs text-gray-500 mt-1">Pay when you receive your order</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <button type="submit" 
                                class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200 {{ !auth()->user()->street_address || !auth()->user()->city || !auth()->user()->province ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ !auth()->user()->street_address || !auth()->user()->city || !auth()->user()->province ? 'disabled' : '' }}>
                            Place Order
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <x-footer />

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGJRfKT8Q7eyut7XKU2j9rtLXvlfLXpwk&libraries=places&region=PH&language=en" async defer></script>
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

        // Google Places Autocomplete for Philippine address fields
        function initAutocomplete() {
            const options = {
                componentRestrictions: { country: "ph" },
                fields: ["address_components", "geometry"],
                types: ["address"]
            };

            const streetInput = document.getElementById('street_address');
            const cityInput = document.getElementById('city');
            const provinceInput = document.getElementById('province');

            const autocomplete = new google.maps.places.Autocomplete(streetInput, options);

            autocomplete.addListener('place_changed', () => {
                const place = autocomplete.getPlace();
                if (!place.address_components) {
                    return;
                }

                let street = '';
                let city = '';
                let province = '';

                place.address_components.forEach(component => {
                    const types = component.types;
                    if (types.includes('street_number')) {
                        street = component.long_name + ' ' + street;
                    }
                    if (types.includes('route')) {
                        street += component.long_name;
                    }
                    if (types.includes('locality')) {
                        city = component.long_name;
                    }
                    if (types.includes('administrative_area_level_1')) {
                        province = component.long_name;
                    }
                });

                streetInput.value = street;
                cityInput.value = city;
                provinceInput.value = province;
            });
        }

        window.initAutocomplete = initAutocomplete;
    </script>
</body>
</html>
