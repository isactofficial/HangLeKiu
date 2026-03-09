@extends('admin.layout.admin')
@section('title', 'Kasir')

@section('navbar')
    @include('admin.components.navbar', ['title' => 'Kasir'])
@endsection

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

<style>
    /* ===== CASHIER PAGE ===== */

    /* Header */
    .cashier-header {
        margin-bottom: 20px;
    }

    .cashier-title {
        font-size: 30px; 
        font-weight: 700;
        color: #582C0C;
        margin: 0;
    }

    .cashier-subtitle {
        font-size: 18.75px;
        color: #C58F59;
    }

    /* Layout */
    .cashier-layout {
        display: flex;
        gap: 20px;
    }

    /* Tabs */
    .cashier-tabs {
        display: flex;
        flex-direction: column;
        min-width: 170px;
        background: white;
        border-radius: 12px;
        padding: 6px;
        box-shadow: 0 1px 3px rgba(88, 44, 12, 0.06);
        height: fit-content;
    }

    .cashier-tab {
        padding: 12px 16px;
        border: none;
        background: none;
        font-size: 13px;
        font-weight: 500;
        font-family: 'Instrument Sans', sans-serif;
        color: #6B513E;
        text-align: left;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .cashier-tab:hover {
        background: rgba(197, 143, 89, 0.08);
    }

    .cashier-tab.active {
        background: #C58F59;
        color: white;
        font-weight: 600;
    }

    /* Content */
    .cashier-content {
        flex: 1;
    }

    .cashier-tab-content {
        display: none;
    }

    .cashier-tab-content.active {
        display: block;
    }

    /* Toolbar */
    .cashier-toolbar {
        display: flex;
        gap: 12px;
        align-items: center;
        margin-bottom: 16px;
    }

    /* Search */
    .cashier-search {
        flex: 1;
        position: relative;
    }

    .cashier-search-input {
        width: 100%;
        padding: 12px 16px;
        padding-right: 44px;
        border: 1.5px solid #E5D6C5;
        border-radius: 8px;
        font-size: 13px;
        font-family: 'Instrument Sans', sans-serif;
        color: #582C0C;
        background: white;
        transition: border-color 0.2s;
    }

    .cashier-search-input::placeholder {
        color: #C58F59;
        opacity: 0.6;
    }

    .cashier-search-input:focus {
        outline: none;
        border-color: #C58F59;
    }

    .cashier-search-icon {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        width: 18px;
        height: 18px;
        color: #6B513E;
    }

    /* Buttons */
    .cashier-btn {
        padding: 12px 22px;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        font-family: 'Instrument Sans', sans-serif;
        cursor: pointer;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .cashier-btn-primary {
        background: #C58F59;
        color: white;
    }

    .cashier-btn-primary:hover {
        background: #b07d4a;
        box-shadow: 0 4px 12px rgba(197, 143, 89, 0.3);
    }

    .cashier-btn-success {
        background: #6B513E;
        color: white;
    }

    .cashier-btn-success:hover {
        background: #582C0C;
    }

    .cashier-btn-dark {
        background: #582C0C;
        color: white;
    }

    .cashier-btn-dark:hover {
        background: #3d1e08;
    }

    /* Date Filter */
    .cashier-filter {
        display: flex;
        gap: 16px;
        align-items: flex-end;
        margin-bottom: 20px;
    }

    .cashier-date-group {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .cashier-date-group label {
        font-size: 13px;
        color: #6B513E;
        font-weight: 500;
    }

    .cashier-date-input {
        padding: 10px 14px;
        border: 1.5px solid #E5D6C5;
        border-radius: 8px;
        font-size: 13px;
        font-family: 'Instrument Sans', sans-serif;
        color: #582C0C;
        background: white;
    }

    .cashier-date-input:focus {
        outline: none;
        border-color: #C58F59;
    }

    /* Table */
    .cashier-table-wrapper {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(88, 44, 12, 0.06);
    }

    .cashier-table {
        width: 100%;
        border-collapse: collapse;
    }

    .cashier-table thead {
        border-bottom: 2px solid #E5D6C5;
    }

    .cashier-table th {
        padding: 14px 18px;
        text-align: left;
        font-size: 13px;
        font-weight: 700;
        color: #582C0C;
        white-space: nowrap;
    }

    .cashier-table td {
        padding: 18px;
        font-size: 13px;
        color: #6B513E;
        vertical-align: top;
        border-bottom: 1px solid #f0ebe4;
    }

    .invoice-date {
        font-weight: 600;
        color: #582C0C;
    }

    .invoice-number {
        font-size: 13px;
        color: #C58F59;
        margin-top: 4px;
    }

    /* Keterangan grid */
    .keterangan-grid {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 6px 16px;
        min-width: 320px; /* Force spread to ensure table is scrollable */
    }

    .ket-label {
        font-weight: 600;
        color: #582C0C;
        white-space: nowrap;
    }

    .ket-value {
        color: #6B513E;
        line-height: 1.5;
    }

    /* Badge */
    .badge-lunas {
        display: inline-block;
        padding: 6px 16px;
        background: #C58F59;
        color: white;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 700;
    }

    /* Pagination */
    .cashier-pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 18px;
        background: white;
        border-radius: 0 0 12px 12px;
        border-top: 1px solid #f0ebe4;
    }

    .pagination-info {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #6B513E;
    }

    .pagination-select {
        padding: 4px 8px;
        border: 1px solid #E5D6C5;
        border-radius: 6px;
        font-size: 13px;
        font-family: 'Instrument Sans', sans-serif;
        color: #582C0C;
        background: white;
    }

    .pagination-count {
        margin-left: 16px;
        color: #582C0C;
        font-weight: 500;
    }

    .pagination-controls {
        display: flex;
        gap: 4px;
    }

    .pagination-btn {
        width: 32px;
        height: 32px;
        border: 1px solid #E5D6C5;
        border-radius: 6px;
        background: white;
        color: #6B513E;
        font-size: 13px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        font-family: 'Instrument Sans', sans-serif;
    }

    .pagination-btn:hover:not(:disabled) {
        background: rgba(197, 143, 89, 0.1);
        border-color: #C58F59;
    }

    .pagination-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .cashier-layout {
            flex-direction: column;
        }

        .cashier-tabs {
            flex-direction: row;
            min-width: 100%;
            justify-content: center;
            gap: 4px;
        }

        .cashier-tab {
            flex: 1;
            text-align: center;
            padding: 10px 12px;
            font-size: 13px;
            white-space: normal;
        }

        .cashier-toolbar {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }
        
        .cashier-toolbar .cashier-search,
        .cashier-toolbar .cashier-btn {
            width: 100%;
        }

        .cashier-filter {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }

        .cashier-filter .cashier-date-group {
            width: 100%;
        }

        .cashier-filter .cashier-btn {
            width: 100%;
        }

        .cashier-table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            width: 100%;
        }

        .cashier-table {
            min-width: 800px; /* Lebarkan sedikit supaya lebih jelas jadinya ada scroll */
        }

        .cashier-pagination {
            flex-direction: column;
            gap: 12px;
            align-items: center;
        }
    }
</style>

<script>
    function switchCashierTab(btn, tabId) {
        document.querySelectorAll('.cashier-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.cashier-tab-content').forEach(c => c.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('tab-' + tabId).classList.add('active');
    }
</script>
@endsection
