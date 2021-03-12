<?php

namespace App\Services;

use App\Kad;
use App\Warna;
use Carbon\Carbon;
use App\XtraAnggota;
use Illuminate\Support\Collection;

class WarnaKadService
{
    public function janaWarnaKadConsole(Collection $usersCollection, Carbon $tarikh)
    {
        $senAnggota = XtraAnggota::when($usersCollection->isNotEmpty(), function ($query, $value) use ($usersCollection) {
            return $query->whereIn('anggota_id', $usersCollection->toArray());
        })->get();

        $tarikhLepas = clone $tarikh;
        $tarikhLepas->subMonth();

        foreach ($senAnggota as $anggota) {
            $kad = $anggota->warnaKad()->where("bulan", $tarikhLepas->month)->where("tahun", $tarikhLepas->year)->first();

            $kadSemasa = $kad->warna_kod ?? Warna::KUNING;

            $bilKesalahan = $anggota->kesalahanBulanan($tarikh)->count();

            if ($bilKesalahan > 2) {
                switch ($kadSemasa) {
                    case Warna::KUNING:
                        $kadSemasa = Warna::HIJAU;
                        break;
                    case Warna::HIJAU:
                        $kadSemasa = Warna::MERAH;
                        break;
                }
            }

            if ($bilKesalahan == 0) {
                switch ($kadSemasa) {
                    case Warna::HIJAU:
                        $kadSemasa = Warna::KUNING;
                        break;
                    case Warna::MERAH:
                        $kadSemasa = Warna::HIJAU;
                        break;
                }
            }

            Kad::updateOrCreate(
                ["anggota_id" => $anggota->anggota_id, 'bulan' => $tarikh->month, 'tahun' => $tarikh->year],
                ["warna_kod" => $kadSemasa]
            );
        }
    }
}
