<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FoodController extends Controller
{
    public function index(Request $request)
    {
        Log::info('FoodController@index method called');

        $query = Food::query();

        // Apply filters
        if ($request->filled('pet_type')) {
            $query->where('pet_type', $request->pet_type);
        }
        if ($request->filled('status')) {
            if ($request->status === 'In-Stock') {
                $query->where('stock', '>', 0);
            } else if ($request->status === 'Out of Stock') {
                $query->where('stock', '=', 0);
            }
        }

        $foods = $query->latest()->get();

        // Stats
        $totalFood = Food::count();
        $availableFood = Food::where('status', 'Available')->count();

        Log::info('Food stats:', [
            'totalFood' => $totalFood,
            'availableFood' => $availableFood,
        ]);

        return view('admin.food.index', compact('foods', 'totalFood', 'availableFood'));
    }

    public function create()
    {
        return view('admin.food.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'pet_type' => 'required|in:dog,cat',
            'brand' => 'nullable|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'flavor' => 'nullable|string|max:255',
            'status' => 'required|in:Available,Unavailable',
            'food_image1' => 'nullable|image|max:2048',
            'food_image2' => 'nullable|image|max:2048',
            'food_image3' => 'nullable|image|max:2048',
            'food_image4' => 'nullable|image|max:2048',
            'food_image5' => 'nullable|image|max:2048',
        ]);

        // Handle image uploads
        for ($i = 1; $i <= 5; $i++) {
            if ($request->hasFile("food_image{$i}")) {
                $path = $request->file("food_image{$i}")->store('foods', 'public');
                $validated["food_image{$i}"] = $path;
            }
        }

        // Map food_image keys to image keys for the model
        for ($i = 1; $i <= 5; $i++) {
            if (isset($validated["food_image{$i}"])) {
                $validated["image{$i}"] = $validated["food_image{$i}"];
                unset($validated["food_image{$i}"]);
            }
        }

        Food::create($validated);

        return redirect()->route('admin.food.index')
            ->with('success', 'Food item added successfully.');
    }

    public function edit(Food $food)
    {
        return view('admin.food.edit', compact('food'));
    }

    public function update(Request $request, Food $food)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'pet_type' => 'required|in:dog,cat',
            'brand' => 'nullable|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'flavor' => 'nullable|string|max:255',
            'status' => 'required|in:Available,Unavailable',
            'food_image1' => 'nullable|image|max:2048',
            'food_image2' => 'nullable|image|max:2048',
            'food_image3' => 'nullable|image|max:2048',
            'food_image4' => 'nullable|image|max:2048',
            'food_image5' => 'nullable|image|max:2048',
        ]);

        // Handle image replacements
        for ($i = 1; $i <= 5; $i++) {
            if ($request->hasFile("food_image{$i}")) {
                if ($food->{"food_image{$i}"}) {
                    Storage::disk('public')->delete($food->{"food_image{$i}"});
                }
                $path = $request->file("food_image{$i}")->store('foods', 'public');
                $validated["food_image{$i}"] = $path;
            }
        }

        // Map food_image keys to image keys for the model
        for ($i = 1; $i <= 5; $i++) {
            if (isset($validated["food_image{$i}"])) {
                $validated["image{$i}"] = $validated["food_image{$i}"];
                unset($validated["food_image{$i}"]);
            }
        }

        $food->update($validated);

        return redirect()->route('admin.food.index')
            ->with('success', 'Food item updated successfully.');
    }

    public function destroy(Food $food)
    {
        for ($i = 1; $i <= 5; $i++) {
            if ($food->{"food_image{$i}"}) {
                Storage::disk('public')->delete($food->{"food_image{$i}"});
            }
        }

        $food->delete();

        return redirect()->route('admin.food.index')
            ->with('success', 'Food item deleted successfully.');
    }
}
