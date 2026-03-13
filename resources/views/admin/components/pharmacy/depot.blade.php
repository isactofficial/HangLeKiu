@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/pharmacy/depot.css') }}">
@endpush


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
