<style>
    .apt-card { background: #fff; border-radius: 8px; border: 1px solid #E5D6C5; box-shadow: 0 1px 3px rgba(88,44,12,.06); }
    .apt-card-title { font-size: 18.75px; font-weight: 700; color: #C58F59; margin: 0 0 8px; }
    .apt-btn-primary { background: #C58F59; color: #fff; border: none; padding: 6px 12px; border-radius: 5px; font-size: 13px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap; font-family: inherit; }
    .apt-btn-primary:hover { background: #b07d4a; }
    .apt-table-wrapper { width: 100%; overflow-x: auto; }
    .apt-table { width: 100%; border-collapse: collapse; text-align: left; }
    .apt-table th { background: #fdf8f4; color: #582C0C; font-size: 13px; font-weight: 600; padding: 11px 16px; border-top: 1px solid #E5D6C5; border-bottom: 2px solid #E5D6C5; }
    .apt-table td { padding: 11px 16px; font-size: 13px; color: #374151; border-bottom: 1px solid #F3EDE6; }
    .apt-table tr:last-child td { border-bottom: none; }
    .apt-table tr:hover td { background: rgba(253,248,244,.7); }
    .apt-pagination { display: flex; justify-content: flex-end; align-items: center; padding: 12px 18px; gap: 20px; border-top: 1px solid #E5D6C5; }
    .apt-page-info { color: #6B513E; }
    .apt-page-controls { display: flex; gap: 4px; }
    .apt-page-btn { background: none; border: none; color: #9CA3AF; cursor: pointer; padding: 4px 6px; border-radius: 4px; line-height: 0; }
    .apt-page-btn[disabled] { opacity: .4; cursor: default; pointer-events: none; }
</style>

<div class="apt-card">
    <div style="padding:18px 20px 14px;">
        <h2 class="apt-card-title">Depot</h2>
        <p style="font-size:13px; color:#6B513E; line-height:1.6; margin:0;">
            Depot merupakan fitur untuk maintenance jumlah obat yang tersebar di Klinik.<br>
            Pemilik Klinik atau Apoteker bisa mengetahui jumlah obat yang terdapat di Apotek, Ruang Dokter, Gudang, dan lain-lain.
        </p>
    </div>

    <div class="apt-table-wrapper">
        <table class="apt-table">
            <thead>
                <tr>
                    <th>Nama Depot</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Apotek Utama</td>
                    <td>
                        <div style="display:flex; gap:8px; justify-content:flex-end;">
                            <button class="apt-btn-primary">Show Obat</button>
                            <button class="apt-btn-primary">Stok Opname Obat</button>
                            <button class="apt-btn-primary">Stok Opname BHP</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Ruang Dokter 1</td>
                    <td>
                        <div style="display:flex; gap:8px; justify-content:flex-end;">
                            <button class="apt-btn-primary">Show Obat</button>
                            <button class="apt-btn-primary">Stok Opname Obat</button>
                            <button class="apt-btn-primary">Stok Opname BHP</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Gudang</td>
                    <td>
                        <div style="display:flex; gap:8px; justify-content:flex-end;">
                            <button class="apt-btn-primary">Show Obat</button>
                            <button class="apt-btn-primary">Stok Opname Obat</button>
                            <button class="apt-btn-primary">Stok Opname BHP</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="apt-pagination">
        <div class="apt-page-info">1–3 dari 3 data</div>
        <div class="apt-page-controls">
            <button class="apt-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg></button>
            <button class="apt-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg></button>
        </div>
    </div>
</div>
