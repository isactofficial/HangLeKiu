<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Rawat Jalan — Hanglekiu Dental Specialist</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/user/components/create.css') }}">
</head>

<body>
    <div class="card">
        <div class="card-form">
            <h3>Buat Janji Temu</h3>
            <p class="tagline">hanglekiu dental specialist</p>

            @if ($errors->any())
                <div class="error-box">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('appointments.store') }}">
                @csrf

                <div class="form-group">
                    <label>Nama Lengkap <span class="req">*</span></label>
                    <input type="text" name="patient_name" placeholder="Nama sesuai KTP"
                        value="{{ old('patient_name') }}" required>
                    @error('patient_name')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Nomor WhatsApp <span class="req">*</span></label>
                    <input type="tel" name="patient_phone" placeholder="08xxxxxxxxxx"
                        value="{{ old('patient_phone') }}" required>
                    @error('patient_phone')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Jenis Perawatan <span class="req">*</span></label>
                    <select name="treatment_id" required>
                        <option value="" disabled {{ old('treatment_id') ? '' : 'selected' }}>Pilih perawatan...
                        </option>
                        @foreach ($treatments as $t)
                            <option value="{{ $t->id }}" {{ old('treatment_id') == $t->id ? 'selected' : '' }}>
                                {{ $t->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('treatment_id')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Pilih Dokter <span class="req">*</span></label>
                    <select name="doctor_id" required>
                        <option value="" disabled {{ old('doctor_id') ? '' : 'selected' }}>Pilih dokter...
                        </option>
                        @foreach ($doctors as $d)
                            <option value="{{ $d->id }}" {{ old('doctor_id') == $d->id ? 'selected' : '' }}>
                                {{ $d->full_title }}
                            </option>
                        @endforeach
                    </select>
                    @error('doctor_id')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row-2">
                    <div class="form-group">
                        <label>Tanggal <span class="req">*</span></label>
                        <input type="date" name="appointment_date" value="{{ old('appointment_date') }}"
                            min="{{ today()->toDateString() }}" required>
                        @error('appointment_date')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Jam <span class="req">*</span></label>
                        <select name="appointment_time" required>
                            <option value="" disabled {{ old('appointment_time') ? '' : 'selected' }}>Pilih
                                jam...</option>
                            @php
                                $slots = [];
                                $s = \Carbon\Carbon::createFromTime(9, 0);
                                $e = \Carbon\Carbon::createFromTime(20, 0);
                                while ($s <= $e) {
                                    $slots[] = $s->format('H:i');
                                    $s->addMinutes(15);
                                }
                            @endphp
                            @foreach ($slots as $slot)
                                <option value="{{ $slot }}"
                                    {{ old('appointment_time') == $slot ? 'selected' : '' }}>
                                    {{ $slot }} WIB
                                </option>
                            @endforeach
                        </select>
                        @error('appointment_time')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Metode pembayaran --}}
                <div class="form-group">
                    <div class="payment-label">Metode Pembayaran <span class="req">*</span></div>
                    <div class="payment-opts">
                        <div class="pay-opt active" onclick="selectPay(this, 'tunai')">
                            Tunai
                        </div>
                        <div class="pay-opt disabled" title="Segera tersedia">
                            Transfer
                        </div>
                        <div class="pay-opt disabled" title="Segera tersedia">
                            QRIS
                        </div>
                    </div>
                    <p class="pay-hint">Transfer & QRIS segera tersedia</p>
                    <input type="hidden" name="payment_method" id="payment_method_input" value="tunai">
                    @error('payment_method')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Keluhan / Catatan Tambahan</label>
                    <textarea name="notes" rows="2" placeholder="Contoh: gigi belakang kiri sakit saat makan..."
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
