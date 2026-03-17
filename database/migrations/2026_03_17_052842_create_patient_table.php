<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patient', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('user_id', 50)->nullable();
            $table->string('full_name', 100);
            $table->string('email', 100)->nullable();
            $table->string('medical_record_no', 50)->unique();
            $table->date('date_of_birth');
            $table->enum('gender', ['Male', 'Female']);
            $table->enum('blood_type', ['A','B','AB','O','unknown'])->nullable();
            $table->enum('rhesus', ['+','-','unknown'])->nullable();
            $table->string('address', 50)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('id_card_number', 20)->nullable();
            $table->text('allergy_history')->nullable();
            $table->timestamps();
 
            $table->foreign('user_id')->references('id')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient');
    }
};
