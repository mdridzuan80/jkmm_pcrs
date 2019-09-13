<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const SUPER_ADMIN = 'SUPER_ADMIN';
    const ADMIN = 'ADMIN';
    const KETUA_JABATAN = 'KETUA_JABATAN';
    const KETUA_KERANI = 'KETUA_KERANI';
    const PENGGUNA = 'PENGGUNA';

    public function __construct()
    {
        $this->setDateFormat(config('pcrs.modelDateFormat'));
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function xtraAnggota()
    {
        return $this->belongsToMany(XtraAnggota::class);
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'role_user', 'role_id', 'department_id');
    }
}
