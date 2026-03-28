<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcedureMedicine extends Model
{
    protected $table = 'procedure_medicine';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'procedure_id',
        'medicine_id',
        'quantity_used',
    ];

    public function medicalProcedure()
    {
        return $this->belongsTo(MedicalProcedure::class, 'procedure_id');
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}