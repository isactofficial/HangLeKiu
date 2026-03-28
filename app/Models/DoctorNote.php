<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoctorNote extends Model
{
    use SoftDeletes;

    protected $table = 'doctor_note';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'procedure_id',
        'user_id',
        'notes',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function medicalProcedure(): BelongsTo
    {
        return $this->belongsTo(MedicalProcedure::class, 'procedure_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
