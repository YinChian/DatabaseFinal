<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id('CustomerID');
            // $table->id();
            $table->string('Name');
            $table->string('Email')->unique();
            $table->string('PhoneNumber');
            $table->string('Address');
            $table->enum('CustomerType', ['Individual', 'Corporate']);
            $table->timestamp('RegistrationDate');
            // $table->date('RegistrationDate');
            // $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
