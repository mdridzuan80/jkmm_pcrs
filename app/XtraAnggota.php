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
        return $this->hasMany(kad::class, 'anggota_id', 'anggota_id');
    }

    public function shifts()
    {
        return $this->belongsToMany(Shift::class, 'anggota_shift', 'anggota_id', 'shift_id')
            ->as('waktu_bekerja_anggota')
            ->withPivot('id', 'tkh_mula', 'tkh_tamat');
    }

    public function finalAttendance()
    {
        return $this->hasMany(finalAttendance::class, 'anggota_id', 'anggota_id');
    }

    public function pegawaiYangDinilai()
    {
        return $this->hasMany(PegawaiPenilai::class, 'pegawai_id');
    }

    public function pemohonJustifikasi()
    {
        return $this->hasMany(Acara::class, 'pelulus_id');
    }

    //----End Relationship-----

    public function scopeKelulusanJustifikasi()
    {
        return $this->pemohonJustifikasi()->where('flag_kelulusan', Acara::STATUS_PERMOHONAN_MOHON)->with('finalAttendance.anggota');
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
}
