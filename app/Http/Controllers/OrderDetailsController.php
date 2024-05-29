<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderDetailsRequest;
use App\Models\OrderDetails;

class OrderDetailsController extends Controller
{
    public function index ()
    {
        $orderDetails = OrderDetails::all();

        return response()->json($orderDetails);
    }

    public function store (OrderDetailsRequest $request)
    {
        $orderDetail = OrderDetails::create($request->all());

        return response()->json($orderDetail, 201);
    }

    public function show ($id)
    {
        $orderDetail = OrderDetails::find($id);

        return response()->json($orderDetail);
    }

    public function update (OrderDetailsRequest $request, $id)
    {
        $orderDetail = OrderDetails::findOrFail($id);
        $orderDetail->update($request->all());

        return response()->json($orderDetail);
    }

    public function destroy ($id)
    {
        OrderDetails::find($id)->delete();
        return response()->json(null, 204);
    }
}
