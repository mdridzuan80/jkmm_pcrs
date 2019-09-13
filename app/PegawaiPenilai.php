<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PegawaiPenilai extends Model
{
    const FLAG_PEGAWAI_PERTAMA = 1;
    const FLAG_PEGAWAI_KEDUA = 2;

    protected $table = 'pegawai_penilai';

    protected $fillable = ['anggota_id', 'pegawai_id', 'pegawai_flag'];

    public function __construct()
    {
        $this->setDateFormat(config('pcrs.modelDateFormat'));
    }

    public function personel()
    {
        return $this->belongsTo(anggota::class, 'anggota_id');
    }

    public function penilai()
    {
        return $this->belongsTo(anggota::class, 'pegawai_id');
    }
}
