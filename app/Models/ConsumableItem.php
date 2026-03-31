<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ConsumableItem extends Model
{
    protected $table = 'consumable_items';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'item_code',
        'item_name',
        'brand',
        'initial_stock',
        'current_stock',
        'purchase_price',
        'general_price',
        'otc_price',
        'avg_hpp',
        'min_stock',
    ];

    protected $casts = [
        'initial_stock'  => 'integer',
        'current_stock'  => 'integer',
        'min_stock'      => 'integer',
        'purchase_price' => 'float',
        'general_price'  => 'float',
        'otc_price'      => 'float',
        'avg_hpp'        => 'float',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    // ─── Relationships ────────────────────────────────────────────
    public function usages()
    {
        return $this->hasMany(ConsumableUsage::class, 'bhp_id');
    }

    public function restocks()
    {
        return $this->hasMany(ConsumableRestock::class, 'bhp_id');
    }

    public function expiryLogs()
    {
        return $this->hasMany(ConsumableExpiryLog::class, 'bhp_id');
    }

    // ─── Helpers ──────────────────────────────────────────────────
    public function isLowStock(): bool
    {
        return $this->current_stock <= $this->min_stock;
    }
}