<?php

namespace App;

use Flow;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Abstraction\Eventable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Acara extends Eventable
{
    protected $table = 'acara';

    public $timestamps = true;

    protected $dates = [
        'tarikh_mula',
        'tarikh_tamat',
    ];

    const JENIS_ACARA_CHECKIN = 'IN';
    const JENIS_ACARA_CHECKOUT = 'OUT';

    const STATUS_PERMOHONAN_MOHON = 'MOHON';
    const STATUS_PERMOHONAN_BATAL = 'BATAL';
    const STATUS_PERMOHONAN_LULUS = 'LULUS';
    const STATUS_PERMOHONAN_TOLAK = 'TOLAK';

    const KATEGORI_JUSTIFIKASI = 'J';
    const KATEGORI_TIMESLIP = 'T';
    const KATEGORI_CATATAN = 'C';

    /* public function __construct()
    {
        $this->setDateFormat(config('pcrs.modelDateFormat'));
    }*/

    public function finalAttendance()
    {
        return $this->belongsTo(FinalAttendance::class);
    }
	
		
	public function acara_finalAttendance()
	{
		return $this->belongsTo(FinalAttendance::class, 'final_attendance_id', 'id');
	}

    public function acara_userinfo()
    {
        return $this->belongsTo(XtraAnggota::class, 'anggota_id', 'anggota_id');
    }
		

    public function scopeEvents($query)
    {
        return $query->select(
            DB::raw('kategori'),
            DB::raw('perkara as \'title\''),
            DB::raw('tarikh_mula as \'start\''),
            DB::raw('tarikh_tamat as \'end\''),
            DB::raw('\'false\' as \'allDay\''),
            DB::raw('\'#00c0ef\' as \'color\''),
            DB::raw('\'black\' as \'textColor\''),
            DB::raw('id'),
            DB::raw('keterangan'),
            DB::raw('\'' . Eventable::ACARA . '\' as \'table_name\'')
        );
		//)->orderBy('tarikh_mula_time', 'ASC');
    }
	

    public function scopeGetByDateRange($query, $start, $end)
    {
        $acaraMula = clone $query;

        return $query->where('tarikh_tamat', '>=', $start)
            ->where('tarikh_tamat', '<', $end)
            ->union($acaraMula->where('tarikh_mula', '>=', $start)->where('tarikh_mula', '<', $end));
    }

    public function scopeGetEventablesByDate($query, Carbon $tarikh)
    {
        $acaraMula = clone $query;
        $acaraMula2 = clone $query;
        $tarikMulaTamat2 = clone $tarikh;
        $tarikhTamatMula2 = clone $tarikh;


        return $query->events()
            ->where('tarikh_mula', '>=', $tarikh)
            ->where('tarikh_mula', '<', $tarikMulaTamat2->addDay()->subMinute()->toDateTimeString())
            ->union($acaraMula->events()
                ->where('tarikh_tamat', '>', $tarikh)
                ->Where('tarikh_tamat', '<', $tarikhTamatMula2->addDay()))
            ->union($acaraMula2->events()
                ->where('tarikh_mula', '<', $tarikh)
                ->where('tarikh_tamat', '>', $tarikh));
    }

    public static function storeAcara(Anggota $profil, Request $request)
    {
        if (!self::isOverlaped(Auth::user()->id, Carbon::parse($request->input('masaMula')), Carbon::parse($request->input('masaTamat')), date("Y-m-d", strtotime(Carbon::parse($request->input('masaMula')))), date("Y-m-d", strtotime(Carbon::parse($request->input('masaTamat')))), date("H", strtotime(Carbon::parse($request->input('masaMula')))).date("i", strtotime(Carbon::parse($request->input('masaMula')))).date("s", strtotime(Carbon::parse($request->input('masaMula')))), date("H", strtotime(Carbon::parse($request->input('masaTamat')))).date("i", strtotime(Carbon::parse($request->input('masaTamat')))).date("s", strtotime(Carbon::parse($request->input('masaTamat')))))) {
            $acara = new Acara;
            $acara->basedept_id = $profil->xtraAttr->basedept_id;
            $acara->kategori = $request->input('jenisAcara');
            $acara->perkara = $request->input('perkara');
            $acara->tarikh_mula = Carbon::parse($request->input('masaMula'));
            $acara->tarikh_tamat = Carbon::parse($request->input('masaTamat'));
            $acara->tarikh_mula_date = date("Y-m-d", strtotime(Carbon::parse($request->input('masaMula'))));
            $acara->tarikh_tamat_date = date("Y-m-d", strtotime(Carbon::parse($request->input('masaTamat'))));
            $acara->tarikh_mula_time = date("H", strtotime(Carbon::parse($request->input('masaMula')))).date("i", strtotime(Carbon::parse($request->input('masaMula')))).date("s", strtotime(Carbon::parse($request->input('masaMula'))));
            $acara->tarikh_tamat_time = date("H", strtotime(Carbon::parse($request->input('masaTamat')))).date("i", strtotime(Carbon::parse($request->input('masaTamat')))).date("s", strtotime(Carbon::parse($request->input('masaTamat'))));
            $acara->keterangan = $request->input('keterangan');
            //$acara->pelulus_id = $profil->pegawaiPenilai->pegawai_id;
			$acara->pelulus_id = Flow::pelulus($profil)->xtraAttr->anggota_id;
            $acara->user_id = Auth::user()->id;
            return $profil->acara()->save($acara);
        }
        return [];
    }
	
	

    public function eventableItem()
    {
        return collect([
            'title' => $this->perkara,
            'start' => $this->tarikh_mula->toDateTimeString(),
            'end' => $this->tarikh_tamat->toDateTimeString(),
            'allDay' => false,
            'color' => '#e74c3c',
            'textColor' => '#FFF',
            'id' => $this->id,
            'table_name' => 'acara'
        ]);
    }

    public function descKategori()
    {
        if ($this->kategori === self::KATEGORI_JUSTIFIKASI) {
            return 'justifikasi';
        }
        if ($this->kategori === self::KATEGORI_TIMESLIP) {
            return 'timeslip';
        }
        if ($this->kategori === self::KATEGORI_CATATAN) {
            return 'catatan';
        }
    }

    //static public function isOverlaped($user_id, $masa_mula, $masa_tamat, $tarikh_mula_date, $tarikh_tamat_date, $tarikh_mula_time, $tarikh_tamat_time)
    //{
	static public function isOverlaped($user_id, $masa_mula, $masa_tamat)
    {
        
		
		//if(($kategori_acara == 'J') || ($kategori_acara == 'T')){
			
			return self::where('user_id', $user_id)
				
				->where(function ($query) use ($masa_mula, $masa_tamat) {
					
					$query->where(function ($query) use ($masa_mula, $masa_tamat) {
						$query->where('tarikh_mula', '<=', $masa_mula)
							->where('tarikh_tamat', '>=', $masa_mula);
					})->orWhere(function ($query) use ($masa_mula, $masa_tamat) {
						$query->where('tarikh_mula', '<=', $masa_tamat)
							->where('tarikh_tamat', '>=', $masa_tamat);
					})->orWhere(function ($query) use ($masa_mula, $masa_tamat) {
						$query->where('tarikh_mula', '>=', $masa_mula)
							->where('tarikh_tamat', '<=', $masa_tamat);
					})->orWhere(function ($query) use ($masa_mula, $masa_tamat) {
						$query->where('tarikh_mula', '<=', $masa_mula)
							->where('tarikh_tamat', '>=', $masa_tamat);
					});
					
				})->count();
			
		//}
		
		/*	
			return self::where('user_id', $user_id)
				->where(function ($query) use ($masa_mula, $masa_tamat, $tarikh_mula_time, $tarikh_tamat_time) {
					
					$query->where(function ($query) use ($masa_mula, $masa_tamat, $tarikh_mula_time, $tarikh_tamat_time) {
						$query->where('tarikh_mula', '<=', $masa_mula)
						->where('tarikh_tamat', '>=', $masa_mula)
						
						->where(function ($query) use ($tarikh_mula_time, $tarikh_tamat_time) {
							
							$query->where(function ($query) use ($tarikh_mula_time, $tarikh_tamat_time) {
								$query->where('tarikh_mula_time', '<=', $tarikh_mula_time)
									->where('tarikh_tamat_time', '>', $tarikh_mula_time);
							})
							->orWhere(function ($query) use ($tarikh_mula_time, $tarikh_tamat_time) {
								$query->where('tarikh_mula_time', '<', $tarikh_tamat_time)
									->where('tarikh_tamat_time', '>=', $tarikh_tamat_time);
							})
							->orWhere(function ($query) use ($tarikh_mula_time, $tarikh_tamat_time) {
								$query->where('tarikh_mula_time', '>=', $tarikh_mula_time)
									->where('tarikh_tamat_time', '<=', $tarikh_tamat_time);
							})
							->orWhere(function ($query) use ($tarikh_mula_time, $tarikh_tamat_time) {
								$query->where('tarikh_mula_time', '<=', $tarikh_mula_time)
									->where('tarikh_tamat_time', '>=', $tarikh_tamat_time);
							});
			
						});
								
					})->orWhere(function ($query) use ($masa_mula, $masa_tamat, $tarikh_mula_time, $tarikh_tamat_time) {
						$query->where('tarikh_mula', '<=', $masa_tamat)
						->where('tarikh_tamat', '>=', $masa_tamat)
						
						->where(function ($query) use ($tarikh_mula_time, $tarikh_tamat_time) {
							
							$query->where(function ($query) use ($tarikh_mula_time, $tarikh_tamat_time) {
								$query->where('tarikh_mula_time', '<=', $tarikh_mula_time)
									->where('tarikh_tamat_time', '>', $tarikh_mula_time);
							})
							->orWhere(function ($query) use ($tarikh_mula_time, $tarikh_tamat_time) {
								$query->where('tarikh_mula_time', '<', $tarikh_tamat_time)
									->where('tarikh_tamat_time', '>=', $tarikh_tamat_time);
							})
							->orWhere(function ($query) use ($tarikh_mula_time, $tarikh_tamat_time) {
								$query->where('tarikh_mula_time', '>=', $tarikh_mula_time)
									->where('tarikh_tamat_time', '<=', $tarikh_tamat_time);
							})
							->orWhere(function ($query) use ($tarikh_mula_time, $tarikh_tamat_time) {
								$query->where('tarikh_mula_time', '<=', $tarikh_mula_time)
									->where('tarikh_tamat_time', '>=', $tarikh_tamat_time);
							});
			
						});
							
					})->orWhere(function ($query) use ($masa_mula, $masa_tamat, $tarikh_mula_time, $tarikh_tamat_time) {
						$query->where('tarikh_mula', '>=', $masa_mula)
						->where('tarikh_tamat', '<=', $masa_tamat)
						
						->where(function ($query) use ($tarikh_mula_time, $tarikh_tamat_time) {
							
							$query->where(function ($query) use ($tarikh_mula_time, $tarikh_tamat_time) {
								$query->where('tarikh_mula_time', '<=', $tarikh_mula_time)
									->where('tarikh_tamat_time', '>', $tarikh_mula_time);
							})
							->orWhere(function ($query) use ($tarikh_mula_time, $tarikh_tamat_time) {
								$query->where('tarikh_mula_time', '<', $tarikh_tamat_time)
									->where('tarikh_tamat_time', '>=', $tarikh_tamat_time);
							})
							->orWhere(function ($query) use ($tarikh_mula_time, $tarikh_tamat_time) {
								$query->where('tarikh_mula_time', '>=', $tarikh_mula_time)
									->where('tarikh_tamat_time', '<=', $tarikh_tamat_time);
							})
							->orWhere(function ($query) use ($tarikh_mula_time, $tarikh_tamat_time) {
								$query->where('tarikh_mula_time', '<=', $tarikh_mula_time)
									->where('tarikh_tamat_time', '>=', $tarikh_tamat_time);
							});
			
						});
							
					})->orWhere(function ($query) use ($masa_mula, $masa_tamat, $tarikh_mula_time, $tarikh_tamat_time) {
						$query->where('tarikh_mula', '<=', $masa_mula)
						->where('tarikh_tamat', '>=', $masa_tamat)
						
						->where(function ($query) use ($tarikh_mula_time, $tarikh_tamat_time) {
							
							$query->where(function ($query) use ($tarikh_mula_time, $tarikh_tamat_time) {
								$query->where('tarikh_mula_time', '<=', $tarikh_mula_time)
									->where('tarikh_tamat_time', '>', $tarikh_mula_time);
							})
							->orWhere(function ($query) use ($tarikh_mula_time, $tarikh_tamat_time) {
								$query->where('tarikh_mula_time', '<', $tarikh_tamat_time)
									->where('tarikh_tamat_time', '>=', $tarikh_tamat_time);
							})
							->orWhere(function ($query) use ($tarikh_mula_time, $tarikh_tamat_time) {
								$query->where('tarikh_mula_time', '>=', $tarikh_mula_time)
									->where('tarikh_tamat_time', '<=', $tarikh_tamat_time);
							})
							->orWhere(function ($query) use ($tarikh_mula_time, $tarikh_tamat_time) {
								$query->where('tarikh_mula_time', '<=', $tarikh_mula_time)
									->where('tarikh_tamat_time', '>=', $tarikh_tamat_time);
							});
			
						});
							
					});
					
				})->count();
			
		
		*/
		
    }

    public function isJustified()
    {
        return $this->flag_kelulusan == self::STATUS_PERMOHONAN_MOHON ||
            $this->flag_kelulusan == self::STATUS_PERMOHONAN_TOLAK ||
            $this->flag_kelulusan == self::STATUS_PERMOHONAN_BATAL;
    }

    /* public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value);
    } */



 	public function scopedetail_acara_individu($query)
	//public function scopedetail_acara($query,$userid)
    {    
        //return $query
		return $query->leftjoin('xtra_userinfo','acara.anggota_id','=','xtra_userinfo.anggota_id')
        ->select ('*','xtra_userinfo.nama as namaa')	
        ->where('pcrs.acara.anggota_id', '=', '3')
        //->where('pcrs.acara.anggota_id', '=', $userid)
        ->get();
    } 
	
	
	
	 	public function scopedetail_acara_ikutdepartment($query, $departmentDisplayId, $comSenPPP, $txtTarikh)
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
			->where('tarikh_mula', '>=', $txtTarikh_format)
			->where('tarikh_tamat', '<=', $txtTarikhHingga_format)
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
