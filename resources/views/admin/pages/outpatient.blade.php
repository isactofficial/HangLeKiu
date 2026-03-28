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
<<<<<<< HEAD
<<<<<<< Updated upstream
=======
                <div class="rj-mobile-doc-nav">
                    <select class="rj-doc-select" onchange="if(this.value) window.location.href=this.value">
                        <option value="{{ route('admin.rawat-jalan', ['date' => $date]) }}" {{ $viewMode === 'all' ? 'selected' : '' }}>Semua Dokter</option>
                        @foreach ($doctors as $doc)
                            <option value="{{ route('admin.rawat-jalan', ['date' => $date, 'doctor_id' => $doc->id]) }}" {{ $selectedDoctorId == $doc->id ? 'selected' : '' }}>{{ $doc->full_name }} @if($doc->specialization) - {{ $doc->specialization }} @endif</option>
                        @endforeach
                    </select>
                </div>
>>>>>>> Stashed changes
=======
                <div class="rj-mobile-doc-nav">
                    <select class="rj-doc-select" onchange="if(this.value) window.location.href=this.value">
                        <option value="{{ route('admin.outpatient', ['date' => $date]) }}" {{ $viewMode === 'all' ? 'selected' : '' }}>Semua Dokter</option>
                        @foreach ($doctors as $doc)
                            <option value="{{ route('admin.outpatient', ['date' => $date, 'doctor_id' => $doc->id]) }}" {{ $selectedDoctorId == $doc->id ? 'selected' : '' }}>{{ $doc->full_name }} @if($doc->specialization) - {{ $doc->specialization }} @endif</option>
                        @endforeach
                    </select>
                </div>
