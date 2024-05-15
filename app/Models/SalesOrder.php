<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalesOrder extends Model
{
    protected $fillable = [
        'CustomerID',
        'TotalAmount',
        'PaymentStatus',
        'DeliveryStatus',
    ];

    public function salesorders_parent(): BelongsTo
    {
        return $this->belongsTo(Customers::class, 'CustomerID');
    }

    public function salesorders_children(): HasMany
    {
        return $this->hasMany(OrderDetails::class, 'OrderID');
    }

}
