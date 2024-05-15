<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequestsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'CustomerID' => ['required', 'integer'],
            'ProductID' => ['required', 'integer'],
            'IssueDescription' => ['required'],
            'ResolutionDate' => ['required', 'date'],
            'Status' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
