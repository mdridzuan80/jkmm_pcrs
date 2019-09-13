<?php

namespace App;

use App\Abstraction\Eventable;
use Awobaz\Compoships\Compoships;
use Illuminate\Support\Facades\DB;

class Cuti extends Eventable
{
    use Compoships;

    protected $table = 'cuti';

    protected $dates = [
        'tarikh',
        'start',
        'end',
    ];

    public function __construct()
    {
        $this->setDateFormat(config('pcrs.modelDateFormat'));
    }

    public function scopeEvents($query)
    {
        return $query->select(DB::raw('perihal as \'title\''), DB::raw('tarikh as \'start\''), DB::raw('tarikh as \'end\''), DB::raw('\'true\' as \'allDay\''), DB::raw('\'#f1c40f\' as \'color\''), DB::raw('\'#000\' as \'textColor\''), DB::raw('id'), DB::raw('\'' . Eventable::CUTI . '\' as \'table_name\''));
    }
}
