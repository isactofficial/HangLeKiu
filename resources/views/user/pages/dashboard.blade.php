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
                            <button type="button" class="px-4 py-2 rounded-lg bg-cyan-600 hover:bg-cyan-700 text-white font-medium transition">Edit Akun</button>
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
                                <p class="font-semibold text-slate-800">-</p>
                            </div>
                            <div class="rounded-lg bg-slate-50 p-4">
                                <p class="text-slate-500">Tanggal Lahir</p>
                                <p class="font-semibold text-slate-800">-</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-100">
                            <h2 class="text-xl font-semibold text-slate-800">Status Antrean Aktif</h2>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="rounded-xl border border-slate-200 p-4">
                                <p class="text-xs text-slate-500 uppercase tracking-wide">Nomor Antrean</p>
                                <p class="text-2xl font-bold text-slate-800">A-012</p>
                            </div>
                            <div class="rounded-xl border border-slate-200 p-4">
                                <p class="text-xs text-slate-500 uppercase tracking-wide">Poli</p>
                                <p class="text-lg font-semibold text-slate-800">Poli Gigi Umum</p>
                            </div>
                            <div class="rounded-xl border border-slate-200 p-4">
                                <p class="text-xs text-slate-500 uppercase tracking-wide">Status</p>
                                <p class="inline-flex items-center mt-2 rounded-full px-3 py-1 bg-amber-100 text-amber-700 text-sm font-semibold">Menunggu Panggilan</p>
                            </div>
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
                            <button id="openVisitModal" type="button" class="w-full mt-4 px-4 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold transition">Daftar Kunjungan</button>
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

        <div id="visitModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
            <div id="visitBackdrop" class="absolute inset-0 bg-slate-900/60"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-xl border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-slate-800">Daftar Kunjungan</h2>
                    <button id="closeVisitModal" type="button" class="text-slate-500 hover:text-slate-700 text-xl leading-none">&times;</button>
                </div>
                <form class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Pilih Poli</label>
                        <select class="w-full rounded-lg border-slate-300 focus:border-cyan-600 focus:ring-cyan-600">
                            <option>Poli Gigi Umum</option>
                            <option>Poli Bedah Mulut</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Kunjungan</label>
                        <input type="date" class="w-full rounded-lg border-slate-300 focus:border-cyan-600 focus:ring-cyan-600" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Keluhan Singkat</label>
                        <textarea rows="3" class="w-full rounded-lg border-slate-300 focus:border-cyan-600 focus:ring-cyan-600" placeholder="Tulis keluhan utama..."></textarea>
                    </div>
                    <div class="flex justify-end gap-3 pt-2">
                        <button id="cancelVisitModal" type="button" class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50">Batal</button>
                        <button type="button" class="px-4 py-2 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700">Simpan (UI)</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        const visitModal = document.getElementById('visitModal');
        const openVisitModal = document.getElementById('openVisitModal');
        const closeVisitModal = document.getElementById('closeVisitModal');
        const cancelVisitModal = document.getElementById('cancelVisitModal');
        const visitBackdrop = document.getElementById('visitBackdrop');

        const showModal = () => {
            visitModal.classList.remove('hidden');
            visitModal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        };

        const hideModal = () => {
            visitModal.classList.add('hidden');
            visitModal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        };

        openVisitModal.addEventListener('click', showModal);
        closeVisitModal.addEventListener('click', hideModal);
        cancelVisitModal.addEventListener('click', hideModal);
        visitBackdrop.addEventListener('click', hideModal);

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !visitModal.classList.contains('hidden')) {
                hideModal();
            }
        });
    </script>
</body>

</html>
