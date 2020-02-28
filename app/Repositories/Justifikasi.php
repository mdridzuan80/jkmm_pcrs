<?php

namespace App\Repositories;

use Auth;
use App\Acara;
use Carbon\Carbon;
use App\Contracts\Catatan;

class Justifikasi implements Catatan
{
    const FLAG_MEDAN_KESALAHAN_PAGI = "PAGI";
    const FLAG_MEDAN_KESALAHAN_PETANG = "PETANG";

    const FLAG_JUSTIKASI_SAMA = "SAMA";
    const FLAG_JUSTIKASI_TIDAK_SAMA = "XSAMA";

    const PUNCH_OUT = "OUT";
    const PUNCH_MIN = "MIN";
    const PUNCH_MOUT = "MOUT";

    public function simpan(array $data)
    {
        if (!Acara::isOverlaped(Auth::user()->id, Carbon::parse($data['tarikh_mula']), Carbon::parse($data['tarikh_tamat']))) {
            $justifikasi = new Acara;
            $justifikasi->basedept_id = $data['basedept_id'];
            $justifikasi->final_attendance_id = $data['finalattendance_id'];
            $justifikasi->tarikh_mula = $data['tarikh_mula'];
            $justifikasi->tarikh_tamat = $data['tarikh_tamat'];
            $justifikasi->medan_kesalahan = $data['medan_kesalahan'];
            $justifikasi->flag_justifikasi = $data['flag_justifikasi'];
            $justifikasi->keterangan = $data['alasan'];
            $justifikasi->pelulus_id = $data['pelulus_id'];
            $justifikasi->kategori = $data['kategori'];
            $justifikasi->user_id = Auth::user()->id;
            $justifikasi->save();
            return true;
        }

        return false;
    }
}
