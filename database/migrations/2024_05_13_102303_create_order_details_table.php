<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('OrderID')->constrained('sales_orders')->onDelete('cascade');
            $table->foreignId('ProductID')->constrained('products')->onDelete('cascade');
            $table->unsignedInteger('Quantity');
            $table->decimal('Price', 8, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
