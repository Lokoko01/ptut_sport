<?php

namespace App\Http\Controllers;

use App\Sport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Location;
use App\Professor;
use App\Session;
use App\TimeSlots;


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
        $ufrs = DB::table('ufr')->get();
        return view('ufr.ufr')->with('ufrs', $ufrs);
    }

    public function showListOfStudents()
    {
        $students = DB::table('students')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->orderBy('users.lastname', 'asc')
            ->paginate(10);
        return view('professor.list_of_students')->with('students', $students);
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

            return view('professor.list_of_students')->with('students', $students);

        } else {
            $students = DB::table('students')
                ->join('users', 'users.id', '=', 'students.user_id')
                ->orderBy('users.lastname', 'asc')
                ->paginate(10);
            return view('professor.list_of_students')->with('students', $students);
        }
    }

    public function downloadExcel()
    {
        /* Tous les étudiants */
        $allStudents = DB::table('students')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->select(DB::raw("students.studentNumber as Numéroétudiant, users.lastname as Nom, users.firstname as Prénom, 
                              users.email as Email_inscription, students.studyLevel as Niveau_études, students.privateEmail as Email_privé, 
                              DATE_FORMAT(users.created_at, \"%d-%m-%Y\") as Date_inscription"))
            ->orderBy('users.lastname', 'asc')
            ->get();

        /* Tous les étudiants de Lyon 1 */
        $studentsLyon1 = DB::table('students')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->select(DB::raw("students.studentNumber as Numéroétudiant, users.lastname as Nom, users.firstname as Prénom, 
                              users.email as Email_inscription, students.studyLevel as Niveau_études, students.privateEmail as Email_privé, 
                              DATE_FORMAT(users.created_at, \"%d-%m-%Y\") as Date_inscription"))
            ->where('users.email', 'REGEXP', '^[a-z0-9](\.?[a-z0-9]){5,}@etu\.univ-lyon1\.fr$')
            ->orderBy('users.lastname', 'asc')
            ->get();

        /* Tous les étudiants de Lyon 2 */
        $studentsLyon2 = DB::table('students')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->select(DB::raw("students.studentNumber as Numéroétudiant, users.lastname as Nom, users.firstname as Prénom, 
                              users.email as Email_inscription, students.studyLevel as Niveau_études, students.privateEmail as Email_privé, 
                              DATE_FORMAT(users.created_at, \"%d-%m-%Y\") as Date_inscription"))
            ->where('users.email', 'REGEXP', '^[a-z0-9](\.?[a-z0-9]){5,}@etu\.univ-lyon2\.fr$')
            ->orderBy('users.lastname', 'asc')
            ->get();

        /* Tous les étudiants de Lyon 3 */
        $studentsLyon3 = DB::table('students')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->select(DB::raw("students.studentNumber as Numéroétudiant, users.lastname as Nom, users.firstname as Prénom, 
                              users.email as Email_inscription, students.studyLevel as Niveau_études, students.privateEmail as Email_privé, 
                              DATE_FORMAT(users.created_at, \"%d-%m-%Y\") as Date_inscription"))
            ->where('users.email', 'REGEXP', '^[a-z0-9](\.?[a-z0-9]){5,}@etu\.univ-lyon3\.fr$')
            ->orderBy('users.lastname', 'asc')
            ->get();

        /* Tous les étudiants de Lyon 3 */
        $studentsLyon3Lvl1 = DB::table('students')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->select(DB::raw("students.studentNumber as Numéroétudiant, users.lastname as Nom, users.firstname as Prénom, 
                              users.email as Email_inscription, students.studyLevel as Niveau_études, students.privateEmail as Email_privé, 
                              DATE_FORMAT(users.created_at, \"%d-%m-%Y\") as Date_inscription"))
            ->where('users.email', 'REGEXP', '^[a-z0-9](\.?[a-z0-9]){5,}@etu\.univ-lyon3\.fr$')
            ->where('students.studyLevel', '1')
            ->orderBy('users.lastname', 'asc')
            ->get();

        /* Tous les étudiants de Lyon 3 */
        $studentsLyon3Lvl2 = DB::table('students')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->select(DB::raw("students.studentNumber as Numéroétudiant, users.lastname as Nom, users.firstname as Prénom, 
                              users.email as Email_inscription, students.studyLevel as Niveau_études, students.privateEmail as Email_privé, 
                              DATE_FORMAT(users.created_at, \"%d-%m-%Y\") as Date_inscription"))
            ->where('users.email', 'REGEXP', '^[a-z0-9](\.?[a-z0-9]){5,}@etu\.univ-lyon3\.fr$')
            ->where('students.studyLevel', '2')
            ->orderBy('users.lastname', 'asc')
            ->get();

        /* Tous les étudiants de Lyon 3 */
        $studentsLyon3Lvl3 = DB::table('students')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->select(DB::raw("students.studentNumber as Numéroétudiant, users.lastname as Nom, users.firstname as Prénom, 
                              users.email as Email_inscription, students.studyLevel as Niveau_études, students.privateEmail as Email_privé, 
                              DATE_FORMAT(users.created_at, \"%d-%m-%Y\") as Date_inscription"))
            ->where('users.email', 'REGEXP', '^[a-z0-9](\.?[a-z0-9]){5,}@etu\.univ-lyon3\.fr$')
            ->where('students.studyLevel', '3')
            ->orderBy('users.lastname', 'asc')
            ->get();

        /* Tous les étudiants de Lyon 3 */
        $studentsLyon3Lvl4 = DB::table('students')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->select(DB::raw("students.studentNumber as Numéroétudiant, users.lastname as Nom, users.firstname as Prénom, 
                              users.email as Email_inscription, students.studyLevel as Niveau_études, students.privateEmail as Email_privé, 
                              DATE_FORMAT(users.created_at, \"%d-%m-%Y\") as Date_inscription"))
            ->where('users.email', 'REGEXP', '^[a-z0-9](\.?[a-z0-9]){5,}@etu\.univ-lyon3\.fr$')
            ->where('students.studyLevel', '4')
            ->orderBy('users.lastname', 'asc')
            ->get();

        /* Tous les étudiants de Lyon 3 */
        $studentsLyon3Lvl5 = DB::table('students')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->select(DB::raw("students.studentNumber as Numéroétudiant, users.lastname as Nom, users.firstname as Prénom, 
                              users.email as Email_inscription, students.studyLevel as Niveau_études, students.privateEmail as Email_privé, 
                              DATE_FORMAT(users.created_at, \"%d-%m-%Y\") as Date_inscription"))
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
  
   public function addsession(){
        $sports = Sport::orderBy('label', 'asc')
            ->pluck('label', 'id');

        $timeSlots = TimeSlots::orderBy('dayOfWeek')->get();

        $collectionFormatedTimeSlots = array();
        foreach($timeSlots as $oneTimeSlot){
            $collectionFormatedTimeSlots[$oneTimeSlot->id] = $oneTimeSlot->dayOfWeek." ".$oneTimeSlot->startTime."-".$oneTimeSlot->endTime;
        }

        $professors = DB::select('SELECT p.id, u.firstname, u.lastname FROM users u JOIN professors p ON u.id = p.user_id ORDER BY u.lastname');
        $collectionFormatedProfessors = array();

        foreach ($professors as $oneProfessor) {
            $collectionFormatedProfessors[$oneProfessor->id] = $oneProfessor->lastname . " " . $oneProfessor->firstname;
        }

        $locations = Location::orderBy('postCode')->get();

        $collectionFormatedLocations = array();
        foreach ($locations as $oneLocation) {
            $collectionFormatedLocations[$oneLocation->id] = $oneLocation->name." : ".$oneLocation->streetNumber." ".$oneLocation->streetName." ".$oneLocation->postCode." ".$oneLocation->city;
        }

        return view ('admin.addsession')
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
}
