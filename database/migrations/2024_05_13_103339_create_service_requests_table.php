<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('CustomerID')->constrained('customers')->onDelete('cascade');
            $table->foreignId('ProductID')->constrained('products')->onDelete('cascade');
            $table->text('IssueDescription');
            // $table->date('ResolutionDate')->nullable();
            $table->enum('Status', ['Pending', 'Resolved']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
