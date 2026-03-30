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
        'price' => 'decimal:2',
        'base_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function procedureItems()
    {
        return $this->hasMany(ProcedureItem::class);
    }

    public function careType()
    {
        return $this->belongsTo(MasterCareType::class, 'care_type_id', 'id');
    }
}