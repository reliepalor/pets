<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'breed',
        'age',
        'gender',
        'color',
        'price',
        'quantity',
        'status',
        'description',
        'pet_image1',
        'pet_image2',
        'pet_image3',
        'pet_image4',
        'pet_image5',
        'main_image',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'age' => 'decimal:1',
        'quantity' => 'integer',
        'date_added' => 'datetime',
    ];

    // Mutator for gender
    public function setGenderAttribute($value)
    {
        $this->attributes['gender'] = strtolower($value);
    }

    // Accessor for gender
    public function getGenderAttribute($value)
    {
        return ucfirst($value);
    }

    // Mutator for status
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = strtolower($value);
    }

    // Accessor for status
    public function getStatusAttribute($value)
    {
        return ucfirst($value);
    }
} 