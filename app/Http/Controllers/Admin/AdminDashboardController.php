<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Pet::query();

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by breed
        if ($request->filled('breed')) {
            $query->where('breed', $request->breed);
        }

        // Filter by age
        if ($request->filled('age')) {
            $query->where('age', $request->age);
        }

        // Filter by gender
        if ($request->filled('gender')) {
            $query->where('gender', strtolower($request->gender));
        }

        // Filter by color
        if ($request->filled('color')) {
            $query->where('color', $request->color);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', strtolower($request->status));
        }

        $pets = $query->get();

        // Sold out pets (quantity = 0)
        $soldOutPets = Pet::where('quantity', 0)->get();

        // Sold out accessories (stock = 0)
        $soldOutAccessories = \App\Models\Accessories::where('stock', 0)->get();

        // Sold out food (stock = 0)
        $soldOutFood = \App\Models\Food::where('stock', 0)->get();

        // Total sold out count
        $soldOutCount = $soldOutPets->count() + $soldOutAccessories->count() + $soldOutFood->count();

        return view('admin.dashboard', compact('pets', 'soldOutPets', 'soldOutAccessories', 'soldOutFood', 'soldOutCount'));
    }
} 