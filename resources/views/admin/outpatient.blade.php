@extends('layouts.admin')
@section('title', 'Rawat Jalan')

@section('navbar')
    @include('components.navbar', ['title' => 'Rawat Jalan'])
@endsection

@section('content')
<div class="rj-container">

    {{-- Page Header --}}
    <div class="rj-header">
        <div class="rj-title-area">
            <h1 class="rj-title">Rawat Jalan</h1>
            <p class="rj-subtitle">hanglekiu dental specialist</p>
        </div>

        {{-- Status Legend --}}
        <div class="rj-status-legend">
            <span class="rj-status-item"><span class="rj-dot" style="background:#EF4444"></span> Pending</span>
            <span class="rj-status-item"><span class="rj-dot" style="background:#F59E0B"></span> Confirmed</span>
            <span class="rj-status-item"><span class="rj-dot" style="background:#8B5CF6"></span> Waiting</span>
            <span class="rj-status-item"><span class="rj-dot" style="background:#3B82F6"></span> Engaged</span>
            <span class="rj-status-item"><span class="rj-dot" style="background:#84CC16"></span> Succeed</span>
        </div>

        {{-- Navigasi Tanggal --}}
        <div class="rj-header-actions">
            <div class="rj-date-nav">
                <a href="{{ route('admin.outpatient', ['date' => \Carbon\Carbon::parse($date)->subDay()->toDateString()]) }}" class="rj-icon-btn">
                    <i class="fas fa-chevron-left"></i>
                </a>
                <div class="rj-date-text">
                    <span class="rj-date-day">{{ $carbon->locale('id')->isoFormat('dddd') }}</span>
                    <span class="rj-date-full">{{ $carbon->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                </div>
                <a href="{{ route('admin.outpatient', ['date' => \Carbon\Carbon::parse($date)->addDay()->toDateString()]) }}" class="rj-icon-btn">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
            <a href="{{ route('admin.outpatient') }}" class="rj-btn-today">HARI INI</a>
        </div>
    </div>

    {{-- Layout Utama --}}
    <div class="rj-layout">

        {{-- Sidebar Daftar Dokter --}}
        <div class="rj-sidebar">
            <div class="rj-sidebar-header">Seluruh Dokter</div>
            <ul class="rj-doctor-list">
                @foreach($doctors as $doctor)
                    <li class="rj-doctor-item">{{ $doctor->full_title }}</li>
                @endforeach
            </ul>
        </div>

        {{-- Grid Jadwal --}}
        <div class="rj-main">
            <div class="rj-table-wrapper">
                <table class="rj-table">
                    <thead>
                        <tr>
                            <th class="rj-time-col sticky-col">JAM</th>
                            @foreach($doctors as $doctor)
                                <th>
                                    <div class="rj-th-content">
                                        <span>{{ strtoupper($doctor->full_title) }}</span>
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php $now = \Carbon\Carbon::now()->format('H:i'); @endphp

                        @foreach($timeSlots as $slot)
                            <tr>
                                <td class="rj-time-col sticky-col">
                                    @if($date === today()->toDateString() && $slot === collect($timeSlots)->first(fn($t) => $t >= $now))
                                        <span class="rj-current-time-dot"></span>
                                    @endif
                                    {{ $slot }} WIB
                                </td>

                                @foreach($doctors as $doctor)
                                    @php $apt = $schedule[$doctor->id][$slot] ?? null; @endphp
                                    <td>
                                        @if($apt)
                                            <div class="rj-appointment"
                                                 style="border-left:3px solid {{ $apt->status_color }}"
                                                 onclick="openStatusModal({{ $apt->id }}, '{{ addslashes($apt->patient_name) }}', '{{ $apt->status }}')"
                                                 title="{{ $apt->patient_name }} — {{ $apt->treatment->name }}">
                                                <div class="rj-apt-name">{{ $apt->patient_name }}</div>
                                                <div class="rj-apt-treatment">{{ $apt->treatment->name }}</div>
                                                <span class="rj-apt-status" style="background:{{ $apt->status_color }}">
                                                    {{ ucfirst($apt->status) }}
                                                </span>
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal Update Status --}}
<div id="statusModal" class="rj-modal-overlay" onclick="closeModal(event)">
    <div class="rj-modal">
        <div class="rj-modal-header">
            <h3 id="modalPatientName">Update Status</h3>
            <button class="rj-modal-close" onclick="closeStatusModal()">✕</button>
        </div>
        <div class="rj-modal-body">
            <p style="font-size:13px;color:#6B513E;margin-bottom:16px">Pilih status baru untuk pasien ini:</p>
            <div class="rj-status-btns">
                <button class="rj-status-btn" style="background:#EF4444" onclick="updateStatus('pending')">Pending</button>
                <button class="rj-status-btn" style="background:#F59E0B" onclick="updateStatus('confirmed')">Confirmed</button>
                <button class="rj-status-btn" style="background:#8B5CF6" onclick="updateStatus('waiting')">Waiting</button>
                <button class="rj-status-btn" style="background:#3B82F6" onclick="updateStatus('engaged')">Engaged</button>
                <button class="rj-status-btn" style="background:#84CC16" onclick="updateStatus('succeed')">Succeed</button>
            </div>
        </div>
    </div>
</div>

