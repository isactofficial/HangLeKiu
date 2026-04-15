<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    @vite('resources/css/app.css')
    <style>
        .brand-surface {
            background:
                radial-gradient(circle at 8% 12%, rgba(255, 255, 255, 0.24) 0, rgba(255, 255, 255, 0) 28%),
                radial-gradient(circle at 92% 86%, rgba(255, 255, 255, 0.18) 0, rgba(255, 255, 255, 0) 30%),
                linear-gradient(135deg, #6b513e 0%, #582c0c 100%);
        }

        .dash-card {
            border: 1px solid color-mix(in srgb, var(--color-primary) 22%, white);
            box-shadow: 0 14px 30px rgba(88, 44, 12, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .dash-card:hover {
            box-shadow: 0 20px 40px rgba(88, 44, 12, 0.12);
        }

        .soft-panel {
            background: color-mix(in srgb, var(--color-primary) 8%, white);
            border: 1px solid color-mix(in srgb, var(--color-primary) 20%, white);
        }

        .avatar-ring {
            box-shadow: 0 0 0 4px white, 0 0 0 6px color-mix(in srgb, var(--color-primary) 30%, transparent);
        }

        .field-label {
            display: block;
            margin-bottom: 0.375rem;
            font-size: 0.8125rem;
            font-weight: 700;
            color: var(--font-color-primary);
        }

        .field-input {
            width: 100%;
            border-radius: 0.75rem;
            border-color: #d9c3ae;
            background: #f8fafc;
            font-size: 0.9375rem;
            font-weight: 500;
        }

        .field-input:focus {
            border-color: var(--color-primary);
            --tw-ring-color: var(--color-primary);
            background: #ffffff;
        }

        .profile-item {
            background: color-mix(in srgb, var(--color-primary) 7%, white);
            border: 1px solid color-mix(in srgb, var(--color-primary) 20%, white);
            border-radius: 1rem;
            padding: 0.9rem 1rem;
        }

        .profile-item-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 700;
            color: var(--font-color-secondary);
            margin-bottom: 0.2rem;
        }

        .profile-item-value {
            font-size: 0.92rem;
            font-weight: 600;
            color: var(--font-color-primary);
            line-height: 1.35;
        }

        .modal-scroll {
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            touch-action: pan-y;
        }
    </style>
</head>

<body class="bg-[var(--color-background-primary)] text-[var(--font-color-primary)] flex flex-col min-h-screen font-sans">
    @include('user.components.navbarWelcome')

    <div id="navbarSpacer" class="h-0"></div>

    <main class="grow pb-12">

        <section class="container mx-auto px-5 sm:px-10 lg:px-16 xl:px-24 py-8 relative z-20">
            @if(session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800 shadow-sm flex items-start gap-3">
                    <svg class="w-6 h-6 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-800 shadow-sm flex items-start gap-3">
                    <svg class="w-6 h-6 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <p class="font-bold mb-1">Terjadi kesalahan:</p>
                        <ul class="list-disc pl-5 text-sm space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-x-8 gap-y-12">
                <div class="xl:col-span-2">
                    @if($isIncompleteProfile ?? false)
                        <div class="bg-amber-50 border-l-4 border-amber-400 p-6 rounded-2xl mb-8 shadow-sm flex items-start gap-4">
                            <div class="bg-amber-100 p-2 rounded-full">
                                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-bold text-amber-800 uppercase tracking-wider mb-1">Lengkapi Profil Anda</h3>
                                <p class="text-amber-700 text-sm leading-relaxed">Selamat datang! Untuk kenyamanan pendaftaran kunjungan, mohon lengkapi data No. WhatsApp, Tanggal Lahir, dan Jenis Kelamin Anda.</p>
                                <button type="button" onclick="document.getElementById('openEditAccountModal').click()" class="mt-3 text-sm font-bold text-amber-800 hover:text-amber-900 flex items-center gap-1 transition">
                                    Lengkapi Sekarang <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                </button>
                            </div>
                        </div>
                    @endif

                    {{-- PROFIL PASIEN --}}
                    <div id="profil-pasien" class="dash-card bg-white rounded-3xl overflow-hidden relative mb-10">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-[#F4E9DF] to-transparent opacity-40 rounded-bl-full pointer-events-none"></div>
                        
                        <div class="px-8 lg:px-10 py-6 border-b border-[#EFE3D7]/60 flex items-center justify-between gap-4 relative z-10">
                            <h2 class="text-xl font-bold text-[var(--font-color-primary)] flex items-center gap-2">
                                <svg class="w-6 h-6 text-[var(--color-primary)] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                </svg>
                                <span class="truncate">Informasi Pasien</span>
                            </h2>
                            
                            <button id="openEditAccountModal" type="button" class="shrink-0 px-4 py-2 rounded-lg bg-[var(--font-color-primary)] hover:bg-[var(--color-primary)] text-white font-medium transition text-xs shadow-sm flex items-center gap-1.5 whitespace-nowrap">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Edit Profil
                            </button>
                        </div>
                        
                        <div class="p-8 lg:p-10 relative z-10">
                            <div class="flex flex-col md:flex-row items-center md:items-start gap-8 pb-8 md:pl-2">
                                <div class="relative w-28 h-28 shrink-0">
                                    <div class="w-full h-full rounded-full avatar-ring overflow-hidden bg-slate-100 flex items-center justify-center">
                                        @if(!empty($patient->photo))
                                            <img src="{{ $patient->photo }}" alt="Foto {{ $patient->full_name }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-4xl font-bold text-slate-400 uppercase">{{ substr($patient->full_name ?? $user->name, 0, 1) }}</span>
                                        @endif
                                    </div>
                                    @if($patient?->gender == 'Male')
                                        <div class="absolute bottom-0 right-0 bg-blue-500 w-8 h-8 rounded-full border-2 border-white flex items-center justify-center text-white" title="Laki-laki">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a2 2 0 012 2v2.58l4.5 4.5V9a1 1 0 112 0v6a1 1 0 11-2 0v-2.58l-4.5-4.5V12a2 2 0 01-4 0v-1.58l-4.5 4.5V15a1 1 0 11-2 0V9a1 1 0 112 0v2.58l4.5-4.5V4a2 2 0 012-2z"></path></svg>
                                        </div>
                                    @elseif($patient?->gender == 'Female')
                                        <div class="absolute bottom-0 right-0 bg-pink-500 w-8 h-8 rounded-full border-2 border-white flex items-center justify-center text-white" title="Perempuan">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21a2 2 0 01-2-2v-3.58l-4.5-4.5V13a1 1 0 11-2 0V7a1 1 0 112 0v1.58l4.5 4.5V15a2 2 0 014 0v-1.58l4.5-4.5V7a1 1 0 112 0v6a1 1 0 11-2 0v-2.08l-4.5 4.5V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="text-center md:text-left flex-1 mt-2">
                                    <h3 class="text-2xl font-extrabold text-[var(--font-color-primary)] mb-1">{{ $patient->full_name ?? $user->name }}</h3>
                                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 text-[var(--font-color-secondary)] font-medium mb-3">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                            RM: {{ $patient->medical_record_no ?? 'Belum Tersedia' }}
                                        </span>
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-300 hidden md:block"></span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            NIK: {{ $patient->id_card_number ?? '-' }}
                                        </span>
                                    </div>
                                
                                </div>
                            </div>

                            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6 text-sm md:pl-2">
                                <div class="profile-item">
                                    <p class="profile-item-label text-[var(--font-color-secondary)] font-medium mb-1">Email</p>
                                    <p class="profile-item-value truncate font-semibold text-[var(--font-color-primary)]">{{ $user->email }}</p>
                                </div>
                                <div class="profile-item">
                                    <p class="profile-item-label text-[var(--font-color-secondary)] font-medium mb-1">No. WhatsApp</p>
                                    <p class="profile-item-value font-semibold text-[var(--font-color-primary)]">{{ $patient->phone_number ?? '-' }}</p>
                                </div>
                                <div class="profile-item">
                                    <p class="profile-item-label text-[var(--font-color-secondary)] font-medium mb-1">Tanggal Lahir</p>
                                    <p class="profile-item-value font-semibold text-[var(--font-color-primary)]">{{ $patient?->date_of_birth ? $patient->date_of_birth->format('d M Y') : '-' }}</p>
                                </div>
                                <div class="profile-item">
                                    <p class="profile-item-label text-[var(--font-color-secondary)] font-medium mb-1">Jenis Kelamin</p>
                                    <p class="profile-item-value font-semibold text-[var(--font-color-primary)]">{{ $patient->gender ?? '-' }}</p>
                                </div>
                            </div>

                            <div id="patientMoreDetails" class="hidden mt-8 grid grid-cols-1 md:grid-cols-2 gap-6 text-sm md:pl-2">
                                <div class="profile-item">
                                    <p class="profile-item-label text-[var(--font-color-secondary)] font-medium mb-1">Golongan Darah / Rhesus</p>
                                    <p class="profile-item-value font-semibold text-[var(--font-color-primary)]">{{ $patient->blood_type ?? '-' }} / {{ $patient->rhesus ?? '-' }}</p>
                                </div>
                                <div class="profile-item">
                                    <p class="profile-item-label text-[var(--font-color-secondary)] font-medium mb-1">NIK</p>
                                    <p class="profile-item-value font-semibold text-[var(--font-color-primary)]">{{ $patient->id_card_number ?? '-' }}</p>
                                </div>
                                <div class="profile-item">
                                    <p class="profile-item-label text-[var(--font-color-secondary)] font-medium mb-1">Kota</p>
                                    <p class="profile-item-value font-semibold text-[var(--font-color-primary)]">{{ $patient->city ?? '-' }}</p>
                                </div>
                                <div class="profile-item">
                                    <p class="profile-item-label text-[var(--font-color-secondary)] font-medium mb-1">Agama</p>
                                    <p class="profile-item-value font-semibold text-[var(--font-color-primary)]">{{ $patient->religion ?? '-' }}</p>
                                </div>
                                <div class="profile-item">
                                    <p class="profile-item-label text-[var(--font-color-secondary)] font-medium mb-1">Pendidikan</p>
                                    <p class="profile-item-value font-semibold text-[var(--font-color-primary)]">{{ $patient->education ?? '-' }}</p>
                                </div>
                                <div class="profile-item">
                                    <p class="profile-item-label text-[var(--font-color-secondary)] font-medium mb-1">Pekerjaan</p>
                                    <p class="profile-item-value font-semibold text-[var(--font-color-primary)]">{{ $patient->occupation ?? '-' }}</p>
                                </div>
                                <div class="profile-item">
                                    <p class="profile-item-label text-[var(--font-color-secondary)] font-medium mb-1">Status Pernikahan</p>
                                    <p class="profile-item-value font-semibold text-[var(--font-color-primary)]">{{ $patient->marital_status ?? '-' }}</p>
                                </div>
                                <div class="profile-item">
                                    <p class="profile-item-label text-[var(--font-color-secondary)] font-medium mb-1">First Chat Date</p>
                                    <p class="profile-item-value font-semibold text-[var(--font-color-primary)]">{{ $patient?->first_chat_date ? $patient->first_chat_date->format('d M Y') : '-' }}</p>
                                </div>
                                <div class="profile-item md:col-span-2">
                                    <p class="profile-item-label text-[var(--font-color-secondary)] font-medium mb-1">Alamat</p>
                                    <p class="profile-item-value font-semibold text-[var(--font-color-primary)]">{{ $patient->address ?? '-' }}</p>
                                </div>
                                <div class="profile-item md:col-span-2">
                                    <p class="profile-item-label text-[var(--font-color-secondary)] font-medium mb-1">Riwayat Alergi</p>
                                    <p class="profile-item-value font-semibold text-[var(--font-color-primary)]">{{ $patient->allergy_history ?? '-' }}</p>
                                </div>
                            </div>

                            <button id="togglePatientDetails" type="button" class="mt-8 md:ml-2 inline-flex items-center gap-1.5 text-sm font-semibold text-[var(--color-primary)] hover:text-[var(--font-color-primary)] transition">
                                Lihat Lebih Banyak Data
                                <svg class="w-4 h-4 transition-transform duration-200" id="toggleIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div class="dash-card bg-white rounded-3xl overflow-hidden mb-10 relative">
                        <div class="px-8 lg:px-10 py-6 border-b border-[#EFE3D7]/60 flex items-center justify-between gap-4 relative z-10">
                        <h2 class="text-xl font-bold text-[var(--font-color-primary)] flex items-center gap-2">
                            <svg class="w-6 h-6 text-[var(--color-primary)] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <span class="truncate">Daftar Kunjungan</span>
                        </h2>
                        
                        <button id="openVisitModal" type="button" class="shrink-0 px-4 py-2 rounded-lg bg-[var(--font-color-primary)] hover:brightness-110 text-white font-medium transition text-xs shadow-sm flex items-center gap-1.5 whitespace-nowrap">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Kunjungan
                        </button>
                    </div>

                        <div class="p-8 lg:p-10 relative z-10">
                            @php
                                $statusFormat = [
                                    'pending'   => ['bg-amber-100', 'text-amber-800', 'Menunggu'],
                                    'confirmed' => ['bg-blue-100', 'text-blue-800', 'Terkonfirmasi'],
                                    'waiting'   => ['bg-indigo-100', 'text-indigo-800', 'Dalam Antrean'],
                                    'engaged'   => ['bg-cyan-100', 'text-cyan-800', 'Sedang Dilayani'],
                                    'done'      => ['bg-emerald-100', 'text-emerald-800', 'Selesai'],
                                    'cancelled' => ['bg-red-100', 'text-red-800', 'Batal'],
                                ];
                            @endphp

                            <div class="overflow-x-auto rounded-2xl border border-[#EBDCCF] shadow-sm">
                                <table class="min-w-full text-sm text-left w-full">
                                    <thead class="bg-[#FEFCFA] border-b border-[#EBDCCF] text-[var(--font-color-secondary)] uppercase text-xs tracking-wider font-bold">
                                        <tr>
                                            <th class="px-4 py-4 text-center w-12">No</th>
                                            <th class="px-4 py-4 whitespace-nowrap">Status</th>
                                            <th class="px-4 py-4 whitespace-nowrap">Tgl Kunjungan</th>
                                            <th class="px-4 py-4 whitespace-nowrap">Tgl Dibuat</th>
                                            <th class="px-4 py-4 whitespace-nowrap">Poli</th>
                                            <th class="px-4 py-4 min-w-[150px]">Nama Pasien</th>
                                            <th class="px-4 py-4 min-w-[200px]">Rencana Tindakan</th>
                                            <th class="px-4 py-4 min-w-[150px]">Dokter Pemeriksa</th>
                                            <th class="px-4 py-4 whitespace-nowrap">Metode Bayar</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-[#EFE3D7] bg-white">
                                        @forelse($activeRegistrations as $row)
                                            @php
                                                $activeStat = $statusFormat[strtolower($row->status)] ?? ['bg-slate-100', 'text-slate-800', ucfirst($row->status)];
                                            @endphp
                                            <tr class="hover:bg-slate-50 transition align-middle">
                                                <td class="px-4 py-3 text-center font-medium text-[var(--font-color-secondary)]">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <span class="inline-flex rounded-lg px-2.5 py-1 text-xs font-bold {{ $activeStat[0] }} {{ $activeStat[1] }}">{{ $activeStat[2] }}</span>
                                                </td>
                                                <td class="px-4 py-3 font-bold text-[var(--font-color-primary)] whitespace-nowrap">
                                                    {{ optional($row->appointment_datetime)->format('d M Y - H:i') ?? '-' }}
                                                </td>
                                                <td class="px-4 py-3 text-[var(--font-color-secondary)] whitespace-nowrap">
                                                    {{ optional($row->created_at)->format('d M Y') ?? '-' }}
                                                </td>
                                                <td class="px-4 py-3 font-medium text-[var(--font-color-primary)] whitespace-nowrap">
                                                    {{ $row->poli->name ?? '-' }}
                                                </td>
                                                <td class="px-4 py-3 font-semibold text-[var(--font-color-primary)] whitespace-nowrap">
                                                    {{ $row->patient->full_name ?? $patient->full_name ?? '-' }}
                                                </td>
                                                <td class="px-4 py-3 text-[var(--font-color-secondary)] max-w-[200px] truncate" title="{{ $row->procedure_plan ?? '-' }}">
                                                    {{ $row->procedure_plan ?? '-' }}
                                                </td>
                                                <td class="px-4 py-3 text-[var(--font-color-primary)] whitespace-nowrap">
                                                    {{ $row->doctor->full_name ?? '-' }}
                                                </td>
                                                <td class="px-4 py-3 text-[var(--font-color-secondary)] whitespace-nowrap">
                                                    <span class="uppercase text-xs font-bold tracking-wide">
                                                        {{ $row->paymentMethod->name ?? $row->payment_method ?? 'UMUM' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="px-4 py-12 text-center text-[var(--font-color-secondary)]">
                                                    <div class="flex flex-col items-center justify-center">
                                                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                                                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                                        </div>
                                                        <p class="font-bold text-[var(--font-color-primary)] mb-1">Belum ada data kunjungan</p>
                                                        <p class="text-sm">Klik tombol "Tambah Kunjungan" untuk mendaftar antrean.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <div class="dash-card bg-white rounded-3xl overflow-hidden mb-10 relative">
    <div class="px-8 lg:px-10 py-6 border-b border-[#EFE3D7]/60 flex items-center justify-between gap-4 relative z-10">
        <h2 class="text-xl font-bold text-[var(--font-color-primary)] flex items-center gap-2">
            <svg class="w-6 h-6 text-[var(--color-primary)] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <span class="truncate">Riwayat Medis</span>
        </h2>
    </div>

    <div class="p-8 lg:p-10 relative z-10">
        
        <div class="flex flex-wrap gap-2 mb-6 bg-[#FEFCFA] p-1.5 rounded-xl border border-[#EFE3D7] inline-flex shadow-sm">
            <button type="button" data-tab="registrasi" class="history-tab-btn px-6 py-2.5 rounded-lg text-sm font-bold bg-[var(--font-color-primary)] text-white shadow-sm transition">Kunjungan</button>
            <button type="button" data-tab="odontogram" class="history-tab-btn px-6 py-2.5 rounded-lg text-sm font-bold text-[var(--font-color-secondary)] hover:text-[var(--font-color-primary)] transition">Odontogram Gigi</button>
        </div>

        <div id="tab-registrasi" class="history-tab-panel">
            <div class="rounded-2xl border border-[#EBDCCF] shadow-sm overflow-hidden flex flex-col">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left w-full">
                        <thead class="bg-[#FEFCFA] border-b border-[#EBDCCF] text-[var(--font-color-secondary)] uppercase text-xs tracking-wider font-bold">
                            <tr>
                                <th class="px-6 py-5 whitespace-nowrap">Tanggal Kunjungan</th>
                                <th class="px-6 py-5 whitespace-nowrap">Dokter</th>
                                <th class="px-6 py-5 min-w-[300px]">Tindakan Prosedur / Obat</th>
                                <th class="px-6 py-5 text-center whitespace-nowrap">No Gigi</th>
                                <th class="px-6 py-5 text-center whitespace-nowrap">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#EFE3D7] bg-white">
                            @forelse($medicalHistoryRows as $row)
                                <tr class="hover:bg-slate-50 transition align-middle">
                                    <td class="px-6 py-5 font-bold text-[var(--font-color-primary)] whitespace-nowrap">
                                        {{ optional($row->appointment_datetime)->format('d M Y') ?? '-' }} <br>
                                        <span class="text-xs text-[var(--font-color-secondary)] font-normal mt-0.5 inline-block">{{ optional($row->appointment_datetime)->format('H:i') ?? '' }} WIB</span>
                                    </td>
                                    <td class="px-6 py-5 font-medium text-[var(--font-color-primary)] whitespace-nowrap">
                                        {{ $row->doctor->full_name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-5 text-[var(--font-color-secondary)] max-w-[300px] truncate leading-relaxed" title="{{ $row->procedure_plan ?? $row->complaint ?? '-' }}">
                                        {{ $row->procedure_plan ?? $row->complaint ?? '-' }}
                                    </td>
                                    <td class="px-6 py-5 text-center font-semibold text-[var(--font-color-primary)] whitespace-nowrap">
                                        {{ $row->tooth_number ?? '-' }}
                                    </td>
                                    <td class="px-6 py-5 text-center whitespace-nowrap">
                                        <span class="inline-flex rounded-lg px-3 py-1.5 text-xs font-bold bg-emerald-100 text-emerald-800">Selesai</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-14 text-center text-[var(--font-color-secondary)]">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                            </div>
                                            <p class="font-bold text-[var(--font-color-primary)]">Belum ada riwayat kunjungan</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($medicalHistoryRows->hasPages())
                <div class="px-6 py-4 border-t border-[#EBDCCF] bg-[#FEFCFA] flex flex-col sm:flex-row items-center justify-between gap-4">
                    <span class="text-sm text-[var(--font-color-secondary)] font-medium">
                        Menampilkan {{ $medicalHistoryRows->firstItem() ?? 0 }} - {{ $medicalHistoryRows->lastItem() ?? 0 }} dari {{ $medicalHistoryRows->total() }} data
                    </span>
                    <div class="flex items-center gap-1">
                        {{-- Laravel Custom Pagination Tailwind Hook --}}
                        {{ $medicalHistoryRows->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div id="tab-odontogram" class="history-tab-panel hidden">
            <div class="rounded-2xl border border-[#EBDCCF] shadow-sm overflow-hidden flex flex-col">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left w-full">
                        <thead class="bg-[#FEFCFA] border-b border-[#EBDCCF] text-[var(--font-color-secondary)] uppercase text-xs tracking-wider font-bold">
                            <tr>
                                <th class="px-6 py-5 whitespace-nowrap w-48">Tanggal Periksa</th>
                                <th class="px-6 py-5 whitespace-nowrap w-56">Dokter</th>
                                <th class="px-6 py-5 text-center whitespace-nowrap w-32">No Gigi</th>
                                <th class="px-6 py-5 min-w-[300px]">Catatan Odontogram</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#EFE3D7] bg-white">
                            @forelse($odontogramRows as $record)
                                <tr class="hover:bg-slate-50 transition align-middle">
                                    <td class="px-6 py-5 font-bold text-[var(--font-color-primary)] whitespace-nowrap">
                                        {{ optional($record->examined_at)->format('d M Y') ?? '-' }} <br>
                                        <span class="text-xs text-[var(--font-color-secondary)] font-normal mt-0.5 inline-block">{{ optional($record->examined_at)->format('H:i') ?? '' }} WIB</span>
                                    </td>
                                    <td class="px-6 py-5 font-medium text-[var(--font-color-primary)] whitespace-nowrap">
                                        {{ $record->doctor->full_name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-5 text-center font-bold text-[var(--color-primary)] whitespace-nowrap">
                                        {{ $record->tooth_number ?? '-' }}
                                    </td>
                                    <td class="px-6 py-5 text-[var(--font-color-secondary)] leading-relaxed max-w-[300px] truncate" title="{{ $record->notes ?: '-' }}">
                                        {{ $record->notes ?: 'Tidak ada catatan khusus.' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-14 text-center text-[var(--font-color-secondary)]">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                            </div>
                                            <p class="font-bold text-[var(--font-color-primary)]">Belum ada riwayat Odontogram</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($odontogramRows->hasPages())
                <div class="px-6 py-4 border-t border-[#EBDCCF] bg-[#FEFCFA] flex flex-col sm:flex-row items-center justify-between gap-4">
                    <span class="text-sm text-[var(--font-color-secondary)] font-medium">
                        Menampilkan {{ $odontogramRows->firstItem() ?? 0 }} - {{ $odontogramRows->lastItem() ?? 0 }} dari {{ $odontogramRows->total() }} data
                    </span>
                    <div class="flex items-center gap-1">
                        {{-- Laravel Custom Pagination Tailwind Hook --}}
                        {{ $odontogramRows->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
                     
                </div>

                <aside class="xl:sticky xl:top-24 h-max w-full">
    
                   <div class="dash-card bg-white rounded-3xl p-8 mb-10 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[#F4E9DF] to-transparent opacity-50 rounded-bl-full pointer-events-none"></div>

                        <h3 class="text-lg font-bold text-[var(--font-color-primary)] mb-6 flex items-center gap-2 relative z-10">
                            <svg class="w-5 h-5 text-[var(--color-primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                            </svg>
                            Statistik Medis
                        </h3>
                        
                        <div class="space-y-4 relative z-10">
                            <div class="group bg-white border border-[#EFE3D7] rounded-2xl p-5 flex items-center gap-5 shadow-sm hover:shadow-md hover:border-[#D9C3AE] hover:-translate-y-1 transition-all duration-300 cursor-default">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#F9F1EA] to-[#F4E9DF] flex items-center justify-center text-[var(--color-primary)] shadow-inner shrink-0 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[var(--font-color-secondary)] text-xs font-bold uppercase tracking-widest mb-1">Total Kunjungan</p>
                                    <p class="text-3xl font-black text-[var(--font-color-primary)] flex items-baseline gap-1.5">
                                        {{ $totalVisits }} 
                                        <span class="text-sm font-semibold text-[var(--font-color-secondary)] normal-case tracking-normal">Kali</span>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="group bg-white border border-[#EFE3D7] rounded-2xl p-5 flex items-center gap-5 shadow-sm hover:shadow-md hover:border-[#D9C3AE] hover:-translate-y-1 transition-all duration-300 cursor-default">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-slate-50 to-slate-100 flex items-center justify-center text-slate-500 shadow-inner shrink-0 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-[var(--font-color-secondary)] text-xs font-bold uppercase tracking-widest mb-1">Berobat Terakhir</p>
                                    <p class="font-extrabold text-[var(--font-color-primary)] text-lg truncate">
                                        {{ optional($recentAppointments->first()?->appointment_datetime)->format('d M Y') ?? 'Belum Pernah' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dash-card bg-white rounded-3xl p-8 border-t-4 border-t-red-500 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-red-50 opacity-60 rounded-bl-full pointer-events-none"></div>

                        <h3 class="text-lg font-bold text-red-600 mb-2 relative z-10 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            Keluar Sistem
                        </h3>
                        
                        <p class="text-sm text-[var(--font-color-secondary)] mb-6 relative z-10 leading-relaxed">
                            Pastikan Anda telah mengecek semua jadwal dan informasi medis Anda sebelum keluar dari portal.
                        </p>
                        
                        <form action="{{ route('logout') }}" method="POST" class="relative z-10">
                            @csrf
                            <button type="submit" class="w-full bg-white border-2 border-red-500 text-red-600 hover:bg-red-500 hover:text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 flex items-center justify-center gap-2 shadow-sm hover:shadow-md">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Logout Akun
                            </button>
                        </form>
                    </div>
                    
                </aside>
            </div>
        </section>

        <div id="visitModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 sm:p-6 overflow-hidden">
            <div id="visitBackdrop" class="absolute inset-0 bg-slate-900/45 backdrop-blur-sm transition-opacity"></div>
            <div class="relative bg-[#FFFDFC] rounded-3xl shadow-2xl w-full max-w-3xl overflow-hidden transform transition-all h-[calc(100dvh-2rem)] sm:h-[calc(100dvh-3rem)] max-h-[920px] flex flex-col min-h-0 border border-[#EADBCF]">
                <div class="px-6 sm:px-8 py-5 border-b border-[#E9DACA] flex items-center justify-between bg-gradient-to-r from-[#FEF9F3] to-[#FFFDFC] shrink-0">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-[#8B5E3C] text-white shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </span>
                        <div>
                            <h2 class="text-xl font-bold text-[var(--font-color-primary)]">Daftar Kunjungan</h2>
                            <p class="text-xs text-[var(--font-color-secondary)]">Tanda <span class="text-red-500">*</span> wajib diisi</p>
                        </div>
                    </div>
                    <button id="closeVisitModal" type="button" class="w-9 h-9 flex items-center justify-center rounded-full bg-slate-100 text-[var(--font-color-secondary)] hover:bg-red-100 hover:text-red-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('appointments.store') }}" method="POST" class="p-6 sm:p-8 space-y-6 modal-scroll min-h-0 flex-1 overscroll-contain">
                    @csrf
                    <div class="rounded-2xl border border-[#E9DACA] bg-white p-5 sm:p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="hidden">
                            <input name="patient_name" type="text" value="{{ $patient->full_name ?? $user->name }}" required>
                            <input name="patient_phone" type="text" value="{{ $patient->phone_number ?? '-' }}" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-[var(--font-color-primary)] mb-1.5">Tenaga Medis <span class="text-red-500">*</span></label>
                            <select name="doctor_id" class="w-full rounded-xl border-[#D9C3AE] bg-slate-50 focus:bg-white focus:border-[var(--color-primary)] focus:ring-[var(--color-primary)]" required>
                                <option value="" disabled selected>Pilih dokter spesialis...</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-[var(--font-color-primary)] mb-1.5">Layanan / Tindakan <span class="text-red-500">*</span></label>
                            <select name="treatment_id" class="w-full rounded-xl border-[#D9C3AE] bg-slate-50 focus:bg-white focus:border-[var(--color-primary)] focus:ring-[var(--color-primary)]" required>
                                <option value="" disabled selected>Pilih tindakan medis...</option>
                                @foreach($treatments as $treatment)
                                    <option value="{{ $treatment->id }}">{{ $treatment->procedure_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-[var(--font-color-primary)] mb-1.5">Tanggal Berobat <span class="text-red-500">*</span></label>
                            <input name="appointment_date" type="date" min="{{ now()->toDateString() }}" class="w-full rounded-xl border-[#D9C3AE] bg-slate-50 focus:bg-white focus:border-[var(--color-primary)] focus:ring-[var(--color-primary)]" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-[var(--font-color-primary)] mb-1.5">Waktu Kunjungan <span class="text-red-500">*</span></label>
                            <input name="appointment_time" type="time" class="w-full rounded-xl border-[#D9C3AE] bg-slate-50 focus:bg-white focus:border-[var(--color-primary)] focus:ring-[var(--color-primary)]" required>
                        </div>
                    </div>
                    </div>

                    <div class="rounded-2xl border border-[#E9DACA] bg-white p-5 sm:p-6">
                        <label class="block text-sm font-bold text-[var(--font-color-primary)] mb-1.5">Keluhan Utama <span class="text-xs text-slate-400 font-normal">(Opsional)</span></label>
                        <textarea name="notes" rows="3" class="w-full rounded-xl border-[#D9C3AE] bg-slate-50 focus:bg-white focus:border-[var(--color-primary)] focus:ring-[var(--color-primary)]" placeholder="Ceritakan keluhan sakit yang Anda rasakan..."></textarea>
                    </div>

                    <input type="hidden" name="payment_method" value="tunai">

                    <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-5 border-t border-[#E9DACA]">
                        <button id="cancelVisitModal" type="button" class="px-6 py-2.5 rounded-xl border-2 border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition">Batal</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#8B5E3C] text-white font-bold hover:bg-[#734A2E] transition shadow-md">Simpan Pendaftaran</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="editAccountModal" class="fixed inset-0 z-50 hidden items-center justify-center p-2 sm:p-4 overflow-hidden">
            <div id="editAccountBackdrop" class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"></div>
            <div id="editAccountDialog" class="relative bg-white rounded-3xl shadow-2xl w-full max-w-3xl border border-[#EFE3D7] overflow-hidden transform transition-all flex flex-col min-h-0 max-h-full" style="height: min(920px, calc(100vh - 1rem));">
                <div class="px-6 sm:px-8 py-4 sm:py-5 border-b border-[#EFE3D7] flex items-center justify-between bg-gradient-to-r from-[#FEFCFA] to-white shrink-0 sticky top-0 z-20">
                    <h2 class="text-xl font-bold text-[var(--font-color-primary)]">Edit Profil</h2>
                    <button id="closeEditAccountModal" type="button" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-[var(--font-color-secondary)] hover:bg-red-100 hover:text-red-600 transition">&times;</button>
                </div>
                <div class="flex-1 min-h-0 modal-scroll overscroll-contain">
                <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-5">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col items-center justify-center mb-2">
                        <div class="relative w-24 h-24 mb-3 group cursor-pointer" onclick="document.getElementById('photoInput').click()">
                            <div class="w-full h-full rounded-full border-4 border-slate-100 overflow-hidden bg-slate-200 flex items-center justify-center">
                                @if(!empty($patient->photo))
                                    <img id="photoPreview" src="{{ $patient->photo }}" alt="Foto" class="w-full h-full object-cover">
                                @else
                                    <img id="photoPreview" src="" class="w-full h-full object-cover hidden">
                                    <svg id="photoIcon" class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                @endif
                            </div>
                            <div class="absolute inset-0 bg-black/40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                            </div>
                        </div>
                        <p class="text-xs font-semibold text-[var(--color-primary)] cursor-pointer" onclick="document.getElementById('photoInput').click()">Ubah Foto Profil</p>
                        <input type="file" id="photoInput" name="photo" class="hidden" accept="image/*" onchange="previewImage(event)">
                        <input type="hidden" id="photoBase64" name="photo_base64">
                    </div>

                    <div>
                        <label class="field-label">Nama Lengkap</label>
                        <input type="text" name="full_name" value="{{ $patient->full_name ?? $user->name }}" class="field-input" required>
                    </div>

                    <div>
                        <label class="field-label">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="field-input" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="field-label">No. WhatsApp</label>
                            <input type="text" name="phone_number" value="{{ $patient->phone_number ?? '' }}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="field-input">
                        </div>
                        <div>
                            <label class="field-label">Tanggal Lahir</label>
                            <input type="date" name="date_of_birth" value="{{ $patient?->date_of_birth ? $patient->date_of_birth->format('Y-m-d') : '' }}" class="field-input">
                        </div>
                        <div>
                            <label class="field-label">Jenis Kelamin</label>
                            <select name="gender" class="field-input">
                                <option value="">Pilih</option>
                                <option value="Male" {{ ($patient?->gender === 'Male') ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Female" {{ ($patient?->gender === 'Female') ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="field-label">Golongan Darah</label>
                            <select name="blood_type" class="field-input">
                                @foreach(['A','B','AB','O','unknown'] as $bloodType)
                                    <option value="{{ $bloodType }}" {{ ($patient?->blood_type === $bloodType) ? 'selected' : '' }}>{{ strtoupper($bloodType) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="field-label">Rhesus</label>
                            <select name="rhesus" class="field-input">
                                @foreach(['+','-','unknown'] as $rhesus)
                                    <option value="{{ $rhesus }}" {{ ($patient?->rhesus === $rhesus) ? 'selected' : '' }}>{{ $rhesus }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="field-label">NIK</label>
                            <input type="text" name="id_card_number" value="{{ $patient->id_card_number ?? '' }}" class="field-input">
                        </div>
                        <div>
                            <label class="field-label">Kota</label>
                            <input type="text" name="city" value="{{ $patient->city ?? '' }}" class="field-input">
                        </div>
                        <div>
                            <label class="field-label">Agama</label>
                            <input type="text" name="religion" value="{{ $patient->religion ?? '' }}" class="field-input">
                        </div>
                        <div>
                            <label class="field-label">Pendidikan</label>
                            <input type="text" name="education" value="{{ $patient->education ?? '' }}" class="field-input">
                        </div>
                        <div>
                            <label class="field-label">Pekerjaan</label>
                            <input type="text" name="occupation" value="{{ $patient->occupation ?? '' }}" class="field-input">
                        </div>
                        <div>
                            <label class="field-label">Status Pernikahan</label>
                            <input type="text" name="marital_status" value="{{ $patient->marital_status ?? '' }}" class="field-input">
                        </div>
                        <div>
                            <label class="field-label">First Chat Date</label>
                            <input type="date" name="first_chat_date" value="{{ $patient?->first_chat_date ? $patient->first_chat_date->format('Y-m-d') : '' }}" class="field-input">
                        </div>
                    </div>

                    <div>
                        <label class="field-label">Alamat</label>
                        <textarea name="address" rows="2" class="field-input">{{ $patient->address ?? '' }}</textarea>
                    </div>

                    <div>
                        <label class="field-label">Riwayat Alergi</label>
                        <textarea name="allergy_history" rows="2" class="field-input">{{ $patient->allergy_history ?? '' }}</textarea>
                    </div>

                    <div class="pt-5 border-t border-[#EFE3D7]">
                        <p class="text-xs text-[var(--font-color-secondary)] mb-3 uppercase tracking-wider font-bold">Keamanan (Ubah Password)</p>
                        <div class="space-y-3">
                            <input type="password" name="password" placeholder="Password Baru (Kosongkan jika tidak diubah)" class="field-input text-sm">
                            <input type="password" name="password_confirmation" placeholder="Ketik Ulang Password Baru" class="field-input text-sm">
                        </div>
                    </div>

                    <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-5 border-t border-[#EFE3D7]">
                        <button id="cancelEditAccountModal" type="button" class="px-6 py-2.5 rounded-xl border-2 border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition">Batalkan</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-[var(--font-color-primary)] text-white font-bold hover:brightness-110 transition shadow-md">Simpan Profil</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Adjust Spacer for Fixed Navbar
        const navbarSpacer = document.getElementById('navbarSpacer');
        const fixedNavbar = document.querySelector('nav.fixed');

        const syncNavbarOffset = () => {
            if (!navbarSpacer || !fixedNavbar) return;
            navbarSpacer.style.height = `${fixedNavbar.offsetHeight}px`;
        };

        // Modal Toggles
        const visitModal = document.getElementById('visitModal');
        const editAccountModal = document.getElementById('editAccountModal');

        const toggleModal = (element, isShow) => {
            if (!element) return;
            if(isShow) {
                element.classList.remove('hidden');
                element.classList.add('flex');
                setTimeout(() => element.querySelector('.transform')?.classList.remove('scale-95', 'opacity-0'), 10);
            } else {
                element.classList.add('hidden');
                element.classList.remove('flex');
            }
            document.body.classList.toggle('overflow-hidden', isShow);
        };

        // Tabs Logic
        const tabButtons = document.querySelectorAll('.history-tab-btn');
        const tabPanels = document.querySelectorAll('.history-tab-panel');
        const patientMoreDetails = document.getElementById('patientMoreDetails');
        const togglePatientDetails = document.getElementById('togglePatientDetails');

        const activateHistoryTab = (tabName) => {
            tabPanels.forEach((panel) => {
                panel.classList.toggle('hidden', panel.id !== `tab-${tabName}`);
            });

            tabButtons.forEach((button) => {
                const isActive = button.dataset.tab === tabName;
                button.classList.toggle('bg-[var(--font-color-primary)]', isActive);
                button.classList.toggle('text-white', isActive);
                button.classList.toggle('shadow-sm', isActive);
                button.classList.toggle('text-[var(--font-color-secondary)]', !isActive);
                button.classList.toggle('bg-transparent', !isActive);
            });
        };

        // Event Listeners
        document.getElementById('openVisitModal')?.addEventListener('click', () => toggleModal(visitModal, true));
        document.getElementById('closeVisitModal')?.addEventListener('click', () => toggleModal(visitModal, false));
        document.getElementById('cancelVisitModal')?.addEventListener('click', () => toggleModal(visitModal, false));
        document.getElementById('visitBackdrop')?.addEventListener('click', () => toggleModal(visitModal, false));

        document.getElementById('openEditAccountModal')?.addEventListener('click', () => toggleModal(editAccountModal, true));
        document.getElementById('closeEditAccountModal')?.addEventListener('click', () => toggleModal(editAccountModal, false));
        document.getElementById('cancelEditAccountModal')?.addEventListener('click', () => toggleModal(editAccountModal, false));
        document.getElementById('editAccountBackdrop')?.addEventListener('click', () => toggleModal(editAccountModal, false));

        document.getElementById('editAccountDialog')?.addEventListener('click', (event) => {
            event.stopPropagation();
        });

        editAccountModal?.addEventListener('click', (event) => {
            if (event.target === editAccountModal) {
                toggleModal(editAccountModal, false);
            }
        });

        tabButtons.forEach((button) => {
            button.addEventListener('click', () => activateHistoryTab(button.dataset.tab));
        });

        if (togglePatientDetails && patientMoreDetails) {
            togglePatientDetails.addEventListener('click', () => {
                const isHidden = patientMoreDetails.classList.contains('hidden');
                patientMoreDetails.classList.toggle('hidden', !isHidden);
                togglePatientDetails.textContent = isHidden ? 'Show Less Data' : 'Show More Data';
            });
        }

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                if (visitModal && !visitModal.classList.contains('hidden')) toggleModal(visitModal, false);
                if (editAccountModal && !editAccountModal.classList.contains('hidden')) toggleModal(editAccountModal, false);
            }
        });

        syncNavbarOffset();
        window.addEventListener('resize', syncNavbarOffset);
        window.addEventListener('load', syncNavbarOffset);

        // Preview Profile Image & convert to Base64 (Optional for Controller)
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('photoPreview');
                    const icon = document.getElementById('photoIcon');
                    const base64Input = document.getElementById('photoBase64');
                    
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if(icon) icon.classList.add('hidden');
                    
                    // Isi input hidden jika backend pakai `photo_base64`
                    if(base64Input) base64Input.value = e.target.result; 
                };
                reader.readAsDataURL(file);
            }
        }

        // ===================== ODONTOGRAM MODAL =====================
        const odontogramData = @json($odontogramData);
        
        function openOdontogramDetailModal(recordId) {
            const record = odontogramData.find(r => r.id === recordId);
            if (!record) return;

            document.getElementById('odoModalDate').textContent       = record.date;
            document.getElementById('odoModalExaminedBy').textContent = record.examined_by;
            document.getElementById('odoModalNotes').textContent      = record.notes;

            const tbody = document.getElementById('odoModalTeethBody');
            if (!record.teeth || record.teeth.length === 0) {
                tbody.innerHTML = `<tr><td colspan="4" class="px-4 py-8 text-center text-gray-400">Tidak ada data kondisi gigi.</td></tr>`;
            } else {
                tbody.innerHTML = record.teeth.map(t => `
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-4 py-3 font-bold text-[var(--font-color-primary)]">${t.tooth_number}</td>
                        <td class="px-4 py-3 text-[var(--font-color-primary)]">${t.condition_label}</td>
                        <td class="px-4 py-3 text-[var(--font-color-secondary)]">${t.surfaces}</td>
                        <td class="px-4 py-3 text-[var(--font-color-secondary)]">${t.condition_code}</td>
                    </tr>
                `).join('');
            }

            const modal = document.getElementById('odontogramDetailModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function closeOdontogramDetailModal() {
            const modal = document.getElementById('odontogramDetailModal');
            if (!modal) return;
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }
        @if($isIncompleteProfile ?? false)
        window.addEventListener('DOMContentLoaded', () => {
            // Give a small delay for smoother UX
            setTimeout(() => {
                const editBtn = document.getElementById('openEditAccountModal');
                if (editBtn) editBtn.click();
            }, 800);
        });
        @endif
    </script>
</body>

</html>