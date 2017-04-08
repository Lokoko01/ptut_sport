<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Sport;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('home');
    }

    public function registerprofessor()
    {
        return view('auth.registerprofessor');
    }

    public function sport()
    {
        $sports = Sport::orderBy('label', 'asc')
            ->pluck('label', 'id');
        return view('sport.sport')->with('sports', $sports);
    }

    public function ufr()
    {
        $ufrs = DB::table('ufr')->orderBy('code', 'asc')->paginate(10);
        return view('ufr.ufr')->with('ufrs', $ufrs);
    }

}
