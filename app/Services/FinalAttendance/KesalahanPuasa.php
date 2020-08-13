<?php

namespace App\Services\FinalAttendance;

use Carbon\Carbon;
use App\Kehadiran;

class KesalahanPuasa extends AbstractKesalahanCalculator
{
    protected $total_hour = 30600; //formula 8.5 hours in second 60*60*8.5
}
