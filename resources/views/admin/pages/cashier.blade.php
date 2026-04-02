@extends('admin.layout.admin')
@section('title', 'Kasir - HangLeKiu')

@section('navbar')
    @include('admin.components.navbar', ['title' => 'Kasir'])
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/pages/cashier.css') }}">
    <style>
        .badge-lunas-hijau {
            background-color: #dcfce7;
            color: #166534;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 700;
            margin-right: 8px;
        }
        .badge-belum-lunas {
            background-color: #fef08a;
            color: #854d0e;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 700;
            margin-right: 8px;
        }

        /* =========================================
           CSS KHUSUS CETAK NOTA (ANTI BLANK PAGE)
           ========================================= */
        
        /* 1. Di Layar Monitor: Sembunyikan Nota */
        @media screen {
            #nota-cetak {
                display: none !important;
            }
        }

        /* 2. Saat Di-Print: Tampilkan Nota, Sembunyikan Dashboard */
        @media print {
            body * {
                visibility: hidden;
            }
            .no-print {
                display: none !important;
            }
            #nota-cetak, #nota-cetak * {
                visibility: visible !important;
            }
            #nota-cetak {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                display: block !important;
                background: white;
            }
            @page { margin: 0; }
            body, html { margin: 0 !important; padding: 0 !important; background: white !important; }
        }
    </style>
@endpush

