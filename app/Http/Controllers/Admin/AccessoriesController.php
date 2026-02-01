<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accessories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class AccessoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $accessories = Accessories::all();

        // Stats
        $totalAccessories = Accessories::count();
        $availableAccessories = Accessories::where('stock', '>', 0)->count();

        if ($request->filled('status')) {
            if ($request->status === 'In-Stock') {
                $accessories = Accessories::where('stock', '>', 0)->get();
            } else if ($request->status === 'Out of Stock') {
                $accessories = Accessories::where('stock', '=', 0)->get();
            }
        }

        return view('admin.accessories.index', [
            'accessories' => $accessories,
            'totalAccessories' => $totalAccessories,
            'availableAccessories' => $availableAccessories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('admin.accessories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming data
    $request->validate([
        'name' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'color' => 'nullable|string|max:255',
        'size' => 'nullable|string|max:255',
        'image1' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        'image2' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        'image3' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        'image4' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        'image5' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    // Create a new accessory instance
    $accessories = new Accessories();
    $accessories->name = $request->name;
    $accessories->category = $request->category;
    $accessories->price = $request->price;
    $accessories->stock = $request->stock;
    $accessories->color = $request->color;
    $accessories->size = $request->size;

    // Handle image uploads
    if ($request->hasFile('image1')) {
        $accessories->image1 = $request->file('image1')->store('accessories', 'public');
    }
    if ($request->hasFile('image2')) {
        $accessories->image2 = $request->file('image2')->store('accessories', 'public');
    }
    if ($request->hasFile('image3')) {
        $accessories->image3 = $request->file('image3')->store('accessories', 'public');
    }
    if ($request->hasFile('image4')) {
        $accessories->image4 = $request->file('image4')->store('accessories', 'public');
    }
    if ($request->hasFile('image5')) {
        $accessories->image5 = $request->file('image5')->store('accessories', 'public');
    }

    // Save the accessory
    $accessories->save();

    // Redirect to the index page with a success message
    return redirect()->route('admin.accessories.index')->with('success', 'Accessories created successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $accessory = Accessories::findOrFail($id);
        return view('admin.accessories.show', compact('accessory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $accessories = Accessories::findOrFail($id);

        return view('admin.accessories.edit', compact('accessories'));
    }

    /**
     * Update the specified resource in storage.
     */public function update(Request $request, $id)
{
    // Validate the incoming data
    $request->validate([
        'name' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'color' => 'nullable|string|max:255',
        'size' => 'nullable|string|max:255',
        'main_image' => 'required|in:1,2,3,4,5', // Add logic for main image selection
        'image1' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        'image2' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        'image3' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        'image4' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        'image5' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    // Find the accessory by ID
    $accessories = Accessories::findOrFail($id);

    // Update the accessory attributes
    $updateData = [
        'name' => $request->name,
        'category' => $request->category,
        'price' => $request->price,
        'stock' => $request->stock,
        'color' => $request->color,
        'size' => $request->size,
        'main_image' => $request->main_image, // Update the main_image field
    ];

    // Handle image uploads for pet_image1 to pet_image5
    for ($i = 1; $i <= 5; $i++) {
        if ($request->hasFile('image' . $i)) {
            // Delete old image if exists
            if ($accessories->{'image' . $i} && file_exists(storage_path('app/public/' . $accessories->{'image' . $i}))) {
                unlink(storage_path('app/public/' . $accessories->{'image' . $i}));
            }

            // Store the new image and update the respective field
            $updateData['image' . $i] = $request->file('image' . $i)->store('accessories', 'public');
        }
    }

    // Update the accessory with the new data
    $accessories->update($updateData);

    // Redirect back with a success message
    return redirect()->route('admin.accessories.index')->with('success', 'Accessory updated successfully!');
}

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        for($i = 1; $i <=5; $i++){
            $accessories = Accessories::findOrFail($id);
            if ($accessories->{'image' . $i} && file_exists(storage_path('app/public/' . $accessories->{'image' . $i}))) {
                unlink(storage_path('app/public/' . $accessories->{'image' . $i}));
            }
        }
        $accessories = Accessories::findOrFail($id);
        $accessories->delete();
        return redirect()->route('admin.accessories.index')->with('success', 'Accessory deleted successfully!');
    }
}
