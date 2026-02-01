<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PetController extends Controller
{
    public function index(Request $request)
    {
        Log::info('PetController@index method called'); // Debug to confirm method execution

        $query = Pet::query();

        // Apply filters
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('breed')) {
            $query->where('breed', $request->breed);
        }
        if ($request->filled('age')) {
            $query->where('age', $request->age);
        }
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }
        if ($request->filled('color')) {
            $query->where('color', $request->color);
        }
        if ($request->filled('status')) {
            if ($request->status === 'In-Stock') {
                $query->where('quantity', '>', 0);
            } else if ($request->status === 'Out of Stock') {
                $query->where('quantity', '=', 0);
            }
        }
        
        $pets = $query->latest()->get();

        // Calculate stats for the dashboard
        $totalPets = Pet::count();
        $availablePets = Pet::where('quantity', '>', 0)->count();
        $soldOutPets = Pet::where('quantity', '=', 0)->count();
        $totalBreeds = Pet::distinct('breed')->count('breed');

        // Debug: Log the values to ensure they're being calculated
        Log::info('Stats calculated:', [
            'totalPets' => $totalPets,
            'availablePets' => $availablePets,
            'soldOutPets' => $soldOutPets,
            'totalBreeds' => $totalBreeds,
        ]);

        // Debug: Log the variables being passed to the view
        Log::info('Variables passed to view:', compact('pets', 'totalPets', 'availablePets', 'soldOutPets', 'totalBreeds'));

        return view('admin.pets.index', compact('pets', 'totalPets', 'availablePets', 'soldOutPets', 'totalBreeds'));
    }

    public function create()
    {
        return view('admin.pets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:Dog,Cat',
            'breed' => 'required|string|max:255',
            'age' => 'required|numeric|min:0',
            'gender' => 'required|in:Male,Female',
            'quantity' => 'required|integer|min:1',
            'color' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'status' => 'required|in:Available,Adopted,Reserved',
            'pet_image1' => 'nullable|image|max:2048',
            'pet_image2' => 'nullable|image|max:2048',
            'pet_image3' => 'nullable|image|max:2048',
            'pet_image4' => 'nullable|image|max:2048',
            'pet_image5' => 'nullable|image|max:2048',
        ]);

        // Handle image uploads
        for ($i = 1; $i <= 5; $i++) {
            if ($request->hasFile("pet_image{$i}")) {
                $path = $request->file("pet_image{$i}")->store('pets', 'public');
                $validated["pet_image{$i}"] = $path;
            }
        }

        Pet::create($validated);

        return redirect()->route('admin.pets.index')
            ->with('success', 'Pet added successfully.');
    }

    public function edit(Pet $pet)
    {
        return view('admin.pets.edit', compact('pet'));
    }

    public function update(Request $request, Pet $pet)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:Dog,Cat',
            'breed' => 'required|string|max:255',
            'age' => 'required|numeric|min:0',
            'gender' => 'required|in:Male,Female',
            'quantity' => 'required|integer|min:1',
            'color' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'status' => 'required|in:Available,Adopted,Reserved',
            'pet_image1' => 'nullable|image|max:2048',
            'pet_image2' => 'nullable|image|max:2048',
            'pet_image3' => 'nullable|image|max:2048',
            'pet_image4' => 'nullable|image|max:2048',
            'pet_image5' => 'nullable|image|max:2048',
        ]);

        // Handle image uploads
        for ($i = 1; $i <= 5; $i++) {
            if ($request->hasFile("pet_image{$i}")) {
                // Delete old image if exists
                if ($pet->{"pet_image{$i}"}) {
                    Storage::disk('public')->delete($pet->{"pet_image{$i}"});
                }
                $path = $request->file("pet_image{$i}")->store('pets', 'public');
                $validated["pet_image{$i}"] = $path;
            }
        }

        $pet->update($validated);

        return redirect()->route('admin.pets.index')
            ->with('success', 'Pet updated successfully.');
    }

    public function destroy(Pet $pet)
    {
        // Delete all pet images
        for ($i = 1; $i <= 5; $i++) {
            if ($pet->{"pet_image{$i}"}) {
                Storage::disk('public')->delete($pet->{"pet_image{$i}"});
            }
        }

        $pet->delete();

        return redirect()->route('admin.pets.index')
            ->with('success', 'Pet deleted successfully.');
    }
}