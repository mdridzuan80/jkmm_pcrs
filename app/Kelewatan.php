<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelewatan extends Model
{
    const FLAG_SMS = 0;
    const FLAG_NON_SMS = 1;

    protected $table = 'kelewatan';

    public function __construct()
    {
        $this->setDateFormat(config('pcrs.modelDateFormat'));
    }
}
