<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warna extends Model
{
    protected $table = 'warna';

    const KUNING = "KUNING";
    const HIJAU = "HIJAU";
    const MERAH = "MERAH";
}
