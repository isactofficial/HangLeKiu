<?php

namespace App\Models;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $table     = 'user';
    public $incrementing = false;
    protected $keyType   = 'string';
    protected $with = ['role'];

    protected $fillable = [
        'id',
        'role_id',
        'name',
        'email',
        'password',
        'email_verification_token',
        'avatar_url',
        'is_active',
        'is_verified',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password'      => 'hashed',
        'is_active'     => 'boolean',
        'is_verified'   => 'boolean',
        'last_login_at' => 'datetime',
        'deleted_at'    => 'datetime',
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
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function patient(): HasOne
    {
        return $this->hasOne(Patient::class, 'user_id', 'id');
    }
}