@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/settings/manajemen_staff.css') }}">
    <style>
        :root {
            --cream-50: #fdf9f5;
            --cream-100: #f7f0e6;
            --cream-200: #ecdcca;
            --gold-300: #d4a96a;
            --gold-400: #c58f59;
            --gold-500: #a97540;
            --brown-600: #7a4f28;
            --brown-700: #582c0c;
            --text-gray: #b09a85;
            --req-star: #e05252;
            --transition: 0.2s ease-in-out;
        }

        .ts-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 20px;
        }

        .ts-modal-overlay.show {
            display: flex;
        }

        .ts-modal-content {
            background: #ffffff;
            border-radius: 12px;
            width: 100%;
            max-width: 700px;
            font-family: 'Instrument Sans', sans-serif;
            box-shadow: 0 10px 40px rgba(88, 44, 12, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .ts-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 24px;
            border-bottom: 1px solid var(--cream-100);
        }

        .ts-modal-header h3 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            color: var(--brown-700);
        }

        .ts-close-btn {
            background: none;
            border: none;
            color: var(--text-gray);
            font-size: 24px;
            line-height: 1;
            cursor: pointer;
            transition: color var(--transition);
        }

        .ts-close-btn:hover {
            color: var(--req-star);
        }

        .ts-modal-body {
            padding: 24px;
            overflow-y: auto;
            max-height: 80vh;
        }

        .ts-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px 24px;
            margin-bottom: 20px;
        }

        @media (max-width: 640px) {
            .ts-grid-2 {
                grid-template-columns: 1fr;
                gap: 16px;
            }
        }

        .ts-form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .ts-form-group.full {
            margin-bottom: 20px;
        }

        .ts-label {
            font-size: 14px;
            font-weight: 600;
            color: var(--brown-700);
        }

        .ts-label span {
            color: var(--req-star);
        }

        .ts-input,
        .ts-select {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid var(--cream-200);
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Instrument Sans', sans-serif;
            color: var(--brown-700);
            background: var(--white);
            outline: none;
            transition: border-color var(--transition);
        }

        .ts-input::placeholder {
            color: #cbbdad;
        }

        .ts-input:focus,
        .ts-select:focus {
            border-color: var(--gold-400);
        }

        .ts-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%23582C0C' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round' xmlns='http://www.w3.org/2000/svg'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            cursor: pointer;
        }

        .ts-control-wrapper {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            padding-top: 8px;
        }

        .ts-control-left {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .ts-checkbox {
            width: 18px;
            height: 18px;
            margin-top: 2px;
            accent-color: var(--gold-400);
            cursor: pointer;
        }

        .ts-control-text {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .ts-control-text strong {
            font-size: 14px;
            font-weight: 600;
            color: var(--brown-700);
        }

        .ts-control-text span {
            font-size: 13px;
            color: var(--text-gray);
        }

        .ts-toggle-switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .ts-toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .ts-slider {
            position: absolute;
            cursor: pointer;
            inset: 0;
            background-color: var(--cream-200);
            transition: 0.3s;
            border-radius: 34px;
        }

        .ts-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: 0.3s;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .ts-toggle-switch input:checked + .ts-slider {
            background-color: var(--gold-400);
        }

        .ts-toggle-switch input:checked + .ts-slider:before {
            transform: translateX(20px);
        }

        .ts-modal-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--cream-100);
            background: var(--cream-50);
            display: flex;
            justify-content: flex-end;
        }

        .ts-btn-primary {
            background: var(--gold-400);
            color: var(--white);
            border: none;
            border-radius: 8px;
            padding: 10px 32px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background var(--transition);
        }

        .ts-btn-primary:hover {
            background: var(--gold-500);
        }

        .ms-table-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(88, 44, 12, 0.06);
            border: 1px solid var(--cream-200);
            overflow: hidden;
            margin-top: 24px;
            font-family: 'Instrument Sans', sans-serif;
        }

        .ms-card-nav {
            display: flex;
            gap: 8px;
            padding: 16px 20px;
            background: var(--cream-50);
            border-bottom: 1px solid var(--cream-200);
            overflow-x: auto;
        }

        .ms-nav-link {
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-gray);
            transition: all var(--transition);
            white-space: nowrap;
            border: 1px solid transparent;
        }

        .ms-nav-link:hover {
            color: var(--brown-700);
            background: var(--cream-100);
        }

        .ms-nav-link.active {
            background: var(--white);
            color: var(--brown-700);
            border-color: var(--cream-200);
            box-shadow: 0 2px 8px rgba(88, 44, 12, 0.05);
        }

        .ms-table-wrapper {
            overflow-x: auto;
        }

        .ms-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .ms-table th {
            padding: 16px 20px;
            background: var(--white);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-gray);
            text-align: center;
            border-bottom: 2px solid var(--cream-100);
        }

        .ms-table td {
            padding: 18px 20px;
            font-size: 14px;
            color: var(--brown-700);
            text-align: center;
            border-bottom: 1px solid var(--cream-50);
            vertical-align: middle;
        }

        .ms-table tbody tr:hover {
            background: var(--cream-50);
        }

        .ms-staff-name {
            font-weight: 700;
            display: block;
            color: var(--brown-700);
        }

        .ms-staff-sub {
            font-size: 12px;
            color: var(--text-gray);
            display: block;
        }

        .ms-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .ms-badge-aktif {
            background: #e6f4ea;
            color: #1e7e34;
        }

        .ms-badge-nonaktif {
            background: #fce8e8;
            color: #c62828;
        }

        .ms-email-masked {
            font-family: 'Monaco', 'Consolas', monospace;
            color: var(--text-gray);
            background: var(--cream-50);
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 12px;
        }

        .ms-pagination {
            padding: 16px 20px;
            border-top: 1px solid var(--cream-100);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--white);
        }

        .ms-page-info {
            font-size: 13px;
            color: var(--text-gray);
        }

        .staff-toggle-btn {
            background: #a97540;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background 0.2s ease;
        }

        .staff-toggle-btn:hover {
            background: #8a6b52;
        }

        .staff-toggle-btn:disabled {
            background: #a975405e;
            color: #ffffff;
            cursor: not-allowed;
            opacity: 1;
        }
    </style>
