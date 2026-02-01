<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Accessories - Admin Dashboard</title>
    <link rel="icon" type="image/x-icon" href="/images/paw.png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/Sidebar.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen font-[Instrument Sans]">
    <div class="min-h-screen flex">
<!-- Sidebar -->
<div class="sidebar expanded fixed left-4 top-4 h-[calc(100vh-2rem)] bg-white rounded-2xl p-4 z-50">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <span class="sidebar-title">pawhaven</span>
        <button id="sidebarToggle" class="p-2 rounded-lg hover:bg-gray-100">
            <svg class="w-6 h-6 text-gray-600 toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Navigation Items -->
    <nav class="space-y-2 flex flex-col h-full">
        <div>
            <a href="{{ route('admin.totals.products') }}" class="flex items-center p-3 text-gray-700 rounded-lg {{ request()->routeIs('admin.totals.products') ? 'active' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4v17M20 4v17" />
                </svg>
                <span class="nav-text ml-3">Totals</span>
            </a>
            <a href="{{ route('admin.pets.index') }}" class="flex items-center p-3 text-gray-700 rounded-lg {{ request()->routeIs('admin.pets.*') ? 'active' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="nav-text ml-3">Pets</span>
            </a>
            <a href="{{ route('admin.accessories.index') }}" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-200 transition {{ request()->routeIs('admin.accessories.index') ? 'active' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 014 12V7a4 4 0 013-4z" />
                </svg>
                <span class="nav-text ml-3">Accessories</span>
            </a>
            <a href="{{ route('admin.food.index') }}" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-200 transition {{ request()->routeIs('admin.food.index') ? 'active' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4" />
                </svg>
                <span class="nav-text ml-3">Food</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-200 transition {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span class="nav-text ml-3">Orders</span>
            </a>
            <a href="{{ route('admin.customers.index') }}" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-200 transition {{ request()->routeIs('admin.customers.index') ? 'active' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span class="nav-text ml-3">Customer List</span>
            </a>
        </div>
        <hr class="my-4">

        <!-- Bottom section - positioned at the bottom of the nav -->
        <div class="absolute bottom-0 left-0 right-0 p-4">
            <div class="flex flex-col space-y-2">
                <a href="" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100">
                    <img src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : asset('images/default-profile.png') }}" 
                        alt="Admin Profile" 
                        class="w-10 h-10 rounded-full object-cover">
                    <div>
                        <p class="text-gray-900 font-semibold">{{ auth()->user()->name }}</p>
                        <p class="text-gray-500 text-sm">Administrator</p>
                    </div>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="nav-text ml-3">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>
</div>
        

        <!-- Main Content -->
        <div class="main-content flex-1 ml-[270px] p-8">
            <div class="max-w-7xl mx-auto">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Total Accessories Card -->
                    <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100/50">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Total Accessories</p>
                                <p class="text-3xl font-semibold bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent">{{ $totalAccessories }}</p>
                            </div>
                            <div class="p-3 bg-blue-50/50 rounded-xl">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 014 12V7a4 4 0 013-4z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Available Accessories Card -->
                    <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100/50">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Available Accessories</p>
                                <p class="text-3xl font-semibold bg-gradient-to-r from-green-600 to-green-400 bg-clip-text text-transparent">{{ $availableAccessories }}</p>
                            </div>
                            <div class="p-3 bg-green-50/50 rounded-xl">
                                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Sold Out Accessories Card -->
                    <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100/50">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Sold Out Accessories</p>
                                <p class="text-3xl font-semibold bg-gradient-to-r from-red-600 to-red-400 bg-clip-text text-transparent">{{ $totalAccessories - $availableAccessories }}</p>
                            </div>
                            <div class="p-3 bg-red-50/50 rounded-xl">
                                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-gray-900">Manage Accessories</h2>
                        <a href="{{ route('admin.accessories.create') }}" 
                           class="inline-flex items-center px-4 py-3 rounded-md text-sm font-medium text-gray-900 bg-gray-100 hover:bg-gray-200">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add New Accessories
                        </a>
                    </div>

                    <!-- Filters -->
                    <div class="mb-6">
                        <form action="{{ route('admin.accessories.index') }}" method="GET" class="flex gap-4">
                            <select name="category" id="category" class="filter-btn rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-300 w-[8vw]">
                                <option value="">Category</option>
                                <option value="Collar" {{ request('category') == 'Collar' ? 'selected' : '' }}>Collar</option>
                                <option value="Leash" {{ request('category') == 'Leash' ? 'selected' : '' }}>Leash</option>
                                <option value="Toy" {{ request('category') == 'Toy' ? 'selected' : '' }}>Toy</option>
                            </select>

                            <select name="status" class="rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-900">
                                <option value="">Status</option>
                                <option value="In-Stock" {{ request('status') == 'In-Stock' ? 'selected' : '' }}>In-Stock</option>
                                <option value="Out of Stock" {{ request('status') == 'Out of Stock' ? 'selected' : '' }}>Out of Stock</option>
                            </select>

                            <button type="submit" class="px-4 py-2 rounded-md text-sm font-medium text-gray-900 bg-gray-100 hover:bg-gray-200">Filter</button>

                            @if(request()->anyFilled(['category', 'status']))
                                <a href="{{ route('admin.accessories.index') }}" class="px-4 py-2 rounded-md text-sm font-medium text-gray-900 bg-gray-100 hover:bg-gray-200">
                                    Clear Filters
                                </a>
                            @endif
                        </form>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md">
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Accessories Cards Grid -->
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($accessories as $accessory)
                        <div class="bg-white overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300">
                            <!-- Accessory Image -->
                            <div class="relative h-48">
                                <img src="{{ asset('storage/' . $accessory->image1) }}" alt="{{ $accessory->name }}" class="w-full h-full object-cover">
                                <div class="absolute top-2 right-2">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($accessory->stock > 0) bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        @if($accessory->stock > 0) In-Stock @else Out of Stock @endif
                                    </span>
                                </div>
                            </div>

                            <!-- Accessory Details -->
                            <div class="p-4 border-t">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">{{ $accessory->name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $accessory->category }}</p>
                                    </div>
                                    <span class="text-lg font-semibold text-blue-800">₱{{ number_format($accessory->price, 2) }}</span>
                                </div>

                                <div class="mt-4 grid grid-cols-2 gap-4 text-sm text-gray-600">
                                    <div>
                                        <span class="font-medium">Stock:</span> {{ $accessory->stock }}
                                    </div>
                                    <div>
                                        <span class="font-medium">Color:</span> {{ $accessory->color }}
                                    </div>
                                    <div>
                                        <span class="font-medium">Size:</span> {{ $accessory->size }}
                                    </div>
                                </div>

                                <div class="mt-4 flex justify-between items-center">
                                    <a href="{{ route('admin.accessories.edit', $accessory->id) }}" 
                                       class="text-sm text-blue-600 hover:text-blue-800">
                                        Edit Details
                                    </a>
                                    <form action="{{ route('admin.accessories.destroy', $accessory->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-sm text-red-600 hover:text-red-800"
                                                onclick="return confirm('Are you sure you want to delete this accessory?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
