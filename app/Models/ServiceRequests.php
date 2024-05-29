<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceRequests extends Model
{
    protected $fillable = [
        'CustomerID',
        'ProductID',
        'IssueDescription',
        'ResolutionDate',
        'Status',
    ];

    public function customers_service_requests(): BelongsTo
    {
        return $this->belongsTo(Customers::class, 'CustomerID');
    }

    public function products_service_requests(): BelongsTo
    {
        return $this->belongsTo(Products::class, 'ProductID');
    }

    protected function casts()
    {
        return [
            'ResolutionDate' => 'date',
        ];
    }
}
