@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/pharmacy/bhp.css') }}">
@endpush

<div class="apt-card">
    <div class="apt-card-header">
        <div>
            <h2 class="apt-card-title">Data Stok Bahan Habis Pakai</h2>
            <p class="apt-card-subtitle" id="lastUpdateBHP">Memuat data...</p>
        </div>
        <div class="apt-card-actions">
            <div class="apt-search-box">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                <input type="text" placeholder="Cari kode, nama barang atau brand" id="searchBHP">
            </div>

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
                    <div class="apt-dropdown-item active">Semua</div>
                </div>
            </div>
        </div>
    </div>

    <div class="apt-table-wrapper">
        <table class="apt-table" style="min-width:1000px;">
            <thead>
                <tr>
                    <th style="width:40px;"><input type="checkbox" class="apt-checkbox" id="checkAll"></th>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Brand</th>
                    <th>Stok</th>
                    <th>Harga Umum
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2" class="apt-info-icon"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    </th>
                    <th>Harga Beli
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2" class="apt-info-icon"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    </th>
                    <th>Avg HPP</th>
                    <th>Harga OTC</th>
                    <th>Margin Profit</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tabel-bhp">
                <tr>
                    <td colspan="11" style="text-align:center;padding:24px;color:#9CA3AF">Memuat data...</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="apt-pagination">
        <div class="apt-page-size">
            Jumlah baris per halaman:
            <select id="pageSizeBHP">
                <option>10</option>
                <option>25</option>
                <option>50</option>
            </select>
        </div>
        <div class="apt-page-controls">
            <button class="apt-page-btn" id="btnPrevBHP" disabled>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>
            </button>
            <div class="apt-page-info" id="pageInfoBHP">0–0 dari 0 data</div>
            <button class="apt-page-btn" id="btnNextBHP" disabled>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>
            </button>
        </div>
    </div>
</div>

<!-- ====MODAL TAMBAH DATA BHP==== -->
<div id="modalBHP" class="modal-overlay">
    <div class="modal-container" style="max-height:90vh; overflow-y:auto;">
        <div class="modal-header">
            <h3 class="modal-title">Tambah Data Bahan Habis Pakai Baru</h3>
            <button id="btnCloseX" class="modal-close-btn" type="button">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
            </button>
        </div>
        <form class="modal-form" id="formBHP">
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Kode Barang</label>
                    <input type="text" name="item_code" placeholder="BHP-XXX" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Barang <span style="color:#EF4444">*</span></label>
                    <input type="text" name="item_name" placeholder="Contoh: Masker Bedah" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Brand</label>
                    <input type="text" name="brand" placeholder="Contoh: OneMed" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Stok Awal</label>
                    <input type="number" name="initial_stock" value="0" min="0" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Minimum Stok</label>
                    <input type="number" name="min_stock" value="0" min="0" class="form-input">
                </div>

                <div class="form-divider">
                    <span class="form-divider-text">Informasi Keuangan (Rp)</span>
                </div>

                <div class="form-group">
                    <label class="form-label">Harga Beli</label>
                    <input type="number" name="purchase_price" placeholder="0" min="0" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Harga Umum</label>
                    <input type="number" name="general_price" placeholder="0" min="0" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Harga OTC</label>
                    <input type="number" name="otc_price" placeholder="0" min="0" class="form-input">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnCancel" class="modal-btn modal-btn-cancel">Batal</button>
                <button type="submit" class="modal-btn modal-btn-submit">Simpan Barang</button>
            </div>
        </form>
    </div>
</div>

<!-- ====MODAL EDIT DATA BHP==== -->
<div id="modalEditBHP" class="modal-overlay">
    <div class="modal-container" style="max-height:90vh; overflow-y:auto;">
        <div class="modal-header">
            <h3 class="modal-title">Edit Data Bahan Habis Pakai</h3>
            <button id="btnCloseEditX" class="modal-close-btn" type="button">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
            </button>
        </div>
        <form class="modal-form" id="formEditBHP">
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Kode Barang</label>
                    <input type="text" name="item_code" placeholder="BHP-XXX" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Barang <span style="color:#EF4444">*</span></label>
                    <input type="text" name="item_name" placeholder="Contoh: Masker Bedah" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Brand</label>
                    <input type="text" name="brand" placeholder="Contoh: OneMed" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Stok Saat Ini</label>
                    <input type="number" name="current_stock" class="form-input" disabled
                        style="background:#F3F4F6;color:#6B7280;cursor:not-allowed;">
                </div>
                <div class="form-group">
                    <label class="form-label">Minimum Stok</label>
                    <input type="number" name="min_stock" value="0" min="0" class="form-input">
                </div>

                <div class="form-divider">
                    <span class="form-divider-text">Informasi Keuangan (Rp)</span>
                </div>

                <div class="form-group">
                    <label class="form-label">Harga Beli</label>
                    <input type="number" name="purchase_price" placeholder="0" min="0" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Harga Umum</label>
                    <input type="number" name="general_price" placeholder="0" min="0" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Harga OTC</label>
                    <input type="number" name="otc_price" placeholder="0" min="0" class="form-input">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnBatalEdit" class="modal-btn modal-btn-cancel">Batal</button>
                <button type="button" onclick="simpanEditBHP()" class="modal-btn modal-btn-submit">Update Data</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
