@extends('admin.layout.admin')
@section('title', 'Kasir - HangLeKiu')

@section('navbar')
    @include('admin.components.navbar', ['title' => 'Kasir'])
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/pages/cashier.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/pages/cashier-mobile.css') }}">
    <style>
        /* Modal Overlay — sama persis dengan obat.css */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: opacity 300ms ease, visibility 300ms ease;
        }
        .modal-overlay.open {
            opacity: 1;
            visibility: visible;
        }
        .modal-container {
            transform: scale(0.95);
            transition: transform 300ms ease;
        }
        .modal-overlay.open .modal-container {
            transform: scale(1);
        }
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
            .no-print,
            .modal-overlay {
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
        <div class="cashier-content">
            <div class="cashier-tab-content active">
                {{-- Toolbar --}}
                <div class="cashier-toolbar">
                    <div class="cashier-search" style="display: flex; gap: 12px; align-items: center; flex: 1;">
                        <input type="text" placeholder="Cari invoice atau pasien..." class="cashier-search-input" id="cashierSearch" style="flex: 1;">
                        <div style="display: flex; gap: 8px; align-items: center;">
                            <label style="font-size: 12px; color: #6B513E; white-space: nowrap;">Dari:</label>
                            <input type="date" id="filterFromDate" style="padding: 8px 12px; border: 1.5px solid #E5D6C5; border-radius: 6px; font-size: 12px; font-family: 'Instrument Sans', sans-serif; color: #582C0C;">
                        </div>
                        <div style="display: flex; gap: 8px; align-items: center;">
                            <label style="font-size: 12px; color: #6B513E; white-space: nowrap;">Sampai:</label>
                            <input type="date" id="filterToDate" style="padding: 8px 12px; border: 1.5px solid #E5D6C5; border-radius: 6px; font-size: 12px; font-family: 'Instrument Sans', sans-serif; color: #582C0C;">
                        </div>
                        <button class="cashier-btn btn-cokelat" style="padding: 8px 14px; font-size: 12px;" onclick="resetFilters()">Reset</button>
                    </div>
                    <button class="cashier-btn btn-cokelat" onclick="openModalManual()">+ Pembayaran Manual</button>
                    <button class="cashier-btn cashier-btn-success" id="btnExportCsv" onclick="exportCashierCsv()">
                        <i class="fas fa-file-csv"></i> Export CSV
                    </button>
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
                                            <button class="flex items-center justify-center gap-2 px-4 py-2 text-xs font-bold text-white transition-colors bg-[#8e6a45] border-2 border-[#8e6a45] rounded shadow-sm hover:bg-[#7a5938] hover:border-[#7a5938]" 
                                            onclick='prepareAndPrint(
                                                @json($invoiceNo), 
                                                @json($apt->patient->full_name ?? "Pasien"), 
                                                @json($apt->doctor->full_name ?? "-"), 
                                                @json($arrTindakan), 
                                                @json($arrHarga), 
                                                @json($arrQty), 
                                                @json($arrDiskon), 
                                                @json($arrSubtotal), 
                                                @json($arrGigi), 
                                                @json($metodeBayar), 
                                                @json($tglInputStr), 
                                                @json($catatanInvoice), 
                                                @json($invoiceStatus), 
                                                {{ $amtPaid }}, 
                                                {{ $amtChange }}, 
                                                {{ $amtDebt }}
                                            )'
                                        >
                                            <i class="fa fa-print"></i> Nota
                                        </button>
                                        </div>
                                    @elseif($apt->status === 'succeed')
                                        {{-- JIKA BELUM ADA DI TABEL INVOICE SAMA SEKALI --}}
                                        <div class="flex justify-center w-full">
                                            <button class="btn-bayar-tabel text-white bg-[#A67C52] px-4 py-2 rounded shadow-sm font-bold text-xs hover:bg-[#8e6a45] transition-colors flex items-center gap-2" 
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
                                                <i class="fa fa-wallet"></i> Bayar Sekarang
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

                {{-- Pagination Controls --}}
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 16px; padding: 16px; background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(88, 44, 12, 0.06);">
                    <button class="cashier-btn btn-cokelat" id="pagination-prev-btn" onclick="previousPage()" style="padding: 10px 18px; font-size: 12px;">← Sebelumnya</button>
                    <span id="pagination-info" style="font-size: 12px; color: #6B513E; font-weight: 600;">Halaman 1 • 0 data</span>
                    <button class="cashier-btn btn-cokelat" id="pagination-next-btn" onclick="nextPage()" style="padding: 10px 18px; font-size: 12px;">Berikutnya →</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- INCLUDE PENTING! MEMANGGIL MODAL --}}
