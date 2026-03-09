@extends('admin.layout.admin')
@section('title', 'Profil')

@section('navbar')
    @include('admin.components.navbar', ['title' => 'Profil'])
@endsection

@section('content')
{{-- Page Header --}}
<div class="profile-header">
    <h1 class="profile-title">Profile</h1>
    <p class="profile-subtitle">hanglekiu dental specialist</p>
</div>

{{-- Profile Completion Card --}}
<div class="profile-card">
    {{-- Left: Illustration --}}
    <div class="profile-card-illustration">
        <img src="/images/profile-illustration.png" alt="Ilustrasi Profil">
    </div>

    {{-- Right: Info --}}
    <div class="profile-card-info">
        <h2 class="profile-card-title">Pastikan Faskes Anda Ditemukan Masyarakat Indonesia</h2>

        <p class="profile-card-label">Informasi Fasilitas Kesehatan</p>
        <p class="profile-card-desc">
            Kelengkapan informasi faskes Anda mempengaruhi kepercayaan dan kemudahan pasien untuk menemukan Anda.
        </p>

        {{-- Progress Bar --}}
        <div class="profile-progress-bar">
            <div class="profile-progress-fill" style="width: 71%"></div>
        </div>
        <p class="profile-progress-text">Kelengkapan profil Anda <strong>71%</strong></p>

        {{-- Edit Button --}}
        <div class="profile-card-action">
            <a href="#" class="profile-edit-btn">Edit</a>
        </div>
    </div>
</div>

<style>
    /* ===== PROFILE PAGE ===== */

    /* Header */
    .profile-header {
        margin-bottom: 20px;
    }

    .profile-title {
        font-size: 30px;
        font-weight: 700;
        color: #582C0C;
    }

    .profile-subtitle {
        font-size: 18.75px;
        color: #C58F59;
    }

    /* Profile Card */
    .profile-card {
        display: flex;
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(88, 44, 12, 0.06);
    }

    /* Illustration */
    .profile-card-illustration {
        flex: 0 0 420px;
        background: #f0ebe4;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 32px;
    }

    .profile-card-illustration img {
        width: 100%;
        height: auto;
        max-height: 280px;
        object-fit: contain;
        border-radius: 12px;
    }

    /* Info side */
    .profile-card-info {
        flex: 1;
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .profile-card-title {
        font-size: 26px;
        font-weight: 700;
        color: #582C0C;
        line-height: 1.3;
        margin: 0 0 20px 0;
    }

    .profile-card-label {
        font-size: 13px;
        color: #C58F59;
        font-weight: 500;
        margin: 0 0 6px 0;
    }

    .profile-card-desc {
        font-size: 14px;
        color: #6B513E;
        line-height: 1.6;
        margin: 0 0 20px 0;
    }

    /* Progress Bar */
    .profile-progress-bar {
        width: 100%;
        height: 14px;
        background: #E5D6C5;
        border-radius: 10px;
        overflow: hidden;
    }

    .profile-progress-fill {
        height: 100%;
        background: linear-gradient(135deg, #C58F59 0%, #6B513E 100%);
        border-radius: 10px;
        transition: width 0.6s ease;
    }

    .profile-progress-text {
        font-size: 13px;
        color: #6B513E;
        margin-top: 10px;
    }

    .profile-progress-text strong {
        color: #582C0C;
    }

    /* Edit Button */
    .profile-card-action {
        display: flex;
        justify-content: flex-end;
        margin-top: 16px;
    }

    .profile-edit-btn {
        display: inline-block;
        padding: 10px 28px;
        background: #C58F59;
        color: white;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        font-family: 'Instrument Sans', sans-serif;
        text-decoration: none;
        transition: all 0.2s;
    }

    .profile-edit-btn:hover {
        background: #b07d4a;
        box-shadow: 0 4px 12px rgba(197, 143, 89, 0.3);
        transform: translateY(-1px);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .profile-card {
            flex-direction: column;
        }

        .profile-card-illustration {
            flex: none;
            padding: 24px;
        }

        .profile-card-info {
            padding: 28px;
        }

        .profile-card-title {
            font-size: 22px;
        }
    }
</style>
@endsection
