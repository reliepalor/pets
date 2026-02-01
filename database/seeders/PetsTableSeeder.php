<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pet;
use Illuminate\Support\Facades\DB;

class PetsTableSeeder extends Seeder
{
    public function run()
    {
        // Update or create the first pet
        DB::table('pets')->updateOrInsert(
            ['name' => 'Ung Ang'],
            [
                'category' => 'Cat',
                'breed' => 'Tilapia Cat',
                'age' => 5,
                'gender' => 'Female',
                'quantity' => 1,
                'color' => 'Brown / Gray',
                'price' => 155.00,
                'description' => 'Angry Cat',
                'status' => 'Adopted',
                'pet_image1' => 'pets/K53LxG5cYIFumorub2hUzf0lFKdPyN8O8nUYBNpq.jpg',
                'pet_image2' => null,
                'pet_image3' => null,
                'pet_image4' => null,
                'pet_image5' => null,
                'date_added' => now(),
                'updated_at' => now(),
            ]
        );

        // Update or create the second pet
        DB::table('pets')->updateOrInsert(
            ['name' => 'Pokay'],
            [
                'category' => 'Dog',
                'breed' => 'Shit Zu',
                'age' => 2,
                'gender' => 'Female',
                'quantity' => 1,
                'color' => 'White',
                'price' => 143.00,
                'description' => 'We miss you pokay',
                'status' => 'Reserved',
                'pet_image1' => 'pets/IYmOvsqCahgay4PrdggMxcRcpxc087cxoYk8nN5C.jpg',
                'pet_image2' => 'pets/yuYTsll2SuFGHbRV3O4WbnHqVciarEPglvvmk9pH.jpg',
                'pet_image3' => 'pets/WIVAnPMzVNYcG4UQKuvo1dKU25x8FRtz9w9Zs0la.jpg',
                'pet_image4' => null,
                'pet_image5' => null,
                'date_added' => now(),
                'updated_at' => now(),
            ]
        );
    }
} 