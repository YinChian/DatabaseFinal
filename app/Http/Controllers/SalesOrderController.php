<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalesOrderRequest;
use App\Models\Customers;
use App\Models\SalesOrder;
use App\Models\OrderDetail;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SalesOrderController extends Controller
{
    public function index()
    {
        $salesOrders = SalesOrder::all();
        return response()->json($salesOrders);
    }

    // public function store (SalesOrderRequest $request)
    // {
    //     $salesOrder = SalesOrder::create($request->all());

    //     if (!$salesOrder) {
    //         return response()->json(['error' => 'Sales Order not created'], 404);
    //     }

    //     return response()->json(true, 201);
    // }


    public function store(SalesOrderRequest $request)
    {
        Log::info('Store function in SalesOrderController hit.');

        $validatedData = $request->validated();

        // Check if request quantity is smaller than Product quantity
        foreach ($validatedData['order_details'] as $detail) {
            $product = Products::find($detail['product_id']);
            if ($product) {
                if ($product->StockQuantity < $detail['quantity']) {
                    return response()->json(['error' => 'Quantity of product ' . $product->id . ' is not enough.'], 400);
                }
            } else {
                return response()->json(['error' => 'Product not found: ' . $detail['product_id']], 404);
            }
        }



        // Initialize total amount
        $totalAmount = 0;


        // Calculate total amount
        foreach ($validatedData['order_details'] as $detail) {
            $product = Products::find($detail['product_id']);
            if ($product) {
                $totalAmount += $product->Price * $detail['quantity'];
            }
            else {
                Log::error('Product not found: ' . $detail['product_id']);
            }
        }
        DB::beginTransaction();
        try {
            // Create Sales Order
            $salesOrder = SalesOrder::create([
                'CustomerID' => $validatedData['customer_id'],
                'TotalAmount' => $totalAmount,
                'PaymentStatus' => 'Pending',
                'DeliveryStatus' => 'Pending',
            ]);

            LOG::info('Sales Order created: ' . $salesOrder);

            if ($salesOrder) {
                // Create Order Details
                foreach ($validatedData['order_details'] as $detail) {
                    $product = Products::find($detail['product_id']);
                    LOG::info('Product found: ' . $product);
                    if ($product) {
                        OrderDetails::create([
                            'OrderID' => $salesOrder->id,
                            'ProductID' => $detail['product_id'],
                            'Quantity' => $detail['quantity'],
                            'Price' => $product->Price * $detail['quantity'],
                        ]);
                    } else {
                        Log::error('Product not found while creating order detail: ' . $detail['product_id']);
                    }
                }

                DB::commit();

                return response()->json(['success' => true, 'OrderID' => $salesOrder->id], 201);
            } else {
                DB::rollBack();
                return response()->json(['error' => 'Failed to create sales order.'], 500);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating sales order: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while creating the sales order.'], 500);
        }
    }

    public function show($id)
    {
        $salesOrder = SalesOrder::find($id);

        if (!$salesOrder) {
            return response()->json(['error' => 'Sales Order not found'], 404);
        }

        return response()->json($salesOrder);
    }

    public function update(Request $request, $id)
    {
        Log::info('Update function in SalesOrderController hit.');
        // $salesOrder = SalesOrder::find($id);
        // $validatedData = $request->validated();

        // find SalesOrder CustomerID couloum and compare with $request->customer_id
        // $salesOrder = SalesOrder::where('CustomerID', $request->order_id)->first();

        $salesOrder = SalesOrder::find($id);

        Log::info('Sales Order found: ' . $salesOrder);

        if (!$salesOrder) {
            return response()->json(['error' => 'Sales Order not found'], 404);
        }


        // // Check if request quantity is smaller than Product quantity
        // foreach ($validatedData['order_details'] as $detail) {
        //     $product = Products::find($detail['product_id']);
        //     if ($product) {
        //         if ($product->StockQuantity < $detail['quantity']) {
        //             return response()->json(['error' => 'Quantity of product ' . $product->id . ' is not enough.'], 400);
        //         }
        //     } else {
        //         return response()->json(['error' => 'Product not found: ' . $detail['product_id']], 404);
        //     }
        // }

        // LOG::info('Sales Order found: ' . $salesOrder);

        DB::beginTransaction();
        try {
            $salesOrder->update([
                'PaymentStatus' => $request->payment_status,
                'DeliveryStatus' => $request->delivery_status,
            ]);

            LOG::info('Sales Order updated: ' . $salesOrder);


            // design for update order details
            // if (isset($validatedData['order_details'])) {
            //     OrderDetails::where('OrderID', $id)->delete();

            //     foreach ($validatedData['order_details'] as $detail) {
            //         $product = Products::find($detail['product_id']);
            //         if ($product) {
            //             OrderDetails::create([
            //                 'OrderID' => $salesOrder->id,
            //                 'ProductID' => $detail['product_id'],
            //                 'Quantity' => $detail['quantity'],
            //                 'Price' => $product->price * $detail['quantity'],
            //             ]);
            //         } else {
            //             Log::error('Product not found while updating order detail: ' . $detail['product_id']);
            //         }
            //     }
            // }

            DB::commit();

            return response()->json(['success' => true, 'order_id' => $salesOrder->id], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating sales order: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while updating the sales order.'], 500);
        }
    }

    public function destroy($id)
    {
        $salesOrder = SalesOrder::find($id);

        if (!$salesOrder) {
            return response()->json(['error' => 'Sales Order not found'], 404);
        }

        DB::beginTransaction();
        try {
            $salesOrder->delete();
            DB::commit();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting sales order: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while deleting the sales order.'], 500);
        }
    }
}
