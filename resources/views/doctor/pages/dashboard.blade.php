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

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-x-8 gap-y-12">
                
                {{-- Left Side (Primary Content) --}}
                <div class="xl:col-span-2">
                    
                    {{-- Informasi Dokter (Profil) --}}
                    <div class="dash-card bg-white rounded-3xl overflow-hidden relative mb-10">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-[#F4E9DF] to-transparent opacity-40 rounded-bl-full pointer-events-none"></div>
                        <div class="px-8 lg:px-10 py-6 border-b border-[#EFE3D7]/60 flex items-center justify-between gap-4 relative z-10">
                            <h2 class="text-xl font-bold text-[var(--font-color-primary)] flex items-center gap-2">
                                <i class="fas fa-user-md text-[var(--color-primary)]"></i>
                                <span class="truncate">Profil Profesional Dokter</span>
                            </h2>
                            <button id="openEditProfileModal" type="button" class="shrink-0 px-4 py-2 rounded-lg bg-[var(--font-color-primary)] hover:bg-[var(--color-primary)] text-white font-medium transition text-xs shadow-sm flex items-center gap-1.5 whitespace-nowrap">
                                <i class="fas fa-edit"></i>
                                Edit Profil
                            </button>
                        </div>
                        <div class="p-8 lg:p-10 relative z-10">
                            <div class="flex flex-col md:flex-row items-center md:items-start gap-8 pb-8 md:pl-2">
                                <div class="relative w-28 h-28 shrink-0">
                                    <div class="w-full h-full rounded-full avatar-ring overflow-hidden bg-white flex items-center justify-center border-4 border-white shadow-md">
                                        @if($doctor && $doctor->foto_profil)
                                            <img src="{{ $doctor->foto_profil }}" alt="{{ $doctor->full_name }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-4xl font-bold text-slate-300">{{ substr($user->name, 0, 1) }}</span>
                                        @endif
                                    </div>
                                    <div class="absolute bottom-0 right-0 w-6 h-6 bg-emerald-500 border-2 border-white rounded-full"></div>
                                </div>
                                <div class="text-center md:text-left flex-1 mt-2">
                                    <h3 class="text-2xl font-extrabold text-[var(--font-color-primary)] mb-1">{{ $doctor->full_title ?? $user->name }}</h3>
                                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 text-[var(--font-color-secondary)] font-medium mb-3">
                                        <span class="flex items-center gap-1"><i class="fas fa-stethoscope text-xs"></i> {{ $doctor->specialization ?? 'Dokter Gigi' }}</span>
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-300 hidden md:block"></span>
                                        <span class="flex items-center gap-1"><i class="fas fa-id-card text-xs"></i> SIP: {{ $doctor->sip_number ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6 text-sm md:pl-2">
                                <div class="profile-item">
                                    <p class="profile-item-label">Email Aktif</p>
                                    <p class="profile-item-value truncate">{{ $user->email }}</p>
                                </div>
                                <div class="profile-item">
                                    <p class="profile-item-label">No. WhatsApp</p>
                                    <p class="profile-item-value">{{ $doctor->phone_number ?? '-' }}</p>
                                </div>
                                <div class="profile-item">
                                    <p class="profile-item-label">STR / License No</p>
                                    <p class="profile-item-value">{{ $doctor->license_no ?? '-' }}</p>
                                </div>
                                <div class="profile-item">
                                    <p class="profile-item-label">Jabatan</p>
                                    <p class="profile-item-value">{{ $doctor->job_title ?? 'Dokter Spesialis' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Registration Actions --}}
                    <div class="dash-card bg-white p-8 rounded-3xl flex items-center justify-between gap-6 mb-10 border-l-8 border-l-[var(--color-primary)]">
                        <div class="flex items-center gap-6">
                            <div class="w-16 h-16 rounded-2xl bg-amber-50 flex items-center justify-center text-[var(--color-primary)]">
                                <i class="fas fa-calendar-plus text-3xl"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-[var(--font-color-primary)]">Kunjungan Pasien</h3>
                                <p class="text-[var(--font-color-secondary)] font-medium text-sm">Lakukan pendaftaran baru untuk kunjungan hari ini</p>
                            </div>
                        </div>
                        <button onclick="openRegModal('modalPendaftaranBaru')" class="px-10 py-4 bg-[var(--color-primary)] text-white rounded-2xl font-bold hover:brightness-110 transition-all shadow-xl active:scale-95 flex items-center gap-2">
                            <i class="fas fa-user-plus"></i>
                            Pendaftaran Baru
                        </button>
                    </div>

                    {{-- Today's Schedule Table --}}
                    <div class="dash-card bg-white rounded-3xl overflow-hidden relative">
                        <div class="px-8 lg:px-10 py-6 border-b border-[#EFE3D7]/60 flex items-center justify-between gap-4 relative z-10">
                            <h2 class="text-xl font-bold text-[var(--font-color-primary)] flex items-center gap-2">
                                <svg class="w-6 h-6 text-[var(--color-primary)] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
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

                {{-- Right Side (Sidebar) --}}
                <aside class="xl:sticky xl:top-24 h-max w-full">
                    
                    {{-- Next Patient Card --}}
                    @if($nextPatient)
                    <div class="dash-card brand-surface rounded-3xl p-8 mb-8 text-white relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                        <span class="inline-block px-3 py-1 rounded-full bg-white/20 text-[10px] font-bold uppercase tracking-wider mb-4 relative z-10">Antrean Mendatang</span>
                        <h3 class="text-3xl font-bold mb-2 relative z-10">{{ $nextPatient->patient->full_name }}</h3>
                        <div class="flex items-center gap-3 mb-6 relative z-10 text-white/90">
                            <span class="flex items-center gap-1.5 text-sm font-medium">
                                <i class="far fa-clock"></i>
                                {{ \Carbon\Carbon::parse($nextPatient->appointment_datetime)->format('H:i') }} WIB
                            </span>
                        </div>
                        <a href="/admin/outpatient?date={{ date('Y-m-d') }}" class="w-full py-3.5 bg-white text-[var(--color-primary)] rounded-2xl font-bold hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2 shadow-lg relative z-10">
                            Panggil Pasien
                            <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                    @else
                    <div class="dash-card bg-emerald-50 border-emerald-100 rounded-3xl p-8 mb-8 text-emerald-800 relative overflow-hidden">
                        <div class="flex items-center gap-4 relative z-10">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-emerald-600">
                                <i class="fas fa-check-circle text-xl"></i>
                            </div>
                            <div>
                                <p class="font-bold">Antrean Kosong</p>
                                <p class="text-xs opacity-90">Tidak ada pasien menunggu.</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Work Stats --}}
                    <div class="dash-card bg-white rounded-3xl p-8 mb-8 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[#F4E9DF] to-transparent opacity-50 rounded-bl-full pointer-events-none"></div>
                        <h3 class="text-lg font-bold text-[var(--font-color-primary)] mb-6 flex items-center gap-2 relative z-10">Kinerja Hari Ini</h3>
                        <div class="space-y-4 relative z-10">
                            <div class="group bg-white border border-[#EFE3D7] rounded-2xl p-5 flex items-center gap-5 shadow-sm hover:shadow-md hover:border-[#D9C3AE] hover:-translate-y-1 transition-all duration-300 cursor-default">
                                <div class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 shrink-0 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-users text-2xl"></i>
                                </div>
                                <div>
                                    <p class="text-[var(--font-color-secondary)] text-[10px] font-bold uppercase tracking-widest mb-1">Total Dilayani</p>
                                    <p class="text-2xl font-black text-[var(--font-color-primary)]">{{ $totalPatientsTreated }} <span class="text-xs font-semibold text-[var(--font-color-secondary)]">Pasien</span></p>
                                </div>
                            </div>
                            <div class="group bg-white border border-[#EFE3D7] rounded-2xl p-5 flex items-center gap-5 shadow-sm hover:shadow-md hover:border-[#D9C3AE] hover:-translate-y-1 transition-all duration-300 cursor-default">
                                <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-calendar-alt text-2xl"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-[var(--font-color-secondary)] text-[10px] font-bold uppercase tracking-widest mb-1">Jadwal Hari Ini</p>
                                    <p class="text-xl font-black text-[var(--font-color-primary)]">{{ $todayAppointments->count() }} <span class="text-xs font-semibold text-[var(--font-color-secondary)]">Antrean</span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Practice Schedule --}}
                    <div class="dash-card bg-[#F9EFE4] border-[#EFE3D7] rounded-3xl p-8 mb-8">
                        <h4 class="font-bold text-[var(--font-color-primary)] mb-5 flex items-center gap-2 text-base">
                            <i class="fas fa-clock text-[var(--color-primary)]"></i>
                            Jadwal Praktek Anda
                        </h4>
                        <div class="space-y-3">
                            @php
                                $orderedDays = ['monday' => 'Senin', 'tuesday' => 'Selasa', 'wednesday' => 'Rabu', 'thursday' => 'Kamis', 'friday' => 'Jumat', 'saturday' => 'Sabtu', 'sunday' => 'Minggu'];
                                $doctorSchedules = $doctor ? $doctor->schedules->groupBy('day') : collect();
                            @endphp
                            @foreach($orderedDays as $dayKey => $dayName)
                            <div class="flex justify-between items-center bg-white/50 px-4 py-3 rounded-2xl text-sm">
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

                    {{-- Logout Card --}}
                    <div class="dash-card bg-white rounded-3xl p-8 border-t-4 border-t-red-500 relative overflow-hidden">
                        <form action="{{ route('logout') }}" method="POST" class="relative z-10">
                            @csrf
                            <button type="submit" class="w-full bg-white border-2 border-red-500 text-red-600 hover:bg-red-500 hover:text-white font-bold py-4 px-6 rounded-2xl transition-all flex items-center justify-center gap-3 shadow-sm hover:shadow-md">
                                <i class="fas fa-sign-out-alt"></i>
                                Keluar Aplikasi
                            </button>
                        </form>
                    </div>
                </aside>
            </div>
        </section>
    </main>

    {{-- Modal Edit Profile --}}
    <div id="editProfileModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-2 sm:p-4 overflow-hidden">
        <div id="editProfileBackdrop" class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"></div>
        <div id="editProfileDialog" class="relative bg-white rounded-3xl shadow-2xl w-full max-w-3xl border border-[#EFE3D7] overflow-hidden transform transition-all flex flex-col min-h-0 max-h-full" style="height: min(920px, calc(100vh - 1rem));">
            
            <div class="px-6 sm:px-8 py-4 sm:py-5 border-b border-[#EFE3D7] flex items-center justify-between bg-gradient-to-r from-[#FEFCFA] to-white shrink-0 sticky top-0 z-20">
                <div>
                    <h2 class="text-xl font-bold text-[var(--font-color-primary)]">Edit Profil & Akun</h2>
                    <p class="text-xs text-[var(--font-color-secondary)] font-medium">Perbarui informasi profesional Anda</p>
                </div>
                <button id="closeEditProfileModal" type="button" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-[var(--font-color-secondary)] hover:bg-red-100 hover:text-red-600 transition">&times;</button>
            </div>
            
            <div class="flex-1 min-h-0 modal-scroll overscroll-contain overflow-y-auto">
                <form id="profileUpdateForm" method="POST" action="{{ route('doctor.profile.update') }}" enctype="multipart/form-data" autocomplete="off" class="p-6 sm:p-8 space-y-8">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="photo_base64" id="photo_base64">
                    
                    <div class="flex flex-col items-center justify-center mb-4">
                        <div class="relative w-28 h-28 mb-3 group cursor-pointer" onclick="document.getElementById('photo_input').click()">
                            <div class="w-full h-full rounded-full border-4 border-[#F4E9DF] overflow-hidden bg-slate-100 flex items-center justify-center shadow-sm">
                                <img id="photoPreview" src="{{ ($doctor && $doctor->foto_profil) ? $doctor->foto_profil : asset('images/user-placeholder.jpg') }}" class="w-full h-full object-cover">
                            </div>
                            <div class="absolute inset-0 bg-black/40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                            </div>
                        </div>
                        <p class="text-sm font-bold text-[#8B5E3C] cursor-pointer hover:text-[#582c0c] transition" onclick="document.getElementById('photo_input').click()">Ubah Foto Profil</p>
                        <input type="file" id="photo_input" class="hidden" accept="image/*">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-[#8B5E3C] mb-2 pl-1">Nama Lengkap & Gelar</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-2.5 rounded-xl border-[#EBDCCF] bg-[#FEFCFA] focus:bg-white focus:border-[#8B5E3C] focus:ring-[#8B5E3C] shadow-sm text-[var(--font-color-primary)] font-medium" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-[#8B5E3C] mb-2 pl-1">Email Aktif</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-2.5 rounded-xl border-[#EBDCCF] bg-[#FEFCFA] focus:bg-white focus:border-[#8B5E3C] focus:ring-[#8B5E3C] shadow-sm text-[var(--font-color-primary)] font-medium" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-[#8B5E3C] mb-2 pl-1">No. WhatsApp</label>
                            <input type="tel" name="phone_number" value="{{ old('phone_number', $doctor->phone_number ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border-[#EBDCCF] bg-[#FEFCFA] focus:bg-white focus:border-[#8B5E3C] focus:ring-[#8B5E3C] shadow-sm text-[var(--font-color-primary)] font-medium" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-[#8B5E3C] mb-2 pl-1">Nomor SIP</label>
                            <input type="text" name="sip_number" value="{{ old('sip_number', $doctor->sip_number ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border-[#EBDCCF] bg-[#FEFCFA] focus:bg-white focus:border-[#8B5E3C] focus:ring-[#8B5E3C] shadow-sm text-[var(--font-color-primary)] font-medium">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-[#8B5E3C] mb-2 pl-1">License / STR</label>
                            <input type="text" name="license_no" value="{{ old('license_no', $doctor->license_no ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border-[#EBDCCF] bg-[#FEFCFA] focus:bg-white focus:border-[#8B5E3C] focus:ring-[#8B5E3C] shadow-sm text-[var(--font-color-primary)] font-medium">
                        </div>
                    </div>

                    <div class="pt-6 border-t border-[#EFE3D7]">
                        <p class="text-xs text-[#8B5E3C] mb-4 uppercase tracking-wider font-extrabold flex items-center gap-2">
                            <i class="fas fa-lock"></i>
                            Keamanan (Ubah Password)
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <input type="password" name="password" autocomplete="new-password" placeholder="Password Baru" class="w-full px-4 py-2.5 rounded-xl border-[#EBDCCF] bg-[#FEFCFA] focus:bg-white focus:border-[#8B5E3C] focus:ring-[#8B5E3C] shadow-sm text-sm">
                            <input type="password" name="password_confirmation" autocomplete="new-password" placeholder="Ulangi Password" class="w-full px-4 py-2.5 rounded-xl border-[#EBDCCF] bg-[#FEFCFA] focus:bg-white focus:border-[#8B5E3C] focus:ring-[#8B5E3C] shadow-sm text-sm">
                        </div>
                        <p class="mt-3 text-[10px] text-slate-400 pl-1">Kosongkan kolom password jika tidak ingin mengubah.</p>
                    </div>

                    <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 py-5 px-6 sm:px-8 -mx-6 sm:-mx-8 -mb-6 sm:-mb-8 border-t border-[#EFE3D7] bg-white sticky bottom-0 z-20">
                        <button id="cancelEditProfile" type="button" class="px-6 py-2.5 rounded-xl border-2 border-[#EBDCCF] text-[var(--font-color-primary)] font-bold hover:bg-[#F9F1EA] transition">
                            Batalkan
                        </button>
                        <button type="submit" class="px-8 py-2.5 rounded-xl bg-[var(--font-color-primary)] hover:brightness-110 text-white font-bold transition shadow-md flex items-center justify-center gap-2">
                            <i class="fas fa-save shadow-sm"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Modal Logic
        const modal = document.getElementById('editProfileModal');
        const openBtn = document.getElementById('openEditProfileModal');
        const closeBtn = document.getElementById('closeEditProfileModal');
        const cancelBtn = document.getElementById('cancelEditProfile');
        const backdrop = document.getElementById('editProfileBackdrop');

        const toggleModal = (show) => {
            modal.classList.toggle('hidden', !show);
            modal.classList.toggle('flex', show);
            document.body.style.overflow = show ? 'hidden' : '';
        };

        openBtn?.addEventListener('click', () => toggleModal(true));
        closeBtn?.addEventListener('click', () => toggleModal(false));
        cancelBtn?.addEventListener('click', () => toggleModal(false));
        backdrop?.addEventListener('click', () => toggleModal(false));

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
            let m = document.getElementById(modalId);
            if(m) {
                m.classList.add('open');
                document.body.style.overflow = 'hidden'; 
            }
        };
        
        window.closeRegModal = function(modalId) {
            let m = document.getElementById(modalId);
            if(m) {
                m.classList.remove('open');
                document.body.style.overflow = '';
            }
        };

        // Pasien Baru Modal Logic
        window.openNewPatientModal = function() {
            const m = document.getElementById('modalPasienBaru');
            if (m) {
                m.style.display = 'flex';
                const f = document.getElementById('pasienBaruForm');
                if (f) f.reset();
            }
        };

        window.closePasienBaruModal = function() {
            const m = document.getElementById('modalPasienBaru');
            if (m) m.style.display = 'none';
        };

        window.addEventListener('patientCreatedInModal', function (e) {
            const newPatient = e.detail?.patient;
            if (newPatient && typeof selectPatient === 'function') {
                selectPatient(newPatient);
                closePasienBaruModal();
            }
        });

        // Setup navbar offset
        const navbarSpacer = document.getElementById('navbarSpacer');
        const fixedNavbar = document.querySelector('nav.fixed');
        const syncNavbarOffset = () => {
            if (!navbarSpacer || !fixedNavbar) return;
            navbarSpacer.style.height = `${fixedNavbar.offsetHeight}px`;
        };
        syncNavbarOffset();
        window.addEventListener('resize', syncNavbarOffset);
        window.addEventListener('load', syncNavbarOffset);

        // Handle Escape Key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') toggleModal(false);
        });
    </script>
    
    @include('admin.components.pendaftaran-baru')
    @include('admin.components.pasien-baru')
</body>

</html>
