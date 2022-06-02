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
       
	   if (!Acara::isOverlaped(Auth::user()->id, Carbon::parse($data['tarikh_mula']), Carbon::parse($data['tarikh_tamat']), date("Y-m-d", strtotime(Carbon::parse($data['tarikh_mula']))), date("Y-m-d", strtotime(Carbon::parse($data['tarikh_tamat']))), date("H", strtotime(Carbon::parse($data['tarikh_mula']))).date("i", strtotime(Carbon::parse($data['tarikh_mula']))).date("s", strtotime(Carbon::parse($data['tarikh_mula']))), date("H", strtotime(Carbon::parse($data['tarikh_tamat']))).date("i", strtotime(Carbon::parse($data['tarikh_tamat']))).date("s", strtotime(Carbon::parse($data['tarikh_tamat']))))) {
            $justifikasi = new Acara;
            $justifikasi->basedept_id = $data['basedept_id'];
            $justifikasi->final_attendance_id = $data['finalattendance_id'];
            $justifikasi->tarikh_mula = Carbon::parse($data['tarikh_mula']);
            $justifikasi->tarikh_tamat = Carbon::parse($data['tarikh_tamat']);
			
            $justifikasi->tarikh_mula_date = date("Y-m-d", strtotime(Carbon::parse($data['tarikh_mula'])));
            $justifikasi->tarikh_tamat_date = date("Y-m-d", strtotime(Carbon::parse($data['tarikh_tamat'])));
			
            $justifikasi->tarikh_mula_time = date("H", strtotime(Carbon::parse($data['tarikh_mula']))).date("i", strtotime(Carbon::parse($data['tarikh_mula']))).date("s", strtotime(Carbon::parse($data['tarikh_mula'])));
            $justifikasi->tarikh_tamat_time = date("H", strtotime(Carbon::parse($data['tarikh_tamat']))).date("i", strtotime(Carbon::parse($data['tarikh_tamat']))).date("s", strtotime(Carbon::parse($data['tarikh_tamat'])));
			
            $justifikasi->medan_kesalahan = $data['medan_kesalahan'];
            $justifikasi->flag_justifikasi = $data['flag_justifikasi'];
            $justifikasi->keterangan = $data['alasan'];
            $justifikasi->pelulus_id = $data['pelulus_id'];
            $justifikasi->kategori = $data['kategori'];
            $justifikasi->user_id = Auth::user()->id;			
            $justifikasi->anggota_id = Auth::user()->xtraAnggota->anggota_id;		
			//$justifikasi->anggota_id = '5';	
			
            $justifikasi->save();
			
            return true;
        }

        return false;
    }
}
