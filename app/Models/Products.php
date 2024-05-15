<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Products extends Model
{
    protected $fillable = [
        'Name',
        'Description',
        'Price',
        'StockQuantity',
        'CategoryID',
    ];

    public function products_firstchild(): HasMany
    {
        return $this->hasMany(ServiceRequests::class, 'ProductID');
    }

    public function products_secondchild(): HasMany
    {
        return $this->hasMany(OrderDetails::class, 'ProductID');
    }

}
