<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('customer_interactions', function (Blueprint $table) {
            $table->id('InteractionID');
            $table->foreignId('CustomerID')->constrained('customers');
            $table->date('Date');
            $table->enum('Mode', ['Email', 'Phone', 'In-Person']);
            $table->text('Description');
            $table->timestamp('InteractionDate');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_interactions');
    }
};
