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
                    <th>Harga Umum</th>
                    <th>Harga Beli</th>
                    <th>Avg HPP</th>
                    <th>Harga OTC</th>
                    <th>Margin Profit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="tabel-obat">
                <tr>
                    <td colspan="12" style="text-align:center;padding:24px;color:#9CA3AF">Memuat data...</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="apt-pagination">
        <div class="apt-page-size">Jumlah baris per halaman:
            <select id="pageSizeSelect">
                <option>10</option>
                <option>25</option>
                <option>50</option>
            </select>
        </div>
        <div class="apt-page-controls">
            <button class="apt-page-btn" id="btnPrev" disabled>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>
            </button>
            <div class="apt-page-info" id="pageInfo">1–10 dari 0 data</div>
            <button class="apt-page-btn" id="btnNext" disabled>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>
            </button>
        </div>
    </div>
</div>

<!-- ====MODAL TAMBAH DATA OBAT==== -->
<div id="modalTambahObat" class="modal-overlay">
    <div class="modal-container" style="max-height:90vh; overflow-y:auto;">
        <div class="modal-header">
            <h3 class="modal-title">Tambah Data Obat Baru</h3>
            <button id="btnCloseX" class="modal-close-btn" type="button">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
            </button>
        </div>
        <form class="modal-form" id="formTambahObat">
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Kode Obat</label>
                    <input type="text" name="medicine_code" placeholder="Contoh: OBT-006" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Obat <span style="color:#EF4444">*</span></label>
                    <input type="text" name="medicine_name" placeholder="Nama Lengkap & Dosis" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Farmasi</label>
                    <input type="text" name="manufacturer" placeholder="Nama Produsen" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Jenis</label>
                    <select name="medicine_type" class="form-select">
                        <option value="">-- Pilih Jenis --</option>
                        <option value="Tablet">Tablet</option>
                        <option value="Kapsul">Kapsul</option>
                        <option value="Cairan">Cairan</option>
                        <option value="Injeksi">Injeksi</option>
                        <option value="Salep">Salep</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <input type="text" name="category" placeholder="Contoh: Antibiotik" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Satuan</label>
                    <input type="text" name="unit" placeholder="Contoh: Strip, Botol" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Stok Awal</label>
                    <input type="number" name="current_stock" value="0" min="0" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Minimum Stok</label>
                    <input type="number" name="minimum_stock" value="0" min="0" class="form-input">
                </div>
                <div class="form-divider">
                    <span class="form-divider-text">Informasi Harga (Rp)</span>
                </div>
                <div class="form-group">
                    <label class="form-label">Harga Beli</label>
                    <input type="number" name="purchase_price" placeholder="0" min="0" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Harga Umum</label>
                    <input type="number" name="selling_price_general" placeholder="0" min="0" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Harga OTC</label>
                    <input type="number" name="selling_price_otc" placeholder="0" min="0" class="form-input">
                </div>
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label class="form-label">Catatan</label>
                    <textarea name="notes" placeholder="Catatan tambahan..." class="form-input" rows="2" style="resize:vertical;"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnBatal" class="modal-btn modal-btn-cancel">Batal</button>
                <button type="submit" class="modal-btn modal-btn-submit">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<!-- ====MODAL EDIT DATA OBAT==== -->
<div id="modalEditObat" class="modal-overlay">
    <div class="modal-container" style="max-height:90vh; overflow-y:auto;">
        <div class="modal-header">
            <h3 class="modal-title">Edit Data Obat</h3>
            <button id="btnCloseEditX" class="modal-close-btn" type="button">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
            </button>
        </div>
        <form class="modal-form" id="formEditObat">
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Kode Obat</label>
                    <input type="text" name="medicine_code" placeholder="Contoh: OBT-006" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Obat <span style="color:#EF4444">*</span></label>
                    <input type="text" name="medicine_name" placeholder="Nama Lengkap & Dosis" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Farmasi</label>
                    <input type="text" name="manufacturer" placeholder="Nama Produsen" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Jenis</label>
                    <select name="medicine_type" class="form-select">
                        <option value="">-- Pilih Jenis --</option>
                        <option value="Tablet">Tablet</option>
                        <option value="Kapsul">Kapsul</option>
                        <option value="Cairan">Cairan</option>
                        <option value="Injeksi">Injeksi</option>
                        <option value="Salep">Salep</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <input type="text" name="category" placeholder="Contoh: Antibiotik" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Satuan</label>
                    <input type="text" name="unit" placeholder="Contoh: Strip, Botol" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Minimum Stok</label>
                    <input type="number" name="minimum_stock" value="0" min="0" class="form-input">
                </div>
                <div class="form-divider">
                    <span class="form-divider-text">Informasi Harga (Rp)</span>
                </div>
                <div class="form-group">
                    <label class="form-label">Harga Beli</label>
                    <input type="number" name="purchase_price" placeholder="0" min="0" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Harga Umum</label>
                    <input type="number" name="selling_price_general" placeholder="0" min="0" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Harga OTC</label>
                    <input type="number" name="selling_price_otc" placeholder="0" min="0" class="form-input">
                </div>
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label class="form-label">
                        Avg HPP
                        <span style="font-size:11px;font-weight:400;color:#F59E0B;margin-left:6px;">
                            ⚠️ Ubah hanya jika terjadi kesalahan input. Nilai normal dihitung otomatis saat Stock In.
                        </span>
                    </label>
                    <input type="number" name="avg_hpp" placeholder="0" min="0" class="form-input"
                        style="border-color:#FDE68A;background:#FFFBEB;">
                </div>
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label class="form-label">Catatan</label>
                    <textarea name="notes" placeholder="Catatan tambahan..." class="form-input" rows="2" style="resize:vertical;"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnBatalEdit" class="modal-btn modal-btn-cancel">Batal</button>
                <button type="button" onclick="simpanEdit()" class="modal-btn modal-btn-submit">Update Data</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
