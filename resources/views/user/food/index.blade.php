<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Paw Haven | Food</title>
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
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: #d1d1d6;
            border-radius: 3px;
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
        @media (max-width: 768px) {
            .filter-sidebar,
            #filterToggle,
            #filter-button,
            .filter-overlay,
            .filter-buttons {
                display: none !important;
            }
        }

        /* Update z-index for other elements */
        #primary-nav {
            z-index: 99997;
        }
        #secondary-nav {
            z-index: 99996;
        }
        .main-content {
            position: relative;
            z-index: 1;
        }
        .food-grid {
            position: relative;
            z-index: 1;
        }
        .footer {
            position: relative;
            z-index: 1;
        }

        /* Filter button styles */
        #filter-button {
            position: fixed;
            bottom: 4rem;
            left: 1rem;
            z-index: 1000000;
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
        <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Browse Foods</h1>
    </div>
    <div class="flex items-center space-x-4">
        <form id="desktopFilterForm" method="GET" action="{{ route('user.food.index') }}" class="space-y-4 flex-1 max-w-md mx-4">
            <input type="text" name="search" id="searchInput" value="{{ request('search') }}" class="w-full sm:w-[20vw] border border-gray-200 rounded-full px-4 py-2 text-sm text-gray-900 placeholder-gray-600 focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200" placeholder="Search by food name...">
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
        <form id="desktopFilterForm" method="GET" action="{{ route('user.food.index') }}" class="space-y-4">
            <!-- Category -->
            <div>
                <label for="category" class="block text-xs font-medium text-gray-600 mb-1">Category</label>
                <select id="category" name="category" class="w-full border border-gray-200 rounded-full px-3 py-2 text-sm bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200">
                    <option value="">All</option>
                    <option value="Dry Food" {{ request('category') == 'Dry Food' ? 'selected' : '' }}>Dry Food</option>
                    <option value="Wet Food" {{ request('category') == 'Wet Food' ? 'selected' : '' }}>Wet Food</option>
                    <option value="Treats" {{ request('category') == 'Treats' ? 'selected' : '' }}>Treats</option>
                    <option value="Supplements" {{ request('category') == 'Supplements' ? 'selected' : '' }}>Supplements</option>
                </select>
            </div>
            <!-- Price Range -->
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Price</label>
                <div class="flex gap-3">
                    <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}" class="w-full border border-gray-200 rounded-full px-3 py-2 text-sm focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200" min="0" step="100">
                    <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}" class="w-full border border-gray-200 rounded-full px-3 py-2 text-sm focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200" min="0" step="100">
                </div>
            </div>
            <!-- Status -->
            <div>
                <label for="status" class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                <select name="status" id="status" class="w-full border border-gray-200 rounded-full px-3 py-2 text-sm bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200">
                    <option value="">Any</option>
                    <option value="Available" {{ request('status') == 'Available' ? 'selected' : '' }}>Available</option>
                    <option value="Unavailable" {{ request('status') == 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
                </select>
            </div>
            <!-- Buttons -->
            <div class="space-y-2">
                <button type="submit" class="w-full bg-blue-600 text-white rounded-full py-2 text-sm font-medium hover:bg-blue-700 transition duration-200">Apply Filters</button>
                @if(request()->anyFilled(['category', 'min_price', 'max_price', 'status']))
                    <a href="{{ route('user.food.index') }}" class="w-full block text-center border border-gray-200 text-gray-900 rounded-full py-2 text-sm font-medium hover:bg-gray-100 transition duration-200">Clear Filters</a>
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
        <form id="mobileFilterForm" method="GET" action="{{ route('user.food.index') }}" class="space-y-4">
            <!-- Category -->
            <div>
                <label for="mobile_category" class="block text-xs font-medium text-gray-600 mb-1">Category</label>
                <select id="mobile_category" name="category" class="w-full border border-gray-200 rounded-full px-3 py-2 text-sm bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200">
                    <option value="">All</option>
                    <option value="Dry Food" {{ request('category') == 'Dry Food' ? 'selected' : '' }}>Dry Food</option>
                    <option value="Wet Food" {{ request('category') == 'Wet Food' ? 'selected' : '' }}>Wet Food</option>
                    <option value="Treats" {{ request('category') == 'Treats' ? 'selected' : '' }}>Treats</option>
                    <option value="Supplements" {{ request('category') == 'Supplements' ? 'selected' : '' }}>Supplements</option>
                </select>
            </div>
            <!-- Price Range -->
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Price</label>
                <div class="flex gap-3">
                    <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}" class="w-full border border-gray-200 rounded-full px-3 py-2 text-sm focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200" min="0" step="100">
                    <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}" class="w-full border border-gray-200 rounded-full px-3 py-2 text-sm focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200" min="0" step="100">
                </div>
            </div>
            <!-- Status -->
            <div>
                <label for="mobile_status" class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                <select name="status" id="mobile_status" class="w-full border border-gray-200 rounded-full px-3 py-2 text-sm bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200">
                    <option value="">Any</option>
                    <option value="Available" {{ request('status') == 'Available' ? 'selected' : '' }}>Available</option>
                    <option value="Unavailable" {{ request('status') == 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
                </select>
            </div>
            <!-- Buttons -->
            <div class="space-y-2">
                <button type="submit" class="w-full bg-blue-600 text-white rounded-full py-2 text-sm font-medium hover:bg-blue-700 transition duration-200">Apply Filters</button>
                @if(request()->anyFilled(['category', 'min_price', 'max_price', 'status']))
                    <a href="{{ route('user.food.index') }}" class="w-full block text-center border border-gray-200 text-gray-900 rounded-full py-2 text-sm font-medium hover:bg-gray-100 transition duration-200">Clear Filters</a>
                @endif
            </div>
        </form>
    </div>
</div>

    <script src="{{ asset('javascript/food-filter.js') }}"></script>

    <!-- Mobile Search Bar -->
    <form id="mobileFilterForm" method="GET" action="{{ route('user.food.index') }}" class="sm:hidden px-4 py-2 bg-white border-b">
        <input type="text" name="search" id="mobileSearchInput" value="{{ request('search') }}" class="w-full border border-gray-200 rounded-full px-4 py-2 text-sm text-gray-900 placeholder-gray-600 focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200" placeholder="Search by food name...">
    </form>

    <!-- Mobile Filter Button -->
    <button id="filter-button" class="md:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
        </svg>
    </button>

    <!-- Filter Overlay -->
    <div class="filter-overlay"></div>

    <!-- Main Container -->
    <div class="flex flex-col md:flex-row min-h-[calc(100vh-112px)] pt-28 max-w-7xl mx-auto px-4 sm:px-6 z-20">
        <!-- Filter Sidebar (Mobile) -->
        <div id="filterContainer" class="md:hidden">
            <div id="filterOverlay" class="filter-overlay"></div>

        </div>



        <!-- Main Content -->
        <main class="flex-1 md:pl-8 z-20 mt-4 md:mt-0 main-content">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-8 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg fade-in">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-green-700 text-sm">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Food Grid -->
            <div id="foodGrid" class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-5 food-grid">
                @forelse($foods as $food)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg hover:scale-[1.02] fade-in" data-name="{{ $food->name }}">
                        <div class="relative">
                            <img src="{{ asset('storage/' . $food->image1) }}" alt="{{ $food->name }}" class="w-full h-48 sm:h-64 object-cover rounded-t-xl">
                            <div class="absolute top-3 right-3">
                                @if(strtolower($food->status) === 'sold out' || strtolower($food->status) === 'unavailable')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                        Sold Out
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                        In Stock
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $food->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $food->category }}</p>
                                </div>
                                <p class="text-lg font-medium text-gray-900">₱{{ number_format($food->price, 2) }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-2 text-sm text-gray-600 mb-4">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                    </svg>
                                    <span>{{ $food->brand }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                    </svg>
                                    <span>{{ $food->weight }}</span>
                                </div>
                            </div>
                            <a href="{{ route('user.food.show', $food->id) }}" class="block w-full text-center bg-blue-600 text-white py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition duration-200">View Details</a>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-600 col-span-full text-sm py-8 z-20 fade-in">No foods available matching your filters.</p>
                @endforelse
            </div>

            <!-- Pagination -->
            @if(method_exists($foods, 'hasPages') && $foods->hasPages())
                <div class="mt-6 fade-in">
                    {{ $foods->links('pagination::tailwind') }}
                </div>
            @endif
        </main>
    </div><br>
<x-footer />
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>
</html>