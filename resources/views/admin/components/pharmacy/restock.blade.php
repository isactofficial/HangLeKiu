<style>
    .apt-card { background: #fff; border-radius: 8px; border: 1px solid #E5D6C5; box-shadow: 0 1px 3px rgba(88,44,12,.06); }
    .apt-card-header { padding: 18px 20px; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 14px; border-bottom: 1px solid #E5D6C5; }
    .apt-card-title    { font-size: 18.75px; font-weight: 700; color: #C58F59; margin: 0 0 2px; line-height: 1; }
    .apt-card-subtitle { font-size: 13px; color: #6B513E; margin: 0; }
    .apt-card-actions  { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
    .apt-search-box { display: flex; align-items: center; border: 1px solid #E5D6C5; border-radius: 5px; padding: 7px 10px; gap: 7px; background: #fff; }
    .apt-search-box:focus-within { border-color: #C58F59; }
    .apt-search-box input { border: none; outline: none; font-size: 13px; color: #582C0C; background: transparent; width: 220px; }
    .apt-search-box input::placeholder { color: #b09a88; }
    .apt-btn-primary { background: #C58F59; color: #fff; border: none; padding: 8px 14px; border-radius: 5px; font-size: 13px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap; }
    .apt-btn-primary:hover { background: #b07d4a; }
    .apt-btn-outline-icon { background: #fff; color: #582C0C; border: 1px solid #E5D6C5; padding: 8px; border-radius: 5px; cursor: pointer; display: inline-flex; align-items: center; transition: all .2s; }
    .apt-btn-outline-icon:hover { border-color: #C58F59; color: #C58F59; }
    .apt-btn-sm { background: #fff; color: #582C0C; border: 1px solid #E5D6C5; padding: 5px 10px; border-radius: 5px; font-size: 13px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; transition: all .2s; }
    .apt-btn-sm:hover { border-color: #C58F59; color: #C58F59; }
    .apt-table-wrapper { width: 100%; overflow-x: auto; }
    .apt-table-wrapper::-webkit-scrollbar { height: 6px; }
    .apt-table-wrapper::-webkit-scrollbar-thumb { background: #C58F59; border-radius: 3px; }
    .apt-table { width: 100%; border-collapse: collapse; text-align: left; }
    .apt-table th { background: #fdf8f4; color: #582C0C; font-size: 13px; font-weight: 600; padding: 11px 16px; border-top: 1px solid #E5D6C5; border-bottom: 2px solid #E5D6C5; white-space: nowrap; }
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
