<?php

namespace App\Http\Controllers;

use App\XtraAnggota;
use Illuminate\Http\Request;

class WarnaKadAnggotaController extends Controller
{
    public function show(XtraAnggota $profil, $bulan, $tahun)
    {
        return $profil->warnaKadByBulan($bulan, $tahun);
    }
}
