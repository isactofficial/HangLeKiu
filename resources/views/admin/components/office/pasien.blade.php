@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/office/pasien.css') }}">
@endpush

{{-- resources/views/admin/office/pasien.blade.php --}}
@php $tab = request('tab', 'summary'); @endphp
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
