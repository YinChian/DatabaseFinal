<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalesOrderRequest;
use App\Models\SalesOrder;

class SalesOrderController extends Controller
{
    public function index()
    {
        return SalesOrder::all();
    }

    public function store(SalesOrderRequest $request)
    {
        return SalesOrder::create($request->validated());
    }

    public function show(SalesOrder $salesOrder)
    {
        return $salesOrder;
    }

    public function update(SalesOrderRequest $request, SalesOrder $salesOrder)
    {
        $salesOrder->update($request->validated());

        return $salesOrder;
    }

    public function destroy(SalesOrder $salesOrder)
    {
        $salesOrder->delete();

        return response()->json();
    }
}
