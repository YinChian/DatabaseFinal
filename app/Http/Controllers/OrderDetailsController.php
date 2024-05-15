<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderDetailsRequest;
use App\Models\OrderDetails;

class OrderDetailsController extends Controller
{
    public function index()
    {
        return OrderDetails::all();
    }

    public function store(OrderDetailsRequest $request)
    {
        return OrderDetails::create($request->validated());
    }

    public function show(OrderDetails $orderDetails)
    {
        return $orderDetails;
    }

    public function update(OrderDetailsRequest $request, OrderDetails $orderDetails)
    {
        $orderDetails->update($request->validated());

        return $orderDetails;
    }

    public function destroy(OrderDetails $orderDetails)
    {
        $orderDetails->delete();

        return response()->json();
    }
}
