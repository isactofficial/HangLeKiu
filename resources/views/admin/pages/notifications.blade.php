@extends('admin.layout.admin')

@section('title', 'Notifikasi')

@section('navbar')
    @include('admin.components.navbar')
@endsection

@section('content')
<style>
.notif-page { max-width: 860px; margin: 0 auto; padding: 28px 32px; }
.notif-page-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 24px; }
.notif-page-title { font-size: 22px; font-weight: 600; color: #3b1f0a; margin: 0 0 4px; }
.notif-page-sub { font-size: 13px; color: #9c6f4a; }
.btn-mark-all { display: flex; align-items: center; gap: 6px; font-size: 12px; color: #7a3b0a; background: none; border: 1px solid #d6a87a; border-radius: 20px; padding: 6px 14px; cursor: pointer; transition: background 0.15s; white-space: nowrap; }
.btn-mark-all:hover { background: #fdf0e4; }
.notif-tabs { display: flex; gap: 4px; border-bottom: 1.5px solid #e8d5c0; margin-bottom: 0; }
.notif-tab { display: flex; align-items: center; gap: 6px; padding: 10px 16px; font-size: 13px; color: #9c6f4a; background: none; border: none; border-bottom: 2px solid transparent; margin-bottom: -1.5px; cursor: pointer; transition: color 0.15s; }
.notif-tab.active { color: #5C2D0A; border-bottom-color: #5C2D0A; font-weight: 500; }
.notif-tab:hover { color: #5C2D0A; }
.tab-badge { background: #8B3A0A; color: #fff; font-size: 10px; font-weight: 600; padding: 1px 6px; border-radius: 20px; line-height: 1.6; }
.notif-tab-content { display: none; padding-top: 8px; }
.notif-tab-content.active { display: block; }
.notif-section-label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.6px; color: #b08060; padding: 14px 0 8px; }
.notif-card { display: flex; align-items: flex-start; gap: 12px; padding: 16px; background: #fff; border: 0.5px solid #e8d5c0; border-radius: 12px; margin-bottom: 10px; position: relative; transition: box-shadow 0.15s, transform 0.15s; cursor: pointer; }
.notif-card:hover { box-shadow: 0 2px 8px rgba(90,40,10,0.07); transform: translateY(-1px); }
.notif-card.unread { background: #fdf6ef; border-color: #d6b08a; }
.notif-dot { position: absolute; top: 20px; left: -5px; width: 8px; height: 8px; background: #8B3A0A; border-radius: 50%; border: 2px solid #fff; }
.notif-avatar { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 600; flex-shrink: 0; }
.av-janji  { background: #f5dfc3; color: #7a3b0a; }
.av-sistem { background: #e8d5c0; color: #5C2D0A; }
.notif-body { flex: 1; min-width: 0; }
.notif-top { display: flex; align-items: center; gap: 8px; margin-bottom: 5px; }
.notif-badge { font-size: 10px; font-weight: 600; padding: 2px 8px; border-radius: 20px; }
.badge-janji  { background: #f5dfc3; color: #7a3b0a; }
.badge-sistem { background: #e8d5c0; color: #5C2D0A; }
.notif-time { font-size: 11px; color: #b08060; margin-left: auto; }
.notif-title { font-size: 13px; color: #3b1f0a; margin: 0 0 3px; line-height: 1.5; }
.notif-title strong { font-weight: 600; }
.notif-desc { font-size: 12px; color: #9c6f4a; margin: 0 0 12px; }
.notif-actions { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
.btn-confirm, .btn-wa, .btn-calendar, .btn-reschedule { display: inline-flex; align-items: center; gap: 5px; padding: 6px 14px; font-size: 12px; font-weight: 500; border-radius: 20px; border: 1px solid; cursor: pointer; transition: all 0.15s; }
.btn-confirm { background: #5C2D0A; color: #fff; border-color: #5C2D0A; }
.btn-confirm:hover { background: #3b1f0a; }
.btn-wa { background: #fff; color: #128c40; border-color: #a3d8b8; }
.btn-wa:hover { background: #f0faf4; border-color: #128c40; }
.btn-calendar { background: #5C2D0A; color: #fff; border-color: #5C2D0A; }
.btn-calendar:hover { background: #3b1f0a; }
.btn-reschedule { background: #fff; color: #9c3a1a; border-color: #d6a87a; }
.btn-reschedule:hover { background: #fff0e8; border-color: #9c3a1a; }
.status-confirmed { font-size: 12px; font-weight: 600; color: #2d7a4a; background: #e6f5ed; padding: 4px 12px; border-radius: 20px; }
.status-rescheduled { font-size: 12px; font-weight: 600; color: #9c3a1a; background: #fdeee8; padding: 4px 12px; border-radius: 20px; }
.coming-soon-card { display: flex; align-items: flex-start; gap: 14px; padding: 18px 20px; background: #fff8f2; border: 1.5px dashed #d6a87a; border-radius: 12px; margin-bottom: 10px; }
.cs-icon-wrap { width: 44px; height: 44px; background: #f5dfc3; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #7a3b0a; flex-shrink: 0; }
.cs-title { font-size: 13px; font-weight: 600; color: #3b1f0a; margin: 0 0 4px; }
.cs-desc  { font-size: 12px; color: #9c6f4a; line-height: 1.6; margin: 0; }
.cs-pill  { flex-shrink: 0; font-size: 10px; font-weight: 600; background: #8B3A0A; color: #fff; padding: 3px 10px; border-radius: 20px; letter-spacing: 0.5px; align-self: flex-start; margin-top: 2px; }
.notif-empty { display: flex; flex-direction: column; align-items: center; gap: 12px; padding: 60px 20px; color: #b08060; font-size: 13px; }

/* SLIDE PANEL */
.slide-panel-overlay { position: fixed; inset: 0; background: rgba(30,10,0,0.35); z-index: 3000; opacity: 0; pointer-events: none; transition: opacity 0.25s; }
.slide-panel-overlay.open { opacity: 1; pointer-events: all; }
.slide-panel { position: fixed; top: 0; right: 0; width: 420px; max-width: 100vw; height: 100vh; background: #fff; box-shadow: -4px 0 32px rgba(60,20,0,0.13); z-index: 3001; display: flex; flex-direction: column; transform: translateX(100%); transition: transform 0.3s cubic-bezier(0.4,0,0.2,1); overflow: hidden; }
.slide-panel.open { transform: translateX(0); }
.sp-header { display: flex; align-items: center; justify-content: space-between; padding: 20px 24px 16px; border-bottom: 1px solid #f0e0cc; background: #fdf6ef; flex-shrink: 0; }
.sp-header-left { display: flex; align-items: center; gap: 12px; }
.sp-avatar { width: 44px; height: 44px; border-radius: 50%; background: #f5dfc3; color: #7a3b0a; display: flex; align-items: center; justify-content: center; font-size: 15px; font-weight: 700; flex-shrink: 0; }
.sp-name { font-size: 15px; font-weight: 600; color: #3b1f0a; margin: 0 0 2px; }
.sp-mr   { font-size: 11px; color: #9c6f4a; }
.sp-close { width: 32px; height: 32px; border: none; background: #f0e0cc; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #7a3b0a; transition: background 0.15s; flex-shrink: 0; }
.sp-close:hover { background: #e0c8a8; }
.sp-body { flex: 1; overflow-y: auto; padding: 20px 24px; }
.sp-section { margin-bottom: 20px; }
.sp-section-title { font-size: 10px; text-transform: uppercase; letter-spacing: 0.8px; color: #b08060; margin: 0 0 10px; font-weight: 600; }
.sp-row { display: flex; justify-content: space-between; align-items: flex-start; padding: 8px 0; border-bottom: 1px solid #f5ede3; gap: 12px; }
.sp-row:last-child { border-bottom: none; }
.sp-label { font-size: 12px; color: #9c6f4a; flex-shrink: 0; }
.sp-val   { font-size: 12px; color: #3b1f0a; font-weight: 500; text-align: right; }
.sp-status-badge { display: inline-block; font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 20px; }
.sp-status-pending   { background: #f5dfc3; color: #7a3b0a; }
.sp-status-confirmed { background: #e6f5ed; color: #2d7a4a; }
.sp-status-sistem    { background: #e8d5c0; color: #5C2D0A; }
.sp-complaint-box { background: #fdf6ef; border: 1px solid #e8d5c0; border-radius: 8px; padding: 10px 12px; font-size: 12px; color: #5c3a1a; line-height: 1.6; margin-top: 4px; }
.sp-footer { padding: 16px 24px; border-top: 1px solid #f0e0cc; background: #fdf6ef; display: flex; flex-direction: column; gap: 10px; flex-shrink: 0; }
.sp-footer-note { font-size: 11px; color: #b08060; text-align: center; margin-top: 4px; }
.btn-sp-confirm { width: 100%; padding: 11px; background: #5C2D0A; color: #fff; border: none; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: background 0.15s; }
.btn-sp-confirm:hover { background: #3b1f0a; }
.btn-sp-confirm:disabled { background: #c4a882; cursor: not-allowed; }
.btn-sp-wa { width: 100%; padding: 10px; background: #fff; color: #128c40; border: 1.5px solid #a3d8b8; border-radius: 10px; font-size: 13px; font-weight: 500; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.15s; }
.btn-sp-wa:hover { background: #f0faf4; border-color: #128c40; }
.btn-sp-calendar { width: 100%; padding: 10px; background: #fff; color: #1a73e8; border: 1.5px solid #aac4f0; border-radius: 10px; font-size: 13px; font-weight: 500; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.15s; }
.btn-sp-calendar:hover { background: #f0f5ff; border-color: #1a73e8; }
.btn-sp-reschedule { width: 100%; padding: 10px; background: #fff; color: #9c3a1a; border: 1.5px solid #d6a87a; border-radius: 10px; font-size: 13px; font-weight: 500; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.15s; }
.btn-sp-reschedule:hover { background: #fff0e8; border-color: #9c3a1a; }
.sp-confirmed-state { text-align: center; padding: 12px; background: #e6f5ed; border-radius: 10px; color: #2d7a4a; font-size: 13px; font-weight: 600; }
.sp-spinner { width: 16px; height: 16px; border: 2px solid rgba(255,255,255,0.4); border-top-color: #fff; border-radius: 50%; animation: spin 0.6s linear infinite; display: none; }
@keyframes spin { to { transform: rotate(360deg); } }
.notif-toast { position: fixed; bottom: 28px; right: 28px; background: #3b1f0a; color: #fff; font-size: 13px; padding: 12px 20px; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.18); z-index: 4000; transform: translateY(20px); opacity: 0; transition: all 0.25s; display: flex; align-items: center; gap: 8px; }
.notif-toast.show { transform: translateY(0); opacity: 1; }
.notif-toast.success { background: #1a6e3a; }
.notif-toast.error   { background: #9c1a1a; }

/* RESCHEDULE MODAL */
.rs-modal-overlay { position: fixed; inset: 0; z-index: 3100; display: none; align-items: center; justify-content: center; background: rgba(30,10,0,0.45); }
.rs-modal-overlay.open { display: flex; }
.rs-modal-card { background: #fff; border-radius: 16px; width: 400px; max-width: 95vw; box-shadow: 0 8px 40px rgba(60,20,0,0.18); overflow: hidden; }
.rs-modal-head { padding: 20px 24px 16px; background: #fdf6ef; border-bottom: 1px solid #f0e0cc; display: flex; justify-content: space-between; align-items: center; }
.rs-modal-title { font-size: 15px; font-weight: 600; color: #3b1f0a; margin: 0 0 2px; }
.rs-modal-sub   { font-size: 11px; color: #9c6f4a; margin: 0; }
.rs-modal-close { width: 32px; height: 32px; border: none; background: #f0e0cc; border-radius: 50%; cursor: pointer; color: #7a3b0a; display: flex; align-items: center; justify-content: center; transition: background 0.15s; }
.rs-modal-close:hover { background: #e0c8a8; }
.rs-modal-body { padding: 20px 24px; }
.rs-field-label { font-size: 11px; font-weight: 700; color: #b08060; text-transform: uppercase; letter-spacing: 0.6px; display: block; margin-bottom: 6px; }
.rs-input { width: 100%; padding: 10px 12px; border: 1.5px solid #e8d5c0; border-radius: 8px; font-size: 13px; color: #3b1f0a; outline: none; font-family: inherit; box-sizing: border-box; transition: border-color 0.15s; }
.rs-input:focus { border-color: #C58F59; }
.rs-textarea { width: 100%; padding: 10px 12px; border: 1.5px solid #e8d5c0; border-radius: 8px; font-size: 13px; color: #3b1f0a; outline: none; font-family: inherit; resize: none; box-sizing: border-box; transition: border-color 0.15s; }
.rs-textarea:focus { border-color: #C58F59; }
.rs-btn-row { display: flex; gap: 8px; margin-top: 20px; }
.rs-btn-cancel { flex: 1; padding: 10px; background: #fff; color: #9c3a1a; border: 1.5px solid #d6a87a; border-radius: 10px; font-size: 13px; font-weight: 500; cursor: pointer; font-family: inherit; transition: all 0.15s; }
.rs-btn-cancel:hover { background: #fff0e8; border-color: #9c3a1a; }
.rs-btn-save { flex: 2; padding: 10px; background: #5C2D0A; color: #fff; border: none; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: inherit; transition: background 0.15s; }
.rs-btn-save:hover { background: #3b1f0a; }
.rs-btn-save:disabled { background: #c4a882; cursor: not-allowed; }
</style>

<div class="notif-page">
    <div class="notif-page-header">
        <div>
            <h1 class="notif-page-title">Notifikasi</h1>
            <p class="notif-page-sub">Pantau aktivitas & janji temu masuk</p>
        </div>
        <button class="btn-mark-all" id="markAllRead">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
            Tandai semua dibaca
        </button>
    </div>

    <div class="notif-tabs">
        <button class="notif-tab active" data-tab="semua">
            Semua
            @php $totalPending = ($todayNotifs ?? collect())->count() + ($upcomingNotifs ?? collect())->count() @endphp
            @if($totalPending > 0)<span class="tab-badge" id="badge-semua">{{ $totalPending }}</span>@endif
        </button>
        <button class="notif-tab" data-tab="janji">
            Janji Temu
            @if(($todayNotifs ?? collect())->count() + ($upcomingNotifs ?? collect())->count() > 0)
                <span class="tab-badge" id="badge-janji">{{ ($todayNotifs ?? collect())->count() + ($upcomingNotifs ?? collect())->count() }}</span>
            @endif
        </button>
        <button class="notif-tab" data-tab="sistem">
            Sistem
            @if(($sistemNotifs ?? collect())->count() > 0)<span class="tab-badge">{{ ($sistemNotifs ?? collect())->count() }}</span>@endif
        </button>
    </div>

    {{-- TAB: SEMUA --}}
    <div class="notif-tab-content active" id="tab-semua">
        @php $allUserNotifs = ($todayNotifs ?? collect())->concat($upcomingNotifs ?? collect()); @endphp

        @if($allUserNotifs->count() > 0)
            <div class="notif-section-label">Menunggu konfirmasi</div>
            @foreach($allUserNotifs as $apt)
            @php $initials = collect(explode(' ', $apt->patient->full_name ?? 'P'))->take(2)->map(fn($w) => strtoupper(substr($w,0,1)))->implode(''); @endphp
            <div class="notif-card unread"
                 data-id="{{ $apt->id }}" data-type="janji"
                 data-patient="{{ $apt->patient->full_name ?? '-' }}"
                 data-mr="{{ $apt->patient->medical_record_no ?? '-' }}"
                 data-dob="{{ $apt->patient?->date_of_birth ? \Carbon\Carbon::parse($apt->patient->date_of_birth)->format('d M Y') : '-' }}"
                 data-gender="{{ $apt->patient?->gender === 'Male' ? 'Laki-laki' : 'Perempuan' }}"
                 data-phone="{{ $apt->patient?->phone_number ?? '-' }}"
                 data-doctor="{{ $apt->doctor->full_name ?? '-' }}"
                 data-poli="{{ $apt->poli->name ?? '-' }}"
                 data-datetime="{{ $apt->appointment_datetime }}"
                 data-duration="{{ $apt->duration_minutes ?? 30 }}"
                 data-complaint="{{ $apt->complaint ?? '-' }}"
                 data-procedure="{{ $apt->procedure_plan ?? '-' }}"
                 data-condition="{{ $apt->patient_condition ?? '-' }}"
                 data-payment="{{ $apt->paymentMethod->name ?? '-' }}"
                 data-status="{{ $apt->status }}"
                 data-initials="{{ $initials }}">
                <div class="notif-dot"></div>
                <div class="notif-avatar av-janji">{{ $initials }}</div>
                <div class="notif-body">
                    <div class="notif-top">
                        <span class="notif-badge badge-janji">Janji Temu</span>
                        <span class="notif-time">{{ $apt->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="notif-title">Permintaan janji temu baru — <strong>{{ $apt->patient->full_name ?? '-' }}</strong></p>
                    <p class="notif-desc">
                        {{ \Carbon\Carbon::parse($apt->appointment_datetime)->locale('id')->isoFormat('dddd, D MMM YYYY') }}
                        · {{ \Carbon\Carbon::parse($apt->appointment_datetime)->format('H:i') }}
                        · {{ $apt->poli->name ?? ($apt->procedure_plan ?? '-') }}
                    </p>
                    <div class="notif-actions" id="actions-{{ $apt->id }}">
                        <button class="btn-confirm" onclick="event.stopPropagation(); openPanel('{{ $apt->id }}', this.closest('.notif-card'))">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>Konfirmasi
                        </button>
                        <button class="btn-reschedule" onclick="event.stopPropagation(); openRescheduleModal('{{ $apt->id }}', this.closest('.notif-card').dataset)">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M23 4v6h-6"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>Reschedule
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        @endif

        @if(($sistemNotifs ?? collect())->count() > 0)
            <div class="notif-section-label" style="margin-top:20px;">Aktivitas sistem</div>
            @foreach($sistemNotifs as $apt)
            @php $initials = collect(explode(' ', $apt->patient->full_name ?? 'P'))->take(2)->map(fn($w) => strtoupper(substr($w,0,1)))->implode(''); @endphp
            <div class="notif-card"
                 data-id="{{ $apt->id }}" data-type="sistem"
                 data-patient="{{ $apt->patient->full_name ?? '-' }}"
                 data-mr="{{ $apt->patient->medical_record_no ?? '-' }}"
                 data-dob="{{ $apt->patient?->date_of_birth ? \Carbon\Carbon::parse($apt->patient->date_of_birth)->format('d M Y') : '-' }}"
                 data-gender="{{ $apt->patient?->gender === 'Male' ? 'Laki-laki' : 'Perempuan' }}"
                 data-phone="{{ $apt->patient?->phone_number ?? '-' }}"
                 data-doctor="{{ $apt->doctor->full_name ?? '-' }}"
                 data-poli="{{ $apt->poli->name ?? '-' }}"
                 data-datetime="{{ $apt->appointment_datetime }}"
                 data-duration="{{ $apt->duration_minutes ?? 30 }}"
                 data-complaint="{{ $apt->complaint ?? '-' }}"
                 data-procedure="{{ $apt->procedure_plan ?? '-' }}"
                 data-condition="{{ $apt->patient_condition ?? '-' }}"
                 data-payment="{{ $apt->paymentMethod->name ?? '-' }}"
                 data-status="{{ $apt->status }}"
                 data-creator="{{ $apt->admin->name ?? 'Admin' }}"
                 data-initials="{{ $initials }}">
                <div class="notif-avatar av-sistem">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                </div>
                <div class="notif-body">
                    <div class="notif-top">
                        <span class="notif-badge badge-sistem">Sistem</span>
                        <span class="notif-time">{{ $apt->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="notif-title">Admin mendaftarkan janji — <strong>{{ $apt->patient->full_name ?? '-' }}</strong></p>
                    <p class="notif-desc">
                        {{ \Carbon\Carbon::parse($apt->appointment_datetime)->locale('id')->isoFormat('dddd, D MMM YYYY') }}
                        · {{ \Carbon\Carbon::parse($apt->appointment_datetime)->format('H:i') }}
                        · {{ $apt->doctor->full_name ?? '-' }}
                    </p>
                    <div class="notif-actions">
                        <button class="btn-calendar" onclick="event.stopPropagation(); handleGoogleCalendar(this.closest('.notif-card'))">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            Tambah ke Google Calendar
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        @endif

        @if($allUserNotifs->count() === 0 && ($sistemNotifs ?? collect())->count() === 0)
        <div class="notif-empty">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            <p>Tidak ada notifikasi baru</p>
        </div>
        @endif

        <div class="notif-section-label" style="margin-top:28px;">Segera hadir</div>
        <div class="coming-soon-card">
            <div class="cs-icon-wrap"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg></div>
            <div>
                <p class="cs-title">Notifikasi Real-time & Push Notification</p>
                <p class="cs-desc">Admin akan otomatis menerima alert setiap ada janji baru, perubahan jadwal, atau pembatalan tanpa perlu refresh halaman.</p>
            </div>
            <span class="cs-pill">Coming Soon</span>
        </div>
    </div>

    {{-- TAB: JANJI TEMU --}}
    <div class="notif-tab-content" id="tab-janji">
        @if(($todayNotifs ?? collect())->count() > 0)
            <div class="notif-section-label">Terbaru hari ini</div>
            @foreach($todayNotifs as $apt)
            @php $initials = collect(explode(' ', $apt->patient->full_name ?? 'P'))->take(2)->map(fn($w) => strtoupper(substr($w,0,1)))->implode(''); @endphp
            <div class="notif-card unread"
                 data-id="{{ $apt->id }}" data-type="janji"
                 data-patient="{{ $apt->patient->full_name ?? '-' }}"
                 data-mr="{{ $apt->patient->medical_record_no ?? '-' }}"
                 data-dob="{{ $apt->patient?->date_of_birth ? \Carbon\Carbon::parse($apt->patient->date_of_birth)->format('d M Y') : '-' }}"
                 data-gender="{{ $apt->patient?->gender === 'Male' ? 'Laki-laki' : 'Perempuan' }}"
                 data-phone="{{ $apt->patient?->phone_number ?? '-' }}"
                 data-doctor="{{ $apt->doctor->full_name ?? '-' }}"
                 data-poli="{{ $apt->poli->name ?? '-' }}"
                 data-datetime="{{ $apt->appointment_datetime }}"
                 data-duration="{{ $apt->duration_minutes ?? 30 }}"
                 data-complaint="{{ $apt->complaint ?? '-' }}"
                 data-procedure="{{ $apt->procedure_plan ?? '-' }}"
                 data-condition="{{ $apt->patient_condition ?? '-' }}"
                 data-payment="{{ $apt->paymentMethod->name ?? '-' }}"
                 data-status="{{ $apt->status }}"
                 data-initials="{{ $initials }}">
                <div class="notif-dot"></div>
                <div class="notif-avatar av-janji">{{ $initials }}</div>
                <div class="notif-body">
                    <div class="notif-top">
                        <span class="notif-badge badge-janji">Janji Temu</span>
                        <span class="notif-time">{{ $apt->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="notif-title">Permintaan janji temu baru — <strong>{{ $apt->patient->full_name ?? '-' }}</strong></p>
                    <p class="notif-desc">
                        {{ \Carbon\Carbon::parse($apt->appointment_datetime)->locale('id')->isoFormat('dddd, D MMM YYYY') }}
                        · {{ \Carbon\Carbon::parse($apt->appointment_datetime)->format('H:i') }}
                        · {{ $apt->poli->name ?? '-' }}
                    </p>
                    <div class="notif-actions" id="actions-janji-{{ $apt->id }}">
                        <button class="btn-confirm" onclick="event.stopPropagation(); openPanel('{{ $apt->id }}', this.closest('.notif-card'))">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>Konfirmasi
                        </button>
                        <button class="btn-reschedule" onclick="event.stopPropagation(); openRescheduleModal('{{ $apt->id }}', this.closest('.notif-card').dataset)">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M23 4v6h-6"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>Reschedule
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        @endif

        @if(($upcomingNotifs ?? collect())->count() > 0)
            <div class="notif-section-label" style="margin-top:20px;">Sebelumnya</div>
            @foreach($upcomingNotifs as $apt)
            @php $initials = collect(explode(' ', $apt->patient->full_name ?? 'P'))->take(2)->map(fn($w) => strtoupper(substr($w,0,1)))->implode(''); @endphp
            <div class="notif-card unread"
                 data-id="{{ $apt->id }}" data-type="janji"
                 data-patient="{{ $apt->patient->full_name ?? '-' }}"
                 data-mr="{{ $apt->patient->medical_record_no ?? '-' }}"
                 data-dob="{{ $apt->patient?->date_of_birth ? \Carbon\Carbon::parse($apt->patient->date_of_birth)->format('d M Y') : '-' }}"
                 data-gender="{{ $apt->patient?->gender === 'Male' ? 'Laki-laki' : 'Perempuan' }}"
                 data-phone="{{ $apt->patient?->phone_number ?? '-' }}"
                 data-doctor="{{ $apt->doctor->full_name ?? '-' }}"
                 data-poli="{{ $apt->poli->name ?? '-' }}"
                 data-datetime="{{ $apt->appointment_datetime }}"
                 data-duration="{{ $apt->duration_minutes ?? 30 }}"
                 data-complaint="{{ $apt->complaint ?? '-' }}"
                 data-procedure="{{ $apt->procedure_plan ?? '-' }}"
                 data-condition="{{ $apt->patient_condition ?? '-' }}"
                 data-payment="{{ $apt->paymentMethod->name ?? '-' }}"
                 data-status="{{ $apt->status }}"
                 data-initials="{{ $initials }}">
                <div class="notif-dot"></div>
                <div class="notif-avatar av-janji">{{ $initials }}</div>
                <div class="notif-body">
                    <div class="notif-top">
                        <span class="notif-badge badge-janji">Janji Temu</span>
                        <span class="notif-time">{{ $apt->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="notif-title">Permintaan janji temu baru — <strong>{{ $apt->patient->full_name ?? '-' }}</strong></p>
                    <p class="notif-desc">
                        {{ \Carbon\Carbon::parse($apt->appointment_datetime)->locale('id')->isoFormat('dddd, D MMM YYYY') }}
                        · {{ \Carbon\Carbon::parse($apt->appointment_datetime)->format('H:i') }}
                        · {{ $apt->poli->name ?? '-' }}
                    </p>
                    <div class="notif-actions">
                        <button class="btn-confirm" onclick="event.stopPropagation(); openPanel('{{ $apt->id }}', this.closest('.notif-card'))">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>Konfirmasi
                        </button>
                        <button class="btn-reschedule" onclick="event.stopPropagation(); openRescheduleModal('{{ $apt->id }}', this.closest('.notif-card').dataset)">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M23 4v6h-6"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>Reschedule
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        @endif

        @if(($todayNotifs ?? collect())->count() === 0 && ($upcomingNotifs ?? collect())->count() === 0)
        <div class="notif-empty">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            <p>Tidak ada janji temu yang menunggu konfirmasi</p>
        </div>
        @endif
    </div>

    {{-- TAB: SISTEM --}}
    <div class="notif-tab-content" id="tab-sistem">
        @if(($sistemNotifs ?? collect())->count() > 0)
            <div class="notif-section-label">Pendaftaran oleh admin</div>
            @foreach($sistemNotifs as $apt)
            @php $initials = collect(explode(' ', $apt->patient->full_name ?? 'P'))->take(2)->map(fn($w) => strtoupper(substr($w,0,1)))->implode(''); @endphp
            <div class="notif-card"
                 data-id="{{ $apt->id }}" data-type="sistem"
                 data-patient="{{ $apt->patient->full_name ?? '-' }}"
                 data-mr="{{ $apt->patient->medical_record_no ?? '-' }}"
                 data-dob="{{ $apt->patient?->date_of_birth ? \Carbon\Carbon::parse($apt->patient->date_of_birth)->format('d M Y') : '-' }}"
                 data-gender="{{ $apt->patient?->gender === 'Male' ? 'Laki-laki' : 'Perempuan' }}"
                 data-phone="{{ $apt->patient?->phone_number ?? '-' }}"
                 data-doctor="{{ $apt->doctor->full_name ?? '-' }}"
                 data-poli="{{ $apt->poli->name ?? '-' }}"
                 data-datetime="{{ $apt->appointment_datetime }}"
                 data-duration="{{ $apt->duration_minutes ?? 30 }}"
                 data-complaint="{{ $apt->complaint ?? '-' }}"
                 data-procedure="{{ $apt->procedure_plan ?? '-' }}"
                 data-condition="{{ $apt->patient_condition ?? '-' }}"
                 data-payment="{{ $apt->paymentMethod->name ?? '-' }}"
                 data-status="{{ $apt->status }}"
                 data-creator="{{ $apt->admin->name ?? 'Admin' }}"
                 data-initials="{{ $initials }}">
                <div class="notif-avatar av-sistem">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                </div>
                <div class="notif-body">
                    <div class="notif-top">
                        <span class="notif-badge badge-sistem">Sistem</span>
                        <span class="notif-time">{{ $apt->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="notif-title"><strong>{{ $apt->admin->name ?? 'Admin' }}</strong> mendaftarkan janji — <strong>{{ $apt->patient->full_name ?? '-' }}</strong></p>
                    <p class="notif-desc">
                        {{ \Carbon\Carbon::parse($apt->appointment_datetime)->locale('id')->isoFormat('dddd, D MMM YYYY') }}
                        · {{ \Carbon\Carbon::parse($apt->appointment_datetime)->format('H:i') }}
                        · {{ $apt->doctor->full_name ?? '-' }}
                    </p>
                    <div class="notif-actions">
                        <button class="btn-calendar" onclick="event.stopPropagation(); handleGoogleCalendar(this.closest('.notif-card'))">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            Tambah ke Google Calendar
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        @else
        <div class="notif-empty">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
            <p>Belum ada notifikasi sistem</p>
        </div>
        @endif
    </div>
</div>

{{-- SLIDE PANEL --}}
<div class="slide-panel-overlay" id="slidePanelOverlay" onclick="closePanel()"></div>
<div class="slide-panel" id="slidePanel">
    <div class="sp-header">
        <div class="sp-header-left">
            <div class="sp-avatar" id="sp-avatar">--</div>
            <div>
                <p class="sp-name" id="sp-name">-</p>
                <p class="sp-mr"  id="sp-mr">-</p>
            </div>
        </div>
        <button class="sp-close" onclick="closePanel()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
    </div>
    <div class="sp-body">
        <div class="sp-section">
            <p class="sp-section-title">Informasi Pasien</p>
            <div class="sp-row"><span class="sp-label">Tanggal Lahir</span><span class="sp-val" id="sp-dob">-</span></div>
            <div class="sp-row"><span class="sp-label">Jenis Kelamin</span><span class="sp-val" id="sp-gender">-</span></div>
            <div class="sp-row"><span class="sp-label">No. WhatsApp</span><span class="sp-val" id="sp-phone">-</span></div>
        </div>
        <div class="sp-section">
            <p class="sp-section-title">Detail Janji Temu</p>
            <div class="sp-row"><span class="sp-label">Tanggal & Jam</span><span class="sp-val" id="sp-datetime">-</span></div>
            <div class="sp-row"><span class="sp-label">Dokter</span><span class="sp-val" id="sp-doctor">-</span></div>
            <div class="sp-row"><span class="sp-label">Poli</span><span class="sp-val" id="sp-poli">-</span></div>
            <div class="sp-row"><span class="sp-label">Durasi</span><span class="sp-val" id="sp-duration">-</span></div>
            <div class="sp-row"><span class="sp-label">Pembayaran</span><span class="sp-val" id="sp-payment">-</span></div>
            <div class="sp-row"><span class="sp-label">Status</span><span class="sp-val" id="sp-status">-</span></div>
        </div>
        <div class="sp-section">
            <p class="sp-section-title">Keluhan & Catatan</p>
            <div class="sp-complaint-box" id="sp-complaint">-</div>
        </div>
        <div class="sp-section" id="sp-creator-section" style="display:none">
            <p class="sp-section-title">Dibuat oleh</p>
            <div class="sp-row"><span class="sp-label">Admin</span><span class="sp-val" id="sp-creator">-</span></div>
        </div>
    </div>
    <div class="sp-footer" id="sp-footer"></div>
</div>

{{-- RESCHEDULE MODAL --}}
<div class="rs-modal-overlay" id="rsModalOverlay">
    <div class="rs-modal-card">
        <div class="rs-modal-head">
            <div>
                <p class="rs-modal-title">Reschedule Janji Temu</p>
                <p class="rs-modal-sub" id="rs-patient-name">-</p>
            </div>
            <button class="rs-modal-close" onclick="closeRescheduleModal()">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="rs-modal-body">
            <div style="margin-bottom:16px;">
                <label class="rs-field-label">Tanggal & Jam Baru</label>
                <input type="datetime-local" id="rs-datetime" class="rs-input">
            </div>
            <div style="margin-bottom:4px;">
                <label class="rs-field-label">Catatan (opsional)</label>
                <textarea id="rs-note" rows="2" placeholder="Alasan reschedule..." class="rs-textarea"></textarea>
            </div>
            <div class="rs-btn-row">
                <button class="rs-btn-cancel" onclick="closeRescheduleModal()">Batal</button>
                <button class="rs-btn-save" id="rs-save-btn" onclick="doSaveReschedule()">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="display:inline;vertical-align:middle;margin-right:4px;"><path d="M20 6L9 17l-5-5"/></svg>
                    Simpan Reschedule
                </button>
            </div>
        </div>
    </div>
</div>

<div class="notif-toast" id="notifToast"></div>

@endsection

@push('scripts')
<script>
let currentAptId    = null;
let currentAptData  = null;
let rescheduleAptId = null;

// ============================================================
// POLLING — cek notif baru setiap 30 detik
// ============================================================
(function() {
    const INTERVAL = 30000;

    async function checkNotifCount() {
        try {
            const res  = await fetch('/admin/notifications/count', {
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();
            const count = data.count || 0;

            // Update badge di tab
            ['badge-semua', 'badge-janji'].forEach(id => {
                const el = document.getElementById(id);
                if (!el) return;
                if (count > 0) el.textContent = count;
                else el.remove();
            });

            // Update badge di navbar (semua navbar)
            document.querySelectorAll('.notif-badge-count').forEach(el => {
                if (count > 0) {
                    el.textContent = count > 99 ? '99+' : count;
                    el.style.display = 'flex';
                } else {
                    el.style.display = 'none';
                }
            });

        } catch (err) {
            console.warn('Notif polling failed:', err);
        }
    }

    checkNotifCount();
    setInterval(checkNotifCount, INTERVAL);
})();

function openPanel(aptId, cardEl) {
    currentAptId   = aptId;
    const d        = cardEl.dataset;
    currentAptData = d;

    document.getElementById('sp-avatar').textContent = d.initials || '??';
    document.getElementById('sp-name').textContent   = d.patient  || '-';
    document.getElementById('sp-mr').textContent     = 'No. RM: ' + (d.mr || '-');
    document.getElementById('sp-dob').textContent    = d.dob    || '-';
    document.getElementById('sp-gender').textContent = d.gender || '-';
    document.getElementById('sp-phone').textContent  = d.phone  || '-';

    const dt    = new Date(d.datetime);
    const dtStr = dt.toLocaleDateString('id-ID', { weekday:'long', day:'numeric', month:'long', year:'numeric' })
                + ' · ' + dt.toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' });
    document.getElementById('sp-datetime').textContent = dtStr;
    document.getElementById('sp-doctor').textContent   = d.doctor  || '-';
    document.getElementById('sp-poli').textContent     = d.poli    || '-';
    document.getElementById('sp-duration').textContent = (d.duration || 30) + ' menit';
    document.getElementById('sp-payment').textContent  = d.payment || '-';

    const statusMap   = { pending:'sp-status-pending', confirmed:'sp-status-confirmed', sistem:'sp-status-sistem' };
    const statusLabel = { pending:'Menunggu Konfirmasi', confirmed:'Dikonfirmasi', waiting:'Menunggu', engaged:'Dalam Tindakan', succeed:'Selesai' };
    document.getElementById('sp-status').innerHTML =
        `<span class="sp-status-badge ${statusMap[d.status] || 'sp-status-pending'}">${statusLabel[d.status] || d.status}</span>`;

    const complaintText = [d.complaint, d.procedure, d.condition].filter(v => v && v !== '-').join(' · ') || '-';
    document.getElementById('sp-complaint').textContent = complaintText;

    const creatorSection = document.getElementById('sp-creator-section');
    if (d.type === 'sistem' && d.creator) {
        creatorSection.style.display = 'block';
        document.getElementById('sp-creator').textContent = d.creator;
    } else {
        creatorSection.style.display = 'none';
    }

    renderPanelFooter(d);
    document.getElementById('slidePanelOverlay').classList.add('open');
    document.getElementById('slidePanel').classList.add('open');
}

function closePanel() {
    document.getElementById('slidePanelOverlay').classList.remove('open');
    document.getElementById('slidePanel').classList.remove('open');
    currentAptId   = null;
    currentAptData = null;
}

function renderPanelFooter(d) {
    const footer = document.getElementById('sp-footer');

    if (d.type === 'sistem') {
        footer.innerHTML = `
            <button class="btn-sp-calendar" onclick="handleGoogleCalendarFromPanel()">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Tambah ke Google Calendar
            </button>
            <p class="sp-footer-note">Janji ini telah didaftarkan langsung oleh admin</p>
        `;
    } else {
        // SEBELUM KONFIRMASI: WA → Konfirmasi → Reschedule
        footer.innerHTML = `
            <button class="btn-sp-wa" onclick="doSendWA()">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                </svg>
                Kirim via WhatsApp
            </button>
            <button class="btn-sp-confirm" id="sp-btn-confirm" onclick="doConfirm()">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
                <span id="sp-confirm-label">Konfirmasi Janji</span>
                <div class="sp-spinner" id="sp-confirm-spinner"></div>
            </button>
            <button class="btn-sp-reschedule" onclick="doReschedule()">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 4v6h-6"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                Reschedule Jadwal
            </button>
        `;
    }
}

async function doConfirm() {
    if (!currentAptId) return;

    const btn     = document.getElementById('sp-btn-confirm');
    const label   = document.getElementById('sp-confirm-label');
    const spinner = document.getElementById('sp-confirm-spinner');

    btn.disabled = true;
    label.textContent = 'Mengkonfirmasi...';
    spinner.style.display = 'block';

    try {
        const res = await fetch(`/admin/notifications/${currentAptId}/confirm`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        });

        const data = await res.json();

        if (data.success) {
            const card = document.querySelector(`.notif-card[data-id="${currentAptId}"]`);
            if (card) {
                card.classList.remove('unread');
                card.querySelector('.notif-dot')?.remove();
                const actionsEl = card.querySelector('.notif-actions');
                if (actionsEl) actionsEl.innerHTML = `<span class="status-confirmed">✓ Dikonfirmasi — masuk Rawat Jalan</span>`;
            }

            // SETELAH KONFIRMASI: Status → Google Calendar → WA
            document.getElementById('sp-footer').innerHTML = `
                <div class="sp-confirmed-state">
                    ✓ Berhasil dikonfirmasi!<br>
                    <span style="font-weight:400; font-size:12px;">Pasien sudah masuk Rawat Jalan</span>
                </div>
                <button class="btn-sp-calendar" onclick="handleGoogleCalendarFromPanel()">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Tambah ke Google Calendar
                </button>
                <button class="btn-sp-wa" onclick="doSendWA()">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                    </svg>
                    Kirim Konfirmasi via WhatsApp
                </button>
            `;

            updateBadges();
            showToast('✓ Janji dikonfirmasi! Pasien masuk Rawat Jalan.', 'success');
        } else {
            showToast(data.message || 'Terjadi kesalahan.', 'error');
            btn.disabled = false;
            label.textContent = 'Konfirmasi Janji';
            spinner.style.display = 'none';
        }
    } catch (err) {
        showToast('Gagal terhubung ke server.', 'error');
        btn.disabled = false;
        label.textContent = 'Konfirmasi Janji';
        spinner.style.display = 'none';
    }
}

function doSendWA() {
    if (!currentAptData) return;

    const d   = currentAptData;
    const dt  = new Date(d.datetime);
    const tgl = dt.toLocaleDateString('id-ID', { weekday:'long', day:'numeric', month:'long', year:'numeric' });
    const jam = dt.toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' });

    const msg = encodeURIComponent(
        `Halo ${d.patient}, kami dari *Hanglekiu Dental Specialist* ingin mengkonfirmasi janji temu Anda:\n\n` +
        `📅 *${tgl}*\n⏰ Jam *${jam} WIB*\n👨‍⚕️ Dokter: *${d.doctor}*\n🏥 Poli: *${d.poli}*\n\n` +
        `Mohon hadir 10 menit sebelum jadwal. Terima kasih! 🙏`
    );

    let phone = (d.phone || '').replace(/\D/g, '');
    if (phone.startsWith('0')) phone = '62' + phone.slice(1);
    if (!phone.startsWith('62')) phone = '62' + phone;

    window.open(`https://wa.me/${phone}?text=${msg}`, '_blank');
}

function doReschedule() {
    if (!currentAptData) return;
    openRescheduleModal(currentAptId, currentAptData);
}

function openRescheduleModal(aptId, data) {
    rescheduleAptId = aptId;
    document.getElementById('rs-patient-name').textContent = data.patient || '-';
    const dt  = new Date(data.datetime);
    const pad = n => String(n).padStart(2, '0');
    document.getElementById('rs-datetime').value = `${dt.getFullYear()}-${pad(dt.getMonth()+1)}-${pad(dt.getDate())}T${pad(dt.getHours())}:${pad(dt.getMinutes())}`;
    document.getElementById('rs-note').value = '';
    document.getElementById('rsModalOverlay').classList.add('open');
}

function closeRescheduleModal() {
    document.getElementById('rsModalOverlay').classList.remove('open');
    rescheduleAptId = null;
}

async function doSaveReschedule() {
    const newDatetime = document.getElementById('rs-datetime').value;
    if (!newDatetime) { showToast('Pilih tanggal & jam baru dulu.', 'error'); return; }

    const btn = document.getElementById('rs-save-btn');
    btn.disabled = true;
    btn.textContent = 'Menyimpan...';

    try {
        const res = await fetch(`/admin/notifications/${rescheduleAptId}/reschedule`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ appointment_datetime: newDatetime })
        });

        const data = await res.json();

        if (data.success) {
            const card = document.querySelector(`.notif-card[data-id="${rescheduleAptId}"]`);
            if (card) {
                const actionsEl = card.querySelector('.notif-actions');
                if (actionsEl) actionsEl.innerHTML = `<span class="status-rescheduled">↺ Dijadwalkan ulang</span>`;
                card.classList.remove('unread');
                card.querySelector('.notif-dot')?.remove();
                const descEl = card.querySelector('.notif-desc');
                if (descEl) {
                    const newDt = new Date(newDatetime);
                    descEl.textContent = newDt.toLocaleDateString('id-ID', { weekday:'long', day:'numeric', month:'long', year:'numeric' })
                        + ' · ' + newDt.toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' });
                }
            }
            closeRescheduleModal();
            showToast('↺ Jadwal berhasil diubah!', 'success');
        } else {
            showToast(data.message || 'Gagal menyimpan.', 'error');
        }
    } catch (err) {
        showToast('Gagal terhubung ke server.', 'error');
    } finally {
        btn.disabled = false;
        btn.innerHTML = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="display:inline;vertical-align:middle;margin-right:4px;"><path d="M20 6L9 17l-5-5"/></svg> Simpan Reschedule`;
    }
}

document.getElementById('rsModalOverlay')?.addEventListener('click', function(e) {
    if (e.target === this) closeRescheduleModal();
});

function handleGoogleCalendar(cardEl) { buildAndOpenCalendar(cardEl.dataset); }
function handleGoogleCalendarFromPanel() { if (!currentAptData) return; buildAndOpenCalendar(currentAptData); }

function buildAndOpenCalendar(d) {
    const dt  = new Date(d.datetime);
    const pad = n => String(n).padStart(2, '0');
    const fmt = (date) => date.getUTCFullYear() + pad(date.getUTCMonth()+1) + pad(date.getUTCDate()) + 'T' + pad(date.getUTCHours()) + pad(date.getUTCMinutes()) + '00Z';
    const start    = fmt(dt);
    const end      = fmt(new Date(dt.getTime() + (parseInt(d.duration) || 30) * 60000));
    const title    = encodeURIComponent(`Janji Temu: ${d.patient} — ${d.poli}`);
    const details  = encodeURIComponent(`Dokter: ${d.doctor}\nPoli: ${d.poli}\nPasien: ${d.patient}\nNo. RM: ${d.mr}\nKeluhan: ${d.complaint}`);
    const location = encodeURIComponent('Hanglekiu Dental Specialist');
    window.open(`https://calendar.google.com/calendar/render?action=TEMPLATE&text=${title}&dates=${start}/${end}&details=${details}&location=${location}`, '_blank');
    showToast('📅 Google Calendar dibuka!', 'success');
}

document.querySelectorAll('.notif-card').forEach(card => {
    card.addEventListener('click', function(e) {
        if (e.target.closest('button')) return;
        const aptId = this.dataset.id;
        if (aptId) openPanel(aptId, this);
    });
});

document.querySelectorAll('.notif-tab').forEach(tab => {
    tab.addEventListener('click', function() {
        document.querySelectorAll('.notif-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.notif-tab-content').forEach(c => c.classList.remove('active'));
        this.classList.add('active');
        document.getElementById('tab-' + this.dataset.tab).classList.add('active');
    });
});

document.getElementById('markAllRead')?.addEventListener('click', function() {
    document.querySelectorAll('.notif-card.unread').forEach(card => {
        card.classList.remove('unread');
        card.querySelector('.notif-dot')?.remove();
    });
    updateBadges();
    fetch('/admin/notifications/mark-all-read', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }
    });
});

function updateBadges() {
    const unread = document.querySelectorAll('.notif-card.unread').length;
    ['badge-semua', 'badge-janji'].forEach(id => {
        const el = document.getElementById(id);
        if (!el) return;
        if (unread > 0) el.textContent = unread;
        else el.remove();
    });
}

function showToast(msg, type = '') {
    const toast = document.getElementById('notifToast');
    toast.textContent = msg;
    toast.className   = 'notif-toast ' + type;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 3000);
}

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') { closePanel(); closeRescheduleModal(); }
});
</script>
@endpush