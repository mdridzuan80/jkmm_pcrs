<?php

namespace App\Services;

use App\Cuti;
use App\Anggota;
use App\Parameter;
use App\Kehadiran;
use App\Kelewatan;
use Carbon\Carbon;
use App\XtraAnggota;
use App\FinalAttendance;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use App\Services\FinalAttendance\KesalahanCalculatorManager;

class FinalAttendanceService
{
    //const TOTAL_HOUR = 32400; //formula 9 hours in second 60*60*9
    //const MINIMUM = "7:30";

    private $statusLewat = false;

    public function tarikhTamat($tkhTamat)
    {
        if ($tkhTamat->lt(Carbon::now())) {
            return $tkhTamat;
        }

        return Carbon::now()->subDays(1);
    }

    public function janaFinalAttendanceConsole(Collection $usersCollection, Carbon $tkhMula, Carbon $tkhTamat, Command $command)
    {
        $fTarikhTamat = clone $tkhTamat;
        $fTarikhTamat->addDay();

        $cuti = Cuti::whereBetween('tarikh', [$tkhMula, $fTarikhTamat])->get();
        $senaraiXAnggota = XtraAnggota::with('anggota', 'shifts')->when($usersCollection->isNotEmpty(), function ($query, $value) use ($usersCollection) {
            return $query->whereIn('anggota_id', $usersCollection->toArray());
        })->get();

        foreach ($senaraiXAnggota as $xAnggota) {
            if ($xAnggota->anggota) {
                $command->info($xAnggota->anggota_id . " " . $xAnggota->nama);
                $rekodKehadiran = $xAnggota->anggota->kehadiran()->rekodByMulaTamat($tkhMula, $fTarikhTamat)->orderBy('checktime')->get();
                $shifts =  $xAnggota->shifts;
                $fTarikh = clone $tkhMula;

                do {
                    $shift = $shifts->first(function ($value, $key) use ($fTarikh) {
                        return Carbon::parse($value->waktu_bekerja_anggota->tkh_mula)->lte($fTarikh) && Carbon::parse($value->waktu_bekerja_anggota->tkh_tamat)->gte($fTarikh);
                    });

                    if ($shift) {
                        $this->personelFinalAttendance($xAnggota->anggota, $fTarikh, $shift, $cuti, $rekodKehadiran);
                    }
                } while ($fTarikh->addDay()->lte($tkhTamat));
            }
        }
    }

    public function janaPersonelFinalAttendance(Anggota $profil, Carbon $tkhMula, Carbon $tkhTamat, $shift)
    {
        $cuti = Cuti::whereBetween('tarikh', [$tkhMula, $tkhTamat])->get();
        $rekodKehadiran = $profil->kehadiran()->rekodByMulaTamat($tkhMula, $tkhTamat)->orderBy('checktime')->get();
        $fTarikh = clone $tkhMula;

        do {
            $this->personelFinalAttendance($profil, $fTarikh, $shift, $cuti, $rekodKehadiran);
        } while ($fTarikh->addDay()->lte($tkhTamat));
    }

    public function personelFinalAttendance(Anggota $profil, Carbon $tarikh, $shift, $cuti, $rekodKehadiran)
    {
        $preData = $this->preDataFinalAttendance($profil, $tarikh, $shift, $cuti, $rekodKehadiran);

        $this->janaFinalAttendance($profil, $preData, $shift);

        if ($this->statusLewat) {
            $this->tambahLewat($profil, $preData, $shift, Kelewatan::FLAG_NON_SMS);
            $this->statusLewat = false;
        }
    }

    private function preDataFinalAttendance(Anggota $profil, Carbon $tarikh, $shift, $cuti, $rekodKehadiran)
    {
        $check_in = $this->punch($rekodKehadiran, $tarikh, $cuti, Kehadiran::PUNCH_IN, $profil->ZIP);
        $check_out = $this->punch($rekodKehadiran, $tarikh, $cuti, Kehadiran::PUNCH_OUT, $profil->ZIP);
        $check_in_mid = $this->punch($rekodKehadiran, $tarikh, $cuti, Kehadiran::PUNCH_MIN, $profil->ZIP);
        $check_out_mid = $this->punch($rekodKehadiran, $tarikh, $cuti, Kehadiran::PUNCH_MOUT, $profil->ZIP);
        $kesalahan = (new KesalahanCalculatorManager)->calculate($profil, $tarikh, $check_in, $check_out, $cuti, $shift);
        return (object) [
            'anggota_id' => $profil->userid,
            'basedept_id' => $profil->xtraAttr->basedept_id,
            'tarikh' => $tarikh,
            'check_in' => $check_in,
            'check_out' => $check_out,
            'check_in_mid' => $check_in_mid,
            'check_out_mid' => $check_out_mid,
            'kesalahan' => json_encode($kesalahan),
            'tatatertib_flag' => $this->getFlag($kesalahan),
            'shift_id' => $shift->id,
        ];
    }

