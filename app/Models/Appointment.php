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
        'status',
        'complaint',
        'patient_condition',
        'procedure_plan',
    ];

    protected $casts = [
        'registration_date' => 'date',
        'appointment_datetime' => 'datetime',
    ];

    // Status beserta warna untuk UI
    const STATUS_COLORS = [
        'pending'   => '#EF4444',
        'confirmed' => '#F59E0B',
        'waiting'   => '#8B5CF6',
        'engaged'   => '#3B82F6',
        'succeed'   => '#84CC16',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? '#6B7280';
    }

    /**
     * Format jam: "19:30" → "19:30 WIB"
     */
    public function getFormattedTimeAttribute(): string
    {
        if (!$this->appointment_datetime) {
            return '-';
        }

        return Carbon::parse($this->appointment_datetime)->format('H:i') . ' WIB';
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
    }

    /**
     * Scope: filter berdasarkan tanggal (untuk halaman Rawat Jalan)
     */
    public function scopeForDate($query, $date)
    {
        return $query->whereDate('appointment_datetime', $date);
    }
}
