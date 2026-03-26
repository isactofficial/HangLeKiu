<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterCareType extends Model
{
     protected $table = 'master_care_type';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['id', 'name', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function scopeActive($query) {
        return $query->where('is_active', true);
    }
}
