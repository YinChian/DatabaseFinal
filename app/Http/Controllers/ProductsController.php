<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsRequest;
use App\Models\Products;

class ProductsController extends Controller
{
    public function index()
    {
        return Products::all();
    }

    public function store(ProductsRequest $request)
    {
        return Products::create($request->validated());
    }

    public function show(Products $products)
    {
        return $products;
    }

    public function update(ProductsRequest $request, Products $products)
    {
        $products->update($request->validated());

        return $products;
    }

    public function destroy(Products $products)
    {
        $products->delete();

        return response()->json();
    }
}
