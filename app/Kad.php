<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kad extends Model
{
    protected $table = 'kad';

    public function warna()
    {
        return $this->belongsTo(Warna::class,'warna_kod','kod');
    }
}
