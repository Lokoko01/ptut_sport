<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contact;

class ContactController extends Controller
{
    public function create()
    {
        return view('contact');
    }

    public function sendMail(Request $request)
    {
        $data = array(
            'name' => "Formulaire d'inscription",
        );

        //$name = Request::input('name');

        Mail::send('emails.contact', $data, function ($message) {

            $message->from('univ.sport.lyon@gmail.com', 'Formulaire d\'inscription');

            $message->to('martin.rascle@gmail.com')->subject('Accéder au formulaire d\'inscription');

        });

        return "Your email has been sent successfully";
    }
}
