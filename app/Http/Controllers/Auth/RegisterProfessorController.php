<?php

namespace App\Http\Controllers\Auth;

use App\Ufr;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;



class RegisterProfessorController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data){
        return Validator::make($data, [
            'lastname' => 'required|max:255',
            'firstname' => 'required|max:255',
            'sex' => 'required',
            'email' => 'required|email|max:255|unique:users',
            'phone_number' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);
    }


    protected function create(array $data)
    {
        $user = User::create([
            'lastname' => $data['lastname'],
            'firstname' => $data['firstname'],
            'sex' => $data['sex'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'password' => bcrypt($data['password']),
        ]);

        $user->professor()->create([
            'phoneNumber' => $data['phone_number'],
        ]);

        $idProfessorRole = Role::where('name', 'professor')->first();
        $user->attachRole($idProfessorRole);
        return $user;
    }
}
