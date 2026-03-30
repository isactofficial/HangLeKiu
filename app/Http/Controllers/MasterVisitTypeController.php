<?php

namespace App\Http\Controllers;

class MasterVisitTypeController extends BaseMasterController
{
    public function __construct()
    {
        parent::__construct('App\Models\MasterVisitType', 'Visit Type');
    }
}
