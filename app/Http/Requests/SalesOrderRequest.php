<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'CustomerID' => ['required', 'integer'],
            'TotalAmount' => ['required', 'integer'],
            'PaymentStatus' => ['required'],
            'DeliveryStatus' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
