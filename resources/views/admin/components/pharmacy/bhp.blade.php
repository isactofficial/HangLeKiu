@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/pharmacy/bhp.css') }}">
@endpush


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
