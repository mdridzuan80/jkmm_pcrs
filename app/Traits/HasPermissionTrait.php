<?php

namespace App\Traits;

trait HasPermissionTrait
{
    public function roles()
    {
        return $this->belongsToMany('App\Role')->using('App\RoleUser')
            ->withPivot('id', 'department_id');
    }

    public function hasRole(...$roles)
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('key', $role)) {
                return true;
            }
        }

        return false;
    }

    public function hasKelulusanSubmitter()
    {
        return $this->xtraAnggota->pegawaiYangDinilai()->where('pegawai_flag', 1)->count();
    }
}
