@extends('admin.layout.admin')
@section('title', 'Profil')

@section('navbar')
    @include('admin.components.navbar', ['title' => 'Profil'])
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/pages/profile.css') }}">
@endpush

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
@endsection
