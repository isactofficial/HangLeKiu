@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/pharmacy/penggunaan-obat.css') }}">
@endpush


<div class="apt-card">
    <div class="apt-card-header">
        <div>
            <h2 class="apt-card-title">Penggunaan Obat</h2>
            <p class="apt-card-subtitle">Last Update: 05/03/2026 08:00</p>
        </div>
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
                <input type="text" placeholder="Cari nama obat">
            </div>
            <button class="apt-btn-primary">Filter</button>
            <button class="apt-btn-secondary">Export</button>
            <button class="apt-btn-outline" title="Cetak">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            </button>
        </div>
    </div>

    <div class="apt-table-wrapper">
        <table class="apt-table" style="min-width:800px;">
            <thead>
                <tr>
                    <th>Nama Obat ↑</th>
                    <th>Penggunaan Obat Umum</th>
                    <th>Nominal Obat Umum</th>
                    <th>Penggunaan Obat BPJS —</th>
                    <th>Nominal Obat BPJS</th>
                    <th>Sisa Obat</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Amoxicillin 500mg</td>
                    <td>42</td>
                    <td>Rp 210.000</td>
                    <td>18</td>
                    <td>Rp 90.000</td>
                    <td>190</td>
                </tr>
                <tr>
                    <td>Chlorhexidine 0.2%</td>
                    <td>15</td>
                    <td>Rp 270.000</td>
                    <td>0</td>
                    <td>Rp 0</td>
                    <td>45</td>
                </tr>
                <tr>
                    <td>Ibuprofen 400mg</td>
                    <td>30</td>
                    <td>Rp 135.000</td>
                    <td>12</td>
                    <td>Rp 54.000</td>
                    <td>138</td>
                </tr>
                <tr>
                    <td>Lidocaine 2%</td>
                    <td>28</td>
                    <td>Rp 700.000</td>
                    <td>10</td>
                    <td>Rp 250.000</td>
                    <td>57</td>
                </tr>
                <tr>
                    <td>Paracetamol 500mg</td>
                    <td>60</td>
                    <td>Rp 120.000</td>
                    <td>20</td>
                    <td>Rp 40.000</td>
                    <td>120</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="apt-pagination">
        <div class="apt-page-size">Jumlah baris per halaman: <select><option>5</option><option>10</option><option>25</option></select></div>
        <div class="apt-page-info">1–5 dari 5 data</div>
        <div class="apt-page-controls">
            <button class="apt-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 17l-5-5 5-5M18 17l-5-5 5-5"/></svg></button>
            <button class="apt-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg></button>
            <button class="apt-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg></button>
            <button class="apt-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M13 17l5-5-5-5M6 17l5-5-5-5"/></svg></button>
        </div>
    </div>
</div>
