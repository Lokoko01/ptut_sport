<?php

namespace App\Http\Controllers;

use App\Preregister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contact;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $data = [
            'name' => "Formulaire d'inscription",
            'studentEmail' => $request->input('studentEmail')
        ];

        $this->validate($request, [
            'studentEmail' => 'required|email|max:255|regex:/^(\.?\-?[a-z0-9]?)+@((etu\.univ-lyon+[1-2])|(univ-lyon3))\.fr$/'
        ]);

        $token = uniqid();

        $data['token'] = $token;

        if($this->isUserAlreadyExist($data['studentEmail'])){
            return redirect('preregister')->with('error', 'Un email a déjà été envoyé, vérfiez votre boite mail ou contactez l\'admin. Nous ne pouvons pas vous envoyer un deuxième email.');
        }

        $data['route'] = route('register_with_token', ['studentEmail'=> $data['studentEmail'], 'token' => $data['token']]);

        Preregister::create([
            'email' => $data['studentEmail'],
            'token' => $token,
        ]);

        Mail::to($data['studentEmail'])
            ->send(new Contact($data));

        return redirect('preregister')->with('message', 'Nous vous avons envoyé un email de confirmation. Veuillez vérifier vos mails.');
    }

    private function isUserAlreadyExist($studentAdress){
        $user = DB::table('user_preregister')->where('email', $studentAdress)->get();
        if(!empty($user->all())){
            return true;
        }else return false;
    }
}
