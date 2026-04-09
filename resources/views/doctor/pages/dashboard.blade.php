<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard - Hanglekiu Dental Specialist</title>
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
    </style>
</head>

<body class="bg-[var(--color-background-primary)] text-[var(--font-color-primary)] flex flex-col min-h-screen font-sans">
    @include('doctor.components.navbarDoctor')

    <div id="navbarSpacer" class="h-24 md:h-28 w-full shrink-0"></div>

    <main class="grow pb-12">
        <section class="container mx-auto px-5 sm:px-10 lg:px-16 xl:px-24 py-8 -mt-8 relative z-20">
            
            {{-- Stats Overview --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
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
                <div class="dash-card bg-white p-6 rounded-3xl flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[var(--font-color-secondary)] text-sm font-medium">Selesai Hari Ini</p>
                        <p class="text-2xl font-bold text-[var(--font-color-primary)]">{{ $todayAppointments->where('status', 'succeed')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-x-8 gap-y-12">
                
                {{-- Left Side: Appointments & Next Patient --}}
                <div class="xl:col-span-2">
                    
                    {{-- Next Patient Feature --}}
                    @if($nextPatient)
                    <div class="dash-card brand-surface rounded-3xl p-8 mb-10 text-white relative overflow-hidden">
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
                            <div class="shrink-0">
                                <a href="/admin/outpatient?date={{ date('Y-m-d') }}" class="px-6 py-3 bg-white text-[var(--color-primary)] rounded-xl font-bold hover:scale-105 transition-transform inline-block shadow-lg">
                                    Lihat Detail Antrean
                                </a>
                            </div>
                         </div>
                    </div>
                    @else
                    <div class="dash-card bg-emerald-50 border-emerald-100 rounded-3xl p-8 mb-10 text-emerald-800 flex items-center gap-4">
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

                {{-- Right Side: Profile & Professional Info --}}
                <div class="xl:col-span-1">
                    <div class="dash-card bg-white rounded-3xl overflow-hidden mb-8">
                        <div class="h-24 brand-surface"></div>
                        <div class="px-8 pb-8 -mt-12 text-center">
                            <div class="relative inline-block mb-4">
                                <div class="w-24 h-24 rounded-full avatar-ring overflow-hidden bg-slate-100 flex items-center justify-center mx-auto">
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
                                    <p class="profile-item-label">Nomor SIP</p>
                                    <p class="profile-item-value">{{ $doctor->sip_number ?? '-' }}</p>
                                </div>
                                <div class="profile-item text-xs">
                                     <p class="font-bold text-[var(--font-color-secondary)] uppercase mb-1">Berlaku Hingga</p>
                                     <p class="text-[var(--font-color-primary)] font-medium">{{ $doctor->sip_expiry_date ? $doctor->sip_expiry_date->format('d M Y') : '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dash-card bg-[#F9EFE4] border-[#EFE3D7] rounded-3xl p-6">
                        <h4 class="font-bold text-[var(--font-color-primary)] mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-[var(--color-primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Jam Praktik Mingguan
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
</body>

</html>
