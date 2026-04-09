<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard - Hanglekiu Dental Specialist</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/pages/registration-shared.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/pages/pasien-baru.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/pages/pendaftaran-baru.css') }}">
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

        .modal-scroll {
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            touch-action: pan-y;
        }
    </style>
</head>

<body class="bg-[var(--color-background-primary)] text-[var(--font-color-primary)] flex flex-col min-h-screen font-sans">
    @include('doctor.components.navbarDoctor')

    <div id="navbarSpacer" class="h-24 md:h-28 w-full shrink-0"></div>

    <main class="grow pb-12">
        <section class="container mx-auto px-5 sm:px-10 lg:px-16 xl:px-24 py-8 -mt-8 relative z-20">
            
            {{-- Toast Notifications --}}
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

            {{-- Registration Actions --}}
            <div class="dash-card bg-white p-8 rounded-3xl flex items-center justify-between gap-6 mb-10 border-l-8 border-l-[var(--color-primary)]">
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 rounded-2xl bg-amber-50 flex items-center justify-center text-[var(--color-primary)]">
                        <i class="fas fa-calendar-plus text-3xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-[var(--font-color-primary)]">Kunjungan Pasien</h3>
                        <p class="text-[var(--font-color-secondary)] font-medium">Lakukan pendaftaran baru atau buat kunjungan pasien hari ini</p>
                    </div>
                </div>
                <button onclick="openRegModal('modalPendaftaranBaru')" class="px-10 py-4 bg-[var(--color-primary)] text-white rounded-2xl font-bold hover:brightness-110 transition-all shadow-xl active:scale-95 flex items-center gap-2">
                    <i class="fas fa-user-plus"></i>
                    Pendaftaran Baru
                </button>
            </div>

            {{-- Stats Overview --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                <div class="dash-card bg-white p-6 rounded-3xl flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[var(--font-color-secondary)] text-sm font-medium">Pasien Dilayani</p>
                        <p class="text-2xl font-bold text-[var(--font-color-primary)]">{{ $totalPatientsTreated }}</p>
                    </div>
                </div>
                <div class="dash-card bg-white p-6 rounded-3xl flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[var(--font-color-secondary)] text-sm font-medium">Jadwal Hari Ini</p>
                        <p class="text-2xl font-bold text-[var(--font-color-primary)]">{{ $todayAppointments->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-x-8 gap-y-12">
                
                {{-- Left Side --}}
                <div class="xl:col-span-2">
                    
                    {{-- Next Patient Feature --}}
                    @if($nextPatient)
                    <div class="dash-card brand-surface rounded-3xl p-8 mb-10 text-white relative overflow-hidden text-left">
                         <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                         <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                            <div>
                                <span class="inline-block px-3 py-1 rounded-full bg-white/20 text-xs font-bold uppercase tracking-wider mb-3">Pasien Berikutnya</span>
                                <h3 class="text-3xl font-bold mb-1">{{ $nextPatient->patient->full_name }}</h3>
                                <p class="text-white/80 font-medium flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Terjadwal: {{ \Carbon\Carbon::parse($nextPatient->appointment_datetime)->format('H:i') }} WIB
                                </p>
                            </div>
                            <div class="shrink-0 text-left">
                                <a href="/admin/outpatient?date={{ date('Y-m-d') }}" class="px-6 py-3 bg-white text-[var(--color-primary)] rounded-xl font-bold hover:scale-105 transition-transform inline-block shadow-lg">
                                    Lihat Detail Antrean
                                </a>
                            </div>
                         </div>
                    </div>
                    @else
                    <div class="dash-card bg-emerald-50 border-emerald-100 rounded-3xl p-8 mb-10 text-emerald-800 flex items-center gap-4 text-left">
                        <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>
                            <p class="font-bold text-lg">Semua Aman!</p>
                            <p class="text-sm opacity-90">Tidak ada antrean tunggu mendesak saat ini.</p>
                        </div>
                    </div>
                    @endif

                    {{-- Today's Schedule Table --}}
                    <div class="dash-card bg-white rounded-3xl overflow-hidden relative">
                        <div class="px-8 lg:px-10 py-6 border-b border-[#EFE3D7]/60 flex items-center justify-between gap-4 relative z-10">
                            <h2 class="text-xl font-bold text-[var(--font-color-primary)] flex items-center gap-2">
                                <svg class="w-6 h-6 text-[var(--color-primary)] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                                <span class="truncate">Jadwal Praktik Hari Ini</span>
                            </h2>
                            <span class="text-xs font-bold text-[var(--font-color-secondary)] uppercase bg-slate-50 px-3 py-1 rounded-full">{{ \Carbon\Carbon::today()->format('d M Y') }}</span>
                        </div>
                        <div class="p-8 lg:p-10">
                            <div class="overflow-x-auto rounded-2xl border border-[#EBDCCF] shadow-sm">
                                <table class="min-w-full text-sm text-left">
                                    <thead class="bg-[#FEFCFA] border-b border-[#EBDCCF] text-[var(--font-color-secondary)] uppercase text-xs tracking-wider font-bold">
                                        <tr>
                                            <th class="px-6 py-4">Waktu</th>
                                            <th class="px-6 py-4">Pasien</th>
                                            <th class="px-6 py-4 text-center">No RM</th>
                                            <th class="px-6 py-4 whitespace-nowrap">Layanan</th>
                                            <th class="px-6 py-4 text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-[#EFE3D7] bg-white text-[var(--font-color-primary)]">
                                        @forelse($todayAppointments as $apt)
                                        <tr class="hover:bg-slate-50 transition">
                                            <td class="px-6 py-4 font-bold">{{ \Carbon\Carbon::parse($apt->appointment_datetime)->format('H:i') }}</td>
                                            <td class="px-6 py-4">
                                                <div class="font-bold">{{ $apt->patient->full_name }}</div>
                                                <div class="text-[10px] text-[var(--font-color-secondary)] uppercase tracking-tight">{{ $apt->patient->gender === 'Male' ? 'Laki-laki' : 'Perempuan' }}</div>
                                            </td>
                                            <td class="px-6 py-4 text-center font-medium">{{ $apt->patient->medical_record_no ?? '-' }}</td>
                                            <td class="px-6 py-4">
                                                <div class="font-medium">{{ $apt->poli->name ?? 'Gigi Umum' }}</div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                @php
                                                    $statusClasses = [
                                                        'pending'   => 'bg-amber-100 text-amber-800',
                                                        'confirmed' => 'bg-blue-100 text-blue-800',
                                                        'waiting'   => 'bg-indigo-100 text-indigo-800',
                                                        'engaged'   => 'bg-cyan-100 text-cyan-800',
                                                        'succeed'   => 'bg-emerald-100 text-emerald-800',
                                                        'failed'    => 'bg-red-100 text-red-800',
                                                    ];
                                                    $statusLabels = [
                                                        'pending'   => 'Menunggu',
                                                        'confirmed' => 'Dikonfirmasi',
                                                        'waiting'   => 'Menunggu Antrean',
                                                        'engaged'   => 'Sedang Dilayani',
                                                        'succeed'   => 'Selesai',
                                                        'failed'    => 'Batal',
                                                    ];
                                                @endphp
                                                <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-bold {{ $statusClasses[$apt->status] ?? 'bg-slate-100' }}">
                                                    {{ $statusLabels[$apt->status] ?? $apt->status }}
                                                </span>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                                <svg class="w-12 h-12 mx-auto mb-3 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                Belum ada jadwal pendaftaran untuk hari ini.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Side --}}
                <div class="xl:col-span-1">
                    <div class="dash-card bg-white rounded-3xl overflow-hidden mb-8 text-center">
                        <div class="h-24 brand-surface relative">
                            <button id="openEditProfileModal" class="absolute top-4 right-4 p-2 bg-white/20 hover:bg-white/40 text-white rounded-lg transition-colors" title="Edit Profil">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                        </div>
                        <div class="px-8 pb-8 -mt-12">
                            <div class="relative inline-block mb-4">
                                <div class="w-24 h-24 rounded-full avatar-ring overflow-hidden bg-white flex items-center justify-center mx-auto border-4 border-white">
                                    @if($doctor && $doctor->foto_profil)
                                        <img src="{{ $doctor->foto_profil }}" alt="{{ $doctor->full_name }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-3xl font-bold text-slate-300">{{ substr($user->name, 0, 1) }}</span>
                                    @endif
                                </div>
                                <div class="absolute bottom-0 right-0 w-6 h-6 bg-emerald-500 border-2 border-white rounded-full" title="Status Aktif"></div>
                            </div>
                            <h3 class="text-xl font-bold text-[var(--font-color-primary)]">{{ $doctor->full_title ?? $user->name }}</h3>
                            <p class="text-sm font-semibold text-[var(--color-primary)] uppercase tracking-wider mb-6">{{ $doctor->job_title ?? 'Dokter Spesialis' }}</p>
                            
                            <div class="space-y-4 text-left">
                                <div class="profile-item">
                                    <p class="profile-item-label">Spesialisasi</p>
                                    <p class="profile-item-value">{{ $doctor->specialization ?? '-' }}</p>
                                </div>
                                <div class="profile-item">
                                    <p class="profile-item-label">WhatsApp</p>
                                    <p class="profile-item-value">{{ $doctor->phone_number ?? '-' }}</p>
                                </div>
                                <div class="profile-item">
                                    <p class="profile-item-label">Nomor SIP</p>
                                    <p class="profile-item-value">{{ $doctor->sip_number ?? '-' }}</p>
                                </div>
                                <div class="profile-item">
                                    <p class="profile-item-label">License / STR</p>
                                    <p class="profile-item-value">{{ $doctor->license_no ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dash-card bg-[#F9EFE4] border-[#EFE3D7] rounded-3xl p-6 text-left">
                        <h4 class="font-bold text-[var(--font-color-primary)] mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-[var(--color-primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Jadwal Praktik Mingguan
                        </h4>
                        <div class="space-y-3">
                            @php
                                $orderedDays = ['monday' => 'Senin', 'tuesday' => 'Selasa', 'wednesday' => 'Rabu', 'thursday' => 'Kamis', 'friday' => 'Jumat', 'saturday' => 'Sabtu', 'sunday' => 'Minggu'];
                                $doctorSchedules = $doctor ? $doctor->schedules->groupBy('day') : collect();
                            @endphp
                            @foreach($orderedDays as $dayKey => $dayName)
                            <div class="flex justify-between items-center bg-white/50 px-3 py-2 rounded-xl text-sm">
                                <span class="font-medium text-[var(--font-color-secondary)]">{{ $dayName }}</span>
                                <span class="font-bold text-[var(--font-color-primary)]">
                                    @if($doctorSchedules->has($dayKey))
                                        {{ \Carbon\Carbon::parse($doctorSchedules[$dayKey]->first()->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($doctorSchedules[$dayKey]->first()->end_time)->format('H:i') }}
                                    @else
                                        -
                                    @endif
                                </span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    {{-- Modal Edit Profile --}}
    <div id="editProfileModal" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm transition-opacity"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl w-full max-w-2xl max-h-[90vh] overflow-hidden shadow-2xl flex flex-col transform transition-all">
                <div class="px-8 py-6 border-b border-[#EFE3D7]/60 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-[var(--font-color-primary)]">Edit Profil & Akun</h3>
                        <p class="text-xs text-[var(--font-color-secondary)] font-medium">Perbarui informasi profesional Anda</p>
                    </div>
                    <button id="closeEditProfileModal" class="p-2 hover:bg-slate-100 rounded-xl transition text-[var(--font-color-secondary)]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="grow modal-scroll p-8">
                    <form id="profileUpdateForm" method="POST" action="{{ route('doctor.profile.update') }}" class="space-y-8">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="photo_base64" id="photo_base64">

                        {{-- Photo Section --}}
                        <div class="flex flex-col items-center gap-4 py-4 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                            <div class="relative group">
                                <div class="w-28 h-28 rounded-full avatar-ring overflow-hidden bg-white flex items-center justify-center border-4 border-white shadow-md">
                                    <img id="photoPreview" src="{{ ($doctor && $doctor->foto_profil) ? $doctor->foto_profil : asset('images/user-placeholder.jpg') }}" class="w-full h-full object-cover">
                                </div>
                                <label for="photo_input" class="absolute inset-0 flex items-center justify-center bg-black/40 text-white rounded-full opacity-0 group-hover:opacity-100 transition cursor-pointer">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </label>
                                <input type="file" id="photo_input" class="hidden" accept="image/*">
                            </div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Klik foto untuk mengubah</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label class="field-label">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="field-input px-4 py-3" placeholder="Nama Lengkap" required>
                            </div>
                            <div class="space-y-1">
                                <label class="field-label">Email Aktif</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="field-input px-4 py-3" placeholder="Email" required>
                            </div>
                            <div class="space-y-1">
                                <label class="field-label">No. WhatsApp</label>
                                <input type="tel" name="phone_number" value="{{ old('phone_number', $doctor->phone_number ?? '') }}" class="field-input px-4 py-3" placeholder="Ex: 0812..." oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>
                             <div class="space-y-1">
                                <label class="field-label">Nomor SIP</label>
                                <input type="text" name="sip_number" value="{{ old('sip_number', $doctor->sip_number ?? '') }}" class="field-input px-4 py-3" placeholder="Nomor Surat Izin Praktik">
                            </div>
                             <div class="space-y-1">
                                <label class="field-label">License / STR</label>
                                <input type="text" name="license_no" value="{{ old('license_no', $doctor->license_no ?? '') }}" class="field-input px-4 py-3" placeholder="Nomor STR">
                            </div>
                        </div>

                        <div class="pt-6 border-t border-[#EFE3D7]/60">
                            <h4 class="text-sm font-bold text-[var(--font-color-primary)] mb-4">Ubah Password <span class="text-xs font-normal text-slate-400 ml-2">(Kosongkan jika tidak ingin diubah)</span></h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-1">
                                    <label class="field-label">Password Baru</label>
                                    <input type="password" name="password" class="field-input px-4 py-3" placeholder="Minimal 8 karakter">
                                </div>
                                <div class="space-y-1">
                                    <label class="field-label">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="field-input px-4 py-3" placeholder="Ulangi password">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="px-8 py-6 bg-slate-50 border-t border-[#EFE3D7]/60 flex items-center justify-end gap-3">
                    <button type="button" id="cancelEditProfile" class="px-6 py-2.5 rounded-xl text-sm font-bold text-[var(--font-color-secondary)] hover:bg-slate-200 transition">Batal</button>
                    <button type="submit" form="profileUpdateForm" class="px-8 py-2.5 rounded-xl text-sm font-bold bg-[var(--font-color-primary)] hover:brightness-110 text-white shadow-lg transition transform active:scale-95">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Modal Logic
        const modal = document.getElementById('editProfileModal');
        const openBtn = document.getElementById('openEditProfileModal');
        const closeBtn = document.getElementById('closeEditProfileModal');
        const cancelBtn = document.getElementById('cancelEditProfile');

        const openModal = () => {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        };

        const closeModal = () => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        };

        openBtn?.addEventListener('click', openModal);
        closeBtn?.addEventListener('click', closeModal);
        cancelBtn?.addEventListener('click', closeModal);

        // Photo Preview Logic
        const photoInput = document.getElementById('photo_input');
        const photoPreview = document.getElementById('photoPreview');
        const photoBase64 = document.getElementById('photo_base64');

        photoInput?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    photoPreview.src = event.target.result;
                    photoBase64.value = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        // Toast Logic
        function closeToast(id) {
            const toast = document.getElementById(id);
            if(toast) {
                toast.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => toast.remove(), 500);
            }
        }

        // Auto hide success toast
        setTimeout(() => closeToast('toast-success'), 5000);

        // Core Window Functions for Admin Components
        window.openRegModal = function(modalId) {
            let modal = document.getElementById(modalId);
            if(modal) {
                modal.classList.add('open');
                document.body.style.overflow = 'hidden'; 
            }
        };
        
        window.closeRegModal = function(modalId) {
            let modal = document.getElementById(modalId);
            if(modal) {
                modal.classList.remove('open');
                document.body.style.overflow = '';
            }
        };

        // Pasien Baru Modal
        window.openNewPatientModal = function() {
            const modal = document.getElementById('modalPasienBaru');
            if (modal) {
                modal.style.display = 'flex';
                const form = document.getElementById('pasienBaruForm');
                if (form) form.reset();
            }
        };

        window.closePasienBaruModal = function() {
            const modal = document.getElementById('modalPasienBaru');
            if (modal) modal.style.display = 'none';
        };

        window.addEventListener('patientCreatedInModal', function (e) {
            const newPatient = e.detail?.patient;
            if (newPatient && typeof selectPatient === 'function') {
                selectPatient(newPatient);
                closePasienBaruModal();
            }
        });
    </script>
    
    @include('admin.components.pendaftaran-baru')
    @include('admin.components.pasien-baru')
</body>

</html>
