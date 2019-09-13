<?php

namespace App\Http\Controllers;

use App\Base\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends BaseController
{
    public function switchRole(Request $request, $role)
    {
        if (! Auth::user()->hasRole($role))
        {
            return abort(404);
        }

        Auth::user()->perananSemasa($role);
    } 
}
