<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Kunjungan — Hanglekiu Dental Clinic</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Instrument Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url('{{ asset('images/bg-clinic.png') }}') no-repeat center center fixed;
            background-size: cover;
        }

        .card {
            display: flex;
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 40px rgba(88, 44, 12, 0.15);
            overflow: hidden;
            width: 980px;
            min-height: 590px;
        }

        .card-image { width: 45%; min-height: 100%; }
        .card-image img { width: 100%; height: 100%; object-fit: cover; display: block; }

        .card-form {
            width: 55%;
            padding: 44px 44px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .logo { margin-bottom: 8px; }
        .logo img { height: 60px; object-fit: contain; }

        .tagline {
            font-size: 14px;
            color: #6B513E;
            margin-bottom: 22px;
            line-height: 1.5;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .form-group {
            margin-bottom: 16px;
            position: relative;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #582C0C;
            margin-bottom: 8px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #C58F59;
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Instrument Sans', sans-serif;
            color: #582C0C;
            background: transparent;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .form-group textarea { min-height: 90px; resize: vertical; }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: #C58F59;
            opacity: 0.6;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #582C0C;
        }

        .hint {
            margin-top: 8px;
            font-size: 12px;
            color: #6B513E;
            opacity: .85;
            line-height: 1.4;
        }

        .btn {
            width: 100%;
            padding: 14px;
            background: #582C0C;
            color: #F7F7F7;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            font-family: 'Instrument Sans', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 6px;
        }

        .btn:hover {
            background: #3d1e08;
            box-shadow: 0 6px 20px rgba(88, 44, 12, 0.35);
            transform: translateY(-1px);
        }
        .btn:active { transform: translateY(0); }

        .btn-secondary {
            width: 100%;
            padding: 12px;
            background: white;
            border: 2px solid #582C0C;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            font-family: 'Instrument Sans', sans-serif;
            color: #582C0C;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-secondary:hover {
            box-shadow: 0 2px 8px rgba(197, 143, 89, 0.15);
            transform: translateY(-1px);
        }

        .error {
            background-color: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
            font-size: 14px;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 18px;
        }

        .pill-row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 4px;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1.5px solid #C58F59;
            border-radius: 999px;
            padding: 10px 14px;
            cursor: pointer;
            user-select: none;
            color: #582C0C;
            transition: all .2s ease;
            background: rgba(197, 143, 89, 0.06);
            font-weight: 600;
            font-size: 13px;
        }

        .pill input { display:none; }

        .pill.active {
            background: #582C0C;
            border-color: #582C0C;
            color: #fff;
        }

        .divider {
            margin: 14px 0 10px;
            height: 1px;
            background: rgba(197, 143, 89, 0.35);
        }

        /* Responsive */
        @media (max-width: 992px) {
            body { padding: 20px; }
            .card { width: 100%; max-width: 980px; }
        }
        @media (max-width: 768px) {
            .card { flex-direction: column; width: 100%; max-width: 520px; }
            .card-image { width: 100%; height: 220px; }
            .card-form { width: 100%; padding: 28px 22px; }
            .grid-2 { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-image">
            <img src="{{ asset('images/dentist.png') }}" alt="Hanglekiu Dental Clinic">
        </div>

        <div class="card-form">
            <div class="logo">
                <img src="{{ asset('images/logo-hds.png') }}" alt="Hanglekiu Dental Clinic">
            </div>

            <p class="tagline">
                Daftarkan kunjungan pasien dengan cepat — pilih jenis kunjungan, dokter, jadwal, dan metode pembayaran.
            </p>

            @if($errors->any())
                <div class="error">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('registration.store') }}">
                @csrf

                <div class="form-group">
                    <label for="patient_name">Nama Pasien *</label>
                    <input
                        type="text"
                        name="patient_name"
                        id="patient_name"
                        placeholder="Contoh: Andita"
                        value="{{ old('patient_name') }}"
                        required
                    >
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label for="visit_type">Jenis Kunjungan *</label>
                        <select name="visit_type" id="visit_type" required>
                            <option value="" disabled {{ old('visit_type') ? '' : 'selected' }}>Pilih jenis kunjungan</option>
                            <option value="perawatan" {{ old('visit_type') === 'perawatan' ? 'selected' : '' }}>Perawatan</option>
                            <option value="kunjungan_sakit" {{ old('visit_type') === 'kunjungan_sakit' ? 'selected' : '' }}>Kunjungan Sakit</option>
                            <option value="kunjungan_sehat" {{ old('visit_type') === 'kunjungan_sehat' ? 'selected' : '' }}>Kunjungan Sehat</option>
                        </select>
                        <div class="hint">Kalau pilih <b>Perawatan</b>, nanti muncul pilihan <b>Wajah/Badan</b>.</div>
                    </div>

                    <div class="form-group" id="care_area_group" style="display:none;">
                        <label>Metode Perawatan *</label>
                        <div class="pill-row" id="care_area_pills">
                            <label class="pill" data-value="wajah">
                                <input type="radio" name="care_area" value="wajah" {{ old('care_area') === 'wajah' ? 'checked' : '' }}>
                                Wajah
                            </label>
                            <label class="pill" data-value="badan">
                                <input type="radio" name="care_area" value="badan" {{ old('care_area') === 'badan' ? 'checked' : '' }}>
                                Badan
                            </label>
                        </div>
                        <div class="hint">Wajib dipilih kalau jenis kunjungannya <b>Perawatan</b>.</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="treatment">Perawatan / Keluhan *</label>
                    <input
                        type="text"
                        name="treatment"
                        id="treatment"
                        placeholder="Contoh: Tambal gigi"
                        value="{{ old('treatment') }}"
                        required
                    >
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label for="doctor">Dokter *</label>
                        <select name="doctor" id="doctor" required>
                            <option value="" disabled {{ old('doctor') ? '' : 'selected' }}>Pilih dokter</option>
                            {{-- dummy dulu, nanti gampang diganti jadi dari DB --}}
                            <option value="drg. Jane Doe Sp.Ortho" {{ old('doctor') === 'drg. Jane Doe Sp.Ortho' ? 'selected' : '' }}>drg. Jane Doe Sp.Ortho</option>
                            <option value="drg. John Smith Sp.Ortho" {{ old('doctor') === 'drg. John Smith Sp.Ortho' ? 'selected' : '' }}>drg. John Smith Sp.Ortho</option>
                            <option value="DR. drg. Alan Turing Sp.BM" {{ old('doctor') === 'DR. drg. Alan Turing Sp.BM' ? 'selected' : '' }}>DR. drg. Alan Turing Sp.BM</option>
                            <option value="drg. Ada Lovelace" {{ old('doctor') === 'drg. Ada Lovelace' ? 'selected' : '' }}>drg. Ada Lovelace</option>
                            <option value="drg. Grace Hopper Sp.Perio" {{ old('doctor') === 'drg. Grace Hopper Sp.Perio' ? 'selected' : '' }}>drg. Grace Hopper Sp.Perio</option>
                            <option value="drg. Marie Curie Sp.Pros" {{ old('doctor') === 'drg. Marie Curie Sp.Pros' ? 'selected' : '' }}>drg. Marie Curie Sp.Pros</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="date">Tanggal Kunjungan *</label>
                        <input type="date" name="date" id="date" value="{{ old('date') }}" required>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label for="time">Jam Kunjungan *</label>
                        <input type="time" name="time" id="time" value="{{ old('time') }}" required>
                        <div class="hint">Contoh: 11:45, 12:00, 12:15, dst.</div>
                    </div>

                    <div class="form-group">
                        <label for="payment_method">Metode Pembayaran *</label>
                        <select name="payment_method" id="payment_method" required>
                            <option value="" disabled {{ old('payment_method') ? '' : 'selected' }}>Pilih metode</option>
                            <option value="tunai" {{ old('payment_method') === 'tunai' ? 'selected' : '' }}>Tunai</option>
                            <option value="transfer" {{ old('payment_method') === 'transfer' ? 'selected' : '' }}>Transfer</option>
                        </select>
                    </div>
                </div>

                <div class="form-group" id="insurer_group">
                    <label for="insurer">Penjamin *</label>
                    <select name="insurer" id="insurer" required>
                        <option value="" disabled {{ old('insurer') ? '' : 'selected' }}>Pilih penjamin</option>
                        <option value="tidak_ada" {{ old('insurer') === 'tidak_ada' ? 'selected' : '' }}>Tidak ada</option>
                        <option value="avrist" {{ old('insurer') === 'avrist' ? 'selected' : '' }}>Avrist</option>
                        <option value="admedika" {{ old('insurer') === 'admedika' ? 'selected' : '' }}>AdMedika</option>
                        <option value="chubb" {{ old('insurer') === 'chubb' ? 'selected' : '' }}>Chubb</option>
                    </select>
                    <div class="hint">Kalau pilih <b>Tidak ada</b>, berarti pasien bayar pribadi.</div>
                </div>

                <div class="divider"></div>

                <button type="submit" class="btn">Simpan Kunjungan</button>
                <button type="button" class="btn-secondary" onclick="history.back()">Kembali</button>
            </form>
        </div>
    </div>

    <script>
        // Toggle perawatan (wajah/badan) hanya muncul kalau jenis_kunjungan = perawatan
        const visitType = document.getElementById('visit_type');
        const careAreaGroup = document.getElementById('care_area_group');
        const carePills = document.querySelectorAll('#care_area_pills .pill');

        function syncCareAreaVisibility() {
            const isPerawatan = visitType.value === 'perawatan';
            careAreaGroup.style.display = isPerawatan ? 'block' : 'none';

            // kalau bukan perawatan, kosongkan radio care_area biar gak ikut terkirim
            if (!isPerawatan) {
                const radios = careAreaGroup.querySelectorAll('input[type="radio"][name="care_area"]');
                radios.forEach(r => r.checked = false);
                carePills.forEach(p => p.classList.remove('active'));
            } else {
                // jika ada yang checked dari old(), aktifkan pill-nya
                carePills.forEach(pill => {
                    const radio = pill.querySelector('input[type="radio"]');
                    pill.classList.toggle('active', radio.checked);
                });
            }
        }

        carePills.forEach(pill => {
            pill.addEventListener('click', () => {
                carePills.forEach(p => p.classList.remove('active'));
                pill.classList.add('active');
                const radio = pill.querySelector('input[type="radio"]');
                radio.checked = true;
            });
        });

        visitType.addEventListener('change', syncCareAreaVisibility);
        // initial
        syncCareAreaVisibility();
    </script>
</body>
</html>