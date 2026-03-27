@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/pharmacy/bhp.css') }}">
    <!-- Tambahkan Tailwind via CDN untuk styling modal jika belum ada di project -->
    <script src="https://cdn.tailwindcss.com"></script>
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
            
            <!-- Tombol Trigger Modal -->
            <button class="apt-btn-primary" id="btnOpenModal">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                Tambah Data BHP
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
                <!-- Row 1 -->
                <tr>
                    <td><input type="checkbox" class="apt-checkbox"></td>
                    <td>BHP-001</td><td>Masker Bedah</td><td>OneMed</td><td>500</td>
                    <td>Rp 2.000</td><td>Rp 1.200</td><td>Rp 1.200</td><td>Rp 2.500</td><td>67%</td>
                    <td><div style="display:flex;gap:6px;"><button class="apt-btn-outline">Edit</button><button class="apt-btn-outline" style="color:#EF4444;border-color:#FEE2E2;">Hapus</button></div></td>
                </tr>
                <!-- Tambahkan row lainnya di sini -->
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

<!-- ==========================================
     MODAL POP-UP (TAMBAH DATA BHP)
     ========================================== -->
<div id="modalBHP" class="modal-overlay">
    <div class="modal-container">
        
        <!-- Header -->
        <div class="modal-header">
            <h3 class="modal-title">Tambah Data Bahan Habis Pakai Baru</h3>
            <button id="btnCloseX" class="modal-close-btn" type="button">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Form Body -->
        <form class="modal-form" id="formBHP">
            <div class="form-grid">
                
                <div class="form-group">
                    <label class="form-label">Kode Barang</label>
                    <input type="text" name="kode" placeholder="BHP-XXX" class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" name="nama" placeholder="Contoh: Masker Bedah" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Brand</label>
                    <input type="text" name="brand" placeholder="Contoh: OneMed" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Stok Awal</label>
                    <input type="number" name="stok" placeholder="0" class="form-input">
                </div>

                <!-- Divider Harga -->
                <div class="form-divider">
                    <span class="form-divider-text">Informasi Keuangan (Rp)</span>
                </div>

                <div class="form-group">
                    <label class="form-label">Harga Beli</label>
                    <input type="number" name="harga_beli" placeholder="Rp 0" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Harga Umum</label>
                    <input type="number" name="harga_umum" placeholder="Rp 0" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Harga OTC</label>
                    <input type="number" name="harga_otc" placeholder="Rp 0" class="form-input">
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="modal-footer">
                <button type="button" id="btnCancel" class="modal-btn modal-btn-cancel">Batal</button>
                <button type="submit" class="modal-btn modal-btn-submit">Simpan Barang</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalBHP');
        const btnOpen = document.getElementById('btnOpenModal');
        const btnCloseX = document.getElementById('btnCloseX');
        const btnCancel = document.getElementById('btnCancel');
        const form = document.getElementById('formBHP');

        // Fungsi Buka Modal
        btnOpen.onclick = () => {
            modal.classList.add('open');
        };

        // Fungsi Tutup Modal
        const closeModal = () => {
            modal.classList.remove('open');
            form.reset();
        };

        btnCloseX.onclick = closeModal;
        btnCancel.onclick = closeModal;

        // Tutup jika klik di luar modal (overlay)
        modal.onclick = (e) => {
            if (e.target === modal) closeModal();
        };
    });
</script>