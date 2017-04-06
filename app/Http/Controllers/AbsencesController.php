<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AbsencesController extends Controller
{

    public function check()
    {
        $professor = Auth::user()->professor->id;

        $students = DB::table('students')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->join('student_sport', 'student_sport.student_id', '=', 'students.id')
            ->select(DB::raw("CONCAT(users.lastname,' ',users.firstname) as full_name"))
            ->whereIn('student_sport.session_id', function ($query) use ($professor) {
                $query->select(DB::raw('sessions.id'))
                    ->from('sessions')
                    ->where('sessions.professor_id', $professor);
            })
            ->get();

        return view('professor.check_absences')->with('students', $students);
    }
}
