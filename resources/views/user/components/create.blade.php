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
            --text-main: #333333;
            --text-muted: #777777;
            --border-color: #EBDCCF;
        }

        html {
            height: 100%;
        }

        /* 1. Kunci Body agar layar utama tidak bisa di-scroll */
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

        /* 2. Form Wrapper untuk menengahkan form di sisa layar */
        .form-wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 75px; /* Jarak aman agar tidak tertutup navbar fixed */
            height: calc(100vh - 75px); /* Sisa tinggi layar */
            padding: 1.5rem; 
            box-sizing: border-box;
        }

        /* 3. Card Form 2 Kolom - Bisa di-scroll mandiri */
        .card {
            background: var(--card-bg);
            width: 100%;
            max-width: 900px; /* Ukuran lebar pas untuk 2 kolom */
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(139, 94, 60, 0.1);
            border: 1px solid var(--border-color);
            
            /* Agar isi kotak bisa di-scroll */
            max-height: 100%; 
            overflow-y: auto; 
            display: flex;
            flex-direction: column;
        }

        /* Styling Scrollbar agar lebih cantik */
        .card::-webkit-scrollbar {
            width: 8px;
        }
        .card::-webkit-scrollbar-track {
            background: transparent;
        }
        .card::-webkit-scrollbar-thumb {
            background-color: var(--border-color);
            border-radius: 10px;
        }
        .card:hover::-webkit-scrollbar-thumb {
            background-color: var(--secondary-color);
        }

        .card-form {
            padding: 3rem 4rem;
        }

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

        /* Grid System 2 Kolom */
        .row-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem; 
            margin-bottom: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        /* Input Styling */
        .form-group label {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-main);
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
            color: var(--text-main);
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(139, 94, 60, 0.1);
            background-color: #fff;
        }

        /* Error Styling */
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

        /* Button Styling */
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
        }

        .btn:hover {
            background-color: #734A2E;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(139, 94, 60, 0.3);
        }

        .form-note {
            text-align: center;
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-top: 1.5rem;
            font-weight: 500;
        }

        /* Responsive HP (1 Kolom) */
        @media (max-width: 640px) {
            .row-2 { grid-template-columns: 1fr; gap: 1.25rem; margin-bottom: 1.25rem;}
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

                <form method="POST" action="{{ route('appointments.store') }}">
                    @csrf

                    <div class="row-2">
                        <div class="form-group">
                            <label>Nama Lengkap <span class="req">*</span></label>
                            <input type="text" name="patient_name" placeholder="Nama sesuai KTP"
                                value="{{ old('patient_name', $patient?->full_name ?? '') }}" required>
                            @error('patient_name')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Nomor WhatsApp <span class="req">*</span></label>
                            <input type="tel" name="patient_phone" placeholder="08xxxxxxxxxx"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                value="{{ old('patient_phone', $patient?->phone_number ?? '') }}" required>
                            @error('patient_phone')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row-2">
                        <div class="form-group">
                            <label>Tanggal Lahir <span class="req">*</span></label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $patient?->date_of_birth ? $patient->date_of_birth->format('Y-m-d') : '') }}"            
                            max="{{ today()->toDateString() }}" required>                
                            @error('date_of_birth')                
                                <div class="field-error">{{ $message }}</div>               
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Jenis Kelamin <span class="req">*</span></label>        
                            <select name="gender" required>
                                <option value="" disabled {{ old('gender', $patient?->gender ?? '') ? '' : 'selected' }}>Pilih...</option>                    
                                <option value="Male" {{ old('gender', $patient?->gender ?? '') === 'Male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Female" {{ old('gender', $patient?->gender ?? '') === 'Female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender')            
                                <div class="field-error">{{ $message }}</div>        
                            @enderror    
                        </div>
                    </div>

                    <div class="row-2">
                        <div class="form-group">
                            <label>Tipe Pasien <span class="req">*</span></label>
                            <select name="patient_type" required>
                                <option value="non_rujuk" {{ old('patient_type', 'non_rujuk') === 'non_rujuk' ? 'selected' : '' }}>Pasien Non Rujuk</option>
                                <option value="rujuk" {{ old('patient_type') === 'rujuk' ? 'selected' : '' }}>Pasien Rujuk</option>
                            </select>
                            @error('patient_type')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Penjamin <span class="req">*</span></label>
                            <select name="guarantor_type_id" required>
                                <option value="" disabled {{ old('guarantor_type_id') ? '' : 'selected' }}>-- Pilih Penjamin --</option>
                                @foreach(($guarantorTypes ?? []) as $gt)
                                    <option value="{{ $gt->id }}" {{ old('guarantor_type_id') == $gt->id ? 'selected' : '' }}>{{ $gt->name }}</option>
                                @endforeach
                            </select>
                            @error('guarantor_type_id')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
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
                            @error('payment_method_id')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Jenis Kunjungan <span class="req">*</span></label>
                            <select name="visit_type_id" required>
                                <option value="" disabled {{ old('visit_type_id') ? '' : 'selected' }}>-- Pilih Jenis Kunjungan --</option>
                                @foreach(($visitTypes ?? []) as $vt)
                                    <option value="{{ $vt->id }}" {{ old('visit_type_id') == $vt->id ? 'selected' : '' }}>{{ $vt->name }}</option>
                                @endforeach
                            </select>
                            @error('visit_type_id')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
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
                            @error('poli_id')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
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
                            @error('doctor_id')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row-2">
                        <div class="form-group">
                            <label>Tanggal <span class="req">*</span></label>
                            <input type="date" id="appointment_date" name="appointment_date" value="{{ old('appointment_date') }}"
                                min="{{ today()->toDateString() }}" required>
                            @error('appointment_date')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Jam <span class="req">*</span></label>
                            <input type="time" name="appointment_time" id="appointment_time" value="{{ old('appointment_time') }}" required>
                            @error('appointment_time')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="field-error" id="scheduleWarning" style="display:none; margin-top:-10px; margin-bottom:15px;"></div>

                    <div class="row-2">
                        <div class="form-group">
                            <label>Jenis Perawatan <span class="req">*</span></label>
                            <select name="care_type_id" required>
                                <option value="" disabled {{ old('care_type_id') ? '' : 'selected' }}>-- Pilih Perawatan --</option>
                                @foreach(($careTypes ?? []) as $ct)
                                    <option value="{{ $ct->id }}" {{ old('care_type_id') == $ct->id ? 'selected' : '' }}>{{ $ct->name }}</option>
                                @endforeach
                            </select>
                            @error('care_type_id')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Lama Durasi (menit)</label>
                            <input type="number" name="duration_minutes" min="1" max="480" value="{{ old('duration_minutes', 30) }}">
                            @error('duration_minutes')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row-2">
                        <div class="form-group">
                            <label>Keluhan</label>
                            <input type="text" name="complaint" value="{{ old('complaint') }}" placeholder="Keluhan utama pasien">
                            @error('complaint')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Prosedur Rencana</label>
                            <input type="text" name="procedure_plan" value="{{ old('procedure_plan') }}" placeholder="Rencana tindakan (opsional)">
                            @error('procedure_plan')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row-2">
                        <div class="form-group col-span-2" style="grid-column: span 2;">
                            <label>Informasi Kondisi Pasien</label>
                            <input type="text" name="patient_condition" value="{{ old('patient_condition') }}" placeholder="Kondisi tambahan (alergi obat, hamil, dll)">
                            @error('patient_condition')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn">Kirim Pendaftaran &rarr;</button>
                </form>

                <p class="form-note">Kami akan mengonfirmasi pendaftaran Anda via WhatsApp dalam 1×24 jam</p>
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
                            'end' => \Carbon\Carbon::parse($schedule->end_time)->format('H:i'),
                        ],
                    ];
                });

            return [$doctor->id => $schedules];
        });
    @endphp

    <script>
        const doctorSchedules = @json($doctorSchedules);
        const dayMap = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

        const doctorField = document.getElementById('doctor_id');
        const dateField = document.getElementById('appointment_date');
        const timeField = document.getElementById('appointment_time');
        const warningField = document.getElementById('scheduleWarning');
        const scheduleInfoField = document.getElementById('doctorScheduleInfo');

        const dayLabelMap = {
            monday: 'Senin',
            tuesday: 'Selasa',
            wednesday: 'Rabu',
            thursday: 'Kamis',
            friday: 'Jumat',
            saturday: 'Sabtu',
            sunday: 'Minggu',
        };

        function renderDoctorScheduleInfo() {
            const doctorId = doctorField?.value;

            if (!doctorId) {
                scheduleInfoField.style.display = 'none';
                scheduleInfoField.textContent = '';
                return;
            }

            const schedules = doctorSchedules?.[doctorId] || {};
            const dayKeys = Object.keys(schedules);

            if (dayKeys.length === 0) {
                scheduleInfoField.style.display = 'block';
                scheduleInfoField.textContent = 'Dokter belum memiliki jadwal praktek aktif.';
                return;
            }

            const orderedDays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
            const lines = orderedDays
                .filter((day) => schedules[day])
                .map((day) => `${dayLabelMap[day]}: ${schedules[day].start} - ${schedules[day].end}`);

            scheduleInfoField.style.display = 'block';
            scheduleInfoField.innerHTML = `<strong>Jadwal Praktek Dokter:</strong><br>${lines.join('<br>')}`;
        }

        function validateDoctorSchedule() {
            const doctorId = doctorField?.value;
            const dateVal = dateField?.value;
            const timeVal = timeField?.value;

            if (!warningField || !dateField || !timeField) return;

            warningField.style.display = 'none';
            timeField.setCustomValidity('');
            dateField.setCustomValidity('');

            if (!doctorId || !dateVal) return;

            const schedules = doctorSchedules?.[doctorId] || {};
            const dayKey = dayMap[new Date(dateVal + 'T00:00:00').getDay()];
            const daySchedule = schedules?.[dayKey];

            if (!daySchedule) {
                const msg = 'Peringatan: Dokter tidak memiliki jadwal praktek pada tanggal ini.';
                warningField.textContent = msg;
                warningField.style.display = 'block';
                dateField.setCustomValidity(msg);
                return;
            }

            if (timeVal && (timeVal < daySchedule.start || timeVal > daySchedule.end)) {
                const msg = `Peringatan: Jam yang dipilih berada di luar jadwal praktek (${daySchedule.start} - ${daySchedule.end}).`;
                warningField.textContent = msg;
                warningField.style.display = 'block';
                timeField.setCustomValidity(msg);
                return;
            }
        }

        doctorField?.addEventListener('change', () => {
            renderDoctorScheduleInfo();
            validateDoctorSchedule();
        });
        dateField?.addEventListener('change', validateDoctorSchedule);
        timeField?.addEventListener('change', validateDoctorSchedule);

        renderDoctorScheduleInfo();
        validateDoctorSchedule();
    </script>
</body>

</html>