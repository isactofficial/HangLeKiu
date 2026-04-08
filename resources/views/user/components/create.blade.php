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

                <div class="row-2">
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
                </div>

                <div class="row-2">
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
                    <div class="form-group">
                        <label>Jenis Perawatan <span class="req">*</span></label>
                        <select name="care_type_id" required>
                            <option value="" disabled {{ old('care_type_id') ? '' : 'selected' }}>-- Pilih Jenis Perawatan --</option>
                            @foreach(($careTypes ?? []) as $ct)
                                <option value="{{ $ct->id }}" {{ old('care_type_id') == $ct->id ? 'selected' : '' }}>{{ $ct->name }}</option>
                            @endforeach
                        </select>
                        @error('care_type_id')
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
                        <div id="doctorScheduleInfo" class="pay-hint" style="display:none; margin-top:8px;"></div>
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

                <div class="form-group">
                    <label>Lama Durasi (menit)</label>
                    <input type="number" name="duration_minutes" min="1" max="480" value="{{ old('duration_minutes', 30) }}">
                    @error('duration_minutes')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field-error" id="scheduleWarning" style="display:none;"></div>

                <div class="form-group">
                    <label>Keluhan</label>
                    <input type="text" name="complaint" value="{{ old('complaint') }}" placeholder="Keluhan utama pasien">
                    @error('complaint')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Prosedur Rencana</label>
                    <input type="text" name="procedure_plan" value="{{ old('procedure_plan') }}" placeholder="Rencana tindakan">
                    @error('procedure_plan')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Informasi Kondisi Pasien</label>
                    <input type="text" name="patient_condition" value="{{ old('patient_condition') }}" placeholder="Kondisi tambahan pasien">
                    @error('patient_condition')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn">Kirim Pendaftaran →</button>
            </form>

            <p class="form-note">Kami akan konfirmasi via WhatsApp dalam 1×24 jam</p>
        </div>
    </div>

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
            scheduleInfoField.innerHTML = `Jadwal Dokter:<br>${lines.join('<br>')}`;
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
                const msg = 'Dokter tidak memiliki jadwal praktek pada tanggal ini.';
                warningField.textContent = msg;
                warningField.style.display = 'block';
                dateField.setCustomValidity(msg);
                return;
            }

            if (timeVal && (timeVal < daySchedule.start || timeVal > daySchedule.end)) {
                const msg = `Jam di luar jadwal praktek dokter (${daySchedule.start} - ${daySchedule.end}).`;
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
