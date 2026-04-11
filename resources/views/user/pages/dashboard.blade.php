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

        .history-scroll {
            scrollbar-width: thin;
            scrollbar-color: #c9a98d #f4e9df;
        }

        .history-scroll::-webkit-scrollbar {
            height: 10px;
            width: 10px;
        }

        .history-scroll::-webkit-scrollbar-track {
            background: #f4e9df;
            border-radius: 9999px;
        }

        .history-scroll::-webkit-scrollbar-thumb {
            background: #c9a98d;
            border-radius: 9999px;
            border: 2px solid #f4e9df;
        }

        .history-scroll::-webkit-scrollbar-thumb:hover {
            background: #b88d68;
        }

        .history-pagination nav > div:first-child > span,
        .history-pagination nav > div:first-child a,
        .history-pagination nav > div:last-child > span,
        .history-pagination nav > div:last-child a {
            border-radius: 0.6rem;
            border-color: #e5cdb8;
            background: #fff;
            color: #7a5a42;
            box-shadow: none;
        }

        .history-pagination nav > div:first-child a:hover,
        .history-pagination nav > div:last-child a:hover {
            background: #f9f1ea;
            color: #5d3a20;
        }

        .history-pagination nav > div:first-child span[aria-disabled="true"],
        .history-pagination nav > div:last-child span[aria-disabled="true"] {
            color: #c3a892;
            background: #fdf7f1;
            border-color: #efdccc;
        }

        .history-pagination nav > div:last-child span[aria-current="page"] {
            background: #6b3b14;
            border-color: #6b3b14;
            color: #fff;
        }

        .history-pagination nav svg {
            color: inherit;
        }

        .visit-scroll {
            scrollbar-width: thin;
            scrollbar-color: #c9a98d #f4e9df;
        }

        .visit-scroll::-webkit-scrollbar {
            height: 10px;
            width: 10px;
        }

        .visit-scroll::-webkit-scrollbar-track {
            background: #f4e9df;
            border-radius: 9999px;
        }

        .visit-scroll::-webkit-scrollbar-thumb {
            background: #c9a98d;
            border-radius: 9999px;
            border: 2px solid #f4e9df;
        }

        .visit-scroll::-webkit-scrollbar-thumb:hover {
            background: #b88d68;
        }

        .visit-pagination nav > div:first-child > span,
        .visit-pagination nav > div:first-child a,
        .visit-pagination nav > div:last-child > span,
        .visit-pagination nav > div:last-child a,
        .visit-pagination nav span,
        .visit-pagination nav a {
            border-radius: 0.6rem;
            border-color: #e5cdb8;
            background: #fff;
            color: #7a5a42;
            box-shadow: none;
        }

        .visit-pagination nav > div:first-child a:hover,
        .visit-pagination nav > div:last-child a:hover {
            background: #f9f1ea;
            color: #5d3a20;
        }

        .visit-pagination nav > div:first-child span[aria-disabled="true"],
        .visit-pagination nav > div:last-child span[aria-disabled="true"] {
            color: #c3a892;
            background: #fdf7f1;
            border-color: #efdccc;
        }

        .visit-pagination nav > div:last-child span[aria-current="page"] {
            background: #6b3b14;
            border-color: #6b3b14;
            color: #fff;
        }

        .visit-pagination nav svg {
            color: inherit;
        }
    </style>
</head>

