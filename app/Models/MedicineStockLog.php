<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicineStockLog extends Model
{
    protected $fillable = [
        'medicine_id',
        'type',
        'qty',
        'note'
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}