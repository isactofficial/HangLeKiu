<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use HasFactory, SoftDeletes;

    // UUID — WAJIB ada dua baris ini, tanpanya insert/find selalu gagal
    protected $keyType      = 'string';
    public    $incrementing = false;

    protected $fillable = [
        'id',
        'photo',
        'name',
        'profession',
        'comment',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('ordered', function ($builder) {
            $builder->orderBy('order')->orderBy('created_at');
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // ✅ ADDED: For home page - only active, ordered
    public function scopeForHomepage($query)
    {
        return $query->active()->orderBy('order')->limit(20);
    }
}