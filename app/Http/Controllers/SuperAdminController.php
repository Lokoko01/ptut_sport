<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function __construct() {
        $this->middleware('superadmin');
    }
    public function index(){
        return view('home');
    }

    public function registerprofessor(){
        return view('auth.registerprofessor');
    }

}
