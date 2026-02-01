<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\Accessories;
use App\Models\Food;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total counts
        $totalPets = Pet::count();
        $totalAccessories = Accessories::count();
        $totalFood = Food::count();
        $totalOrders = Order::count();
        $totalCustomers = User::where('role', 'user')->count();

        // Get available counts
        $availablePets = Pet::where('status', 'Available')->count();
        $availableAccessories = Accessories::where('stock', '>', 0)->count();
        $availableFood = Food::where('stock', '>', 0)->count();

        // Get sold out counts
        $soldOutPets = Pet::where('status', 'Sold Out')->get();
        $soldOutAccessories = Accessories::where('stock', 0)->get();
        $soldOutFood = Food::where('stock', 0)->get();
        $soldOutCount = $soldOutPets->count() + $soldOutAccessories->count() + $soldOutFood->count();

        // Get recent orders
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPets',
            'totalAccessories',
            'totalFood',
            'totalOrders',
            'totalCustomers',
            'availablePets',
            'availableAccessories',
            'availableFood',
            'soldOutCount',
            'soldOutPets',
            'soldOutAccessories',
            'soldOutFood',
            'recentOrders'
        ));
    }
} 