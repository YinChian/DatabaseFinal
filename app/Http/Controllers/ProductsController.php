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

        if (!$products) {
            return response()->json(['error' => 'Product not created'], 404);
        }

        return response()->json(true, 201);
    }

    public function show ($id)
    {
        $product = Products::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json($product);
    }

    public function update (ProductsRequest $request, $id)
    {
        $product = Products::findOrFail($id);
        $product->update($request->all());

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json(true);
    }

    public function destroy ($id)
    {
        $product = Products::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(true, 204);
    }
}
