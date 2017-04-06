<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Validator;
use App\Role;
use Illuminate\Auth\Events\Registered;



class RegisterAdminController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('admin');
    }

    protected function validator(array $data){
        return Validator::make($data, [
            'lastname' => 'required|max:255',
            'firstname' => 'required|max:255',
            'sex' => 'required',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        //$this->guard()->login($user);

        return $this->registered($request, $user)
            ?:redirect('/admin/addAdmin')->with('message_sucess_admin','L\'administrateur '.$user->lastname.' '.$user->firstname.' à bien été ajouté.');
    }

    protected function create(array $data){
        $user = User::create([
            'lastname' => $data['lastname'],
            'firstname' => $data['firstname'],
            'sex' => $data['sex'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $idAdminRole = Role::where('name', 'admin')->first();
        $user->attachRole($idAdminRole);


        return $user;
    }
}
