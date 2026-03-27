@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/pharmacy/obat.css') }}">
    <!-- Pastikan Tailwind CSS terload untuk utilitas class modal -->
    <script src="https://cdn.tailwindcss.com"></script>
@endpush

<div class="apt-card" style="margin-top:16px;">
    <!-- Header Tabel -->
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
            
            <!-- Tombol Trigger Modal -->
            <button class="apt-btn-primary" id="btnTambahObat">
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

    <!-- Tabel Data -->
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
                <!-- Contoh Data Row -->
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
                    <td>
                        <div style="display:flex;gap:6px;">
                            <button class="apt-btn-outline">Edit</button>
                            <button class="apt-btn-outline" style="color:#EF4444;border-color:#FEE2E2;">Hapus</button>
                        </div>
                    </td>
                </tr>
                <!-- Tambahkan row lainnya di sini -->
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="apt-pagination">
        <div class="apt-page-size">Jumlah baris per halaman: <select><option>10</option><option>25</option><option>50</option></select></div>
        <div class="apt-page-controls">
            <button class="apt-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg></button>
            <div class="apt-page-info">1–5 dari 5 data</div>
            <button class="apt-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg></button>
        </div>
    </div>
</div>

<!-- ====MODAL POP-UP (TAMBAH DATA OBAT) === -->

<div id="modalTambahObat" class="modal-overlay">
    <div class="modal-container">
        
        <!-- Modal Header -->
        <div class="modal-header">
            <h3 class="modal-title">Tambah Data Obat Baru</h3>
            <button id="btnCloseX" class="modal-close-btn" type="button">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Modal Form Body -->
        <form class="modal-form" id="formTambahObat">
            <div class="form-grid">
                
                <div class="form-group">
                    <label class="form-label">Kode Obat</label>
                    <input type="text" name="kode" placeholder="Contoh: OBT-006" class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Nama Obat</label>
                    <input type="text" name="nama" placeholder="Nama Lengkap & Dosis" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Farmasi</label>
                    <input type="text" name="farmasi" placeholder="Nama Produsen" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Jenis</label>
                    <select name="jenis" class="form-select">
                        <option value="Tablet">Tablet</option>
                        <option value="Kapsul">Kapsul</option>
                        <option value="Cairan">Cairan</option>
                        <option value="Injeksi">Injeksi</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <select name="kategori" class="form-select">
                        <option value="Antibiotik">Antibiotik</option>
                        <option value="Analgesik">Analgesik</option>
                        <option value="Antiseptik">Antiseptik</option>
                        <option value="Anestesi">Anestesi</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Stok Awal</label>
                    <input type="number" name="stok" value="0" min="0" class="form-input">
                </div>

                <div class="form-divider">
                    <span class="form-divider-text">Informasi Harga (Rp)</span>
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

            <!-- Footer Action -->
            <div class="modal-footer">
                <button type="button" id="btnBatal" class="modal-btn modal-btn-cancel">Batal</button>
                <button type="submit" class="modal-btn modal-btn-submit">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript Logic -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalTambahObat');
        const btnTambah = document.getElementById('btnTambahObat');
        const btnBatal = document.getElementById('btnBatal');
        const btnCloseX = document.getElementById('btnCloseX');
        const form = document.getElementById('formTambahObat');

        // Fungsi Membuka Modal
        const openModal = () => {
            modal.classList.add('open');
        };

        // Fungsi Menutup Modal
        const closeModal = () => {
            modal.classList.remove('open');
            form.reset();
        };

        // Event Listeners
        btnTambah.addEventListener('click', openModal);
        btnBatal.addEventListener('click', closeModal);
        btnCloseX.addEventListener('click', closeModal);

        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });

        // Handle Submit Form
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            closeModal();
        });
    });
</script>