<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paw Haven | Your Cart</title>
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
        .cart-table tr:hover {
            background-color: #f9fafb;
        }
        .cart-image {
            width: 64px;
            height: 64px;
            object-fit: cover;
            border-radius: 8px;
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
            <a href="{{ route('user.pets.index') }}">
                <svg class="w-5 h-5 text-gray-600 hover:text-blue-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-2xl font-semibold text-gray-900">Your Cart</h1>
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
        <div class="bg-white rounded-xl shadow-sm p-6 lg:p-8 fade-in">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6 border-b border-gray-200 pb-4">Shopping Cart</h1>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-xl fade-in">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl fade-in">
            {{ session('error') }}
        </div>
    @endif

    @php
        use Illuminate\Support\Facades\DB;
        $cartItems = DB::table('cart_items')
            ->join('pets', 'cart_items.item_id', '=', 'pets.id')
            ->where('cart_items.user_id', auth()->id())
            ->where('cart_items.item_type', 'App\\Models\\Pet')
            ->select('cart_items.*', 'pets.name', 'pets.price', 'pets.pet_image1', 'pets.quantity as pet_quantity')
            ->get();

        $accessoryItems = DB::table('cart_items')
            ->join('accessories', 'cart_items.item_id', '=', 'accessories.id')
            ->where('cart_items.user_id', auth()->id())
            ->where('cart_items.item_type', 'App\\Models\\Accessories')
            ->select('cart_items.*', 'accessories.name', 'accessories.price', 'accessories.image1', 'accessories.stock')
            ->get();

        $foodItems = DB::table('cart_items')
            ->join('food', 'cart_items.item_id', '=', 'food.id')
            ->where('cart_items.user_id', auth()->id())
            ->where('cart_items.item_type', 'App\\Models\\Food')
            ->select('cart_items.*', 'food.name', 'food.price', 'food.image1', 'food.stock')
            ->get();

        $cartItems = $cartItems->concat($accessoryItems)->concat($foodItems);
    @endphp

    @if($cartItems->isEmpty())
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <h2 class="text-xl font-semibold text-gray-900 mb-2">Your cart is empty</h2>
            <p class="text-gray-600 mb-6">Looks like you haven't added any items to your cart yet.</p>
            <a href="{{ route('user.pets.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                Start Shopping
            </a>
        </div>
    @else
        <form action="{{ route('user.cart.checkout') }}" method="GET" id="checkout-form">
            <!-- Desktop Table View -->
            <div class="hidden md:block">
                <table class="min-w-full divide-y divide-gray-200 cart-table">
                    <thead class="bg-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Item</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Price</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Quantity</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($cartItems as $item)
                            <tr class="hover:bg-gray-50 transition duration-200" data-price="{{ $item->price }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" 
                                           name="selected_items[]" 
                                           value="{{ $item->id }}" 
                                           class="item-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                           onchange="updateTotal()"
                                           aria-label="Select {{ $item->name }}">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap flex items-center space-x-4">
                                    <img src="{{ $item->item_type === 'App\\Models\\Pet' ? asset('storage/' . $item->pet_image1) : ($item->image1 ? asset('storage/' . $item->image1) : asset('images/default-image.png')) }}" 
                                         alt="{{ $item->name }}" 
                                         class="w-16 h-16 object-cover rounded-lg shadow-sm">
                                    <span class="text-sm font-medium text-gray-900">{{ $item->name }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    @if($item->item_type === 'App\\Models\\Pet' || $item->item_type === 'pet')
                                        Pet
                                    @elseif($item->item_type === 'App\\Models\\Accessories' || $item->item_type === 'accessory')
                                        Accessory
                                    @else
                                        Food
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 price">
                                    ₱{{ number_format($item->price, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('user.cart.update', $item->id) }}" method="POST" class="flex items-center space-x-2">
                                        @csrf
                                        @method('PATCH')
                                        <label for="quantity-{{ $item->id }}" class="sr-only">Quantity for {{ $item->name }}</label>
                                        <input type="number" 
                                               name="quantity" 
                                               id="quantity-{{ $item->id }}" 
                                               value="{{ $item->quantity }}" 
                                               min="1" 
                                               max="{{ $item->item_type === 'App\\Models\\Pet' ? $item->pet_quantity : $item->stock }}"
                                               class="item-quantity w-20 px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200"
                                               onchange="this.form.submit()">
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('user.cart.remove', $item->id) }}" method="POST" class="flex-shrink-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium transition-colors duration-200" aria-label="Remove {{ $item->name }}">
                                            Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden space-y-4">
                @foreach($cartItems as $item)
                    <div class="cart-item bg-white border border-gray-200 rounded-xl p-4 shadow-sm" data-price="{{ $item->price }}">
                        <div class="flex items-center space-x-4 mb-4">
                            <input type="checkbox" 
                                   name="selected_items[]" 
                                   value="{{ $item->id }}" 
                                   class="item-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                   onchange="updateTotal()"
                                   aria-label="Select {{ $item->name }}">
                            <img src="{{ $item->item_type === 'App\\Models\\Pet' ? asset('storage/' . $item->pet_image1) : ($item->image1 ? asset('storage/' . $item->image1) : asset('images/default-image.png')) }}" 
                                 alt="{{ $item->name }}" 
                                 class="w-16 h-16 object-cover rounded-lg shadow-sm">
                            <div>
                                <h3 class="text-sm font-medium text-gray-900">{{ $item->name }}</h3>
                                <p class="text-sm text-gray-600">
                                    @if($item->item_type === 'App\\Models\\Pet' || $item->item_type === 'pet')
                                        Pet
                                    @elseif($item->item_type === 'App\\Models\\Accessories' || $item->item_type === 'accessory')
                                        Accessory
                                    @else
                                        Food
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-xs font-medium text-gray-600">Price</p>
                                <p class="text-sm font-medium text-gray-900 price">₱{{ number_format($item->price, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-600">Quantity</p>
                                <form action="{{ route('user.cart.update', $item->id) }}" method="POST" class="flex items-center">
                                    @csrf
                                    @method('PATCH')
                                    <label for="quantity-{{ $item->id }}" class="sr-only">Quantity for {{ $item->name }}</label>
                                    <input type="number" 
                                           name="quantity" 
                                           id="quantity-{{ $item->id }}" 
                                           value="{{ $item->quantity }}" 
                                           min="1" 
                                           max="{{ $item->item_type === 'App\\Models\\Pet' ? $item->pet_quantity : $item->stock }}"
                                           class="item-quantity w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200"
                                           onchange="this.form.submit()">
                                </form>
                            </div>
                        </div>
                        <form action="{{ route('user.cart.remove', $item->id) }}" method="POST" class="flex-shrink-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium transition-colors duration-200 w-full text-left" aria-label="Remove {{ $item->name }}">
                                Remove
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-lg font-medium text-gray-900">Selected Items Total</span>
                    <span class="text-lg font-medium text-gray-900" id="selected-total">₱0.00</span>
                </div>
                <button type="submit" 
                        id="checkout-button"
                        class="w-full flex items-center justify-center px-4 py-3 bg-blue-600 text-white rounded-xl text-base font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                    Proceed to Checkout
                </button>
            </div>
        </form>
    @endif
</div>

<script>
function toggleAllItems(checkbox) {
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    itemCheckboxes.forEach(itemCheckbox => {
        itemCheckbox.checked = checkbox.checked;
    });
    // Add slight delay to ensure checkboxes are updated before calculating total
    setTimeout(updateTotal, 50);
}

function updateTotal() {
    const checkboxes = document.querySelectorAll('.item-checkbox:checked');
    let total = 0;

    checkboxes.forEach(checkbox => {
        const row = checkbox.closest('tr') || checkbox.closest('.cart-item');
        if (!row) return;
        let priceText = '';
        let quantityInput = null;

        if (row.tagName.toLowerCase() === 'tr') {
            // Desktop view
            priceText = row.querySelector('td:nth-child(4)').textContent.replace('₱', '').replace(/,/g, '');
            quantityInput = row.querySelector('.item-quantity');
        } else {
            // Mobile view
            const priceElem = row.querySelector('.price');
            priceText = priceElem ? priceElem.textContent.replace('₱', '').replace(/,/g, '') : '';
            quantityInput = row.querySelector('.item-quantity');
        }

        console.log('Price text:', priceText);
        console.log('Quantity input:', quantityInput);

        if (priceText && quantityInput) {
            const price = parseFloat(priceText);
            const quantity = parseInt(quantityInput.value);
            
            if (!isNaN(price) && !isNaN(quantity)) {
                total += price * quantity;
            }
        }
    });

    const totalElement = document.getElementById('selected-total');
    if (totalElement) {
        totalElement.textContent = '₱' + total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }

    // Update select all checkbox state
    const selectAllCheckbox = document.getElementById('select-all');
    const allCheckboxes = document.querySelectorAll('.item-checkbox');
    const checkedCheckboxes = document.querySelectorAll('.item-checkbox:checked');
    
    if (selectAllCheckbox) {
        selectAllCheckbox.checked = allCheckboxes.length === checkedCheckboxes.length;
    }

    // Update checkout button state
    const checkoutButton = document.getElementById('checkout-button');
    if (checkoutButton) {
        checkoutButton.disabled = checkedCheckboxes.length === 0;
        checkoutButton.classList.toggle('opacity-50', checkedCheckboxes.length === 0);
        checkoutButton.classList.toggle('cursor-not-allowed', checkedCheckboxes.length === 0);
    }
}

// Initialize total on page load
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners for quantity changes
    const quantityInputs = document.querySelectorAll('.item-quantity');
    quantityInputs.forEach(input => {
        input.addEventListener('change', updateTotal);
    });

    // Add event listeners for checkboxes
    const checkboxes = document.querySelectorAll('.item-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateTotal);
    });

    // Add event listener for select-all checkbox
    const selectAllCheckbox = document.getElementById('select-all');
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            toggleAllItems(this);
        });
    }

    // Initial total calculation
    updateTotal();
});
</script>
    </main>    
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

        function toggleAllItems(checkbox) {
            const itemCheckboxes = document.querySelectorAll('.item-checkbox');
            itemCheckboxes.forEach(itemCheckbox => {
                itemCheckbox.checked = checkbox.checked;
            });
            updateTotal();
        }

        function updateTotal() {
            const checkboxes = document.querySelectorAll('.item-checkbox:checked');
            let total = 0;

            checkboxes.forEach(checkbox => {
                const row = checkbox.closest('tr');
                const priceText = row.querySelector('td:nth-child(4)').textContent.replace('₱', '').replace(/,/g, '');
                const quantityInput = row.querySelector('.item-quantity');
                
                if (priceText && quantityInput) {
                    const price = parseFloat(priceText);
                    const quantity = parseInt(quantityInput.value);
                    
                    if (!isNaN(price) && !isNaN(quantity)) {
                        total += price * quantity;
                    }
                }
            });

            const totalElement = document.getElementById('selected-total');
            if (totalElement) {
                totalElement.textContent = '₱' + total.toFixed(2);
            }

            // Update select all checkbox state
            const selectAllCheckbox = document.getElementById('select-all');
            const allCheckboxes = document.querySelectorAll('.item-checkbox');
            const checkedCheckboxes = document.querySelectorAll('.item-checkbox:checked');
            
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = allCheckboxes.length === checkedCheckboxes.length;
            }

            // Update checkout button state
            const checkoutButton = document.getElementById('checkout-button');
            if (checkoutButton) {
                checkoutButton.disabled = checkedCheckboxes.length === 0;
                checkoutButton.classList.toggle('opacity-50', checkedCheckboxes.length === 0);
                checkoutButton.classList.toggle('cursor-not-allowed', checkedCheckboxes.length === 0);
            }
        }

        // Initialize total on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Add event listeners for quantity changes
            const quantityInputs = document.querySelectorAll('.item-quantity');
            quantityInputs.forEach(input => {
                input.addEventListener('change', updateTotal);
            });

            // Add event listeners for checkboxes
            const checkboxes = document.querySelectorAll('.item-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateTotal);
            });

            // Initial total calculation
            updateTotal();
        });
    </script>
</body>
</html>