<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Role;
use App\Ufr;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


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
     * Show the application registration form.
     *
     * @param string email
     * @param string token
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm($email, $token)
    {
        $isTokenRight = $this->verifyToken($token, $email);
        if ($isTokenRight) {
            $ufrs = Ufr::orderBy('label', 'asc')
                ->pluck('label', 'id');

            return view('auth.register')
                ->with('ufrs', $ufrs)
                ->with('token', $token);
        } else {
            abort(404);
        }
    }

    private function verifyToken($token, $email)
    {
        $tokens = DB::table('user_preregister')->where([
            ['email', $email],
            ['token', $token],
        ])->get();

        if (!empty($tokens->all())) {
            return true;
        } else return false;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'lastname' => 'required|max:255',
            'firstname' => 'required|max:255',
            'studentNumber' => 'required|unique:students|max:8',
            'sex' => 'required',
            'ufr' => 'required',
            'privateEmail' => 'required|email|max:255|unique:students',
            'password' => 'required|min:8|confirmed',
            'token' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        $emailEtu = DB::table('user_preregister')->where('token', $data['token'])->value('email');

        $user = User::create([
            'lastname' => strtoupper($data['lastname']),
            'firstname' => $data['firstname'],
            'sex' => $data['sex'],
            'email' => $emailEtu,
            'password' => bcrypt($data['password']),
        ]);

        $user->student()->create([
            'studentNumber' => $data['studentNumber'],
            'privateEmail' => $data['privateEmail'],
            'ufr_id' => $data['ufr']
        ]);

        $idStudentRole = Role::where('name', 'student')->first();
        $user->attachRole($idStudentRole);

        return $user;
    }
}
