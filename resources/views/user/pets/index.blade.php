<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Paw Haven | Pets</title>
    <link rel="icon" type="image/x-icon" href="/images/paw.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ asset('css/pets.css') }}" rel="stylesheet">


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
        <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Browse Pets</h1>
    </div>
    <div class="flex items-center space-x-4">
        <!-- Search Input -->
        <div class="flex-1 max-w-md mx-4">
            <input type="text" id="searchInput" class="w-full sm:w-[20vw] border border-gray-200 rounded-full px-4 py-2 text-sm text-gray-900 placeholder-gray-600 focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200" placeholder="Search by pet name...">
        </div>
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
        <form id="desktopFilterForm" method="GET" action="{{ route('user.pets.index') }}" class="space-y-4">
            <!-- Category -->
            <div>
                <label for="category" class="block text-xs font-medium text-gray-600 mb-1">Category</label>
                <select id="category" name="category" class="w-full border border-gray-200 rounded-full px-3 py-2 text-sm bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200">
                    <option value="">All</option>
                    <option value="Dog" {{ request('category') == 'Dog' ? 'selected' : '' }}>Dog</option>
                    <option value="Cat" {{ request('category') == 'Cat' ? 'selected' : '' }}>Cat</option>
                </select>
            </div>
            <!-- Breed -->
            <div>
                <label for="breed" class="block text-xs font-medium text-gray-600 mb-1">Breed</label>
                <select id="breed" name="breed" class="w-full border border-gray-200 rounded-full px-3 py-2 text-sm bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200">
                    <option value="">All</option>
                    @foreach($breeds as $breed)
                        <option value="{{ $breed }}" {{ request('breed') == $breed ? 'selected' : '' }}>{{ $breed }}</option>
                    @endforeach
                </select>
            </div>
            <!-- Age -->
            <div>
                <label for="age" class="block text-xs font-medium text-gray-600 mb-1">Age</label>
                <select name="age" class="w-full border border-gray-200 rounded-full px-3 py-2 text-sm bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200">
                    <option value="">Any</option>
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ request('age') == $i ? 'selected' : '' }}>{{ $i }}Y</option>
                    @endfor
                </select>
            </div>
            <!-- Gender -->
            <div>
                <label for="gender" class="block text-xs font-medium text-gray-600 mb-1">Gender</label>
                <select name="gender" class="w-full border border-gray-200 rounded-full px-3 py-2 text-sm bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200">
                    <option value="">Any</option>
                    <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
            <!-- Color -->
            <div>
                <label for="color" class="block text-xs font-medium text-gray-600 mb-1">Color</label>
                <select name="color" class="w-full border border-gray-200 rounded-full px-3 py-2 text-sm bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200">
                    <option value="">Any</option>
                    <option value="Black" {{ request('color') == 'Black' ? 'selected' : '' }}>Black</option>
                    <option value="White" {{ request('color') == 'White' ? 'selected' : '' }}>White</option>
                    <option value="Brown" {{ request('color') == 'Brown' ? 'selected' : '' }}>Brown</option>
                </select>
            </div>
            <!-- Status -->
            <div>
                <label for="status" class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                <select name="status" class="w-full border border-gray-200 rounded-full px-3 py-2 text-sm bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200">
                    <option value="">Any</option>
                    <option value="Available" {{ request('status') == 'Available' ? 'selected' : '' }}>Available</option>
                    <option value="Reserved" {{ request('status') == 'Reserved' ? 'selected' : '' }}>Reserved</option>
                </select>
            </div>
            <!-- Price Range -->
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Price</label>
                <div class="flex gap-3">
                    <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}" class="w-full border border-gray-200 rounded-full px-3 py-2 text-sm focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200" min="0" step="1000">
                    <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}" class="w-full border border-gray-200 rounded-full px-3 py-2 text-sm focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition duration-200" min="0" step="1000">
                </div>
            </div>
            <!-- Buttons -->
            <div class="space-y-2">
                <button type="submit" class="w-full bg-blue-600 text-white rounded-full py-2 text-sm font-medium hover:bg-blue-700 transition duration-200">Apply Filters</button>
                @if(request()->anyFilled(['category', 'breed', 'age', 'gender', 'color', 'status', 'min_price', 'max_price']))
                    <a href="{{ route('user.pets.index') }}" class="w-full block text-center border border-gray-200 text-gray-900 rounded-full py-2 text-sm font-medium hover:bg-gray-100 transition duration-200">Clear Filters</a>
                @endif
            </div>
        </form>
    </div>
</nav>

