<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerInteractionsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'CustomerID' => ['required'],
            'Date' => ['required', 'date'],
            'Mode' => ['required'],
            'Description' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
