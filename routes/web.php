<?php

namespace App\Http\Controllers;
//use App\Http\Middleware\CorsMiddleware;
use Illuminate\Support\Facades\Route;
//use App\Http\Middleware\ApiKeyMiddleware;
//// use App\Http\Kernel;

// Route::get('/', function () {
//    return view('welcome');
// });

Route::get('csrf-token', function () {
    return response()->json(['csrfToken' => csrf_token()]);
});

//Route::middleware(CorsMiddleware::class)->group(function () {
    Route::apiResource('customers', CustomersController::class);
    Route::apiResource('products', ProductsController::class);
    Route::apiResource('order-details', OrderDetailsController::class);
    Route::apiResource('sales-orders', SalesOrderController::class);
    Route::apiResource('customer-interactions', CustomerInteractionsController::class);
    Route::apiResource('service-requests', ServiceRequestsController::class);
//});
