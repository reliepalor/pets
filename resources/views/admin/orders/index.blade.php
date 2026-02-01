<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Pets - Admin Dashboard</title>
    <link rel="icon" type="image/x-icon" href="/images/paw.png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/Sidebar.css') }}">
        <script src="{{ asset('javascript/Sidebar.js') }}"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen font-sans text-gray-800">
    <div class="flex min-h-screen">
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

<div class="ml-64 w-full px-8 py-10">
    <!-- Title -->
    <h1 class="text-3xl font-semibold text-gray-900 mb-6">Pending COD Orders</h1>

    <!-- Alerts -->
    @if(session('success'))
        <div class="flex items-center bg-green-50 text-green-700 p-4 rounded-md mb-6 shadow-sm border-l-4 border-green-500" role="alert">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="flex items-center bg-red-50 text-red-700 p-4 rounded-md mb-6 shadow-sm border-l-4 border-red-500" role="alert">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Table or Empty State -->
    @if($orders->isEmpty())
        <div class="bg-white p-8 rounded-lg shadow-md text-center">
            <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h1l1 2h13l1-2h1M5 6h14l1 4H4l1-4zM6 18h12v2H6v-2z" />
            </svg>
            <p class="text-gray-600 text-lg">No pending COD orders found.</p>
            <p class="text-gray-500 mt-2">Check back later or manage other resources.</p>
        </div>
    @else
        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="min-w-full">
                <thead class="bg-gray-100 text-gray-800 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium">Order ID</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Customer</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Total Amount</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-4 py-3 text-gray-800 text-sm">{{ $order->id }}</td>
                            <td class="px-4 py-3 text-gray-800">
                                <div class="flex items-center space-x-3">
                                    @if($order->user->profile_image && $order->user->profile_image !== 'images/default-profile.png')
                                        <img src="{{ asset('storage/' . $order->user->profile_image) }}" 
                                             alt="{{ $order->user->name }}" 
                                             class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <img src="{{ asset('images/default-profile.png') }}" 
                                             alt="{{ $order->user->name }}" 
                                             class="w-10 h-10 rounded-full object-cover">
                                    @endif
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $order->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $order->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-gray-800 text-sm">{{ number_format($order->total_amount, 2) }} PHP</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-gray-600 capitalize">
                                    {{ $order->payment_status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 flex space-x-3">
                                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <input type="hidden" name="payment_status" value="approved">
                                    <button type="submit"
                                            class="flex items-center bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500"
                                            aria-label="Approve order {{ $order->id }}"
                                            title="Approve Order">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Approve
                                    </button>
                                </form>
                                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <input type="hidden" name="payment_status" value="rejected">
                                    <button type="submit"
                                            class="flex items-center bg-red-400 text-white px-4 py-2 rounded-md hover:bg-red-500 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-300"
                                            aria-label="Reject order {{ $order->id }}"
                                            title="Reject Order">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Reject
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
    </div>
        <script src="{{ asset('javascript/Sidebar.js') }}"></script>

</body>
</html>
