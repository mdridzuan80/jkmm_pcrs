<?php

namespace App;

use App\Abstraction\Flowly;

class FlowAnggota extends Flowly
{
    protected $table = 'flow_anggota';

    public function __construct()
    {
        $this->setDateFormat(config('pcrs.modelDateFormat'));
    }
}
