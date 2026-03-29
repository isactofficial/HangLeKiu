@extends('admin.layout.admin')
@section('title', 'Kasir - HangLeKiu')

@section('navbar')
    @include('admin.components.navbar', ['title' => 'Kasir'])
@endsection

@push('styles')
    {{-- Memanggil file CSS yang sudah dipisah --}}
    <link rel="stylesheet" href="{{ asset('css/admin/pages/cashier.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/components/cashier/nota.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
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
                        <input type="text" placeholder="Cari invoice atau pasien..." class="cashier-search-input">
                    </div>
                    <button class="cashier-btn btn-cokelat">+ Pembayaran</button>
                    <button class="cashier-btn cashier-btn-success">Export</button>
                </div>

                {{-- Tabel --}}
                <div class="cashier-table-wrapper">
                    <table class="cashier-table">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Nama Lengkap Pasien</th>
                                <th>Keterangan</th>
                                <th style="text-align: center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="cashier-tbody">
                            {{-- State: Belum Bayar --}}
                            <tr id="row-inv-315">
                                <td>
                                    <div class="invoice-date">13 Maret 2026</div>
                                    <div class="invoice-number">INV000315</div>
                                </td>
                                <td>Rameyza Alya S</td>
                                <td>
                                    <div class="keterangan-grid">
                                        <span class="ket-label">Tenaga Medis</span>
                                        <span class="ket-value">drg. Ria Budiati Sp. Ortho</span>
                                        <span class="ket-label">Tindakan</span>
                                        <span class="ket-value">Kontrol Ortho MBT Ria Medianto</span>
                                    </div>
                                </td>
                                <td style="text-align: center;" id="action-inv-315">
                                    <button class="btn-bayar-tabel" onclick="openPayment('INV000315', 'Rameyza Alya S', 'Kontrol Ortho MBT', 350000)">Bayar</button>
                                </td>
                            </tr>

                            {{-- State: Sudah Lunas (Data Dummy) --}}
                            <tr id="row-inv-316">
                                <td>
                                    <div class="invoice-date">13 Maret 2026</div>
                                    <div class="invoice-number">INV000316</div>
                                </td>
                                <td>Kama</td>
                                <td>
                                    <div class="keterangan-grid">
                                        <span class="ket-label">Tenaga Medis</span>
                                        <span class="ket-value">drg. Ria Budiati Sp. Ortho</span>
                                        <span class="ket-label">Tindakan</span>
                                        <span class="ket-value">Restorasi Komposit Posterior Kecil</span>
                                    </div>
                                </td>
                                <td style="text-align: center;">
                                    <div class="flex items-center justify-center">
                                        <span class="badge-lunas-hijau">Lunas</span>
                                        <button class="btn-print-cokelat" onclick="prepareAndPrint('INV000316', 'Kama', 'Restorasi Komposit...', 600000, 0, 'Debit')">Print Nota</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Memanggil komponen Modal & Nota --}}
@include('admin.components.cashier.modal-payment')
@include('admin.components.cashier.nota')

<script>
    let activeData = {};

    function openPayment(inv, name, tindakan, price) {
        activeData = { inv, name, tindakan, price };
        document.getElementById('m-inv-no').innerText = inv;
        document.getElementById('m-bayar').value = price;
        document.getElementById('m-items').innerHTML = `
            <tr class="border-b">
                <td class="p-2">${tindakan}</td>
                <td class="p-2 text-center">1</td>
                <td class="p-2 text-right">${price.toLocaleString('id-ID')}</td>
                <td class="p-2 text-right">0</td>
                <td class="p-2 text-right font-bold">${price.toLocaleString('id-ID')}</td>
            </tr>`;
        document.getElementById('modalPayment').classList.remove('hidden');
    }

    function closePayment() { document.getElementById('modalPayment').classList.add('hidden'); }

    function prosesDone() {
        const metode = document.getElementById('m-metode').value;
        const finalPrice = document.getElementById('m-bayar').value;
        const finalDisc = document.getElementById('m-disc').value;

        const invoiceNumber = activeData.inv.match(/INV0*(\d+)/i)?.[1] || activeData.inv;
        const actionID = `action-inv-${invoiceNumber}`;
        const actionCell = document.getElementById(actionID);

        if (actionCell) {
            actionCell.innerHTML = `
                <div class="flex items-center justify-center">
                    <span class="badge-lunas-hijau">Lunas</span>
                    <button class="btn-print-cokelat" onclick="prepareAndPrint('${activeData.inv}', '${activeData.name}', '${activeData.tindakan}', ${finalPrice}, ${finalDisc}, '${metode}')">Print Nota</button>
                </div>`;
        }
        closePayment();
    }

    function prepareAndPrint(inv, nama, tindakan, total, disc, metode) {
        document.getElementById('print-invoice').innerText = inv;
        document.getElementById('print-nama').innerText = nama;
        document.getElementById('print-metode').innerText = metode;
        document.getElementById('print-total').innerText = Number(total).toLocaleString('id-ID');

        const itemContainer = document.getElementById('print-items-list');
        if (itemContainer) {
            itemContainer.innerHTML = `
            <tr>
                <td style="border: 1px solid #000; padding: 5px;">${tindakan}</td>
                <td style="border: 1px solid #000; padding: 5px; text-align: center;">1</td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right;">${(Number(total) + Number(disc)).toLocaleString('id-ID')}</td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right;">${Number(disc).toLocaleString('id-ID')}</td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right; font-weight: bold;">${Number(total).toLocaleString('id-ID')}</td>
            </tr>`;
        }
        window.print();
    }
</script>
@endsection