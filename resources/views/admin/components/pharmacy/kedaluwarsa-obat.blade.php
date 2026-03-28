@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/pharmacy/kedaluwarsa-obat.css') }}">
@endpush


{{-- Warning --}}
<div class="apt-card" style="margin-bottom:16px;">
    <div style="padding:16px 20px 14px;">
        <h2 class="apt-section-title">Warning Kedaluwarsa Obat</h2>
    </div>
    <div class="apt-table-wrapper">
        <table class="apt-table">
            <thead>
                <tr>
                    <th>Nama Obat</th>
                    <th>Tanggal Kedaluwarsa</th>
                    <th>Stok Obat</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Paracetamol 500mg</td>
                    <td><span class="apt-badge apt-badge-danger">15/03/2026</span></td>
                    <td>4</td>
                </tr>
                <tr>
                    <td>Chlorhexidine 0.2%</td>
                    <td><span class="apt-badge apt-badge-warning">28/04/2026</span></td>
                    <td>12</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- Data --}}
<div class="apt-card">
    <div class="apt-card-header">
        <div>
            <h2 class="apt-card-title">Data Kedaluwarsa Obat</h2>
            <p class="apt-card-subtitle">Last Update: 05/03/2026 08:00</p>
        </div>
        <div class="apt-search-box">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            <input type="text" placeholder="Cari kode atau nama obat">
        </div>
    </div>
    <div class="apt-table-wrapper">
        <table class="apt-table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Obat (Klik nama obat untuk detail kedaluwarsa obat)</th>
                    <th>Pembelian Obat Terakhir</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>OBT-002</td>
                    <td><a href="#" class="apt-link">Paracetamol 500mg</a></td>
                    <td>10/01/2026</td>
                </tr>
                <tr>
                    <td>OBT-004</td>
                    <td><a href="#" class="apt-link">Chlorhexidine 0.2%</a></td>
                    <td>05/02/2026</td>
                </tr>
                <tr>
                    <td>OBT-001</td>
                    <td><a href="#" class="apt-link">Amoxicillin 500mg</a></td>
                    <td>20/02/2026</td>
                </tr>
                <tr>
                    <td>OBT-003</td>
                    <td><a href="#" class="apt-link">Ibuprofen 400mg</a></td>
                    <td>01/03/2026</td>
                </tr>
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
