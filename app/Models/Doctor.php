<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use SoftDeletes;

    protected $table = 'doctor';

    // 🔥 WAJIB kalau pakai ID string (D001, dll)
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'full_name',
        'specialization',
        'subspecialization',
        'is_active',
        'is_flexible',
        'default_fee_percentage',
        'user_id',
        'email',
        'foto_profil',
        'ttd',
        'estimasi_konsultasi',
        'phone_number',
        'title_prefix',
        'license_no',
        'str_institution',
        'str_number',
        'str_expiry_date',
        'sip_institution',
        'sip_number',
        'sip_expiry_date',
        'job_title',
        'experience',
        'alma_mater',
        'bio',
        'shadow_image',
        'badge_1',
        'badge_2',
        'instagram_url',
        'linkedin_url',
        'carousel_order',
        'show_in_carousel',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_flexible' => 'boolean',
        'default_fee_percentage' => 'decimal:2',
        'estimasi_konsultasi' => 'integer',
        'str_expiry_date' => 'date',
        'sip_expiry_date' => 'date',
        'deleted_at' => 'datetime',
    ];

    // ================= RELATION =================

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(DoctorSchedule::class, 'doctor_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // ================= ACCESSOR =================

    /**
     * Contoh: "drg. Jane Doe Sp.Ortho"
     */
    public function getFullTitleAttribute(): string
    {
        $prefix = $this->title_prefix ? "{$this->title_prefix} " : "";
        $spec = $this->specialization ? ", {$this->specialization}" : "";
        return "{$prefix}{$this->full_name}{$spec}";
    }

    // ================= SCOPE =================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}