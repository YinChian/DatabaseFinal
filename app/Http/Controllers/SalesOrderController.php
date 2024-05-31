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

    public function store(SalesOrderRequest $request)
    {
        Log::info('Store function in SalesOrderController hit.');

        $validatedData = $request->validated();

        // Initialize total amount
        $totalAmount = 0;

        // Check if request quantity is smaller than Product quantity
        foreach ($validatedData['order_details'] as $detail) {
            $product = Products::find($detail['product_id']);
            if ($product) {
                if ($product->StockQuantity < $detail['quantity']) {
                    return response()->json(['error' => 'Quantity of product ' . $product->id . ' is not enough.'], 400);
                }
                $totalAmount += $product->Price * $detail['quantity'];
            } else {
                return response()->json(['error' => 'Product not found: ' . $detail['product_id']], 404);
            }
        }

        // find if there is a SalesOrder not completed by the customer
        $salesOrder = SalesOrder::where('CustomerID', $validatedData['customer_id'])
            ->where('PaymentStatus', 'Pending')
            ->where('DeliveryStatus', 'Pending')
            ->first();

        DB::beginTransaction();
        try {
            if ($salesOrder) {
                $salesOrder->update([
                    'TotalAmount' => $totalAmount,
                ]);
                // delete Order Details where OrderID = $salesOrder->id
                OrderDetails::where('OrderID', $salesOrder->id)->delete();
            } else {
                // Create Sales Order
                $salesOrder = SalesOrder::create([
                    'CustomerID' => $validatedData['customer_id'],
                    'TotalAmount' => $totalAmount,
                    'PaymentStatus' => 'Pending',
                    'DeliveryStatus' => 'Pending',
                ]);
            }

            // LOG::info('Sales Order created: ' . $salesOrder);

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
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating sales order: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while creating the sales order.'], 500);
        }
    }

    public function show($id)
    {
        // find sales order by customer id
        $salesOrder = SalesOrder::where('CustomerID', $id)->first();

        if (!$salesOrder) {
            return response()->json(['error' => 'Customer has no sales order'], 404);
        }

        // find sales details by order id
        $orderDetails = OrderDetails::where('OrderID', $salesOrder->id)->get();

        // return sales order and order details
        return response()->json(['sales_order' => $salesOrder, 'order_details' => $orderDetails]);
    }

    public function update(Request $request, $id)
    {
        Log::info('Update function in SalesOrderController hit.');
        // $salesOrder = SalesOrder::find($id);
        // $validatedData = $request->validated();

        // find SalesOrder CustomerID couloum and compare with $request->customer_id
        // $salesOrder = SalesOrder::where('CustomerID', $request->order_id)->first();

        $salesOrder = SalesOrder::find($id);

        // Log::info('Sales Order found: ' . $salesOrder);

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


            // LOG::info('Sales Order updated: ' . $salesOrder);


            // Check if payment status is Completed
            // then update product quantity
            if ($request->payment_status == 'Completed') {
                $orderDetails = OrderDetails::where('OrderID', $salesOrder->id)->get();
                foreach ($orderDetails as $detail) {
                    $product = Products::find($detail->ProductID);
                    if ($product) {
                        $product->StockQuantity -= $detail->Quantity;
                        $product->save();
                    } else {
                        Log::error('Product not found while updating stock quantity: ' . $detail->ProductID);
                    }
                }
            }

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
