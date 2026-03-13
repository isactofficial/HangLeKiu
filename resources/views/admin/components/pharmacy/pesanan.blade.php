@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/pharmacy/pesanan.css') }}">
@endpush


<div class="apt-card">
    <div class="apt-card-header">
        <h2 class="apt-card-title">Pesanan & Stok Masuk</h2>
        <div class="apt-search-box">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            <input type="text" placeholder="Cari nama obat, kode transaksi atau jenis transaksi">
        </div>
    </div>

    <div class="apt-table-wrapper">
        <table class="apt-table" style="min-width:900px;">
            <thead>
                <tr>
                    <th>Kode Transaksi</th>
                    <th>Tanggal Purchase Order</th>
                    <th>Supplier</th>
                    <th>PIC</th>
                    <th>Telepon</th>
                    <th>Nama Obat / Bahan Habis Pakai</th>
                    <th>Jumlah</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>PO-2026-001</td>
                    <td>28/02/2026</td>
                    <td>PT. Kimia Farma</td>
                    <td>Budi Hartono</td>
                    <td>0811-2345-6789</td>
                    <td>Amoxicillin 500mg</td>
                    <td>200</td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <button class="apt-btn-sm">Detail</button>
                            <button class="apt-btn-primary">Terima</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>PO-2026-002</td>
                    <td>01/03/2026</td>
                    <td>PT. Medline Indonesia</td>
                    <td>Rika Suharto</td>
                    <td>0812-3456-7890</td>
                    <td>Sarung Tangan Latex S</td>
                    <td>100</td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <button class="apt-btn-sm">Detail</button>
                            <button class="apt-btn-primary">Terima</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>PO-2026-003</td>
                    <td>03/03/2026</td>
                    <td>PT. Dexa Medica</td>
                    <td>Andi Prasetyo</td>
                    <td>0813-4567-8901</td>
                    <td>Ibuprofen 400mg</td>
                    <td>150</td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <button class="apt-btn-sm">Detail</button>
                            <button class="apt-btn-primary">Terima</button>
                        </div>
                    </td>
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
