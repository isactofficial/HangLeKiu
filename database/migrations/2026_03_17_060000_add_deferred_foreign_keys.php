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
        Schema::table('registration', function (Blueprint $table) {
            $table->foreign('patient_id')->references('id')->on('patient');
            $table->foreign('doctor_id')->references('id')->on('doctor');
            $table->foreign('admin_id')->references('id')->on('user');
            $table->foreign('poli_id')->references('id')->on('master_poli');
            $table->foreign('guarantor_type_id')->references('id')->on('master_guarantor_type');
            $table->foreign('payment_method_id')->references('id')->on('master_payment_method');
            $table->foreign('visit_type_id')->references('id')->on('master_visit_type');
            $table->foreign('care_type_id')->references('id')->on('master_care_type');
        });

        Schema::table('medical_procedure', function (Blueprint $table) {
            $table->foreign('registration_id')->references('id')->on('registration');
            $table->foreign('patient_id')->references('id')->on('patient');
            $table->foreign('doctor_id')->references('id')->on('doctor');
        });

        Schema::table('stock_mutation', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('user');
        });

        Schema::table('doctor_note', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctor_note', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('stock_mutation', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('medical_procedure', function (Blueprint $table) {
            $table->dropForeign(['registration_id']);
            $table->dropForeign(['patient_id']);
            $table->dropForeign(['doctor_id']);
        });

        Schema::table('registration', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
            $table->dropForeign(['doctor_id']);
            $table->dropForeign(['admin_id']);
            $table->dropForeign(['poli_id']);
            $table->dropForeign(['guarantor_type_id']);
            $table->dropForeign(['payment_method_id']);
            $table->dropForeign(['visit_type_id']);
            $table->dropForeign(['care_type_id']);
        });
    }
};
