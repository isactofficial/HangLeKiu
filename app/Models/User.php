<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'user';

    protected $keyType = 'string';

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'role_id',
        'name',
        'email',
        'password',
        'avatar_url',
        'is_active',
        'is_verified',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_active' => 'boolean',
            'is_verified' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    public function roleRecord(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function getRoleAttribute(): ?string
    {
        $role = $this->relationLoaded('roleRecord')
            ? $this->getRelation('roleRecord')
            : $this->roleRecord()->first();

        if (! $role) {
            return null;
        }

        $code = strtoupper((string) $role->code);

        if ($code === 'ADM' || $code === 'OWN') {
            return 'admin';
        }

        if ($code === 'PAT') {
            return 'user';
        }

        if ($code === 'DCT') {
            return 'doctor';
        }

        return strtolower((string) $role->name);
    }
}
