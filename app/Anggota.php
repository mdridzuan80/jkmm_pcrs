<?php

namespace App;

use Carbon\Carbon;
use App\Base\BaseModel;
use Illuminate\Http\Request;
use App\Abstraction\Flowable;
use Illuminate\Support\Facades\Auth;

class Anggota extends BaseModel implements Flowable
{
    const KEHADIRAN = 'kehadiran';
    const FINALKEHADIRAN = 'finalKehadiran';
    const ACARA = 'acara';
    const CUTI = 'cuti';

    public function __construct()
    {
        $this->table = 'userinfo';
        $this->primaryKey = 'userid';
        $this->setDateFormat(config('pcrs.modelDateFormat'));
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'defaultdeptid');
    }

    public function shifts()
    {
        return $this->belongsToMany(Shift::class, 'anggota_shift', 'anggota_id', 'shift_id')
            ->as('waktu_bekerja_anggota')
            ->withPivot('id', 'tkh_mula', 'tkh_tamat');
    }

    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class, 'userid', 'userid');
    }

    public function finalKehadiran()
    {
        return $this->hasMany(FinalAttendance::class, 'anggota_id');
    }

    public function penilai()
    {
        return $this->hasOne(Anggota::class, 'ssn', 'ophone');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'anggota_id');
    }

    public function acara()
    {
        return $this->hasMany(Acara::class, 'anggota_id');
    }

    public function pegawaiPenilai()
    {
        return $this->hasOne(PegawaiPenilai::class, 'anggota_id');
    }

    public function pegawaiYangDinilai()
    {
        return $this->hasMany(PegawaiPenilai::class, 'pegawai_id');
    }

    public function pegawaiYangMenilai()
    {
        return $this->hasMany(PegawaiPenilai::class, 'anggota_id');
    }

    public function xtraAttr()
    {
        return $this->hasOne(XtraAnggota::class, 'anggota_id');
    }

    public function scopeXtraAnggota($query)
    {
        return $query
            ->leftJoin('xtra_userinfo', 'xtra_userinfo.anggota_id', '=', $this->getTable() . '.' . $this->getKeyName())
            ->orderBy('xtra_userinfo.nama');
    }

    public function flow()
    {
        return $this->hasOne(FlowAnggota::class, 'anggota_id');
    }

    public function scopeAuthorize($query)
    {
        $related = [];
        $effectedDept = Auth::user()->roles()->where('key', Auth::user()->perananSemasa()->key)->get()->map(function ($item, $key) {
            return $item->pivot->department_id;
        })->flatten()->unique()->toArray();

        foreach ($effectedDept as $dept) {
            $related = array_merge($related, array_flatten(Utility::pcrsRelatedDepartment(Department::all(), $dept)));
        }

        $query->whereIn('dept_id', array_merge($effectedDept, $related));
    }

    public function scopeSenaraiAnggota($query, $search)
    {
        return $query->xtraAnggota()->with(['user'])
            ->whereRaw('IF(dept_id, dept_id, 1) IN(' . $search->get('dept') . ')')
            ->when($search->get('key'), function ($query) use ($search) {
                $query->whereRaw("concat(badgenumber,if(isnull(nama), '', nama), if(isnull(nokp), '', nokp), if(isnull(jawatan), '', jawatan)) LIKE '%" . $search->get('key') . "%'");
            })
            ->when(Auth::user()->email !== env('PCRS_DEFAULT_USER_ADMIN', 'admin@internal'), function ($query) {
                $query->authorize();
            });
    }

    public function kemaskiniProfil(Request $request)
    {
        XtraAnggota::updateOrCreate(
            ['anggota_id' => $request->input('txtAnggotaId')],
            [
                'anggota_id' => $request->input('txtAnggotaId'),
                'nama' => $request->input('txtNama'),
                'nokp' => $request->input('txtNoKP'),
                'jawatan' => $request->input('txtJawatan'),
                'email' => $request->input('txtEmail'),
                'nohp' => $request->input('txtTelefon'),
                'dept_id' => $request->input('txtDepartmentId'),
            ]
        );
    }

    public function kemaskiniPPP(Request $request)
    {
        $this->pegawaiYangMenilai()->updateOrCreate(
            [
                'pegawai_flag' => $request->input('pegawai-flag'),
            ],
            [
                'pegawai_flag' => $request->input('pegawai-flag'),
                'pegawai_id' => $request->input('comSenPPP'),
            ]
        );
    }

    public function storeBaseBahagian(Request $request)
    {
        $this->xtraAttr()->updateOrCreate([], ['basedept_id' => $request->input('txtDepartmentId')]);
    }

    public function updateFlow(Request $request)
    {
        $this->flow()->updateOrCreate([], ['flag' => $request->input('flag'), 'ubah_user_id' => Auth::user()->username]);
    }

    public function getAcaraTerlibat($method, Carbon $tarikh)
    {
        if ($method === self::KEHADIRAN) {
            $today = null;

            if ($tarikh->isToday()) {
                $today = $this->{$method}()->today()->get();

                if ($today) {
                    return [Kehadiran::itemEventableNone()];
                }
            }

            return $today;
        }

        if ($method == self::CUTI) {
            return (new Cuti)->getEventablesByDate($tarikh)->get();
        }

        return $this->{$method}()->getEventablesByDate($tarikh)->get();
    }
}
