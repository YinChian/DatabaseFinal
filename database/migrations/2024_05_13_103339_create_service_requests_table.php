<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id('RequestID');
            $table->bigInteger('CustomerID')->unsigned();
            $table->bigInteger('ProductID')->unsigned();
            $table->string('IssueDescription');
            $table->date('ResolutionDate');
            $table->string('Status');
            $table->timestamp('RequestDate')->nullable();

            $table->foreign('CustomerID')
                ->references('CustomerID')
                ->on('customers');

            $table->foreign('ProductID')
                ->references('ProductID')
                ->on('products');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
