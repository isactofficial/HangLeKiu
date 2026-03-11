@php $tab = request('tab', 'summary'); @endphp

<style>
    .pas-tabs {
        display: flex;
        gap: 4px;
        margin-bottom: 20px;
    }

    .pas-tab {
        padding: 8px 22px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        font-family: inherit;
        text-decoration: none;
        display: inline-block;
        transition: all .15s;
    }

    .pas-tab.active {
        background: #C58F59;
        color: #fff;
    }

    .pas-tab.inactive {
        background: #F3EDE6;
        color: #6B513E;
    }

    .pas-tab.inactive:hover {
        background: #E5D6C5;
        color: #582C0C;
    }

    .pas-stat-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 20px;
    }

    .pas-stat {
        background: #fff;
        border: 1px solid #E5D6C5;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 1px 3px rgba(88, 44, 12, .05);
    }

    .pas-stat-label {
        font-size: 13px;
        font-weight: 700;
        color: #582C0C;
        margin: 0 0 10px;
    }

    .pas-stat-number {
        font-size: 30px;
        font-weight: 700;
        color: #C58F59;
        margin: 0;
        line-height: 1;
    }

    .pas-bday-section {
        margin-bottom: 20px;
    }

    .pas-bday-label {
        font-size: 13px;
        color: #6B513E;
        margin: 0 0 8px;
    }

    .pas-bday-row {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .pas-bday-card {
        background: #fff;
        border: 1.5px solid #C58F59;
        border-radius: 6px;
        padding: 10px 16px;
        font-size: 13px;
        color: #582C0C;
        font-weight: 500;
        flex: 1;
        min-width: 180px;
    }

    .pas-chart-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .pas-chart-card {
        background: #fff;
        border: 1px solid #E5D6C5;
        border-radius: 8px;
        padding: 16px 18px;
        box-shadow: 0 1px 3px rgba(88, 44, 12, .05);
    }

    .pas-chart-title {
        font-size: 13px;
        font-weight: 700;
        color: #582C0C;
        text-align: center;
        margin: 0 0 14px;
    }

    .pas-chart-area {
        position: relative;
        height: 150px;
    }

    .pas-bar-wrap {
        display: flex;
        align-items: flex-end;
        gap: 16px;
        height: 130px;
        padding: 0 10px;
    }

    .pas-bar-col {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        flex: 1;
    }

    .pas-bar {
        width: 100%;
        background: #f4a4a4;
        border-radius: 4px 4px 0 0;
    }

    .pas-bar-label {
        font-size: 13px;
        color: #6B513E;
        text-align: center;
    }

    .pas-y-axis {
        display: flex;
        flex-direction: column-reverse;
        justify-content: space-between;
        height: 130px;
        padding: 0;
    }

    .pas-y-tick {
        font-size: 13px;
        color: #9CA3AF;
    }

    .pas-chart-inner {
        display: flex;
        gap: 6px;
    }

    .pas-chart-border {
        border: 1px solid #E5D6C5;
        border-radius: 4px;
        padding: 6px 8px;
    }

    .pas-card {
        background: #fff;
        border: 1px solid #E5D6C5;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(88, 44, 12, .05);
    }

    .pas-card-header {
        padding: 14px 18px;
        border-bottom: 1px solid #E5D6C5;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .pas-card-title {
        font-size: 18.75px;
        font-weight: 700;
        color: #C58F59;
        margin: 0;
    }

    .pas-search-box {
        display: flex;
        align-items: center;
        border: 1px solid #E5D6C5;
        border-radius: 5px;
        padding: 7px 10px;
        gap: 7px;
        background: #fff;
    }

    .pas-search-box:focus-within {
        border-color: #C58F59;
    }

    .pas-search-box input {
        border: none;
        outline: none;
        font-size: 13px;
        color: #582C0C;
        background: transparent;
        width: 220px;
        font-family: inherit;
    }

    .pas-search-box input::placeholder {
        color: #b09a88;
    }

    .pas-btn-export {
        background: #582C0C;
        color: #fff;
        border: none;
        padding: 8px 14px;
        border-radius: 5px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        white-space: nowrap;
    }

    .pas-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .pas-table-wrapper::-webkit-scrollbar {
        height: 6px;
    }

    .pas-table-wrapper::-webkit-scrollbar-thumb {
        background: #C58F59;
        border-radius: 3px;
    }

    .pas-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .pas-table th {
        background: #fdf8f4;
        color: #582C0C;
        font-size: 13px;
        font-weight: 600;
        padding: 11px 16px;
        border-bottom: 2px solid #E5D6C5;
        white-space: nowrap;
    }

    .pas-table td {
        padding: 11px 16px;
        font-size: 13px;
        color: #374151;
        border-bottom: 1px solid #F3EDE6;
        white-space: nowrap;
    }

    .pas-table tr:last-child td {
        border-bottom: none;
    }

    .pas-table tr:hover td {
        background: rgba(253, 248, 244, .7);
    }

    .pas-badge {
        display: inline-block;
        padding: 3px 9px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }

    .pas-badge-ok {
        background: #D1FAE5;
        color: #065F46;
    }

    .pas-badge-warning {
        background: #FEF3C7;
        color: #92400E;
    }

    .pas-pagination {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        padding: 12px 18px;
        gap: 20px;
        border-top: 1px solid #E5D6C5;
    }

    .pas-page-size {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #6B513E;
    }

    .pas-page-size select {
        border: none;
        outline: none;
        font-weight: 600;
        color: #582C0C;
        font-size: 13px;
        cursor: pointer;
        background: transparent;
        font-family: inherit;
    }

    .pas-page-info {
        color: #6B513E;
    }

    .pas-page-controls {
        display: flex;
        gap: 4px;
    }

    .pas-page-btn {
        background: none;
        border: none;
        color: #9CA3AF;
        cursor: pointer;
        padding: 4px 6px;
        border-radius: 4px;
        line-height: 0;
    }

    .pas-page-btn:not([disabled]):hover {
        color: #582C0C;
        background: #fdf8f4;
    }

    .pas-page-btn[disabled] {
        opacity: .4;
        cursor: default;
        pointer-events: none;
    }
</style>

<div class="pas-tabs">
    <a href="?menu=pasien&tab=summary" class="pas-tab {{ $tab === 'summary' ? 'active' : 'inactive' }}">Summary</a>
    <a href="?menu=pasien&tab=data-pasien" class="pas-tab {{ $tab === 'data-pasien' ? 'active' : 'inactive' }}">Data
        Pasien</a>
</div>

@if ($tab === 'summary')

    <div class="pas-stat-grid">
        <div class="pas-stat">
            <p class="pas-stat-label">Pasien Terdaftar</p>
            <p class="pas-stat-number">385</p>
            <p style="font-size:13px;color:#6B513E;margin:6px 0 0;">Pasien</p>
        </div>
        <div class="pas-stat">
            <p class="pas-stat-label">Pasien Baru Bulan Ini</p>
            <p class="pas-stat-number">2</p>
            <p style="font-size:13px;color:#6B513E;margin:6px 0 0;">Pasien</p>
        </div>
        <div class="pas-stat">
            <p class="pas-stat-label">Pasien Walk-in Hari Ini</p>
            <p class="pas-stat-number">4</p>
            <p style="font-size:13px;color:#6B513E;margin:6px 0 0;">Pasien</p>
        </div>
    </div>

    <div class="pas-bday-section">
        <p class="pas-bday-label">Upcoming Birthdays</p>
        <div class="pas-bday-row">
            <div class="pas-bday-card">Adinda, Tanggal Lahir: 08-03-2005</div>
            <div class="pas-bday-card">Adinda Salsabila, Tanggal Lahir: 08-03-2005</div>
            <div class="pas-bday-card">Farrah, Tanggal Lahir: 06-03-2003</div>
        </div>
    </div>

    <div class="pas-chart-grid">
        @foreach (['Agama', 'Golongan darah', 'Pendidikan terakhir', 'Pekerjaan', 'Status'] as $chartTitle)
            <div class="pas-chart-card"
                style="{{ $loop->last && $loop->count % 2 !== 0 ? 'grid-column:span 2; max-width:50%;' : '' }}">
                <p class="pas-chart-title">{{ $chartTitle }}</p>
                <div class="pas-chart-inner">
                    <div class="pas-y-axis">
                        <span class="pas-y-tick">0</span>
                        <span class="pas-y-tick">95</span>
                        <span class="pas-y-tick">190</span>
                        <span class="pas-y-tick">285</span>
                        <span class="pas-y-tick">380</span>
                    </div>
                    <div style="flex:1;">
                        <div class="pas-chart-border">
                            <div class="pas-bar-wrap">
                                <div class="pas-bar-col">
                                    <div class="pas-bar" style="height:{{ $chartTitle === 'Agama' ? '90%' : '95%' }};">
                                    </div>
                                    <span
                                        class="pas-bar-label">{{ $chartTitle === 'Agama' ? 'Tidak Tahu' : 'Tidak Tahu' }}</span>
                                </div>
                                @if ($chartTitle === 'Agama')
                                    <div class="pas-bar-col">
                                        <div class="pas-bar" style="height:20%;"></div>
                                        <span class="pas-bar-label">Islam</span>
                                    </div>
                                @else
                                    <div class="pas-bar-col">
                                        <div class="pas-bar" style="height:5%;"></div>
                                        <span class="pas-bar-label">Lainnya</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="pas-card">
        <div class="pas-card-header">
            <h2 class="pas-card-title">Data Pasien</h2>
            <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                <div class="pas-search-box">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6B513E"
                        stroke-width="2">
                        <circle cx="11" cy="11" r="8" />
                        <path d="M21 21l-4.35-4.35" />
                    </svg>
                    <input type="text" placeholder="Cari nama, No MR, No KTP...">
                </div>
                <button class="pas-btn-export">Export</button>
            </div>
        </div>
        <div class="pas-table-wrapper">
            <table class="pas-table" style="min-width:800px;">
                <thead>
                    <tr>
                        <th>No MR</th>
                        <th>Nama Pasien</th>
                        <th>Tanggal Lahir</th>
                        <th>No KTP</th>
                        <th>No HP</th>
                        <th>Jenis Pasien</th>
                        <th>Kunjungan Terakhir</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="color:#C58F59;font-weight:600;">MR-00385</td>
                        <td>Rina Wulandari</td>
                        <td>12/05/1995</td>
                        <td>3573012345678901</td>
                        <td>0812-3456-7890</td>
                        <td><span class="pas-badge pas-badge-ok">Umum</span></td>
                        <td>05/03/2026</td>
                    </tr>
                    <tr>
                        <td style="color:#C58F59;font-weight:600;">MR-00384</td>
                        <td>Budi Santoso</td>
                        <td>08/11/1988</td>
                        <td>3573019876543210</td>
                        <td>0813-9876-5432</td>
                        <td><span class="pas-badge pas-badge-ok">Umum</span></td>
                        <td>05/03/2026</td>
                    </tr>
                    <tr>
                        <td style="color:#C58F59;font-weight:600;">MR-00383</td>
                        <td>Sari Melati</td>
                        <td>25/03/2000</td>
                        <td>3573011122334455</td>
                        <td>0814-1122-3344</td>
                        <td><span class="pas-badge pas-badge-warning">BPJS</span></td>
                        <td>06/03/2026</td>
                    </tr>
                    <tr>
                        <td style="color:#C58F59;font-weight:600;">MR-00382</td>
                        <td>Hendra Gunawan</td>
                        <td>17/07/1982</td>
                        <td>3573015566778899</td>
                        <td>0815-5566-7788</td>
                        <td><span class="pas-badge pas-badge-ok">Umum</span></td>
                        <td>06/03/2026</td>
                    </tr>
                    <tr>
                        <td style="color:#C58F59;font-weight:600;">MR-00381</td>
                        <td>Dewi Kusuma</td>
                        <td>30/01/1993</td>
                        <td>3573016677889900</td>
                        <td>0816-6677-8899</td>
                        <td><span class="pas-badge pas-badge-warning">BPJS</span></td>
                        <td>02/03/2026</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="pas-pagination">
            <div class="pas-page-size">Jumlah baris per halaman: <select>
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                </select></div>
            <div class="pas-page-info">1–5 dari 385 data</div>
            <div class="pas-page-controls">
                <button class="pas-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M11 17l-5-5 5-5M18 17l-5-5 5-5" />
                    </svg></button>
                <button class="pas-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M15 18l-6-6 6-6" />
                    </svg></button>
                <button class="pas-page-btn"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5">
                        <path d="M9 18l6-6-6-6" />
                    </svg></button>
                <button class="pas-page-btn"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5">
                        <path d="M13 17l5-5-5-5M6 17l5-5-5-5" />
                    </svg></button>
            </div>
        </div>
    </div>

@endif
