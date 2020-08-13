<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ShiftConf extends Model
{
    const NORMAL = 'NORMAL';
    const PUASA = 'PUASA';
    const MENGANDUNG = 'MENGANDUNG';

    protected $table = 'shift_confs';

    protected $fillable = ['anggota_id', 'puasa_id', 'jenis', 'pilihan', 'tkh_mula', 'tkh_tamat'];

    public function scopeTahunSemasa($query)
    {
        $tkhMula = Carbon::now()->year . "-01-01 00:00:00";
        $tkhTamat = Carbon::now()->year + 1 . "-01-01 00:00:00";

        return $query->where('tkh_mula', '>=', $tkhMula)->orWhere('tkh_tamat', '>', $tkhTamat);
    }

    private function puasaSemasa($anggota_id)
    {
        $tkhMula = Carbon::now()->year . "-01-01 00:00:00";
        $tkhTamat = Carbon::now()->year + 1 . "-01-01 00:00:00";

        return $this->join('puasa', 'shift_confs.puasa_id', '=', 'puasa.id')
            ->select('shift_confs.id', 'shift_confs.anggota_id', 'shift_confs.jenis', 'shift_confs.pilihan', 'shift_confs.puasa_id', 'puasa.tkhmula as tkh_mula', 'puasa.tkhtamat as tkh_tamat')
            ->where('shift_confs.anggota_id', $anggota_id)
            ->where('puasa.tkhmula', '>=', $tkhMula)
            ->orWhere('puasa.tkhtamat', '>', $tkhTamat);
    }

    public function confTahunSemasa($anggota_id)
    {
        $puasa = $this->puasaSemasa($anggota_id);
        return $this->tahunSemasa()
            ->select('id', 'anggota_id', 'jenis', 'pilihan', 'puasa_id', 'tkh_mula', 'tkh_tamat')
            ->where('anggota_id', $anggota_id)
            ->union($puasa)->orderBy('id')->get();
    }

    public function isExistsByDate($tarikh)
    {
        return $this->where('tkh_mula', '<=', $tarikh)->orWhere('tkh_tamat', '>', $tarikh)->exists();
    }
}
