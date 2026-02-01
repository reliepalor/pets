<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Pets - Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .sidebar {
            transition: width 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .sidebar.minimized {
            width: 80px;
        }
        .sidebar.expanded {
            width: 250px;
        }
        .nav-text {
            transition: opacity 0.3s ease;
        }
        .sidebar.minimized .nav-text {
            opacity: 0;
        }
        .sidebar.expanded .nav-text {
            opacity: 1;
        }
        .main-content {
            transition: margin-left 0.3s ease;
        }
        .filter-btn {
            transition: all 0.2s ease;
        }
        .filter-btn:hover {
            background-color: #e5e7eb;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen font-[Instrument Sans]">
    <div class="flex">
        <!-- Sidebar -->
        <div class="sidebar expanded fixed left-4 top-4 h-[calc(100vh-2rem)] bg-white rounded-2xl p-4 z-50">
            <!-- Toggle Button -->
            <button id="sidebarToggle" class="w-full flex items-center justify-center mb-6 p-2 rounded-lg hover:bg-gray-100">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Navigation Items -->
            <nav class="space-y-2">

                <a href="{{ route('admin.pets.index') }}" class="flex items-center p-3 text-gray-700 rounded-lg bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    <span class="nav-text ml-3">Manage Pets</span>
                </a>
                <a href="{{ route('admin.pets.create') }}" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="nav-text ml-3">Add New Pet</span>
                </a>
                <hr class="my-4">
                <form method="POST" action="{{ route('logout') }}" class="mt-auto">
                    @csrf
                    <button type="submit" class="w-full flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="nav-text ml-3">Logout</span>
                    </button>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 main-content ml-[270px] p-8">
            <div class="max-w-7xl mx-auto">
                <!-- Stat Boxes -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Pets -->
                    <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Total of Added Pets</h3>
                                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $totalPets ?? 0 }}</p>
                            </div>
                            <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.5"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M5 13l4 4L19 7M12 22a10 10 0 100-20 10 10 0 000 20z" />
                            </svg>
                        </div>
                    </div>
                
                    <!-- Total Dogs -->
                    <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Total of Added Dogs</h3>
                                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $totalDogs ?? 0 }}</p>
                            </div>
                            <svg class="w-10 h-10 text-yellow-500" fill="none" stroke="currentColor" stroke-width="1.5"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.5 17l-1.5-1.5-2 2L7 14l5-5 6 6-3.5 2.5z" />
                            </svg>
                        </div>
                    </div>
                
                    <!-- Total Cats -->
                    <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Total of Added Cats</h3>
                                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $totalCats ?? 0 }}</p>
                            </div>
                            <svg class="w-10 h-10 text-pink-500" fill="none" stroke="currentColor" stroke-width="1.5"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 4l2 4h4l-3 3 1 4-4-2-4 2 1-4-3-3h4l2-4z" />
                            </svg>
                        </div>
                    </div>
                
                    <!-- Total Breeds -->
                    <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Total Breeds Added</h3>
                                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $totalBreeds ?? 0 }}</p>
                            </div>
                            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" stroke-width="1.5"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6V4m0 16v-2m8-6h-2m-12 0H4m13.66-6.34l-1.41 1.41M6.34 6.34L4.93 7.75m12.73 12.73l-1.41-1.41M6.34 17.66l-1.41-1.41" />
                            </svg>
                        </div>
                    </div>
                </div>
                

                <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-gray-900">Manage Pets</h2>
                        <a href="{{ route('admin.pets.create') }}" 
                           class="inline-flex items-center px-4 py-2 rounded-md text-sm font-medium text-gray-900 bg-gray-100 hover:bg-gray-200">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add New Pet
                        </a>
                    </div>

                    <!-- Filters -->
                    <div class="mb-6 flex gap-3">
                        <form action="{{ route('admin.pets.index') }}" method="GET" class="flex gap-3">
                            <select name="category" id="category" class="filter-btn rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-300">
                                <option value="">Category</option>
                                <option value="Dog" {{ request('category') == 'Dog' ? 'selected' : '' }}>Dog</option>
                                <option value="Cat" {{ request('category') == 'Cat' ? 'selected' : '' }}>Cat</option>
                            </select>

                            <select name="breed" id="breed" class="filter-btn rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-300">
                                <option value="">Breed</option>
                                @foreach($pets->pluck('breed')->unique() as $breed)
                                    <option value="{{ $breed }}" {{ request('breed') == $breed ? 'selected' : '' }}>{{ $breed }}</option>
                                @endforeach
                            </select>

                            <select name="status" class="filter-btn rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-300">
                                <option value="">Status</option>
                                <option value="Available" {{ request('status') == 'Available' ? 'selected' : '' }}>Available</option>
                                <option value="Adopted" {{ request('status') == 'Adopted' ? 'selected' : '' }}>Adopted</option>
                                <option value="Reserved" {{ request('status') == 'Reserved' ? 'selected' : '' }}>Reserved</option>
                            </select>

                            <button type="submit" class="filter-btn px-4 py-2 rounded-md text-sm font-medium text-gray-900 bg-gray-100 hover:bg-gray-200">
                                Filter
                            </button>

                            @if(request()->anyFilled(['category', 'breed', 'status']))
                                <a href="{{ route('admin.pets.index') }}" class="filter-btn px-4 py-2 rounded-md text-sm font-medium text-gray-900 bg-gray-100 hover:bg-gray-200">
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

                    <!-- Pet Cards Grid -->
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($pets as $pet)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                            <!-- Pet Image -->
                            <div class="relative h-48">
                                <img src="{{ asset('storage/' . $pet->pet_image1) }}" alt="{{ $pet->name }}" class="w-full h-full object-cover">
                                <div class="absolute top-2 right-2">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($pet->status === 'Available') bg-green-50 text-green-700
                                        @elseif($pet->status === 'Adopted') bg-gray-50 text-gray-700
                                        @elseif($pet->status === 'Reserved') bg-yellow-50 text-yellow-700 @endif">
                                        {{ $pet->status }}
                                    </span>
                                </div>
                            </div>

                            <!-- Pet Details -->
                            <div class="p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">{{ $pet->name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $pet->breed }} • {{ $pet->category }}</p>
                                    </div>
                                    <span class="text-lg font-semibold text-gray-900">₱{{ number_format($pet->price, 2) }}</span>
                                </div>

                                <div class="mt-4 grid grid-cols-2 gap-4 text-sm text-gray-600">
                                    <div>
                                        <span class="font-medium">Age:</span> {{ $pet->age }} years
                                    </div>
                                    <div>
                                        <span class="font-medium">Gender:</span> {{ $pet->gender }}
                                    </div>
                                    <div>
                                        <span class="font-medium">Color:</span> {{ $pet->color }}
                                    </div>
                                    <div>
                                        <span class="font-medium">Quantity:</span> {{ $pet->quantity }}
                                    </div>
                                </div>

                                <div class="mt-4 flex justify-between items-center">
                                    <a href="{{ route('admin.pets.edit', $pet->id) }}" 
                                       class="text-sm text-gray-900 hover:text-gray-700">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.pets.destroy', $pet->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-sm text-red-600 hover:text-red-800"
                                                onclick="return confirm('Are you sure you want to delete this pet?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Sold Out Items Box -->
                    <div id="soldOutBox" class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 cursor-pointer">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Sold Out Items</h3>
                            <span class="text-2xl font-bold text-red-600">{{ $soldOutCount }}</span>
                        </div>
                        <p class="text-sm text-gray-600">Items that are currently out of stock</p>
                    </div>

                    <!-- Sold Out Items Modal -->
                    <div id="soldOutModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
                        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-xl font-semibold text-gray-900">Sold Out Items</h3>
                                <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            
                            <!-- Tabs -->
                            <div class="border-b border-gray-200 mb-4">
                                <nav class="flex space-x-4" aria-label="Tabs">
                                    <button onclick="switchTab('pets')" class="px-3 py-2 text-sm font-medium text-blue-600 border-b-2 border-blue-600" id="pets-tab">
                                        Pets
                                    </button>
                                    <button onclick="switchTab('accessories')" class="px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700" id="accessories-tab">
                                        Accessories
                                    </button>
                                    <button onclick="switchTab('food')" class="px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700" id="food-tab">
                                        Food
                                    </button>
                                </nav>
                            </div>

                            <!-- Content -->
                            <div class="max-h-96 overflow-y-auto">
                                <!-- Pets Tab Content -->
                                <div id="pets-content" class="space-y-4">
                                    @foreach($soldOutPets as $pet)
                                        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                                            <img src="{{ asset('storage/' . $pet->pet_image1) }}" alt="{{ $pet->name }}" class="w-16 h-16 rounded-lg object-cover">
                                            <div class="flex-1">
                                                <h4 class="text-sm font-medium text-gray-900">{{ $pet->name }}</h4>
                                                <p class="text-xs text-gray-500">{{ $pet->breed }} • {{ $pet->category }}</p>
                                            </div>
                                            <span class="text-sm font-medium text-red-600">Sold Out</span>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Accessories Tab Content -->
                                <div id="accessories-content" class="space-y-4 hidden">
                                    @foreach($soldOutAccessories as $accessory)
                                        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                                            <img src="{{ asset('storage/' . $accessory->image1) }}" alt="{{ $accessory->name }}" class="w-16 h-16 rounded-lg object-cover">
                                            <div class="flex-1">
                                                <h4 class="text-sm font-medium text-gray-900">{{ $accessory->name }}</h4>
                                                <p class="text-xs text-gray-500">{{ $accessory->category }}</p>
                                            </div>
                                            <span class="text-sm font-medium text-red-600">Sold Out</span>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Food Tab Content -->
                                <div id="food-content" class="space-y-4 hidden">
                                    @foreach($soldOutFood as $food)
                                        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                                            <img src="{{ asset('storage/' . $food->image1) }}" alt="{{ $food->name }}" class="w-16 h-16 rounded-lg object-cover">
                                            <div class="flex-1">
                                                <h4 class="text-sm font-medium text-gray-900">{{ $food->name }}</h4>
                                                <p class="text-xs text-gray-500">{{ $food->category }}</p>
                                            </div>
                                            <span class="text-sm font-medium text-red-600">Sold Out</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar functionality
            const sidebar = document.querySelector('.sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const mainContent = document.querySelector('.main-content');

            const isMinimized = localStorage.getItem('sidebarMinimized') === 'true';
            if (isMinimized) {
                sidebar.classList.remove('expanded');
                sidebar.classList.add('minimized');
                mainContent.classList.remove('ml-[270px]');
                mainContent.classList.add('ml-[100px]');
            }

            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('minimized');
                sidebar.classList.toggle('expanded');
                
                if (sidebar.classList.contains('minimized')) {
                    mainContent.classList.remove('ml-[270px]');
                    mainContent.classList.add('ml-[100px]');
                    localStorage.setItem('sidebarMinimized', 'true');
                } else {
                    mainContent.classList.remove('ml-[100px]');
                    mainContent.classList.add('ml-[270px]');
                    localStorage.setItem('sidebarMinimized', 'false');
                }
            });

            // Modal functionality
            const soldOutBox = document.getElementById('soldOutBox');
            const modal = document.getElementById('soldOutModal');
            const closeModalBtn = document.getElementById('closeModalBtn');

            // Open modal
            soldOutBox.addEventListener('click', function() {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });

            // Close modal with button
            closeModalBtn.addEventListener('click', function() {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            });

            // Close modal when clicking outside
            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }
            });
        });

        function switchTab(tabName) {
            // Hide all content
            document.getElementById('pets-content').classList.add('hidden');
            document.getElementById('accessories-content').classList.add('hidden');
            document.getElementById('food-content').classList.add('hidden');

            // Remove active state from all tabs
            document.getElementById('pets-tab').classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');
            document.getElementById('pets-tab').classList.add('text-gray-500');
            document.getElementById('accessories-tab').classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');
            document.getElementById('accessories-tab').classList.add('text-gray-500');
            document.getElementById('food-tab').classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');
            document.getElementById('food-tab').classList.add('text-gray-500');

            // Show selected content and update tab style
            document.getElementById(tabName + '-content').classList.remove('hidden');
            document.getElementById(tabName + '-tab').classList.remove('text-gray-500');
            document.getElementById(tabName + '-tab').classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
        }
    </script>
</body>
</html>