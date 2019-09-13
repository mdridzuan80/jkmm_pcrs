<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name = 'Administrator';
        $user->username = 'admin';
        $user->domain = 'internal';
        $user->email = 'admin@internal';
        $user->password = bcrypt('abc123');
        $user->anggota_id = 0;
        $user->save();
    }
}
