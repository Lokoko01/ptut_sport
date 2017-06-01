<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WishesController extends Controller
{
    public function addWishesToStudent(Request $request)
    {

        $data = $request->only(['voeu1', 'voeu2', 'voeu3', 'studentId','isNotedFirstWish','isNotedSecondWish','isNotedThirdWish']);
        $creneaux = DB::table('sessions')
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


        $selected1 = DB::table('student_wishes')->select('session_id', 'rank','isEvaluated')->where([['student_id', Auth::user()->student->id],['rank',1]])->get();
        $selected2 = DB::table('student_wishes')->select('session_id', 'rank','isEvaluated')->where([['student_id', Auth::user()->student->id],['rank',2]])->get();
        $selected3 = DB::table('student_wishes')->select('session_id', 'rank','isEvaluated')->where([['student_id', Auth::user()->student->id],['rank',3]])->get();


        if(
            (($data['voeu1']==$data['voeu2']) && ($data['voeu1'] != 0 ))
            || (($data['voeu1']==$data['voeu3']) && ($data['voeu3'] != 0))
            || (($data['voeu3']==$data['voeu2']) && ($data['voeu2'] != 0 ))) {

            return redirect('student/choose_sport')
                ->with('creneaux', $creneaux)
                ->with('selected1', $selected1)
                ->with('selected2', $selected2)
                ->with('selected3', $selected3)
                ->with('message_voeux_identiques', "Attention des voeux sont identiques ! ");
        }


        if ($data['voeu1'] == '0') {
            if($data['voeu2']!= 0 || $data['voeu3']!= 0){
                return redirect('student/choose_sport')
                    ->with('creneaux', $creneaux)
                    ->with('selected1', $selected1)
                    ->with('selected2', $selected2)
                    ->with('selected3', $selected3)
                    ->with('message_voeux_identiques', "Vous devez posséder un voeu 1 pour pouvoir enregistrer d'autres voeux");

            }
            else{
                $this->WishDelete($data['studentId'], 1);
            }
        } else {
            if (!$this->WishAlreadyExist($data['studentId'], $data['voeu1'],!Empty($data['isNotedFirstWish'])) && !$this->RankAlreadyExist($data['studentId'], 1)) {
                DB::table('student_wishes')->insert([
                    ['student_id' => $data['studentId'], 'session_id' => $data['voeu1'], 'rank' => '1', 'isEvaluated' => !Empty($data['isNotedFirstWish'])]
                ]);
            } else {
                if (!$this->WishAlreadyExist($data['studentId'], $data['voeu1'],!Empty($data['isNotedFirstWish']))) {
                    $this->WishUpdate($data['studentId'], $data['voeu1'], 1,!Empty($data['isNotedFirstWish']));
                }
            }
        }

        if ($data['voeu2'] == '0') {
            if($data['voeu3']!= 0){
                return redirect('student/choose_sport')
                    ->with('creneaux', $creneaux)
                    ->with('selected1', $selected1)
                    ->with('selected2', $selected2)
                    ->with('selected3', $selected3)
                    ->with('message_voeux_identiques', "Vous devez posséder un voeu 2 pour pouvoir enregistrer d'autres voeux");

            }
            else{
                $this->WishDelete($data['studentId'], 2);
            }
        } else {

            if (!$this->WishAlreadyExist($data['studentId'], $data['voeu2'],!Empty($data['isNotedSecondWish'])) && !$this->RankAlreadyExist($data['studentId'], 2)) {

                DB::table('student_wishes')->insert([
                    ['student_id' => $data['studentId'], 'session_id' => $data['voeu2'], 'rank' => '2', 'isEvaluated' => !Empty($data['isNotedSecondWish'])]
                ]);
            } else {
                if (!$this->WishAlreadyExist($data['studentId'], $data['voeu2'],!Empty($data['isNotedSecondWish']))) {
                    $this->WishUpdate($data['studentId'], $data['voeu2'], 2,!Empty($data['isNotedSecondWish']));
                }
            }
        }
        if ($data['voeu3'] == '0') {
            $this->WishDelete($data['studentId'], 3);
        } else {
            if (!$this->WishAlreadyExist($data['studentId'], $data['voeu3'],!Empty($data['isNotedThirdWish'])) && !$this->RankAlreadyExist($data['studentId'], 3)) {

                DB::table('student_wishes')->insert([
                    ['student_id' => $data['studentId'], 'session_id' => $data['voeu3'], 'rank' => '3', 'isEvaluated' => !Empty($data['isNotedThirdWish'])]
                ]);
            } else {
                if (!$this->WishAlreadyExist($data['studentId'], $data['voeu3'],!Empty($data['isNotedThirdWish']))) {
                    $this->WishUpdate($data['studentId'], $data['voeu3'], 3,!Empty($data['isNotedThirdWish']));
                }
            }
        }

        return redirect('student/choose_sport')
            ->with('creneaux', $creneaux)
            ->with('selected1', $selected1)
            ->with('selected2', $selected2)
            ->with('selected3', $selected3)
            ->with('message_voeux_identiques', "Voeu(x) validé(s)");

    }

    private function WishAlreadyExist($studentID, $sessionID, $isEvaluated)
    {
        $whish = DB::table('student_wishes')->where([
            ['student_id', '=', $studentID],
            ['session_id', '=', $sessionID],
            ['isEvaluated', '=', $isEvaluated]])->get();

        if (!empty($whish->all())) {
            return true;
        } else {
            return false;
        }
    }

    private function RankAlreadyExist($studentID, $myrank)
    {
        $rank = DB::table('student_wishes')->where([
            ['student_id', '=', $studentID],
            ['rank', '=', $myrank]])->get();

        if (!empty($rank->all())) {
            return true;
        } else {
            return false;
        }
    }


    private function WishUpdate($studentID, $sessionID, $rank, $isEvaluated)
    {
        DB::table('student_wishes')
            ->where([['student_id', $studentID], ['rank', $rank]])
            ->update(['session_id' => $sessionID,'isEvaluated' => $isEvaluated]);
    }

    private function WishDelete($studentID, $rank)
    {
        $ifexist = DB::table('student_wishes')
            ->where([['student_id', $studentID], ['rank', $rank]])
            ->get();
        if (!empty(($ifexist->all()))) {
            DB::table('student_wishes')
                ->where([['student_id', $studentID], ['rank', $rank]])
                ->delete();
        }
    }
}
