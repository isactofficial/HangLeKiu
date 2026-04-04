<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Appointment extends Model
{
    use SoftDeletes; 

    protected $table = 'registration';
    protected $keyType = 'string';
    public $incrementing = false;

    // public $timestamps = false; // <-- INI SUDAH DIHAPUS BIAR created_at OTOMATIS JALAN!

    protected $appends = ['formatted_time', 'formatted_created_at'];

    // Sudah dibersihkan dari duplikat
    protected $fillable = [
        'id', // Hapus ini dari fillable jika 'id' Auto Increment
        'patient_id',
        'doctor_id',
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
        'registration_date'    => 'date',
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
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id'); // Pastikan model User sudah di-import di atas jika tidak se-folder
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

    /**
     * Get Bootstrap-compatible badge class for status
     */
    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'pending'   => 'badge-pending',
            'confirmed' => 'badge-confirmed',
            'waiting'   => 'badge-waiting',
            'engaged'   => 'badge-engaged',
            'succeed'   => 'badge-succeed',
            default     => 'badge-default'
        };
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

    /**
     * Format created_at: "d M Y H:i"
     */
    public function getFormattedCreatedAtAttribute(): string
    {
        return $this->created_at ? $this->created_at->format('d M Y H:i') : '-';
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

    public function medicalProcedures()
    {
    // Sesuaikan 'appointment_id' jika nama kolom foreign key di tabel prosedur berbeda
        return $this->hasMany(MedicalProcedure::class, 'registration_id'); 
    }


}