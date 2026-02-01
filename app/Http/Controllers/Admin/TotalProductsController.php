<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\Accessories;
use App\Models\Food;
use App\Models\Order;
use Illuminate\Http\Request;

class TotalProductsController extends Controller
{
    public function index(Request $request)
    {
        // Total counts
        $totalPets = Pet::count();
        $totalAccessories = Accessories::count();
        $totalFoods = Food::count();

        // Total products (pets + accessories + foods)
        $totalProducts = $totalPets + $totalAccessories + $totalFoods;

        // Orders query without date filter
        $ordersQuery = Order::query();

        // Total orders
        $totalOrders = $ordersQuery->count();

        // Total revenue (sum of all orders' total_amount)
        $totalRevenue = $ordersQuery->sum('total_amount');

        // Orders by status with timestamps for charting
        $ordersByStatus = $ordersQuery->selectRaw('payment_status, DATE(created_at) as date, count(*) as count')
            ->groupBy('payment_status', 'date')
            ->orderBy('date')
            ->get();

        // Get the last 30 days of data for charts
        $startDate = now()->subDays(30);
        
        // Revenue by date for charting
        $revenueByDate = $ordersQuery->selectRaw('DATE(created_at) as date, SUM(total_amount) as total_revenue')
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Orders by date for charting
        $ordersByDate = $ordersQuery->selectRaw('DATE(created_at) as date, COUNT(*) as order_count')
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Format dates for chart labels
        $chartLabels = $revenueByDate->pluck('date')->map(function($date) {
            return \Carbon\Carbon::parse($date)->format('M d');
        })->toArray();

        $chartData = [
            'labels' => $chartLabels,
            'revenue' => $revenueByDate->pluck('total_revenue')->toArray(),
            'orders' => $ordersByDate->pluck('order_count')->toArray()
        ];

        // Sold out products (pets, accessories, foods with quantity 0)
        $soldOutPets = Pet::where('quantity', 0)->count();
        $soldOutAccessories = Accessories::where('stock', 0)->count();
        $soldOutFoods = Food::where('stock', 0)->count();
        $totalSoldOut = $soldOutPets + $soldOutAccessories + $soldOutFoods;

        return view('admin.totals.total_products', [
            'totalProducts' => $totalProducts,
            'totalPets' => $totalPets,
            'totalAccessories' => $totalAccessories,
            'totalFoods' => $totalFoods,
            'totalOrders' => $totalOrders,
            'totalSales' => $totalRevenue,
            'totalSoldOut' => $totalSoldOut,
            'soldOutPets' => $soldOutPets,
            'soldOutAccessories' => $soldOutAccessories,
            'soldOutFoods' => $soldOutFoods,
            'ordersByStatus' => $ordersByStatus,
            'revenueByDate' => $revenueByDate,
            'chartData' => $chartData
        ]);
    }
}
