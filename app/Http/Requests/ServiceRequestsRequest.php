<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequestsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'CustomerID' => ['required'],
            'ProductID' => ['required'],
            'IssueDescription' => ['required']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
