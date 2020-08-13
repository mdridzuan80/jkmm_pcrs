<?php

namespace App\Services\FinalAttendance;

use Carbon\Carbon;
use App\Kehadiran;

class KesalahanMengandung extends AbstractKesalahanCalculator
{
    protected $total_hour = 28800; //formula 9 hours in second 60*60*8
}
