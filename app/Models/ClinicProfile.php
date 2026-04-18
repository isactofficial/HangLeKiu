<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicProfile extends Model
{
    use HasFactory;

    protected $table = 'clinic_profiles';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'logo',
        'address',
        'phone',
        'operational_hours',
        'operational_summary',
    ];

    protected $casts = [
        'operational_hours' => 'array',
    ];
}
