<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_note', function (Blueprint $table) {
            $table->string('id', 50)->primary();

            $table->string('procedure_id', 50)->nullable();
            $table->string('user_id', 50)->nullable();

            $table->text('notes')->nullable();

            $table->timestamp('created_at')->useCurrent();

            $table->foreign('procedure_id')->references('id')->on('medical_procedure');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_note');
    }
};
