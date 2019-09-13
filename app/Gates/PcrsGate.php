<?php

namespace App\Gates;

use App\Role;
use Illuminate\Support\Facades\Gate;

class PcrsGate
{
    public function register()
    {
        // Anggota
        Gate::define('view-anggota', $this->minPrivilege(Role::KETUA_KERANI));

        // Profil
        Gate::define('view-profil', $this->minPrivilege(Role::KETUA_KERANI));
        Gate::define('edit-profil', $this->minPrivilege(Role::KETUA_KERANI));

        // Waktu Bekerja
        Gate::define('view-waktu_bekerja', $this->minPrivilege(Role::KETUA_KERANI));
        Gate::define('add-waktu_bekerja', $this->minPrivilege(Role::KETUA_KERANI));
        Gate::define('delete-waktu_bekerja', $this->minPrivilege(Role::KETUA_KERANI));

        // Penilai
        Gate::define('view-penilai', $this->minPrivilege(Role::KETUA_KERANI));
        Gate::define('edit-penilai', $this->minPrivilege(Role::KETUA_KERANI));

        // Pengguna
        Gate::define('view-login', $this->minPrivilege(Role::KETUA_KERANI));
        Gate::define('add-login', $this->minPrivilege(Role::KETUA_KERANI));
        Gate::define('view-peranan', $this->minPrivilege(Role::KETUA_KERANI));
        Gate::define('add-peranan', $this->minPrivilege(Role::KETUA_KERANI));
        Gate::define('delete-peranan', $this->minPrivilege(Role::KETUA_KERANI));

        // Base Bahagian
        Gate::define('view-base-bahagian', $this->minPrivilege(Role::ADMIN));
        Gate::define('edit-base-bahagian', $this->minPrivilege(Role::ADMIN));

        //profil flow
        Gate::define('view-flow-profil', $this->minPrivilege(Role::KETUA_KERANI));
        Gate::define('edit-flow-profil', $this->minPrivilege(Role::KETUA_KERANI));

        //Laporan
        Gate::define('view-laporan', $this->minPrivilege(Role::KETUA_KERANI));

        // Konfigurasi
        Gate::define('view-setting', $this->minPrivilege(Role::KETUA_KERANI));
        Gate::define('view-flow-bahagian-setting', $this->minPrivilege(Role::KETUA_KERANI));
        Gate::define('edit-flow-bahagian-setting', $this->minPrivilege(Role::KETUA_KERANI));

        Gate::define('view-shift', $this->minPrivilege(Role::ADMIN));
        Gate::define('add-shift', $this->minPrivilege(Role::ADMIN));
        Gate::define('edit-shift', $this->minPrivilege(Role::ADMIN));
        Gate::define('delete-shift', $this->minPrivilege(Role::ADMIN));

        Gate::define('view-kelulusan', $this->kelulusan());
    }

    private function minPrivilege($minPriv)
    {
        return function ($user) use ($minPriv) {
            return !($user->perananSemasa()->priority > Role::where('key', $minPriv)->first()->priority);
        };
    }

    private function kelulusan()
    {
        return function ($user) {
            return ($user->username == 'admin') ? false : $user->hasKelulusanSubmitter();
        };
    }
}
