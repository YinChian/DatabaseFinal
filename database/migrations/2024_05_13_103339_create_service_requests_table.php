<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id('RequestID');
            $table->foreignId('CustomerID')->constrained('customers');
            $table->foreignId('ProductID')->constrained('products');
            $table->text('IssueDescription');
            $table->date('ResolutionDate')->nullable();
            $table->timestamp('RequestDate');
            $table->enum('Status', ['Pending', 'Resolved']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
