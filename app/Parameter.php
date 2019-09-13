<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    public function __construct()
    {
        $this->setDateFormat(config('pcrs.modelDateFormat'));
    }
}
