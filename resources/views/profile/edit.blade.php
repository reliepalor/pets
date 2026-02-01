<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paw Haven | Profile - {{ Auth::user()->name }}</title>
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
        .order-row:hover {
            background-color: #f9fafb;
        }
        .profile-image, .order-image {
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
                        @if(Auth::user()->profile_image)
                            <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile Image" class="w-6 h-6 rounded-full mr-2 object-cover">
                        @else
                            <img src="/images/default-profile.png" alt="Profile Image" class="w-6 h-6 rounded-full mr-2 object-cover">
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
            <a href="{{ route('user.dashboard') }}">
                <svg class="w-5 h-5 text-gray-600 hover:text-blue-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-2xl font-semibold text-gray-900">Profile</h1>
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
        <div class="max-w-4xl mx-auto space-y-8">
            <!-- Profile Form -->
            <div class="bg-white rounded-xl shadow-sm p-8 fade-in">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Profile Information</h2>
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <!-- Profile Image -->
                    <div>
                        <label for="profile_image" class="block text-sm font-semibold text-gray-900 mb-2">Profile Image</label>
                        <img src="{{ $user->profile_image && $user->profile_image !== 'images/default-profile.png' ? asset('storage/' . $user->profile_image) : asset('images/default-profile.png') }}"
                             alt="Profile Image"
                             class="w-24 h-24 rounded-full profile-image shadow-sm hover:scale-105 transition-transform duration-200 mb-3">
                        <input id="profile_image" name="profile_image" type="file"
                               class="block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0
                                      file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100
                                      focus:outline-none focus:ring-2 focus:ring-blue-100 transition duration-200" />
                        @error('profile_image')
                            <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Name and Email -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-900 mb-2">Name</label>
                            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}"
                                   class="block w-full border border-gray-200 rounded-full p-3 text-sm
                                          focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200"
                                   required autofocus />
                            @error('name')
                                <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-900 mb-2">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}"
                                   class="block w-full border border-gray-200 rounded-full p-3 text-sm
                                          focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200"
                                   required />
                            @error('email')
                                <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Address -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Shipping Address</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="street_address" class="block text-sm font-semibold text-gray-900 mb-2">Barangay</label>
                                <input id="street_address" name="street_address" type="text" value="{{ old('street_address', $user->street_address) }}"
                                       class="block w-full border border-gray-200 rounded-full p-3 text-sm
                                              focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200"
                                       required />
                                @error('street_address')
                                    <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="city" class="block text-sm font-semibold text-gray-900 mb-2">Municipality</label>
                                <input id="city" name="city" type="text" value="{{ old('city', $user->city) }}"
                                       class="block w-full border border-gray-200 rounded-full p-3 text-sm
                                              focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200"
                                       required />
                                @error('city')
                                    <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="province" class="block text-sm font-semibold text-gray-900 mb-2">Province</label>
                                <input id="province" name="province" type="text" value="{{ old('province', $user->province) }}"
                                       class="block w-full border border-gray-200 rounded-full p-3 text-sm
                                              focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200"
                                       required />
                                @error('province')
                                    <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="postal_code" class="block text-sm font-semibold text-gray-900 mb-2">Postal Code</label>
                                <input id="postal_code" name="postal_code" type="text" value="{{ old('postal_code', $user->postal_code) }}"
                                       class="block w-full border border-gray-200 rounded-full p-3 text-sm
                                              focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200"
                                       required />
                                @error('postal_code')
                                    <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="country" class="block text-sm font-semibold text-gray-900 mb-2">Country</label>
                                <input id="country" name="country" type="text" value="{{ old('country', $user->country ?? 'Philippines') }}"
                                       class="block w-full border border-gray-200 rounded-full p-3 text-sm
                                              focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200"
                                       required />
                                @error('country')
                                    <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="flex items-center gap-4">
                        <button type="submit"
                                class="bg-blue-600 text-white py-3 px-6 rounded-full text-sm font-medium hover:bg-blue-700 transition-colors duration-200 w-full md:w-auto">
                            Save
                        </button>
                        @if (session('status') === 'profile-updated')
                            <div x-data="{ show: true }" x-show="show" x-transition
                                 x-init="setTimeout(() => show = false, 2000)"
                                 class="bg-green-50 text-green-700 p-3 rounded-xl text-sm font-medium fade-in">
                                Saved.
                            </div>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Orders Table -->
            <div class="bg-white rounded-xl shadow-sm p-8 fade-in">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Order History</h2>
                @if($orders->isEmpty())
                    <p class="text-gray-600 text-sm fade-in">You have no orders yet.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left">
                            <thead class="text-xs font-semibold text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    
                                    <th class="px-4 py-3">Products</th>
                                    <th class="px-4 py-3">Total Amount</th>
                                    <th class="px-4 py-3">Payment Method</th>
                                    <th class="px-4 py-3">Payment Status</th>
                                    <th class="px-4 py-3">Order Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($orders as $order)
                                    <tr class="order-row fade-in">
                                      
                                        <td class="px-4 py-4">
                                            <div class="space-y-2">
                                                @foreach($order->orderItems as $item)
                                                    <div class="flex items-center gap-3">
<img src="{{ $item->item && $item->item_type === 'App\\Models\\Pet' ? asset('storage/' . $item->item->pet_image1) : ($item->item && $item->item->image1 ? asset('storage/' . $item->item->image1) : '/images/placeholder.png') }}"
     alt="{{ $item->item ? $item->item->name : 'Item' }}"
     class="w-12 h-12 order-image">
                                                        <div>
<p class="text-sm font-medium text-gray-900">{{ $item->item ? $item->item->name : 'Item' }}</p>
                                                            <p class="text-xs text-gray-600">{{ ucfirst(class_basename($item->item_type)) }} x {{ $item->quantity }}</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-4 py-4">₱{{ number_format($order->total_amount, 2) }}</td>
                                        <td class="px-4 py-4">{{ ucfirst($order->payment_method) }}</td>
                                        <td class="px-4 py-4">{{ ucfirst($order->payment_status) }}</td>
                                        <td class="px-4 py-4">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </main>

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
    </script>
</body>
</html>