<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Rawat Jalan — Hanglekiu Dental Specialist</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family:'Instrument Sans', sans-serif;
            min-height:100vh;
            display:flex; align-items:center; justify-content:center;
            background: url('{{ asset("images/bg-clinic.png") }}') no-repeat center center fixed;
            background-size:cover;
            padding:20px;
        }

        .card {
            display:flex;
            background:white;
            border-radius:20px;
            box-shadow:0 8px 40px rgba(88,44,12,0.15);
            overflow:hidden;
            width:900px;
            min-height:600px;
        }

        .card-image {
            width:38%;
            background:linear-gradient(160deg, #C58F59 0%, #582C0C 100%);
            display:flex; flex-direction:column; align-items:center; justify-content:center;
            padding:40px 28px; text-align:center;
        }

        .card-image .tooth { font-size:64px; margin-bottom:20px; }

        .card-image h2 { color:white; font-size:22px; font-weight:700; line-height:1.3; margin-bottom:10px; }

        .card-image p { color:rgba(255,255,255,0.8); font-size:13px; line-height:1.6; margin-bottom:28px; }

        .card-image .info-item {
            background:rgba(255,255,255,0.15); border-radius:8px;
            padding:10px 14px; font-size:12px; color:rgba(255,255,255,0.9);
            margin-bottom:8px; width:100%; text-align:left;
        }

        .card-form {
            width:62%;
            padding:40px 36px;
            overflow-y:auto;
            max-height:700px;
        }

        .card-form h3 { font-size:22px; font-weight:700; color:#582C0C; margin-bottom:4px; }
        .tagline { font-size:13px; color:#C58F59; margin-bottom:28px; }

        .form-group { margin-bottom:16px; position:relative; }

        .form-group label {
            display:block; font-size:13px; font-weight:600;
            color:#582C0C; margin-bottom:6px;
        }

        .form-group label .req { color:#EF4444; }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width:100%; padding:11px 16px;
            border:1.5px solid #C58F59; border-radius:10px;
            font-size:14px; font-family:'Instrument Sans', sans-serif;
            color:#582C0C; background:white; outline:none;
            transition:border-color 0.2s; appearance:none;
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder { color:rgba(197,143,89,0.6); }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus { border-color:#582C0C; }

        .form-group select {
            background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23C58F59' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat:no-repeat; background-position:right 14px center; padding-right:36px; cursor:pointer;
        }

        .row-2 { display:grid; grid-template-columns:1fr 1fr; gap:14px; }

        /* Pilihan pembayaran */
        .payment-label { font-size:13px; font-weight:600; color:#582C0C; margin-bottom:8px; }
        .payment-opts { display:flex; gap:10px; }
        .pay-opt {
            flex:1; border:1.5px solid #C58F59; border-radius:10px;
            padding:12px 8px; text-align:center; cursor:pointer;
            font-size:13px; color:#9a7a60; font-weight:600;
            transition:all 0.2s;
        }
        .pay-opt.active { background:#582C0C; border-color:#582C0C; color:white; }
        .pay-opt.disabled { opacity:0.4; cursor:not-allowed; }
        .pay-opt .pay-icon { font-size:22px; display:block; margin-bottom:4px; }
        .pay-hint { font-size:11px; color:#9a7a60; margin-top:6px; }

        /* Input hidden untuk pembayaran */
        #payment_method_input { display:none; }

        .btn {
            width:100%; padding:13px;
            background:#582C0C; color:white; border:none;
            border-radius:10px; font-size:14px; font-weight:700;
            font-family:'Instrument Sans', sans-serif; cursor:pointer;
            transition:all 0.3s; margin-top:4px;
        }
        .btn:hover { background:#3d1e08; box-shadow:0 6px 20px rgba(88,44,12,0.3); transform:translateY(-1px); }
        .btn:active { transform:translateY(0); }

        .form-note { font-size:11px; color:#9a7a60; text-align:center; margin-top:10px; }

        /* Error */
        .error-box {
            background:#fef2f2; color:#b91c1c;
            border:1px solid #fecaca; border-radius:10px;
            padding:12px 16px; margin-bottom:20px; font-size:13px;
        }
        .field-error { font-size:12px; color:#EF4444; margin-top:4px; }

        /* Scrollbar */
        .card-form::-webkit-scrollbar { width:6px; }
        .card-form::-webkit-scrollbar-track { background:#f5ede3; }
        .card-form::-webkit-scrollbar-thumb { background:#C58F59; border-radius:4px; }

        @media (max-width:768px) {
            .card { flex-direction:column; width:100%; max-width:480px; }
            .card-image { width:100%; padding:24px; }
            .card-image .tooth { font-size:48px; }
            .card-form { width:100%; padding:28px 20px; max-height:none; }
            .row-2 { grid-template-columns:1fr; }
        }
    </style>
</head>
<body>
<div class="card">

    {{-- Sisi kiri: ilustrasi / info --}}
    <div class="card-image">
        <div class="tooth">🦷</div>
        <h2>Daftar Rawat Jalan</h2>
        <p>Buat janji temu dengan dokter gigi spesialis kami. Mudah, cepat, dan terpercaya.</p>
        <div class="info-item">✔ Konfirmasi via WhatsApp</div>
        <div class="info-item">✔ Pembayaran di tempat</div>
        <div class="info-item">✔ Reschedule H-1 sebelum jadwal</div>
    </div>

    {{-- Sisi kanan: form --}}
    <div class="card-form">
        <h3>Buat Janji Temu</h3>
        <p class="tagline">hanglekiu dental specialist</p>

        @if($errors->any())
            <div class="error-box">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('appointments.store') }}">
            @csrf

            <div class="form-group">
                <label>Nama Lengkap <span class="req">*</span></label>
                <input type="text" name="patient_name"
                       placeholder="Nama sesuai KTP"
                       value="{{ old('patient_name') }}" required>
                @error('patient_name')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Nomor WhatsApp <span class="req">*</span></label>
                <input type="tel" name="patient_phone"
                       placeholder="08xxxxxxxxxx"
                       value="{{ old('patient_phone') }}" required>
                @error('patient_phone')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Jenis Perawatan <span class="req">*</span></label>
                <select name="treatment_id" required>
                    <option value="" disabled {{ old('treatment_id') ? '' : 'selected' }}>Pilih perawatan...</option>
                    @foreach($treatments as $t)
                        <option value="{{ $t->id }}" {{ old('treatment_id') == $t->id ? 'selected' : '' }}>
                            {{ $t->name }}
                        </option>
                    @endforeach
                </select>
                @error('treatment_id')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Pilih Dokter <span class="req">*</span></label>
                <select name="doctor_id" required>
                    <option value="" disabled {{ old('doctor_id') ? '' : 'selected' }}>Pilih dokter...</option>
                    @foreach($doctors as $d)
                        <option value="{{ $d->id }}" {{ old('doctor_id') == $d->id ? 'selected' : '' }}>
                            {{ $d->full_title }}
                        </option>
                    @endforeach
                </select>
                @error('doctor_id')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="row-2">
                <div class="form-group">
                    <label>Tanggal <span class="req">*</span></label>
                    <input type="date" name="appointment_date"
                           value="{{ old('appointment_date') }}"
                           min="{{ today()->toDateString() }}" required>
                    @error('appointment_date')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Jam <span class="req">*</span></label>
                    <select name="appointment_time" required>
                        <option value="" disabled {{ old('appointment_time') ? '' : 'selected' }}>Pilih jam...</option>
                        @php
                            $slots = [];
                            $s = \Carbon\Carbon::createFromTime(9,0);
                            $e = \Carbon\Carbon::createFromTime(20,0);
                            while($s <= $e) { $slots[] = $s->format('H:i'); $s->addMinutes(15); }
                        @endphp
                        @foreach($slots as $slot)
                            <option value="{{ $slot }}" {{ old('appointment_time') == $slot ? 'selected' : '' }}>
                                {{ $slot }} WIB
                            </option>
                        @endforeach
                    </select>
                    @error('appointment_time')<div class="field-error">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Metode pembayaran --}}
            <div class="form-group">
                <div class="payment-label">Metode Pembayaran <span class="req">*</span></div>
                <div class="payment-opts">
                    <div class="pay-opt active" onclick="selectPay(this, 'tunai')">
                        <span class="pay-icon">💵</span>Tunai
                    </div>
                    <div class="pay-opt disabled" title="Segera tersedia">
                        <span class="pay-icon">💳</span>Transfer
                    </div>
                    <div class="pay-opt disabled" title="Segera tersedia">
                        <span class="pay-icon">📱</span>QRIS
                    </div>
                </div>
                <p class="pay-hint">Transfer & QRIS segera tersedia</p>
                <input type="hidden" name="payment_method" id="payment_method_input" value="tunai">
                @error('payment_method')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Keluhan / Catatan Tambahan</label>
                <textarea name="notes" rows="2"
                          placeholder="Contoh: gigi belakang kiri sakit saat makan..."
                          style="resize:none">{{ old('notes') }}</textarea>
            </div>

            <button type="submit" class="btn">Kirim Pendaftaran →</button>
        </form>

        <p class="form-note">Kami akan konfirmasi via WhatsApp dalam 1×24 jam</p>
    </div>
</div>

<script>
function selectPay(el, value) {
    if (el.classList.contains('disabled')) return;
    document.querySelectorAll('.pay-opt:not(.disabled)').forEach(o => o.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('payment_method_input').value = value;
}
</script>
</body>
</html>
