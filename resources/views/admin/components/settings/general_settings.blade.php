@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/settings/general_settings.css') }}">
@endpush


<h2 class="gs-title">General Settings</h2>

<div class="gs-list">
    @foreach ([
        'Bridging Satu Sehat',
        'Bridging Badung Sehat',
        'Bridging BPJS',
        'Bridging Antrean Online',
        'Rawat Jalan',
        'EMR',
        'Apotek',
        'Kasir',
        'Tooltip',
        'Message Center',
        'Manajemen Approval',
        'Reset Data',
        'Notifikasi',
        'Data Masking',
        'Ubah Bahasa',
        'Manajemen Password',
    ] as $item)
        <a href="#" class="gs-item">
            <span class="gs-item-label">{{ $item }}</span>
            <svg class="gs-item-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M9 18l6-6-6-6"/>
            </svg>
        </a>
    @endforeach
</div>
