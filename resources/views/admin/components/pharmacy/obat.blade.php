@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/pharmacy/obat.css') }}">
@endpush


<div class="apt-card">

    <div class="apt-card-header">
        <div>
            <h2 class="apt-card-title">Data Stok Obat</h2>
            <p class="apt-card-subtitle">Last Update: 05/03/2026 08:00</p>
        </div>
        <div class="apt-card-actions">
            <div class="apt-search-box">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                <input type="text" placeholder="Cari kode, nama obat atau kategori">
            </div>
            <button class="apt-btn-primary">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                Tambah Data Obat
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
        <table class="apt-table" style="min-width:1100px;">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Obat</th>
                    <th>Farmasi</th>
                    <th>Jenis</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Harga Umum <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2" class="apt-info-icon"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></th>
                    <th>Harga Beli <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2" class="apt-info-icon"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></th>
                    <th>Avg HPP</th>
                    <th>Harga OTC</th>
                    <th>Margin Profit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>OBT-001</td>
                    <td>Amoxicillin 500mg</td>
                    <td>Kimia Farma</td>
                    <td>Kapsul</td>
                    <td>Antibiotik</td>
                    <td>250</td>
                    <td>Rp 5.000</td>
                    <td>Rp 3.200</td>
                    <td>Rp 3.200</td>
                    <td>Rp 6.000</td>
                    <td>56%</td>
                    <td><div style="display:flex;gap:6px;"><button class="apt-btn-outline">Edit</button><button class="apt-btn-outline" style="color:#EF4444;border-color:#FEE2E2;">Hapus</button></div></td>
                </tr>
                <tr>
                    <td>OBT-002</td>
                    <td>Paracetamol 500mg</td>
                    <td>Kalbe Farma</td>
                    <td>Tablet</td>
                    <td>Analgesik</td>
                    <td><span class="apt-badge apt-badge-danger">4</span></td>
                    <td>Rp 2.000</td>
                    <td>Rp 1.100</td>
                    <td>Rp 1.100</td>
                    <td>Rp 2.500</td>
                    <td>82%</td>
                    <td><div style="display:flex;gap:6px;"><button class="apt-btn-outline">Edit</button><button class="apt-btn-outline" style="color:#EF4444;border-color:#FEE2E2;">Hapus</button></div></td>
                </tr>
                <tr>
                    <td>OBT-003</td>
                    <td>Ibuprofen 400mg</td>
                    <td>Dexa Medica</td>
                    <td>Tablet</td>
                    <td>Analgesik</td>
                    <td>180</td>
                    <td>Rp 4.500</td>
                    <td>Rp 2.800</td>
                    <td>Rp 2.800</td>
                    <td>Rp 5.000</td>
                    <td>61%</td>
                    <td><div style="display:flex;gap:6px;"><button class="apt-btn-outline">Edit</button><button class="apt-btn-outline" style="color:#EF4444;border-color:#FEE2E2;">Hapus</button></div></td>
                </tr>
                <tr>
                    <td>OBT-004</td>
                    <td>Chlorhexidine 0.2%</td>
                    <td>Guardian Pharma</td>
                    <td>Cairan</td>
                    <td>Antiseptik</td>
                    <td>60</td>
                    <td>Rp 18.000</td>
                    <td>Rp 11.000</td>
                    <td>Rp 11.000</td>
                    <td>Rp 20.000</td>
                    <td>64%</td>
                    <td><div style="display:flex;gap:6px;"><button class="apt-btn-outline">Edit</button><button class="apt-btn-outline" style="color:#EF4444;border-color:#FEE2E2;">Hapus</button></div></td>
                </tr>
                <tr>
                    <td>OBT-005</td>
                    <td>Lidocaine 2%</td>
                    <td>Kimia Farma</td>
                    <td>Injeksi</td>
                    <td>Anestesi</td>
                    <td>95</td>
                    <td>Rp 25.000</td>
                    <td>Rp 15.000</td>
                    <td>Rp 15.000</td>
                    <td>Rp 28.000</td>
                    <td>67%</td>
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
