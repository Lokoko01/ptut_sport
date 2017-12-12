<?php

namespace App\Http\Controllers;

use App\Absence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\StudentSport;

class AbsencesController extends Controller
{
    public function addAbsences(Request $request)
    {
        $data = [
            'check' => $request->input('check'),
            'sessionId' => $request->input('sessionId'),
            'date' => $request->input('date'),
        ];



        // Récupérer l'id du professeur connecté
        $professor = Auth::user()->professor->id;


        $students = DB::table('student_sport')
            ->join('students', 'students.id', '=', 'student_sport.student_id')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->join('ufr', 'ufr.id', '=', 'students.ufr_id')
            ->select(DB::raw("student_sport.id as student_sport_id"))
            ->where('student_sport.session_id', '=', $data['sessionId'])
            ->orderBy('users.lastname', 'asc')
            ->get();

        foreach ($students as $student){
                $exists = DB::table('absences')
                    ->where('student_sport_id', $student->student_sport_id)
                    ->where('date',$data['date'])
                    ->first();
                if($exists){
                    Absence::where('student_sport_id',$student->student_sport_id)
                        ->where('date',$data['date'])
                        ->delete();
                }
        }

        // Pour chaque étudiant coché absent
        for ($i = 0; $i < sizeof($data['check']); $i++) {
            $studentSport = StudentSport
                ::select('id')
                ->where('student_id', $data['check'][$i])
                ->where('session_id', $data['sessionId'])
                ->first();

            $studentSport->absence()->updateOrCreate([
                'isJustified' => 0,
                'date' => $data['date']
            ]);
        }
        return redirect(route('home'))->with('message', 'L\'appel a été fait');
    }
}
