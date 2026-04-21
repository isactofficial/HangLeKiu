@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/pharmacy/penggunaan-obat.css') }}">
@endpush

<div class="apt-card">
    <div class="apt-card-header">
        <div>
            <h2 class="apt-card-title">Penggunaan Obat</h2>
            <p class="apt-card-subtitle" id="subtitleUpdate">Memuat data...</p>
        </div>
        <div class="apt-card-actions">
            <div class="apt-date-input">
                <label>Dari Tanggal</label>
                <input type="date" id="inputDari" value="{{ now()->startOfMonth()->toDateString() }}">
            </div>
            <div class="apt-date-input">
                <label>Sampai Tanggal</label>
                <input type="date" id="inputSampai" value="{{ now()->toDateString() }}">
            </div>
            <div class="apt-search-box">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                </svg>
                <input type="text" id="inputSearch" placeholder="Cari nama obat">
            </div>
            <button class="apt-btn-primary" id="btnFilter">Filter</button>
           
        </div>
    </div>

    <div class="apt-table-wrapper">
        <table class="apt-table" style="min-width:800px;">
            <thead>
                <tr>
                    <th>Nama Obat</th>
                    <th>Penggunaan Obat Umum</th>
                    <th>Nominal Obat Umum</th>
                    <th>Penggunaan Obat BPJS</th>
                    <th>Nominal Obat BPJS</th>
                    <th>Sisa Obat</th>
                </tr>
            </thead>
            <tbody id="tabel-penggunaan-obat">
                <tr>
                    <td colspan="6" style="text-align:center;padding:24px;color:#9CA3AF">Memuat data...</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="apt-pagination">
        <div class="apt-page-size">
            Jumlah baris per halaman:
            <select id="pageSizePO">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="25">25</option>
            </select>
        </div>
        <div class="apt-page-controls">
            <button class="apt-page-btn" id="btnPrevPO" disabled>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
            </button>
            <div class="apt-page-info" id="pageInfoPO">0 data</div>
            <button class="apt-page-btn" id="btnNextPO" disabled>
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
    let currentPage = 1;
    let pageSize    = 10;

    // ─── LOAD DATA ───────────────────────────────────────────
    async function loadPenggunaanObat(page = 1) {
        const dari   = document.getElementById('inputDari').value;
        const sampai = document.getElementById('inputSampai').value;
        const search = document.getElementById('inputSearch').value.trim();

        const params = new URLSearchParams({
            dari, sampai, per_page: pageSize, page
        });
        if (search) params.append('search', search);

        const tbody = document.getElementById('tabel-penggunaan-obat');
        tbody.innerHTML = `<tr><td colspan="6" style="text-align:center;padding:24px;color:#9CA3AF">Memuat data...</td></tr>`;

        try {
            const res  = await fetch(`/admin/pharmacy/penggunaan-obat?${params}`, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
            });
            const json = await res.json();

            if (!json.success) throw new Error(json.message ?? 'Gagal memuat data');

            const paginatedData = json.data;
            const rows          = paginatedData.data ?? [];
            const total         = paginatedData.total ?? 0;
            const from          = paginatedData.from  ?? 0;
            const to            = paginatedData.to    ?? 0;
            const lastPage      = paginatedData.last_page ?? 1;

            renderTabel(rows);
            renderPagination(from, to, total, page, lastPage, dari, sampai, search);

            // Update subtitle
            const subtitle = document.getElementById('subtitleUpdate');
            if (subtitle) subtitle.textContent = `Data periode ${dari} s/d ${sampai}`;

        } catch (err) {
            tbody.innerHTML = `<tr><td colspan="6" style="text-align:center;padding:24px;color:#EF4444">
                Gagal memuat data: ${err.message}</td></tr>`;
        }
    }

    // ─── RENDER TABEL ────────────────────────────────────────
    function renderTabel(data) {
        const tbody = document.getElementById('tabel-penggunaan-obat');

        if (!data.length) {
            tbody.innerHTML = `<tr><td colspan="6" style="text-align:center;padding:24px;color:#9CA3AF">
                Tidak ada data penggunaan obat pada periode ini.</td></tr>`;
            return;
        }

        tbody.innerHTML = data.map(o => `
            <tr>
                <td>${o.medicine_name ?? '-'}</td>
                <td>${o.qty_umum ?? 0}</td>
                <td>${rp(o.nominal_umum)}</td>
                <td>${o.qty_bpjs ?? 0}</td>
                <td>${rp(o.nominal_bpjs)}</td>
                <td>${o.current_stock ?? 0}</td>
            </tr>
        `).join('');
    }

    // ─── RENDER PAGINATION ───────────────────────────────────
    function renderPagination(from, to, total, page, lastPage, dari, sampai, search) {
        const info    = document.getElementById('pageInfoPO');
        const btnPrev = document.getElementById('btnPrevPO');
        const btnNext = document.getElementById('btnNextPO');

        if (info) info.textContent = `${from}–${to} dari ${total} data`;

        if (btnPrev) {
            btnPrev.disabled = page <= 1;
            btnPrev.onclick  = () => loadPenggunaanObat(page - 1);
        }
        if (btnNext) {
            btnNext.disabled = page >= lastPage;
            btnNext.onclick  = () => loadPenggunaanObat(page + 1);
        }
    }

    // ─── HELPER RUPIAH ───────────────────────────────────────
    function rp(angka) {
        if (angka == null) return 'Rp 0';
        return 'Rp ' + Number(angka).toLocaleString('id-ID');
    }

    // ─── INIT ────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', () => {
        loadPenggunaanObat();

        // Tombol filter
        document.getElementById('btnFilter')?.addEventListener('click', () => {
            loadPenggunaanObat(1);
        });

        // Search enter
        document.getElementById('inputSearch')?.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') loadPenggunaanObat(1);
        });

        // Page size
        document.getElementById('pageSizePO')?.addEventListener('change', (e) => {
            pageSize = Number(e.target.value);
            loadPenggunaanObat(1);
        });
    });
})();
</script>
@endpush