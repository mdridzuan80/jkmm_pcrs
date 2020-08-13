<?php

namespace App\Services\FinalAttendance;

use App\Puasa;
use App\Anggota;
use App\ShiftConf;

class KesalahanCalculatorManager
{
    private $userShiftConf;

    public function calculate(Anggota $profil, $tarikh, $check_in, $check_out, $cuti, $shift)
    {
        $shiftConf = new ShiftConf;
        $puasa = new Puasa;
        $this->userShiftConf = $shiftConf->confTahunSemasa($profil->userid);

        if ($this->userShiftConf->count()) {
            if ($this->existJenisByTarikh(ShiftConf::MENGANDUNG, $tarikh)) {
                return (new KesalahanMengandung)
                    ->kesalahanCalculator($tarikh, $check_in, $check_out, $shift, $cuti); // mengandung
            }

            if ($this->existJenisByTarikh(ShiftConf::PUASA, $tarikh)->count()
                && $this->existJenisByTarikh(ShiftConf::PUASA, $tarikh)->first()->jenis === ShiftConf::NORMAL) {
                return (new KesalahanNormal)
                    ->kesalahanCalculator($tarikh, $check_in, $check_out, $shift, $cuti); // normal
            }

            return (new KesalahanPuasa)
                ->kesalahanCalculator($tarikh, $check_in, $check_out, $shift, $cuti); // puasa
        }

        return (new KesalahanNormal)
            ->kesalahanCalculator($tarikh, $check_in, $check_out, $shift, $cuti); // normal
    }

    private function existJenisByTarikh($jenis, $tarikh)
    {
        return $this->userShiftConf->filter(function ($conf, $key) use ($jenis, $tarikh) {
            return $conf->jenis == $jenis 
                && $conf->tkh_mula <= $tarikh->format('Y-m-d')
                && $conf->tkh_tamat > $tarikh->format('Y-m-d');
        });
    }
}
