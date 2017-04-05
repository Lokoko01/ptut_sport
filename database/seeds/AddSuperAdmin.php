<?php

use Illuminate\Database\Seeder;
use App\Role;

class AddSuperAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Role();
        $admin->name         = 'superadmin';
        $admin->display_name = 'SuperAdmin'; // optional
        $admin->save();
    }
}
