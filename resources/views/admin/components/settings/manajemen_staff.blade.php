@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/settings/manajemen_staff.css') }}">
    <style>
        /* ==========================================================================
           MODAL TAMBAH STAFF STYLING (Tema Cokelat/Emas)
           ========================================================================== */
        :root {
            --cream-50:  #fdf9f5;
            --cream-100: #f7f0e6;
            --cream-200: #ecdcca;
            --gold-300:  #d4a96a;
            --gold-400:  #C58F59;
            --gold-500:  #a97540;
            --brown-600: #7a4f28;
            --brown-700: #582C0C;
            --text-gray: #b09a85;
            --req-star:  #e05252;
            --transition: 0.2s ease-in-out;
        }

        .ts-modal-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 20px;
        }
        .ts-modal-overlay.show { display: flex; }

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

        /* Header */
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
        .ts-close-btn:hover { color: var(--req-star); }

        /* Body & Grid */
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
        @media(max-width: 640px) {
            .ts-grid-2 { grid-template-columns: 1fr; gap: 16px; }
        }

        /* Form Groups & Inputs */
        .ts-form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .ts-form-group.full { margin-bottom: 20px; }
        .ts-label {
            font-size: 14px;
            font-weight: 600;
            color: var(--brown-700);
        }
        .ts-label span { color: var(--req-star); }
        
        .ts-input, .ts-select {
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
        .ts-input::placeholder { color: #cbbdad; }
        .ts-input:focus, .ts-select:focus { border-color: var(--gold-400); }
        
        .ts-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%23582C0C' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round' xmlns='http://www.w3.org/2000/svg'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            cursor: pointer;
        }

        /* Custom Checkbox & Toggle Section */
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

        /* Custom Toggle Switch */
        .ts-toggle-switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
            flex-shrink: 0;
            margin-top: 2px;
        }
        .ts-toggle-switch input { opacity: 0; width: 0; height: 0; }
        .ts-slider {
            position: absolute;
            cursor: pointer;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: var(--cream-200);
            transition: .3s;
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
            transition: .3s;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .ts-toggle-switch input:checked + .ts-slider { background-color: var(--gold-400); }
        .ts-toggle-switch input:checked + .ts-slider:before { transform: translateX(20px); }

        /* Footer */
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
        .ts-btn-primary:hover { background: var(--gold-500); }
    </style>
@endpush

{{-- resources/views/admin/settings/manajemen_staff.blade.php --}}
<div class="ms-header-row">
    <div>
        <h2 class="ms-title">Manajemen Staff</h2>
        <p class="ms-subtitle">Last Update: 17 Desember 2024 (13:50 WIB)</p>
    </div>
    <div class="ms-actions-row">
        <div class="ms-btn-group">
            <button class="ms-btn-primary" id="ms-open-doctor-modal">Tambah Akun</button>
            <button class="ms-btn-group-item">Tidak Aktif</button>
        </div>
    </div>
</div>

@if (session('success'))
    <div class="ms-alert ms-alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->has('doctor_create') || $errors->any())
    <div class="ms-alert ms-alert-error">
        {{ $errors->first('doctor_create') ?: 'Periksa kembali form tambah staff.' }}
    </div>
@endif

{{-- MODAL TAMBAH STAFF (Refactored) --}}
<div id="ms-doctor-modal" class="ts-modal-overlay" aria-hidden="true">
    <div class="ts-modal-content" role="dialog" aria-modal="true">
        
        <div class="ts-modal-header">
            <h3>Tambah Staff</h3>
            <button type="button" class="ts-close-btn" id="ms-close-doctor-modal" aria-label="Tutup">&times;</button>
        </div>

        <form method="POST" action="{{ route('admin.settings.staff.doctor.store') }}">
            @csrf
            
            <div class="ts-modal-body">
                {{-- Row 1: Nama Lengkap --}}
                <div class="ts-form-group full">
                    <label class="ts-label" for="full_name">Nama Lengkap <span>*</span></label>
                    <input class="ts-input" id="full_name" name="full_name" type="text" placeholder="Nama Lengkap" required>
                </div>

                {{-- Row 2: Jabatan & Tipe Akses --}}
                <div class="ts-grid-2">
                    <div class="ts-form-group">
                        <label class="ts-label" for="job_title">Jabatan <span>*</span></label>
                        <input class="ts-input" id="job_title" name="job_title" type="text" placeholder="Jabatan" required>
                    </div>
                    <div class="ts-form-group">
                        <label class="ts-label" for="access_type">Tipe Akses <span>*</span></label>
                        <select class="ts-select" id="access_type" name="access_type" required>
                            <option value="" disabled selected>Pilih Tipe Akses</option>
                            <option value="owner">Owner</option>
                            <option value="doctor">Doctor</option>
                            <option value="staff">Staff</option>
                        </select>
                    </div>
                </div>

                {{-- Row 3: Alamat Email & Nomor HP --}}
                <div class="ts-grid-2">
                    <div class="ts-form-group">
                        <label class="ts-label" for="email">Alamat Email <span>*</span></label>
                        <input class="ts-input" id="email" name="email" type="email" placeholder="Alamat Email" required>
                    </div>
                    <div class="ts-form-group">
                        <label class="ts-label" for="phone">Nomor Hp <span>*</span></label>
                        <input class="ts-input" id="phone" name="phone" type="text" placeholder="Nomor Hp" required>
                    </div>
                </div>

                {{-- Row 4: Nomor Pegawai & Catatan --}}
                <div class="ts-grid-2">
                    <div class="ts-form-group">
                        <label class="ts-label" for="employee_id">Nomor Pegawai</label>
                        <input class="ts-input" id="employee_id" name="employee_id" type="text" placeholder="Nomor Pegawai">
                    </div>
                    <div class="ts-form-group">
                        <label class="ts-label" for="notes">Catatan</label>
                        <input class="ts-input" id="notes" name="notes" type="text" placeholder="Catatan">
                    </div>
                </div>

                {{-- Row 5: Checkbox PIC & Toggle Status Aktif --}}
                <div class="ts-grid-2" style="margin-top: 12px; margin-bottom: 0;">
                    
                    {{-- Checkbox PIC --}}
                    <label class="ts-control-wrapper" style="cursor: pointer;">
                        <div class="ts-control-left">
                            <input type="checkbox" class="ts-checkbox" name="is_pic" value="1">
                            <div class="ts-control-text">
                                <strong>Tetapkan staff sebagai PIC</strong>
                                <span>Staff akan ditetapkan sebagai PIC</span>
                            </div>
                        </div>
                    </label>

                    {{-- Toggle Status --}}
                    <label class="ts-control-wrapper" style="cursor: pointer;">
                        <div class="ts-control-left">
                            <div class="ts-control-text">
                                <strong>Status Staff Aktif</strong>
                                <span>Staff dapat login dan mengakses sistem</span>
                            </div>
                        </div>
                        <div class="ts-toggle-switch">
                            <input type="checkbox" name="is_active" value="1" checked>
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
{{-- END MODAL --}}


{{-- SISA KODE BAWAAN HALAMAN (Search, Table, Pagination) --}}
<div class="ms-actions-row">
    <div class="ms-search-box">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6B513E" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
        <input type="text" placeholder="Cari staff">
    </div>
    <button class="ms-btn-filter">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="6" x2="16" y2="6"/><line x1="8" y1="12" x2="20" y2="12"/><line x1="4" y1="18" x2="12" y2="18"/></svg>
        Filter
    </button>
</div>

<script>
    // Script Modals yang sudah disederhanakan
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('ms-doctor-modal');
        const openBtn = document.getElementById('ms-open-doctor-modal');
        const closeBtn = document.getElementById('ms-close-doctor-modal');

        if (!modal || !openBtn) return;

        const openModal = () => {
            modal.classList.add('show');
            document.body.style.overflow = 'hidden'; // Mencegah scroll di background
        };

        const closeModal = () => {
            modal.classList.remove('show');
            document.body.style.overflow = '';
        };

        openBtn.addEventListener('click', openModal);
        if (closeBtn) closeBtn.addEventListener('click', closeModal);

        // Tutup modal jika klik area luar modal (overlay)
        modal.addEventListener('click', (event) => {
            if (event.target === modal) closeModal();
        });

        // Tutup modal jika tekan tombol ESC
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && modal.classList.contains('show')) {
                closeModal();
            }
        });

        // Tampilkan modal jika ada error saat disubmit (dari validasi Laravel)
        @if($errors->has('doctor_create') || $errors->any())
            openModal();
        @endif
    });
