<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerInteractionsRequest;
use App\Models\CustomerInteractions;

class CustomerInteractionsController extends Controller
{
    public function index()
    {
        return CustomerInteractions::all();
    }

    public function store(CustomerInteractionsRequest $request)
    {
        return CustomerInteractions::create($request->validated());
    }

    public function show(CustomerInteractions $customerInteractions)
    {
        return $customerInteractions;
    }

    public function update(CustomerInteractionsRequest $request, CustomerInteractions $customerInteractions)
    {
        $customerInteractions->update($request->validated());

        return $customerInteractions;
    }

    public function destroy(CustomerInteractions $customerInteractions)
    {
        $customerInteractions->delete();

        return response()->json();
    }
}
