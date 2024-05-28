<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::apiResource('customers', CustomersController::class);
Route::apiResource('sales-orders', SalesOrderController::class);
Route::apiResource('products', ProductsController::class);
Route::apiResource('order-details', OrderDetailsController::class);
Route::apiResource('customer-interactions', CustomerInteractionsController::class);
Route::apiResource('service-requests', ServiceRequestsController::class);

//Route::post('/store', '');
