<?php

namespace App\Http\Controllers;

use App\Absence;
use App\Location;
use App\Mark;
use App\Sport;
use App\Student;
use App\StudentSport;
use App\TimeSlots;
use App\User;
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
                $sheet->row(1, ['Numéro_étudiant', 'Nom',
                    'Prénom', 'Email_inscription',
                    'Niveau_études', 'Email_privé',
                    'Date_inscription', 'Sport', 'Note', 'Commentaire']);
                $sheet->row(1, function ($row) {
                    $row->setBackground('#CCCCCC');;
                });
                $sheet->fromArray($dataAll);
            });
            $excel->sheet('liste_etudiants_lyon_1', function ($sheet) use ($dataLyon1) {
                $sheet->row(1, ['Numéro_étudiant', 'Nom',
                    'Prénom', 'Email_inscription',
                    'Niveau_études', 'Email_privé',
                    'Date_inscription', 'Sport', 'Note', 'Commentaire']);
                $sheet->row(1, function ($row) {
                    $row->setBackground('#CCCCCC');;
                });
                $sheet->fromArray($dataLyon1);
            });
            $excel->sheet('liste_etudiants_lyon_2', function ($sheet) use ($dataLyon2) {
                $sheet->row(1, ['Numéro_étudiant', 'Nom',
                    'Prénom', 'Email_inscription',
                    'Niveau_études', 'Email_privé',
                    'Date_inscription', 'Sport', 'Note', 'Commentaire']);
                $sheet->row(1, function ($row) {
                    $row->setBackground('#CCCCCC');;
                });
                $sheet->fromArray($dataLyon2);
            });
            $excel->sheet('liste_etudiants_lyon_3', function ($sheet) use ($dataLyon3) {
                $sheet->row(1, ['Numéro_étudiant', 'Nom',
                    'Prénom', 'Email_inscription',
                    'Niveau_études', 'Email_privé',
                    'Date_inscription', 'Sport', 'Note', 'Commentaire']);
                $sheet->row(1, function ($row) {
                    $row->setBackground('#CCCCCC');;
                });
                $sheet->fromArray($dataLyon3);
            });
            $excel->sheet('liste_etudiants_lyon_3_lvl_1', function ($sheet) use ($dataLyon3Lvl1) {
                $sheet->row(1, ['Numéro_étudiant', 'Nom',
                    'Prénom', 'Email_inscription',
                    'Niveau_études', 'Email_privé',
                    'Date_inscription', 'Sport', 'Note', 'Commentaire']);
                $sheet->row(1, function ($row) {
                    $row->setBackground('#CCCCCC');;
                });
                $sheet->fromArray($dataLyon3Lvl1);
            });
            $excel->sheet('liste_etudiants_lyon_3_lvl_2', function ($sheet) use ($dataLyon3Lvl2) {
                $sheet->row(1, ['Numéro_étudiant', 'Nom',
                    'Prénom', 'Email_inscription',
                    'Niveau_études', 'Email_privé',
                    'Date_inscription', 'Sport', 'Note', 'Commentaire']);
                $sheet->row(1, function ($row) {
                    $row->setBackground('#CCCCCC');;
                });
                $sheet->fromArray($dataLyon3Lvl2);
            });
            $excel->sheet('liste_etudiants_lyon_3_lvl_3', function ($sheet) use ($dataLyon3Lvl3) {
                $sheet->row(1, ['Numéro_étudiant', 'Nom',
                    'Prénom', 'Email_inscription',
                    'Niveau_études', 'Email_privé',
                    'Date_inscription', 'Sport', 'Note', 'Commentaire']);
                $sheet->row(1, function ($row) {
                    $row->setBackground('#CCCCCC');;
                });
                $sheet->fromArray($dataLyon3Lvl3);
            });
            $excel->sheet('liste_etudiants_lyon_3_lvl_4', function ($sheet) use ($dataLyon3Lvl4) {
                $sheet->row(1, ['Numéro_étudiant', 'Nom',
                    'Prénom', 'Email_inscription',
                    'Niveau_études', 'Email_privé',
                    'Date_inscription', 'Sport', 'Note', 'Commentaire']);
                $sheet->row(1, function ($row) {
                    $row->setBackground('#CCCCCC');;
                });
                $sheet->fromArray($dataLyon3Lvl4);
            });
            $excel->sheet('liste_etudiants_lyon_3_lvl_5', function ($sheet) use ($dataLyon3Lvl5) {
                $sheet->row(1, ['Numéro_étudiant', 'Nom',
                    'Prénom', 'Email_inscription',
                    'Niveau_études', 'Email_privé',
                    'Date_inscription', 'Sport', 'Note', 'Commentaire']);
                $sheet->row(1, function ($row) {
                    $row->setBackground('#CCCCCC');;
                });
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

    public function sortsWishes()
    {
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

        $messages = DB::table('messages')->get();
        return view('message.addMessage')
            ->with('typeOfUser', $typeOfUser)
            ->with('messages', $messages)
            ->with('sessions', $sessions);
    }

    public function editStudent(Request $request)
    {
        $data = [
            'user_id' => $request->input('user_id'),
            'student_lastname' => $request->input('student_lastname'),
            'student_firstname' => $request->input('student_firstname'),
            'student_private_email' => $request->input('student_private_email'),
            'student_number' => $request->input('student_number'),
            'student_email' => $request->input('student_email')
        ];


        $user = User::find($data['user_id']);
        $student = Student::where('user_id', $data['user_id'])->first();

        $user->lastname = !empty($data['student_lastname']) ? $data['student_lastname'] : $user->lastname;
        $user->firstname = !empty($data['student_firstname']) ? $data['student_firstname'] : $user->firstname;
        $user->email = !empty($data['student_email']) ? $data['student_email'] : $user->email;

        $student->studentNumber = !empty($data['student_number']) ? $data['student_number'] : $student->studentNumber;
        $student->privateEmail = !empty($data['student_private_email']) ? $data['student_private_email'] : $student->privateEmail;

        $user->save();
        $student->save();

        return redirect(route('students'))->with('message', $data['student_firstname'] . ' ' . $data['student_lastname'] . ' a bien été mis à jour');
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

        return view('admin.student_infos')
            ->with('userInfos', $userInfos)
            ->with('marks', $marks)
            ->with('absences', $absences)
            ->with('sessions', $sports)
            ->with('allSessions', $sessionsFormated);
    }

    public function editAbsence(Request $request)
    {
        $absenceId = $request->input('absence_id');
        $isJustified = !empty($request->input('isJustified')) ? 1 : 0;


        $absence = Absence::find($absenceId);
        $absence->isJustified = $isJustified;
        $absence->save();

        return redirect(route('students'))->with('message', 'L\'absence a bien été modifiée');
    }

    public function editMark(Request $request)
    {
        $mark = Mark::find($request->input('mark_id'));

        $mark->mark = !empty($request->input('mark')) ? $request->input('mark') : 0;
        $mark->comment = $request->input('comment');

        $mark->save();

        return redirect(route('students'))->with('message', 'La note a bien été modifiée');
    }

    public function deleteSession(Request $request)
    {
        $studentId = $request->input('studentId');
        $sessionId = $request->input('sessionId');

        $studentSportId = StudentSport::where('student_id', $studentId)->where('session_id', $sessionId)->first()->id;


        DB::table('marks')->where('student_sport_id', $studentSportId)->delete();
        DB::table('absences')->where('student_sport_id', $studentSportId)->delete();
        DB::table('levels_student_sport')->where('student_sport_id', $studentSportId)->delete();

        StudentSport::where('student_id', $studentId)->where('session_id', $sessionId)->delete();

        return redirect(route('students'))->with('message', 'L\'étudiant à bien été désinscrit');
    }

    public function affectSession(Request $request)
    {
        $sessionId = $request->input('session');
        $studentId = $request->input('studentId');


        if (!empty($sessionId) && !empty($studentId)) {
            $studentSport = StudentSport::firstOrCreate([
                'student_id' => $studentId,
                'session_id' => $sessionId
            ]);

            if ($studentSport->wasRecentlyCreated) {
                return redirect(route('students'))->with('message', 'L\'étudiant a bien été inscrit au sport');
            } else return redirect(route('students'))->with('warning', 'L\'étudiant est déjà inscrit au sport');
        } else {
            return redirect(route('students'))->with('error', 'L\'étudiant n\'a pas été inscrit');
        }
    }

    public function exportStudentsBySportExcel()
    {
        $sports = DB::table('sports')->get();

        if (!($sports)->isEmpty()) {
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

        } else {
            return Excel::create('listes_etudiants_par_sport', function ($excel) {
                $excel->sheet('liste_etudiants_', function ($sheet) {

                    $sheet->row(1, ['Numéro_étudiant', 'Nom',
                        'Prénom', 'Email_inscription',
                        'Niveau_études', 'Sport', 'Note', 'Commentaire']);
                    $sheet->row(1, function ($row) {
                        $row->setBackground('#CCCCCC');;
                    });
                    $sheet->fromArray(array(
                        array('Pas de données.')
                    ));
                });
            })->download('xls');
        }
    }

    public function exportStudentsBySportPdf()
    {
        $sports = DB::table('sports')->get();

        if (!($sports)->isEmpty()) {
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

        } else {
                return Excel::create('listes_etudiants_par_sport', function ($excel) {
                    $excel->sheet('liste_etudiants_', function ($sheet) {

                        $sheet->row(1, ['Numéro_étudiant', 'Nom',
                            'Prénom', 'Email_inscription',
                            'Niveau_études', 'Sport', 'Note', 'Commentaire']);
                        $sheet->row(1, function ($row) {
                            $row->setBackground('#CCCCCC');;
                        });
                        $sheet->fromArray(array(
                            array('Pas de données.')
                        ));
                    });
                })->download('pdf');
            }
        }
}
