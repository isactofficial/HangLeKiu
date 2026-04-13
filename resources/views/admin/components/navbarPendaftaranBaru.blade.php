{{-- Navbar Component --}}
@props(['title' => ''])

<header class="admin-navbar">

    {{-- DESKTOP & MOBILE BARIS 1: Search + Daftar --}}
    <div class="navbar-left">
        {{-- Hamburger — hanya tampil di mobile --}}
        <button class="sidebar-hamburger" type="button" aria-label="Toggle menu" onclick="toggleSidebar()">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>

        <div class="navbar-search-wrapper" style="position: relative;">
            <svg class="navbar-search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="text" id="navbarGlobalSearch" class="navbar-search-input"
                   placeholder="Cari Pasien / No MR / No Ktp / No Asuransi..."
                   autocomplete="off">
            <svg class="navbar-user-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>

            <div id="navbarSearchDropdown" style="
                display: none;
                position: absolute;
                top: calc(100% + 6px);
                left: 0;
                right: 0;
                background: white;
                border: 1px solid #E5D6C5;
                border-radius: 10px;
                z-index: 9999;
                max-height: 380px;
                overflow-y: auto;
                box-shadow: 0 8px 24px rgba(88,44,12,0.12);
            "></div>
        </div>

        <div class="navbar-dropdown" id="pendaftaranDropdown">
            <button class="navbar-btn-primary" onclick="toggleDropdown('pendaftaranMenu')">
                <span class="btn-text-desktop">{{ $title ?: 'Pilih Opsi' }}</span>
                <span class="btn-text-mobile">Daftar</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-left:6px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div class="navbar-dropdown-menu" id="pendaftaranMenu">
                <a href="#" onclick="openRegModal('modalPendaftaranBaru'); return false;" class="dropdown-item" style="display:flex;align-items:center;gap:8px;">
                    <i class="fas fa-calendar-plus" style="color:#C58F59;width:16px;"></i>
                    Pendaftaran Baru
                </a>
                <a href="#" onclick="openRegModal('modalPasienBaru'); return false;" class="dropdown-item" style="display:flex;align-items:center;gap:8px;">
                    <i class="fas fa-user-plus" style="color:#C58F59;width:16px;"></i>
                    Pasien Baru
                </a>
            </div>
        </div>

        <script>

            (function() {
    // Cek setiap 30 detik
    const INTERVAL = 30000;

    async function checkNotifCount() {
        try {
            const res  = await fetch('/admin/notifications/count', {
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();
            const count = data.count || 0;

            // Update semua badge notif yang ada di halaman
            document.querySelectorAll('.notif-badge-count').forEach(el => {
                if (count > 0) {
                    el.textContent = count > 99 ? '99+' : count;
                    el.style.display = 'flex';
                } else {
                    el.style.display = 'none';
                }
            });
        } catch (err) {
            console.warn('Notif check failed:', err);
        }
    }

    // Cek pertama saat load
    checkNotifCount();

    // Cek terus tiap 30 detik
    setInterval(checkNotifCount, INTERVAL);
})();
        (function () {
            const input    = document.getElementById('navbarGlobalSearch');
            const dropdown = document.getElementById('navbarSearchDropdown');
            let   timer;

            if (!input) return;

            input.addEventListener('input', function () {
                clearTimeout(timer);
                const q = this.value.trim();
                if (q.length < 2) {
                    dropdown.style.display = 'none';
                    return;
                }
                timer = setTimeout(() => doSearch(q), 350);
            });

            async function doSearch(q) {
                dropdown.style.display = 'block';
                dropdown.innerHTML = '<div style="padding:12px 16px; color:#999; font-size:13px;">Mencari...</div>';

                try {
                    const res = await fetch(`/admin/patients/search?q=${encodeURIComponent(q)}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    const data = await res.json();

                    if (data.success && data.data && data.data.length > 0) {
                        dropdown.innerHTML = data.data.map(p => {
                            const statusColors = {
                                pending: '#EF4444', confirmed: '#F59E0B', waiting: '#8B5CF6',
                                engaged: '#3B82F6', succeed: '#84CC16'
                            };

                            const appointmentRows = p.appointments && p.appointments.length > 0
                                ? p.appointments.map(a => {
                                    const dt       = new Date(a.datetime);
                                    const tgl      = dt.toLocaleDateString('id-ID', { day:'2-digit', month:'short', year:'numeric' });
                                    const jam      = dt.toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' });
                                    const badgeColor = statusColors[a.status?.toLowerCase()] || '#888';

                                    return `
                                        <div onclick="navbarSearchSelect('${a.id}', '${p.full_name.replace(/'/g, "\\'")}')"
                                             style="padding: 7px 16px 7px 28px; cursor: pointer; border-bottom: 1px solid #faf3ec; font-size: 12px; display: flex; justify-content: space-between; align-items: center; background: #fdfaf7;"
                                             onmouseover="this.style.background='#f5ede0'"
                                             onmouseout="this.style.background='#fdfaf7'">
                                            <div style="display:flex; align-items:center; gap:8px;">
                                                <i class="fas fa-calendar-alt" style="color:#C58F59; font-size:10px;"></i>
                                                <span style="color:#5a3e28;">${tgl}, ${jam}</span>
                                                <span style="color:#aaa;">— ${a.poli} / ${a.doctor}</span>
                                            </div>
                                            <div style="display:flex; align-items:center; gap:6px;">
                                                <span style="background:${badgeColor}; color:white; font-size:9px; padding:2px 7px; border-radius:20px; font-weight:700; text-transform:uppercase;">${a.status}</span>
                                                <span style="color:#C58F59; font-size:10px;"><i class="fas fa-arrow-right"></i></span>
                                            </div>
                                        </div>
                                    `;
                                }).join('')
                                : `<div style="padding: 7px 16px 7px 28px; font-size: 12px; color: #bbb; background:#fdfaf7; border-bottom: 1px solid #faf3ec;">
                                       <i class="fas fa-info-circle"></i> Belum ada kunjungan
                                   </div>`;

                            return `
                                <div>
                                    <div style="padding: 10px 16px; border-bottom: 1px solid #f0e8df; background: white; display: flex; justify-content: space-between; align-items: center;">
                                        <div>
                                            <div style="font-weight: 700; color: #2C1810; font-size: 13px;">${p.full_name}</div>
                                            <div style="color: #999; font-size: 11px; margin-top: 2px;">
                                                MR: ${p.medical_record_no || '-'} &nbsp;|&nbsp; KTP: ${p.id_card_number || '-'}
                                            </div>
                                        </div>
                                        <div style="color:#aaa; font-size:11px; white-space:nowrap; margin-left:8px;">
                                            ${p.appointments.length} kunjungan
                                        </div>
                                    </div>
                                    ${appointmentRows}
                                </div>
                            `;
                        }).join('');
                    } else {
                        dropdown.innerHTML = '<div style="padding:12px 16px; color:#999; font-size:13px;">Pasien tidak ditemukan.</div>';
                    }
                } catch (err) {
                    console.error(err);
                    dropdown.innerHTML = '<div style="padding:12px 16px; color:#e05252; font-size:13px;">Gagal mencari data.</div>';
                }
            }

            window.navbarSearchSelect = function (apptId, name) {
                dropdown.style.display = 'none';
                input.value = name;
                window.location.href = `/admin/emr?open=${apptId}`;
            };

            document.addEventListener('click', function (e) {
                if (!input.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.style.display = 'none';
                }
            });

            input.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    dropdown.style.display = 'none';
                    this.blur();
                }
            });
        })();
        </script>
    </div>

    {{-- DESKTOP: Right icons --}}
    <div class="navbar-right">
        <div class="navbar-collapsible" id="navbarIconGroup">
            <div class="navbar-hds-logo">
                <img src="/images/logo-hds.png" alt="HDS">
            </div>

            <div class="navbar-dropdown" id="clinicDropdown">
                <button class="navbar-dropdown-btn" onclick="toggleDropdown('clinicMenu')">
                    <span>hanglekiu dent...</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div class="navbar-dropdown-menu" id="clinicMenu">
                    <a href="#" class="dropdown-item active">Hanglekiu Dental Clinic</a>
                    <a href="#" class="dropdown-item">Cabang Kemang</a>
                    <a href="#" class="dropdown-item">Cabang Sudirman</a>
                </div>
            </div>

            <div class="navbar-divider"></div>

            <button class="navbar-icon-btn" title="Bantuan">
                <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                    <path d="M12 17l0 .01" />
                    <path d="M12 13.5a1.5 1.5 0 0 1 1 -1.5a2.6 2.6 0 1 0 -3 -4" />
                </svg>
            </button>

            {{-- Notifications --}}
            @php
                $pendingCount = \App\Models\Appointment::where('status','pending')
                ->whereNull('admin_id')
                ->whereHas('patient')
                ->count();
            @endphp
            <a href="{{ route('admin.notifications') }}" style="position:relative; display:inline-flex;">
                <button class="navbar-icon-btn" title="Notifikasi">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"/>
                        <path d="M9 17v1a3 3 0 0 0 6 0v-1"/>
                    </svg>
                    @if($pendingCount > 0)
                        <span style="position:absolute; top:-4px; right:-4px; background:#EF4444; color:white; font-size:10px; font-weight:700; min-width:16px; height:16px; border-radius:20px; display:flex; align-items:center; justify-content:center; padding:0 4px; line-height:1;">
                             {{ $pendingCount > 99 ? '99+' : $pendingCount }}
                        </span>
                    @endif
                </button>
            </a>

            <div class="navbar-dropdown">
                <button class="navbar-icon-btn" title="Profil" onclick="toggleDropdown('profileMenu')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 13a3 3 0 1 0 0 -6a3 3 0 0 0 0 6" />
                        <path d="M12 3c7.2 0 9 1.8 9 9c0 7.2 -1.8 9 -9 9c-7.2 0 -9 -1.8 -9 -9c0 -7.2 1.8 -9 9 -9" />
                        <path d="M6 20.05v-.05a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v.05" />
                    </svg>
                </button>
                <div class="navbar-dropdown-menu navbar-profile-menu" id="profileMenu">
                    <div class="dropdown-header">
                        <strong>{{ Auth::check() ? Auth::user()->name : 'Admin' }}</strong>
                        <small>{{ Auth::check() ? Auth::user()->email : 'admin@hds.com' }}</small>
                    </div>
                    <a href="#" class="dropdown-item">Pengaturan Profil</a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item dropdown-logout">Logout</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Tombol MORE — hanya tampil di mobile --}}
        <button class="navbar-more-btn" id="navbarMoreBtn" onclick="toggleNavbarMore()">
            more
            <svg id="navbarMoreChevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left: 4px;">
                <path d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
        </button>
    </div>
</header>

<script>
    function toggleNavbarMore() {
        const group   = document.getElementById('navbarIconGroup');
        const chevron = document.getElementById('navbarMoreChevron');
        const isOpen  = group.classList.toggle('open');
        chevron.style.transform = isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
    }

    function toggleDropdown(menuId) {
        const menu = document.getElementById(menuId);
        document.querySelectorAll('.navbar-dropdown-menu').forEach(m => {
            if (m.id !== menuId) m.classList.remove('show');
        });
        menu.classList.toggle('show');
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.navbar-dropdown') &&
            !e.target.closest('.navbar-icon-btn') &&
            !e.target.closest('.navbar-more-btn')) {
            document.querySelectorAll('.navbar-dropdown-menu').forEach(m => m.classList.remove('show'));
        }
    });
</script>