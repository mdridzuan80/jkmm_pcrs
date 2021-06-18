<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Bdrsetting extends Model
{
    public function byTahun()
    {
        $tkhMula = Carbon::now()->year . "-01-01 00:00:00";
        $tkhTamat = Carbon::now()->year + 1 . "-01-01 00:00:00";

        return $this->where('tkhmula', '>=', $tkhMula)->orWhere('tkhtamat', '>', $tkhTamat)->get();
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'bahagian_id');
    }

    public function scopeBetweenDates(Builder $query, $from, $to)
    {
        return $query
            ->where("tkhmula", "<=", $from)
            ->where("tkhtamat", ">=", $to);
    }
}
