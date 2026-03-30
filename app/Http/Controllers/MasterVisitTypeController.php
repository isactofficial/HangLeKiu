<?php

namespace App\Http\Controllers;

use App\Models\MasterVisitType;

class MasterVisitTypeController extends BaseMasterController
{
    public function __construct()
    {
        parent::__construct(MasterVisitType::class, 'Jenis Kunjungan');
    }
}

