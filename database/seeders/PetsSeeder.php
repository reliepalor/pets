<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pet;
use Illuminate\Support\Facades\Storage;

class PetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create pets using existing images
        Pet::create([
            'name' => 'Buddy',
            'speccategoryies' => 'Dog',
            'breed' => 'Golden Retriever',
            'age' => 2,
            'gender' => 'Male',
            'quantity' => 1,
            'color' => 'Golden',
            'price' => 15000,
            'description' => 'Friendly and well-trained Golden Retriever puppy.',
            'status' => 'Available',
            'pet_image1' => 'pets/WIVAnPMzVNYcG4UQKuvo1dKU25x8FRtz9w9Zs0la.jpg',
            'pet_image2' => 'pets/yuYTsll2SuFGHbRV3O4WbnHqVciarEPglvvmk9pH.jpg',
            'pet_image3' => 'pets/IYmOvsqCahgay4PrdggMxcRcpxc087cxoYk8nN5C.jpg',
        ]);

        Pet::create([
            'name' => 'Luna',
            'category' => 'Cat',
            'breed' => 'Persian',
            'age' => 1.5,
            'gender' => 'Female',
            'quantity' => 1,
            'color' => 'White',
            'price' => 12000,
            'description' => 'Beautiful Persian cat with a gentle personality.',
            'status' => 'Available',
            'pet_image1' => 'pets/K53LxG5cYIFumorub2hUzf0lFKdPyN8O8nUYBNpq.jpg',
            'pet_image2' => 'pets/RTBY8glAqZB492TqvwqDsvZ4nhNvhgmwacZkUkHr.jpg',
        ]);

        Pet::create([
            'name' => 'Rocky',
            'category' => 'Dog',
            'breed' => 'German Shepherd',
            'age' => 3,
            'gender' => 'Male',
            'quantity' => 1,
            'color' => 'Black and Tan',
            'price' => 18000,
            'description' => 'Strong and loyal German Shepherd with excellent training.',
            'status' => 'Available',
            'pet_image1' => 'pets/sample7.jpg',
            'pet_image2' => 'pets/sample8.jpg',
            'pet_image3' => 'pets/sample9.jpg',
        ]);
    }
}
