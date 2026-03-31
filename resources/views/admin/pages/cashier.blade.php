@extends('admin.layout.admin')
@section('title', 'Kasir - HangLeKiu')

@section('navbar')
    @include('admin.components.navbar', ['title' => 'Kasir'])
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/pages/cashier.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/components/cashier/nota.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
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
                                    // 1. Ambil data billing (medical_procedure)
                                    $medicalProcedure = $apt->medicalProcedures->first(); 
                                    
                                    // 2. Kumpulkan semua nama tindakan dari procedure_item
                                    $listTindakan = [];
                                    if ($medicalProcedure && $medicalProcedure->items->count() > 0) {
                                        foreach ($medicalProcedure->items as $item) {
                                            if ($item->masterProcedure) {
                                                $listTindakan[] = $item->masterProcedure->procedure_name;
                                            }
                                        }
                                    }
                                    
                                    // 3. Gabungkan nama tindakan untuk parameter JS
                                    $tindakanDisplay = count($listTindakan) > 0 
                                        ? implode(', ', $listTindakan) 
                                        : 'Konsultasi/Pemeriksaan Umum';

                                    // 4. Ambil total tagihan
                                    $totalHarga = $medicalProcedure ? (float) $medicalProcedure->total_amount : 0;
                                    
                                    // 5. Buat Nomor Invoice
                                    $tglInvoice = \Carbon\Carbon::parse($apt->appointment_datetime)->format('Ymd');
                                    $invoiceNo = 'INV' . $tglInvoice . str_pad($apt->id, 3, '0', STR_PAD_LEFT);
                                    
                                    // 6. Ambil Nama Metode Bayar
                                    $metodeBayar = $apt->paymentMethod->name ?? 'Belum Ditentukan';
                                @endphp
                                
                                <tr id="row-{{ $apt->id }}" class="patient-row">
                                    {{-- Kolom Invoice --}}
                                    <td style="vertical-align: top; padding: 15px 10px;">
                                        <div class="invoice-date" style="font-size: 11px; color: #6B513E;">
                                            {{ \Carbon\Carbon::parse($apt->appointment_datetime)->format('d M Y') }}
                                        </div>
                                        <div class="invoice-number" style="font-weight: 800; color: #C58F59;">
                                            {{ $invoiceNo }}
                                        </div>
                                    </td>

                                    {{-- Kolom Nama Pasien --}}
                                    <td class="patient-name" style="vertical-align: top; padding: 15px 10px; font-weight: 700; color: #6B513E;">
                                        {{ $apt->patient->full_name ?? 'Pasien Tidak Dikenal' }}
                                    </td>

                                    {{-- Kolom Keterangan Medis --}}
                                    <td style="vertical-align: top; padding: 15px 10px;">
                                        <div class="keterangan-grid" style="display: grid; grid-template-columns: 120px 1fr; gap: 8px 12px; align-items: start;">
                                            {{-- Baris Dokter --}}
                                            <span class="ket-label" style="font-size: 11px; color: #6B513E; text-transform: uppercase; font-weight: 700; margin-top: 2px;">Dokter</span>
                                            <span class="ket-value" style="font-size: 13px; color: #6B513E; font-weight: 600;">
                                                {{ $apt->doctor->full_name ?? 'Dokter Klinik' }}
                                            </span>

                                            {{-- Baris Tindakan --}}
                                            <span class="ket-label" style="font-size: 11px; color: #6B513E; text-transform: uppercase; font-weight: 700; margin-top: 2px;">Tindakan</span>
                                            <div class="ket-value">
                                                @if(count($listTindakan) > 0)
                                                    <ul style="margin: 0; padding: 0; list-style: none; display: flex; flex-direction: column; gap: 4px;">
                                                        @foreach($listTindakan as $tindakan)
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

                                            {{-- Baris Metode --}}
                                            <span class="ket-label" style="font-size: 11px; color: #6B513E; text-transform: uppercase; font-weight: 700; margin-top: 4px;">Metode Bayar</span>
                                            <span class="ket-value">
                                                <span style="color: #C58F59; font-weight: 800; font-size: 11px; background: #fdfaf8; padding: 2px 10px; border-radius: 4px; border: 1px solid #f0e6dd; display: inline-block; letter-spacing: 0.5px;">
                                                    {{ strtoupper($metodeBayar) }}
                                                </span>
                                            </span>
                                        </div>
                                    </td>

                                    {{-- Kolom Action --}}
                                    <td style="vertical-align: top; text-align: center; padding: 15px 10px;" id="action-{{ $apt->id }}">
                                    @if($apt->status === 'succeed')
                                        @php
                                        $arrTindakan = []; $arrHarga = []; $arrQty = []; $arrSubtotal = []; $arrGigi = [];
                                        $medicalProcedure = $apt->medicalProcedures->first();

                                        // ====================================================================
                                        // 1. CARI DATA GIGI DARI ODONTOGRAM RECORD BERDASARKAN PASIEN & VISIT
                                        // ====================================================================
                                        $gigiStr = '-'; // Default jika tidak ada gigi
                                        
                                        // Cari record odontogram milik pasien ini di kunjungan (registrasi) ini
                                        $recordOdontogram = \Illuminate\Support\Facades\DB::table('odontogram_records')
                                            ->where('patient_id', $apt->patient_id)
                                            ->where('visit_id', $apt->id) // $apt->id adalah ID dari tabel registration
                                            ->orderBy('created_at', 'desc')
                                            ->first();

                                        if ($recordOdontogram) {
                                            // Jika record ketemu, ambil semua nomor gigi dari tabel odontogram_teeth
                                            $gigiList = \Illuminate\Support\Facades\DB::table('odontogram_teeth')
                                                ->where('odontogram_record_id', $recordOdontogram->id)
                                                ->pluck('tooth_number')
                                                ->toArray();
                                                
                                            if (count($gigiList) > 0) {
                                                // Gabungkan nomor gigi jadi satu string, misal: "11, 21, 44"
                                                $gigiStr = implode(', ', $gigiList);
                                            }
                                        }
                                        // ====================================================================

                                        // 2. MASUKKAN DATA TINDAKAN & GIGI KE DALAM ARRAY UNTUK MODAL
                                        if ($medicalProcedure && $medicalProcedure->items->count() > 0) {
                                            foreach ($medicalProcedure->items as $item) {
                                                $arrTindakan[] = $item->masterProcedure->procedure_name ?? 'Tindakan';
                                                $arrHarga[] = (float) $item->unit_price;
                                                $arrQty[] = (int) $item->quantity;
                                                $arrSubtotal[] = (float) $item->subtotal;
                                                
                                                // Masukkan data gigi yang sudah dicari di atas ke setiap baris tindakan
                                                $arrGigi[] = $gigiStr;
                                            }
                                        }

                                        // 3. DATA PASIEN
                                        $dataPasien = [
                                            'nama' => $apt->patient->full_name ?? '-',
                                            'id' => $apt->patient->medical_record_no ?? '-',
                                            'usia' => $apt->patient->date_of_birth ? \Carbon\Carbon::parse($apt->patient->date_of_birth)->age . ' Thn' : '-',
                                            'hp' => $apt->patient->phone_number ?? '-',
                                            'dokter' => $apt->doctor->full_name ?? '-'
                                        ];
                                        $tglInput = \Carbon\Carbon::parse($apt->appointment_datetime)->format('d-m-Y H:i').' WIB';
                                    @endphp

                            
                                    <div class="flex justify-center w-full">
                                        <button class="btn-bayar-tabel text-white bg-[#A67C52] px-4 py-2 rounded shadow-sm font-bold text-xs hover:bg-[#8e6a45] transition-colors flex items-center" 
                                            onclick='openPayment(
                                                "{{ $invoiceNo }}", 
                                                @json($dataPasien), 
                                                @json($arrTindakan), 
                                                @json($arrHarga), 
                                                @json($arrQty), 
                                                @json($arrSubtotal), 
                                                @json($arrGigi),
                                                "{{ $tglInput }}",
                                                "{{ $apt->id }}"
                                            )'>
                                            <i class="fa fa-wallet mr-1.5"></i> Bayar Sekarang
                                        </button>
                                    </div>

                                    @else
                                        <div class="flex items-center justify-center gap-2">
                                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full font-bold text-xs uppercase">Lunas</span>
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

