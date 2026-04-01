<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ConsumableExpiryLog extends Model
{
    protected $table = 'consumable_expiry_log';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'bhp_id',
        'quantity_expired',
        'expiry_date',
        'notes',
        'created_at',
    ];

    protected $casts = [
        'quantity_expired' => 'integer',
        'expiry_date'      => 'date:Y-m-d',
        'created_at'       => 'datetime',
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

        // Kurangi stok saat barang kadaluarsa dicatat
        static::created(function ($model) {
            ConsumableItem::where('id', $model->bhp_id)
                ->decrement('current_stock', $model->quantity_expired);
        });

        // Kembalikan stok jika log dihapus
        static::deleted(function ($model) {
            ConsumableItem::where('id', $model->bhp_id)
                ->increment('current_stock', $model->quantity_expired);
        });
    }

    public function item()
    {
        return $this->belongsTo(ConsumableItem::class, 'bhp_id');
    }
}