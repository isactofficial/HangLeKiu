<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MasterPoli extends Model
{
    protected $table = 'master_poli';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['id', 'name', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function scopeActive($query) {
        return $query->where('is_active', true);
    }
}