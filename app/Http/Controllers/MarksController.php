<?php

namespace App\Http\Controllers;

use App\Mark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MarksController extends Controller
{
    public function addMarks(Request $request)
    {
        // Récupérer l'id du professeur connecté
        $professor = Auth::user()->professor->id;

        // Récupérer les valeurs du formulaire
        $students = $request->only('students');

        // Pour chaque étudiant noté
        foreach ($students as $student) {
            foreach ($student as $values) {
                // Insertion en BD
                //TODO Récupérer le session_id de la session qui a été sélectionné dans la vue avec la liste déroulante
                /*Mark::create([
                    'student_id' => $values['student_id'],
                    'session_id' => $session_id,
                    'mark' => $values['mark'],
                    'comment' => $values['comment']
                ]);*/
            }
        }

        /*        return view('professor.main');*/
    }
}
