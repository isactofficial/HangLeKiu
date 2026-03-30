<?php

namespace App\Http\Controllers;

use App\Models\MasterPoli;

class MasterPoliController extends BaseMasterController
{
    public function __construct()
    {
        parent::__construct(MasterPoli::class, 'Poli');
    }
}
