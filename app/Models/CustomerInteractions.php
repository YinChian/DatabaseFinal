<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerInteractions extends Model
{
    protected $fillable = [
        'CustomerID',
        'Mode',
        'Description',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customers::class, 'CustomerID');
    }
}
