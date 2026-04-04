<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('procedure_item', function (Blueprint $table) {
            if (!Schema::hasColumn('procedure_item', 'tooth_numbers')) {
                $table->string('tooth_numbers', 255)->nullable()->after('master_procedure_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('procedure_item', function (Blueprint $table) {
            if (Schema::hasColumn('procedure_item', 'tooth_numbers')) {
                $table->dropColumn('tooth_numbers');
            }
        });
    }
};
