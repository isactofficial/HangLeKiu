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
        Schema::create('invoices', function (Blueprint $table) {
            // PK (Primary Key) - UUID dengan VARCHAR(50) sesuai desain ERD
            $table->string('id', 50)->primary();

            // FK (Foreign Keys) - UUID dengan VARCHAR(50)
            $table->string('registration_id', 50);
            $table->string('admin_id', 50);

            // UK (Unique Keys)
            $table->string('invoice_number', 50)->unique();
            $table->string('receipt_number', 20)->unique()->nullable(); // Dibuat nullable untuk antisipasi jika struk belum dicetak

            // Kolom Data Transaksi
            $table->string('payment_type', 50);
            $table->string('payment_method', 100)->nullable();
            
            // Decimal (Total 15 digit, 2 angka di belakang koma)
            $table->decimal('amount_paid', 15, 2)->default(0);
            $table->decimal('change_amount', 15, 2)->default(0);
            $table->decimal('debt_amount', 15, 2)->default(0);
            $table->decimal('rounding', 15, 2)->default(0);
            
            $table->text('notes')->nullable();

            // Timestamp (Di ERD hanya ada created_at)
            $table->timestamp('created_at')->useCurrent();
            
            // ---------------------------------------------------------------------
            // OPSIONAL: Jika boss mau langsung mengaktifkan relasi Foreign Key-nya 
            // di level database, bisa uncomment kode di bawah ini.
            // Pastikan nama tabel referensinya ('registrations' / 'admins') sudah benar.
            // ---------------------------------------------------------------------
            // $table->foreign('registration_id')->references('id')->on('registrations')->onDelete('cascade');
            // $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};