@extends('admin.layout.admin')
@section('title', 'Pesan')

@section('navbar')
    @include('admin.components.navbar', ['title' => 'Message Center'])
@endsection

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

<style>
    /* ===== MESSAGE CENTER ===== */

    /* Header */
    .mc-header {
        margin-bottom: 20px;
    }

    .mc-title {
        font-size: 30px;
        font-weight: 700;
        color: #582C0C;
    }

    .mc-subtitle {
        font-size: 18.75px;
        color: #C58F59;
    }

    /* Layout */
    .mc-layout {
        display: flex;
        gap: 20px;
    }

    /* Tabs */
    .mc-tabs {
        display: flex;
        flex-direction: column;
        min-width: 160px;
        background: white;
        border-radius: 12px;
        padding: 6px;
        box-shadow: 0 1px 3px rgba(88, 44, 12, 0.06);
        height: fit-content;
    }

    .mc-tab {
        padding: 12px 16px;
        border: none;
        background: none;
        font-size: 14px;
        font-weight: 500;
        font-family: 'Instrument Sans', sans-serif;
        color: #6B513E;
        text-align: left;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .mc-tab:hover {
        background: rgba(197, 143, 89, 0.08);
    }

    .mc-tab.active {
        background: #C58F59;
        color: white;
        font-weight: 600;
    }

    /* Content */
    .mc-content {
        flex: 1;
    }

    .mc-tab-content {
        display: none;
    }

    .mc-tab-content.active {
        display: block;
    }

    /* Row */
    .mc-row {
        display: flex;
        gap: 16px;
        margin-bottom: 16px;
    }

    /* Cards */
    .mc-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(88, 44, 12, 0.06);
    }

    .mc-card-info {
        flex: 2;
    }

    .mc-card-stat {
        flex: 1;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .mc-card-title {
        font-size: 16px;
        font-weight: 700;
        color: #582C0C;
        margin: 0;
    }

    .mc-card-desc {
        font-size: 13px;
        color: #6B513E;
        line-height: 1.6;
        margin-top: 8px;
    }

    /* Card Actions */
    .mc-card-actions {
        display: flex;
        gap: 10px;
        margin-top: 18px;
    }

    .mc-btn {
        padding: 10px 20px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        font-family: 'Instrument Sans', sans-serif;
        cursor: pointer;
        transition: all 0.2s;
        letter-spacing: 0.5px;
    }

    .mc-btn-primary {
        background: #C58F59;
        color: white;
        border: none;
    }

    .mc-btn-primary:hover {
        background: #b07d4a;
        box-shadow: 0 4px 12px rgba(197, 143, 89, 0.3);
    }

    .mc-btn-outline {
        background: white;
        color: #582C0C;
        border: 1.5px solid #E5D6C5;
    }

    .mc-btn-outline:hover {
        border-color: #C58F59;
        background: rgba(197, 143, 89, 0.05);
    }

    /* Stat card */
    .mc-stat-number {
        font-size: 48px;
        font-weight: 700;
        color: #C58F59;
        line-height: 1;
    }

    .mc-stat-title {
        font-size: 14px;
        font-weight: 700;
        color: #582C0C;
        margin-top: 8px;
    }

    .mc-stat-desc {
        font-size: 12px;
        color: #6B513E;
        margin-top: 6px;
        line-height: 1.5;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .mc-layout {
            flex-direction: column;
        }

        .mc-tabs {
            flex-direction: row;
            min-width: 100%;
            justify-content: center;
            gap: 4px;
        }

        .mc-tab {
            flex: 1;
            text-align: center;
            padding: 10px 8px;
            font-size: 12px;
            white-space: normal;
        }

        .mc-row {
            flex-direction: column;
        }

        .mc-card-actions {
            flex-wrap: wrap;
        }

        .mc-btn {
            font-size: 11px;
            padding: 8px 14px;
        }
    }
</style>

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
