<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OdontogramRecord extends Model
{
    protected $table = 'odontogram_records';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'patient_id',
        'visit_id',
        'examined_by',
        'notes',
        'examined_at',
    ];

    protected $casts = [
        'examined_at' => 'datetime',
    ];

    // Auto-generate UUID saat create
    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    // Relationships
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function visit()
    {
        return $this->belongsTo(MasterVisit::class, 'visit_id');
    }

    public function teeth()
    {
        return $this->hasMany(OdontogramTooth::class, 'odontogram_record_id');
    }

    // Helper: ambil semua kondisi per nomor gigi
    public function toothMap(): array
    {
        return $this->teeth
            ->groupBy('tooth_number')
            ->map(fn($items) => $items->values())
            ->toArray();
    }
}