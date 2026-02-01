<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingLocation extends Model
{
    use HasFactory;
    protected $fillable = [
        'province',
        'city',
        'barangay',
        'zip_code',
        'delivery_fee',
        'estimated_days',
    ];
    
}
