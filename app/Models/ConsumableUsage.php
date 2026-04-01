<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ConsumableUsage extends Model
{
    protected $table = 'consumable_usage';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'bhp_id',
        'treatment_id',
        'usage_type',
        'quantity_used',
        'unit_price',
        'usage_date',
        'notes',
        'created_at',
    ];

    protected $casts = [
        'quantity_used' => 'integer',
        'unit_price'    => 'float',
        'usage_date'    => 'date:Y-m-d',
        'created_at'    => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
            if (empty($model->created_at)) {
                $model->created_at = now();
            }
        });

        // Kurangi stok saat usage dibuat
        static::created(function ($model) {
            ConsumableItem::where('id', $model->bhp_id)
                ->decrement('current_stock', $model->quantity_used);
        });

        // Kembalikan stok saat usage dihapus
        static::deleted(function ($model) {
            ConsumableItem::where('id', $model->bhp_id)
                ->increment('current_stock', $model->quantity_used);
        });
    }

    public function item()
    {
        return $this->belongsTo(ConsumableItem::class, 'bhp_id');
    }
}