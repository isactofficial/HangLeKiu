<style>
    .apt-card { background: #fff; border-radius: 8px; border: 1px solid #E5D6C5; box-shadow: 0 1px 3px rgba(88,44,12,.06); }
    .apt-card-header { padding: 18px 20px; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 14px; border-bottom: 1px solid #E5D6C5; }
    .apt-card-title    { font-size: 18.75px; font-weight: 700; color: #C58F59; margin: 0 0 2px; line-height: 1; }
    .apt-card-subtitle { font-size: 13px; color: #6B513E; margin: 0; }
    .apt-section-title { font-size: 18.75px; font-weight: 700; color: #C58F59; margin: 0; }
    .apt-search-box { display: flex; align-items: center; border: 1px solid #E5D6C5; border-radius: 5px; padding: 7px 10px; gap: 7px; background: #fff; }
    .apt-search-box:focus-within { border-color: #C58F59; }
    .apt-search-box input { border: none; outline: none; font-size: 13px; color: #582C0C; background: transparent; width: 240px; }
    .apt-search-box input::placeholder { color: #b09a88; }
    .apt-table-wrapper { width: 100%; overflow-x: auto; }
    .apt-table { width: 100%; border-collapse: collapse; text-align: left; }
    .apt-table th { background: #fdf8f4; color: #582C0C; font-size: 13px; font-weight: 600; padding: 11px 16px; border-top: 1px solid #E5D6C5; border-bottom: 2px solid #E5D6C5; white-space: nowrap; }
    .apt-table td { padding: 11px 16px; font-size: 13px; color: #374151; border-bottom: 1px solid #F3EDE6; white-space: nowrap; }
    .apt-table tr:last-child td { border-bottom: none; }
    .apt-table tr:hover td { background: rgba(253,248,244,.7); }
    .apt-badge { display: inline-block; padding: 3px 9px; border-radius: 20px; font-size: 13px; font-weight: 600; }
    .apt-badge-danger  { background: #FEE2E2; color: #991B1B; }
    .apt-badge-warning { background: #FEF3C7; color: #92400E; }
    .apt-link { color: #C58F59; text-decoration: none; font-weight: 600; }
    .apt-link:hover { text-decoration: underline; }
    .apt-pagination { display: flex; justify-content: flex-end; align-items: center; padding: 12px 18px; gap: 20px; border-top: 1px solid #E5D6C5; }
    .apt-page-size { display: flex; align-items: center; gap: 6px; color: #6B513E; }
    .apt-page-size select { border: none; outline: none; font-weight: 600; color: #582C0C; font-size: 13px; cursor: pointer; background: transparent; }
    .apt-page-info { color: #6B513E; }
    .apt-page-controls { display: flex; gap: 4px; }
    .apt-page-btn { background: none; border: none; color: #9CA3AF; cursor: pointer; padding: 4px 6px; border-radius: 4px; line-height: 0; }
    .apt-page-btn:hover { color: #582C0C; background: #fdf8f4; }
    .apt-page-btn[disabled] { opacity: .4; cursor: default; pointer-events: none; }
</style>

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
