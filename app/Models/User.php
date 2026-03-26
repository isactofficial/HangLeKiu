<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
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

    // ── JWT ───────────────────────────────────────────
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [
            'role'  => $this->role?->code,
            'email' => $this->email,
            'name'  => $this->name,
        ];
    }

    // ── Relations ─────────────────────────────────────
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}