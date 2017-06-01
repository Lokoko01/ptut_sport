<?php

namespace App\Http\Controllers;

use App\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AddSessionController extends Controller
{
    public function add(Request $request){
        $data = [
            'sport' => $request->input('sport'),
            'timeSlot' => $request->input('timeSlot'),
            'professor' => $request->input('professor'),
            'location' => $request->input('location'),
            'max_seat' => $request->input('max_seat')
        ];

        $this->validator($request->all())->validate();

        if($this->isSessionAlreadyExist($data)){
            return redirect('/admin/addSession')->with('error_message_session', 'Le créneau existe déjà');
       } else {
            Session::create([
                'timeSlot_id' => $data['timeSlot'],
                'sport_id' => $data['sport'],
                'professor_id' => $data['professor'],
                'location_id' => $data['location'],
                'max_seat' => $data['max_seat']
            ]);

            return redirect('/admin/addSession')->with('succeed_message_session', 'Le créneau à bien été ajouté');

        }
    }

    protected function validator(array $data){
        return Validator::make($data, [
            'sport' => 'required',
            'timeSlot' => 'required',
            'professor' => 'required',
            'location' => 'required',
            'max_seat' => 'required',
        ]);
    }


    private function isSessionAlreadyExist($data){
        $session = DB::table('sessions')->where('timeSlot_id', $data['timeSlot'])->where('sport_id', $data['sport'])->where('professor_id', $data['professor'])->where('location_id', $data['location'])->get();
        if(!empty($session->all())){
            return true;
        } else return false;
    }
}