    private function punch($rekodKehadiran, Carbon $tarikh, $cuti, $jnsPunch, $jnsUser)
    {
        $closureFilter = function ($value, $key) use ($tarikh, $cuti, $jnsPunch, $jnsUser) {
            switch ($jnsPunch) {
                case Kehadiran::PUNCH_IN:
                    if ($this->isCuti($tarikh, $cuti)) {
                        return $value->checktime->gte($tarikh->copy()->addHours(4)) &&
                            $value->checktime->lt($tarikh->copy()->addDays(1)->addHours(4));
                    } else {
                        return $value->checktime->gte($tarikh->copy()->addHours(4)) &&
                            $value->checktime->lt($tarikh->copy()->addHours(13));
                    }

                    break;

                case Kehadiran::PUNCH_OUT:
                    if ($this->isCuti($tarikh, $cuti)) {
                        return $value->checktime->gte($tarikh->copy()->addHours(4)) &&
                            $value->checktime->lt($tarikh->copy()->addDays(1)->addHours(4));
                    } else {
                        return $value->checktime->gte($tarikh->copy()->addHours(13)) &&
                            $value->checktime->lt($tarikh->copy()->addDays(1)->addHours(4));
                    }

                    break;

                case Kehadiran::PUNCH_MIN:
                    if ($jnsUser) {
                        return $value->checktime->gte($tarikh->copy()->addHours(4)) &&
                            $value->checktime->lt($tarikh->copy()->addDays(1)->addHours(4)) &&
                            $value->checktype == '1';
                    }

                    break;

                case Kehadiran::PUNCH_MOUT:
                    if ($jnsUser) {
                        return $value->checktime->gte($tarikh->copy()->addHours(4)) &&
                            $value->checktime->lt($tarikh->copy()->addDays(1)->addHours(4)) &&
                            $value->checktype == 'i';
                    }

                    break;
            }
        };

        $data = $rekodKehadiran->filter($closureFilter);

        if ($data->isNotEmpty()) {
            if ($jnsPunch == Kehadiran::PUNCH_IN || $jnsPunch == Kehadiran::PUNCH_MIN) {
                return $data->first()->checktime;
            }

            if ($jnsPunch == Kehadiran::PUNCH_OUT || $jnsPunch == Kehadiran::PUNCH_MOUT) {
                return $data->last()->checktime;
            }
        }

        return null;
    }

    public function getFlag($kesalahan)
    {
        foreach ($kesalahan as $salah) {
            if ($salah != Kehadiran::FLAG_KESALAHAN_NONE) {
                return Kehadiran::FLAG_TATATERTIB_TUNJUK_SEBAB;
            }
        }

        return Kehadiran::FLAG_TATATERTIB_CLEAR;
    }

    public function janaFinalAttendance($profil, $preData, $shift)
    {
        FinalAttendance::updateOrCreate(['anggota_id' => $preData->anggota_id, 'tarikh' => $preData->tarikh], (array) $preData);
    }

    public function tambahLewat($profil, $preData, $shift, $smsFlag)
    {
        $lewat = new Kelewatan;
        $lewat->anggota_id = $profil->userid;
        $lewat->shift_id = $shift->id;
        $lewat->check_in = $preData->check_in;
        $lewat->send_sms_flag = $smsFlag;

        return $lewat->save();
    }

    public function hapusLewat($profil, $tkhMula, $tkhTamat)
    {
        return Kelewatan::where('anggota_id', $profil->userid)
            ->where('check_in', '>=', $tkhMula)
            ->where('check_in', '<=', $tkhTamat)
            ->delete();
    }

    public function isCuti(Carbon $tarikh, $cuti)
    {
        return $cuti->contains(function ($item, $key) use ($tarikh) {
            return $item->tarikh->eq($tarikh);
        }) ||
            $tarikh->dayOfWeek == Carbon::SATURDAY ||
            $tarikh->dayOfWeek == Carbon::SUNDAY;
    }
}
