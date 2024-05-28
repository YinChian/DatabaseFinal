<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomersRequest;
use App\Models\Customers;

class CustomersController extends Controller
{
    public function index ()
    {
        $customers = Customers::all();

        return  view('customers.index', compact('customers'));
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
        Customers::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
