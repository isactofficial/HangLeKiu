<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcedureItem extends Model
{
    use SoftDeletes;

    protected $table = 'procedure_item';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'procedure_id',
        'master_procedure_id',
        'tooth_numbers',
        'quantity',
        'unit_price',
        'discount_type',
        'discount_value',
        'subtotal',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'discount_value' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'deleted_at' => 'datetime',
    ];

    public function medicalProcedure(): BelongsTo
    {
        return $this->belongsTo(MedicalProcedure::class, 'procedure_id');
    }

    public function masterProcedure(): BelongsTo
    {
        return $this->belongsTo(MasterProcedure::class, 'master_procedure_id');
    }

        
    
}
