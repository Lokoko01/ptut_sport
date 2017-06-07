<?php

namespace App\Http\Controllers;

use App\Mark;
use App\StudentSport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MarkController extends Controller
{
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
