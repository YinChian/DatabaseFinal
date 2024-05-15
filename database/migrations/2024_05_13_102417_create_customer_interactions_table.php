<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('customer_interactions', function (Blueprint $table) {
            $table->id('InteractionID');
            $table->bigInteger('CustomerID')->unsigned();
            $table->string('Mode');
            $table->string('Description');
            $table->timestamp('InteractionDate');

            $table->foreign('CustomerID')
                ->references('CustomerID')
                ->on('customers');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_interactions');
    }
};
