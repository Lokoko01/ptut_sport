<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssignNoteController extends Controller
{
    public function check() {
        $students = DB::table('students')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->select(DB::raw("CONCAT(users.lastname,' ',users.firstname) as full_name"))
            ->get();

        return view('professor.check_absences')->with('students', $students);
    }
}
