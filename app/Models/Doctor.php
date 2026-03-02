<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    protected $fillable = ['name', 'specialization', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Nama lengkap dengan gelar & spesialisasi
     * Contoh: "drg. Jane Doe Sp.Ortho"
     */
    public function getFullTitleAttribute(): string
    {
        return $this->specialization
            ? "{$this->name} {$this->specialization}"
            : $this->name;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
