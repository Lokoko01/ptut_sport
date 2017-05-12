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

    public function addAdmin()
    {
        return view('auth.register_admin');
    }
}
