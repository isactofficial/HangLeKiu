<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Invoice extends Model
{
    protected $table = 'invoices';
    protected $keyType = 'string';
    public $incrementing = false;

    const UPDATED_AT = null; 

    protected $fillable = [
        'id',
        'registration_id',
        'admin_id',
        'invoice_number',
        'status',
        'receipt_number',
        'payment_type',
        'payment_method',
        'cash_account',
        'amount_paid',
        'change_amount',
        'debt_amount',
        'rounding',
        'notes',
        'is_multi_payment',
        'second_payment_method_id',
        'second_payment_amount',
        'created_at'
    ];

    public function secondPaymentMethod()
    {
        return $this->belongsTo(MasterPaymentMethod::class, 'second_payment_method_id');
    }

    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function registration()
    {
        return $this->belongsTo(Appointment::class, 'registration_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}