<?php

namespace App\Http\Controllers;
use App\Sport;

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

    public function addsport(){
            $sports = Sport::orderBy('label', 'asc')
                ->pluck('label', 'id');
        return view('sport.sport')
                ->with('sports', $sports);
    }

    public function addufr(){
        return view('ufr.addufr');
    }

}
