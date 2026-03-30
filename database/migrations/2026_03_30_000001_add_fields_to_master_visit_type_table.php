<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('master_visit_type', function (Blueprint $table) {
            if (!Schema::hasColumn('master_visit_type', 'description')) {
                $table->text('description')->nullable()->after('name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('master_visit_type', function (Blueprint $table) {
            if (Schema::hasColumn('master_visit_type', 'description')) {
                $table->dropColumn('description');
            }
        });
    }
};