<style>
    .rj-container { padding:0 16px 24px 16px; font-family:'Instrument Sans',sans-serif; }
    .rj-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:16px; }
    .rj-title-area { flex:1; min-width:200px; }
    .rj-title { font-size:24px; font-weight:700; color:#582C0C; margin:0; }
    .rj-subtitle { font-size:14px; color:#C58F59; margin:4px 0 0; }
    .rj-status-legend { display:flex; gap:14px; align-items:center; flex-wrap:wrap; }
    .rj-status-item { font-size:12px; color:#6B513E; display:flex; align-items:center; gap:6px; font-weight:500; }
    .rj-dot { width:10px; height:10px; border-radius:50%; display:inline-block; }
    .rj-header-actions { display:flex; align-items:center; gap:14px; }
    .rj-date-nav { display:flex; align-items:center; gap:10px; }
    .rj-date-text { display:flex; flex-direction:column; align-items:center; line-height:1.2; }
    .rj-date-day { font-size:13px; font-weight:700; color:#C58F59; }
    .rj-date-full { font-size:15px; font-weight:700; color:#582C0C; }
    .rj-icon-btn { background:none; border:none; color:#C58F59; cursor:pointer; font-size:16px; padding:4px; text-decoration:none; transition:color 0.2s; }
    .rj-icon-btn:hover { color:#582C0C; }
    .rj-btn-today { background:#582C0C; color:white; border:none; padding:8px 16px; border-radius:4px; font-size:13px; font-weight:700; cursor:pointer; text-decoration:none; transition:background 0.2s; }
    .rj-btn-today:hover { background:#401f08; }
    .rj-layout { display:flex; gap:20px; align-items:flex-start; }
    .rj-sidebar { width:240px; flex-shrink:0; background:white; box-shadow:0 1px 3px rgba(88,44,12,0.08); }
    .rj-sidebar-header { background:#C58F59; color:white; font-size:15px; font-weight:600; padding:14px 18px; text-align:center; }
    .rj-doctor-list { list-style:none; padding:0; margin:0; }
    .rj-doctor-item { padding:14px 18px; font-size:13px; color:#582C0C; border:1px solid #E5D6C5; border-top:none; cursor:pointer; transition:background 0.2s; }
    .rj-doctor-item:hover { background:rgba(197,143,89,0.06); }
    .rj-main { flex:1; min-width:0; background:white; box-shadow:0 1px 3px rgba(88,44,12,0.08); }
    .rj-table-wrapper { width:100%; max-height:620px; overflow-x:auto; overflow-y:auto; }
    .rj-table-wrapper::-webkit-scrollbar { width:7px; height:7px; }
    .rj-table-wrapper::-webkit-scrollbar-thumb { background:#C58F59; border-radius:4px; }
    .rj-table { width:100%; min-width:900px; border-collapse:collapse; table-layout:fixed; }
    .sticky-col { position:sticky; left:0; background:white; z-index:2; border-right:1px solid #E5D6C5 !important; }
    .rj-table th { background:#C58F59; color:white; font-size:12px; font-weight:600; padding:14px 12px; text-align:left; border:1px solid #b07d4a; position:sticky; top:0; z-index:1; }
    .rj-table th.sticky-col { z-index:3; width:90px; text-align:center; }
    .rj-th-content { display:flex; justify-content:space-between; align-items:center; gap:6px; }
    .rj-table td { border:1px solid #E5D6C5; height:64px; padding:8px; vertical-align:top; }
    .rj-time-col { font-size:12px; color:#582C0C; text-align:center; font-weight:500; vertical-align:middle !important; position:relative; }
    .rj-current-time-dot { display:inline-block; width:9px; height:9px; background:#3B82F6; border-radius:50%; position:absolute; left:7px; top:50%; transform:translateY(-50%); }
    .rj-appointment { background:#fdf8f4; border-radius:6px; padding:6px 8px; cursor:pointer; border-left:3px solid #C58F59; transition:background 0.2s; height:100%; }
    .rj-appointment:hover { background:#f5ede3; }
    .rj-apt-name { font-size:12px; font-weight:700; color:#582C0C; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .rj-apt-treatment { font-size:11px; color:#9a7a60; margin-top:1px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .rj-apt-status { font-size:10px; color:white; padding:1px 6px; border-radius:10px; display:inline-block; margin-top:3px; font-weight:600; }
    .rj-modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:1000; align-items:center; justify-content:center; }
    .rj-modal-overlay.open { display:flex; }
    .rj-modal { background:white; border-radius:16px; width:360px; overflow:hidden; box-shadow:0 8px 40px rgba(88,44,12,0.2); }
    .rj-modal-header { background:#582C0C; color:white; padding:16px 20px; display:flex; justify-content:space-between; align-items:center; }
    .rj-modal-header h3 { font-size:15px; font-weight:700; }
    .rj-modal-close { background:none; border:none; color:white; font-size:18px; cursor:pointer; opacity:0.8; }
    .rj-modal-close:hover { opacity:1; }
    .rj-modal-body { padding:20px; }
    .rj-status-btns { display:flex; flex-direction:column; gap:8px; }
    .rj-status-btn { width:100%; padding:10px; border:none; border-radius:8px; color:white; font-size:14px; font-weight:600; font-family:'Instrument Sans',sans-serif; cursor:pointer; transition:opacity 0.2s; }
    .rj-status-btn:hover { opacity:0.85; }
    @media(max-width:992px) {
        .rj-layout { flex-direction:column; }
        .rj-sidebar { width:100%; }
        .rj-header { flex-direction:column; align-items:flex-start; }
    }
</style>

<script>
let currentAptId = null;

function openStatusModal(id, name, currentStatus) {
    currentAptId = id;
    document.getElementById('modalPatientName').textContent = name;
    document.getElementById('statusModal').classList.add('open');
}

function closeStatusModal() {
    document.getElementById('statusModal').classList.remove('open');
    currentAptId = null;
}

function closeModal(e) {
    if (e.target === document.getElementById('statusModal')) closeStatusModal();
}

function updateStatus(status) {
    if (!currentAptId) return;

    fetch(`/admin/appointments/${currentAptId}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ status })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            closeStatusModal();
            location.reload();
        }
    })
    .catch(err => console.error(err));
}
</script>
@endsection
