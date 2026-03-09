<style>
    .apt-card { background: #fff; border-radius: 8px; border: 1px solid #E5D6C5; box-shadow: 0 1px 3px rgba(88,44,12,.06); }
    .apt-card-header { padding: 18px 20px; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 14px; border-bottom: 1px solid #E5D6C5; }
    .apt-card-title { font-size: 18.75px; font-weight: 700; color: #C58F59; margin: 0; line-height: 1; }
    .apt-card-actions { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
    .apt-date-input { display: flex; flex-direction: column; gap: 2px; }
    .apt-date-input label { font-size: 13px; color: #6B513E; }
    .apt-date-input input { border: none; border-bottom: 1px solid #E5D6C5; padding: 4px 0; font-size: 13px; color: #582C0C; outline: none; background: transparent; width: 110px; }
    .apt-date-input input:focus { border-color: #C58F59; }
    .apt-search-box { display: flex; align-items: center; border: 1px solid #E5D6C5; border-radius: 5px; padding: 7px 10px; gap: 7px; background: #fff; }
    .apt-search-box:focus-within { border-color: #C58F59; }
    .apt-search-box input { border: none; outline: none; font-size: 13px; color: #582C0C; background: transparent; width: 180px; }
    .apt-search-box input::placeholder { color: #b09a88; }
    .apt-btn-primary   { background: #C58F59; color: #fff; border: none; padding: 8px 14px; border-radius: 5px; font-size: 13px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap; }
    .apt-btn-primary:hover { background: #b07d4a; }
    .apt-btn-secondary { background: #582C0C; color: #fff; border: none; padding: 8px 14px; border-radius: 5px; font-size: 13px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap; }
    .apt-btn-secondary:hover { background: #401f08; }
    .apt-btn-outline { background: #fff; color: #582C0C; border: 1px solid #E5D6C5; padding: 8px; border-radius: 5px; font-size: 13px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; transition: all .2s; }
    .apt-btn-outline:hover { border-color: #C58F59; color: #C58F59; }
    .apt-table-wrapper { width: 100%; overflow-x: auto; }
    .apt-table-wrapper::-webkit-scrollbar { height: 6px; }
    .apt-table-wrapper::-webkit-scrollbar-thumb { background: #C58F59; border-radius: 3px; }
    .apt-table { width: 100%; border-collapse: collapse; text-align: left; }
    .apt-table th { background: #fdf8f4; color: #582C0C; font-size: 13px; font-weight: 600; padding: 11px 16px; border-top: 1px solid #E5D6C5; border-bottom: 2px solid #E5D6C5; white-space: nowrap; cursor: pointer; }
    .apt-table th:hover { color: #C58F59; }
    .apt-table td { padding: 11px 16px; font-size: 13px; color: #374151; border-bottom: 1px solid #F3EDE6; white-space: nowrap; }
    .apt-table tr:last-child td { border-bottom: none; }
    .apt-table tr:hover td { background: rgba(253,248,244,.7); }
    .apt-pagination { display: flex; justify-content: flex-end; align-items: center; padding: 12px 18px; gap: 20px; border-top: 1px solid #E5D6C5; }
    .apt-page-size { display: flex; align-items: center; gap: 6px; color: #6B513E; }
    .apt-page-size select { border: none; outline: none; font-weight: 600; color: #582C0C; font-size: 13px; cursor: pointer; background: transparent; }
    .apt-page-info { color: #6B513E; }
    .apt-page-controls { display: flex; gap: 4px; }
    .apt-page-btn { background: none; border: none; color: #9CA3AF; cursor: pointer; padding: 4px 6px; border-radius: 4px; line-height: 0; }
    .apt-page-btn:hover { color: #582C0C; background: #fdf8f4; }
    .apt-page-btn[disabled] { opacity: .4; cursor: default; pointer-events: none; }
</style>

<div class="apt-card">
    <div class="apt-card-header">
        <h2 class="apt-card-title">Penggunaan Obat</h2>
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

    <p style="padding:6px 18px 8px; font-size:13px; color:#6B513E;">Last Update: 05/03/2026 08:00</p>

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
