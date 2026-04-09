@extends('admin.layout.admin')

@section('title', 'Notifikasi')


@section('navbar')
    @include('admin.components.navbar')
@endsection

@section('content')
<style>
    /* === NOTIFICATIONS PAGE === */

.notif-page {
    max-width: 860px;
    margin: 0 auto;
    padding: 28px 32px;
}

.notif-page-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 24px;
}

.notif-page-title {
    font-size: 22px;
    font-weight: 600;
    color: #3b1f0a;
    margin: 0 0 4px;
}

.notif-page-sub {
    font-size: 13px;
    color: #9c6f4a;
}

.btn-mark-all {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: #7a3b0a;
    background: none;
    border: 1px solid #d6a87a;
    border-radius: 20px;
    padding: 6px 14px;
    cursor: pointer;
    transition: background 0.15s;
    white-space: nowrap;
}
.btn-mark-all:hover { background: #fdf0e4; }

/* === TABS === */
.notif-tabs {
    display: flex;
    gap: 4px;
    border-bottom: 1.5px solid #e8d5c0;
    margin-bottom: 0;
}

.notif-tab {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 10px 16px;
    font-size: 13px;
    color: #9c6f4a;
    background: none;
    border: none;
    border-bottom: 2px solid transparent;
    margin-bottom: -1.5px;
    cursor: pointer;
    transition: color 0.15s;
}
.notif-tab.active {
    color: #5C2D0A;
    border-bottom-color: #5C2D0A;
    font-weight: 500;
}
.notif-tab:hover { color: #5C2D0A; }

.tab-badge {
    background: #8B3A0A;
    color: #fff;
    font-size: 10px;
    font-weight: 600;
    padding: 1px 6px;
    border-radius: 20px;
    line-height: 1.6;
}

/* === TAB CONTENT === */
.notif-tab-content { display: none; padding-top: 8px; }
.notif-tab-content.active { display: block; }

/* === SECTION LABEL === */
.notif-section-label {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: #b08060;
    padding: 14px 0 8px;
}

/* === NOTIFICATION CARD === */
.notif-card {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 16px;
    background: #fff;
    border: 0.5px solid #e8d5c0;
    border-radius: 12px;
    margin-bottom: 10px;
    position: relative;
    transition: box-shadow 0.15s;
}
.notif-card:hover { box-shadow: 0 2px 8px rgba(90,40,10,0.07); }
.notif-card.unread { background: #fdf6ef; border-color: #d6b08a; }

.notif-dot {
    position: absolute;
    top: 20px;
    left: -5px;
    width: 8px;
    height: 8px;
    background: #8B3A0A;
    border-radius: 50%;
    border: 2px solid #fff;
}

.notif-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 600;
    flex-shrink: 0;
}
.av-janji { background: #f5dfc3; color: #7a3b0a; }
.av-sistem { background: #e8d5c0; color: #5C2D0A; }

.notif-body { flex: 1; min-width: 0; }

.notif-top {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 5px;
}

.notif-badge {
    font-size: 10px;
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 20px;
}
.badge-janji { background: #f5dfc3; color: #7a3b0a; }
.badge-sistem { background: #e8d5c0; color: #5C2D0A; }

.notif-time {
    font-size: 11px;
    color: #b08060;
    margin-left: auto;
}

.notif-title {
    font-size: 13px;
    color: #3b1f0a;
    margin: 0 0 3px;
    line-height: 1.5;
}
.notif-title strong { font-weight: 600; }

.notif-desc {
    font-size: 12px;
    color: #9c6f4a;
    margin: 0 0 12px;
}

/* === ACTION BUTTONS === */
.notif-actions {
    display: flex;
    gap: 8px;
    align-items: center;
}

.btn-accept,
.btn-reject {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 6px 14px;
    font-size: 12px;
    font-weight: 500;
    border-radius: 20px;
    border: 1px solid;
    cursor: pointer;
    transition: all 0.15s;
}

.btn-accept {
    background: #5C2D0A;
    color: #fff;
    border-color: #5C2D0A;
}
.btn-accept:hover { background: #3b1f0a; }

.btn-reject {
    background: #fff;
    color: #9c3a1a;
    border-color: #d6a87a;
}
.btn-reject:hover { background: #fff0e8; border-color: #9c3a1a; }

.status-accepted {
    font-size: 12px;
    font-weight: 600;
    color: #2d7a4a;
    background: #e6f5ed;
    padding: 4px 12px;
    border-radius: 20px;
}
.status-rejected {
    font-size: 12px;
    font-weight: 600;
    color: #9c3a1a;
    background: #fdeee8;
    padding: 4px 12px;
    border-radius: 20px;
}

/* === COMING SOON === */
.coming-soon-card {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 18px 20px;
    background: #fff8f2;
    border: 1.5px dashed #d6a87a;
    border-radius: 12px;
    margin-bottom: 10px;
}

.cs-icon-wrap {
    width: 44px;
    height: 44px;
    background: #f5dfc3;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #7a3b0a;
    flex-shrink: 0;
}

.cs-title {
    font-size: 13px;
    font-weight: 600;
    color: #3b1f0a;
    margin: 0 0 4px;
}

.cs-desc {
    font-size: 12px;
    color: #9c6f4a;
    line-height: 1.6;
    margin: 0;
}

.cs-pill {
    flex-shrink: 0;
    font-size: 10px;
    font-weight: 600;
    background: #8B3A0A;
    color: #fff;
    padding: 3px 10px;
    border-radius: 20px;
    letter-spacing: 0.5px;
    align-self: flex-start;
    margin-top: 2px;
}

/* === EMPTY STATE === */
.notif-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
    padding: 60px 20px;
    color: #b08060;
    font-size: 13px;
}
</style>

<div class="notif-page">

    <div class="notif-page-header">
        <div>
            <h1 class="notif-page-title">Notifikasi</h1>
            <p class="notif-page-sub">Pantau aktivitas & janji temu masuk</p>
        </div>
        <button class="btn-mark-all" id="markAllRead">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 6L9 17l-5-5"/>
            </svg>
            Tandai semua dibaca
        </button>
    </div>

    {{-- Tab --}}
    <div class="notif-tabs">
        <button class="notif-tab active" data-tab="semua">
            Semua
            <span class="tab-badge" id="badge-semua">{{ $unreadCount ?? 3 }}</span>
        </button>
        <button class="notif-tab" data-tab="janji">
            Janji Temu
            <span class="tab-badge" id="badge-janji">{{ $unreadAppointmentCount ?? 3 }}</span>
        </button>
        <button class="notif-tab" data-tab="sistem">
            Sistem
        </button>
    </div>

    {{-- Tab: Semua --}}
    <div class="notif-tab-content active" id="tab-semua">

        <div class="notif-section-label">Terbaru hari ini</div>

        @forelse($notifications ?? [] as $notif)
        <div class="notif-card {{ $notif->read_at ? '' : 'unread' }}" data-id="{{ $notif->id }}">
            @if(!$notif->read_at)<div class="notif-dot"></div>@endif
            <div class="notif-avatar av-janji">
                {{ strtoupper(substr($notif->patient_name ?? 'X', 0, 1)) }}{{ strtoupper(substr(explode(' ', $notif->patient_name ?? 'X ')[1] ?? '', 0, 1)) }}
            </div>
            <div class="notif-body">
                <div class="notif-top">
                    <span class="notif-badge badge-janji">Janji Temu</span>
                    <span class="notif-time">{{ $notif->created_at->diffForHumans() }}</span>
                </div>
                <p class="notif-title">Permintaan janji temu baru — <strong>{{ $notif->patient_name }}</strong></p>
                <p class="notif-desc">
                    {{ \Carbon\Carbon::parse($notif->appointment_datetime)->isoFormat('dddd, D MMM YYYY') }}
                    · {{ \Carbon\Carbon::parse($notif->appointment_datetime)->format('H:i') }}
                    · {{ $notif->procedure_plan ?? '-' }}
                </p>
                <div class="notif-actions">
                    <button class="btn-accept" onclick="handleAddToCalendar(1)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">            
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>            
                            <line x1="16" y1="2" x2="16" y2="6"/>            
                            <line x1="8" y1="2" x2="8" y2="6"/>            
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        Tambah ke Kalender
                    </button>
                    <button class="btn-reject" onclick="handleReschedule(1)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M23 4v6h-6"/>
                            <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                        </svg>
                        Reschedule
                    </button>
                </div>
            </div>
        </div>
        @empty
        {{-- Fallback: data statis untuk development / demo --}}
        <div class="notif-card unread" data-id="1">
            <div class="notif-dot"></div>
            <div class="notif-avatar av-janji">RT</div>
            <div class="notif-body">
                <div class="notif-top">
                    <span class="notif-badge badge-janji">Janji Temu</span>
                    <span class="notif-time">5 menit lalu</span>
                </div>
                <p class="notif-title">Permintaan janji temu baru — <strong>Rina Tanjung</strong></p>
                <p class="notif-desc">Kamis, 10 Apr 2026 · 09:00 · Pembersihan Karang Gigi</p>
                <div class="notif-actions">
                    <button class="btn-accept" onclick="handleAddToCalendar(2)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">            
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>            
                            <line x1="16" y1="2" x2="16" y2="6"/>            
                            <line x1="8" y1="2" x2="8" y2="6"/>            
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        Tambah ke Kalender
                    </button>
                    <button class="btn-reject" onclick="handleReschedule(2)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M23 4v6h-6"/>
                            <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                        </svg>
                        Reschedule
                    </button>
                </div>
            </div>
        </div>

        <div class="notif-card unread" data-id="2">
            <div class="notif-dot"></div>
            <div class="notif-avatar av-janji">BS</div>
            <div class="notif-body">
                <div class="notif-top">
                    <span class="notif-badge badge-janji">Janji Temu</span>
                    <span class="notif-time">32 menit lalu</span>
                </div>
                <p class="notif-title">Permintaan janji temu baru — <strong>Budi Santoso</strong></p>
                <p class="notif-desc">Jumat, 11 Apr 2026 · 14:00 · Konsultasi Ortodonti</p>
                <div class="notif-actions">
                    <button class="btn-accept" onclick="handleAddToCalendar(3)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">            
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>            
                            <line x1="16" y1="2" x2="16" y2="6"/>            
                            <line x1="8" y1="2" x2="8" y2="6"/>            
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        Tambah ke Kalender
                    </button>
                    <button class="btn-reject" onclick="handleReschedule(3)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M23 4v6h-6"/>
                            <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                        </svg>
                        Reschedule
                    </button>
                </div>
            </div>
        </div>

        <div class="notif-card unread" data-id="3">
            <div class="notif-dot"></div>
            <div class="notif-avatar av-janji">LP</div>
            <div class="notif-body">
                <div class="notif-top">
                    <span class="notif-badge badge-janji">Janji Temu</span>
                    <span class="notif-time">1 jam lalu</span>
                </div>
                <p class="notif-title">Permintaan janji temu baru — <strong>Lestari Putri</strong></p>
                <p class="notif-desc">Senin, 14 Apr 2026 · 11:00 · Tambal Gigi</p>
                <div class="notif-actions">
                    <button class="btn-accept" onclick="handleAddToCalendar(4)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">            
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>            
                            <line x1="16" y1="2" x2="16" y2="6"/>            
                            <line x1="8" y1="2" x2="8" y2="6"/>            
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        Tambah ke Kalender
                    </button>
                    <button class="btn-reject" onclick="handleReschedule(4)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M23 4v6h-6"/>
                            <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                        </svg>
                        Reschedule
                    </button>
                </div>
            </div>
        </div>
        @endforelse

        {{-- Coming Soon Section --}}
        <div class="notif-section-label" style="margin-top: 28px;">Segera hadir</div>
        <div class="coming-soon-card">
            <div class="cs-icon-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                </svg>
            </div>
            <div>
                <p class="cs-title">Notifikasi Real-time & Push Notification</p>
                <p class="cs-desc">Admin akan otomatis menerima alert setiap ada janji baru, perubahan jadwal, atau pembatalan tanpa perlu refresh halaman.</p>
            </div>
            <span class="cs-pill">Coming Soon</span>
        </div>

    </div>

    {{-- Tab: Janji Temu --}}
    <div class="notif-tab-content" id="tab-janji">
        <div class="notif-section-label">Menunggu konfirmasi</div>

        @forelse($appointmentNotifications ?? [] as $notif)
        <div class="notif-card {{ $notif->read_at ? '' : 'unread' }}">
            @if(!$notif->read_at)<div class="notif-dot"></div>@endif
            <div class="notif-avatar av-janji">
                {{ strtoupper(substr($notif->patient_name ?? 'X', 0, 1)) }}{{ strtoupper(substr(explode(' ', $notif->patient_name ?? 'X ')[1] ?? '', 0, 1)) }}
            </div>
            <div class="notif-body">
                <div class="notif-top">
                    <span class="notif-badge badge-janji">Janji Temu</span>
                    <span class="notif-time">{{ $notif->created_at->diffForHumans() }}</span>
                </div>
                <p class="notif-title">Permintaan janji temu baru — <strong>{{ $notif->patient_name }}</strong></p>
                <p class="notif-desc">
                    {{ \Carbon\Carbon::parse($notif->appointment_datetime)->isoFormat('dddd, D MMM YYYY') }}
                    · {{ \Carbon\Carbon::parse($notif->appointment_datetime)->format('H:i') }}
                    · {{ $notif->procedure_plan ?? '-' }}
                </p>
                <div class="notif-actions">
                    <button class="btn-accept" onclick="handleAddToCalendar(5)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">            
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>            
                            <line x1="16" y1="2" x2="16" y2="6"/>            
                            <line x1="8" y1="2" x2="8" y2="6"/>            
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        Tambah ke Kalender
                    </button>
                    <button class="btn-reject" onclick="handleReschedule(5)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M23 4v6h-6"/>
                            <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                        </svg>
                        Reschedule
                    </button>
                </div>
            </div>
        </div>
        @empty
        {{-- Fallback statis --}}
        <div class="notif-card unread">
            <div class="notif-dot"></div>
            <div class="notif-avatar av-janji">RT</div>
            <div class="notif-body">
                <div class="notif-top">
                    <span class="notif-badge badge-janji">Janji Temu</span>
                    <span class="notif-time">5 menit lalu</span>
                </div>
                <p class="notif-title">Permintaan janji temu baru — <strong>Rina Tanjung</strong></p>
                <p class="notif-desc">Kamis, 10 Apr 2026 · 09:00 · Pembersihan Karang Gigi</p>
                                <div class="notif-actions">
                    <button class="btn-accept" onclick="handleAddToCalendar(6)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">            
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>            
                            <line x1="16" y1="2" x2="16" y2="6"/>            
                            <line x1="8" y1="2" x2="8" y2="6"/>            
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        Tambah ke Kalender
                    </button>
                    <button class="btn-reject" onclick="handleReschedule(6)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M23 4v6h-6"/>
                            <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                        </svg>
                        Reschedule
                    </button>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    {{-- Tab: Sistem --}}
    <div class="notif-tab-content" id="tab-sistem">
        <div class="notif-empty">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
            <p>Belum ada notifikasi sistem</p>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Tab switching
    document.querySelectorAll('.notif-tab').forEach(tab => {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.notif-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.notif-tab-content').forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('tab-' + this.dataset.tab).classList.add('active');
        });
    });

    // Mark all read
    document.getElementById('markAllRead')?.addEventListener('click', function () {
        document.querySelectorAll('.notif-card.unread').forEach(card => {
            card.classList.remove('unread');
            card.querySelector('.notif-dot')?.remove();
        });
        document.querySelectorAll('.tab-badge').forEach(b => b.remove());

        fetch('/admin/notifications/mark-all-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            }
        });
    });

    // ✅ DIGANTI: Calendar & Reschedule handler
    function handleAddToCalendar(id) {
        const card = document.querySelector(`.notif-card[data-id="${id}"]`);
        if (!card) return;

        card.querySelector('.notif-actions').innerHTML =
            `<span class="status-accepted">✓ Ditambahkan ke Kalender</span>`;
        card.classList.remove('unread');
        card.querySelector('.notif-dot')?.remove();
        updateBadges();

        fetch(`/admin/notifications/${id}/calendar`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            }
        });
    }

    function handleReschedule(id) {
        const card = document.querySelector(`.notif-card[data-id="${id}"]`);
        if (!card) return;

        card.querySelector('.notif-actions').innerHTML =
            `<span class="status-rejected">↺ Reschedule Diminta</span>`;
        card.classList.remove('unread');
        card.querySelector('.notif-dot')?.remove();
        updateBadges();

        fetch(`/admin/notifications/${id}/reschedule`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            }
        });
    }

    // Update badge count
    function updateBadges() {
        const unreadCount = document.querySelectorAll('#tab-semua .notif-card.unread').length;
        const bSemua = document.getElementById('badge-semua');
        const bJanji = document.getElementById('badge-janji');
        if (bSemua) { unreadCount > 0 ? bSemua.textContent = unreadCount : bSemua.remove(); }
        if (bJanji) { unreadCount > 0 ? bJanji.textContent = unreadCount : bJanji.remove(); }
    }
</script>
@endpush