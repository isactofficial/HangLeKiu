@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/pharmacy/penggunaan-bhp.css') }}">
@endpush


<div class="apt-card">
    <div class="apt-card-header">
        <h2 class="apt-card-title">Penggunaan BHP</h2>
        <div class="apt-card-actions">
            <div class="apt-date-input">
                <label>Dari Tanggal</label>
                <input type="date" value="2026-03-01">
            </div>
            <div class="apt-date-input">
                <label>Sampai Tanggal</label>
                <input type="date" value="2026-03-05">
            </div>
            <div class="apt-search-box">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                <input type="text" placeholder="Cari nama bhp">
            </div>
            <button class="apt-btn-primary">Filter</button>
            <button class="apt-btn-secondary">Export</button>
            <button class="apt-btn-outline" title="Cetak">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            </button>
        </div>
    </div>

    <p style="padding:6px 18px 8px; font-size:13px; color:#6B513E;">Last Update: 05/03/2026 08:00</p>

    <div class="apt-table-wrapper">
        <table class="apt-table" style="min-width:800px;">
            <thead>
                <tr>
                    <th>Nama BHP ↑</th>
                    <th>Penggunaan Umum</th>
                    <th>Nominal BHP Umum</th>
                    <th>Penggunaan BPJS —</th>
                    <th>Nominal BHP BPJS</th>
                    <th>Sisa BHP</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>Cotton Roll</td><td>80</td><td>Rp 40.000</td><td>20</td><td>Rp 10.000</td><td>120</td></tr>
                <tr><td>Gutta Percha Point #25</td><td>12</td><td>Rp 540.000</td><td>4</td><td>Rp 180.000</td><td>14</td></tr>
                <tr><td>Masker Bedah</td><td>120</td><td>Rp 240.000</td><td>60</td><td>Rp 120.000</td><td>320</td></tr>
                <tr><td>Sarung Tangan Latex S</td><td>30</td><td>Rp 105.000</td><td>10</td><td>Rp 35.000</td><td>60</td></tr>
                <tr><td>Syringe 3cc</td><td>45</td><td>Rp 180.000</td><td>15</td><td>Rp 60.000</td><td>140</td></tr>
            </tbody>
        </table>
    </div>

    <div class="apt-pagination">
        <div class="apt-page-size">Jumlah baris per halaman: <select><option>5</option><option>10</option></select></div>
        <div class="apt-page-info">1–5 dari 5 data</div>
        <div class="apt-page-controls">
            <button class="apt-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 17l-5-5 5-5M18 17l-5-5 5-5"/></svg></button>
            <button class="apt-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg></button>
            <button class="apt-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg></button>
            <button class="apt-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M13 17l5-5-5-5M6 17l5-5-5-5"/></svg></button>
        </div>
    </div>
</div>
