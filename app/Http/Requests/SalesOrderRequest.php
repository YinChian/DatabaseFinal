<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'customer_id' => ['required', 'exists:customers,id'],
            'order_details' => ['required', 'array'],
            'order_details.*.product_id' => ['required', 'exists:products,id'],
            'order_details.*.quantity' => ['required', 'integer', 'min:1'],
        ];

        // return [];

        // return [
        //     'CustomerID' => ['required', 'exists:customers,id'],
        //     'PaymentStatus' => ['required'],
        //     'DeliveryStatus' => ['required'],
        // ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