<!-- Mobile Filter Modal -->
<div id="mobileFilterModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 z-50 hidden md:hidden">
    <div class="fixed bottom-0 left-0 right-0 bg-white rounded-t-2xl p-3 max-h-[60vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-3">
            <h2 class="text-base font-semibold text-gray-900">Filters</h2>
            <button id="closeMobileFilter" class="text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form id="mobileFilterForm" method="GET" action="{{ route('user.pets.index') }}" class="space-y-3">
            <!-- Category -->
            <div>
                <label for="mobile_category" class="block text-[10px] font-medium text-gray-600 mb-1">Category</label>
                <select id="mobile_category" name="category" class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-xs bg-white focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-100 transition duration-200">
                    <option value="">All</option>
                    <option value="Dog" {{ request('category') == 'Dog' ? 'selected' : '' }}>Dog</option>
                    <option value="Cat" {{ request('category') == 'Cat' ? 'selected' : '' }}>Cat</option>
                </select>
            </div>
            <!-- Breed -->
            <div>
                <label for="mobile_breed" class="block text-[10px] font-medium text-gray-600 mb-1">Breed</label>
                <select id="mobile_breed" name="breed" class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-xs bg-white focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-100 transition duration-200">
                    <option value="">All</option>
                    @foreach($breeds as $breed)
                        <option value="{{ $breed }}" {{ request('breed') == $breed ? 'selected' : '' }}>{{ $breed }}</option>
                    @endforeach
                </select>
            </div>
            <!-- Age -->
            <div>
                <label for="mobile_age" class="block text-[10px] font-medium text-gray-600 mb-1">Age</label>
                <select name="age" class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-xs bg-white focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-100 transition duration-200">
                    <option value="">Any</option>
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ request('age') == $i ? 'selected' : '' }}>{{ $i }}Y</option>
                    @endfor
                </select>
            </div>
            <!-- Gender -->
            <div>
                <label for="mobile_gender" class="block text-[10px] font-medium text-gray-600 mb-1">Gender</label>
                <select name="gender" class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-xs bg-white focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-100 transition duration-200">
                    <option value="">Any</option>
                    <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
            <!-- Color -->
            <div>
                <label for="mobile_color" class="block text-[10px] font-medium text-gray-600 mb-1">Color</label>
                <select name="color" class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-xs bg-white focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-100 transition duration-200">
                    <option value="">Any</option>
                    <option value="Black" {{ request('color') == 'Black' ? 'selected' : '' }}>Black</option>
                    <option value="White" {{ request('color') == 'White' ? 'selected' : '' }}>White</option>
                    <option value="Brown" {{ request('color') == 'Brown' ? 'selected' : '' }}>Brown</option>
                </select>
            </div>
            <!-- Status -->
            <div>
                <label for="mobile_status" class="block text-[10px] font-medium text-gray-600 mb-1">Status</label>
                <select name="status" class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-xs bg-white focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-100 transition duration-200">
                    <option value="">Any</option>
                    <option value="Available" {{ request('status') == 'Available' ? 'selected' : '' }}>Available</option>
                    <option value="Reserved" {{ request('status') == 'Reserved' ? 'selected' : '' }}>Reserved</option>
                </select>
            </div>
            <!-- Price Range -->
            <div>
                <label class="block text-[10px] font-medium text-gray-600 mb-1">Price</label>
                <div class="flex gap-2">
                    <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}" class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-100 transition duration-200" min="0" step="1000">
                    <input type="number" name="max_price" placeholder="Max" value="{{ request('min_price') }}" class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-100 transition duration-200" min="0" step="1000">
                </div>
            </div>
            <!-- Buttons -->
            <div class="space-y-1.5">
                <button type="submit" class="w-full bg-blue-600 text-white rounded-full py-1.5 text-xs font-medium hover:bg-blue-700 transition duration-200">Apply Filters</button>
                @if(request()->anyFilled(['category', 'breed', 'age', 'gender', 'color', 'status', 'min_price', 'max_price']))
                    <a href="{{ route('user.pets.index') }}" class="w-full block text-center border border-gray-200 text-gray-900 rounded-full py-1.5 text-xs font-medium hover:bg-gray-100 transition duration-200">Clear Filters</a>
                @endif
            </div>
        </form>
    </div>
</div>
    <!-- Filter Overlay -->
    <div class="filter-overlay"></div>

<!-- Main Container -->
<div class="flex flex-col md:flex-row min-h-[calc(100vh-112px)] pt-28 max-w-7xl mx-auto px-4 sm:px-6 z-20">
    <!-- Main Content -->
    <main class="flex-1 md:pl-8 z-20 mt-4 md:mt-0">
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

        <!-- Pets Grid -->
        <div id="petsGrid" class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6 mb-5">
            @forelse($pets as $pet)
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg hover:scale-[1.02] fade-in" data-name="{{ $pet->name }}">
                    <div class="relative">
                        <img src="{{ asset('storage/' . $pet->pet_image1) }}" 
                             alt="{{ $pet->name }}" 
                             class="w-full h-40 sm:h-64 object-cover rounded-t-xl">
                        <div class="absolute top-3 right-3">
                            @if(strtolower($pet->status) === 'sold out' || strtolower($pet->status) === 'unavailable')
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                    Sold Out
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                    Available
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="p-3 sm:p-4">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h3 class="text-base sm:text-lg font-semibold text-gray-900">{{ $pet->name }}</h3>
                                <p class="text-xs sm:text-sm text-gray-600">{{ $pet->breed }} • {{ $pet->category }}</p>
                            </div>
                            <p class="text-base sm:text-lg font-medium text-gray-900">₱{{ number_format($pet->price, 2) }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-xs sm:text-sm text-gray-600 mb-3 sm:mb-4">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $pet->age }} months</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>{{ $pet->gender }}</span>
                            </div>
                            <div class="flex items-center col-span-2">
                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                </svg>
                                <span>{{ $pet->color }}</span>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('user.pets.show', $pet) }}" 
                               class="flex-1 text-center bg-blue-600 text-white py-2 rounded-lg text-xs sm:text-sm font-medium hover:bg-blue-700 transition duration-200">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-600 col-span-full text-sm py-8 z-20 fade-in">No pets available matching your filters.</p>
            @endforelse
        </div>
    </main>
</div>
    <x-footer />
    
</body>
</html>