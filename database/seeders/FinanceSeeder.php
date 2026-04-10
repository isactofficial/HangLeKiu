<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\ConsumableRestock;
use App\Models\ConsumableItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FinanceSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Sedang membuat data dummy keuangan...');

        // 1. Ambil semua pendaftaran yang statusnya 'succeed'
        $appointments = Appointment::where('status', 'succeed')->get();

        if ($appointments->isEmpty()) {
            $this->command->warn('⚠️ Tidak ada data pendaftaran (succeed). Jalankan PatientDummySeeder dulu!');
            return;
        }

        foreach ($appointments as $appt) {
            // Cek jika sudah punya invoice, skip
            if (Invoice::where('registration_id', $appt->id)->exists()) continue;

            $totalBill = rand(200, 1500) * 1000; // 200rb - 1.5jt
            $isPaid = rand(0, 5) > 0; // 80% lunas
            
            $amountPaid = $isPaid ? $totalBill : ($totalBill * 0.5);
            $debtAmount = $totalBill - $amountPaid;

                // Fetch dynamic admin_id (like UserSeeder)
                $adminId = DB::table('user')->where('email', 'admin@hanglekiu.com')->value('id');
                if (!$adminId) {
                    $this->command->warn('⚠️ Admin user not found, skipping invoice for ' . $appt->id);
                    continue;
                }

                Invoice::create([
                'id'              => (string) Str::uuid(),
                'registration_id' => $appt->id,
                'admin_id'        => $adminId,
                'invoice_number'  => 'INV-' . $appt->appointment_datetime->format('Ymd') . '-' . strtoupper(Str::random(4)),
                'status'          => $isPaid ? 'paid' : 'partial',
                'receipt_number'  => 'REC-' . $appt->appointment_datetime->format('Ymd') . '-' . strtoupper(Str::random(4)),
                'payment_type'    => rand(0, 3) === 0 ? 'BPJS' : 'Langsung', 
                'payment_method'  => rand(0, 1) === 0 ? 'Cash' : 'Transfer',
                'amount_paid'     => $amountPaid,
                'change_amount'   => 0,
                'debt_amount'     => $debtAmount,
                'rounding'        => 0,
                'notes'           => 'Pembayaran dummy hasil seeder.',
                'created_at'      => $appt->appointment_datetime // Samakan dengan tgl berobat
            ]);
        }

        // 2. Buat Pengeluaran Dummy (Restock BHP)
        $items = ConsumableItem::all();
        if ($items->isNotEmpty()) {
            for ($i = 0; $i < 10; $i++) {
                $item = $items->random();
                $qty = rand(5, 20);
                $price = rand(10, 50) * 1000;
                $date = Carbon::now()->subDays(rand(0, 30));

                ConsumableRestock::create([
                    'bhp_id'            => $item->id,
                    'supplier_id'       => null,
                    'restock_type'      => 'restock',
                    'quantity_added'    => $qty,
                    'purchase_price'    => $price,
                    'expiry_date'       => $date->addYear()->toDateString(),
                    'batch_number'      => 'BTCH-' . strtoupper(Str::random(5)),
                    'notes'             => 'Restock dummy seeder.',
                    'created_at'        => $date
                ]);
            }
        }

        $this->command->info('✅ Berhasil membuat data dummy Pemasukan dan Pengeluaran!');
    }
}
