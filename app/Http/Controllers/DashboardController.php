<?php

namespace App\Http\Controllers;

use App\Role;
use App\Base\BaseController;
use Illuminate\Http\Request;

class DashboardController extends BaseController
{
    public function index(Request $request)
    {
        return $this->renderView('dashboard.index');
    }
}
