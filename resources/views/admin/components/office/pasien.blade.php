@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/office/pasien.css') }}">
    <style>
        .pas-chart-full {
            background: #fff; border: 1px solid #E5D6C5; border-radius: 8px;
            padding: 20px; box-shadow: 0 1px 3px rgba(88,44,12,.05);
            margin-bottom: 20px;
        }
        .pas-chart-container { height: 250px; position: relative; }
        .pas-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        @media (max-width: 768px) { .pas-row { grid-template-columns: 1fr; } }
    </style>
@endpush

{{-- resources/views/admin/components/office/pasien.blade.php --}}
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
            <p class="pas-stat-number">{{ number_format($totalPatients ?? 0) }}</p>
            <p style="font-size:13px;color:#6B513E;margin:6px 0 0;">Pasien</p>
        </div>
        <div class="pas-stat">
            <p class="pas-stat-label">Pasien Baru Bulan Ini</p>
            <p class="pas-stat-number">{{ number_format($newPatientsThisMonth ?? 0) }}</p>
            <p style="font-size:13px;color:#6B513E;margin:6px 0 0;">Pasien</p>
        </div>
        <div class="pas-stat">
            <p class="pas-stat-label">Pasien Walk-in Hari Ini</p>
            <p class="pas-stat-number">{{ number_format($walkInToday ?? 0) }}</p>
            <p style="font-size:13px;color:#6B513E;margin:6px 0 0;">Pasien</p>
        </div>
    </div>

        <div class="pas-bday-section">
        <p class="pas-bday-label">Upcoming Birthdays (7 Hari ke depan)</p>
        <div class="pas-bday-row">
            @forelse ($upcomingBirthdays ?? [] as $bday)
                <div class="pas-bday-card">
                    <strong>{{ $bday->full_name }}</strong>, 
                    Tanggal Lahir: {{ $bday->date_of_birth->format('d-m-Y') }}
                </div>
            @empty
                <div class="pas-bday-card" style="opacity: 0.6;">Tidak ada ulang tahun dalam waktu dekat.</div>
            @endforelse
        </div>
    </div>

    <div class="pas-row">
        <div class="pas-chart-card">
            <p class="pas-chart-title">Distribusi Golongan Darah</p>
            <div class="pas-chart-container">
                <canvas id="bloodTypeChart"></canvas>
            </div>
        </div>
        <div class="pas-chart-card">
            <p class="pas-chart-title">Pendidikan Terakhir</p>
            <div class="pas-chart-container">
                <canvas id="educationChart"></canvas>
            </div>
        </div>
    </div>

@else
    <div class="pas-card">
        <div class="pas-card-header">
            <h2 class="pas-card-title">Data Pasien</h2>
            <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                <form action="{{ url()->current() }}" method="GET" class="pas-search-box">
                    <input type="hidden" name="menu" value="pasien">
                    <input type="hidden" name="tab" value="data-pasien">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6B513E"
                        stroke-width="2">
                        <circle cx="11" cy="11" r="8" />
                        <path d="M21 21l-4.35-4.35" />
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, No MR, No KTP...">
                </form>
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
                    @forelse ($patients ?? [] as $p)
                        <tr>
                            <td style="color:#C58F59;font-weight:600;">{{ $p->medical_record_no }}</td>
                            <td>{{ $p->full_name }}</td>
                            <td>{{ $p->date_of_birth ? $p->date_of_birth->format('d/m/Y') : '-' }}</td>
                            <td>{{ $p->id_card_number ?: '-' }}</td>
                            <td>{{ $p->phone_number ?: '-' }}</td>
                            <td>
                                @php
                                    $guarantor = $p->latestAppointment?->guarantorType?->name ?? 'Umum';
                                    $badgeClass = ($guarantor === 'BPJS') ? 'pas-badge-warning' : 'pas-badge-ok';
                                @endphp
                                <span class="pas-badge {{ $badgeClass }}">{{ $guarantor }}</span>
                            </td>
                            <td>{{ $p->latestAppointment ? $p->latestAppointment->appointment_datetime->format('d/m/Y') : '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;padding:40px;color:#999;">Belum ada data pasien.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pas-pagination">
            <div class="pas-page-size">
                Showing {{ $patients->firstItem() ?? 0 }} to {{ $patients->lastItem() ?? 0 }} of {{ $patients->total() ?? 0 }} entries
            </div>
            
            <div class="pas-page-controls">
                @if ($patients->onFirstPage())
                    <button class="pas-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6" /></svg></button>
                @else
                    <a href="{{ $patients->previousPageUrl() }}" class="pas-page-btn"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6" /></svg></a>
                @endif

                @if ($patients->hasMorePages())
                    <a href="{{ $patients->nextPageUrl() }}" class="pas-page-btn"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6" /></svg></a>
                @endif
            </div>
        </div>
    </div>

@endif

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if ($tab === 'summary')
    // Color Palette
    const primaryColor = '#C58F59';
    const secondaryColor = '#582C0C';
    const gridColor = '#F3EDE6';

    // 1. Blood Type Chart (Bar)
    const bloodCtx = document.getElementById('bloodTypeChart').getContext('2d');
    new Chart(bloodCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($bloodTypeStats)) !!},
            datasets: [{
                data: {!! json_encode(array_values($bloodTypeStats)) !!},
                backgroundColor: primaryColor,
                hoverBackgroundColor: primaryColor, // Disable hover color change
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: { enabled: true }
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    grid: { color: gridColor },
                    border: { display: true, color: primaryColor, width: 2 }
                },
                x: { 
                    grid: { display: false },
                    border: { display: true, color: primaryColor, width: 2 }
                }
            }
        }
    });

    // 2. Education Chart (Bar)
    const eduCtx = document.getElementById('educationChart').getContext('2d');
    new Chart(eduCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($educationStats)) !!},
            datasets: [{
                data: {!! json_encode(array_values($educationStats)) !!},
                backgroundColor: secondaryColor,
                hoverBackgroundColor: secondaryColor,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { 
                    beginAtZero: true, 
                    grid: { color: gridColor },
                    border: { display: true, color: secondaryColor, width: 2 }
                },
                x: { 
                    grid: { display: false },
                    border: { display: true, color: secondaryColor, width: 2 }
                }
            }
        }
    });
    @endif
});
</script>
@endpush
