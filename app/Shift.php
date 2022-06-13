<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shift extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = [
        'check_in',
        'check_out',
        'deleted_at',
    ];

    public function __construct()
    {
        $this->setDateFormat(config('pcrs.modelDateFormat'));
    }

    public function anggota()
    {
        return $this->belongsToMany(Anggota::class, 'anggota_shift', 'shift_id', 'anggota_id')
            ->withPivot('tkh_mula', 'tkh_tamat', 'id');
    }
	
	
	
		
	
	 	public function scopedetail_wbb_bulanan_ikutdepartment($query, $departmentDisplayId, $comSenPPP, $txtTarikh)
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
		
			
			
			return $query->leftjoin('xtra_userinfo','anggota_shift.anggota_id','=','xtra_userinfo.anggota_id')
			->leftjoin('shifts','anggota_shift.shift_id','=','shifts.id')			
			->select ('*')
			->from('anggota_shift')		
			//->where('dept_id', '=', $departmentDisplayId)
			->where('basedept_id', '=', $departmentDisplayId)	
			->where('tkh_mula', '<=', $txtTarikh_format)
			->where('tkh_tamat', '>=', $txtTarikhHingga_format)
			->get();
		
    } 	

		
	
	 	public function scopedetail_wbb_puasa_mengandung_ikutdepartment($query, $departmentDisplayId, $comSenPPP, $txtTarikh)
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
		
			
			
			return $query->leftjoin('xtra_userinfo','shift_confs.anggota_id','=','xtra_userinfo.anggota_id')
			->leftjoin('puasa','shift_confs.puasa_id','=','puasa.id')			
			->select ('*')
			->from('shift_confs')		
			//->where('dept_id', '=', $departmentDisplayId)
			->where('basedept_id', '=', $departmentDisplayId)
						
			->where(function ($query) use ($txtTarikh_format, $txtTarikhHingga_format) {
				
				$query->where(function ($query) use ($txtTarikh_format, $txtTarikhHingga_format) {
					$query->where('tkh_mula', '>=', $txtTarikh_format)
						->where('tkh_tamat', '<=', $txtTarikhHingga_format);
				})
				->orWhere(function ($query) use ($txtTarikh_format, $txtTarikhHingga_format) {
					$query->where('tkhmula', '>=', $txtTarikh_format)
						->where('tkhtamat', '<=', $txtTarikhHingga_format);
				});

			})
			->get();
		
    } 
		
}
