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
        'procedure_name',
        'base_price',
        'is_active',
    ];

    public function procedureItems()
    {
        return $this->hasMany(ProcedureItem::class);
    }
}