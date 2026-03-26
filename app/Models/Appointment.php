<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Appointment extends Model
{
    protected $table = 'registration';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'patient_id',
        'doctor_id',
        'payment_method_id',
        'registration_date',
        'appointment_datetime',
        'admin_id',
        'poli_id',
        'guarantor_type_id',
        'payment_method_id',
        'visit_type_id',
        'care_type_id',
        'patient_type',
        'registration_date',
        'appointment_datetime',
        'duration_minutes',
        'status',
        'complaint',
        'patient_condition',
        'procedure_plan',
    ];

    protected $casts = [
<<<<<<< Updated upstream
        'registration_date' => 'date',
=======
        'registration_date'    => 'date',
>>>>>>> Stashed changes
        'appointment_datetime' => 'datetime',
    ];

    // ─── Status Colors ────────────────────────────
    const STATUS_COLORS = [
        'pending'   => '#EF4444',
        'confirmed' => '#F59E0B',
        'waiting'   => '#8B5CF6',
        'engaged'   => '#3B82F6',
        'succeed'   => '#84CC16',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function patient(): BelongsTo
    {
<<<<<<< Updated upstream
        return $this->belongsTo(Patient::class);
=======
        return $this->belongsTo(Patient::class, 'patient_id');
>>>>>>> Stashed changes
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function poli(): BelongsTo
    {
        return $this->belongsTo(MasterPoli::class, 'poli_id');
    }

    public function guarantorType(): BelongsTo
    {
        return $this->belongsTo(MasterGuarantorType::class, 'guarantor_type_id');
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(MasterPaymentMethod::class, 'payment_method_id');
    }

    public function visitType(): BelongsTo
    {
        return $this->belongsTo(MasterVisitType::class, 'visit_type_id');
    }

    public function careType(): BelongsTo
    {
        return $this->belongsTo(MasterCareType::class, 'care_type_id');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? '#6B7280';
    }

    public function getFormattedTimeAttribute(): string
    {
        if (!$this->appointment_datetime) {
            return '-';
        }

        return Carbon::parse($this->appointment_datetime)->format('H:i') . ' WIB';
<<<<<<< Updated upstream
    }

    // Kompatibilitas ke view lama yang masih memakai appointment_time
    public function getAppointmentTimeAttribute(): ?string
    {
        if (!$this->appointment_datetime) {
            return null;
        }

        return Carbon::parse($this->appointment_datetime)->format('H:i:s');
    }

    // Kompatibilitas ke view lama yang masih memakai appointment_date
    public function getAppointmentDateAttribute(): ?string
    {
        if (!$this->appointment_datetime) {
            return null;
        }

        return Carbon::parse($this->appointment_datetime)->toDateString();
    }

    // Kompatibilitas untuk kartu jadwal yang menampilkan nama pasien
    public function getPatientNameAttribute(): string
    {
        if ($this->relationLoaded('patient') && $this->patient) {
            return $this->patient->full_name;
        }

        if ($this->patient_id) {
            $patient = Patient::query()->select('full_name')->find($this->patient_id);
            if ($patient?->full_name) {
                return $patient->full_name;
            }
        }

        if ($this->complaint && preg_match('/Nama\s*:\s*(.+)/i', $this->complaint, $matches)) {
            return trim($matches[1]);
        }

        return 'Pasien';
    }

    // Kompatibilitas untuk field treatment di halaman outpatient
    public function getTreatmentNameAttribute(): string
    {
        return $this->procedure_plan ?: '-';
=======
>>>>>>> Stashed changes
    }

    // Kompatibilitas view lama
    public function getAppointmentTimeAttribute(): ?string
    {
        if (!$this->appointment_datetime) {
            return null;
        }

        return Carbon::parse($this->appointment_datetime)->format('H:i:s');
    }

    // Kompatibilitas view lama
    public function getAppointmentDateAttribute(): ?string
    {
        if (!$this->appointment_datetime) {
            return null;
        }

        return Carbon::parse($this->appointment_datetime)->toDateString();
    }

    // Nama pasien dengan fallback
    public function getPatientNameAttribute(): string
    {
        if ($this->relationLoaded('patient') && $this->patient) {
            return $this->patient->full_name;
        }

        if ($this->patient_id) {
            $patient = Patient::query()->select('full_name')->find($this->patient_id);
            if ($patient?->full_name) {
                return $patient->full_name;
            }
        }

        // Fallback dari complaint (booking publik lama)
        if ($this->complaint && preg_match('/Nama\s*:\s*(.+)/i', $this->complaint, $matches)) {
            return trim($matches[1]);
        }

        return 'Pasien';
    }

    public function getTreatmentNameAttribute(): string
    {
        return $this->procedure_plan ?: '-';
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeForDate($query, $date)
    {
        return $query->whereDate('appointment_datetime', $date);
    }

    public function scopeForDoctor($query, $doctorId)
    {
        return $query->where('doctor_id', $doctorId);
    }

    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['succeed']);
    }
}