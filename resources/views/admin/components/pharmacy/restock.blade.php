@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/pharmacy/restock.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
@endpush

<div class="apt-card">
    <!-- Header -->
    <div class="apt-card-header">
        <div>
            <h2 class="apt-card-title">Restock dan Return</h2>
            <p class="apt-card-subtitle" id="lastCreate">Memuat data...</p>
        </div>
        <div class="apt-card-actions">
            <div class="apt-search-box">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                <input type="text" id="searchInput" placeholder="Cari kode / tanggal jatuh tempo">
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
        <table class="apt-table" style="min-width:1300px;">
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
            <tbody id="tabel-restock">
                <tr>
                    <td colspan="12" style="text-align:center;padding:24px;color:#9CA3AF">Memuat data...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- ==========================================
     MODAL RESTOCK / RETURN
     ========================================== -->
<div id="modalRestock" class="modal-overlay">
    <div class="modal-container" id="modalContent">
        <div class="modal-header">
            <h3 class="modal-title" id="modalRestockTitle">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><polyline points="17 11 19 13 23 9"/></svg>
                Transaksi Restock / Return Baru
            </h3>
            <button id="btnCloseX" class="modal-close-btn" type="button">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
            </button>
        </div>

        <form class="modal-form" id="formRestock">
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">No. Faktur / Invoice</label>
                    <input type="text" name="no_faktur" placeholder="Contoh: INV-2026-0301" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Jenis Transaksi</label>
                    <select name="jenis" id="selectJenis" class="form-select">
                        <option value="restock">Restock (Barang Masuk)</option>
                        <option value="return">Return (Barang Kembali)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Supplier</label>
                    <input type="text" name="supplier" placeholder="Ketik nama supplier..." class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Kategori Item</label>
                    <select id="selectKategori" name="kategori_item" class="form-select">
                        <option value="obat">Obat</option>
                        <option value="bhp">Bahan Habis Pakai (BHP)</option>
                    </select>
                </div>
                <div class="form-group full-width">
                    <label class="form-label">Nama Obat / Barang <span style="color:#EF4444">*</span></label>
                    <select id="selectItem" name="item_id" class="form-select" required>
                        <option value="">-- Pilih Item --</option>
                    </select>
                    <p id="infoStok" style="font-size:12px;color:#6B7280;margin-top:4px;"></p>
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
                    <input type="number" name="jumlah" placeholder="0" min="1" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Total Harga</label>
                    <input type="number" name="total_harga" placeholder="Rp 0" min="0" class="form-input">
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
            <div class="modal-footer">
                <button type="button" id="btnCancel" class="modal-btn modal-btn-cancel">Batal</button>
                <button type="submit" id="btnSubmit" class="modal-btn modal-btn-submit">Simpan Transaksi</button>
            </div>
        </form>
    </div>
</div>

<!-- ==========================================
     MODAL DETAIL
     ========================================== -->
