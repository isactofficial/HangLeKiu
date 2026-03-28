<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tooth_procedure', function (Blueprint $table) {

            // Permukaan gigi yang terdampak: M, D, O, B, L, I (dipisah koma)
            $table->string('surfaces', 20)->nullable()->after('tooth_number');

            // Kode kondisi: CAR, AMF, COF, RCT, MIS, dll
            $table->string('condition_code', 10)->nullable()->after('surfaces');

            // Label Indonesia untuk tampil di UI dan invoice
            $table->string('condition_label', 100)->nullable()->after('condition_code');

            // Warna marker di chart odontogram
            $table->string('color_code', 10)->nullable()->after('condition_label');

            $table->text('notes')->nullable()->after('color_code');

            $table->timestamp('updated_at')->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('tooth_procedure', function (Blueprint $table) {
            $table->dropColumn([
                'surfaces',
                'condition_code',
                'condition_label',
                'color_code',
                'notes',
                'updated_at',
            ]);
        });
    }
};