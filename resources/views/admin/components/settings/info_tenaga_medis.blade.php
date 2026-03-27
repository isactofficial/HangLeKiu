@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/settings/info_tenaga_medis.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/components/settings/manajemen_staff.css') }}">
@endpush

{{-- resources/views/admin/settings/info_tenaga_medis.blade.php --}}
<div class="itm-toolbar">
    <div class="itm-search-box">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#6B513E" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
        <input type="text" placeholder="Search Name, STR or SIP">
    </div>
    <button class="itm-btn-filter">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="6" x2="16" y2="6"/><line x1="8" y1="12" x2="20" y2="12"/><line x1="4" y1="18" x2="12" y2="18"/></svg>
        FILTER
    </button>
    <button class="itm-btn-tambah" type="button" id="ms-open-doctor-modal">
        + TAMBAH DATA TENAGA MEDIS
    </button>
</div>

@include('admin.components.settings.partials.doctor_form_modal')

<div class="itm-grid">

    @foreach ([
        ['drg. Dinda Tegar Jelita Sp.Ortho', 'Dokter Gigi'],
        ['drg. Ria Budiati Sp. Ortho',       'Dokter Gigi Spesialis Ortodonsia'],
        ['DR. drg. Wenny Yulvie Sp.BM',      'Dokter Gigi Spesialis Bedah Mulut'],
        ['drg. Aditya Putra',                'Dokter Gigi Umum'],
        ['drg . MAY Lewerissa Sp.Perio',     'Dokter Gigi Spesialis Periodonsia'],
        ['drg. Fanny Arditya M. Sp.Prost',   'Dokter Gigi Spesialis Prostodensia'],
    ] as [$name, $role])
        <div>
            <div class="itm-card">
                <div class="itm-photo">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <path d="M8.5 12.5 L12 8 L15.5 12.5"/>
                        <circle cx="9" cy="9" r="1"/>
                    </svg>
                </div>
                <div class="itm-info">
                    <p class="itm-name">{{ $name }}</p>
                    <p class="itm-role">{{ $role }}</p>
                    <a href="#" class="itm-show-more">Show More</a>
                    <div>
                        <button class="itm-btn-edit">
                            EDIT PROFIL
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

</div>
