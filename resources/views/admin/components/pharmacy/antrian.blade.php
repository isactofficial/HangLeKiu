@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/pharmacy/antrian.css') }}">
@endpush


<div class="apt-card">

    <div
        style="display:flex; justify-content:space-between; align-items:center; padding:12px 18px; flex-wrap:wrap; gap:10px;">
        <div class="apt-tabs">
            <a href="#" class="apt-tab active">Belum Selesai</a>
            <a href="#" class="apt-tab">Sudah Selesai</a>
        </div>
        <div class="apt-card-actions">
            <div class="apt-search-box">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <path d="M21 21l-4.35-4.35" />
                </svg>
                <input type="text" placeholder="Cari nama pasien...">
            </div>
            <button class="apt-btn-primary">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5">
                    <path d="M12 5v14M5 12h14" />
                </svg>
                Tambah Resep
            </button>
        </div>
    </div>

    <div class="apt-table-wrapper">
        <table class="apt-table" style="min-width:700px;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pasien</th>
                    <th>Dokter</th>
                    <th>Waktu Masuk</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Rina Wulandari</td>
                    <td>drg. Anisa Putri</td>
                    <td>08:15</td>
                    <td><span class="apt-badge apt-badge-warning">Menunggu</span></td>
                    <td><button class="apt-btn-outline">Proses</button></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Budi Santoso</td>
                    <td>drg. Budi Raharjo</td>
                    <td>09:00</td>
                    <td><span class="apt-badge apt-badge-warning">Menunggu</span></td>
                    <td><button class="apt-btn-outline">Proses</button></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Sari Melati</td>
                    <td>drg. Citra Dewi</td>
                    <td>09:30</td>
                    <td><span class="apt-badge apt-badge-ok">Selesai</span></td>
                    <td><button class="apt-btn-outline">Proses</button></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Hendra Gunawan</td>
                    <td>drg. Anisa Putri</td>
                    <td>10:00</td>
                    <td><span class="apt-badge apt-badge-warning">Menunggu</span></td>
                    <td><button class="apt-btn-outline">Proses</button></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="apt-pagination">
        <div class="apt-page-size">Jumlah baris per halaman: <select>
                <option>10</option>
                <option>25</option>
                <option>50</option>
            </select></div>
        <div class="apt-page-controls">
            <button class="apt-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5">
                    <path d="M15 18l-6-6 6-6" />
                </svg></button>
            <div class="apt-page-info">1–4 dari 4 data</div>
            <button class="apt-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5">
                    <path d="M9 18l6-6-6-6" />
                </svg></button>
        </div>
    </div>

</div>