@endpush

<div class="ms-header-row">
    <div>
        <h2 class="ms-title">Manajemen Staff</h2>
        <p class="ms-subtitle">Last Update: 17 Desember 2024 (13:50 WIB)</p>
    </div>
    <div class="ms-actions-row">
        <div >
            <button class="ms-btn-primary" id="ms-open-doctor-modal" type="button">Tambah Akun</button>
        </div>
    </div>
</div>

@if (session('success'))
    <div class="ms-alert ms-alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->has('staff_account_create') || $errors->any())
    <div class="ms-alert ms-alert-error">
        {{ $errors->first('staff_account_create') ?: $errors->first() }}
    </div>
@endif

<div id="ms-doctor-modal" class="ts-modal-overlay" aria-hidden="true">
    <div class="ts-modal-content" role="dialog" aria-modal="true">
        <div class="ts-modal-header">
            <h3>Tambah Staff</h3>
            <button type="button" class="ts-close-btn" id="ms-close-doctor-modal" aria-label="Tutup">&times;</button>
        </div>

        <form method="POST" action="{{ route('admin.settings.staff.account.store') }}">
            @csrf

            <div class="ts-modal-body">
                <div class="ts-form-group full">
                    <label class="ts-label" for="full_name">Nama Lengkap <span>*</span></label>
                    <input class="ts-input" id="full_name" name="full_name" type="text" placeholder="Nama Lengkap" value="{{ old('full_name') }}" required>
                </div>

                <div class="ts-grid-2">
                    <div class="ts-form-group">
                        <label class="ts-label" for="email">Alamat Email <span>*</span></label>
                        <input class="ts-input" id="email" name="email" type="email" placeholder="Alamat Email" value="{{ old('email') }}" required>
                    </div>
                    <div class="ts-form-group">
                        <label class="ts-label" for="access_type">Tipe Akses <span>*</span></label>
                        <select class="ts-select" id="access_type" name="access_type" required>
                            <option value="" disabled {{ old('access_type') ? '' : 'selected' }}>Pilih Tipe Akses</option>
                            <option value="ADM" {{ old('access_type') === 'ADM' ? 'selected' : '' }}>Admin</option>
                            <option value="OWN" {{ old('access_type') === 'OWN' ? 'selected' : '' }}>Owner</option>
                            <option value="DCT" {{ old('access_type') === 'DCT' ? 'selected' : '' }}>Doctor</option>
                        </select>
                    </div>
                </div>

                <div class="ts-grid-2">
                    <div class="ts-form-group">
                        <label class="ts-label" for="password">Password <span>*</span></label>
                        <input class="ts-input" id="password" name="password" type="password" placeholder="Minimal 8 karakter" required>
                    </div>
                    <div class="ts-form-group">
                        <label class="ts-label" for="password_confirmation">Konfirmasi Password <span>*</span></label>
                        <input class="ts-input" id="password_confirmation" name="password_confirmation" type="password" placeholder="Ulangi password" required>
                    </div>
                </div>

                <div class="ts-grid-2" style="margin-top: 12px; margin-bottom: 0;">
                    <div></div>
                    <label class="ts-control-wrapper" style="cursor: pointer;">
                        <div class="ts-control-left">
                            <div class="ts-control-text">
                                <strong>Status Staff Aktif</strong>
                                <span>Staff dapat login dan mengakses sistem</span>
                            </div>
                        </div>
                        <div class="ts-toggle-switch">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                            <span class="ts-slider"></span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="ts-modal-footer">
                <button type="submit" class="ts-btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div class="ms-table-card">
    @php
        $countAdm = (int) ($staffCounts['ADM'] ?? 0);
        $countDct = (int) ($staffCounts['DCT'] ?? 0);
        $countOwn = (int) ($staffCounts['OWN'] ?? 0);

        $roleLabelMap = [
            'ADM' => 'Admin',
            'DCT' => 'Doctor',
            'OWN' => 'Owner',
        ];

    @endphp

    <div class="ms-card-nav">
        <a href="{{ route('admin.settings', ['menu' => 'manajemen-staff']) }}" class="ms-nav-link {{ ($staffRoleFilter ?? 'ALL') === 'ALL' ? 'active' : '' }}">
            Semua Akun <span style="opacity: 0.5; margin-left: 4px;">{{ $countAdm + $countDct + $countOwn }}</span>
        </a>
        <a href="{{ route('admin.settings', ['menu' => 'manajemen-staff', 'staff_role' => 'ADM']) }}" class="ms-nav-link {{ ($staffRoleFilter ?? 'ALL') === 'ADM' ? 'active' : '' }}">
            Admin ({{ $countAdm }})
        </a>
        <a href="{{ route('admin.settings', ['menu' => 'manajemen-staff', 'staff_role' => 'DCT']) }}" class="ms-nav-link {{ ($staffRoleFilter ?? 'ALL') === 'DCT' ? 'active' : '' }}">
            Doctor ({{ $countDct }})
        </a>
        <a href="{{ route('admin.settings', ['menu' => 'manajemen-staff', 'staff_role' => 'OWN']) }}" class="ms-nav-link {{ ($staffRoleFilter ?? 'ALL') === 'OWN' ? 'active' : '' }}">
            Owner ({{ $countOwn }})
        </a>
    </div>

    <div class="ms-table-wrapper">
        <table class="ms-table">
            <thead>
                <tr>
                    <th>Nama Staff</th>
                    <th>Status</th>
                    <th>Tipe Akses</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($staffAccounts ?? [] as $account)
                    @php
                        $isSelfAccount = (string) auth()->id() === (string) $account->id;
                    @endphp
                    <tr>
                        <td>
                            <span class="ms-staff-name">{{ $account->name }}</span>
                        </td>
                        <td>
                            <span class="ms-badge {{ $account->is_active ? 'ms-badge-aktif' : 'ms-badge-nonaktif' }} staff-status-badge">
                                {{ $account->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; justify-content: center; align-items: center; gap: 6px;">
                                <div style="width: 8px; height: 8px; border-radius: 50%; background: var(--gold-400);"></div>
                                <span style="font-weight: 600;">{{ $roleLabelMap[$account->role->code ?? ''] ?? '-' }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="ms-email-masked">{{ $account->email }}</span>
                        </td>
                        <td>
                            <div style="display: flex; justify-content: center;">
                                <button
                                    type="button"
                                    class="staff-toggle-btn"
                                    data-toggle-url="{{ route('admin.settings.staff.account.toggle-status', ['id' => $account->id]) }}"
                                    data-is-active="{{ $account->is_active ? 'true' : 'false' }}"
                                    @disabled($isSelfAccount)
                                >
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    {{ $account->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding: 60px 20px;">
                            <div style="color: var(--text-gray);">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" style="margin-bottom: 12px; opacity: 0.5;">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                                <p style="font-weight: 500;">Tidak ada data staff ditemukan</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="ms-pagination">
        <div class="ms-page-info">Menampilkan <strong>{{ count($staffAccounts ?? []) }}</strong> staff terdaftar</div>
        <div style="display: flex; gap: 8px;"></div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('ms-doctor-modal');
        const openBtn = document.getElementById('ms-open-doctor-modal');
        const closeBtn = document.getElementById('ms-close-doctor-modal');
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        if (modal && openBtn) {
            const openModal = () => {
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';
            };

            const closeModal = () => {
                modal.classList.remove('show');
                document.body.style.overflow = '';
            };

            openBtn.addEventListener('click', openModal);

            if (closeBtn) {
                closeBtn.addEventListener('click', closeModal);
            }

            modal.addEventListener('click', function (event) {
                if (event.target === modal) {
                    closeModal();
                }
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && modal.classList.contains('show')) {
                    closeModal();
                }
            });

            @if ($errors->has('staff_account_create') || $errors->any())
                openModal();
            @endif
        }

        document.querySelectorAll('.staff-toggle-btn').forEach(function (button) {
            button.addEventListener('click', async function (event) {
                event.preventDefault();

                const toggleUrl = this.getAttribute('data-toggle-url');
                const row = this.closest('tr');

                try {
                    const response = await fetch(toggleUrl, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                    });

                    const result = await response.json();

                    if (!response.ok || !result.success) {
                        alert(result.message || 'Gagal mengubah status akun.');
                        return;
                    }

                    const statusBadge = row.querySelector('.staff-status-badge');

                    if (result.is_active) {
                        statusBadge.classList.remove('ms-badge-nonaktif');
                        statusBadge.classList.add('ms-badge-aktif');
                        statusBadge.textContent = 'Aktif';
                        this.setAttribute('data-is-active', 'true');
                        this.innerHTML = `
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            Nonaktifkan
                        `;
                    } else {
                        statusBadge.classList.remove('ms-badge-aktif');
                        statusBadge.classList.add('ms-badge-nonaktif');
                        statusBadge.textContent = 'Tidak Aktif';
                        this.setAttribute('data-is-active', 'false');
                        this.innerHTML = `
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            Aktifkan
                        `;
                    }
                } catch (error) {
                    console.error('Gagal mengubah status:', error);
                    alert('Gagal mengubah status akun. Coba lagi.');
                }
            });
        });
    });
</script>