(function () {
    const CSRF = document.querySelector('meta[name="csrf-token"]').content;
    let editId   = null;
    let pageSizeVal = 10;

    // ─── LOAD TABEL ──────────────────────────────────────────
    async function loadObat(search = '', page = 1) {
        const params = new URLSearchParams();
        if (search) params.append('search', search);
        params.append('page', page);
        params.append('per_page', pageSizeVal);

        const res  = await fetch(`/admin/pharmacy/medicine?${params.toString()}`, {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
        });
        const json = await res.json();

        const paginatedData = json.data;           // Laravel paginator object
        const rows          = paginatedData?.data ?? json.data ?? [];
        const total         = paginatedData?.total ?? rows.length;
        const currentPage   = paginatedData?.current_page ?? 1;
        const lastPage      = paginatedData?.last_page ?? 1;
        const from          = paginatedData?.from ?? 1;
        const to            = paginatedData?.to ?? rows.length;

        renderTabel(rows);
        renderPagination(from, to, total, currentPage, lastPage, search);
    }

    function renderTabel(data) {
        const tbody = document.getElementById('tabel-obat');
        if (!tbody) return;

        if (!data.length) {
            tbody.innerHTML = `<tr><td colspan="12" style="text-align:center;padding:24px;color:#9CA3AF">Belum ada data obat.</td></tr>`;
            return;
        }

        tbody.innerHTML = data.map(o => `
            <tr>
                <td>${o.medicine_code ?? '-'}</td>
                <td>${o.medicine_name ?? '-'}</td>
                <td>${o.manufacturer ?? '-'}</td>
                <td>${o.medicine_type ?? '-'}</td>
                <td>${o.category ?? '-'}</td>
                <td>${o.current_stock ?? 0}</td>
                <td>${rp(o.selling_price_general)}</td>
                <td>${rp(o.purchase_price)}</td>
                <td>${rp(o.avg_hpp)}</td>
                <td>${rp(o.selling_price_otc)}</td>
                <td>${o.margin_profit_percent != null ? o.margin_profit_percent + '%' : '-'}</td>
                <td>
                    <div style="display:flex;gap:6px;">
                        <button class="apt-btn-outline" onclick="bukaEdit('${o.id}')">Edit</button>
                        <button class="apt-btn-outline" style="color:#EF4444;border-color:#FEE2E2;"
                            onclick="hapusObat('${o.id}', '${(o.medicine_name ?? '').replace(/'/g, "\\'")}')">Hapus</button>
                    </div>
                </td>
            </tr>
        `).join('');
    }

    function renderPagination(from, to, total, currentPage, lastPage, search) {
        const info    = document.getElementById('pageInfo');
        const btnPrev = document.getElementById('btnPrev');
        const btnNext = document.getElementById('btnNext');

        if (info) info.textContent = `${from ?? 0}–${to ?? 0} dari ${total} data`;

        if (btnPrev) {
            btnPrev.disabled = currentPage <= 1;
            btnPrev.onclick  = () => loadObat(search, currentPage - 1);
        }
        if (btnNext) {
            btnNext.disabled = currentPage >= lastPage;
            btnNext.onclick  = () => loadObat(search, currentPage + 1);
        }
    }

    // ─── SIMPAN (TAMBAH / EDIT) ───────────────────────────────
    async function simpanObat(form, url, method) {
        const raw  = Object.fromEntries(new FormData(form).entries());
        const body = {};

        // Kirim semua field, konversi angka
        const numericFields = ['current_stock','minimum_stock','purchase_price',
                               'selling_price_general','selling_price_otc','avg_hpp'];

        Object.keys(raw).forEach(k => {
            body[k] = numericFields.includes(k) && raw[k] !== ''
                ? Number(raw[k])
                : raw[k];
        });

        const btnSubmit = form.querySelector('[type="submit"]') 
                       ?? form.querySelector('button[onclick="simpanEdit()"]');
        if (btnSubmit) { btnSubmit.disabled = true; btnSubmit.textContent = 'Menyimpan...'; }

        try {
            const res  = await fetch(url, {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF
                },
                body: JSON.stringify(body)
            });

            const json = await res.json();

            if (res.ok) {
                tutupSemua();
                form.reset();
                loadObat();
            } else {
                const msgs = Object.values(json.errors ?? {}).flat().join('\n');
                alert('Gagal:\n' + (msgs || json.message || 'Terjadi kesalahan.'));
            }
        } catch (err) {
            alert('Error jaringan: ' + err.message);
        } finally {
            if (btnSubmit) {
                btnSubmit.disabled = false;
                btnSubmit.textContent = method === 'PUT' ? 'Update Data' : 'Simpan Data';
            }
        }
    }

    // ─── EDIT ────────────────────────────────────────────────
    window.bukaEdit = async function (id) {
        editId = id;
        const res  = await fetch(`/admin/pharmacy/medicine/${id}`, {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
        });
        const json = await res.json();
        const o    = json.data ?? json;

        const form = document.getElementById('formEditObat');
        if (!form) return;

        // Isi semua field sesuai name
        const fields = ['medicine_code','medicine_name','manufacturer','medicine_type',
                        'category','unit','minimum_stock','purchase_price',
                        'selling_price_general','selling_price_otc','avg_hpp','notes'];

        fields.forEach(f => {
            const el = form.querySelector(`[name="${f}"]`);
            if (el) el.value = o[f] ?? '';
        });

        document.getElementById('modalEditObat')?.classList.add('open');
    };

    window.simpanEdit = function () {
        if (!editId) return;
        const form = document.getElementById('formEditObat');
        simpanObat(form, `/admin/pharmacy/medicine/${editId}`, 'PUT');
    };

    // ─── HAPUS ────────────────────────────────────────────────
    window.hapusObat = async function (id, nama) {
        if (!confirm(`Hapus obat "${nama}"?`)) return;

        const res = await fetch(`/admin/pharmacy/medicine/${id}`, {
            method: 'DELETE',
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
        });

        if (res.ok) {
            loadObat();
        } else {
            alert('Gagal menghapus data.');
        }
    };

    // ─── MODAL HELPERS ────────────────────────────────────────
    function tutupSemua() {
        document.getElementById('modalTambahObat')?.classList.remove('open');
        document.getElementById('modalEditObat')?.classList.remove('open');
        editId = null;
    }

    // ─── HELPER FORMAT RUPIAH ─────────────────────────────────
    function rp(angka) {
        if (angka == null || angka === '') return '-';
        return 'Rp ' + Number(angka).toLocaleString('id-ID');
    }

    // ─── INIT ─────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', () => {
        loadObat();

        // Search
        const inputSearch = document.querySelector('.apt-search-box input');
        if (inputSearch) {
            let timer;
            inputSearch.addEventListener('input', () => {
                clearTimeout(timer);
                timer = setTimeout(() => loadObat(inputSearch.value.trim()), 400);
            });
        }

        // Page size
        const pageSizeEl = document.getElementById('pageSizeSelect');
        if (pageSizeEl) {
            pageSizeEl.addEventListener('change', () => {
                pageSizeVal = Number(pageSizeEl.value);
                loadObat();
            });
        }

        // Modal tambah
        document.getElementById('btnTambahObat')?.addEventListener('click', () => {
            document.getElementById('modalTambahObat')?.classList.add('open');
        });

        // Tombol batal & close X — tambah
        document.getElementById('btnBatal')?.addEventListener('click', tutupSemua);
        document.getElementById('btnCloseX')?.addEventListener('click', tutupSemua);

        // Tombol batal & close X — edit
        document.getElementById('btnBatalEdit')?.addEventListener('click', tutupSemua);
        document.getElementById('btnCloseEditX')?.addEventListener('click', tutupSemua);

        // Klik luar modal
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', e => {
                if (e.target === overlay) tutupSemua();
            });
        });

        // Form submit tambah
        document.getElementById('formTambahObat')?.addEventListener('submit', async (e) => {
            e.preventDefault();
            await simpanObat(e.target, '/admin/pharmacy/medicine', 'POST');
        });
    });
})();
</script>
@endpush