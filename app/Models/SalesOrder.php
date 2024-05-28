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

    public function customers_salesOrder(): BelongsTo
    {
        return $this->belongsTo(Customers::class, 'CustomerID');
    }

    public function orderDetails_salesOrder(): HasMany
    {
        return $this->hasMany(OrderDetails::class, 'OrderID');
    }

}
