<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsencesController extends Controller
{

    public function check() {
        $students = DB::table('students')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->select('users.lastname', 'users.firstname')
            ->get();

        return view('professor.check_absences')->with('students', $students);
    }
}
