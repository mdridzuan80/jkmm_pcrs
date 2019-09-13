<?php

namespace App\Services;

use DB;
use App\Shift;
use App\Anggota;
use Carbon\Carbon;
use FinalAttendance;
use Illuminate\Support\Collection;

class WaktuBerperingkatService
{
    public function createBulanan(Anggota $profil, $CBulan, $tahun, $shift)
    {
        foreach ($this->excludeCreatedBulanan($profil, $CBulan, $tahun) as $bulan) {
            $tkhMula = Carbon::create($tahun, $bulan, 1, 0, 0, 0);
            $tkhTamat = Carbon::create($tahun, $bulan, cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun), 0, 0, 0);

            DB::transaction(function () use ($profil, $tkhMula, $tkhTamat, $bulan, $shift) {
                $profil->shifts()->attach($shift, ['tkh_mula' => $tkhMula, 'tkh_tamat' => $tkhTamat]);

                if ($bulan <= Carbon::now()->month) {
                    FinalAttendance::janaPersonelFinalAttendance($profil, $tkhMula, FinalAttendance::tarikhTamat($tkhTamat), $shift);
                }
            });
        }
    }

    public function createHarian(Anggota $profil, Carbon $tkhMula, Carbon $tkhTamat, Shift $shift)
    {
        if ($this->hasCreateHarian($profil, $tkhMula, $tkhTamat)) {
            return abort(409);
        }

        $profil->shifts()->attach($shift, ['tkh_mula' => $tkhMula, 'tkh_tamat' => $tkhTamat]);
    }

    public function hapus(Anggota $profil, $waktuBekerjaId)
    {
        DB::transaction(function () use ($profil, $waktuBekerjaId) {
            $waktuBekerja = $profil->shifts()
                ->newPivotStatement()
                ->where('id', $waktuBekerjaId)
                ->where('anggota_id', $profil->userid)
                ->first();

            $profil->shifts()->newPivotStatement()->where('id', $waktuBekerjaId)->where('anggota_id', $profil->userid)->delete();
            FinalAttendance::hapusLewat($profil, $waktuBekerja->tkh_mula, $waktuBekerja->tkh_tamat);
        });
    }

    private function excludeCreatedBulanan(Anggota $profil, Collection $bulan, $tahun)
    {
        $convert = function ($array_data) {
            $d = [];

            foreach ($array_data as $data) {
                $d[] = (array) $data;
            }

            return collect(array_flatten($d));
        };

        return $bulan->diff(
            $convert($profil->shifts()->newPivotStatement()
                ->selectRaw('MONTH(tkh_mula) as bulan')
                ->whereRaw('YEAR(tkh_mula) = ?', [$tahun])
                ->where('anggota_id', $profil->userid)
                ->get()->toArray())
        );
    }

    private function hasCreateHarian(Anggota $profil, Carbon $tkhMula, Carbon $tkhTamat)
    {
        return $profil->shifts()->newPivotStatement()
            ->where('anggota_id', $profil->userid)
            ->whereRaw('((tkh_mula >= ? AND tkh_tamat <= ?) OR (tkh_mula <= ? AND tkh_tamat >= ?))', [$tkhMula, $tkhTamat, $tkhTamat, $tkhMula])
            ->exists();
    }
}
