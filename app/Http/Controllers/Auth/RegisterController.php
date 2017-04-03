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



class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'lastname' => 'required|max:255',
            'firstname' => 'required|max:255',
            //'studentNumber' => 'required|unique:users|max:8',
            'sex' => 'required',
            'ufr' => 'required',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'lastname' => $data['lastname'],
            'firstname' => $data['firstname'],
            'sex' => $data['sex'],
           // 'studentNumber' => $data['studentNumber'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        $idStudentRole = Role::where('name', 'student')->first();
        $user->attachRole($idStudentRole);
        return $user;

    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm($email, $token)
    {
        $isTokenRight = $this->verifyToken($token, $email);
        if($isTokenRight){
            $ufrs = Ufr::orderBy('label', 'asc')
                ->pluck('label', 'code');

            return view('auth.register')
                ->with('ufrs', $ufrs);
        }
        else{
            abort(404);
        }
    }

    private function verifyToken($token, $email){
        $tokens = DB::table('user_preregister')->where([
            ['email', $email],
            ['token', $token],
        ])->get();

        if(!empty($tokens->all())){
            return true;
        }else return false;
    }
}
