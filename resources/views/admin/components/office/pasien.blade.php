{{-- ══════════════════════════════════════════════════════
     PASIEN — Tab di dalam Laporan
     ?tab=pasien&sub=summary   (default)
     ?tab=pasien&sub=data-pasien
══════════════════════════════════════════════════════ --}}

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/components/office/pasien.css') }}">
<style>
*, *::before, *::after { box-sizing: border-box; }

/* ── Sub-tab bar ────────────────────────────── */
.pas-tabs { display:flex; gap:4px; margin-bottom:20px; border-bottom:2px solid #E5D6C5; }
.pas-tab { padding:9px 20px; font-size:13px; font-weight:600; border-radius:6px 6px 0 0; text-decoration:none; color:#8B5E3C; background:transparent; position:relative; bottom:-2px; border-bottom:3px solid transparent; transition:all .18s; }
.pas-tab.active  { color:#582C0C; border-bottom:3px solid #C58F59; background:#fdf8f3; }
.pas-tab.inactive:hover { background:#fdf8f3; color:#582C0C; }

/* ── Stat Cards ─────────────────────────────── */
.pas-stat-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:24px; }
@media (max-width:900px) { .pas-stat-grid { grid-template-columns:repeat(2,1fr); } }
@media (max-width:500px)  { .pas-stat-grid { grid-template-columns:1fr; } }

.pas-stat-card { background:#fff; border:1px solid #E5D6C5; border-radius:10px; padding:18px 20px; box-shadow:0 1px 4px rgba(88,44,12,.06); }
.pas-stat-icon { width:36px; height:36px; border-radius:8px; display:flex; align-items:center; justify-content:center; margin-bottom:8px; font-size:18px; }
.icon-blue   { background:#EFF6FF; }
.icon-green  { background:#F0FDF4; }
.icon-orange { background:#FFF7ED; }
.icon-purple { background:#F5F3FF; }
.pas-stat-label  { font-size:11px; font-weight:700; color:#8B5E3C; text-transform:uppercase; letter-spacing:.5px; }
.pas-stat-number { font-size:26px; font-weight:800; color:#582C0C; line-height:1.1; margin:2px 0; }
.pas-stat-sub    { font-size:11px; color:#9CA3AF; }

/* ── Birthday ───────────────────────────────── */
.pas-bday-section { background:linear-gradient(135deg,#FDF8F3,#FFF4E6); border:1px solid #E5D6C5; border-radius:10px; padding:16px 20px; margin-bottom:24px; }
.pas-bday-label { font-size:11px; font-weight:700; color:#8B5E3C; text-transform:uppercase; letter-spacing:.6px; margin:0 0 10px; }
.pas-bday-row { display:flex; flex-wrap:wrap; gap:8px; }
.pas-bday-chip { background:#fff; border:1px solid #E5D6C5; border-radius:20px; padding:5px 14px; font-size:12px; color:#582C0C; font-weight:600; display:flex; align-items:center; gap:6px; }
.pas-bday-chip span { color:#C58F59; }

/* ── Chart Grid ─────────────────────────────── */
.pas-chart-grid   { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:20px; }
.pas-chart-grid-2 { display:grid; grid-template-columns:repeat(2,1fr); gap:16px; margin-bottom:24px; }
@media (max-width:1100px) { .pas-chart-grid { grid-template-columns:repeat(2,1fr); } }
@media (max-width:700px)  { .pas-chart-grid,.pas-chart-grid-2 { grid-template-columns:1fr; } }

.pas-chart-card { background:#fff; border:1px solid #E5D6C5; border-radius:10px; padding:18px 20px; box-shadow:0 1px 4px rgba(88,44,12,.06); }
.pas-chart-title { font-size:12px; font-weight:700; color:#582C0C; text-transform:uppercase; letter-spacing:.5px; margin:0 0 14px; display:flex; align-items:center; gap:6px; }
.pas-chart-title::before { content:''; display:block; width:3px; height:14px; border-radius:2px; background:#C58F59; }
.pas-chart-canvas { height:200px; position:relative; }

/* Donut */
.pas-donut-wrap { display:flex; align-items:center; gap:16px; height:200px; }
.pas-donut-canvas { flex:0 0 130px; height:130px; }
.pas-donut-legend { flex:1; display:flex; flex-direction:column; gap:6px; overflow:auto; max-height:190px; }
.pas-legend-item { display:flex; align-items:center; gap:7px; font-size:11px; color:#6B513E; }
.pas-legend-dot  { width:9px; height:9px; border-radius:50%; flex-shrink:0; }
.pas-legend-val  { margin-left:auto; font-weight:700; color:#582C0C; font-size:11px; }

/* ── Table ──────────────────────────────────── */
.pas-card { background:#fff; border:1px solid #E5D6C5; border-radius:10px; overflow:hidden; box-shadow:0 1px 4px rgba(88,44,12,.06); }
.pas-card-header { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; padding:16px 20px; border-bottom:1px solid #E5D6C5; background:#FDFAF7; }
.pas-card-title { font-size:14px; font-weight:800; color:#582C0C; margin:0; }
.pas-toolbar { display:flex; align-items:center; gap:10px; flex-wrap:wrap; }

.pas-search-box { display:flex; align-items:center; gap:7px; border:1px solid #E5D6C5; border-radius:6px; padding:7px 12px; background:#fff; }
.pas-search-box input { border:none; outline:none; font-size:13px; color:#582C0C; background:transparent; width:200px; font-family:inherit; }

.pas-filter-select { border:1px solid #E5D6C5; border-radius:6px; padding:7px 10px; font-size:12px; font-weight:600; color:#582C0C; background:#fff; cursor:pointer; font-family:inherit; outline:none; }

.pas-btn-export { background:#582C0C; color:#fff; border:none; border-radius:6px; padding:8px 16px; font-size:12px; font-weight:700; cursor:pointer; font-family:inherit; display:flex; align-items:center; gap:6px; transition:background .18s; }
.pas-btn-export:hover { background:#8B5E3C; }

.pas-table-wrapper { overflow-x:auto; }
.pas-table { width:100%; border-collapse:collapse; font-size:12px; min-width:1100px; }
.pas-table thead tr { background:#FDFAF7; border-bottom:2px solid #E5D6C5; }
.pas-table th { padding:10px 12px; text-align:left; font-size:10px; font-weight:700; color:#8B5E3C; text-transform:uppercase; letter-spacing:.5px; white-space:nowrap; }
.pas-table td { padding:11px 12px; color:#582C0C; border-bottom:1px solid #F5EDE3; vertical-align:middle; }
.pas-table tbody tr:hover { background:#FDFAF7; }
.pas-table tbody tr:last-child td { border-bottom:none; }

.pas-badge { display:inline-block; padding:3px 10px; border-radius:20px; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.4px; white-space:nowrap; }
.pas-badge-ok     { background:#DCFCE7; color:#166534; }
.pas-badge-warn   { background:#FEF9C3; color:#854D0E; }
.pas-badge-info   { background:#DBEAFE; color:#1D4ED8; }
.pas-badge-purple { background:#EDE9FE; color:#6D28D9; }
.pas-badge-gray   { background:#F3F4F6; color:#4B5563; }
.pas-badge-red    { background:#FEF2F2; color:#991B1B; }

.gender-dot { display:inline-flex; align-items:center; gap:5px; font-weight:600; }
.gender-dot::before { content:''; width:8px; height:8px; border-radius:50%; }
.gender-m::before { background:#3B82F6; }
.gender-f::before { background:#EC4899; }

/* Pagination */
.pas-pagination { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; padding:14px 20px; border-top:1px solid #F5EDE3; background:#FDFAF7; }
.pas-page-info { font-size:12px; color:#8B5E3C; font-weight:600; }
.pas-page-right { display:flex; align-items:center; gap:10px; flex-wrap:wrap; }
.pas-per-page-wrap { display:flex; align-items:center; gap:6px; font-size:12px; color:#8B5E3C; }
.pas-per-page-select { border:1px solid #E5D6C5; border-radius:6px; padding:5px 10px; font-size:12px; font-weight:600; color:#582C0C; background:#fff; cursor:pointer; font-family:inherit; outline:none; }
.pas-page-controls { display:flex; gap:4px; }
.pas-page-btn { min-width:32px; height:32px; padding:0 6px; border:1px solid #E5D6C5; border-radius:6px; background:#fff; cursor:pointer; display:flex; align-items:center; justify-content:center; color:#582C0C; font-size:12px; font-weight:700; text-decoration:none; transition:all .15s; }
.pas-page-btn:hover:not([disabled]) { background:#582C0C; color:#fff; border-color:#582C0C; }
.pas-page-btn[disabled] { opacity:.4; cursor:not-allowed; pointer-events:none; }
.pas-page-btn.active { background:#582C0C; color:#fff; border-color:#582C0C; }
</style>
@endpush

@php $subTab = request('sub', 'summary'); @endphp

<div class="pas-tabs">
    <a href="?menu=laporan&tab=pasien&sub=summary"
       class="pas-tab {{ $subTab === 'summary' ? 'active' : 'inactive' }}">📊 Summary</a>
    <a href="?menu=laporan&tab=pasien&sub=data-pasien"
       class="pas-tab {{ $subTab === 'data-pasien' ? 'active' : 'inactive' }}">🗂 Data Pasien</a>
</div>


{{-- ══════════════════ SUMMARY ══════════════════ --}}
@if ($subTab === 'summary')

    {{-- Stat Cards --}}
    <div class="pas-stat-grid">
        <div class="pas-stat-card">
            <div class="pas-stat-icon icon-blue">👥</div>
            <div class="pas-stat-label">Total Pasien</div>
            <div class="pas-stat-number">{{ number_format($totalPatients ?? 0) }}</div>
            <div class="pas-stat-sub">Terdaftar di sistem</div>
        </div>
        <div class="pas-stat-card">
            <div class="pas-stat-icon icon-green">🆕</div>
            <div class="pas-stat-label">Pasien Baru Bulan Ini</div>
            <div class="pas-stat-number">{{ number_format($newPatientsThisMonth ?? 0) }}</div>
            <div class="pas-stat-sub">{{ now()->translatedFormat('F Y') }}</div>
        </div>
        <div class="pas-stat-card">
            <div class="pas-stat-icon icon-orange">🚶</div>
            <div class="pas-stat-label">Walk-in Hari Ini</div>
            <div class="pas-stat-number">{{ number_format($walkInToday ?? 0) }}</div>
            <div class="pas-stat-sub">Kunjungan via appointment</div>
        </div>
        <div class="pas-stat-card">
            <div class="pas-stat-icon icon-purple">🌐</div>
            <div class="pas-stat-label">Daftar Online</div>
            <div class="pas-stat-number">{{ number_format($totalOnlinePatients ?? 0) }}</div>
            <div class="pas-stat-sub">Melalui aplikasi / web</div>
        </div>
    </div>

    {{-- Upcoming Birthdays --}}
    <div class="pas-bday-section">
        <p class="pas-bday-label">🎂 Ulang Tahun dalam 7 Hari ke Depan</p>
        <div class="pas-bday-row">
            @forelse ($upcomingBirthdays ?? [] as $bday)
                <div class="pas-bday-chip">
                    {{ $bday->full_name }}
                    <span>{{ $bday->date_of_birth->format('d M') }}</span>
                </div>
            @empty
                <div style="font-size:12px;color:#9CA3AF;font-style:italic;">
                    Tidak ada ulang tahun dalam waktu dekat.
                </div>
            @endforelse
        </div>
    </div>

    {{-- Row 1: Donut Charts (3 kolom) --}}
    <div class="pas-chart-grid">
        <div class="pas-chart-card">
            <p class="pas-chart-title">Golongan Darah</p>
            <div class="pas-donut-wrap">
                <div class="pas-donut-canvas"><canvas id="chartBloodType"></canvas></div>
                <div class="pas-donut-legend" id="legendBloodType"></div>
            </div>
        </div>
        <div class="pas-chart-card">
            <p class="pas-chart-title">Jenis Kelamin</p>
            <div class="pas-donut-wrap">
                <div class="pas-donut-canvas"><canvas id="chartGender"></canvas></div>
                <div class="pas-donut-legend" id="legendGender"></div>
            </div>
        </div>
        <div class="pas-chart-card">
            <p class="pas-chart-title">Sumber Pendaftaran</p>
            <div class="pas-donut-wrap">
                <div class="pas-donut-canvas"><canvas id="chartSource"></canvas></div>
                <div class="pas-donut-legend" id="legendSource"></div>
            </div>
        </div>
    </div>

    {{-- Row 2: Bar Charts (3 kolom) --}}
    <div class="pas-chart-grid">
        <div class="pas-chart-card">
            <p class="pas-chart-title">Pendidikan Terakhir</p>
            <div class="pas-chart-canvas"><canvas id="chartEducation"></canvas></div>
        </div>
        <div class="pas-chart-card">
            <p class="pas-chart-title">Status Pernikahan</p>
            <div class="pas-chart-canvas"><canvas id="chartMarital"></canvas></div>
        </div>
        <div class="pas-chart-card">
            <p class="pas-chart-title">Agama</p>
            <div class="pas-chart-canvas"><canvas id="chartReligion"></canvas></div>
        </div>
    </div>

    {{-- Row 3: Pekerjaan + Pertumbuhan --}}
    <div class="pas-chart-grid-2">
        <div class="pas-chart-card">
            <p class="pas-chart-title">Pekerjaan</p>
            <div class="pas-chart-canvas"><canvas id="chartOccupation"></canvas></div>
        </div>
        <div class="pas-chart-card">
            <p class="pas-chart-title">Pertumbuhan Pasien (12 Bulan)</p>
            <div class="pas-chart-canvas"><canvas id="chartGrowth"></canvas></div>
        </div>
    </div>


{{-- ══════════════════ DATA PASIEN ══════════════════ --}}
@else

    @php
        $perPage = (int) request('per_page', 10);
    @endphp

    <div class="pas-card">
        <div class="pas-card-header">
            <h2 class="pas-card-title">Data Pasien</h2>
            <div class="pas-toolbar">
                <form id="filterForm" action="{{ url()->current() }}" method="GET" style="display:contents;">
                    <input type="hidden" name="menu" value="laporan">
                    <input type="hidden" name="tab" value="pasien">
                    <input type="hidden" name="sub" value="data-pasien">
                    <input type="hidden" name="per_page" id="perPageHidden" value="{{ $perPage }}">

                    <div class="pas-search-box">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6B513E" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="M21 21l-4.35-4.35"/>
                        </svg>

                        <input 
                            type="text"
                            id="searchInput"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Nama, No MR, No KTP, HP..."
                        >
                    </div>

                </form>

                
            </div>
        </div>

        <div class="pas-table-wrapper">
            <table class="pas-table">
                <thead>
                    <tr>
                        <th style="width:40px;">#</th>
                        <th>No MR</th>
                        <th>Nama Lengkap</th>
                        <th>Gender</th>
                        <th>Tgl Lahir / Usia</th>
                        <th>No HP</th>
                        <th>No KTP</th>
                        <th>Pekerjaan</th>
                        <th>Pendidikan</th>
                        <th>Gol. Darah</th>
                        <th>Sumber Daftar</th>
                        <th>Kunjungan Terakhir</th>
                        <th>Jenis Pasien</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($patients ?? [] as $i => $p)
                        @php
                            $age          = $p->date_of_birth ? $p->date_of_birth->age : null;
                            $guarantor    = $p->latestAppointment?->guarantorType?->name ?? 'Umum';
                            $isOnline     = !is_null($p->user_id);
                            $genderLabel  = match($p->gender) { 'male'=>'Laki-laki','female'=>'Perempuan',default=>$p->gender??'-' };
                            $genderClass  = $p->gender==='male' ? 'gender-m' : ($p->gender==='female' ? 'gender-f':'');
                            $bloodDisplay = trim(($p->blood_type??'') . ($p->rhesus??''));
                            $rowNo        = ($patients->currentPage()-1) * $patients->perPage() + $i + 1;
                        @endphp
                        <tr>
                            <td style="color:#9CA3AF;font-size:11px;">{{ $rowNo }}</td>
                            <td style="color:#C58F59;font-weight:700;white-space:nowrap;">
                                {{ $p->medical_record_no ?? '-' }}
                            </td>
                            <td style="font-weight:600;white-space:nowrap;">{{ $p->full_name }}</td>
                            <td>
                                @if($p->gender)
                                    <span class="gender-dot {{ $genderClass }}">{{ $genderLabel }}</span>
                                @else
                                    <span style="color:#D1D5DB;">-</span>
                                @endif
                            </td>
                            <td style="white-space:nowrap;">
                                {{ $p->date_of_birth ? $p->date_of_birth->format('d/m/Y') : '-' }}
                                @if($age)
                                    <br><span style="color:#9CA3AF;font-size:10px;">{{ $age }} tahun</span>
                                @endif
                            </td>
                            <td>{{ $p->phone_number ?: '-' }}</td>
                            <td style="font-size:11px;color:#6B513E;">{{ $p->id_card_number ?: '-' }}</td>
                            <td>{{ $p->occupation ?: '-' }}</td>
                            <td>{{ $p->education ?: '-' }}</td>
                            <td>
                                @if($bloodDisplay)
                                    <span class="pas-badge pas-badge-info">{{ $bloodDisplay }}</span>
                                @else
                                    <span style="color:#D1D5DB;">-</span>
                                @endif
                            </td>
                            <td>
                                @if($isOnline)
                                    <span class="pas-badge pas-badge-purple">🌐 Online</span>
                                @else
                                    <span class="pas-badge pas-badge-gray">🏥 Langsung</span>
                                @endif
                            </td>
                            <td style="white-space:nowrap;font-size:11px;">
                                {{ $p->latestAppointment
                                    ? $p->latestAppointment->appointment_datetime->format('d/m/Y')
                                    : '-' }}
                            </td>
                            <td>
                                <span class="pas-badge {{ $guarantor==='BPJS' ? 'pas-badge-warn' : 'pas-badge-ok' }}">
                                    {{ $guarantor }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="14" style="text-align:center;padding:50px;color:#9CA3AF;">
                                <div style="font-size:32px;margin-bottom:8px;">🔍</div>
                                Tidak ada data pasien ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @php
            $lastPage    = $patients->lastPage();
            $currentPage = $patients->currentPage();
            $extraQuery  = http_build_query([
                'menu'          => 'laporan',
                'tab'           => 'pasien',
                'sub'           => 'data-pasien',
                'per_page'      => $perPage,
                'search'        => request('search',''),
                'gender_filter' => request('gender_filter',''),
                'source_filter' => request('source_filter',''),
            ]);
        @endphp
        <div class="pas-pagination">
            {{-- Info --}}
            <div class="pas-page-info">
                Menampilkan <strong>{{ $patients->firstItem() ?? 0 }}</strong>–<strong>{{ $patients->lastItem() ?? 0 }}</strong>
                dari <strong>{{ $patients->total() ?? 0 }}</strong> pasien
            </div>

            <div class="pas-page-right">
                {{-- Per-page --}}
                <div class="pas-per-page-wrap">
                    <span>Tampilkan:</span>
                    <select class="pas-per-page-select" onchange="changePerPage(this.value)">
                        @foreach([10,30,50,100] as $pp)
                            <option value="{{ $pp }}" {{ $perPage==$pp ? 'selected':'' }}>{{ $pp }} baris</option>
                        @endforeach
                    </select>
                </div>

                {{-- Page controls --}}
                <div class="pas-page-controls">
                    @if($patients->onFirstPage())
                        <button class="pas-page-btn" disabled>‹</button>
                    @else
                        <a href="{{ $patients->previousPageUrl() }}&{{ $extraQuery }}" class="pas-page-btn">‹</a>
                    @endif

                    @php
                        $pStart = max(1, $currentPage - 2);
                        $pEnd   = min($lastPage, $currentPage + 2);
                    @endphp

                    @if($pStart > 1)
                        <a href="{{ $patients->url(1) }}&{{ $extraQuery }}" class="pas-page-btn">1</a>
                        @if($pStart > 2)<span class="pas-page-btn" style="cursor:default;pointer-events:none;">…</span>@endif
                    @endif

                    @for($pg = $pStart; $pg <= $pEnd; $pg++)
                        <a href="{{ $patients->url($pg) }}&{{ $extraQuery }}"
                           class="pas-page-btn {{ $pg===$currentPage ? 'active':'' }}">{{ $pg }}</a>
                    @endfor

                    @if($pEnd < $lastPage)
                        @if($pEnd < $lastPage - 1)<span class="pas-page-btn" style="cursor:default;pointer-events:none;">…</span>@endif
                        <a href="{{ $patients->url($lastPage) }}&{{ $extraQuery }}" class="pas-page-btn">{{ $lastPage }}</a>
                    @endif

                    @if($patients->hasMorePages())
                        <a href="{{ $patients->nextPageUrl() }}&{{ $extraQuery }}" class="pas-page-btn">›</a>
                    @else
                        <button class="pas-page-btn" disabled>›</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endif


{{-- ═══ SCRIPTS ════════════════════════════════════════ --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>

let searchTimeout;

document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('filterForm');
    const searchInput = document.getElementById('searchInput');
    const refreshBtn = document.getElementById('keuRefreshBtn');

    // 🔍 SEARCH (DEBOUNCE)
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimeout);

            searchTimeout = setTimeout(() => {
                if (this.value.length >= 2 || this.value.length === 0) {
                    form.submit();
                }
            }, 500);
        });
    }

    // 📄 PER PAGE
    window.changePerPage = function(val) {
        document.getElementById('perPageHidden').value = val;
        form.submit();
    };


    // ── Export CSV ───────────────────────────────────────────────
    window.exportPatientCsv = function() {
        const p = new URLSearchParams({
            menu: 'laporan', tab: 'pasien', sub: 'data-pasien',
            search:        document.querySelector('input[name=search]')?.value || '',
            gender_filter: document.querySelector('select[name=gender_filter]')?.value || '',
            source_filter: document.querySelector('select[name=source_filter]')?.value || '',
            export: 'csv'
        });
        window.location.href = '{{ url()->current() }}?' + p.toString();
    };

    @if ($subTab === 'summary')

    // ── Color Palette ────────────────────────────────────────────
    const PALETTE = [
        '#C58F59','#582C0C','#8B5E3C','#E8B97A','#3B4A6B',
        '#6B8F71','#C47C5A','#9B7FA6','#5B8DB8','#D4A853','#7A9E7E','#B85C5C'
    ];

    // ── Donut builder ────────────────────────────────────────────
    function buildDonut(canvasId, legendId, labels, values) {
        const ctx = document.getElementById(canvasId);
        const leg = document.getElementById(legendId);
        if (!ctx) return;
        const total = values.reduce((a, b) => a + b, 0);

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels,
                datasets: [{
                    data: values,
                    backgroundColor: PALETTE.slice(0, labels.length),
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '68%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: c => ` ${c.label}: ${c.raw} (${total > 0 ? Math.round(c.raw / total * 100) : 0}%)`
                        }
                    }
                }
            }
        });

        if (leg) {
            leg.innerHTML = labels.map((lbl, i) => `
                <div class="pas-legend-item">
                    <div class="pas-legend-dot" style="background:${PALETTE[i]}"></div>
                    <span>${lbl || '—'}</span>
                    <span class="pas-legend-val">${values[i]}</span>
                </div>`).join('');
        }
    }

    // ── Bar builder ──────────────────────────────────────────────
    function buildBar(canvasId, labels, values, color) {
        const ctx = document.getElementById(canvasId);
        if (!ctx) return;
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels,
                datasets: [{ data: values, backgroundColor: color, borderRadius: 5, borderSkipped: false }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#F3EDE6' }, ticks: { font: { size: 10 } } },
                    x: { grid: { display: false }, ticks: { font: { size: 10 }, maxRotation: 40 } }
                }
            }
        });
    }

    // ── Render Charts ────────────────────────────────────────────
    buildDonut('chartBloodType','legendBloodType',
        {!! json_encode(array_keys($bloodTypeStats ?? [])) !!},
        {!! json_encode(array_values($bloodTypeStats ?? [])) !!});

    buildDonut('chartGender','legendGender',
        {!! json_encode(array_keys($genderStats ?? [])) !!},
        {!! json_encode(array_values($genderStats ?? [])) !!});

    buildDonut('chartSource','legendSource',
        {!! json_encode(array_keys($sourceStats ?? [])) !!},
        {!! json_encode(array_values($sourceStats ?? [])) !!});

    buildBar('chartEducation',
        {!! json_encode(array_keys($educationStats ?? [])) !!},
        {!! json_encode(array_values($educationStats ?? [])) !!},
        '#8B5E3C');

    buildBar('chartMarital',
        {!! json_encode(array_keys($maritalStats ?? [])) !!},
        {!! json_encode(array_values($maritalStats ?? [])) !!},
        '#3B4A6B');

    buildBar('chartReligion',
        {!! json_encode(array_keys($religionStats ?? [])) !!},
        {!! json_encode(array_values($religionStats ?? [])) !!},
        '#6B8F71');

    buildBar('chartOccupation',
        {!! json_encode(array_keys($occupationStats ?? [])) !!},
        {!! json_encode(array_values($occupationStats ?? [])) !!},
        '#C47C5A');

    // Line chart: pertumbuhan 12 bulan
    const growthCtx = document.getElementById('chartGrowth');
    if (growthCtx) {
        new Chart(growthCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_keys($growthStats ?? [])) !!},
                datasets: [{
                    data: {!! json_encode(array_values($growthStats ?? [])) !!},
                    borderColor: '#C58F59',
                    backgroundColor: 'rgba(197,143,89,.12)',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#C58F59',
                    pointRadius: 4,
                    fill: true,
                    tension: .4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#F3EDE6' }, ticks: { font: { size: 10 } } },
                    x: { grid: { display: false }, ticks: { font: { size: 10 }, maxRotation: 35 } }
                }
            }
        });
    }

    @endif
});
</script>
@endpush