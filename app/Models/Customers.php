<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customers extends Model
{
    use HasFactory;

    protected $fillable = [
        'Name',
        'Email',
        'PhoneNumber',
        'Address',
        'CustomerType',
    ];

    public function customer_customerInteractions():HasMany
    {
        return $this->hasMany(CustomerInteractions::class, 'CustomerID');
    }

    public function customer_serviceRequests():HasMany
    {
        return $this->hasMany(ServiceRequests::class, 'CustomerID');
    }

    public function customer_salesOrder():HasOne
    {
        return $this->hasOne(SalesOrder::class, 'CustomerID');
    }

}
