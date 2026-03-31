<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ConsumableRestock extends Model
{
    protected $table = 'consumable_restock';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'bhp_id',
        'restock_type',
        'quantity_added',
        'purchase_price',
        'expiry_date',
        'batch_number',
        'notes',
        'created_at',
    ];

    protected $casts = [
        'quantity_added' => 'integer',
        'purchase_price' => 'float',
        'expiry_date'    => 'date:Y-m-d',
        'created_at'     => 'datetime',
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

        // Tambah stok saat restock dibuat
        static::created(function ($model) {
            $item = ConsumableItem::find($model->bhp_id);
            if (!$item) return;

            $item->increment('current_stock', $model->quantity_added);

            // Hitung ulang avg_hpp jika ada purchase_price baru
            if ($model->purchase_price > 0) {
                $totalRestocks = ConsumableRestock::where('bhp_id', $model->bhp_id)
                    ->where('purchase_price', '>', 0)
                    ->count();
                $avgHpp = ConsumableRestock::where('bhp_id', $model->bhp_id)
                    ->where('purchase_price', '>', 0)
                    ->avg('purchase_price');
                $item->update(['avg_hpp' => round($avgHpp, 2)]);
            }
        });

        // Kurangi stok kembali jika restock dibatalkan / dihapus
        static::deleted(function ($model) {
            ConsumableItem::where('id', $model->bhp_id)
                ->decrement('current_stock', $model->quantity_added);
        });
    }

    public function item()
    {
        return $this->belongsTo(ConsumableItem::class, 'bhp_id');
    }
}