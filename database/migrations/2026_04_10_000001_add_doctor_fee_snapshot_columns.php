<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doctor', function (Blueprint $table) {
            if (! Schema::hasColumn('doctor', 'default_fee_percentage')) {
                $table->decimal('default_fee_percentage', 5, 2)
                    ->default(0)
                    ->after('is_active');
            }
        });

        Schema::table('medical_procedure', function (Blueprint $table) {
            if (! Schema::hasColumn('medical_procedure', 'doctor_fee_percentage_snapshot')) {
                $table->decimal('doctor_fee_percentage_snapshot', 5, 2)
                    ->nullable()
                    ->after('doctor_id');
            }
        });

        DB::statement("
            UPDATE medical_procedure mp
            JOIN doctor d ON d.id = mp.doctor_id
            SET mp.doctor_fee_percentage_snapshot = d.default_fee_percentage
            WHERE mp.doctor_fee_percentage_snapshot IS NULL
        ");
    }

    public function down(): void
    {
        Schema::table('medical_procedure', function (Blueprint $table) {
            if (Schema::hasColumn('medical_procedure', 'doctor_fee_percentage_snapshot')) {
                $table->dropColumn('doctor_fee_percentage_snapshot');
            }
        });

        Schema::table('doctor', function (Blueprint $table) {
            if (Schema::hasColumn('doctor', 'default_fee_percentage')) {
                $table->dropColumn('default_fee_percentage');
            }
        });
    }
};
