<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('student');
    }

    public function index()
    {
        return view('home');
    }

   public function chooseSport (){

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
        return view ('student.chooseSport')->with('creneaux',$creneaux);
   }
}
