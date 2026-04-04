<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalProcedure extends Model
{
    use SoftDeletes;

    protected $table = 'medical_procedure';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'registration_id',
        'patient_id',
        'doctor_id',
        'discount_type',
        'discount_value',
        'total_amount',
        'notes',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'deleted_at' => 'datetime',
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Appointment::class, 'registration_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
    public function items()
    {
        // MedicalProcedure punya banyak ProcedureItem
        return $this->hasMany(ProcedureItem::class, 'procedure_id', 'id');
    }

    public function medicines()
    {
        return $this->hasMany(ProcedureMedicine::class, 'procedure_id', 'id');
    }

    public function doctorNotes()
    {
        return $this->hasMany(DoctorNote::class, 'procedure_id', 'id');
    }

    public function assistants()
    {
        return $this->hasMany(ProcedureAssistant::class, 'procedure_id', 'id');
    }
}
