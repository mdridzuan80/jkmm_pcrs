<?php

namespace App;

use DB;
use Carbon\Carbon;
use App\Abstraction\Eventable;
use CoenJacobs\EloquentCompositePrimaryKeys\HasCompositePrimaryKey;

class Kehadiran extends Eventable
{
    use HasCompositePrimaryKey;

    const PUNCH_IN = "IN";
    const PUNCH_OUT = "OUT";
    const PUNCH_MIN = "MIN";
    const PUNCH_MOUT = "MOUT";

    const FLAG_TATATERTIB_CLEAR = "C";
    const FLAG_TATATERTIB_TUNJUK_SEBAB = "TS";

    const FLAG_KESALAHAN_NONE = 'NONE';
    const FLAG_KESALAHAN_LEWAT = 'LEWAT';
    const FLAG_KESALAHAN_AWAL = 'AWAL';
    const FLAG_KESALAHAN_NONEIN = 'NONEIN';
    const FLAG_KESALAHAN_NONEOUT = 'NONEOUT';
    const FLAG_KESALAHAN_NONEMIN = 'NONEMIN';
    const FLAG_KESALAHAN_NONEMOUT = 'NONEMOUT';

    const BUTTON_TEXT = [
        'NONEIN' => 'Tidak Punch-In',
        'NONEOUT' => 'Tidak Punch-Out',
        'LEWAT' => 'Datang Lewat',
        'AWAL' => 'Pulang Awal',
    ];

    protected $dateFormat = 'Y-m-d H:i:s';
    protected $dates = ['checktime'];

    public function __construct()
    {
        $this->table = 'checkinout';
        $this->primaryKey = ['userid', 'checktime'];
        $this->incrementing = false;
        $this->setDateFormat(config('pcrs.modelDateFormat'));
    }

    public function scopeRekodByMulaTamat($query, Carbon $tkhMula, Carbon $tkhTamat)
    {
        return $query->where('checktime', '>=', $tkhMula)
            ->where('checktime', '<', $tkhTamat);
    }

    public function scopeEvents($query)
    {
        return $query->select(DB::raw('CONCAT(\'IN : \', checktime, "\n", \' OUT : -\') as \'title\''), DB::raw('\'C\' as \'tatatertib_flag\''), DB::raw('\'' . today() . '\' as \'start\''), DB::raw('\'' . today() . '\' as \'end\''), DB::raw('\'true\' as \'allDay\''), DB::raw('\'#dcf442\' as \'color\''), DB::raw('\'#000\' as \'textColor\''), DB::raw('0 as \'id\''), DB::raw('\'' . Eventable::CURRENTATT . '\' as \'table_name\''));
    }

    public function scopeToday($query)
    {
        return $query->whereBetween('checktime', [today()->addHours(4), today()->addHours(13)]);
    }

    public static function itemEventableNone()
    {
        return [
            'title' => 'IN: -' . "\n" . 'OUT: -',
            'start' => today()->toDateTimeString(),
            'end' => today()->toDateTimeString(),
            'allDay' => 'true',
            'color' => '#1abc9c',
            'textColor' => '#000',
            'id' => 0,
            'table_name' => 'current'
        ];
    }
}
