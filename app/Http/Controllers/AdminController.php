<?php

namespace App\Http\Controllers;


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

    public function addAdmin(){
        return view('auth.registeradmin');
    }
}
