<?php

namespace App\Http\Controllers;

use App\Models\MasterGuarantorType;

class MasterGuarantorTypeController extends BaseMasterController
{
    public function __construct()
    {
        parent::__construct(MasterGuarantorType::class, 'Guarantor');
    }
}
