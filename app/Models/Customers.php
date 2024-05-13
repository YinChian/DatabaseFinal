<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $fillable = [
        'Name',
        'Email',
        'PhoneNumber',
        'Address',
        'CustomerType',
    ];
}
