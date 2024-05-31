<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('Name');
            $table->text('Description');
            $table->decimal('Price', 8, 2);
            $table->unsignedInteger('StockQuantity');
            $table->unsignedInteger('CategoryID'); //TODO: This will be a foreign key to the 'categories' table
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
