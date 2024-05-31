<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetails extends Model
{
    protected $fillable = [
        'OrderID',
        'ProductID',
        'Quantity',
        'Price',
    ];

    public function product_orderDetails(): BelongsTo
    {
        return $this->belongsTo(Products::class, 'ProductID');
    }

    public function salesOrder_orderDetails(): BelongsTo
    {
        return $this->belongsTo(SalesOrder::class, 'OrderID');
    }

}
