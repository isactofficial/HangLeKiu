@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/settings/general_settings.css') }}">
@endpush

@php
    $submenu = request('submenu');
@endphp

@if ($submenu == 'Testimonial')
    @include('admin.components.settings.testimonial')
@elseif ($submenu == 'Artikel')
    @include('admin.components.settings.artikel')
@elseif ($submenu == 'Partner Asuransi')
    @include('admin.components.settings.insurance_partner')
@else
    <h2 class="gs-title">Beranda Settings</h2>

    <div class="gs-list">
@foreach ([
            'Artikel',
            'Partner Asuransi',
            'Testimonial'
        ] as $item)
            @php
                $href = "?menu=beranda-settings&submenu={$item}";
            @endphp
            <a href="{{ $href }}" class="gs-item">
                <span class="gs-item-label">{{ $item }}</span>
                <svg class="gs-item-arrow" width="16" height="16" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M9 18l6-6-6-6"/>
                </svg>
            </a>
        @endforeach
    </div>
@endif