>>>>>>> origin/main
                <ul class="rj-doctor-list">
                    <li>
                        <a href="{{ route('admin.rawat-jalan', ['date' => $date]) }}"
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
                            <a href="{{ route('admin.rawat-jalan', ['date' => $date, 'doctor_id' => $doc->id]) }}"
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
                            <a href="{{ route('admin.rawat-jalan', ['date' => \Carbon\Carbon::parse($date)->subDay()->toDateString()]) }}" class="rj-nav-btn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6" /></svg>
                            </a>
                            <div class="rj-nav-date">
                                <span class="rj-nav-day">{{ $carbon->locale('id')->isoFormat('dddd') }}</span>
                                <span class="rj-nav-full">{{ $carbon->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                            </div>
                            <a href="{{ route('admin.rawat-jalan', ['date' => \Carbon\Carbon::parse($date)->addDay()->toDateString()]) }}" class="rj-nav-btn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6" /></svg>
                            </a>
                            @if ($isToday)
                                <span class="rj-today-btn disabled">Hari Ini</span>
                            @else
                                <a href="{{ route('admin.rawat-jalan') }}" class="rj-today-btn">Hari Ini</a>
                            @endif
                        @else
                            {{-- Mode single doctor: navigasi per minggu --}}
                            @php $offset = (int) request('offset', 0); @endphp
                            <a href="{{ route('admin.rawat-jalan', ['date' => $date, 'doctor_id' => $selectedDoctorId, 'offset' => $offset - 1]) }}" class="rj-nav-btn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6" /></svg>
                            </a>
                            <div class="rj-nav-date">
                                <span class="rj-nav-day">{{ $selectedDoctor?->full_name }}</span>
                                <span class="rj-nav-full">
                                    {{ \Carbon\Carbon::parse($dateColumns[0])->locale('id')->isoFormat('D MMM') }}
                                    – {{ \Carbon\Carbon::parse($dateColumns[6])->locale('id')->isoFormat('D MMM YYYY') }}
                                </span>
                            </div>
                            <a href="{{ route('admin.rawat-jalan', ['date' => $date, 'doctor_id' => $selectedDoctorId, 'offset' => $offset + 1]) }}" class="rj-nav-btn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6" /></svg>
                            </a>
                            @if ($offset === 0)
                                <span class="rj-today-btn disabled">Hari Ini</span>
                            @else
                                <a href="{{ route('admin.rawat-jalan', ['date' => $today, 'doctor_id' => $selectedDoctorId]) }}" class="rj-today-btn">Hari Ini</a>
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
<<<<<<< HEAD
<<<<<<< Updated upstream
                                                    <div class="apt-card" style="border-left-color:{{ $apt->status_color }}" onclick="openModal({{ $apt->id }},'{{ addslashes($apt->patient_name) }}','{{ $apt->status }}')">
                                                        <div class="apt-name">{{ $apt->patient_name }}</div>
                                                        <div class="apt-treat">{{ $apt->treatment->name }}</div>
=======
                                                    <div class="apt-card" style="border-left-color:{{ $apt->status_color }}" onclick="event.stopPropagation(); openModal('{{ $apt->id }}')">
                                                        <div class="apt-name" style="{{ $apt->status === 'pending' ? 'color: #ef4444;' : '' }}">{{ $apt->patient_name }}</div>
                                                        <div class="apt-treat">{{ $apt->treatment_name }}</div>
>>>>>>> Stashed changes
=======
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
>>>>>>> origin/main
                                                        <span class="apt-badge" style="background:{{ $apt->status_color }}">{{ ucfirst($apt->status) }}</span>
                                                    </div>
                                                @endif
                                            </td>
                                        @endforeach
                                    @else
                                        @foreach ($dateColumns as $dc)
                                            @php
                                                $apt = \App\Models\Appointment::with('patient')
                                                    ->where('doctor_id', $selectedDoctorId)
                                                    ->whereDate('appointment_datetime', $dc)
                                                    ->whereTime('appointment_datetime', $slot)
                                                    ->first();
                                                $isColToday = $dc === $today;
                                                $poliId = $selectedDoctor->poli_id ?? '';
                                            @endphp
                                            <td class="{{ $isColToday ? 'col-today' : '' }}" onclick="openRegModal('modalPendaftaranBaru', '{{ $selectedDoctorId }}', '{{ $slot }}', '{{ $poliId }}', '{{ $dc }}')">
                                                @if ($apt)
<<<<<<< HEAD
<<<<<<< Updated upstream
                                                    <div class="apt-card" style="border-left-color:{{ $apt->status_color }}" onclick="openModal({{ $apt->id }},'{{ addslashes($apt->patient_name) }}','{{ $apt->status }}')">
                                                        <div class="apt-name">{{ $apt->patient_name }}</div>
                                                        <div class="apt-treat">{{ $apt->treatment->name }}</div>
=======
                                                    <div class="apt-card" style="border-left-color:{{ $apt->status_color }}" onclick="event.stopPropagation(); openModal('{{ $apt->id }}')">
                                                        <div class="apt-name" style="{{ $apt->status === 'pending' ? 'color: #ef4444;' : '' }}">{{ $apt->patient_name }}</div>
                                                        <div class="apt-treat">{{ $apt->treatment_name }}</div>
>>>>>>> Stashed changes
=======
                                                    <div class="apt-card" style="border-left-color:{{ $apt->status_color }}" 
                                                        data-id="{{ $apt->id }}"
                                                        data-patient="{{ $apt->patient_name }}"
                                                        data-mr="{{ $apt->mr_number }}"
                                                        data-treatment="{{ $apt->treatment_name }}"
                                                        data-time="{{ $slot }}"
                                                        data-doctor="{{ $selectedDoctor->full_name }}"
                                                        data-status="{{ $apt->status }}"
                                                        onclick="handleAptClick(this, event)">
                                                        <div class="apt-name" style="{{ $apt->status === 'pending' ? 'color: #ef4444;' : '' }}">{{ $apt->patient_name }}</div>
                                                        <div class="apt-treat">{{ $apt->treatment_name }}</div>
>>>>>>> origin/main
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
<<<<<<< HEAD
<<<<<<< Updated upstream
=======

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
                                                <div class="apt-card m-card" style="border-left-color:{{ $apt->status_color }}" onclick="openModal('{{ $apt->id }}')">
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
                                            <div class="apt-card m-card" style="border-left-color:{{ $apt->status_color }}" onclick="openModal('{{ $apt->id }}')">
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

>>>>>>> Stashed changes
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div id="aptModal" class="modal-overlay" onclick="closeModalOutside(event)">
        <div class="modal-box modal-box-lg">
            <div class="modal-head">
                <h3 id="modalName">Informasi Kunjungan</h3>
                <button onclick="closeModal()">✕</button>
            </div>
            <div class="modal-body" id="modalBodyContent">
                <p>Memuat data kunjungan...</p>
=======

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

>>>>>>> origin/main
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

<<<<<<< HEAD
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
        let activeAppointment = null;

        function openModal(id) {
            activeId = id;
            activeAppointment = null;
            document.getElementById('modalName').textContent = 'Informasi Kunjungan';
            document.getElementById('aptModal').classList.add('open');
            document.getElementById('modalBodyContent').innerHTML = '<p>Memuat data kunjungan...</p>';

            fetch(`/admin/appointments/${id}/detail`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                },
                credentials: 'include'
            })
                .then(r => r.json())
                .then(res => {
                    if (!res.success || !res.data) {
                        throw new Error('Detail kunjungan tidak ditemukan');
                    }

                    activeAppointment = res.data;
                    renderVisitModal(res.data);
                })
                .catch(() => {
                    document.getElementById('modalBodyContent').innerHTML = '<p>Gagal memuat detail kunjungan.</p>';
                });
        }

        function closeModal() {
            document.getElementById('aptModal').classList.remove('open');
            activeId = null;
            activeAppointment = null;
        }

        function closeModalOutside(e) {
            if (e.target.id === 'aptModal') closeModal();
        }

        function renderVisitModal(data) {
            const patient = data.patient || {};
            const doctor = data.doctor || {};
            const poli = data.poli || {};
            const paymentMethod = data.payment_method || {};
            const visitType = data.visit_type || {};
            const careType = data.care_type || {};
            const guarantorType = data.guarantor_type || {};
            const status = data.status || '-';
            const statusColor = data.status_color || '#999';
            const appointmentDate = data.appointment_datetime
                ? new Date(data.appointment_datetime).toLocaleString('id-ID', { dateStyle: 'full', timeStyle: 'short' })
                : '-';
            const registrationDate = data.registration_date
                ? new Date(data.registration_date).toLocaleDateString('id-ID', { dateStyle: 'medium' })
                : '-';

            const html = `
                <div class="visit-info-grid">
                    <div class="visit-info-item"><span>Nama Pasien</span><strong>${patient.full_name || '-'}</strong></div>
                    <div class="visit-info-item"><span>No. RM</span><strong>${patient.medical_record_no || '-'}</strong></div>
                    <div class="visit-info-item"><span>Dokter</span><strong>${doctor.full_title || doctor.full_name || '-'}</strong></div>
                    <div class="visit-info-item"><span>Poli</span><strong>${poli.name || '-'}</strong></div>
                    <div class="visit-info-item"><span>Tanggal Registrasi</span><strong>${registrationDate}</strong></div>
                    <div class="visit-info-item"><span>Metode Bayar</span><strong>${paymentMethod.name || '-'}</strong></div>
                    <div class="visit-info-item"><span>Jenis Kunjungan</span><strong>${visitType.name || '-'}</strong></div>
                    <div class="visit-info-item"><span>Jenis Perawatan</span><strong>${careType.name || '-'}</strong></div>
                    <div class="visit-info-item"><span>Penjamin</span><strong>${guarantorType.name || '-'}</strong></div>
                    <div class="visit-info-item full"><span>Jadwal Kunjungan</span><strong>${appointmentDate}</strong></div>
                    <div class="visit-info-item full"><span>Kondisi Pasien</span><strong>${data.patient_condition || '-'}</strong></div>
                    <div class="visit-info-item full"><span>Keluhan</span><strong>${data.complaint || '-'}</strong></div>
                    <div class="visit-info-item full"><span>Rencana Prosedur</span><strong>${data.procedure_plan || '-'}</strong></div>
                    <div class="visit-info-item full">
                        <span>Status Saat Ini</span>
                        <strong><span class="apt-badge" style="background:${statusColor}">${status.charAt(0).toUpperCase() + status.slice(1)}</span></strong>
                    </div>
                </div>

                <div class="visit-status-wrap">
                    <label for="visitStatusSelect">Update Status</label>
                    <select id="visitStatusSelect" class="visit-status-select">
                        <option value="pending" ${status === 'pending' ? 'selected' : ''}>Pending</option>
                        <option value="confirmed" ${status === 'confirmed' ? 'selected' : ''}>Confirmed</option>
                        <option value="waiting" ${status === 'waiting' ? 'selected' : ''}>Waiting</option>
                        <option value="engaged" ${status === 'engaged' ? 'selected' : ''}>Engaged</option>
                        <option value="succeed" ${status === 'succeed' ? 'selected' : ''}>Succeed</option>
                    </select>
                </div>

                <div class="visit-action-btns">
                    <button class="visit-btn visit-btn-emr" onclick="goToEmr()">Lihat Rekam Medis</button>
                    <button class="visit-btn visit-btn-status" onclick="updateSelectedStatus()">Simpan Status</button>
                </div>
            `;

            document.getElementById('modalBodyContent').innerHTML = html;
        }

        function goToEmr() {
            if (!activeId) return;
            sessionStorage.setItem('autoSelectAppointmentId', activeId);
            window.location.href = '/admin/emr';
        }

        function updateSelectedStatus() {
            const select = document.getElementById('visitStatusSelect');
            if (!select) return;
            setStatus(select.value);
        }

        function setStatus(status) {
            if (!activeId) return;
            fetch(`/admin/appointments/${activeId}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    credentials: 'include',
                    body: JSON.stringify({
                        status
                    })
                })
                .then(r => {
                    if (!r.ok) {
                        throw new Error('Gagal update status');
                    }
                    return r.json();
                })
                .then(data => {
                    if (data.success) {
                        closeModal();
                        location.reload();
                        return;
                    }

                    throw new Error(data.message || 'Gagal update status');
                })
                .catch((err) => {
                    alert(err.message || 'Gagal update status');
                });
        }
    </script>
=======
>>>>>>> origin/main
@endsection