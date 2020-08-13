<?php

namespace App\Services\FinalAttendance;

use Carbon\Carbon;
use App\Kehadiran;

class KesalahanNormal extends AbstractKesalahanCalculator
{
    protected $total_hour = 32400; //formula 8 hours in second 60*60*9
}
