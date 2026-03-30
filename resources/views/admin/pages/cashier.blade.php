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
                                    // 1. Cek Medical Procedures secara aman agar tidak error "first() on null"
                                    $procedure = $apt->medicalProcedures ? $apt->medicalProcedures->first() : null;
                                    
                                    // 2. Ambil nama tindakan, jika kosong tampilkan default
                                    $tindakanNama = 'Konsultasi/Pemeriksaan Umum';
                                    if ($procedure && $procedure->items && $procedure->items->first() && $procedure->items->first()->masterProcedure) {
                                        $tindakanNama = $procedure->items->first()->masterProcedure->procedure_name;
                                    }

                                    // 3. Ambil total harga
                                    $totalHarga = $procedure ? $procedure->total_amount : 0;
                                    
                                    // 4. Format No Invoice unik
                                    $invoiceNo = 'INV' . date('Ymd', strtotime($apt->appointment_datetime)) . str_pad($apt->id, 3, '0', STR_PAD_LEFT);
                                @endphp
                                <tr id="row-{{ $apt->id }}" class="patient-row">
                                    <td>
                                        <div class="invoice-date">{{ \Carbon\Carbon::parse($apt->appointment_datetime)->format('d M Y') }}</div>
                                        <div class="invoice-number" style="font-weight: 800; color: #C58F59;">{{ $invoiceNo }}</div>
                                    </td>
                                    <td class="patient-name" style="font-weight: 700;">{{ $apt->patient->full_name ?? 'Pasien Tidak Dikenal' }}</td>
                                    <td>
                                        <div class="keterangan-grid">
                                            <span class="ket-label">Dokter</span>
                                            <span class="ket-value">{{ $apt->doctor->full_name ?? 'Dokter Klinik' }}</span>
                                            <span class="ket-label">Tindakan</span>
                                            <span class="ket-value">{{ $tindakanNama }}</span>
                                        </div>
                                    </td>
                                    <td style="text-align: center;" id="action-{{ $apt->id }}">
                                        @if($apt->status == 'succeed')
                                            <button class="btn-bayar-tabel" 
                                                onclick="openPayment('{{ $invoiceNo }}', '{{ addslashes($apt->patient->full_name ?? '-') }}', '{{ addslashes($tindakanNama) }}', {{ $totalHarga }}, '{{ $apt->id }}')">
                                                Bayar Sekarang
                                            </button>
                                        @else
                                            <div class="flex items-center justify-center">
                                                <span class="badge-lunas-hijau">Lunas</span>
                                                <button class="btn-print-cokelat" 
                                                    onclick="prepareAndPrint('{{ $invoiceNo }}', '{{ addslashes($apt->patient->full_name ?? '-') }}', '{{ addslashes($tindakanNama) }}', {{ $totalHarga }}, 0, 'Tunai')">
                                                    <i class="fa fa-print"></i> Nota
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

@include('admin.components.cashier.modal-payment')
@include('admin.components.cashier.nota')

<script>
    let activeData = {};

    function openPayment(inv, name, tindakan, price, appointmentId) {
        activeData = { inv, name, tindakan, price, appointmentId };
        
        document.getElementById('m-inv-no').innerText = inv;
        document.getElementById('m-bayar').value = price;
        
        document.getElementById('m-items').innerHTML = `
            <tr class="border-b">
                <td class="p-3 text-sm">${tindakan}</td>
                <td class="p-3 text-center text-sm">1</td>
                <td class="p-3 text-right text-sm">${Number(price).toLocaleString('id-ID')}</td>
                <td class="p-3 text-right text-sm">0</td>
                <td class="p-3 text-right text-sm font-bold">${Number(price).toLocaleString('id-ID')}</td>
            </tr>`;
            
        document.getElementById('modalPayment').classList.remove('hidden');
    }

    function closePayment() { 
        document.getElementById('modalPayment').classList.add('hidden'); 
    }

    async function prosesDone() {
        const appointmentId = activeData.appointmentId;
        const metode = document.getElementById('m-metode').value;
        const btnSimpan = document.querySelector('#modalPayment .btn-cokelat');

        btnSimpan.innerText = "Memproses...";
        btnSimpan.disabled = true;

        try {
            const response = await fetch(`/admin/appointments/${appointmentId}/status`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ status: 'finished' }) 
            });

            const result = await response.json();

            if (result.success) {
                const actionCell = document.getElementById(`action-${appointmentId}`);
                if (actionCell) {
                    actionCell.innerHTML = `
                        <div class="flex items-center justify-center">
                            <span class="badge-lunas-hijau">Lunas</span>
                            <button class="btn-print-cokelat" onclick="prepareAndPrint('${activeData.inv}', '${activeData.name}', '${activeData.tindakan}', ${activeData.price}, 0, '${metode}')">
                                <i class="fa fa-print"></i> Nota
                            </button>
                        </div>`;
                }
                closePayment();
                alert("✓ Pembayaran Berhasil Disimpan!");
            }
        } catch (error) {
            console.error(error);
            alert("Gagal memproses pembayaran.");
        } finally {
            btnSimpan.innerText = "SIMPAN PEMBAYARAN";
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