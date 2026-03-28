@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/pharmacy/restock.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
@endpush

<div class="apt-card">
    <!-- Header Tabel Tetap Sama -->
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
            
            <button class="apt-btn-primary" id="btnOpenRestock">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                Restock Dan Return Obat / Barang
            </button>

            <button class="apt-btn-outline-icon" title="Cetak">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            </button>
        </div>
    </div>

    <!-- Tabel Data -->
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
                    <td><span class="px-2 py-1 rounded bg-green-100 text-green-700 text-xs font-bold">Restock</span></td>
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
            </tbody>
        </table>
    </div>
</div>

<!-- ==========================================
     MODAL POP-UP (CSS-Based)
     ========================================== -->
<div id="modalRestock" class="modal-overlay">
    <div class="modal-container" id="modalContent">
        
        <!-- Header -->
        <div class="modal-header">
            <h3 class="modal-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><polyline points="17 11 19 13 23 9"/></svg>
                Transaksi Restock / Return Baru
            </h3>
            <button id="btnCloseX" class="modal-close-btn" type="button">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Form Body -->
        <form class="modal-form" id="formRestock">
            <div class="form-grid">
                
                <div class="form-group">
                    <label class="form-label">No. Faktur / Invoice</label>
                    <input type="text" name="no_faktur" placeholder="Contoh: INV-2026-0301" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Jenis Transaksi</label>
                    <select name="jenis" class="form-select">
                        <option value="Restock">Restock (Barang Masuk)</option>
                        <option value="Return">Return (Barang Kembali)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Supplier</label>
                    <input type="text" name="supplier" placeholder="Ketik nama supplier..." class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Nama Obat / Barang</label>
                    <input type="text" name="nama_obat" placeholder="Contoh: Amoxicillin 500mg" class="form-input" required>
                </div>

                <div class="form-divider">
                    <span class="form-divider-text">Detail Pengiriman & Pembayaran</span>
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal Pengiriman</label>
                    <input type="date" name="tgl_kirim" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Jumlah (Qty)</label>
                    <input type="number" name="jumlah" placeholder="0" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Total Harga</label>
                    <input type="number" name="total_harga" placeholder="Rp 0" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Tempo Pembayaran</label>
                    <input type="text" name="tempo" placeholder="Contoh: Lunas atau 30 Hari" class="form-input">
                </div>

                <div class="form-group full-width">
                    <label class="form-label">Diapprove Oleh</label>
                    <input type="text" name="checker" placeholder="Nama petugas yang menyetujui..." class="form-input">
                </div>
            </div>

            <!-- Footer Action -->
            <div class="modal-footer">
                <button type="button" id="btnCancel" class="modal-btn modal-btn-cancel">
                    Batal
                </button>
                <button type="submit" class="modal-btn modal-btn-submit">
                    Simpan Transaksi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalRestock');
        const btnOpen = document.getElementById('btnOpenRestock');
        const btnCloseX = document.getElementById('btnCloseX');
        const btnCancel = document.getElementById('btnCancel');
        const form = document.getElementById('formRestock');

        const openModal = () => {
            modal.classList.add('open');
        };

        const closeModal = () => {
            modal.classList.remove('open');
            setTimeout(() => {
                form.reset();
            }, 300);
        };

        btnOpen.onclick = openModal;
        btnCancel.onclick = closeModal;
        btnCloseX.onclick = closeModal;

        modal.onclick = (e) => {
            if (e.target === modal) closeModal();
        };

        form.onsubmit = (e) => {
            e.preventDefault();
            alert('Transaksi Berhasil Disimpan!');
            closeModal();
        };
    });
</script>