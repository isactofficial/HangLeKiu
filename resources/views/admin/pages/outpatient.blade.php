@extends('admin.layout.admin')
@section('title', 'Rawat Jalan')

@section('navbar')
    @include('admin.components.navbar', ['title' => 'Rawat Jalan'])
@endsection

@section('content')
    @php
        $today = today()->toDateString();
        $isToday = $date === $today;
        $selectedDoctorId = request('doctor_id');
        $viewMode = $selectedDoctorId ? 'single' : 'all';
        $selectedDoctor = $selectedDoctorId ? $doctors->find($selectedDoctorId) : null;

        $dateColumns = [];
        if ($viewMode === 'single') {
            $startOffset = (int) request('offset', 0); 
            for ($i = 0; $i < 7; $i++) {
                $dateColumns[] = \Carbon\Carbon::parse($today)
                    ->addDays($startOffset + $i)
                    ->toDateString();
            }
        }
    @endphp

    <div class="rj-outer">
        <div class="rj-wrap">

            {{-- ─── SIDEBAR ─── --}}
            <div class="rj-sidebar">
                <div class="rj-sidebar-title">Dokter</div>
                <ul class="rj-doctor-list">
                    <li>
                        <a href="{{ route('admin.outpatient', ['date' => $date]) }}"
                            class="rj-doc-item {{ $viewMode === 'all' ? 'active' : '' }}">
                            <span class="rj-doc-avatar all">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                </svg>
                            </span>
                            <span class="rj-doc-name">Semua Dokter</span>
                        </a>
                    </li>
                    @foreach ($doctors as $doc)
                        <li>
                            <a href="{{ route('admin.outpatient', ['date' => $date, 'doctor_id' => $doc->id]) }}"
                                class="rj-doc-item {{ $selectedDoctorId == $doc->id ? 'active' : '' }}">
                                <span class="rj-doc-avatar">{{ strtoupper(substr($doc->name, 5, 1)) }}</span>
                                <div class="rj-doc-info">
                                    <span class="rj-doc-name">{{ $doc->name }}</span>
                                    @if ($doc->practice)
                                        <span class="rj-doc-spec">{{ $doc->practice }}</span>
                                    @endif
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- ─── MAIN ─── --}}
            <div class="rj-main">

                {{-- Header --}}
                <div class="rj-header">
                    <div class="rj-header-left">
                        <h1 class="rj-title">Rawat Jalan</h1>
                        <p class="rj-subtitle">hanglekiu dental specialist</p>
                    </div>

                    <div class="rj-legend">
                        <span class="rj-leg"><span class="dot" style="background:#EF4444"></span>Pending</span>
                        <span class="rj-leg"><span class="dot" style="background:#F59E0B"></span>Confirmed</span>
                        <span class="rj-leg"><span class="dot" style="background:#8B5CF6"></span>Waiting</span>
                        <span class="rj-leg"><span class="dot" style="background:#3B82F6"></span>Engaged</span>
                        <span class="rj-leg"><span class="dot" style="background:#84CC16"></span>Succeed</span>
                    </div>

                    {{-- Navigasi --}}
                    <div class="rj-nav">
                        @if ($viewMode === 'all')
                            {{-- Mode all: navigasi per hari --}}
                            <a href="{{ route('admin.outpatient', ['date' => \Carbon\Carbon::parse($date)->subDay()->toDateString()]) }}" class="rj-nav-btn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6" /></svg>
                            </a>
                            <div class="rj-nav-date">
                                <span class="rj-nav-day">{{ $carbon->locale('id')->isoFormat('dddd') }}</span>
                                <span class="rj-nav-full">{{ $carbon->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                            </div>
                            <a href="{{ route('admin.outpatient', ['date' => \Carbon\Carbon::parse($date)->addDay()->toDateString()]) }}" class="rj-nav-btn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6" /></svg>
                            </a>
                            @if ($isToday)
                                <span class="rj-today-btn disabled">Hari Ini</span>
                            @else
                                <a href="{{ route('admin.outpatient') }}" class="rj-today-btn">Hari Ini</a>
                            @endif
                        @else
                            {{-- Mode single doctor: navigasi per minggu --}}
                            @php $offset = (int) request('offset', 0); @endphp
                            <a href="{{ route('admin.outpatient', ['date' => $date, 'doctor_id' => $selectedDoctorId, 'offset' => $offset - 1]) }}" class="rj-nav-btn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6" /></svg>
                            </a>
                            <div class="rj-nav-date">
                                <span class="rj-nav-day">{{ $selectedDoctor?->name }}</span>
                                <span class="rj-nav-full">
                                    {{ \Carbon\Carbon::parse($dateColumns[0])->locale('id')->isoFormat('D MMM') }}
                                    – {{ \Carbon\Carbon::parse($dateColumns[6])->locale('id')->isoFormat('D MMM YYYY') }}
                                </span>
                            </div>
                            <a href="{{ route('admin.outpatient', ['date' => $date, 'doctor_id' => $selectedDoctorId, 'offset' => $offset + 1]) }}" class="rj-nav-btn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6" /></svg>
                            </a>
                            @if ($offset === 0)
                                <span class="rj-today-btn disabled">Hari Ini</span>
                            @else
                                <a href="{{ route('admin.outpatient', ['date' => $today, 'doctor_id' => $selectedDoctorId]) }}" class="rj-today-btn">Hari Ini</a>
                            @endif
                        @endif
                    </div>
                </div>

                {{-- Grid --}}
                <div class="rj-table-wrap">
                    <table class="rj-table">
                        <thead>
                            <tr>
                                <th class="th-time">JAM</th>
                                @if ($viewMode === 'all')
                                    @foreach ($doctors as $doc)
                                        <th>{{ strtoupper($doc->full_title) }}</th>
                                    @endforeach
                                @else
                                    @foreach ($dateColumns as $dc)
                                        @php
                                            $dcCarbon = \Carbon\Carbon::parse($dc);
                                            $isColToday = $dc === $today;
                                        @endphp
                                        <th class="{{ $isColToday ? 'th-today' : '' }}">
                                            <div class="th-date-col">
                                                <span class="th-weekday">{{ $dcCarbon->locale('id')->isoFormat('ddd') }}</span>
                                                <span class="th-datenum {{ $isColToday ? 'today-badge' : '' }}">{{ $dcCarbon->format('d') }}</span>
                                                <span class="th-month">{{ $dcCarbon->locale('id')->isoFormat('MMM') }}</span>
                                            </div>
                                        </th>
                                    @endforeach
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php $now = \Carbon\Carbon::now()->format('H:i'); @endphp
                            @foreach ($timeSlots as $slot)
                                <tr>
                                    <td class="td-time">{{ $slot }}</td>
                                    @if ($viewMode === 'all')
                                        @foreach ($doctors as $doc)
                                            @php $apt = $schedule[$doc->id][$slot] ?? null; @endphp
                                            <td>
                                                @if ($apt)
                                                    <div class="apt-card" style="border-left-color:{{ $apt->status_color }}" onclick="openModal({{ $apt->id }},'{{ addslashes($apt->patient_name) }}','{{ $apt->status }}')">
                                                        <div class="apt-name">{{ $apt->patient_name }}</div>
                                                        <div class="apt-treat">{{ $apt->treatment->name }}</div>
                                                        <span class="apt-badge" style="background:{{ $apt->status_color }}">{{ ucfirst($apt->status) }}</span>
                                                    </div>
                                                @endif
                                            </td>
                                        @endforeach
                                    @else
                                        @foreach ($dateColumns as $dc)
                                            @php
                                                $apt = \App\Models\Appointment::with('treatment')
                                                    ->where('doctor_id', $selectedDoctorId)
                                                    ->whereDate('appointment_date', $dc)
                                                    ->where('appointment_time', $slot . ':00')
                                                    ->first();
                                                $isColToday = $dc === $today;
                                            @endphp
                                            <td class="{{ $isColToday ? 'col-today' : '' }}">
                                                @if ($apt)
                                                    <div class="apt-card" style="border-left-color:{{ $apt->status_color }}" onclick="openModal({{ $apt->id }},'{{ addslashes($apt->patient_name) }}','{{ $apt->status }}')">
                                                        <div class="apt-name">{{ $apt->patient_name }}</div>
                                                        <div class="apt-treat">{{ $apt->treatment->name }}</div>
                                                        <span class="apt-badge" style="background:{{ $apt->status_color }}">{{ ucfirst($apt->status) }}</span>
                                                    </div>
                                                @endif
                                            </td>
                                        @endforeach
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div id="aptModal" class="modal-overlay" onclick="closeModalOutside(event)">
        <div class="modal-box">
            <div class="modal-head">
                <h3 id="modalName">Update Status</h3>
                <button onclick="closeModal()">✕</button>
            </div>
            <div class="modal-body">
                <p>Pilih status baru:</p>
                <div class="modal-btns">
                    <button style="background:#EF4444" onclick="setStatus('pending')">Pending</button>
                    <button style="background:#F59E0B" onclick="setStatus('confirmed')">Confirmed</button>
                    <button style="background:#8B5CF6" onclick="setStatus('waiting')">Waiting</button>
                    <button style="background:#3B82F6" onclick="setStatus('engaged')">Engaged</button>
                    <button style="background:#84CC16" onclick="setStatus('succeed')">Succeed</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --brown: #582C0C;
            --gold: #C58F59;
            --cream: #fdf8f4;
            --border: #E5D6C5;
        }

        .rj-outer {
            padding: 0 0px 20px 0px;
            font-family: 'Instrument Sans', sans-serif;
            font-size: 13px;
        }

        .rj-outer * {
            font-size: 13px;
        }

        .rj-title,
        .th-datenum,
        .modal-head h3 {
            font-size: 18.75px;
            font-weight: 700;
        }

        .rj-wrap {
            display: flex;
            gap: 16px;
            align-items: flex-start;
        }

        .rj-sidebar {
            width: 220px;
            flex-shrink: 0;
            background: white;
            border-radius: 10px;
            border: 1px solid var(--border);
            align-self: flex-start;
            overflow: hidden;
        }

        .rj-sidebar-title {
            padding: 16px 18px 10px;
            font-weight: 700;
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .rj-doctor-list {
            list-style: none;
            padding: 0 8px 12px;
            margin: 0;
        }

        .rj-doc-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 10px;
            border-radius: 8px;
            text-decoration: none;
            color: var(--brown);
            transition: background .15s;
            cursor: pointer;
        }

        .rj-doc-item:hover { background: rgba(197, 143, 89, .08); }
        .rj-doc-item.active { background: rgba(88, 44, 12, .08); }

        .rj-doc-avatar {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--gold);
            color: white;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .rj-doc-avatar.all { background: var(--brown); }

        .rj-doc-info {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .rj-doc-name {
            font-weight: 600;
            color: var(--brown);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .rj-doc-spec { color: var(--gold); }

        .rj-main {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            background: white;
            border-radius: 10px;
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .rj-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            gap: 16px;
            flex-wrap: wrap;
            border-bottom: 1px solid var(--border);
        }

        .rj-header-left { flex: 1; min-width: 160px; }
        .rj-title { color: var(--brown); margin: 0; font-size: 30px; font-weight: 700; }
        .rj-subtitle { color: var(--gold); margin: 4px 0 0 0; font-size: 18.75px; }

        .rj-legend {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .rj-leg {
            color: #6B513E;
            display: flex;
            align-items: center;
            gap: 5px;
            font-weight: 500;
        }

        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
        }

        .rj-nav { display: flex; align-items: center; gap: 8px; }
        .rj-nav-btn {
            width: 32px; height: 32px;
            border-radius: 8px;
            border: 2px solid var(--brown);
            background: var(--brown);
            color: white;
            display: flex; align-items: center; justify-content: center;
            text-decoration: none; cursor: pointer; transition: all .2s;
        }
        .rj-nav-btn:hover { background: #401f08; border-color: #401f08; }
        .rj-nav-btn.disabled { background: transparent; color: var(--brown); cursor: not-allowed; opacity: .5; pointer-events: none; }
        
        .rj-nav-date { display: flex; flex-direction: column; align-items: center; line-height: 1.2; min-width: 130px; }
        .rj-nav-day { font-weight: 700; color: var(--gold); }
        .rj-nav-full { font-weight: 700; color: var(--brown); }

        .rj-today-btn {
            padding: 6px 14px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer; text-decoration: none; transition: all .2s;
            background: var(--brown); color: white; border: 2px solid var(--brown);
        }
        .rj-today-btn:hover { background: #401f08; }
        .rj-today-btn.disabled { background: transparent; color: var(--brown); cursor: not-allowed; opacity: .6; pointer-events: none; border-color: var(--brown); }

        .rj-table-wrap {
            height: 500px;
            overflow: auto;
        }
        .rj-table-wrap::-webkit-scrollbar { width: 6px; height: 6px; }
        .rj-table-wrap::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 4px; }

        .rj-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .th-time, .td-time {
            width: 72px;
            position: sticky; left: 0;
            background: white; z-index: 2;
            border-right: 1px solid var(--border);
            text-align: center;
            color: var(--brown);
            font-weight: 600;
        }

        .rj-table th {
            background: var(--brown);
            color: white;
            font-weight: 600;
            padding: 10px 8px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, .1);
            position: sticky; top: 0; z-index: 1;
        }

        .rj-table th.th-time { z-index: 3; }
        .rj-table th.th-today { background: #401f08; }

        .th-date-col { display: flex; flex-direction: column; align-items: center; gap: 2px; }
        .th-weekday, .th-month { opacity: .7; }
        .th-datenum { line-height: 1; }
        .th-datenum.today-badge {
            background: var(--gold); color: white;
            width: 32px; height: 32px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
        }

        .rj-table td {
            border: 1px solid var(--border);
            height: 60px;
            padding: 6px;
            vertical-align: top;
        }
        .rj-table td.col-today { background: rgba(88, 44, 12, .02); }
        .td-time { height: 60px; vertical-align: middle !important; }

        .apt-card {
            border-radius: 5px;
            padding: 6px;
            cursor: pointer;
            border-left: 4px solid var(--gold);
            background: var(--cream);
            transition: background .15s;
            height: 100%;
        }
        .apt-card:hover { background: #f0e8df; }

        .apt-name {
            font-weight: 700; color: var(--brown);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .apt-treat {
            color: #9a7a60;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .apt-badge {
            color: white;
            padding: 2px 6px;
            border-radius: 8px;
            display: inline-block;
            margin-top: 4px;
            font-weight: 600;
        }

        .modal-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0, 0, 0, .4); z-index: 1000;
            align-items: center; justify-content: center;
        }
        .modal-overlay.open { display: flex; }
        .modal-box { background: white; border-radius: 16px; width: 340px; overflow: hidden; box-shadow: 0 8px 40px rgba(88, 44, 12, .2); }
        .modal-head { background: var(--brown); color: white; padding: 14px 18px; display: flex; justify-content: space-between; align-items: center; }
        .modal-head button { background: none; border: none; color: white; cursor: pointer; opacity: .8; }
        .modal-body { padding: 16px; }
        .modal-body p { color: #6B513E; margin: 0 0 12px; }
        .modal-btns { display: flex; flex-direction: column; gap: 7px; }
        .modal-btns button {
            width: 100%; padding: 9px; border: none; border-radius: 8px;
            color: white; font-weight: 600; cursor: pointer;
            text-align: left; transition: opacity .2s;
        }
        .modal-btns button:hover { opacity: .85; }

    </style>

    <script>
        let activeId = null;

        function openModal(id, name, status) {
            activeId = id;
            document.getElementById('modalName').textContent = name;
            document.getElementById('aptModal').classList.add('open');
        }

        function closeModal() {
            document.getElementById('aptModal').classList.remove('open');
            activeId = null;
        }

        function closeModalOutside(e) {
            if (e.target.id === 'aptModal') closeModal();
        }

        function setStatus(status) {
            if (!activeId) return;
            fetch(`/admin/appointments/${activeId}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        status
                    })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        closeModal();
                        location.reload();
                    }
                });
        }
    </script>
@endsection