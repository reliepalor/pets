<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paw Haven - Add New Food</title>
    <link rel="icon" type="image/x-icon" href="/images/paw.png">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="{{ asset('css/Sidebar.css') }}">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
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
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Add New Food</h2>
                        <a href="{{ route('admin.food.index') }}" class="text-blue-600 hover:text-blue-800">
                            Back to Food List
                        </a>
                    </div>

                    <form action="{{ route('admin.food.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        @if ($errors->any())
                            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Basic Information -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900">Basic Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Food Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Pet Type</label>
                                    <select name="pet_type" id="pet_type" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="" {{ old('pet_type') ? '' : 'selected' }}>Select Pet Type</option>
                                        <option value="dog" {{ old('pet_type') == 'dog' ? 'selected' : '' }}>Dog</option>
                                        <option value="cat" {{ old('pet_type') == 'cat' ? 'selected' : '' }}>Cat</option>
                                    </select>
                                    @error('pet_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Brand</label>
                                    <input type="text" name="brand" id="brand" value="{{ old('brand') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('brand')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Price (₱)</label>
                                    <input type="number" name="price" id="price" value="{{ old('price') }}" min="0" step="0.01" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Stock</label>
                                    <input type="number" name="stock" id="stock" value="{{ old('stock') }}" min="0" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('stock')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Weight (kg)</label>
                                    <input type="number" name="weight" id="weight" value="{{ old('weight') }}" min="0" step="0.01"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('weight')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900">Description</h3>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="description" rows="4" required
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900">Status</h3>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="" {{ old('status') ? '' : 'selected' }}>Select Status</option>
                                    <option value="Available" {{ old('status') == 'Available' ? 'selected' : '' }}>Available</option>
                                    <option value="Unavailable" {{ old('status') == 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Food Images -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900">Food Images</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @for($i = 1; $i <= 5; $i++)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Image {{ $i }} {{ $i === 1 ? '(Required)' : '(Optional)' }}
                                        </label>
                                        <input type="file" name="food_image{{ $i }}" id="food_image{{ $i }}" accept="image/*"
                                               {{ $i === 1 ? 'required' : '' }}
                                               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                        @error('food_image' . $i)
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-md hover:bg-blue-700">
                                Add Food
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
<script src="{{ asset('javascript/Sidebar.js') }}"></script>

</html>
