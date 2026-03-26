<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $table = 'medicine';

    protected $primaryKey = 'id';
    public $incrementing = false; // karena id string
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'medicine_name',
        'category',
        'unit',
        'current_stock',
        'minimum_stock',
        'notes'
    ];
    public function stockLogs()
    {
        return $this->hasMany(MedicineStockLog::class);
    }
}