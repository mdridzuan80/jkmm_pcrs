<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shift extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = [
        'check_in',
        'check_out',
        'deleted_at',
    ];

    public function __construct()
    {
        $this->setDateFormat(config('pcrs.modelDateFormat'));
    }

    public function anggota()
    {
        return $this->belongsToMany(Anggota::class, 'anggota_shift', 'shift_id', 'anggota_id')
            ->withPivot('tkh_mula', 'tkh_tamat', 'id');
    }
}
