<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('CustomerID')->constrained('customers')->onDelete('cascade');
            $table->decimal('TotalAmount', 8, 2);
            $table->enum('PaymentStatus', ['Pending', 'Completed', 'Failed']);
            $table->enum('DeliveryStatus', ['Pending', 'Shipped', 'Delivered']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
