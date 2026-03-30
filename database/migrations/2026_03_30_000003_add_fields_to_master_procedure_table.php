<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('master_procedure', function (Blueprint $table) {
            // Add name column if not exists
            if (!Schema::hasColumn('master_procedure', 'name')) {
                $table->string('name', 150)->nullable()->after('id');
            }
            // Add care_type_id if not exists
            if (!Schema::hasColumn('master_procedure', 'care_type_id')) {
                $table->string('care_type_id', 50)->nullable()->after('name');
            }
            // Add price if not exists
            if (!Schema::hasColumn('master_procedure', 'price')) {
                $table->decimal('price', 12, 2)->nullable()->after('base_price');
            }
            // Add description if not exists
            if (!Schema::hasColumn('master_procedure', 'description')) {
                $table->text('description')->nullable()->after('price');
            }
            // Add foreign key if not exists
            if (!Schema::hasColumn('master_procedure', 'care_type_id')) {
                $table->foreign('care_type_id')->references('id')->on('master_care_type')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('master_procedure', function (Blueprint $table) {
            // Drop foreign key if exists
            $foreignKeys = DB::select(DB::raw(
                "SELECT CONSTRAINT_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                 WHERE TABLE_NAME='master_procedure' AND COLUMN_NAME='care_type_id' 
                 AND CONSTRAINT_NAME != 'PRIMARY'"
            ));
            
            foreach ($foreignKeys as $fk) {
                try {
                    $table->dropForeign($fk->CONSTRAINT_NAME);
                } catch (\Exception $e) {
                    // Foreign key doesn't exist
                }
            }
            
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
};
