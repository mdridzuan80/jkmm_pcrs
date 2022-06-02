<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class XtraAnggota extends Model
{
    protected $table = 'xtra_userinfo';

    protected $primaryKey = 'anggota_id';

    protected $fillable = ['anggota_id', 'basedept_id', 'email', 'nama', 'nokp', 'jawatan', 'dept_id', 'nohp'];

    public function __construct()
    {
        $this->setDateFormat(config('pcrs.modelDateFormat'));
    }

    //----Relationship-----
    public function user()
    {
        return $this->hasOne(User::class, 'anggota_id');
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }

    public function baseDepartment()
    {
        return $this->belongsTo(Department::class, 'basedept_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id');
    }

    public function flowBaseDepartment()
    {
        return $this->hasOne(FlowBahagian::class, 'dept_id', 'basedept_id');
    }

    public function flow()
    {
        return $this->hasOne(FlowAnggota::class, 'anggota_id');
    }

    public function warnaKad()
    {
        return $this->hasMany(Kad::class, 'anggota_id', 'anggota_id');
    }

    public function shifts()
    {
        return $this->belongsToMany(Shift::class, 'anggota_shift', 'anggota_id', 'shift_id')
            ->as('waktu_bekerja_anggota')
            ->withPivot('id', 'tkh_mula', 'tkh_tamat');
    }

    public function finalAttendance()
    {
        return $this->hasMany(FinalAttendance::class, 'anggota_id', 'anggota_id');
    }

    public function pegawaiYangDinilai()
    {
        return $this->hasMany(PegawaiPenilai::class, 'pegawai_id');
    }

    public function pemohonJustifikasi()
    {
        return $this->hasMany(Acara::class, 'pelulus_id');
    }

    public function pemohonAcaraIndividu()
    {
        return $this->hasMany(Acara::class, 'anggota_id');
    }

    //----End Relationship-----

    public function scopeKelulusanJustifikasi($query, $kategori_acara='0')
    {
		

        if($kategori_acara == '0'){
			return $this->pemohonJustifikasi()
			->where('flag_kelulusan', Acara::STATUS_PERMOHONAN_MOHON)
			->with('finalAttendance.anggota')
			->orderBy('tarikh_mula', 'desc');
		}
		return $this->pemohonJustifikasi()
			->where('flag_kelulusan', Acara::STATUS_PERMOHONAN_MOHON)
			->where('kategori', $kategori_acara)
			->with('finalAttendance.anggota')
			->orderBy('tarikh_mula', 'desc');
    }
	
	
	public function scopePermohonan_jtc($query, $kategori_acara='0', $txtTarikhMula='0', $txtTarikhAkhir='0')
    {
		
		$txtTarikhMula_format = $txtTarikhMula.' 00:00:00';
		$txtTarikhAkhir_format = $txtTarikhAkhir.' 23:59:59';

        if($kategori_acara == '0'){
			return $this->pemohonAcaraIndividu()->with('finalAttendance.anggota')
			->where('tarikh_mula', '>=', $txtTarikhMula_format)
			->where('tarikh_mula', '<=', $txtTarikhAkhir_format)
			->orderBy('tarikh_mula', 'desc');
		}
		return $this->pemohonAcaraIndividu()
			->where('kategori', $kategori_acara)
			->where('tarikh_mula', '>=', $txtTarikhMula_format)
			->where('tarikh_mula', '<=', $txtTarikhAkhir_format)
			->with('finalAttendance.anggota')
			->orderBy('tarikh_mula', 'desc');
    }
	

    public static function setupXtra($profil, User $user)
    {
        $xtra = self::updateOrCreate(
            ['anggota_id' => $user->anggota_id, 'email' => $profil->email],
            [
                'nama' => $profil->name,
                'nohp' => $profil->telephone,
                'jawatan' => $profil->grade,
                'basedept_id' => $profil->dept_id,
                'dept_id' => $profil->dept_id
            ]
        );
    }

    public function kesalahanBulanan(Carbon $tkh)
    {
        return $this->finalAttendance()
            ->where('tarikh', '>=', $tkh->format('Y-m-d'))
            ->where('tarikh', '<=', $tkh->format('Y-m-') . $tkh->daysInMonth)
            ->where('tatatertib_flag', 'TS')
            ->with('justifikasi')
            ->get()
            ->filter(function ($value) {
                if ($value->justifikasi->isEmpty()) {
                    return true;
                }

                foreach ($value->justifikasi as $justifikasi) {
                    if ($justifikasi->isJustified()) {
                        return true;
                    }
                }

                return false;
            });
    }

    public function warnaKadByBulan($bulan, $tahun)
    {
        $kad = $this->warnaKad()->where("bulan", $bulan)->where("tahun", $tahun)->first();

        return $kad->warna_kod ?? Warna::KUNING;
    }
	
	public function scopelist_nama_ikutdepartment($query, $departmentDisplayId, $comSenPPP)
    {    
	
		if($comSenPPP == '0'){
			
			//return $query
			//->select ('*')	
			return $query->leftjoin('userinfo','xtra_userinfo.anggota_id','=','userinfo.userid')
			->select ('*','userinfo.Badgenumber as badgenumberr')	
			->where('pcrs.xtra_userinfo.dept_id', '=', $departmentDisplayId)
			->get();	
		
		}else{
			
			//return $query
			//return $query
			//->select ('*')
			return $query->leftjoin('userinfo','xtra_userinfo.anggota_id','=','userinfo.userid')
			->leftjoin('departments','departments.deptid','=','xtra_userinfo.dept_id')
			
			->select ('*','userinfo.Badgenumber as badgenumberr')		
			//->where('dept_id', '=', $departmentDisplayId)
			->where('pcrs.xtra_userinfo.anggota_id', '=', $comSenPPP)
			->get();	
		
		}			
		
    } 
	
	
	
	
	public function scopelist_nama_ikutdepartmentALL($query, $departmentDisplayId, $comSenPPP)
    {    
			
			//return $query
			//->select ('*')	
			return $query->leftjoin('userinfo','xtra_userinfo.anggota_id','=','userinfo.userid')
			->leftjoin('departments','xtra_userinfo.basedept_id','=','departments.deptid')
			->select ('*','userinfo.Badgenumber as badgenumberr')	
			->where('pcrs.xtra_userinfo.dept_id', '=', $departmentDisplayId)
			->get();	
		
			
		
    } 
	
}
