<?php

namespace App;

use Carbon\Carbon;
use App\Abstraction\Eventable;
use Illuminate\Support\Facades\DB;

class FinalAttendance extends Eventable
{
    //use Compoships;

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
        'hours',
    ];

    protected $dates = [
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
        return $this->hasMany(Acara::class, 'final_attendance_id');
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
        return $this->belongsTo(Cuti::class, 'tarikh', 'tarikh');
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
            DB::raw('hours'),
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
	
	




 	public function scopedetail_finalattendance_individu($query, $departmentDisplayId, $comSenPPP, $txtTarikh)
	//public function scopedetail_checkinout_individu($query,$comPegawai='0')
    {    
        
		//echo $departmentDisplayId;
		//echo $comSenPPP;
		//echo $txtTarikh;
		//echo $txtTarikhHingga;
		
		
		$bulantahun = explode ("-", $txtTarikh); 
			
		$bulan = $bulantahun[0];
		$tahun = $bulantahun[1];
		
		if($bulan == 'Jan'){
			$bulan_nombor = '01';
			$bulan_malay = 'Januari';
		}
		if($bulan == 'Feb'){
			$bulan_nombor = '02';
			$bulan_malay = 'Februari';
		}
		if($bulan == 'Mar'){
			$bulan_nombor = '03';
			$bulan_malay = 'Mac';
		}
		if($bulan == 'Apr'){
			$bulan_nombor = '04';
			$bulan_malay = 'April';
		}
		if($bulan == 'May'){
			$bulan_nombor = '05';
			$bulan_malay = 'Mei';
		}
		if($bulan == 'Jun'){
			$bulan_nombor = '06';
			$bulan_malay = 'Jun';
		}
		if($bulan == 'Jul'){
			$bulan_nombor = '07';
			$bulan_malay = 'Julai';
		}
		if($bulan == 'Aug'){
			$bulan_nombor = '08';
			$bulan_malay = 'Ogos';
		}
		if($bulan == 'Sep'){
			$bulan_nombor = '09';
			$bulan_malay = 'September';
		}
		if($bulan == 'Oct'){
			$bulan_nombor = '10';
			$bulan_malay = 'Oktober';
		}
		if($bulan == 'Nov'){
			$bulan_nombor = '11';
			$bulan_malay = 'November';
		}
		if($bulan == 'Dec'){
			$bulan_nombor = '12';
			$bulan_malay = 'Disember';
		}
		
		
		//echo $txtTarikh;
		$harilast_dalambulan = cal_days_in_month(CAL_GREGORIAN, $bulan_nombor, $tahun);			
					
		$txtTarikh2 = $tahun.'-'.$bulan_nombor.'-01';
		$txtTarikhHingga2 = $tahun.'-'.$bulan_nombor.'-'.$harilast_dalambulan;
		
		
		//echo $comSenPPP;
		$txtTarikh_format = $txtTarikh2.' 00:00:00';
		$txtTarikhHingga_format = $txtTarikhHingga2.' 00:00:00';
		
		//$txtTarikh_format = '2021-08-01 00:00:00';
		//$txtTarikhHingga_format = '2021-08-03 00:00:00';
		
		
			
		
			
			return $query
			
			->select ('*')		
			//->where('dept_id', '=', $departmentDisplayId)
			->where('basedept_id', '=', $departmentDisplayId)	
			->where('tarikh', '>=', $txtTarikh_format)
			->where('tarikh', '<=', $txtTarikhHingga_format)
			->get();
			
			
			/*
			return $query->leftjoin('acara','final_attendances.id','=','acara.final_attendance_id')			
			->select ('*','final_attendances.anggota_id as anggota_ids')
			->where('pcrs.final_attendances.anggota_id', '=', $comSenPPP)
			->where('tarikh', '>=', $txtTarikh_format)
			->where('tarikh', '<=', $txtTarikhHingga_format)
			->get();				
			*/
		
		
    } 	
	
	
	
}
