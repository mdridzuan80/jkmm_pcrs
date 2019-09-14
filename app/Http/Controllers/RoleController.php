<?php

namespace App\Http\Controllers;

use Auth;
use App\Base\BaseController;
use Illuminate\Http\Request;

class RoleController extends BaseController
{
    public function switchRole(Request $request, $role)
    {
        if (!Auth::user()->hasRole($role)) {
            return abort(404);
        }

        Auth::user()->perananSemasa($role);
    }
}
