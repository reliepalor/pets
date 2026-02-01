<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'item_type',
        'item_id',
        'quantity',
        'price',
    ];

    /**
     * Get the owning item model.
     */
    public function item(): MorphTo
    {
        return $this->morphTo();
    }
}
