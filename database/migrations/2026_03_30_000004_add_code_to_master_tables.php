<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('master_visit_type', function (Blueprint $table) {
            if (!Schema::hasColumn('master_visit_type', 'code')) {
                $table->string('code', 20)->default('');
            }
        });

        Schema::table('master_care_type', function (Blueprint $table) {
            if (!Schema::hasColumn('master_care_type', 'code')) {
                $table->string('code', 20)->default('');
            }
        });

        Schema::table('master_procedure', function (Blueprint $table) {
            if (!Schema::hasColumn('master_procedure', 'code')) {
                $table->string('code', 20)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('master_visit_type', function (Blueprint $table) {
            if (Schema::hasColumn('master_visit_type', 'code')) {
                $table->dropColumn('code');
            }
        });

        Schema::table('master_care_type', function (Blueprint $table) {
            if (Schema::hasColumn('master_care_type', 'code')) {
                $table->dropColumn('code');
            }
        });

        Schema::table('master_procedure', function (Blueprint $table) {
            if (Schema::hasColumn('master_procedure', 'code')) {
                $table->dropColumn('code');
            }
        });
    }
};
