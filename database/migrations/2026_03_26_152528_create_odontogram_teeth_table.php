<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ⚠️  FIX dari versi sebelumnya:
//   - tooth_number: tinyInteger → unsignedSmallInteger (lebih aman, range 0-65535)
//   - Hapus created_at manual dari migration, biarkan $timestamps handle via UPDATED_AT=null

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('odontogram_teeth');

        Schema::create('odontogram_teeth', function (Blueprint $table) {
            $table->string('id', 50)->primary();

            $table->string('odontogram_record_id', 50);

            // FIX: unsignedSmallInteger lebih aman untuk FDI (11-85)
            $table->unsignedSmallInteger('tooth_number');

            // Permukaan: M, D, O, B, L — simpan sebagai "M,D,O"
            $table->string('surfaces', 30)->nullable();

            // Kondisi: CAR, AMF, COF, RCT, MIS, dll
            $table->string('condition_code', 10)->nullable();
            $table->string('condition_label', 100)->nullable();

            $table->string('color_code', 10)->nullable();
            $table->text('notes')->nullable();

            // Hanya created_at, tidak ada updated_at
            $table->timestamp('created_at')->nullable();

            $table->foreign('odontogram_record_id')
                  ->references('id')->on('odontogram_records')
                  ->cascadeOnDelete();

            // Satu gigi bisa banyak kondisi — NOT unique
            $table->index(['odontogram_record_id', 'tooth_number']);
            $table->index('condition_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('odontogram_teeth');
    }
};