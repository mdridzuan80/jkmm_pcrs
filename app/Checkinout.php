<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Abstraction\Eventable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class Checkinout extends Model
{
	protected $table = 'checkinout';
	//protected $guarded =[];


/*
    public $timestamps = true;


    protected $dates = [
        'tarikh_mula',
        'tarikh_tamat',
    ];
*/

/*
    const JENIS_ACARA_CHECKIN = 'IN';
    const JENIS_ACARA_CHECKOUT = 'OUT';

    const STATUS_PERMOHONAN_MOHON = 'MOHON';
    const STATUS_PERMOHONAN_BATAL = 'BATAL';
    const STATUS_PERMOHONAN_LULUS = 'LULUS';
    const STATUS_PERMOHONAN_TOLAK = 'TOLAK';

    const KATEGORI_JUSTIFIKASI = 'J';
    const KATEGORI_TIMESLIP = 'T';
    const KATEGORI_CATATAN = 'C';
*/

    /* public function __construct()
    {
        $this->setDateFormat(config('pcrs.modelDateFormat'));
    }*/


/*
    public function finalAttendance()
    {
        return $this->belongsTo(FinalAttendance::class);
    }
	
		
	public function acara_finalAttendance()
	{
		return $this->belongsTo(FinalAttendance::class, 'final_attendance_id', 'id');
	}
*/

 public function scopedetail_temuduga($query,$id_acara)
    {
    
        return $query->leftjoin('users','his_intvs.no_kp','=','users.no_kp')
        ->leftjoin('jenis_sijils','his_intvs.jenis_sijil','=','jenis_sijils.id_sijil')
        ->select ('*','his_intvs.created_at as date')
        ->where('users.level', '<>', '1')
        ->where('his_intvs.id_acara', '=', $id_acara)
        //->where('status','new')
        ->get();
    } 


 	public function scopedetail_checkinout_individu($query, $departmentDisplayId='0', $comSenPPP='0', $txtTarikh='0', $txtTarikhHingga='0')
	//public function scopedetail_checkinout_individu($query,$comPegawai='0')
    {    
        
		//echo $departmentDisplayId;
		//echo $comSenPPP;
		//echo $txtTarikh;
		//echo $txtTarikhHingga;
		
		//echo $comSenPPP;
		$txtTarikh_format = $txtTarikh.' 00:00:00:000';
		$txtTarikhHingga_format = $txtTarikhHingga.' 23:59:59:000';
		
		
		if($comSenPPP == '0'){
			
			//echo $comSenPPP == '3';
			//echo '3a';
           
		   /*                             
			$sql_userinfo="SELECT * FROM xtra_userinfo WHERE dept_id='$departmentDisplayId'";
			$result_userinfo=mysqli_query($sql_userinfo);
			//$result_userinfo=mysqli_query($con,$sql_userinfo);
			//$count_userinfo=mysqli_num_rows($result_userinfo);
	
			while($rows_userinfo=mysqli_fetch_array($result_userinfo)){	
	
				echo $anggota_id_userinfo = $rows_userinfo['anggota_id'];
				$nama_userinfo = $rows_userinfo['nama'];
				
			}
			*/
			
			
			//return $query
			return $query->leftjoin('xtra_userinfo','checkinout.userid','=','xtra_userinfo.anggota_id')
			->select ('*','xtra_userinfo.nama as namaa')	
			//->where('pcrs.checkinout.userid', '=', '3')	
			->where('pcrs.xtra_userinfo.dept_id', '=', $departmentDisplayId)
			//->where('pcrs.checkinout.checktime', '>', '2021-06-01 00:00:00.000')
			//->where('pcrs.checkinout.checktime', '<', '2021-12-31 00:00:00.000')		
			->where('pcrs.checkinout.checktime', '>', $txtTarikh_format)
			->where('pcrs.checkinout.checktime', '<', $txtTarikhHingga_format)
			->get();
			
		}
		if($comSenPPP != '0'){
		
			//echo '3b';
			
			//return $query
			return $query->leftjoin('xtra_userinfo','checkinout.userid','=','xtra_userinfo.anggota_id')
			->select ('*','xtra_userinfo.nama as namaa')	
			//->where('pcrs.checkinout.userid', '=', '3')	
			->where('pcrs.checkinout.userid', '=', $comSenPPP)
			//->where('pcrs.checkinout.checktime', '>', '2021-06-01 00:00:00.000')
			//->where('pcrs.checkinout.checktime', '<', '2021-12-31 00:00:00.000')		
			->where('pcrs.checkinout.checktime', '>', $txtTarikh_format)
			->where('pcrs.checkinout.checktime', '<', $txtTarikhHingga_format)
			->get();
		
		}
		
    } 


    public function scopeKelulusanJustifikasi($query, $kategori_acara='0')
    {
		

        if($kategori_acara == '0'){
			return $this->pemohonJustifikasi()
			->where('flag_kelulusan', Acara::STATUS_PERMOHONAN_MOHON)
			->with('finalAttendance.anggota');
		}
		return $this->pemohonJustifikasi()
			->where('flag_kelulusan', Acara::STATUS_PERMOHONAN_MOHON)
			->where('kategori', $kategori_acara)
			->with('finalAttendance.anggota');
    }



		
	public function scopePermohonan_jtc($query, $kategori_acara='0', $txtTarikhMula='0', $txtTarikhAkhir='0')
    {
		
		$txtTarikhMula_format = $txtTarikhMula.' 00:00:00';
		$txtTarikhAkhir_format = $txtTarikhAkhir.' 00:00:00';

        if($kategori_acara == '0'){
			return $this->pemohonAcaraIndividu()->with('finalAttendance.anggota')
			->where('tarikh_mula', '>=', $txtTarikhMula_format)
			->where('tarikh_mula', '<=', $txtTarikhAkhir_format);
		}
		return $this->pemohonAcaraIndividu()
			->where('kategori', $kategori_acara)
			->where('tarikh_mula', '>=', $txtTarikhMula_format)
			->where('tarikh_mula', '<=', $txtTarikhAkhir_format)
			->with('finalAttendance.anggota');
    }
		
	
}
