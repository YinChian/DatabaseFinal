<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id('OrderID');
            $table->foreignId('CustomerID')->constrained('customers');
            $table->unsignedInteger('TotalAmount');
            $table->enum('PaymentStatus', ['Pending', 'Completed', 'Failed']);
            $table->enum('DeliveryStatus', ['Pending', 'Shipped', 'Delivered']);
            $table->timestamp('OrderDate')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
