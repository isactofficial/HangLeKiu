<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProcedureAssistant extends Model
{
    protected $table = 'procedure_assistant';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'procedure_id',
        'doctor_id',
    ];

    public function medicalProcedure(): BelongsTo
    {
        return $this->belongsTo(MedicalProcedure::class, 'procedure_id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}
