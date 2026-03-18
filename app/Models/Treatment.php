<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Treatment extends Model
{
    protected $table = 'master_procedure';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'procedure_name', 'base_price', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
        'base_price' => 'decimal:2',
    ];

    // Kompatibilitas untuk view lama yang masih memanggil $t->name
    public function getNameAttribute(): ?string
    {
        return $this->procedure_name;
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
