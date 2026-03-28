<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OdontogramTooth extends Model
{
    protected $table = 'odontogram_teeth';
    protected $keyType = 'string';
    public $incrementing = false;

    const UPDATED_AT = null;       // tidak ada kolom updated_at
    public $timestamps = true;     // aktifkan manajemen timestamp Laravel

    protected $fillable = [
        'id',
        'odontogram_record_id',
        'tooth_number',
        'surfaces',
        'condition_code',
        'condition_label',
        'color_code',
        'notes',
    ];

    protected $casts = [
        'tooth_number' => 'integer',
        'created_at'   => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    // ----------------------------------------------------------------
    // Relationships
    // ----------------------------------------------------------------
    public function record()
    {
        return $this->belongsTo(OdontogramRecord::class, 'odontogram_record_id');
    }

    // ----------------------------------------------------------------
    // Accessors
    // ----------------------------------------------------------------

    /**
     * surfaces sebagai array, misal "M,D,O" → ['M','D','O']
     */
    public function getSurfacesArrayAttribute(): array
    {
        return $this->surfaces
            ? array_map('trim', explode(',', $this->surfaces))
            : [];
    }
}