@include('admin.components.cashier.modal-payment')
@include('admin.components.cashier.modal-payment-manual')
@include('admin.components.cashier.nota')


<script>
    let activeData = {};
    let currentGrandTotal = 0;

    try {
        localStorage.removeItem('cashier_attention_pending');
        localStorage.removeItem('cashier_attention_count');
        window.dispatchEvent(new Event('cashierAttentionChanged'));
    } catch (e) {
        console.warn('Gagal sinkronisasi badge cashier:', e);
    }

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
                <tr style="border-bottom:1px solid #f0ebe4;">
                    <td style="padding:8px 10px; font-size:12px; color:#6b7280; white-space:nowrap;">${tanggalInput}</td>
                    <td style="padding:8px 10px; font-size:12px; color:#374151; font-weight:500;">${tindakan}</td>
                    <td style="padding:8px 10px; text-align:center; font-size:12px; color:#8B5E3C; font-weight:700;">${noGigi}</td>
                    <td style="padding:8px 10px; text-align:center;">
                        <div style="border:1px solid #e5e7eb; border-radius:4px; padding:3px 8px; display:inline-block; min-width:28px; text-align:center; font-size:12px; color:#374151;">${qty}</div>
                    </td>
                    <td style="padding:8px 10px; text-align:right; font-size:12px; color:#6b7280;">Rp${Number(harga).toLocaleString('id-ID')}</td>
                    <td style="padding:8px 10px; text-align:right;">
                        <div style="border:1px solid #e5e7eb; border-radius:4px; padding:3px 8px; display:inline-block; min-width:40px; text-align:right; font-size:12px; color:#9ca3af;">${Number(diskon).toLocaleString('id-ID')}</div>
                    </td>
                    <td style="padding:8px 10px; text-align:right; font-size:12px; color:#8B5E3C; font-weight:700;">Rp${Number(subtotal).toLocaleString('id-ID')}</td>
                    <td style="padding:8px 10px; text-align:center;">
                        <button style="background:none; border:none; cursor:pointer; color:#d1d5db; font-size:13px;" onclick=""><i class="fa fa-trash"></i></button>
                    </td>
                </tr>`;
        });

        activeData.total = currentGrandTotal;

        document.getElementById('m-items').innerHTML = htmlItems;
        document.getElementById('m-grand-total').innerText = 'Rp' + Number(currentGrandTotal).toLocaleString('id-ID');
        document.getElementById('m-input-bayar').value = currentGrandTotal; 
        
        if(typeof hitungKembalian === 'function') hitungKembalian(); 

        const modal = document.getElementById('modalPayment');
        modal.classList.add('open');
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
        document.getElementById('modalPayment').classList.remove('open');
    }

    // ─── HAPUS ITEM DARI TABEL MODAL ────────────────────────────────
    function hapusItemModal(index) {
        activeData.tindakanArray.splice(index, 1);
        activeData.pricesArray.splice(index, 1);
        activeData.qtyArray.splice(index, 1);
        activeData.diskonArray.splice(index, 1);
        activeData.subtotalArray.splice(index, 1);
        activeData.gigiArray.splice(index, 1);
        recalcTableFromActiveData();
    }

    function recalcTableFromActiveData() {
        let htmlItems = '';
        currentGrandTotal = 0;

        activeData.tindakanArray.forEach((tindakan, index) => {
            const harga    = parseFloat(activeData.pricesArray[index])   || 0;
            const qty      = parseInt(activeData.qtyArray[index])        || 1;
            const diskon   = parseFloat(activeData.diskonArray[index])   || 0;
            const subtotal = parseFloat(activeData.subtotalArray[index]) || 0;
            const noGigi   = (index === 0 && activeData.gigiArray[0] && activeData.gigiArray[0] !== '-') ? activeData.gigiArray[0] : '-';
            currentGrandTotal += subtotal;

            htmlItems += `
                <tr style="border-bottom:1px solid #f0ebe4;">
                    <td style="padding:8px 10px; font-size:12px; color:#6b7280; white-space:nowrap;">${activeData.tglInput}</td>
                    <td style="padding:8px 10px; font-size:12px; color:#374151; font-weight:500;">${tindakan}</td>
                    <td style="padding:8px 10px; text-align:center; font-size:12px; color:#8B5E3C; font-weight:700;">${noGigi}</td>
                    <td style="padding:8px 10px; text-align:center;">
                        <div style="border:1px solid #e5e7eb; border-radius:4px; padding:3px 8px; display:inline-block; min-width:28px; text-align:center; font-size:12px; color:#374151;">${qty}</div>
                    </td>
                    <td style="padding:8px 10px; text-align:right; font-size:12px; color:#6b7280;">Rp${Number(harga).toLocaleString('id-ID')}</td>
                    <td style="padding:8px 10px; text-align:right;">
                        <div style="border:1px solid #e5e7eb; border-radius:4px; padding:3px 8px; display:inline-block; min-width:40px; text-align:right; font-size:12px; color:#9ca3af;">${Number(diskon).toLocaleString('id-ID')}</div>
                    </td>
                    <td style="padding:8px 10px; text-align:right; font-size:12px; color:#8B5E3C; font-weight:700;">Rp${Number(subtotal).toLocaleString('id-ID')}</td>
                    <td style="padding:8px 10px; text-align:center;">
                        <button style="background:none; border:none; cursor:pointer; color:#d1d5db; font-size:13px;" onclick="hapusItemModal(${index})"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>`;
        });

        activeData.total = currentGrandTotal;
        document.getElementById('m-items').innerHTML = htmlItems || '<tr><td colspan="8" style="text-align:center;padding:16px;color:#9ca3af;">Tidak ada item.</td></tr>';
        document.getElementById('m-grand-total').innerText = 'Rp' + Number(currentGrandTotal).toLocaleString('id-ID');
        document.getElementById('m-input-bayar').value = currentGrandTotal;
        hitungKembalian();
    }

    function doPrintPreview() {
        if (!activeData || !activeData.inv) return;
        const showDetail = document.getElementById('m-cb-detail')?.checked !== false;
        const metodeText = document.getElementById('m-metode')?.options[document.getElementById('m-metode')?.selectedIndex]?.text || 'Tunai';
        const notesText = document.getElementById('m-notes')?.value || '-';

        // Tutup modal dulu agar tidak mengganggu rendering print
        closePayment();

        // Beri waktu agar animasi close modal selesai, baru panggil print
        setTimeout(() => {
            prepareAndPrint(
                activeData.inv,
                activeData.nama,
                activeData.dokter,
                showDetail ? activeData.tindakanArray : [],
                showDetail ? activeData.pricesArray   : [],
                showDetail ? activeData.qtyArray       : [],
                showDetail ? activeData.diskonArray    : [],
                showDetail ? activeData.subtotalArray  : [],
                showDetail ? activeData.gigiArray      : [],
                metodeText,
                activeData.tglInput,
                notesText,
                'unpaid', 0, 0, 0
            );
        }, 350);
    }

    async function prosesDone() {
        const appointmentId = activeData.appointmentId;
        const btnSimpan = document.querySelector('button[onclick="prosesDone()"]');
        
        const inputBayarRaw = document.getElementById('m-input-bayar').value.replace(/[^0-9]/g, '');
        const amountPaid = parseFloat(inputBayarRaw) || 0;
        
        if (amountPaid <= 0) {
            showWarningPopup('Silakan masukkan nominal uang yang diterima terlebih dahulu.');
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
                    payment_method:  paymentMethodName,
                    payment_type:    document.getElementById('m-tipe')?.value || 'Langsung',
                    cash_account:    document.getElementById('m-akun-kas')?.value || 'Kas Utama Klinik',
                    amount_paid:     amountPaid,
                    change_amount:   changeAmount,
                    debt_amount:     debtAmount,
                    status:          statusKasir, 
                    notes:           notes
                }) 
            });

            const result = await response.json();

            if (result.success) {
                closePayment();

                showSuccessPopup("Pembayaran Berhasil Disimpan!<br>Nomor Invoice: <b>" + result.invoice_number + "</b>", function() {
                    const showDetail = document.getElementById('m-cb-detail')?.checked !== false;
                    
                    // Auto-reload halaman SETELAH print dialog ditutup oleh user
                    // Aman karena modal sudah ditutup (closePayment) dan CSS print 
                    // sudah menambahkan .modal-overlay { display: none !important }
                    window.onafterprint = function() {
                        window.location.reload();
                    };

                    prepareAndPrint(
                        result.invoice_number,
                        activeData.nama,
                        activeData.dokter,
                        showDetail ? activeData.tindakanArray : [],
                        showDetail ? activeData.pricesArray   : [],
                        showDetail ? activeData.qtyArray       : [],
                        showDetail ? activeData.diskonArray    : [],
                        showDetail ? activeData.subtotalArray  : [],
                        showDetail ? activeData.gigiArray      : [],
                        paymentMethodName,
                        activeData.tglInput,
                        notes,
                        statusKasir,
                        amountPaid,
                        changeAmount,
                        debtAmount
                    );
                });

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

    function showSuccessPopup(message, callback) {
        const overlay = document.createElement('div');
        overlay.className = 'modal-overlay open';
        overlay.style.zIndex = '10000';
        
        const container = document.createElement('div');
        container.className = 'modal-container';
        container.style.background = '#fff';
        container.style.borderRadius = '10px';
        container.style.padding = '30px 24px';
        container.style.maxWidth = '360px';
        container.style.textAlign = 'center';
        container.style.boxShadow = '0 20px 60px rgba(0,0,0,0.25)';
        
        const icon = document.createElement('div');
        icon.innerHTML = '<i class="fa fa-check-circle"></i>';
        icon.style.fontSize = '50px';
        icon.style.color = '#15803d'; // Green
        icon.style.marginBottom = '16px';
        
        const text = document.createElement('p');
        text.innerHTML = message;
        text.style.fontSize = '14px';
        text.style.color = '#374151';
        text.style.marginBottom = '26px';
        text.style.lineHeight = '1.5';
        
        const btn = document.createElement('button');
        btn.innerHTML = '<i class="fa fa-print" style="margin-right:6px;"></i> Cetak Nota & Selesai';
        btn.style.background = '#8B5E3C';
        btn.style.color = '#fff';
        btn.style.border = 'none';
        btn.style.padding = '10px 24px';
        btn.style.borderRadius = '6px';
        btn.style.fontSize = '13px';
        btn.style.fontWeight = '700';
        btn.style.cursor = 'pointer';
        btn.style.width = '100%';
        btn.style.transition = 'background 0.2s';
        
        btn.onmouseover = () => btn.style.background = '#7a5234';
        btn.onmouseout = () => btn.style.background = '#8B5E3C';
        
        btn.onclick = () => {
            document.body.removeChild(overlay);
            if (callback) callback();
        };
        
        container.appendChild(icon);
        container.appendChild(text);
        container.appendChild(btn);
        overlay.appendChild(container);
        document.body.appendChild(overlay);
    }

    function showWarningPopup(message) {
        const overlay = document.createElement('div');
        overlay.className = 'modal-overlay open';
        overlay.style.zIndex = '10000';
        
        const container = document.createElement('div');
        container.className = 'modal-container';
        container.style.background = '#fff';
        container.style.borderRadius = '10px';
        container.style.padding = '30px 24px';
        container.style.maxWidth = '360px';
        container.style.textAlign = 'center';
        container.style.boxShadow = '0 20px 60px rgba(0,0,0,0.25)';
        
        const icon = document.createElement('div');
        icon.innerHTML = '<i class="fa fa-exclamation-triangle"></i>';
        icon.style.fontSize = '50px';
        icon.style.color = '#C58F59';
        icon.style.marginBottom = '16px';
        
        const text = document.createElement('p');
        text.innerHTML = message;
        text.style.fontSize = '14px';
        text.style.color = '#374151';
        text.style.marginBottom = '26px';
        text.style.lineHeight = '1.5';
        
        const btn = document.createElement('button');
        btn.innerHTML = 'Mengerti';
        btn.style.background = '#8B5E3C';
        btn.style.color = '#fff';
        btn.style.border = 'none';
        btn.style.padding = '10px 24px';
        btn.style.borderRadius = '6px';
        btn.style.fontSize = '13px';
        btn.style.fontWeight = '700';
        btn.style.cursor = 'pointer';
        btn.style.width = '100%';
        btn.style.transition = 'background 0.2s';
        
        btn.onmouseover = () => btn.style.background = '#7a5234';
        btn.onmouseout = () => btn.style.background = '#8B5E3C';
        
        btn.onclick = () => {
            document.body.removeChild(overlay);
        };
        
        container.appendChild(icon);
        container.appendChild(text);
        container.appendChild(btn);
        overlay.appendChild(container);
        document.body.appendChild(overlay);
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
        applyCashierFilters();
    });

    document.getElementById('filterFromDate').addEventListener('change', function(e) {
        applyCashierFilters();
    });

    document.getElementById('filterToDate').addEventListener('change', function(e) {
        applyCashierFilters();
    });

    // ──── PAGINATION & FILTER ────────────────────
    const CASHIER_PAGE_SIZE = 10;
    let currentCashierPage = 1;
    let allPatientRows = [];

    function applyCashierFilters() {
        const searchTerm = document.getElementById('cashierSearch').value.toLowerCase();
        const fromDate = document.getElementById('filterFromDate').value;
        const toDate = document.getElementById('filterToDate').value;

        const allRows = document.querySelectorAll('.patient-row');
        allPatientRows = [];

        allRows.forEach(row => {
            const name = row.querySelector('.patient-name').innerText.toLowerCase();
            const inv = row.querySelector('.invoice-number').innerText.toLowerCase();
            const dateStr = row.querySelector('.invoice-date').innerText.trim();
            
            // Parse tanggal dari format "dd MMM yyyy" menjadi comparable format
            const rowDate = parseIndonesianDate(dateStr);
            
            // Check search term
            const matchesSearch = name.includes(searchTerm) || inv.includes(searchTerm);
            
            // Check date range
            let matchesDateRange = true;
            if (fromDate || toDate) {
                const fromDateObj = fromDate ? new Date(fromDate) : null;
                const toDateObj = toDate ? new Date(toDate) : null;
                
                if (rowDate) {
                    if (fromDateObj && rowDate < fromDateObj) matchesDateRange = false;
                    if (toDateObj) {
                        // Add 1 day untuk include hari terakhir
                        toDateObj.setDate(toDateObj.getDate() + 1);
                        if (rowDate >= toDateObj) matchesDateRange = false;
                    }
                }
            }

            if (matchesSearch && matchesDateRange) {
                allPatientRows.push(row);
            }
        });

        currentCashierPage = 1;
        applyCashierPagination();
    }

    function parseIndonesianDate(dateStr) {
        // Format: "02 Mar 2025" atau "2 Mar 2025"
        const months = {
            'Jan': '01', 'Feb': '02', 'Mar': '03', 'Apr': '04', 'May': '05', 'Jun': '06',
            'Jul': '07', 'Aug': '08', 'Sep': '09', 'Oct': '10', 'Nov': '11', 'Dec': '12'
        };
        
        const parts = dateStr.split(' ');
        if (parts.length === 3) {
            const day = parts[0].padStart(2, '0');
            const month = months[parts[1]] || '01';
            const year = parts[2];
            return new Date(`${year}-${month}-${day}`);
        }
        return null;
    }

    function applyCashierPagination() {
        const totalRows = allPatientRows.length;
        const totalPages = Math.ceil(totalRows / CASHIER_PAGE_SIZE);
        
        // Validasi current page
        if (currentCashierPage > totalPages) currentCashierPage = totalPages || 1;
        if (currentCashierPage < 1) currentCashierPage = 1;

        const startIdx = (currentCashierPage - 1) * CASHIER_PAGE_SIZE;
        const endIdx = startIdx + CASHIER_PAGE_SIZE;

        // Sembunyikan semua row
        document.querySelectorAll('.patient-row').forEach(row => {
            row.style.display = 'none';
        });

        // Tampilkan hanya row di halaman ini
        allPatientRows.slice(startIdx, endIdx).forEach(row => {
            row.style.display = '';
        });

        // Update pagination info
        const infoText = totalRows === 0 
            ? 'Tidak ada data' 
            : `Halaman ${currentCashierPage} dari ${totalPages} • ${totalRows} data`;
        document.getElementById('pagination-info').innerText = infoText;

        // Update button states
        document.getElementById('pagination-prev-btn').disabled = currentCashierPage === 1;
        document.getElementById('pagination-next-btn').disabled = currentCashierPage === totalPages || totalPages === 0;

        // Styling untuk disabled buttons
        const prevBtn = document.getElementById('pagination-prev-btn');
        const nextBtn = document.getElementById('pagination-next-btn');
        prevBtn.style.opacity = prevBtn.disabled ? '0.5' : '1';
        prevBtn.style.cursor = prevBtn.disabled ? 'not-allowed' : 'pointer';
        nextBtn.style.opacity = nextBtn.disabled ? '0.5' : '1';
        nextBtn.style.cursor = nextBtn.disabled ? 'not-allowed' : 'pointer';
    }

    function previousPage() {
        if (currentCashierPage > 1) {
            currentCashierPage--;
            applyCashierPagination();
        }
    }

    function nextPage() {
        const totalRows = allPatientRows.length;
        const totalPages = Math.ceil(totalRows / CASHIER_PAGE_SIZE) || 1;
        if (currentCashierPage < totalPages) {
            currentCashierPage++;
            applyCashierPagination();
        }
    }

    function resetFilters() {
        document.getElementById('cashierSearch').value = '';
        document.getElementById('filterFromDate').value = '';
        document.getElementById('filterToDate').value = '';
        applyCashierFilters();
    }

    // ──── EXPORT CSV ─────────────────────────────
    function exportCashierCsv() {
        const searchTerm = document.getElementById('cashierSearch').value;
        const fromDate = document.getElementById('filterFromDate').value;
        const toDate = document.getElementById('filterToDate').value;

        // Gunakan parameter URL untuk GET Request ke endpoint export CSV
        let url = '{{ route("admin.cashier.exportCsv") }}?';
        const params = new URLSearchParams();
        if (searchTerm) params.append('q', searchTerm);
        if (fromDate) params.append('from_date', fromDate);
        if (toDate) params.append('to_date', toDate);

        // Download by setting window.location
        window.location.href = url + params.toString();
    }

    // INIT: Load semua rows on page load
    window.addEventListener('load', function() {
        applyCashierFilters();
    });
</script>
@endsection