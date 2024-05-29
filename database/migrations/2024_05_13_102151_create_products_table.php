<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('ProductID');
            $table->string('Name');
            $table->text('Description');
            $table->unsignedInteger('Price');
            $table->unsignedInteger('StockQuantity');
            $table->unsignedInteger('CategoryID');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
