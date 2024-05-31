<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomersRequest;
use App\Models\Customers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class CustomersController extends Controller
{

    public function index ()
    {
        LOG::info('CustomersController@index hit');

        $customers = Customers::all();

        // return response()->json($customers);
        return csrf_token(); // This will return the CSRF token for postmen testing
    }

    public function store (CustomersRequest $request)
    {
        $customers = Customers::create($request->all());

        if (!$customers) {
            return response()->json(['error' => 'Customer not created'], 404);
        }

        return response()->json(true, 201);
    }

    public function show($id)
    {
        $customer = Customers::find($id);
        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        return response()->json($customer);
    }

    public function update (CustomersRequest $request, $id)
    {
        $customers = Customers::find($id);

        if (!$customers) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        $customers->update($request->all());

        return response()->json(true);
    }

    public function destroy ($id)
    {
        $customer = Customers::find($id);

        if (!$customer) {
            return response()->json(['error' => 'Customer not found.'], 404);
        }
        $customer->delete();

        return response()->json(true, 204);
    }
}
