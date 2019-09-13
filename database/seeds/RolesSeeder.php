<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role;
        $role->key = 'SUPER_ADMIN';
        $role->name = 'Super Admin';
        $role->priority = 0;
        $role->save();

        $role = new Role;
        $role->key = 'ADMIN';
        $role->name = 'Admin';
        $role->priority = 1;
        $role->save();

        $role = new Role;
        $role->key = 'KETUA_JABATAN';
        $role->name = 'Ketua Jabatan/Unit';
        $role->priority = 2;
        $role->save();

        $role = new Role;
        $role->key = 'KETUA_KERANI';
        $role->name = 'Ketua Kerani';
        $role->priority = 3;
        $role->save();

        $role = new Role;
        $role->key = 'PENGGUNA';
        $role->name = 'Pengguna';
        $role->priority = 4;
        $role->save();
    }
}
