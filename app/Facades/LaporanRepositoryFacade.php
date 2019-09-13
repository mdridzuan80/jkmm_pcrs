<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class LaporanRepositoryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'App\Repositories\LaporanRepository';
    }
}
