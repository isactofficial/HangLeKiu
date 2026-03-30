<?php

namespace App\Http\Controllers;

use App\Models\MasterCareType;

class MasterCareTypeController extends BaseMasterController
{
    public function __construct()
    {
        parent::__construct(MasterCareType::class, 'Jenis Perawatan');
    }
}

