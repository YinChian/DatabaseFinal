<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetails extends Model
{
    protected $fillable = [
        'ProductID',
        'Quantity',
        'Price',
    ];

    public function products_firstparent(): BelongsTo
    {
        return $this->belongsTo(Products::class, 'ProductID');
    }

    public function products_secondparent(): BelongsTo
    {
        return $this->belongsTo(SalesOrder::class, 'ProductID');
    }

}
