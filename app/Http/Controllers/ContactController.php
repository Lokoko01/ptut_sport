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

    public function store(Request $request)
    {

        $data = [
            'name' => "Formulaire d'inscription",
            'studentEmail'   => $request->input('studentEmail')
        ];


        Mail::send('emails.contact', $data, function ($message) use ($data) {


            $message->from('univ.sport.lyon@gmail.com', $data['name']);

            $message->to($data['studentEmail'])->subject('Accéder au formulaire d\'inscription');

        });

        return "Your email has been sent successfully";
    }
}
