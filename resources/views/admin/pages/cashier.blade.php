@extends('admin.layout.admin')
@section('title', 'Kasir')

@section('navbar')
    @include('admin.components.navbar', ['title' => 'Kasir'])
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/pages/cashier.css') }}">
@endpush

@section('content')
{{-- Page Header --}}
<div class="cashier-header">
    <h1 class="cashier-title">Cashier</h1>
    <p class="cashier-subtitle">hanglekiu dental specialist</p>
</div>

{{-- Content Layout: Tabs + Main --}}
<div class="cashier-layout">
    {{-- Left Tabs --}}
    <div class="cashier-tabs">
        <button class="cashier-tab active" onclick="switchCashierTab(this, 'pembayaran')">Pembayaran</button>
        <button class="cashier-tab" onclick="switchCashierTab(this, 'hutang')">Hutang & Piutang</button>
    </div>

    {{-- Right Content --}}
    <div class="cashier-content">
        {{-- Tab: Pembayaran --}}
        <div class="cashier-tab-content active" id="tab-pembayaran">
            {{-- Toolbar --}}
            <div class="cashier-toolbar">
                <div class="cashier-search">
                    <input type="text" placeholder="Cari nama pasien, dokter atau invoice" class="cashier-search-input">
                    <svg class="cashier-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                    </svg>
                </div>
                <button class="cashier-btn cashier-btn-primary">+ Pembayaran</button>
                <button class="cashier-btn cashier-btn-success">Export</button>
            </div>

            {{-- Date Filter --}}
            <div class="cashier-filter">
                <div class="cashier-date-group">
                    <label>Dari Tanggal</label>
                    <input type="date" value="2026-02-25" class="cashier-date-input">
                </div>
                <div class="cashier-date-group">
                    <label>Sampai Tanggal</label>
                    <input type="date" value="2026-02-25" class="cashier-date-input">
                </div>
                <button class="cashier-btn cashier-btn-dark">FILTER</button>
            </div>

            {{-- Table --}}
            <div class="cashier-table-wrapper">
                <table class="cashier-table">
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Nama Lengkap Pasien</th>
                            <th>Keterangan</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="invoice-date">25 Februari 2026</div>
                                <div class="invoice-number">INV000294</div>
                            </td>
                            <td>Bpk Johndoe</td>
                            <td>
                                <div class="keterangan-grid">
                                    <span class="ket-label">Tenaga Medis</span>
                                    <span class="ket-value">drg. Budi Sp. Ortho</span>
                                    <span class="ket-label">Tindakan</span>
                                    <span class="ket-value">Pencetakan Alginat<br>Retainer Hawley</span>
                                    <span class="ket-label">Pembayaran</span>
                                    <span class="ket-value">Total Transaksi: Rp1.000.000<br>Pembulatan: Rp0<br>Total Dibayar: Rp1.000.000</span>
                                    <span class="ket-label">Metode Bayar</span>
                                    <span class="ket-value">Langsung - Transfer</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge-lunas">Lunas</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="cashier-pagination">
                <div class="pagination-info">
                    <span>Jumlah baris per halaman:</span>
                    <select class="pagination-select">
                        <option>5</option>
                        <option>10</option>
                        <option>25</option>
                    </select>
                    <span class="pagination-count">1-1 dari 1 data</span>
                </div>
                <div class="pagination-controls">
                    <button class="pagination-btn" disabled>|&lt;</button>
                    <button class="pagination-btn" disabled>&lt;</button>
                    <button class="pagination-btn" disabled>&gt;</button>
                    <button class="pagination-btn" disabled>&gt;|</button>
                </div>
            </div>
        </div>

        {{-- Tab: Hutang & Piutang --}}
        <div class="cashier-tab-content" id="tab-hutang">
            <div class="admin-card" style="padding: 40px; text-align: center;">
                <h3 style="font-size: 18.75px; font-weight: 700; color: #582C0C;">Hutang & Piutang</h3>
                <p style="font-size: 13px; color: #6B513E; margin-top: 8px;">Fitur hutang dan piutang. Halaman ini masih dalam pengembangan.</p>
            </div>
        </div>
    </div>
</div>
<script>
    function switchCashierTab(btn, tabId) {
        document.querySelectorAll('.cashier-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.cashier-tab-content').forEach(c => c.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('tab-' + tabId).classList.add('active');
    }
</script>
@endsection
