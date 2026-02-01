<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accessories extends Model
{
         use HasFactory;

       protected $table = 'accessories';

       protected $fillable = [
           'name',
           'category',
           'price',
           'stock',
           'color',
           'size',
           'image1',
           'image2',
           'image3',
           'image4',
           'image5',
       ];
   
       // The attributes that should be hidden for arrays
       protected $hidden = [];
   
       // The attributes that should be cast
       protected $casts = [
           'price' => 'decimal:2',
           'stock' => 'integer',
       ];
}