<body class="bg-[var(--color-background-primary)] text-[var(--font-color-primary)] flex flex-col min-h-screen font-sans">
    @include('user.components.navbarWelcome')

    <div id="navbarSpacer" class="h-24 md:h-28 w-full shrink-0"></div>

    <main class="grow pb-12">
        

        <section class="container mx-auto px-5 sm:px-10 lg:px-16 xl:px-24 py-8 -mt-8 relative z-20">
            @if(session('success'))
                <div id="toast-success" class="fixed top-28 right-6 z-50 w-full max-w-sm rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800 shadow-xl flex items-start gap-3 transition-all duration-500 transform translate-x-0 opacity-100">
                    <svg class="w-6 h-6 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div class="flex-1">
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                    <button onclick="closeToast('toast-success')" class="text-emerald-500 hover:text-emerald-800 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div id="toast-error" class="fixed top-28 right-6 z-50 w-full max-w-sm rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-800 shadow-xl flex items-start gap-3 transition-all duration-500 transform translate-x-0 opacity-100">
                    <svg class="w-6 h-6 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div class="flex-1">
                        <p class="font-bold mb-1">Terjadi kesalahan:</p>
                        <ul class="list-disc pl-5 text-sm space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button onclick="closeToast('toast-error')" class="text-red-500 hover:text-red-800 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif


            <div class="grid grid-cols-1 xl:grid-cols-3 gap-x-8 gap-y-12">
                <div class="xl:col-span-2">
                    <div id="profil-pasien" class="dash-card bg-white rounded-3xl overflow-hidden relative mb-10">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-[#F4E9DF] to-transparent opacity-40 rounded-bl-full pointer-events-none"></div>
                        <div class="px-8 lg:px-10 py-6 border-b border-[#EFE3D7]/60 flex items-center justify-between gap-4 relative z-10">
                            <h2 class="text-xl font-bold text-[var(--font-color-primary)] flex items-center gap-2">
                                <svg class="w-6 h-6 text-[var(--color-primary)] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
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
                                        @if(!empty($patient?->photo))
                                            <img src="{{ $patient->photo }}" alt="Foto {{ $patient->full_name }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-4xl font-bold text-slate-400 uppercase">{{ substr($patient?->full_name ?? $user->name, 0, 1) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-center md:text-left flex-1 mt-2">
                                    <h3 class="text-2xl font-extrabold text-[var(--font-color-primary)] mb-1">{{ $patient?->full_name ?? $user->name }}</h3>
                                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 text-[var(--font-color-secondary)] font-medium mb-3">
                                        <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>RM: {{ $patient?->medical_record_no ?? 'Belum Tersedia' }}</span>
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-300 hidden md:block"></span>
                                        <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>NIK: {{ $patient?->id_card_number ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6 text-sm md:pl-2">
                                <div class="profile-item"><p class="profile-item-label text-[var(--font-color-secondary)] font-medium mb-1">Email</p><p class="profile-item-value truncate font-semibold text-[var(--font-color-primary)]">{{ $user->email }}</p></div>
                                <div class="profile-item"><p class="profile-item-label text-[var(--font-color-secondary)] font-medium mb-1">No. WhatsApp</p><p class="profile-item-value font-semibold text-[var(--font-color-primary)]">{{ $patient?->phone_number ?? '-' }}</p></div>
                                <div class="profile-item"><p class="profile-item-label text-[var(--font-color-secondary)] font-medium mb-1">Tanggal Lahir</p><p class="profile-item-value font-semibold text-[var(--font-color-primary)]">{{ $patient?->date_of_birth ? $patient->date_of_birth->format('d M Y') : '-' }}</p></div>
                                <div class="profile-item"><p class="profile-item-label text-[var(--font-color-secondary)] font-medium mb-1">Jenis Kelamin</p><p class="profile-item-value font-semibold text-[var(--font-color-primary)]">{{ ($patient?->gender === 'Male') ? 'Laki-laki' : (($patient?->gender === 'Female') ? 'Perempuan' : '-') }}</p></div>
                            </div>

                            <div id="patientMoreDetails" class="hidden mt-8 grid grid-cols-1 md:grid-cols-2 gap-6 text-sm md:pl-2">
                                <div class="profile-item"><p class="profile-item-label text-[var(--font-color-secondary)] font-medium mb-1">Golongan Darah / Rhesus</p><p class="profile-item-value font-semibold text-[var(--font-color-primary)]">{{ $patient?->blood_type ?? '-' }} / {{ $patient?->rhesus ?? '-' }}</p></div>
                                <div class="profile-item"><p class="profile-item-label text-[var(--font-color-secondary)] font-medium mb-1">NIK</p><p class="profile-item-value font-semibold text-[var(--font-color-primary)]">{{ $patient?->id_card_number ?? '-' }}</p></div>
                                <div class="profile-item"><p class="profile-item-label text-[var(--font-color-secondary)] font-medium mb-1">Kota</p><p class="profile-item-value font-semibold text-[var(--font-color-primary)]">{{ $patient?->city ?? '-' }}</p></div>
                                <div class="profile-item"><p class="profile-item-label text-[var(--font-color-secondary)] font-medium mb-1">Agama</p><p class="profile-item-value font-semibold text-[var(--font-color-primary)]">{{ $patient?->religion ?? '-' }}</p></div>
                                <div class="profile-item"><p class="profile-item-label text-[var(--font-color-secondary)] font-medium mb-1">Pendidikan</p><p class="profile-item-value font-semibold text-[var(--font-color-primary)]">{{ $patient?->education ?? '-' }}</p></div>
                                <div class="profile-item"><p class="profile-item-label text-[var(--font-color-secondary)] font-medium mb-1">Pekerjaan</p><p class="profile-item-value font-semibold text-[var(--font-color-primary)]">{{ $patient?->occupation ?? '-' }}</p></div>
                                <div class="profile-item"><p class="profile-item-label text-[var(--font-color-secondary)] font-medium mb-1">Status Pernikahan</p><p class="profile-item-value font-semibold text-[var(--font-color-primary)]">{{ $patient?->marital_status ?? '-' }}</p></div>
                                <div class="profile-item"><p class="profile-item-label text-[var(--font-color-secondary)] font-medium mb-1">First Chat Date</p><p class="profile-item-value font-semibold text-[var(--font-color-primary)]">{{ $patient?->first_chat_date ? $patient->first_chat_date->format('d M Y') : '-' }}</p></div>
                                <div class="profile-item md:col-span-2"><p class="profile-item-label text-[var(--font-color-secondary)] font-medium mb-1">Alamat</p><p class="profile-item-value font-semibold text-[var(--font-color-primary)]">{{ $patient?->address ?? '-' }}</p></div>
                                <div class="profile-item md:col-span-2"><p class="profile-item-label text-[var(--font-color-secondary)] font-medium mb-1">Riwayat Alergi</p><p class="profile-item-value font-semibold text-[var(--font-color-primary)]">{{ $patient?->allergy_history ?? '-' }}</p></div>
                            </div>

                            <button id="togglePatientDetails" type="button" class="mt-8 md:ml-2 inline-flex items-center gap-1.5 text-sm font-semibold text-[var(--color-primary)] hover:text-[var(--font-color-primary)] transition">Lihat Lebih Banyak Data <svg class="w-4 h-4 transition-transform duration-200" id="toggleIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>
                        </div>
                    </div>

                    <div class="dash-card bg-white rounded-3xl overflow-hidden mb-10 relative">
                        <div class="px-8 lg:px-10 py-6 border-b border-[#EFE3D7]/60 flex items-center justify-between gap-4 relative z-10">
                            <h2 class="text-xl font-bold text-[var(--font-color-primary)] flex items-center gap-2">
                                <svg class="w-6 h-6 text-[var(--color-primary)] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                <span class="truncate">Daftar Kunjungan</span>
                            </h2>
                            
                            <a href="{{ route('registration.form') }}" class="shrink-0 px-4 py-2 rounded-lg bg-[var(--font-color-primary)] hover:brightness-110 text-white font-medium transition text-xs shadow-sm flex items-center gap-1.5 whitespace-nowrap">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Tambah Kunjungan
                            </a>
                        </div>
                        <div class="p-8 lg:p-10 relative z-10">
                            @php
                                $statusFormat = ['pending' => ['bg-amber-100', 'text-amber-800', 'Menunggu'], 'confirmed' => ['bg-blue-100', 'text-blue-800', 'Terkonfirmasi'], 'waiting' => ['bg-indigo-100', 'text-indigo-800', 'Dalam Antrean'], 'engaged' => ['bg-cyan-100', 'text-cyan-800', 'Sedang Dilayani'], 'done' => ['bg-emerald-100', 'text-emerald-800', 'Selesai'], 'cancelled' => ['bg-red-100', 'text-red-800', 'Batal']];
                            @endphp
                            <div class="overflow-x-auto visit-scroll rounded-2xl border border-[#EBDCCF] shadow-sm">
                                <table class="min-w-full text-sm text-left w-full">
                                    <thead class="bg-[#FEFCFA] border-b border-[#EBDCCF] text-[var(--font-color-secondary)] uppercase text-xs tracking-wider font-bold"><tr><th class="px-4 py-4 text-center w-12">No</th><th class="px-4 py-4 whitespace-nowrap">Status</th><th class="px-4 py-4 whitespace-nowrap">Tgl Kunjungan</th><th class="px-4 py-4 whitespace-nowrap">Tgl Dibuat</th><th class="px-4 py-4 whitespace-nowrap">Poli</th><th class="px-4 py-4 min-w-[200px]">Rencana Tindakan</th><th class="px-4 py-4 min-w-[150px]">Dokter Pemeriksa</th><th class="px-4 py-4 whitespace-nowrap">Metode Bayar</th></tr></thead>
                                    <tbody class="divide-y divide-[#EFE3D7] bg-white">
                                        @forelse($activeRegistrations as $row)
                                            @php $activeStat = $statusFormat[strtolower($row->status)] ?? ['bg-slate-100', 'text-slate-800', ucfirst($row->status)]; @endphp
                                            <tr class="hover:bg-slate-50 transition align-middle"><td class="px-4 py-3 text-center font-medium text-[var(--font-color-secondary)]">{{ $loop->iteration }}</td><td class="px-4 py-3 whitespace-nowrap"><span class="inline-flex rounded-lg px-2.5 py-1 text-xs font-bold {{ $activeStat[0] }} {{ $activeStat[1] }}">{{ $activeStat[2] }}</span></td><td class="px-4 py-3 font-bold text-[var(--font-color-primary)] whitespace-nowrap">{{ optional($row->appointment_datetime)->format('d M Y - H:i') ?? '-' }}</td><td class="px-4 py-3 text-[var(--font-color-secondary)] whitespace-nowrap">{{ optional($row->created_at)->format('d M Y') ?? '-' }}</td><td class="px-4 py-3 font-medium text-[var(--font-color-primary)] whitespace-nowrap">{{ $row->poli->name ?? '-' }}</td><td class="px-4 py-3 text-[var(--font-color-secondary)] max-w-[200px] truncate" title="{{ $row->procedure_plan ?? '-' }}">{{ $row->procedure_plan ?? '-' }}</td><td class="px-4 py-3 text-[var(--font-color-primary)] whitespace-nowrap">{{ $row->doctor->full_name ?? '-' }}</td><td class="px-4 py-3 text-[var(--font-color-secondary)] whitespace-nowrap"><span class="uppercase text-xs font-bold tracking-wide">{{ $row->paymentMethod->name ?? $row->payment_method ?? 'UMUM' }}</span></td></tr>
                                        @empty
                                            <tr><td colspan="8" class="px-4 py-12 text-center text-[var(--font-color-secondary)]"><div class="flex flex-col items-center justify-center"><div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3"><svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 012-2h2a2 2 0 012 2"></path></svg></div><p class="font-bold text-[var(--font-color-primary)] mb-1">Belum ada data kunjungan</p><p class="text-sm">Klik tombol "Tambah Kunjungan" untuk mendaftar antrean.</p></div></td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if($activeRegistrations->hasPages())
                            <div class="mt-5 px-6 py-4 border-t border-[#EBDCCF] bg-[#FEFCFA] flex flex-col sm:flex-row items-center justify-between gap-4 rounded-2xl">
                                <span class="text-sm text-[var(--font-color-secondary)] font-medium">Menampilkan {{ $activeRegistrations->firstItem() ?? 0 }} - {{ $activeRegistrations->lastItem() ?? 0 }} dari {{ $activeRegistrations->total() }} data</span>
                                <div class="flex items-center gap-1 visit-pagination">{{ $activeRegistrations->links('pagination::tailwind') }}</div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="dash-card bg-white rounded-3xl overflow-hidden mb-10 relative">
                        <div class="px-8 lg:px-10 py-6 border-b border-[#EFE3D7]/60 flex items-center justify-between gap-4 relative z-10"><h2 class="text-xl font-bold text-[var(--font-color-primary)] flex items-center gap-2"><svg class="w-6 h-6 text-[var(--color-primary)] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 012-2h2a2 2 0 012 2"></path></svg><span class="truncate">Riwayat Medis</span></h2></div>
                        <div class="p-8 lg:p-10 relative z-10">
                            <div class="flex flex-wrap gap-2 mb-6 bg-[#FEFCFA] p-1.5 rounded-xl border border-[#EFE3D7] inline-flex shadow-sm">
                                <button type="button" data-tab="registrasi" class="history-tab-btn px-6 py-2.5 rounded-lg text-sm font-bold bg-[var(--font-color-primary)] text-white shadow-sm transition">Kunjungan</button>
                                <button type="button" data-tab="catatan-dokter" class="history-tab-btn px-6 py-2.5 rounded-lg text-sm font-bold text-[var(--font-color-secondary)] hover:text-[var(--font-color-primary)] transition">Catatan Dokter</button>
                                <button type="button" data-tab="odontogram" class="history-tab-btn px-6 py-2.5 rounded-lg text-sm font-bold text-[var(--font-color-secondary)] hover:text-[var(--font-color-primary)] transition">Odontogram Gigi</button>
                            </div>

                            <div id="tab-registrasi" class="history-tab-panel">
                                <div class="rounded-2xl border border-[#EBDCCF] shadow-sm overflow-hidden flex flex-col">
                                    <div class="overflow-x-auto history-scroll"><table class="min-w-full text-sm text-left w-full"><thead class="bg-[#FEFCFA] border-b border-[#EBDCCF] text-[var(--font-color-secondary)] uppercase text-xs tracking-wider font-bold"><tr><th class="px-6 py-5 whitespace-nowrap">Tanggal Kunjungan</th><th class="px-6 py-5 whitespace-nowrap">Dokter</th><th class="px-6 py-5 min-w-[300px]">Jenis Perawatan / Tindakan</th><th class="px-6 py-5 text-center whitespace-nowrap">No Gigi</th><th class="px-6 py-5 text-center whitespace-nowrap">Status</th></tr></thead><tbody class="divide-y divide-[#EFE3D7] bg-white">
                                    @forelse($medicalHistoryRows as $row)
                                        <tr class="hover:bg-slate-50 transition align-middle">
                                            <td class="px-6 py-5 font-bold text-[var(--font-color-primary)] whitespace-nowrap">{{ optional($row->appointment_datetime)->format('d M Y') ?? '-' }} <br><span class="text-xs text-[var(--font-color-secondary)] font-normal mt-0.5 inline-block">{{ optional($row->appointment_datetime)->format('H:i') ?? '' }} WIB</span></td>
                                            <td class="px-6 py-5 font-medium text-[var(--font-color-primary)] whitespace-nowrap">{{ $row->doctor->full_name ?? '-' }}
                                                @if($row->medicalProcedures->count() > 0)
                                                    @foreach($row->medicalProcedures->first()->assistants ?? [] as $assistant)
                                                        <br><span class="text-sm text-[var(--font-color-secondary)]">> {{ $assistant->doctor->full_name ?? '-' }}</span>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td class="px-6 py-5 text-[var(--font-color-secondary)] max-w-[300px]">
                                                @php
                                                    $tindakanList = [];
                                                    foreach($row->medicalProcedures as $proc) {
                                                        // 1. AMBIL PROSEDUR (PROCEDURE ITEM)
                                                        $items = \Illuminate\Support\Facades\DB::table('procedure_item')
                                                            ->join('master_procedure', 'procedure_item.master_procedure_id', '=', 'master_procedure.id')
                                                            ->where('procedure_item.procedure_id', $proc->id)
                                                            ->select('master_procedure.procedure_name')
                                                            ->get();
                                                        foreach ($items as $item) {
                                                            $tindakanList[] = $item->procedure_name ?? $item->name;
                                                        }

                                                        // 2. AMBIL OBAT (PROCEDURE MEDICINE)
                                                        $medicines = \Illuminate\Support\Facades\DB::table('procedure_medicine')
                                                            ->join('medicine', 'procedure_medicine.medicine_id', '=', 'medicine.id')
                                                            ->where('procedure_medicine.procedure_id', $proc->id)
                                                            ->select('medicine.medicine_name')
                                                            ->get();
                                                        foreach ($medicines as $med) {
                                                            $tindakanList[] = $med->medicine_name;
                                                        }

                                                        // 3. AMBIL BHP (CONSUMABLE USAGE)
                                                        $bhpUsages = \Illuminate\Support\Facades\DB::table('consumable_usage')
                                                            ->join('consumable_items', 'consumable_usage.bhp_id', '=', 'consumable_items.id')
                                                            ->where('consumable_usage.treatment_id', $proc->id)
                                                            ->select('consumable_items.item_name')
                                                            ->get();
                                                        foreach ($bhpUsages as $bhp) {
                                                            $tindakanList[] = $bhp->item_name;
                                                        }
                                                    }
                                                @endphp
                                                @if(count($tindakanList) > 0)
                                                    {!! implode('<br>', $tindakanList) !!}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="px-6 py-5 text-center font-semibold text-[var(--font-color-primary)] whitespace-nowrap">
                                                @php
                                                    $teeth = [];
                                                    foreach($row->medicalProcedures as $proc) {
                                                        foreach($proc->items ?? [] as $item) {
                                                            if($item->tooth_numbers) {
                                                                $teeth[] = $item->tooth_numbers;
                                                            }
                                                        }
                                                    }
                                                @endphp
                                                @if(count($teeth) > 0) {{ implode(', ', array_unique($teeth)) }} @else - @endif
                                            </td>
                                            <td class="px-6 py-5 text-center whitespace-nowrap"><span class="inline-flex rounded-lg px-3 py-1.5 text-xs font-bold bg-emerald-100 text-emerald-800">Selesai</span></td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="px-6 py-14 text-center text-[var(--font-color-secondary)]"><div class="flex flex-col items-center justify-center"><div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3"><svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 012-2h2a2 2 0 012 2"></path></svg></div><p class="font-bold text-[var(--font-color-primary)]">Belum ada riwayat kunjungan</p></div></td></tr>
                                    @endforelse
                                    </tbody></table></div>
                                    @if($medicalHistoryRows->hasPages())<div class="px-6 py-4 border-t border-[#EBDCCF] bg-[#FEFCFA] flex flex-col sm:flex-row items-center justify-between gap-4"><span class="text-sm text-[var(--font-color-secondary)] font-medium">Menampilkan {{ $medicalHistoryRows->firstItem() ?? 0 }} - {{ $medicalHistoryRows->lastItem() ?? 0 }} dari {{ $medicalHistoryRows->total() }} data</span><div class="history-pagination flex items-center gap-1">{{ $medicalHistoryRows->links('pagination::tailwind') }}</div></div>@endif
                                </div>
                            </div>

                            <div id="tab-catatan-dokter" class="history-tab-panel hidden">
                                <div class="rounded-2xl border border-[#EBDCCF] shadow-sm overflow-hidden flex flex-col">
                                    <div class="overflow-x-auto history-scroll"><table class="min-w-full text-sm text-left w-full"><thead class="bg-[#FEFCFA] border-b border-[#EBDCCF] text-[var(--font-color-secondary)] uppercase text-xs tracking-wider font-bold"><tr><th class="px-6 py-5 whitespace-nowrap w-48">Tanggal</th><th class="px-6 py-5 whitespace-nowrap w-56">Dokter</th><th class="px-6 py-5 min-w-[360px]">Catatan</th></tr></thead><tbody class="divide-y divide-[#EFE3D7] bg-white">
                                    @forelse($doctorNotesRows as $noteRow)
                                        <tr class="hover:bg-slate-50 transition align-middle">
                                            <td class="px-6 py-5 font-bold text-[var(--font-color-primary)] whitespace-nowrap">{{ optional($noteRow->appointment_datetime)->format('d M Y') ?? '-' }}</td>
                                            <td class="px-6 py-5 font-medium text-[var(--font-color-primary)] whitespace-nowrap">
                                                @if($noteRow->doctor)
                                                    {{ $noteRow->doctor->full_name ?? '-' }}
                                                    @foreach($noteRow->assistants ?? [] as $assistant)
                                                        <br><span class="text-sm text-[var(--font-color-secondary)]">> {{ $assistant->doctor->full_name ?? '-' }}</span>
                                                    @endforeach
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="px-6 py-5 text-[var(--font-color-secondary)] max-w-[360px]">
                                                @php
                                                    $notesText = $noteRow->notes ?? '';
                                                    $sections = [];
                                                    
                                                    // Parse sections from notes text
                                                    $lines = explode("\n", $notesText);
                                                    $currentSection = null;
                                                    $currentContent = '';
                                                    
                                                    foreach ($lines as $line) {
                                                        $trimmedLine = trim($line);
                                                        
                                                        if (in_array($trimmedLine, ['Subjective:', 'Objective:', 'Plan:'])) {
                                                            if ($currentSection && $currentContent !== '') {
                                                                $sections[$currentSection] = trim($currentContent);
                                                            }
                                                            $currentSection = str_replace(':', '', $trimmedLine);
                                                            $currentContent = '';
                                                        } else {
                                                            $currentContent .= $line . "\n";
                                                        }
                                                    }
                                                    
                                                    // Save last section
                                                    if ($currentSection && $currentContent !== '') {
                                                        $sections[$currentSection] = trim($currentContent);
                                                    }
                                                @endphp
                                                
                                                @if(count($sections) > 0)
                                                    <div class="grid grid-cols-2 gap-4 items-start">
                                                        @foreach(['Subjective', 'Objective', 'Plan'] as $label)
                                                            @if(isset($sections[$label]) && $sections[$label] !== '')
                                                                <div class="font-semibold text-[var(--font-color-secondary)] text-xs uppercase">{{ $label }}</div>
                                                                <div class="text-sm text-[var(--font-color-primary)] whitespace-pre-wrap">{{ $sections[$label] }}</div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div class="text-sm text-[var(--font-color-secondary)]">Tidak ada catatan dokter.</div>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="px-6 py-14 text-center text-[var(--font-color-secondary)]"><div class="flex flex-col items-center justify-center"><div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3"><svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 012-2h2a2 2 0 012 2"></path></svg></div><p class="font-bold text-[var(--font-color-primary)]">Belum ada catatan dokter</p></div></td></tr>
                                    @endforelse
                                    </tbody></table></div>
                                    @if($doctorNotesRows->hasPages())<div class="px-6 py-4 border-t border-[#EBDCCF] bg-[#FEFCFA] flex flex-col sm:flex-row items-center justify-between gap-4"><span class="text-sm text-[var(--font-color-secondary)] font-medium">Menampilkan {{ $doctorNotesRows->firstItem() ?? 0 }} - {{ $doctorNotesRows->lastItem() ?? 0 }} dari {{ $doctorNotesRows->total() }} data</span><div class="history-pagination flex items-center gap-1">{{ $doctorNotesRows->links('pagination::tailwind') }}</div></div>@endif
                                </div>
                            </div>

                            <div id="tab-odontogram" class="history-tab-panel hidden">
                                <div class="rounded-2xl border border-[#EBDCCF] shadow-sm overflow-hidden flex flex-col">
                                    <div class="overflow-x-auto history-scroll"><table class="min-w-full text-sm text-left w-full"><thead class="bg-[#FEFCFA] border-b border-[#EBDCCF] text-[var(--font-color-secondary)] uppercase text-xs tracking-wider font-bold"><tr><th class="px-6 py-5 whitespace-nowrap w-36">Tanggal Periksa</th><th class="px-6 py-5 min-w-[220px]">Diagnosa Gigi</th><th class="pl-3 pr-6 py-5 min-w-[440px]">Catatan</th></tr></thead><tbody class="divide-y divide-[#EFE3D7] bg-white">
                                    @forelse($odontogramRows as $record)
                                        <tr class="hover:bg-slate-50 transition align-middle">
                                            <td class="px-6 py-5 font-bold text-[var(--font-color-primary)] whitespace-nowrap">{{ optional($record->examined_at)->format('d M Y') ?? '-' }}</td>
                                            <td class="px-6 py-5 text-sm text-[var(--font-color-primary)]">
                                                @php
                                                    $diagnosaRows = [];
                                                    foreach($record->teeth->groupBy('tooth_number') as $toothNum => $teeth) {
                                                        $tooth = $teeth->first();
                                                        $diagnosa = trim((string) ($tooth->condition_label ?? ''));
                                                        if($diagnosa === '') {
                                                            $diagnosa = trim((string) ($tooth->surfaces ?? ''));
                                                        }
                                                        if($diagnosa === '') {
                                                            $diagnosa = trim((string) ($tooth->condition_code ?? ''));
                                                        }
                                                        if($diagnosa !== '' && $diagnosa !== '-') {
                                                            $diagnosaRows[] = $toothNum . ' : ' . $diagnosa;
                                                        }
                                                    }
                                                @endphp
                                                @if(count($diagnosaRows) > 0)
                                                    {!! implode('<br>', $diagnosaRows) !!}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="pl-3 pr-6 py-5 align-top">
                                                @php
                                                    $noteText = trim((string) ($record->notes ?? ''));
                                                    $labelMap = [
                                                        'occlusi' => 'Occlusi',
                                                        'torus palatinus' => 'Torus Palatinus',
                                                        'diastema' => 'Diastema',
                                                        'torus mandibularis' => 'Torus Mandibularis',
                                                        'palatum' => 'Palatum',
                                                        'gigi anomali' => 'Gigi Anomali',
                                                        'd' => 'D',
                                                        'm' => 'M',
                                                        'f' => 'F',
                                                        'catatan tambahan' => 'Catatan Tambahan',
                                                    ];
                                                    $parsedNotes = [];

                                                    if($noteText !== '') {
                                                        $pattern = '/(Occlusi|Torus Palatinus|Diastema|Torus Mandibularis|Palatum|Gigi Anomali|D|M|F|Catatan Tambahan)\s*:\s*/i';
                                                        preg_match_all($pattern, $noteText, $matches, PREG_OFFSET_CAPTURE);

                                                        if(!empty($matches[0])) {
                                                            $totalMatches = count($matches[0]);
                                                            for($i = 0; $i < $totalMatches; $i++) {
                                                                $fullMatch = $matches[0][$i][0];
                                                                $startOffset = $matches[0][$i][1] + strlen($fullMatch);
                                                                $endOffset = $i + 1 < $totalMatches ? $matches[0][$i + 1][1] : strlen($noteText);
                                                                $rawLabel = strtolower(trim($matches[1][$i][0]));
                                                                $value = trim(substr($noteText, $startOffset, $endOffset - $startOffset));
                                                                $value = trim($value, " \t\n\r\0\x0B,");

                                                                if(isset($labelMap[$rawLabel]) && $value !== '' && $value !== '-') {
                                                                    $parsedNotes[$labelMap[$rawLabel]] = $value;
                                                                }
                                                            }
                                                        } elseif($noteText !== '-') {
                                                            $parsedNotes['Catatan Tambahan'] = $noteText;
                                                        }
                                                    }

                                                    $orderedLabels = ['Occlusi', 'Torus Palatinus', 'Diastema', 'Torus Mandibularis', 'Palatum', 'Gigi Anomali', 'D', 'M', 'F', 'Catatan Tambahan'];
                                                    $visibleLabels = [];
                                                    foreach($orderedLabels as $label) {
                                                        if(isset($parsedNotes[$label]) && trim((string) $parsedNotes[$label]) !== '') {
                                                            $visibleLabels[] = $label;
                                                        }
                                                    }
                                                @endphp
                                                @if(count($visibleLabels) > 0)
                                                    <div class="space-y-2">
                                                        @foreach($visibleLabels as $label)
                                                            <div class="flex items-start justify-between gap-4">
                                                                <div class="w-40 shrink-0 font-semibold text-[var(--font-color-secondary)] text-xs uppercase leading-relaxed">{{ $label }}</div>
                                                                <div class="flex-1 text-sm text-[var(--font-color-primary)] leading-relaxed whitespace-pre-wrap break-words text-right">{{ $parsedNotes[$label] }}</div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="px-6 py-14 text-center text-[var(--font-color-secondary)]"><div class="flex flex-col items-center justify-center"><div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3"><svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 012-2h2a2 2 0 012 2"></path></svg></div><p class="font-bold text-[var(--font-color-primary)]">Belum ada riwayat Odontogram</p></div></td></tr>
                                    @endforelse
                                    </tbody></table></div>
                                    @if($odontogramRows->hasPages())<div class="px-6 py-4 border-t border-[#EBDCCF] bg-[#FEFCFA] flex flex-col sm:flex-row items-center justify-between gap-4"><span class="text-sm text-[var(--font-color-secondary)] font-medium">Menampilkan {{ $odontogramRows->firstItem() ?? 0 }} - {{ $odontogramRows->lastItem() ?? 0 }} dari {{ $odontogramRows->total() }} data</span><div class="history-pagination flex items-center gap-1">{{ $odontogramRows->links('pagination::tailwind') }}</div></div>@endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <aside class="xl:sticky xl:top-24 h-max w-full">
                    <div class="dash-card bg-white rounded-3xl p-8 mb-10 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[#F4E9DF] to-transparent opacity-50 rounded-bl-full pointer-events-none"></div>
                        <h3 class="text-lg font-bold text-[var(--font-color-primary)] mb-6 flex items-center gap-2 relative z-10">Statistik Medis</h3>
                        <div class="space-y-4 relative z-10">
                            <div class="group bg-white border border-[#EFE3D7] rounded-2xl p-5 flex items-center gap-5 shadow-sm hover:shadow-md hover:border-[#D9C3AE] hover:-translate-y-1 transition-all duration-300 cursor-default">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#F9F1EA] to-[#F4E9DF] flex items-center justify-center text-[var(--color-primary)] shadow-inner shrink-0 group-hover:scale-110 transition-transform duration-300"><svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg></div>
                                <div><p class="text-[var(--font-color-secondary)] text-xs font-bold uppercase tracking-widest mb-1">Total Kunjungan</p><p class="text-3xl font-black text-[var(--font-color-primary)] flex items-baseline gap-1.5">{{ $totalVisits }} <span class="text-sm font-semibold text-[var(--font-color-secondary)] normal-case tracking-normal">Kali</span></p></div>
                            </div>
                            <div class="group bg-white border border-[#EFE3D7] rounded-2xl p-5 flex items-center gap-5 shadow-sm hover:shadow-md hover:border-[#D9C3AE] hover:-translate-y-1 transition-all duration-300 cursor-default">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-slate-50 to-slate-100 flex items-center justify-center text-slate-500 shadow-inner shrink-0 group-hover:scale-110 transition-transform duration-300"><svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>
                                <div class="flex-1 min-w-0"><p class="text-[var(--font-color-secondary)] text-xs font-bold uppercase tracking-widest mb-1">Berobat Terakhir</p><p class="font-extrabold text-[var(--font-color-primary)] text-lg truncate">{{ optional($recentAppointments->first()?->appointment_datetime)->format('d M Y') ?? 'Belum Pernah' }}</p></div>
                            </div>
                        </div>
                    </div>

                    <div class="dash-card bg-white rounded-3xl p-8 border-t-4 border-t-red-500 relative overflow-hidden">
                       
                        <form action="{{ route('logout') }}" method="POST" class="relative z-10">@csrf<button type="submit" class="w-full bg-white border-2 border-red-500 text-red-600 hover:bg-red-500 hover:text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 flex items-center justify-center gap-2 shadow-sm hover:shadow-md">Logout Akun</button></form>
                    </div>
                </aside>
            </div>
        </section>

        <div id="editAccountModal" class="fixed inset-0 z-50 hidden items-center justify-center p-2 sm:p-4 overflow-hidden">
    <div id="editAccountBackdrop" class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"></div>
    <div id="editAccountDialog" class="relative bg-white rounded-3xl shadow-2xl w-full max-w-3xl border border-[#EFE3D7] overflow-hidden transform transition-all flex flex-col min-h-0 max-h-full" style="height: min(920px, calc(100vh - 1rem));">
        
        <div class="px-6 sm:px-8 py-4 sm:py-5 border-b border-[#EFE3D7] flex items-center justify-between bg-gradient-to-r from-[#FEFCFA] to-white shrink-0 sticky top-0 z-20">
            <h2 class="text-xl font-bold text-[var(--font-color-primary)]">Edit Profil</h2>
            <button id="closeEditAccountModal" type="button" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-[var(--font-color-secondary)] hover:bg-red-100 hover:text-red-600 transition">&times;</button>
        </div>
        
        <div class="flex-1 min-h-0 modal-scroll overscroll-contain overflow-y-auto">
            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" autocomplete="off" class="p-6 sm:p-8 space-y-6">
                @csrf
                @method('PUT')
                
                <div class="flex flex-col items-center justify-center mb-4">
                    <div class="relative w-28 h-28 mb-3 group cursor-pointer" onclick="document.getElementById('photoInput').click()">
                        <div class="w-full h-full rounded-full border-4 border-[#F4E9DF] overflow-hidden bg-slate-100 flex items-center justify-center shadow-sm">
                            @if(!empty($patient->photo))
                                <img id="photoPreview" src="{{ $patient->photo }}" alt="Foto" class="w-full h-full object-cover">
                            @else
                                <img id="photoPreview" src="" class="w-full h-full object-cover hidden">
                                <svg id="photoIcon" class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            @endif
                        </div>
                        <div class="absolute inset-0 bg-black/40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                        </div>
                    </div>
                    <p class="text-sm font-bold text-[#8B5E3C] cursor-pointer hover:text-[#582c0c] transition" onclick="document.getElementById('photoInput').click()">Ubah Foto Profil</p>
                    <input type="file" id="photoInput" name="photo" class="hidden" accept="image/*" onchange="previewImage(event)">
                    <input type="hidden" id="photoBase64" name="photo_base64">
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-[#8B5E3C] mb-2 pl-1">Nama Lengkap</label>
                        <input type="text" name="full_name" value="{{ $patient->full_name ?? $user->name }}" class="w-full px-4 py-2.5 rounded-xl border-[#EBDCCF] bg-[#FEFCFA] focus:bg-white focus:border-[#8B5E3C] focus:ring-[#8B5E3C] shadow-sm text-[var(--font-color-primary)] font-medium" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#8B5E3C] mb-2 pl-1">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="w-full px-4 py-2.5 rounded-xl border-[#EBDCCF] bg-[#FEFCFA] focus:bg-white focus:border-[#8B5E3C] focus:ring-[#8B5E3C] shadow-sm text-[var(--font-color-primary)] font-medium" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-[#8B5E3C] mb-2 pl-1">No. WhatsApp</label>
                        <input type="text" name="phone_number" value="{{ $patient->phone_number ?? '' }}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full px-4 py-2.5 rounded-xl border-[#EBDCCF] bg-[#FEFCFA] focus:bg-white focus:border-[#8B5E3C] focus:ring-[#8B5E3C] shadow-sm text-[var(--font-color-primary)] font-medium">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#8B5E3C] mb-2 pl-1">Tanggal Lahir</label>
                        <input type="date" name="date_of_birth" value="{{ $patient?->date_of_birth ? $patient->date_of_birth->format('Y-m-d') : '' }}" class="w-full px-4 py-2.5 rounded-xl border-[#EBDCCF] bg-[#FEFCFA] focus:bg-white focus:border-[#8B5E3C] focus:ring-[#8B5E3C] shadow-sm text-[var(--font-color-primary)] font-medium">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#8B5E3C] mb-2 pl-1">Jenis Kelamin</label>
                        <select name="gender" class="w-full px-4 py-2.5 rounded-xl border-[#EBDCCF] bg-[#FEFCFA] focus:bg-white focus:border-[#8B5E3C] focus:ring-[#8B5E3C] shadow-sm text-[var(--font-color-primary)] font-medium">
                            <option value="">Pilih</option>
                            <option value="Male" {{ ($patient?->gender === 'Male') ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Female" {{ ($patient?->gender === 'Female') ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#8B5E3C] mb-2 pl-1">Golongan Darah</label>
                        <select name="blood_type" class="w-full px-4 py-2.5 rounded-xl border-[#EBDCCF] bg-[#FEFCFA] focus:bg-white focus:border-[#8B5E3C] focus:ring-[#8B5E3C] shadow-sm text-[var(--font-color-primary)] font-medium">
                            @foreach(['A','B','AB','O','unknown'] as $bloodType)
                                <option value="{{ $bloodType }}" {{ ($patient?->blood_type === $bloodType) ? 'selected' : '' }}>{{ strtoupper($bloodType) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#8B5E3C] mb-2 pl-1">Rhesus</label>
                        <select name="rhesus" class="w-full px-4 py-2.5 rounded-xl border-[#EBDCCF] bg-[#FEFCFA] focus:bg-white focus:border-[#8B5E3C] focus:ring-[#8B5E3C] shadow-sm text-[var(--font-color-primary)] font-medium">
                            @foreach(['+','-','unknown'] as $rhesus)
                                <option value="{{ $rhesus }}" {{ ($patient?->rhesus === $rhesus) ? 'selected' : '' }}>{{ $rhesus }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#8B5E3C] mb-2 pl-1">NIK</label>
                        <input type="text" name="id_card_number" value="{{ $patient->id_card_number ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border-[#EBDCCF] bg-[#FEFCFA] focus:bg-white focus:border-[#8B5E3C] focus:ring-[#8B5E3C] shadow-sm text-[var(--font-color-primary)] font-medium">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#8B5E3C] mb-2 pl-1">Kota</label>
                        <input type="text" name="city" value="{{ $patient->city ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border-[#EBDCCF] bg-[#FEFCFA] focus:bg-white focus:border-[#8B5E3C] focus:ring-[#8B5E3C] shadow-sm text-[var(--font-color-primary)] font-medium">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#8B5E3C] mb-2 pl-1">Agama</label>
                        <input type="text" name="religion" value="{{ $patient->religion ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border-[#EBDCCF] bg-[#FEFCFA] focus:bg-white focus:border-[#8B5E3C] focus:ring-[#8B5E3C] shadow-sm text-[var(--font-color-primary)] font-medium">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#8B5E3C] mb-2 pl-1">Pendidikan</label>
                        <input type="text" name="education" value="{{ $patient->education ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border-[#EBDCCF] bg-[#FEFCFA] focus:bg-white focus:border-[#8B5E3C] focus:ring-[#8B5E3C] shadow-sm text-[var(--font-color-primary)] font-medium">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#8B5E3C] mb-2 pl-1">Pekerjaan</label>
                        <input type="text" name="occupation" value="{{ $patient->occupation ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border-[#EBDCCF] bg-[#FEFCFA] focus:bg-white focus:border-[#8B5E3C] focus:ring-[#8B5E3C] shadow-sm text-[var(--font-color-primary)] font-medium">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#8B5E3C] mb-2 pl-1">Status Pernikahan</label>
                        <input type="text" name="marital_status" value="{{ $patient->marital_status ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border-[#EBDCCF] bg-[#FEFCFA] focus:bg-white focus:border-[#8B5E3C] focus:ring-[#8B5E3C] shadow-sm text-[var(--font-color-primary)] font-medium">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#8B5E3C] mb-2 pl-1">First Chat Date</label>
                        <input type="date" name="first_chat_date" value="{{ $patient?->first_chat_date ? $patient->first_chat_date->format('Y-m-d') : '' }}" class="w-full px-4 py-2.5 rounded-xl border-[#EBDCCF] bg-[#FEFCFA] focus:bg-white focus:border-[#8B5E3C] focus:ring-[#8B5E3C] shadow-sm text-[var(--font-color-primary)] font-medium">
                    </div>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-[#8B5E3C] mb-2 pl-1">Alamat</label>
                        <textarea name="address" rows="2" class="w-full px-4 py-2.5 rounded-xl border-[#EBDCCF] bg-[#FEFCFA] focus:bg-white focus:border-[#8B5E3C] focus:ring-[#8B5E3C] shadow-sm text-[var(--font-color-primary)] font-medium">{{ $patient->address ?? '' }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#8B5E3C] mb-2 pl-1">Riwayat Alergi</label>
                        <textarea name="allergy_history" rows="2" class="w-full px-4 py-2.5 rounded-xl border-[#EBDCCF] bg-[#FEFCFA] focus:bg-white focus:border-[#8B5E3C] focus:ring-[#8B5E3C] shadow-sm text-[var(--font-color-primary)] font-medium">{{ $patient->allergy_history ?? '' }}</textarea>
                    </div>
                </div>

                <div class="pt-6 border-t border-[#EFE3D7]">
                    <p class="text-xs text-[#8B5E3C] mb-4 uppercase tracking-wider font-extrabold flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Keamanan (Ubah Password)
                    </p>
                    <div class="space-y-4">
                        <input type="password" name="password" value="" autocomplete="new-password" placeholder="Password Baru (Kosongkan jika tidak diubah)" class="w-full px-4 py-2.5 rounded-xl border-[#EBDCCF] bg-[#FEFCFA] focus:bg-white focus:border-[#8B5E3C] focus:ring-[#8B5E3C] shadow-sm text-sm">
                        <input type="password" name="password_confirmation" value="" autocomplete="new-password" placeholder="Ketik Ulang Password Baru" class="w-full px-4 py-2.5 rounded-xl border-[#EBDCCF] bg-[#FEFCFA] focus:bg-white focus:border-[#8B5E3C] focus:ring-[#8B5E3C] shadow-sm text-sm">
                    </div>
                </div>

                <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 py-5 px-6 sm:px-8 -mx-6 sm:-mx-8 -mb-6 sm:-mb-8 border-t border-[#EFE3D7] bg-white sticky bottom-0 z-20">
                    <button id="cancelEditAccountModal" type="button" class="px-6 py-2.5 rounded-xl border-2 border-[#EBDCCF] text-[var(--font-color-primary)] font-bold hover:bg-[#F9F1EA] transition">
                        Batalkan
                    </button>
                    <button type="submit" class="px-8 py-2.5 rounded-xl bg-[var(--font-color-primary)] hover:brightness-110 text-white font-bold transition shadow-md flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Profil
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


    </main>

    <script>
        const navbarSpacer = document.getElementById('navbarSpacer');
        const fixedNavbar = document.querySelector('nav.fixed');
        const visitModal = document.getElementById('visitModal');
        const editAccountModal = document.getElementById('editAccountModal');

        const syncNavbarOffset = () => {
            if (!navbarSpacer || !fixedNavbar) return;
            navbarSpacer.style.height = `${fixedNavbar.offsetHeight}px`;
        };

        const toggleModal = (element, isShow) => {
            if (!element) return;
            element.classList.toggle('hidden', !isShow);
            element.classList.toggle('flex', isShow);
            document.body.classList.toggle('overflow-hidden', isShow);
        };

        const tabButtons = document.querySelectorAll('.history-tab-btn');
        const tabPanels = document.querySelectorAll('.history-tab-panel');
        const patientMoreDetails = document.getElementById('patientMoreDetails');
        const togglePatientDetails = document.getElementById('togglePatientDetails');

        const activateHistoryTab = (tabName) => {
            tabPanels.forEach((panel) => panel.classList.toggle('hidden', panel.id !== `tab-${tabName}`));
            tabButtons.forEach((button) => {
                const isActive = button.dataset.tab === tabName;
                button.classList.toggle('bg-[var(--font-color-primary)]', isActive);
                button.classList.toggle('text-white', isActive);
                button.classList.toggle('shadow-sm', isActive);
                button.classList.toggle('text-[var(--font-color-secondary)]', !isActive);
                button.classList.toggle('bg-transparent', !isActive);
            });
        };

        document.getElementById('openVisitModal')?.addEventListener('click', () => toggleModal(visitModal, true));
        document.getElementById('closeVisitModal')?.addEventListener('click', () => toggleModal(visitModal, false));
        document.getElementById('cancelVisitModal')?.addEventListener('click', () => toggleModal(visitModal, false));
        document.getElementById('visitBackdrop')?.addEventListener('click', () => toggleModal(visitModal, false));

        document.getElementById('openEditAccountModal')?.addEventListener('click', () => toggleModal(editAccountModal, true));
        document.getElementById('closeEditAccountModal')?.addEventListener('click', () => toggleModal(editAccountModal, false));
        document.getElementById('cancelEditAccountModal')?.addEventListener('click', () => toggleModal(editAccountModal, false));
        document.getElementById('editAccountBackdrop')?.addEventListener('click', () => toggleModal(editAccountModal, false));

        tabButtons.forEach((button) => button.addEventListener('click', () => activateHistoryTab(button.dataset.tab)));

        const historyContainer = document.querySelector('.history-tab-panel')?.closest('.dash-card');

        const refreshHistoryPanel = async (url, panelId) => {
            const currentPanel = document.getElementById(panelId);
            if (!currentPanel) return;

            currentPanel.style.opacity = '0.6';
            currentPanel.style.pointerEvents = 'none';

            try {
                const response = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html'
                    }
                });

                if (!response.ok) {
                    throw new Error('Gagal memuat halaman riwayat medis.');
                }

                const html = await response.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const nextPanel = doc.getElementById(panelId);

                if (!nextPanel) {
                    throw new Error('Panel riwayat medis tidak ditemukan.');
                }

                currentPanel.innerHTML = nextPanel.innerHTML;
                activateHistoryTab(panelId.replace('tab-', ''));
                history.replaceState({}, '', url);

                if (historyContainer) {
                    historyContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            } catch (error) {
                window.alert('Gagal memuat data. Coba lagi.');
            } finally {
                currentPanel.style.opacity = '1';
                currentPanel.style.pointerEvents = 'auto';
            }
        };

        document.addEventListener('click', (event) => {
            const paginationLink = event.target.closest('.history-pagination a[href]');
            if (!paginationLink) return;

            const parentPanel = paginationLink.closest('.history-tab-panel');
            if (!parentPanel) return;

            event.preventDefault();
            refreshHistoryPanel(paginationLink.href, parentPanel.id);
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

        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const preview = document.getElementById('photoPreview');
                    const icon = document.getElementById('photoIcon');
                    const base64Input = document.getElementById('photoBase64');
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (icon) icon.classList.add('hidden');
                    if (base64Input) base64Input.value = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

    
    function closeToast(id) {
        const toast = document.getElementById(id);
        if (toast) {
            // Efek geser ke kanan dan menghilang
            toast.classList.remove('translate-x-0', 'opacity-100');
            toast.classList.add('translate-x-full', 'opacity-0');
            
            // Hapus elemen dari HTML setelah animasi selesai (500ms)
            setTimeout(() => {
                toast.remove();
            }, 500);
        }
    }

    // Auto-hide setelah beberapa detik
    document.addEventListener('DOMContentLoaded', function() {
        // Hilangkan pesan sukses otomatis setelah 4 detik
        if(document.getElementById('toast-success')) {
            setTimeout(() => {
                closeToast('toast-success');
            }, 4000);
        }

        // Hilangkan pesan error otomatis setelah 6 detik (karena biasanya teksnya lebih panjang)
        if(document.getElementById('toast-error')) {
            setTimeout(() => {
                closeToast('toast-error');
            }, 6000);
        }
    });

    </script>
</body>

</html>