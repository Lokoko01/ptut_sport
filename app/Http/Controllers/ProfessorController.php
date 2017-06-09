<?php

namespace App\Http\Controllers;

use App\Mark;
use App\StudentSport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

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

    public function mark()
    {
        $sessions = $this->getSessions();

        return view('professor.assignMark')->with('sessions', $sessions);
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

    public function Message()
    {
        $sessions = DB::table('sessions')
            ->join('timeSlots', 'sessions.timeSlot_id', '=', 'timeSlots.id')
            ->join('locations', 'sessions.location_id', '=', 'locations.id')
            ->join('sports', 'sessions.sport_id', '=', 'sports.id')
            ->select('sports.label',
                'timeSlots.startTime',
                'timeSlots.endTime',
                'timeSlots.dayOfWeek',
                'locations.postCode',
                'locations.streetName',
                'locations.city',
                'locations.name',
                'sessions.id'
            )->get();
        $typeOfUser = DB::table('roles')->get();

        return view('message.addMessageProfessor')
            ->with('typeOfUser', $typeOfUser)
            ->with('sessions', $sessions);
    }

    public function exportStudentsBySportExcel()
    {
        return Excel::create('listes_etudiants_par_sport', function ($excel) {
            $sports = DB::table('sports')->get();

            foreach ($sports as $sport) {
                /* Tous les étudiants par sport */
                $allStudents = DB::table('students')
                    ->leftJoin('users', 'users.id', '=', 'students.user_id')
                    ->leftJoin('student_sport', 'student_sport.student_id', '=', 'students.id')
                    ->leftJoin('marks', 'marks.student_sport_id', '=', 'student_sport.id')
                    ->leftJoin('sessions', 'sessions.id', '=', 'student_sport.session_id')
                    ->leftJoin('sports', 'sports.id', '=', 'sessions.sport_id')
                    ->select(DB::raw("distinct students.studentNumber as Numéro_étudiant, users.lastname as Nom, users.firstname as Prénom, 
                               users.email as Email_inscription,
                               case 
                                  when students.studyLevel like '1' then '1ère année'
                                  when students.studyLevel like '2' then '2ème année'
                                  when students.studyLevel like '3' then '3ème année'
                                  when students.studyLevel like '4' then '4ème année'
                                  when students.studyLevel like '5' then '5ème année'
                               end as Niveau_études,
                               sports.label as Sport, 
                               marks.mark as Note, 
                               marks.comment as Commentaire"))
                    ->where('sports.label', $sport->label)
                    ->orderBy('users.lastname', 'asc')
                    ->get();

                $datas = array();
                foreach ($allStudents as $student) {
                    $datas[] = (array)$student;
                }

                $excel->sheet('liste_etudiants_' . $sport->label, function ($sheet) use ($datas) {

                    $sheet->row(1, ['Numéro_étudiant', 'Nom',
                        'Prénom', 'Email_inscription',
                        'Niveau_études', 'Sport', 'Note', 'Commentaire']);
                    $sheet->row(1, function ($row) {
                        $row->setBackground('#CCCCCC');;
                    });
                    $sheet->fromArray($datas);
                });
            }
        })->download('xls');
    }

    public function exportStudentsBySportPdf()
    {
        return Excel::create('listes_etudiants_par_sport', function ($excel) {
            $sports = DB::table('sports')->get();

            foreach ($sports as $sport) {
                /* Tous les étudiants par sport */
                $allStudents = DB::table('students')
                    ->leftJoin('users', 'users.id', '=', 'students.user_id')
                    ->leftJoin('student_sport', 'student_sport.student_id', '=', 'students.id')
                    ->leftJoin('marks', 'marks.student_sport_id', '=', 'student_sport.id')
                    ->leftJoin('sessions', 'sessions.id', '=', 'student_sport.session_id')
                    ->leftJoin('sports', 'sports.id', '=', 'sessions.sport_id')
                    ->select(DB::raw("distinct students.studentNumber as Numéro_étudiant, users.lastname as Nom, users.firstname as Prénom,
                               users.email as Email_inscription,
                               case 
                                  when students.studyLevel like '1' then '1ère année'
                                  when students.studyLevel like '2' then '2ème année'
                                  when students.studyLevel like '3' then '3ème année'
                                  when students.studyLevel like '4' then '4ème année'
                                  when students.studyLevel like '5' then '5ème année'
                               end as Niveau_études,
                               sports.label as Sport, 
                               marks.mark as Note, 
                               marks.comment as Commentaire"))
                    ->where('sports.label', $sport->label)
                    ->orderBy('users.lastname', 'asc')
                    ->get();

                $datas = array();
                foreach ($allStudents as $student) {
                    $datas[] = (array)$student;
                }

                $excel->sheet('liste_etudiants_' . $sport->label, function ($sheet) use ($datas) {
                    $sheet->setOrientation('landscape');
                    $sheet->setAllBorders('thin');
                    $sheet->row(1, ['Numéro_étudiant', 'Nom',
                        'Prénom', 'Email_inscription',
                        'Niveau_études', 'Sport', 'Note', 'Commentaire']);
                    $sheet->row(1, function ($row) {
                        $row->setBackground('#CCCCCC');;
                    });
                    $sheet->fromArray($datas, null, 'A1', true, true);
                });
            }
        })->download('pdf');
    }
}
