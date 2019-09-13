<?php

namespace App\Repositories;

use DB;
use App\User;
use App\XtraAnggota;

class AnggotaRepository
{
    public static function updateProfile($profile, $password)
    {
        DB::transaction(function () use ($profile, $password) {
            XtraAnggota::setupXtra($profile, User::setupLogin($profile, $password));
        });
    }
}
