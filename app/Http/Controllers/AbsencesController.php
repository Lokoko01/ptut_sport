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
        $data = [
            'check' => $request->input('check'),
            'sessionId' => $request->input('sessionId'),
            'isToday' => $request->input('isToday'),
            'dateSelector' => $request->input('dateSelector')
        ];
        // Récupérer l'id du professeur connecté
        $professor = Auth::user()->professor->id;

        // Récupérer la date du jour
        if($data['isToday']){
            $date = Carbon::now()->toDateTimeString();
        } else {
            $date = $data['dateSelector'];
        }

        // Récupérer les valeurs du formulaire


        // Pour chaque étudiant coché absent
        for ($i = 0; $i < sizeof($data['check']); $i++) {
            $studentSport = StudentSport
                ::select('id')
                ->where('student_id', $data['check'][$i])
                ->where('session_id', $data['sessionId'])
                ->first();

            $studentSport->absence()->create([
                'isJustified' => 0,
                'date' => $date
            ]);
        }
        return view('professor.main');
    }
}