(function () {
    const CSRF       = document.querySelector('meta[name="csrf-token"]').content;
    const BASE_URL   = '/admin/pharmacy/bhp/items';
    let editId       = null;
    let pageSizeVal  = 10;
    let currentSearch = '';

    // ─── FORMAT RUPIAH ────────────────────────────────────────
    function rp(angka) {
        if (angka == null || angka === '') return '-';
        return 'Rp ' + Number(angka).toLocaleString('id-ID');
    }

    // ─── LOAD TABEL ──────────────────────────────────────────
    async function loadBHP(search = '', page = 1) {
        currentSearch = search;
        const params = new URLSearchParams();
        if (search) params.append('search', search);
        params.append('page', page);
        params.append('per_page', pageSizeVal);

        try {
            const res  = await fetch(`${BASE_URL}?${params.toString()}`, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
            });
            const json = await res.json();

            // Support both paginated { data: { data: [...] } } and flat { data: [...] }
            const paginated    = json.data;
            const rows         = paginated?.data ?? json.data ?? [];
            const total        = paginated?.total   ?? rows.length;
            const currentPage  = paginated?.current_page ?? 1;
            const lastPage     = paginated?.last_page    ?? 1;
            const from         = paginated?.from ?? (rows.length ? 1 : 0);
            const to           = paginated?.to   ?? rows.length;

            renderTabel(rows);
            renderPagination(from, to, total, currentPage, lastPage, search);
            updateLastUpdate();
        } catch (err) {
            document.getElementById('tabel-bhp').innerHTML =
                `<tr><td colspan="11" style="text-align:center;padding:24px;color:#EF4444">Gagal memuat data: ${err.message}</td></tr>`;
        }
    }

    function renderTabel(data) {
        const tbody = document.getElementById('tabel-bhp');
        if (!tbody) return;

        if (!data.length) {
            tbody.innerHTML = `<tr><td colspan="11" style="text-align:center;padding:24px;color:#9CA3AF">Belum ada data bahan habis pakai.</td></tr>`;
            return;
        }

        tbody.innerHTML = data.map(item => {
            // Hitung margin jika belum disediakan backend
            let margin = '-';
            if (item.margin_profit_percent != null) {
                margin = item.margin_profit_percent + '%';
            } else if (item.purchase_price && item.general_price && item.purchase_price > 0) {
                const m = ((item.general_price - item.purchase_price) / item.purchase_price * 100).toFixed(1);
                margin = m + '%';
            }

            const itemName = (item.item_name ?? '-').replace(/'/g, "\\'");

            return `
            <tr>
                <td><input type="checkbox" class="apt-checkbox row-check" data-id="${item.id}"></td>
                <td>${item.item_code ?? '-'}</td>
                <td>${item.item_name ?? '-'}</td>
                <td>${item.brand ?? '-'}</td>
                <td>${item.current_stock ?? 0}</td>
                <td>${rp(item.general_price)}</td>
                <td>${rp(item.purchase_price)}</td>
                <td>${rp(item.avg_hpp)}</td>
                <td>${rp(item.otc_price)}</td>
                <td>${margin}</td>
                <td>
                    <div style="display:flex;gap:6px;">
                        <button class="apt-btn-outline" onclick="bukaEditBHP('${item.id}')">Edit</button>
                        <button class="apt-btn-outline" style="color:#EF4444;border-color:#FEE2E2;"
                            onclick="hapusBHP('${item.id}', '${itemName}')">Hapus</button>
                    </div>
                </td>
            </tr>`;
        }).join('');

        // Check all handler
        document.getElementById('checkAll')?.addEventListener('change', function () {
            document.querySelectorAll('.row-check').forEach(cb => cb.checked = this.checked);
        });
    }

    function renderPagination(from, to, total, currentPage, lastPage, search) {
        const info    = document.getElementById('pageInfoBHP');
        const btnPrev = document.getElementById('btnPrevBHP');
        const btnNext = document.getElementById('btnNextBHP');

        if (info) info.textContent = `${from ?? 0}–${to ?? 0} dari ${total} data`;

        if (btnPrev) {
            btnPrev.disabled = currentPage <= 1;
            btnPrev.onclick  = () => loadBHP(search, currentPage - 1);
        }
        if (btnNext) {
            btnNext.disabled = currentPage >= lastPage;
            btnNext.onclick  = () => loadBHP(search, currentPage + 1);
        }
    }

    function updateLastUpdate() {
        const el = document.getElementById('lastUpdateBHP');
        if (el) {
            const now = new Date();
            const tgl = now.toLocaleDateString('id-ID', { day:'2-digit', month:'2-digit', year:'numeric' });
            const jam = now.toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' });
            el.textContent = `Last Update: ${tgl} ${jam}`;
        }
    }

    // ─── SIMPAN (TAMBAH / EDIT) ───────────────────────────────
    async function simpanBHP(form, url, method) {
        const raw  = Object.fromEntries(new FormData(form).entries());
        const body = {};

        const numericFields = ['initial_stock', 'min_stock', 'purchase_price',
                               'general_price', 'otc_price', 'avg_hpp'];

        Object.keys(raw).forEach(k => {
            body[k] = numericFields.includes(k) && raw[k] !== ''
                ? Number(raw[k])
                : raw[k];
        });

        const btnSubmit = form.querySelector('[type="submit"]')
                       ?? form.querySelector('button[onclick="simpanEditBHP()"]');
        const origText  = btnSubmit?.textContent;
        if (btnSubmit) { btnSubmit.disabled = true; btnSubmit.textContent = 'Menyimpan...'; }

        try {
            const res  = await fetch(url, {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept':       'application/json',
                    'X-CSRF-TOKEN': CSRF
                },
                body: JSON.stringify(body)
            });

            const json = await res.json();

            if (res.ok) {
                tutupSemua();
                form.reset();
                loadBHP(currentSearch);
            } else {
                const msgs = Object.values(json.errors ?? {}).flat().join('\n');
                alert('Gagal:\n' + (msgs || json.message || 'Terjadi kesalahan.'));
            }
        } catch (err) {
            alert('Error jaringan: ' + err.message);
        } finally {
            if (btnSubmit) {
                btnSubmit.disabled    = false;
                btnSubmit.textContent = origText;
            }
        }
    }

    // ─── EDIT ────────────────────────────────────────────────
    window.bukaEditBHP = async function (id) {
        editId = id;

        try {
            const res  = await fetch(`${BASE_URL}/${id}`, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
            });
            const json = await res.json();
            const item = json.data ?? json;

            const form = document.getElementById('formEditBHP');
            if (!form) return;

            const fields = ['item_code', 'item_name', 'brand',
                            'current_stock', 'min_stock', 'purchase_price',
                            'general_price', 'otc_price'];

            fields.forEach(f => {
                const el = form.querySelector(`[name="${f}"]`);
                if (el) el.value = item[f] ?? '';
            });

            document.getElementById('modalEditBHP')?.classList.add('open');
        } catch (err) {
            alert('Gagal memuat data: ' + err.message);
        }
    };

    window.simpanEditBHP = function () {
        if (!editId) return;
        const form = document.getElementById('formEditBHP');
        simpanBHP(form, `${BASE_URL}/${editId}`, 'PUT');
    };

    // ─── HAPUS ────────────────────────────────────────────────
    window.hapusBHP = async function (id, nama) {
        if (!confirm(`Hapus barang "${nama}"? Tindakan ini tidak dapat dibatalkan.`)) return;

        try {
            const res = await fetch(`${BASE_URL}/${id}`, {
                method:  'DELETE',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
            });

            if (res.ok) {
                loadBHP(currentSearch);
            } else {
                const json = await res.json().catch(() => ({}));
                alert('Gagal menghapus: ' + (json.message || 'Terjadi kesalahan.'));
            }
        } catch (err) {
            alert('Error jaringan: ' + err.message);
        }
    };

    // ─── MODAL HELPERS ────────────────────────────────────────
    function tutupSemua() {
        document.getElementById('modalBHP')?.classList.remove('open');
        document.getElementById('modalEditBHP')?.classList.remove('open');
        editId = null;
    }

    // ─── INIT ─────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', () => {
        loadBHP();

        // Search dengan debounce
        const inputSearch = document.getElementById('searchBHP');
        if (inputSearch) {
            let timer;
            inputSearch.addEventListener('input', () => {
                clearTimeout(timer);
                timer = setTimeout(() => loadBHP(inputSearch.value.trim()), 400);
            });
        }

        // Page size
        const pageSizeEl = document.getElementById('pageSizeBHP');
        if (pageSizeEl) {
            pageSizeEl.addEventListener('change', () => {
                pageSizeVal = Number(pageSizeEl.value);
                loadBHP(currentSearch);
            });
        }

        // Buka modal tambah
        document.getElementById('btnOpenModal')?.addEventListener('click', () => {
            document.getElementById('modalBHP')?.classList.add('open');
        });

        // Tutup modal tambah
        document.getElementById('btnCancel')?.addEventListener('click', tutupSemua);
        document.getElementById('btnCloseX')?.addEventListener('click', tutupSemua);

        // Tutup modal edit
        document.getElementById('btnBatalEdit')?.addEventListener('click', tutupSemua);
        document.getElementById('btnCloseEditX')?.addEventListener('click', tutupSemua);

        // Klik luar modal (overlay)
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', e => {
                if (e.target === overlay) tutupSemua();
            });
        });

        // Submit form tambah
        document.getElementById('formBHP')?.addEventListener('submit', async (e) => {
            e.preventDefault();
            await simpanBHP(e.target, BASE_URL, 'POST');
        });
    });
})();
</script>
@endpush