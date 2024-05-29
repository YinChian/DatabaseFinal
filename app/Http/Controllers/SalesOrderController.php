<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalesOrderRequest;
use App\Models\SalesOrder;

class SalesOrderController extends Controller
{
    public function index ()
    {
        $orders = SalesOrder::all();

        return response()->json($orders);
    }

    public function store (SalesOrderRequest $request)
    {
        $order = SalesOrder::create($request->all());

        return response()->json($order, 201);
    }

    public function show ($id)
    {
        $order = SalesOrder::find($id);

        return response()->json($order);
    }

    public function update (SalesOrderRequest $request, $id)
    {
        $order = SalesOrder::findorFail($id);
        $order->update($request->all());

        return response()->json($order);
    }

    public function destroy ($id)
    {
        SalesOrder::find($id)->delete();

        return response()->json(null, 204);
    }
}
