<?php

use Illuminate\Database\Seeder;
use App\Role;
class AddAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Role();
        $admin->name         = 'admin';
        $admin->display_name = 'Administrateur'; // optional
        $admin->save();
    }
}
