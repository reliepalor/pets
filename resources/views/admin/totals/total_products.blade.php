<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paw Haven | Sales Analytics</title>
    <link rel="icon" type="image/x-icon" href="/images/paw.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/Sidebar.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom"></script>
    
    <style>
        body {
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
        .stat-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: transform 0.2s ease-in-out;
        }
        .stat-card:hover {
            transform: translateY(-2px);
        }
        .chart-container {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            margin-bottom: 1.5rem;
            height: 400px;
            position: relative;
        }
        .time-filter {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        .time-filter button {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            background: white;
            color: #4b5563;
            font-size: 0.875rem;
            transition: all 0.2s;
        }
        .time-filter button:hover {
            background: #f3f4f6;
        }
        .time-filter button.active {
            background: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }
        .side-nav {
            width: 270px;
            background: white;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding: 1rem;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.05);
        }
        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #4b5563;
            border-radius: 0.5rem;
            transition: all 0.2s;
            margin-bottom: 0.5rem;
        }
        .nav-item:hover {
            background: #f3f4f6;
            color: #1d1d1f;
        }
        .nav-item.active {
            background: #3b82f6;
            color: white;
        }
        .main-content {
            margin-left: 270px;
            padding: 2rem;
        }
    </style>
</head>
<body class="min-h-screen">
<!-- Sidebar -->
<div class="sidebar expanded fixed left-4 top-4 h-[calc(100vh-2rem)] bg-white rounded-2xl p-4 z-50">
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

    <!-- Navigation Items -->
    <nav class="space-y-2 flex flex-col h-full">
        <div>
            <a href="{{ route('admin.totals.products') }}" class="flex items-center p-3 text-gray-700 rounded-lg {{ request()->routeIs('admin.totals.products') ? 'active' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v18H3zM9 3v18M15 3v18M3 9h18M3 15h18" />
                </svg>
                <span class="nav-text ml-3">Totals</span>
            </a>
            <a href="{{ route('admin.pets.index') }}" class="flex items-center p-3 text-gray-700 rounded-lg {{ request()->routeIs('admin.pets.*') ? 'active' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4a4 4 0 00-4 4c0 1.5.8 2.8 2 3.5m4-3.5a4 4 0 00-4 4c0 1.5.8 2.8 2 3.5m-2 2v2m-6-2h12" />
                </svg>
                <span class="nav-text ml-3">Pets</span>
            </a>
            <a href="{{ route('admin.accessories.index') }}" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-200 transition {{ request()->routeIs('admin.accessories.index') ? 'active' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 4h4v4m-4 12h4v-4m-12 4v-4H4v4m4-16H4v4m8 4v4m-4-4h8" />
                </svg>
                <span class="nav-text ml-3">Accessories</span>
            </a>
            <a href="{{ route('admin.food.index') }}" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-200 transition {{ request()->routeIs('admin.food.index') ? 'active' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3h14v2H5zm0 4h14v12H5zm2 2h10v8H7z" />
                </svg>
                <span class="nav-text ml-3">Food</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-200 transition {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 12h14M5 16h14" />
                </svg>
                <span class="nav-text ml-3">Orders</span>
            </a>
            <a href="{{ route('admin.customers.index') }}" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-200 transition {{ request()->routeIs('admin.customers.index') ? 'active' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12a4 4 0 100-8 4 4 0 000 8zm-6 6h12a2 2 0 01-2 2H8a2 2 0 01-2-2z" />
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
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 6l4 6-4 6M3 12h14" />
                        </svg>
                        <span class="nav-text ml-3">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>
</div>
                    
    <!-- Main Content -->
    <div class="main-content">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-semibold text-gray-900">Sales Analytics</h1>
                <div class="time-filter">
                    <button class="active" data-period="week">Week</button>
                    <button data-period="month">Month</button>
                    <button data-period="year">Year</button>
                </div>
            </div>

            <!-- Product Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6 mb-8">
                <!-- Total Products -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Products</p>
                            <p class="mt-2 text-2xl font-semibold text-gray-900">{{ $totalProducts }}</p>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-lg">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Pets -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Pets</p>
                            <p class="mt-2 text-2xl font-semibold text-gray-900">{{ $totalPets }}</p>
                        </div>
                        <div class="p-3 bg-purple-50 rounded-lg">
                            <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Accessories -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Accessories</p>
                            <p class="mt-2 text-2xl font-semibold text-gray-900">{{ $totalAccessories }}</p>
                        </div>
                        <div class="p-3 bg-green-50 rounded-lg">
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Foods -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Foods</p>
                            <p class="mt-2 text-2xl font-semibold text-gray-900">{{ $totalFoods }}</p>
                        </div>
                        <div class="p-3 bg-orange-50 rounded-lg">
                            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Sold Out Items -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Sold Out Items</p>
                            <p class="mt-2 text-2xl font-semibold text-gray-900">{{ $totalSoldOut }}</p>
                        </div>
                        <div class="p-3 bg-red-50 rounded-lg">
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="stat-card fade-in">
                    <h3 class="text-sm font-medium text-gray-500">Total Sales</h3>
                    <p class="text-2xl font-semibold text-gray-900 mt-2">₱{{ number_format($totalSales, 2) }}</p>
                    <div class="mt-2 flex items-center text-sm">
                        <span class="text-green-500">↑ 12%</span>
                        <span class="text-gray-500 ml-2">from last period</span>
                    </div>
                </div>
                <div class="stat-card fade-in">
                    <h3 class="text-sm font-medium text-gray-500">Total Orders</h3>
                    <p class="text-2xl font-semibold text-gray-900 mt-2">{{ $totalOrders }}</p>
                    <div class="mt-2 flex items-center text-sm">
                        <span class="text-green-500">↑ 8%</span>
                        <span class="text-gray-500 ml-2">from last period</span>
                    </div>
                </div>
                <div class="stat-card fade-in">
                    <h3 class="text-sm font-medium text-gray-500">Average Order Value</h3>
                    <p class="text-2xl font-semibold text-gray-900 mt-2">₱{{ number_format($totalSales / max($totalOrders, 1), 2) }}</p>
                    <div class="mt-2 flex items-center text-sm">
                        <span class="text-green-500">↑ 5%</span>
                        <span class="text-gray-500 ml-2">from last period</span>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Sales Chart -->
                <div class="chart-container fade-in">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Sales Trend</h3>
                    <canvas id="salesChart"></canvas>
                </div>

                <!-- Orders Chart -->
                <div class="chart-container fade-in">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Orders Trend</h3>
                    <canvas id="ordersChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
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

            // Initialize charts
            initializeCharts();
        });

        // Time filter buttons
        document.querySelectorAll('.time-filter button').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelectorAll('.time-filter button').forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                updateCharts(button.dataset.period);
            });
        });

        function initializeCharts() {
            // Register the zoom plugin
            Chart.register(ChartZoom);

            // Sales Chart
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: @json($chartData['labels']),
                    datasets: [{
                        label: 'Sales',
                        data: @json($chartData['revenue']),
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true,
                        pointRadius: 0,
                        pointHoverRadius: 4,
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        zoom: {
                            pan: {
                                enabled: true,
                                mode: 'x',
                                threshold: 0,
                                onPan: function({chart}) {
                                    updateChartInfo(chart, 'sales');
                                }
                            },
                            zoom: {
                                wheel: {
                                    enabled: true,
                                },
                                pinch: {
                                    enabled: true
                                },
                                mode: 'x',
                                onZoom: function({chart}) {
                                    updateChartInfo(chart, 'sales');
                                }
                            },
                            limits: {
                                x: {min: 'original', max: 'original', minRange: 5}
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                label: function(context) {
                                    return `₱${context.parsed.y.toLocaleString()}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '₱' + value.toLocaleString();
                                }
                            },
                            grid: {
                                drawBorder: false,
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                maxRotation: 0,
                                autoSkip: true,
                                maxTicksLimit: 8
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    layout: {
                        padding: {
                            top: 10,
                            right: 10,
                            bottom: 10,
                            left: 10
                        }
                    }
                }
            });

            // Orders Chart
            const ordersCtx = document.getElementById('ordersChart').getContext('2d');
            const ordersChart = new Chart(ordersCtx, {
                type: 'bar',
                data: {
                    labels: @json($chartData['labels']),
                    datasets: [{
                        label: 'Orders',
                        data: @json($chartData['orders']),
                        backgroundColor: '#3b82f6',
                        borderRadius: 4,
                        barThickness: 8,
                        maxBarThickness: 12
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        zoom: {
                            pan: {
                                enabled: true,
                                mode: 'x',
                                threshold: 0,
                                onPan: function({chart}) {
                                    updateChartInfo(chart, 'orders');
                                }
                            },
                            zoom: {
                                wheel: {
                                    enabled: true,
                                },
                                pinch: {
                                    enabled: true
                                },
                                mode: 'x',
                                onZoom: function({chart}) {
                                    updateChartInfo(chart, 'orders');
                                }
                            },
                            limits: {
                                x: {min: 'original', max: 'original', minRange: 5}
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            },
                            grid: {
                                drawBorder: false,
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                maxRotation: 0,
                                autoSkip: true,
                                maxTicksLimit: 8
                            }
                        }
                    },
                    layout: {
                        padding: {
                            top: 10,
                            right: 10,
                            bottom: 10,
                            left: 10
                        }
                    }
                }
            });

            // Add chart info display
            function updateChartInfo(chart, type) {
                const meta = chart.getDatasetMeta(0);
                const data = chart.data;
                const visibleData = data.datasets[0].data.slice(meta.start, meta.end + 1);
                
                let min = Math.min(...visibleData);
                let max = Math.max(...visibleData);
                let avg = visibleData.reduce((a, b) => a + b, 0) / visibleData.length;
                
                if (type === 'sales') {
                    min = '₱' + min.toLocaleString();
                    max = '₱' + max.toLocaleString();
                    avg = '₱' + avg.toLocaleString();
                }
                
                const infoElement = document.getElementById(`${type}ChartInfo`);
                if (infoElement) {
                    infoElement.innerHTML = `
                        <div class="text-sm text-gray-600">
                            <span class="mr-4">Min: ${min}</span>
                            <span class="mr-4">Max: ${max}</span>
                            <span>Avg: ${avg}</span>
                        </div>
                    `;
                }
            }

            // Initialize chart info
            updateChartInfo(salesChart, 'sales');
            updateChartInfo(ordersChart, 'orders');
        }

        function updateCharts(period) {
            // This function would typically fetch new data from the server
            // For now, we'll just update with random data
            const salesData = Array.from({length: 7}, () => Math.floor(Math.random() * 30000) + 10000);
            const ordersData = Array.from({length: 7}, () => Math.floor(Math.random() * 15) + 5);

            window.salesChart.data.datasets[0].data = salesData;
            window.salesChart.update();

            window.ordersChart.data.datasets[0].data = ordersData;
            window.ordersChart.update();
        }
    </script>

    <!-- Add reset zoom buttons after the charts -->
    <div class="flex justify-end space-x-4 mt-4">
        <button onclick="resetZoom('salesChart')" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Reset Sales Chart
        </button>
        <button onclick="resetZoom('ordersChart')" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Reset Orders Chart
        </button>
    </div>

    <script>
        function resetZoom(chartId) {
            const chart = Chart.getChart(chartId);
            if (chart) {
                chart.resetZoom();
            }
        }
    </script>
</body>
<script src="{{ asset('javascript/Sidebar.js') }}"></script>

</html>
