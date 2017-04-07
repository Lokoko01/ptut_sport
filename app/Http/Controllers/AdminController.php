<?php

namespace App\Http\Controllers;

use App\Location;
use App\Professor;
use App\Session;
use App\Sport;
use App\TimeSlots;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    public function __construct() {
        $this->middleware('admin');
    }
    public function index(){
        return view('home');
    }

    public function registerprofessor(){
        return view('auth.registerprofessor');
    }

    public function assignnote(){
        return view('admin.assignnote');
    }

    public function addsession(){
        $sports = Sport::orderBy('label', 'asc')
            ->pluck('label', 'id');

        $timeSlots = TimeSlots::orderBy('dayOfWeek')->get();

        $collectionFormatedTimeSlots = array();
        foreach($timeSlots as $oneTimeSlot){
            $collectionFormatedTimeSlots[$oneTimeSlot->id] = $oneTimeSlot->dayOfWeek." ".$oneTimeSlot->startTime."-".$oneTimeSlot->endTime;
        }

        $professors = DB::select('SELECT p.id, u.firstname, u.lastname FROM users u JOIN professors p ON u.id = p.user_id ORDER BY u.lastname');
        $collectionFormatedProfessors = array();

        foreach ($professors as $oneProfessor) {
            $collectionFormatedProfessors[$oneProfessor->id] = $oneProfessor->lastname . " " . $oneProfessor->firstname;
        }

        $locations = Location::orderBy('postCode')->get();

        $collectionFormatedLocations = array();
        foreach ($locations as $oneLocation) {
            $collectionFormatedLocations[$oneLocation->id] = $oneLocation->name." : ".$oneLocation->streetNumber." ".$oneLocation->streetName." ".$oneLocation->postCode." ".$oneLocation->city;
        }

        return view ('admin.addsession')
            ->with('sports', $sports)
            ->with('timeSlots', $collectionFormatedTimeSlots)
            ->with('professors', $collectionFormatedProfessors)
            ->with('locations', $collectionFormatedLocations);
    }

}
