@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/office/akun.css') }}">
@endpush

{{-- resources/views/admin/office/akun.blade.php --}}
<div class="akun-toolbar">
    <button class="akun-btn-edit">EDIT AKUN</button>
    <div class="akun-date-row">
        <input type="text" class="akun-date-input" value="01/03/2026">
        <span class="akun-sep">-</span>
        <input type="text" class="akun-date-input" value="31/03/2026">
        <button class="akun-btn-refresh">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 4v6h-6M1 20v-6h6"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
        </button>
    </div>
</div>

<div class="akun-cards-row">
    <div class="akun-card">
        <p class="akun-card-name">Kas</p>
        <p class="akun-card-total">Rp246.150.000</p>
        <p class="akun-card-detail">
            <span class="plus">+Rp3.600.000</span>
            /
            <span class="minus">-Rp0</span>
        </p>
    </div>
    <div class="akun-card">
        <p class="akun-card-name">Cover BPJS</p>
        <p class="akun-card-total">Rp0</p>
        <p class="akun-card-detail">
            <span class="plus">+Rp0</span>
            /
            <span class="minus">-Rp0</span>
        </p>
    </div>
</div>

{{-- Area Chart (static illustration) --}}
<div class="akun-chart-wrap">
    <div class="akun-chart-inner">

        {{-- Y gridlines --}}
        <div class="akun-y">
            <span>0%</span>
            <span>25%</span>
            <span>50%</span>
            <span>75%</span>
            <span>100%</span>
        </div>
        <div class="akun-plot">
            <div class="akun-gridline" style="bottom:0%;"></div>
            <div class="akun-gridline" style="bottom:25%;"></div>
            <div class="akun-gridline" style="bottom:50%;"></div>
            <div class="akun-gridline" style="bottom:75%;"></div>
            <div class="akun-gridline" style="bottom:100%;"></div>

            {{-- Filled area --}}
            <div class="akun-area-fill"></div>
        </div>

        {{-- X axis --}}
        <div class="akun-x">
            <span>March 25</span>
            <span>April 25</span>
            <span>May 25</span>
            <span>June 25</span>
            <span>July 25</span>
            <span>September 25</span>
            <span>November 25</span>
            <span>January 26</span>
            <span>March 26</span>
        </div>

    </div>
</div>
