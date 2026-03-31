@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/settings/general_settings.css') }}">
@endpush

@php
    $submenu = request('submenu');
@endphp

@if ($submenu == 'Poli')
    @include('admin.components.settings.poli')
@elseif ($submenu == 'Guarantor')
    @include('admin.components.settings.guarantor')
@elseif ($submenu == 'Payment Method')
    @include('admin.components.settings.payment_method')
@else
    <h2 class="gs-title">General Settings</h2>

    <div class="gs-list">
        @foreach ([
            'Poli',
            'Guarantor',
            'Payment Method',
            'Visit Type',
            'Care Type',
            'Procedure',
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
            @php
                $isImplemented = in_array($item, ['Poli', 'Guarantor', 'Payment Method']);
                $href = $isImplemented ? "?menu=general-settings&submenu=$item" : "#";
            @endphp
            <a href="{{ $href }}" class="gs-item">
                <span class="gs-item-label">{{ $item }}</span>
                <svg class="gs-item-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M9 18l6-6-6-6"/>
                </svg>
            </a>
        @endforeach
    </div>
@endif
