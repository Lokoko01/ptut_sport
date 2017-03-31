<?php

use Illuminate\Database\Seeder;
use App\Role;
class AddRole extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $student = new Role();
        $student->name         = 'student';
        $student->display_name = 'Etudiant'; // optional
        $student->save();
    }
}
