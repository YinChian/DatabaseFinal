<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomersRequest extends FormRequest
{
    public function rules()
    {
        return [
            'Name' => ['required'],
            'Email' => ['required'],
            'PhoneNumber' => ['required'],
            'Address' => ['required'],
            'CustomerType' => ['required'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
