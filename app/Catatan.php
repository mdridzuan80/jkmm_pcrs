<?php

namespace App;

use App\Scopes\CatatanScope;

class Catatan extends Acara
{
    public function __construct()
    {
        parent::__construct();

        parent::boot();

        static::addGlobalScope(new CatatanScope);
    }
}
