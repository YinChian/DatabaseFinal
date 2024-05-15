<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderDetailsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'ProductID' => ['required', 'integer'],
            'Quantity' => ['required', 'integer'],
            'Price' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
