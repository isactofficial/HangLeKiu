@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/pharmacy/kedaluwarsa-bhp.css') }}">
@endpush


<div class="apt-card" style="margin-bottom:16px;">
    <div style="padding:16px 20px 14px;">
        <h2 class="apt-section-title">Warning Kedaluwarsa Bahan Habis Pakai</h2>
    </div>
    <div class="apt-table-wrapper">
        <table class="apt-table">
            <thead>
                <tr>
                    <th>Nama Bahan Habis Pakai</th>
                    <th>Tanggal Kedaluwarsa</th>
                    <th>Stok Bahan Habis Pakai</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Sarung Tangan Latex S</td>
                    <td><span class="apt-badge apt-badge-danger">20/03/2026</span></td>
                    <td>8</td>
                </tr>
                <tr>
                    <td>Gutta Percha Point #25</td>
                    <td><span class="apt-badge apt-badge-warning">15/05/2026</span></td>
                    <td>14</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="apt-card">
    <div class="apt-card-header">
        <div>
            <h2 class="apt-card-title">Data Kedaluwarsa Bahan Habis Pakai</h2>
            <p class="apt-card-subtitle">Last Update: 05/03/2026 08:00</p>
        </div>
        <div class="apt-search-box">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            <input type="text" placeholder="Cari kode atau nama bahan habis pakai">
        </div>
    </div>
    <div class="apt-table-wrapper">
        <table class="apt-table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Bahan Habis Pakai (Klik untuk detail kedaluwarsa)</th>
                    <th>Pembelian Bahan Habis Pakai Terakhir</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>BHP-002</td><td><a href="#" class="apt-link">Sarung Tangan Latex S</a></td><td>15/01/2026</td></tr>
                <tr><td>BHP-004</td><td><a href="#" class="apt-link">Gutta Percha Point #25</a></td><td>10/02/2026</td></tr>
                <tr><td>BHP-001</td><td><a href="#" class="apt-link">Masker Bedah</a></td><td>20/02/2026</td></tr>
                <tr><td>BHP-003</td><td><a href="#" class="apt-link">Cotton Roll</a></td><td>01/03/2026</td></tr>
            </tbody>
        </table>
    </div>
    <div class="apt-pagination">
        <div class="apt-page-size">Jumlah baris per halaman: <select><option>5</option><option>10</option></select></div>
        <div class="apt-page-info">1–4 dari 4 data</div>
        <div class="apt-page-controls">
            <button class="apt-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 17l-5-5 5-5M18 17l-5-5 5-5"/></svg></button>
            <button class="apt-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg></button>
            <button class="apt-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg></button>
            <button class="apt-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M13 17l5-5-5-5M6 17l5-5-5-5"/></svg></button>
        </div>
    </div>
</div>
