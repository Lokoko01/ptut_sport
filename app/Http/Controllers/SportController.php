<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sport;
use Illuminate\Support\Facades\DB;

class SportController extends Controller
{
    public function addSport(Request $request)
    {
        $data = [
            'sport' => $request->input('sport')
        ];

        $this->validate($request, [
            'sport' => 'required|max:255'
        ]);

        if($this->isSportAlreadyExist($data['sport'])){
            return redirect('/admin/addsport')->with('sportAlreadyExist', 'Le sport '.$data['sport'].' est déjà dans la base de donnée');

        } else {
            Sport::create([
                'label' => $data['sport']
            ]);

            return redirect('/admin/addsport')->with('message', $data['sport'].' ajouté');
        }

    }

    private function isSportAlreadyExist($sportName){
        $sport = DB::table('sports')->where('label', $sportName)->get();
        if(!empty($sport->all())){
            return true;
        }else return false;
    }
}
