<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsRequest;
use App\Models\Products;

class ProductsController extends Controller
{
    public function index ()
    {
        $products =  Products::all();

        return response()->json($products);
    }

    public function store (ProductsRequest $request)
    {
        $products = Products::create($request->all());

        return response()->json($products, 201);
    }

    public function show ($id)
    {
        $product = Products::find($id);

        return response()->json($product);
    }

    public function update (ProductsRequest $request, $id)
    {
        $product = Products::findOrFail($id);
        $product->update($request->all());

        return response()->json($product);
    }

    public function destroy ($id)
    {
        Products::find($id)->delete();

        return response()->json(null, 204);
    }
}
