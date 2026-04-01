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
        'supplier_id',
        'restock_type',
        'quantity_added',
        'quantity_returned',  
        'purchase_price',
        'expiry_date',
        'batch_number',
        'notes',
        'created_at',
    ];

    protected $casts = [
        'quantity_added'    => 'integer',
        'quantity_returned' => 'integer',  
        'purchase_price'    => 'float',
        'expiry_date'       => 'date:Y-m-d',
        'created_at'        => 'datetime',
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

        static::created(function ($model) {
            $item = ConsumableItem::find($model->bhp_id);
            if (!$item) return;

            if ($model->restock_type === 'restock') {
                // Tambah stok
                $item->increment('current_stock', $model->quantity_added);

                // Hitung ulang avg_hpp
                if ($model->purchase_price > 0) {
                    $avgHpp = ConsumableRestock::where('bhp_id', $model->bhp_id)
                        ->where('restock_type', 'restock')
                        ->where('purchase_price', '>', 0)
                        ->avg('purchase_price');
                    $item->update(['avg_hpp' => round($avgHpp, 2)]);
                }
            } elseif ($model->restock_type === 'return') {
                // Kurangi stok
                $item->decrement('current_stock', $model->quantity_returned);
            }
        });

        static::deleted(function ($model) {
            $item = ConsumableItem::find($model->bhp_id);
            if (!$item) return;

            // Balik stok sesuai tipe transaksi
            if ($model->restock_type === 'restock') {
                $item->decrement('current_stock', $model->quantity_added);
            } elseif ($model->restock_type === 'return') {
                $item->increment('current_stock', $model->quantity_returned);
            }
        });
    }

    public function item()
    {
        return $this->belongsTo(ConsumableItem::class, 'bhp_id');
    }
}