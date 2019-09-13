<?php

namespace App;

use App\Abstraction\Flowly;

class FlowBahagian extends Flowly
{
    protected $table = 'flow_bahagian';

    public function __construct()
    {
        $this->setDateFormat(config('pcrs.modelDateFormat'));
    }
}
