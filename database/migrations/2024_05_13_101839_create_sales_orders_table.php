<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id('OrderID');
            $table->bigInteger('CustomerID')->unsigned();
            $table->unsignedInteger('TotalAmount');
            $table->string('PaymentStatus');
            $table->string('DeliveryStatus');
            $table->timestamp('OrderDate')->nullable();

            $table->foreign('CustomerID')
                ->references('CustomerID')
                ->on('customers');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