<div id="modalDetail" class="modal-overlay">
    <div class="modal-container" style="max-width:500px;">
        <div class="modal-header">
            <h3 class="modal-title">Detail Transaksi</h3>
            <button id="btnCloseDetail" class="modal-close-btn" type="button">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
            </button>
        </div>
        <div id="isiDetail" style="padding: 4px 0;"></div>
        <div class="modal-footer" style="padding:12px 24px;margin-top:0;display:flex;justify-content:space-between;align-items:center;">
            <button type="button" id="btnHapusDetail" class="modal-btn"
                style="background:#FEE2E2;color:#991B1B;border:1px solid #FECACA;font-weight:600;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:4px;vertical-align:middle;">
                    <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/>
                </svg>
                Hapus
            </button>
            <div style="display:flex;gap:8px;">
                <button type="button" id="btnTutupDetail" class="modal-btn modal-btn-cancel">Tutup</button>
                <button type="button" id="btnEditDetail" class="modal-btn modal-btn-submit">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:4px;vertical-align:middle;">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    Edit
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const CSRF           = document.querySelector('meta[name="csrf-token"]').content;
    const modal          = document.getElementById('modalRestock');
    const btnOpen        = document.getElementById('btnOpenRestock');
    const btnCloseX      = document.getElementById('btnCloseX');
    const btnCancel      = document.getElementById('btnCancel');
    const form           = document.getElementById('formRestock');
    const selectKategori = document.getElementById('selectKategori');
    const selectItem     = document.getElementById('selectItem');
    const infoStok       = document.getElementById('infoStok');

    let allRows       = [];
    let searchQuery   = '';
    let currentDetail = {};

    // ── LOAD TABEL ───────────────────────────────────────────
    async function loadTabel() {
        const tbody = document.getElementById('tabel-restock');
        tbody.innerHTML = `<tr><td colspan="12" style="text-align:center;padding:24px;color:#9CA3AF">Memuat data...</td></tr>`;
        
        try {
            const [resBhp, resObat] = await Promise.all([
                fetch('/api/bhp/restock',             { headers: { 'Accept': 'application/json' } }),
                fetch('/api/medicine/stock-mutations', { headers: { 'Accept': 'application/json' } }),
            ]);
            const bhp  = await resBhp.json();
            const obat = await resObat.json();

            allRows = [
                ...(bhp.data  ?? []),
                ...(obat.data ?? []),
            ].sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

            if (allRows.length > 0) {
                const tgl = new Date(allRows[0].created_at).toLocaleDateString('id-ID');
                document.getElementById('lastCreate').textContent = 'Last Create: ' + tgl;
            } else {
                document.getElementById('lastCreate').textContent = 'Belum ada transaksi';
            }

            renderTabel();
        } catch (err) {
            tbody.innerHTML = `<tr><td colspan="12" style="text-align:center;padding:24px;color:#EF4444">Gagal memuat data: ${err.message}</td></tr>`;
        }
    }

    function renderTabel() {
        const tbody = document.getElementById('tabel-restock');
        let data = [...allRows];

        if (searchQuery) {
            const q = searchQuery.toLowerCase();
            data = data.filter(r =>
                (r.item?.item_name ?? '').toLowerCase().includes(q) ||
                (r.notes ?? '').toLowerCase().includes(q) ||
                (r.batch_number ?? '').toLowerCase().includes(q)
            );
        }

        if (!data.length) {
            tbody.innerHTML = `<tr><td colspan="12" style="text-align:center;padding:24px;color:#9CA3AF">Belum ada data restock.</td></tr>`;
            return;
        }

        tbody.innerHTML = data.map((r, i) => {
            const notes    = r.notes ?? '';
            const noFaktur = notes.match(/No Faktur: ([^|]+)/)?.[1]?.trim() ?? '-';
            const supplier = notes.match(/Supplier: ([^|]+)/)?.[1]?.trim() ?? '-';
            const checker  = notes.match(/Approve: ([^|]+)/)?.[1]?.trim() ?? '-';
            const tempo    = notes.match(/Tempo: ([^|]+)/)?.[1]?.trim() ?? '-';
            const tglKirim = notes.match(/Kirim: ([^|]+)/)?.[1]?.trim() ?? '-';
            const kode     = 'RST-' + String(allRows.length - i).padStart(3, '0');
            const jumlah   = r.restock_type === 'restock' ? r.quantity_added : r.quantity_returned;
            const tglBuat  = r.created_at ? new Date(r.created_at).toLocaleDateString('id-ID') : '-';
            const nama     = r.item?.item_name ?? '-';
            const source   = r._source ?? 'bhp';
            const itemId   = r.bhp_id ?? r.medicine_id ?? '';

            // ✅ FIX harga: purchase_price sudah di-map dari unit_price di controller
            const hargaVal = Number(r.purchase_price ?? 0);
            const harga    = hargaVal > 0 ? 'Rp ' + hargaVal.toLocaleString('id-ID') : '-';

            const esc = (s) => String(s ?? '').replace(/'/g, "\\'");

            return `<tr>
                <td>${kode}</td>
                <td>${noFaktur}</td>
                <td>
                    <span class="px-2 py-1 rounded text-xs font-bold"
                        style="background:${r.restock_type === 'restock' ? '#D1FAE5' : '#FEE2E2'};
                               color:${r.restock_type === 'restock' ? '#065F46' : '#991B1B'}">
                        ${r.restock_type === 'restock' ? 'Restock' : 'Return'}
                    </span>
                </td>
                <td>${tglKirim}</td>
                <td>${tglBuat}</td>
                <td>${supplier}</td>
                <td>${nama}</td>
                <td>${jumlah ?? 0}</td>
                <td>${checker}</td>
                <td>${harga}</td>
                <td>${tempo}</td>
                <td>
                    <button class="apt-btn-sm"
                        onclick="lihatDetail(
                            '${esc(r.id)}','${esc(kode)}','${esc(noFaktur)}','${esc(r.restock_type)}',
                            '${esc(tglKirim)}','${esc(tglBuat)}','${esc(supplier)}','${esc(nama)}',
                            ${jumlah ?? 0},'${esc(checker)}','${esc(harga)}','${esc(tempo)}',
                            '${esc(r.batch_number ?? '-')}','${esc(source)}','${esc(itemId)}'
                        )">
                        Detail
                    </button>
                </td>
            </tr>`;
        }).join('');
    }

    // ── MODAL DETAIL ─────────────────────────────────────────
    window.lihatDetail = function (id, kode, noFaktur, jenis, tglKirim, tglBuat, supplier, nama, jumlah, checker, harga, tempo, batch, source, itemId) {
        currentDetail = { id, kode, noFaktur, jenis, tglKirim, tglBuat, supplier, nama, jumlah, checker, harga, tempo, batch, source, itemId };

        const rows = [
            ['Kode',               kode],
            ['No Faktur',          noFaktur],
            ['Jenis',              jenis === 'restock' ? 'Restock' : 'Return'],
            ['Nama Item',          nama],
            ['Jumlah',             jumlah],
            ['No. Batch',          batch],
            ['Total Harga',        harga],
            ['Tanggal Pengiriman', tglKirim],
            ['Tanggal Pembuatan',  tglBuat],
            ['Supplier',           supplier],
            ['Diapprove Oleh',     checker],
            ['Tempo Pembayaran',   tempo],
        ];

        document.getElementById('isiDetail').innerHTML = rows.map(([label, val], i) => {
            const isLast  = i === rows.length - 1;
            const isJenis = label === 'Jenis';
            const valDisplay = isJenis
                ? `<span style="display:inline-block;font-size:11px;font-weight:500;padding:3px 12px;border-radius:99px;background:${val === 'Restock' ? '#D1FAE5' : '#FEE2E2'};color:${val === 'Restock' ? '#065F46' : '#991B1B'};">${val}</span>`
                : `<span style="font-size:13px;font-weight:${val === '-' ? '400' : '500'};color:${val === '-' ? 'var(--color-text-secondary)' : 'var(--color-text-primary)'};">${val ?? '-'}</span>`;
            return `
            <div style="display:grid;grid-template-columns:160px 1fr;align-items:center;padding:8px 24px;${!isLast ? 'border-bottom:0.5px solid var(--color-border-tertiary);' : ''}">
                <span style="font-size:13px;color:var(--color-text-secondary);">${label}</span>
                ${valDisplay}
            </div>`;
        }).join('');

        document.getElementById('modalDetail').classList.add('open');
    };

    document.getElementById('btnCloseDetail')?.addEventListener('click', () => {
        document.getElementById('modalDetail').classList.remove('open');
    });
    document.getElementById('btnTutupDetail')?.addEventListener('click', () => {
        document.getElementById('modalDetail').classList.remove('open');
    });
    document.getElementById('modalDetail')?.addEventListener('click', e => {
        if (e.target === document.getElementById('modalDetail'))
            document.getElementById('modalDetail').classList.remove('open');
    });

    // ── EDIT DARI DETAIL ─────────────────────────────────────
    document.getElementById('btnEditDetail')?.addEventListener('click', async () => {
        const d = currentDetail;
        document.getElementById('modalDetail').classList.remove('open');

        selectKategori.value = d.source === 'obat' ? 'obat' : 'bhp';
        await loadItems(selectKategori.value);

        document.getElementById('selectJenis').value = d.jenis;

        // ✅ FIX: set item setelah loadItems selesai
        selectItem.value = d.itemId;
        const stok = selectItem.options[selectItem.selectedIndex]?.dataset?.stok;
        infoStok.textContent = stok !== undefined ? `Stok saat ini: ${stok}` : '';

        form.querySelector('[name="no_faktur"]').value  = d.noFaktur !== '-' ? d.noFaktur : '';
        form.querySelector('[name="supplier"]').value   = d.supplier  !== '-' ? d.supplier  : '';
        form.querySelector('[name="checker"]').value    = d.checker   !== '-' ? d.checker   : '';
        form.querySelector('[name="tempo"]').value      = d.tempo     !== '-' ? d.tempo     : '';
        form.querySelector('[name="jumlah"]').value     = d.jumlah;

        // ✅ FIX: strip "Rp " dan titik ribuan
        const hargaNum = d.harga !== '-' ? d.harga.replace(/[^0-9]/g, '') : '';
        form.querySelector('[name="total_harga"]').value = hargaNum;

        // Konversi tanggal d/m/yyyy → yyyy-mm-dd
        if (d.tglKirim !== '-') {
            const parts = d.tglKirim.split('/');
            if (parts.length === 3) {
                form.querySelector('[name="tgl_kirim"]').value =
                    `${parts[2]}-${String(parts[1]).padStart(2,'0')}-${String(parts[0]).padStart(2,'0')}`;
            }
        }

        form.dataset.editId     = d.id;
        form.dataset.editSource = d.source;
        form.dataset.editItemId = d.itemId;
        form.dataset.editJenis  = d.jenis;

        document.getElementById('modalRestockTitle').innerHTML = `
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
            Edit Transaksi`;
        document.getElementById('btnSubmit').textContent = 'Simpan Perubahan';

        modal.classList.add('open');
    });

    // ── HAPUS DARI DETAIL ────────────────────────────────────
    document.getElementById('btnHapusDetail')?.addEventListener('click', async () => {
        const d = currentDetail;
        if (!confirm(`Hapus transaksi ${d.kode}?\nStok akan dikembalikan secara otomatis.`)) return;

        const btnHapus = document.getElementById('btnHapusDetail');
        btnHapus.disabled    = true;
        btnHapus.textContent = 'Menghapus...';

        try {
            // ✅ FIX: d.itemId = medicine_id, d.id = mutation_id
            const url = d.source === 'obat'
                ? `/api/medicine/${d.itemId}/stock-mutation/${d.id}`
                : `/api/bhp/restock/${d.id}`;

            const res  = await fetch(url, {
                method : 'DELETE',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            });
            const json = await res.json();

            if (res.ok) {
                document.getElementById('modalDetail').classList.remove('open');
                alert('Transaksi berhasil dihapus!');
                loadTabel();
            } else {
                alert('Gagal: ' + (json.message ?? 'Terjadi kesalahan.'));
            }
        } catch (err) {
            alert('Error: ' + err.message);
        } finally {
            btnHapus.disabled    = false;
            btnHapus.textContent = 'Hapus';
        }
    });

    // ── LOAD DROPDOWN ITEM ───────────────────────────────────
    async function loadItems(kategori) {
        selectItem.innerHTML = '<option value="">-- Memuat... --</option>';
        infoStok.textContent = '';

        try {
            const url = kategori === 'obat'
                ? '/api/medicine?per_page=200'
                : '/api/bhp/items';

            const res  = await fetch(url, { headers: { 'Accept': 'application/json' } });
            const json = await res.json();

            const items = kategori === 'obat'
                ? (json.data?.data ?? json.data ?? [])
                : (json.data ?? []);

            selectItem.innerHTML = '<option value="">-- Pilih Item --</option>' +
                items.map(i => {
                    const code = i.medicine_code ?? i.item_code ?? '';
                    const name = i.medicine_name ?? i.item_name ?? '';
                    const stok = i.current_stock ?? 0;
                    return `<option value="${i.id}" data-stok="${stok}" data-name="${name}">${code ? code + ' \u2013 ' : ''}${name} (Stok: ${stok})</option>`;
                }).join('');

        } catch (err) {
            selectItem.innerHTML = '<option value="">Gagal memuat data</option>';
        }
    }

    selectKategori.addEventListener('change', () => loadItems(selectKategori.value));
    selectItem.addEventListener('change', function () {
        const stok = this.options[this.selectedIndex]?.dataset?.stok;
        infoStok.textContent = stok !== undefined ? `Stok saat ini: ${stok}` : '';
    });

    // ── MODAL FORM OPEN / CLOSE ──────────────────────────────
    function resetModalForm() {
        form.reset();
        infoStok.textContent = '';
        delete form.dataset.editId;
        delete form.dataset.editSource;
        delete form.dataset.editItemId;
        delete form.dataset.editJenis;
        document.getElementById('modalRestockTitle').innerHTML = `
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="8.5" cy="7" r="4"/><polyline points="17 11 19 13 23 9"/>
            </svg>
            Transaksi Restock / Return Baru`;
        document.getElementById('btnSubmit').textContent = 'Simpan Transaksi';
    }

    const openModal = () => {
        modal.classList.add('open');
        loadItems(selectKategori.value);
    };
    const closeModal = () => {
        modal.classList.remove('open');
        setTimeout(() => resetModalForm(), 300);
    };

    btnOpen.onclick   = openModal;
    btnCancel.onclick = closeModal;
    btnCloseX.onclick = closeModal;
    modal.onclick = (e) => { if (e.target === modal) closeModal(); };

    // ── SUBMIT FORM (CREATE & EDIT) ───────────────────────────
    form.onsubmit = async (e) => {
        e.preventDefault();

        const isEdit     = !!form.dataset.editId;
        const editId     = form.dataset.editId;
        const editSource = form.dataset.editSource;
        const editItemId = form.dataset.editItemId;

        const kategori = selectKategori.value;
        const itemId   = selectItem.value;
        const jenis    = document.getElementById('selectJenis').value;
        const jumlah   = parseInt(form.querySelector('[name="jumlah"]').value) || 0;
        const harga    = parseFloat(form.querySelector('[name="total_harga"]').value) || 0;
        const noFaktur = form.querySelector('[name="no_faktur"]').value;
        const supplier = form.querySelector('[name="supplier"]').value;
        const checker  = form.querySelector('[name="checker"]').value;
        const tempo    = form.querySelector('[name="tempo"]').value;
        const tglKirim = form.querySelector('[name="tgl_kirim"]').value;

        const notes = [
            noFaktur ? `No Faktur: ${noFaktur}` : '',
            supplier ? `Supplier: ${supplier}` : '',
            checker  ? `Approve: ${checker}` : '',
            tempo    ? `Tempo: ${tempo}` : '',
            tglKirim ? `Kirim: ${new Date(tglKirim).toLocaleDateString('id-ID')}` : '',
        ].filter(Boolean).join(' | ');

        if (!itemId) { alert('Pilih item terlebih dahulu.'); return; }
        if (!jumlah) { alert('Jumlah harus diisi minimal 1.'); return; }

        const btnSubmit = document.getElementById('btnSubmit');
        btnSubmit.disabled    = true;
        btnSubmit.textContent = 'Menyimpan...';

        try {
            // Mode edit: hapus data lama dulu
            if (isEdit) {
                const delUrl = editSource === 'obat'
                    ? `/api/medicine/${editItemId}/stock-mutation/${editId}`
                    : `/api/bhp/restock/${editId}`;

                const delRes = await fetch(delUrl, {
                    method : 'DELETE',
                    headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                });

                if (!delRes.ok) {
                    const delJson = await delRes.json();
                    alert('Gagal memperbarui: ' + (delJson.message ?? 'Terjadi kesalahan saat menghapus data lama.'));
                    return;
                }
            }

            // POST data baru
            let url, body;
            if (kategori === 'obat') {
                url  = `/api/medicine/${itemId}/stock-${jenis === 'restock' ? 'in' : 'out'}`;
                body = { qty: jumlah, unit_price: harga, note: notes };
            } else {
                url  = '/api/bhp/restock';
                body = {
                    bhp_id            : itemId,
                    restock_type      : jenis,
                    purchase_price    : harga,
                    notes             : notes || null,
                    quantity_added    : jenis === 'restock' ? jumlah : 0,
                    quantity_returned : jenis === 'return'  ? jumlah : 0,
                };
            }

            const res  = await fetch(url, {
                method : 'POST',
                headers: {
                    'Content-Type' : 'application/json',
                    'Accept'       : 'application/json',
                    'X-CSRF-TOKEN' : CSRF,
                },
                body: JSON.stringify(body),
            });

            const json = await res.json();

            if (res.ok) {
                alert(isEdit ? 'Transaksi Berhasil Diperbarui!' : 'Transaksi Berhasil Disimpan!');
                closeModal();
                loadTabel();
            } else {
                const msgs = Object.values(json.errors ?? {}).flat().join('\n');
                alert('Gagal:\n' + (msgs || json.message || 'Terjadi kesalahan.'));
            }

        } catch (err) {
            alert('Error jaringan: ' + err.message);
        } finally {
            btnSubmit.disabled    = false;
            btnSubmit.textContent = isEdit ? 'Simpan Perubahan' : 'Simpan Transaksi';
        }
    };

    // ── SEARCH ───────────────────────────────────────────────
    let timer;
    document.getElementById('searchInput')?.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(() => {
            searchQuery = this.value.trim();
            renderTabel();
        }, 300);
    });

    // ── INIT ─────────────────────────────────────────────────
    loadTabel();
});
</script>