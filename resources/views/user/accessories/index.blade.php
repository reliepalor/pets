<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Paw Haven | Accessories</title>
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
        .sidebar-mobile-hidden {
            display: none;
        }
        @media (min-width: 768px) {
            .sidebar-mobile-hidden {
                display: block;
            }
        }
        @media (max-width: 768px) {
            .filter-sidebar,
            #filterToggle,
            #filter-button,
            .filter-overlay,
            .filter-buttons {
                display: none !important;
            }
        }
        #filter-button {
            position: fixed;
            bottom: 4rem;
            left: 1rem;
            z-index: 1000;
            background-color: #3b82f6;
            color: white;
            padding: 0.75rem;
            border-radius: 9999px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.2s ease;
        }
        #filter-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 8px -1px rgba(0, 0, 0, 0.15), 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="min-h-screen">
    <!------------------------ MAIN HEADER ------------------------->
    <x-header />
<!-- Secondary Navigation (Hide/Show on Scroll) -->
<nav id="secondary-nav" class="flex items-center justify-between px-4 sm:px-6 py-4 bg-white shadow-sm sticky top-16 z-40 max-w-7xl mx-auto transition-transform duration-300">
    <div class="flex items-center space-x-3">
        <a href="{{ route('user.dashboard') }}">
            <svg class="w-5 h-5 text-gray-600 hover:text-blue-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Browse Accessories</h1>
    </div>
    <div class="flex items-center space-x-4 justify-center">
        <form id="desktopFilterForm" action="{{ route('user.accessories.index') }}" method="GET" class="space-y-4 flex-1 max-w-md mx-4">
            <input type="text" name="search" id="searchInput" value="{{ request('search') }}" class="w-full sm:w-[20vw] border border-gray-200 rounded-full px-4 py-2 text-sm text-gray-900 placeholder-gray-600 focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200" placeholder="Search by accessory name...">
        </form>
        <!-- Desktop Filter Toggle Button -->
        <button id="desktopFilterToggle" class="hidden md:flex items-center space-x-2 px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
            <span>Filters</span>
        </button>
        <!-- Mobile Filter Toggle Button -->
        <button id="mobileFilterToggle" class="md:hidden flex items-center space-x-2 px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
            <span>Filters</span>
        </button>
        <!-- Cart Icon -->
        <a href="{{ route('user.cart.index') }}" class="text-gray-600 hover:text-blue-600 transition-colors duration-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </a>
    </div>
    <!-- Desktop Filter Dropdown -->
    <div id="desktopFilterDropdown" class="hidden absolute right-4 top-16 w-64 bg-white rounded-xl shadow-lg p-4 z-50">
        <form id="desktopFilterForm" action="{{ route('user.accessories.index') }}" method="GET" class="space-y-4">
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                <select name="category" id="category" class="mt-1 block w-full rounded-full border border-gray-200 px-3 py-2 text-sm bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                            {{ ucfirst($category) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Price Range</label>
                <div class="mt-1 grid grid-cols-2 gap-2">
                    <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}" class="block w-full rounded-full border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200">
                    <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}" class="block w-full rounded-full border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200">
                </div>
            </div>
            <div>
                <label for="sort_by" class="block text-sm font-medium text-gray-700">Sort By</label>
                <select name="sort_by" id="sort_by" class="mt-1 block w-full rounded-full border border-gray-200 px-3 py-2 text-sm bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200">
                    <option value="">Newest First</option>
                    <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="name_asc" {{ request('sort_by') == 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                    <option value="name_desc" {{ request('sort_by') == 'name_desc' ? 'selected' : '' }}>Name: Z to A</option>
                </select>
            </div>
            <div class="space-y-2">
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700 transition duration-200">Apply Filters</button>
                @if(request()->anyFilled(['category', 'min_price', 'max_price', 'sort_by']))
                    <a href="{{ route('user.accessories.index') }}" class="w-full block text-center border border-gray-200 text-gray-900 rounded-full px-4 py-2 text-sm font-medium hover:bg-gray-100 transition duration-200">Clear Filters</a>
                @endif
            </div>
        </form>
    </div>
</nav>

<!-- Mobile Filter Modal -->
<div id="mobileFilterModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 z-50 hidden md:hidden">
    <div class="fixed bottom-0 left-0 right-0 bg-white rounded-t-2xl p-4 max-h-[80vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-900">Filters</h2>
            <button id="closeMobileFilter" class="text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form id="mobileFilterForm" action="{{ route('user.accessories.index') }}" method="GET" class="space-y-4">
            <div>
                <label for="mobile_category" class="block text-sm font-medium text-gray-700">Category</label>
                <select name="category" id="mobile_category" class="mt-1 block w-full rounded-full border border-gray-200 px-3 py-2 text-sm bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                            {{ ucfirst($category) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Price Range</label>
                <div class="mt-1 grid grid-cols-2 gap-2">
                    <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}" class="block w-full rounded-full border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200">
                    <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}" class="block w-full rounded-full border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200">
                </div>
            </div>
            <div>
                <label for="mobile_sort_by" class="block text-sm font-medium text-gray-700">Sort By</label>
                <select name="sort_by" id="mobile_sort_by" class="mt-1 block w-full rounded-full border border-gray-200 px-3 py-2 text-sm bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200">
                    <option value="">Newest First</option>
                    <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="name_asc" {{ request('sort_by') == 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                    <option value="name_desc" {{ request('sort_by') == 'name_desc' ? 'selected' : '' }}>Name: Z to A</option>
                </select>
            </div>
            <div class="space-y-2">
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700 transition duration-200">Apply Filters</button>
                @if(request()->anyFilled(['category', 'min_price', 'max_price', 'sort_by']))
                    <a href="{{ route('user.accessories.index') }}" class="w-full block text-center border border-gray-200 text-gray-900 rounded-full px-4 py-2 text-sm font-medium hover:bg-gray-100 transition duration-200">Clear Filters</a>
                @endif
            </div>
        </form>
    </div>
</div>

    <!-- Filter Overlay -->
    <div class="filter-overlay" id="filterOverlay"></div>

<!-- Main Container -->
<div class="flex flex-col md:flex-row min-h-[calc(100vh-112px)] pt-28 max-w-7xl mx-auto px-4 sm:px-6 z-20">
    <main class="flex-1">
        @if(session('success'))
            <div class="mb-6 p-4 bg-white border-l-4 border-green-500 rounded-xl shadow-sm fade-in">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="text-sm text-green-700">{{ session('success') }}</span>
                </div>
            </div>
        @endif
        <div id="accessoriesGrid" class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-2.5 sm:gap-6 mb-5">
            @forelse($accessories as $accessory)
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg hover:scale-[1.02] fade-in" data-name="{{ $accessory->name }}" data-category="{{ $accessory->category }}" data-color="{{ $accessory->color }}" data-size="{{ $accessory->size }}" data-price="{{ $accessory->price }}">
                    <div class="relative">
                        <img src="{{ asset('storage/' . $accessory->image1) }}" 
                             alt="{{ $accessory->name }}" 
                             class="w-full h-40 sm:h-48 object-cover rounded-t-xl">
                        <div class="absolute top-2 right-2">
                            @if($accessory->stock > 0)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                    Available
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                    Out of Stock
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="p-3.5 sm:p-4">
                        <div class="grid grid-cols-[1fr_auto] gap-2 mb-2">
                            <div class="min-w-0">
                                <h3 class="text-xs sm:text-base font-semibold text-gray-900 line-clamp-2">{{ $accessory->name }}</h3>
                                <p class="text-xs sm:text-sm text-gray-600">{{ $accessory->category }}</p>
                            </div>
                            <p class="text-xs sm:text-base font-medium text-gray-900">₱{{ number_format($accessory->price, 2) }}</p>
                        </div>
                        <div class="flex items-center text-xs sm:text-sm text-gray-600 mb-3">
                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <span>Stock: {{ $accessory->stock }}</span>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('user.accessories.show', $accessory) }}" class="flex-1 text-center bg-blue-600 text-white py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition duration-200">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No accessories found</h3>
                    <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter criteria.</p>
                </div>
            @endforelse
        </div>
        @if(method_exists($accessories, 'links'))
            <div class="mt-6 bg-white shadow-sm rounded-lg p-3 flex justify-center">
                <span class="text-black">{!! $accessories->links() !!}</span>
            </div>
        @endif
    </main>
</div>
    <x-footer />
    <script src="//unpkg.com/alpinejs" defer></script>

</body>
</html>
