<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class FlowFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Flow';
    }
}
