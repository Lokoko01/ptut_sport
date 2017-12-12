<?php

namespace App\Http\Controllers;
use App\Absence;
use App\Mark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

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
    public function listEdit()
    {
        $professorId = Auth::user()->professor->id;
        $students = DB::table('students')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->join('student_sport', 'student_sport.student_id', '=','students.id')
            ->join('sessions','sessions.id', '=','student_sport.session_id')
            ->join('sports','sports.id','=','sport_id')
            ->where('professor_id','=',$professorId)
            ->orderBy('users.lastname', 'asc')
            ->paginate(10);
        return view('professor.list_of_students')
            ->with('students', $students);
    }
    public function editMark(Request $request)
    {
        $mark = Mark::find($request->input('mark_id'));

        $mark->mark = !empty($request->input('mark')) ? $request->input('mark') : 0;
        $mark->comment = $request->input('comment');

        $mark->save();

        return redirect(route('listStudentEdit'))->with('message', 'La note a bien été modifiée');
    }

    public function studentInfos(Request $request)
    {
        $userId = $request->input('userId');

        $userInfos = DB::table('students')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->select('students.id', 'users.firstname', 'users.lastname')
            ->where('students.user_id', $userId)
            ->first();

        $absences = DB::table('students')
            ->join('student_sport', 'students.id', '=', 'student_sport.student_id')
            ->join('sessions', 'student_sport.session_id', '=', 'sessions.id')
            ->join('absences', 'student_sport.id', '=', 'absences.student_sport_id')
            ->join('sports', 'sessions.sport_id', '=', 'sports.id')
            ->select('absences.date', 'absences.isJustified', 'sports.label', 'absences.id')
            ->where('students.user_id', $userId)
            ->get();

        $marks = DB::table('students')
            ->join('student_sport', 'students.id', '=', 'student_sport.student_id')
            ->join('sessions', 'student_sport.session_id', '=', 'sessions.id')
            ->join('marks', 'student_sport.id', '=', 'marks.student_sport_id')
            ->join('sports', 'sessions.sport_id', '=', 'sports.id')
            ->select('marks.mark', 'marks.comment', 'sports.label', 'marks.id')
            ->where('students.user_id', $userId)
            ->get();

        $sports = DB::table('students')
            ->join('student_sport', 'students.id', '=', 'student_sport.student_id')
            ->join('sessions', 'student_sport.session_id', '=', 'sessions.id')
            ->join('sports', 'sessions.sport_id', '=', 'sports.id')
            ->join('timeSlots', 'sessions.timeSlot_id', '=', 'timeSlots.id')
            ->join('locations', 'sessions.location_id', '=', 'locations.id')
            ->join('professors', 'sessions.professor_id', '=', 'professors.id')
            ->join('users', 'professors.user_id', '=', 'users.id')
            ->select(DB::raw('CONCAT(timeSlots.dayOfWeek," ", timeSlots.startTime,":" , timeSlots.endTime) as timeSlot, CONCAT(locations.name,":" ,locations.streetNumber," ", locations.streetName," ", locations.postCode," ",locations.city) as location, sports.label, CONCAT(users.firstname, " ", users.lastname) as professor, sessions.id'))
            ->where('students.user_id', $userId)
            ->get();

        $sessions = DB::table('sessions')
            ->join('sports', 'sessions.sport_id', '=', 'sports.id')
            ->join('timeSlots', 'sessions.timeSlot_id', '=', 'timeSlots.id')
            ->join('locations', 'sessions.location_id', '=', 'locations.id')
            ->select(DB::raw('CONCAT(sports.label, " (",timeSlots.dayOfWeek," ", timeSlots.startTime,":" , timeSlots.endTime, ") ",locations.name," (", locations.postCode," ",locations.city, ") ") as session, sessions.id'))
            ->get();


        $sessionsFormated = array();
        foreach ($sessions as $session) {
            $sessionsFormated[$session->id] = $session->session;
        }

        return view('professor.student_infos_prof')
            ->with('userInfos', $userInfos)
            ->with('marks', $marks)
            ->with('absences', $absences)
            ->with('sessions', $sports)
            ->with('allSessions', $sessionsFormated);
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
    public function editAbsence(Request $request)
    {
        $absenceId = $request->input('absence_id');
        $isJustified = !empty($request->input('isJustified')) ? 1 : 0;


        $absence = Absence::find($absenceId);
        $absence->isJustified = $isJustified;
        $absence->save();

        return redirect(route('listStudentEdit'))->with('message', 'L\'absence a bien été modifiée');
    }

    public function getStudentsBySessions(Request $request)
    {
        $idSession = $request->input('select_sessions');
        $view = 'professor.' . $request->input('view');
        $sessions = $this->getSessions();
        $date=null;

        // Récupérer la date du jour
        if($request->input('isToday')){
            $date = Carbon::now()->toDateString();
        } else {
            $date = $request->input('dateSelector');
        }


        if ($idSession == 0 || !isset($idSession)) {
            return view($view)->with('sessions', $sessions);
        } else {
            $students = DB::table('student_sport')
                ->join('students', 'students.id', '=', 'student_sport.student_id')
                ->join('users', 'users.id', '=', 'students.user_id')
                ->join('ufr', 'ufr.id', '=', 'students.ufr_id')
                ->leftjoin('marks','marks.student_sport_id','=','student_sport.id')
                ->select(DB::raw("CONCAT(users.lastname,' ',users.firstname) as full_name, students.id as student_id, ufr.label as label_ufr,session_id,student_sport.id as student_sport_id"))
                ->where('student_sport.session_id', '=', $idSession)
                ->orderBy('users.lastname', 'asc')
                ->get();
            $absences= DB::table('absences')
                ->where('absences.date','=',$date)
                ->select('student_sport_id')
                ->get()
                ->all();
            $students = $students->all();
            return view($view)
                ->with('students', $students)
                ->with('sessions', $sessions)
                ->with('sessionId', $idSession)
                ->with('absences',$absences)
                ->with('date',$date);
        }
    }

    public function Message()
    {
        $mySessions = $this->getSessions();
        $sessionIdTab=array();
        foreach ($mySessions as $mySession){
            array_push($sessionIdTab,$mySession->id);
        }
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
            ->with('sessions', $sessions)
            ->with('sessionIdTab',$sessionIdTab);
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
