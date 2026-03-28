<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    protected $table = 'doctor_schedule';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['id', 'doctor_id', 'day', 'start_time', 'end_time', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];
}
