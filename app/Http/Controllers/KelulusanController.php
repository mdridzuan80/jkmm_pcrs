<?php

namespace App\Http\Controllers;

use App\Base\BaseController;

class KelulusanController extends BaseController
{
    public function index()
    {
        //$permohonan =
        return $this->renderView('kelulusan.index');
    }
}
