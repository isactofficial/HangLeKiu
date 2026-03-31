<?php

namespace App\Http\Controllers;

use App\Models\MasterPaymentMethod;

class MasterPaymentMethodController extends BaseMasterController
{
    public function __construct()
    {
        parent::__construct(MasterPaymentMethod::class, 'Payment Method');
    }
}
