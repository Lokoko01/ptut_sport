<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('home');
    }

    public function registerprofessor()
    {
        return view('auth.registerprofessor');
    }

    public function assignnote()
    {
        $students = DB::table('students')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->join('student_sport', 'student_sport.student_id', '=', 'students.id')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->select(DB::raw("CONCAT(users.lastname,' ',users.firstname) as full_name"))
            ->get();

        return view('admin.assignnote')->with('students', $students);
    }
  
    public function sport()
    {
       // $sports = DB::table('sports')->orderBy('label', 'asc')->paginate(10);

        $sports = DB::table('sports')
            ->leftJoin('sessions', 'sports.id', '=', 'sessions.sport_id')
            ->leftJoin('professors', 'professors.id', '=', 'professor_id')
            ->leftJoin('users', 'users.id', '=', 'user_id')
            ->select('sports.id', 'sports.label', 'lastname', 'firstname')
            ->paginate(10);

        return view('sport.sport')->with('sports', $sports);
    }

    public function ufr()
    {
        $ufrs = DB::table('ufr')->orderBy('code', 'asc')->paginate(10);
        return view('ufr.ufr')->with('ufrs', $ufrs);
    }

    public function addAdmin()
    {
        return view('auth.register_admin');
    }
}
