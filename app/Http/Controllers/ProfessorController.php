<?php

namespace App\Http\Controllers;

use App\Mark;
use App\StudentSport;
use Illuminate\Http\Request;
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

    public function mark()
    {
        $sessions = $this->getSessions();

        return view('professor.assignMark')->with('sessions', $sessions);
    }


    public function addMarks(Request $request)
    {
        // Récupérer l'id du professeur connecté
        $professor = Auth::user()->professor->id;

        // Récupérer les valeurs du formulaire
        $students = $request->only('students');

        $session_id = $request->input('sessionId');

        // Pour chaque étudiant noté
        foreach ($students as $student) {
            foreach ($student as $values) {
                $maxMark = $this->getMaxMarkByStudentSession($session_id, $values['student_id']);

                if ($maxMark >= $values['mark']) {
                    $mark = $values['mark'];
                } else {
                    $mark = $maxMark;
                }

                $studentSportId = StudentSport::where('session_id', '=', $session_id)->where('student_id', '=', $values['student_id'])->value('id');

                Mark::create([
                    'student_sport_id' => $studentSportId,
                    'mark' => $mark,
                    'comment' => $values['comment']
                ]);
            }
        }
        return redirect(route('home'));
    }

    public function getStudentsBySessions(Request $request)
    {
        $idSession = $request->input('select_sessions');
        $view = 'professor.' . $request->input('view');
        $sessions = $this->getSessions();

        if ($idSession == 0 || !isset($idSession)) {
            return view($view)->with('sessions', $sessions);
        } else {
            $students = DB::table('student_sport')
                ->join('students', 'students.id', '=', 'student_sport.student_id')
                ->join('users', 'users.id', '=', 'students.user_id')
                ->join('ufr', 'ufr.id', '=', 'students.ufr_id')
                ->select(DB::raw("CONCAT(users.lastname,' ',users.firstname) as full_name, students.id as student_id, ufr.label as label_ufr"))
                ->where('student_sport.session_id', '=', $idSession)
                ->get();


            $students = $students->all();

            return view($view)
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

    public function getMaxMarkByStudentSession($sessionId, $studentId)
    {
        $maxMark = DB::table('levels_student_sport')
            ->join('student_sport', 'student_sport.id', '=', 'levels_student_sport.student_sport_id')
            ->join('levels', 'levels.id', '=', 'levels_student_sport.level_id')
            ->select('levels.maxMark')
            ->where('student_sport.student_id', '=', $studentId)
            ->where('student_sport.session_id', '=', $sessionId)
            ->get();

        $maxMark = $maxMark->all();

        if (count($maxMark) == 1) {
            return $maxMark[0]->maxMark;
        } else {
            return 20;
        }
    }
}
