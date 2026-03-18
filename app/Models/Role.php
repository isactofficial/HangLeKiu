<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Role extends Model
{
    protected $table     = 'role'; // tabel singular sesuai ERD tim
    public $incrementing = false;
    protected $keyType   = 'string';
    public $timestamps   = false;  // hanya ada created_at, tidak ada updated_at

    protected $fillable = [
        'id',
        'code',
        'name',
        'permissions',
    ];

    protected $casts = [
        'permissions' => 'array',
        'created_at'  => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    // ── Relations ─────────────────────────────────────
    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}