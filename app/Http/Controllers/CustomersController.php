<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomersRequest;
use App\Models\Customers;

class CustomersController extends Controller
{
    public function index()
    {
        return Customers::all();
    }

    public function store(CustomersRequest $request)
    {
        return Customers::create($request->validated());
    }

    public function show(Customers $customers)
    {
        return $customers;
    }

    public function update(CustomersRequest $request, Customers $customers)
    {
        $customers->update($request->validated());

        return $customers;
    }

    public function destroy(Customers $customers)
    {
        $customers->delete();

        return response()->json();
    }
}
