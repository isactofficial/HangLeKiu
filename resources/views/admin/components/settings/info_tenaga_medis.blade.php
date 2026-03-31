@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/settings/info_tenaga_medis.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/components/settings/manajemen_staff.css') }}">
    <style>
        /* Tambahan CSS agar transisi pencarian halus */
        .doctor-card-wrapper {
            transition: all 0.3s ease;
        }
        .itm-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .no-data-info {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px;
            background: #fdfaf8;
            border-radius: 12px;
            border: 2px dashed #e2d9d2;
            color: #8A6B52;
        }
    </style>
@endpush

{{-- resources/views/admin/settings/info_tenaga_medis.blade.php --}}
<div class="itm-toolbar">
    <div class="itm-search-box">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#6B513E" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
        {{-- ID untuk pencarian --}}
        <input type="text" id="itm-search-input" placeholder="Search Name, STR or SIP">
    </div>
    <button class="itm-btn-filter">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="6" x2="16" y2="6"/><line x1="8" y1="12" x2="20" y2="12"/><line x1="4" y1="18" x2="12" y2="18"/></svg>
        FILTER
    </button>
    <button class="itm-btn-tambah" type="button" id="ms-open-doctor-modal">
        + TAMBAH TENAGA MEDIS
    </button>
</div>

{{-- Modal form tetap di-include --}}
@include('admin.components.settings.partials.doctor_form_modal')

<div class="itm-grid" id="doctor-grid">
    {{-- Membaca data asli dari variabel $doctors --}}
    @forelse ($doctors as $doctor)
        <div class="doctor-card-wrapper" 
             data-name="{{ strtolower($doctor->full_name) }}" 
             data-str="{{ strtolower($doctor->str_number) }}" 
             data-sip="{{ strtolower($doctor->sip_number) }}">
            <div class="itm-card">
                <div class="itm-photo">
                    @if($doctor->foto_profil)
                        <img src="{{ asset('storage/' . $doctor->foto_profil) }}" alt="{{ $doctor->full_name }}">
                    @else
                        {{-- Fallback jika tidak ada foto --}}
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#C58F59" stroke-width="1.5">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <path d="M8.5 12.5 L12 8 L15.5 12.5"/>
                            <circle cx="9" cy="9" r="1"/>
                        </svg>
                    @endif
                </div>
                <div class="itm-info">
                    {{-- Menampilkan Nama Lengkap dengan Gelar Depan jika ada --}}
                    <p class="itm-name">
                        {{ $doctor->title_prefix ? $doctor->title_prefix . ' ' : '' }}{{ $doctor->full_name }}
                    </p>
                    
                    {{-- Menampilkan Jabatan atau Spesialisasi --}}
                    <p class="itm-role">
                        {{ $doctor->job_title ?: ($doctor->specialization ?: 'Tenaga Medis') }}
                    </p>
                    
                    <a href="javascript:void(0)" class="itm-show-more" onclick="openShowModal('{{ $doctor->id }}')">
                        Show More
                    </a>
                    <div>
                        {{-- Menggunakan type="button" untuk mencegah submit form tidak sengaja --}}
                        <button type="button" 
                                class="itm-btn-edit" 
                                onclick="openEditModal('{{ $doctor->id }}')"
                                style="cursor: pointer;">
                            <i class="fa fa-edit" style="margin-right: 5px;"></i> EDIT PROFIL
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @empty
        {{-- State jika data kosong --}}
        <div class="no-data-info">
            <i class="fa fa-user-md-slash" style="font-size: 32px; margin-bottom: 10px; display: block;"></i>
            <p>Belum ada data tenaga medis tercatat.</p>
        </div>
    @endforelse
</div>


@include('admin.components.settings.partials.doctor_show_modal')
@include('admin.components.settings.partials.doctor_edit_modal')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('itm-search-input');
        const doctorCards = document.querySelectorAll('.doctor-card-wrapper');

        // Fitur Pencarian Real-time
        searchInput.addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase();

            doctorCards.forEach(card => {
                const name = card.getAttribute('data-name');
                const str = card.getAttribute('data-str');
                const sip = card.getAttribute('data-sip');

                if (name.includes(term) || str.includes(term) || sip.includes(term)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

</script>