<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomersRequest;
use App\Models\Customers;

class CustomersController extends Controller
{
    public function index ()
    {
        $customers = Customers::all();

        return  response()->json($customers);
    }

    public function store (CustomersRequest $request)
    {
        $customers = Customers::create($request->all());

        return response()->json($customers, 201);
    }

    public function show ($id)
    {
        $customers = Customers::findOrFail($id);

        return response()->json($customers);
    }

    public function update (CustomersRequest $request, $id)
    {
        $customers = Customers::findOrFail($id)->update($request->all());

        return response()->json($customers);
    }

    public function destroy ($id)
    {
        $customer = Customers::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found.'], 404);
        }
        $customer->delete();

        return response()->json(null, 204);
    }
}
