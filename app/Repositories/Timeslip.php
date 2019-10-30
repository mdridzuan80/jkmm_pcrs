<?php

namespace App\Repositories;

use Auth;
use App\Acara;
use App\Contracts\Catatan;

class Timeslip implements Catatan
{
    public function simpan(array $data)
    {
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
    }
}
