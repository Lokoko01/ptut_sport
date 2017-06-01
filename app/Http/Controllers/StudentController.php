<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function chooseSport()
    {

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

        $selected1 = DB::table('student_wishes')->select('session_id', 'rank','spareTime')->where([['student_id', Auth::id()],['rank',1]])->get();
        $selected2 = DB::table('student_wishes')->select('session_id', 'rank','spareTime')->where([['student_id', Auth::id()],['rank',2]])->get();
        $selected3 = DB::table('student_wishes')->select('session_id', 'rank','spareTime')->where([['student_id', Auth::id()],['rank',3]])->get();

        return view('student.chooseSport')
            ->with('creneaux', $creneaux)
            ->with('selected1', $selected1)
            ->with('selected2', $selected2)
            ->with('selected3', $selected3);
    }
}
