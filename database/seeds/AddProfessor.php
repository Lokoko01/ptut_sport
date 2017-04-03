<?php

use Illuminate\Database\Seeder;
use App\Role;
class AddProfessor extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $student = new Role();
        $student->name         = 'professor';
        $student->display_name = 'Professeur'; // optional
        $student->save();
    }
}
