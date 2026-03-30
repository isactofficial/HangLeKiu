<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Either add default value or nullable to code field
        
        // For master_visit_type
        if (Schema::hasTable('master_visit_type') && Schema::hasColumn('master_visit_type', 'code')) {
            Schema::table('master_visit_type', function (Blueprint $table) {
                $table->string('code', 50)->nullable()->change();
            });
        }

        // For master_care_type
        if (Schema::hasTable('master_care_type') && Schema::hasColumn('master_care_type', 'code')) {
            Schema::table('master_care_type', function (Blueprint $table) {
                $table->string('code', 50)->nullable()->change();
            });
        }

        // For master_procedure
        if (Schema::hasTable('master_procedure') && Schema::hasColumn('master_procedure', 'code')) {
            Schema::table('master_procedure', function (Blueprint $table) {
                $table->string('code', 50)->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        // Revert changes if needed
    }
};
