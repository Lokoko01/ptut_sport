<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfessorController extends Controller
{
    public function __construct()
    {
        $this->middleware('professor');
    }

    public function index()
    {
        return view('professor.main');
    }

    public function check()
    {
        // Récupérer l'id du professeur connecté
        $professor = Auth::user()->professor->id;

        $students = DB::table('students')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->join('student_sport', 'student_sport.student_id', '=', 'students.id')
            ->join('ufr', 'ufr.id', '=', 'students.ufr_id')
            ->select(DB::raw("distinct CONCAT(users.lastname,' ',users.firstname) as full_name, students.id as student_id, ufr.label as label_ufr"))
            ->whereIn('student_sport.session_id', function ($query) use ($professor) {
                $query->select(DB::raw('sessions.id'))
                    ->from('sessions')
                    ->where('sessions.professor_id', $professor);
            })
            ->get();

        return view('professor.check_absences')->with('students', $students);
    }

    public function assignMark()
    {
        // Récupérer l'id du professeur connecté
        $professor = Auth::user()->professor->id;

        $students = DB::table('students')
            ->leftJoin('users', 'users.id', '=', 'students.user_id')
            ->leftJoin('student_sport', 'student_sport.student_id', '=', 'students.id')
            ->leftJoin('sessions', 'sessions.id', '=', 'student_sport.session_id')
            ->leftJoin('sports', 'sports.id', '=', 'sessions.sport_id')
            ->select(DB::raw("distinct CONCAT(users.lastname,' ',users.firstname) as full_name, 
                              students.id as student_id, sports.label as sport_label"))
            ->whereIn('student_sport.session_id', function ($query) use ($professor) {
                $query->select(DB::raw('sessions.id'))
                    ->from('sessions')
                    ->where('sessions.professor_id', $professor);
            })
            ->whereNotNull('sports.label')
            ->orderBy('users.lastname')
            ->get();

        return view('professor.assignMark')->with('students', $students);
    }
}
