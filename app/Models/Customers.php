<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customers extends Model
{
    protected $fillable = [
        'Name',
        'Email',
        'PhoneNumber',
        'Address',
        'CustomerType',
    ];

    public function customer_firstchild():HasMany
    {
        return $this->hasMany(CustomerInteractions::class, 'CustomerID');
    }

    public function customer_secondchild():HasMany
    {
        return $this->hasMany(ServiceRequests::class, 'CustomerID');
    }

    public function customer_thirdchild():HasOne
    {
        return $this->hasOne(SalesOrder::class, 'CustomerID');
    }

}
