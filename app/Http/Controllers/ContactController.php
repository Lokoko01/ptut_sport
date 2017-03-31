<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function create()
    {
        return view('contact');
    }

    public function store(Request $request)
    {

        $data = [
            'name' => "Formulaire d'inscription",
            'studentEmail' => $request->input('studentEmail')
        ];

        $this->validate($request, [
            'studentEmail' => 'required|email|max:255|regex:/^[a-z0-9](\.?[a-z0-9]){5,}@etu\.univ-lyon+[0-3]\.fr$/'
        ]);

        Mail::send('emails.contact', $data, function ($message) use ($data) {


            $message->from('univ.sport.lyon@gmail.com', $data['name']);

            $message->to($data['studentEmail'])->subject('Accéder au formulaire d\'inscription');

        });

        return redirect('preregister')->with('message', 'Nous vous avons envoyé un email de confirmation. Veuillez vérifier vos mails.');
    }
}