@section('content')
<div class="no-print">
    {{-- Header --}}
    <div class="cashier-header">
        <h1 class="cashier-title">Cashier</h1>
        <p class="cashier-subtitle">hanglekiu dental specialist</p>
    </div>

    <div class="cashier-layout">
        {{-- Tabs --}}
        <div class="cashier-tabs">
            <button class="cashier-tab active">Pembayaran</button>
            <button class="cashier-tab">Hutang & Piutang</button>
        </div>

        <div class="cashier-content">
            <div class="cashier-tab-content active">
                {{-- Toolbar --}}
                <div class="cashier-toolbar">
                    <div class="cashier-search">
                        <input type="text" placeholder="Cari invoice atau pasien..." class="cashier-search-input" id="cashierSearch">
                    </div>
                    <button class="cashier-btn btn-cokelat">+ Pembayaran Manual</button>
                    <button class="cashier-btn cashier-btn-success">Export CSV</button>
                </div>

                {{-- Tabel Antrean Pembayaran --}}
                <div class="cashier-table-wrapper">
                    <table class="cashier-table">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Nama Lengkap Pasien</th>
                                <th>Keterangan Medis</th>
                                <th style="text-align: center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="cashier-tbody">
                            @forelse($appointments as $apt)
                                @php
                                // 1. Ambil Prosedur Medis Utama
                                $medicalProcedure = $apt->medicalProcedures->first(); 
                                
                                $arrTindakan = []; $arrHarga = []; $arrQty = []; $arrDiskon = []; $arrSubtotal = []; $arrGigi = [];
                                $gigiStr = '-'; 
                                
                                // 2. Ambil data Odontogram (Nomor Gigi)
                                $recordOdontogram = \Illuminate\Support\Facades\DB::table('odontogram_records')
                                    ->where('patient_id', $apt->patient_id)
                                    ->where('visit_id', $apt->id) 
                                    ->orderBy('created_at', 'desc')
                                    ->first();

                                if ($recordOdontogram) {
                                    $gigiList = \Illuminate\Support\Facades\DB::table('odontogram_teeth')
                                        ->where('odontogram_record_id', $recordOdontogram->id)
                                        ->pluck('tooth_number')
                                        ->toArray();
                                    if (count($gigiList) > 0) $gigiStr = implode(', ', $gigiList);
                                }

                                // 3. Loop Item Prosedur & Obat-obatan untuk Array JS
                                if ($medicalProcedure) {
                                    // Items Tindakan
                                    if ($medicalProcedure->items->count() > 0) {
                                        foreach ($medicalProcedure->items as $item) {
                                            $arrTindakan[] = $item->masterProcedure->procedure_name ?? 'Tindakan';
                                            $arrHarga[] = (float) $item->unit_price;
                                            $arrQty[] = (int) $item->quantity;
                                            $arrDiskon[] = (float) $item->discount_value;
                                            $arrSubtotal[] = (float) $item->subtotal;
                                            $arrGigi[] = $gigiStr;
                                        }
                                    }

                                    // Gabungkan Obat
                                    $medicines = \Illuminate\Support\Facades\DB::table('procedure_medicine')
                                        ->join('medicine', 'procedure_medicine.medicine_id', '=', 'medicine.id')
                                        ->where('procedure_medicine.procedure_id', $medicalProcedure->id)
                                        ->select('medicine.medicine_name', 'medicine.selling_price_general', 'procedure_medicine.quantity_used')
                                        ->get();

                                    foreach ($medicines as $med) {
                                        $arrTindakan[] = $med->medicine_name;
                                        $medPrice = (float) $med->selling_price_general;
                                        $medQty = (int) $med->quantity_used;
                                        
                                        $arrHarga[] = $medPrice;
                                        $arrQty[] = $medQty;
                                        $arrDiskon[] = 0; 
                                        $arrSubtotal[] = $medPrice * $medQty;
                                        $arrGigi[] = '-'; 
                                    }
                                }
                                
                                // 4. CEK DATA DI TABEL INVOICE (Data Permanen setelah Refresh)
                                $invoice = \Illuminate\Support\Facades\DB::table('invoices')
                                    ->where('registration_id', $apt->id)
                                    ->first();
                                
                                // Status Invoice: paid, partial, atau unpaid
                                $invoiceStatus = $invoice ? ($invoice->status ?? 'paid') : 'unpaid'; 
                                
                                // Ambil data pembayaran ASLI dari database (Penting!)
                                $amtPaid = $invoice ? (float) $invoice->amount_paid : 0;
                                $amtChange = $invoice ? (float) $invoice->change_amount : 0;
                                $amtDebt = $invoice ? (float) $invoice->debt_amount : 0;
                                
                                // 5. Variabel Display & Data JS
                                $invoiceNo = $invoice ? $invoice->invoice_number : 'INV' . \Carbon\Carbon::parse($apt->appointment_datetime)->format('Ymd') . str_pad($apt->id, 3, '0', STR_PAD_LEFT);
                                $metodeBayar = $invoice ? $invoice->payment_method : ($apt->paymentMethod->name ?? 'Belum Ditentukan');
                                $catatanInvoice = $invoice ? ($invoice->notes ?? '-') : '-';
                                $tglInputStr = \Carbon\Carbon::parse($apt->appointment_datetime)->format('d-m-Y H:i').' WIB';

                                $dataPasien = [
                                    'nama' => $apt->patient->full_name ?? 'Pasien',
                                    'id' => $apt->patient->medical_record_no ?? '-',
                                    'usia' => $apt->patient->date_of_birth ? \Carbon\Carbon::parse($apt->patient->date_of_birth)->age . ' Thn' : '-',
                                    'hp' => $apt->patient->phone_number ?? '-',
                                    'dokter' => $apt->doctor->full_name ?? '-'
                                ];
                            @endphp
                                
                                <tr id="row-{{ $apt->id }}" class="patient-row">
                                    <td style="vertical-align: top; padding: 15px 10px;">
                                        <div class="invoice-date" style="font-size: 11px; color: #6B513E;">
                                            {{ \Carbon\Carbon::parse($apt->appointment_datetime)->format('d M Y') }}
                                        </div>
                                        <div class="invoice-number" style="font-weight: 800; color: #C58F59;">
                                            {{ $invoiceNo }}
                                        </div>
                                    </td>

                                    <td class="patient-name" style="vertical-align: top; padding: 15px 10px; font-weight: 700; color: #6B513E;">
                                        {{ $apt->patient->full_name ?? 'Pasien Tidak Dikenal' }}
                                    </td>

                                    <td style="vertical-align: top; padding: 15px 10px;">
                                        <div class="keterangan-grid" style="display: grid; grid-template-columns: 120px 1fr; gap: 8px 12px; align-items: start;">
                                            <span class="ket-label" style="font-size: 11px; color: #6B513E; text-transform: uppercase; font-weight: 700; margin-top: 2px;">Dokter</span>
                                            <span class="ket-value" style="font-size: 13px; color: #6B513E; font-weight: 600;">
                                                {{ $apt->doctor->full_name ?? 'Dokter Klinik' }}
                                            </span>

                                            <span class="ket-label" style="font-size: 11px; color: #6B513E; text-transform: uppercase; font-weight: 700; margin-top: 2px;">Tindakan</span>
                                            <div class="ket-value">
                                                @if(count($arrTindakan) > 0)
                                                    <ul style="margin: 0; padding: 0; list-style: none; display: flex; flex-direction: column; gap: 4px;">
                                                        @foreach($arrTindakan as $tindakan)
                                                            <li style="font-size: 12px; color: #C58F59; display: flex; align-items: center; gap: 6px;">
                                                                <i class="fa fa-caret-right" style="color: #C58F59; font-size: 10px;"></i>
                                                                {{ $tindakan }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <span style="font-size: 13px; color: #6B513E; font-style: italic;">Konsultasi Umum</span>
                                                @endif
                                            </div>

                                            <span class="ket-label" style="font-size: 11px; color: #6B513E; text-transform: uppercase; font-weight: 700; margin-top: 4px;">Metode Bayar</span>
                                            <span class="ket-value">
                                                <span style="color: #C58F59; font-weight: 800; font-size: 11px; background: #fdfaf8; padding: 2px 10px; border-radius: 4px; border: 1px solid #f0e6dd; display: inline-block; letter-spacing: 0.5px;">
                                                    {{ strtoupper($metodeBayar) }}
                                                </span>
                                            </span>
                                        </div>
                                    </td>

                                    <td style="vertical-align: top; text-align: center; padding: 15px 10px;" id="action-{{ $apt->id }}">
                                    @if($invoiceStatus === 'paid' || $invoiceStatus === 'partial')
                                        {{-- JIKA SUDAH ADA DATA DI TABEL INVOICE (SUDAH PERNAH BAYAR) --}}
                                        <div class="flex items-center justify-center gap-2">
                                            @if($invoiceStatus === 'paid')
                                                <span class="badge-lunas-hijau">Lunas</span>
                                            @else
                                                <span class="badge-belum-lunas">Belum Lunas</span>
                                            @endif

                                            {{-- Tombol Nota tetap muncul untuk print ulang --}}
                                            <button class="text-white bg-[#8e6a45] px-3 py-1.5 rounded shadow-sm font-bold text-xs hover:bg-[#7a5938] transition-colors flex items-center" 
                                                onclick='prepareAndPrint(@json($invoiceNo), @json($apt->patient->full_name ?? "Pasien"), @json($apt->doctor->full_name ?? "-"), @json($arrTindakan), @json($arrHarga), @json($arrQty), @json($arrDiskon), @json($arrSubtotal), @json($arrGigi), @json($metodeBayar), @json($tglInputStr), @json($catatanInvoice), @json($invoiceStatus), {{ $amtPaid }}, {{ $amtChange }}, {{ $amtDebt }})'>
                                                <i class="fa fa-print mr-1"></i> Nota
                                            </button>
                                        </div>
                                    @elseif($apt->status === 'succeed')
                                        {{-- JIKA BELUM ADA DI TABEL INVOICE SAMA SEKALI --}}
                                        <div class="flex justify-center w-full">
                                            <button class="btn-bayar-tabel text-white bg-[#A67C52] px-4 py-2 rounded shadow-sm font-bold text-xs hover:bg-[#8e6a45] transition-colors flex items-center" 
                                                onclick='openPayment(
                                                    @json($invoiceNo), 
                                                    @json($dataPasien), 
                                                    @json($arrTindakan), 
                                                    @json($arrHarga), 
                                                    @json($arrQty), 
                                                    @json($arrDiskon), 
                                                    @json($arrSubtotal), 
                                                    @json($arrGigi),
                                                    @json($tglInputStr),
                                                    @json($apt->id)
                                                )'>
                                                <i class="fa fa-wallet mr-1.5"></i> Bayar Sekarang
                                            </button>
                                        </div>
                                    @endif
                                </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align: center; padding: 60px 20px; color: #94a3b8;">
                                        <p>Belum ada antrean pembayaran dari EMR.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- INCLUDE PENTING! MEMANGGIL MODAL --}}
