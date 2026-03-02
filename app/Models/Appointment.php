<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'patient_name',
        'patient_phone',
        'doctor_id',
        'treatment_id',
        'appointment_date',
        'appointment_time',
        'payment_method',
        'status',
        'notes',
    ];

    protected $casts = [
        'appointment_date' => 'date',
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

    public function treatment(): BelongsTo
    {
        return $this->belongsTo(Treatment::class);
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
        return \Carbon\Carbon::parse($this->appointment_time)->format('H:i') . ' WIB';
    }

    /**
     * Scope: filter berdasarkan tanggal (untuk halaman Rawat Jalan)
     */
    public function scopeForDate($query, $date)
    {
        return $query->where('appointment_date', $date);
    }
}
