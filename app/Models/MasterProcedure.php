<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterProcedure extends Model
{
    protected $table = 'master_procedure';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'procedure_name',
        'care_type_id',
        'base_price',
        'price',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'base_price' => 'decimal:2',
    ];

    public function careType()
    {
        return $this->belongsTo(MasterCareType::class, 'care_type_id', 'id');
    }

    public function procedureItems()
    {
        return $this->hasMany(ProcedureItem::class);
    }
}