<?php

namespace App\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class WaktuBekerjaTransformer extends TransformerAbstract
{
    public function transform($pivot)
    {
        return [
            'USERID' => $pivot->waktu_bekerja_anggota->anggota_id,
            'STARTTIME' => $pivot->check_in->format('H:i:s.u'),
            'ENDTIME' => $pivot->check_out->format('H:i:s.u'),
            'YEAR' => Carbon::parse($pivot->waktu_bekerja_anggota->tkh_mula)->year,
            'MONTH' => Carbon::parse($pivot->waktu_bekerja_anggota->tkh_mula)->month,
            'STARTDATE' => Carbon::parse($pivot->waktu_bekerja_anggota->tkh_mula)->format('Y-m-d'),
            'ENDDATE' => Carbon::parse($pivot->waktu_bekerja_anggota->tkh_tamat)->format('Y-m-d'),
            'NUM_RUNID' => $pivot->waktu_bekerja_anggota->id,
            'NAME' => $pivot->name,
        ];
    }
}