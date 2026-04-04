<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('procedure_assistant', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('procedure_id', 50);
            $table->string('doctor_id', 50);
            $table->timestamps();

            $table->foreign('procedure_id')->references('id')->on('medical_procedure')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('doctor');

            $table->unique(['procedure_id', 'doctor_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('procedure_assistant');
    }
};
