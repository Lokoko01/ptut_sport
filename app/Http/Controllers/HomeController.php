<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->isStudent()) {
            $studentId = Auth::user()->student->id;
            $sessions = DB::table('student_sport')->where('student_id', $studentId)->get();
            $myRole = Auth::user()->ReturnRole();
            $myRoleMessage = DB::table('roles')->where('display_name', $myRole)->first();

            foreach ($sessions as $session) {
                $myMessages = DB::table('messages')
                    ->where('type_user', $myRoleMessage->id)
                    ->orWhere('session_id', $session->session_id)
                    ->orderBy('created_at')->paginate(10);
            }
            return view('student.main')->with('myMessages', $myMessages);
        }
        if (Auth::user()->isProfessor()) {
            $myRole = Auth::user()->ReturnRole();
            $myRoleMessage = DB::table('roles')->where('display_name', $myRole)->first();

            $myMessages = DB::table('messages')
                ->where('type_user', $myRoleMessage->id)
                ->orderBy('created_at')->paginate(10);
            return view('professor.main')->with('myMessages', $myMessages);
        }
        if (Auth::user()->isAdmin()) {
            $myMessages = DB::table('messages')
                ->orderBy('created_at')->paginate(10);
            return view('admin.main')->with('myMessages', $myMessages);
        }
    }
}