@include('admin.components.cashier.modal-payment')
@include('admin.components.cashier.nota')

<script>
    let activeData = {};
    let currentGrandTotal = 0;

    function openPayment(inv, dataPasien, tindakanArray, pricesArray, qtyArray, subtotalArray, gigiArray, tanggalInput, appointmentId) {
        // Pastikan bentuknya array
        const listTindakan = Array.isArray(tindakanArray) ? tindakanArray : [];
        const listHarga = Array.isArray(pricesArray) ? pricesArray : [];
        const listQty = Array.isArray(qtyArray) ? qtyArray : [];
        const listSubtotal = Array.isArray(subtotalArray) ? subtotalArray : [];
        const listGigi = Array.isArray(gigiArray) ? gigiArray : [];

        // Simpan data ke variabel global untuk dipakai saat print nanti
        activeData = { 
            inv: inv, 
            appointmentId: appointmentId,
            nama: dataPasien.nama || '-',
            tindakan: listTindakan.length > 0 ? listTindakan.join(', ') : 'Konsultasi Umum',
            total: 0 // Akan diupdate di bawah
        };
        
        // Set Header Info Pasien
        document.getElementById('m-inv-no').innerText = inv;
        document.getElementById('m-pasien-nama').innerText = dataPasien.nama || '-';
        document.getElementById('m-pasien-id').innerText = dataPasien.id || '-';
        document.getElementById('m-pasien-usia').innerText = dataPasien.usia || '-';
        document.getElementById('m-pasien-hp').innerText = dataPasien.hp || '-';
        document.getElementById('m-pasien-dokter').innerText = dataPasien.dokter || '-';
        document.getElementById('m-input-pembayar').value = (dataPasien.nama || '') + ' (Pribadi)';

        // Render Tabel Tindakan
        let htmlItems = '';
        currentGrandTotal = 0;

        listTindakan.forEach((tindakan, index) => {
            const harga = parseFloat(listHarga[index]) || 0;
            const qty = parseInt(listQty[index]) || 1;
            const subtotal = parseFloat(listSubtotal[index]) || (harga * qty);
            
            // Cek index. Kalau baris pertama (index 0), tampilkan nomor gigi. Kalau baris kedua dst, kosongkan saja.
            const noGigi = (index === 0) ? (listGigi[index] || '-') : '-';
            
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
                            <input type="text" value="0" readonly class="w-16 border border-[#A67C52]/30 rounded p-1 text-xs text-right bg-white outline-none text-[#A67C52]/50 font-medium">
                        </div>
                    </td>
                    <td class="p-3 text-right text-[#A67C52] font-black">Rp${Number(subtotal).toLocaleString('id-ID')}</td>
                    <td class="p-3 text-center">
                        <button class="text-[#A67C52]/50 hover:text-red-500 transition-colors"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>`;
        });

        // Update Total
        activeData.total = currentGrandTotal;

        document.getElementById('m-items').innerHTML = htmlItems;
        document.getElementById('m-grand-total').innerText = 'Rp' + Number(currentGrandTotal).toLocaleString('id-ID');
        document.getElementById('m-input-bayar').value = currentGrandTotal; 
        
        // Kalau ada fungsi hitung kembalian
        if(typeof hitungKembalian === 'function') hitungKembalian(); 

        // Buka Modal
        document.getElementById('modalPayment').classList.remove('hidden');
        document.getElementById('modalPayment').style.display = 'flex';
    }

    // Fungsi Hitung Kembalian Otomatis
    function hitungKembalian() {
        let inputBayar = document.getElementById('m-input-bayar').value;
        // Bersihkan titik ribuan jika kasir mengetik manual (misal: 1.000.000 -> 1000000)
        inputBayar = inputBayar.replace(/\./g, '');
        let bayar = parseFloat(inputBayar) || 0;
        
        let kembalian = bayar - currentGrandTotal;
        let hutang = currentGrandTotal - bayar;

        // Tampilkan di UI
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
        
        // Ambil nominal yang diketik kasir dan hapus format titik
        const inputBayarRaw = document.getElementById('m-input-bayar').value.replace(/[^0-9]/g, '');
        const amountPaid = parseFloat(inputBayarRaw) || 0;
        
        // Validasi input
        if (amountPaid <= 0) {
            alert('Silakan masukkan jumlah uang yang diterima terlebih dahulu.');
            return;
        }
      
        // Ambil nilai dari textarea menggunakan ID
        const notes = document.getElementById('m-notes').value;

        // Ambil ID dari dropdown (Value di tag select metode pembayaran)
        const paymentMethodSelect = document.getElementById('m-metode');
        const paymentMethodName = paymentMethodSelect.options[paymentMethodSelect.selectedIndex].text;

        // Kalkulasi kembalian dan hutang
        let changeAmount = 0;
        let debtAmount = 0;

        if (amountPaid > currentGrandTotal) {
            changeAmount = amountPaid - currentGrandTotal;
        } else if (amountPaid < currentGrandTotal) {
            debtAmount = currentGrandTotal - amountPaid;
        }

        const originalText = btnSimpan.innerHTML;
        btnSimpan.innerHTML = '<i class="fa fa-spinner fa-spin text-lg"></i> Memproses...';
        btnSimpan.disabled = true;

        try {
            // Tembak request ke EmrController@storePayment
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
                    notes: notes
                }) 
            });

            const result = await response.json();

            if (result.success) {
                // 1. Tutup Modal
                closePayment();
                alert("✓ Pembayaran Berhasil Disimpan!\nNomor Invoice: " + result.invoice_number);
                
                // 2. Ubah Tampilan Baris Menjadi "Lunas" dan Tambah Tombol "Nota" (Tanpa Refresh)
                const actionCell = document.getElementById(`action-${appointmentId}`);
                if (actionCell) {
                    // Escape quotes untuk mencegah error syntax JS di atribut onclick
                    const safeName = activeData.nama.replace(/'/g, "\\'");
                    const safeTindakan = activeData.tindakan.replace(/'/g, "\\'");

                    actionCell.innerHTML = `
                        <div class="flex items-center justify-center gap-2">
                            <span class="badge-lunas-hijau">Lunas</span>
                            <button class="text-white bg-[#8e6a45] px-3 py-1.5 rounded shadow-sm font-bold text-xs hover:bg-[#7a5938] transition-colors flex items-center" 
                                onclick="prepareAndPrint('${result.invoice_number}', '${safeName}', '${safeTindakan}', ${activeData.total}, 0, '${paymentMethodName}')">
                                <i class="fa fa-print mr-1"></i> Nota
                            </button>
                        </div>`;
                }

                // 3. Otomatis Trigger Print Nota
                prepareAndPrint(result.invoice_number, activeData.nama, activeData.tindakan, activeData.total, 0, paymentMethodName);

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

    function prepareAndPrint(inv, nama, tindakan, total, disc, metode) {
        document.getElementById('print-invoice').innerText = inv;
        document.getElementById('print-nama').innerText = nama;
        document.getElementById('print-metode').innerText = metode;
        document.getElementById('print-total').innerText = "Rp " + Number(total).toLocaleString('id-ID');

        const itemContainer = document.getElementById('print-items-list');
        if (itemContainer) {
            itemContainer.innerHTML = `
            <tr>
                <td style="border: 1px solid #000; padding: 8px;">${tindakan}</td>
                <td style="border: 1px solid #000; padding: 8px; text-align: center;">1</td>
                <td style="border: 1px solid #000; padding: 8px; text-align: right;">${(Number(total) + Number(disc)).toLocaleString('id-ID')}</td>
                <td style="border: 1px solid #000; padding: 8px; text-align: right;">${Number(disc).toLocaleString('id-ID')}</td>
                <td style="border: 1px solid #000; padding: 8px; text-align: right; font-weight: bold;">${Number(total).toLocaleString('id-ID')}</td>
            </tr>`;
        }
        
        // Munculkan dialog print browser
        window.print();
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