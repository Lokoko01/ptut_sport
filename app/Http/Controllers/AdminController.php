<?php

namespace App\Http\Controllers;

use App\Location;
use App\Sport;
use App\TimeSlots;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


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


    public function sport()
    {
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
        $ufrs = DB::table('ufr')->paginate(10);
        return view('ufr.ufr')->with('ufrs', $ufrs);
    }

    public function showListOfStudents()
    {
        $students = DB::table('students')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->orderBy('users.lastname', 'asc')
            ->paginate(10);
        return view('admin.list_of_students')->with('students', $students);
    }

    public function showStudentsBySearch(Request $request)
    {
        $searchterm = $request->input('q');

        if ($searchterm) {

            $students = DB::table('students')
                ->join('users', 'users.id', '=', 'students.user_id')
                ->where('users.lastname', 'LIKE', '%' . $searchterm . '%')
                ->orWhere('users.firstname', 'LIKE', '%' . $searchterm . '%')
                ->orWhere('students.studentNumber', 'LIKE', '%' . $searchterm . '%')
                ->paginate(10);

            return view('admin.list_of_students')->with('students', $students);

        } else {
            $students = DB::table('students')
                ->join('users', 'users.id', '=', 'students.user_id')
                ->orderBy('users.lastname', 'asc')
                ->paginate(10);
            return view('admin.list_of_students')->with('students', $students);
        }
    }

    public function downloadExcel()
    {
        /* Tous les étudiants */
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
                               students.privateEmail as Email_privé, 
                               DATE_FORMAT(users.created_at, \"%d-%m-%Y\") as Date_inscription, 
                               sports.label as Sport, 
                               marks.mark as Note, 
                               marks.comment as Commentaire"))
            ->orderBy('users.lastname', 'asc')
            ->get();

        /* Tous les étudiants de Lyon 1 */
        $studentsLyon1 = DB::table('students')
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
                               students.privateEmail as Email_privé, 
                               DATE_FORMAT(users.created_at, \"%d-%m-%Y\") as Date_inscription, 
                               sports.label as Sport, 
                               marks.mark as Note, 
                               marks.comment as Commentaire"))
            ->where('users.email', 'REGEXP', '^[a-z0-9](\.?[a-z0-9]){5,}@etu\.univ-lyon1\.fr$')
            ->orderBy('users.lastname', 'asc')
            ->get();

        /* Tous les étudiants de Lyon 2 */
        $studentsLyon2 = DB::table('students')
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
                               students.privateEmail as Email_privé, 
                               DATE_FORMAT(users.created_at, \"%d-%m-%Y\") as Date_inscription, 
                               sports.label as Sport, 
                               marks.mark as Note, 
                               marks.comment as Commentaire"))
            ->where('users.email', 'REGEXP', '^[a-z0-9](\.?[a-z0-9]){5,}@etu\.univ-lyon2\.fr$')
            ->orderBy('users.lastname', 'asc')
            ->get();

        /* Tous les étudiants de Lyon 3 */
        $studentsLyon3 = DB::table('students')
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
                               students.privateEmail as Email_privé, 
                               DATE_FORMAT(users.created_at, \"%d-%m-%Y\") as Date_inscription, 
                               sports.label as Sport, 
                               marks.mark as Note, 
                               marks.comment as Commentaire"))
            ->where('users.email', 'REGEXP', '^[a-z0-9](\.?[a-z0-9]){5,}@etu\.univ-lyon3\.fr$')
            ->orderBy('users.lastname', 'asc')
            ->get();

        /* Tous les étudiants de Lyon 3 */
        $studentsLyon3Lvl1 = DB::table('students')
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
                               students.privateEmail as Email_privé, 
                               DATE_FORMAT(users.created_at, \"%d-%m-%Y\") as Date_inscription, 
                               sports.label as Sport, 
                               marks.mark as Note, 
                               marks.comment as Commentaire"))
            ->where('users.email', 'REGEXP', '^[a-z0-9](\.?[a-z0-9]){5,}@etu\.univ-lyon3\.fr$')
            ->where('students.studyLevel', '1')
            ->orderBy('users.lastname', 'asc')
            ->get();

        /* Tous les étudiants de Lyon 3 */
        $studentsLyon3Lvl2 = DB::table('students')
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
                               students.privateEmail as Email_privé, 
                               DATE_FORMAT(users.created_at, \"%d-%m-%Y\") as Date_inscription, 
                               sports.label as Sport, 
                               marks.mark as Note, 
                               marks.comment as Commentaire"))
            ->where('users.email', 'REGEXP', '^[a-z0-9](\.?[a-z0-9]){5,}@etu\.univ-lyon3\.fr$')
            ->where('students.studyLevel', '2')
            ->orderBy('users.lastname', 'asc')
            ->get();

        /* Tous les étudiants de Lyon 3 */
        $studentsLyon3Lvl3 = DB::table('students')
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
                               students.privateEmail as Email_privé, 
                               DATE_FORMAT(users.created_at, \"%d-%m-%Y\") as Date_inscription, 
                               sports.label as Sport, 
                               marks.mark as Note, 
                               marks.comment as Commentaire"))
            ->where('users.email', 'REGEXP', '^[a-z0-9](\.?[a-z0-9]){5,}@etu\.univ-lyon3\.fr$')
            ->where('students.studyLevel', '3')
            ->orderBy('users.lastname', 'asc')
            ->get();

        /* Tous les étudiants de Lyon 3 */
        $studentsLyon3Lvl4 = DB::table('students')
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
                               students.privateEmail as Email_privé, 
                               DATE_FORMAT(users.created_at, \"%d-%m-%Y\") as Date_inscription, 
                               sports.label as Sport, 
                               marks.mark as Note, 
                               marks.comment as Commentaire"))
            ->where('users.email', 'REGEXP', '^[a-z0-9](\.?[a-z0-9]){5,}@etu\.univ-lyon3\.fr$')
            ->where('students.studyLevel', '4')
            ->orderBy('users.lastname', 'asc')
            ->get();

        /* Tous les étudiants de Lyon 3 */
        $studentsLyon3Lvl5 = DB::table('students')
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
                               students.privateEmail as Email_privé, 
                               DATE_FORMAT(users.created_at, \"%d-%m-%Y\") as Date_inscription, 
                               sports.label as Sport, 
                               marks.mark as Note, 
                               marks.comment as Commentaire"))
            ->where('users.email', 'REGEXP', '^[a-z0-9](\.?[a-z0-9]){5,}@etu\.univ-lyon3\.fr$')
            ->where('students.studyLevel', '5')
            ->orderBy('users.lastname', 'asc')
            ->get();

        $dataAll = array();
        foreach ($allStudents as $student) {
            $dataAll[] = (array)$student;
        }

        $dataLyon1 = array();
        foreach ($studentsLyon1 as $student) {
            $dataLyon1[] = (array)$student;
        }

        $dataLyon2 = array();
        foreach ($studentsLyon2 as $student) {
            $dataLyon2[] = (array)$student;
        }

        $dataLyon3 = array();
        foreach ($studentsLyon3 as $student) {
            $dataLyon3[] = (array)$student;
        }

        $dataLyon3Lvl1 = array();
        foreach ($studentsLyon3Lvl1 as $student) {
            $dataLyon3Lvl1[] = (array)$student;
        }
        $dataLyon3Lvl2 = array();
        foreach ($studentsLyon3Lvl2 as $student) {
            $dataLyon3Lvl2[] = (array)$student;
        }
        $dataLyon3Lvl3 = array();
        foreach ($studentsLyon3Lvl3 as $student) {
            $dataLyon3Lvl3[] = (array)$student;
        }
        $dataLyon3Lvl4 = array();
        foreach ($studentsLyon3Lvl4 as $student) {
            $dataLyon3Lvl4[] = (array)$student;
        }
        $dataLyon3Lvl5 = array();
        foreach ($studentsLyon3Lvl5 as $student) {
            $dataLyon3Lvl5[] = (array)$student;
        }

        return Excel::create('listes_etudiants', function ($excel) use (
            $dataAll, $dataLyon1, $dataLyon2, $dataLyon3,
            $dataLyon3Lvl1, $dataLyon3Lvl2, $dataLyon3Lvl3, $dataLyon3Lvl4, $dataLyon3Lvl5
        ) {
            $excel->sheet('liste_etudiants', function ($sheet) use ($dataAll) {
                $sheet->fromArray($dataAll);
            });
            $excel->sheet('liste_etudiants_lyon_1', function ($sheet) use ($dataLyon1) {
                $sheet->fromArray($dataLyon1);
            });
            $excel->sheet('liste_etudiants_lyon_2', function ($sheet) use ($dataLyon2) {
                $sheet->fromArray($dataLyon2);
            });
            $excel->sheet('liste_etudiants_lyon_3', function ($sheet) use ($dataLyon3) {
                $sheet->fromArray($dataLyon3);
            });
            $excel->sheet('liste_etudiants_lyon_3_lvl_1', function ($sheet) use ($dataLyon3Lvl1) {
                $sheet->fromArray($dataLyon3Lvl1);
            });
            $excel->sheet('liste_etudiants_lyon_3_lvl_2', function ($sheet) use ($dataLyon3Lvl2) {
                $sheet->fromArray($dataLyon3Lvl2);
            });
            $excel->sheet('liste_etudiants_lyon_3_lvl_3', function ($sheet) use ($dataLyon3Lvl3) {
                $sheet->fromArray($dataLyon3Lvl3);
            });
            $excel->sheet('liste_etudiants_lyon_3_lvl_4', function ($sheet) use ($dataLyon3Lvl4) {
                $sheet->fromArray($dataLyon3Lvl4);
            });
            $excel->sheet('liste_etudiants_lyon_3_lvl_5', function ($sheet) use ($dataLyon3Lvl5) {
                $sheet->fromArray($dataLyon3Lvl5);
            });
        })->download('xls');
    }


    public function addsession()
    {
        $sports = Sport::orderBy('label', 'asc')
            ->pluck('label', 'id');

        $timeSlots = TimeSlots::orderBy('dayOfWeek')->get();

        $collectionFormatedTimeSlots = array();
        foreach ($timeSlots as $oneTimeSlot) {
            $collectionFormatedTimeSlots[$oneTimeSlot->id] = $oneTimeSlot->dayOfWeek . " " . $oneTimeSlot->startTime . "-" . $oneTimeSlot->endTime;
        }

        $professors = DB::select('SELECT p.id, u.firstname, u.lastname FROM users u JOIN professors p ON u.id = p.user_id ORDER BY u.lastname');
        $collectionFormatedProfessors = array();

        foreach ($professors as $oneProfessor) {
            $collectionFormatedProfessors[$oneProfessor->id] = $oneProfessor->lastname . " " . $oneProfessor->firstname;
        }

        $locations = Location::orderBy('postCode')->get();

        $collectionFormatedLocations = array();
        foreach ($locations as $oneLocation) {
            $collectionFormatedLocations[$oneLocation->id] = $oneLocation->name . " : " . $oneLocation->streetNumber . " " . $oneLocation->streetName . " " . $oneLocation->postCode . " " . $oneLocation->city;
        }

        return view('admin.addsession')
            ->with('sports', $sports)
            ->with('timeSlots', $collectionFormatedTimeSlots)
            ->with('professors', $collectionFormatedProfessors)
            ->with('locations', $collectionFormatedLocations);
    }

    public function addAdmin()
    {
        return view('auth.register_admin');
    }

    public function sortsWishes(){
       return view('admin.sort_wishes');
     }
     
    public function locations()
    {
        $locations = DB::table('locations')
            ->paginate(10);

        return view('admin.location')->with('locations', $locations);
    }

    public function timeSlots()
    {
        $timeSlots = DB::table('timeSlots')
            ->paginate(10);
            
        return view('admin.timeSlots')->with('timeSlots', $timeSlots);
    }


    public function Message(){
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

        $messages = DB::table('messages')->get();
        return view('message.addMessage')
            ->with('typeOfUser', $typeOfUser)
            ->with('messages', $messages)
            ->with('sessions', $sessions);
    }
}
