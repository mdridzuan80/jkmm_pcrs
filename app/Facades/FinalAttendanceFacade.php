<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class FinalAttendanceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'FinalAttendance';
    }

}
