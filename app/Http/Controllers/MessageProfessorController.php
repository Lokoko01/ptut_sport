<?php

namespace App\Http\Controllers;

use App\Mail\Message;
use App\MessageInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class MessageProfessorController extends Controller
{
    public function addMessage(Request $request)
    {
        $data = $request->only(
            ['select_sessions', 'select_user', 'message']);


        if ($data['select_sessions'] == 0 && $data['select_user'] == 0) {
            return redirect(route('professor_message'))->with('message', 'Il faut choisoir au moins un critère');
        }


        if ($data['select_user']) {
            $allUser = DB::table('users')->get();
            foreach ($allUser as $user ) {
                if ($this->getRoleUser($user->id) == $data['select_user']) {
                    Mail::to($user->email)
                        ->send(new Message($data));
                }
            }
        }

        if ($data['select_sessions']) {
            $studentOfSession = DB::table('student_sport')->where('session_id', $data['select_sessions'])->get();
            foreach ($studentOfSession as $student) {

                Mail::to($this->getEmailUser($student->student_id))
                    ->send(new Message($data));
            }
        }


        if ($data['message']) {
            MessageInformation::create([
                'message' => $data['message'],
                'session_id' => $data['select_sessions'],
                'type_user' => $data['select_user']
            ]);
            return redirect(route('professor_message'))->with('message', 'Message envoyé.');
        } else {
            return redirect(route('professor_message'))->with('message', 'Message vide');
        }
    }

    public function getRoleUser($userId)
    {
        $myRole = DB::table('role_user')->where('user_id', $userId)->get();
        return $myRole['0']->role_id;
    }

    public function getEmailUser($studentId)
    {
        $myUserId = DB::table('students')->where('id', $studentId)->get();
        $myEmail = DB::table('users')->where('id', $myUserId['0']->user_id)->get();
        return $myEmail['0']->email;
    }
}
