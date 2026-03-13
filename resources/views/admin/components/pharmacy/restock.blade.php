@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/pharmacy/restock.css') }}">
@endpush


<div class="apt-card">
    <div class="apt-card-header">
        <div>
            <h2 class="apt-card-title">Restock dan Return</h2>
            <p class="apt-card-subtitle">Last Create: 01/03/2026</p>
        </div>
        <div class="apt-card-actions">
            <div class="apt-search-box">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                <input type="text" placeholder="Cari kode / tanggal jatuh tempo">
            </div>
            <button class="apt-btn-primary">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                Restock Dan Return Obat / Barang
            </button>
            <button class="apt-btn-outline-icon" title="Cetak">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            </button>
        </div>
    </div>

    <div class="apt-table-wrapper">
        <table class="apt-table" style="min-width:1100px;">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>No Faktur</th>
                    <th>Jenis Pemesanan</th>
                    <th>Tanggal Pengiriman</th>
                    <th>Tanggal Pembuatan</th>
                    <th>Supplier</th>
                    <th>Nama Obat</th>
                    <th>Jumlah</th>
                    <th>Diapprove oleh</th>
                    <th>Total Harga</th>
                    <th>Tempo Pembayaran</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>RST-001</td>
                    <td>INV-2026-0301</td>
                    <td>Restock</td>
                    <td>03/03/2026</td>
                    <td>01/03/2026</td>
                    <td>PT. Kimia Farma</td>
                    <td>Amoxicillin 500mg</td>
                    <td>200</td>
                    <td>apt. Sari</td>
                    <td>Rp 640.000</td>
                    <td>30 hari</td>
                    <td><button class="apt-btn-sm">Detail</button></td>
                </tr>
                <tr>
                    <td>RST-002</td>
                    <td>INV-2026-0302</td>
                    <td>Restock</td>
                    <td>04/03/2026</td>
                    <td>02/03/2026</td>
                    <td>PT. Kalbe Farma</td>
                    <td>Paracetamol 500mg</td>
                    <td>500</td>
                    <td>apt. Sari</td>
                    <td>Rp 550.000</td>
                    <td>14 hari</td>
                    <td><button class="apt-btn-sm">Detail</button></td>
                </tr>
                <tr>
                    <td>RST-003</td>
                    <td>INV-2026-0303</td>
                    <td>Return</td>
                    <td>05/03/2026</td>
                    <td>03/03/2026</td>
                    <td>PT. Guardian Pharma</td>
                    <td>Chlorhexidine 0.2%</td>
                    <td>10</td>
                    <td>apt. Sari</td>
                    <td>Rp 110.000</td>
                    <td>0 hari</td>
                    <td><button class="apt-btn-sm">Detail</button></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="apt-pagination">
        <div class="apt-page-size">Jumlah baris per halaman: <select><option>5</option><option>10</option><option>25</option></select></div>
        <div class="apt-page-info">1–3 dari 3 data</div>
        <div class="apt-page-controls">
            <button class="apt-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 17l-5-5 5-5M18 17l-5-5 5-5"/></svg></button>
            <button class="apt-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg></button>
            <button class="apt-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg></button>
            <button class="apt-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M13 17l5-5-5-5M6 17l5-5-5-5"/></svg></button>
        </div>
    </div>
</div>
