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
        Schema::table('invoices', function (Blueprint $table) {
            // Menambahkan kolom status. 
            // Pilihannya bisa disesuaikan, misal: 'paid' (lunas), 'unpaid' (belum dibayar), 'partial' (nyicil/piutang)
            $table->enum('status', ['paid', 'partial'])->default('paid')->after('invoice_number');
            
            // Catatan: after('invoice_number') opsional, gunanya agar posisi kolom rapi setelah kolom invoice_number
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Hapus kolom jika migrasi di-rollback
            $table->dropColumn('status');
        });
    }
};