</script>

<div class="ms-table-card">
    <div class="ms-table-wrapper">
        <table class="ms-table">
            <thead>
                <tr>
                    <th><span class="sort">↑↓ Nama</span></th>
                    <th><span class="sort">↑↓ Status</span></th>
                    <th><span class="sort">↑↓ Tipe Akses</span></th>
                    <th>Nomor HP</th>
                    <th>Login Email</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>dinda tegar jelita</td>
                    <td><span class="ms-badge-aktif">Aktif</span></td>
                    <td>Owner</td>
                    <td>**********355</td>
                    <td>**********...</td>
                    <td>
                        <div class="ms-action-row">
                            <button class="ms-icon-btn" title="Edit">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            <button class="ms-kebab-btn" title="More">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="5" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="12" cy="19" r="1.5"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>drg. Maya Sp.Perio</td>
                    <td><span class="ms-badge-aktif">Aktif</span></td>
                    <td>Doctor</td>
                    <td>**********43</td>
                    <td>**********...</td>
                    <td>
                        <div class="ms-action-row">
                            <button class="ms-icon-btn" title="Edit">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            <button class="ms-kebab-btn" title="More">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="5" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="12" cy="19" r="1.5"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>drg. Ria Budiati Sp.Ortho</td>
                    <td><span class="ms-badge-aktif">Aktif</span></td>
                    <td>Owner</td>
                    <td>**********244</td>
                    <td>**********...</td>
                    <td>
                        <div class="ms-action-row">
                            <button class="ms-icon-btn" title="Edit">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            <button class="ms-kebab-btn" title="More">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="5" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="12" cy="19" r="1.5"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Sonia Novitasari</td>
                    <td><span class="ms-badge-aktif">Aktif</span></td>
                    <td>Owner</td>
                    <td>**********3039</td>
                    <td>**********...</td>
                    <td>
                        <div class="ms-action-row">
                            <button class="ms-icon-btn" title="Edit">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            <button class="ms-kebab-btn" title="More">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="5" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="12" cy="19" r="1.5"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="ms-pagination">
        <div class="ms-page-size">Jumlah baris per halaman: <select><option>5</option><option>10</option><option>25</option></select></div>
        <div class="ms-page-info">1–4 dari 4 data</div>
        <div class="ms-page-controls">
            <button class="ms-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 17l-5-5 5-5M18 17l-5-5 5-5"/></svg></button>
            <button class="ms-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg></button>
            <button class="ms-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg></button>
            <button class="ms-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M13 17l5-5-5-5M6 17l5-5-5-5"/></svg></button>
        </div>
    </div>
</div>