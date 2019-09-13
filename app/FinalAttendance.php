<?php

namespace App;

use DB;
use Carbon\Carbon;
use App\Abstraction\Eventable;
use Awobaz\Compoships\Compoships;


class FinalAttendance extends Eventable
{
    use Compoships;

    protected $fillable = [
        'anggota_id',
        'basedept_id',
        'tarikh',
        'shift_id',
        'check_in',
        'check_out',
        'check_in_mid',
        'check_in_out',
        'tatatertib_flag',
        'kesalahan',
    ];

    protected $dates = [
        'tarikh',
        'check_in',
        'check_out',
        'check_in_mid',
        'check_in_out',
        'start',
        'end',
    ];

    public function __construct()
    {
        $this->setDateFormat(config('pcrs.modelDateFormat'));
    }

    public function justifikasi()
    {
        return $this->hasMany(Justifikasi::class, 'final_attendance_id');
    }

    public function anggota()
    {
        return $this->belongsTo(XtraAnggota::class, 'anggota_id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function cuti()
    {
        return $this->belongsTo(Cuti::class, ['tarikh'], ['tarikh']);
    }

    public function scopeEvents($query)
    {
        return $query->select(
            DB::raw('id'),
            DB::raw('tarikh'),
            DB::raw('check_in'),
            DB::raw('check_out'),
            DB::raw('CONCAT(\'IN : \', if(isnull(check_in),\'-\', date_format(check_in, \'%l:%i %p\')), "\n", \' OUT : \', if(isnull(check_out),\'-\', date_format(check_out, \'%l:%i %p\'))) as \'title\''),
            DB::raw('kesalahan'),
            DB::raw('tatatertib_flag'),
            DB::raw('tarikh as \'start\''),
            DB::raw('tarikh as \'end\''),
            DB::raw('\'true\' as \'allDay\''),
            DB::raw('\'#1abc9c\' as \'color\''),
            DB::raw('\'#000\' as \'textColor\''),
            DB::raw('\'' . Eventable::FINALATT . '\' as \'table_name\'')
        )->with(['justifikasi', 'cuti']);
    }

    public function scopeGetEventBetween($query, array $waktu)
    {
        list($mula, $tamat) = $waktu;

        $tamat = Carbon::parse($tamat)->subDay()->format('Y-m-d');

        return $query->whereBetween('tarikh', [$mula, $tamat]);
    }

    public function eventCheckIn()
    {
        $masa = explode("\n", $this->title);
        return trim(explode(":", $masa[0], 2)[1]);
    }

    public function eventCheckOut()
    {
        $masa = explode("\n", $this->title);
        return trim(explode(":", $masa[1], 2)[1]);
    }
}
