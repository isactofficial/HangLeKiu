@extends('admin.layout.admin')
@section('title', 'Pesan')

@section('navbar')
    @include('admin.components.navbar', ['title' => 'Message Center'])
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/pages/messages.css') }}">
@endpush

@section('content')
{{-- Page Header --}}
<div class="mc-header">
    <h1 class="mc-title">Message Center</h1>
    <p class="mc-subtitle">hanglekiu dental specialist</p>
</div>

{{-- Content Layout: Tabs + Cards --}}
<div class="mc-layout">
    {{-- Left Tabs --}}
    <div class="mc-tabs">
        <button class="mc-tab active" onclick="switchTab(this, 'ikhtisar')">Ikhtisar</button>
        <button class="mc-tab" onclick="switchTab(this, 'sms')">Targeted SMS</button>
        <button class="mc-tab" onclick="switchTab(this, 'wa')">Notifikasi WA</button>
    </div>

    {{-- Right Content --}}
    <div class="mc-content">
        {{-- Tab: Ikhtisar --}}
        <div class="mc-tab-content active" id="tab-ikhtisar">
            {{-- SMS Row --}}
            <div class="mc-row">
                <div class="mc-card mc-card-info">
                    <h3 class="mc-card-title">Kredit SMS Tersisa</h3>
                    <p class="mc-card-desc">
                        Saat ini kredit sms kamu tersisa 0 SMS. Kamu dapat melakukan pengisian kredit sms untuk
                        menghindari gagalnya pengiriman sms.
                    </p>
                    <div class="mc-card-actions">
                        <button class="mc-btn mc-btn-primary">+ KREDIT SMS</button>
                        <button class="mc-btn mc-btn-outline">BUAT SMS →</button>
                    </div>
                </div>
                <div class="mc-card mc-card-stat">
                    <span class="mc-stat-number">0</span>
                    <h4 class="mc-stat-title">SMS Terkirim Bulan Ini</h4>
                    <p class="mc-stat-desc">Total sms yang berhasil terkirim bulan ini adalah 0 sms.</p>
                </div>
            </div>

            {{-- WhatsApp Row --}}
            <div class="mc-row">
                <div class="mc-card mc-card-info">
                    <h3 class="mc-card-title">Kredit Whatsapp Tersisa</h3>
                    <p class="mc-card-desc">
                        Saat ini kredit Whatsapp kamu tersisa 100. Kamu dapat melakukan pengisian kredit Whatsapp
                        untuk menghindari gagalnya pengiriman Whatsapp.
                    </p>
                    <div class="mc-card-actions">
                        <button class="mc-btn mc-btn-primary">+ KREDIT WHATSAPP</button>
                        <button class="mc-btn mc-btn-outline">STATUS NOTIFIKASI WHATSAPP →</button>
                    </div>
                </div>
                <div class="mc-card mc-card-stat">
                    <span class="mc-stat-number">0</span>
                    <h4 class="mc-stat-title">Pesan Whatsapp Terkirim Bulan Ini</h4>
                    <p class="mc-stat-desc">Total pesan Whatsapp yang berhasil terkirim bulan ini adalah 0 pesan.</p>
                </div>
            </div>
        </div>

        {{-- Tab: Targeted SMS --}}
        <div class="mc-tab-content" id="tab-sms">
            <div class="mc-card" style="padding: 40px; text-align: center;">
                <h3 class="mc-card-title">Targeted SMS</h3>
                <p class="mc-card-desc" style="margin-top: 8px;">Fitur pengiriman SMS tertarget. Halaman ini masih dalam pengembangan.</p>
            </div>
        </div>

        {{-- Tab: Notifikasi WA --}}
        <div class="mc-tab-content" id="tab-wa">
            <div class="mc-card" style="padding: 40px; text-align: center;">
                <h3 class="mc-card-title">Notifikasi WhatsApp</h3>
                <p class="mc-card-desc" style="margin-top: 8px;">Fitur notifikasi WhatsApp otomatis. Halaman ini masih dalam pengembangan.</p>
            </div>
        </div>
    </div>
</div>
<script>
    function switchTab(btn, tabId) {
        // Remove active from all tabs
        document.querySelectorAll('.mc-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.mc-tab-content').forEach(c => c.classList.remove('active'));

        // Activate clicked tab
        btn.classList.add('active');
        document.getElementById('tab-' + tabId).classList.add('active');
    }
</script>
@endsection
