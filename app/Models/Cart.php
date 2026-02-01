<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pet;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pet_id',
        'quantity',
        'status', // 'pending', 'checked_out'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}
