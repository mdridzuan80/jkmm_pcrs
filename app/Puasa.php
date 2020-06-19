<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Puasa extends Model
{
    protected $table = 'puasa';

    public function isExistsByDate($tarikh)
    {
        return $this->where('tkhmula', '<=', $tarikh)->orWhere('tkhtamat', '>', $tarikh)->exists();
    }

    public function byTahun()
    {
        $tkhMula = Carbon::now()->year . "-01-01 00:00:00";
        $tkhTamat = Carbon::now()->year + 1 . "-01-01 00:00:00";

        return $this->where('tkhmula', '>=', $tkhMula)->orWhere('tkhtamat', '>', $tkhTamat)->get();
    }
}
