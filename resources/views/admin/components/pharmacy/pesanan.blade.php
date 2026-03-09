<style>
    .apt-card { background: #fff; border-radius: 8px; border: 1px solid #E5D6C5; box-shadow: 0 1px 3px rgba(88,44,12,.06); }
    .apt-card-header { padding: 18px 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px; border-bottom: 1px solid #E5D6C5; }
    .apt-card-title { font-size: 18.75px; font-weight: 700; color: #C58F59; margin: 0; }
    .apt-search-box { display: flex; align-items: center; border: 1px solid #E5D6C5; border-radius: 5px; padding: 7px 10px; gap: 7px; background: #fff; }
    .apt-search-box:focus-within { border-color: #C58F59; }
    .apt-search-box input { border: none; outline: none; font-size: 13px; color: #582C0C; background: transparent; width: 300px; }
    .apt-search-box input::placeholder { color: #b09a88; }
    .apt-btn-primary { background: #C58F59; color: #fff; border: none; padding: 5px 12px; border-radius: 5px; font-size: 13px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap; font-family: inherit; }
    .apt-btn-primary:hover { background: #b07d4a; }
    .apt-btn-sm { background: #fff; color: #582C0C; border: 1px solid #E5D6C5; padding: 5px 10px; border-radius: 5px; font-size: 13px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; transition: all .2s; font-family: inherit; }
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
