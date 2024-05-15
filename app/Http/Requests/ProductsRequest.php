<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'Name' => ['required'],
            'Description' => ['required'],
            'Price' => ['required', 'integer'],
            'StockQuantity' => ['required', 'integer'],
            'CategoryID' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
