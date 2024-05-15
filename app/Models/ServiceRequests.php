<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequests extends Model
{
    protected $fillable = [
        'CustomerID',
        'ProductID',
        'IssueDescription',
        'ResolutionDate',
        'Status',
    ];

    protected function casts()
    {
        return [
            'ResolutionDate' => 'date',
        ];
    }
}
