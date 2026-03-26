<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    protected $table = 'doctor';
    protected $fillable = ['full_name', 'specialization', 'subspecialization', 'is_active', 'user_id', 'email', 'phone_number', 'title_prefix', 'license_no', 'str_institution', 'str_number', 'str_expiry_date', 'sip_institution', 'sip_number', 'sip_expiry_date', 'job_title'];

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
            ? "{$this->full_name} {$this->specialization}"
            : $this->full_name;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
