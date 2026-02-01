<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    // Table name (optional if it matches the default 'foods')
    protected $table = 'food';

    // Fields that are mass assignable
    protected $fillable = [
        'name',
        'category',
        'description',
        'price',
        'stock',
        'weight',
        'flavor',
        'pet_type',
        'brand',
        'image1',
        'image2',
        'image3',
        'image4',
        'image5',
        'status',
    ];

    // Casts for specific field types
    protected $casts = [
        'price' => 'decimal:2',
        'weight' => 'decimal:2',
        'stock' => 'integer',
    ];
}
