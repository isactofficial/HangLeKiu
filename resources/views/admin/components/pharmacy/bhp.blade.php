<style>
    .apt-card { background: #fff; border-radius: 8px; border: 1px solid #E5D6C5; box-shadow: 0 1px 3px rgba(88,44,12,.06); }
    .apt-card-header { padding: 18px 20px; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 14px; border-bottom: 1px solid #E5D6C5; }
    .apt-card-title    { font-size: 18.75px; font-weight: 700; color: #C58F59; margin: 0 0 2px; line-height: 1; }
    .apt-card-subtitle { font-size: 13px; color: #6B513E; margin: 0; }
    .apt-card-actions  { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
    .apt-search-box { display: flex; align-items: center; border: 1px solid #E5D6C5; border-radius: 5px; padding: 7px 10px; gap: 7px; background: #fff; }
    .apt-search-box:focus-within { border-color: #C58F59; }
    .apt-search-box input { border: none; outline: none; font-size: 13px; color: #582C0C; background: transparent; width: 200px; }
    .apt-search-box input::placeholder { color: #b09a88; }
    .apt-btn-primary   { background: #C58F59; color: #fff; border: none; padding: 8px 14px; border-radius: 5px; font-size: 13px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap; }
    .apt-btn-primary:hover { background: #b07d4a; }
    .apt-btn-secondary { background: #582C0C; color: #fff; border: none; padding: 8px 14px; border-radius: 5px; font-size: 13px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap; }
    .apt-btn-secondary:hover { background: #401f08; }
    .apt-btn-outline { background: #fff; color: #582C0C; border: 1px solid #E5D6C5; padding: 5px 10px; border-radius: 5px; font-size: 13px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; transition: all .2s; }
    .apt-btn-outline:hover { border-color: #C58F59; color: #C58F59; }
    .apt-dropdown { position: relative; }
    .apt-dropdown-menu { display: none; position: absolute; top: calc(100% + 4px); right: 0; background: #fdf8f4; border: 1px solid #E5D6C5; border-radius: 8px; min-width: 200px; box-shadow: 0 6px 18px rgba(88,44,12,.10); z-index: 50; overflow: hidden; }
    .apt-dropdown-menu.open { display: block; }
    .apt-dropdown-item { padding: 11px 16px; font-size: 13px; color: #582C0C; cursor: pointer; border-bottom: 1px solid #E5D6C5; }
    .apt-dropdown-item:last-child { border-bottom: none; }
    .apt-dropdown-item:hover { background: #f0e8df; }
    .apt-dropdown-item.active { font-weight: 700; }
    .apt-checkbox { width: 15px; height: 15px; accent-color: #C58F59; cursor: pointer; }
    .apt-table-wrapper { width: 100%; overflow-x: auto; }
    .apt-table-wrapper::-webkit-scrollbar { height: 6px; }
    .apt-table-wrapper::-webkit-scrollbar-thumb { background: #C58F59; border-radius: 3px; }
    .apt-table { width: 100%; border-collapse: collapse; text-align: left; }
    .apt-table th { background: #fdf8f4; color: #582C0C; font-size: 13px; font-weight: 600; padding: 11px 16px; border-top: 1px solid #E5D6C5; border-bottom: 2px solid #E5D6C5; white-space: nowrap; }
    .apt-table td { padding: 11px 16px; font-size: 13px; color: #374151; border-bottom: 1px solid #F3EDE6; white-space: nowrap; }
    .apt-table tr:last-child td { border-bottom: none; }
    .apt-table tr:hover td { background: rgba(253,248,244,.7); }
    .apt-info-icon { color: #9CA3AF; margin-left: 3px; cursor: help; vertical-align: middle; }
    .apt-badge { display: inline-block; padding: 3px 9px; border-radius: 20px; font-size: 13px; font-weight: 600; }
    .apt-badge-danger { background: #FEE2E2; color: #991B1B; }
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
            <h2 class="apt-card-title">Data Stok Bahan Habis Pakai</h2>
            <p class="apt-card-subtitle">Last Update: 05/03/2026 08:00</p>
        </div>
        <div class="apt-card-actions">
            <div class="apt-search-box">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                <input type="text" placeholder="Cari bahan habis pakai">
            </div>
            <button class="apt-btn-primary">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                Tambah Data Barang
            </button>
            <div class="apt-dropdown">
                <button class="apt-btn-secondary" data-dropdown-trigger>
                    Export Excel
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
                </button>
                <div class="apt-dropdown-menu">
                    <div class="apt-dropdown-item active">Semua Metode Pembayaran</div>
                    <div class="apt-dropdown-item">Umum / Tunai</div>
                    <div class="apt-dropdown-item">Asuransi</div>
                    <div class="apt-dropdown-item">BPJS Kesehatan</div>
                </div>
            </div>
        </div>
    </div>

    <div class="apt-table-wrapper">
        <table class="apt-table" style="min-width:1000px;">
            <thead>
                <tr>
                    <th style="width:40px;"><input type="checkbox" class="apt-checkbox"></th>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Brand</th>
                    <th>Stok</th>
                    <th>Harga Umum <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2" class="apt-info-icon"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></th>
                    <th>Harga Beli <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2" class="apt-info-icon"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></th>
                    <th>Avg HPP</th>
                    <th>Harga OTC</th>
                    <th>Margin Profit</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="checkbox" class="apt-checkbox"></td>
                    <td>BHP-001</td><td>Masker Bedah</td><td>OneMed</td><td>500</td>
                    <td>Rp 2.000</td><td>Rp 1.200</td><td>Rp 1.200</td><td>Rp 2.500</td><td>67%</td>
                    <td><div style="display:flex;gap:6px;"><button class="apt-btn-outline">Edit</button><button class="apt-btn-outline" style="color:#EF4444;border-color:#FEE2E2;">Hapus</button></div></td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="apt-checkbox"></td>
                    <td>BHP-002</td><td>Sarung Tangan Latex S</td><td>Medline</td><td><span class="apt-badge apt-badge-danger">8</span></td>
                    <td>Rp 3.500</td><td>Rp 2.000</td><td>Rp 2.000</td><td>Rp 4.000</td><td>75%</td>
                    <td><div style="display:flex;gap:6px;"><button class="apt-btn-outline">Edit</button><button class="apt-btn-outline" style="color:#EF4444;border-color:#FEE2E2;">Hapus</button></div></td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="apt-checkbox"></td>
                    <td>BHP-003</td><td>Cotton Roll</td><td>Prevest</td><td>120</td>
                    <td>Rp 500</td><td>Rp 280</td><td>Rp 280</td><td>Rp 600</td><td>79%</td>
                    <td><div style="display:flex;gap:6px;"><button class="apt-btn-outline">Edit</button><button class="apt-btn-outline" style="color:#EF4444;border-color:#FEE2E2;">Hapus</button></div></td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="apt-checkbox"></td>
                    <td>BHP-004</td><td>Gutta Percha Point #25</td><td>DiaDent</td><td>30</td>
                    <td>Rp 45.000</td><td>Rp 28.000</td><td>Rp 28.000</td><td>Rp 50.000</td><td>61%</td>
                    <td><div style="display:flex;gap:6px;"><button class="apt-btn-outline">Edit</button><button class="apt-btn-outline" style="color:#EF4444;border-color:#FEE2E2;">Hapus</button></div></td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="apt-checkbox"></td>
                    <td>BHP-005</td><td>Syringe 3cc</td><td>Terumo</td><td>200</td>
                    <td>Rp 4.000</td><td>Rp 2.500</td><td>Rp 2.500</td><td>Rp 4.500</td><td>60%</td>
                    <td><div style="display:flex;gap:6px;"><button class="apt-btn-outline">Edit</button><button class="apt-btn-outline" style="color:#EF4444;border-color:#FEE2E2;">Hapus</button></div></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="apt-pagination">
        <div class="apt-page-size">Jumlah baris per halaman: <select><option>10</option><option>25</option><option>50</option></select></div>
        <div class="apt-page-info">1–5 dari 5 data</div>
        <div class="apt-page-controls">
            <button class="apt-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg></button>
            <button class="apt-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg></button>
        </div>
    </div>
</div>
