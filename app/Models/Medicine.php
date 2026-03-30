<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $table = 'medicine';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'medicine_code',
        'medicine_name',
        'manufacturer',
        'medicine_type',
        'category',
        'unit',
        'current_stock',
        'minimum_stock',
        'purchase_price',
        'selling_price_general',
        'selling_price_otc',
        'avg_hpp',
        'notes',
    ];

    public function stockMutations()
    {
        return $this->hasMany(StockMutation::class);
    }
}