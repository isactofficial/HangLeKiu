@extends('admin.layout.admin')
@section('title', 'Rawat Jalan')

@section('navbar')
    @include('admin.components.navbar', ['title' => 'Rawat Jalan'])
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/pages/outpatient.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/pages/registration-shared.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/pages/pasien-baru.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/pages/pendaftaran-baru.css') }}">
@endpush

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
                <div class="rj-mobile-doc-nav">
                    <select class="rj-doc-select" onchange="if(this.value) window.location.href=this.value">
                        <option value="{{ route('admin.outpatient', ['date' => $date]) }}" {{ $viewMode === 'all' ? 'selected' : '' }}>Semua Dokter</option>
                        @foreach ($doctors as $doc)
                            <option value="{{ route('admin.outpatient', ['date' => $date, 'doctor_id' => $doc->id]) }}" {{ $selectedDoctorId == $doc->id ? 'selected' : '' }}>{{ $doc->full_name }} @if($doc->specialization) - {{ $doc->specialization }} @endif</option>
                        @endforeach
                    </select>
                </div>
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
                                <span class="rj-doc-avatar">{{ strtoupper(substr($doc->full_name, 0, 1)) }}</span>
                                <div class="rj-doc-info">
                                    <span class="rj-doc-name">{{ $doc->full_name }}</span>
                                    @if ($doc->specialization)
                                        <span class="rj-doc-spec">{{ $doc->specialization }}</span>
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
                                <span class="rj-nav-day">{{ $selectedDoctor?->full_name }}</span>
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

                {{-- Grid Desktop --}}
                <div class="rj-table-wrap desktop-table">
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
                                            @php 
                                                $apt = $schedule[$doc->id][$slot] ?? null; 
                                                $poliId = $doc->poli_id ?? ''; // Assuming doctor has poli_id relation or attribute
                                            @endphp
                                            <td onclick="openRegModal('modalPendaftaranBaru', '{{ $doc->id }}', '{{ $slot }}', '{{ $poliId }}')">
                                                @if ($apt)
                                                    <div class="apt-card" style="border-left-color:{{ $apt->status_color }}" 
                                                        data-id="{{ $apt->id }}"
                                                        data-patient="{{ $apt->patient_name }}"
                                                        data-mr="{{ $apt->mr_number }}"
                                                        data-treatment="{{ $apt->treatment_name }}"
                                                        data-time="{{ $slot }}"
                                                        data-doctor="{{ $doc->full_name }}"
                                                        data-status="{{ $apt->status }}"
                                                        onclick="handleAptClick(this, event)">
                                                        <div class="apt-name" style="{{ $apt->status === 'pending' ? 'color: #ef4444;' : '' }}">{{ $apt->patient_name }}</div>
                                                        <div class="apt-treat">{{ $apt->treatment_name }}</div>
                                                        <span class="apt-badge" style="background:{{ $apt->status_color }}">{{ ucfirst($apt->status) }}</span>
                                                    </div>
                                                @endif
                                            </td>
                                        @endforeach
                                    @else
    {{-- Mode Per Dokter (Mingguan) --}}
    @foreach ($dateColumns as $dc)
        @php
            // JANGAN PAKAI QUERY DATABASE LAGI DISINI BOSS!
            // Ambil langsung dari $schedule yang sudah kita bulatkan di Controller
            $apt = $schedule[$dc][$slot] ?? null; 
            
            $isColToday = $dc === $today;
            $poliId = $selectedDoctor->poli_id ?? '';
        @endphp
        
        <td class="{{ $isColToday ? 'col-today' : '' }}" onclick="openRegModal('modalPendaftaranBaru', '{{ $selectedDoctorId }}', '{{ $slot }}', '{{ $poliId }}', '{{ $dc }}')">
            @if ($apt)
                <div class="apt-card" style="border-left: 4px solid {{ $apt->status_color }}" 
                    data-id="{{ $apt->id }}"
                    data-patient="{{ $apt->patient_name }}"
                    onclick="handleAptClick(this, event)">
                    <div class="apt-name" style="{{ $apt->status === 'pending' ? 'color: #ef4444;' : '' }}">
                        {{ $apt->patient_name }}
                    </div>
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

                {{-- Mobile Cards --}}
                <div class="rj-mobile-schedule">
                    @if ($viewMode === 'all')
                        @foreach ($timeSlots as $slot)
                            @php
                                $hasApt = false;
                                foreach($doctors as $doc) {
                                    if(isset($schedule[$doc->id][$slot])) $hasApt = true;
                                }
                            @endphp
                            <div class="mobile-time-group">
                                <div class="m-time-label">{{ $slot }}</div>
                                <div class="m-cards">
                                    @if ($hasApt)
                                        @foreach ($doctors as $doc)
                                            @php $apt = $schedule[$doc->id][$slot] ?? null; @endphp
                                            @if ($apt)
                                                <div class="apt-card m-card" style="border-left-color:{{ $apt->status_color }}" 
                                                    data-id="{{ $apt->id }}"
                                                    data-patient="{{ $apt->patient_name }}"
                                                    data-mr="{{ $apt->mr_number }}"
                                                    data-treatment="{{ $apt->treatment_name }}"
                                                    data-time="{{ $slot }}"
                                                    data-doctor="{{ $doc->full_name }}"
                                                    data-status="{{ $apt->status }}"
                                                    onclick="handleAptClick(this, event)">
                                                    <div class="m-card-header">
                                                        <div class="apt-name">{{ $apt->patient_name }}</div>
                                                        <span class="apt-badge" style="background:{{ $apt->status_color }}">{{ ucfirst($apt->status) }}</span>
                                                    </div>
                                                    <div class="apt-treat">{{ $apt->treatment_name }}</div>
                                                    <div class="m-doc-name">
                                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg> 
                                                        {{ $doc->full_name }}
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        <div class="m-empty-slot" onclick="openRegModal('modalPendaftaranBaru', '{{ $doc->id }}', '{{ $slot }}', '{{ $doc->poli_id ?? '' }}', '{{ $date }}')" style="cursor:pointer;">Kosong (Klik untuk Daftar)</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        @foreach ($dateColumns as $dc)
                            @php 
                                $dcCarbon = \Carbon\Carbon::parse($dc); 
                                $aptsForDate = \App\Models\Appointment::with('patient')
                                    ->where('doctor_id', $selectedDoctorId)
                                    ->whereDate('appointment_datetime', $dc)
                                    ->orderBy('appointment_datetime')
                                    ->get();
                            @endphp
                            <div class="mobile-time-group">
                                <div class="m-time-label" style="background: var(--gold); color: white;">
                                    {{ $dcCarbon->locale('id')->isoFormat('dddd, D MMM YYYY') }}
                                </div>
                                <div class="m-cards">
                                    @if ($aptsForDate->count() > 0)
                                        @foreach ($aptsForDate as $apt)
                                            <div class="apt-card m-card" style="border-left-color:{{ $apt->status_color }}" 
                                                data-id="{{ $apt->id }}"
                                                data-patient="{{ $apt->patient_name }}"
                                                data-mr="{{ $apt->mr_number }}"
                                                data-treatment="{{ $apt->treatment_name }}"
                                                data-time="{{ \Carbon\Carbon::parse($apt->appointment_datetime)->format('H:i') }}"
                                                data-doctor="{{ $apt->doctor?->full_name ?? $selectedDoctor->full_name }}"
                                                data-status="{{ $apt->status }}"
                                                onclick="handleAptClick(this, event)">
                                                <div class="m-card-header">
                                                    <div class="apt-name">{{ \Carbon\Carbon::parse($apt->appointment_datetime)->format('H:i') }} | {{ $apt->patient_name }}</div>
                                                    <span class="apt-badge" style="background:{{ $apt->status_color }}">{{ ucfirst($apt->status) }}</span>
                                                </div>
                                                <div class="apt-treat">{{ $apt->treatment_name }}</div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="m-empty-slot" onclick="openRegModal('modalPendaftaranBaru', '{{ $selectedDoctorId }}', '{{ $slot }}', '{{ $selectedDoctor->poli_id ?? '' }}', '{{ $dc }}')" style="cursor:pointer;">Tidak ada jadwal (Klik untuk Daftar)</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

            </div>
        </div>
    </div>


