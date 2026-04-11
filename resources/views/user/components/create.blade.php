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

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-color: #8B5E3C;
            --secondary-color: #A98467;
            --bg-color: #F9F4EF;
            --card-bg: #FFFFFF;
            --text-main: #5B321B;
            --text-muted: #B08968;
            --label-dark-brown: #8B5E3C;
            --value-soft-brown: #A98467;
            --border-color: #EBDCCF;
        }

        html { height: 100%; }

        body {
            background: url('{{ asset("images/bg-clinic.png") }}') center center / cover no-repeat fixed;
            font-family: 'Instrument Sans', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            min-height: 100vh;
            min-width: 100%;
            overflow-x: hidden;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .form-wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 75px;
            height: calc(100vh - 75px);
            padding: 1.5rem;
            box-sizing: border-box;
        }

        .card {
            background: var(--card-bg);
            width: 100%;
            max-width: 900px;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(139, 94, 60, 0.1);
            border: 1px solid var(--border-color);
            max-height: 100%;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .card::-webkit-scrollbar { width: 8px; }
        .card::-webkit-scrollbar-track { background: transparent; }
        .card::-webkit-scrollbar-thumb { background-color: var(--border-color); border-radius: 10px; }
        .card:hover::-webkit-scrollbar-thumb { background-color: var(--secondary-color); }

        .card-form { padding: 3rem 4rem; }

        .card-form h3 {
            font-size: 2rem;
            color: var(--primary-color);
            font-weight: 800;
            margin: 0 0 0.5rem 0;
            text-align: center;
        }

        .tagline {
            text-align: center;
            color: var(--secondary-color);
            text-transform: uppercase;
            letter-spacing: 2.5px;
            font-size: 0.8rem;
            font-weight: 800;
            margin-bottom: 2.5rem;
        }

        .row-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-group { display: flex; flex-direction: column; }

        .form-group label {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--label-dark-brown);
            margin-bottom: 0.6rem;
        }

        .req { color: #e3342f; }

        .form-group input[type="text"],
        .form-group input[type="tel"],
        .form-group input[type="date"],
        .form-group input[type="time"],
        .form-group input[type="number"],
        .form-group select {
            width: 100%;
            padding: 0.85rem 1.2rem;
            border: 1.5px solid var(--border-color);
            border-radius: 12px;
            background-color: #FEFCFA;
            font-family: inherit;
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--value-soft-brown);
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .form-group input::placeholder { color: #C4A288; }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(139, 94, 60, 0.1);
            background-color: #fff;
        }

        /* Input error state */
        .form-group input.input-error,
        .form-group select.input-error {
            border-color: #EF4444;
            background-color: #FEF2F2;
        }

        /* Input warning state */
        .form-group input.input-warning,
        .form-group select.input-warning {
            border-color: #F59E0B;
            background-color: #FFFBEB;
        }

        .error-box {
            background-color: #FEF2F2;
            border: 1px solid #FCA5A5;
            color: #B91C1C;
            padding: 1.25rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            font-size: 0.85rem;
            line-height: 1.5;
        }

        .field-error {
            color: #B91C1C;
            font-size: 0.8rem;
            margin-top: 0.5rem;
            font-weight: 600;
        }

        .pay-hint {
            font-size: 0.8rem;
            color: var(--secondary-color);
            background: #FEFCFA;
            padding: 0.75rem;
            border-radius: 8px;
            border: 1px dashed var(--border-color);
            line-height: 1.5;
            margin-top: 0.5rem;
        }

        /* ===== ALERT SLOT ===== */
        /* Hard block — merah */
        .slot-alert {
            display: none;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
            line-height: 1.5;
            margin-top: -8px;
            margin-bottom: 16px;
            align-items: flex-start;
            gap: 10px;
        }
        .slot-alert.show { display: flex; }

        .slot-alert-error {
            background: #FEF2F2;
            border: 1.5px solid #FCA5A5;
            color: #B91C1C;
        }

        /* Soft warning — kuning */
        .slot-alert-warning {
            background: #FFFBEB;
            border: 1.5px solid #FCD34D;
            color: #92400E;
        }

        .slot-alert-icon {
            font-size: 1rem;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .slot-alert-text { flex: 1; }
        .slot-alert-text strong { display: block; margin-bottom: 2px; }

        /* Checking indicator */
        .slot-checking {
            display: none;
            font-size: 0.8rem;
            color: var(--secondary-color);
            margin-top: -8px;
            margin-bottom: 16px;
            align-items: center;
            gap: 8px;
        }
        .slot-checking.show { display: flex; }

        .slot-checking-spinner {
            width: 14px;
            height: 14px;
            border: 2px solid #EBDCCF;
            border-top-color: var(--primary-color);
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        /* ===== BUTTON ===== */
        .btn {
            width: 100%;
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 1.25rem;
            font-size: 1.1rem;
            font-weight: 700;
            border-radius: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
            box-shadow: 0 4px 15px rgba(139, 94, 60, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn:hover:not(:disabled) {
            background-color: #734A2E;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(139, 94, 60, 0.3);
        }

        /* Disabled state saat slot terisi */
        .btn:disabled,
        .btn.blocked {
            background-color: #D1B8A8;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
            opacity: 0.8;
        }

        .form-note {
            text-align: center;
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-top: 1.5rem;
            font-weight: 500;
        }

        .form-note-urgent {
            text-align: center;
            font-size: 0.85rem;
            color: #92400E;
            background: #FFFBEB;
            border: 1px dashed #FCD34D;
            border-radius: 8px;
            padding: 10px 16px;
            margin-top: 1.5rem;
            font-weight: 500;
            display: none;
        }
        .form-note-urgent.show { display: block; }

        @media (max-width: 640px) {
            .row-2 { grid-template-columns: 1fr; gap: 1.25rem; margin-bottom: 1.25rem; }
            .card-form { padding: 2rem 1.5rem; }
            .form-wrapper { padding: 1rem; }
            .col-span-2 { grid-column: span 1 !important; }
        }
    </style>
</head>

<body>
    @include('user.components.navbarWelcome')

    <main class="form-wrapper">
        <div class="card">
            <div class="card-form">
                <h3>Buat Janji Temu</h3>
                <p class="tagline">hanglekiu dental specialist</p>

                @if ($errors->any())
                    <div class="error-box">
                        @foreach ($errors->all() as $error)
                            <div>• {{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('appointments.store') }}" id="appointmentForm">
                    @csrf

                    <div class="row-2">
                        <div class="form-group">
                            <label>Nama Lengkap <span class="req">*</span></label>
                            <input type="text" name="patient_name" placeholder="Nama sesuai KTP"
                                value="{{ old('patient_name', $patient?->full_name ?? '') }}" required>
                            @error('patient_name')<div class="field-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label>Nomor WhatsApp <span class="req">*</span></label>
                            <input type="tel" name="patient_phone" placeholder="08xxxxxxxxxx"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                value="{{ old('patient_phone', $patient?->phone_number ?? '') }}" required>
                            @error('patient_phone')<div class="field-error">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row-2">
                        <div class="form-group">
                            <label>Tanggal Lahir <span class="req">*</span></label>
                            <input type="date" name="date_of_birth"
                                value="{{ old('date_of_birth', $patient?->date_of_birth ? $patient->date_of_birth->format('Y-m-d') : '') }}"
                                max="{{ today()->toDateString() }}" required>
                            @error('date_of_birth')<div class="field-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label>Jenis Kelamin <span class="req">*</span></label>
                            <select name="gender" required>
                                <option value="" disabled {{ old('gender', $patient?->gender ?? '') ? '' : 'selected' }}>Pilih...</option>
                                <option value="Male" {{ old('gender', $patient?->gender ?? '') === 'Male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Female" {{ old('gender', $patient?->gender ?? '') === 'Female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender')<div class="field-error">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row-2">
                        <div class="form-group">
                            <label>Tipe Pasien <span class="req">*</span></label>
                            <select name="patient_type" required>
                                <option value="non_rujuk" {{ old('patient_type', 'non_rujuk') === 'non_rujuk' ? 'selected' : '' }}>Pasien Non Rujuk</option>
                                <option value="rujuk" {{ old('patient_type') === 'rujuk' ? 'selected' : '' }}>Pasien Rujuk</option>
                            </select>
                            @error('patient_type')<div class="field-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label>Penjamin <span class="req">*</span></label>
                            <select name="guarantor_type_id" required>
                                <option value="" disabled {{ old('guarantor_type_id') ? '' : 'selected' }}>-- Pilih Penjamin --</option>
                                @foreach(($guarantorTypes ?? []) as $gt)
                                    <option value="{{ $gt->id }}" {{ old('guarantor_type_id') == $gt->id ? 'selected' : '' }}>{{ $gt->name }}</option>
                                @endforeach
                            </select>
                            @error('guarantor_type_id')<div class="field-error">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row-2">
                        <div class="form-group">
                            <label>Metode Pembayaran <span class="req">*</span></label>
                            <select name="payment_method_id" required>
                                <option value="" disabled {{ old('payment_method_id') ? '' : 'selected' }}>-- Pilih Metode Bayar --</option>
                                @foreach(($paymentMethods ?? []) as $pm)
                                    <option value="{{ $pm->id }}" {{ old('payment_method_id') == $pm->id ? 'selected' : '' }}>{{ $pm->name }}</option>
                                @endforeach
                            </select>
                            @error('payment_method_id')<div class="field-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label>Jenis Kunjungan <span class="req">*</span></label>
                            <select name="visit_type_id" required>
                                <option value="" disabled {{ old('visit_type_id') ? '' : 'selected' }}>-- Pilih Jenis Kunjungan --</option>
                                @foreach(($visitTypes ?? []) as $vt)
                                    <option value="{{ $vt->id }}" {{ old('visit_type_id') == $vt->id ? 'selected' : '' }}>{{ $vt->name }}</option>
                                @endforeach
                            </select>
                            @error('visit_type_id')<div class="field-error">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row-2">
                        <div class="form-group">
                            <label>Poli <span class="req">*</span></label>
                            <select name="poli_id" required>
                                <option value="" disabled {{ old('poli_id') ? '' : 'selected' }}>-- Pilih Poli --</option>
                                @foreach(($polis ?? []) as $poli)
                                    <option value="{{ $poli->id }}" {{ old('poli_id') == $poli->id ? 'selected' : '' }}>{{ $poli->name }}</option>
                                @endforeach
                            </select>
                            @error('poli_id')<div class="field-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label>Tenaga Medis <span class="req">*</span></label>
                            <select name="doctor_id" id="doctor_id" required>
                                <option value="" disabled {{ old('doctor_id') ? '' : 'selected' }}>-- Pilih Dokter --</option>
                                @foreach ($doctors as $d)
                                    <option value="{{ $d->id }}" {{ old('doctor_id') == $d->id ? 'selected' : '' }}>
                                        {{ $d->full_title }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="doctorScheduleInfo" class="pay-hint" style="display:none;"></div>
                            @error('doctor_id')<div class="field-error">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- Tanggal & Jam — trigger slot check --}}
                    <div class="row-2">
                        <div class="form-group">
                            <label>Tanggal <span class="req">*</span></label>
                            <input type="date" id="appointment_date" name="appointment_date"
                                value="{{ old('appointment_date') }}"
                                min="{{ today()->toDateString() }}" required>
                            @error('appointment_date')<div class="field-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label>Jam <span class="req">*</span></label>
                            <input type="time" name="appointment_time" id="appointment_time"
                                value="{{ old('appointment_time') }}" required>
                            @error('appointment_time')<div class="field-error">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- Jadwal dokter warning --}}
                    <div class="field-error" id="scheduleWarning" style="display:none; margin-top:-10px; margin-bottom:15px;"></div>

                    {{-- Slot checking indicator --}}
                    <div class="slot-checking" id="slotChecking">
                        <div class="slot-checking-spinner"></div>
                        <span>Mengecek ketersediaan slot...</span>
                    </div>

                    {{-- HARD BLOCK: slot terisi --}}
                    <div class="slot-alert slot-alert-error" id="slotErrorAlert">
                        <span class="slot-alert-icon">🚫</span>
                        <div class="slot-alert-text">
                            <strong>Slot Sudah Terisi</strong>
                            <span id="slotErrorMsg">Dokter ini sudah memiliki pasien pada jam yang dipilih. Silakan pilih jam lain.</span>
                        </div>
                    </div>

                    {{-- SOFT WARNING: H-0 atau H-1 --}}
                    <div class="slot-alert slot-alert-warning" id="slotUrgentAlert">
                        <span class="slot-alert-icon">⚠️</span>
                        <div class="slot-alert-text">
                            <strong>Jadwal Sangat Dekat</strong>
                            Kamu mendaftar untuk hari ini atau besok. Pastikan nomor WhatsApp aktif — kami akan menghubungi kamu lebih cepat dari biasanya untuk konfirmasi.
                        </div>
                    </div>

                    <div class="row-2">
                        <div class="form-group">
                            <label>Jenis Perawatan <span class="req">*</span></label>
                            <select name="care_type_id" required>
                                <option value="" disabled {{ old('care_type_id') ? '' : 'selected' }}>-- Pilih Perawatan --</option>
                                @foreach(($careTypes ?? []) as $ct)
                                    <option value="{{ $ct->id }}" {{ old('care_type_id') == $ct->id ? 'selected' : '' }}>{{ $ct->name }}</option>
                                @endforeach
                            </select>
                            @error('care_type_id')<div class="field-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label>Lama Durasi (menit)</label>
                            <input type="number" name="duration_minutes" min="1" max="480" value="{{ old('duration_minutes', 30) }}">
                            @error('duration_minutes')<div class="field-error">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row-2">
                        <div class="form-group">
                            <label>Keluhan</label>
                            <input type="text" name="complaint" value="{{ old('complaint') }}" placeholder="Keluhan utama pasien">
                            @error('complaint')<div class="field-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label>Prosedur Rencana</label>
                            <input type="text" name="procedure_plan" value="{{ old('procedure_plan') }}" placeholder="Rencana tindakan (opsional)">
                            @error('procedure_plan')<div class="field-error">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row-2">
                        <div class="form-group col-span-2" style="grid-column: span 2;">
                            <label>Informasi Kondisi Pasien</label>
                            <input type="text" name="patient_condition" value="{{ old('patient_condition') }}" placeholder="Kondisi tambahan (alergi obat, hamil, dll)">
                            @error('patient_condition')<div class="field-error">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <button type="submit" class="btn" id="submitBtn">
                        <span id="submitLabel">Kirim Pendaftaran →</span>
                    </button>
                </form>

                {{-- Note normal --}}
                <p class="form-note" id="formNoteNormal">
                    Kami akan mengonfirmasi pendaftaran Anda via WhatsApp dalam 1×24 jam
                </p>

                {{-- Note urgent (H-0/H-1) --}}
                <p class="form-note-urgent" id="formNoteUrgent">
                    ⚡ Karena jadwal sangat dekat, konfirmasi akan kami lakukan lebih cepat — pastikan WhatsApp aktif!
                </p>
            </div>
        </div>
    </main>

    @php
        $doctorSchedules = $doctors->mapWithKeys(function ($doctor) {
            $schedules = $doctor->schedules
                ->where('is_active', true)
                ->mapWithKeys(function ($schedule) {
                    return [
                        $schedule->day => [
                            'start' => \Carbon\Carbon::parse($schedule->start_time)->format('H:i'),
                            'end'   => \Carbon\Carbon::parse($schedule->end_time)->format('H:i'),
                        ],
                    ];
                });
            return [$doctor->id => $schedules];
        });
    @endphp

    <script>
        const doctorSchedules = @json($doctorSchedules);
        const dayMap = ['sunday','monday','tuesday','wednesday','thursday','friday','saturday'];
        const dayLabelMap = {
            monday:'Senin', tuesday:'Selasa', wednesday:'Rabu',
            thursday:'Kamis', friday:'Jumat', saturday:'Sabtu', sunday:'Minggu',
        };

        // Elements
        const doctorField       = document.getElementById('doctor_id');
        const dateField         = document.getElementById('appointment_date');
        const timeField         = document.getElementById('appointment_time');
        const warningField      = document.getElementById('scheduleWarning');
        const scheduleInfoField = document.getElementById('doctorScheduleInfo');
        const submitBtn         = document.getElementById('submitBtn');
        const submitLabel       = document.getElementById('submitLabel');

        // Slot alert elements
        const slotChecking     = document.getElementById('slotChecking');
        const slotErrorAlert   = document.getElementById('slotErrorAlert');
        const slotErrorMsg     = document.getElementById('slotErrorMsg');
        const slotUrgentAlert  = document.getElementById('slotUrgentAlert');
        const formNoteNormal   = document.getElementById('formNoteNormal');
        const formNoteUrgent   = document.getElementById('formNoteUrgent');

        // State
        let slotCheckTimeout = null;
        let isSlotBlocked    = false;

        // ============================================================
        // DOCTOR SCHEDULE INFO
        // ============================================================
        function renderDoctorScheduleInfo() {
            const doctorId = doctorField?.value;
            if (!doctorId) { scheduleInfoField.style.display = 'none'; return; }

            const schedules = doctorSchedules?.[doctorId] || {};
            const dayKeys   = Object.keys(schedules);

            if (dayKeys.length === 0) {
                scheduleInfoField.style.display = 'block';
                scheduleInfoField.textContent = 'Dokter belum memiliki jadwal praktek aktif.';
                return;
            }

            const orderedDays = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
            const lines = orderedDays
                .filter(day => schedules[day])
                .map(day => `${dayLabelMap[day]}: ${schedules[day].start} - ${schedules[day].end}`);

            scheduleInfoField.style.display = 'block';
            scheduleInfoField.innerHTML = `<strong>Jadwal Praktek Dokter:</strong><br>${lines.join('<br>')}`;
        }

        // ============================================================
        // VALIDATE DOCTOR SCHEDULE (jam di luar jadwal praktek)
        // ============================================================
        function validateDoctorSchedule() {
            const doctorId = doctorField?.value;
            const dateVal  = dateField?.value;
            const timeVal  = timeField?.value;

            warningField.style.display = 'none';
            timeField.setCustomValidity('');
            dateField.setCustomValidity('');

            if (!doctorId || !dateVal) return true;

            const schedules  = doctorSchedules?.[doctorId] || {};
            const dayKey     = dayMap[new Date(dateVal + 'T00:00:00').getDay()];
            const daySchedule = schedules?.[dayKey];

            if (!daySchedule) {
                const msg = 'Dokter tidak memiliki jadwal praktek pada tanggal ini. Pilih tanggal lain.';
                warningField.textContent   = msg;
                warningField.style.display = 'block';
                dateField.setCustomValidity(msg);
                return false;
            }

            if (timeVal && (timeVal < daySchedule.start || timeVal > daySchedule.end)) {
                const msg = `Jam yang dipilih di luar jadwal praktek (${daySchedule.start} - ${daySchedule.end}).`;
                warningField.textContent   = msg;
                warningField.style.display = 'block';
                timeField.setCustomValidity(msg);
                return false;
            }

            return true;
        }

        // ============================================================
        // URGENT CHECK (H-0 / H-1)
        // ============================================================
        function checkUrgent(dateVal) {
            if (!dateVal) {
                slotUrgentAlert.classList.remove('show');
                formNoteNormal.style.display  = 'block';
                formNoteUrgent.classList.remove('show');
                return;
            }

            const today    = new Date(); today.setHours(0,0,0,0);
            const tomorrow = new Date(today); tomorrow.setDate(today.getDate() + 1);
            const selected = new Date(dateVal + 'T00:00:00');

            const isUrgent = selected <= tomorrow;

            slotUrgentAlert.classList.toggle('show', isUrgent && !isSlotBlocked);
            formNoteNormal.style.display = isUrgent ? 'none' : 'block';
            formNoteUrgent.classList.toggle('show', isUrgent && !isSlotBlocked);
        }

        // ============================================================
        // HARD BLOCK — CEK SLOT VIA AJAX
        // ============================================================
        function resetSlotState() {
            slotChecking.classList.remove('show');
            slotErrorAlert.classList.remove('show');
            isSlotBlocked = false;
            submitBtn.disabled = false;
            submitBtn.classList.remove('blocked');
            submitLabel.textContent = 'Kirim Pendaftaran →';

            // Hapus visual error dari input tanggal & jam
            dateField.classList.remove('input-error');
            timeField.classList.remove('input-error');
        }

        async function checkSlotAvailability() {
            const doctorId = doctorField?.value;
            const dateVal  = dateField?.value;
            const timeVal  = timeField?.value;

            // Reset dulu
            resetSlotState();

            // Cek urgent
            checkUrgent(dateVal);

            // Butuh semua 3 field untuk cek slot
            if (!doctorId || !dateVal || !timeVal) return;

            // Validasi jadwal dokter dulu — kalau gagal, skip cek slot
            if (!validateDoctorSchedule()) return;

            // Tampilkan checking indicator
            slotChecking.classList.add('show');
            submitBtn.disabled = true;
            submitLabel.textContent = 'Mengecek slot...';

            try {
                const res = await fetch(
                    `/appointments/check-slot?doctor_id=${doctorId}&date=${dateVal}&time=${timeVal}`,
                    {
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        }
                    }
                );

                const data = await res.json();

                slotChecking.classList.remove('show');

                if (data.available === false) {
                    // ❌ HARD BLOCK
                    isSlotBlocked = true;
                    slotErrorAlert.classList.add('show');
                    slotUrgentAlert.classList.remove('show'); // sembunyikan warning kalau block
                    formNoteUrgent.classList.remove('show');
                    formNoteNormal.style.display = 'block';

                    slotErrorMsg.textContent = data.message
                        || 'Dokter ini sudah memiliki pasien pada jam yang dipilih. Silakan pilih jam lain.';

                    // Visual error pada input
                    dateField.classList.add('input-error');
                    timeField.classList.add('input-error');

                    // Disable submit
                    submitBtn.disabled = true;
                    submitBtn.classList.add('blocked');
                    submitLabel.textContent = '🚫 Slot Tidak Tersedia';

                } else {
                    // ✅ Slot kosong
                    isSlotBlocked = false;
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('blocked');
                    submitLabel.textContent = 'Kirim Pendaftaran →';

                    // Re-check urgent setelah slot aman
                    checkUrgent(dateVal);
                }

            } catch (err) {
                // Kalau gagal request, jangan block user — biarkan lanjut
                slotChecking.classList.remove('show');
                submitBtn.disabled = false;
                submitLabel.textContent = 'Kirim Pendaftaran →';
                console.warn('Slot check failed:', err);
            }
        }

        // ============================================================
        // EVENT LISTENERS
        // ============================================================
        doctorField?.addEventListener('change', () => {
            renderDoctorScheduleInfo();
            // Debounce
            clearTimeout(slotCheckTimeout);
            slotCheckTimeout = setTimeout(checkSlotAvailability, 300);
        });

        dateField?.addEventListener('change', () => {
            clearTimeout(slotCheckTimeout);
            slotCheckTimeout = setTimeout(checkSlotAvailability, 300);
        });

        timeField?.addEventListener('change', () => {
            clearTimeout(slotCheckTimeout);
            slotCheckTimeout = setTimeout(checkSlotAvailability, 500);
        });

        // Guard: jangan submit kalau slot blocked
        document.getElementById('appointmentForm')?.addEventListener('submit', function(e) {
            if (isSlotBlocked) {
                e.preventDefault();
                slotErrorAlert.classList.add('show');
                return false;
            }
        });

        // Init
        renderDoctorScheduleInfo();
        validateDoctorSchedule();
        checkUrgent(dateField?.value);
    </script>
</body>
</html>