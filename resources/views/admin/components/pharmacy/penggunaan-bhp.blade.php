@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/pharmacy/penggunaan-bhp.css') }}">
@endpush

<div class="apt-card">
    <div class="apt-card-header">
        <div>
            <h2 class="apt-card-title">Penggunaan BHP</h2>
            <p class="apt-card-subtitle" id="subtitleUsageBHP">Memuat data...</p>
        </div>
        <div class="apt-card-actions">
            <div class="apt-date-input">
                <label>Dari Tanggal</label>
                <input type="date" id="inputDariBHP" value="{{ now()->startOfMonth()->toDateString() }}">
            </div>
            <div class="apt-date-input">
                <label>Sampai Tanggal</label>
                <input type="date" id="inputSampaiBHP" value="{{ now()->toDateString() }}">
            </div>
            <div class="apt-search-box">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                </svg>
                <input type="text" id="inputSearchBHP" placeholder="Cari nama BHP">
            </div>
            <button class="apt-btn-primary" id="btnFilterBHP">Filter</button>
        
        </div>
    </div>

    <div class="apt-table-wrapper">
        <table class="apt-table" style="min-width:800px;">
            <thead>
                <tr>
                    <th>Nama BHP</th>
                    <th>Penggunaan Umum</th>
                    <th>Nominal BHP Umum</th>
                    <th>Penggunaan BPJS</th>
                    <th>Nominal BHP BPJS</th>
                    <th>Sisa BHP</th>
                </tr>
            </thead>
            <tbody id="tabel-penggunaan-bhp">
                <tr>
                    <td colspan="6" style="text-align:center;padding:24px;color:#9CA3AF">Memuat data...</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="apt-pagination">
        <div class="apt-page-size">
            Jumlah baris per halaman:
            <select id="pageSizeUsageBHP">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="25">25</option>
            </select>
        </div>
        <div class="apt-page-controls">
            <button class="apt-page-btn" id="btnPrevUsageBHP" disabled>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
            </button>
            <div class="apt-page-info" id="pageInfoUsageBHP">0 data</div>
            <button class="apt-page-btn" id="btnNextUsageBHP" disabled>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M9 18l6-6-6-6"/>
                </svg>
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function () {
    const CSRF      = document.querySelector('meta[name="csrf-token"]').content;
    let pageSize    = 10;
    let allData     = [];   // hasil agregat, untuk client-side pagination & search
    let currentPage = 1;

    // ─── LOAD DATA FROM API ───────────────────────────────────
    async function loadUsageBHP(page = 1) {
        currentPage = page;
        const dari   = document.getElementById('inputDariBHP').value;
        const sampai = document.getElementById('inputSampaiBHP').value;
        const search = document.getElementById('inputSearchBHP').value.trim().toLowerCase();

        const params = new URLSearchParams({ date_from: dari, date_to: sampai });

        const tbody = document.getElementById('tabel-penggunaan-bhp');
        tbody.innerHTML = `<tr><td colspan="6" style="text-align:center;padding:24px;color:#9CA3AF">Memuat data...</td></tr>`;

        try {
            const res  = await fetch(`/admin/pharmacy/bhp/usage?${params}`, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
            });
            const json = await res.json();

            if (!json.success) throw new Error(json.message ?? 'Gagal memuat data');

            // Controller return per-record → kita agregat di FE
            const records = json.data ?? [];
            allData = agregat(records);

            const subtitle = document.getElementById('subtitleUsageBHP');
            if (subtitle) {
                const now = new Date();
                const jam = now.toLocaleDateString('id-ID', { day:'2-digit', month:'2-digit', year:'numeric' })
                          + ' ' + now.toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' });
                subtitle.textContent = `Last Update: ${jam} — Periode ${dari} s/d ${sampai}`;
            }

            renderTabelFiltered(search, 1);

        } catch (err) {
            tbody.innerHTML = `<tr><td colspan="6" style="text-align:center;padding:24px;color:#EF4444">
                Gagal memuat data: ${err.message}</td></tr>`;
        }
    }

    // ─── AGREGASI per item BHP ────────────────────────────────
    // Input : array per-record dari controller (tiap record = 1 log penggunaan)
    // Output: array agregat per bhp_id  { item_name, qty_umum, nominal_umum, qty_bpjs, nominal_bpjs, current_stock }
    function agregat(records) {
        const map = {};

        records.forEach(r => {
            const id = r.bhp_id;
            if (!map[id]) {
                map[id] = {
                    item_name:     r.item?.item_name   ?? '-',
                    qty_umum:      0,
                    nominal_umum:  0,
                    qty_bpjs:      0,
                    nominal_bpjs:  0,
                    current_stock: r.item?.current_stock ?? 0,
                };
            }

            const qty   = r.quantity_used ?? 0;
            const harga = r.unit_price    ?? 0;

            if (r.usage_type === 'umum') {
                map[id].qty_umum     += qty;
                map[id].nominal_umum += qty * harga;
            } else if (r.usage_type === 'bpjs') {
                map[id].qty_bpjs     += qty;
                map[id].nominal_bpjs += qty * harga;
            }
        });

        return Object.values(map).sort((a, b) => a.item_name.localeCompare(b.item_name));
    }

    // ─── FILTER + RENDER ─────────────────────────────────────
    function renderTabelFiltered(search = '', page = 1) {
        const filtered = search
            ? allData.filter(r => r.item_name.toLowerCase().includes(search))
            : allData;

        renderTabel(filtered, page);
    }

    // ─── RENDER TABEL (client-side pagination) ────────────────
    function renderTabel(data, page) {
        const tbody    = document.getElementById('tabel-penggunaan-bhp');
        const total    = data.length;
        const from     = total ? (page - 1) * pageSize + 1 : 0;
        const to       = Math.min(page * pageSize, total);
        const lastPage = Math.ceil(total / pageSize) || 1;
        const slice    = data.slice((page - 1) * pageSize, page * pageSize);

        if (!slice.length) {
            tbody.innerHTML = `<tr><td colspan="6" style="text-align:center;padding:24px;color:#9CA3AF">
                Tidak ada data penggunaan BHP pada periode ini.</td></tr>`;
        } else {
            tbody.innerHTML = slice.map(o => `
                <tr>
                    <td>${o.item_name}</td>
                    <td>${o.qty_umum}</td>
                    <td>${rp(o.nominal_umum)}</td>
                    <td>${o.qty_bpjs}</td>
                    <td>${rp(o.nominal_bpjs)}</td>
                    <td>${o.current_stock}</td>
                </tr>
            `).join('');
        }

        renderPagination(from, to, total, page, lastPage, data);
    }

    // ─── PAGINATION ──────────────────────────────────────────
    function renderPagination(from, to, total, page, lastPage, data) {
        const info    = document.getElementById('pageInfoUsageBHP');
        const btnPrev = document.getElementById('btnPrevUsageBHP');
        const btnNext = document.getElementById('btnNextUsageBHP');

        if (info) info.textContent = `${from}–${to} dari ${total} data`;

        if (btnPrev) {
            btnPrev.disabled = page <= 1;
            btnPrev.onclick  = () => renderTabel(data, page - 1);
        }
        if (btnNext) {
            btnNext.disabled = page >= lastPage;
            btnNext.onclick  = () => renderTabel(data, page + 1);
        }
    }

    // ─── HELPERS ─────────────────────────────────────────────
    function rp(angka) {
        if (angka == null) return 'Rp 0';
        return 'Rp ' + Number(angka).toLocaleString('id-ID');
    }

    // ─── INIT ────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', () => {
        loadUsageBHP();

        // Tombol filter → re-fetch dari API
        document.getElementById('btnFilterBHP')?.addEventListener('click', () => {
            loadUsageBHP(1);
        });

        // Search live → filter dari allData tanpa re-fetch
        document.getElementById('inputSearchBHP')?.addEventListener('input', () => {
            const search = document.getElementById('inputSearchBHP').value.trim().toLowerCase();
            renderTabelFiltered(search, 1);
        });

        // Enter di search → sama dengan klik filter
        document.getElementById('inputSearchBHP')?.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') loadUsageBHP(1);
        });

        // Page size
        document.getElementById('pageSizeUsageBHP')?.addEventListener('change', (e) => {
            pageSize = Number(e.target.value);
            const search = document.getElementById('inputSearchBHP').value.trim().toLowerCase();
            renderTabelFiltered(search, 1);
        });
    });
})();
</script>
@endpush