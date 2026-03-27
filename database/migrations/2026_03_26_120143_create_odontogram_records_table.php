<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('odontogram_records');

        Schema::create('odontogram_records', function (Blueprint $table) {
            $table->string('id', 50)->primary();

            $table->string('patient_id', 50);
            $table->string('visit_id', 50)->nullable(); // FK ke registration

            $table->string('examined_by', 100)->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('examined_at')->nullable();
            $table->timestamps();

            $table->foreign('patient_id')
                  ->references('id')->on('patient')
                  ->cascadeOnDelete();

            $table->foreign('visit_id')
                  ->references('id')->on('registration') // ← BENAR
                  ->nullOnDelete();

            $table->index(['patient_id', 'examined_at']);
            $table->index('visit_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('odontogram_records');
    }
};