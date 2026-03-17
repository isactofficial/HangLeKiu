<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Catatan: tabel ini membutuhkan tabel berikut tersedia sebelum dijalankan:
     *   - patient
     *   - doctor
     *   - master_poli
     *   - master_guarantor_type
     *   - master_payment_method
     *   - master_visit_type
     *   - master_care_type
     */
    public function up(): void
    {
        Schema::create('registration', function (Blueprint $table) {
            $table->string('id', 50)->primary();

            $table->string('patient_id', 50)->nullable();
            $table->string('doctor_id', 50)->nullable();
            $table->string('admin_id', 50)->nullable();

            $table->string('poli_id', 50)->nullable();
            $table->string('guarantor_type_id', 50)->nullable();
            $table->string('payment_method_id', 50)->nullable();
            $table->string('visit_type_id', 50)->nullable();
            $table->string('care_type_id', 50)->nullable();

            $table->enum('patient_type', ['rujuk', 'non_rujuk'])->nullable();

            $table->date('registration_date')->nullable();
            $table->dateTime('appointment_datetime')->nullable();
            $table->integer('duration_minutes')->nullable();

            $table->enum('status', ['pending', 'confirmed', 'waiting', 'engaged', 'succeed'])->nullable();

            $table->text('complaint')->nullable();
            $table->text('patient_condition')->nullable();
            $table->text('procedure_plan')->nullable();

            $table->foreign('patient_id')->references('id')->on('patient');
            $table->foreign('doctor_id')->references('id')->on('doctor');
            $table->foreign('poli_id')->references('id')->on('master_poli');
            $table->foreign('guarantor_type_id')->references('id')->on('master_guarantor_type');
            $table->foreign('payment_method_id')->references('id')->on('master_payment_method');
            $table->foreign('visit_type_id')->references('id')->on('master_visit_type');
            $table->foreign('care_type_id')->references('id')->on('master_care_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registration');
    }
};
