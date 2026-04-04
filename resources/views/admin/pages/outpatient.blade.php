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
    <style>
        /* Force hidden mobile view on desktop to prevent click-through */
        @media (min-width: 1024px) {
            .rj-mobile-schedule {
                display: none !important;
                pointer-events: none !important;
            }
        }
    </style>
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
                                        {{-- ====== MODE SEMUA DOKTER ====== --}}
                                        @foreach ($doctors as $doc)
                                           @php 
                                                $apt = $schedule[$doc->id][$slot] ?? null; 
                                                $poliId = $doc->poli_id ?? ''; 
                                                
                                                // Ambil nama hari dalam bahasa Inggris huruf kecil
                                                $dayName = strtolower(\Carbon\Carbon::parse($date)->locale('en')->dayName);
                                                
                                                // Query ke tabel doctor_schedule (Kembalikan ke logika awal yang pas)
                                                $isPracticing = \Illuminate\Support\Facades\DB::table('doctor_schedule')
                                                    ->where('doctor_id', $doc->id)
                                                    ->where('day', $dayName)
                                                    ->where('is_active', 1)
                                                    ->where('start_time', '<=', $slot . ':00')
                                                    ->where('end_time', '>', $slot . ':00') 
                                                    ->exists();
                                            @endphp
                                            
                                            @if ($apt)
                                                <td>
                                                    <div class="apt-card {{ $apt->status }}" style="border-left-color:{{ $apt->status_color }}" 
                                                        data-id="{{ $apt->id }}"
                                                        data-patient="{{ $apt->patient->full_name ?? 'Pasien' }}"
                                                        data-mr="{{ $apt->patient->medical_record_no ?? '-' }}"
                                                        data-dob="{{ $apt->patient->date_of_birth ?? '' }}"
                                                        data-gender="{{ $apt->patient->gender ?? '' }}"
                                                        data-time="{{ $apt->formatted_time }}"
                                                        data-doctor="{{ $doc->full_name ?? '-' }}"
                                                        data-creator="{{ $apt->admin->name ?? ($apt->admin_id == 1 ? 'System' : '-') }}"
                                                        data-created-at="{{ $apt->formatted_created_at }}"
                                                        data-payment="{{ $apt->paymentMethod->name ?? '-' }}"
                                                        data-duration="{{ $apt->duration_minutes ?? 10 }}"
                                                        data-status="{{ $apt->status }}"
                                                        data-action="open-detail">
                                                        <div class="apt-name" style="{{ $apt->status === 'pending' ? 'color: #ef4444;' : '' }}">{{ $apt->patient->full_name ?? 'Pasien' }}</div>
                                                        <div class="apt-treat">{{ $apt->poli->name ?? '-' }}</div>
                                                        <span class="apt-badge" style="background:{{ $apt->status_color }}">{{ ucfirst($apt->status) }}</span>
                                                    </div>
                                                </td>
                                            @elseif ($isPracticing)
                                                {{-- Sel Kosong TAPI Dokter Sedang Praktek (Hanya Teks) --}}
                                               <td 
                                                   data-action="open-registration"
                                                   data-doctor-id="{{ $doc->id }}"
                                                   data-time="{{ $slot }}"
                                                   data-poli-id="{{ $poliId }}"
                                                   data-date="{{ $date }}"
                                                   class="cursor-pointer hover:bg-[#fdfaf8] transition-colors" 
                                                   style="text-align: center; vertical-align: middle;">
                                                    <span style="color: #A67C52; font-size: 11px; font-weight: 700;">Tambah Pasien</span>
                                                </td>
                                            @else
                                                {{-- Sel Kosong DAN Diluar Jam Praktek / Terlalu Mepek Jam Selesai --}}
                                                <td style="background-color: #f9fafb; cursor: not-allowed; text-align: center; vertical-align: middle;">
                                                    <span style="color: #d1d5db; font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">Tidak Ada Praktek</span>
                                                </td>
                                            @endif
                                        @endforeach
                                    @else
                                        {{-- ====== MODE SATU DOKTER ====== --}}
                                        @foreach ($dateColumns as $dc)
                                          
                                                @php 
                                                $apt = $schedule[$dc][$slot] ?? null; 
                                                $isColToday = $dc === $today;
                                                $poliId = $selectedDoctor->poli_id ?? '';

                                                // Ambil nama hari dalam bahasa Inggris huruf kecil
                                                $dayName = strtolower(\Carbon\Carbon::parse($dc)->locale('en')->dayName);
                                                
                                                // Query ke tabel doctor_schedule
                                                $isPracticing = \Illuminate\Support\Facades\DB::table('doctor_schedule')
                                                    ->where('doctor_id', $selectedDoctorId)
                                                    ->where('day', $dayName)
                                                    ->where('is_active', 1)
                                                    ->where('start_time', '<=', $slot . ':00')
                                                    ->where('end_time', '>', $slot . ':00') // 15:45 bisa, 16:00 mati
                                                    ->exists();
                                            @endphp
                                            
                                            @if ($apt)
                                                <td class="{{ $isColToday ? 'col-today' : '' }}">
                                                    <div class="apt-card {{ $apt->status }}" style="border-left: 4px solid {{ $apt->status_color }}" 
                                                        data-id="{{ $apt->id }}"
                                                        data-patient="{{ $apt->patient->full_name ?? 'Pasien' }}"
                                                        data-mr="{{ $apt->patient->medical_record_no ?? '-' }}"
                                                        data-dob="{{ $apt->patient->date_of_birth ?? '' }}"
                                                        data-gender="{{ $apt->patient->gender ?? '' }}"
                                                        data-time="{{ $apt->formatted_time }}"
                                                        data-doctor="{{ $selectedDoctor->full_name ?? '-' }}"
                                                        data-creator="{{ $apt->admin->name ?? ($apt->admin_id == 1 ? 'System' : '-') }}"
                                                        data-created-at="{{ $apt->formatted_created_at }}"
                                                        data-payment="{{ $apt->paymentMethod->name ?? '-' }}"
                                                        data-duration="{{ $apt->duration_minutes ?? 10 }}"
                                                        data-status="{{ $apt->status }}"
                                                        data-action="open-detail">
                                                        <div class="apt-name" style="{{ $apt->status === 'pending' ? 'color: #ef4444;' : '' }}">
                                                            {{ $apt->patient->full_name ?? 'Pasien' }}
                                                        </div>
                                                        <span class="apt-badge" style="background:{{ $apt->status_color }}">{{ ucfirst($apt->status) }}</span>
                                                    </div>
                                                </td>
                                            @elseif ($isPracticing)
                                                {{-- Sel Kosong TAPI Dokter Sedang Praktek (Hanya Teks) --}}
                                                <td 
                                                    data-action="open-registration"
                                                    data-doctor-id="{{ $selectedDoctorId }}"
                                                    data-time="{{ $slot }}"
                                                    data-poli-id="{{ $poliId }}"
                                                    data-date="{{ $dc }}"
                                                    class="{{ $isColToday ? 'col-today' : '' }} cursor-pointer hover:bg-[#fdfaf8] transition-colors" 
                                                    style="text-align: center; vertical-align: middle;">
                                                    <span style="color: #A67C52; font-size: 11px; font-weight: 700;">Tambah Pasien</span>
                                                </td>
                                            @else
                                                {{-- Sel Kosong DAN Diluar Jam Praktek / Terlalu Mepek Jam Selesai --}}
                                                <td class="{{ $isColToday ? 'col-today' : '' }}" style="background-color: #f9fafb; cursor: not-allowed; text-align: center; vertical-align: middle;">
                                                    <span style="color: #d1d5db; font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">Tidak Ada Praktek</span>
                                                </td>
                                            @endif
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
                            <div class="mobile-time-group">
                                <div class="m-time-label">{{ $slot }}</div>
                                <div class="m-cards">
                                    @foreach ($doctors as $doc)
                                        @php 
                                            $apt = $schedule[$doc->id][$slot] ?? null; 
                                            $dayName = strtolower(\Carbon\Carbon::parse($date)->locale('en')->dayName);
                                            
                                            $isPracticing = \Illuminate\Support\Facades\DB::table('doctor_schedule')
                                                ->where('doctor_id', $doc->id)
                                                ->where('day', $dayName)
                                                ->where('is_active', 1)
                                                ->where('start_time', '<=', $slot . ':00')
                                                ->where('end_time', '>', $slot . ':00')
                                                ->exists();
                                        @endphp

                                        @if ($apt)
                                            <div class="apt-card m-card {{ $apt->status }}" style="border-left-color:{{ $apt->status_color }}" 
                                                data-id="{{ $apt->id }}"
                                                data-patient="{{ $apt->patient->full_name ?? 'Pasien' }}"
                                                data-mr="{{ $apt->patient->medical_record_no ?? '-' }}"
                                                data-dob="{{ $apt->patient->date_of_birth ?? '' }}"
                                                data-gender="{{ $apt->patient->gender ?? '' }}"
                                                data-time="{{ $apt->formatted_time }}"
                                                data-doctor="{{ $doc->full_name ?? '-' }}"
                                                data-creator="{{ $apt->admin->name ?? ($apt->admin_id == 1 ? 'System' : '-') }}"
                                                data-created-at="{{ $apt->formatted_created_at }}"
                                                data-payment="{{ $apt->paymentMethod->name ?? '-' }}"
                                                data-duration="{{ $apt->duration_minutes ?? 10 }}"
                                                data-status="{{ $apt->status }}"
                                                data-action="open-detail">
                                                <div class="m-card-header">
                                                    <div class="apt-name">{{ $apt->patient->full_name ?? 'Pasien' }}</div>
                                                    <span class="apt-badge" style="background:{{ $apt->status_color }}">{{ ucfirst($apt->status) }}</span>
                                                </div>
                                                <div class="apt-treat">{{ $apt->poli->name ?? '-' }}</div>
                                                <div class="m-doc-name">
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg> 
                                                    {{ $doc->full_name }}
                                                </div>
                                            </div>
                                        @elseif ($isPracticing)
                                            <div class="m-empty-slot" 
                                                data-action="open-registration"
                                                data-doctor-id="{{ $doc->id }}"
                                                data-time="{{ $slot }}"
                                                data-poli-id="{{ $doc->poli_id ?? '' }}"
                                                data-date="{{ $date }}"
                                                style="cursor:pointer; border: 1px dashed #A67C52;">
                                                <div class="m-empty-label text-[#A67C52]"><i class="fa fa-plus"></i> Tambah Pasien ({{ $doc->full_name }})</div>
                                            </div>
                                        @else
                                            <div class="m-empty-slot" style="background:#f9fafb; cursor:not-allowed; border: 1px dashed #e5e7eb;">
                                                <div class="m-empty-label" style="color:#d1d5db;">Tidak Ada Praktek ({{ $doc->full_name }})</div>
                                            </div>
                                        @endif
                                    @endforeach
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
                                            <div class="apt-card m-card {{ $apt->status }}" style="border-left-color:{{ $apt->status_color }}" 
                                                data-id="{{ $apt->id }}"
                                                data-patient="{{ $apt->patient->full_name ?? 'Pasien' }}"
                                                data-mr="{{ $apt->patient->medical_record_no ?? '-' }}"
                                                data-dob="{{ $apt->patient->date_of_birth ?? '' }}"
                                                data-gender="{{ $apt->patient->gender ?? '' }}"
                                                data-time="{{ $apt->formatted_time }}"
                                                data-doctor="{{ $apt->doctor?->full_name ?? $selectedDoctor->full_name }}"
                                                data-creator="{{ $apt->admin->name ?? ($apt->admin_id == 1 ? 'System' : '-') }}"
                                                data-created-at="{{ $apt->formatted_created_at }}"
                                                data-payment="{{ $apt->paymentMethod->name ?? '-' }}"
                                                data-duration="{{ $apt->duration_minutes ?? 10 }}"
                                                data-status="{{ $apt->status }}"
                                                data-action="open-detail">
                                                <div class="m-card-header">
                                                    <div class="apt-name">{{ \Carbon\Carbon::parse($apt->appointment_datetime)->format('H:i') }} | {{ $apt->patient->full_name ?? 'Pasien' }}</div>
                                                    <span class="apt-badge" style="background:{{ $apt->status_color }}">{{ ucfirst($apt->status) }}</span>
                                                </div>
                                                <div class="apt-treat">{{ $apt->poli->name ?? '-' }}</div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="m-empty-slot" style="background:#f9fafb; border: 1px dashed #e5e7eb; cursor:not-allowed;">
                                            <div class="m-empty-label" style="color:#d1d5db;">Tidak ada jadwal di hari ini</div>
                                        </div>
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
    document.addEventListener('DOMContentLoaded', function() {
        const scheduleContainer = document.querySelector('.rj-wrap');
        if (!scheduleContainer) return;

        scheduleContainer.addEventListener('click', function(e) {
            const target = e.target.closest('[data-action]');
            if (!target) return;

            // Debug log to see what was clicked
            console.log('Target clicked:', target);
            console.log('Action:', target.getAttribute('data-action'));

            // Ignore if the target is actually hidden (prevents invisible mobile card clicks)
            if (window.getComputedStyle(target).display === 'none' || target.offsetParent === null) {
                console.log('Canceled: Target is hidden');
                return;
            }

            e.preventDefault();
            e.stopPropagation();

            const action = target.getAttribute('data-action');

            if (action === 'open-detail') {
                const data = {
                    id: target.getAttribute('data-id'),
                    patientName: target.getAttribute('data-patient'),
                    mrNumber: target.getAttribute('data-mr'),
                    dob: target.getAttribute('data-dob'),
                    gender: target.getAttribute('data-gender'),
                    time: target.getAttribute('data-time'),
                    doctor: target.getAttribute('data-doctor'),
                    creator: target.getAttribute('data-creator'),
                    createdAt: target.getAttribute('data-created-at'),
                    payment: target.getAttribute('data-payment'),
                    duration: target.getAttribute('data-duration'),
                    status: target.getAttribute('data-status')
                };

                if (typeof openApptDetailModal === 'function') {
                    openApptDetailModal(data);
                }
            } 
            else if (action === 'open-registration') {
                const doctorId = target.getAttribute('data-doctor-id');
                const time = target.getAttribute('data-time');
                const poliId = target.getAttribute('data-poli-id');
                const date = target.getAttribute('data-date');

                openRegModal('modalPendaftaranBaru', doctorId, time, poliId, date);
            }
        });
    });

    /** --- GLOBAL MODAL CONTROLLER (RESTORED) --- **/
    function openRegModal(modalId, doctorId = null, time = null, poliId = null, date = null) {
        console.log('Opening modal:', modalId);
        const modal = document.getElementById(modalId);
        if (!modal) return;

        modal.classList.add('open');
        document.body.style.overflow = 'hidden'; 

        if (modalId === 'modalPendaftaranBaru') {
            if (doctorId) {
                const docSelect = document.getElementById('pb_doctor_id');
                if (docSelect) {
                    docSelect.value = doctorId;
                    docSelect.dispatchEvent(new Event('change'));
                }
            }
            if (time) {
                const timeInput = document.getElementById('pb_appointment_time');
                if (timeInput) timeInput.value = time;
            }
            if (poliId) {
                const poliSelect = document.getElementById('pb_poli_id');
                if (poliSelect) {
                    poliSelect.value = poliId;
                    poliSelect.dispatchEvent(new Event('change'));
                }
            }
            if (date) {
                const dateInput = document.getElementById('pb_appointment_date');
                if (dateInput) dateInput.value = date;
            }
        }
    }

    function closeRegModal(modalId) {
        console.log('Closing modal:', modalId);
        const modal = document.getElementById(modalId);
        if (modal) modal.classList.remove('open');
        document.body.style.overflow = '';
    }

    // Close registration modals when clicking overlay
    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('reg-modal-overlay')) {
            closeRegModal(e.target.id);
        }
    });
</script>

@include('admin.components.pasien-baru')
@include('admin.components.appointment-detail')
@include('admin.components.pendaftaran-baru')
    
@endsection


