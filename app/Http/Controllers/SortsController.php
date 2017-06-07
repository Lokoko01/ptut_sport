<?php

namespace App\Http\Controllers;

use App\ResultWeights;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class SortsController extends Controller
{
    public function validateSorts(Request $request)
    {
        $data = [
            'password' => $request->input('password'),
            'semestre' => $request->input('semestre')
        ];


        if ($this->validatePassword($data['password'])) {
            $weights = DB::table('weights')->get();

            $firstWishes = DB::table('student_wishes')
                ->where('rank', '=', '1')
                ->get();

            $secondWishes = DB::table('student_wishes')
                ->where('rank', '=', '2')
                ->get();

            $thirdWishes = DB::table('student_wishes')
                ->where('rank', '=', '3')
                ->get();

            $listOfWeight = array();
            $listOfSession = DB::table('sessions')->get();


            foreach ($weights as $weight) {
                $listOfWeight[$weight->label] = $weight->value;
            }
            //////////////////////////////////////////////////////////////////////////////////////////////
            foreach ($firstWishes as $wish) {
                $myWeight = 0;
                if (!$wish->isEvaluated) {
                    $myWeight += $listOfWeight['sport_loisir'];
                }
                $myStudent = DB::table('students')
                    ->where('id', $wish->student_id)
                    ->select('studyLevel')
                    ->get();
                // semestre 1
                if ($data['semestre']) {
                    if ($myStudent['0']->studyLevel > 1) {
                        $myWeight += $listOfWeight['priorite_2eme_annee_au_S1'];
                    }
                    ResultWeights::create(['student_id' => $wish->student_id,
                        'student_wishes_id' => $wish->id,
                        'weight' => $myWeight]);
                } else { //semestre 2
                    $myStudentHaveSportS1 = DB::table('backup')
                        ->where([['student_id', '=', $wish->student_id],
                            ['session_id', '=', $wish->session_id],
                            ['semester', '=', 1]])
                        ->get();
                    if (!empty($myStudentHaveSportS1->all())) { // deja eu le sport au S1
                        $myWeight += $listOfWeight['sport_deja_au_S1'];
                    }
                    ResultWeights::create(['student_id' => $wish->student_id,
                        'student_wishes_id' => $wish->id,
                        'weight' => $myWeight]);
                }
            }
            foreach ($listOfSession as $session) {
                $listOfStudent = DB::table('result_weights')
                    ->join('student_wishes', 'student_wishes.id', '=', 'result_weights.student_wishes_id')
                    ->where([['session_id', $session->id], ['rank', 1]])
                    ->orderBy('weight', 'desc')
                    ->limit($session->max_seat)
                    ->get();

                foreach ($listOfStudent as $student) {
                    DB::table("student_sport")->insert(['student_id' => $student->student_id,
                        'session_id' => $session->id]);
                }
            }
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////

            foreach ($secondWishes as $wish) {
                $myWeight = 0;
                if (!$wish->isEvaluated) {
                    $myWeight += $listOfWeight['sport_loisir'];
                }
                $myStudent = DB::table('students')
                    ->where('id', $wish->student_id)
                    ->select('studyLevel')
                    ->get();
                if (!$this->myStudentHaveSportValidated($wish->student_id)) {
                    $myWeight += $listOfWeight['priorite_si_pas_autre_sport_affecte'];
                }

                // semestre 1
                if ($data['semestre']) {
                    if ($myStudent['0']->studyLevel > 1) {
                        $myWeight += $listOfWeight['priorite_2eme_annee_au_S1'];
                    }
                    ResultWeights::create(['student_id' => $wish->student_id,
                        'student_wishes_id' => $wish->id,
                        'weight' => $myWeight]);
                } else { //semestre 2
                    $myStudentHaveSportS1 = DB::table('backup')
                        ->where([['student_id', '=', $wish->student_id],
                            ['session_id', '=', $wish->session_id],
                            ['semester', '=', 1]])
                        ->get();
                    if (!empty($myStudentHaveSportS1->all())) { // deja eu le sport au S1
                        $myWeight += $listOfWeight['sport_deja_au_S1'];
                    }
                    ResultWeights::create(['student_id' => $wish->student_id,
                        'student_wishes_id' => $wish->id,
                        'weight' => $myWeight]);
                }
            }
            foreach ($listOfSession as $session) {
                $listOfStudent = DB::table('result_weights')
                    ->join('student_wishes', 'student_wishes.id', '=', 'result_weights.student_wishes_id')
                    ->where([['session_id', $session->id], ['rank', 2]])
                    ->orderBy('weight', 'desc')
                    ->limit($this->numberRemainingSeats($session->id))
                    ->get();

                foreach ($listOfStudent as $student) {
                    DB::table("student_sport")->insert(['student_id' => $student->student_id,
                        'session_id' => $session->id]);

                }
            }

            /////////////////////////////////////////////////////////////////////////////////////////////////////////////
            foreach ($thirdWishes as $wish) {
                $myWeight = 0;
                if (!$wish->isEvaluated) {
                    $myWeight += $listOfWeight['sport_loisir'];
                }
                $myStudent = DB::table('students')
                    ->where('id', $wish->student_id)
                    ->select('studyLevel')
                    ->get();

                if (!$this->myStudentHaveSportValidated($wish->student_id)) {
                    $myWeight += 2 * $listOfWeight['priorite_si_pas_autre_sport_affecte'];
                }

                // semestre 1
                if ($data['semestre']) {
                    if ($myStudent['0']->studyLevel > 1) {
                        $myWeight += $listOfWeight['priorite_2eme_annee_au_S1'];
                    }
                    ResultWeights::create(['student_id' => $wish->student_id,
                        'student_wishes_id' => $wish->id,
                        'weight' => $myWeight]);
                } else { //semestre 2
                    $myStudentHaveSportS1 = DB::table('backup')
                        ->where([['student_id', '=', $wish->student_id],
                            ['session_id', '=', $wish->session_id],
                            ['semester', '=', 1]])
                        ->get();
                    if (!empty($myStudentHaveSportS1->all())) { // deja eu le sport au S1
                        $myWeight += $listOfWeight['sport_deja_au_S1'];
                    }
                    ResultWeights::create(['student_id' => $wish->student_id,
                        'student_wishes_id' => $wish->id,
                        'weight' => $myWeight]);
                }
            }
            foreach ($listOfSession as $session) {
                $listOfStudent = DB::table('result_weights')
                    ->join('student_wishes', 'student_wishes.id', '=', 'result_weights.student_wishes_id')
                    ->where([['session_id', $session->id], ['rank', 3]])
                    ->orderBy('weight', 'desc')
                    ->limit($this->numberRemainingSeats($session->id))
                    ->get();
                foreach ($listOfStudent as $student) {
                    DB::table("student_sport")->insert(['student_id' => $student->student_id,
                        'session_id' => $session->id]);

                }
            }

        }
        return redirect(route('home'))
            ->with('message', "La répartition a été effectué ");
    }

    public function validatePassword($passsword)
    {

        if (Hash::check($passsword, Auth::user()->getAuthPassword())) {
            return true;
        } else {
            return false;
        }
    }

    public function myStudentHaveSportValidated($student_id)
    {
        $sportvalited = DB::table('student_sport')
            ->where('student_id',$student_id)
            ->get();
        if (!empty($sportvalited->all())) {
            return true;
        } else {
            return false;
        }
    }

    public function numberRemainingSeats($sessions_id)
    {
        $numberSeatsmax = DB::table('sessions')
            ->where('id', $sessions_id)
            ->select('max_seat')
            ->get();

        $numberSeatsTake = DB::table('student_sport')
            ->where('session_id', $sessions_id)
            ->count();
        $numberRemainingSeats = $numberSeatsmax[0]->max_seat - $numberSeatsTake;
        return $numberRemainingSeats;
    }
}
