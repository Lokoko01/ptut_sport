<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\StudentSport;

class AbsencesController extends Controller
{

    public function addAbsences(Request $request)
    {
        // Récupérer l'id du professeur connecté
        $professor = Auth::user()->professor->id;

        // Récupérer la date du jour
        $sysdate = Carbon::now()->toDateTimeString();

        // Récupérer les valeurs du formulaire
        $data = [
            'check' => $request->input('check')
        ];

        // Récupérer l'id de la sessions que gère le professeur connecté à l'application
        $session_id = DB::table('sessions')
            ->join('professors', 'professors.id', '=', 'sessions.professor_id')
            ->select(DB::raw("sessions.id as session_id"))
            ->where('professors.id', $professor)
            ->get();

        // Pour chaque étudiant coché absent
        for ($i = 0; $i < sizeof($data['check']); $i++) {
            // Récupérer l'id de l'étudiant coché comme absent dans le formulaire
            $student_id = DB::table('students')
                ->select(DB::raw("students.id as student_id"))
                ->where('id', $data['check'][$i])
                ->get();

            $students[$i] = $student_id;

            // Insertion en BD
            $studentSport = StudentSport::create([
                'student_id' => $students[$i][0]->student_id,
                'session_id' => $session_id[0]->session_id
            ]);
            $studentSport->absence()->create([
                'date' => $sysdate
            ]);
        }

        return view('professor.main');
    }
}
