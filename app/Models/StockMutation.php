<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMutation extends Model
{
    protected $table = 'stock_mutation';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'medicine_id',
        'user_id',
        'type',
        'quantity',
        'notes',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}