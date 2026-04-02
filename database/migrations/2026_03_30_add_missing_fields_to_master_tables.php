<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add description to master_visit_type
        if (Schema::hasTable('master_visit_type') && !Schema::hasColumn('master_visit_type', 'description')) {
            Schema::table('master_visit_type', function (Blueprint $table) {
                $table->string('description', 255)->nullable()->after('name');
            });
        }

        // Add price and description to master_care_type
        if (Schema::hasTable('master_care_type')) {
            if (!Schema::hasColumn('master_care_type', 'price')) {
                Schema::table('master_care_type', function (Blueprint $table) {
                    $table->decimal('price', 12, 2)->nullable()->after('name');
                });
            }
            if (!Schema::hasColumn('master_care_type', 'description')) {
                Schema::table('master_care_type', function (Blueprint $table) {
                    $table->string('description', 255)->nullable()->after('price');
                });
            }
        }

        // Add fields to master_procedure
        if (Schema::hasTable('master_procedure')) {
            if (!Schema::hasColumn('master_procedure', 'name')) {
                Schema::table('master_procedure', function (Blueprint $table) {
                    $table->string('name', 150)->nullable()->after('id');
                });
            }
            if (!Schema::hasColumn('master_procedure', 'care_type_id')) {
                Schema::table('master_procedure', function (Blueprint $table) {
                    $table->string('care_type_id', 50)->nullable()->after('procedure_name');
                });
            }
            if (!Schema::hasColumn('master_procedure', 'price')) {
                Schema::table('master_procedure', function (Blueprint $table) {
                    $table->decimal('price', 12, 2)->nullable()->after('base_price');
                });
            }
            if (!Schema::hasColumn('master_procedure', 'description')) {
                Schema::table('master_procedure', function (Blueprint $table) {
                    $table->string('description', 255)->nullable()->after('price');
                });
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('master_visit_type') && Schema::hasColumn('master_visit_type', 'description')) {
            Schema::table('master_visit_type', function (Blueprint $table) {
                $table->dropColumn('description');
            });
        }

        if (Schema::hasTable('master_care_type')) {
            Schema::table('master_care_type', function (Blueprint $table) {
                $table->dropColumn('price', 'description');
            });
        }

        if (Schema::hasTable('master_procedure')) {
            Schema::table('master_procedure', function (Blueprint $table) {
                if (Schema::hasColumn('master_procedure', 'name')) {
                    $table->dropColumn('name');
                }
                if (Schema::hasColumn('master_procedure', 'care_type_id')) {
                    $table->dropColumn('care_type_id');
                }
                if (Schema::hasColumn('master_procedure', 'price')) {
                    $table->dropColumn('price');
                }
                if (Schema::hasColumn('master_procedure', 'description')) {
                    $table->dropColumn('description');
                }
            });
        }
    }
};
