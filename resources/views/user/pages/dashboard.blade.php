<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 flex flex-col min-h-screen">
    @include('user.components.navbarWelcome')
    <main class="grow">
        @if(session('success'))
            <div class="container mx-auto px-4 mt-4">
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif
        <section class="bg-gradient-to-r from-teal-600 via-cyan-600 to-sky-700 text-white">
            <div class="container mx-auto px-4 py-10">
                <p class="text-sm uppercase tracking-[0.2em] text-cyan-100 mb-2">Portal Pasien</p>
                <h1 class="text-3xl md:text-4xl font-bold">Dashboard Pasien</h1>
                <p class="mt-3 text-cyan-50 max-w-2xl">Kelola profil, pantau antrean aktif, cek riwayat medis, dan akses odontogram dalam satu halaman.</p>
            </div>
        </section>

        <section class="container mx-auto px-4 py-8 -mt-6">
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <div class="xl:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                            <h2 class="text-xl font-semibold text-slate-800">Profil Pasien & Edit Akun</h2>
                            <button type="button" onclick="showEditAccountModal()" class="px-4 py-2 rounded-lg bg-cyan-600 hover:bg-cyan-700 text-white font-medium transition">Edit Akun</button>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div class="rounded-lg bg-slate-50 p-4">
                                <p class="text-slate-500">Nama Pasien</p>
                                <p class="font-semibold text-slate-800">{{ Auth::user()->name }}</p>
                            </div>
                            <div class="rounded-lg bg-slate-50 p-4">
                                <p class="text-slate-500">Email</p>
                                <p class="font-semibold text-slate-800">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="rounded-lg bg-slate-50 p-4">
                                <p class="text-slate-500">No. Telepon</p>
                                <p class="font-semibold text-slate-800">{{ $patient->phone_number ?? '-' }}</p>
                            </div>
                            <div class="rounded-lg bg-slate-50 p-4">
                                <p class="text-slate-500">Tanggal Lahir</p>
                                <p class="font-semibold text-slate-800">{{ $patient->date_of_birth ? $patient->date_of_birth->format('d M Y') : '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-100">
                            <h2 class="text-xl font-semibold text-slate-800">Status Antrean Aktif</h2>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                            @if($upcomingAppointment)
                                <div class="rounded-xl border border-slate-200 p-4">
                                    <p class="text-xs text-slate-500 uppercase tracking-wide">Nomor Antrean</p>
                                    <p class="text-2xl font-bold text-slate-800">{{ $upcomingAppointment->token ?? '-' }}</p>
                                </div>
                                <div class="rounded-xl border border-slate-200 p-4">
                                    <p class="text-xs text-slate-500 uppercase tracking-wide">Poli</p>
                                    <p class="text-lg font-semibold text-slate-800">{{ $upcomingAppointment->poli->name ?? 'Poli Gigi' }}</p>
                                </div>
                                <div class="rounded-xl border border-slate-200 p-4">
                                    <p class="text-xs text-slate-500 uppercase tracking-wide">Status</p>
                                    @php
                                        $statusFormat = [
                                            'pending'   => ['bg-amber-100', 'text-amber-700', 'Menunggu'],
                                            'confirmed' => ['bg-blue-100', 'text-blue-700', 'Tikonfirmasi'],
                                            'waiting'   => ['bg-indigo-100', 'text-indigo-700', 'Dalam Antrean'],
                                            'engaged'   => ['bg-cyan-100', 'text-cyan-700', 'Sedang Dilayani'],
                                        ];
                                        $curr = $statusFormat[strtolower($upcomingAppointment->status)] ?? ['bg-slate-100', 'text-slate-700', $upcomingAppointment->status];
                                    @endphp
                                    <p class="inline-flex items-center mt-2 rounded-full px-3 py-1 {{ $curr[0] }} {{ $curr[1] }} text-sm font-semibold">{{ $curr[2] }}</p>
                                </div>
                            @else
                                <div class="col-span-3 text-center py-6 text-slate-500 italic">
                                    Belum ada antrean aktif hari ini.
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-100">
                            <h2 class="text-xl font-semibold text-slate-800">Riwayat Medis & Odontogram</h2>
                        </div>
                        <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <h3 class="font-semibold text-slate-800 mb-3">Riwayat Registrasi & Catatan Dokter</h3>
                                <div class="space-y-3">
                                    <div class="border border-slate-200 rounded-xl p-4">
                                        <p class="text-sm font-medium text-slate-800">12 Mar 2026 - Pemeriksaan Karang Gigi</p>
                                        <p class="text-sm text-slate-600 mt-1">Catatan dokter: pembersihan menyeluruh, kontrol ulang 6 bulan.</p>
                                    </div>
                                    <div class="border border-slate-200 rounded-xl p-4">
                                        <p class="text-sm font-medium text-slate-800">08 Jan 2026 - Tambal Gigi</p>
                                        <p class="text-sm text-slate-600 mt-1">Catatan dokter: tambalan komposit pada gigi posterior kanan.</p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="font-semibold text-slate-800 mb-3">Odontogram</h3>
                                <div class="rounded-xl border border-dashed border-cyan-300 bg-cyan-50 p-5 h-full flex flex-col justify-between">
                                    <p class="text-sm text-slate-700">Ringkasan odontogram terakhir akan ditampilkan di sini. Tampilan detail visual gigi dapat ditambahkan pada tahap berikutnya.</p>
                                    <button type="button" class="mt-4 self-start px-4 py-2 rounded-lg bg-cyan-600 hover:bg-cyan-700 text-white font-medium transition">Lihat Detail Odontogram</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <aside class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-100">
                            <h2 class="text-xl font-semibold text-slate-800">Form Pendaftaran Layanan</h2>
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-slate-600">Untuk saat ini, silakan gunakan tombol di bawah untuk membuka modal Daftar Kunjungan.</p>
                            <a href="{{ route('registration.form') }}" class="block text-center w-full mt-4 px-4 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold transition">Daftar Kunjungan</a>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-md border border-slate-100 p-6">
                        <h3 class="text-lg font-semibold text-slate-800 mb-3">Aksi Cepat</h3>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2.5 px-6 rounded-lg transition duration-300">Logout</button>
                        </form>
                    </div>
                </aside>
            </div>
        </section>


        {{-- Modal Edit Akun --}}
        <div id="editAccountModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
            <div id="editAccountBackdrop" class="absolute inset-0 bg-slate-900/60"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <h2 class="text-lg font-semibold text-slate-800">Edit Profil & Akun</h2>
                    <button type="button" onclick="hideEditAccountModal()" class="text-slate-500 hover:text-slate-700 text-xl leading-none">&times;</button>
                </div>
                <form action="{{ route('user.profile.update') }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="w-full rounded-lg border-slate-300 focus:border-cyan-600 focus:ring-cyan-600" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Nomor WhatsApp</label>
                            <input type="text" name="phone_number" value="{{ $patient->phone_number ?? '' }}" 
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                   placeholder="08xxxx"
                                   class="w-full rounded-lg border-slate-300 focus:border-cyan-600 focus:ring-cyan-600" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Lahir</label>
                            <input type="date" name="date_of_birth" value="{{ $patient->date_of_birth ? $patient->date_of_birth->format('Y-m-d') : '' }}" 
                                   class="w-full rounded-lg border-slate-300 focus:border-cyan-600 focus:ring-cyan-600">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <p class="text-xs text-slate-500 mb-3 uppercase tracking-wider font-semibold">Ganti Password (Kosongkan jika tidak diganti)</p>
                        <div class="space-y-3">
                            <input type="password" name="password" placeholder="Password Baru" class="w-full rounded-lg border-slate-300 focus:border-cyan-600 focus:ring-cyan-600">
                            <input type="password" name="password_confirmation" placeholder="Konfirmasi Password Baru" class="w-full rounded-lg border-slate-300 focus:border-cyan-600 focus:ring-cyan-600">
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" onclick="hideEditAccountModal()" class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 font-medium">Batal</button>
                        <button type="submit" class="px-6 py-2 rounded-lg bg-cyan-600 text-white hover:bg-cyan-700 font-semibold transition shadow-sm">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        // Edit Akun Logic
        const editAccountModal = document.getElementById('editAccountModal');
        const editAccountBackdrop = document.getElementById('editAccountBackdrop');

        window.showEditAccountModal = () => {
            editAccountModal.classList.remove('hidden');
            editAccountModal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        };

        window.hideEditAccountModal = () => {
            editAccountModal.classList.add('hidden');
            editAccountModal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        };

        editAccountBackdrop.addEventListener('click', hideEditAccountModal);
    </script>
</body>

</html>
