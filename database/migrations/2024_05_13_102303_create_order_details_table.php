<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->foreignId('OrderID')->constrained('sales_orders');
            $table->foreignId('ProductID')->constrained('products');
            $table->unsignedInteger('Quantity');
            $table->unsignedInteger('Price');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
