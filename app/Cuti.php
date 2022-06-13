<?php

namespace App;

use DB;
use Carbon\Carbon;
use App\Abstraction\Eventable;
use Awobaz\Compoships\Compoships;

class Cuti extends Eventable
{
    // untuk membuat relationship kepada lebih key
    use Compoships;

    protected $table = 'cuti';

    protected $dates = [];

    public function __construct()
    {
        $this->setDateFormat(config('pcrs.modelDateFormat'));
    }

    public function scopeEvents($query)
    {
        return $query->select(DB::raw('perihal as \'title\''), DB::raw('tarikh as \'start\''), DB::raw('tarikh as \'end\''), DB::raw('\'true\' as \'allDay\''), DB::raw('\'#f1c40f\' as \'color\''), DB::raw('\'#000\' as \'textColor\''), DB::raw('id'), DB::raw('\'' . Eventable::CUTI . '\' as \'table_name\''));
    }

    public static function years()
    {
        return self::select(DB::raw('year(tarikh) as year'))
            ->groupBy('year')
            ->get();
    }

    public function getTarikhCutiAttribute($value)
    {
        return Carbon::createFromTimeString($this->tarikh);
    }
	
	public function scopedetail_list_cuti($query, $txtTarikh)
    {    		
		
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
		
			
			return $query
			
			->select ('*')		
			->where('tarikh', '>=', $txtTarikh_format)
			->where('tarikh', '<=', $txtTarikhHingga_format)
			->get();
			
    } 	
}