@include('admin.components.cashier.modal-payment')
@include('admin.components.cashier.nota')


<script>
    let activeData = {};
    let currentGrandTotal = 0;

    function openPayment(inv, dataPasien, tindakanArray, pricesArray, qtyArray, diskonArray, subtotalArray, gigiArray, tanggalInput, appointmentId) {
        const listTindakan = Array.isArray(tindakanArray) ? tindakanArray : [];
        const listHarga = Array.isArray(pricesArray) ? pricesArray : [];
        const listQty = Array.isArray(qtyArray) ? qtyArray : [];
        const listDiskon = Array.isArray(diskonArray) ? diskonArray : [];
        const listSubtotal = Array.isArray(subtotalArray) ? subtotalArray : [];
        const listGigi = Array.isArray(gigiArray) ? gigiArray : [];

        activeData = { 
            inv: inv, 
            appointmentId: appointmentId,
            nama: dataPasien.nama || '-',
            dokter: dataPasien.dokter || '-',
            tindakanArray: listTindakan,
            pricesArray: listHarga,
            qtyArray: listQty,
            diskonArray: listDiskon,
            subtotalArray: listSubtotal,
            gigiArray: listGigi,
            total: 0,
            tglInput: tanggalInput
        };
        
        document.getElementById('m-inv-no').innerText = inv;
        document.getElementById('m-pasien-nama').innerText = dataPasien.nama || '-';
        document.getElementById('m-pasien-id').innerText = dataPasien.id || '-';
        document.getElementById('m-pasien-usia').innerText = dataPasien.usia || '-';
        document.getElementById('m-pasien-hp').innerText = dataPasien.hp || '-';
        document.getElementById('m-pasien-dokter').innerText = dataPasien.dokter || '-';
        document.getElementById('m-input-pembayar').value = (dataPasien.nama || '') + ' (Pribadi)';

        let htmlItems = '';
        currentGrandTotal = 0;

        listTindakan.forEach((tindakan, index) => {
            const harga = parseFloat(listHarga[index]) || 0;
            const qty = parseInt(listQty[index]) || 1;
            const diskon = parseFloat(listDiskon[index]) || 0;
            const subtotal = parseFloat(listSubtotal[index]) || 0;
            
            // Cek index supaya gigi tidak tampil berulang
            const noGigi = (index === 0 && listGigi[0] && listGigi[0] !== '-') ? listGigi[0] : '-';
            
            currentGrandTotal += subtotal;

            htmlItems += `
                <tr class="border-b border-[#A67C52]/20 hover:bg-[#A67C52]/5 transition-colors">
                    <td class="p-3 text-[#A67C52] font-medium">${tanggalInput}</td>
                    <td class="p-3 text-[#A67C52] font-bold">${tindakan}</td>
                    <td class="p-3 text-center text-[#A67C52] font-black bg-[#A67C52]/5">${noGigi}</td>
                    <td class="p-3 text-center">
                        <input type="text" value="${qty}" readonly class="w-10 text-center border border-[#A67C52]/30 rounded p-1 text-xs bg-white outline-none text-[#A67C52] font-bold">
                    </td>
                    <td class="p-3 text-right text-[#A67C52] font-medium">Rp${Number(harga).toLocaleString('id-ID')}</td>
                    <td class="p-3 text-right">
                        <div class="flex justify-end gap-1">
                            <input type="text" value="${Number(diskon).toLocaleString('id-ID')}" readonly class="w-20 border border-[#A67C52]/30 rounded p-1 text-xs text-right bg-white outline-none text-[#A67C52]/50 font-medium">
                        </div>
                    </td>
                    <td class="p-3 text-right text-[#A67C52] font-black">Rp${Number(subtotal).toLocaleString('id-ID')}</td>
                    <td class="p-3 text-center">
                        <button class="text-[#A67C52]/50 hover:text-red-500 transition-colors"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>`;
        });

        activeData.total = currentGrandTotal;

        document.getElementById('m-items').innerHTML = htmlItems;
        document.getElementById('m-grand-total').innerText = 'Rp' + Number(currentGrandTotal).toLocaleString('id-ID');
        document.getElementById('m-input-bayar').value = currentGrandTotal; 
        
        if(typeof hitungKembalian === 'function') hitungKembalian(); 

        document.getElementById('modalPayment').classList.remove('hidden');
        document.getElementById('modalPayment').style.display = 'flex';
    }

    function hitungKembalian() {
        let inputBayar = document.getElementById('m-input-bayar').value;
        inputBayar = inputBayar.replace(/\./g, '');
        let bayar = parseFloat(inputBayar) || 0;
        
        let kembalian = bayar - currentGrandTotal;
        let hutang = currentGrandTotal - bayar;

        if (kembalian > 0) {
            document.getElementById('m-kembalian').innerText = 'Rp' + Number(kembalian).toLocaleString('id-ID');
            document.getElementById('m-hutang').innerText = 'Rp0';
        } else if (hutang > 0) {
            document.getElementById('m-kembalian').innerText = 'Rp0';
            document.getElementById('m-hutang').innerText = 'Rp' + Number(hutang).toLocaleString('id-ID');
        } else {
            document.getElementById('m-kembalian').innerText = 'Rp0';
            document.getElementById('m-hutang').innerText = 'Rp0';
        }
    }
    
    function closePayment() { 
        const modal = document.getElementById('modalPayment');
        modal.classList.add('hidden');
        modal.style.display = 'none';
    }

    async function prosesDone() {
        const appointmentId = activeData.appointmentId;
        const btnSimpan = document.querySelector('button[onclick="prosesDone()"]');
        
        const inputBayarRaw = document.getElementById('m-input-bayar').value.replace(/[^0-9]/g, '');
        const amountPaid = parseFloat(inputBayarRaw) || 0;
        
        if (amountPaid <= 0) {
            alert('Silakan masukkan nominal uang yang diterima terlebih dahulu.');
            document.getElementById('m-input-bayar').focus();
            return;
        }

        const paymentMethodSelect = document.getElementById('m-metode');
        const paymentMethodName = paymentMethodSelect ? paymentMethodSelect.options[paymentMethodSelect.selectedIndex].text : 'Tunai';
        const notes = document.getElementById('m-notes')?.value || '-';

        let changeAmount = 0;
        let debtAmount = 0;

        if (amountPaid > currentGrandTotal) {
            changeAmount = amountPaid - currentGrandTotal;
        } else if (amountPaid < currentGrandTotal) {
            debtAmount = currentGrandTotal - amountPaid;
        }

        // PENENTUAN STATUS (LUNAS / BELUM LUNAS)
        const statusKasir = debtAmount > 0 ? 'partial' : 'paid';

        const originalText = btnSimpan.innerHTML;
        btnSimpan.innerHTML = '<i class="fa fa-spinner fa-spin text-lg"></i> Memproses...';
        btnSimpan.disabled = true;

        try {
            const response = await fetch('/admin/cashier/store-payment', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ 
                    registration_id: appointmentId, 
                    payment_method: paymentMethodName,
                    amount_paid: amountPaid,
                    change_amount: changeAmount,
                    debt_amount: debtAmount,
                    status: statusKasir, 
                    notes: notes
                }) 
            });

            const result = await response.json();

            if (result.success) {
                // Sembunyikan modal
                closePayment();
                
                // Tampilkan notifikasi sukses
                alert("✓ Pembayaran Berhasil Disimpan!\nNomor Invoice: " + result.invoice_number);

                // REFRESH HALAMAN AGAR BARIS TABEL BERUBAH STATUSNYA
                window.location.reload(); 

            } else {
                alert("Gagal: " + result.message);
                btnSimpan.innerHTML = originalText;
                btnSimpan.disabled = false;
            }
        } catch (error) {
            console.error(error);
            alert("Terjadi kesalahan koneksi saat memproses pembayaran.");
            btnSimpan.innerHTML = originalText;
            btnSimpan.disabled = false;
        }
    }

    // PARAMETER DITAMBAH: statusInv, amtPaid, amtChange, amtDebt
    function prepareAndPrint(inv, nama, dokter, tindakanArray, pricesArray, qtyArray, diskonArray, subtotalArray, gigiArray, metode, tglApt, catatan, statusInv, amtPaid, amtChange, amtDebt) {
        const setHtml = (id, html) => {
            const el = document.getElementById(id);
            if (el) el.innerHTML = html;
        };

        const formatRp = (angka) => 'Rp' + Number(angka).toLocaleString('id-ID');

        // Pastikan berbentuk Array
        const listTindakan = Array.isArray(tindakanArray) ? tindakanArray : [tindakanArray];
        const listHarga = Array.isArray(pricesArray) ? pricesArray : [pricesArray];
        const listQty = Array.isArray(qtyArray) ? qtyArray : [qtyArray];
        const listDiskon = Array.isArray(diskonArray) ? diskonArray : [diskonArray];
        const listSubtotal = Array.isArray(subtotalArray) ? subtotalArray : [subtotalArray];
        const listGigi = Array.isArray(gigiArray) ? gigiArray : [gigiArray];

        // 1. Info Header
        setHtml('print-invoice', inv);
        setHtml('print-kwitansi', inv.replace('INV', 'KWI'));
        setHtml('print-nama', nama);
        setHtml('print-dokter', dokter); 
        setHtml('print-metode-atas', metode); 
        setHtml('print-tanggal-appointment', tglApt || '-');
        setHtml('print-catatan', catatan || '-');
        
        let totalSeluruhSubtotal = 0;
        let totalSeluruhDiskon = 0;
        let itemsHtml = '';

        // 2. Info Item & Gigi
        listTindakan.forEach((tindakan, index) => {
            const harga = parseFloat(listHarga[index]) || 0;
            const qty = parseInt(listQty[index]) || 1;
            const diskon = parseFloat(listDiskon[index]) || 0;
            const subtotal = parseFloat(listSubtotal[index]) || 0;
            
            const noGigi = (index === 0 && listGigi[0] && listGigi[0] !== '-') ? listGigi[0] : '-'; 

            totalSeluruhSubtotal += subtotal;
            totalSeluruhDiskon += diskon;

            let diskonLabel = '';
            if (diskon > 0) {
                diskonLabel = `<br><span style="color: #888; font-size: 9px;">Disc: ${formatRp(diskon)}</span>`;
            }

            itemsHtml += `
            <tr>
                <td style="border: 1px solid #000; padding: 6px; vertical-align: middle;">
                    ${tindakan}
                </td>
                <td style="border: 1px solid #000; padding: 6px; text-align: center; vertical-align: middle;">${noGigi}</td>
                <td style="border: 1px solid #000; padding: 6px; text-align: center; vertical-align: middle;">x${qty}</td>
                <td style="border: 1px solid #000; padding: 6px; text-align: right; vertical-align: middle;">${formatRp(harga)}</td>
                <td style="border: 1px solid #000; padding: 6px; text-align: right; vertical-align: middle;">${formatRp(diskon)}</td>
                <td style="border: 1px solid #000; padding: 6px; text-align: right; font-weight: bold; vertical-align: middle;">${formatRp(subtotal)}</td>
            </tr>`;
        });

        const itemContainer = document.getElementById('print-items-list');
        if (itemContainer) itemContainer.innerHTML = itemsHtml;

        // 3. Info Harga Footer (Terapkan Pembayaran, Kembalian, Hutang)
        setHtml('print-harga-awal', formatRp(totalSeluruhSubtotal + totalSeluruhDiskon));
        setHtml('print-diskon', formatRp(totalSeluruhDiskon));
        setHtml('print-total', formatRp(totalSeluruhSubtotal));
        setHtml('print-label-transfer', `Dibayar (${metode})`);
        
        // Gunakan parameter amount yang di-passing, jika kosong / undefined (kasus nota lama), gunakan totalSeluruhSubtotal
        let finalPaid = amtPaid !== undefined ? amtPaid : totalSeluruhSubtotal;
        let finalChange = amtChange !== undefined ? amtChange : 0;
        let finalDebt = amtDebt !== undefined ? amtDebt : 0;

        setHtml('print-dibayar', formatRp(finalPaid));
        setHtml('print-kembali', formatRp(finalChange));

        const rowHutang = document.getElementById('row-print-hutang');
        if(statusInv === 'partial' || finalDebt > 0) {
            setHtml('print-hutang', formatRp(finalDebt));
            rowHutang.style.display = 'table-row';
        } else {
            rowHutang.style.display = 'none';
        }

        // Tampilkan Nota -> Print -> Sembunyikan
        const notaEl = document.getElementById('nota-cetak');
        if (notaEl) {
            notaEl.style.display = 'block'; 
            setTimeout(() => {
                window.print();
                notaEl.style.display = 'none'; 
            }, 300);
        } else {
            console.error("Elemen #nota-cetak tidak ditemukan di halaman.");
        }
    }

    document.getElementById('cashierSearch').addEventListener('input', function(e) {
        const term = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('.patient-row');
        rows.forEach(row => {
            const name = row.querySelector('.patient-name').innerText.toLowerCase();
            const inv = row.querySelector('.invoice-number').innerText.toLowerCase();
            row.style.display = (name.includes(term) || inv.includes(term)) ? '' : 'none';
        });
    });
</script>
@endsection