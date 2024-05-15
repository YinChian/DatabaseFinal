<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->bigInteger('OrderID')->unsigned();
            $table->bigInteger('ProductID')->unsigned();
            $table->unsignedInteger('Quantity');
            $table->unsignedInteger('Price');

            $table->foreign('OrderID')
                ->references('OrderID')
                ->on('sales_orders');

            $table->foreign('ProductID')
                ->references('ProductID')
                ->on('products');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