<script>
        // Registration Modal Functions
        function openRegModal(modalId, doctorId = null, time = null, poliId = null, date = null) {
            const modal = document.getElementById(modalId);
            if (!modal) return;

            modal.classList.add('open');
            document.body.style.overflow = 'hidden'; 

            if (modalId === 'modalPendaftaranBaru') {
                // Pre-fill fields in pendaftaran-baru.blade.php
                if (doctorId) {
                    const docSelect = document.getElementById('pb_doctor_id');
                    if (docSelect) docSelect.value = doctorId;
                }
                if (time) {
                    const timeInput = document.getElementById('pb_appointment_time');
                    if (timeInput) timeInput.value = time;
                }
                if (poliId) {
                    const poliSelect = document.getElementById('pb_poli_id');
                    if (poliSelect) poliSelect.value = poliId;
                }
                if (date) {
                    const dateInput = document.getElementById('pb_appointment_date');
                    if (dateInput) dateInput.value = date;
                }
            }
        }
        
        function closeRegModal(modalId) {
            document.getElementById(modalId).classList.remove('open');
            document.body.style.overflow = '';
        }

        // Close registration modals when clicking overlay
        window.addEventListener('click', function(e) {
            if (e.target.classList.contains('reg-modal-overlay')) {
                closeRegModal(e.target.id);
            }
        });
        function handleAptClick(el, e) {
        if (e) e.stopPropagation();
        const id = el.getAttribute('data-id');
        const patient = el.getAttribute('data-patient');
        const mr = el.getAttribute('data-mr');
        const treatment = el.getAttribute('data-treatment');
        const time = el.getAttribute('data-time');
        const doctor = el.getAttribute('data-doctor');
        const status = el.getAttribute('data-status');
        
        console.log('Opening Apt Detail Modal for:', patient);
        openApptDetailModal(id, patient, mr, treatment, time, doctor, status);
    }
</script>

    <!-- Include Registration Modals -->
    @include('admin.components.pasien-baru')
    @include('admin.components.pendaftaran-baru')
    @include('admin.components.appointment-detail')

@endsection