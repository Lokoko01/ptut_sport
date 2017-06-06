<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
        $sessions = $this->getSessions();

        return view('professor.check_absences')->with('sessions', $sessions);
    }

    public function getStudentsBySessions(Request $request)
    {
        $idSession = $request->input('select_sessions');
        $sessions = $this->getSessions();

        if ($idSession == 0 || !isset($idSession)) {
            return view('professor.check_absences')->with('sessions', $sessions);
        } else {
            $students = DB::table('student_sport')
                ->join('students', 'students.id', '=', 'student_sport.student_id')
                ->join('users', 'users.id', '=', 'students.user_id')
                ->join('ufr', 'ufr.id', '=', 'students.ufr_id')
                ->select(DB::raw("CONCAT(users.lastname,' ',users.firstname) as full_name, students.id as student_id, ufr.label as label_ufr"))
                ->where('student_sport.session_id', '=', $idSession)
                ->get();


            $students = $students->all();

            return view('professor.check_absences')
                ->with('students', $students)
                ->with('sessions', $sessions)
                ->with('sessionId', $idSession);
        }
    }

    public function getSessions()
    {
        $professorId = Auth::user()->professor->id;

        if ($professorId) {
            $sessions = DB::table('sessions')
                ->join('sports', 'sessions.sport_id', "=", "sports.id")
                ->join('timeSlots', 'sessions.timeSlot_id', '=', 'timeSlots.id')
                ->join('locations', 'sessions.location_id', '=', 'locations.id')
                ->select('sessions.id', 'sports.label', 'locations.name', 'locations.city', 'timeSlots.dayOfWeek', 'timeSlots.startTime', 'timeSlots.endTime')
                ->where('sessions.professor_id', '=', $professorId)
                ->get();

            $sessions = $sessions->all();

            if ($sessions != null) {
                return $sessions;
            } else return false;
        } else return false;
    }
}
