<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patient';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'full_name',
        'email',
        'medical_record_no',
        'date_of_birth',
        'gender',
        'blood_type',
        'rhesus',
        'address',
        'city',
        'id_card_number',
        'allergy_history',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];
}
