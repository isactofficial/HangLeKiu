<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_procedure', function (Blueprint $table) {
            $table->string('id', 50)->primary();

            $table->string('registration_id', 50)->nullable();
            $table->string('patient_id', 50)->nullable();
            $table->string('doctor_id', 50)->nullable();

            $table->enum('discount_type', ['fix', 'percentage', 'none'])->nullable();
            $table->decimal('discount_value', 12, 2)->nullable();
            $table->decimal('total_amount', 12, 2)->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();

            // FK ditambahkan di migration lanjutan agar urutan create table aman.
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_procedure');
    }
};
